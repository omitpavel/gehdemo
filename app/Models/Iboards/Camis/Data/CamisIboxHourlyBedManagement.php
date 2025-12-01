<?php

namespace App\Models\Iboards\Camis\Data;

use App\Models\Iboards\Camis\Master\BedDetails;
use App\Models\Iboards\Camis\Master\Wards;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\View\CamisIboxSdecPatientInformation;
class CamisIboxHourlyBedManagement extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_bed_management_hourly_data';

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function ward()
    {
        return $this->belongsTo(Wards::class, 'ward_id', 'id');
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
