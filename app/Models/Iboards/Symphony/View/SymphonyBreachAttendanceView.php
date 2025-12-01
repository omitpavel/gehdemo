<?php

namespace App\Models\Iboards\Symphony\View;

use Illuminate\Database\Eloquent\Model;

class SymphonyBreachAttendanceView extends Model
{
    protected $guarded      = [];    
    protected $connection   = 'mysql_symphony_etl_data';
    protected $table        = 'v_symphony_attendance_one_year_breach_data';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_etl_data","ibox_constant_database_names").".v_symphony_attendance_one_year_breach_data";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_etl_data","ibox_constant_database_names");
    }
}
