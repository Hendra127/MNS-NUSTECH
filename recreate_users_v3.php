<?php

use App\Models\User;
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
    
    // Delete existing users
    User::query()->delete();
    echo "Existing users deleted.\n";

    // Create staff users
    foreach($staff as $u) {
        User::create([
            'name' => $u['name'],
            'email' => $u['email'],
            'password' => Hash::make('Masuk123*#'),
            'role' => $u['role'],
            'is_admin' => ($u['role'] === 'superadmin' ? 1 : 0)
        ]);
        echo "Created staff: " . $u['name'] . " (" . $u['role'] . ")\n";
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

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
}
