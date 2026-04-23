<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenTicketController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\DatapasController;
// use App\Http\Controllers\LaporanpmController;
use App\Http\Controllers\PmlibertaController;
use App\Http\Controllers\CloseTicketController;
use App\Http\Controllers\DetailticketController;
use App\Http\Controllers\SummaryTicketController;
use App\Http\Controllers\PergantianController;
use App\Http\Controllers\LogpergantianController;
use App\Http\Controllers\SparetrackerController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\LaporanCMController;
use App\Http\Controllers\MyDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\PiketController;
use App\Http\Controllers\SummaryPMController;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\RemoteLogController;
use App\Http\Controllers\MikrotikController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- */
// --- MY DASHBOARD & CHAT ROUTES ---
Route::get('/dashboard', [MyDashboardController::class, 'index'])->name('mydashboard');
Route::get('/ticket/detail/{site_code}', [MyDashboardController::class, 'getDetail']);
Route::post('/chat/send', [MyDashboardController::class, 'storeMessage'])->name('chat.send');
Route::get('/chat/fetch', [MyDashboardController::class, 'fetchMessages'])->name('chat.fetch');
Route::get('/tickets/filter', [MyDashboardController::class, 'getFilteredTickets'])->name('tickets.filter');
Route::get('/dashboard/stats', [MyDashboardController::class, 'fetchStats'])->name('dashboard.stats');

// --- SPAREPART NEEDED DASHBOARD ROUTES ---
Route::get('/sparepart-needed', [\App\Http\Controllers\SparepartNeededController::class, 'index'])->name('sparepart.needed.index');
Route::post('/sparepart-needed/store', [\App\Http\Controllers\SparepartNeededController::class, 'store'])->name('sparepart.needed.store');
Route::put('/sparepart-needed/update/{id}', [\App\Http\Controllers\SparepartNeededController::class, 'update'])->name('sparepart.needed.update');
Route::delete('/sparepart-needed/delete/{id}', [\App\Http\Controllers\SparepartNeededController::class, 'destroy'])->name('sparepart.needed.destroy');
Route::patch('/sparepart-needed/status/{id}', [\App\Http\Controllers\SparepartNeededController::class, 'updateStatus'])->name('sparepart.needed.status');
Route::post('/sparepart-needed/print', [\App\Http\Controllers\SparepartNeededController::class, 'printPengajuan'])->name('sparepart.needed.print');

// --- REMOTE LOG (AJAX store - harus login) ---
Route::post('/remote-log/store', [RemoteLogController::class, 'store'])->name('remotelog.store')->middleware('auth');

// Halaman Utama (Landing Page) via mns.nustech.co.id
Route::domain('mns.nustech.co.id')->group(function () {
    Route::get('/', [LandingpageController::class, 'index'])->name('landingpage');
});

// Halaman Utama (Home) via nustech.co.id
Route::domain('nustech.co.id')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Fallback for timeout-logout to prevent 404
Route::get('/timeout-logout', function () {
    return redirect('/login');
});

// CSRF Token Refresh — dipanggil JS di semua halaman agar session tidak expire
Route::get('/csrf-refresh', function () {
    return response()->json(['token' => csrf_token()]);
})->name('csrf.refresh');

// --- NOTIFICATION ROUTES ---
Route::get('/notifications/fetch', function () {
    if (!auth()->check())
        return response()->json([]);
    return response()->json([
        'notifications' => auth()->user()->notifications()->latest()->take(10)->get(),
        'count' => auth()->user()->unreadNotifications->count()
    ]);
})->name('notifications.fetch');

Route::post('/notifications/mark-read', function () {
    if (!auth()->check())
        return response()->json(['success' => false]);
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
})->name('notifications.markRead');

