<?php

namespace App\Models\Governance;
use Illuminate\Database\Eloquent\Model;

class LogReplicationAutomatedJobLogStatus extends Model
{
    protected $guarded          = [];    
    protected $connection       = 'mysql_governance_frontend';
    protected $table            = 'log_replication_automated_job_log_status';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_governance_frontend","ibox_constant_database_names").".log_replication_automated_job_log_status";
    }
}
