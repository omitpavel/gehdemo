<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;
use Closure;
use Config;
class CheckForMaintenanceMode extends Middleware
{
    protected $except = [];

    public function handle($request, Closure $next)
    {
        $url                    =   $request->url();
        $offline_mode           =   RetriveSpecificConstantSettingValues('ibox_offline_mode',"ibox_constant_default_setting_values");
        if($offline_mode == 1 AND ($request->path() !== "under-construction") AND strpos($url, 'localhost') === FALSE)
        {
            return redirect('/under-construction');
        }
        return $next($request);
    }
}
