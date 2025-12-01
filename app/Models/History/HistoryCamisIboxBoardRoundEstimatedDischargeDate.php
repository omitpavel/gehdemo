<?php

namespace App\Models\History;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Database\Eloquent\Model;

class HistoryCamisIboxBoardRoundEstimatedDischargeDate extends Model
{
    protected $guarded          = [];    
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_camis_ibox_board_round_estimated_discharge_date';
    public $timestamps          = false;

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_data_history","ibox_constant_database_names").".history_camis_ibox_board_round_estimated_discharge_date";
    }
}