Route::get('/get-drive-title', function (Illuminate\Http\Request $request) {
    $url = $request->query('url');
    if (!$url)
        return response()->json(['error' => 'URL is required'], 400);
    try {
        $client = new \GuzzleHttp\Client([
            'timeout' => 5,
            'verify' => false,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
            ]
        ]);
        $response = $client->get($url);
        $html = (string) $response->getBody();
        preg_match('/<title>(.*?)<\/title>/', $html, $matches);
        if (isset($matches[1])) {
            $title = str_replace(' - Google Drive', '', $matches[1]);
            return response()->json(['title' => html_entity_decode(trim($title))]);
        }
        return response()->json(['error' => 'Title not found'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->name('get.drive.title')->middleware('auth');


// --- PROTECTED ROUTES (Harus login dulu) ---
Route::middleware(['auth'])->group(function () {

    // --- REMOTE LOG AUDIT TRAIL ---
    Route::get('/remote-log', [RemoteLogController::class, 'index'])->name('remotelog')->middleware('role:superadmin');

    // --- ACTIVITY LOG ---


    // --- SITES / DATASITE ROUTES ---
    Route::get('/sites/export', [SiteController::class, 'export'])->name('sites.export');
    Route::post('/sites/import', [SiteController::class, 'import'])->name('sites.import');
    Route::resource('sites', SiteController::class)->names(['index' => 'datasite'])->except(['show', 'create', 'edit']);

    // --- OPEN TICKET ROUTES ---
    Route::prefix('open-ticket')->group(
        function () {
            // Sekarang namanya sudah 'open.ticket' sesuai pemanggilan di Blade
            Route::get('/', [OpenTicketController::class, 'index'])->name('open.ticket');

            // 2. Rute CRUD dan Operasional
            Route::post('/store', [OpenTicketController::class, 'store'])->name('open.ticket.store');
            Route::get('/export', [OpenTicketController::class, 'export'])->name('open.ticket.export');
            Route::post('/import', [OpenTicketController::class, 'import'])->name('open.ticket.import');
            Route::put('/{id}', [OpenTicketController::class, 'update'])->name('open.ticket.update');
            Route::delete('/{id}', [OpenTicketController::class, 'destroy'])->name('open.ticket.destroy');
            Route::post('/import', [OpenTicketController::class, 'import'])->name('open.ticket.import');

            // 3. Rute Proses Close
            Route::put('/close/{id}', [OpenTicketController::class, 'closeTicket'])->name('open.ticket.close');
        }
    );

    // --- CLOSE TICKET ROUTES ---
    Route::get('/close-ticket', [CloseTicketController::class, 'index'])->name('close.ticket');
    Route::post('/close-ticket/store', [CloseTicketController::class, 'store'])->name('close.ticket.store');
    Route::get('/close-ticket/export', [CloseTicketController::class, 'export'])->name('close.ticket.export');
    Route::post('/close-ticket/import', [CloseTicketController::class, 'import'])->name('close.ticket.import');
    Route::put('/close-ticket/{id}', [CloseTicketController::class, 'update'])->name('close.ticket.update');
    Route::delete('/close-ticket/{id}', [CloseTicketController::class, 'destroy'])->name('close.ticket.destroy');

    Route::get('/summaryticket', [SummaryTicketController::class, 'index'])->name('summaryticket');
    Route::get('/detailticket', [DetailticketController::class, 'index'])->name('detailticket');

    // --- DATA PAS ROUTES ---
    Route::get('/datapass', [DatapasController::class, 'index'])->name('datapas');
    Route::post('/datapas/store', [DatapasController::class, 'store'])->name('datapas.store');
    Route::get('/datapas/export', [DatapasController::class, 'export'])->name('datapas.export');
    Route::post('/datapas/import', [DatapasController::class, 'import'])->name('datapas.import');
    Route::put('/datapass/{id}', [DatapasController::class, 'update'])->name('datapas.update');
    Route::delete('/datapass/{id}', [DatapasController::class, 'destroy'])->name('datapas.destroy');

    // --- PERANGKAT & TRACKER (Admin & Superadmin) ---
    Route::middleware(['role:admin,superadmin'])->group(function () {
        Route::get('/pergantianperangkat', [PergantianController::class, 'index'])->name('pergantianperangkat');
        Route::post('/pergantianperangkat/store', [PergantianController::class, 'store'])->name('pergantianperangkat.store');
        Route::post('/pergantianperangkat/import', [PergantianController::class, 'import'])->name('pergantianperangkat.import');
        Route::get('/pergantianperangkat/export', [PergantianController::class, 'export'])->name('pergantianperangkat.export');
        Route::put('/pergantianperangkat/update/{id}', [PergantianController::class, 'update'])->name('pergantianperangkat.update');
        Route::delete('/pergantianperangkat/delete/{id}', [PergantianController::class, 'destroy'])->name('pergantianperangkat.destroy');
        Route::get('/logpergantian', [LogpergantianController::class, 'index'])->name('logpergantian');
        Route::get('/sparetracker', [SparetrackerController::class, 'index'])->name('sparetracker');
        Route::post('/sparetracker/import', [SparetrackerController::class, 'import'])->name('sparetracker.import');
        Route::get('/sparetracker/export', [SparetrackerController::class, 'export'])->name('sparetracker.export');
        Route::post('/sparetracker/store', [SparetrackerController::class, 'store'])->name('sparetracker.store');
        Route::post('/sparetracker/update', [SparetrackerController::class, 'update'])->name('sparetracker.update');
        Route::delete('/sparetracker/delete/{id}', [SparetrackerController::class, 'destroy'])->name('sparetracker.destroy');
        Route::get('/pm-summary', [SummaryController::class, 'index'])->name('summaryperangkat');
    });

    // --- TO DO LIST ---
    Route::get('/todolist', [TodolistController::class, 'index'])->name('todolist');
    Route::post('/todolist/store', [TodolistController::class, 'store'])->name('todolist.store');
    Route::post('/todolist/toggle/{id}', [TodolistController::class, 'toggle'])->name('todolist.toggle');
    Route::post('/todolist/update/{id}', [TodolistController::class, 'update'])->name('todolist.update');
    Route::delete('/todolist/delete/{id}', [TodolistController::class, 'destroy'])->name('todolist.destroy');
    Route::post('/todolist/subtask/add/{id}', [TodolistController::class, 'addSubTask'])->name('subtask.add');
    Route::post('/todolist/subtask/toggle/{id}', [TodolistController::class, 'toggleSubTask'])->name('subtask.toggle');
    Route::post('/todolist/update-title/{id}', [TodolistController::class, 'updateTitle']);
    Route::post('/todolist/subtask/update/{id}', [TodolistController::class, 'updateSubTask']);
    Route::delete('/todolist/subtask/delete/{id}', [TodolistController::class, 'deleteSubTask']);

    // --- LAPORAN CM ROUTES (Admin & Superadmin) ---
    Route::middleware(['role:admin,superadmin'])->group(function () {
        Route::get('/laporancm', [LaporanCMController::class, 'index'])->name('laporancm');
        Route::post('/laporancm/store', [LaporanCMController::class, 'store'])->name('laporancm.store');
        Route::put('/laporancm/{id}', [LaporanCMController::class, 'update'])->name('laporancm.update');
        Route::delete('/laporancm/{id}', [LaporanCMController::class, 'destroy'])->name('laporancm.destroy');
        Route::get('/laporancm/export', [LaporanCMController::class, 'export'])->name('laporancm.export');
        Route::post('/laporancm/import', [LaporanCMController::class, 'import'])->name('laporancm.import');
    });

    // --- PM LIBERTA ROUTES ---
    Route::get('/PMLiberta', [PMLibertaController::class, 'index'])->name('pmliberta');
    Route::post('/PMLiberta/store', [PMLibertaController::class, 'store'])->name('pmliberta.store');
    Route::post('/PMLiberta/import', [PMLibertaController::class, 'import'])->name('pmliberta.import');
    Route::get('/PMLiberta/export', [PMLibertaController::class, 'export'])->name('pmliberta.export');
    Route::put('/PMLiberta/{id}', [PMLibertaController::class, 'update'])->name('pmliberta.update');
    Route::delete('/PMLiberta/{id}', [PMLibertaController::class, 'destroy'])->name('pmliberta.destroy');

    // --- JADWAL PIKET ROUTES (Superadmin Only) ---
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/jadwalpiket', [PiketController::class, 'index'])->name('jadwalpiket');
        Route::post('/jadwal-piket/upload', [PiketController::class, 'upload'])->name('piket.upload');
        Route::delete('/jadwal-piket/delete-all', [PiketController::class, 'deleteAll'])->name('piket.deleteAll');
        Route::post('/jadwal-piket/batch-update', [PiketController::class, 'batchUpdate'])->name('piket.batchUpdate');
    });

    // --- SUMMARY PM ROUTES ---
    Route::get('/summarypm', [SummaryPMController::class, 'index'])->name('summarypm');
    Route::get('/summarypm/chart-data', [SummaryPMController::class, 'getChartData'])->name('summarypm.chartdata');
    Route::get('/summarypm/sites', [SummaryPMController::class, 'getSites'])->name('summarypm.sites');

    // Rute yang memerlukan login (Halaman Landing, Profile, dll)

    // Halaman landingpage
    Route::get('/landingpage', [LandingpageController::class, 'index'])->name('landingpage');
    Route::get('/todo', [LandingpageController::class, 'todo'])->name('todo');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Setting (Superadmin Only)
    Route::middleware(['role:superadmin'])->prefix('setting')->group(
        function () {
            Route::get('/', [SettingController::class, 'index'])->name('setting.index');
            Route::post('/store', [SettingController::class, 'store'])->name('setting.store');
            Route::put('/update/{id}', [SettingController::class, 'update'])->name('setting.update');
            Route::delete('/destroy/{id}', [SettingController::class, 'destroy'])->name('setting.destroy');
        }
    );

    // ============================================================
    // --- MIKROTIK MANAGER ROUTES ---
    // ============================================================
    Route::prefix('mikrotik')->name('mikrotik.')->group(function () {
        // Halaman Utama
        Route::get('/', [MikrotikController::class, 'index'])->name('index');

        // Credentials
        Route::get('/credentials/{siteId}', [MikrotikController::class, 'getCredentials'])->name('credentials.get');
        Route::post('/credentials/save', [MikrotikController::class, 'saveCredentials'])->name('credentials.save');
        Route::post('/credentials/test', [MikrotikController::class, 'testConnection'])->name('credentials.test');

        // System Info
        Route::get('/system/{siteId}', [MikrotikController::class, 'getSystemInfo'])->name('system.info');
        Route::post('/system/{siteId}/identity', [MikrotikController::class, 'setSystemIdentity'])->name('system.identity');
        Route::get('/system/{siteId}/log', [MikrotikController::class, 'getSystemLog'])->name('system.log');
        Route::get('/system/{siteId}/ntp', [MikrotikController::class, 'getSystemNtp'])->name('system.ntp');
        Route::post('/system/{siteId}/ntp', [MikrotikController::class, 'setSystemNtp'])->name('system.ntp.set');
        Route::post('/system/{siteId}/reboot', [MikrotikController::class, 'systemReboot'])->name('system.reboot');

        // Interface
        Route::get('/interface/{siteId}', [MikrotikController::class, 'getInterfaces'])->name('interface.list');
        Route::post('/interface/{siteId}/set', [MikrotikController::class, 'setInterface'])->name('interface.set');
        Route::post('/interface/{siteId}/toggle', [MikrotikController::class, 'toggleInterface'])->name('interface.toggle');
        Route::get('/vlan/{siteId}', [MikrotikController::class, 'getVlans'])->name('vlan.list');
        Route::post('/vlan/{siteId}/add', [MikrotikController::class, 'addVlan'])->name('vlan.add');
        Route::delete('/vlan/{siteId}/remove', [MikrotikController::class, 'removeVlan'])->name('vlan.remove');
        Route::get('/bridge/{siteId}', [MikrotikController::class, 'getBridges'])->name('bridge.list');
        Route::get('/bridge/{siteId}/ports', [MikrotikController::class, 'getBridgePorts'])->name('bridge.ports');

        // IP Address
        Route::get('/ip/{siteId}', [MikrotikController::class, 'getIpAddresses'])->name('ip.list');
        Route::post('/ip/{siteId}/add', [MikrotikController::class, 'addIpAddress'])->name('ip.add');
        Route::post('/ip/{siteId}/set', [MikrotikController::class, 'setIpAddress'])->name('ip.set');
        Route::delete('/ip/{siteId}/remove', [MikrotikController::class, 'removeIpAddress'])->name('ip.remove');

        // Routes
        Route::get('/routes/{siteId}', [MikrotikController::class, 'getRoutes'])->name('route.list');
        Route::post('/routes/{siteId}/add', [MikrotikController::class, 'addRoute'])->name('route.add');
        Route::delete('/routes/{siteId}/remove', [MikrotikController::class, 'removeRoute'])->name('route.remove');

        // DHCP
        Route::get('/dhcp/{siteId}/servers', [MikrotikController::class, 'getDhcpServers'])->name('dhcp.servers');
        Route::get('/dhcp/{siteId}/leases', [MikrotikController::class, 'getDhcpLeases'])->name('dhcp.leases');
        Route::post('/dhcp/{siteId}/lease/add', [MikrotikController::class, 'addDhcpLease'])->name('dhcp.lease.add');
        Route::delete('/dhcp/{siteId}/lease', [MikrotikController::class, 'removeDhcpLease'])->name('dhcp.lease.remove');
        Route::post('/dhcp/{siteId}/lease/static', [MikrotikController::class, 'makeDhcpLeaseStatic'])->name('dhcp.lease.static');
        Route::get('/dhcp/{siteId}/networks', [MikrotikController::class, 'getDhcpNetworks'])->name('dhcp.networks');

        // DNS
        Route::get('/dns/{siteId}', [MikrotikController::class, 'getDns'])->name('dns.info');
        Route::post('/dns/{siteId}/set', [MikrotikController::class, 'setDns'])->name('dns.set');
        Route::get('/dns/{siteId}/static', [MikrotikController::class, 'getDnsStatic'])->name('dns.static');
        Route::post('/dns/{siteId}/static/add', [MikrotikController::class, 'addDnsStatic'])->name('dns.static.add');
        Route::delete('/dns/{siteId}/static', [MikrotikController::class, 'removeDnsStatic'])->name('dns.static.remove');

        // Firewall
        Route::get('/firewall/{siteId}/filter', [MikrotikController::class, 'getFirewallFilter'])->name('firewall.filter');
        Route::post('/firewall/{siteId}/filter/add', [MikrotikController::class, 'addFirewallFilter'])->name('firewall.filter.add');
        Route::post('/firewall/{siteId}/filter/toggle', [MikrotikController::class, 'toggleFirewallFilter'])->name('firewall.filter.toggle');
        Route::delete('/firewall/{siteId}/filter', [MikrotikController::class, 'removeFirewallFilter'])->name('firewall.filter.remove');
        Route::get('/firewall/{siteId}/nat', [MikrotikController::class, 'getFirewallNat'])->name('firewall.nat');
        Route::post('/firewall/{siteId}/nat/add', [MikrotikController::class, 'addFirewallNat'])->name('firewall.nat.add');
        Route::delete('/firewall/{siteId}/nat', [MikrotikController::class, 'removeFirewallNat'])->name('firewall.nat.remove');
        Route::get('/firewall/{siteId}/mangle', [MikrotikController::class, 'getFirewallMangle'])->name('firewall.mangle');
        Route::get('/firewall/{siteId}/address-list', [MikrotikController::class, 'getFirewallAddressLists'])->name('firewall.addresslist');
        Route::post('/firewall/{siteId}/address-list', [MikrotikController::class, 'addFirewallAddressList'])->name('firewall.addresslist.add');

        // Wireless
        Route::get('/wireless/{siteId}', [MikrotikController::class, 'getWireless'])->name('wireless.info');
        Route::post('/wireless/{siteId}/set', [MikrotikController::class, 'setWireless'])->name('wireless.set');

        // Users MikroTik
        Route::get('/users/{siteId}', [MikrotikController::class, 'getUsers'])->name('users.list');
        Route::post('/users/{siteId}/add', [MikrotikController::class, 'addUser'])->name('users.add');
        Route::delete('/users/{siteId}/remove', [MikrotikController::class, 'removeUser'])->name('users.remove');

        // Queue
        Route::get('/queue/{siteId}', [MikrotikController::class, 'getQueues'])->name('queue.list');
        Route::post('/queue/{siteId}/add', [MikrotikController::class, 'addSimpleQueue'])->name('queue.add');
        Route::delete('/queue/{siteId}/remove', [MikrotikController::class, 'removeSimpleQueue'])->name('queue.remove');
        Route::post('/queue/{siteId}/toggle', [MikrotikController::class, 'toggleQueue'])->name('queue.toggle');

        // PPP & VPN
        Route::get('/ppp/{siteId}', [MikrotikController::class, 'getPpp'])->name('ppp.list');
        Route::post('/ppp/{siteId}/secret/add', [MikrotikController::class, 'addPppSecret'])->name('ppp.secret.add');
        Route::delete('/ppp/{siteId}/secret', [MikrotikController::class, 'removePppSecret'])->name('ppp.secret.remove');

        // Hotspot
        Route::get('/hotspot/{siteId}', [MikrotikController::class, 'getHotspot'])->name('hotspot.list');
        Route::post('/hotspot/{siteId}/user/add', [MikrotikController::class, 'addHotspotUser'])->name('hotspot.user.add');
        Route::delete('/hotspot/{siteId}/user', [MikrotikController::class, 'removeHotspotUser'])->name('hotspot.user.remove');

        // IP Services
        Route::get('/services/{siteId}', [MikrotikController::class, 'getIpServices'])->name('services.list');
        Route::post('/services/{siteId}/set', [MikrotikController::class, 'setIpService'])->name('services.set');
        Route::post('/services/{siteId}/toggle', [MikrotikController::class, 'toggleIpService'])->name('services.toggle');

        // ARP & Neighbor
        Route::get('/arp/{siteId}', [MikrotikController::class, 'getArp'])->name('arp.list');

        // Scripts & Scheduler
        Route::get('/scripts/{siteId}', [MikrotikController::class, 'getScripts'])->name('scripts.list');
        Route::post('/scripts/{siteId}/add', [MikrotikController::class, 'addScript'])->name('scripts.add');
        Route::post('/scripts/{siteId}/run', [MikrotikController::class, 'runScript'])->name('scripts.run');
        Route::post('/scheduler/{siteId}/add', [MikrotikController::class, 'addScheduler'])->name('scheduler.add');

        // Backup & Files
        Route::post('/backup/{siteId}', [MikrotikController::class, 'createBackup'])->name('backup.create');
        Route::get('/files/{siteId}', [MikrotikController::class, 'getFiles'])->name('files.list');

        // Tools
        Route::post('/tools/{siteId}/ping', [MikrotikController::class, 'ping'])->name('tools.ping');
        Route::post('/tools/{siteId}/traffic', [MikrotikController::class, 'getTrafficMonitor'])->name('tools.traffic');

        // Audit Log
        Route::get('/logs/{siteId}', [MikrotikController::class, 'getCommandLogs'])->name('logs');
    });
});
