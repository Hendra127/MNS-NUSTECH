<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmPengajuan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_clear' => 'boolean',
    ];

    private const TTD_PATHS = [
        'pemohon'    => 'assets/img/ttd/pemohon.png',
        'manager'    => 'assets/img/ttd/manager.png',
        'accounting' => 'assets/img/ttd/accounting.png',
        'direktur'   => 'assets/img/ttd/direktur.png',
        'penasihat'  => 'assets/img/ttd/penasihat.png',
    ];

    // Status Constants
    public const STATUS_PENDING_NOC         = 'pending_noc';
    public const STATUS_PENDING             = 'pending';
    public const STATUS_APPROVED_MANAGER    = 'approved_manager';
    public const STATUS_APPROVED_ACCOUNTING = 'approved_accounting';
    public const STATUS_APPROVED_DIREKTUR   = 'approved_direktur';
    public const STATUS_APPROVED_PENASIHAT  = 'approved_penasihat';
    public const STATUS_REJECTED            = 'rejected';

    /**
     * Relationship to the user who created the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
            default                          => $this->approval_status,
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
     * Next approver role given current status
     */
    public function getNextApproverAttribute(): ?string
    {
        return match ($this->approval_status) {
            self::STATUS_PENDING_NOC         => 'noc_leader',
            self::STATUS_PENDING             => 'manager',
            self::STATUS_APPROVED_MANAGER    => 'accounting',
            self::STATUS_APPROVED_ACCOUNTING => 'direktur',
            self::STATUS_APPROVED_DIREKTUR   => 'penasihat',
            default                          => null,
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

    public function getTtdPemohonAttribute(?string $value): ?string
    {
        return $value ?: self::TTD_PATHS['pemohon'];
    }

    public function getTtdManagerAttribute(?string $value): ?string
    {
        if ($value) {
            return $value;
        }

        return in_array($this->approval_status, [
            self::STATUS_APPROVED_MANAGER,
            self::STATUS_APPROVED_ACCOUNTING,
            self::STATUS_APPROVED_DIREKTUR,
            self::STATUS_APPROVED_PENASIHAT,
        ]) ? self::TTD_PATHS['manager'] : null;
    }

    public function getTtdAccountingAttribute(?string $value): ?string
    {
        if ($value) {
            return $value;
        }

        return in_array($this->approval_status, [
            self::STATUS_APPROVED_ACCOUNTING,
            self::STATUS_APPROVED_DIREKTUR,
            self::STATUS_APPROVED_PENASIHAT,
        ]) ? self::TTD_PATHS['accounting'] : null;
    }

    public function getTtdDirekturAttribute(?string $value): ?string
    {
        if ($value) {
            return $value;
        }

        return in_array($this->approval_status, [
            self::STATUS_APPROVED_DIREKTUR,
            self::STATUS_APPROVED_PENASIHAT,
        ]) ? self::TTD_PATHS['direktur'] : null;
    }

    public function getTtdPenasihatAttribute(?string $value): ?string
    {
        if ($value) {
            return $value;
        }

        return $this->approval_status === self::STATUS_APPROVED_PENASIHAT ? self::TTD_PATHS['penasihat'] : null;
    }
}
