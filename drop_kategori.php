<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('cm_pengajuans', function (Blueprint $table) {
    if (Schema::hasColumn('cm_pengajuans', 'kategori')) {
        $table->dropColumn('kategori');
    }
});

Schema::table('csr_pengajuans', function (Blueprint $table) {
    if (Schema::hasColumn('csr_pengajuans', 'kategori')) {
        $table->dropColumn('kategori');
    }
});

Schema::table('pengajuan_spareparts', function (Blueprint $table) {
    if (Schema::hasColumn('pengajuan_spareparts', 'kategori')) {
        $table->dropColumn('kategori');
    }
});
echo "Done\n";
