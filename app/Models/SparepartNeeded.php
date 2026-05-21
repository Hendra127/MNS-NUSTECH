<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparepartNeeded extends Model
{
    protected $guarded = [];

    // Approval flow stages
    const STATUS_PENDING_NOC         = 'pending_noc';
    const STATUS_PENDING             = 'pending';
    const STATUS_APPROVED_MANAGER    = 'approved_manager';
    const STATUS_APPROVED_ACCOUNTING = 'approved_accounting';
    const STATUS_APPROVED_DIREKTUR   = 'approved_direktur';
    const STATUS_APPROVED_PENASIHAT  = 'approved_penasihat';
    const STATUS_REJECTED            = 'rejected';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'site_id');
    }

    /**
     * Human-readable label for approval status
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->approval_status) {
            self::STATUS_PENDING_NOC         => 'Menunggu Persetujuan NOC Leader',
            self::STATUS_PENDING             => 'Menunggu Persetujuan Manager',
            self::STATUS_APPROVED_MANAGER    => 'Disetujui Manager – Menunggu Accounting',
            self::STATUS_APPROVED_ACCOUNTING => 'Disetujui Accounting – Menunggu Direktur',
            self::STATUS_APPROVED_DIREKTUR   => 'Disetujui Direktur – Menunggu Penasihat',
            self::STATUS_APPROVED_PENASIHAT  => 'Selesai – Disetujui Penasihat',
            self::STATUS_REJECTED            => 'Ditolak',
            default                          => $this->approval_status ?? 'Pending NOC',
        };
    }

    /**
     * Badge color class for approval status
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->approval_status) {
            self::STATUS_PENDING_NOC         => 'warning',
            self::STATUS_PENDING             => 'warning',
            self::STATUS_APPROVED_MANAGER    => 'info',
            self::STATUS_APPROVED_ACCOUNTING => 'primary',
            self::STATUS_APPROVED_DIREKTUR   => 'secondary',
            self::STATUS_APPROVED_PENASIHAT  => 'success',
            self::STATUS_REJECTED            => 'danger',
            default                          => 'secondary',
        };
    }

    /**
     * Step number (1–6) for progress indicator
     */
    public function getStepAttribute(): int
    {
        return match ($this->approval_status) {
            self::STATUS_PENDING_NOC         => 1,
            self::STATUS_PENDING             => 2,
            self::STATUS_APPROVED_MANAGER    => 3,
            self::STATUS_APPROVED_ACCOUNTING => 4,
            self::STATUS_APPROVED_DIREKTUR   => 5,
            self::STATUS_APPROVED_PENASIHAT  => 6,
            default                          => 0,
        };
    }
}
