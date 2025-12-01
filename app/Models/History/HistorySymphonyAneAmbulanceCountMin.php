<?php

namespace App\Models\History;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Database\Eloquent\Model;

class HistorySymphonyAneAmbulanceCountMin extends Model
{
    protected $guarded          = [];    
    protected $connection       = 'mysql_data_history';
    protected $table            = 'history_symphony_ane_ambulance_count_30min_60min';
    public $timestamps          = false;

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_data_history","ibox_constant_database_names").".history_symphony_ane_ambulance_count_30min_60min";
    }
}
