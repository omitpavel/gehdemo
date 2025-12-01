<?php

namespace App\Models\Iboards\Camis\Data;

use App\Models\Iboards\Camis\Master\MissedDischargedReason;
use App\Models\Iboards\Camis\Master\Wards;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CamisIboxBoardRoundMissedPotentialDefinite extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_board_round_missed_pd_discharges';

    protected $with = ['MissedReason'];

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }
    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".ibox_board_round_missed_pd_discharges";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
    }
    public function Ward()
    {
        return $this->belongsTo(Wards::class, 'ward_id', 'id');
    }
    public function PatientInformation()
    {
        return $this->belongsTo(CamisIboxPatientInformationDetails::class, 'patient_id', 'camis_patient_id');
    }

    public function PatientInformationWithBedDetails()
    {
        return $this->belongsTo(CamisIboxWardPatientInformationWithBedDetailsView::class, 'patient_id', 'camis_patient_id');
    }

    public function SocialHistory()
    {
        return $this->hasOne(CamisIboxBoardRoundSocialHistory::class, 'patient_id', 'patient_id');

    }

    public function AdmittingReason()
    {
        return $this->hasOne(CamisIboxBoardRoundAdmittingReason::class, 'patient_id', 'patient_id');

    }

    public function BoardRoundMedicallyFitData()
    {
        return $this->hasOne(CamisIboxBoardRoundMedFit::class, 'patient_id', 'patient_id');

    }

    public function BoardRoundEstimatedDischargeDate()
    {
        return $this->hasOne(CamisIboxBoardRoundEstimatedDischargeDate::class, 'patient_id', 'patient_id');

    }

    public function PatientFlag()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientFlag::class, 'patient_id', 'patient_id')->where('patient_flag_status_value', 1);

    }

    public function MissedReason(): BelongsTo
    {
        return $this->belongsTo(
            MissedDischargedReason::class,
            'missed_reason',
            'id'
        )->select(['id', 'reason_type', 'reason_text', 'status']);
    }

    public function getMissedReasonTextAttribute(): ?string
    {
        return $this->MissedReason?->full_reason;
    }
}
