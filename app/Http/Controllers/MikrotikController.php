<?php

namespace App\Http\Controllers;

use App\Models\MikrotikCredential;
use App\Models\MikrotikCommandLog;
use App\Models\Site;
use App\Services\MikrotikService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Exception;

class MikrotikController extends Controller
{
    /**
     * Buat instance MikrotikService berdasarkan site_id
     */
    protected function getMikrotikService(string $siteId): MikrotikService
    {
        $cred = MikrotikCredential::where('site_id', $siteId)->first();

        if (!$cred) {
            throw new Exception('Credentials belum dikonfigurasi untuk site ini. Klik tombol "Konfigurasi Kredensial" di bawah sidebar terlebih dahulu.');
        }

        return new MikrotikService([
            'host'    => $cred->api_host,
            'user'    => $cred->api_user,
            'pass'    => $cred->api_password,
            'port'    => $cred->api_port,
            'timeout' => 5,
        ]);
    }

    /**
     * Catat audit log perintah MikroTik
     */
    protected function logCommand(string $siteId, string $command, array $params, $response, bool $success, string $category = ''): void
    {
        MikrotikCommandLog::create([
            'site_id'    => $siteId,
            'user_id'    => Auth::id(),
            'command'    => $command,
            'parameters' => $params,
            'response'   => is_array($response) ? json_encode($response) : (string) $response,
            'status'     => $success ? 'success' : 'failed',
            'category'   => $category,
            'executed_at'=> now(),
        ]);
    }

