<?php

namespace App\Models\Iboards\Symphony\View;

use Illuminate\Database\Eloquent\Model;

class SymphonyEDLocationWaitsSiteOverview extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_symphony_data';
    protected $table        = 'v_ed_location_waits_site_overview';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names").".v_ed_location_waits_site_overview";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_symphony_data","ibox_constant_database_names");
    }
}
