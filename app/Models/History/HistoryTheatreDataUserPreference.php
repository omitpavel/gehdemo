<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class HistoryTheatreDataUserPreference extends Model
{
    protected $guarded          = [];
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_ibox_theatre_list_user_preference';
    public $timestamps          = false;

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_data_history","ibox_constant_database_names").".history_ibox_theatre_list_user_preference";
    }
}

