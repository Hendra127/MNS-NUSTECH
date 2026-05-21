<?php
// Script untuk membuat users CSR workflow
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Users yang ada sekarang ===\n";
foreach (User::all(['id','name','email','role']) as $u) {
    echo "{$u->id} | {$u->name} | {$u->email} | {$u->role}\n";
}

// Define CSR workflow users
$csrUsers = [
    [
        'name'     => 'Dimas Farid Awaludin, S.Kom',
        'email'    => 'manager@nustech.co.id',
        'role'     => 'manager',
        'password' => 'manager123',
    ],
    [
        'name'     => 'Baiq Nana Erlina, A.Md',
        'email'    => 'accounting@nustech.co.id',
        'role'     => 'accounting',
        'password' => 'accounting123',
    ],
    [
        'name'     => 'Galuh Zakiyatun, S.Kom',
        'email'    => 'direktur@nustech.co.id',
        'role'     => 'direktur',
        'password' => 'direktur123',
    ],
    [
        'name'     => 'Raden Yuniarta Alba, S.Kom',
        'email'    => 'penasihat@nustech.co.id',
        'role'     => 'penasihat',
        'password' => 'penasihat123',
    ],
];

echo "\n=== Membuat / memperbarui users CSR workflow ===\n";
foreach ($csrUsers as $userData) {
    $existing = User::where('email', $userData['email'])->first();
    if ($existing) {
        $existing->update([
            'name'     => $userData['name'],
            'role'     => $userData['role'],
            'password' => Hash::make($userData['password']),
        ]);
        echo "UPDATED: {$userData['name']} ({$userData['email']}) -> role: {$userData['role']}\n";
    } else {
        User::create([
            'name'     => $userData['name'],
            'email'    => $userData['email'],
            'role'     => $userData['role'],
            'password' => Hash::make($userData['password']),
            'is_admin' => 0,
        ]);
        echo "CREATED: {$userData['name']} ({$userData['email']}) -> role: {$userData['role']}\n";
    }
}

echo "\n=== Semua users setelah update ===\n";
foreach (User::all(['id','name','email','role']) as $u) {
    echo "{$u->id} | {$u->name} | {$u->email} | {$u->role}\n";
}

echo "\nSelesai!\n";
