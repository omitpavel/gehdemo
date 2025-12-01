<?php

namespace App\Http\Middleware;

use App\Models\Common\ActiveUsers;
use App\Models\Common\Roles;
use Closure;
use Illuminate\Support\Facades\Session;
use Sentinel;
use DB;
use App\Http\Controllers\Controller;


class SentinelMiddleware extends Controller
{
    public function handle($request, Closure $next)
    {

        $requestedPath      = $request->getPathInfo();
        if ($user = Sentinel::check())
        {
            return $next($request);
            $visit_status_admin     =   0;
            $sessionid = Session::getId();
            ActiveUsers::where('user_id', $user->id)->where('session_id', $sessionid)->update(array('last_activity_time' => DB::raw('NOW()')));
            $assignd_roles = Sentinel::findById($user->id)->roles()->get();
            $assigned = array();
            if (!empty($assignd_roles))
            {
                foreach ($assignd_roles as $val)
                {
                    $assigned[] = $val->name;
                }
            }
            $perm_roles                 = Roles::where('admin_permission', '=', 1)->get();
            $assigned_permission        = array();
            if (!empty($perm_roles))
            {
                foreach ($perm_roles as $val)
                {
                    if (in_array($val->name, $assigned))
                    {
                        $visit_status_admin = 1;
                        break;
                    }
                }
            }
            $requestedPath              = $request->getPathInfo();
            if (!empty($assigned))
            {
                if (count($assigned) == 1 && $requestedPath != '/ane/dashboards/ed-home' && $requestedPath != '/ane/dashboards/ed-home/content-data-load')
                {
                    foreach ($assigned as $val)
                    {
                        if ($val == 'ED Welcome')
                        {
                            return redirect('/ane/dashboards/ed-home');
                        }
                    }
                }
            }
            if ($visit_status_admin == 1)
            {
                return $next($request);
            }
            else
            {
                return redirect('/');
            }
        }
        else
        {
            return redirect('/');
        }
    }
}
