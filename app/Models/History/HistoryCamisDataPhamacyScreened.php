<?php

namespace App\Models\History;

use App\Models\Iboards\Camis\Master\Wards;
use Illuminate\Database\Eloquent\Model;

class HistoryCamisDataPhamacyScreened extends Model
{
    protected $guarded          = [];
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_camis_ibox_board_round_pharmacist_screened';
    public $timestamps          = false;

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function Ward()
    {
        return $this->belongsTo(Wards::class,'ward_id','id');
    }

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_data_history","ibox_constant_database_names").".history_camis_ibox_board_round_pharmacist_screened";
    }
}

