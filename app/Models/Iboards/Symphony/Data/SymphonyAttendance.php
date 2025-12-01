<?php

namespace App\Models\Iboards\Symphony\Data;

use Illuminate\Database\Eloquent\Model;

class SymphonyAttendance extends Model
{
    protected $guarded      = [];    
    protected $connection   = 'mysql_symphony_etl_data';
    protected $table        = 'symphony_attendance';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_etl_data","ibox_constant_database_names").".symphony_attendance";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_etl_data","ibox_constant_database_names");
    }
}
