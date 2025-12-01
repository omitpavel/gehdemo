<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class HistoryCamisIboxBoardRoundDischargeLoungeHandover extends Model
{
    protected $guarded          = [];
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_camis_ibox_board_round_discharge_lounge_handover';
    public $timestamps          = false;

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_data_history","ibox_constant_database_names").".history_camis_ibox_board_round_discharge_lounge_handover";
    }
}

