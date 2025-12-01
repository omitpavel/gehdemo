<?php
namespace App\Services;
use App\Models\Common\Roles;

class RolesService{

    static $defaultRoles = ['guest'];

    public static function get(){
        $roles = Roles::where('admin_permission','=', 1)->get();
        $result = array();
        foreach($roles as $role){
            array_push($result, $role->name);
        }
        //return array_merge(self::$defaultRoles, $result);
        return $result;
    }

}
