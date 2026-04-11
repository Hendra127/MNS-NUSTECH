<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = User::updateOrCreate(
    ['email' => 'user@nustech.co.id'],
    [
        'name' => 'User Manual',
        'password' => Hash::make('password'),
        'role' => 'user'
    ]
);

echo "User created/updated: " . $user->email . "\n";
