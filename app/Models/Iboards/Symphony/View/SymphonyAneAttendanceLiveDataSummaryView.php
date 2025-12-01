<?php

namespace App\Models\Iboards\Symphony\View;

use Illuminate\Database\Eloquent\Model;

class SymphonyAneAttendanceLiveDataSummaryView extends Model
{
    protected $guarded      = [];    
    protected $connection   = 'mysql_symphony_etl_data';
    protected $table        = 'v_ane_attendance_live_data_summary';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_etl_data","ibox_constant_database_names").".v_ane_attendance_live_data_summary";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_etl_data","ibox_constant_database_names");
    }
}
