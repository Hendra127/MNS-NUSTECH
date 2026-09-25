<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tracker = \App\Models\Sparetracker::where('sn', 'MIK6A99C07AACF2E')->first();
if ($tracker) {
    echo "SN: " . $tracker->sn . "\n";
    echo "FOTO: " . ($tracker->foto ? $tracker->foto : "NULL or EMPTY") . "\n";
} else {
    echo "SN not found in DB\n";
}
