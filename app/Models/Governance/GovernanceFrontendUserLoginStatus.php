<?php

namespace App\Models\Governance;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Database\Eloquent\Model;

class GovernanceFrontendUserLoginStatus extends Model
{
    protected $guarded          = [];   
    protected $connection       = 'mysql_governance_frontend';
    protected $table            = 'governance_frontend_user_login_status_logs';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_governance_frontend","ibox_constant_database_names").".governance_frontend_user_login_status_logs";
    }
}
