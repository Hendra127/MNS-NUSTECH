<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
Auth::loginUsingId(1);

$items = Sparetracker::whereNotNull('foto')->where('foto','!=','')->take(3)->get(['sn','foto']);
echo json_encode($items->toArray());