    /**
     * Helper: response sukses
     */
    protected function ok(mixed $data, string $message = 'Berhasil'): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data]);
    }

    /**
     * Helper: response error
     */
    protected function err(string $message, int $code = 500): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message, 'data' => null], $code);
    }

    // ===========================
    // HALAMAN UTAMA
    // ===========================

    public function index(Request $request)
    {
        $sites       = Site::select('site_id', 'sitename', 'ip_router')->orderBy('sitename')->get();
        $credentials = MikrotikCredential::pluck('site_id')->toArray();

        return view('mikrotik', compact('sites', 'credentials'));
    }

    // ===========================
    // CREDENTIALS MANAGEMENT
    // ===========================

    public function getCredentials(string $siteId): JsonResponse
    {
        $cred = MikrotikCredential::where('site_id', $siteId)->first();
        if (!$cred) return $this->err('Credentials belum dikonfigurasi', 404);

        return $this->ok([
            'site_id'  => $cred->site_id,
            'api_host' => $cred->api_host,
            'api_port' => $cred->api_port,
            'api_user' => $cred->api_user,
            'use_ssl'  => $cred->use_ssl,
            'is_active'=> $cred->is_active,
            'last_connected' => $cred->last_connected?->diffForHumans(),
        ]);
    }

    public function saveCredentials(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'site_id'      => 'required|string|exists:sites,site_id',
            'api_host'     => 'required|string|max:100',
            'api_port'     => 'required|integer|min:1|max:65535',
            'api_user'     => 'required|string|max:100',
            'api_password' => 'required|string',
            'use_ssl'      => 'boolean',
        ]);

        MikrotikCredential::updateOrCreate(
            ['site_id' => $validated['site_id']],
            [
                'api_host'     => $validated['api_host'],
                'api_port'     => $validated['api_port'],
                'api_user'     => $validated['api_user'],
                'api_password' => $validated['api_password'],
                'use_ssl'      => $validated['use_ssl'] ?? false,
                'is_active'    => true,
            ]
        );

        return $this->ok(null, 'Credentials berhasil disimpan');
    }

    public function testConnection(Request $request): JsonResponse
    {
        $siteId = $request->input('site_id');
        try {
            $service  = $this->getMikrotikService($siteId);
            $identity = $service->getSystemIdentity();
            $resource = $service->getSystemResource();

            MikrotikCredential::where('site_id', $siteId)->update([
                'last_connected' => now(),
                'last_error'     => null,
            ]);

            return $this->ok([
                'identity' => $identity[0]['name'] ?? 'Unknown',
                'resource' => $resource[0] ?? [],
            ], 'Koneksi berhasil!');
        } catch (Exception $e) {
            MikrotikCredential::where('site_id', $siteId)->update([
                'last_error' => $e->getMessage(),
            ]);
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // SYSTEM INFO
    // ===========================

    public function getSystemInfo(string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $identity = $service->getSystemIdentity();
            $resource = $service->getSystemResource();
            $clock    = $service->getSystemClock();

            return $this->ok([
                'identity' => $identity[0] ?? [],
                'resource' => $resource[0] ?? [],
                'clock'    => $clock[0] ?? [],
            ]);
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function setSystemIdentity(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->setSystemIdentity($request->input('name'));
            $this->logCommand($siteId, '/system/identity/set', ['name' => $request->input('name')], $response, true, 'system');
            return $this->ok(null, 'Identity berhasil diubah');
        } catch (Exception $e) {
            $this->logCommand($siteId, '/system/identity/set', [], $e->getMessage(), false, 'system');
            return $this->err($e->getMessage());
        }
    }

    public function getSystemLog(string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            return $this->ok($service->getSystemLog());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getSystemNtp(string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            return $this->ok($service->getSystemNtp());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function setSystemNtp(Request $request, string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            $params  = $request->only(['enabled', 'primary-ntp', 'secondary-ntp', 'mode']);
            $response = $service->setSystemNtp($params);
            $this->logCommand($siteId, '/system/ntp/client/set', $params, $response, true, 'system');
            return $this->ok(null, 'NTP berhasil dikonfigurasi');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function systemReboot(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->systemReboot();
            $this->logCommand($siteId, '/system/reboot', [], $response, true, 'system');
            return $this->ok(null, 'Perintah reboot berhasil dikirim');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // INTERFACE
    // ===========================

    public function getInterfaces(string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            return $this->ok($service->getInterfaces());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function setInterface(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $id       = $request->input('.id');
            $params   = $request->except(['site_id', '_token']);
            $response = $service->setInterface($id, $params);
            $this->logCommand($siteId, '/interface/set', $params, $response, true, 'interface');
            return $this->ok(null, 'Interface berhasil diupdate');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function toggleInterface(Request $request, string $siteId): JsonResponse
    {
        $action = $request->input('action'); // enable / disable
        try {
            $service  = $this->getMikrotikService($siteId);
            $id       = $request->input('.id');
            $response = $action === 'enable'
                ? $service->enableInterface($id)
                : $service->disableInterface($id);
            $this->logCommand($siteId, "/interface/{$action}", ['.id' => $id], $response, true, 'interface');
            return $this->ok(null, "Interface berhasil di-{$action}");
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getVlans(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getVlans());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addVlan(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->except(['site_id', '_token']);
            $response = $service->addVlan($params);
            $this->logCommand($siteId, '/interface/vlan/add', $params, $response, true, 'interface');
            return $this->ok(null, 'VLAN berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removeVlan(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->removeVlan($request->input('.id'));
            $this->logCommand($siteId, '/interface/vlan/remove', ['.id' => $request->input('.id')], $response, true, 'interface');
            return $this->ok(null, 'VLAN berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getBridges(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getBridges());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getBridgePorts(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getBridgePorts());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // IP ADDRESS
    // ===========================

    public function getIpAddresses(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getIpAddresses());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addIpAddress(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['address', 'interface', 'comment']);
            $response = $service->addIpAddress($params);
            $this->logCommand($siteId, '/ip/address/add', $params, $response, true, 'ip');
            return $this->ok(null, 'IP Address berhasil ditambahkan');
        } catch (Exception $e) {
            $this->logCommand($siteId, '/ip/address/add', $request->all(), $e->getMessage(), false, 'ip');
            return $this->err($e->getMessage());
        }
    }

    public function setIpAddress(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $id       = $request->input('.id');
            $params   = $request->except(['site_id', '_token', '.id']);
            $response = $service->setIpAddress($id, $params);
            $this->logCommand($siteId, '/ip/address/set', array_merge(['.id' => $id], $params), $response, true, 'ip');
            return $this->ok(null, 'IP Address berhasil diupdate');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removeIpAddress(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $id       = $request->input('.id');
            $response = $service->removeIpAddress($id);
            $this->logCommand($siteId, '/ip/address/remove', ['.id' => $id], $response, true, 'ip');
            return $this->ok(null, 'IP Address berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // IP ROUTE
    // ===========================

    public function getRoutes(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getRoutes());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addRoute(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['dst-address', 'gateway', 'distance', 'comment']);
            $response = $service->addRoute($params);
            $this->logCommand($siteId, '/ip/route/add', $params, $response, true, 'route');
            return $this->ok(null, 'Route berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removeRoute(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->removeRoute($request->input('.id'));
            $this->logCommand($siteId, '/ip/route/remove', ['.id' => $request->input('.id')], $response, true, 'route');
            return $this->ok(null, 'Route berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // DHCP SERVER & LEASES
    // ===========================

    public function getDhcpServers(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getDhcpServers());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getDhcpLeases(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getDhcpLeases());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addDhcpLease(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['address', 'mac-address', 'comment', 'server']);
            $response = $service->addDhcpLease($params);
            $this->logCommand($siteId, '/ip/dhcp-server/lease/add', $params, $response, true, 'dhcp');
            return $this->ok(null, 'Lease berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removeDhcpLease(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->removeDhcpLease($request->input('.id'));
            $this->logCommand($siteId, '/ip/dhcp-server/lease/remove', ['.id' => $request->input('.id')], $response, true, 'dhcp');
            return $this->ok(null, 'Lease berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function makeDhcpLeaseStatic(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->makeDhcpLeaseStatic($request->input('.id'));
            $this->logCommand($siteId, '/ip/dhcp-server/lease/make-static', ['.id' => $request->input('.id')], $response, true, 'dhcp');
            return $this->ok(null, 'Lease berhasil dijadikan static');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getDhcpNetworks(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getDhcpNetworks());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // DNS
    // ===========================

    public function getDns(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getDns());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function setDns(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['servers', 'allow-remote-requests', 'max-udp-packet-size', 'cache-max-ttl']);
            $response = $service->setDns($params);
            $this->logCommand($siteId, '/ip/dns/set', $params, $response, true, 'dns');
            return $this->ok(null, 'DNS berhasil diupdate');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getDnsStatic(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getDnsStatic());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addDnsStatic(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['name', 'address', 'ttl', 'comment']);
            $response = $service->addDnsStatic($params);
            $this->logCommand($siteId, '/ip/dns/static/add', $params, $response, true, 'dns');
            return $this->ok(null, 'DNS static berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removeDnsStatic(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->removeDnsStatic($request->input('.id'));
            $this->logCommand($siteId, '/ip/dns/static/remove', ['.id' => $request->input('.id')], $response, true, 'dns');
            return $this->ok(null, 'DNS static berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // FIREWALL
    // ===========================

    public function getFirewallFilter(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getFirewallFilter());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addFirewallFilter(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->except(['site_id', '_token']);
            $response = $service->addFirewallFilter($params);
            $this->logCommand($siteId, '/ip/firewall/filter/add', $params, $response, true, 'firewall');
            return $this->ok(null, 'Firewall Filter berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function toggleFirewallFilter(Request $request, string $siteId): JsonResponse
    {
        $action = $request->input('action');
        try {
            $service  = $this->getMikrotikService($siteId);
            $id       = $request->input('.id');
            $response = $action === 'enable'
                ? $service->enableFirewallFilter($id)
                : $service->disableFirewallFilter($id);
            $this->logCommand($siteId, "/ip/firewall/filter/{$action}", ['.id' => $id], $response, true, 'firewall');
            return $this->ok(null, "Firewall rule berhasil di-{$action}");
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removeFirewallFilter(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->removeFirewallFilter($request->input('.id'));
            $this->logCommand($siteId, '/ip/firewall/filter/remove', ['.id' => $request->input('.id')], $response, true, 'firewall');
            return $this->ok(null, 'Firewall rule berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getFirewallNat(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getFirewallNat());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addFirewallNat(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->except(['site_id', '_token']);
            $response = $service->addFirewallNat($params);
            $this->logCommand($siteId, '/ip/firewall/nat/add', $params, $response, true, 'firewall');
            return $this->ok(null, 'NAT rule berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removeFirewallNat(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->removeFirewallNat($request->input('.id'));
            $this->logCommand($siteId, '/ip/firewall/nat/remove', ['.id' => $request->input('.id')], $response, true, 'firewall');
            return $this->ok(null, 'NAT rule berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getFirewallMangle(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getFirewallMangle());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getFirewallAddressLists(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getFirewallAddressLists());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addFirewallAddressList(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['list', 'address', 'comment']);
            $response = $service->addFirewallAddressList($params);
            $this->logCommand($siteId, '/ip/firewall/address-list/add', $params, $response, true, 'firewall');
            return $this->ok(null, 'Address List berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // WIRELESS
    // ===========================

    public function getWireless(string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            return $this->ok([
                'interfaces'        => $service->getWirelessInterfaces(),
                'registrations'     => $service->getWirelessRegistrations(),
                'security_profiles' => $service->getWirelessSecurityProfiles(),
            ]);
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function setWireless(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $id       = $request->input('.id');
            $params   = $request->except(['site_id', '_token', '.id']);
            $response = $service->setWirelessInterface($id, $params);
            $this->logCommand($siteId, '/interface/wireless/set', array_merge(['.id' => $id], $params), $response, true, 'wireless');
            return $this->ok(null, 'Wireless berhasil diupdate');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // USER MANAGEMENT
    // ===========================

    public function getUsers(string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            return $this->ok([
                'users'       => $service->getUsers(),
                'groups'      => $service->getUserGroups(),
                'active_list' => $service->getUserActiveList(),
            ]);
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addUser(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['name', 'password', 'group', 'comment', 'address']);
            $response = $service->addUser($params);
            $this->logCommand($siteId, '/user/add', array_merge($params, ['password' => '***']), $response, true, 'user');
            return $this->ok(null, 'User berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removeUser(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->removeUser($request->input('.id'));
            $this->logCommand($siteId, '/user/remove', ['.id' => $request->input('.id')], $response, true, 'user');
            return $this->ok(null, 'User berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // QUEUE (BANDWIDTH)
    // ===========================

    public function getQueues(string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            return $this->ok([
                'simple' => $service->getSimpleQueues(),
                'tree'   => $service->getQueueTrees(),
            ]);
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addSimpleQueue(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->except(['site_id', '_token']);
            $response = $service->addSimpleQueue($params);
            $this->logCommand($siteId, '/queue/simple/add', $params, $response, true, 'queue');
            return $this->ok(null, 'Queue berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removeSimpleQueue(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->removeSimpleQueue($request->input('.id'));
            $this->logCommand($siteId, '/queue/simple/remove', ['.id' => $request->input('.id')], $response, true, 'queue');
            return $this->ok(null, 'Queue berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function toggleQueue(Request $request, string $siteId): JsonResponse
    {
        $action = $request->input('action');
        try {
            $service  = $this->getMikrotikService($siteId);
            $id       = $request->input('.id');
            $response = $action === 'enable'
                ? $service->enableSimpleQueue($id)
                : $service->disableSimpleQueue($id);
            $this->logCommand($siteId, "/queue/simple/{$action}", ['.id' => $id], $response, true, 'queue');
            return $this->ok(null, "Queue berhasil di-{$action}");
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // PPP & VPN
    // ===========================

    public function getPpp(string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            return $this->ok([
                'secrets'    => $service->getPppSecrets(),
                'active'     => $service->getPppActiveSessions(),
                'profiles'   => $service->getPppProfiles(),
                'pppoe_svr'  => $service->getPppoeServers(),
            ]);
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addPppSecret(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['name', 'password', 'service', 'profile', 'local-address', 'remote-address', 'comment']);
            $response = $service->addPppSecret($params);
            $this->logCommand($siteId, '/ppp/secret/add', array_merge($params, ['password' => '***']), $response, true, 'vpn');
            return $this->ok(null, 'PPP Secret berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removePppSecret(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->removePppSecret($request->input('.id'));
            $this->logCommand($siteId, '/ppp/secret/remove', ['.id' => $request->input('.id')], $response, true, 'vpn');
            return $this->ok(null, 'PPP Secret berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // HOTSPOT
    // ===========================

    public function getHotspot(string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            return $this->ok([
                'servers'  => $service->getHotspotServers(),
                'users'    => $service->getHotspotUsers(),
                'active'   => $service->getHotspotActiveUsers(),
                'profiles' => $service->getHotspotProfiles(),
            ]);
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addHotspotUser(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['name', 'password', 'profile', 'limit-uptime', 'limit-bytes-total', 'comment']);
            $response = $service->addHotspotUser($params);
            $this->logCommand($siteId, '/ip/hotspot/user/add', array_merge($params, ['password' => '***']), $response, true, 'hotspot');
            return $this->ok(null, 'Hotspot user berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function removeHotspotUser(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $response = $service->removeHotspotUser($request->input('.id'));
            $this->logCommand($siteId, '/ip/hotspot/user/remove', ['.id' => $request->input('.id')], $response, true, 'hotspot');
            return $this->ok(null, 'Hotspot user berhasil dihapus');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // IP SERVICES
    // ===========================

    public function getIpServices(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getIpServices());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function setIpService(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $id       = $request->input('.id');
            $params   = $request->only(['port', 'address', 'disabled']);
            $response = $service->setIpService($id, $params);
            $this->logCommand($siteId, '/ip/service/set', array_merge(['.id' => $id], $params), $response, true, 'system');
            return $this->ok(null, 'Service berhasil diupdate');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function toggleIpService(Request $request, string $siteId): JsonResponse
    {
        $action = $request->input('action');
        try {
            $service  = $this->getMikrotikService($siteId);
            $id       = $request->input('.id');
            $response = $action === 'enable'
                ? $service->enableIpService($id)
                : $service->disableIpService($id);
            $this->logCommand($siteId, "/ip/service/{$action}", ['.id' => $id], $response, true, 'system');
            return $this->ok(null, "Service berhasil di-{$action}");
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // ARP & NEIGHBOR
    // ===========================

    public function getArp(string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            return $this->ok([
                'arp'       => $service->getArpTable(),
                'neighbors' => $service->getNeighbors(),
            ]);
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // SCRIPTS & SCHEDULER
    // ===========================

    public function getScripts(string $siteId): JsonResponse
    {
        try {
            $service = $this->getMikrotikService($siteId);
            return $this->ok([
                'scripts'    => $service->getScripts(),
                'schedulers' => $service->getSchedulers(),
            ]);
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addScript(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['name', 'policy', 'source', 'comment']);
            $response = $service->addScript($params);
            $this->logCommand($siteId, '/system/script/add', $params, $response, true, 'script');
            return $this->ok(null, 'Script berhasil disimpan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function runScript(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $id       = $request->input('.id');
            $response = $service->runScript($id);
            $this->logCommand($siteId, '/system/script/run', ['.id' => $id], $response, true, 'script');
            return $this->ok(null, 'Script berhasil dieksekusi');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function addScheduler(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $params   = $request->only(['name', 'on-event', 'start-date', 'start-time', 'interval', 'comment']);
            $response = $service->addScheduler($params);
            $this->logCommand($siteId, '/system/scheduler/add', $params, $response, true, 'script');
            return $this->ok(null, 'Scheduler berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // BACKUP
    // ===========================

    public function createBackup(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $name     = $request->input('name', 'backup_' . date('Ymd_His'));
            $response = $service->createBackup($name);
            $this->logCommand($siteId, '/system/backup/save', ['name' => $name], $response, true, 'system');
            return $this->ok(['filename' => $name . '.backup'], 'Backup berhasil dibuat di MikroTik');
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getFiles(string $siteId): JsonResponse
    {
        try {
            return $this->ok($this->getMikrotikService($siteId)->getFiles());
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // TOOLS
    // ===========================

    public function ping(Request $request, string $siteId): JsonResponse
    {
        try {
            $service  = $this->getMikrotikService($siteId);
            $address  = $request->input('address');
            $count    = (int) $request->input('count', 4);
            $response = $service->ping($address, $count);
            return $this->ok($response);
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    public function getTrafficMonitor(Request $request, string $siteId): JsonResponse
    {
        try {
            $service    = $this->getMikrotikService($siteId);
            $interface  = $request->input('interface');
            $response   = $service->getTrafficMonitor($interface);
            return $this->ok($response);
        } catch (Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // ===========================
    // AUDIT LOG
    // ===========================

    public function getCommandLogs(string $siteId): JsonResponse
    {
        $logs = MikrotikCommandLog::where('site_id', $siteId)
            ->with('user:id,name')
            ->orderByDesc('executed_at')
            ->limit(100)
            ->get();

        return $this->ok($logs);
    }
}
