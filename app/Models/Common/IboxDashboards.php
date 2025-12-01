<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class IboxDashboards extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_settings';
    protected $table        = 'ibox_dashboard_lists';
    protected $casts = [
        'dashboard_required_permission' => 'array',
    ];


    public function getDashboardRequiredPermissionAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) : $value;
    }
    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_settings","ibox_constant_database_names").".ibox_dashboard_lists";
    }
}
