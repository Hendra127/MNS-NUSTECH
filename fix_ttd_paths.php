<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$cols = ['ttd_pemohon','ttd_manager','ttd_accounting','ttd_direktur','ttd_penasihat'];
$total = 0;
foreach ($cols as $col) {
    $n = DB::table('csr_pengajuans')
        ->where($col, 'like', '%.jpeg%')
        ->update([$col => DB::raw("REPLACE($col, '.jpeg', '.png')")]);
    if ($n) echo "Updated $n rows for $col\n";
    $total += $n;
}
echo $total ? "\nDone! Total $total rows updated.\n" : "Nothing to update (already .png or empty).\n";
