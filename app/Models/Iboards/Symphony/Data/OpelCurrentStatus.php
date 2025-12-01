<?php

namespace App\Models\Iboards\Symphony\Data;

use Illuminate\Database\Eloquent\Model;

class OpelCurrentStatus extends Model
{
    protected $guarded      = [];    
    protected $connection   = 'mysql_symphony_data';
    protected $table        = 'ane_opel_status';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names").".ane_opel_status";
    }
}
