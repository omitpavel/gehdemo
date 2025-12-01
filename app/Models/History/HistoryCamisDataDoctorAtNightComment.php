<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class HistoryCamisDataDoctorAtNightComment extends Model
{
    protected $guarded          = [];
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_virtual_ward_doctor_at_night_comments';
    public $timestamps          = false;

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_data_history","ibox_constant_database_names").".history_camis_master_ward_details";
    }
}

