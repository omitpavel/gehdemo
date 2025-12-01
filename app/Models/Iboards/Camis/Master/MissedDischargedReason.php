<?php

namespace App\Models\Iboards\Camis\Master;

use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMissedPotentialDefinite;
use Illuminate\Database\Eloquent\Model;

class MissedDischargedReason extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_missed_discharge_reason';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_master","ibox_constant_database_names").".master_missed_discharge_reason";
    }

    public static function ReturnConnectionTableName()
    {
        return 'mysql_camis_master.master_missed_discharge_reason';
    }

    public function getFullReasonAttribute(): string
    {
        return trim(($this->reason_type ?? '') . ' - ' . ($this->reason_text ?? ''), " -");
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('reason_type')->orderBy('reason_text');
    }

    public static function optionsForSelect(): array
    {
        return static::query()
            ->active()
            ->ordered()
            ->get(['id', 'reason_type', 'reason_text'])
            ->mapWithKeys(fn ($r) => [$r->id => $r->full_reason])
            ->toArray();
    }

    public function camisIboxBoardRoundMissedPotentialDefinites()
    {
        return $this->hasMany(
            CamisIboxBoardRoundMissedPotentialDefinite::class,
            'missed_reason',
            'id'
        );
    }
}
