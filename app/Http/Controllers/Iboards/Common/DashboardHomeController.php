<?php

namespace App\Http\Controllers\Iboards\Common;

use App\Http\Requests\Request;
use App\Models\Common\IboxUserDtocMenu;
use Sentinel;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Models\Common\IboxDashboards;
use App\Models\Common\IboxUserFavouriteDashboard;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPotentialDefinite;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Camis\Master\Wards;
use View;
use Illuminate\Support\Facades\Route;

class DashboardHomeController extends Controller
{
    public function PageDataLoad(&$process_array,&$success_array)
    {
        $common_controller                                              = new CommonController;
        $common_controller->SetDefaultConstantsValue($process_array,$success_array);

        return $success_array;
    }

    public function index()
    {

        if(!Sentinel::check()){
            return redirect()->route('login.screen');
        }







        if(Sentinel::getUser() && !is_numeric(Sentinel::getUser()->user_type)){

            return redirect()->route('ward.ward-details', Sentinel::getUser()->user_type);

        } elseif(Sentinel::getUser() && Sentinel::getUser()->user_type == 2){
            return redirect()->route('ane.livestatus');
        }

        $process_array                                                  = array();
        $success_array                                                  = array();
        $this->PageDataLoad($process_array,$success_array);
        $success_array["page_sub_title"]                = date('jS F H:i');


        $favourites_menu = IboxUserFavouriteDashboard::with([
            'Menus'])->where('user_id', session()->get('LOGGED_USER_ID', ''))->orderBy('position', 'asc')->first();

        $dtoc_favourites_menu = IboxUserDtocMenu::with([
            'Menus'])->where('user_id', session()->get('LOGGED_USER_ID', ''))->orderBy('position', 'asc')->first();



        $all_dashboards_list = IboxDashboards::where('status', 1)->where('dashboard_type', 'Discharge Tracker')->orderBy('dashboard_type', 'asc')->orderBy('dashboard_name', 'asc')->get();
        $all_dashboards_array = [];
        foreach($all_dashboards_list as $dashboard_list){

            foreach($dashboard_list->dashboard_required_permission as $perm){
                if(CheckDashboardPermission($perm)){
                    $all_dashboards_array[$dashboard_list->id] = $dashboard_list;
                }
            }

        }
        if(count($all_dashboards_array) > 0){
            if($dtoc_favourites_menu != null){

                $all_dashboards = $all_dashboards_array[$dtoc_favourites_menu->menu_id];
            } else {
                $all_dashboards = reset($all_dashboards_array);
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

        return view('Home.Index', compact('success_array', 'redirect_url', 'dtoc_permission', 'dtoc_redirect_url'));
    }

    public function ane_index()
    {
        if(!Sentinel::check()){
            return redirect()->route('login.screen');
        }

        if(Sentinel::getUser() && !is_numeric(Sentinel::getUser()->user_type)){

            return redirect()->route('ward.ward-details', Sentinel::getUser()->user_type);

        } elseif(Sentinel::getUser() && Sentinel::getUser()->user_type == 2){
            return redirect()->route('ane.livestatus');
        }


        $process_array                                                  = array();
        $success_array                                                  = array();
        $this->PageDataLoad($process_array,$success_array);
        $success_array["page_sub_title"]                = date('jS F H:i');

        return view('Home.ANEHome', compact('success_array'));
    }
    public function IndexRefreshDataLoad()
    {
        $process_array                                                  = array();
        $success_array                                                  = array();
        $this->PageDataLoad($process_array,$success_array);
        $view                                                           = View::make('Home.Index', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }



    public function WardDashboard()
    {

        $wards_to_excludes = Wards::where('ward_bed_matrix_status', 0)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        $other_ward = Wards::where('ward_type_primary', 16)->pluck('ward_short_name')->toArray();
        $wards_to_exclude = array_merge($wards_to_excludes, $other_ward);
        $all_inpatient = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('camis_patient_id')->toArray();

        $definite_potential = CamisIboxBoardRoundPotentialDefinite::whereDate('potential_definite_date', date('Y-m-d'))
        ->whereIn('patient_id', $all_inpatient)->get()
        ->toArray();



        $success_array = array();
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('id')->toArray();
        $patient_list                       = CamisIboxWardPatientInformationWithBedDetailsView::with('IboxBedStatus')->whereIn('ibox_ward_id', $wards_ids)->whereIn('ibox_ward_id', $wards_ids)->where('ibox_bed_type', '=', 'Bed')->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();

        $success_array['total_occupied']['total'] = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            return !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));


        $success_array['total_occupied']['available'] = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){


            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if(strtolower($item['ibox_bed_status_camis']) != 'open'){
                return false;
            }

            return empty($item['camis_patient_id']) && $item['ibox_bed_status_camis'] == 'open' && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));

