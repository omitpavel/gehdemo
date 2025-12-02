<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use App\Http\Controllers\Controller;
use App\Models\History\HistoryCamisIboxBoardWardRound;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPathwayRequirement;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\View\CamisIboxAdmitToday;
use App\Models\Iboards\Camis\View\CamisIboxDischargeToday;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Symphony\Data\OpelCurrentStatus;
use App\Models\Iboards\Symphony\Data\SymphonyAttendanceCalculatedDailyEDSummary;
use App\Models\Iboards\Symphony\View\SymphonyAneAttendanceView;
use App\Models\Iboards\Symphony\View\SymphonyAneDTAPatientView;
use App\Models\Iboards\Symphony\View\SymphonyAneEDNowPatientView;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use App\Models\Iboards\Symphony\View\SymphonyDTAInEDSiteOverview;
use App\Models\Iboards\Symphony\View\SymphonyEDLocationWaitsSiteOverview;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Toastr;

class SiteOverViewController extends Controller
{
    public function Index()
    {

        if (CheckDashboardPermission('flow_dashboard_siteoverview_view')) {
            return view('Dashboards.Camis.SiteOverview.Index');
        } elseif (CheckDashboardPermission('pharmacy_dashboard_view')) {
            return redirect()->route('pharmacy.dashboard');
        } elseif (CheckDashboardPermission('flow_dashboard_red_bed_view') || CheckDashboardPermission('flow_dashboard_redbed_performance_view')) {
            return redirect()->route('red.bed.dashboard');
        }
        //        elseif(CheckDashboardPermission('doctor_at_night_dashboard_view')){
        //            return redirect()->route('doctor.at.night');
        //        }
        elseif (CheckDashboardPermission('leaflet_dashboard_view')) {
            return redirect()->route('virtual.ward.leaflet');
        } elseif (CheckDashboardPermission('stranded_dashboard')) {
            return redirect()->route('site.stranded_patients');
        } elseif (CheckDashboardPermission('r_to_r_view_')) {
            return redirect()->route('reason_reside.dashboard');
        } elseif (CheckDashboardPermission('surgical_wards_dashboard_view')) {
            return redirect()->route('surgical.ward');
        } elseif (CheckDashboardPermission('allowed_to_move_dashboard_view')) {
            return redirect()->route('allowed_to_move.dashboard');
        } elseif (CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')) {
            return redirect()->route('discharges_patient.dashboard');
        } elseif (CheckDashboardPermission('site_office_report_view')) {
            return redirect()->route('site.office');
        } elseif (CheckDashboardPermission('flow_dashboard_patient_search_view')) {
            return redirect()->route('global.patient.search');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function IndexDataLoad(Request $request)
    {
        $specific_date = date('Y-m-d');

        $start_date = date('Y-m-d', strtotime($specific_date . ' -28 days'));

        $common_controller                                  = new CommonController;
        $common_symphony_controller                                                 = new CommonSymphonyController;

        $process_array                                      = array();
        $success_array                                      = array();
        $process_array["start_date"]                        = Carbon::parse($specific_date);
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);
        CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "day");

        $todays_attendence_all_category                                             = SymphonyAttendanceView::whereBetween('symphony_discharge_date', array($process_array["start_date"], $process_array["end_date"]))->orderBy('symphony_discharge_date', 'ASC')->get()->toArray();
        $todays_discharged_all_category                                             = SymphonyAttendanceView::whereBetween('symphony_discharge_date', array($process_array["start_date"], $process_array["end_date"]))->orderBy('symphony_discharge_date', 'ASC')->get()->toArray();
        $process_array['todays_attendence_all_category']                            = $todays_attendence_all_category;
        $process_array['todays_discharged_all_category']                            = $todays_discharged_all_category;

        $discharged_all_admitted_discharged_breached                                = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($process_array['todays_discharged_all_category'], $process_array);

        $common_symphony_controller->GetAnePatientCategorySplitUpArrayWithAtdTypes($todays_attendence_all_category, $process_array);
        $todays_attendence_main_category                                            = $process_array['attendance_arr']['attendance_main'];




        $performance_array                                              = array();
        $performance_array_admitted                                     = $discharged_all_admitted_discharged_breached['admitted_patients'];
        $performance_array_discharged                                   = $discharged_all_admitted_discharged_breached['discharged_patients'];




        $performance_array["total"]                                     = count($todays_attendence_main_category);
        $performance_array["total_discharges"]                          = count($todays_discharged_all_category);
        $performance_array["admitted_count"]                            = count($performance_array_admitted);
        $performance_array["non_admitted_count"]                        = count($performance_array_discharged);
        $performance_array["breach_total"]                              = count($discharged_all_admitted_discharged_breached['breached_patients']);



        $success_array['attendance']['type_1_2_3']                                  = count($todays_attendence_main_category);

        CalculateStartEndDateAccordingSelection($process_array["start_date"], $process_array["end_date"], "last 30 days");
        $last_year_symphony_query                                   = SymphonyAttendanceCalculatedDailyEDSummary::whereBetween('ed_summary_date', [$process_array["start_date"], $process_array["end_date"]])->get()->toArray();
        $yearly_summary_date                                        = EDDailySummaryArrayRearrange($last_year_symphony_query);
        $success_array['symphony_average_attendance']               = 0;
        $success_array['symphony_average_admission']                = 0;

        if (count($yearly_summary_date) > 0) {
            $total_attendance                                       = SumSymphonyDailySUmmary($yearly_summary_date, 'symphony_attendance');
            $success_array['symphony_average_attendance']           = round($total_attendance / 30);
        }




        if ($success_array['attendance']['type_1_2_3'] > $success_array["symphony_average_attendance"]) {
            $success_array["attendance_color"]                      = "#d72626";
            $success_array["attendance_class"]                      = "down-value";
        } else {
            $success_array["attendance_color"]                      = "#0066FF";
            $success_array["attendance_class"]                      = "raise-value";
        }
        $success_array["attendance_difference"]                     = round($success_array['attendance']['type_1_2_3'] - $success_array["symphony_average_attendance"]);


        $success_array['dta_in_ed']                                 = SymphonyDTAInEDSiteOverview::select('val', 'keyvalue')->get()->toArray();
        $ed_location_waits                                          = SymphonyEDLocationWaitsSiteOverview::pluck('val', 'keyvalue')->toArray();


        $success_array['in_ed_corridor']                            = $ed_location_waits['in_ed_corridor'];
        $success_array['in_ambulance_bay']                          = $ed_location_waits['in_ambulance_bay'];
        $success_array['longest_wait_ambulance_bay']                = ConvertMinutesToHourMinutesWithTextFormated($ed_location_waits['longest_wait_ambulance_bay']);



        $process_array["date_last_hour"]                = date('Y-m-d H:i:s', strtotime($process_array["date_time_now"] . '-1 hour'));
        $process_array["ane_today_date_check"]          = date('Y-m-d', strtotime($process_array["date_time_now"]));


        $process_array["attendence_today_all"]          = SymphonyAneAttendanceView::orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
        $all_admitted_discharge_today                   = $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($process_array["attendence_today_all"], $process_array);
        $all_breached_today                             = $common_symphony_controller->GetBreachedArrayProcessFrom240Minutes($process_array["attendence_today_all"], $process_array);
        $all_admitted_breached_today                    = $common_symphony_controller->GetBreachedArrayProcessFrom240Minutes($all_admitted_discharge_today["admitted_patients"], $process_array);
        $all_non_admitted_breached_today                = $common_symphony_controller->GetBreachedArrayProcessFrom240Minutes($all_admitted_discharge_today["discharged_patients"], $process_array);
        $all_arrival_patients_today                     = $common_symphony_controller->PatientsOnSpecificDateArrayProcess($process_array["attendence_today_all"], $process_array, 'symphony_registration_date_time');
        $success_array["top_matrix"]["performance"]["admitted_value"]                       = PerformanceCalculationAne(count($all_admitted_breached_today), count($all_admitted_discharge_today["admitted_patients"]), $process_array["ibox_decimal_places_precise"]);
        $success_array["top_matrix"]["performance"]["nonadmitted_value"]                    = PerformanceCalculationAne(count($all_non_admitted_breached_today), count($all_admitted_discharge_today["discharged_patients"]), $process_array["ibox_decimal_places_precise"]);
        $success_array["top_matrix"]["performance"]["admitted_performance_text_colour"]     = PerformanceShowTextColourSetting($success_array["top_matrix"]["performance"]["admitted_value"]);
        $success_array["top_matrix"]["performance"]["nonadmitted_performance_text_colour"]  = PerformanceShowTextColourSetting($success_array["top_matrix"]["performance"]["nonadmitted_value"]);

        $success_array["top_matrix"]["conversion_rate"]                                     = PercentageCalculationOfValues(count($all_admitted_discharge_today["admitted_patients"]), count($process_array["attendence_today_all"]), $process_array["ibox_decimal_places_precise"]);
        $success_array["top_matrix"]["breaches_value"]                                      = count($all_breached_today);
        $success_array["top_matrix"]["performance_value"]                                   = PerformanceCalculationAne(count($all_breached_today), count($all_admitted_discharge_today["discharged_patients"]), $process_array["ibox_decimal_places_precise"]);
        $success_array["top_matrix"]["performance_text_colour"]                             = PerformanceShowTextColourSetting($success_array["top_matrix"]["performance_value"]);

        $success_array["top_matrix"]["performance_value_guage_colour"]                      = PerformanceShowGuageColourSetting($success_array["top_matrix"]["performance_value"]);;
        $success_array["top_matrix"]["performance_value_guage_border_colour"]               = PerformanceShowGuageBorderColourSetting($success_array["top_matrix"]["performance_value"]);;

        $success_array["still_in_ae_patients_list"]     = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->orderBy('symphony_registration_date_time', 'ASC')->count();





        //camis section


        $all_ward_shown_array = Wards::where('status', 1)->get()->toArray();
        $ward_shown_array = [];
        foreach ($all_ward_shown_array as $ward_shown) {
            if (isset($ward_shown['ward_shown_name']) && !empty($ward_shown['ward_shown_name']) && $ward_shown['ward_shown_name'] != 'AMU') {
                $ward_shown_array[$ward_shown['ward_short_name']] = $ward_shown['ward_shown_name'];
            } else {
                $ward_shown_array[$ward_shown['ward_short_name']] = $ward_shown['ward_name'];
            }
        }

        $wards_to_excludes = Wards::where('ward_bed_matrix_status', 0)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        $other_ward = Wards::where('ward_type_primary', 16)->pluck('ward_short_name')->toArray();
        $wards_to_exclude = array_merge($wards_to_excludes, $other_ward);
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();

        $all_inpatient = CamisIboxWardPatientInformationWithBedDetailsView::whereNotIn('camis_patient_ward', ['RLTDISCHARGE', 'RLTFAU', 'RLTSDECPW', 'RLTSDECIP'])->with(['IboxBedStatus', 'Ward.PrimaryWardType', 'BoardRoundEstimatedDischargeDate', 'BoardRoundLevel', 'BoardRoundMedicallyFitData', 'BoardRoundCdt', 'PotentialDefinite', 'BoardRoundTherapyFitData'])->whereIn('ibox_ward_id', $wards_ids)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('ibox_bed_type', 'Bed')->get()->toArray();

        $filtered_inpatient = [];
        $success_array['discharges']['total_poteintial'] = 0;
        $success_array['discharges']['total_definite'] = 0;
        $success_array['bed'] = [
            'available'   => 0,
            'restrict'    => 0,
            'escalation'  => 0,
            'occupied'    => 0,
            'total'       => 0,
        ];
        $los_0_to_6_medical     = 0;
        $los_0_to_6_surgical    = 0;
        $los_7_to_13_medical    = 0;
        $los_7_to_13_surgical   = 0;
        $los_14_to_20_medical    = 0;
        $los_14_to_20_surgical   = 0;
        $los_21_more_medical    = 0;
        $los_21_more_surgical   = 0;
        $medfit_no_count        = 0;
        $medfit_yes_patient     = array();
        $medfit_cdt_patient = array();
        $medfit_cdt_no_patient = array();
        $board_round_level_0     = 0;
        $board_round_level_1     = 0;
        $board_round_level_2     = 0;
        $board_round_level_3     = 0;


        $therapy_fit_yes = 0;
        $therapy_fit_no = 0;


        foreach ($all_inpatient as $row) {

            if (strtolower($row['ibox_ward_short_name']) == 'rltitu') {
                if (isset($row['board_round_level']['level']) && $row['board_round_level']['level'] == 1) {
                    $board_round_level_0 += 1;
                } elseif (isset($row['board_round_level']['level']) && $row['board_round_level']['level'] == 2) {
                    $board_round_level_1 += 1;
                } elseif (isset($row['board_round_level']['level']) && $row['board_round_level']['level'] == 3) {
                    $board_round_level_2 += 1;
                } elseif (isset($row['board_round_level']['level']) && $row['board_round_level']['level'] == 4) {
                    $board_round_level_3 += 1;
                }
            }
            if (isset($row['potential_definite']['potential_definite_date']) && date('Y-m-d', strtotime($row['potential_definite']['potential_definite_date'])) == $specific_date) {
                if ($row['potential_definite']['type'] == 1) {
                    $success_array['discharges']['total_poteintial']++;
                } elseif ($row['potential_definite']['type'] == 2) {
                    $success_array['discharges']['total_definite']++;
                }
            }

            $ward_name = $row['ibox_ward_short_name'] ?? null;
            $patient_id = $row['camis_patient_id'] ?? null;
            $bed_status = $row['ibox_bed_status']['status'] ?? null;
            $bed_status_camis = strtolower($row['ibox_bed_status_camis'] ?? '');
            $escalation_status = $row['ibox_bed_escalation_status'] ?? null;

            if (!in_array($ward_name, $wards_to_exclude)) {
                if (empty($patient_id) && $bed_status == 1) {
                    continue;
                }

                if ($escalation_status == 1) {
                    $success_array['bed']['escalation']++;
                }
            }
            if (!in_array($ward_name, $wards_to_exclude)) {
                if (!(empty($patient_id) && $bed_status == 1)) {
                    $success_array['bed']['total']++;
                }
            }

            if (!in_array($ward_name, $wards_to_exclude)) {
                $is_skip = empty($patient_id) && $bed_status == 1;

                if (!$is_skip && empty($patient_id) && $bed_status_camis == 'open') {
                    $success_array['bed']['available']++;
                }
            }

            if (!in_array($ward_name, $wards_to_exclude)) {
                if (!empty($patient_id)) {
                    $success_array['bed']['occupied']++;
                }
            }

            if (!in_array($ward_name, $wards_to_exclude)) {
                if (empty($patient_id) && $bed_status == 2) {
                    $success_array['bed']['restrict']++;
                }
            }





            $admissionDate = Carbon::parse($row['camis_patient_admission_date']);
            $length_of_stay = $admissionDate->diffInDays(Carbon::now());


            if (!empty($row['camis_patient_id']) && !in_array($row['ibox_ward_short_name'], $wards_to_exclude)) {

                if ($length_of_stay >= 0 && $length_of_stay <= 6) {
                    if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
                        $los_0_to_6_medical++;
                    } else if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
                        $los_0_to_6_surgical++;
                    }
                } else if ($length_of_stay >= 7 && $length_of_stay <= 13) {
                    if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
                        $los_7_to_13_medical++;
                    } else if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
                        $los_7_to_13_surgical++;
                    }
                } else if ($length_of_stay >= 14 && $length_of_stay <= 20) {
                    if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
                        $los_14_to_20_medical++;
                    } else if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
                        $los_14_to_20_surgical++;
                    }
                } else if ($length_of_stay >= 21) {
                    if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
                        $los_21_more_medical++;
                    } else if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
                        $los_21_more_surgical++;
                    }
                }
            }
            if (!empty($row['camis_patient_id']) && !in_array($row['ibox_ward_short_name'], $wards_to_excludes)) {

                if (isset($row['board_round_therapy_fit_data']['patient_therapy_fit_status']) && $row['board_round_therapy_fit_data']['patient_therapy_fit_status'] == 1) {
                    $therapy_fit_yes++;
                } else {
                    $therapy_fit_no++;
                }

                if (isset($row['board_round_cdt']['cdt_status']) && in_array($row['board_round_cdt']['cdt_status'], [0])) {
                    $medfit_cdt_no_patient[] = $row['camis_patient_id'];
                }
                if (isset($row['board_round_medically_fit_data']['patient_medically_fit_status']) && $row['board_round_medically_fit_data']['patient_medically_fit_status'] == 1) {
                    $medfit_yes_patient[] = $row['camis_patient_id'];




                    if (isset($row['board_round_cdt']['cdt_status']) && in_array($row['board_round_cdt']['cdt_status'], [1])) {
                        $medfit_cdt_patient[] = $row['camis_patient_id'];
                    }
                } else {

                    $medfit_no_count++;
                }
            }
        }















        $success_array['it_level']['level_0']     = $board_round_level_0;
        $success_array['it_level']['level_1']     = $board_round_level_1;
        $success_array['it_level']['level_2']     = $board_round_level_2;
        $success_array['it_level']['level_3']     = $board_round_level_3;
        $success_array['medfit']['medfit_no']     = $medfit_no_count;
        $success_array['medfit']['medfit_yes']    = count($medfit_yes_patient);
        $success_array['therapy']['therapy_yes']     = $therapy_fit_yes;
        $success_array['therapy']['therapy_no']    = $therapy_fit_no;



        $success_array['patient_los']['medical']['los_0_to_6']     = $los_0_to_6_medical;
        $success_array['patient_los']['surgical']['los_0_to_6']    = $los_0_to_6_surgical;
        $success_array['patient_los']['overall']['los_0_to_6']     = ($los_0_to_6_medical + $los_0_to_6_surgical);


        $success_array['patient_los']['medical']['los_7_to_13']    = $los_7_to_13_medical;
        $success_array['patient_los']['surgical']['los_7_to_13']   = $los_7_to_13_surgical;
        $success_array['patient_los']['overall']['los_7_to_13']    = ($los_7_to_13_medical + $los_7_to_13_surgical);

        $success_array['patient_los']['medical']['los_14_to_20']    = $los_14_to_20_medical;
        $success_array['patient_los']['surgical']['los_14_to_20']   = $los_14_to_20_surgical;
        $success_array['patient_los']['overall']['los_14_to_20']    = ($los_14_to_20_medical + $los_14_to_20_surgical);

        $success_array['patient_los']['medical']['los_21_more']    = $los_21_more_medical;
        $success_array['patient_los']['surgical']['los_21_more']   = $los_21_more_surgical;
        $success_array['patient_los']['overall']['los_21_more']    = ($los_21_more_medical + $los_21_more_surgical);


        $pathway_query = CamisIboxBoardRoundPathwayRequirement::selectRaw('dtoc_service_text,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 0%" THEN 1 ELSE 0 END) as p0,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 1%" THEN 1 ELSE 0 END) as p1,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 2%" THEN 1 ELSE 0 END) as p2,
            SUM(CASE WHEN dtoc_pathway_text LIKE  "Pathway 3%" THEN 1 ELSE 0 END) as p3,
            COUNT(*) as total')
            ->whereIn('patient_id', $medfit_cdt_patient)
            ->groupBy('dtoc_service_text');

        $pathway_results = $pathway_query->get();
        $total_p0 = 0;
        $total_p1 = 0;
        $total_p2 = 0;
        $total_p3 = 0;
        foreach ($pathway_results as $result) {
            $service = $result->dtoc_service_text;
            $total_p0 += $result->p0;
            $total_p1 += $result->p1;
            $total_p2 += $result->p2;
            $total_p3 += $result->p3;
        }
        $success_array['medfit']['p0']    = $total_p0;
        $success_array['medfit']['p1']    = $total_p1;
        $success_array['medfit']['p2']    = $total_p2;
        $success_array['medfit']['p3']    = $total_p3;

        $success_array['medfit_cdt_patient'] = count($medfit_cdt_no_patient) + $success_array['medfit']['p0'] + $success_array['medfit']['p1'] + $success_array['medfit']['p2'] + $success_array['medfit']['p3'];





        $ward_list = Wards::whereNotIn('ward_short_name', ['RLTFAU', 'RLTSDECIP', 'RLTSDECPW'])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->with('PrimaryWardType')->orderBy('ward_name', 'asc')->get()->toArray();

        $medical_wards = array();
        $surgical_wards = array();
        $others_without_emergency = array();
        $other_wards = array();
        $surgical_other_wards = array();
        $emergency_wards = array();
        foreach ($ward_list as $item) {



            $ward_type = strtolower($item['primary_ward_type']['ward_type'] ?? '');



            if ($ward_type === 'medical') {
                $medical_wards[] = $item;
            }
            if ($ward_type === 'surgical') {
                $surgical_wards[] = $item;
            }

            if (in_array($item['ward_url_name'], ['rltsauip', 'rltsdecip'])) {
                $emergency_wards[] = $item;
            }

            if ($ward_type === 'others' && !in_array($item['ward_url_name'], ['rltsauip', 'rltsdecip'])) {
                $others_without_emergency[] = $item;
            }
            if ($ward_type === 'others') {
                $other_wards[] = $item;
            }
            if (in_array($ward_type, ['surgical', 'others'])) {
                $surgical_other_wards[] = $item;
            }
        }


        $today_board_round = HistoryCamisIboxBoardWardRound::whereDate('updated_at', $specific_date)->get();

        $board_round_data = [];
        foreach ($today_board_round as $board_round) {
            $ward_id = $board_round->ward_id;

            if (!isset($board_round_data[$ward_id])) {
                $board_round_data[$ward_id]['status'] = 0;
            }

            if ($board_round->status == 1) {
                $board_round_data[$ward_id]['status'] = 1;
            }
        }

        $partial_boardround = [];
        $complete_boardround = [];
        foreach ($board_round_data as $ward_id => $data) {
            if ($data['status'] == 1) {
                $complete_boardround[$ward_id] = true;
            } else {
                $partial_boardround[$ward_id] = true;
            }
        }
        $medical_ids = array_column($medical_wards, 'id');
        $surgical_ids = array_column($surgical_wards, 'id');

        $medical_lookup = array_flip($medical_ids);
        $surgical_lookup = array_flip($surgical_ids);

        $medical_ward_complete_board_round = 0;
        $medical_ward_partial_complete_board_round = 0;
        $medical_ward_not_complete_board_round = 0;

        $surgical_ward_complete_board_round = 0;
        $surgical_ward_partial_complete_board_round = 0;
        $surgical_ward_not_complete_board_round = 0;

        foreach ($ward_list as $ward) {
            $ward_id = $ward['id'];

            $is_medical = isset($medical_lookup[$ward_id]);
            $is_surgical = isset($surgical_lookup[$ward_id]);

            if ($is_medical || $is_surgical) {
                if (isset($partial_boardround[$ward_id])) {
                    if ($is_medical) $medical_ward_partial_complete_board_round++;
                    else $surgical_ward_partial_complete_board_round++;
                } elseif (isset($complete_boardround[$ward_id])) {
                    if ($is_medical) $medical_ward_complete_board_round++;
                    else $surgical_ward_complete_board_round++;
                } else {
                    if ($is_medical) $medical_ward_not_complete_board_round++;
                    else $surgical_ward_not_complete_board_round++;
                }
            }
        }





        $admission_discharge = array();



        $medical_patient_admission_count = [];
        $surgical_patient_admission_count = [];

        $medical_patient_discharge_count = [];
        $surgical_patient_discharge_count = [];
        $success_array['medical_ward_admissions'] = 0;
        $success_array['medical_ward_discharges'] = 0;
        $success_array['surgical_other_ward_admissions'] = 0;
        $success_array['surgical_other_ward_discharges'] = 0;




        $selected_medical_ward_set = array_column($medical_wards, 'ward_short_name');
        $selected_surgical_ward_set = array_column($surgical_wards, 'ward_short_name');
        $selected_emergency_ward_set = array_column($emergency_wards, 'ward_short_name');
        $selected_others_ward_set = array_column($other_wards, 'ward_short_name');
        $selected_surgical_emergency_ward_set = array_merge($selected_surgical_ward_set, $selected_emergency_ward_set);

        $selected_surgical_other_ward_set = array_merge($selected_surgical_emergency_ward_set, $selected_others_ward_set);
        $merged_wards = array_merge($selected_medical_ward_set, $selected_surgical_other_ward_set);
        $medical_wards_chart = [];
        $surgical_other_wards_chart = [];

        foreach ($ward_list as $item) {
            $short_name = $item['ward_short_name'];
            $ward_type = strtolower($item['primary_ward_type']['ward_type'] ?? '');

            if ($item['ward_short_name'] == 'RLTDISCHARGE') {
                $ward_type = 'medical';
            }

            if (isset($selected_medical_ward_set[$short_name]) && $ward_type === 'medical') {

                $medical_wards_chart[] = $item;
            } elseif (isset($selected_surgical_other_ward_set[$short_name]) && in_array($ward_type, ['surgical', 'others'], true)) {
                $surgical_other_wards_chart[] = $item;
            }
        }





        $surgical_other_ward_array_chart = array_map(function ($item) {
            if ($item['ward_shown_name'] == 'AMU') {
                return false;
            }
            return $item['ward_shown_name'] !== null ? $item['ward_shown_name'] : $item['ward_name'];
        }, $surgical_other_wards_chart);

        $medical_wards_array_chart                                        = array_map(function ($item) {
            if ($item['ward_shown_name'] == 'AMU') {
                return false;
            }
            return $item['ward_shown_name'] !== null ? $item['ward_shown_name'] : $item['ward_name'];
        }, $medical_wards_chart);


        foreach ($selected_medical_ward_set as $ward_loop) {
            $medical_patient_admission_discharge_count[$ward_loop]['admission']         = 0;
            $medical_patient_admission_discharge_count[$ward_loop]['discharge']         = 0;
        }


        foreach ($selected_surgical_other_ward_set as $ward_loop) {
            $surgical_patient_admission_discharge_count[$ward_loop]['admission']        = 0;
            $surgical_patient_admission_discharge_count[$ward_loop]['discharge']        = 0;
        }


        $patient_admission_today_list           = CamisIboxAdmitToday::with(['Ward.PrimaryWardType'])->whereBetween('camis_patient_admission_date_time', [$specific_date . ' 00:00:01', $specific_date . ' 23:59:59'])->orderBy('camis_patient_ward', 'ASC')->get()->toArray();
        $patient_discharge_today_list           = CamisIboxDischargeToday::with(['Ward.PrimaryWardType'])->whereBetween('camis_patient_discharge_date', [$specific_date . ' 00:00:01', $specific_date . ' 23:59:59'])->orderBy('camis_patient_ward', 'ASC')->get()->toArray();

        $patient_admit_dischagre_by_hour['medical']['00_11'] = ['admission' => 0, 'discharge' => 0];
        $patient_admit_dischagre_by_hour['medical']['12_15'] = ['admission' => 0, 'discharge' => 0];
        $patient_admit_dischagre_by_hour['medical']['16_24'] = ['admission' => 0, 'discharge' => 0];
        $patient_admit_dischagre_by_hour['surgical']['00_11'] = ['admission' => 0, 'discharge' => 0];
        $patient_admit_dischagre_by_hour['surgical']['12_15'] = ['admission' => 0, 'discharge' => 0];
        $patient_admit_dischagre_by_hour['surgical']['16_24'] = ['admission' => 0, 'discharge' => 0];

        foreach ($patient_discharge_today_list as $discharge_data) {

            if (isset($discharge_data['ward']['primary_ward_type']['ward_type'])) {
                $ward_short_name = $discharge_data['ibox_ward_short_name'];
                $ward_type = strtolower($discharge_data['ward']['primary_ward_type']['ward_type']);
                $admission_type = strtolower($discharge_data['ibox_admission_type_description']);

                if (
                    !isset($discharge_data['ward']) ||
                    !isset($discharge_data['ward']['status'], $discharge_data['ward']['disabled_on_all_dashboard_except_ward_summary']) ||
                    $discharge_data['ward']['status'] != 1 ||
                    $discharge_data['ward']['disabled_on_all_dashboard_except_ward_summary'] != 0
                ) {
                    continue;
                }


                if (strpos($admission_type, 'non-elective') !== false) {

                    if ($ward_type == 'medical') {
                        if (isset($medical_patient_admission_discharge_count[$ward_short_name]['discharge'])) {
                            $medical_patient_admission_discharge_count[$ward_short_name]['discharge']++;
                        }
                        $success_array['medical_ward_discharges']++;
                    } else if ($ward_type == 'surgical' || $ward_type == 'others') {
                        if (isset($surgical_patient_admission_discharge_count[$ward_short_name]['discharge'])) {
                            $surgical_patient_admission_discharge_count[$ward_short_name]['discharge']++;
                        }
                    }
                }
                $camis_patient_discharge_date = $discharge_data['camis_patient_discharge_date'];
                $dateTime = Carbon::parse($camis_patient_discharge_date);
                $hour = $dateTime->hour;

                if (in_array($ward_short_name, $merged_wards)) {

                    if (isset($patient_admit_dischagre_by_hour[$ward_type]) && strpos($admission_type, 'non-elective') !== false) {

                        if ($hour >= 0 && $hour < 12) {
                            $patient_admit_dischagre_by_hour[$ward_type]['00_11']['discharge']++;
                        } elseif ($hour >= 12 && $hour < 16) {
                            $patient_admit_dischagre_by_hour[$ward_type]['12_15']['discharge']++;
                        } else {
                            $patient_admit_dischagre_by_hour[$ward_type]['16_24']['discharge']++;
                        }
                    }
                }
            }
        }

        foreach ($patient_admission_today_list as $admission_data) {
            $ward_short_name = $admission_data['ibox_ward_short_name'];
            $ward_type = strtolower($admission_data['ward']['primary_ward_type']['ward_type']);
            $admission_type = strtolower($admission_data['ibox_admission_type_description']);



            if (
                !isset($admission_data['ward']) ||
                !isset($admission_data['ward']['status'], $admission_data['ward']['disabled_on_all_dashboard_except_ward_summary']) ||
                $admission_data['ward']['status'] != 1 ||
                $admission_data['ward']['disabled_on_all_dashboard_except_ward_summary'] != 0
            ) {
                continue;
            }
            if (strpos($admission_type, 'non-elective') !== false) {
                if ($ward_type == 'medical') {

                    if (isset($medical_patient_admission_discharge_count[$ward_short_name]['admission'])) {

                        $medical_patient_admission_discharge_count[$ward_short_name]['admission']++;
                    }

                    $success_array['medical_ward_admissions']++;
                } else if ($ward_type == 'surgical' || $ward_type == 'others') {
                    if (isset($surgical_patient_admission_discharge_count[$ward_short_name]['admission'])) {
                        $surgical_patient_admission_discharge_count[$ward_short_name]['admission']++;
                    }
                }
            }
            $camis_patient_admission_date = $admission_data['camis_patient_admission_date_time'];
            $dateTime = Carbon::parse($camis_patient_admission_date);
            $hour = $dateTime->hour;
            if (in_array($ward_short_name, $merged_wards)) {
                if (isset($patient_admit_dischagre_by_hour[$ward_type]) && strpos($admission_type, 'non-elective') !== false) {
                    if ($hour >= 0 && $hour < 12) {
                        $patient_admit_dischagre_by_hour[$ward_type]['00_11']['admission']++;
                    } elseif ($hour >= 12 && $hour < 16) {
                        $patient_admit_dischagre_by_hour[$ward_type]['12_15']['admission']++;
                    } else {
                        $patient_admit_dischagre_by_hour[$ward_type]['16_24']['admission']++;
                    }
                }
            }
        }




        $success_array['surgical_patient_admission_discharge_count'] = $surgical_patient_admission_discharge_count;
        $success_array['medical_patient_admission_discharge_count'] = $medical_patient_admission_discharge_count;

        $success_array['row_def_admission_discharge'] = (count($medical_patient_admission_discharge_count) - count($surgical_patient_admission_discharge_count));


        $success_array['medical_ward_array'] = array_map(function ($item) {
            if ($item['ward_shown_name'] == 'AMU') {
                return false;
            }
            return $item['ward_shown_name'] !== null ? $item['ward_shown_name'] : $item['ward_name'];
        }, $medical_wards_chart);


        $success_array['surgical_ward_array'] = array_map(function ($item) {
            if ($item['ward_shown_name'] == 'AMU') {
                return false;
            }
            return $item['ward_shown_name'] !== null ? $item['ward_shown_name'] : $item['ward_name'];
        }, $surgical_other_wards_chart);

        $success_array['ward_shown_array'] = $ward_shown_array;





        $success_array['boardround']['medical']['ward_complete_board_round'] = $medical_ward_complete_board_round;
        $success_array['boardround']['medical']['ward_partial_complete_board_round'] = $medical_ward_partial_complete_board_round;
        $success_array['boardround']['medical']['ward_not_complete_board_round'] = $medical_ward_not_complete_board_round;

        $success_array['boardround']['surgical']['ward_complete_board_round'] = $surgical_ward_complete_board_round;
        $success_array['boardround']['surgical']['ward_partial_complete_board_round'] = $surgical_ward_partial_complete_board_round;
        $success_array['boardround']['surgical']['ward_not_complete_board_round'] = $surgical_ward_not_complete_board_round;

        $success_array['boardround']['overall']['ward_complete_board_round'] = ($medical_ward_complete_board_round + $surgical_ward_complete_board_round);
        $success_array['boardround']['overall']['ward_partial_complete_board_round'] = ($medical_ward_partial_complete_board_round + $surgical_ward_partial_complete_board_round);
        $success_array['boardround']['overall']['ward_not_complete_board_round'] = ($medical_ward_not_complete_board_round + $surgical_ward_not_complete_board_round);
        $success_array['admit_discharge_by_hour'] = $patient_admit_dischagre_by_hour;

        $success_array['ane_opel_status'] = ['opel' => 0, 'status' => 0];
        $success_array['ward_opel_status'] = ['opel' => 0, 'status' => 0];

        $success_array['ane_opel_status'] = ['opel' => GetANEOpelStatus(), 'status' => 1];
        $ward_opel_status = OpelCurrentStatus::where('ane_opel_status_data_type', 2)->first();
        $success_array['ward_opel_status'] = ['opel' => $ward_opel_status->ane_opel_status_data ?? 0, 'status' => $ward_opel_status->ane_opel_status_data_show_status ?? 0];
        $success_array = json_decode(file_get_contents('demo_data/inpatient/site_overview_index_data.json'), true);
        return view('Dashboards.Camis.SiteOverview.IndexDataLoad', compact('success_array'));
    }


    public function BedWisePatientList(Request $request)
    {
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();
        $patient_list = CamisIboxWardPatientInformationWithBedDetailsView::with(['IboxBedStatus', 'Ward.PrimaryWardType', 'BoardRoundEstimatedDischargeDate', 'BoardRoundLevel', 'BoardRoundMedicallyFitData', 'BoardRoundCdt', 'PotentialDefinite', 'BoardRoundPathwayRequirement', 'BoardRoundTherapyFitData'])->whereIn('ibox_ward_id', $wards_ids)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('ibox_bed_type', 'Bed')->get()->toArray();
        $wards_to_excludes = Wards::where('ward_bed_matrix_status', 0)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();
        $other_ward = Wards::where('ward_type_primary', 16)->pluck('ward_short_name')->toArray();
        $wards_to_exclude = array_merge($wards_to_excludes, $other_ward);
        $ward_list = Wards::whereNotIn('ward_short_name', ['RLTFAU', 'RLTSDECIP', 'RLTSDECPW'])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->with('PrimaryWardType')->orderBy('ward_name', 'asc')->get()->toArray();

        $medical_wards = array();
        $surgical_wards = array();
        $others_without_emergency = array();
        $other_wards = array();
        $surgical_other_wards = array();
        $emergency_wards = array();
        foreach ($ward_list as $item) {



            $ward_type = strtolower($item['primary_ward_type']['ward_type'] ?? '');



            if ($ward_type === 'medical') {
                $medical_wards[] = $item;
            }
            if ($ward_type === 'surgical') {
                $surgical_wards[] = $item;
            }

            if (in_array($item['ward_url_name'], ['rltsauip', 'rltsdecip'])) {
                $emergency_wards[] = $item;
            }

            if ($ward_type === 'others' && !in_array($item['ward_url_name'], ['rltsauip', 'rltsdecip'])) {
                $others_without_emergency[] = $item;
            }
            if ($ward_type === 'others') {
                $other_wards[] = $item;
            }
            if (in_array($ward_type, ['surgical', 'others'])) {
                $surgical_other_wards[] = $item;
            }
        }

        $selected_medical_ward_set = array_column($medical_wards, 'ward_short_name');
        $selected_surgical_ward_set = array_column($surgical_wards, 'ward_short_name');
        $selected_emergency_ward_set = array_column($emergency_wards, 'ward_short_name');
        $selected_others_ward_set = array_column($other_wards, 'ward_short_name');
        $selected_surgical_emergency_ward_set = array_merge($selected_surgical_ward_set, $selected_emergency_ward_set);

        $selected_surgical_other_ward_set = array_merge($selected_surgical_emergency_ward_set, $selected_others_ward_set);
        $merged_wards = array_merge($selected_medical_ward_set, $selected_surgical_other_ward_set);
        //$patient_list = [];

        // foreach ($all_inpatient as $row) {
        //     $ward_name = $row['ibox_ward_short_name'] ?? null;
        //     $patient_id = $row['camis_patient_id'] ?? null;
        //     $bed_status = $row['ibox_bed_status']['status'] ?? null;
        //     $bed_status_camis = strtolower($row['ibox_bed_status_camis'] ?? '');
        //     $escalation_status = $row['ibox_bed_escalation_status'] ?? null;
        //     $ward_short_name = $row['ibox_ward_short_name'];
        //     if (!$request->filled('type')) {
        //         continue;
        //     }
        //     if ($request->type == 'all') {
        //         if (!in_array($ward_name, $wards_to_exclude)) {
        //             if (!(empty($patient_id) && $bed_status == 1)) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'empty') {
        //         if (!in_array($ward_name, $wards_to_exclude)) {
        //             $is_skip = empty($patient_id) && $bed_status == 1;

        //             if (!$is_skip && empty($patient_id) && $bed_status_camis == 'open') {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'occupied') {
        //         if (!in_array($ward_name, $wards_to_exclude)) {
        //             if (!empty($patient_id)) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'escalation') {
        //         if (!in_array($ward_name, $wards_to_exclude)) {
        //             if (empty($patient_id) && $bed_status == 1) {
        //                 continue;
        //             }

        //             if ($escalation_status == 1) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'restricted') {
        //         if (!in_array($ward_name, $wards_to_exclude)) {
        //             if (empty($patient_id) && $bed_status == 2) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'definite') {
        //         if (isset($row['potential_definite']['potential_definite_date']) && date('Y-m-d', strtotime($row['potential_definite']['potential_definite_date'])) == date('Y-m-d')) {
        //             if ($row['potential_definite']['type'] == 2) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'potential') {
        //         if (isset($row['potential_definite']['potential_definite_date']) && date('Y-m-d', strtotime($row['potential_definite']['potential_definite_date'])) == date('Y-m-d')) {
        //             if ($row['potential_definite']['type'] == 1) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'itu_1') {
        //         if (strtolower($row['ibox_ward_short_name']) == 'rltitu') {
        //             if (isset($row['board_round_level']['level']) && $row['board_round_level']['level'] == 2) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'itu_2') {
        //         if (strtolower($row['ibox_ward_short_name']) == 'rltitu') {
        //             if (isset($row['board_round_level']['level']) && $row['board_round_level']['level'] == 3) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'itu_3') {
        //         if (strtolower($row['ibox_ward_short_name']) == 'rltitu') {
        //             if (isset($row['board_round_level']['level']) && $row['board_round_level']['level'] == 4) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'pathway_0') {
        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_excludes) &&
        //             ($row['board_round_cdt']['cdt_status'] ?? null) == 1 &&
        //             ($row['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null) == 1 &&
        //             stripos($row['board_round_pathway_requirement']['dtoc_pathway_text'] ?? '', 'pathway 0') !== false
        //         ) {
        //             $patient_list[] = $row;
        //         }
        //     } elseif ($request->type == 'pathway_1') {
        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_excludes) &&
        //             ($row['board_round_cdt']['cdt_status'] ?? null) == 1 &&
        //             ($row['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null) == 1 &&
        //             stripos($row['board_round_pathway_requirement']['dtoc_pathway_text'] ?? '', 'pathway 1') !== false
        //         ) {
        //             $patient_list[] = $row;
        //         }
        //     } elseif ($request->type == 'pathway_2') {
        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_excludes) &&
        //             ($row['board_round_cdt']['cdt_status'] ?? null) == 1 &&
        //             ($row['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null) == 1 &&
        //             stripos($row['board_round_pathway_requirement']['dtoc_pathway_text'] ?? '', 'pathway 2') !== false
        //         ) {
        //             $patient_list[] = $row;
        //         }
        //     } elseif ($request->type == 'pathway_3') {
        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_excludes) &&
        //             ($row['board_round_cdt']['cdt_status'] ?? null) == 1 &&
        //             ($row['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null) == 1 &&
        //             stripos($row['board_round_pathway_requirement']['dtoc_pathway_text'] ?? '', 'pathway 3') !== false
        //         ) {
        //             $patient_list[] = $row;
        //         }
        //     } elseif ($request->type == 'medfit_yes') {
        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_excludes) &&
        //             ($row['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null) == 1
        //         ) {
        //             $patient_list[] = $row;
        //         }
        //     } elseif ($request->type == 'therapy_yes') {
        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_excludes) &&
        //             ($row['board_round_therapy_fit_data']['patient_therapy_fit_status'] ?? null) == 1
        //         ) {
        //             $patient_list[] = $row;
        //         }
        //     } elseif ($request->type == 'medfit_no') {
        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_excludes)
        //         ) {
        //             $isMedicallyFit = $row['board_round_medically_fit_data']['patient_medically_fit_status'] ?? null;

        //             if ($isMedicallyFit != 1) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif ($request->type == 'therapy_no') {
        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_excludes)
        //         ) {
        //             $isMedicallyFit = $row['board_round_therapy_fit_data']['patient_therapy_fit_status'] ?? null;

        //             if ($isMedicallyFit != 1) {
        //                 $patient_list[] = $row;
        //             }
        //         }
        //     } elseif (stripos($request->type ?? '', 'los_') !== false) {
        //         $admissionDate = Carbon::parse($row['camis_patient_admission_date']);
        //         $length_of_stay = $admissionDate->diffInDays(Carbon::now());
        //         $los_string = explode('_', $request->type);
        //         $ward_type = end($los_string);
        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_exclude)
        //         ) {

        //             if (stripos($request->type ?? '', 'los_0_6') !== false) {
        //                 if ($length_of_stay >= 0 && $length_of_stay <= 6 && $ward_type == 'medical') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
        //                         $patient_list[] = $row;
        //                     }
        //                 } elseif ($length_of_stay >= 0 && $length_of_stay <= 6 && $ward_type == 'surgical') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
        //                         $patient_list[] = $row;
        //                     }
        //                 } elseif ($length_of_stay >= 0 && $length_of_stay <= 6 && $ward_type == 'all') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == ['surgical', 'medical']) {
        //                         $patient_list[] = $row;
        //                     }
        //                 }
        //             } elseif (stripos($request->type ?? '', 'los_7_13') !== false) {
        //                 if ($length_of_stay >= 7 && $length_of_stay <= 13 && $ward_type == 'medical') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
        //                         $patient_list[] = $row;
        //                     }
        //                 } elseif ($length_of_stay >= 7 && $length_of_stay <= 13 && $ward_type == 'surgical') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
        //                         $patient_list[] = $row;
        //                     }
        //                 } elseif ($length_of_stay >= 7 && $length_of_stay <= 13 && $ward_type == 'all') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && in_array(strtolower($row['ward']['primary_ward_type']['ward_type']), ['surgical', 'medical'])) {
        //                         $patient_list[] = $row;
        //                     }
        //                 }
        //             } elseif (stripos($request->type ?? '', 'los_14_20') !== false) {
        //                 if ($length_of_stay >= 14 && $length_of_stay <= 20 && $ward_type == 'medical') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
        //                         $patient_list[] = $row;
        //                     }
        //                 } elseif ($length_of_stay >= 14 && $length_of_stay <= 20 && $ward_type == 'surgical') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
        //                         $patient_list[] = $row;
        //                     }
        //                 } elseif ($length_of_stay >= 14 && $length_of_stay <= 20 && $ward_type == 'all') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && in_array(strtolower($row['ward']['primary_ward_type']['ward_type']), ['surgical', 'medical'])) {
        //                         $patient_list[] = $row;
        //                     }
        //                 }
        //             } elseif (stripos($request->type ?? '', 'los_21_plus') !== false) {
        //                 if ($length_of_stay >= 21 && $ward_type == 'medical') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
        //                         $patient_list[] = $row;
        //                     }
        //                 } elseif ($length_of_stay >= 21 && $ward_type == 'surgical') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
        //                         $patient_list[] = $row;
        //                     }
        //                 } elseif ($length_of_stay >= 21 && $ward_type == 'all') {
        //                     if (isset($row['ward']['primary_ward_type']['ward_type']) && in_array(strtolower($row['ward']['primary_ward_type']['ward_type']), ['surgical', 'medical'])) {
        //                         $patient_list[] = $row;
        //                     }
        //                 }
        //             }
        //         }
        //     } elseif (stripos($request->type ?? '', 'admit_') !== false) {
        //         $admit_string = explode('_', $request->type);
        //         $ward_type = end($admit_string);
        //         $admission_type = strtolower($row['ip_admission_type_description']);
        //         $camis_patient_admission_date = $row['camis_patient_admission_date_time'];
        //         $dateTime = Carbon::parse($camis_patient_admission_date);
        //         $hour = $dateTime->hour;
        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_exclude)
        //         ) {
        //             if (in_array($ward_short_name, $merged_wards)) {
        //                 if (strpos($admission_type, 'non-elective') !== false && $dateTime->isToday()) {
        //                     if (stripos($request->type ?? '', 'admit_00_11') !== false) {
        //                         if ($hour >= 0 && $hour <= 12 && $ward_type == 'medical') {
        //                             if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
        //                                 $patient_list[] = $row;
        //                             }
        //                         } elseif ($hour >= 0 && $hour <= 12 && $ward_type == 'surgical') {
        //                             if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
        //                                 $patient_list[] = $row;
        //                             }
        //                         } elseif ($hour >= 0 && $hour <= 12 && $ward_type == 'all') {
        //                             if (isset($row['ward']['primary_ward_type']['ward_type']) && in_array(strtolower($row['ward']['primary_ward_type']['ward_type']), ['surgical', 'medical'])) {
        //                                 $patient_list[] = $row;
        //                             }
        //                         }
        //                     } elseif (stripos($request->type ?? '', 'admit_12_15') !== false) {
        //                         if ($hour >= 12 && $hour <= 15 && $ward_type == 'medical') {
        //                             if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
        //                                 $patient_list[] = $row;
        //                             }
        //                         } elseif ($hour >= 12 && $hour <= 15 && $ward_type == 'surgical') {
        //                             if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
        //                                 $patient_list[] = $row;
        //                             }
        //                         } elseif ($hour >= 12 && $hour <= 15 && $ward_type == 'all') {
        //                             if (isset($row['ward']['primary_ward_type']['ward_type']) && in_array(strtolower($row['ward']['primary_ward_type']['ward_type']), ['surgical', 'medical'])) {
        //                                 $patient_list[] = $row;
        //                             }
        //                         }
        //                     } elseif (stripos($request->type ?? '', 'admit_16_23') !== false) {
        //                         if ($hour >= 16 && $hour <= 23 && $ward_type == 'medical') {
        //                             if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'medical') {
        //                                 $patient_list[] = $row;
        //                             }
        //                         } elseif ($hour >= 16 && $hour <= 23 && $ward_type == 'surgical') {
        //                             if (isset($row['ward']['primary_ward_type']['ward_type']) && strtolower($row['ward']['primary_ward_type']['ward_type']) == 'surgical') {
        //                                 $patient_list[] = $row;
        //                             }
        //                         } elseif ($hour >= 16 && $hour <= 23 && $ward_type == 'all') {
        //                             if (isset($row['ward']['primary_ward_type']['ward_type']) && in_array(strtolower($row['ward']['primary_ward_type']['ward_type']), ['surgical', 'medical'])) {
        //                                 $patient_list[] = $row;
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     } elseif (stripos($request->type ?? '', 'overall_inpatient_') !== false) {
        //         $admit_string = explode('_', $request->type);
        //         $ward = end($admit_string);
        //         $admission_type = strtolower($row['ip_admission_type_description']);
        //         $camis_patient_admission_date = $row['camis_patient_admission_date_time'];
        //         $dateTime = Carbon::parse($camis_patient_admission_date);

        //         if (
        //             !empty($row['camis_patient_id']) &&
        //             !in_array($row['ibox_ward_short_name'] ?? '', $wards_to_exclude)
        //         ) {
        //             if (strpos($admission_type, 'non-elective') !== false && $dateTime->isToday()) {
        //                 if ($row['ibox_ward_short_name'] == $ward) {
        //                     $patient_list[] = $row;
        //                 }
        //             }
        //         }
        //     }
        // }
        $ward_wise_patient = array_reduce($patient_list, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($ward_wise_patient);
        if ($request->filled('data_type') && $request->data_type == 'bed_only') {
            $view = View::make('Dashboards.Camis.SiteOverview.Partials.PatientEmptyBed', compact('ward_wise_patient'));
        } else {
            $view = View::make('Dashboards.Camis.SiteOverview.Partials.PatientOffcanvasData', compact('ward_wise_patient'));
        }

        return $view->render();
    }


    public function MedfitPatientPatientList(Request $request)
    {
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();
        $patient_list = CamisIboxWardPatientInformationWithBedDetailsView::with(['IboxBedStatus', 'Ward.PrimaryWardType', 'BoardRoundEstimatedDischargeDate', 'BoardRoundLevel', 'BoardRoundMedicallyFitData', 'BoardRoundCdt', 'PotentialDefinite', 'BoardRoundPathwayRequirement', 'BoardRoundTherapyFitData'])->whereIn('ibox_ward_id', $wards_ids)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('ibox_bed_type', 'Bed')->get()->toArray();
        $wards_to_excludes = Wards::where('ward_bed_matrix_status', 0)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();
        $other_ward = Wards::where('ward_type_primary', 16)->pluck('ward_short_name')->toArray();
        $wards_to_exclude = array_merge($wards_to_excludes, $other_ward);

        //$patient_list = [];

        // foreach ($all_inpatient as $row) {
        //     $ward_name = $row['ibox_ward_short_name'] ?? null;
        //     $patient_id = $row['camis_patient_id'] ?? null;
        //     $bed_status = $row['ibox_bed_status']['status'] ?? null;
        //     $bed_status_camis = strtolower($row['ibox_bed_status_camis'] ?? '');
        //     $escalation_status = $row['ibox_bed_escalation_status'] ?? null;
        //     $board_round_cdt = $row['board_round_cdt']['cdt_status'] ?? 0;
        //     $board_round_medfit = $row['board_round_medically_fit_data']['patient_medically_fit_status'] ?? 0;
        //     $board_round_therapy = $row['board_round_therapy_fit_data']['patient_therapy_fit_status'] ?? 0;

        //     if (empty($patient_id) || in_array($ward_name, $wards_to_exclude)) {
        //         continue;
        //     }

        //     $medfit_required = (int) $request->medfit;
        //     if ((int) $board_round_medfit != $medfit_required) {
        //         continue;
        //     }

        //     if ($request->filled('cdt_status')) {
        //         if ($request->cdt_status == 'cdt_yes') {
        //             if ($board_round_cdt != 1) {
        //                 continue;
        //             }
        //         }

        //         if ($request->cdt_status == 'cdt_no') {
        //             if ($board_round_cdt == 1) {
        //                 continue;
        //             }
        //         }
        //     }
        //     if ($request->filled('therapy_status')) {

        //         if ($request->therapy_status == 'therapy_yes') {
        //             if ($board_round_therapy != 1) {
        //                 continue;
        //             }
        //         }

        //         if ($request->therapy_status == 'therapy_no') {
        //             if ($board_round_therapy == 1) {
        //                 continue;
        //             }
        //         }
        //     }

        //     $patient_list[] = $row;
        // }


        $ward_wise_patient = array_reduce($patient_list, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($ward_wise_patient);
        $view = View::make('Dashboards.Camis.SiteOverview.Partials.MedfitCDTPatientList', compact('ward_wise_patient'));
        return $view->render();
    }


    public function TherapyPatientPatientList(Request $request)
    {
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();
        $patient_list = CamisIboxWardPatientInformationWithBedDetailsView::with(['IboxBedStatus', 'Ward.PrimaryWardType', 'BoardRoundEstimatedDischargeDate', 'BoardRoundLevel', 'BoardRoundMedicallyFitData', 'BoardRoundCdt', 'PotentialDefinite', 'BoardRoundPathwayRequirement', 'BoardRoundTherapyFitData'])->whereIn('ibox_ward_id', $wards_ids)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('ibox_bed_type', 'Bed')->get()->toArray();
        $wards_to_excludes = Wards::where('ward_bed_matrix_status', 0)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();
        $other_ward = Wards::where('ward_type_primary', 16)->pluck('ward_short_name')->toArray();
        $wards_to_exclude = array_merge($wards_to_excludes, $other_ward);

        $patient_list = [];

        // foreach ($all_inpatient as $row) {
        //     $ward_name = $row['ibox_ward_short_name'] ?? null;
        //     $patient_id = $row['camis_patient_id'] ?? null;
        //     $bed_status = $row['ibox_bed_status']['status'] ?? null;
        //     $bed_status_camis = strtolower($row['ibox_bed_status_camis'] ?? '');
        //     $escalation_status = $row['ibox_bed_escalation_status'] ?? null;
        //     $board_round_cdt = $row['board_round_cdt']['cdt_status'] ?? 0;
        //     $board_round_medfit = $row['board_round_medically_fit_data']['patient_medically_fit_status'] ?? 0;
        //     $board_round_therapy = $row['board_round_therapy_fit_data']['patient_therapy_fit_status'] ?? 0;
        //     if (empty($patient_id) || in_array($ward_name, $wards_to_exclude)) {
        //         continue;
        //     }

        //     $therapy_required = (int) $request->therapy;
        //     if ((int) $board_round_therapy != $therapy_required) {
        //         continue;
        //     }

        //     if ($request->filled('cdt_status')) {
        //         if ($request->cdt_status == 'cdt_yes') {
        //             if ($board_round_cdt != 1) {
        //                 continue;
        //             }
        //         }

        //         if ($request->cdt_status == 'cdt_no') {
        //             if ($board_round_cdt == 1) {
        //                 continue;
        //             }
        //         }
        //     }
        //     if ($request->filled('medfit_status')) {

        //         if ($request->medfit_status == 'medfit_yes') {
        //             if ($board_round_medfit != 1) {
        //                 continue;
        //             }
        //         }

        //         if ($request->medfit_status == 'medfit_no') {
        //             if ($board_round_medfit == 1) {
        //                 continue;
        //             }
        //         }
        //     }




        //     $patient_list[] = $row;
        // }

        $ward_wise_patient = array_reduce($patient_list, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($ward_wise_patient);
        $view = View::make('Dashboards.Camis.SiteOverview.Partials.TherapyCDTPatientList', compact('ward_wise_patient'));
        return $view->render();
    }

    public function DischargePatientList(Request $request)
    {
        $all_wards = Wards::pluck('ward_name', 'ward_short_name')->toArray();
        $specific_date = date('Y-m-d');
        $ward_list = Wards::whereNotIn('ward_short_name', ['RLTFAU', 'RLTSDECIP', 'RLTSDECPW'])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->with('PrimaryWardType')->orderBy('ward_name', 'asc')->get()->toArray();

        $medical_wards = array();
        $surgical_wards = array();
        $others_without_emergency = array();
        $other_wards = array();
        $surgical_other_wards = array();
        $emergency_wards = array();
        foreach ($ward_list as $item) {



            $ward_type = strtolower($item['primary_ward_type']['ward_type'] ?? '');



            if ($ward_type === 'medical') {
                $medical_wards[] = $item;
            }
            if ($ward_type === 'surgical') {
                $surgical_wards[] = $item;
            }

            if (in_array($item['ward_url_name'], ['rltsauip', 'rltsdecip'])) {
                $emergency_wards[] = $item;
            }

            if ($ward_type === 'others' && !in_array($item['ward_url_name'], ['rltsauip', 'rltsdecip'])) {
                $others_without_emergency[] = $item;
            }
            if ($ward_type === 'others') {
                $other_wards[] = $item;
            }
            if (in_array($ward_type, ['surgical', 'others'])) {
                $surgical_other_wards[] = $item;
            }
        }

        $selected_medical_ward_set = array_column($medical_wards, 'ward_short_name');
        $selected_surgical_ward_set = array_column($surgical_wards, 'ward_short_name');
        $selected_emergency_ward_set = array_column($emergency_wards, 'ward_short_name');
        $selected_others_ward_set = array_column($other_wards, 'ward_short_name');
        $selected_surgical_emergency_ward_set = array_merge($selected_surgical_ward_set, $selected_emergency_ward_set);

        $selected_surgical_other_ward_set = array_merge($selected_surgical_emergency_ward_set, $selected_others_ward_set);
        $merged_wards = array_merge($selected_medical_ward_set, $selected_surgical_other_ward_set);
        $patient_list           = CamisIboxDischargeToday::with(['Ward.PrimaryWardType', 'PatientInformation'])->orderBy('camis_patient_ward', 'ASC')->get()->toArray();
        //$patient_list = [];
        // foreach ($patient_discharge_today_list as $discharge_data) {
        //     if (isset($discharge_data['ward']['primary_ward_type']['ward_type'])) {
        //         $ward_short_name = $discharge_data['ibox_ward_short_name'];
        //         $ward_type = strtolower($discharge_data['ward']['primary_ward_type']['ward_type']);
        //         $admission_type = strtolower($discharge_data['ibox_admission_type_description']);
        //         $camis_patient_discharge_date = $discharge_data['camis_patient_discharge_date'];
        //         $dateTime = Carbon::parse($camis_patient_discharge_date);
        //         $hour = $dateTime->hour;
        //         if (
        //             !isset($discharge_data['ward']) ||
        //             !isset($discharge_data['ward']['status'], $discharge_data['ward']['disabled_on_all_dashboard_except_ward_summary']) ||
        //             $discharge_data['ward']['status'] != 1 ||
        //             $discharge_data['ward']['disabled_on_all_dashboard_except_ward_summary'] != 0
        //         ) {
        //             continue;
        //         }

        //         if (!in_array($ward_short_name, $merged_wards)) {
        //             continue;
        //         }

        //         if (stripos($request->type ?? '', 'discharge_00_11') !== false && strpos($admission_type, 'non-elective') !== false) {
        //             if ($hour >= 0 && $hour <= 12 && $ward_type == 'medical') {
        //                 if (isset($discharge_data['ward']['primary_ward_type']['ward_type']) && strtolower($discharge_data['ward']['primary_ward_type']['ward_type']) == 'medical') {
        //                     $patient_list[] = $discharge_data;
        //                 }
        //             } elseif ($hour >= 0 && $hour <= 12 && $ward_type == 'surgical') {
        //                 if (isset($discharge_data['ward']['primary_ward_type']['ward_type']) && strtolower($discharge_data['ward']['primary_ward_type']['ward_type']) == 'surgical') {
        //                     $patient_list[] = $discharge_data;
        //                 }
        //             } elseif ($hour >= 0 && $hour <= 12 && $ward_type == 'all') {
        //                 if (isset($discharge_data['ward']['primary_ward_type']['ward_type']) && in_array(strtolower($discharge_data['ward']['primary_ward_type']['ward_type']), ['surgical', 'medical'])) {
        //                     $patient_list[] = $discharge_data;
        //                 }
        //             }
        //         } elseif (stripos($request->type ?? '', 'discharge_12_15') !== false && strpos($admission_type, 'non-elective') !== false) {

        //             if ($hour >= 12 && $hour <= 15 && $ward_type == 'medical') {

        //                 if (isset($discharge_data['ward']['primary_ward_type']['ward_type']) && strtolower($discharge_data['ward']['primary_ward_type']['ward_type']) == 'medical') {

        //                     $patient_list[] = $discharge_data;
        //                 }
        //             } elseif ($hour >= 12 && $hour <= 15 && $ward_type == 'surgical') {
        //                 if (isset($discharge_data['ward']['primary_ward_type']['ward_type']) && strtolower($discharge_data['ward']['primary_ward_type']['ward_type']) == 'surgical') {
        //                     $patient_list[] = $discharge_data;
        //                 }
        //             } elseif ($hour >= 12 && $hour <= 15 && $ward_type == 'all') {
        //                 if (isset($discharge_data['ward']['primary_ward_type']['ward_type']) && in_array(strtolower($discharge_data['ward']['primary_ward_type']['ward_type']), ['surgical', 'medical'])) {
        //                     $patient_list[] = $discharge_data;
        //                 }
        //             }
        //         } elseif (stripos($request->type ?? '', 'discharge_16_23') !== false && strpos($admission_type, 'non-elective') !== false) {
        //             if ($hour >= 16 && $hour <= 23 && $ward_type == 'medical') {
        //                 if (isset($discharge_data['ward']['primary_ward_type']['ward_type']) && strtolower($discharge_data['ward']['primary_ward_type']['ward_type']) == 'medical') {
        //                     $patient_list[] = $discharge_data;
        //                 }
        //             } elseif ($hour >= 16 && $hour <= 23 && $ward_type == 'surgical') {
        //                 if (isset($discharge_data['ward']['primary_ward_type']['ward_type']) && strtolower($discharge_data['ward']['primary_ward_type']['ward_type']) == 'surgical') {
        //                     $patient_list[] = $discharge_data;
        //                 }
        //             } elseif ($hour >= 16 && $hour <= 23 && $ward_type == 'all') {
        //                 if (isset($discharge_data['ward']['primary_ward_type']['ward_type']) && in_array(strtolower($discharge_data['ward']['primary_ward_type']['ward_type']), ['surgical', 'medical'])) {
        //                     $patient_list[] = $discharge_data;
        //                 }
        //             }
        //         } elseif (stripos($request->type ?? '', 'overall_outpatient_') !== false) {
        //             $admit_string = explode('_', $request->type);
        //             $ward = end($admit_string);
        //             $admission_type = strtolower($discharge_data['ip_admission_type_description']);


        //             if (strpos($admission_type, 'non-elective') !== false) {
        //                 if ($discharge_data['ibox_ward_short_name'] == $ward) {
        //                     $patient_list[] = $discharge_data;
        //                 }
        //             }
        //         }
        //     }
        // }

        $ward_wise_patient = array_reduce($patient_list, function ($carry, $item)
        {
            $ward_name = $item['camis_patient_ward'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        $view = View::make('Dashboards.Camis.SiteOverview.Partials.DischargedPatient', compact('ward_wise_patient', 'all_wards'));
        return $view->render();
    }

    public function WardBoardRoundReport(Request $request)
    {

        $ward_type = $request->ward_type;
        $date = date('Y-m-d');

        $all_wards = Wards::when($ward_type == 'medical', function ($q) {
            return $q->where('ward_type_primary', 13);
        })->when($ward_type == 'surgical', function ($q) {
            return $q->where('ward_type_primary', 14);
        })->when($ward_type == 'all', function ($q) {
            return $q->whereIn('ward_type_primary', [13, 14]);
        })
            ->where('status', 1)
            ->where('show_on_boardround_dashboard', 1)
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->pluck('ward_name', 'id')->toArray();


        $board_round_history  = HistoryCamisIboxBoardWardRound::select(
            'ward_id',
            'history_id',
            'status',
            \DB::raw('MAX(board_round_session) AS board_round_session'),
            \DB::raw('MIN(history_id) AS min_history_id'),
            \DB::raw('SUM(IF(TIME(created_at) < "12:00:00", 1, 0)) AS am_total'),
            \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00", 1, 0)) AS pm_total'),
            \DB::raw('SUM(IF(TIME(created_at) < "12:00:00", 20, 0)) AS am_percentage_total'),
            \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00", 20, 0)) AS pm_percentage_total'),
            \DB::raw('(SUM(IF(TIME(created_at) < "12:00:00", 20, 0)) + SUM(IF(TIME(created_at) >= "12:00:00", 20, 0))) / 2 AS total'),

            // \DB::raw('SUM(IF(TIME(created_at) < "12:00:00" AND status = 1, 1, 0)) AS am_total'),
            // \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00" AND status = 1, 1, 0)) AS pm_total'),
            // \DB::raw('SUM(IF(TIME(created_at) < "12:00:00" AND status = 1, 20, 0)) AS am_percentage_total'),
            // \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00" AND status = 1, 20, 0)) AS pm_percentage_total'),
            // \DB::raw('(SUM(IF(TIME(created_at) < "12:00:00" AND status = 1, 20, 0)) + SUM(IF(TIME(created_at) >= "12:00:00" AND status = 1, 20, 0))) / 2 AS total'),
            \DB::raw('DATE(created_at) AS date'),
            \DB::raw('COALESCE(MAX(CASE WHEN TIME(created_at) < "12:00:00" THEN DATE_FORMAT(created_at, "%H:%i") ELSE "00:00" END), "00:00") AS am_time'),
            \DB::raw('COALESCE(MAX(CASE WHEN TIME(created_at) >= "12:00:00" THEN DATE_FORMAT(created_at, "%H:%i") ELSE "00:00" END), "00:00") AS pm_time')
        )
           // ->whereDate('created_at', $date)
            ->whereDate('ward_id', array_keys($all_wards))
            ->groupBy('history_id', 'ward_id', 'status', \DB::raw('DATE(created_at)'))
            ->orderBy('history_id', 'asc')
            ->get();
        $board_round_chart_results = [];
        foreach ($all_wards as $ward_id => $ward_name) {
            $board_round_chart_results[$ward_name] = [
                'am' => '00:00',
                'pm' => '00:00',
                'am_total' => 0,
                'pm_total' => 0,
                'am_percentage_total' => 0,
                'pm_percentage_total' => 0,
                'total' => 0,
                'am_status' => 0,
                'pm_status' => 0,
                'board_round_session' => '',
                'ward_id' => $ward_id,
                'ward_name' => $ward_name,
                'overall_status' => 0,
            ];
        }
        foreach ($board_round_history as $result) {


            $am_total = $result->am_total;
            $pm_total = $result->pm_total;
            $pm_percentage_total = ($result->pm_total != 0) ? $result->pm_percentage_total / $result->pm_total : 0;
            $am_percentage_total = ($result->am_total != 0) ? $result->am_percentage_total / $result->am_total : 0;
            if (!isset($all_wards[$result->ward_id])) {
                continue;
            }
            $ward_name = $all_wards[$result->ward_id];



            $am_status = $result->am_time != '00:00' && $result->status == 1 ? 1 : 2;
            $pm_status = $result->pm_time != '00:00' && $result->status == 1 ? 1 : 2;
            if (
                isset($board_round_chart_results[$ward_name]['overall_status'])
                && $board_round_chart_results[$ward_name]['overall_status'] == 1
            ) {
                continue;
            }

            if ($am_total != 0) {
                $existing_am_status = isset($board_round_chart_results[$ward_name]['am_status'])
                    && $board_round_chart_results[$ward_name]['am_status'] == 1;

                if (!$existing_am_status) {
                    $board_round_chart_results[$ward_name]['am'] = $result->am_time;
                    $board_round_chart_results[$ward_name]['am_percentage_total'] = $am_percentage_total;
                    $board_round_chart_results[$ward_name]['am_total'] = $am_total;
                    $board_round_chart_results[$ward_name]['am_status'] = $am_status;
                    $board_round_chart_results[$ward_name]['total'] = (($am_percentage_total + $pm_percentage_total) / 2);
                    $board_round_chart_results[$ward_name]['date'] = $result->date;
                    $board_round_chart_results[$ward_name]['status'] = $result->status;
                    $board_round_chart_results[$ward_name]['ward_name'] = $ward_name;
                    $board_round_chart_results[$ward_name]['ward_id'] = $result->ward_id;
                    $board_round_chart_results[$ward_name]['board_round_session'] = $result->board_round_session;
                }
            }

            if ($pm_total != 0) {
                $existing_pm_status = isset($board_round_chart_results[$ward_name]['pm_status'])
                    && $board_round_chart_results[$ward_name]['pm_status'] == 1;

                if (!$existing_pm_status) {
                    $board_round_chart_results[$ward_name]['pm'] = $result->pm_time;
                    $board_round_chart_results[$ward_name]['pm_percentage_total'] = $pm_percentage_total;
                    $board_round_chart_results[$ward_name]['pm_total'] = $pm_total;
                    $board_round_chart_results[$ward_name]['pm_status'] = $pm_status;
                    $board_round_chart_results[$ward_name]['status'] = $result->status;
                    $board_round_chart_results[$ward_name]['total'] = (($am_percentage_total + $pm_percentage_total) / 2);
                    $board_round_chart_results[$ward_name]['date'] = $result->date;
                    $board_round_chart_results[$ward_name]['ward_name'] = $ward_name;
                    $board_round_chart_results[$ward_name]['ward_id'] = $result->ward_id;
                    $board_round_chart_results[$ward_name]['board_round_session'] = $result->board_round_session;
                }
            }
            if ($board_round_chart_results[$ward_name]['am'] != '00:00' || $board_round_chart_results[$ward_name]['pm'] != '00:00') {
                $board_round_chart_results[$ward_name]['total'] = 20;
            }
            if ($am_status == 1 || $pm_status == 1) {
                $status = 1;
            } elseif (($am_status == 2 || $pm_status == 2) && ($am_status != 1 && $pm_status != 1)) {
                $status = 2;
            }

            $board_round_chart_results[$ward_name]['overall_status'] = $status ?? null;
        }
        ksort($board_round_chart_results);
        $board_round_chart_results = array_filter($board_round_chart_results, function ($ward) use ($request) {
            return $ward['overall_status'] == $request->board_round_type;
        });



        $view = View::make('Dashboards.Camis.WardPerformance.BoardRoundReportOffcanvasData', compact('board_round_chart_results', 'date'));
        return $view->render();
    }

    public function SymphonyAnePatient(Request $request)
    {
        $data = [];
        if ($request->type == 'ed') {
            $data = SymphonyAneEDNowPatientView::where('status_key', $request->key)->get()->toArray();
        } else {
            $data = SymphonyAneDTAPatientView::where('dta_type_key', $request->key)->get()->toArray();
        }
        $data = SymphonyAneDTAPatientView::get()->toArray();
        $view = View::make('Dashboards.Camis.SiteOverview.Partials.ANEOffcanvas', compact('data'));
        return $view->render();
    }
}
