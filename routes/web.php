<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenTicketController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\DatapasController;
use App\Http\Controllers\LaporanpmController;
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

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- */
// --- MY DASHBOARD & CHAT ROUTES ---
Route::get('/dashboard', [MyDashboardController::class , 'index'])->name('mydashboard');
Route::get('/ticket/detail/{site_code}', [MyDashboardController::class , 'getDetail']);
Route::post('/chat/send', [MyDashboardController::class , 'storeMessage'])->name('chat.send');
Route::get('/chat/fetch', [MyDashboardController::class , 'fetchMessages'])->name('chat.fetch');
Route::get('/tickets/filter', [MyDashboardController::class , 'getFilteredTickets'])->name('tickets.filter');
Route::get('/dashboard/stats', [MyDashboardController::class , 'fetchStats'])->name('dashboard.stats');

// --- REMOTE LOG (AJAX store - harus login) ---
Route::post('/remote-log/store', [RemoteLogController::class , 'store'])->name('remotelog.store')->middleware('auth');

// Halaman Utama (Landing Page) via mns.nustech.co.id
Route::domain('mns.nustech.co.id')->group(function () {
    Route::get('/', [LandingpageController::class, 'index'])->name('landingpage');
});

// Halaman Utama (Home) via nustech.co.id
Route::domain('nustech.co.id')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

// Auth Routes
Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'login']);
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');


