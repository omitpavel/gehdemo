<?php

namespace App\Models\Governance;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Database\Eloquent\Model;

class GovernanceUserAdminLogs extends Model
{
    protected $connection       = 'mysql_governance_admin';
    protected $table            = 'governance_admin_user_operation_logs';
}
