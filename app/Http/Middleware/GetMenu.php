<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Menus\GetSidebarMenu;
use App\Models\Common\Menulist;
use App\Models\Common\Menus;
use App\Models\Common\RoleHierarchy;
use App\Models\Common\Roles;
use Sentinel;
use DB;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($user = Sentinel::check())
        {
            $role                       = 'guest';
            $userRoles                  = Sentinel::findById($user->id)->roles()->get();
            $roleHierarchy              = RoleHierarchy::with('RoleHierarchyMany')->orderBy('hierarchy', 'asc')->get();



            $flag                       = false;
            foreach($roleHierarchy as $roleHier)
            {
                if(isset($roleHier->RoleHierarchyMany->name))
                {
                    foreach($userRoles as $userRole)
                    {
                        if($userRole->name == $roleHier->RoleHierarchyMany->name)
                        {
                            $role           = $userRole->name;
                            $flag           = true;
                            break;
                        }
                    }
                    if($flag === true)
                    {
                        break;
                    }
                }
            }
        }
        else
        {
            $role = 'guest';
        }
        //session(['prime_user_role' => $role]);
        
        $uri = $request->getRequestUri();
        $uri = str_replace("/admin", "",$uri);
        $uri = rtrim($uri, '/');
        $uri = ltrim($uri, '/');
        $uri = explode("/", $uri, 2);
        $menu_item = Menus::where('href','like','%'.$uri[0].'%')->first();

        $menus = new GetSidebarMenu();
        $menulists = Menulist::all();
        $result = array();
        $ids = array();
        foreach($menulists as $menulist){
            $result[ $menulist->name ] = $menus->get( $role, $menulist->id );
            if($menu_item != null && $request->getRequestUri()!='/admin')
            {
                $ids = array_merge($ids,array_column($result[ $menulist->name ], 'id'));
                foreach($result[ $menulist->name ] as $item)
                {
                    if(isset($item['elements']))
                    {
                        $ids = array_merge($ids,array_column($item['elements'], 'id'));
                    }
                }
            }
        }
        if($menu_item != null && $request->getRequestUri()!='/admin')
        {
            if(!in_array($menu_item->id,$ids))
            {
                return abort(404);
            }
        }
        view()->share('appMenus', $result );


        return $next($request);
    }
}
