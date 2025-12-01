<?php

namespace App\Models\Iboards\Camis\Data;

use App\Models\Iboards\Camis\Master\BedDetails;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxSdecPatientInformation;
class CamisIboxFrailtyPosition extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_patient_frailty_postion';

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function PatientInformation()
    {
        return $this->belongsTo(CamisIboxSdecPatientInformation::class, 'camis_patient_id', 'camis_patient_id');
    }

    public function FrailtyPosition()
    {
        return $this->hasOne(BedDetails::class, 'id', 'frailty_bed_id');
    }



    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".ibox_board_round_cdt";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
    }
}
