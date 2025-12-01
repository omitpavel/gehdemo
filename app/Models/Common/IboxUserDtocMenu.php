<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class IboxUserDtocMenu extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_settings';
    protected $table        = 'ibox_user_dtoc_menus';

    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_settings","ibox_constant_database_names").".ibox_user_dtoc_menus";
    }

    public function Menus(){
        return $this->hasOne(IboxDashboards::class,'id','menu_id');
    }
}
