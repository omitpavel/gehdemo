<?php

namespace App\Models\History;

use App\Models\Common\User;
use App\Models\Iboards\Camis\Master\InfectionControl;
use Illuminate\Database\Eloquent\Model;

class HistoryCamisIboxBoardInfectionRisk extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_data_history';
    protected $table        = 'history_camis_ibox_board_roundin_infection_list';
    public $timestamps      = false;

    public function GetTableNameWithConnection()
    {
        $connectionName     = $this->getConnectionName();
        $tableName          = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function infection()
    {
        return $this->belongsTo(InfectionControl::class, 'infection_id');
    }


}
