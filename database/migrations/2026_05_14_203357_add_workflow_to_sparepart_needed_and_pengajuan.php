<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sparepart_neededs', function (Blueprint $table) {
            $table->string('approval_status')->default('pending_noc')->after('status');
            $table->timestamp('approved_noc_at')->nullable()->after('approval_status');
            $table->timestamp('approved_manager_at')->nullable()->after('approved_noc_at');
            $table->timestamp('approved_accounting_at')->nullable()->after('approved_manager_at');
            $table->timestamp('approved_direktur_at')->nullable()->after('approved_accounting_at');
            $table->timestamp('approved_penasihat_at')->nullable()->after('approved_direktur_at');
            $table->timestamp('rejected_at')->nullable()->after('approved_penasihat_at');
            $table->string('rejected_by')->nullable()->after('rejected_at');
            $table->text('rejection_reason')->nullable()->after('rejected_by');
            $table->unsignedBigInteger('user_id')->nullable()->after('rejection_reason');
        });

        Schema::table('pengajuan_spareparts', function (Blueprint $table) {
            $table->string('approval_status')->default('pending_noc')->after('grand_total');
            $table->timestamp('approved_noc_at')->nullable()->after('approval_status');
            $table->timestamp('approved_manager_at')->nullable()->after('approved_noc_at');
            $table->timestamp('approved_accounting_at')->nullable()->after('approved_manager_at');
            $table->timestamp('approved_direktur_at')->nullable()->after('approved_accounting_at');
            $table->timestamp('approved_penasihat_at')->nullable()->after('approved_direktur_at');
            $table->timestamp('rejected_at')->nullable()->after('approved_penasihat_at');
            $table->string('rejected_by')->nullable()->after('rejected_at');
            $table->text('rejection_reason')->nullable()->after('rejected_by');
            $table->unsignedBigInteger('user_id')->nullable()->after('rejection_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sparepart_neededs', function (Blueprint $table) {
            $table->dropColumn([
                'approval_status', 'approved_noc_at', 'approved_manager_at',
                'approved_accounting_at', 'approved_direktur_at', 'approved_penasihat_at',
                'rejected_at', 'rejected_by', 'rejection_reason', 'user_id'
            ]);
        });

        Schema::table('pengajuan_spareparts', function (Blueprint $table) {
            $table->dropColumn([
                'approval_status', 'approved_noc_at', 'approved_manager_at',
                'approved_accounting_at', 'approved_direktur_at', 'approved_penasihat_at',
                'rejected_at', 'rejected_by', 'rejection_reason', 'user_id'
            ]);
        });
    }
};
