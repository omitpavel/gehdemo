<?php

namespace App\Models\Iboards\Camis\Data;

use App\Models\Iboards\Camis\Master\BedDetails;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxSdecPatientInformation;
class CamisIboxDischargeLoungePosition extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_patient_discharge_lounge_postion';

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function PatientInformation()
    {
        return $this->belongsTo(CamisIboxWardPatientInformationWithBedDetailsView::class, 'camis_patient_id', 'camis_patient_id');
    }

    public function DischargeLoungePosition()
    {
        return $this->hasOne(BedDetails::class, 'id', 'dischagre_lounge_bed_id');
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
