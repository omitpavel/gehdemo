<?php

namespace App\Models\Iboards\Symphony\Data;

use Illuminate\Database\Eloquent\Model;

class AmbulanceArrivalOverMinutes extends Model
{
    protected $guarded      = [];    
    protected $connection   = 'mysql_symphony_data';
    protected $table        = 'ane_ambulance_count_30min_60min';
   
    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names").".ane_ambulance_count_30min_60min";
    }

}
