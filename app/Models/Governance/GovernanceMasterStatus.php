<?php

namespace App\Models\Governance;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Database\Eloquent\Model;

class GovernanceMasterStatus extends Model
{
    protected $guarded          = [];    
    protected $connection       = 'mysql_governance_master';
    protected $table            = 'governance_master_status';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_governance_master","ibox_constant_database_names").".governance_master_status";
    }
}
