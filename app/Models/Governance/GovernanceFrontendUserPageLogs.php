<?php

namespace App\Models\Governance;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Database\Eloquent\Model;

class GovernanceFrontendUserPageLogs extends Model
{
    protected $guarded          = [];    
    protected $connection       = 'mysql_governance_frontend';
    protected $table            = 'governance_frontend_user_page_logs';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_governance_frontend","ibox_constant_database_names").".governance_frontend_user_page_logs";
    }
}
