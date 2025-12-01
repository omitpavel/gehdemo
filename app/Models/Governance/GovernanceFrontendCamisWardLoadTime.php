<?php

namespace App\Models\Governance;
use Illuminate\Database\Eloquent\Model;

class GovernanceFrontendCamisWardLoadTime extends Model
{
    protected $guarded          = [];
    protected $connection       = 'mysql_governance_frontend';
    protected $table            = 'governance_frontend_camis_logs_ward_load_time_track';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_governance_frontend","ibox_constant_database_names").".governance_frontend_camis_logs_ward_load_time_track";
    }
}
