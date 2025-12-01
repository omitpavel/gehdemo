<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryCamisIboxBoardCareRequirement extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_data_history';
    protected $table        = 'history_camis_ibox_board_round_care_requirements';
    public $timestamps      = false;

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }
}
