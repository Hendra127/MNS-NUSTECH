<?php

use App\Models\User;
use App\Models\JadwalPiket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$staff = [
    ['name' => 'Raden Kukuh Ridho Ahadi', 'email' => 'raden@nustech.co.id', 'role' => 'admin'],
    ['name' => 'Hendra Hadi Pratama', 'email' => 'hendra@nustech.co.id', 'role' => 'superadmin'],
    ['name' => 'Andri Pratama', 'email' => 'andri@nustech.co.id', 'role' => 'admin'],
    ['name' => 'Muhammad Azul', 'email' => 'muhammad@nustech.co.id', 'role' => 'admin'],
    ['name' => 'Lalu Taufiq Wijaya', 'email' => 'lalu@nustech.co.id', 'role' => 'admin'],
    ['name' => 'Aditia Marandika Rachman', 'email' => 'aditia@nustech.co.id', 'role' => 'admin'],
    ['name' => 'IWAN VANI', 'email' => 'iwan@nustech.co.id', 'role' => 'admin']
];

try {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    // Truncate users to reset IDs to 1
    User::truncate();
    echo "Users table truncated (IDs reset to 1).\n";

    // Re-create staff users
    foreach($staff as $u) {
        User::create([
            'name' => $u['name'],
            'email' => $u['email'],
            'password' => Hash::make('Masuk123*#'),
            'role' => $u['role'],
            'is_admin' => ($u['role'] === 'superadmin' ? 1 : 0)
        ]);
        echo "Created staff: " . $u['name'] . "\n";
    }

    // Add fallback Admin
    User::create([
        'name' => 'Admin',
        'email' => 'admin@nustech.co.id',
        'password' => Hash::make('Admin123*#'),
        'role' => 'superadmin',
        'is_admin' => 1
    ]);
    echo "Created fallback Admin.\n";

    // SYNC SCHEDULE - Link user_id based on name
    echo "Syncing JadwalPiket user_id references...\n";
    $piketRecords = JadwalPiket::all();
    $users = User::all();
    
    $syncCount = 0;
    foreach($piketRecords as $record) {
        $matchedUser = $users->first(function($u) use ($record) {
            return strtolower(trim($u->name)) === strtolower(trim($record->nama_petugas));
        });
        
        if ($matchedUser) {
            $record->user_id = $matchedUser->id;
            $record->save();
            $syncCount++;
        }
    }
    echo "Successfully synced $syncCount piket records.\n";

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
}
