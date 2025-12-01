<?php

namespace App\Http\Controllers\Iboards\Camis;
use App\Http\Controllers\Controller;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundAllowedToMove;
use Illuminate\Http\Request;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Illuminate\Support\Facades\View;
use Toastr;

class AllowedToMoveController extends Controller
{
    public function Index()
    {
        if (!CheckDashboardPermission('allowed_to_move_dashboard_view'))
        {
            Toastr::error('Permission Denied');
            return back();
        }

        return view('Dashboards.Camis.AllowedToMove.Index');
    }

    public function IndexRefreshDataLoad(Request $request)
    {
        if($request->filled('ward_id')){
            $ward_list_arry = $request->ward_id;
            $ward_list = Wards::whereIn('id', $ward_list_arry)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('ward_short_name')->toArray();
        } else {
            $ward_list = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        }

        if($request->filled('move_to')){
            $move_to_array = $request->move_to;
            $move_to = Wards::whereIn('id', $move_to_array)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('ward_short_name')->toArray();
        } else {
            $move_to = [];
        }

        $all_inpatients                                                 = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('camis_patient_id')->toArray();


        $allowed_to_patients                                            = CamisIboxBoardRoundAllowedToMove::whereIn('patient_allowed_to_be_moved_from', $ward_list)->when(($request->filled('type') && $request->type == '2'), function ($q) use($ward_list){
            return $q->where('patient_allowed_to_be_moved_to', 'Do Not Move');
        })
        ->when((count($move_to) > 0), function ($q) use($move_to){
            return $q->whereIn('patient_allowed_to_be_moved_to', $move_to);
        })
        ->when(($request->filled('type') && $request->type == '1'), function ($q) use($ward_list){
            return $q->where('patient_allowed_to_be_moved_to', '!=', 'Do Not Move');
        })->whereIn('patient_id', $all_inpatients)->pluck('patient_id')->toArray();

        $all_patients                                                   = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $allowed_to_patients)->where('disabled_on_all_dashboard_except_ward_summary', 0)->with(['BoardRoundMedicallyFitData', 'AllowedToMove'])->get()->toArray();
        $success_array                                                  = array();
        $total_patients                                                 = count($all_patients);
        $patients = array_reduce($all_patients, function ($carry, $item)
        {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($patients);

        $all_wards = Wards::pluck('ward_name','ward_short_name')->toArray();

        $view = View::make('Dashboards.Camis.AllowedToMove.IndexDataLoad', compact('patients', 'total_patients', 'all_wards'));
        $sections = $view->render();
        return $sections;
    }

    public function Export(Request $request)
    {
        if($request->filled('ward_id')){
            $ward_list_arry = explode(',', $request->input('ward_id'));
            $ward_list = Wards::whereIn('id', $ward_list_arry)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('ward_short_name')->toArray();
        } else {
            $ward_list = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        }

        if($request->filled('move_to')){
            $move_to_array = explode(',', $request->input('move_to'));
            $move_to = Wards::whereIn('id', $move_to_array)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('ward_short_name')->toArray();
        } else {
            $move_to = [];
        }

        $all_inpatients                                                 = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('camis_patient_id')->toArray();


        $allowed_to_patients                                            = CamisIboxBoardRoundAllowedToMove::whereIn('patient_allowed_to_be_moved_from', $ward_list)->when(($request->filled('type') && $request->type == '2'), function ($q) use($ward_list){
            return $q->where('patient_allowed_to_be_moved_to', 'Do Not Move');
        })
        ->when((count($move_to) > 0), function ($q) use($move_to){
            return $q->whereIn('patient_allowed_to_be_moved_to', $move_to);
        })
        ->when(($request->filled('type') && $request->type == '1'), function ($q) use($ward_list){
            return $q->where('patient_allowed_to_be_moved_to', '!=', 'Do Not Move');
        })->whereIn('patient_id', $all_inpatients)->pluck('patient_id')->toArray();

        $all_patients                                                   = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $allowed_to_patients)->with(['BoardRoundMedicallyFitData', 'AllowedToMove'])->where('disabled_on_all_dashboard_except_ward_summary', 0)->get();
        $name = 'Allowed To Move';
        $heading = [
            "Sl No",
            "Camis Patient ID",
            "Bay & Bed",
            "Name",
            "Pas Number",
            "Med Fit",
            "Consultant",
            "Admitted Date",
            "Current Ward",
            "Move To Ward"
        ];
        $all_wards = Wards::pluck('ward_name','ward_short_name')->toArray();

        $patient_list =  $all_patients->map(function ($patient, $index) use($all_wards)  {

                return [
                    'sn' => $index + 1,
                    'id' => $patient['camis_patient_id'],
                    'bay_and_bed' => $patient['ibox_actual_bed_full_name'],
                    'name' => $patient['camis_patient_name'],
                    'pas_id' => $patient['camis_patient_pas_number'],
                    'medfit' => isset($patient['BoardRoundMedicallyFitData']['patient_medically_fit_status']) && $patient['BoardRoundMedicallyFitData']['patient_medically_fit_status'] == 1 ? 'Yes' : 'No',
                    'consultant' => $patient['camis_consultant_name'],
                    'admitted_date' => PredefinedDateFormatFor24Hour($patient['camis_patient_admission_date_time']),
                    'current_ward' => $all_wards[$patient['AllowedToMove']['patient_allowed_to_be_moved_from']] ?? 'Do Not Move',
                    'move_to_ward' => $all_wards[$patient['AllowedToMove']['patient_allowed_to_be_moved_to']] ?? 'Do Not Move',
                ];

        });
        return ExportFunction($patient_list, $heading, $name);
    }

}