        $success_array['total_occupied']['occupied'] = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            return !empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));

        $success_array['total_occupied']['restrict'] = count(ArrayFilter($patient_list, function($item)  use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if (
                (!in_array($item['ibox_ward_short_name'], $wards_to_exclude) && empty($item['camis_patient_id']) && isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 2)
            ) {
                return true;
            }
        }));



        $success_array['male_empty']['total']                           = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return (empty($item['bay_gender_value']) || strtolower($item['bay_gender_value']) == strtolower('Male')) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));

        $success_array['male_empty']['available']                       = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if(empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if(strtolower($item['ibox_bed_status_camis']) != 'open'){
                return false;
            }
            return ((empty($item['bay_gender_value']) || strtolower($item['bay_gender_value']) == strtolower('Male')) && empty($item['camis_patient_id']) && strtolower($item['ibox_bed_status_camis']) == 'open' && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));

        $success_array['male_empty']['occupied']                       = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return ((empty($item['bay_gender_value']) || strtolower($item['bay_gender_value']) == strtolower('Male')) && !empty($item['camis_patient_id'])) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));


        $success_array['male_empty']['restrict']                       = count(ArrayFilter($patient_list, function($item)  use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            if (
                (!in_array($item['ibox_ward_short_name'], $wards_to_exclude) && empty($item['camis_patient_id']) && (empty($item['bay_gender_value']) || strtolower($item['bay_gender_value']) == strtolower('Male')) && empty($item['camis_patient_id']) && isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 2)
            ) {
                return true;
            }
        }));



        $success_array['escalation']['total']                           = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return $item['ibox_bed_escalation_status'] == 1 && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));

        $success_array['escalation']['available']                       = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            if(strtolower($item['ibox_bed_status_camis']) != 'open'){
                return false;
            }
            return ($item['ibox_bed_escalation_status'] == 1 && empty($item['camis_patient_id']) && strtolower($item['ibox_bed_status_camis']) == 'open' && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));

        $success_array['escalation']['occupied']                       = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return ($item['ibox_bed_escalation_status'] == 1 && !empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));


        $success_array['escalation']['restrict']                       = count(ArrayFilter($patient_list, function($item)  use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if (
                (!in_array($item['ibox_ward_short_name'], $wards_to_exclude) && empty($item['camis_patient_id']) && $item['ibox_bed_escalation_status'] == 1 && empty($item['camis_patient_id']) && isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 2)
            ) {
                return true;
            }
        }));






        $success_array['female_empty']['total']                         = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return strtolower($item['bay_gender_value']) == strtolower('Female') && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));
        $success_array['female_empty']['available']                     = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            if(strtolower($item['ibox_bed_status_camis']) != 'open'){
                return false;
            }
            return (strtolower($item['bay_gender_value']) == strtolower('Female') && empty($item['camis_patient_id']) && strtolower($item['ibox_bed_status_camis']) == 'open' && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));

        $success_array['female_empty']['occupied']                     = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return (strtolower($item['bay_gender_value']) == strtolower('Female') && !empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));
        $success_array['female_empty']['restrict']                       = count(ArrayFilter($patient_list, function($item)  use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            if (
                (!in_array($item['ibox_ward_short_name'], $wards_to_exclude) && empty($item['camis_patient_id']) && strtolower($item['bay_gender_value']) == strtolower('Female') && empty($item['camis_patient_id']) && isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 2)
            ) {
                return true;
            }
        }));

        $success_array['sr_empty']['total']                             = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return strtolower($item['bay_gender_value']) == strtolower('Side Room') && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));
        $success_array['sr_empty']['available']                         = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){

            if(empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if(strtolower($item['ibox_bed_status_camis']) != 'open'){
                return false;
            }
            return (strtolower($item['bay_gender_value']) == strtolower('Side Room') && empty($item['camis_patient_id'])  && strtolower($item['ibox_bed_status_camis']) == 'open' && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));

        $success_array['sr_empty']['occupied']                         = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return (strtolower($item['bay_gender_value']) == strtolower('Side Room') && !empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));

        $success_array['sr_empty']['restrict']                       = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            if (
                (!in_array($item['ibox_ward_short_name'], $wards_to_exclude) && empty($item['camis_patient_id']) && strtolower($item['bay_gender_value']) == strtolower('Side Room') && empty($item['camis_patient_id']) && isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 2)
            ) {
                return true;
            }
        }));

        $success_array['total_poteintial'] = count(ArrayFilter($definite_potential, function($item) {
            return ($item['type'] == 1);
        }));

        $success_array['total_definite'] = count(ArrayFilter($definite_potential, function($item) {
            return ($item['type'] == 2);
        }));


        $success_array['ward_list'] = Wards::where('status',1)
        ->whereNotIn('ward_url_name', ['rltsdecip','rltsauip','rltsdecpw', 'rltfau'])
        ->orderBy('ward_name', 'asc')->get()->toArray();
       $success_array['emergency_ward_list'] = Wards::where('status',1)->whereIn('ward_url_name', ['rltsdecip','rltsauip', 'rltfau'])->orderBy('ward_name', 'desc')->get()->toArray();

        $success_array['medical_ward'] = [];
        $success_array['surgical_ward'] = [];
        $success_array['other_ward'] = [];
        $success_array['emergency_ward'] = [];
        foreach ($success_array['emergency_ward_list'] as $em_data) {
            $success_array['emergency_ward'][] = $em_data;
        }
        foreach ($success_array['ward_list'] as $ward_data) {
            if ($ward_data['ward_type_primary'] == 13) {
                $success_array['medical_ward'][] = $ward_data;
            } elseif ($ward_data['ward_type_primary'] == 14) {
                $success_array['surgical_ward'][] = $ward_data;
            } elseif ($ward_data['ward_type_primary'] == 16) {
                $success_array['other_ward'][] = $ward_data;
            }
        }


        return view('Home.WardDashboard', compact('success_array'));
    }

    public function VirtualWard()
    {
        return view('Home.VirtualWard');
    }

    public function site()
    {
        return view('Home.Site');
    }
    public function ReportDashboard()
    {
        return view('Home.ReportDashaboard');
    }


    public function PrintGlobal()
    {
        return view('Common.View.PrintGlob');
    }

}
