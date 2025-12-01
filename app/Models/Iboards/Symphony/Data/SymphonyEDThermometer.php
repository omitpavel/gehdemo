<?php

namespace App\Models\Iboards\Symphony\Data;

use Illuminate\Database\Eloquent\Model;

class SymphonyEDThermometer extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_symphony_data';
    protected $table        = 'ane_ed_thermometer';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names").".ane_ed_thermometer";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names");
    }
}
