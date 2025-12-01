<?php

namespace App\Models\Iboards\Camis\Master;

use Illuminate\Database\Eloquent\Model;

class DischargeTrackerDropdown extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_master';
    protected $table        = 'master_discharge_tracker_discharge_drop_down';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_master", "ibox_constant_database_names") . ".master_discharge_tracker_discharge_drop_down";
    }

    public static function ReturnConnectionTableName()
    {
        return 'mysql_camis_master.master_discharge_tracker_discharge_drop_down';
    }

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }
}

