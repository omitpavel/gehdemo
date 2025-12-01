<?php

namespace App\Models\Iboards\Camis\Data;

use App\Models\Iboards\Camis\View\CamisIboxPatientInfoVitalpacView;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
class CamisIboxDPVirtualWardPatientStatus extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_board_round_dp_virtual_ward_pat_status';

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function PatientInformationWithBedDetails()
    {
        return $this->belongsTo(CamisIboxWardPatientInformationWithBedDetailsView::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundMedicallyFitData()
    {
        return $this->hasOne(CamisIboxBoardRoundMedFit::class, 'patient_id', 'patient_id');

    }

    public function PatientHasFlag()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientFlag::class,'patient_id');
    }


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".ibox_board_round_acuity";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
    }
    public function DpVirtualWardPatientComment()
    {
        return $this->hasMany(CamisIboxDPVirtualWardComment::class, 'patient_id','patient_id');
    }
    public function BoardRoundPatientTasks()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientTasks::class, 'patient_id', 'patient_id');
    }

    public function PatientVitalPacInfo()
    {
        return $this->belongsTo(CamisIboxPatientInfoVitalpacView::class, 'patient_id','camis_patient_id')
            ->select(['camis_patient_id','totalews', 'Herat_Rate_val','Temperature_val','Respiratory_Rate_val','BP_Systolic_val','Oxygen_val','AVPU_val','SATS_val','time_started_obs']);
    }
}
