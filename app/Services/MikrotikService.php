<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;
use Exception;
use Illuminate\Support\Facades\Log;

class MikrotikService
{
    protected ?Client $client = null;
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Buat koneksi ke MikroTik
     */
    public function connect(): bool
    {
        try {
            $this->client = new Client([
                'host'     => $this->config['host'],
                'user'     => $this->config['user'],
                'pass'     => $this->config['pass'],
                'port'     => (int) ($this->config['port'] ?? 8728),
                'timeout'  => $this->config['timeout'] ?? 5,
                'attempts' => 1,
            ]);
            return true;
        } catch (Exception $e) {
            Log::error('MikroTik connect error: ' . $e->getMessage());
            throw new Exception('Gagal terhubung ke MikroTik: ' . $e->getMessage());
        }
    }

    /**
     * Eksekusi query ke MikroTik dan kembalikan hasilnya
     */
    public function query(string $command, array $params = []): array
    {
        if (!$this->client) $this->connect();

        try {
            $query = new Query($command);
            foreach ($params as $key => $value) {
                $query->equal($key, $value);
            }
            return $this->client->query($query)->read();
        } catch (Exception $e) {
            Log::error('MikroTik query error: ' . $e->getMessage());
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Eksekusi perintah tanpa return (set, add, remove, enable, disable)
     */
    public function execute(string $command, array $params = []): array
    {
        if (!$this->client) $this->connect();

        try {
            $query = new Query($command);
            foreach ($params as $key => $value) {
                $query->equal($key, $value);
            }
            return $this->client->query($query)->read();
        } catch (Exception $e) {
            Log::error('MikroTik execute error: ' . $e->getMessage());
            throw new Exception('Error eksekusi: ' . $e->getMessage());
        }
    }

    // =============================
    // SYSTEM INFO
    // =============================

    public function getSystemResource(): array
    {
        return $this->query('/system/resource/print');
    }

    public function getSystemIdentity(): array
    {
        return $this->query('/system/identity/print');
    }

    public function getSystemClock(): array
    {
        return $this->query('/system/clock/print');
    }

    public function setSystemIdentity(string $name): array
    {
        return $this->execute('/system/identity/set', ['name' => $name]);
    }

    public function setSystemClock(array $params): array
    {
        return $this->execute('/system/clock/set', $params);
    }

    public function getSystemHealth(): array
    {
        return $this->query('/system/health/print');
    }

    public function getSystemNtp(): array
    {
        return $this->query('/system/ntp/client/print');
    }

    public function setSystemNtp(array $params): array
    {
        return $this->execute('/system/ntp/client/set', $params);
    }

    public function systemReboot(): array
    {
        return $this->execute('/system/reboot');
    }

    public function getSystemLog(int $count = 50): array
    {
        return $this->query('/log/print');
    }

    // =============================
    // INTERFACE
    // =============================

    public function getInterfaces(): array
    {
        return $this->query('/interface/print');
    }

    public function getInterfaceStats(): array
    {
        return $this->query('/interface/print', ['stats' => '']);
    }

    public function enableInterface(string $id): array
    {
        return $this->execute('/interface/enable', ['.id' => $id]);
    }

    public function disableInterface(string $id): array
    {
        return $this->execute('/interface/disable', ['.id' => $id]);
    }

    public function setInterface(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/interface/set', $params);
    }

    public function getBridges(): array
    {
        return $this->query('/interface/bridge/print');
    }

    public function addBridge(array $params): array
    {
        return $this->execute('/interface/bridge/add', $params);
    }

    public function getBridgePorts(): array
    {
        return $this->query('/interface/bridge/port/print');
    }

    public function addBridgePort(array $params): array
    {
        return $this->execute('/interface/bridge/port/add', $params);
    }

    public function removeBridgePort(string $id): array
    {
        return $this->execute('/interface/bridge/port/remove', ['.id' => $id]);
    }

    public function getVlans(): array
    {
        return $this->query('/interface/vlan/print');
    }

    public function addVlan(array $params): array
    {
        return $this->execute('/interface/vlan/add', $params);
    }

    public function setVlan(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/interface/vlan/set', $params);
    }

    public function removeVlan(string $id): array
    {
        return $this->execute('/interface/vlan/remove', ['.id' => $id]);
    }

    // =============================
    // IP ADDRESS
    // =============================

    public function getIpAddresses(): array
    {
        return $this->query('/ip/address/print');
    }

    public function addIpAddress(array $params): array
    {
        return $this->execute('/ip/address/add', $params);
    }

    public function setIpAddress(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/ip/address/set', $params);
    }

    public function removeIpAddress(string $id): array
    {
        return $this->execute('/ip/address/remove', ['.id' => $id]);
    }

    public function enableIpAddress(string $id): array
    {
        return $this->execute('/ip/address/enable', ['.id' => $id]);
    }

    public function disableIpAddress(string $id): array
    {
        return $this->execute('/ip/address/disable', ['.id' => $id]);
    }

    // =============================
    // IP ROUTE
    // =============================

    public function getRoutes(): array
    {
        return $this->query('/ip/route/print');
    }

    public function addRoute(array $params): array
    {
        return $this->execute('/ip/route/add', $params);
    }

    public function setRoute(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/ip/route/set', $params);
    }

    public function removeRoute(string $id): array
    {
        return $this->execute('/ip/route/remove', ['.id' => $id]);
    }

    // =============================
    // DHCP SERVER
    // =============================

    public function getDhcpServers(): array
    {
        return $this->query('/ip/dhcp-server/print');
    }

    public function addDhcpServer(array $params): array
    {
        return $this->execute('/ip/dhcp-server/add', $params);
    }

    public function setDhcpServer(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/ip/dhcp-server/set', $params);
    }

    public function removeDhcpServer(string $id): array
    {
        return $this->execute('/ip/dhcp-server/remove', ['.id' => $id]);
    }

    public function getDhcpLeases(): array
    {
        return $this->query('/ip/dhcp-server/lease/print');
    }

    public function addDhcpLease(array $params): array
    {
        return $this->execute('/ip/dhcp-server/lease/add', $params);
    }

    public function removeDhcpLease(string $id): array
    {
        return $this->execute('/ip/dhcp-server/lease/remove', ['.id' => $id]);
    }

    public function makeDhcpLeaseStatic(string $id): array
    {
        return $this->execute('/ip/dhcp-server/lease/make-static', ['.id' => $id]);
    }

    public function getDhcpNetworks(): array
    {
        return $this->query('/ip/dhcp-server/network/print');
    }

    public function addDhcpNetwork(array $params): array
    {
        return $this->execute('/ip/dhcp-server/network/add', $params);
    }

    public function setDhcpNetwork(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/ip/dhcp-server/network/set', $params);
    }

    public function removeDhcpNetwork(string $id): array
    {
        return $this->execute('/ip/dhcp-server/network/remove', ['.id' => $id]);
    }

    // =============================
    // DHCP CLIENT
    // =============================

    public function getDhcpClients(): array
    {
        return $this->query('/ip/dhcp-client/print');
    }

    public function addDhcpClient(array $params): array
    {
        return $this->execute('/ip/dhcp-client/add', $params);
    }

    public function removeDhcpClient(string $id): array
    {
        return $this->execute('/ip/dhcp-client/remove', ['.id' => $id]);
    }

    // =============================
    // DNS
    // =============================

    public function getDns(): array
    {
        return $this->query('/ip/dns/print');
    }

    public function setDns(array $params): array
    {
        return $this->execute('/ip/dns/set', $params);
    }

    public function getDnsCache(): array
    {
        return $this->query('/ip/dns/cache/print');
    }

    public function flushDnsCache(): array
    {
        return $this->execute('/ip/dns/cache/flush');
    }

    public function getDnsStatic(): array
    {
        return $this->query('/ip/dns/static/print');
    }

    public function addDnsStatic(array $params): array
    {
        return $this->execute('/ip/dns/static/add', $params);
    }

    public function removeDnsStatic(string $id): array
    {
        return $this->execute('/ip/dns/static/remove', ['.id' => $id]);
    }

    // =============================
    // FIREWALL
    // =============================

    public function getFirewallFilter(): array
    {
        return $this->query('/ip/firewall/filter/print');
    }

    public function addFirewallFilter(array $params): array
    {
        return $this->execute('/ip/firewall/filter/add', $params);
    }

    public function setFirewallFilter(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/ip/firewall/filter/set', $params);
    }

    public function removeFirewallFilter(string $id): array
    {
        return $this->execute('/ip/firewall/filter/remove', ['.id' => $id]);
    }

    public function enableFirewallFilter(string $id): array
    {
        return $this->execute('/ip/firewall/filter/enable', ['.id' => $id]);
    }

    public function disableFirewallFilter(string $id): array
    {
        return $this->execute('/ip/firewall/filter/disable', ['.id' => $id]);
    }

    public function getFirewallNat(): array
    {
        return $this->query('/ip/firewall/nat/print');
    }

    public function addFirewallNat(array $params): array
    {
        return $this->execute('/ip/firewall/nat/add', $params);
    }

    public function setFirewallNat(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/ip/firewall/nat/set', $params);
    }

    public function removeFirewallNat(string $id): array
    {
        return $this->execute('/ip/firewall/nat/remove', ['.id' => $id]);
    }

    public function enableFirewallNat(string $id): array
    {
        return $this->execute('/ip/firewall/nat/enable', ['.id' => $id]);
    }

    public function disableFirewallNat(string $id): array
    {
        return $this->execute('/ip/firewall/nat/disable', ['.id' => $id]);
    }

    public function getFirewallMangle(): array
    {
        return $this->query('/ip/firewall/mangle/print');
    }

    public function addFirewallMangle(array $params): array
    {
        return $this->execute('/ip/firewall/mangle/add', $params);
    }

    public function removeFirewallMangle(string $id): array
    {
        return $this->execute('/ip/firewall/mangle/remove', ['.id' => $id]);
    }

    public function getFirewallAddressLists(): array
    {
        return $this->query('/ip/firewall/address-list/print');
    }

    public function addFirewallAddressList(array $params): array
    {
        return $this->execute('/ip/firewall/address-list/add', $params);
    }

    public function removeFirewallAddressList(string $id): array
    {
        return $this->execute('/ip/firewall/address-list/remove', ['.id' => $id]);
    }

    // =============================
    // WIRELESS / WIFI
    // =============================

    public function getWirelessInterfaces(): array
    {
        return $this->query('/interface/wireless/print');
    }

    public function setWirelessInterface(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/interface/wireless/set', $params);
    }

    public function getWirelessRegistrations(): array
    {
        return $this->query('/interface/wireless/registration-table/print');
    }

    public function getWirelessSecurityProfiles(): array
    {
        return $this->query('/interface/wireless/security-profiles/print');
    }

    public function addWirelessSecurityProfile(array $params): array
    {
        return $this->execute('/interface/wireless/security-profiles/add', $params);
    }

    public function setWirelessSecurityProfile(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/interface/wireless/security-profiles/set', $params);
    }

    // =============================
    // USER MANAGEMENT
    // =============================

    public function getUsers(): array
    {
        return $this->query('/user/print');
    }

    public function addUser(array $params): array
    {
        return $this->execute('/user/add', $params);
    }

    public function setUser(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/user/set', $params);
    }

    public function removeUser(string $id): array
    {
        return $this->execute('/user/remove', ['.id' => $id]);
    }

    public function getUserGroups(): array
    {
        return $this->query('/user/group/print');
    }

    public function getUserActiveList(): array
    {
        return $this->query('/user/active/print');
    }

    // =============================
    // IP SERVICES (Ports)
    // =============================

    public function getIpServices(): array
    {
        return $this->query('/ip/service/print');
    }

    public function setIpService(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/ip/service/set', $params);
    }

    public function enableIpService(string $id): array
    {
        return $this->execute('/ip/service/enable', ['.id' => $id]);
    }

    public function disableIpService(string $id): array
    {
        return $this->execute('/ip/service/disable', ['.id' => $id]);
    }

    // =============================
    // QUEUE (Bandwidth Control)
    // =============================

    public function getSimpleQueues(): array
    {
        return $this->query('/queue/simple/print');
    }

    public function addSimpleQueue(array $params): array
    {
        return $this->execute('/queue/simple/add', $params);
    }

    public function setSimpleQueue(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/queue/simple/set', $params);
    }

    public function removeSimpleQueue(string $id): array
    {
        return $this->execute('/queue/simple/remove', ['.id' => $id]);
    }

    public function enableSimpleQueue(string $id): array
    {
        return $this->execute('/queue/simple/enable', ['.id' => $id]);
    }

    public function disableSimpleQueue(string $id): array
    {
        return $this->execute('/queue/simple/disable', ['.id' => $id]);
    }

    public function getQueueTrees(): array
    {
        return $this->query('/queue/tree/print');
    }

    // =============================
    // PPP / VPN
    // =============================

    public function getPppProfiles(): array
    {
        return $this->query('/ppp/profile/print');
    }

    public function getPppoeServers(): array
    {
        return $this->query('/interface/pppoe-server/server/print');
    }

    public function getPppoeClients(): array
    {
        return $this->query('/interface/pppoe-client/print');
    }

    public function getPppActiveSessions(): array
    {
        return $this->query('/ppp/active/print');
    }

    public function getPppSecrets(): array
    {
        return $this->query('/ppp/secret/print');
    }

    public function addPppSecret(array $params): array
    {
        return $this->execute('/ppp/secret/add', $params);
    }

    public function setPppSecret(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/ppp/secret/set', $params);
    }

    public function removePppSecret(string $id): array
    {
        return $this->execute('/ppp/secret/remove', ['.id' => $id]);
    }

    // =============================
    // HOTSPOT
    // =============================

    public function getHotspotServers(): array
    {
        return $this->query('/ip/hotspot/print');
    }

    public function getHotspotUsers(): array
    {
        return $this->query('/ip/hotspot/user/print');
    }

    public function addHotspotUser(array $params): array
    {
        return $this->execute('/ip/hotspot/user/add', $params);
    }

    public function setHotspotUser(string $id, array $params): array
    {
        $params['.id'] = $id;
        return $this->execute('/ip/hotspot/user/set', $params);
    }

    public function removeHotspotUser(string $id): array
    {
        return $this->execute('/ip/hotspot/user/remove', ['.id' => $id]);
    }

    public function getHotspotActiveUsers(): array
    {
        return $this->query('/ip/hotspot/active/print');
    }

    public function getHotspotProfiles(): array
    {
        return $this->query('/ip/hotspot/user/profile/print');
    }

    // =============================
    // ARP
    // =============================

    public function getArpTable(): array
    {
        return $this->query('/ip/arp/print');
    }

    public function removeArpEntry(string $id): array
    {
        return $this->execute('/ip/arp/remove', ['.id' => $id]);
    }

    // =============================
    // NEIGHBOR / CDP
    // =============================

    public function getNeighbors(): array
    {
        return $this->query('/ip/neighbor/print');
    }

    // =============================
    // BACKUP & SCRIPT
    // =============================

    public function getScripts(): array
    {
        return $this->query('/system/script/print');
    }

    public function addScript(array $params): array
    {
        return $this->execute('/system/script/add', $params);
    }

    public function runScript(string $id): array
    {
        return $this->execute('/system/script/run', ['.id' => $id]);
    }

    public function removeScript(string $id): array
    {
        return $this->execute('/system/script/remove', ['.id' => $id]);
    }

    public function createBackup(string $name = 'backup'): array
    {
        return $this->execute('/system/backup/save', ['name' => $name]);
    }

    public function getFiles(): array
    {
        return $this->query('/file/print');
    }

    // =============================
    // TOOLS
    // =============================

    public function ping(string $address, int $count = 4): array
    {
        return $this->execute('/ping', [
            'address' => $address,
            'count'   => (string) $count,
        ]);
    }

    public function traceroute(string $address): array
    {
        return $this->execute('/tool/traceroute', ['address' => $address]);
    }

    public function getTrafficMonitor(string $interface): array
    {
        return $this->execute('/interface/monitor-traffic', [
            'interface' => $interface,
            'once'      => '',
        ]);
    }

    // =============================
    // SCHEDULER
    // =============================

    public function getSchedulers(): array
    {
        return $this->query('/system/scheduler/print');
    }

    public function addScheduler(array $params): array
    {
        return $this->execute('/system/scheduler/add', $params);
    }

    public function removeScheduler(string $id): array
    {
        return $this->execute('/system/scheduler/remove', ['.id' => $id]);
    }

    // =============================
    // SNMP
    // =============================

    public function getSnmpSettings(): array
    {
        return $this->query('/snmp/print');
    }

    public function setSnmpSettings(array $params): array
    {
        return $this->execute('/snmp/set', $params);
    }

    // =============================
    // ROUTING OSPF / BGP
    // =============================

    public function getOspfInstances(): array
    {
        return $this->query('/routing/ospf/instance/print');
    }

    public function getBgpInstances(): array
    {
        return $this->query('/routing/bgp/instance/print');
    }

    public function getBgpPeers(): array
    {
        return $this->query('/routing/bgp/peer/print');
    }
}
