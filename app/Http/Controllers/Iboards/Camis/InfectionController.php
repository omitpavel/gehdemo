<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Common\CommonCamisController;
use App\Models\History\HistoryCamisIboxBoardInfectionRisk;
use App\Models\History\HistoryCamisIboxBoardRoundContactTracingNote;
use App\Models\History\HistoryCamisIboxBoardRoundIpcComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundInfectionRisk;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundIpcComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlagAdditionalInfo;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundReverseBarrier;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundScubWard;
use App\Models\Iboards\Camis\View\CamisIboxPatientAlertDetails;
use App\Models\Iboards\Camis\View\CamisIboxPatientAlertDetailsFullList;
use App\Models\Iboards\Camis\View\CamisIboxWardInPatientInformationDetailsView;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Governance\GovernanceController;
use App\Http\Controllers\Common\HistoryController;
use App\Models\Common\User;
use App\Models\History\HistoryCamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundContactTracingNote;
use App\Models\Iboards\Camis\Master\InfectionControl;
use App\Models\Iboards\Camis\Master\Wards;
use Illuminate\Support\Str;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use Illuminate\Http\Request;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class InfectionController extends Controller
{
    public function Index()
    {

        if (!CheckDashboardPermission('infection_control_')) {
            Toastr::error('Permission Denied');
            return back();
        } elseif (CheckDashboardPermission('infection_control_ic_patients_view')) {
            return view('Dashboards.Camis.InfectionControl.Index');
        } elseif (CheckDashboardPermission('infection_control_sideroom_tools_view')) {
            return redirect()->route('infection.sideroom.patients');
        } elseif (CheckDashboardPermission('infection_control_covid_wards_view')) {
            return redirect()->route('infection.covid.ward');
        } elseif (CheckDashboardPermission('infection_control_covid_siterep_view')) {
            return redirect()->route('infection.covid.sitrep');
        } elseif (CheckDashboardPermission('infection_control_covid_contact_tracing_view')) {
            return redirect()->route('infection.contact.tracing');
        }
    }

    public function IndexDataLoad(Request $request)
    {
        $process_array                                                  = array();

        $infection_reason_list                          = InfectionControl::orderBy('infection_list_show_data_name', 'ASC')->where('status', 1)->pluck('infection_list_show_data_name', 'id')->toArray();
        $success_array['infection_reason_list_arr']     = isset($infection_reason_list) ? $infection_reason_list : [];
        $success_array['infection_reason_id']           = $request->infection_reason_id ?? '';
        $success_array['room_type']                     = $request->room_type ?? '';
        $patients_information_table = CamisIboxWardPatientInformationWithBedDetailsView::ReturnTableName();
        $patient_flag_table_table = CamisIboxBoardRoundPatientFlag::ReturnTableName();
        $patient_flag_history_table = HistoryCamisIboxBoardRoundPatientFlag::ReturnTableName();


        $ic_patient_lists = CamisIboxBoardRoundPatientFlag::with('InfectionRisks')
            ->where('patient_flag_name', 'ibox_patient_flag_infection_risk')
            ->join("{$patients_information_table}", "{$patient_flag_table_table}.patient_id", "=", "{$patients_information_table}.camis_patient_id")
            ->when($request->filled('infection_reason_id'), function ($q) use ($request) {
                return $q->whereHas('InfectionRisks', function ($subQuery) use ($request) {
                    $subQuery->where('infection_id', $request->infection_reason_id);
                });
            })
            ->pluck('patient_id')
            ->toArray();


        $ic_patient_query           = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_name', 'ibox_patient_flag_infection_risk')
                    ->where('patient_flag_status_value', 1);
            },
            'ReverseBarrier',
            'InfectionRisks'
        ])
            ->whereHas('PatientWiseFlags', function ($q) use ($request) {
                $q->where('patient_flag_name', 'ibox_patient_flag_infection_risk')
                    ->where('patient_flag_status_value', 1);
            })
            ->when($request->reverse_barrier == 1, function ($q) {
                return $q->whereHas('ReverseBarrier', function ($q) {
                    $q->where('reverse_barrier_status', 1);
                });
            })
            ->whereIn('camis_patient_id', $ic_patient_lists)
            ->where('camis_patient_id', "!=", "")
            ->where('ibox_bed_type', 'Bed')
            ->where('ibox_bed_status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0);

        if ($request->filled('room_type')) {
            if ($request->room_type == 'siderooms') {
                $ic_patient_query->where('ibox_bed_group_name', '=', 'Side Room');
            } elseif ($request->room_type == 'others') {
                $ic_patient_query->where('ibox_bed_group_name', '!=', 'Side Room');
            }
        }
        $success_array['total_reverse_barrier'] = (clone $ic_patient_query)->whereHas('ReverseBarrier', function ($q) {
            $q->where('reverse_barrier_status', 1);
        })->count();
        $ic_patient_array           = $ic_patient_query->get();

        if (count($ic_patient_array) > 0) {
            $data_array             = $ic_patient_array->toArray();
            array_unshift($data_array, null);
            unset($data_array[0]);
            $data_collection        = collect($data_array);
            $data_group_array       = $data_collection->groupBy('ibox_ward_name');
        }
        $success_array['infected_patients']             = $ic_patient_array->count();
        $success_array['ic_patient_list_arr_all']       = isset($data_group_array) ? $data_group_array : [];
        $success_array['reverse_barrier']               = $request->reverse_barrier ?? 0;
        $view                                                = View::make('Dashboards.Camis.InfectionControl.Partials.ICPatientsData', compact('success_array'));
        $sections                                           = $view->render();
        return $sections;
    }




    public function SideRoomPatients()
    {

        if (CheckDashboardPermission('infection_control_sideroom_tools_view')) {
            return view('Dashboards.Camis.InfectionControl.SideRoom');
        } elseif (CheckDashboardPermission('infection_control_covid_wards_view')) {
            return redirect()->route('infection.covid.ward');
        } elseif (CheckDashboardPermission('infection_control_covid_siterep_view')) {
            return redirect()->route('infection.covid.sitrep');
        } elseif (CheckDashboardPermission('infection_control_covid_contact_tracing_view')) {
            return redirect()->route('infection.contact.tracing');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }




    public function SideRoomPatientsDataLoad(Request $request)
    {
        $success_array                                                  = array();
        $process_array                                                  = array();

        $process_array['ward_short_name']                       = $request->ward_id;
        $process_array['query_type_show']                       = $request->query_type_show;
        $ward_list = Wards::with('SecondaryWardType')->where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)


            ->orderBy('ward_name', 'asc')
            ->get()->toArray();
        $all_wards = ArrayFilter($ward_list, function ($item) {
            if ($item['disabled_on_all_dashboard_except_ward_summary'] == 0 && $item['status'] == 1) {
                return true;
            }
        });

        $medical_wards = ArrayFilter($all_wards, function ($item) {
            if (isset($item['secondary_ward_type']['ward_type']) && strtolower($item['secondary_ward_type']['ward_type']) == 'medical') {
                return true;
            }
        });
        $surgical_wards = ArrayFilter($all_wards, function ($item) {
            if (isset($item['secondary_ward_type']['ward_type']) && strtolower($item['secondary_ward_type']['ward_type']) == 'surgical') {
                return true;
            }
        });

        $womens_wards = ArrayFilter($all_wards, function ($item) {
            if (isset($item['secondary_ward_type']['ward_type']) && stripos($item['secondary_ward_type']['ward_type'], 'women') !== false) {
                return true;
            }
        });

        $other_wards = ArrayFilter($all_wards, function ($item) {
            if (isset($item['secondary_ward_type']['ward_type']) && strtolower($item['secondary_ward_type']['ward_type']) == 'others') {
                return true;
            }
        });

        $success_array['ward_short_name']               = $request->ward_id ?? '';
        $success_array['query_type_show']               = $request->query_type_show ?? '';
        $side_room_patient = $this->GetSideroomPatients($process_array);

        $side_room_patient = collect($side_room_patient);
        $success_array['ic_sideroom_patient_list_arr'] = $side_room_patient->filter(function ($value) {
            return count($value) > 0;
        })->toArray();
        $order = ['Medical', 'Surgical', 'Womens & Childrens', 'Others'];

        uksort($success_array['ic_sideroom_patient_list_arr'], function ($a, $b) use ($order) {
            return array_search($a, $order) - array_search($b, $order);
        });
        $view                                                = View::make('Dashboards.Camis.InfectionControl.Partials.SideRoomData', compact('success_array', 'medical_wards', 'surgical_wards', 'womens_wards', 'other_wards'));
        $sections                                            = $view->render();
        return $sections;
    }


    public function CovidWards()
    {


        if (CheckDashboardPermission('infection_control_covid_wards_view')) {
            return view('Dashboards.Camis.InfectionControl.CovidWards');
        } elseif (CheckDashboardPermission('infection_control_covid_siterep_view')) {
            return redirect()->route('infection.covid.sitrep');
        } elseif (CheckDashboardPermission('infection_control_covid_contact_tracing_view')) {
            return redirect()->route('infection.contact.tracing');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function CovidWardDataLoad(Request $request)
    {

        $process_array["all_ward_details"]  = Wards::with('PrimaryWardType')->where('status', 1)->orderBy('ward_name', 'ASC')->get();

        $medical_wards                      = array();
        $surgical_wards                     = array();
        $assessment_wards                   = array();
        $other_wards                        = array();
        $infection_control_drop             = array();

        $m                                  = 0;
        $s                                  = 0;
        $o                                  = 0;
        $a                                  = 0;

        $infection_control_drop[0]          = "Open";
        $infection_control_drop[2]          = "Red";
        $infection_control_drop[3]          = "Yellow";
        $infection_control_drop[4]          = "Green";
        $infection_control_drop[5]          = "Blue";
        $infection_control_drop[1]          = "Outbreak";

        foreach ($process_array["all_ward_details"] as $data) {
            if ($data->PrimaryWardType->ward_type == "Medical") {
                $medical_wards[$m]['ward_name']                 =  $data->ward_name;
                $medical_wards[$m]['id']                        =  $data->id;
                $medical_wards[$m]['ward_typ']                  =  $data->PrimaryWardType->ward_type;
                $medical_wards[$m]['infection_close_status']    =  $data->ward_infection_close_status;
                $m++;
            } elseif ($data->PrimaryWardType->ward_type == "Surgical") {
                $surgical_wards[$s]['id']                       =  $data->id;
                $surgical_wards[$s]['ward_name']                =  $data->ward_name;
                $surgical_wards[$s]['ward_typ']                 =  $data->PrimaryWardType->ward_type;
                $surgical_wards[$s]['infection_close_status']   =  $data->ward_infection_close_status;
                $s++;
            } elseif ($data->PrimaryWardType->ward_type == "Assessment") {
                $assessment_wards[$a]['id']                     =  $data->id;
                $assessment_wards[$a]['ward_name']              =  $data->ward_name;
                $assessment_wards[$a]['ward_typ']               =  $data->PrimaryWardType->ward_type;
                $assessment_wards[$a]['infection_close_status'] =  $data->ward_infection_close_status;
                $a++;
            } else {
                $other_wards[$o]['id']                          =  $data->id;
                $other_wards[$o]['ward_name']                   =  $data->ward_name;
                $other_wards[$o]['ward_typ']                    =  $data->PrimaryWardType->ward_type;
                $other_wards[$o]['infection_close_status']      =  $data->ward_infection_close_status;
                $o++;
            }
        }

        $success_array['ic_drop_list_arr']              = $infection_control_drop;
        $success_array['medical_wards']                 = $medical_wards;
        $success_array['medical_wards_count']           = count($medical_wards);
        $success_array['surgical_wards']                = $surgical_wards;
        $success_array['surgical_wards_count']          = count($surgical_wards);
        $success_array['assessment_wards']              = $assessment_wards;
        $success_array['assessment_wards_count']        = count($assessment_wards);
        $success_array['other_wards']                   = $other_wards;
        $success_array['other_wards_count']             = count($other_wards);

        $view                                                   = View::make('Dashboards.Camis.InfectionControl.Partials.CovidWardData', compact('success_array'));
        $sections                                               = $view->render();
        return $sections;
    }


    public function CovidSitrep()
    {


        if (CheckDashboardPermission('infection_control_covid_siterep_view')) {
            return view('Dashboards.Camis.InfectionControl.CovidSitrep');
        } elseif (CheckDashboardPermission('infection_control_covid_contact_tracing_view')) {
            return redirect()->route('infection.contact.tracing');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function CovidSitrepData(Request $request)
    {

        if ($request->filled('ward_id')) {
            $ward_id = $request->ward_id;
        } else {
            $ward_id = '';
        }

        $all_ic_covid_data_array                        = $this->GetCovidPatients($ward_id);
        $success_array["selected_ward_id"]              = $ward_id;
        $success_array["all_ward_details"]              = Wards::where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->orderBy('ward_name', 'ASC')->get();
        $success_array['ic_covid_patient_list_arr_all'] = isset($all_ic_covid_data_array) ? $all_ic_covid_data_array : [];
        $view                                           = View::make('Dashboards.Camis.InfectionControl.Partials.CovidSitrepData', compact('success_array'));
        $sections                                       = $view->render();
        return $sections;
    }


    public function GetCovidPatients($ward_id = '')
    {
        $ic_covid_patient_query = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'HistoryCamisIboxBoardRoundPatientFlag' => function ($q) {
                $q->orderBy('id', 'desc');
            }
        ])->whereHas('HistoryCamisIboxBoardRoundPatientFlag', function ($q) {

            $conditions = [
                ['flag_details->patient_flag_infection_risk_reason_text', 'like', 'COVID-19 '],
            ];
            $q->where(function ($query) use ($conditions) {
                foreach ($conditions as $condition) {
                    $query->orWhere(function ($subquery) use ($condition) {
                        $subquery->where('flag_details', 'LIKE', "%\"patient_flag_infection_risk_reason_text\":\"%$condition[2]%\"%");
                    });
                }
            });
        })
            ->where('camis_patient_id', "!=", "")
            ->where('ibox_bed_type', 'Bed')
            ->where('ibox_bed_status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0);


        if ($ward_id != '') {
            $ic_covid_patient_query = $ic_covid_patient_query->where('ibox_ward_id', $ward_id);
        }
        $ic_covid_patient_array         = $ic_covid_patient_query->get()->toArray();

        $ic_covid_data_group_array      = array();
        $covid_exposed_query            = 0;
        $covid_exposed_confirmed        = 0;
        $covid_positive_query           = 0;
        $covid_positive_confirmed       = 0;
        $covid_positive_resolved        = 0;
        $swab_overdue                   = 0;
        if (count($ic_covid_patient_array) > 0) {
            foreach ($ic_covid_patient_array as $ic_covid_patient) {
                if ($ic_covid_patient['ibox_ward_name'] != "") {
                    if (isset($ic_covid_patient['history_camis_ibox_board_round_patient_flag'][0])) {
                        $patient_flag_extra_data                                = json_decode($ic_covid_patient['history_camis_ibox_board_round_patient_flag'][0]['flag_details']);
                        if (((strtolower($patient_flag_extra_data->patient_flag_infection_risk_reason_text) == "covid-19 exposed" && (strtolower($patient_flag_extra_data->patient_flag_infection_risk_selected_data) == "query" || strtolower($patient_flag_extra_data->patient_flag_infection_risk_selected_data) == "confirmed")) || (strtolower($patient_flag_extra_data->patient_flag_infection_risk_reason_text) == "covid-19 positive" && (strtolower($patient_flag_extra_data->patient_flag_infection_risk_selected_data) == "query" || strtolower($patient_flag_extra_data->patient_flag_infection_risk_selected_data) == "confirmed" || strtolower($patient_flag_extra_data->patient_flag_infection_risk_selected_data) == "negative"))) /*|| $patient_flag_extra_data->covid_latest_result_fetch == "negative"*/) {
                            $add_check_val                  = 0;

                            if (strtolower($patient_flag_extra_data->patient_flag_infection_risk_reason_text) == "covid-19 exposed" && strtolower($patient_flag_extra_data->patient_flag_infection_risk_selected_data) == "query") {
                                $covid_exposed_query++;
                                $add_check_val              = 1;
                            }

                            if (strtolower($patient_flag_extra_data->patient_flag_infection_risk_reason_text) == "covid-19 exposed" && strtolower($patient_flag_extra_data->patient_flag_infection_risk_selected_data) == "confirmed") {
                                $covid_exposed_confirmed++;
                                $add_check_val              = 1;
                            }

                            if (strtolower($patient_flag_extra_data->patient_flag_infection_risk_reason_text) == "covid-19 positive" && strtolower($patient_flag_extra_data->patient_flag_infection_risk_selected_data) == "query") {
                                $covid_positive_query++;
                                $add_check_val              = 1;
                            }

                            if (strtolower($patient_flag_extra_data->patient_flag_infection_risk_reason_text) == "covid-19 positive" && strtolower($patient_flag_extra_data->patient_flag_infection_risk_selected_data) == "confirmed") {
                                $covid_positive_confirmed++;
                                $add_check_val              = 1;
                            }

                            if (strtolower($patient_flag_extra_data->patient_flag_infection_risk_reason_text) == "covid-19 positive" && strtolower($patient_flag_extra_data->patient_flag_infection_risk_selected_data) == "negative") {
                                $covid_positive_resolved++;
                                $patient_flag_extra_data->covid_risk_status_button = "resolved";
                                $add_check_val              = 1;
                            }

                            if ($add_check_val == 1) {
                                $ic_covid_data_group_array[$ic_covid_patient['ibox_ward_name']]["data"][$ic_covid_patient['camis_patient_pas_number']]['camis_patient_pas_number']                       = $ic_covid_patient['camis_patient_pas_number'];

                                $ic_covid_data_group_array[$ic_covid_patient['ibox_ward_name']]["data"][$ic_covid_patient['camis_patient_pas_number']]['camis_patient_name']                       = $ic_covid_patient['camis_patient_name'];

                                $ic_covid_data_group_array[$ic_covid_patient['ibox_ward_name']]["data"][$ic_covid_patient['camis_patient_pas_number']]['camis_patient_age']                       = $ic_covid_patient['camis_patient_age'];

                                $ic_covid_data_group_array[$ic_covid_patient['ibox_ward_name']]["data"][$ic_covid_patient['camis_patient_pas_number']]['ibox_actual_bed_full_name']                       = $ic_covid_patient['ibox_actual_bed_full_name'];

                                $ic_covid_data_group_array[$ic_covid_patient['ibox_ward_name']]["data"][$ic_covid_patient['camis_patient_pas_number']]['camis_patient_admission_date']                       = $ic_covid_patient['camis_patient_admission_date'];

                                $ic_covid_data_group_array[$ic_covid_patient['ibox_ward_name']]["data"][$ic_covid_patient['camis_patient_pas_number']]['camis_consultant_name']                       = $ic_covid_patient['camis_consultant_name'];

                                $ic_covid_data_group_array[$ic_covid_patient['ibox_ward_name']]["data"][$ic_covid_patient['camis_patient_pas_number']]['patient_flag_infection_risk_status']                       = $patient_flag_extra_data->patient_flag_infection_risk_selected_data;

                                $ic_covid_data_group_array[$ic_covid_patient['ibox_ward_name']]["data"][$ic_covid_patient['camis_patient_pas_number']]['patient_flag_infection_risk_reason']                       = $patient_flag_extra_data->patient_flag_infection_risk_reason_text;
                            }
                        }
                    }
                }
            }
        }

        $ic_covid_all_data_array["covid_exposed_query"]          = $covid_exposed_query;
        $ic_covid_all_data_array["covid_exposed_confirmed"]      = $covid_exposed_confirmed;
        $ic_covid_all_data_array["covid_positive_query"]         = $covid_positive_query;
        $ic_covid_all_data_array["covid_positive_confirmed"]     = $covid_positive_confirmed;
        $ic_covid_all_data_array["covid_positive_resolved"]      = $covid_positive_resolved;
        $ic_covid_all_data_array["swab_overdue"]                 = $swab_overdue;
        $ic_covid_all_data_array["ic_covid_data_group_array"]    = $ic_covid_data_group_array ?? [];
        return $ic_covid_all_data_array;
    }

    public function IPCSideRoomPatients()
    {
        $success_array['infection_control'] = InfectionControl::where('status', 1)->orderBy('infection_list_show_data_name', 'asc')->get();

        return view('Dashboards.Camis.InfectionControl.IPCSideRoom', compact('success_array'));
    }

    public function IPCSideRoomPatientsDataLoad(Request $request)
    {

        $ic_sideroom_query                              = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_status_value', 1);
            },
            'Ward.PrimaryWardType',
            'IboxBedStatus',
            'ReverseBarrier',
            'BoardRoundIpcComment',
            'InfectionRisks',
            'PrimaryInfectionRisk'
        ])
            ->whereRaw('LOWER(ibox_bed_group_name) = ?', ['side room'])
            ->where('ibox_bed_type', 'Bed')
            ->where('ibox_bed_status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->when($request->filled('ward_id'), function ($q) use ($request) {
                return $q->whereIn('ibox_ward_id', $request->ward_id);
            })->unless($request->filled('ward_id'), function ($q) {
                $q->whereIn('ibox_ward_id', AllWardToIDArray());
            })->get()->toArray();




        $scub_rows = CamisIboxBoardRoundScubWard::with(['PatientWiseFlags', 'ReverseBarrier', 'BoardRoundIpcComment', 'InfectionRisks', 'PrimaryInfectionRisk'])->get()->toArray();
        if (count($scub_rows) > 0) {
            foreach ($scub_rows as $scub) {

                $ic_sideroom_query[] = [
                    'scub_ward_id'                   => $scub['bed_id'] ?? 0,
                    'ibox_actual_bed_full_name'      => $scub['bed_name'] ?? 'Side Room 01',
                    'camis_patient_sex'              => $scub['patient_gender'] ?? 'male',
                    'board_round_ipc_comment'        => $scub['board_round_ipc_comment']['comment'] ?? '',
                    'camis_patient_id'               => $scub['camis_patient_id'],
                    'camis_patient_ward'  => 'SCUB',
                    'camis_patient_name'             => $scub['patient_name'],
                    'camis_patient_pas_number'       => $scub['pas_number'],
                    'camis_consultant_name'          => $scub['consultant_name'],
                    'camis_patient_admission_date'   => $scub['admitting_date'] ? Carbon::parse($scub['admitting_date'])->format('Y-m-d') : null,
                    'camis_patient_admission_date_time' => $scub['admitting_date'] ? Carbon::parse($scub['admitting_date'])->toDateTimeString() : null,
                    'ibox_bed_status_camis'          => 'open',
                    'ibox_bed_status'                => 1,
                    'patient_wise_flags'             => $scub['patient_wise_flags'] ?? [],
                    'infection_risks'                => $scub['infection_risks'] ?? [],
                    // emulate ward so downstream grouping works:
                    'ward' => [
                        'ward_name' => 'Special Care Baby Unit',
                        'id' => 00,
                        'primary_ward_type' => ['ward_type' => 'Others']
                    ],
                    'reverse_barrier' => $scub['reverse_barrier'] ?? [],
                ];
            }
        }
        $all_patients = [];
        $can_be_moved_count = 0;
        $can_not_be_moved_count = 0;
        foreach ($ic_sideroom_query as $patient) {
            $patient_ward = $patient['ward']['ward_name'];
            $patient_ward_type = $patient['ward']['primary_ward_type']['ward_type'];


            if (stripos($patient_ward_type, 'women') !== false) {
                $ward_type = 'Womens & Childrens';
            } else {
                $ward_type = $patient_ward_type;
            }



            if (isset($patient['reverse_barrier']['reverse_barrier_status']) && $patient['reverse_barrier']['reverse_barrier_status'] == 1) {
                $patient_row['reverse_barrier_status'] = 1;
            } else {
                $patient_row['reverse_barrier_status'] = 0;
            }

            $patient_row['scub_ward_id'] = $patient['scub_ward_id'] ?? 0;
            $patient_row['infection_risks'] = $patient['infection_risks'] ?? [];
            $patient_row['camis_patient_ward'] = $patient['camis_patient_ward'];
            $patient_row['ibox_actual_bed_full_name'] = $patient['ibox_actual_bed_full_name'];
            $patient_row['camis_patient_sex'] = $patient['camis_patient_sex'];
            $patient_row['camis_patient_ipc_comment'] = $patient['board_round_ipc_comment']['comment'] ?? '';
            $patient_row['camis_patient_id'] = $patient['camis_patient_id'];
            $patient_row['camis_patient_name'] = $patient['camis_patient_name'];
            $patient_row['camis_patient_pas_number'] = !empty($patient['camis_patient_id']) ? $patient['camis_patient_pas_number'] : '--';
            $patient_row['camis_consultant_name'] = !empty($patient['camis_patient_id']) ? $patient['camis_consultant_name'] : '--';
            $patient_row['los'] = !empty($patient['camis_patient_id']) ? NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date'], date('Y-m-d')) . ' Days' : '--';
            $patient_row['camis_patient_admission_date_time'] = !empty($patient['camis_patient_id']) ? PredefinedDateFormatFor24Hour($patient['camis_patient_admission_date_time']) : '--';
            $patient_row['ibox_bed_status_camis'] = $patient['ibox_bed_status_camis'];
            $infection_flag = ArrayFilter($patient['patient_wise_flags'], function ($item) {
                return strtolower($item['patient_flag_name']) == 'ibox_patient_flag_infection_risk';
            });
            $others_flag = ArrayFilter($patient['patient_wise_flags'], function ($item) {
                return strtolower($item['patient_flag_name']) != 'ibox_patient_flag_infection_risk';
            });

            $is_infected = false;
            $primary_infection = '';
            $others_infection  = '';
            $patient_row['primary_next_review_date'] = '';
            $patient_row['is_infected_bg']       = 0;

            if (!empty($patient['infection_risks'])) {

                $infection_risks = $patient['infection_risks'];

                $others_infection = array_map(function ($infection) {
                    $infection_type = ($infection['infection_type'] ?? '') === 'CANSTAYINBAY'
                        ? 'CAN STAY IN BAY'
                        : ($infection['infection_type'] ?? '');
                    return ($infection['infection_name'] ?? '') . ' - ' . ucwords(strtolower($infection_type));
                }, array_values(array_filter($infection_risks, function ($item) {
                    return empty($item['is_primary']) || $item['is_primary'] == 0;
                })));

                $primary_infection = array_map(function ($infection) {
                    $infection_type = ($infection['infection_type'] ?? '') === 'CANSTAYINBAY'
                        ? 'CAN STAY IN BAY'
                        : ($infection['infection_type'] ?? '');
                    return ($infection['infection_name'] ?? '') . ' - ' . ucwords(strtolower($infection_type));
                }, array_values(array_filter($infection_risks, function ($item) {
                    return !empty($item['is_primary']) && $item['is_primary'] == 1;
                })));

                $is_infected_count = array_values(array_filter($infection_risks, function ($item) {
                    return $item['is_primary'] == 1 && in_array(strtoupper($item['infection_type'] ?? ''), ['CONFIRMED', 'QUERY']);
                }));

                $is_infected = count($is_infected_count) > 0;

                $primary = null;
                foreach ($infection_risks as $infection) {
                    if (!empty($infection['is_primary']) && $infection['is_primary'] == 1) {
                        $primary = $infection;
                        break;
                    }
                }

                if ($primary && !empty($primary['infection_type'])) {

                    if (in_array(strtoupper($primary['infection_type']), ['CONFIRMED', 'QUERY'])) {
                        $patient_row['is_infected_bg'] = 1;
                    }
                }
                if ($primary && !empty($primary['next_review_date'])) {
                    $patient_row['primary_next_review_date'] = PredefinedDateFormatForPD($primary['next_review_date']);
                }
            } else {
                $primary_infection = '';
                $others_infection  = '';
            }


            $patient_row['is_infected']       = $is_infected ? 1 : 0;
            $patient_row['primary_infection'] = is_array($primary_infection) ? implode(', ', $primary_infection) : '';
            $patient_row['others_infection']  = is_array($others_infection) ? implode(', ', $others_infection) : '';

            if ($request->can_be_move == 1 && $request->can_not_be_move == 1) {
            } else {

                if ($request->filled('can_be_move') && $request->can_be_move == 0) {
                    if (!$is_infected) {
                        continue;
                    }
                }
                if ($request->filled('can_not_be_move') && $request->can_not_be_move == 0) {
                    if ($is_infected) {
                        continue;
                    }
                }
            }
            if (!empty($patient['camis_patient_id'])) {
                if (!$is_infected) {
                    $can_be_moved_count++;
                } else {
                    $can_not_be_moved_count++;
                }
            }
            $patient_row['patient_wise_flags'] = $others_flag;
            $patient_row['ibox_bed_status'] = $patient['ibox_bed_status'];
            $all_patients[$ward_type][$patient_ward][$patient['ibox_actual_bed_full_name']] = $patient_row;
        }

        ksort($all_patients);
        $ipc_patient_list = [];

        foreach ($all_patients as $department => $wards) {
            $ipc_patient_list[$department] = [];
            $rowIndex = 1;
            $currentRow = [];
            $currentRowCount = 0;

            foreach ($wards as $ward => $beds) {
                $bedPointer = 0;
                $bedCount = count($beds);

                if ($currentRowCount > 0) {
                    $ipc_patient_list[$department]['row_' . $rowIndex] = $currentRow;
                    $rowIndex++;
                    $currentRow = [];
                    $currentRowCount = 0;
                }

                while ($bedPointer < $bedCount) {
                    $remainingSpace = 6 - $currentRowCount;
                    $takeBeds = array_slice($beds, $bedPointer, $remainingSpace);

                    if (!isset($currentRow[$ward])) {
                        $currentRow[$ward] = [];
                    }

                    $currentRow[$ward] = array_merge($currentRow[$ward], $takeBeds);

                    $currentRowCount += count($takeBeds);
                    $bedPointer += count($takeBeds);

                    if ($currentRowCount === 6) {
                        $ipc_patient_list[$department]['row_' . $rowIndex] = $currentRow;
                        $rowIndex++;
                        $currentRow = [];
                        $currentRowCount = 0;
                    }
                }

                if ($currentRowCount > 0) {
                    $ipc_patient_list[$department]['row_' . $rowIndex] = $currentRow;
                    $rowIndex++;
                    $currentRow = [];
                    $currentRowCount = 0;
                }
            }
        }

        $show_on_ward_summary_status_check             = BoardRoundFlagList::where('show_on_normal_ward', 1)->where('show_flag_on_main_ward_summary', '=', 1)->pluck('patient_flag_name', 'patient_flag_stored_name')->toArray();
        uksort($ipc_patient_list, function ($a, $b) {
            return ($a === 'Others') - ($b === 'Others');
        });
        $ward_list = Wards::with('PrimaryWardType')->where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)


            ->orderBy('ward_name', 'asc')
            ->get()->toArray();
        $all_wards = ArrayFilter($ward_list, function ($item) {
            if ($item['disabled_on_all_dashboard_except_ward_summary'] == 0 && $item['status'] == 1) {
                return true;
            }
        });

        $medical_wards = ArrayFilter($all_wards, function ($item) {
            if (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'medical') {
                return true;
            }
        });
        $surgical_wards = ArrayFilter($all_wards, function ($item) {
            if (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'surgical') {
                return true;
            }
        });

        $womens_wards = ArrayFilter($all_wards, function ($item) {
            if (isset($item['primary_ward_type']['ward_type']) && stripos($item['primary_ward_type']['ward_type'], 'women') !== false) {
                return true;
            }
        });

        $other_wards = ArrayFilter($all_wards, function ($item) {
            if (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'others') {
                return true;
            }
        });
        return view('Dashboards.Camis.InfectionControl.Partials.IPCSideRoomData', compact('ipc_patient_list', 'show_on_ward_summary_status_check', 'medical_wards', 'surgical_wards', 'womens_wards', 'other_wards', 'can_be_moved_count', 'can_not_be_moved_count'));
    }

    public function SaveScubPatient(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundScubWard";
        $date_time_now                                              = CurrentDateOnFormat();
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');


        $bed_id                                                     = $request->bed_id ?? '';
        $camis_patient_id                                           = $request->camis_patient_id ?? '';
        $pas_number                                                 = $request->pas_number ?? '';
        $patient_name                                               = $request->patient_name ?? '';
        $consultant_name                                            = $request->consultant_name ?? '';
        $speciality                                                 = $request->speciality ?? '';
        $admitting_date                                             = $request->admitting_date ?? '';
        $patient_gender                                             = $request->patient_gender ?? '';


        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));

        $ward_controller                                            = new WardSummaryController();
        $functional_identity                                        = 'SCUB Bed';

        if ($camis_patient_id != "" && $user_id != "") {

            $gov_text_before_arr                                    = CamisIboxBoardRoundScubWard::where('bed_id', '=', $bed_id)->first();
            $old_camis_patient_id = optional($gov_text_before_arr)->camis_patient_id;



            $updated_data                                           = CamisIboxBoardRoundScubWard::updateOrCreate(['bed_id' => $bed_id], ['camis_patient_id' => $camis_patient_id, 'pas_number' => $pas_number, 'admitting_date' => $admitting_date, 'patient_name' => $patient_name, 'patient_gender' => $patient_gender, 'consultant_name' => $consultant_name, 'speciality' => $speciality, 'updated_by' => $user_id]);

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundScubWard::where('id', '=', $updated_array["id"])->first();
                    $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'SCUB Patient Data', $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"] = DataUpdatedMessage();

                $camis_changed = ($old_camis_patient_id !== null && $old_camis_patient_id !== $camis_patient_id);

                if ($camis_changed) {
                    if ($old_camis_patient_id !== '') {
                        $this->RemovePatientFlagDetails($old_camis_patient_id);
                    }
                }

                if ($gov_text_before_arr) {
                    $gov_text_before    = $gov_text_before_arr->toArray();
                    $updated_array      = $updated_data->getAttributes();
                    if (!empty($updated_array) && isset($updated_array['id'])) {
                        $gov_text_after_arr = CamisIboxBoardRoundScubWard::where('id', $updated_array['id'])->first();
                        $ward_controller->GovernanceBoardRoundUpdatePreCall(
                            $camis_patient_id,
                            $gov_text_before,
                            'SCUB Patient Data',
                            $gov_text_after_arr,
                            $functional_identity,
                            2
                        );
                    }
                }
            }

            $scub_data = CamisIboxBoardRoundScubWard::with([
                'PatientWiseFlags',
                'ReverseBarrier',
                'BoardRoundIpcComment',
                'InfectionRisks',
                'PrimaryInfectionRisk'
            ])->where('bed_id', $bed_id)->first();
            $show_on_ward_summary_status_check             = BoardRoundFlagList::where('show_on_normal_ward', 1)->where('show_flag_on_main_ward_summary', '=', 1)->pluck('patient_flag_name', 'patient_flag_stored_name')->toArray();

            if ($scub_data != null) {
                $patient_ward = 'Special Care Baby Unit';
                $patient_ward_type = 'Others';


                if (stripos($patient_ward_type, 'women') !== false) {
                    $ward_type = 'Womens & Childrens';
                } else {
                    $ward_type = $patient_ward_type;
                }

                $patient_row = $scub_data->toArray();

                if (isset($patient_row['reverse_barrier']['reverse_barrier_status']) && $patient_row['reverse_barrier']['reverse_barrier_status'] == 1) {
                    $patient['reverse_barrier_status'] = 1;
                } else {
                    $patient['reverse_barrier_status'] = 0;
                }

                $patient['scub_ward_id'] = $patient_row['bed_id'] ?? 0;
                $patient['camis_patient_ward'] = 'SCUB';
                $patient['infection_risks'] = $patient_row['infection_risks'] ?? [];
                $patient['ibox_actual_bed_full_name'] = $patient_row['bed_name'] ?? 'Side Room 01';
                $patient['camis_patient_sex'] = $patient_row['patient_gender'] ?? '';
                $patient['camis_patient_ipc_comment'] = $patient_row['board_round_ipc_comment']['comment'] ?? '';
                $patient['camis_patient_id'] = $patient_row['camis_patient_id'];
                $patient['camis_patient_name'] = $patient_row['patient_name'];
                $patient['camis_patient_pas_number'] = !empty($patient_row['camis_patient_id']) ? $patient_row['pas_number'] : '--';
                $patient['camis_consultant_name'] = !empty($patient_row['camis_patient_id']) ? $patient_row['consultant_name'] : '--';
                $patient['los'] = !empty($patient_row['camis_patient_id']) ? NumberOfDaysBetweenTwoDates($patient_row['admitting_date'], date('Y-m-d')) . ' Days' : '--';
                $patient['camis_patient_admission_date_time'] = !empty($patient_row['camis_patient_id']) ? PredefinedDateFormatFor24Hour($patient_row['admitting_date']) : '--';
                $patient['ibox_bed_status_camis'] = 'open';
                $infection_flag = ArrayFilter($patient_row['patient_wise_flags'], function ($item) {
                    return strtolower($item['patient_flag_name']) == 'ibox_patient_flag_infection_risk';
                });
                $others_flag = ArrayFilter($patient_row['patient_wise_flags'], function ($item) {
                    return strtolower($item['patient_flag_name']) != 'ibox_patient_flag_infection_risk';
                });

                $is_infected = false;
                $primary_infection = '';
                $others_infection  = '';
                $patient['primary_next_review_date'] = '';
                $patient['is_infected_bg']       = 0;
                $first_flag_key = array_key_first($infection_flag);

                if (!empty($patient['infection_risks'])) {

                    $infection_risks = $patient['infection_risks'];

                    $others_infection = array_map(function ($infection) {
                        $infection_type = ($infection['infection_type'] ?? '') === 'CANSTAYINBAY'
                            ? 'CAN STAY IN BAY'
                            : ($infection['infection_type'] ?? '');
                        return ($infection['infection_name'] ?? '') . ' - ' . ucwords(strtolower($infection_type));
                    }, array_values(array_filter($infection_risks, function ($item) {
                        return empty($item['is_primary']) || $item['is_primary'] == 0;
                    })));

                    $primary_infection = array_map(function ($infection) {
                        $infection_type = ($infection['infection_type'] ?? '') === 'CANSTAYINBAY'
                            ? 'CAN STAY IN BAY'
                            : ($infection['infection_type'] ?? '');
                        return ($infection['infection_name'] ?? '') . ' - ' . ucwords(strtolower($infection_type));
                    }, array_values(array_filter($infection_risks, function ($item) {
                        return !empty($item['is_primary']) && $item['is_primary'] == 1;
                    })));

                    $is_infected_count = array_values(array_filter($infection_risks, function ($item) {
                        return $item['is_primary'] == 1 && in_array(strtoupper($item['infection_type'] ?? ''), ['CONFIRMED', 'QUERY']);
                    }));

                    $is_infected = count($is_infected_count) > 0;

                    $primary = null;
                    foreach ($infection_risks as $infection) {
                        if (!empty($infection['is_primary']) && $infection['is_primary'] == 1) {
                            $primary = $infection;
                            break;
                        }
                    }

                    if ($primary && !empty($primary['infection_type'])) {
                        if (in_array(strtoupper($primary['infection_type']), ['CONFIRMED', 'QUERY'])) {
                            $patient_row['is_infected_bg'] = 1;
                        }
                    }

                    if ($primary && !empty($primary['next_review_date'])) {
                        $patient_row['primary_next_review_date'] = PredefinedDateFormatForPD($primary['next_review_date']);
                    }
                } else {
                    $primary_infection = '';
                    $others_infection  = '';
                }

                $patient['is_infected']       = $is_infected ? 1 : 0;
                $patient['is_infected_bg']       = $is_infected ? 1 : 0;
                $patient['primary_infection'] = is_array($primary_infection) ? implode(', ', $primary_infection) : '';
                $patient['others_infection']  = is_array($others_infection) ? implode(', ', $others_infection) : '';


                $patient['patient_wise_flags'] = $others_flag;
                $patient['ibox_bed_status'] = 1;
                $html_view                                                           = View::make('Dashboards.Camis.InfectionControl.Partials.ScubSinglePatient', compact('patient', 'show_on_ward_summary_status_check'));
                $success_array['scub_bed_html']                                      = $html_view->render();

                $html_header                                                           = View::make('Dashboards.Camis.InfectionControl.Partials.ScubwardHeader', compact('patient', 'show_on_ward_summary_status_check'));
                $success_array['scub_bed_header']                                      = $html_header->render();


                $success_array['scub_bed']                                   = 1;
            } else {

                $success_array['scub_bed']                                   = 0;
            }





            $success_array["status"]                                    = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }
    public function RemoveScubPatient(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundScubWard";
        $date_time_now                                              = CurrentDateOnFormat();
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');


        $bed_id                                                     = $request->bed_id ?? '';


        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));

        $ward_controller                                            = new WardSummaryController();
        $functional_identity                                        = 'SCUB Bed';

        if ($user_id != "") {

            $gov_text_before_arr                                    = CamisIboxBoardRoundScubWard::where('bed_id', '=', $bed_id)->first();

            $old_camis_patient_id = optional($gov_text_before_arr)->camis_patient_id;


            $updated_data                                           = CamisIboxBoardRoundScubWard::updateOrCreate(['bed_id' => $bed_id], ['camis_patient_id' => null, 'pas_number' => null, 'admitting_date' => null, 'patient_name' => null, 'patient_gender' => null, 'consultant_name' => null, 'speciality' => null, 'updated_by' => $user_id]);



            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
            $camis_changed = ($old_camis_patient_id !== null && $old_camis_patient_id !== null);

            if ($camis_changed) {
                if ($old_camis_patient_id !== '') {
                    $this->RemovePatientFlagDetails($old_camis_patient_id);
                }
            }
            $success_array["message"]                           = DataUpdatedMessage();
            if (count($updated_data->getChanges()) > 0) {
                $updated_array                                  = $updated_data->getAttributes();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {







                    if ($gov_text_before_arr) {
                        $gov_text_before                        = $gov_text_before_arr->toArray();
                        $gov_text_after_arr                     = CamisIboxBoardRoundScubWard::where('id', '=', $updated_array["id"])->first();
                        $ward_controller->GovernanceBoardRoundUpdatePreCall($old_camis_patient_id, $gov_text_before, 'SCUB Patient Data Removed', $gov_text_after_arr, $functional_identity, 2);
                    }
                }
            }


            $scub_data = CamisIboxBoardRoundScubWard::with(['PatientWiseFlags', 'ReverseBarrier', 'BoardRoundIpcComment'])->where('bed_id', $bed_id)->first();
            $show_on_ward_summary_status_check             = BoardRoundFlagList::where('show_on_normal_ward', 1)->where('show_flag_on_main_ward_summary', '=', 1)->pluck('patient_flag_name', 'patient_flag_stored_name')->toArray();

            if ($scub_data != null) {
                $patient_ward = 'Special Care Baby Unit';
                $patient_ward_type = 'Others';
                $patient['camis_patient_id'] = '';
                $patient['camis_patient_ward'] = 'SCUB';
                $patient['scub_ward_id'] = $scub_data->bed_id ?? 0;
                $patient['ibox_bed_status_camis'] = 'open';
                $patient['ibox_actual_bed_full_name'] = $scub_data->bed_name ?? 'Side Room 01';
                $patient['ibox_bed_status'] = 1;
                $html_view                                                           = View::make('Dashboards.Camis.InfectionControl.Partials.ScubSinglePatient', compact('patient', 'show_on_ward_summary_status_check'));
                $success_array['scub_bed_html']                                      = $html_view->render();
                $success_array['scub_bed']                                   = 1;

                $html_header                                                           = View::make('Dashboards.Camis.InfectionControl.Partials.ScubwardHeader', compact('patient', 'show_on_ward_summary_status_check'));
                $success_array['scub_bed_header']                                      = $html_header->render();
            } else {
                $success_array['scub_bed']                                   = 0;
            }





            $success_array["status"]                                    = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function RemovePatientFlagDetails($camis_patient_id, $patient_flag_name = 'ibox_patient_flag_infection_risk')
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientFlag";
        $ward_controller                                            = new WardSummaryController();


        $patient_details                                            = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', '=', $camis_patient_id)->first();

        $gov_text_before_arr                                    = CamisIboxBoardRoundPatientFlag::where('patient_id', '=', $camis_patient_id)->where('patient_flag_name', $patient_flag_name)->first();




        if (isset($gov_text_before_arr->id) && $gov_text_before_arr->id != '') {
            $master_flag_data                                   = BoardRoundFlagList::where('patient_flag_stored_name', '=', $patient_flag_name)->first();

            if (isset($master_flag_data->id) && $master_flag_data->id != '') {
                $flag_set_name                                  = $master_flag_data->patient_flag_name;
            }



            $gov_text_before_arr->flag_updated_ward = $patient_details->camis_patient_ward_id ?? 0;

            $gov_text_before_arr->save();
            CamisIboxBoardRoundPatientFlag::where('id', '=', $gov_text_before_arr->id)->delete();
            CamisIboxBoardRoundPatientFlagAdditionalInfo::where('patient_flag_id', '=', $gov_text_before_arr->id)->delete();
            $updated_data                                       = $gov_text_before_arr;
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
            $functional_identity                                = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_flag", "ibox_governance_frontend_functional_names");
            $success_array["message"]                           = DataRemovalMessage();
            $gov_text_before                                    = $gov_text_before_arr->toArray();
            $gov_text_after_arr                                 = array();
            $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before,  $flag_set_name, $gov_text_after_arr, $functional_identity, 3);
            $success_array["status"]                            = 1;
            $success_array['sections']                          = '';
            $common_camis_controller                            = new CommonCamisController;
        }


        $reverse_barrier_history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundReverseBarrier";
        $reverse_barrier_gov_text_before_arr                                        = CamisIboxBoardRoundReverseBarrier::where('patient_id', '=', $camis_patient_id)->first();
        if ($reverse_barrier_gov_text_before_arr != null) {
            $history_controller->HistoryTableDataInsertFromDelete($reverse_barrier_gov_text_before_arr->toArray(), $reverse_barrier_history_modal, 3);
            CamisIboxBoardRoundReverseBarrier::where('patient_id', '=', $camis_patient_id)->delete();
            $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $reverse_barrier_gov_text_before_arr->toArray(), '', array(), 'Patient Reverse Barrier', 3);
        }
        $this->RemoveAllInfectionForPatient($camis_patient_id);
        $this->SaveIPCCommentHistory($camis_patient_id, $comment = '');
    }
    public function GetScubPatient(Request $request)
    {
        $scub_patient = CamisIboxBoardRoundScubWard::where('bed_id', $request->camis_bed_id)->first();

        $success_array = [
            'camis_patient_id'   => $scub_patient->camis_patient_id ?? '',
            'pas_number'         => $scub_patient->pas_number ?? '',
            'patient_name'       => $scub_patient->patient_name ?? '',
            'consultant_name'    => $scub_patient->consultant_name ?? '',
            'speciality'         => $scub_patient->speciality ?? '',
            'patient_gender'     => $scub_patient->patient_gender ?? '',
            'admitting_date'     => $scub_patient && $scub_patient->admitting_date
                ? Carbon::parse($scub_patient->admitting_date)->format('Y-m-d H:i')
                : ''
        ];

        return ReturnArrayAsJsonToScript($success_array);
    }


    public function IPCSideRoomPatientFlag(Request $request)
    {
        if (CamisIboxBoardRoundScubWard::where('camis_patient_id', $request->patient_id)->exists()) {
            $ic_sideroom_query = CamisIboxBoardRoundScubWard::with([
                'ReverseBarrier',
                'PatientWiseFlags',
                'BoardRoundIpcComment',
                'InfectionRisks',
            ])
                ->where('camis_patient_id', $request->patient_id)
                ->first();


            $ic_sideroom = $ic_sideroom_query->toArray();
            $all_flag = $ic_sideroom['patient_wise_flags'] ?? [];

            $others_flag = ArrayFilter($all_flag, function ($item) {
                return strtolower($item['patient_flag_name']) != 'ibox_patient_flag_infection_risk';
            });
            $patient['ibox_actual_bed_full_name']          = $ic_sideroom['bed_name'] ?? '--';
            $patient['camis_patient_sex']                  = $ic_sideroom['patient_gender'] ?? '--';
            $patient['camis_patient_id']                   = $ic_sideroom['camis_patient_id'] ?? '--';
            $patient['camis_patient_name']                 = $ic_sideroom['patient_name'] ?? '--';
            $patient['camis_patient_pas_number']           = !empty($ic_sideroom['camis_patient_id']) ? ($ic_sideroom['patient_name'] ?? '--') : '--';
            $patient['camis_consultant_name']              = !empty($ic_sideroom['camis_patient_id']) ? ($ic_sideroom['consultant_name'] ?? '--') : '--';
            $patient['los']                                = !empty($ic_sideroom['camis_patient_id']) ? NumberOfDaysBetweenTwoDates($ic_sideroom['admitting_date'] ?? date('Y-m-d'), date('Y-m-d')) . ' Days' : '--';
            $patient['camis_patient_admission_date_time']  = !empty($ic_sideroom['camis_patient_id']) ? PredefinedDateFormatFor24Hour($ic_sideroom['admitting_date'] ?? '') : '--';
            $patient['ibox_bed_status_camis']              = 'open';
            $patient['infection_risks']                      = $ic_sideroom['infection_risks'] ?? [];
            $infection_flag = ArrayFilter($ic_sideroom['patient_wise_flags'], function ($item) {
                return strtolower($item['patient_flag_name'] ?? '') === 'ibox_patient_flag_infection_risk';
            });

            $is_infected = false;
            $primary_infection = '';
            $others_infection  = '';
            $patient['primary_next_review_date'] = '';
            $patient['is_infected_bg']       = 0;
            $first_flag_key = array_key_first($infection_flag);

            if (!empty($patient['infection_risks'])) {

                $infection_risks = $patient['infection_risks'];

                $others_infection = array_map(function ($infection) {
                    $infection_type = ($infection['infection_type'] ?? '') === 'CANSTAYINBAY'
                        ? 'CAN STAY IN BAY'
                        : ($infection['infection_type'] ?? '');
                    return ($infection['infection_name'] ?? '') . ' - ' . ucwords(strtolower($infection_type));
                }, array_values(array_filter($infection_risks, function ($item) {
                    return empty($item['is_primary']) || $item['is_primary'] == 0;
                })));

                $primary_infection = array_map(function ($infection) {
                    $infection_type = ($infection['infection_type'] ?? '') === 'CANSTAYINBAY'
                        ? 'CAN STAY IN BAY'
                        : ($infection['infection_type'] ?? '');
                    return ($infection['infection_name'] ?? '') . ' - ' . ucwords(strtolower($infection_type));
                }, array_values(array_filter($infection_risks, function ($item) {
                    return !empty($item['is_primary']) && $item['is_primary'] == 1;
                })));

                $is_infected_count = array_values(array_filter($infection_risks, function ($item) {
                    return $item['is_primary'] == 1 && in_array(strtoupper($item['infection_type'] ?? ''), ['CONFIRMED', 'QUERY']);
                }));

                $is_infected = count($is_infected_count) > 0;

                $primary = null;
                foreach ($infection_risks as $infection) {
                    if (!empty($infection['is_primary']) && $infection['is_primary'] == 1) {
                        $primary = $infection;
                        break;
                    }
                }

                if (!empty($primary['infection_type'])) {
                    if (in_array(strtoupper($primary['infection_type']), ['CONFIRMED', 'QUERY'])) {

                        $patient_row['is_infected_bg'] = 1;
                    }
                }
                if (!empty($primary['next_review_date'])) {
                    $patient_row['primary_next_review_date'] = PredefinedDateFormatForPD($primary['next_review_date']);
                }
            } else {
                $primary_infection = '';
                $others_infection  = '';
            }
            $patient['primary_next_review_date'] = $patient_row['primary_next_review_date'] ?? '';
            $patient['is_infected_bg']    = $is_infected ? 1 : 0;
            $patient['is_infected']       = $is_infected ? 1 : 0;
            $patient['primary_infection'] = is_array($primary_infection) ? implode(', ', $primary_infection) : '';
            $patient['others_infection']  = is_array($others_infection) ? implode(', ', $others_infection) : '';
            $patient['patient_wise_flags']                 = $others_flag;
            $show_on_ward_summary_status_check = BoardRoundFlagList::where('show_on_normal_ward', 1)
                ->where('show_flag_on_main_ward_summary', '=', 1)
                ->pluck('patient_flag_name', 'patient_flag_stored_name')
                ->toArray();

            $success_array['is_infected']       = $patient['is_infected'];
            $success_array['is_infected_bg']       = $patient['is_infected_bg'];
            $html_view                                                           = View::make('Dashboards.Camis.InfectionControl.Partials.IPCPatientInfectionIcon', compact('patient', 'show_on_ward_summary_status_check'));
            $success_array['html']                                               = $html_view->render();

            return ReturnArrayAsJsonToScript($success_array);
        } else {
            $ic_sideroom_query = CamisIboxWardPatientInformationWithBedDetailsView::with([
                'PatientWiseFlags' => function ($q) {
                    $q->where('patient_flag_status_value', 1);
                },
                'Ward.PrimaryWardType',
                'IboxBedStatus',
                'ReverseBarrier',
                'BoardRoundIpcComment',
                'InfectionRisks',
            ])
                ->where('camis_patient_id', $request->patient_id)
                ->first();

            if (!$ic_sideroom_query) {

                $patient = [
                    'patient_wise_flags' => [],
                    'ibox_actual_bed_full_name' => '--',
                    'camis_patient_sex' => '--',
                    'camis_patient_id' => $request->patient_id ?? '--',
                    'camis_patient_name' => '--',
                    'camis_patient_pas_number' => '--',
                    'camis_consultant_name' => '--',
                    'los' => '--',
                    'camis_patient_admission_date_time' => '--',
                    'ibox_bed_status_camis' => '--',
                    'is_infected' => 0,
                    'primary_infection' => '',
                    'others_infection' => '',
                    'primary_next_review_date' => '',
                    'camis_patient_ipc_comment' => ''
                ];

                $show_on_ward_summary_status_check = BoardRoundFlagList::where('show_on_normal_ward', 1)
                    ->where('show_flag_on_main_ward_summary', 1)
                    ->pluck('patient_flag_name', 'patient_flag_stored_name')
                    ->toArray();

                return view('Dashboards.Camis.InfectionControl.Partials.IPCPatientInfectionIcon', compact('patient', 'show_on_ward_summary_status_check'));
            }

            $ic_sideroom = $ic_sideroom_query->toArray();
            $all_flag = $ic_sideroom['patient_wise_flags'] ?? [];
            $others_flag = ArrayFilter($all_flag, function ($item) {
                return strtolower($item['patient_flag_name']) != 'ibox_patient_flag_infection_risk';
            });

            $patient['ibox_actual_bed_full_name']          = $ic_sideroom['ibox_actual_bed_full_name'] ?? '--';
            $patient['camis_patient_sex']                  = $ic_sideroom['camis_patient_sex'] ?? '--';
            $patient['camis_patient_id']                   = $ic_sideroom['camis_patient_id'] ?? '--';
            $patient['camis_patient_name']                 = $ic_sideroom['camis_patient_name'] ?? '--';
            $patient['camis_patient_pas_number']           = !empty($ic_sideroom['camis_patient_id']) ? ($ic_sideroom['camis_patient_pas_number'] ?? '--') : '--';
            $patient['camis_consultant_name']              = !empty($ic_sideroom['camis_patient_id']) ? ($ic_sideroom['camis_consultant_name'] ?? '--') : '--';
            $patient['los']                                = !empty($ic_sideroom['camis_patient_id']) ? NumberOfDaysBetweenTwoDates($ic_sideroom['camis_patient_admission_date'] ?? date('Y-m-d'), date('Y-m-d')) . ' Days' : '--';
            $patient['camis_patient_admission_date_time']  = !empty($ic_sideroom['camis_patient_id']) ? PredefinedDateFormatFor24Hour($ic_sideroom['camis_patient_admission_date_time'] ?? '') : '--';
            $patient['ibox_bed_status_camis']              = $ic_sideroom['ibox_bed_status_camis'] ?? '--';
            $patient['camis_patient_ipc_comment']          = $ic_sideroom['board_round_ipc_comment']['comment'] ?? '';
            $patient['infection_risks']                      = $ic_sideroom['infection_risks'] ?? [];
            $infection_flag = ArrayFilter($ic_sideroom['patient_wise_flags'], function ($item) {
                return strtolower($item['patient_flag_name'] ?? '') === 'ibox_patient_flag_infection_risk';
            });

            $is_infected = false;
            $primary_infection = '';
            $others_infection  = '';
            $patient['primary_next_review_date'] = '';
            $patient['is_infected_bg']       = 0;
            $first_flag_key = array_key_first($infection_flag);

            if (!empty($patient['infection_risks'])) {

                $infection_risks = $patient['infection_risks'];

                $others_infection = array_map(function ($infection) {
                    $infection_type = ($infection['infection_type'] ?? '') === 'CANSTAYINBAY'
                        ? 'CAN STAY IN BAY'
                        : ($infection['infection_type'] ?? '');
                    return ($infection['infection_name'] ?? '') . ' - ' . ucwords(strtolower($infection_type));
                }, array_values(array_filter($infection_risks, function ($item) {
                    return empty($item['is_primary']) || $item['is_primary'] == 0;
                })));

                $primary_infection = array_map(function ($infection) {
                    $infection_type = ($infection['infection_type'] ?? '') === 'CANSTAYINBAY'
                        ? 'CAN STAY IN BAY'
                        : ($infection['infection_type'] ?? '');
                    return ($infection['infection_name'] ?? '') . ' - ' . ucwords(strtolower($infection_type));
                }, array_values(array_filter($infection_risks, function ($item) {
                    return !empty($item['is_primary']) && $item['is_primary'] == 1;
                })));

                $is_infected_count = array_values(array_filter($infection_risks, function ($item) {
                    return $item['is_primary'] == 1 && in_array(strtoupper($item['infection_type'] ?? ''), ['CONFIRMED', 'QUERY']);
                }));

                $is_infected = count($is_infected_count) > 0;

                $primary = null;
                foreach ($infection_risks as $infection) {
                    if (!empty($infection['is_primary']) && $infection['is_primary'] == 1) {
                        $primary = $infection;
                        break;
                    }
                }

                if (!empty($primary['infection_type'])) {
                    if (in_array(strtoupper($primary['infection_type']), ['CONFIRMED', 'QUERY'])) {

                        $patient_row['is_infected_bg'] = 1;
                    }
                }
                if (!empty($primary['next_review_date'])) {
                    $patient_row['primary_next_review_date'] = PredefinedDateFormatForPD($primary['next_review_date']);
                }
            } else {
                $primary_infection = '';
                $others_infection  = '';
            }
            $patient['primary_next_review_date'] = $patient_row['primary_next_review_date'] ?? '';
            $patient['is_infected_bg']    = $is_infected ? 1 : 0;
            $patient['is_infected']       = $is_infected ? 1 : 0;
            $patient['primary_infection'] = is_array($primary_infection) ? implode(', ', $primary_infection) : '';
            $patient['others_infection']  = is_array($others_infection) ? implode(', ', $others_infection) : '';
            $patient['patient_wise_flags']                 = $others_flag;
            $show_on_ward_summary_status_check = BoardRoundFlagList::where('show_on_normal_ward', 1)
                ->where('show_flag_on_main_ward_summary', '=', 1)
                ->pluck('patient_flag_name', 'patient_flag_stored_name')
                ->toArray();

            $success_array['is_infected']       = $patient['is_infected'];
            $success_array['is_infected_bg']       = $patient['is_infected_bg'];

            $html_view                                                           = View::make('Dashboards.Camis.InfectionControl.Partials.IPCPatientInfectionIcon', compact('patient', 'show_on_ward_summary_status_check'));
            $success_array['html']                                               = $html_view->render();

            return ReturnArrayAsJsonToScript($success_array);
        }
    }
    public function GetIPCInfectionHistory(Request $request)
    {
        $ipc_infection_history    = HistoryCamisIboxBoardInfectionRisk::where('patient_id', $request->camis_patient_id)->orderBy('updated_at', 'desc')->get()->toArray();





        $users = User::where('status', 1)->pluck('username', 'id')->toArray();
        $updated_status = ['0' => 'Created', '1' => 'Created', '2' => 'Updated', '3' => 'Deleted'];
        $html_view = View::make('Dashboards.Camis.InfectionControl.Partials.InfectionHistory', compact('ipc_infection_history', 'users', 'updated_status'));
        $success_array['history'] = $html_view->render();

        return ReturnArrayAsJsonToScript($success_array);
    }
    public function GetIPCCommentHistory(Request $request)
    {

        $ipc_comment_history    = HistoryCamisIboxBoardRoundIpcComment::where('patient_id', $request->camis_patient_id)->orderBy('updated_at', 'desc')->get()->toArray();
        $users = User::where('status', 1)->pluck('username', 'id')->toArray();
        $updated_status = ['1' => 'Created', '2' => 'Updated', '3' => 'Deleted'];
        $html_view = View::make('Dashboards.Camis.InfectionControl.Partials.IPCCommentHistory', compact('ipc_comment_history', 'users', 'updated_status'));
        $success_array['history'] = $html_view->render();

        return ReturnArrayAsJsonToScript($success_array);
    }
    public function SaveIPCCommentHistory($camis_patient_id, $comment = '')
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundIpcComment";
        $date_time_now                                              = CurrentDateOnFormat();
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["comment"]                                   = $comment;
        $ward_controller                                            = new WardSummaryController();
        $functional_identity                                        = 'IPC Comment';

        if ($camis_patient_id != "" && $user_id != "") {
            if ($comment != '') {
                $gov_text_before_arr                                    = CamisIboxBoardRoundIpcComment::where('patient_id', '=', $camis_patient_id)->first();
                $updated_data                                           = CamisIboxBoardRoundIpcComment::updateOrCreate(['patient_id' => $camis_patient_id], ['comment' => $comment, 'updated_by' => $user_id]);

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundIpcComment::where('id', '=', $updated_array["id"])->first();
                        $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $comment, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {

                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundIpcComment::where('id', '=', $updated_array["id"])->first();
                                $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $comment, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
                $success_array["status"]                                    = 1;
            } else {

                $gov_text_before_arr                                    = CamisIboxBoardRoundIpcComment::where('patient_id', '=', $camis_patient_id)->first();
                if ($gov_text_before_arr) {

                    $updated_data                                    = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromDelete($updated_data->toArray(), $history_modal, 3);
                    $success_array["message"]                        = DataRemovalMessage();
                    $gov_text_before                                 = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                              = array();
                    $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                    CamisIboxBoardRoundIpcComment::where('patient_id', '=', $camis_patient_id)->delete();
                }
            }
        }
        $success_array['ipc_comment'] = CamisIboxBoardRoundIpcComment::where('patient_id', $camis_patient_id)
            ->first()->comment ?? '';
    }
    public function GetSideroomPatients(&$process_array)
    {
        $data_array                                     = array();
        $data_group_array                               = array();
        $ward_short_name                                = $process_array['ward_short_name'];
        $query_type_show                                = $process_array['query_type_show'];


        $ward_list = Wards::with('SecondaryWardType')->where('status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)

            ->orderBy('ward_name', 'asc')
            ->get()->toArray();
        $ward_types_array = [];
        foreach ($ward_list as $ward_type) {
            $ward_types_array[$ward_type['ward_name']] = $ward_type['secondary_ward_type']['ward_type'];
        }
        $ic_sideroom_query                              = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_name', 'ibox_patient_flag_infection_risk')
                    ->where('patient_flag_status_value', 1);
            },
            'InfectionRisks',
        ])
            ->where('ibox_bed_group_name', 'Side Room')
            ->where('ibox_bed_type', 'Bed')
            ->where('ibox_bed_status', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0);

        if ($ward_short_name != "") {
            $ic_sideroom_query->whereIn('ibox_ward_id', $ward_short_name);
        }


        $ic_sideroom_patient_array                      = $ic_sideroom_query->get();

        if (count($ic_sideroom_patient_array) > 0) {
            $data_array       = $ic_sideroom_patient_array->toArray();
            array_unshift($data_array, null);
            unset($data_array[0]);

            $data_collection = collect($data_array);
            $data_group_array = $data_collection->groupBy('ibox_ward_name');

            $updated_data_group_array = collect();
            foreach ($data_group_array as $key => $ward_data) {
                $updated_ward_data = $ward_data->map(function ($pl_data) use ($query_type_show) {
                    if (isset($pl_data['patient_wise_flags'][0])) {
                        $pl_data['ic_patient_flag_name']                        = $pl_data['patient_wise_flags'][0]['patient_flag_name'];
                        $pl_data['ic_patient_flag_status_value']                = $pl_data['patient_wise_flags'][0]['patient_flag_status_value'];

                        $patient_flag_extra_data                                = $pl_data['infection_risks'] ?? [];


                        $primaryTrue = array_values(array_filter($patient_flag_extra_data, function ($item) {
                            return isset($item['is_primary']) && $item['is_primary'] === 1;
                        }));

                        $pl_data['ic_patient_flag_infection_risk_selected_data'] = $primaryTrue['0']['infection_name'] ?? '';
                        $pl_data['ic_patient_flag_infection_risk_reason_id'] = $primaryTrue['0']['infection_type'] ?? '';
                    } else {
                        $pl_data['ic_patient_flag_name']                        = '';
                        $pl_data['ic_patient_flag_status_value']                = '';
                        $pl_data['ic_patient_flag_infection_risk_selected_data']   = '';
                        $pl_data['ic_patient_flag_infection_risk_reason_id']       = '';
                    }
                    if ($query_type_show != '') {
                        if ($query_type_show == 'red' && (strtolower($pl_data['ic_patient_flag_infection_risk_selected_data']) == 'query' || strtolower($pl_data['ic_patient_flag_infection_risk_selected_data']) == 'confirmed')) {
                            return $pl_data;
                        }

                        if ($query_type_show == 'green' && (strtolower($pl_data['ic_patient_flag_infection_risk_selected_data']) != 'query' && strtolower($pl_data['ic_patient_flag_infection_risk_selected_data']) != 'confirmed')) {
                            return $pl_data;
                        }
                    } else {
                        return $pl_data;
                    }
                });

                $updated_ward_data = $updated_ward_data->filter(function ($pl_data) {
                    return $pl_data !== null;
                });

                if (isset($ward_types_array[$key])) {
                    $ward_type = $ward_types_array[$key];
                    $updated_data_group_array[$key] = $updated_ward_data;
                }
            }
        }


        $updated_data_group_array_final = collect([]);

        $updated_data_group_array->each(function ($items, $ward_name) use ($ward_types_array, &$updated_data_group_array_final) {
            $category = $ward_types_array[$ward_name] ?? 'Unknown';

            if (!$updated_data_group_array_final->has($category)) {
                $updated_data_group_array_final[$category] = collect();
            }

            $updated_data_group_array_final[$category][$ward_name] = $items;
        });



        $ic_sideroom_patient_list                           = isset($updated_data_group_array_final) ? $updated_data_group_array_final : [];

        $original_array = $ic_sideroom_patient_list->toArray();
        $ic_sideroom_patient_list = array_filter(
            array_map(
                fn($wards) => array_filter($wards, fn($value) => !empty($value)),
                $original_array
            ),
            fn($wards) => !empty($wards)
        );
        return collect($ic_sideroom_patient_list);
    }

    public function SaveInfectionCloseStatus(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisMasterWardDetails";
        $date_time_now                                              = CurrentDateOnFormat();
        $ward_id                                                    = $request->ward_id;
        $infection_close_status                                     = $request->infection_close_status;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["infection_close_status"]                    = $infection_close_status;

        $default_governance_name                                    =   "Ward";
        $default_governance_field                                   =   "ward_name";
        $default_modal_name                                         =   "App\Models\Iboards\Camis\Master\Wards";

        if ($ward_id != "" && $infection_close_status != "" && $user_id != "") {
            $gov_text_before_arr                                    = Wards::where('id', '=', $ward_id)->first();
            $updated_data                                           = Wards::where('id', $ward_id)->update(['ward_infection_close_status' => $infection_close_status]);
            $success_array["status"]                                = 1;

            if ($updated_data > 0) {
                $updated_array                                      = Wards::where('id', '=', $ward_id)->first()->toArray();
                $history_controller->HistoryTableDataInsertFromUpdate($updated_array, $history_modal, 2);
                $success_array["message"]                           = SystemDataUpdatedMessage();

                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    if ($gov_text_before_arr) {
                        $gov_text_before                            = $gov_text_before_arr->toArray();
                        $gov_text_after_arr                         = $updated_array;
                        $this->GovernanceCamisMasterUpdatePreCall($ward_id, $gov_text_before, $default_governance_name, $default_governance_field, $default_modal_name, $gov_text_after_arr, 2);
                    }
                }
            }
        }
        return $success_array;
    }

    public function ContactTracing()
    {
        if (CheckDashboardPermission('infection_control_covid_contact_tracing_view')) {
            return view('Dashboards.Camis.InfectionControl.ContactTracing');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }


    public function ContactTracingDataload(Request $request)
    {
        $success_array                                  = array();

        $patient_pas_number_filter                          = $request->pas_number ?? '@@@@@@@';
        $patient_name_filter                                = $request->name ?? '@@@@@@@';

        if (in_array($request->tab, ['only_infected', 'all_patients'])) {
            $patientRows = CamisIboxPatientAlertDetails::query()

                ->when($request->filled('search_text'), function ($query) use ($request) {
                    return $query->where(function ($q) use ($request) {
                        $q->where('camis_patient_id', 'like', "%{$request->search_text}%")
                            ->orWhere('camis_patient_name', 'like', "%{$request->search_text}%")
                            ->orWhere('camis_patient_pas_number', 'like', "%{$request->search_text}%");
                    });
                })
                ->when($request->filled('tab') && $request->tab == 'only_infected', function ($q) {
                    $q->whereNotNull('alert_code');
                })
                ->get();
        } else {
            if (!$request->filled('search_text')) {
                $patientRows = CamisIboxPatientAlertDetailsFullList::query()
                    ->whereRaw('0 = 1') // Forces the query to return an empty result set
                    ->get();
            } else {
                $patientRows = CamisIboxPatientAlertDetailsFullList::query()
                    ->when($request->filled('search_text'), function ($query) use ($request) {
                        return $query->where(function ($q) use ($request) {
                            $q->where('camis_patient_id', 'like', "%{$request->search_text}%")
                                ->orWhere('camis_patient_name', 'like', "%{$request->search_text}%")
                                ->orWhere('camis_patient_pas_number', 'like', "%{$request->search_text}%");
                        });
                    })

                    ->get();
            }
        }

        $allWard = Wards::where('status', 1)->pluck('ward_name', 'ward_short_name');

        $patients_list = $patientRows
            ->groupBy('camis_patient_id')
            ->map(function ($rows) use ($allWard) {
                $first = $rows->first();

                return [
                    'camis_patient_ward'                => $first->camis_patient_ward,
                    'camis_patient_id'                  => $first->camis_patient_id,
                    'camis_patient_sex'                  => $first->camis_patient_sex,
                    'camis_patient_name'                => $first->camis_patient_name,
                    'ward_name'                         => $allWard[$first->camis_patient_ward] ?? '--',
                    'bed_name'                          => $first->camis_patient_bed_name,
                    'alert'                             => $rows->pluck('alert_description')->filter()->unique()->implode(', '),
                    'alert_code'                        => $rows->pluck('alert_code')->filter()->unique()->implode(', '),
                    'camis_patient_pas_number'          => $first->camis_patient_pas_number,
                    'camis_patient_discharge_date_time' => (isset($first->camis_patient_discharge_date_time) && !empty($first->camis_patient_discharge_date_time)) ? PredefinedDateFormatFor24Hour($first->camis_patient_discharge_date_time) : '--',
                    'camis_patient_admission_date_time' => PredefinedDateFormatFor24Hour($first->camis_patient_admission_date_time),
                ];
            });

        if ($request->filled('infection')) {
            $infections = (array) $request->infection;

            $patients_list = $patients_list->filter(function ($patient) use ($infections) {
                $alert = $patient['alert'] ?? '';

                foreach ($infections as $infection) {
                    if (stripos($alert, $infection) !== false) {
                        return true;
                    }
                }

                return false;
            });
        }


        if ($request->filled('ward_id')) {
            $ward_ids = (array) $request->ward_id;

            $patients_list = $patients_list->filter(function ($patient) use ($ward_ids) {
                $patient_ward = $patient['camis_patient_ward'] ?? '';


                foreach ($ward_ids as $ward) {
                    if (stripos($patient_ward, $ward) !== false) {

                        return true;
                    }
                }

                return false;
            });
        }


        $patients_list = $patients_list->values()->toArray();

        $patients_list = array_reduce($patients_list, function ($carry, $item) {
            $ward_name = $item['ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($patients_list);


        $success_array['patients_list']                                 = $patients_list;
        $success_array['pas_number_pat_list']                           = json_encode(array_column($patients_list, 'camis_patient_pas_number'));
        $success_array["patient_name_pat_list"]                         = json_encode(array_column($patients_list, 'camis_patient_name'));
        $success_array['all_infections']                                = array_unique(array_column($patientRows->toArray(), 'alert_description'));
        $view                                           = View::make('Dashboards.Camis.InfectionControl.Partials.ContactTracingData', compact('success_array'));
        $sections                                       = $view->render();
        return $sections;
    }

    public function ContactTracingPatient(Request $request)
    {
        $patient_array = [];
        $camis_patient_id = $request->camis_patient_id;
        if (in_array($request->tab, ['only_infected', 'all_patients'])) {
            $query = CamisIboxPatientAlertDetails::where('camis_patient_id', $camis_patient_id)->first();
        } else {
            $query = CamisIboxPatientAlertDetailsFullList::where('camis_patient_id', $camis_patient_id)->first();
        }
        $allWard = Wards::where('status', 1)->pluck('ward_name', 'ward_short_name');
        $patient_alerts = [];
        $patient_details = [];
        $contacts = [];
        $all_contacts = [];
        if ($query) {
            $patient_array =  json_decode(json_encode($query->ContactTracing()), true);

            foreach ($patient_array as $p) {
                $p['ward_name']                         = $p['shared_ward'] ?? null;
                $p['camis_patient_id']                  = $p['camis_patient_id'] ?? null;
                $p['contact_pas_number']                = $p['contact_pas_number'] ?? null;
                $p['camis_contact_patient_sex']         = $p['camis_contact_patient_sex'] ?? null;
                $p['shared_bay_area']                   = $p['shared_bay_area'] ?? null;
                $p['contact_patient_name']              = $p['contact_patient_name'] ?? null;
                $p['index_patient_bed_name']            = $p['index_patient_bed_name'] ?? null;
                $p['contact_patient_bed_name']          = $p['contact_patient_bed_name'] ?? null;
                $p['overlap_minutes']                   = $p['overlap_minutes'] ?? 0;
                $p['camis_patient_discharge_date_time'] = !empty($p['camis_patient_discharge_date_time'])
                    ? PredefinedDateFormatFor24Hour($p['camis_patient_discharge_date_time']) : '--';
                $p['contact_start_time']                = !empty($p['contact_start_time'])
                    ? PredefinedDateFormatFor24Hour($p['contact_start_time']) : '--';
                $p['contact_end_time']                  = !empty($p['contact_end_time'])
                    ? PredefinedDateFormatFor24Hour($p['contact_end_time']) : '--';

                $all_contacts[] = $p;
            }


            $all_cotact_patients = array_column($all_contacts, 'camis_patient_id');

            $all_contact_notes = CamisIboxBoardRoundContactTracingNote::whereIn('patient_id', $all_cotact_patients)
                ->pluck('patient_notes', 'patient_id')
                ->toArray();
            $contacts = array_reduce($all_contacts, function ($carry, $item) {
                $ward_name = $item['ward_name'];

                $carry[$ward_name][] = $item;

                return $carry;
            }, []);
            ksort($contacts);

            $camis_patient_pas_number = $query->camis_patient_pas_number;
            $camis_patient_sex = $query->camis_patient_sex;
            $camis_patient_name = $query->camis_patient_name;
            $camis_patient_ward = $allWard[$query->camis_patient_ward] ?? '--';
            $camis_patient_bed_name = $query->camis_patient_bed_name;

            $camis_admission_date = !empty($query->camis_patient_admission_date_time) ? PredefinedDateFormatFor24Hour($query->camis_patient_admission_date_time) : '--';
            $camis_discharge_date = (isset($query->camis_patient_discharge_date_time) && !empty($query->camis_patient_discharge_date_time)) ? PredefinedDateFormatFor24Hour($query->camis_patient_discharge_date_time) : '--';

            $patient_details = ['camis_patient_sex' => $camis_patient_sex, 'camis_patient_pas_number' => $camis_patient_pas_number, 'camis_patient_name' => $camis_patient_name, 'camis_patient_ward' => $camis_patient_ward, 'camis_patient_bed_name' => $camis_patient_bed_name, 'camis_patient_discharge_date_time' => $camis_discharge_date, 'camis_patient_admission_date_time' => $camis_admission_date];
            $patient_alert = CamisIboxPatientAlertDetails::where('camis_patient_id', $camis_patient_id)
                ->select('alert_description', 'alert_applied', 'alert_refreshed')
                ->get()
                ->toArray();
            foreach ($patient_alert as $alert) {
                $alert['alert_applied'] = PredefinedDateFormatFor24Hour($alert['alert_applied']);
                $alert['alert_refreshed'] = PredefinedDateFormatFor24Hour($alert['alert_refreshed']);
                $alert['alert_name'] = $alert['alert_description'];
                $patient_alerts[] = $alert;
            }
        }
        $view                                           = View::make('Dashboards.Camis.InfectionControl.Partials.ContactTracingOffcanvas', compact('patient_array', 'patient_alerts', 'patient_details', 'contacts', 'all_contacts', 'all_contact_notes'));
        $sections                                       = $view->render();
        return $sections;
    }
    public function GovernanceCamisMasterUpdatePreCall($id, $gov_text_before, $default_governance_name, $default_governance_field, $default_modal_name, $gov_text_after_arr, $operation)
    {
        $gov_data                                               =   array();
        $gov_text_after                                         =   $gov_text_after_arr;

        if ($operation   ==  1) {
            if (isset($gov_text_after["id"])) {
                $gov_data["gov_text_before"]                    = "";
                $gov_data["gov_text_after"]                     = json_encode($gov_text_after);
                $gov_data["gov_updation_status"]                = $operation;
                $gov_data["gov_func_identity"]                  = $default_governance_name;
                $gov_data["gov_description"]                    = $gov_text_after[$default_governance_field];
            }
        }
        if ($operation   ==  2) {
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]                    = json_encode($gov_text_before);
                $gov_data["gov_text_after"]                     = json_encode($gov_text_after);
                $gov_data["gov_updation_status"]                = $operation;
                $gov_data["gov_func_identity"]                  = $default_governance_name;
                $gov_data["gov_description"]                    = $gov_text_after[$default_governance_field];
            }
        }
        if ($operation   ==  3) {
            if (isset($gov_text_after["id"])) {
                $gov_data["gov_text_before"]                    = json_encode($gov_text_after);
                $gov_data["gov_text_after"]                     = "";
                $gov_data["gov_updation_status"]                = $operation;
                $gov_data["gov_func_identity"]                  = $default_governance_name;
                $gov_data["gov_description"]                    = $gov_text_after[$default_governance_field];
            }
        }

        if (!empty($gov_data)) {
            if (count($gov_data) > 0) {
                $governance                 =   new GovernanceController;
                $governance->GovernanceStoreCamisMasterData($gov_data);
            }
        }
    }





    public function UpdatePatientFlagDetails(Request $request)
    {
        $success_array =    array();
        if ($request->update_flag == 1) {
            $ward_summary_controller                                    = new WardSummaryController;
            $history_controller                                         = new HistoryController;
            $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientFlag";
            $date_time_now                                              = CurrentDateOnFormat();

            $camis_patient_id                                           = $request->camis_patient_id;
            $patient_flag_name                                          = $request->patient_flag_name;
            $patient_flag_status_value                                  = $request->patient_flag_status_value;
            $patient_details                                            = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', '=', $camis_patient_id)->first();
            $patient_flag_extra_details_array                           = array();
            $patient_flag_plasma_selected_data                          = $request->patient_flag_plasma_selected_data ?? '';

            if ($patient_flag_plasma_selected_data != '') {
                $patient_flag_extra_details_array['patient_flag_plasma_selected_data'] = $patient_flag_plasma_selected_data;
            }

            if ($request->filled('patient_flag_infection_data')) {
                $infection_list = array_reduce($request->patient_flag_infection_data, function ($carry, $item) {
                    $item['infection_type'] = preg_replace('/[^a-zA-Z0-9]/', '', $item['infection_type']);
                    $carry[] = $item;
                    return $carry;
                }, []);
                foreach ($infection_list as $key => $infection) {
                    $patient_flag_extra_details_array[]  = json_encode($infection);
                }

                $primary_infection = current(array_filter($infection_list, function ($item) {
                    return ($item['is_primary'] == 'true');
                }));
                if ($primary_infection) {
                    if ($primary_infection['infection_type'] == 'CANSTAYINBAY') {
                        $ic_text = 'CAN STAY IN BED';
                    } else {
                        $ic_text = $primary_infection['infection_type'];
                    }
                    $success_array['patient_flag_infection_risk_selected_data'] = ucwords(strtolower($ic_text));
                    $success_array['patient_flag_infection_risk_reason_text'] = $primary_infection['infection_text'];
                }
            }






            $patient_flag_extra_details                                 = json_encode($patient_flag_extra_details_array);
            $success_array["patient_flag_stored_name"]                  = '';
            $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"]                                   = ErrorOccuredMessage();
            $success_array["status"]                                    = 0;

            if ($camis_patient_id != "" && $user_id != "") {
                $gov_text_before_arr                                    = CamisIboxBoardRoundPatientFlag::where('patient_id', '=', $camis_patient_id)->where('patient_flag_name', $patient_flag_name)->first();

                if ($gov_text_before_arr != null) {
                    $updated_data                                           = CamisIboxBoardRoundPatientFlag::updateOrCreate(['patient_id' => $camis_patient_id, 'patient_flag_name' => $patient_flag_name], ['patient_flag_status_value' => $patient_flag_status_value, 'patient_flag_extra_details' => $patient_flag_extra_details, 'updated_by' => $user_id]);
                } else {
                    $updated_data                                           = CamisIboxBoardRoundPatientFlag::updateOrCreate(['patient_id' => $camis_patient_id, 'patient_flag_name' => $patient_flag_name], ['patient_flag_status_value' => $patient_flag_status_value, 'patient_flag_extra_details' => $patient_flag_extra_details, 'flag_created_by' => $user_id, 'flag_created_ward' => $patient_details->camis_patient_ward_id ?? 0, 'flag_updated_ward' => $patient_details->camis_patient_ward_id ?? 0, 'updated_by' => $user_id]);
                }
                $get_id_updated_array                                   = $updated_data->getOriginal();

                if (isset($get_id_updated_array['id']) && $get_id_updated_array['id'] != '') {
                    CamisIboxBoardRoundPatientFlagAdditionalInfo::where('patient_flag_id', '=', $get_id_updated_array['id'])->delete();
                    if (count($patient_flag_extra_details_array) > 0) {
                        $additional_info_array                          = array();
                        $x                                              = 1;
                        foreach ($patient_flag_extra_details_array as $key => $row) {
                            $additional_info_array[$x]['patient_flag_id']                               = $get_id_updated_array['id'];
                            $additional_info_array[$x]['patient_flag_extra_data_field_name']            = $key;
                            $additional_info_array[$x]['patient_flag_extra_data_field_value']           = $row;
                            $x++;
                        }
                        CamisIboxBoardRoundPatientFlagAdditionalInfo::insert($additional_info_array);
                    }
                }

                $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_flag", "ibox_governance_frontend_functional_names");
                $flag_set_name                                          = '';
                $master_flag_data                                       = BoardRoundFlagList::where('patient_flag_stored_name', '=', $patient_flag_name)->first();

                if (isset($master_flag_data->id) && $master_flag_data->id != '') {
                    $flag_set_name                                      = $master_flag_data->patient_flag_name;
                }

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundPatientFlag::where('id', '=', $updated_array["id"])->first();
                        $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $flag_set_name, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundPatientFlag::where('id', '=', $updated_array["id"])->first();
                                $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $flag_set_name, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }

                $success_array["updated_date"]                          = date('jS M Y, H:i', strtotime($date_time_now));
                $success_array["updated_date_show"]                     = date('jS M H:i', strtotime($date_time_now));
                $success_array["patient_flag_stored_name"]              = $patient_flag_name;

                $success_array["status"]                                = 1;
            }
        }


        if ($request->filled('patient_flag_infection_data')) {
            $infection_list = array_reduce($request->patient_flag_infection_data, function ($carry, $item) {
                $item['infection_type'] = preg_replace('/[^a-zA-Z0-9]/', '', $item['infection_type']);
                $carry[] = $item;
                return $carry;
            }, []);
            $total_infection = array_filter($infection_list, function ($item) {
                return in_array($item['action_type'], ['update', 'delete'])
                    && !empty($item['infection_id']);
            });
            $this->UpdateInfectionListForPatient($request->camis_patient_id, $total_infection);
        }




        if ($request->filled('camis_patient_id') && $request->filled('reverse_barrier')) {

            $history_controller                                         = new HistoryController;
            $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundReverseBarrier";
            $date_time_now                                              = CurrentDateOnFormat();
            $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"]                                   = ErrorOccuredMessage();
            $success_array["status"]                                    = 0;
            $patient_reverse_barrier                                       = $request->reverse_barrier;
            $camis_patient_id                                           = $request->camis_patient_id;
            $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["reverse_barrier_status_text"]                  = ($patient_reverse_barrier == 1) ? 'Reverse Barrier Assigned' : 'Reverse Barrier Removed';
            $functional_identity                                        = 'Patient Reverse Barrier';
            $ward_summary_controller                                     = new WardSummaryController;
            if ($camis_patient_id != "" && $user_id != "") {
                $gov_text_before_arr                                    = CamisIboxBoardRoundReverseBarrier::where('patient_id', '=', $camis_patient_id)->first();
                if (!$gov_text_before_arr || $gov_text_before_arr->reverse_barrier_status != 1) {
                    $updated_data                                           = CamisIboxBoardRoundReverseBarrier::updateOrCreate(['patient_id' => $camis_patient_id], ['reverse_barrier_status' => $patient_reverse_barrier, 'updated_by' => $user_id]);
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);


                    if ($updated_data->wasRecentlyCreated) {
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                        $success_array["message"]                           = DataAddedMessage();
                        $updated_array                                      = $updated_data->getOriginal();
                        $gov_text_before                                    = array();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            $gov_text_after_arr                             = CamisIboxBoardRoundReverseBarrier::where('id', '=', $updated_array["id"])->first();
                            $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $success_array["reverse_barrier_status_text"], $gov_text_after_arr, $functional_identity, 1);
                        }
                    } else {

                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                        $success_array["message"]                           = DataUpdatedMessage();
                        if (count($updated_data->getChanges()) > 0) {
                            $updated_array                                  = $updated_data->getOriginal();
                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                if ($gov_text_before_arr) {
                                    $gov_text_before                        = $gov_text_before_arr->toArray();
                                    $gov_text_after_arr                     = CamisIboxBoardRoundReverseBarrier::where('id', '=', $updated_array["id"])->first();
                                    $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $success_array["reverse_barrier_status_text"], $gov_text_after_arr, $functional_identity, 2);
                                }
                            }
                        }
                    }
                } else {

                    $updated_data                                            = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromDelete($updated_data->toArray(), $history_modal, 3);
                    $success_array["message"]                                = DataRemovalMessage();
                    $gov_text_before                                         = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                                      = array();
                    CamisIboxBoardRoundReverseBarrier::where('patient_id', '=', $camis_patient_id)->delete();
                    $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                    $success_array["updated_date"]                           = date('jS M Y, H:i', strtotime($date_time_now));
                    $success_array["status"]                                 = 1;
                }
                $success_array["status"]                                    = 1;
            }
        }
        $this->SaveIPCCommentHistory($camis_patient_id, $request->ipc_comment ?? '');


        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdateInfectionListForPatient($camis_patient_id, $infection)
    {

        if (!is_array($infection) && count($infection) < 1) {
            return;
        }

        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardInfectionRisk";
        $date_time_now                                              = CurrentDateOnFormat();

        $all_infection_id = array_column($infection, 'infection_id');

        $forecasted_infections = CamisIboxBoardRoundInfectionRisk::where('patient_id', '=', $camis_patient_id)
            ->whereNotIn('infection_id', $all_infection_id)
            ->get()
            ->toArray();


        $updated_infection = array_filter($infection, function ($item) {
            return in_array($item['action_type'], ['update'])
                && !empty($item['infection_id']);
        });

        $deleted_infection_form = array_filter($infection, function ($item) {
            return in_array($item['action_type'], ['delete'])
                && !empty($item['infection_id']);
        });
        $deleted_infection = array_merge($forecasted_infections, $deleted_infection_form);

        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $functional_identity                                        = 'Infection Risk';
        $ward_summary_controller                                     = new WardSummaryController;
        $success_array["is_infected"]                                                 = 0;
        $success_array["is_infected_bg"]                                                 = 0;
        if ($camis_patient_id != "" && $user_id != "") {

            foreach ($updated_infection as $inf) {
                $gov_text_before_arr                                    = CamisIboxBoardRoundInfectionRisk::where('patient_id', '=', $camis_patient_id)->where('infection_id',  $inf['infection_id'])->first();
                if ($inf['is_primary'] == 1) {
                    if (in_array($inf['infection_type'], ['CONFIRMED'])) {
                        $success_array["is_infected"]                     = 1;
                        $success_array["is_infected_bg"]                     = 1;
                    }
                }
                $updated_data                                           = CamisIboxBoardRoundInfectionRisk::updateOrCreate(['patient_id' => $camis_patient_id, 'infection_id' => $inf['infection_id']], ['infection_name' => $inf['infection_text'], 'infection_type' => $inf['infection_type'], 'next_review_date' => $inf['next_review_date'], 'is_primary' => $inf['is_primary'], 'updated_by' => $user_id]);


                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundInfectionRisk::where('id', '=', $updated_array["id"])->first();
                        $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Infection Update', $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {

                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundInfectionRisk::where('id', '=', $updated_array["id"])->first();
                                $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Infection Update', $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            }

            foreach ($deleted_infection as $inf) {
                $gov_text_before_arr                                    = CamisIboxBoardRoundInfectionRisk::where('patient_id', '=', $camis_patient_id)->where('infection_id',  $inf['infection_id'])->first();
                if ($gov_text_before_arr) {

                    $updated_data                                            = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromDelete($updated_data->toArray(), $history_modal, 3);
                    $success_array["message"]                                = DataRemovalMessage();
                    $gov_text_before                                         = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                                      = array();
                    CamisIboxBoardRoundInfectionRisk::where('patient_id', '=', $camis_patient_id)->where('infection_id',  $inf['infection_id'])->delete();
                    $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                    $success_array["updated_date"]                           = date('jS M Y, H:i', strtotime($date_time_now));
                    $success_array["status"]                                 = 1;
                }
            }


            $success_array["status"]                                    = 1;
        }
    }


    public function RemoveAllInfectionForPatient($camis_patient_id)
    {
        $deleted_infection = CamisIboxBoardRoundInfectionRisk::where('patient_id', '=', $camis_patient_id)->pluck('infection_id')->toArray();

        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardInfectionRisk";
        $date_time_now                                              = CurrentDateOnFormat();



        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $functional_identity                                        = 'Infection Risk';
        $ward_summary_controller                                     = new WardSummaryController;
        if ($camis_patient_id != "" && $user_id != "") {



            foreach ($deleted_infection as $inf) {
                $gov_text_before_arr                                    = CamisIboxBoardRoundInfectionRisk::where('patient_id', '=', $camis_patient_id)->where('infection_id',  $inf)->first();
                if ($gov_text_before_arr) {

                    $updated_data                                            = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromDelete($updated_data->toArray(), $history_modal, 3);
                    $success_array["message"]                                = DataRemovalMessage();
                    $gov_text_before                                         = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                                      = array();
                    CamisIboxBoardRoundInfectionRisk::where('patient_id', '=', $camis_patient_id)->where('infection_id',  $inf)->delete();
                    $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                    $success_array["updated_date"]                           = date('jS M Y, H:i', strtotime($date_time_now));
                    $success_array["status"]                                 = 1;
                }
            }


            $success_array["status"]                                    = 1;
        }
    }

    public function AssignReverseBarrier(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundReverseBarrier";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->patient_id;
        $patient_reverse_barrier                                   = $request->reverse_barrier;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["reverse_barrier_status_text"]                  = ($patient_reverse_barrier == 1) ? 'Reverse Barrier Assigned' : 'Reverse Barrier Removed';
        $functional_identity                                        = 'Patient Reverse Barrier';
        $ward_summary_controller                                     = new WardSummaryController;
        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundReverseBarrier::where('patient_id', '=', $camis_patient_id)->first();
            if (!$gov_text_before_arr || $gov_text_before_arr->reverse_barrier_status != 1) {
                $updated_data                                           = CamisIboxBoardRoundReverseBarrier::updateOrCreate(['patient_id' => $camis_patient_id], ['reverse_barrier_status' => $patient_reverse_barrier, 'updated_by' => $user_id]);
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);


                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundReverseBarrier::where('id', '=', $updated_array["id"])->first();
                        $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $success_array["reverse_barrier_status_text"], $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {

                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundReverseBarrier::where('id', '=', $updated_array["id"])->first();
                                $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $success_array["reverse_barrier_status_text"], $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            } else {
                CamisIboxBoardRoundReverseBarrier::where('patient_id', '=', $camis_patient_id)->delete();
                $updated_data                                            = $gov_text_before_arr;
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
                $success_array["message"]                                = DataRemovalMessage();
                $gov_text_before                                         = $gov_text_before_arr->toArray();
                $gov_text_after_arr                                      = array();
                $ward_summary_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                $success_array["updated_date"]                           = date('jS M Y, H:i', strtotime($date_time_now));
                $success_array["status"]                                 = 1;
            }
            $success_array["status"]                                    = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function ContactTracingOtherNotes(Request $request)
    {
        $camis_patient_id = $request->camis_patient_id;
        $users = User::pluck('username', 'id')->toArray();
        $history_status = [
            1 => 'Added',
            2 => 'Updated',
            3 => 'Deleted'
        ];
        $current_comment  = CamisIboxBoardRoundContactTracingNote::where('patient_id', $camis_patient_id)->first()->patient_notes ?? '';
        $comments_list = HistoryCamisIboxBoardRoundContactTracingNote::where('patient_id', $camis_patient_id)->orderBy('updated_at', 'desc')->get()->toArray();
        $view                                                           = View::make('Dashboards.Camis.InfectionControl.Partials.ContactTracingNotesData', compact('camis_patient_id', 'comments_list', 'users', 'history_status'));
        $sections                                                       = $view->render();
        $success_array["sections"]                                      = $sections;
        $success_array["current_comment"]                             = $current_comment;
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function ContactTracingSaveOtherNotes(Request $request)
    {

        $history_controller                                         = new HistoryController;
        $ward_controller                                            = new WardSummaryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundContactTracingNote";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_notes                                              = $request->comment;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["patient_notes"]                             = $patient_notes;
        $functional_identity                                        = 'Contact Tracing Notes';

        if ($camis_patient_id != "" && $user_id != "") {
            if ($patient_notes != '') {
                $gov_text_before_arr                                    = CamisIboxBoardRoundContactTracingNote::where('patient_id', '=', $camis_patient_id)->first();
                $updated_data                                           = CamisIboxBoardRoundContactTracingNote::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_notes' => $patient_notes, 'updated_by' => $user_id]);

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundContactTracingNote::where('id', '=', $updated_array["id"])->first();
                        $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_notes, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {

                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundContactTracingNote::where('id', '=', $updated_array["id"])->first();
                                $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_notes, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            } else {
                $gov_text_before_arr                                    = CamisIboxBoardRoundContactTracingNote::where('patient_id', '=', $camis_patient_id)->first();
                if ($gov_text_before_arr) {

                    $updated_data                                    = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromDelete($updated_data->toArray(), $history_modal, 3);
                    $success_array["message"]                        = DataRemovalMessage();
                    $gov_text_before                                 = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                              = array();
                    $ward_controller->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                    CamisIboxBoardRoundContactTracingNote::where('patient_id', '=', $camis_patient_id)->delete();
                }
            }
            $success_array["status"]                                    = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }
}
