<?php

namespace App\Models\Governance;
use Illuminate\Database\Eloquent\Model;

class GovernanceFrontendCamisOperationLogsExtraDetails extends Model
{
    protected $guarded          = [];    
    protected $connection       = 'mysql_governance_frontend';
    protected $table            = 'governance_frontend_camis_operation_logs_extra_details';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_governance_frontend","ibox_constant_database_names").".governance_frontend_camis_operation_logs_extra_details";
    }
}
