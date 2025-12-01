<?php

namespace App\Models\Governance;
use Illuminate\Database\Eloquent\Model;

class GovernanceFrontendIboxTempUserDetails extends Model
{
    protected $guarded          = [];    
    protected $connection       = 'mysql_governance_frontend';
    protected $table            = 'governance_frontend_temporary_storage_user_details';
    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_governance_frontend","ibox_constant_database_names").".governance_frontend_temporary_storage_user_details";
    }
}
