<?php


namespace App\Http\Controllers\Iboards\Camis;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonReportController;
use App\Http\Controllers\Controller;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\Master\WardType;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\View;

class VirtualWardLeafletController extends Controller
{
    public function Index()
    {
        if(CheckDashboardPermission('leaflet_dashboard_view')){
            return view('Dashboards.Camis.VirtualWardLeaflet.Index');
        } elseif(CheckDashboardPermission('stranded_dashboard')){
            return redirect()->route('site.stranded_patients');
        } elseif(CheckDashboardPermission('r_to_r_view_')){
            return redirect()->route('reason_reside.dashboard');
        } elseif(CheckDashboardPermission('surgical_wards_dashboard_view')){
            return redirect()->route('surgical.ward');
        } elseif(CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')){
            return redirect()->route('discharges_patient.dashboard');
        } elseif(CheckDashboardPermission('site_office_report_view')){
            return redirect()->route('site.office');
        } elseif(CheckDashboardPermission('flow_dashboard_patient_search_view')){
            return redirect()->route('global.patient.search');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function IndexRefreshDataLoad()
    {


        $wards_ids                                              = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->whereIn('ward_type_primary', [13, 14, 20])->with('PrimaryWardType')->get()->toArray();

        $all_inpatients                                         =  CamisIboxWardPatientInformationWithBedDetailsView::whereIn('ibox_ward_id', array_column($wards_ids, 'id'))->where('ibox_bed_type', 'Bed')->whereNotNull('camis_patient_id')->select('ibox_ward_name','camis_patient_id', 'ibox_ward_id')->with(['Ward.PrimaryWardType',
        'PatientWiseFlags' => function ($q)
        {
            $q->whereIn('patient_flag_name', ['ibox_patient_flag_leaflet_one', 'ibox_patient_flag_leaflet_two']);
        }])->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();

        $leaflet_one = CamisIboxBoardRoundPatientFlag::whereIn('patient_id', array_column($all_inpatients, 'camis_patient_id'))->where('patient_flag_name', 'ibox_patient_flag_leaflet_one')->select('patient_id', 'updated_at')->get()->toArray();
        $leaflet_two = CamisIboxBoardRoundPatientFlag::whereIn('patient_id', array_column($all_inpatients, 'camis_patient_id'))->where('patient_flag_name', 'ibox_patient_flag_leaflet_two')->select('patient_id', 'updated_at')->get()->toArray();

        $now = Carbon::now();

        $less_than_48_hour = ArrayFilter($leaflet_one, function ($item) use ($now) {
            $updatedAt = Carbon::parse($item['updated_at']);
            return $updatedAt->diffInHours($now) < 48;
        });

        $greter_than_48_hours = ArrayFilter($leaflet_one, function ($item) use ($now) {
            $updatedAt = Carbon::parse($item['updated_at']);
            return $updatedAt->diffInHours($now) >= 48;
        });

        $top_matrix = ['bed_occupied' => count($all_inpatients), 'leaflet_one_perc' => CalculatePercentageOfTwoValues(count($all_inpatients), count($leaflet_one)), 'click_less_48' => CalculatePercentageOfTwoValues(count($all_inpatients), count($less_than_48_hour)), 'click_more_48' => CalculatePercentageOfTwoValues(count($all_inpatients), count($greter_than_48_hours))];
        $page_matrix = array();

        foreach($wards_ids as $row){
            $ward_id = $row['id'];
            $ward_type = $row['primary_ward_type']['ward_type'];

            $occupied_bed = ArrayFilter($all_inpatients, function ($item) use($ward_id)  {
                return ($item['ibox_ward_id'] == $ward_id);
            });

            $leftlet_two_flag_clicked = ArrayFilter($occupied_bed, function ($item) use($leaflet_two)  {
                return in_array($item['camis_patient_id'], array_column($leaflet_two, 'patient_id'));
            });
            $leftlet_two_flag_not_clicked = ArrayFilter($occupied_bed, function ($item) use($leaflet_two)  {
                return !in_array($item['camis_patient_id'], array_column($leaflet_two, 'patient_id'));
            });

            $leftlet_one_flag_clicked = ArrayFilter($occupied_bed, function ($item) use($leaflet_one)  {
                return in_array($item['camis_patient_id'], array_column($leaflet_one, 'patient_id'));
            });
            $leftlet_one_flag_not_clicked = ArrayFilter($occupied_bed, function ($item) use($leaflet_one)  {
                return !in_array($item['camis_patient_id'], array_column($leaflet_one, 'patient_id'));
            });

            $ward_less_than_48_hour = ArrayFilter($leftlet_one_flag_clicked, function ($item) use ($now) {

                $updatedAt = Carbon::parse($item['patient_wise_flags']['0']['updated_at']);
                return $updatedAt->diffInHours($now) < 48;
            });

            $ward_greter_than_48_hours = ArrayFilter($leftlet_one_flag_clicked, function ($item) use ($now) {

                $updatedAt = Carbon::parse($item['patient_wise_flags']['0']['updated_at']);
                return $updatedAt->diffInHours($now) >= 48;
            });
            $page_matrix[$ward_type][$row['ward_name']] = ['ward_name' => $row['ward_name'], 'bed_occupied' => count($occupied_bed), 'leaflet_one_click' => count($leftlet_one_flag_clicked), 'leaflet_one_not_click' => count($leftlet_one_flag_not_clicked), 'leaflet_one_perc' => CalculatePercentageOfTwoValues(count($occupied_bed), count($leftlet_one_flag_clicked)), 'leaflet_one_click_less_48' => count($ward_less_than_48_hour), 'leaflet_one_click_more_48' => count($ward_greter_than_48_hours), 'leaflet_two_click' => count($leftlet_two_flag_clicked), 'leaflet_two_not_click' => count($leftlet_two_flag_not_clicked)];

        }
        $success_array = ['top_matrix' => $top_matrix, 'page_matrix' => $page_matrix];
        $view                                                           = View::make('Dashboards.Camis.VirtualWardLeaflet.IndexDataLoad', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }

}
