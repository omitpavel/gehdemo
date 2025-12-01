<?php

namespace App\Models\Iboards\Camis\Data;

use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;

class CamisIboxBoardRoundPotentialDefinite extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_board_round_potential_definite_discharges';



    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }
    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".ibox_board_round_potential_definite_discharges";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
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
}
