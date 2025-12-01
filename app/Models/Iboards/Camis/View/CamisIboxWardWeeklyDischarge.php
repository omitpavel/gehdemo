<?php

namespace App\Models\Iboards\Camis\View;

use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundCDT;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMedFit;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPathwayRequirement;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundTherapyFit;
use Illuminate\Database\Eloquent\Model;


class CamisIboxWardWeeklyDischarge extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'v_ibox_weekly_ward_disch_patients';


    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names") . ".v_ibox_weekly_ward_disch_patients";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data", "ibox_constant_database_names");
    }

    public function BoardRoundMedicallyFitData()
    {
        return $this->hasOne(CamisIboxBoardRoundMedFit::class, 'patient_id', 'camis_patient_id');
    }
    public function BoardRoundTherapyFitData()
    {
        return $this->hasOne(CamisIboxBoardRoundTherapyFit::class, 'patient_id', 'camis_patient_id');
    }
    public function BoardRoundPathwayRequirement()
    {
        return $this->hasOne(CamisIboxBoardRoundPathwayRequirement::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundCdt(){
        return $this->hasOne(CamisIboxBoardRoundCDT::class,'patient_id','camis_patient_id');
    }
}
