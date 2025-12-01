<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class HistoryCamisDischargeDataAssigned extends Model
{
    protected $guarded          = [];
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_camis_discharge_tracker_discharge_patients_assigned';
    public $timestamps          = false;

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_data_history","ibox_constant_database_names").".history_camis_discharge_tracker_discharge_patients_assigned";
    }
}

