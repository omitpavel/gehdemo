<?php

namespace App\Models\Iboards\Camis\Data;

use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
class CamisIboxBoardRoundScubWard extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_board_round_scub_ward';
    protected $primaryKey = 'bed_id';
    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function ReverseBarrier()
    {
        return $this->hasOne(CamisIboxBoardRoundReverseBarrier::class,'patient_id','camis_patient_id');
    }

    public function PatientWiseFlags()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientFlag::class,'patient_id','camis_patient_id');
    }

    public function BoardRoundIpcComment()
    {
        return $this->hasOne(CamisIboxBoardRoundIpcComment::class, 'patient_id', 'camis_patient_id');
    }
    public function InfectionRisks()
    {
        return $this->hasMany(CamisIboxBoardRoundInfectionRisk::class, 'patient_id', 'camis_patient_id');
    }

    public function PrimaryInfectionRisk()
    {
        return $this->hasOne(CamisIboxBoardRoundInfectionRisk::class, 'patient_id', 'camis_patient_id')->where('is_primary', 1);
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".ibox_board_round_scub_ward";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
    }
}
