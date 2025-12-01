<?php

namespace App\Providers;

use App\Models\Common\FlashMessage;
use App\Models\Common\IboxDashboards;
use App\Models\Common\IboxUserDtocMenu;
use App\Models\Common\IboxUserFavouriteDashboard;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        View::composer('Layouts.Common.MasterLayoutHeader', function ($view) {
            $flash_notice = Cache::remember('flash_notice', 60, function () {
                return FlashMessage::where('status', 1)
                    ->whereNotNull('message')
                    ->value('message');
            });
            $view->with('flash_notice', $flash_notice);
        });


        View::composer('Layouts.Common.Sidebar.ANESidebarMain', function ($view) {
            $favourites_menu = IboxUserFavouriteDashboard::with([
                'Menus'])->where('user_id', session()->get('LOGGED_USER_ID', ''))->orderBy('position', 'asc')->first();

            $dtoc_favourites_menu = IboxUserDtocMenu::with([
                'Menus'])->where('user_id', session()->get('LOGGED_USER_ID', ''))->orderBy('position', 'asc')->first();




            $all_dashboards_list = IboxDashboards::where('status', 1)->where('dashboard_type', 'Discharge Tracker')->orderBy('dashboard_type', 'asc')->orderBy('dashboard_name', 'asc')->get();

            foreach($all_dashboards_list as $dashboard_list){
                foreach($dashboard_list->dashboard_required_permission as $perm){
                    if(CheckDashboardPermission($perm)){
                        $all_dashboards = $dashboard_list;
                    }
                }

            }
            $redirect_url = route('user.favourites');

          $dtoc_redirect_url = (($r = ($all_dashboards ?? null)?->dashboard_routes) && Route::has($r)) ? route($r) : '#';

            $dtoc_permission = $all_dashboards->dashboard_required_permission ?? [];


            if(session()->get('AD_LOGIN') != 1){
                $redirect_url = route('home');
                $dtoc_redirect_url = (($r = ($all_dashboards ?? null)?->dashboard_routes) && Route::has($r)) ? route($r) : '#';

            } else {
                if($favourites_menu != null){
                    if(isset($favourites_menu->Menus->dashboard_name) && $favourites_menu->Menus->status == 1){
                        $redirect_url = route($favourites_menu->Menus->dashboard_routes, ['favourites' => 1]);
                    }
                }

                if($dtoc_favourites_menu != null){
                    if(isset($dtoc_favourites_menu->Menus->dashboard_name) && $dtoc_favourites_menu->Menus->status == 1){
                        $dtoc_redirect_url = (($r = ($all_dashboards ?? null)?->dashboard_routes) && Route::has($r))
    ? route($r, ['dtoc_favourites' => 1])
    : '#';

                        $dtoc_permission = $dtoc_favourites_menu->Menus->dashboard_required_permission;
                    }
                } else {
                    $dtoc_redirect_url = (($r = ($all_dashboards ?? null)?->dashboard_routes) && Route::has($r)) ? route($r) : '#';
                    $dtoc_permission = $all_dashboards->dashboard_required_permission ?? [];

                }
            }
            $view->with([
                'favourites_menu'   => $favourites_menu,
                'redirect_url'      => $redirect_url,
                'dtoc_permission'   => $dtoc_permission,
                'dtoc_redirect_url' => $dtoc_redirect_url
            ]);
        });

        View::composer('Layouts.Common.Sidebar.ANESidebarMainMobile', function ($view) {
            $favourites_menu = IboxUserFavouriteDashboard::with([
                'Menus'])->where('user_id', session()->get('LOGGED_USER_ID', ''))->orderBy('position', 'asc')->first();

            $dtoc_favourites_menu = IboxUserDtocMenu::with([
                'Menus'])->where('user_id', session()->get('LOGGED_USER_ID', ''))->orderBy('position', 'asc')->first();




            $all_dashboards_list = IboxDashboards::where('status', 1)->where('dashboard_type', 'Discharge Tracker')->orderBy('dashboard_type', 'asc')->orderBy('dashboard_name', 'asc')->get();

            foreach($all_dashboards_list as $dashboard_list){
                foreach($dashboard_list->dashboard_required_permission as $perm){
                    if(CheckDashboardPermission($perm)){
                        $all_dashboards = $dashboard_list;
                    }
                }

            }
            $redirect_url = route('user.favourites');

            $dtoc_redirect_url = (($r = ($all_dashboards ?? null)?->dashboard_routes) && Route::has($r)) ? route($r) : '#';

            $dtoc_permission = $all_dashboards->dashboard_required_permission ?? [];


            if(session()->get('AD_LOGIN') != 1){
                $redirect_url = route('home');
                $dtoc_redirect_url = (($r = ($all_dashboards ?? null)?->dashboard_routes) && Route::has($r)) ? route($r) : '#';

            } else {
                if($favourites_menu != null){
                    if(isset($favourites_menu->Menus->dashboard_name) && $favourites_menu->Menus->status == 1){
                        $redirect_url = route($favourites_menu->Menus->dashboard_routes, ['favourites' => 1]);
                    }
                }

                if($dtoc_favourites_menu != null){
                    if(isset($dtoc_favourites_menu->Menus->dashboard_name) && $dtoc_favourites_menu->Menus->status == 1){
                        $dtoc_redirect_url = (($r = ($all_dashboards ?? null)?->dashboard_routes) && Route::has($r))
    ? route($r, ['dtoc_favourites' => 1])
    : '#';

                        $dtoc_permission = $dtoc_favourites_menu->Menus->dashboard_required_permission;
                    }
                } else {
                    $dtoc_redirect_url = (($r = ($all_dashboards ?? null)?->dashboard_routes) && Route::has($r)) ? route($r) : '#';

                    $dtoc_permission = $all_dashboards->dashboard_required_permission ?? [];

                }
            }
            $view->with([
                'favourites_menu'   => $favourites_menu,
                'redirect_url'      => $redirect_url,
                'dtoc_permission'   => $dtoc_permission,
                'dtoc_redirect_url' => $dtoc_redirect_url
            ]);
        });
        View::composer('Layouts.Common.Sidebar.FavouritesSidebar', function ($view) {
            $favourites_menu = IboxUserFavouriteDashboard::with(['Menus'])->orderBy('position', 'asc')->where('user_id', Session()->get('LOGGED_USER_ID', ''))->get();
            $view->with('favourites_menu', $favourites_menu);
        });

        View::composer('Layouts.Common.Sidebar.FavouritesSidebarMobile', function ($view) {
            $favourites_menu = IboxUserFavouriteDashboard::with(['Menus'])->orderBy('position', 'asc')->where('user_id', Session()->get('LOGGED_USER_ID', ''))->get();
            $view->with('favourites_menu', $favourites_menu);
        });
        View::composer('Layouts.Common.Sidebar.DischargeTrackerSidebarSubMobile', function ($view) {
            $favourites_menu = IboxUserDtocMenu::with(['Menus'])->orderBy('position', 'asc')->where('menu_id', '!=', 0)->where('user_id', Session()->get('LOGGED_USER_ID', ''))->get();
            $view->with('favourites_menu', $favourites_menu);
        });
        View::composer('Layouts.Common.Sidebar.DischargeTrackerSidebarMain', function ($view) {
            $favourites_menu = IboxUserDtocMenu::with(['Menus'])->orderBy('position', 'asc')->where('menu_id', '!=', 0)->where('user_id', Session()->get('LOGGED_USER_ID', ''))->get();
            $view->with('favourites_menu', $favourites_menu);
        });








    }
}
