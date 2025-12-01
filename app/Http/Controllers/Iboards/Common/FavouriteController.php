<?php

namespace App\Http\Controllers\Iboards\Common;

use App\Models\Common\IboxUserFavouriteDashboard;
use App\Models\Iboards\Camis\Data\CamisIboxPatientInformationDetails;
use Sentinel;
use App\Http\Controllers\Controller;
use App\Models\Common\IboxDashboards;
use App\Models\Common\IboxUserDtocMenu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{


    public function Index()
    {

        return view('Home.Favourites');
    }


    public function MenuDataAutoLoad(Request $request){
        if(session()->get('AD_LOGIN') != 1){
            Toastr::warning('Insufficient Permission');
            return redirect()->route('home');
        }
        $all_dashboards = IboxDashboards::where('status', 1)->whereNotIn('dashboard_routes', ['ed.home'])->orderBy('dashboard_type', 'asc')->orderBy('dashboard_name', 'asc')->get();
        $list_dashboard = [];
        foreach($all_dashboards as $list){
            $list_dashboard[$list['dashboard_type']][] = ['id' => $list['id'], 'name' => $list['dashboard_name']];
        }
        $dtoc_menu = ArrayFilter($all_dashboards->toArray(), function($item){

            if(stripos($item['dashboard_type'], 'discharge') !== false){
                return true;
            } else {
                return false;
            }
        });
        usort($dtoc_menu, function ($a, $b) {
            return $a['id'] <=> $b['id'];
        });
        $user_id = Session()->get('LOGGED_USER_ID', '');

        if($request->tab == 'regular'){
            $user_favourites = IboxUserFavouriteDashboard::with('Menus')->where('user_id', $user_id)->orderBy('position', 'asc')->get()->toArray();
        } else {
            $user_favourites = IboxUserDtocMenu::with('Menus')->where('user_id', $user_id)->orderBy('position', 'asc')->get()->toArray();
        }
        $tab = $request->tab;
        $view                                                           = View::make('Home.FavouriteDataLoad', compact('user_favourites', 'list_dashboard', 'dtoc_menu','tab'));
        $sections                                                       = $view->render();
        return $sections;
    }
    public function SaveUserFavourites(Request $request){
        $user_id = Session()->get('LOGGED_USER_ID', '');
        $favourites = $request->input('favourites');

        if($request->tab == 'regular'){
                IboxUserFavouriteDashboard::where('user_id', $user_id)->delete();

                if($request->filled('favourites') && is_array($favourites)){
                    foreach ($favourites as $item) {
                        $menu_id = $item['id'];
                        $position = $item['position'];
                        IboxUserFavouriteDashboard::updateOrCreate(['user_id' => $user_id, 'menu_id' => $menu_id], ['position' => $position]);
                    }
                }

        } elseif($request->tab == 'dtoc') {
                IboxUserDtocMenu::where('user_id', $user_id)->delete();

                if($request->filled('favourites') && is_array($favourites)){
                    foreach ($favourites as $item) {
                        $menu_id = $item['id'];
                        $position = $item['position'];
                        IboxUserDtocMenu::updateOrCreate(['user_id' => $user_id, 'menu_id' => $menu_id], ['position' => $position]);

                    }
                } else {
                    IboxUserDtocMenu::updateOrCreate(['user_id' => $user_id, 'menu_id' => 0], ['position' => 0]);
                }
        }
        $pc_view = View::make('Layouts.Common.Sidebar.FavouritesSidebar');
        $mobile_view = View::make('Layouts.Common.Sidebar.FavouritesSidebarMobile');
        $success_array['desktop'] = $pc_view->render();
        $success_array['mobile'] = $mobile_view->render();
        return ReturnArrayAsJsonToScript($success_array);
    }


}