// --- PROTECTED ROUTES (Harus login dulu) ---
Route::middleware(['auth'])->group(function () {

    // --- REMOTE LOG AUDIT TRAIL ---
    Route::get('/remote-log', [RemoteLogController::class , 'index'])->name('remotelog')->middleware('role:superadmin');

    // --- SITES / DATASITE ROUTES ---
    Route::get('/sites/export', [SiteController::class , 'export'])->name('sites.export');
    Route::post('/sites/import', [SiteController::class , 'import'])->name('sites.import');
    Route::resource('sites', SiteController::class)->names(['index' => 'datasite'])->except(['show', 'create', 'edit']);

    // --- OPEN TICKET ROUTES ---
    Route::prefix('open-ticket')->group(function () {
            // Sekarang namanya sudah 'open.ticket' sesuai pemanggilan di Blade
            Route::get('/', [OpenTicketController::class , 'index'])->name('open.ticket');

            // 2. Rute CRUD dan Operasional
            Route::post('/store', [OpenTicketController::class , 'store'])->name('open.ticket.store');
            Route::get('/export', [OpenTicketController::class , 'export'])->name('open.ticket.export');
            Route::post('/import', [OpenTicketController::class , 'import'])->name('open.ticket.import');
            Route::put('/{id}', [OpenTicketController::class , 'update'])->name('open.ticket.update');
            Route::delete('/{id}', [OpenTicketController::class , 'destroy'])->name('open.ticket.destroy');
            Route::post('/import', [OpenTicketController::class , 'import'])->name('open.ticket.import');

            // 3. Rute Proses Close
            Route::put('/close/{id}', [OpenTicketController::class , 'closeTicket'])->name('open.ticket.close');
        }
        );

        // --- CLOSE TICKET ROUTES ---
        Route::get('/close-ticket', [CloseTicketController::class , 'index'])->name('close.ticket');
        Route::post('/close-ticket/store', [CloseTicketController::class , 'store'])->name('close.ticket.store');
        Route::get('/close-ticket/export', [CloseTicketController::class , 'export'])->name('close.ticket.export');
        Route::post('/close-ticket/import', [CloseTicketController::class , 'import'])->name('close.ticket.import');
        Route::put('/close-ticket/{id}', [CloseTicketController::class , 'update'])->name('close.ticket.update');
        Route::delete('/close-ticket/{id}', [CloseTicketController::class , 'destroy'])->name('close.ticket.destroy');

        Route::get('/summaryticket', [SummaryTicketController::class , 'index'])->name('summaryticket');
        Route::get('/detailticket', [DetailticketController::class , 'index'])->name('detailticket');

        // --- DATA PAS ROUTES ---
        Route::get('/datapass', [DatapasController::class , 'index'])->name('datapas');
        Route::post('/datapas/store', [DatapasController::class , 'store'])->name('datapas.store');
        Route::get('/datapas/export', [DatapasController::class , 'export'])->name('datapas.export');
        Route::post('/datapas/import', [DatapasController::class , 'import'])->name('datapas.import');
        Route::put('/datapass/{id}', [DatapasController::class , 'update'])->name('datapas.update');
        Route::delete('/datapass/{id}', [DatapasController::class , 'destroy'])->name('datapas.destroy');

        // --- PERANGKAT & TRACKER ---
        Route::get('/pergantianperangkat', [PergantianController::class , 'index'])->name('pergantianperangkat');
        Route::post('/pergantianperangkat/store', [PergantianController::class , 'store'])->name('pergantianperangkat.store');
        Route::post('/pergantianperangkat/import', [PergantianController::class , 'import'])->name('pergantianperangkat.import');
        Route::get('/pergantianperangkat/export', [PergantianController::class , 'export'])->name('pergantianperangkat.export');
        Route::put('/pergantianperangkat/update/{id}', [PergantianController::class , 'update'])->name('pergantianperangkat.update');
        Route::delete('/pergantianperangkat/delete/{id}', [PergantianController::class , 'destroy'])->name('pergantianperangkat.destroy');
        Route::get('/logpergantian', [LogpergantianController::class , 'index'])->name('logpergantian');
        Route::get('/sparetracker', [SparetrackerController::class , 'index'])->name('sparetracker');
        Route::post('/sparetracker/import', [SparetrackerController::class , 'import'])->name('sparetracker.import');
        Route::get('/sparetracker/export', [SparetrackerController::class , 'export'])->name('sparetracker.export');
        Route::post('/sparetracker/store', [SparetrackerController::class , 'store'])->name('sparetracker.store');
        Route::post('/sparetracker/update', [SparetrackerController::class , 'update'])->name('sparetracker.update');
        Route::delete('/sparetracker/delete/{id}', [SparetrackerController::class , 'destroy'])->name('sparetracker.destroy');
        Route::get('/pm-summary', [SummaryController::class , 'index'])->name('summaryperangkat');

        // --- TO DO LIST ---
        Route::get('/todolist', [TodolistController::class , 'index'])->name('todolist');
        Route::post('/todolist/store', [TodolistController::class , 'store'])->name('todolist.store');
        Route::post('/todolist/toggle/{id}', [TodolistController::class , 'toggle'])->name('todolist.toggle');
        Route::post('/todolist/update/{id}', [TodolistController::class , 'update'])->name('todolist.update');
        Route::delete('/todolist/delete/{id}', [TodolistController::class , 'destroy'])->name('todolist.destroy');
        Route::post('/todolist/subtask/add/{id}', [TodolistController::class , 'addSubTask'])->name('subtask.add');
        Route::post('/todolist/subtask/toggle/{id}', [TodolistController::class , 'toggleSubTask'])->name('subtask.toggle');
        Route::post('/todolist/update-title/{id}', [TodolistController::class , 'updateTitle']);
        Route::post('/todolist/subtask/update/{id}', [TodolistController::class , 'updateSubTask']);

        // --- LAPORAN CM ROUTES ---
        Route::get('/laporancm', [LaporanCMController::class , 'index'])->name('laporancm');
        Route::post('/laporancm/store', [LaporanCMController::class , 'store'])->name('laporancm.store');
        Route::put('/laporancm/{id}', [LaporanCMController::class , 'update'])->name('laporancm.update');
        Route::delete('/laporancm/{id}', [LaporanCMController::class , 'destroy'])->name('laporancm.destroy');
        Route::get('/laporancm/export', [LaporanCMController::class , 'export'])->name('laporancm.export');
        Route::post('/laporancm/import', [LaporanCMController::class , 'import'])->name('laporancm.import');

        // --- PM LIBERTA ROUTES ---
        Route::get('/PMLiberta', [PMLibertaController::class , 'index'])->name('pmliberta');
        Route::post('/PMLiberta/store', [PMLibertaController::class , 'store'])->name('pmliberta.store');
        Route::post('/PMLiberta/import', [PMLibertaController::class , 'import'])->name('pmliberta.import');
        Route::get('/PMLiberta/export', [PMLibertaController::class , 'export'])->name('pmliberta.export');
        Route::put('/PMLiberta/{id}', [PMLibertaController::class , 'update'])->name('pmliberta.update');
        Route::delete('/PMLiberta/{id}', [PMLibertaController::class , 'destroy'])->name('pmliberta.destroy');

        // --- JADWAL PIKET ROUTES ---
        Route::get('/jadwalpiket', [PiketController::class , 'index'])->name('jadwalpiket');
        Route::post('/jadwal-piket/upload', [PiketController::class , 'upload'])->name('piket.upload');
        Route::delete('/jadwal-piket/delete-all', [PiketController::class , 'deleteAll'])->name('piket.deleteAll');
        Route::post('/jadwal-piket/batch-update', [PiketController::class , 'batchUpdate'])->name('piket.batchUpdate');

        // --- SUMMARY PM ROUTES ---
        Route::get('/summarypm', [SummaryPMController::class , 'index'])->name('summarypm');
        Route::get('/summarypm/chart-data', [SummaryPMController::class , 'getChartData'])->name('summarypm.chartdata');
        Route::get('/summarypm/sites', [SummaryPMController::class , 'getSites'])->name('summarypm.sites');

        // Rute yang memerlukan login (Middleware Auth)        Route::middleware(['auth'])->group(function () {
    
        // Halaman landingpage
        Route::get('/landingpage', [LandingpageController::class , 'index'])->name('landingpage');
        Route::get('/todo', [LandingpageController::class , 'todo'])->name('todo');

        // Profile
        Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class , 'update'])->name('profile.update');

        // Setting (Superadmin Only)
        Route::middleware(['role:superadmin'])->prefix('setting')->group(function () {
            Route::get('/', [SettingController::class , 'index'])->name('setting.index');
            Route::post('/store', [SettingController::class , 'store'])->name('setting.store');
            Route::put('/update/{id}', [SettingController::class , 'update'])->name('setting.update');
            Route::delete('/destroy/{id}', [SettingController::class , 'destroy'])->name('setting.destroy');
        }
        );
    });
