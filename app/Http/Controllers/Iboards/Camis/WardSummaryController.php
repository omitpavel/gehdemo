<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundDischargeLoungeHandover;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundInfectionRisk;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundIpcComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPastMedicalHistory;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientGoal;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPharmacyScreened;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundReverseBarrier;
use App\Models\Iboards\Camis\Data\CamisIboxSurgicalWardsComment;
use App\Models\Iboards\Camis\View\CamisIboxPatientAlertDetails;
use App\Models\Iboards\Symphony\View\SymphonyAneAttendanceView;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Governance\GovernanceController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonCamisController;
use App\Http\Controllers\Common\HistoryController;
use Sentinel;
use Exception;
use Hash;
use Redirect;
use Illuminate\Support\Facades\Session;
use Log;
use Illuminate\Support\Facades\View;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundAdmittingReason;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundSocialHistory;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundWorkingDiagnosis;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundEstimatedDischargeDate;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundReasonToReside;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMedFit;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundRedGreenBed;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPotentialDefinite;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundEdn;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundTto;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPharmacyData;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPharmacyComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundAllowedToMove;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlagAdditionalInfo;
use App\Models\Iboards\Camis\Data\CamisIboxDPVirtualWardComment;
use App\Models\Iboards\Camis\Master\DtocCurrentStatus;
use App\Models\Iboards\Camis\Data\CamisIboxWardRound;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientStatus;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPathwayRequirement;
use App\Models\Iboards\Camis\Data\CamisIboxDPVirtualWardPatientStatus;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Camis\View\CamisIboxWardInPatientInformationDetailsView;
use App\Models\Iboards\Camis\View\CamisIboxBoardRoundNOK;
use App\Models\Iboards\Symphony\View\SymphonyFormLatestAttendanceNUmber;
use App\Models\Iboards\Symphony\View\SymphonyDataClinicalSeen;
use App\Models\Iboards\Symphony\View\SymphonyDataRefferal;
use App\Models\Iboards\Symphony\View\SymphonyDataTriageData;
use App\Models\Iboards\Symphony\View\SymphonyDataAttendanceData;
use App\Models\Iboards\Symphony\View\SymphonyDataAttendanceDetail;
use App\Models\Iboards\Symphony\View\SymphonyDataPatientDetails;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\Master\ReasonToResideGroup;
use App\Models\Iboards\Camis\Master\BedRedReason;
use App\Models\Iboards\Camis\Master\TaskGroup;
use App\Models\Iboards\Camis\Master\TaskCategory;
use App\Models\Iboards\Camis\Master\InfectionControl;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskNofTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskAkiAssessmentTasks;
use App\Models\Iboards\Camis\Master\BoardRoundGroup;
use App\Models\Iboards\Camis\Master\DpTasks;
use App\Models\Iboards\Camis\Master\DtocPathway;
use Adldap\Adldap;
use App\Models\Common\IboxSettings;
use App\Models\Common\User;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskSepsisTasks;
use App\Models\Iboards\Camis\Data\CamisIboxPatientHandOver;
use App\Models\Governance\GovernanceFrontendCamisOperationLogs;
use App\Models\History\HistoryCamisIboxBoardWardRound;
use App\Models\History\HistoryCamisIboxBoardRoundPharmacyData;
use App\Models\History\HistoryCamisIboxBoardPathwayRequirement;
use App\Models\History\HistoryCamisIboxBoardRoundPatientStatus;
use App\Models\History\HistoryCamisIboxBoardRoundReasonToReside;
use App\Models\History\HistoryCamisIboxSdecPatientPosition;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundBayStatus;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundBedStatus;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundCDT;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundCDTComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundDtocComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundLevel;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundTherapyFit;
use App\Models\Iboards\Camis\Data\CamisIboxDischargeLoungePosition;
use App\Models\Iboards\VitalPac\View\VitalPacAKIData;
use File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Iboards\Camis\Data\CamisIboxDoctorAtNightComment;
use App\Models\Iboards\Camis\Data\CamisIboxFrailtyPosition;
use App\Models\Iboards\Camis\Data\CamisIboxPatientInformationDetails;
use App\Models\Iboards\Camis\Data\CamisIboxSdecPosition;
use App\Models\Iboards\Camis\Master\BedDetails;
use App\Models\Iboards\Camis\Master\SdecWardBed;
use App\Models\Iboards\Camis\View\CamisAeToSDECWaiting;
use App\Models\Iboards\Camis\View\CamisIboxOutstandingTasks;
use App\Models\Iboards\Camis\View\CamisIboxPatientInfoVitalpacView;
use App\Models\Iboards\Camis\View\CamisIboxSdecPatientInformation;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsFullList;
use App\Models\Iboards\Camis\View\CamisIboxWardWeeklyDischarge;
use App\Models\Iboards\Symphony\Data\OpelCurrentStatus;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Current;
use Illuminate\Support\Str;
class WardSummaryController extends Controller
{
    public function Index($ward, Request $request)
    {


        if (!CheckDashboardPermission('camis_')) {
            Toastr::error('Permission Denied');
            return back();
        }

        if (Sentinel::getUser() && !is_numeric(Sentinel::getUser()->user_type)) {
            if (Sentinel::getUser()->user_type != $ward) {
                return redirect()->route('ward.ward-details', Sentinel::getUser()->user_type);
            }
        } elseif (Sentinel::getUser() && Sentinel::getUser()->user_type == 2) {
            return redirect()->route('ane.livestatus');
        }
        $ward_details                                                   = Wards::where('ward_url_name', '=', $ward)->where('status', '=', 1)->with('PrimaryWardType')->first()->toArray();


        if ($ward_details == null) {
            Toastr::error('Ward Doesnt Exits');
            return back();
        }
        if ($ward == 'critc') {
            return redirect()->route('CcuItuWard.ward-details');
        }
        $process_array                                                  = array();
        $success_array                                                  = array();
        $success_array["ward"]                                          = ($ward != '') ? strtolower($ward) : '';
        $success_array['ward_details']                                  = $ward_details;
        return view('Dashboards.Camis.WardSummary.Index', compact('success_array'));
    }
    public function IndexRefreshDataLoad($ward, Request $request)
    {

        return $this->WardSummaryDataLoad($ward);
    }

    public function SDECWard(Request $request)
    {
        if (!CheckDashboardPermission('camis_')) {
            Toastr::error('Permission Denied');
            return back();
        }
        $ward = 'rltsdecip';
        if (Sentinel::getUser() && !is_numeric(Sentinel::getUser()->user_type)) {
            if (Sentinel::getUser()->user_type != $ward) {
                return redirect()->route('ward.ward-details', Sentinel::getUser()->user_type);
            }
        } elseif (Sentinel::getUser() && Sentinel::getUser()->user_type == 2) {
            return redirect()->route('ane.livestatus');
        }
        $ward_details                                                   = Wards::where('ward_url_name', '=', $ward)->where('status', '=', 1)->with('PrimaryWardType')->first()->toArray();
        if ($ward_details == null) {
            Toastr::error('Ward Doesnt Exits');
            return back();
        }

        $process_array                                                  = array();
        $success_array                                                  = array();
        $success_array["ward"]                                          = ($ward != '') ? strtolower($ward) : '';
        $success_array['ward_details']                                  = $ward_details;
        return view('Dashboards.Camis.WardSummary.SDEC', compact('success_array'));
    }


    public function DischargeLoungeWard(Request $request)
    {
        if (!CheckDashboardPermission('camis_')) {
            Toastr::error('Permission Denied');
            return back();
        }
        $ward = 'rltdischarge';
        if (Sentinel::getUser() && !is_numeric(Sentinel::getUser()->user_type)) {
            if (Sentinel::getUser()->user_type != $ward) {
                return redirect()->route('ward.ward-details', Sentinel::getUser()->user_type);
            }
        } elseif (Sentinel::getUser() && Sentinel::getUser()->user_type == 2) {
            return redirect()->route('ane.livestatus');
        }
        $ward_details                                                   = Wards::where('ward_url_name', '=', $ward)->where('status', '=', 1)->with('PrimaryWardType')->first()->toArray();
        if ($ward_details == null) {
            Toastr::error('Ward Doesnt Exits');
            return back();
        }

        $process_array                                                  = array();
        $success_array                                                  = array();
        $success_array["ward"]                                          = ($ward != '') ? strtolower($ward) : '';
        $success_array['ward_details']                                  = $ward_details;
        return view('Dashboards.Camis.WardSummary.DischargeLounge', compact('success_array'));
    }
    public function DischargeLoungeWardDataLoad(Request $request)
    {

        $discharge_lounge_ward = Wards::where('ward_short_name', 'RLTDISCHARGE')->first();
        $discharge_lounge_ward_id = $discharge_lounge_ward->id;

        $patients = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'DischargeLoungePosition',
            'BoardRoundPatientTasks',
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory'
        ])->where('camis_patient_ward_id', $discharge_lounge_ward_id)->get()->toArray();
        $patient_doctor_task = 0;
        $patient_nurse_task = 0;
        $priority_task = 0;
        $waiting_area = [];
        $discharge_lounge_area = [];
        $other_discharge_lounge_postion = [];
        $total_patient = 0;
        $admitted_today = 0;
        $discharged_today = CamisIboxPatientInformationDetails::where('camis_patient_ward_id', $discharge_lounge_ward_id)->whereDate('camis_patient_discharge_date_time', Carbon::today())->count();

        $patient_on_the_ward = ['0_90_minutes' => 0, '91_180_minutes' => 0, '181_240_minutes' => 0, '241_360_minutes' => 0, '361_more_minutes' => 0, '0_3_hours' => 0, '3_6_hours' => 0, '6_more_hours' => 0];
        $total_los_in_minutes = 0;
        $elective   = 0;
        $non_elective = 0;

        $current_sdec_patient = [];
        foreach ($patients as $key => $patient) {
            if ((isset($patient['discharge_lounge_position']['dischagre_lounge_bed_id']) && $patient['discharge_lounge_position']['dischagre_lounge_bed_id'] == 0) || !isset($patient['discharge_lounge_position']['dischagre_lounge_bed_id'])) {
                $waiting_area[] = $patient;
            } else {
                $other_discharge_lounge_postion[] = $patient;
            }
            if (!empty($patient['camis_patient_id'])) {
                $total_patient++;
            }
            if (!empty($patient['camis_patient_id']) && !empty($patient['camis_patient_pas_number'])) {
                $current_sdec_patient[] = $patient['camis_patient_pas_number'];
            }
            if (isset($patient['camis_patient_admission_date_time']) && date('Y-m-d', strtotime($patient['camis_patient_admission_date_time'])) == date('Y-m-d')) {
                $admitted_today++;
            }



            if (empty($patient['camis_patient_id'])) {
                continue;
            }
            if (isset($patient['board_round_patient_tasks']) && !empty($patient['board_round_patient_tasks'])) {
                foreach ($patient['board_round_patient_tasks'] as $task_list) {
                    if ($task_list['task_priority'] == 1 && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                        $priority_task++;
                    }

                    if (isset($task_list['patient_task_group']['task_group_name'])) {
                        if (strtolower($task_list['patient_task_group']['task_group_name']) == 'doctor' && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                            $patient_doctor_task++;
                        } else if (strtolower($task_list['patient_task_group']['task_group_name']) == 'nurse' && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                            $patient_nurse_task++;
                        }
                    }
                }
            }

            $ward_start_time = !empty($patient['camis_patient_ward_start_date']) ? Carbon::parse($patient['camis_patient_ward_start_date']) : Carbon::parse($patient['camis_patient_admission_date_time']);
            $ward_stay_in_mintues = Carbon::now()->diffInMinutes($ward_start_time);
            $ward_stay_in_hours = Carbon::now()->diffInHours($ward_start_time);

            $total_los_in_minutes += $ward_stay_in_mintues;
            if ($ward_stay_in_mintues < 90) {
                $patient_on_the_ward['0_90_minutes']++;
            } elseif ($ward_stay_in_mintues >= 90 && $ward_stay_in_mintues <= 180) {
                $patient_on_the_ward['91_180_minutes']++;
            } elseif ($ward_stay_in_mintues >= 181 && $ward_stay_in_mintues <= 240) {
                $patient_on_the_ward['181_240_minutes']++;
            } elseif ($ward_stay_in_mintues >= 241 && $ward_stay_in_mintues <= 360) {
                $patient_on_the_ward['241_360_minutes']++;
            } elseif ($ward_stay_in_mintues > 361) {
                $patient_on_the_ward['361_more_minutes']++;
            }
            if ($ward_stay_in_hours < 3) {
                $patient_on_the_ward['0_3_hours']++;
            } elseif ($ward_stay_in_hours >= 3 && $ward_stay_in_hours <= 6) {
                $patient_on_the_ward['3_6_hours']++;
            } elseif ($ward_stay_in_hours > 6) {
                $patient_on_the_ward['6_more_hours']++;
            }
            if (!empty($patient['ip_admission_type_description']) && strtolower($patient['ip_admission_type_description']) == 'elective') {
                $elective++;
            } elseif (!empty($patient['ip_admission_type_description']) && strtolower($patient['ip_admission_type_description']) == 'non-elective') {
                $non_elective++;
            }
        }
        $bed_wise_patients = array_reduce($other_discharge_lounge_postion, function ($carry, $item) {
            $ward_name = $item['discharge_lounge_position']['dischagre_lounge_bed_id'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($bed_wise_patients);
        $discharge_lounge_ward_id = Wards::where('ward_short_name', 'RLTDISCHARGE')->first()->id;

        $discharge_lounge_bed = BedDetails::with('bedGroup')->where('ward_id', $discharge_lounge_ward_id)->where('status', 1)->orderBy('bed_priority', 'asc')->get()->toArray();

        foreach ($discharge_lounge_bed as $bed) {
            $patient_row = $bed_wise_patients[$bed['id']]['0'] ?? [];

            $bedGroupName = strtolower(str_replace(' ', '', $bed['bed_group']['bed_group_name']));

            if (stripos($bedGroupName, 'assessment') !== false) {
                $discharge_lounge_area[] = [
                    'bed_id' => $bed['id'],
                    'bed_name' => $bed['bed_actual_name'],
                    'bed_position' => $bed['bed_no'],
                    'camis_patient_id' => $patient_row['camis_patient_id'] ?? '',
                    'camis_patient_admission_date_time' => $patient_row['camis_patient_admission_date_time'] ?? '',
                    'camis_patient_name' => $patient_row['camis_patient_name'] ?? '',
                    'camis_patient_sex' => $patient_row['camis_patient_sex'] ?? '',
                    'camis_patient_pas_number' => $patient_row['camis_patient_pas_number'] ?? '',
                    'camis_consultant_name' => $patient_row['camis_consultant_name'] ?? '',
                    'camis_consultant_code_description' => $patient_row['camis_consultant_code_description'] ?? '',
                    'camis_consultant_specialty' => $patient_row['camis_consultant_specialty'] ?? ''
                ];
            }
        }


        usort($waiting_area, function ($a, $b) {
            if (isset($a['patient_position']['position']) && isset($b['patient_position']['position'])) {

                return $a['patient_position']['position'] - $b['patient_position']['position'];
            }

            if (!isset($a['patient_position']['position']) && isset($b['patient_position']['position'])) {
                return 1;
            }

            if (isset($a['patient_position']['position']) && !isset($b['patient_position']['position'])) {
                return -1;
            }

            return strtotime($a['camis_patient_admission_date_time']) - strtotime($b['camis_patient_admission_date_time']);
        });


        $still_in_ane_patients_list                                         = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
        $dta_patients_array                                                 = array();
        $dta_without_allocated_bed_patients_array                           = array();
        $ane_patients_awaiting_allocation                                   = array();
        $ane_patients_to_sdec                                               = array();
        if (CheckCountArrayToProcess($still_in_ane_patients_list)) {
            foreach ($still_in_ane_patients_list as $row) {
                if (isset($row["symphony_request_date"])) {
                    if ($row["symphony_request_date"] != "") {
                        $dta_patients_array[] = $row;
                        if (isset($row["symphony_dta_ward"])) {
                            if ($row["symphony_dta_ward"] == "") {
                                $dta_without_allocated_bed_patients_array[] = $row;
                            }
                        } else {
                            $dta_without_allocated_bed_patients_array[] = $row;
                        }
                    }
                }
            }
        }
        $success_array['admitted_today'] = $admitted_today;
        $success_array['discharged_today'] = $discharged_today;
        $success_array['stay_in_minutes'] = $patient_on_the_ward;



        $success_array['patient_doctor_task'] = $patient_doctor_task;
        $success_array['patient_nurse_task'] = $patient_nurse_task;
        $success_array['priority_task'] = $priority_task;



        $success_array['average_los_in_minutes'] = ($total_patient > 0) ? ($total_los_in_minutes / $total_patient) : 0;

        $success_array['in_ed_now']          = count($still_in_ane_patients_list);
        $success_array['total_dta_patients'] = count($dta_patients_array);
        $success_array['total_without_bed'] = SymphonyAneAttendanceView::where('symphony_discharge_ward', 'SDEC (Same Day Emergency Care)')->where(function ($query) {
            $query->whereNull('symphony_dta_ward')
                ->orWhere('symphony_dta_ward', '');
        })
            ->count();
        $task_group = TaskGroup::where('status', 1);
        $nurse_task = $task_group->where(DB::raw('LOWER(task_group_name)'), strtolower('Nurse'))->first();
        $doctor_task = $task_group->where(DB::raw('LOWER(task_group_name)'), strtolower('Doctor'))->first();

        $success_array['daily_target']  = $discharge_lounge_ward->ward_daily_goal;
        $current_date = Carbon::now();

        $start_of_current_week = $current_date->startOfWeek()->format('Y-m-d H:i:s');
        $end_of_current_week = $current_date->endOfWeek()->format('Y-m-d 11:59:s');

        $out_patients_records = CamisIboxWardWeeklyDischarge::select('camis_patient_id', 'dayname')->where('camis_patient_ward', 'RLTDISCHARGE')

            ->whereBetween('camis_patient_discharge_date_time', [$start_of_current_week, $end_of_current_week])

            ->orderBy('camis_patient_discharge_date_time', 'desc')
            ->get()->toArray();

        $day_wise_counts = [
            'monday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'monday');
            })),
            'tuesday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'tuesday');
            })),
            'wednesday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'wednesday');
            })),
            'thursday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'thursday');
            })),
            'friday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'friday');
            })),
            'saturday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'saturday');
            })),
            'sunday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'sunday');
            })),
        ];

        $success_array['weekly_discharges_total'] = count($out_patients_records);
        $success_array['weekly_discharges'] = $day_wise_counts;


        $success_array['nurse_task_id'] = $nurse_task->id ?? '39';
        $success_array['doctor_task_id'] = $doctor_task->id ?? '37';
        $success_array['ane_patients_to_sdec'] = CamisAeToSDECWaiting::whereNotIn('symphony_pas_number', $current_sdec_patient)->count();
        $success_array['ane_opel_status']    = GetANEOpelStatus();
        $success_array['ane_opel_class']     = 'bg-opel-' . GetANEOpelStatus();
        $success_array['ane_opel_text']      =  'A&E EMS ' . GetANEOpelStatus();
        $success_array['ward_opel_status']   = GetWardOpelStatusClass();
        $success_array['ward_opel_class']     = 'bg-opel-' . GetWardOpelStatusClass();
        $success_array['ward_opel_text']     =  'GEH EMS ' . GetWardOpelStatus();
        $html_view                                                           = View::make('Dashboards.Camis.WardSummary.DischargeLoungeDataLoad', compact('waiting_area', 'discharge_lounge_area',  'success_array', 'discharge_lounge_ward_id'));
        $success_array['html']                                      = $html_view->render();
        $success_array['elective_count']     = $elective;
        $success_array['non_elective_count'] = $non_elective;
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function FrailtyWard(Request $request)
    {
        if (!CheckDashboardPermission('camis_')) {
            Toastr::error('Permission Denied');
            return back();
        }
        $ward = 'rltfau';
        if (Sentinel::getUser() && !is_numeric(Sentinel::getUser()->user_type)) {
            if (Sentinel::getUser()->user_type != $ward) {
                return redirect()->route('ward.ward-details', Sentinel::getUser()->user_type);
            }
        } elseif (Sentinel::getUser() && Sentinel::getUser()->user_type == 2) {
            return redirect()->route('ane.livestatus');
        }
        $ward_details                                                   = Wards::where('ward_url_name', '=', $ward)->where('status', '=', 1)->with('PrimaryWardType')->first()->toArray();
        if ($ward_details == null) {
            Toastr::error('Ward Doesnt Exits');
            return back();
        }

        $process_array                                                  = array();
        $success_array                                                  = array();
        $success_array["ward"]                                          = ($ward != '') ? strtolower($ward) : '';
        $success_array['ward_details']                                  = $ward_details;
        return view('Dashboards.Camis.WardSummary.Frailty', compact('success_array'));
    }


    public function FrailtyWardDataLoad(Request $request)
    {

        $frailty_ward = Wards::where('ward_short_name', 'RLTFAU')->first();
        $frailty_ward_id = $frailty_ward->id;

        $patients = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'FrailtyPosition',
            'BoardRoundPatientTasks',
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory'
        ])->where('camis_patient_ward_id', $frailty_ward_id)->get()->toArray();
        $patient_doctor_task = 0;
        $patient_nurse_task = 0;
        $priority_task = 0;
        $waiting_area = [];
        $frailty_area = [];
        $other_frailty_postion = [];
        $total_patient = 0;
        $admitted_today = 0;
        $discharged_today = CamisIboxPatientInformationDetails::where('camis_patient_ward_id', $frailty_ward_id)->whereDate('camis_patient_discharge_date_time', Carbon::today())->count();

        $patient_on_the_ward = ['0_90_minutes' => 0, '91_180_minutes' => 0, '181_240_minutes' => 0, '241_360_minutes' => 0, '361_more_minutes' => 0, '0_3_hours' => 0, '3_6_hours' => 0, '6_more_hours' => 0];
        $total_los_in_minutes = 0;
        $elective   = 0;
        $non_elective = 0;

        $current_sdec_patient = [];
        foreach ($patients as $key => $patient) {
            if ((isset($patient['frailty_position']['frailty_bed_id']) && $patient['frailty_position']['frailty_bed_id'] == 0) || !isset($patient['frailty_position']['frailty_bed_id'])) {
                $waiting_area[] = $patient;
            } else {
                $other_frailty_postion[] = $patient;
            }
            if (!empty($patient['camis_patient_id'])) {
                $total_patient++;
            }
            if (!empty($patient['camis_patient_id']) && !empty($patient['camis_patient_pas_number'])) {
                $current_sdec_patient[] = $patient['camis_patient_pas_number'];
            }
            if (isset($patient['camis_patient_admission_date_time']) && date('Y-m-d', strtotime($patient['camis_patient_admission_date_time'])) == date('Y-m-d')) {
                $admitted_today++;
            }



            if (empty($patient['camis_patient_id'])) {
                continue;
            }
            if (isset($patient['board_round_patient_tasks']) && !empty($patient['board_round_patient_tasks'])) {
                foreach ($patient['board_round_patient_tasks'] as $task_list) {
                    if ($task_list['task_priority'] == 1 && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                        $priority_task++;
                    }

                    if (isset($task_list['patient_task_group']['task_group_name'])) {
                        if (strtolower($task_list['patient_task_group']['task_group_name']) == 'doctor' && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                            $patient_doctor_task++;
                        } else if (strtolower($task_list['patient_task_group']['task_group_name']) == 'nurse' && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                            $patient_nurse_task++;
                        }
                    }
                }
            }

            $ward_start_time = !empty($patient['camis_patient_ward_start_date']) ? Carbon::parse($patient['camis_patient_ward_start_date']) : Carbon::parse($patient['camis_patient_admission_date_time']);
            $ward_stay_in_mintues = Carbon::now()->diffInMinutes($ward_start_time);
            $ward_stay_in_hours = Carbon::now()->diffInHours($ward_start_time);

            $total_los_in_minutes += $ward_stay_in_mintues;
            if ($ward_stay_in_mintues < 90) {
                $patient_on_the_ward['0_90_minutes']++;
            } elseif ($ward_stay_in_mintues >= 90 && $ward_stay_in_mintues <= 180) {
                $patient_on_the_ward['91_180_minutes']++;
            } elseif ($ward_stay_in_mintues >= 181 && $ward_stay_in_mintues <= 240) {
                $patient_on_the_ward['181_240_minutes']++;
            } elseif ($ward_stay_in_mintues >= 241 && $ward_stay_in_mintues <= 360) {
                $patient_on_the_ward['241_360_minutes']++;
            } elseif ($ward_stay_in_mintues > 361) {
                $patient_on_the_ward['361_more_minutes']++;
            }
            if ($ward_stay_in_hours < 3) {
                $patient_on_the_ward['0_3_hours']++;
            } elseif ($ward_stay_in_hours >= 3 && $ward_stay_in_hours <= 6) {
                $patient_on_the_ward['3_6_hours']++;
            } elseif ($ward_stay_in_hours > 6) {
                $patient_on_the_ward['6_more_hours']++;
            }
            if (!empty($patient['ip_admission_type_description']) && strtolower($patient['ip_admission_type_description']) == 'elective') {
                $elective++;
            } elseif (!empty($patient['ip_admission_type_description']) && strtolower($patient['ip_admission_type_description']) == 'non-elective') {
                $non_elective++;
            }
        }
        $bed_wise_patients = array_reduce($other_frailty_postion, function ($carry, $item) {
            $ward_name = $item['frailty_position']['frailty_bed_id'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($bed_wise_patients);
        $frailty_ward_id = Wards::where('ward_short_name', 'RLTFAU')->first()->id;

        $frailty_bed = BedDetails::with('bedGroup')->where('ward_id', $frailty_ward_id)->where('status', 1)->orderBy('bed_priority', 'asc')->get()->toArray();

        foreach ($frailty_bed as $bed) {
            $patient_row = $bed_wise_patients[$bed['id']]['0'] ?? [];

            $bedGroupName = strtolower(str_replace(' ', '', $bed['bed_group']['bed_group_name']));

            if ($bedGroupName === 'frailtyassessmentunit') {
                $frailty_area[] = [
                    'bed_id' => $bed['id'],
                    'bed_name' => $bed['bed_actual_name'],
                    'bed_position' => $bed['bed_no'],
                    'camis_patient_id' => $patient_row['camis_patient_id'] ?? '',
                    'camis_patient_admission_date_time' => $patient_row['camis_patient_admission_date_time'] ?? '',
                    'camis_patient_name' => $patient_row['camis_patient_name'] ?? '',
                    'camis_patient_sex' => $patient_row['camis_patient_sex'] ?? '',
                    'camis_patient_pas_number' => $patient_row['camis_patient_pas_number'] ?? '',
                    'camis_consultant_name' => $patient_row['camis_consultant_name'] ?? '',
                    'camis_consultant_code_description' => $patient_row['camis_consultant_code_description'] ?? '',
                    'camis_consultant_specialty' => $patient_row['camis_consultant_specialty'] ?? ''
                ];
            }
        }


        usort($waiting_area, function ($a, $b) {
            if (isset($a['patient_position']['position']) && isset($b['patient_position']['position'])) {

                return $a['patient_position']['position'] - $b['patient_position']['position'];
            }

            if (!isset($a['patient_position']['position']) && isset($b['patient_position']['position'])) {
                return 1;
            }

            if (isset($a['patient_position']['position']) && !isset($b['patient_position']['position'])) {
                return -1;
            }

            return strtotime($a['camis_patient_admission_date_time']) - strtotime($b['camis_patient_admission_date_time']);
        });


        $still_in_ane_patients_list                                         = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
        $dta_patients_array                                                 = array();
        $dta_without_allocated_bed_patients_array                           = array();
        $ane_patients_awaiting_allocation                                   = array();
        $ane_patients_to_sdec                                               = array();
        if (CheckCountArrayToProcess($still_in_ane_patients_list)) {
            foreach ($still_in_ane_patients_list as $row) {
                if (isset($row["symphony_request_date"])) {
                    if ($row["symphony_request_date"] != "") {
                        $dta_patients_array[] = $row;
                        if (isset($row["symphony_dta_ward"])) {
                            if ($row["symphony_dta_ward"] == "") {
                                $dta_without_allocated_bed_patients_array[] = $row;
                            }
                        } else {
                            $dta_without_allocated_bed_patients_array[] = $row;
                        }
                    }
                }
            }
        }
        $success_array['admitted_today'] = $admitted_today;
        $success_array['discharged_today'] = $discharged_today;
        $success_array['stay_in_minutes'] = $patient_on_the_ward;



        $success_array['patient_doctor_task'] = $patient_doctor_task;
        $success_array['patient_nurse_task'] = $patient_nurse_task;
        $success_array['priority_task'] = $priority_task;



        $success_array['average_los_in_minutes'] = ($total_patient > 0) ? ($total_los_in_minutes / $total_patient) : 0;

        $success_array['in_ed_now']          = count($still_in_ane_patients_list);
        $success_array['total_dta_patients'] = count($dta_patients_array);
        $success_array['total_without_bed'] = SymphonyAneAttendanceView::where('symphony_discharge_ward', 'SDEC (Same Day Emergency Care)')->where(function ($query) {
            $query->whereNull('symphony_dta_ward')
                ->orWhere('symphony_dta_ward', '');
        })
            ->count();
        $task_group = TaskGroup::where('status', 1);
        $nurse_task = $task_group->where(DB::raw('LOWER(task_group_name)'), strtolower('Nurse'))->first();
        $doctor_task = $task_group->where(DB::raw('LOWER(task_group_name)'), strtolower('Doctor'))->first();




        $success_array['nurse_task_id'] = $nurse_task->id ?? '39';
        $success_array['doctor_task_id'] = $doctor_task->id ?? '37';
        $success_array['ane_patients_to_sdec'] = CamisAeToSDECWaiting::whereNotIn('symphony_pas_number', $current_sdec_patient)->count();
        $success_array['ane_opel_status']    = GetANEOpelStatus();
        $success_array['ane_opel_class']     = 'bg-opel-' . GetANEOpelStatus();
        $success_array['ane_opel_text']      =  'A&E EMS ' . GetANEOpelStatus();
        $success_array['ward_opel_status']   = GetWardOpelStatusClass();
        $success_array['ward_opel_class']     = 'bg-opel-' . GetWardOpelStatusClass();
        $success_array['ward_opel_text']     =  'GEH EMS ' . GetWardOpelStatus();




        $success_array['daily_target']  = $frailty_ward->ward_daily_goal;
        $current_date = Carbon::now();

        $start_of_current_week = $current_date->startOfWeek()->format('Y-m-d H:i:s');
        $end_of_current_week = $current_date->endOfWeek()->format('Y-m-d 11:59:s');

        $out_patients_records = CamisIboxWardWeeklyDischarge::select('camis_patient_id', 'dayname')->where('camis_patient_ward', 'RLTFAU')

            ->whereBetween('camis_patient_discharge_date_time', [$start_of_current_week, $end_of_current_week])

            ->orderBy('camis_patient_discharge_date_time', 'desc')
            ->get()->toArray();

        $day_wise_counts = [
            'monday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'monday');
            })),
            'tuesday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'tuesday');
            })),
            'wednesday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'wednesday');
            })),
            'thursday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'thursday');
            })),
            'friday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'friday');
            })),
            'saturday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'saturday');
            })),
            'sunday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'sunday');
            })),
        ];

        $success_array['weekly_discharges_total'] = count($out_patients_records);
        $success_array['weekly_discharges'] = $day_wise_counts;




        $html_view                                                           = View::make('Dashboards.Camis.WardSummary.FrailtyDatatLoad', compact('waiting_area', 'frailty_area',  'success_array', 'frailty_ward_id'));
        $success_array['html']                                      = $html_view->render();
        $success_array['elective_count']     = $elective;
        $success_array['non_elective_count'] = $non_elective;








        return ReturnArrayAsJsonToScript($success_array);
    }
    public function SDECWardDataLoad(Request $request)
    {
        $sdec_ward = Wards::where('ward_short_name', 'RLTSDECIP')->first();
        $sdec_ward_id = $sdec_ward->id;
        $patients = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientPosition',
            'BoardRoundPatientTasks',
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory'
        ])->whereIn('camis_patient_ward', ['RLTSDECIP', 'RLTSDECPW'])->get()->toArray();
        $patient_doctor_task = 0;
        $patient_nurse_task = 0;
        $priority_task = 0;
        $waiting_area = [];
        $ed_area = [];
        $planned_area = [];
        $other_sdec_postion = [];
        $total_patient = 0;
        $admitted_today = 0;
        $discharged_today = CamisIboxPatientInformationDetails::whereIn('camis_patient_ward', ['RLTSDECIP', 'RLTSDECPW'])->whereDate('camis_patient_discharge_date_time', Carbon::today())->count();
        $patient_on_the_ward = ['0_90_minutes' => 0, '91_180_minutes' => 0, '181_240_minutes' => 0, '241_360_minutes' => 0, '361_more_minutes' => 0, '0_3_hours' => 0, '3_6_hours' => 0, '6_more_hours' => 0];
        $total_los_in_minutes = 0;
        $elective   = 0;
        $non_elective = 0;
        $current_sdec_patient = [];
        foreach ($patients as $key => $patient) {
            if ((isset($patient['patient_position']['sdec_bed_id']) && $patient['patient_position']['sdec_bed_id'] == 0) || !isset($patient['patient_position']['sdec_bed_id'])) {
                $waiting_area[] = $patient;
            } else {
                $other_sdec_postion[] = $patient;
            }
            if (!empty($patient['camis_patient_id']) && !empty($patient['camis_patient_pas_number'])) {
                $current_sdec_patient[] = $patient['camis_patient_pas_number'];
            }
            if (!empty($patient['camis_patient_id'])) {
                $total_patient++;
            }
            if (isset($patient['camis_patient_admission_date_time']) && date('Y-m-d', strtotime($patient['camis_patient_admission_date_time'])) == date('Y-m-d')) {
                $admitted_today++;
            }



            if (empty($patient['camis_patient_id'])) {
                continue;
            }
            if (isset($patient['board_round_patient_tasks']) && !empty($patient['board_round_patient_tasks'])) {
                foreach ($patient['board_round_patient_tasks'] as $task_list) {
                    if ($task_list['task_priority'] == 1 && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                        $priority_task++;
                    }

                    if (isset($task_list['patient_task_group']['task_group_name'])) {
                        if (strtolower($task_list['patient_task_group']['task_group_name']) == 'doctor' && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                            $patient_doctor_task++;
                        } else if (strtolower($task_list['patient_task_group']['task_group_name']) == 'nurse' && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                            $patient_nurse_task++;
                        }
                    }
                }
            }

            $ward_start_time = !empty($patient['camis_patient_ward_start_date']) ? Carbon::parse($patient['camis_patient_ward_start_date']) : Carbon::parse($patient['camis_patient_admission_date_time']);
            $ward_stay_in_mintues = Carbon::now()->diffInMinutes($ward_start_time);
            $ward_stay_in_hours = Carbon::now()->diffInHours($ward_start_time);

            $total_los_in_minutes += $ward_stay_in_mintues;
            if ($ward_stay_in_mintues < 90) {
                $patient_on_the_ward['0_90_minutes']++;
            } elseif ($ward_stay_in_mintues >= 90 && $ward_stay_in_mintues <= 180) {
                $patient_on_the_ward['91_180_minutes']++;
            } elseif ($ward_stay_in_mintues >= 181 && $ward_stay_in_mintues <= 240) {
                $patient_on_the_ward['181_240_minutes']++;
            } elseif ($ward_stay_in_mintues >= 241 && $ward_stay_in_mintues <= 360) {
                $patient_on_the_ward['241_360_minutes']++;
            } elseif ($ward_stay_in_mintues > 361) {
                $patient_on_the_ward['361_more_minutes']++;
            }
            if ($ward_stay_in_hours < 3) {
                $patient_on_the_ward['0_3_hours']++;
            } elseif ($ward_stay_in_hours >= 3 && $ward_stay_in_hours <= 6) {
                $patient_on_the_ward['3_6_hours']++;
            } elseif ($ward_stay_in_hours > 6) {
                $patient_on_the_ward['6_more_hours']++;
            }
            if (!empty($patient['ip_admission_type_description']) && strtolower($patient['ip_admission_type_description']) == 'elective') {
                $elective++;
            } elseif (!empty($patient['ip_admission_type_description']) && strtolower($patient['ip_admission_type_description']) == 'non-elective') {
                $non_elective++;
            }
        }
        $bed_wise_patients = array_reduce($other_sdec_postion, function ($carry, $item) {
            $ward_name = $item['patient_position']['sdec_bed_id'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($bed_wise_patients);
        $sdec_bed = BedDetails::with('bedGroup')->where('ward_id', $sdec_ward_id)->where('status', 1)->orderBy('bed_priority', 'asc')->get()->toArray();

        foreach ($sdec_bed as $bed) {
            $patient_row = $bed_wise_patients[$bed['id']]['0'] ?? [];

            $bedGroupName = strtolower(str_replace(' ', '', $bed['bed_group']['bed_group_name']));

            if ($bedGroupName === 'edarea') {
                $ed_area[] = [
                    'bed_id' => $bed['id'],
                    'bed_name' => $bed['bed_actual_name'],
                    'bed_position' => $bed['bed_no'],
                    'camis_patient_id' => $patient_row['camis_patient_id'] ?? '',
                    'camis_patient_admission_date_time' => $patient_row['camis_patient_admission_date_time'] ?? '',
                    'camis_patient_name' => $patient_row['camis_patient_name'] ?? '',
                    'camis_patient_sex' => $patient_row['camis_patient_sex'] ?? '',
                    'camis_patient_pas_number' => $patient_row['camis_patient_pas_number'] ?? '',
                    'camis_consultant_name' => $patient_row['camis_consultant_name'] ?? '',
                    'camis_consultant_code_description' => $patient_row['camis_consultant_code_description'] ?? '',
                    'camis_consultant_specialty' => $patient_row['camis_consultant_specialty'] ?? ''
                ];
            } elseif ($bedGroupName === 'plannedarea') {
                $planned_area[] = [
                    'bed_id' => $bed['id'],
                    'bed_name' => $bed['bed_actual_name'],
                    'bed_position' => $bed['bed_no'],
                    'camis_patient_id' => $patient_row['camis_patient_id'] ?? '',
                    'camis_patient_admission_date_time' => $patient_row['camis_patient_admission_date_time'] ?? '',
                    'camis_patient_name' => $patient_row['camis_patient_name'] ?? '',
                    'camis_patient_sex' => $patient_row['camis_patient_sex'] ?? '',
                    'camis_patient_pas_number' => $patient_row['camis_patient_pas_number'] ?? '',
                    'camis_consultant_name' => $patient_row['camis_consultant_name'] ?? '',
                    'camis_consultant_code_description' => $patient_row['camis_consultant_code_description'] ?? '',
                    'camis_consultant_specialty' => $patient_row['camis_consultant_specialty'] ?? ''
                ];
            }
        }


        usort($waiting_area, function ($a, $b) {
            if (isset($a['patient_position']['position']) && isset($b['patient_position']['position'])) {

                return $a['patient_position']['position'] - $b['patient_position']['position'];
            }

            if (!isset($a['patient_position']['position']) && isset($b['patient_position']['position'])) {
                return 1;
            }

            if (isset($a['patient_position']['position']) && !isset($b['patient_position']['position'])) {
                return -1;
            }

            return strtotime($a['camis_patient_admission_date_time']) - strtotime($b['camis_patient_admission_date_time']);
        });


        $still_in_ane_patients_list                                         = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
        $dta_patients_array                                                 = array();
        $dta_without_allocated_bed_patients_array                           = array();
        $ane_patients_awaiting_allocation                                   = array();
        $ane_patients_to_sdec                                               = array();
        if (CheckCountArrayToProcess($still_in_ane_patients_list)) {
            foreach ($still_in_ane_patients_list as $row) {
                if (isset($row["symphony_request_date"])) {
                    if ($row["symphony_request_date"] != "") {
                        $dta_patients_array[] = $row;
                        if (isset($row["symphony_dta_ward"])) {
                            if ($row["symphony_dta_ward"] == "") {
                                $dta_without_allocated_bed_patients_array[] = $row;
                            }
                        } else {
                            $dta_without_allocated_bed_patients_array[] = $row;
                        }
                    }
                }
            }
        }
        $success_array['admitted_today'] = $admitted_today;
        $success_array['discharged_today'] = $discharged_today;
        $success_array['stay_in_minutes'] = $patient_on_the_ward;



        $success_array['patient_doctor_task'] = $patient_doctor_task;
        $success_array['patient_nurse_task'] = $patient_nurse_task;
        $success_array['priority_task'] = $priority_task;



        $success_array['average_los_in_minutes'] = ($total_patient > 0) ? ($total_los_in_minutes / $total_patient) : 0;

        $success_array['in_ed_now']          = count($still_in_ane_patients_list);
        $success_array['total_dta_patients'] = count($dta_patients_array);
        $success_array['total_without_bed'] = SymphonyAneAttendanceView::where('symphony_discharge_ward', 'SDEC (Same Day Emergency Care)')->where(function ($query) {
            $query->whereNull('symphony_dta_ward')
                ->orWhere('symphony_dta_ward', '');
        })
            ->count();
        $task_group = TaskGroup::where('status', 1);
        $nurse_task = $task_group->where(DB::raw('LOWER(task_group_name)'), strtolower('Nurse'))->first();
        $doctor_task = $task_group->where(DB::raw('LOWER(task_group_name)'), strtolower('Doctor'))->first();

        $success_array['daily_target']  = $sdec_ward->ward_daily_goal;
        $current_date = Carbon::now();

        $start_of_current_week = $current_date->startOfWeek()->format('Y-m-d H:i:s');
        $end_of_current_week = $current_date->endOfWeek()->format('Y-m-d 11:59:s');

        $out_patients_records = CamisIboxWardWeeklyDischarge::select('camis_patient_id', 'dayname')->whereIn('camis_patient_ward', ['RLTSDECIP', 'RLTSDECPW'])

            ->whereBetween('camis_patient_discharge_date_time', [$start_of_current_week, $end_of_current_week])

            ->orderBy('camis_patient_discharge_date_time', 'desc')
            ->get()->toArray();

        $day_wise_counts = [
            'monday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'monday');
            })),
            'tuesday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'tuesday');
            })),
            'wednesday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'wednesday');
            })),
            'thursday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'thursday');
            })),
            'friday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'friday');
            })),
            'saturday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'saturday');
            })),
            'sunday' => count(array_filter($out_patients_records, function($item)  {
                return (strtolower($item['dayname']) == 'sunday');
            })),
        ];

        $success_array['weekly_discharges_total'] = count($out_patients_records);
        $success_array['weekly_discharges'] = $day_wise_counts;


        $success_array['nurse_task_id'] = $nurse_task->id ?? '39';
        $success_array['doctor_task_id'] = $doctor_task->id ?? '37';
        //$success_array['ane_patients_to_sdec'] = CamisAeToSDECWaiting::whereNotIn('symphony_pas_number', $current_sdec_patient)->count();
        $success_array['ane_patients_to_sdec'] = CamisAeToSDECWaiting::count();
        $success_array['ane_opel_status']    = GetANEOpelStatus();
        $success_array['ane_opel_class']     = 'bg-opel-' . GetANEOpelStatus();
        $success_array['ane_opel_text']      =  'A&E EMS ' . GetANEOpelStatus();
        $success_array['ward_opel_status']   = GetWardOpelStatusClass();
        $success_array['ward_opel_class']     = 'bg-opel-' . GetWardOpelStatusClass();
        $success_array['ward_opel_text']     =  'GEH EMS ' . GetWardOpelStatus();
        $html_view                                                           = View::make('Dashboards.Camis.WardSummary.SDECDatatLoad', compact('waiting_area', 'ed_area', 'planned_area', 'success_array', 'sdec_ward_id'));
        $success_array['html']                                      = $html_view->render();
        $success_array['elective_count']     = $elective;
        $success_array['non_elective_count'] = $non_elective;
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function SdecBoardRound(Request $request)
    {
        $ward = 'rltsdecip';
        $ward_details                                                   = Wards::where('ward_url_name', '=', $ward)->where('status', '=', 1)->with('PrimaryWardType')->first()->toArray();
        if ($ward_details == null) {
            Toastr::error('Ward Doesnt Exits');
            return back();
        }

        $process_array                                                  = array();
        $success_array                                                  = array();
        $success_array["ward"]                                          = ($ward != '') ? strtolower($ward) : '';
        $success_array['ward_details']                                  = $ward_details;
        $success_array['aki_task']                                      = BoardRoundUserTaskAkiAssessmentTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['nof_task']                                      = BoardRoundUserTaskNofTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['dp_task']                                       = DpTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['sepsis_task']                                   = BoardRoundUserTaskSepsisTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

        return view('Dashboards.Camis.WardSummary.SDECBoardRound', compact('success_array'));
    }

    public function FrailtyBoardRound(Request $request)
    {
        $ward = 'rltfau';
        $ward_details                                                   = Wards::where('ward_url_name', '=', $ward)->where('status', '=', 1)->with('PrimaryWardType')->first()->toArray();
        if ($ward_details == null) {
            Toastr::error('Ward Doesnt Exits');
            return back();
        }

        $process_array                                                  = array();
        $success_array                                                  = array();
        $success_array["ward"]                                          = ($ward != '') ? strtolower($ward) : '';
        $success_array['ward_details']                                  = $ward_details;
        $success_array['aki_task']                                      = BoardRoundUserTaskAkiAssessmentTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['nof_task']                                      = BoardRoundUserTaskNofTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['dp_task']                                       = DpTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['sepsis_task']                                   = BoardRoundUserTaskSepsisTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

        return view('Dashboards.Camis.WardSummary.FrailtyBoardRound', compact('success_array'));
    }

    public function DischargeLoungeBoardRound(Request $request)
    {
        $ward = 'rltdischarge';
        $ward_details                                                   = Wards::where('ward_url_name', '=', $ward)->where('status', '=', 1)->with('PrimaryWardType')->first()->toArray();
        if ($ward_details == null) {
            Toastr::error('Ward Doesnt Exits');
            return back();
        }

        $process_array                                                  = array();
        $success_array                                                  = array();
        $success_array["ward"]                                          = ($ward != '') ? strtolower($ward) : '';
        $success_array['ward_details']                                  = $ward_details;
        $success_array['aki_task']                                      = BoardRoundUserTaskAkiAssessmentTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['nof_task']                                      = BoardRoundUserTaskNofTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['dp_task']                                       = DpTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['sepsis_task']                                   = BoardRoundUserTaskSepsisTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

        return view('Dashboards.Camis.WardSummary.DischargeLoungeBoardRound', compact('success_array'));
    }
    public function DischargeLoungeBoardRoundData(Request $request)
    {
        $success_array = [];

        $process_array                      = array();
        $success_array                      = array();
        $camis_patient_id                   = CleanString($request->camis_patient_id);
        $group_number_count_arr             = array();
        $patient_details                    = array();
        $flag_array                         = array();
        $user_id                            = Session()->get('LOGGED_USER_ID', '');
        $common_controller = new CommonCamisController;

        if ($request->is_boardround == 1) {
            $ward_summary_controller = new WardSummaryController;
            $ward_summary_controller->InsertBoardRoundData($camis_patient_id);
        }
        $patient_info_details      = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'DischargeLoungePosition.DischargeLoungePosition.bedGroup',
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_status_value', 1);
            },
            'AllowedToMove',
            'RedGreenBed',
            'RedGreenBed.RedGreenReason',
            'PotentialDefinite',
            'BoardRoundPastMedicalHistory',
            'BoardRoundPatientGoal',
            'BoardRoundTherapyFitData',
            'BoardRoundMedicallyFitData',
            'BoardRoundEstimatedDischargeDate',
            'BoardRoundReasonToReside',
            'BoardRoundReasonToReside.ReasonToResideCategory',
            'BoardRoundTto',
            'BoardRoundEdn',
            'BoardRoundCdt',
            'BoardRoundPharmacyData',
            'BoardRoundAdmittingReason',
            'BoardRoundSocialHistory',
            'BoardRoundWorkingDiagnosis',
            'BoardRoundPathwayRequirement',
            'BoardRoundCareRequirement',
            'BoardRoundDtocComments' => function ($query) {
                $query->orderBy('date', 'DESC');
            },
            'PatientVitalPacInfo',
            'BoardRoundLevel',
            'DischargeLoungeMovements', 'InfectionRisks'
        ])->where('camis_patient_id', '=', $camis_patient_id)->first();


        $show_flag_group                    = BoardRoundFlagList::where('show_on_normal_ward', '=', 1)->where('status', '=', 1)->orderBy('patient_flag_group_number_normal_ward', 'ASC')->pluck('patient_flag_group_number_normal_ward')->toArray();

        foreach ($show_flag_group as $flag_group) {
            $flag_array[$flag_group]['group_id'] = $flag_group;
            $flag_array[$flag_group]['flag_list'] = BoardRoundFlagList::where('show_on_normal_ward', '=', 1)->where('status', '=', 1)->where('patient_flag_group_number_normal_ward', $flag_group)->orderBy('patient_flag_group_number_normal_ward', 'ASC')->orderBy('patient_flag_priority_normal_ward', 'ASC')->get()->toArray();
        }



        $board_round_text                                           = 'boardround_' . $patient_info_details->ibox_ward_id . '_' . $user_id;
        $board_round_type                                           = 'boardround_type_' . $patient_info_details->ibox_ward_id . '_' . $user_id;
        $board_round_doctor_id                                      = 'boardround_doctor_' . $patient_info_details->ibox_ward_id . '_' . $user_id;
        $board_round_last_patient                                   = 'boardround_last_patient_' . $patient_info_details->ibox_ward_id . '_' . $user_id;

        $board_round_order                                          = $request->board_round_order;
        $ward_id = $patient_info_details->ibox_ward_id;
        $current_time = Carbon::now();
        $current_hour = $current_time->format('H');
        $discharge_lounge_ward_id = Wards::where('ward_short_name', 'RLTDISCHARGE')->first()->id;

        $all_discharge_lounge_patients = CamisIboxWardPatientInformationWithBedDetailsView::with('DischargeLoungePosition')->where('camis_patient_ward_id', $discharge_lounge_ward_id)->get()->toArray();
        $waiting_area = [];
        $discharge_lounge_area = [];
        $other_discharge_lounge_postion = [];
        foreach ($all_discharge_lounge_patients as $key => $patient) {
            if ((isset($patient['discharge_lounge_position']['dischagre_lounge_bed_id']) && $patient['discharge_lounge_position']['dischagre_lounge_bed_id'] == 0) || !isset($patient['discharge_lounge_position']['dischagre_lounge_bed_id'])) {
                $waiting_area[] = $patient['camis_patient_id'];
            } else {
                $other_discharge_lounge_postion[] = $patient;
            }
        }

        $bed_wise_patients = array_reduce($other_discharge_lounge_postion, function ($carry, $item) {
            $ward_name = $item['discharge_lounge_position']['dischagre_lounge_bed_id'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($bed_wise_patients);

        $discharge_lounge_bed = BedDetails::with('bedGroup')->where('ward_id', $discharge_lounge_ward_id)->where('status', 1)->orderBy('bed_priority', 'asc')->get()->toArray();

        foreach ($discharge_lounge_bed as $bed) {
            $patient_row = $bed_wise_patients[$bed['id']]['0'] ?? [];

            $bedGroupName = strtolower(str_replace(' ', '', $bed['bed_group']['bed_group_name']));
            if (!empty($patient_row['camis_patient_id'])) {
                if (stripos($bedGroupName, 'assessment') !== false) {
                    $discharge_lounge_area[] = $patient_row['camis_patient_id'];
                }
            }
        }



        $all_beds_merged = array_merge($waiting_area, $discharge_lounge_area);

        $current_index = array_search($camis_patient_id, $all_beds_merged);
        $prev_patient = $current_index > 0 ? $all_beds_merged[$current_index - 1] : null;
        $next_patient = $current_index !== false && $current_index < count($all_beds_merged) - 1 ? $all_beds_merged[$current_index + 1] : null;




        if (isset($patient_info_details) && isset($patient_info_details->camis_patient_id)) {

            $patient_details       = $patient_info_details->toArray();
        }
        if (count($patient_details) > 0) {

            if ($request->is_boardround == 1) {
                if ($next_patient != null) {
                    Session::put($board_round_last_patient, $next_patient);
                } else {
                    Session::put($board_round_last_patient, $patient_details['camis_patient_id']);
                }
            }
            if (isset($patient_details['discharge_lounge_position']['discharge_lounge_position']['bed_group'])) {
                $bed_name = $patient_details['discharge_lounge_position']['discharge_lounge_position']['bed_group']['bed_group_name'] . ' ' . $patient_details['discharge_lounge_position']['discharge_lounge_position']['bed_actual_name'];
            } else {
                $bed_name = '';
            }
            $patient_details['patient_bed_bay']                         = $bed_name;
            $patient_details['infection_risks']                         = $patient_details['infection_risks'] ?? [];
            $patient_details['ibox_patient_admit_date_los_value']       = NumberOfDaysBetweenTwoDates($patient_details['camis_patient_admission_date'], date('Y-m-d'));
            $patient_details['ibox_patient_admit_date_los_value_ward']  = NumberOfDaysBetweenTwoDates($patient_details['camis_patient_ward_start_date'], date('Y-m-d'));
            $patient_details['camis_patient_name']                      = ucwords(strtolower(trim($patient_details['camis_patient_name'])));
            $patient_details['camis_consultant_name']                   = ucwords(strtolower(trim($patient_details['camis_consultant_name'])));
            $patient_details['camis_patient_post_code']                 = trim($patient_details['camis_patient_post_code']);
            $patient_details['camis_consultant_code_description']       = ucwords(strtolower(trim($patient_details['camis_consultant_code_description'])));
            $patient_details['camis_consultant_code_description']       = (strlen($patient_details['camis_consultant_code_description']) < 5) ? strtoupper($patient_details['camis_consultant_code_description']) : $patient_details['camis_consultant_code_description'];
            //            $patient_details['total_ward_history_movement']             = CamisIboxWardHistory::select('id')->where('id', $patient_details['camis_patient_id'])->count();
            $los_text_show_head                                         = 'LOS ' . $patient_details['ibox_patient_admit_date_los_value'];
            $los_text_show_head                                        .= ($patient_details['ibox_patient_admit_date_los_value'] > 1) ? ' Days ' : ' Day ';
            $los_text_show_head                                        .= 'Total With ' . $patient_details['ibox_patient_admit_date_los_value_ward'];
            $los_text_show_head                                        .= ($patient_details['ibox_patient_admit_date_los_value_ward'] > 1) ? ' Days ' : ' Day ';
            $los_text_show_head                                        .= 'On This Ward';
            $patient_details['boardround_header_text_value']            = $bed_name . ' - ' . $patient_details['camis_patient_name'] . ' (' . $patient_details['camis_patient_age'] . ') - ' . $los_text_show_head;
            $patient_details['each_patient']                            = $bed_name . ' - ' . $patient_details['camis_patient_name'] . ' (' . $patient_details['camis_patient_age'] . ')';
            $patient_ward_bed_info                                      = Wards::where('id', $patient_details['camis_patient_ward_id'])->first()->ward_name ?? '';

            if (!empty($bed_name)) {
                $patient_details['patient_ward_bed_info'] = $patient_ward_bed_info . ' - ' . $bed_name;
            } else {
                $patient_details['patient_ward_bed_info'] = $patient_ward_bed_info;
            }


            $patient_details['patient_name_age']                        = $patient_details['camis_patient_forename'] . '  ' . $patient_details['camis_patient_surname']  . ' - ' . ' ' . $patient_details['camis_patient_age'] . ' Years';
            $patient_details['patient_los']                             = $los_text_show_head;
            $patient_details['patient_herat_rate']                      = $patient_details['patient_vital_pac_info']['herat_rate_val'] ?? 0;
            $patient_details['patient_ews']                             = $patient_details['patient_vital_pac_info']['totalews'] ?? 0;
            $patient_details['patient_temperature']                     = $patient_details['patient_vital_pac_info']['Temperature_val'] ?? 0;
            $patient_details['patient_weight']                          = $patient_details['patient_vital_pac_info']['patient_weight_details'] ?? 0;


            $patient_details['cpi_details']                          = '--';
        }



        $common_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
        $success_array['patient_details']        = $patient_details;
        $success_array['show_flag_list']         = $flag_array;
        $infection_risk_flag = CamisIboxBoardRoundPatientFlag::where('patient_flag_status_value', 1)->where('patient_flag_name', 'ibox_patient_flag_infection_risk')->where('patient_id', $camis_patient_id)->first();
        $success_array['camis_ic_status'] = 'riskfree';
        $success_array['camis_ic_text'] = 'No Infection';
        $success_array['camis_ic_status'] = 'negetive';
        if ($infection_risk_flag != null) {

            $flag_record = CamisIboxBoardRoundInfectionRisk::where('patient_id', $camis_patient_id)
                ->where('is_primary', 1)
                ->first();

            $primary_flag = $flag_record ? $flag_record->toArray() : [];

            if (!empty($primary_flag)) {
                if ((($primary_flag['infection_type'] == "CONFIRMED" || $primary_flag['infection_type'] == "QUERY"))) {
                    $success_array['camis_ic_status'] = 'posetive';
                    $success_array['camis_ic_text'] = $primary_flag['infection_name'] . ' - ' . ucwords(strtolower($primary_flag['infection_type']));
                } else {
                    if ($primary_flag['infection_type'] == 'CANSTAYINBAY') {
                        $ic_text = 'CAN STAY IN BED';
                    } else {
                        $ic_text = $primary_flag['infection_type'];
                    }
                    $success_array['camis_ic_status'] = 'negetive';
                    $success_array['camis_ic_text'] = $primary_flag['infection_name'] . ' - ' . ucwords(strtolower($ic_text));
                }
            }
        }

        $success_array['group_number_width_arr']  = $show_flag_group;
        $success_array['next_patient']            = $next_patient;
        $success_array['prev_patient']            = $prev_patient;


        $success_array['today']  = Carbon::now();

        $success_array['tomorrow'] = Carbon::now()->addDay();

        $success_array['dayAfterTomorrow']   = Carbon::now()->addDays(2);
        $pharmacy_latest_comment            = CamisIboxBoardRoundPharmacyComment::where('patient_id', $camis_patient_id)->orderBy('id', 'desc')->first()->pharmacy_comment ?? '';
        $success_array["pharmacy_latest_comment"]                   = $pharmacy_latest_comment;

        $success_array['dtoc_path_way_drop']                            = DtocPathway::where('status', '=', 1)->get();
        $success_array['bed_red_reason']                                = BedRedReason::where('status', '=', 1)->get();
        $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();

        $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
            return $carry;
        }, []);

        $discharge_lounge_bed = BedDetails::with('bedGroup')
            ->where('ward_id', $discharge_lounge_ward_id)
            ->where('status', 1)
            ->orderBy('bed_priority', 'asc')
            ->get()
            ->toArray();

        $bed_wise_patients = array_reduce($discharge_lounge_bed, function ($carry, $item) {
            $ward_name = $item['id'];
            $carry[$ward_name][] = $item;
            return $carry;
        }, []);
        ksort($bed_wise_patients);

        $movement_trace = [];

        foreach ($patient_info_details->DischargeLoungeMovements->toArray() as $move) {
            $bedId     = $move['dischagre_lounge_bed_id'] ?? null;
            $updatedAt = $move['updated_at'] ?? null;
            if (empty($updatedAt)) continue;

            if (is_null($bedId) || (int)$bedId === 0) {
                $area = 'Waiting Area';
            } else {
                $bed_group_name  = $bed_wise_patients[$bedId][0]['bed_group']['bed_group_name'] ?? '';
                $bed_actual_name = $bed_wise_patients[$bedId][0]['bed_actual_name'] ?? '';
                $area = trim(preg_replace('/\s+/', ' ', trim($bed_group_name . ' ' . $bed_actual_name)));
            }

            $movement_trace[] = [
                'area'     => $area,
                'time_raw' => $updatedAt,
                'time'     => PredefinedDateFormatFor24Hour($updatedAt),
            ];
        }

        usort($movement_trace, fn($a, $b) => strtotime($a['time_raw']) <=> strtotime($b['time_raw']));

        if (!empty($movement_trace) && !is_waiting_area($movement_trace[0]['area'])) {
            array_unshift($movement_trace, [
                'area'     => 'Waiting Area',
                'time_raw' => $movement_trace[0]['time_raw'],
                'time'     => $movement_trace[0]['time'],
            ]);
        }

        $compressed = [];
        foreach ($movement_trace as $e) {
            if (empty($compressed)) {
                $compressed[] = $e;
                continue;
            }
            $last = $compressed[count($compressed) - 1];
            if (strcasecmp($last['area'], $e['area']) === 0) {

                continue;
            }
            $compressed[] = $e;
        }

        $movement_data = [];
        for ($i = 0; $i < count($compressed) - 1; $i++) {
            $from = $compressed[$i];
            $to   = $compressed[$i + 1];
            $movement_data[] = "{$from['area']} to {$to['area']} ({$to['time']})";
        }
        $success_array['movement_data'] = $movement_data;




        return view('Dashboards.Camis.WardSummary.DischargeLoungeBoardRoundDataload', compact('success_array'));
    }

    public function FrailtyBoardRoundData(Request $request)
    {
        $success_array = [];

        $process_array                      = array();
        $success_array                      = array();
        $camis_patient_id                   = CleanString($request->camis_patient_id);
        $group_number_count_arr             = array();
        $patient_details                    = array();
        $flag_array                         = array();
        $user_id                            = Session()->get('LOGGED_USER_ID', '');
        $common_controller = new CommonCamisController;

        if ($request->is_boardround == 1) {
            $ward_summary_controller = new WardSummaryController;
            $ward_summary_controller->InsertBoardRoundData($camis_patient_id);
        }
        $patient_info_details      = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'FrailtyPosition.FrailtyPosition.bedGroup',
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_status_value', 1);
            },
            'AllowedToMove',
            'RedGreenBed',
            'RedGreenBed.RedGreenReason',
            'PotentialDefinite',
            'BoardRoundPastMedicalHistory',
            'BoardRoundPatientGoal',
            'BoardRoundTherapyFitData',
            'BoardRoundMedicallyFitData',
            'BoardRoundEstimatedDischargeDate',
            'BoardRoundReasonToReside',
            'BoardRoundReasonToReside.ReasonToResideCategory',
            'BoardRoundTto',
            'BoardRoundEdn',
            'BoardRoundCdt',
            'BoardRoundPharmacyData',
            'BoardRoundAdmittingReason',
            'BoardRoundSocialHistory',
            'BoardRoundWorkingDiagnosis',
            'BoardRoundPathwayRequirement',
            'BoardRoundCareRequirement',
            'BoardRoundDtocComments' => function ($query) {
                $query->orderBy('date', 'DESC');
            },
            'PatientVitalPacInfo',
            'BoardRoundLevel',
            'FrailtyMovements'
        ])->where('camis_patient_id', '=', $camis_patient_id)->first();


        $show_flag_group                    = BoardRoundFlagList::where('show_on_normal_ward', '=', 1)->where('status', '=', 1)->orderBy('patient_flag_group_number_normal_ward', 'ASC')->pluck('patient_flag_group_number_normal_ward')->toArray();

        foreach ($show_flag_group as $flag_group) {
            $flag_array[$flag_group]['group_id'] = $flag_group;
            $flag_array[$flag_group]['flag_list'] = BoardRoundFlagList::where('show_on_normal_ward', '=', 1)->where('status', '=', 1)->where('patient_flag_group_number_normal_ward', $flag_group)->orderBy('patient_flag_group_number_normal_ward', 'ASC')->orderBy('patient_flag_priority_normal_ward', 'ASC')->get()->toArray();
        }



        $board_round_text                                           = 'boardround_' . $patient_info_details->ibox_ward_id . '_' . $user_id;
        $board_round_type                                           = 'boardround_type_' . $patient_info_details->ibox_ward_id . '_' . $user_id;
        $board_round_doctor_id                                      = 'boardround_doctor_' . $patient_info_details->ibox_ward_id . '_' . $user_id;
        $board_round_last_patient                                   = 'boardround_last_patient_' . $patient_info_details->ibox_ward_id . '_' . $user_id;

        $board_round_order                                          = $request->board_round_order;
        $ward_id = $patient_info_details->ibox_ward_id;
        $current_time = Carbon::now();
        $current_hour = $current_time->format('H');
        $frailty_ward_id = Wards::where('ward_short_name', 'RLTFAU')->first()->id;

        $all_frailty_patients = CamisIboxWardPatientInformationWithBedDetailsView::with('FrailtyPosition')->where('camis_patient_ward_id', $frailty_ward_id)->get()->toArray();
        $waiting_area = [];
        $frailty_area = [];
        $other_frailty_postion = [];
        foreach ($all_frailty_patients as $key => $patient) {
            if ((isset($patient['frailty_position']['frailty_bed_id']) && $patient['frailty_position']['frailty_bed_id'] == 0) || !isset($patient['frailty_position']['frailty_bed_id'])) {
                $waiting_area[] = $patient['camis_patient_id'];
            } else {
                $other_frailty_postion[] = $patient;
            }
        }

        $bed_wise_patients = array_reduce($other_frailty_postion, function ($carry, $item) {
            $ward_name = $item['frailty_position']['frailty_bed_id'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($bed_wise_patients);

        $frailty_bed = BedDetails::with('bedGroup')->where('ward_id', $frailty_ward_id)->where('status', 1)->orderBy('bed_priority', 'asc')->get()->toArray();

        foreach ($frailty_bed as $bed) {
            $patient_row = $bed_wise_patients[$bed['id']]['0'] ?? [];

            $bedGroupName = strtolower(str_replace(' ', '', $bed['bed_group']['bed_group_name']));
            if (!empty($patient_row['camis_patient_id'])) {
                if ($bedGroupName === 'frailtyassessmentunit') {
                    $frailty_area[] = $patient_row['camis_patient_id'];
                }
            }
        }



        $all_beds_merged = array_merge($waiting_area, $frailty_area);

        $current_index = array_search($camis_patient_id, $all_beds_merged);
        $prev_patient = $current_index > 0 ? $all_beds_merged[$current_index - 1] : null;
        $next_patient = $current_index !== false && $current_index < count($all_beds_merged) - 1 ? $all_beds_merged[$current_index + 1] : null;




        if (isset($patient_info_details) && isset($patient_info_details->camis_patient_id)) {

            $patient_details       = $patient_info_details->toArray();
        }
        if (count($patient_details) > 0) {

            if ($request->is_boardround == 1) {
                if ($next_patient != null) {
                    Session::put($board_round_last_patient, $next_patient);
                } else {
                    Session::put($board_round_last_patient, $patient_details['camis_patient_id']);
                }
            }
            if (isset($patient_details['frailty_position']['frailty_position']['bed_group'])) {
                $bed_name = $patient_details['frailty_position']['frailty_position']['bed_group']['bed_group_name'] . ' ' . $patient_details['frailty_position']['frailty_position']['bed_actual_name'];
            } else {
                $bed_name = '';
            }
            $patient_details['patient_bed_bay']                         = $bed_name;
            $patient_details['ibox_patient_admit_date_los_value']       = NumberOfDaysBetweenTwoDates($patient_details['camis_patient_admission_date'], date('Y-m-d'));
            $patient_details['ibox_patient_admit_date_los_value_ward']  = NumberOfDaysBetweenTwoDates($patient_details['camis_patient_ward_start_date'], date('Y-m-d'));
            $patient_details['camis_patient_name']                      = ucwords(strtolower(trim($patient_details['camis_patient_name'])));
            $patient_details['camis_consultant_name']                   = ucwords(strtolower(trim($patient_details['camis_consultant_name'])));
            $patient_details['camis_patient_post_code']                 = trim($patient_details['camis_patient_post_code']);
            $patient_details['camis_consultant_code_description']       = ucwords(strtolower(trim($patient_details['camis_consultant_code_description'])));
            $patient_details['camis_consultant_code_description']       = (strlen($patient_details['camis_consultant_code_description']) < 5) ? strtoupper($patient_details['camis_consultant_code_description']) : $patient_details['camis_consultant_code_description'];
            //            $patient_details['total_ward_history_movement']             = CamisIboxWardHistory::select('id')->where('id', $patient_details['camis_patient_id'])->count();
            $los_text_show_head                                         = 'LOS ' . $patient_details['ibox_patient_admit_date_los_value'];
            $los_text_show_head                                        .= ($patient_details['ibox_patient_admit_date_los_value'] > 1) ? ' Days ' : ' Day ';
            $los_text_show_head                                        .= 'Total With ' . $patient_details['ibox_patient_admit_date_los_value_ward'];
            $los_text_show_head                                        .= ($patient_details['ibox_patient_admit_date_los_value_ward'] > 1) ? ' Days ' : ' Day ';
            $los_text_show_head                                        .= 'On This Ward';
            $patient_details['boardround_header_text_value']            = $bed_name . ' - ' . $patient_details['camis_patient_name'] . ' (' . $patient_details['camis_patient_age'] . ') - ' . $los_text_show_head;
            $patient_details['each_patient']                            = $bed_name . ' - ' . $patient_details['camis_patient_name'] . ' (' . $patient_details['camis_patient_age'] . ')';
            $patient_ward_bed_info                                      = Wards::where('id', $patient_details['camis_patient_ward_id'])->first()->ward_name ?? '';

            if (!empty($bed_name)) {
                $patient_details['patient_ward_bed_info'] = $patient_ward_bed_info . ' - ' . $bed_name;
            } else {
                $patient_details['patient_ward_bed_info'] = $patient_ward_bed_info;
            }


            $patient_details['patient_name_age']                        = $patient_details['camis_patient_forename'] . '  ' . $patient_details['camis_patient_surname']  . ' - ' . ' ' . $patient_details['camis_patient_age'] . ' Years';
            $patient_details['patient_los']                             = $los_text_show_head;
            $patient_details['patient_herat_rate']                      = $patient_details['patient_vital_pac_info']['herat_rate_val'] ?? 0;
            $patient_details['patient_ews']                             = $patient_details['patient_vital_pac_info']['totalews'] ?? 0;
            $patient_details['patient_temperature']                     = $patient_details['patient_vital_pac_info']['Temperature_val'] ?? 0;
            $patient_details['patient_weight']                          = $patient_details['patient_vital_pac_info']['patient_weight_details'] ?? 0;


            $patient_details['cpi_details']                          = '--';
        }



        $common_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
        $success_array['patient_details']        = $patient_details;
        $success_array['show_flag_list']         = $flag_array;
        $infection_risk_flag = CamisIboxBoardRoundPatientFlag::where('patient_flag_status_value', 1)->where('patient_flag_name', 'ibox_patient_flag_infection_risk')->where('patient_id', $camis_patient_id)->first();
        $success_array['camis_ic_status'] = 'riskfree';
        $success_array['camis_ic_text'] = 'No Infection';
        $success_array['camis_ic_status'] = 'negetive';
        if ($infection_risk_flag != null) {

            $flag_record = CamisIboxBoardRoundInfectionRisk::where('patient_id', $camis_patient_id)
                ->where('is_primary', 1)
                ->first();

            $primary_flag = $flag_record ? $flag_record->toArray() : [];

            if (!empty($primary_flag)) {
                if ((($primary_flag['infection_type'] == "CONFIRMED" || $primary_flag['infection_type'] == "QUERY"))) {
                    $success_array['camis_ic_status'] = 'posetive';
                    $success_array['camis_ic_text'] = $primary_flag['infection_name'] . ' - ' . ucwords(strtolower($primary_flag['infection_type']));
                } else {
                    if ($primary_flag['infection_type'] == 'CANSTAYINBAY') {
                        $ic_text = 'CAN STAY IN BED';
                    } else {
                        $ic_text = $primary_flag['infection_type'];
                    }
                    $success_array['camis_ic_status'] = 'negetive';
                    $success_array['camis_ic_text'] = $primary_flag['infection_name'] . ' - ' . ucwords(strtolower($ic_text));
                }
            }
        }

        $success_array['group_number_width_arr']  = $show_flag_group;
        $success_array['next_patient']            = $next_patient;
        $success_array['prev_patient']            = $prev_patient;


        $success_array['today']  = Carbon::now();

        $success_array['tomorrow'] = Carbon::now()->addDay();

        $success_array['dayAfterTomorrow']   = Carbon::now()->addDays(2);
        $pharmacy_latest_comment            = CamisIboxBoardRoundPharmacyComment::where('patient_id', $camis_patient_id)->orderBy('id', 'desc')->first()->pharmacy_comment ?? '';
        $success_array["pharmacy_latest_comment"]                   = $pharmacy_latest_comment;

        $success_array['dtoc_path_way_drop']                            = DtocPathway::where('status', '=', 1)->get();
        $success_array['bed_red_reason']                                = BedRedReason::where('status', '=', 1)->get();
        $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();

        $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
            return $carry;
        }, []);

        $frailty_bed = BedDetails::with('bedGroup')
            ->where('ward_id', $frailty_ward_id)
            ->where('status', 1)
            ->orderBy('bed_priority', 'asc')
            ->get()
            ->toArray();

        $bed_wise_patients = array_reduce($frailty_bed, function ($carry, $item) {
            $ward_name = $item['id'];
            $carry[$ward_name][] = $item;
            return $carry;
        }, []);
        ksort($bed_wise_patients);



        $movement_trace = [];

        foreach ($patient_info_details->FrailtyMovements->toArray() as $move) {
            $bedId     = $move['frailty_bed_id'] ?? null;
            $updatedAt = $move['updated_at'] ?? null;
            if (empty($updatedAt)) continue;

            if (is_null($bedId) || (int)$bedId === 0) {
                $area = 'Waiting Area';
            } else {
                $bed_group_name  = $bed_wise_patients[$bedId][0]['bed_group']['bed_group_name'] ?? '';
                $bed_actual_name = $bed_wise_patients[$bedId][0]['bed_actual_name'] ?? '';
                $area = trim(preg_replace('/\s+/', ' ', trim($bed_group_name . ' ' . $bed_actual_name)));
            }

            $movement_trace[] = [
                'area'     => $area,
                'time_raw' => $updatedAt,
                'time'     => PredefinedDateFormatFor24Hour($updatedAt),
            ];
        }

        usort($movement_trace, fn($a, $b) => strtotime($a['time_raw']) <=> strtotime($b['time_raw']));

        if (!empty($movement_trace) && !is_waiting_area($movement_trace[0]['area'])) {
            array_unshift($movement_trace, [
                'area'     => 'Waiting Area',
                'time_raw' => $movement_trace[0]['time_raw'],
                'time'     => $movement_trace[0]['time'],
            ]);
        }

        $compressed = [];
        foreach ($movement_trace as $e) {
            if (empty($compressed)) {
                $compressed[] = $e;
                continue;
            }
            $last = $compressed[count($compressed) - 1];
            if (strcasecmp($last['area'], $e['area']) === 0) {

                continue;
            }
            $compressed[] = $e;
        }

        $movement_data = [];
        for ($i = 0; $i < count($compressed) - 1; $i++) {
            $from = $compressed[$i];
            $to   = $compressed[$i + 1];
            $movement_data[] = "{$from['area']} to {$to['area']} ({$to['time']})";
        }
        $success_array['movement_data'] = $movement_data;








        return view('Dashboards.Camis.WardSummary.FrailtyBoardRoundDataload', compact('success_array'));
    }

    public function SdecBoardRoundData(Request $request)
    {
        $success_array = [];

        $process_array                      = array();
        $success_array                      = array();
        $camis_patient_id                   = CleanString($request->camis_patient_id);
        $group_number_count_arr             = array();
        $patient_details                    = array();
        $flag_array                         = array();
        $user_id                            = Session()->get('LOGGED_USER_ID', '');
        $common_controller = new CommonCamisController;

        if ($request->is_boardround == 1) {
            $ward_summary_controller = new WardSummaryController;
            $ward_summary_controller->InsertBoardRoundData($camis_patient_id);
        }
        $patient_info_details      = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientPosition.SdecPosition.bedGroup',
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_status_value', 1);
            },
            'AllowedToMove',
            'RedGreenBed',
            'RedGreenBed.RedGreenReason',
            'PotentialDefinite',
            'BoardRoundPastMedicalHistory',
            'BoardRoundPatientGoal',
            'BoardRoundTherapyFitData',
            'BoardRoundMedicallyFitData',
            'BoardRoundEstimatedDischargeDate',
            'BoardRoundReasonToReside',
            'BoardRoundReasonToReside.ReasonToResideCategory',
            'BoardRoundTto',
            'BoardRoundEdn',
            'BoardRoundCdt',
            'BoardRoundPharmacyData',
            'BoardRoundAdmittingReason',
            'BoardRoundSocialHistory',
            'BoardRoundWorkingDiagnosis',
            'BoardRoundPathwayRequirement',
            'BoardRoundCareRequirement',
            'BoardRoundDtocComments' => function ($query) {
                $query->orderBy('date', 'DESC');
            },
            'PatientVitalPacInfo',
            'BoardRoundLevel',
            'SdecMovements'
        ])->where('camis_patient_id', '=', $camis_patient_id)->first();





        $show_flag_group                    = BoardRoundFlagList::where('show_on_normal_ward', '=', 1)->where('status', '=', 1)->orderBy('patient_flag_group_number_normal_ward', 'ASC')->pluck('patient_flag_group_number_normal_ward')->toArray();

        foreach ($show_flag_group as $flag_group) {
            $flag_array[$flag_group]['group_id'] = $flag_group;
            $flag_array[$flag_group]['flag_list'] = BoardRoundFlagList::where('show_on_normal_ward', '=', 1)->where('status', '=', 1)->where('patient_flag_group_number_normal_ward', $flag_group)->orderBy('patient_flag_group_number_normal_ward', 'ASC')->orderBy('patient_flag_priority_normal_ward', 'ASC')->get()->toArray();
        }



        $board_round_text                                           = 'boardround_' . $patient_info_details->ibox_ward_id . '_' . $user_id;
        $board_round_type                                           = 'boardround_type_' . $patient_info_details->ibox_ward_id . '_' . $user_id;
        $board_round_doctor_id                                      = 'boardround_doctor_' . $patient_info_details->ibox_ward_id . '_' . $user_id;
        $board_round_last_patient                                   = 'boardround_last_patient_' . $patient_info_details->ibox_ward_id . '_' . $user_id;

        $board_round_order                                          = $request->board_round_order;
        $ward_id = $patient_info_details->ibox_ward_id;
        $current_time = Carbon::now();
        $current_hour = $current_time->format('H');

        $sdec_ward_id = Wards::where('ward_short_name', 'RLTSDECIP')->first()->id;

        $all_sdec_patients = CamisIboxWardPatientInformationWithBedDetailsView::with('PatientPosition')->where('camis_patient_ward_id', $sdec_ward_id)->get()->toArray();
        $waiting_area = [];
        $ed_area = [];
        $planned_area = [];
        $other_sdec_postion = [];
        foreach ($all_sdec_patients as $key => $patient) {
            if ((isset($patient['patient_position']['sdec_bed_id']) && $patient['patient_position']['sdec_bed_id'] == 0) || !isset($patient['patient_position']['sdec_bed_id'])) {
                $waiting_area[] = $patient['camis_patient_id'];
            } else {
                $other_sdec_postion[] = $patient;
            }
        }

        $bed_wise_patients = array_reduce($other_sdec_postion, function ($carry, $item) {
            $ward_name = $item['patient_position']['sdec_bed_id'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($bed_wise_patients);
        $sdec_bed = BedDetails::with('bedGroup')->where('ward_id', $sdec_ward_id)->where('status', 1)->orderBy('bed_priority', 'asc')->get()->toArray();

        foreach ($sdec_bed as $bed) {
            $patient_row = $bed_wise_patients[$bed['id']]['0'] ?? [];

            $bedGroupName = strtolower(str_replace(' ', '', $bed['bed_group']['bed_group_name']));
            if (!empty($patient_row['camis_patient_id'])) {
                if ($bedGroupName === 'edarea') {
                    $ed_area[] = $patient_row['camis_patient_id'];
                } elseif ($bedGroupName === 'plannedarea') {
                    $planned_area[] = $patient_row['camis_patient_id'];
                }
            }
        }



        $all_beds_merged = array_merge($waiting_area, $ed_area, $planned_area);

        $current_index = array_search($camis_patient_id, $all_beds_merged);
        $prev_patient = $current_index > 0 ? $all_beds_merged[$current_index - 1] : null;
        $next_patient = $current_index !== false && $current_index < count($all_beds_merged) - 1 ? $all_beds_merged[$current_index + 1] : null;




        if (isset($patient_info_details) && isset($patient_info_details->camis_patient_id)) {

            $patient_details       = $patient_info_details->toArray();
        }
        if (count($patient_details) > 0) {

            if ($request->is_boardround == 1) {
                if ($next_patient != null) {
                    Session::put($board_round_last_patient, $next_patient);
                } else {
                    Session::put($board_round_last_patient, $patient_details['camis_patient_id']);
                }
            }

            if (isset($patient_details['patient_position']['sdec_position']['bed_group'])) {
                $bed_name = $patient_details['patient_position']['sdec_position']['bed_group']['bed_group_name'] . ' ' . $patient_details['patient_position']['sdec_position']['bed_actual_name'];
            } else {
                $bed_name = '';
            }
            $patient_details['patient_bed_bay']                         = $bed_name;
            $patient_details['ibox_patient_admit_date_los_value']       = NumberOfDaysBetweenTwoDates($patient_details['camis_patient_admission_date'], date('Y-m-d'));
            $patient_details['ibox_patient_admit_date_los_value_ward']  = NumberOfDaysBetweenTwoDates($patient_details['camis_patient_ward_start_date'], date('Y-m-d'));
            $patient_details['camis_patient_name']                      = ucwords(strtolower(trim($patient_details['camis_patient_name'])));
            $patient_details['camis_consultant_name']                   = ucwords(strtolower(trim($patient_details['camis_consultant_name'])));
            $patient_details['camis_patient_post_code']                 = trim($patient_details['camis_patient_post_code']);
            $patient_details['camis_consultant_code_description']       = ucwords(strtolower(trim($patient_details['camis_consultant_code_description'])));
            $patient_details['camis_consultant_code_description']       = (strlen($patient_details['camis_consultant_code_description']) < 5) ? strtoupper($patient_details['camis_consultant_code_description']) : $patient_details['camis_consultant_code_description'];
            //            $patient_details['total_ward_history_movement']             = CamisIboxWardHistory::select('id')->where('id', $patient_details['camis_patient_id'])->count();
            $los_text_show_head                                         = 'LOS ' . $patient_details['ibox_patient_admit_date_los_value'];
            $los_text_show_head                                        .= ($patient_details['ibox_patient_admit_date_los_value'] > 1) ? ' Days ' : ' Day ';
            $los_text_show_head                                        .= 'Total With ' . $patient_details['ibox_patient_admit_date_los_value_ward'];
            $los_text_show_head                                        .= ($patient_details['ibox_patient_admit_date_los_value_ward'] > 1) ? ' Days ' : ' Day ';
            $los_text_show_head                                        .= 'On This Ward';
            $patient_details['boardround_header_text_value']            = $bed_name . ' - ' . $patient_details['camis_patient_name'] . ' (' . $patient_details['camis_patient_age'] . ') - ' . $los_text_show_head;
            $patient_details['each_patient']                            = $bed_name . ' - ' . $patient_details['camis_patient_name'] . ' (' . $patient_details['camis_patient_age'] . ')';
            $patient_ward_bed_info                                      = Wards::where('id', $patient_details['camis_patient_ward_id'])->first()->ward_name ?? '';

            if (!empty($bed_name)) {
                $patient_details['patient_ward_bed_info'] = $patient_ward_bed_info . ' - ' . $bed_name;
            } else {
                $patient_details['patient_ward_bed_info'] = $patient_ward_bed_info;
            }


            $patient_details['patient_name_age']                        = $patient_details['camis_patient_forename'] . '  ' . $patient_details['camis_patient_surname']  . ' - ' . ' ' . $patient_details['camis_patient_age'] . ' Years';
            $patient_details['patient_los']                             = $los_text_show_head;
            $patient_details['patient_herat_rate']                      = $patient_details['patient_vital_pac_info']['herat_rate_val'] ?? 0;
            $patient_details['patient_ews']                             = $patient_details['patient_vital_pac_info']['totalews'] ?? 0;
            $patient_details['patient_temperature']                     = $patient_details['patient_vital_pac_info']['Temperature_val'] ?? 0;
            $patient_details['patient_weight']                          = $patient_details['patient_vital_pac_info']['patient_weight_details'] ?? 0;


            $patient_details['cpi_details']                          = '--';
        }



        $common_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
        $success_array['patient_details']        = $patient_details;
        $success_array['show_flag_list']         = $flag_array;
        $infection_risk_flag = CamisIboxBoardRoundPatientFlag::where('patient_flag_status_value', 1)->where('patient_flag_name', 'ibox_patient_flag_infection_risk')->where('patient_id', $camis_patient_id)->first();
        $success_array['camis_ic_status'] = 'riskfree';
        $success_array['camis_ic_text'] = 'No Infection';
        $success_array['camis_ic_status'] = 'negetive';
        if ($infection_risk_flag != null) {

            $flag_record = CamisIboxBoardRoundInfectionRisk::where('patient_id', $camis_patient_id)
                ->where('is_primary', 1)
                ->first();

            $primary_flag = $flag_record ? $flag_record->toArray() : [];

            if (!empty($primary_flag)) {
                if ((($primary_flag['infection_type'] == "CONFIRMED" || $primary_flag['infection_type'] == "QUERY"))) {
                    $success_array['camis_ic_status'] = 'posetive';
                    $success_array['camis_ic_text'] = $primary_flag['infection_name'] . ' - ' . ucwords(strtolower($primary_flag['infection_type']));
                } else {
                    if ($primary_flag['infection_type'] == 'CANSTAYINBAY') {
                        $ic_text = 'CAN STAY IN BED';
                    } else {
                        $ic_text = $primary_flag['infection_type'];
                    }
                    $success_array['camis_ic_status'] = 'negetive';
                    $success_array['camis_ic_text'] = $primary_flag['infection_name'] . ' - ' . ucwords(strtolower($ic_text));
                }
            }
        }

        $success_array['group_number_width_arr']  = $show_flag_group;
        $success_array['next_patient']            = $next_patient;
        $success_array['prev_patient']            = $prev_patient;


        $success_array['today']  = Carbon::now();

        $success_array['tomorrow'] = Carbon::now()->addDay();

        $success_array['dayAfterTomorrow']   = Carbon::now()->addDays(2);
        $pharmacy_latest_comment            = CamisIboxBoardRoundPharmacyComment::where('patient_id', $camis_patient_id)->orderBy('id', 'desc')->first()->pharmacy_comment ?? '';
        $success_array["pharmacy_latest_comment"]                   = $pharmacy_latest_comment;

        $success_array['dtoc_path_way_drop']                            = DtocPathway::where('status', '=', 1)->get();
        $success_array['bed_red_reason']                                = BedRedReason::where('status', '=', 1)->get();
        $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();

        $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
            return $carry;
        }, []);
        $sdec_bed = BedDetails::with('bedGroup')
            ->where('ward_id', $sdec_ward_id)
            ->where('status', 1)
            ->orderBy('bed_priority', 'asc')
            ->get()
            ->toArray();

        $bed_wise_patients = array_reduce($sdec_bed, function ($carry, $item) {
            $ward_name = $item['id'];
            $carry[$ward_name][] = $item;
            return $carry;
        }, []);
        ksort($bed_wise_patients);


        $movement_trace = [];
        foreach ($patient_info_details->SdecMovements->toArray() as $move) {
            $bedId     = $move['sdec_bed_id'] ?? null;
            $updatedAt = $move['updated_at'] ?? null;
            if (empty($updatedAt)) continue;

            if (is_null($bedId) || (int)$bedId === 0) {
                $area = 'Waiting Area';
            } else {
                $bed_group_name  = $bed_wise_patients[$bedId][0]['bed_group']['bed_group_name'] ?? '';
                $bed_actual_name = $bed_wise_patients[$bedId][0]['bed_actual_name'] ?? '';
                $area = trim(preg_replace('/\s+/', ' ', trim($bed_group_name . ' ' . $bed_actual_name)));
            }

            $movement_trace[] = [
                'area'     => $area,
                'time_raw' => $updatedAt,
                'time'     => PredefinedDateFormatFor24Hour($updatedAt),
            ];
        }
        usort($movement_trace, fn($a, $b) => strtotime($a['time_raw']) <=> strtotime($b['time_raw']));

        if (!empty($movement_trace) && !is_waiting_area($movement_trace[0]['area'])) {
            array_unshift($movement_trace, [
                'area'     => 'Waiting Area',
                'time_raw' => $movement_trace[0]['time_raw'],
                'time'     => $movement_trace[0]['time'],
            ]);
        }


        $compressed = [];
        foreach ($movement_trace as $e) {
            if (empty($compressed)) {
                $compressed[] = $e;
                continue;
            }
            $last = $compressed[count($compressed) - 1];
            if (strcasecmp($last['area'], $e['area']) === 0) {
                continue;
            }
            $compressed[] = $e;
        }
        $movement_data = [];
        for ($i = 0; $i < count($compressed) - 1; $i++) {
            $from = $compressed[$i];
            $to   = $compressed[$i + 1];
            $movement_data[] = "{$from['area']} to {$to['area']} ({$to['time']})";
        }

        $success_array['movement_data'] = $movement_data;
        return view('Dashboards.Camis.WardSummary.SDECBoardRoundDataload', compact('success_array'));
    }

    public function FetchSDECMovementHistory(Request $request)
    {
        $camis_patient_id = $request->input('camis_patient_id');

        $user = User::pluck('username', 'id')->toArray();

        $all_movements_records = HistoryCamisIboxSdecPatientPosition::with('PatientPosition.SdecPosition.bedGroup')->where('camis_patient_id', $camis_patient_id)->orderBy('created_at', 'desc')->get()->toArray();
        $movement_data = [];
        $last_area = null;
        $last_bed = null;
        $area_status = [
            0 => 'Waiting Area',
            1 => 'ED Area',
            2 => 'Planned Area'
        ];
        $sdec_ward_id = Wards::where('ward_short_name', 'RLTSDECIP')->first()->id;
        $sdec_bed = BedDetails::with('bedGroup')->where('ward_id', $sdec_ward_id)->where('status', 1)->orderBy('bed_priority', 'asc')->get()->toArray();
        $bed_wise_patients = array_reduce($sdec_bed, function ($carry, $item) {
            $ward_name = $item['id'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($bed_wise_patients);
        foreach ($all_movements_records as $record) {
            if ($record['sdec_bed_id'] != $last_bed) {
                $current_bed = $area_status[$record['area']];



                if (!isset($current_bed) || $current_bed == 0) {
                    $current_area = 'Waiting Area';
                } else {
                    if (isset($record['patient_position']['sdec_position']['bed_group']['bed_group_name'])) {
                        $bed_group_name = $bed_wise_patients[$record['sdec_bed_id']][0]['bed_group']['bed_group_name'] ?? '';
                        $bed_actual_name = $bed_wise_patients[$record['sdec_bed_id']][0]['bed_actual_name'] ?? '';
                        $current_area = $bed_group_name . ' ' . $bed_actual_name;
                    } else {
                        $current_area = 'Waiting Area';
                    }
                }

                if (!isset($bed_wise_patients[$last_bed])) {
                    $previous_area = 'Waiting Area';
                } else {
                    if (isset($bed_wise_patients[$last_bed]['0']['bed_group']['bed_group_name'])) {
                        $bed_group_name = $bed_wise_patients[$last_bed][0]['bed_group']['bed_group_name'] ?? '';
                        $bed_actual_name = $bed_wise_patients[$last_bed][0]['bed_actual_name'] ?? '';
                        $previous_area = $bed_group_name . ' ' . $bed_actual_name;
                    } else {

                        $previous_area = 'Waiting Area';
                    }
                }



                $movement_data[] = ['patient_name' => $request->patient_name, 'previous_area' => $previous_area, 'current_area' => $current_area ?? '', 'updated_by' => $user[$record['updated_by']] ?? '', 'updated_at' => PredefinedDateFormatFor24Hour($record['updated_at'])];


                $last_area = $record['area'];
                $last_bed = $record['sdec_bed_id'];
            }
        }
        return view('Dashboards.Camis.WardSummary.Modals.SDECPatientMovementData', compact('movement_data'));
    }


    public function UpdateDischargeLoungePostion(Request $request)
    {
        $history_controller                         = new HistoryController;
        $history_modal                              = "App\Models\History\HistoryCamisIboxDischargeLoungePatientPosition";
        $date_time_now                              = CurrentDateOnFormat();
        $patient_positions = $request->input('allPositions');
        foreach ($patient_positions as $patient_data) {
            if(!isset($patient_data['patient_id'])){
                continue;
            }
            $position = $patient_data['position'];
            $camis_patient_id = $patient_data['patient_id'];
            $area = $patient_data['area'];
            $bed_id = $patient_data['bed_id'];

            $gov_text_data = '';
            if ($area == 0) {
                $gov_text_data = 'Waiting Area Position ' . $position;
            } elseif ($area == 1) {
                $gov_text_data = 'Discharge Lounge Assessment ' . $position;
            }

            $user_id                                    = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"]                   = ErrorOccuredMessage();
            $success_array["status"]                    = 0;

            if ($camis_patient_id != "" && $user_id != "") {

                $gov_text_before_arr                    = CamisIboxDischargeLoungePosition::where('camis_patient_id', '=', $camis_patient_id)->first();
                $updated_data                           = CamisIboxDischargeLoungePosition::updateOrCreate(['camis_patient_id' => $camis_patient_id], ['area' => $area, 'position' => $position, 'dischagre_lounge_bed_id' => $bed_id, 'updated_by' => $user_id]);
                $functional_identity                   = 'Discharge Lounge Wards Data';

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]          = DataAddedMessage();
                    $updated_array                     = $updated_data->getOriginal();
                    $gov_text_before                   = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr            = CamisIboxDischargeLoungePosition::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_text_data, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr     = CamisIboxDischargeLoungePosition::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_text_data, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }

                $success_array["status"]                                    = 1;
            }
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdateFrailtyPostion(Request $request)
    {
        $history_controller                         = new HistoryController;
        $history_modal                              = "App\Models\History\HistoryCamisIboxFrailtyPatientPosition";
        $date_time_now                              = CurrentDateOnFormat();
        $patient_positions = $request->input('allPositions');
        foreach ($patient_positions as $patient_data) {
            if(!isset($patient_data['patient_id'])){
                continue;
            }
            $position = $patient_data['position'];
            $camis_patient_id = $patient_data['patient_id'];
            $area = $patient_data['area'];
            $bed_id = $patient_data['bed_id'];

            $gov_text_data = '';
            if ($area == 0) {
                $gov_text_data = 'Waiting Area Position ' . $position;
            } elseif ($area == 1) {
                $gov_text_data = 'Frailty Assessment ' . $position;
            }

            $user_id                                    = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"]                   = ErrorOccuredMessage();
            $success_array["status"]                    = 0;

            if ($camis_patient_id != "" && $user_id != "") {

                $gov_text_before_arr                    = CamisIboxFrailtyPosition::where('camis_patient_id', '=', $camis_patient_id)->first();
                $updated_data                           = CamisIboxFrailtyPosition::updateOrCreate(['camis_patient_id' => $camis_patient_id], ['area' => $area, 'position' => $position, 'frailty_bed_id' => $bed_id, 'updated_by' => $user_id]);
                $functional_identity                   = 'Frailty Wards Data';

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]          = DataAddedMessage();
                    $updated_array                     = $updated_data->getOriginal();
                    $gov_text_before                   = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr            = CamisIboxFrailtyPosition::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_text_data, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr     = CamisIboxFrailtyPosition::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_text_data, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }

                $success_array["status"]                                    = 1;
            }
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdateSDECPostion(Request $request)
    {
        $history_controller                         = new HistoryController;
        $history_modal                              = "App\Models\History\HistoryCamisIboxSdecPatientPosition";
        $date_time_now                              = CurrentDateOnFormat();
        $patient_positions = $request->input('allPositions');
        foreach ($patient_positions as $patient_data) {
            if(!isset($patient_data['patient_id'])){
                continue;
            }
            $position = $patient_data['position'];
            $camis_patient_id = $patient_data['patient_id'];
            $area = $patient_data['area'];
            $bed_id = $patient_data['bed_id'];

            $gov_text_data = '';
            if ($area == 0) {
                $gov_text_data = 'Waiting Area Position ' . $position;
            } elseif ($area == 1) {
                $gov_text_data = 'ED Area Position ' . $position;
            } elseif ($area == 2) {
                $gov_text_data = 'Planned Area Position ' . $position;
            }

            $user_id                                    = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"]                   = ErrorOccuredMessage();
            $success_array["status"]                    = 0;

            if ($camis_patient_id != "" && $user_id != "") {

                $gov_text_before_arr                    = CamisIboxSdecPosition::where('camis_patient_id', '=', $camis_patient_id)->first();
                $updated_data                           = CamisIboxSdecPosition::updateOrCreate(['camis_patient_id' => $camis_patient_id], ['area' => $area, 'position' => $position, 'sdec_bed_id' => $bed_id, 'updated_by' => $user_id]);
                $functional_identity                   = 'SDEC Wards Data';

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]          = DataAddedMessage();
                    $updated_array                     = $updated_data->getOriginal();
                    $gov_text_before                   = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr            = CamisIboxSdecPosition::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_text_data, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr     = CamisIboxSdecPosition::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_text_data, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }

                $success_array["status"]                                    = 1;
            }
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function WardSummaryDataLoad($ward_url)
    {
        $ward_details                                                   = Wards::where('ward_url_name', '=', $ward_url)->where('status', '=', 1)->with('PrimaryWardType')->first();
        $success_array["ward_summary"]                                  = ReturnObjectSingleArrayAsSequentialArray($ward_details);
        $ward_id                                                        = $success_array["ward_summary"]['id'] ?? '';
        $patient_array              = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_status_value', 1);
            },
            'BoardRoundAdmittingReason' => function ($q) {
                $q->select('id', 'patient_id', 'patient_admitting_reason');
            },
            'BoardRoundSocialHistory' => function ($q) {
                $q->select('id', 'patient_id', 'patient_social_history');
            },
            'BoardRoundPatientGoal' => function ($q) {
                $q->select('id', 'patient_id', 'patient_patient_goal');
            },
            'BoardRoundPastMedicalHistory' => function ($q) {
                $q->select('id', 'patient_id', 'patient_past_medical_history');
            },
            'BoardRoundPharmacyData' => function ($q) {
                $q->select('id', 'patient_id', 'pharmacy_drug_history', 'pharmacy_antibiotic_iv_status', 'pharmacy_antibiotic_oral_status', 'pharmacy_latest_comment', 'updated_at');
            },
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment');
            },
            'BoardRoundEstimatedDischargeDate' => function ($q) {
                $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
            },
            'BoardRoundStatus' => function ($q) use ($ward_id) {
                $q->where('ward_id', $ward_id);
            },
            'PatientHandOver',
            'BoardRoundPatientTasks',
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'AllowedToMove',
            'RedGreenBed',
            'RedGreenBed.RedGreenReason',
            'PotentialDefinite',
            'PatientVitalPacInfo',
            'IboxBedStatus',
            'BoardRoundEdn',
            'BoardRoundTto',
            'BoardRoundCdt',
            'BoardRoundPathwayRequirement', 'InfectionRisks'
        ])->where('ibox_ward_id', '=', $ward_id)->where('ibox_bed_type', '=', 'Bed')->get()->toArray();
        $elective   = 0;
        $non_elective = 0;
        $empty_bed_male = 0;
        $empty_bed_female = 0;
        $empty_bed_sideroom = 0;
        $patient_doctor_task = 0;
        $patient_nurse_task = 0;
        $patient_total_handover = 0;
        $patient_edd_1_3_days = 0;
        $patient_edd_4_7_days = 0;
        $patient_edd_8_more_days = 0;
        $patient_definite_discharge_date = 0;
        $patient_definite_potential_date = 0;
        $patient_los_7_13_days = 0;
        $patient_los_14_20_days = 0;
        $patient_los_21_days_more = 0;
        $patient_allowed_to_move_out = 0;
        $patient_allowed_to_move_in = 0;
        $ward_patient_list_array        = array();
        $cdt_confirm_date = 0;
        $priority_task = 0;

        $admitted_today = 0;
        $patient_on_the_ward = ['0_90_minutes' => 0, '91_180_minutes' => 0, '181_240_minutes' => 0, '241_360_minutes' => 0, '361_more_minutes' => 0, '0_3_hours' => 0, '3_6_hours' => 0, '6_more_hours' => 0];

        $total_los_in_minutes = 0;


        $all_bay_status = CamisIboxBoardRoundBayStatus::where('ward_id', $ward_id)->get()->toArray();
        $ward_patient_surname_array = array();
        if (count($patient_array) > 0) {
            foreach ($patient_array as $key => $val) {
                if ($val['camis_patient_surname'] != '') {
                    $ward_patient_surname_array[] =  trim($val['camis_patient_surname']);
                }
            }
        }
        $ward_patient_surname_count_values             = array_count_values($ward_patient_surname_array);

        $patient_count = 0;
        foreach ($patient_array as $row) {
            if (!empty($row['ip_admission_type_description']) && strtolower($row['ip_admission_type_description']) == 'elective') {
                $elective++;
            } elseif (!empty($row['ip_admission_type_description']) && strtolower($row['ip_admission_type_description']) == 'non-elective') {
                $non_elective++;
            }


            if (isset($row['camis_patient_admission_date_time']) && date('Y-m-d', strtotime($row['camis_patient_admission_date_time'])) == date('Y-m-d')) {
                $admitted_today++;
            }



            if (isset($row['allowed_to_move']['patient_allowed_to_be_moved_from']) && strtolower($row['allowed_to_move']['patient_allowed_to_be_moved_from']) == strtolower($ward_url) && strtolower($row['allowed_to_move']['patient_allowed_to_be_moved_to']) != 'do not move') {
                $patient_allowed_to_move_out++;
            }
            $patient_count++;
            if (empty($row['camis_patient_id']) && strtolower($row['ibox_bed_status_camis']) == 'open') {
                $gender = strtolower($row['bay_gender_value']);

                if ($gender == 'female') {
                    $empty_bed_female++;
                } elseif ($gender == 'male') {
                    $empty_bed_male++;
                } elseif ($gender == 'side room') {
                    $empty_bed_sideroom++;
                }
            }
            if (!empty($row['camis_patient_id'])) {
                $patient_total_handover++;
            }

            if (isset($row['board_round_pathway_requirement']['planned_discharge_date']) && date('Y-m-d', strtotime($row['board_round_pathway_requirement']['planned_discharge_date'])) == date('Y-m-d')) {
                $cdt_confirm_date++;
            }
            if (isset($row['board_round_patient_tasks']) && !empty($row['board_round_patient_tasks'])) {
                foreach ($row['board_round_patient_tasks'] as $task_list) {
                    if ($task_list['task_priority'] == 1 && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                        $priority_task++;
                    }

                    if (isset($task_list['patient_task_group']['task_group_name'])) {
                        if (strtolower($task_list['patient_task_group']['task_group_name']) == 'doctor' && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                            $patient_doctor_task++;
                        } else if (strtolower($task_list['patient_task_group']['task_group_name']) == 'nurse' && $task_list['task_completed_status'] == 0 && $task_list['task_not_applicable_status'] == 0) {
                            $patient_nurse_task++;
                        }
                    }
                }
            }


            if (!empty($row['camis_patient_id']) && !empty($row['camis_patient_ward_start_date'])) {
                $ward_start_time = Carbon::parse($row['camis_patient_ward_start_date']);
                $differenceInDays = Carbon::today()->diffInDays($ward_start_time);

                if ($differenceInDays >= 7 && $differenceInDays <= 13) {
                    $patient_los_7_13_days++;
                } elseif ($differenceInDays >= 14 && $differenceInDays <= 20) {
                    $patient_los_14_20_days++;
                } elseif ($differenceInDays >= 21) {
                    $patient_los_21_days_more++;
                }
            }

            if (!empty($row['camis_patient_id'])) {
                $ward_start_time = !empty($row['camis_patient_ward_start_date']) ? Carbon::parse($row['camis_patient_ward_start_date']) : Carbon::parse($row['camis_patient_admission_date_time']);
                $ward_stay_in_mintues = Carbon::now()->diffInMinutes($ward_start_time);
                $ward_stay_in_hours = Carbon::now()->diffInHours($ward_start_time);

                $total_los_in_minutes += $ward_stay_in_mintues;
                if ($ward_stay_in_mintues < 90) {
                    $patient_on_the_ward['0_90_minutes']++;
                } elseif ($ward_stay_in_mintues >= 90 && $ward_stay_in_mintues <= 180) {
                    $patient_on_the_ward['91_180_minutes']++;
                } elseif ($ward_stay_in_mintues >= 181 && $ward_stay_in_mintues <= 240) {
                    $patient_on_the_ward['181_240_minutes']++;
                } elseif ($ward_stay_in_mintues >= 241 && $ward_stay_in_mintues <= 360) {
                    $patient_on_the_ward['241_360_minutes']++;
                } elseif ($ward_stay_in_mintues > 361) {
                    $patient_on_the_ward['361_more_minutes']++;
                }
                if ($ward_stay_in_hours < 3) {
                    $patient_on_the_ward['0_3_hours']++;
                } elseif ($ward_stay_in_hours >= 3 && $ward_stay_in_hours <= 6) {
                    $patient_on_the_ward['3_6_hours']++;
                } elseif ($ward_stay_in_hours > 6) {
                    $patient_on_the_ward['6_more_hours']++;
                }
            }
            if (isset($row['board_round_estimated_discharge_date']['patient_estimated_discharge_date'])) {
                $estimatedDischargeDate = Carbon::parse($row['board_round_estimated_discharge_date']['patient_estimated_discharge_date']);



                $differenceInDays = Carbon::today()->diffInDays($estimatedDischargeDate);

                if ($differenceInDays >= 1 && $differenceInDays <= 3) {
                    $patient_edd_1_3_days++;
                } elseif ($differenceInDays >= 4 && $differenceInDays <= 7) {
                    $patient_edd_4_7_days++;
                } elseif ($differenceInDays >= 8) {
                    $patient_edd_8_more_days++;
                }
            }


            if (isset($row['potential_definite']['type']) && in_array($row['potential_definite']['type'], [2]) && in_array($row['potential_definite']['potential_definite_date'], [Carbon::now()->toDateString()])) {
                $patient_definite_discharge_date++;
            }
            if (isset($row['potential_definite']['type']) && in_array($row['potential_definite']['type'], [1]) && in_array($row['potential_definite']['potential_definite_date'], [Carbon::now()->toDateString()])) {
                $patient_definite_potential_date++;
            }


            $bay                         = ($row['ibox_bed_group_number'] != 0) ? $row['ibox_bed_group_name'] . ' ' . $row['ibox_bed_group_number'] : $row['ibox_bed_group_name'];





            $row['patient_bed_bay']                         = ($row['ibox_bed_group_number'] != 0) ? $row['ibox_bed_group_name'] . ' ' . $row['ibox_bed_group_number'] : $row['ibox_bed_group_name'];
            $row['ibox_patient_admit_date_los_value']       = NumberOfDaysBetweenTwoDates($row['camis_patient_admission_date'], date('Y-m-d'));


            $ward_start = $row['camis_patient_ward_start_date'];

            if (!empty($ward_start) && strtotime($ward_start)) {
                $row['ibox_patient_admit_date_los_value_hour'] = NumberOfHoursBetweenTwoDates($ward_start, CurrentDateOnFormat());
            } else {
                $row['ibox_patient_admit_date_los_value_hour'] = NumberOfHoursBetweenTwoDates($row['camis_patient_admission_date_time'], CurrentDateOnFormat());
            }


            $row['ibox_patient_admit_date_los_value_ward_hour']  = NumberOfHoursBetweenTwoDates($row['camis_patient_ward_start_date'], CurrentDateOnFormat());
            $row['ibox_patient_admit_date_los_value_ward']  = NumberOfDaysBetweenTwoDates($row['camis_patient_ward_start_date'], date('Y-m-d'));
            $row['camis_consultant_name']                   = ucwords(strtolower(trim($row['camis_consultant_name'])));
            $row['camis_patient_post_code']                 = trim($row['camis_patient_post_code']);
            $row['camis_consultant_code_description']       = ucwords(strtolower(trim($row['camis_consultant_code_description'])));
            $row['camis_consultant_code_description']       = (strlen($row['camis_consultant_code_description']) < 5) ? strtoupper($row['camis_consultant_code_description']) : $row['camis_consultant_code_description'];
            $row['flags']                                   = $row['patient_wise_flags'];
            $row['ibox_patient_hide_name']                           = 'Patient ' . WardBedShowPatientCharacter($patient_count);

            $bay_status = null;
            foreach ($all_bay_status as $status_row) {
                if (
                    $status_row['ibox_bed_group_id'] == $row['ibox_bed_group_id'] &&
                    $status_row['ibox_bed_group_number'] == $row['ibox_bed_group_number']
                ) {
                    $bay_status = $status_row['status'];
                    break;
                }
            }

            $row['bay_status'] = $bay_status;
            if (!empty($row['camis_patient_surname'])) {
                $row['ibox_patient_surname_count']                   = $ward_patient_surname_count_values[trim($row['camis_patient_surname'])];
            }
            $ward_patient_list_array[$bay][] = $row;
        }
        if (session()->has('patient_ids_' . $ward_id)) {
            $total =  $patient_total_handover - count(session()->get('patient_ids_' . $ward_id));
            $success_array["total_handover"] = $total;
        } else {
            $success_array["total_handover"] = $patient_total_handover;
        }

        $success_array['daily_target']  = $success_array['ward_summary']['ward_daily_goal'];
        $current_date = Carbon::now();



        $allowed_to_move_table = CamisIboxBoardRoundAllowedToMove::ReturnTableName();
        $patients_table = CamisIboxWardPatientInformationWithBedDetailsView::ReturnTableName();
        $patient_allowed_to_move_in = CamisIboxBoardRoundAllowedToMove::join($patients_table, function ($join) use ($allowed_to_move_table, $patients_table) {
            $join->on("{$allowed_to_move_table}.patient_id", '=', "{$patients_table}.camis_patient_id")
                ->whereRaw("LOWER({$patients_table}.ibox_ward_short_name) = LOWER({$allowed_to_move_table}.patient_allowed_to_be_moved_from)");
        })
            ->whereRaw('LOWER(patient_allowed_to_be_moved_to) = ?', [strtolower($ward_details->ward_url_name)])
            ->count();
        $start_of_current_week = $current_date->startOfWeek()->format('Y-m-d H:i:s');
        $end_of_current_week = $current_date->endOfWeek()->format('Y-m-d 11:59:s');
        $out_patients_records = CamisIboxWardWeeklyDischarge::select('camis_patient_id', 'dayname')->where('camis_patient_ward_id', $ward_id)

            ->whereBetween('camis_patient_discharge_date_time', [$start_of_current_week, $end_of_current_week])

            ->orderBy('camis_patient_discharge_date_time', 'desc')
            ->get()->toArray();

        $day_wise_counts = [
            'monday'    => 0,
            'tuesday'   => 0,
            'wednesday' => 0,
            'thursday'  => 0,
            'friday'    => 0,
            'saturday'  => 0,
            'sunday'    => 0,
        ];
        foreach ($out_patients_records as $item) {
            $dayname = strtolower($item['dayname']);
            if (array_key_exists($dayname, $day_wise_counts)) {
                $day_wise_counts[$dayname]++;
            }
        }
        $success_array['show_on_ward_summary_status_check']             = BoardRoundFlagList::where('show_on_normal_ward', 1)->where('show_flag_on_main_ward_summary', '=', 1)->pluck('patient_flag_name', 'patient_flag_stored_name')->toArray();

        $success_array['weekly_discharges_total'] = count($out_patients_records);
        $success_array['weekly_discharges'] = $day_wise_counts;
        $success_array['ward_patient_list_array'] = $ward_patient_list_array;
        $success_array['allowed_to_move_in_from_reserved']             = CamisIboxBoardRoundBedStatus::select('id')->where('status', 4)->where('ward_id', $ward_id)->count();
        $success_array['empty_bed_male'] = $empty_bed_male;
        $success_array['empty_bed_female'] = $empty_bed_female;
        $success_array['empty_bed_sideroom'] = $empty_bed_sideroom;
        $success_array['patient_doctor_task'] = $patient_doctor_task;
        $success_array['patient_nurse_task'] = $patient_nurse_task;
        $success_array['average_los_in_minutes'] = ($patient_total_handover > 0) ? ($total_los_in_minutes / $patient_total_handover) : 0;
        $success_array['patient_total_handover'] = $success_array['total_handover'];
        $success_array['patient_edd_1_3_days'] = $patient_edd_1_3_days;
        $success_array['patient_edd_4_7_days'] = $patient_edd_4_7_days;
        $success_array['patient_edd_8_more_days'] = $patient_edd_8_more_days;
        $success_array['patient_definite_discharge_date'] = $patient_definite_discharge_date;
        $success_array['patient_definite_potential_date'] = $patient_definite_potential_date;
        $success_array['patient_los_7_13_days'] = $patient_los_7_13_days;
        $success_array['patient_los_14_20_days'] = $patient_los_14_20_days;
        $success_array['patient_los_21_days_more'] = $patient_los_21_days_more;
        $success_array['patient_allowed_to_move_out'] = $patient_allowed_to_move_out;
        $success_array['patient_allowed_to_move_in'] = $patient_allowed_to_move_in;
        $success_array['cdt_confirm_date']   = $cdt_confirm_date;
        $success_array['priority_task']   = $priority_task;
        $success_array['ward_id']            = $ward_id;
        $success_array['ward_url']            = $ward_url;

        $success_array['ane_opel_status'] = GetANEOpelStatus();

        $last_board_round                                               = CamisIboxWardRound::where('ward_id', $ward_id)->latest()->first();
        if ($last_board_round != null) {
            $LastBoardRoundTime = strtotime($last_board_round->updated_at);
            $currentTimestamp = time();
            $todayStart = strtotime('today', $currentTimestamp);
            $yesterdayStart = strtotime('yesterday', $currentTimestamp);

            if ($LastBoardRoundTime >= $todayStart) {
                $formattedTime = date("H:i", $LastBoardRoundTime);
                $success_array['ward_last_boardround'] = 'LAST BOARD ROUND: <span class="text-info">' . $formattedTime . '</span> TODAY';
            } elseif ($LastBoardRoundTime >= $yesterdayStart) {
                $formattedTime = date("H:i", $LastBoardRoundTime);
                $success_array['ward_last_boardround'] = 'LAST BOARD ROUND: <span class="text-info">' . $formattedTime . '</span> YESTERDAY';
            } else {
                $formattedTime = date("H:i", $LastBoardRoundTime);
                $success_array['ward_last_boardround'] = 'LAST BOARD ROUND: <span class="text-info">' . $formattedTime . '</span> ' . PredefinedDateFormatShowOnCalendarWithoutDay(date('Y-m-d', $LastBoardRoundTime)) . ' ';
            }
        } else {
            $success_array['ward_last_boardround'] = 'LAST BOARD ROUND: <span class="text-info">N/A</span>';
        }
        $task_group = TaskGroup::where('status', 1);
        $nurse_task = $task_group->where(DB::raw('LOWER(task_group_name)'), strtolower('Nurse'))->first();
        $doctor_task = $task_group->where(DB::raw('LOWER(task_group_name)'), strtolower('Doctor'))->first();




        $success_array['admitted_today'] = $admitted_today;
        $success_array['discharged_today'] = CamisIboxPatientInformationDetails::where('camis_patient_ward_id', $ward_id)->whereDate('camis_patient_discharge_date_time', Carbon::today())->count();
        $success_array['stay_in_minutes'] = $patient_on_the_ward;
        $success_array['nurse_task_id'] = $nurse_task->id ?? '39';
        $success_array['doctor_task_id'] = $doctor_task->id ?? '37';
        $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();
        $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
            return $carry;
        }, []);
        $success_array['ward_array_full_name'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_name']) ? $ward_data['ward_name'] : $ward_data['ward_shown_name'];
            return $carry;
        }, []);


        $still_in_ane_patients_list                                         = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
        $dta_patients_array                                                 = array();
        $dta_without_allocated_bed_patients_array                           = array();
        $ane_patients_awaiting_allocation                                   = array();
        $ane_patients_to_sau                                                = array();
        if (CheckCountArrayToProcess($still_in_ane_patients_list)) {
            foreach ($still_in_ane_patients_list as $row) {
                if (isset($row["symphony_request_date"])) {
                    if ($row["symphony_request_date"] != "") {
                        $dta_patients_array[] = $row;
                        if (isset($row["symphony_dta_ward"])) {
                            if ($row["symphony_dta_ward"] == "") {
                                $dta_without_allocated_bed_patients_array[] = $row;
                            }
                        } else {
                            $dta_without_allocated_bed_patients_array[] = $row;
                        }
                    }
                }
            }
        }
        $success_array['in_ed_now']          = count($still_in_ane_patients_list);
        $success_array['total_dta_patients'] = count($dta_patients_array);
        $success_array['total_without_bed'] = SymphonyAneAttendanceView::where('symphony_discharge_ward', 'sau inpatient')->where(function ($query) {
            $query->whereNull('symphony_dta_ward')
                ->orWhere('symphony_dta_ward', '');
        })->count();
        $success_array['ane_patients_to_sau'] = SymphonyAneAttendanceView::where('symphony_discharge_ward', 'sau inpatient')
            ->count();
        $success_array['ane_opel_status']    = GetANEOpelStatus();
        $success_array['ane_opel_class']     = 'bg-opel-' . GetANEOpelStatus();
        $success_array['ane_opel_text']      =  'A&E EMS ' . GetANEOpelStatus();
        $success_array['ward_opel_status']   = GetWardOpelStatusClass();
        $success_array['ward_opel_class']     = 'bg-opel-' . GetWardOpelStatusClass();
        $success_array['ward_opel_text']     =  'GEH EMS ' . GetWardOpelStatus();
        $success_array['elective_count']     = $elective;
        $success_array['non_elective_count'] = $non_elective;


        $html_view                                                           = View::make('Dashboards.Camis.WardSummary.IndexDataLoad', compact('success_array'));
        $success_array['html_sections']                                      = $html_view->render();


        return ReturnArrayAsJsonToScript($success_array);
    }




    public function FetchPDPatients(Request $request)
    {


        $patient_pd_list = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $request->ward_id)->with([
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_status_value', 1);
            },
            'BoardRoundAdmittingReason' => function ($q) {
                $q->select('id', 'patient_id', 'patient_admitting_reason');
            },
            'BoardRoundSocialHistory' => function ($q) {
                $q->select('id', 'patient_id', 'patient_social_history');
            },
            'BoardRoundPharmacyData' => function ($q) {
                $q->select('id', 'patient_id', 'pharmacy_drug_history', 'pharmacy_antibiotic_iv_status', 'pharmacy_antibiotic_oral_status', 'pharmacy_latest_comment', 'updated_at');
            },
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment');
            },
            'BoardRoundEstimatedDischargeDate' => function ($q) {
                $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
            },
            'PatientHandOver',
            'BoardRoundPatientTasks' => function ($q) {
                $q->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('id', 'asc');
            },
            'BoardRoundPatientTasks',
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'AllowedToMove',
            'RedGreenBed',
            'RedGreenBed.RedGreenReason',
            'PotentialDefinite',
            'PatientVitalPacInfo',
        ])->get()->toArray();

        $patients = array();

        foreach ($patient_pd_list as $row) {
            if ($request->type == 'definite') {
                if (isset($row['potential_definite']['type']) && in_array($row['potential_definite']['type'], [2]) && in_array($row['potential_definite']['potential_definite_date'], [Carbon::now()->toDateString()])) {
                    $patients[] = $row;
                }
            } else {
                if (isset($row['potential_definite']['type']) && in_array($row['potential_definite']['type'], [1]) && in_array($row['potential_definite']['potential_definite_date'], [Carbon::now()->toDateString()])) {
                    $patients[] = $row;
                }
            }
        }

        $success_array['patient_list'] = $patients;
        $success_array['type'] = $request->type;

        $success_array['show_on_ward_summary_status_check_all']         = BoardRoundFlagList::where('show_on_normal_ward', 1)->pluck('patient_flag_name', 'patient_flag_stored_name')->toArray();

        $html_view                                                      = View::make('Dashboards.Camis.WardSummary.Modals.PDDataLoad', compact('success_array'));
        $success_array['html_sections']                                 = $html_view->render();
        return ReturnArrayAsJsonToScript($success_array);
    }



    public function FetchAllowedToMoveIn(Request $request)
    {
        $success_array['allowed_to_move_in_from_reserved']             = CamisIboxBoardRoundBedStatus::with(['PatientInformationWithBedDetails', 'PatientCurrentData', 'ReservedData'])->where('status', 4)->where('ward_id', $request->ward_id)->get()->toArray();

        $allowed_to_move_table = CamisIboxBoardRoundAllowedToMove::ReturnTableName();
        $patients_table = CamisIboxWardPatientInformationWithBedDetailsView::ReturnTableName();
        $ward_details                                                   = Wards::where('id', '=', $request->ward_id)->where('status', '=', 1)->with('PrimaryWardType')->first();
        $success_array['patient_move_in'] = CamisIboxBoardRoundAllowedToMove::join($patients_table, function ($join) use ($allowed_to_move_table, $patients_table) {
            $join->on("{$allowed_to_move_table}.patient_id", '=', "{$patients_table}.camis_patient_id")
                ->whereRaw("LOWER({$patients_table}.ibox_ward_short_name) = LOWER({$allowed_to_move_table}.patient_allowed_to_be_moved_from)");
        })
            ->whereRaw('LOWER(patient_allowed_to_be_moved_to) = ?', [strtolower($ward_details->ward_url_name)])
            ->get(["{$allowed_to_move_table}.*", "{$patients_table}.*"])
            ->toArray();
        $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();
        $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
            return $carry;
        }, []);
        $success_array['ward_array_full_name'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_name']) ? $ward_data['ward_name'] : $ward_data['ward_shown_name'];
            return $carry;
        }, []);
        $html_view                                                      = View::make('Dashboards.Camis.WardSummary.Modals.AllowedToMoveInData', compact('success_array'));
        $success_array['html_sections']                                 = $html_view->render();
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function FetchAllowedToMoveOut(Request $request)
    {
        $ward_details                                                   = Wards::where('id', '=', $request->ward_id)->where('status', '=', 1)->with('PrimaryWardType')->first();
        $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();
        $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
            return $carry;
        }, []);
        $success_array['ward_array_full_name'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_name']) ? $ward_data['ward_name'] : $ward_data['ward_shown_name'];
            return $carry;
        }, []);
        $patient_ids                                                    = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $request->ward_id)->pluck('camis_patient_id')->toArray();
        $success_array['patient_move_out']                              = CamisIboxBoardRoundAllowedToMove::whereIn('patient_id', $patient_ids)->with('PatientInformationWithBedDetails')->whereRaw('LOWER(patient_allowed_to_be_moved_from) = ?', [strtolower($ward_details->ward_short_name)])->whereRaw('LOWER(patient_allowed_to_be_moved_to) != ?', [strtolower('Do Not Move')])->get()->toArray();
        $html_view                                                      = View::make('Dashboards.Camis.WardSummary.Modals.AllowedToMoveOutData', compact('success_array'));
        $success_array['html_sections']                                 = $html_view->render();
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function FetchPatientPriorityTask(Request $request)
    {
        $all_inpatients = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->select('camis_patient_id', 'camis_patient_name', 'ibox_actual_bed_full_name', 'camis_patient_pas_number')->where('camis_patient_ward_id', $request->ward_id)->with([
            'BoardRoundPatientTasks' => function ($q) {
                $q->where('task_priority', 1)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('created_at', 'desc');
            },
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory'
        ])->get()->toArray();
        $task_list = array();
        foreach ($all_inpatients as $patient) {



            $priority_task_list = array_filter($patient['board_round_patient_tasks'], function ($task) {
                return ($task['task_priority'] == 1 && $task['task_completed_status'] == 0 && $task['task_not_applicable_status'] == 0);
            });

            if (count($priority_task_list) > 0) {
                $key_name = $patient['camis_patient_name'] . '-' . $patient['ibox_actual_bed_full_name'];
                $task_array['tasks'] = $priority_task_list;
                $task_array['bed'] = $key_name;
                $task_list[] = $task_array;
            }
        }
        $html_view                                                      = View::make('Dashboards.Camis.WardSummary.WardSummaryModals.PriorityTaskData', compact('task_list'));
        return $html_view->render();
    }


    public function BoardRoundConfig(Request $request)
    {
        $ward_id = $request->camis_ward_id;
        $success_array['ward_details']                                                   = Wards::where('id', '=', $ward_id)->where('status', '=', 1)->with('PrimaryWardType')->first();
        $patient_details   = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->where('camis_consultant_code', '!=', null)->get()->toArray();
        $name_array = array_filter(array_unique(array_column($patient_details, 'camis_consultant_name')), function ($value) {
            return $value !== null;
        });
        $new_keys = array_map(function ($value) {
            return str_replace(' ', '_ibox_', $value);
        }, $name_array);

        $combined_array = array_combine($new_keys, $name_array);

        $success_array['consultnat_list'] = $combined_array;
        $success_array['user_id']                                       = Session()->get('LOGGED_USER_ID', '');
        $missed_patient_list = array();

        $start_date = Carbon::now()->subDays(7);

        $success_array['stranded_patient'] = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->whereNotNull('camis_patient_id')
            ->where('camis_patient_ward_start_date', '<=', $start_date)
            ->get()->count();

        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $ward_id                                                    = $request->camis_ward_id;

        $board_round_text                                           = 'boardround_' . $ward_id . '_' . $user_id;
        $board_round_type                                           = 'boardround_type_' . $ward_id . '_' . $user_id;
        $board_round_doctor_id                                      = 'boardround_doctor_' . $ward_id . '_' . $user_id;
        $board_round_last_patient                                   = 'boardround_last_patient_' . $ward_id . '_' . $user_id;
        $doctor_code = str_replace(' ', '_ibox_', Session::get($board_round_doctor_id));


        $base_patient_query = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->whereNotNull('camis_patient_id');

        $patient = clone $base_patient_query;


        $patient = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->whereNotNull('camis_patient_id');
        if (Session::has($board_round_type) && Session::get($board_round_type) == 'stranded') {
            $patient = $patient->whereDate('camis_patient_admission_date', '<=', $start_date);
        } elseif (Session::has($board_round_type) && Session::get($board_round_type) == 'doctor') {
            $patient = $patient->where('camis_consultant_name', str_replace('_ibox_', ' ', Session::get($board_round_doctor_id)));
        }
        $patient = $patient->pluck('camis_patient_id')->toArray();
        $current_time = Carbon::now();
        $current_hour = $current_time->format('H');
        $done_board_round = array();
        if (Session::has('board_round_time')) {
            $boardround_data = Session::get('board_round_time');

            if ($current_hour >= 0 && $current_hour <= 11) {
                $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                    ->where('ward_id', $ward_id)
                    ->whereDate('updated_at', now()->toDateString())
                    ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '00' AND '11'")
                    ->pluck('patient_id')->toArray();
            } else {
                $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                    ->where('ward_id', $ward_id)
                    ->whereDate('updated_at', now()->toDateString())
                    ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '12' AND '23'")
                    ->pluck('patient_id')->toArray();
            }
            $remaing_patients = array_diff($patient, $existing_query);
            if (count($remaing_patients) > 0 && Session::has('boardround_data') && Session::get('boardround_data') == $board_round_text) {
                $missed_patient_list = CamisIboxWardPatientInformationWithBedDetailsView::whereNotIn('camis_patient_id', $existing_query)->where('ibox_ward_id', $ward_id)
                    ->where('ibox_bed_type', '=', 'Bed')
                    ->limit(1500)
                    ->get()->toArray();
                $success_array['status'] = 0;
            } else {
                $success_array['status'] = 1;
            }

            $all_patients = clone $base_patient_query;

            $all_patients = $all_patients->select('camis_patient_id', 'camis_consultant_name')->get()->toArray();

            foreach ($success_array['consultnat_list'] as $consultant_name => $value) {
                $transformed_consultant_name = strtolower(str_replace('_ibox_', ' ', $consultant_name));

                $consultant_patients = array_filter($all_patients, function ($item) use ($transformed_consultant_name) {
                    return (strtolower($item['camis_consultant_name']) === $transformed_consultant_name);
                });
                if (empty(array_diff(array_column($consultant_patients, 'camis_patient_id'), $existing_query))) {
                    array_push($done_board_round, $consultant_name);
                }
            }
        } else {
            $success_array['status'] = 0;
        }
        $success_array['done_board_round'] = $done_board_round;
        $success_array['missed_patient_list'] = $missed_patient_list;
        $success_array['done_board_round'] = $done_board_round;

        $view                                                           = View::make('Dashboards.Camis.WardSummary.Modals.BoardroundData', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }


    public function Boardround(Request $request, $ward_id, $patient_id)
    {
        $process_array                                                  = array();
        $success_array                                                  = array();
        $process_array["ward"]                                          = ($ward_id != '') ? strtolower($ward_id) : '';
        $process_array["patient"]                                       = ($patient_id != '') ? $patient_id : '';


        if (Sentinel::getUser() && !is_numeric(Sentinel::getUser()->user_type)) {
            if (Sentinel::getUser()->user_type != $ward_id) {
                return redirect()->route('ward.ward-details', Sentinel::getUser()->user_type);
            }
        } elseif (Sentinel::getUser() && Sentinel::getUser()->user_type == 2) {
            return redirect()->route('ane.livestatus');
        }



        $ward_details                                                   = Wards::where('ward_url_name', '=', $ward_id)->where('status', '=', 1)->with('PrimaryWardType')->first();
        $success_array["ward_summary"]                                  = ReturnObjectSingleArrayAsSequentialArray($ward_details);

        $success_array['ward_details']                                  = $ward_details;
        $success_array['ward_name'] = $ward_id;
        $success_array['aki_task']                                      = BoardRoundUserTaskAkiAssessmentTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['nof_task']                                      = BoardRoundUserTaskNofTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['dp_task']                                       = DpTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
        $success_array['sepsis_task']                                   = BoardRoundUserTaskSepsisTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

        $success_array['reason_to_reside']                              = ReasonToResideGroup::where('status', 1)->get();
        $red_bed_reason_array                                           = BedRedReason::where('status', '=', 1)->orderBy('red_text_value', 'asc')->pluck('red_text_value', 'id')->toArray();

        $no_red_bed_reason = ArrayFilter($red_bed_reason_array, function ($item) {


            return strtolower($item) == 'no reason';
        });

        $other_red_bed_reason = ArrayFilter($red_bed_reason_array, function ($item) {


            return strtolower($item) != 'no reason';
        });

        $success_array['bed_red_reason'] = $no_red_bed_reason + $other_red_bed_reason;
        $success_array['all_flags']                                     = BoardRoundFlagList::where('show_on_normal_ward', 1)->pluck('patient_flag_stored_name')->toArray();
        $success_array['nof_task']                                      = BoardRoundUserTaskNofTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

        $success_array['infection_control'] = InfectionControl::where('status', 1)->orderBy('infection_list_show_data_name', 'asc')->get();
        $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();
        $success_array['ward_array'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
            return $carry;
        }, []);
        $success_array['ward_array_full_name'] = array_reduce($all_wards, function ($carry, $ward_data) {
            $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_name']) ? $ward_data['ward_name'] : $ward_data['ward_shown_name'];
            return $carry;
        }, []);
        $patient_info_details      = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_status_value', 1);
            },
            'AllowedToMove',
            'RedGreenBed',
            'RedGreenBed.RedGreenReason',
            'PotentialDefinite',
            'BoardRoundPastMedicalHistory',
            'BoardRoundPatientGoal',
            'BoardRoundMedicallyFitData',
            'BoardRoundTherapyFitData',
            'BoardRoundEstimatedDischargeDate',
            'BoardRoundReasonToReside',
            'BoardRoundReasonToReside.ReasonToResideCategory',
            'BoardRoundTto',
            'BoardRoundEdn',
            'BoardRoundCdt',
            'BoardRoundPharmacyData',
            'BoardRoundAdmittingReason',
            'BoardRoundSocialHistory',
            'BoardRoundWorkingDiagnosis',
            'BoardRoundPathwayRequirement',
            'BoardRoundCareRequirement',
            'BoardRoundDtocComments' => function ($query) {
                $query->orderBy('date', 'DESC');
            },
            'PatientVitalPacInfo',
            'BoardRoundLevel'
        ])->where('camis_patient_id', '=', $patient_id)->first();
        if ($patient_info_details == null) {
            Toastr::warning('No Inpatient Found');
            return back();
        }

        return view('Dashboards.Camis.WardSummary.Boardround', compact('success_array'));
    }



    public function HandOverDetailsModal(Request $request)
    {
        if (CheckSpecificPermission('camis_handover_modal_view')) {
            $process_array                                                  = array();
            $success_array                                                  = array();

            $process_array['ward_id']  = $request->ward_id;
            $process_array['patient_id']  = $request->patient_id;
            if ($process_array['patient_id'] != null) {
                $process_array['camis_patient_id'] =  $process_array['patient_id'];
            } else {
                $patient_id =   CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $process_array['ward_id'])->where('camis_patient_id', '!=', null)->first();
                $process_array['camis_patient_id'] = $patient_id['camis_patient_id'];
            }

            if (($request->group_name != null) && ($request->group_number != null) && ($request->bed_no != null) && ($process_array['ward_id'] != null)) {
                $patient_id =   CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $process_array['ward_id'])->where('ibox_bed_no', $request->bed_no)->where('ibox_bed_group_name', $request->group_name)->where('ibox_bed_group_number', $request->group_number)->first();
                $process_array['camis_patient_id'] = $patient_id['camis_patient_id'];
            }

            if ($request->button_type != null) {
                $save_value =   $this->SaveHandOverDetailsData($request);
                $process_array['camis_patient_id'] = $save_value['camis_patient_id'];
            }
            $storedUserData =  session('patient_ids_' . $process_array['ward_id'], []);

            $bed_order      =  CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $process_array['ward_id'])->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();
            $bed_navigation_no =  CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $process_array['ward_id'])->select('camis_patient_id', 'ibox_bed_group_name', 'ibox_bed_group_number', 'ibox_bed_no')->get()->toArray();
            $bed_navigation =  CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $process_array['ward_id'])->select('ibox_bed_group_name', 'ibox_bed_group_number')->distinct()->orderBy('ibox_bed_group_name', 'ASC')->orderBy('ibox_bed_group_number', 'ASC')->get();

            $currentBedIndex = array_search($process_array['camis_patient_id'], $bed_order);


            $next_patient = null;
            if ($currentBedIndex !== false && $currentBedIndex < count($bed_order) - 1) {
                $next_patient = $bed_order[$currentBedIndex + 1];
            }

            $prev_patient = null;
            if ($currentBedIndex !== false && $currentBedIndex > 0) {
                $prev_patient = $bed_order[$currentBedIndex - 1];
            }


            $patient_array              = CamisIboxWardPatientInformationWithBedDetailsView::with([
                'PatientWiseFlags' => function ($q) {
                    $q->where('patient_flag_status_value', 1);
                },
                'BoardRoundAdmittingReason' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_admitting_reason');
                },
                'BoardRoundSocialHistory' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_social_history');
                },
                'BoardRoundPharmacyData' => function ($q) {
                    $q->select('id', 'patient_id', 'pharmacy_drug_history', 'pharmacy_antibiotic_iv_status', 'pharmacy_antibiotic_oral_status', 'pharmacy_latest_comment', 'updated_at');
                },
                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment');
                },
                'BoardRoundTherapyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_therapy_fit_status');
                },
                'BoardRoundEstimatedDischargeDate' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
                },
                'PatientHandOver',
                'BoardRoundPatientTasks' => function ($q) {
                    $q->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('created_at', 'desc');
                },
                'BoardRoundPatientTasks.PatientTaskGroup',
                'BoardRoundPatientTasks.PatientTaskCategory',
                'AllowedToMove',
                'RedGreenBed',
                'RedGreenBed.RedGreenReason',
                'PotentialDefinite',
                'BoardRoundPatientGoal',
                'BoardRoundPastMedicalHistory'

            ])->where('ibox_ward_id', $process_array['ward_id'])
                ->whereNotNull('camis_patient_id')
                ->where('camis_patient_id', $process_array['camis_patient_id'])
                ->first();
            $patient_ids = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_ward_id', $process_array['ward_id'])->pluck('camis_patient_id')->toArray();
            if (session()->has('patient_ids_' . $process_array['ward_id'])) {
                $total =  count($patient_ids) - count(session()->get('patient_ids_' . $process_array['ward_id']));
                $process_array["total_handover"] = $total;
            } else {
                $process_array["total_handover"] = count($patient_ids);
            }

            $success_array['total_handover'] = $process_array["total_handover"];
            $success_array['patient_details'] = $patient_array;
            $success_array['bed_navigation'] = $bed_navigation;
            $success_array['bed_navigation_no'] = $bed_navigation_no;
            $success_array['next_patient'] = $next_patient;
            $success_array['previous_patient'] = $prev_patient;
            $success_array['patients_data'] = $storedUserData;
            $success_array['camis_patient_date_of_birth']            = PredefinedDobDateAlone($patient_array['camis_patient_date_of_birth']);
            $success_array['los_value']                              = NumberOfDaysBetweenTwoDates($patient_array['camis_patient_admission_date'], date('Y-m-d'));
            $success_array['camis_patient_los']                      = $success_array['los_value'] > 1 ? $success_array['los_value'] . ' Days ' : $success_array['los_value'] . ' Day ';
            $success_array['los_ward_value']                         = Carbon::parse($patient_array['camis_patient_ward_start_date'])->diffInDays(Carbon::now());
            $success_array['camis_patient_los_ward']                 = $success_array['los_ward_value'] > 1 ? $success_array['los_ward_value'] . ' Days ' : $success_array['los_ward_value'] . ' Day ';
            $success_array['camis_patient_bed_group']                = ucfirst($patient_array['ibox_bed_group_name']) . ' ' . ($patient_array['ibox_bed_group_number'] != 0 ? $patient_array['ibox_bed_group_number'] : '');
            $success_array['red_bed_reason_list']                    = BedRedReason::where('status', 1)->pluck('red_text_value', 'id')->toArray();

            return view('Dashboards.Camis.WardSummary.WardSummaryModals.HandoverDetailsModalContent', compact('success_array'));
        } else {
            return PermissionDenied();
        }
    }


    public function SaveHandOverDetailsData($process_data)
    {
        try {
            DB::beginTransaction();
            $history_controller                                         = new HistoryController;
            $history_modal                                              = "App\Models\History\HistoryCamisIboxPatientHandOver";
            $date_time_now                                              = CurrentDateOnFormat();
            $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"]                                   = ErrorOccuredMessage();
            $success_array["status"]                                    = 0;
            $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));

            if ($process_data->camis_patient_id != null && $user_id != null) {
                $data = [
                    "patient_id"                          => $process_data->camis_patient_id,
                    "ibox_handover_repositioning_routine" => $process_data->repositioning_routine ?? '',
                    "ibox_handover_skin_conditioning"     => $process_data->skin_conditioning ?? '',
                    "ibox_handover_dressings"             => $process_data->dressings ?? '',
                    "ibox_handover_mobility"              => $process_data->mobility ?? '',
                    "ibox_handover_equipment"             => $process_data->equipment ?? '',
                    "ibox_handover_assistance_needed"     => $process_data->assistance_needed ?? '',
                    "ibox_handover_varience_store"        => $process_data->varience_store ?? '',
                    "ibox_handover_special_diet_comment"  => $process_data->special_diet_comment ?? '',
                    "ibox_handover_obs_varience"          => $process_data->obs ?? '',
                    "ibox_handover_pain_analgesia"        => $process_data->pain_analgesia ?? '0',
                    "ibox_handover_i_continence"          => $process_data->i_continence ?? '',
                    "ibox_handover_s_surface"             => $process_data->s_surface ?? '',
                    "ibox_handover_n_nutrition"           =>  $process_data->n_nutrition ?? '',
                    "ibox_handover_comment"               => $process_data->hand_over_comment ?? '',
                    'updated_by'                          => $user_id
                ];

                $gov_text_before_arr                                    = CamisIboxPatientHandOver::where('patient_id', '=', $process_data->camis_patient_id)->first();
                $updated_data                                           = CamisIboxPatientHandOver::updateOrCreate(['patient_id' => $process_data->camis_patient_id], $data);
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
                $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_hand_over", "ibox_governance_frontend_functional_names");

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxPatientHandOver::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($process_data->camis_patient_id, $gov_text_before, 'Handover Details', $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    if ($gov_text_before_arr->camis_patient_id != '' && $process_data->camis_patient_id == '') {
                        CamisIboxPatientHandOver::where('patient_id', '=', $process_data->camis_patient_id)->delete();
                        $updated_data                                    = $gov_text_before_arr;
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
                        $success_array["message"]                        = DataRemovalMessage();
                        $gov_text_before                                 = $gov_text_before_arr->toArray();
                        $gov_text_after_arr                              = array();
                        $this->GovernanceBoardRoundUpdatePreCall($process_data->camis_patient_id, $gov_text_before, 'Handover Details', $gov_text_after_arr, $functional_identity, 3);
                        $success_array["updated_date"]                   = '';
                    } else {
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                        $success_array["message"]                        = DataUpdatedMessage();
                        if (count($updated_data->getChanges()) > 0) {
                            $updated_array                               = $updated_data->getOriginal();
                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                if ($gov_text_before_arr) {
                                    $gov_text_before                     = $gov_text_before_arr->toArray();
                                    $gov_text_after_arr                  = CamisIboxPatientHandOver::where('id', '=', $updated_array["id"])->first();
                                    $this->GovernanceBoardRoundUpdatePreCall($process_data->camis_patient_id, $gov_text_before, 'Handover Details', $gov_text_after_arr, $functional_identity, 2);
                                }
                            }
                        }
                    }
                }



                $patientIds = session('patient_ids_' . $process_data->ward_id, []);
                if (!in_array($process_data->camis_patient_id, $patientIds)) {
                    $patientIds[] = $process_data->camis_patient_id;
                    session(['patient_ids_' . $process_data->ward_id => $patientIds]);
                }

                if ($process_data->button_type == 'save_and_next') {
                    $bed_order      =  CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $process_data->ward_id)->whereNotNull('camis_patient_id')->pluck('camis_patient_id')->toArray();
                    $currentBedIndex = array_search($process_data->camis_patient_id, $bed_order);
                    $next_patient = null;
                    if ($currentBedIndex !== false && $currentBedIndex < count($bed_order) - 1) {
                        $next_patient = $bed_order[$currentBedIndex + 1];
                    }
                    $process_array["camis_patient_id"]                      = $next_patient;
                } else {
                    $process_array["camis_patient_id"]                      = $process_data->camis_patient_id;
                }
            }
            DB::commit();

            return $process_array;
        } catch (Exception $ex) {
            DB::rollBack();
            return  $ex->getMessage();
        }
    }

    public function GetPatientAdmittingReason(Request $request)
    {
        $camis_patient_id                                               = $request->camis_patient_id;
        $return_text                                                    = '';
        if ($camis_patient_id != '') {
            $result_data = CamisIboxBoardRoundAdmittingReason::where('patient_id', $camis_patient_id)->first();
            if (isset($result_data->patient_admitting_reason) && $result_data->patient_admitting_reason != '') {
                $return_text                                            = $result_data->patient_admitting_reason;
            }
        }
        return $return_text;
    }


    public function GetPatientCDTDetails(Request $request)
    {
        $camis_patient_id                                               = $request->camis_patient_id;
        $success_array['return_text']                                                    = '';
        $success_array['status']                                                         = 0;
        if ($camis_patient_id != '') {
            $result_data = CamisIboxBoardRoundCDT::where('patient_id', $camis_patient_id)->first();
            $cdt_comments = CamisIboxBoardRoundCDTComment::where('patient_id', $camis_patient_id)->orderBy('updated_at', 'desc')->first();
            if (isset($result_data->cdt_status) && $result_data->cdt_status != '') {
                $success_array['return_text']                             = $cdt_comments->cdt_comment ?? '';
                $success_array['status']                                  = $result_data->cdt_status;
            }
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetPatientPastMedicalHistory(Request $request)
    {
        $camis_patient_id                                               = $request->camis_patient_id;
        $return_text                                                    = '';
        if ($camis_patient_id != '') {
            $result_data = CamisIboxBoardRoundPastMedicalHistory::where('patient_id', $camis_patient_id)->first();
            if (isset($result_data->patient_past_medical_history) && $result_data->patient_past_medical_history != '') {
                $return_text                                            = $result_data->patient_past_medical_history;
            }
        }
        return $return_text;
    }

    public function GetPatientGoal(Request $request)
    {
        $camis_patient_id                                               = $request->camis_patient_id;
        $return_text                                                    = '';
        if ($camis_patient_id != '') {
            $result_data = CamisIboxBoardRoundPatientGoal::where('patient_id', $camis_patient_id)->first();
            if (isset($result_data->patient_patient_goal) && $result_data->patient_patient_goal != '') {
                $return_text                                            = $result_data->patient_patient_goal;
            }
        }
        return $return_text;
    }

    public function GetDoctorTasks(Request $request)
    {
        //        dd($request->all());
        $process_array                                                  = array();
        $success_array                                                  = array();
        $ward_id                                                        = $request->ward_id;
        $type_id                                                        = $request->type_id;

        $success_array['filter_value']                                  = '';
        $success_array['total_tasks']                                   = 0;
        $success_array['type']                                          = $request->type;
        $success_array['type_id']                                       = $type_id;
        $user_id                                                        = Session()->get('LOGGED_USER_ID', '');
        $date_time_now                                                  = CurrentDateOnFormat();

        $task_group = TaskGroup::where('status', 1);
        $nurse_task = $task_group->where(DB::raw('LOWER(task_group_name)'), strtolower('Nurse'))->first();
        $doctor_task = $task_group->where(DB::raw('LOWER(task_group_name)'), strtolower('Doctor'))->first();
        $nurse_task_id = $nurse_task->id ?? '39';
        $doctor_task_id = $doctor_task->id ?? '37';
        if ($request->task_ids != null) {
            $task_ids                                                   = explode(",", $request->task_ids);
            CamisIboxBoardRoundPatientTasks::whereIn('id', $task_ids)->update([
                'task_completed_status' => 1,
                'task_completed_by'     => $user_id,
                'task_completed_ward'   => $ward_id,
                'task_completed_at'     => $date_time_now,
            ]);
        }
        $patient_ids = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_ward_id', $ward_id)->pluck('camis_patient_id')->toArray();
        $baseQuery = CamisIboxBoardRoundPatientTasks::whereIn('patient_id', $patient_ids)
            ->where('task_completed_status', 0)->where('task_not_applicable_status', 0)
            ->where('task_group', $type_id);

        $patients_task_total = $baseQuery->count();

        if ($success_array['type'] == 'others') {
            if ((int)$request->filter_value > 0) {
                $type_id                            = (int)$request->filter_value;
            } else {
                $type_id                            = (int)$request->type_id;
            }

            $task_groups                            = TaskGroup::where('status', 1)->get();
            $patients_task = CamisIboxBoardRoundPatientTasks::whereIn('patient_id', $patient_ids)
                ->where('task_completed_status', 0)->where('task_not_applicable_status', 0)
                ->where('task_group', $type_id)
                ->latest()
                ->get();
            $patients_id   = CamisIboxBoardRoundPatientTasks::whereIn('patient_id', $patient_ids)
                ->where('task_completed_status', 0)->where('task_not_applicable_status', 0)
                ->where('task_group', $type_id)
                ->pluck('patient_id')->toArray();
            $patients      = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->whereIn('camis_patient_id', $patients_id)->get();

            $success_array['task_of_patients']         = $patients_task;
            $success_array['patients']                 = $patients;
            $success_array['task_group_name']          = TaskGroup::find($type_id)->task_group_name;
            $success_array['task_groups']              = $task_groups;
            $success_array['filter_value']             = $type_id;
            $success_array['patients_total']            = $patients_task_total;
        } else {
            $success_array['filter_value']              = $request->filter_value;
            $patients_task = $baseQuery->latest()->get();

            $patients_id = $baseQuery->pluck('patient_id')->toArray();


            if (($success_array['filter_value'] != null) && ($success_array['filter_value'] != 'all_doc')) {
                $success_array['consultant']              = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->where('camis_consultant_name', $request->filter_value)->pluck('camis_patient_id')->toArray();

                $patients_task = CamisIboxBoardRoundPatientTasks::whereIn('patient_id', $success_array['consultant'])
                    ->where('task_completed_status', 0)->where('task_not_applicable_status', 0)
                    ->where('task_group', $type_id)
                    ->latest()
                    ->get();

                $success_array['patient_name']              = $success_array['filter_value'];
                $success_array['task_of_patients']          = $patients_task;
                $patients      = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->whereIn('camis_patient_id', $patients_id)->where('camis_consultant_name', $request->filter_value)->get();
                $success_array['patients']                  = $patients;
                $success_array['patients_total']            = $patients_task_total;
            } else {
                $patients      = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->whereIn('camis_patient_id', $patients_id)->get();

                $success_array['patient_name']              = "All Doctor";
                $success_array['task_of_patients']          = $patients_task;
                $success_array['patients']                  = $patients;
                $success_array['patients_total']            = $patients_task_total;
            }
        }

        $success_array['doctor_task_id']  = $doctor_task_id;
        $success_array['nurse_task_id']  = $nurse_task_id;
        $success_array['all_consultant']   = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->whereNotNull('camis_consultant_name')->whereIn('camis_patient_id', $patients_id)->pluck('camis_consultant_name')->unique()->toArray();


        $success_array['patients']                           = $patients;
        $sections = array();
        $view = View::make('Dashboards.Camis.WardSummary.Modals.DoctorTaskInfo', compact('success_array'));
        $sections['views'] = $view->render();
        $sections['total_task'] = $patients_task_total;
        $sections['filter_value'] = $success_array['filter_value'];
        $sections['type'] = $success_array['type'];

        if ($nurse_task_id == $success_array['filter_value']) {
            $sections['task_type'] = 'nurse';
        } elseif ($success_array['filter_value'] == 'all_doc' || $success_array['filter_value'] == $doctor_task_id) {
            $sections['task_type'] = 'doctor';
        }
        $sections['priority_task'] = CamisIboxBoardRoundPatientTasks::whereIn('patient_id', $patient_ids)
            ->where('task_completed_status', 0)->where('task_not_applicable_status', 0)
            ->where('task_priority', 1)
            ->count();

        return $sections;
    }

    public function UpdatePatientAdmittingReason(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundAdmittingReason";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_admitting_reason                                   = $request->patient_admitting_reason;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["patient_admitting_reason"]                  = $patient_admitting_reason;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundAdmittingReason::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundAdmittingReason::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_admitting_reason' => $patient_admitting_reason, 'updated_by' => $user_id]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_admitting_reason", "ibox_governance_frontend_functional_names");

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundAdmittingReason::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_admitting_reason, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundAdmittingReason::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_admitting_reason, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function UpdatePatientPastMedicalHistory(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPastMedicalHistory";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_past_medical_history                               = $request->patient_past_medical_history;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["patient_past_medical_history"]                  = $patient_past_medical_history;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundPastMedicalHistory::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundPastMedicalHistory::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_past_medical_history' => $patient_past_medical_history, 'updated_by' => $user_id]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_admitting_reason", "ibox_governance_frontend_functional_names");

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundPastMedicalHistory::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_past_medical_history, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundPastMedicalHistory::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_past_medical_history, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdatePatientGoal(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientGoal";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_patient_goal                               = $request->patient_patient_goal;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["patient_patient_goal"]                  = $patient_patient_goal;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundPatientGoal::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundPatientGoal::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_patient_goal' => $patient_patient_goal, 'updated_by' => $user_id]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_admitting_reason", "ibox_governance_frontend_functional_names");

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundPatientGoal::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_patient_goal, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundPatientGoal::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_patient_goal, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetPatientSocialHistory(Request $request)
    {
        $camis_patient_id                   = $request->camis_patient_id;
        $return_text                        = '';
        if ($camis_patient_id != '') {
            $result_data = CamisIboxBoardRoundSocialHistory::where('patient_id', $camis_patient_id)->first();
            if (isset($result_data->patient_social_history) && $result_data->patient_social_history != '') {
                $return_text                = $result_data->patient_social_history;
            }
        }
        return $return_text;
    }
    public function UpdatePatientSocialHistory(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundSocialHistory";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_social_history                                     = $request->patient_social_history;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["patient_social_history"]                    = $patient_social_history;
        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundSocialHistory::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundSocialHistory::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_social_history' => $patient_social_history, 'updated_by' => $user_id]);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_social_history", "ibox_governance_frontend_functional_names");

            $success_array["status"]                                = 1;
            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundSocialHistory::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_social_history, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundSocialHistory::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_social_history, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetPatientWorkingDiagnosis(Request $request)
    {
        $camis_patient_id                   = $request->camis_patient_id;
        $return_text                        = '';
        if ($camis_patient_id != '') {
            $result_data                    = CamisIboxBoardRoundWorkingDiagnosis::where('patient_id', $camis_patient_id)->first();
            if (isset($result_data->patient_working_diagnosis) && $result_data->patient_working_diagnosis != '') {
                $return_text                = $result_data->patient_working_diagnosis;
            }
        }
        return $return_text;
    }

    public function UpdatePatientWorkingDiagnosis(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundWorkingDiagnosis";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_working_diagnosis                                  = $request->patient_working_diagnosis;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["patient_working_diagnosis"]                 = $patient_working_diagnosis;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundWorkingDiagnosis::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundWorkingDiagnosis::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_working_diagnosis' => $patient_working_diagnosis, 'updated_by' => $user_id]);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_working_diagnosis", "ibox_governance_frontend_functional_names");
            $success_array["status"]                                = 1;

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundWorkingDiagnosis::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_working_diagnosis, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundWorkingDiagnosis::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_working_diagnosis, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetEstimatedDischargeDate(Request $request)
    {
        $camis_patient_id                   = $request->camis_patient_id;
        $success_array["message"]           = ErrorOccuredMessage();
        $success_array["status"]            = 0;
        $success_array["date"]  = '';
        $success_array["comment"]  = '';
        if ($camis_patient_id != '') {
            $result_data                    = CamisIboxBoardRoundEstimatedDischargeDate::where('patient_id', $camis_patient_id)->first();
            if (isset($result_data->patient_estimated_discharge_date) && $result_data->patient_estimated_discharge_date != '') {
                $success_array["date"]  = $result_data->patient_estimated_discharge_date;
                $success_array["comment"]  = $result_data->patient_estimated_discharge_date_comment;
            }
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdateEstimatedDischargeDate(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundEstimatedDischargeDate";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_estimated_discharge_date                           = $request->patient_estimated_discharge_date;
        $patient_estimated_discharge_date_comment                   = $request->patient_estimated_discharge_date_comment;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundEstimatedDischargeDate::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundEstimatedDischargeDate::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_estimated_discharge_date' => $patient_estimated_discharge_date, 'patient_estimated_discharge_date_comment' => $patient_estimated_discharge_date_comment, 'updated_by' => $user_id]);

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();

                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundEstimatedDischargeDate::where('id', '=', $updated_array["id"])->first();
                    $functional_identity                            = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_estimated_discharge_date", "ibox_governance_frontend_functional_names");
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, date('D jS M Y', strtotime($patient_estimated_discharge_date)), $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();

                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundEstimatedDischargeDate::where('id', '=', $updated_array["id"])->first();
                            $functional_identity                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_estimated_discharge_date", "ibox_governance_frontend_functional_names");
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, date('D jS M Y', strtotime($patient_estimated_discharge_date)), $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["updated_date"]                          = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["estimated_discharge_date"]              = IboxEstimatedDischargeDateShowBoardround($patient_estimated_discharge_date);
            $success_array["status"]                                = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetReasonToReside(Request $request)
    {
        $success_array                                                              = array();
        $camis_patient_id                                                           = $request->camis_patient_id;
        $success_array['patient_reason_to_reside_status']                           = '';
        $success_array['patient_medically_fit_status']                              = 0;
        $success_array['patient_medically_fit_status_comment']                      = '';
        if ($camis_patient_id != '') {


            $result_data_medfit                                                     = CamisIboxBoardRoundMedFit::where('patient_id', $camis_patient_id)->first();

            if ($result_data_medfit != null) {
                $success_array['patient_medically_fit_status']                      = $result_data_medfit->patient_medically_fit_status;
                if ($result_data_medfit->patient_medically_fit_status == 1) {
                    $success_array['patient_medically_fit_status_comment']              = $result_data_medfit->patient_medically_fit_status_comment;
                }
            }

            $result_data                                                            = CamisIboxBoardRoundReasonToReside::where('patient_id', $camis_patient_id)->where('patient_reason_to_reside_status', '!=', 0)->whereNull('reason_to_reside_end_date')->latest('created_at')->first();

            if ($result_data != null) {
                $success_array['patient_reason_to_reside_status']                   = $result_data->patient_reason_to_reside_status;
            }
        }
        $patient_red_green_bed                               = CamisIboxBoardRoundRedGreenBed::where('patient_id', $camis_patient_id)->first();
        if ($patient_red_green_bed != null) {
            if (is_array(json_decode($patient_red_green_bed->patient_red_green_status_reason_code, true))) {
                $pending_red_bed_reason = array_values(array_keys(array_filter(json_decode($patient_red_green_bed->patient_red_green_status_reason_code, true), function ($value) {
                    return ((isset($value['is_complete']) && $value['is_complete'] == 0) || $value == 0);
                })));
            } else {
                $pending_red_bed_reason = array('0' => 1);
            }


            $success_array['patient_red_green_status'] = $patient_red_green_bed->patient_red_green_status;
            $success_array['patient_red_green_status_reason_code'] = $pending_red_bed_reason;
        } else {
            $success_array['patient_red_green_status'] = 0;
            $success_array['patient_red_green_status_reason_code'] = array('0' => 1);
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdateReasonToReside(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundReasonToReside";
        $date_time_now                                              = CurrentDateOnFormat();

        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_reason_to_reside_status                            = $request->patient_reason_to_reside_status;
        $med_fit_set_as_no                                          = $request->med_fit_set_as_no ?? 0;
        $patient_reason_to_reside_status                            = ($patient_reason_to_reside_status == '') ? 0 : $patient_reason_to_reside_status;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $reason_to_reside_text_value                                = '';
        $reason_to_reside_text_value_category                       = '';
        $reason_to_reside_master_text_content                       = ReasonToResideGroup::where('id', '=', $patient_reason_to_reside_status)->first();

        $reason_to_reside_text_value_category                   = $reason_to_reside_master_text_content->reason_to_reside_text_value_category;
        $reason_to_reside_text_value                            = $reason_to_reside_master_text_content->reason_to_reside_text_value;
        $success_array['reason_to_reside_text_value_category']      = $reason_to_reside_text_value_category;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundReasonToReside::where('patient_id', '=', $camis_patient_id)->latest('created_at')->first();


            if ((!isset($gov_text_before_arr->patient_reason_to_reside_status) || isset($gov_text_before_arr->patient_reason_to_reside_status) && $gov_text_before_arr->patient_reason_to_reside_status != $patient_reason_to_reside_status)) {
                if ($gov_text_before_arr == null) {
                    $updated_data                                           = CamisIboxBoardRoundReasonToReside::create(['patient_id' => $camis_patient_id, 'patient_reason_to_reside_status' => $patient_reason_to_reside_status, 'updated_by' => $user_id, 'reason_to_reside_start_date' => CurrentDateOnFormat()]);


                    $success_array['reason_to_reside']                      = ReasonToResideGroup::where('status', '=', 1)->get();
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundReasonToReside::where('id', '=', $updated_array["id"])->first();
                        $functional_identity                            = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_reason_to_reside", "ibox_governance_frontend_functional_names");
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $reason_to_reside_text_value, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {

                    $updated_data = $gov_text_before_arr->fill([
                        'updated_by' => $user_id,
                        'reason_to_reside_end_date' => CurrentDateOnFormat()
                    ]);
                    $updated_data->save();





                    $success_array['reason_to_reside']                      = ReasonToResideGroup::where('status', '=', 1)->get();

                    if ($updated_data->wasChanged()) {




                        $success_array["message"]                           = DataUpdatedMessage();

                        if (count($updated_data->getChanges()) > 0) {
                            $updated_array                                  = $updated_data->getOriginal();
                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                if ($gov_text_before_arr) {
                                    $old_row = HistoryCamisIboxBoardRoundReasonToReside::where('patient_id', $camis_patient_id)->where('patient_reason_to_reside_status', $updated_data->patient_reason_to_reside_status)->whereNull('reason_to_reside_end_date')->orderBy('id', 'desc')->first();
                                    if (isset($old_row->history_id)) {
                                        HistoryCamisIboxBoardRoundReasonToReside::where('history_id', $old_row->history_id)->update([
                                            'updated_by' => $user_id,
                                            'reason_to_reside_end_date' => CurrentDateOnFormat(),
                                            'history_status' => 2,
                                            'updated_at' => CurrentDateOnFormat(),
                                        ]);
                                    }


                                    $gov_text_before                        = $gov_text_before_arr->toArray();
                                    $gov_text_after_arr                     = CamisIboxBoardRoundEstimatedDischargeDate::where('id', '=', $updated_array["id"])->first();
                                    $functional_identity                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_reason_to_reside", "ibox_governance_frontend_functional_names");
                                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $reason_to_reside_text_value, $gov_text_after_arr, $functional_identity, 2);
                                }
                            }
                        }



                        $updated_data                                           = CamisIboxBoardRoundReasonToReside::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_reason_to_reside_status' => $patient_reason_to_reside_status, 'updated_by' => $user_id, 'reason_to_reside_start_date' => CurrentDateOnFormat(), 'reason_to_reside_end_date' => null]);
                        $success_array['reason_to_reside']                      = ReasonToResideGroup::where('status', '=', 1)->get();
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                        $updated_array                                      = $updated_data->getOriginal();
                        $gov_text_before                                    = array();

                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            $gov_text_after_arr                             = CamisIboxBoardRoundReasonToReside::where('id', '=', $updated_array["id"])->first();
                            $functional_identity                            = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_reason_to_reside", "ibox_governance_frontend_functional_names");
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $reason_to_reside_text_value, $gov_text_after_arr, $functional_identity, 1);
                        }
                    }
                }
            }





            $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundMedFit";
            $patient_medically_fit_status                               = $med_fit_set_as_no;
            $patient_medically_fit_status_comment                       = $request->patient_medically_fit_status_comment;
            $success_array["patient_medically_fit_status"]              = '';

            if ($camis_patient_id != "" && $user_id != "") {
                $gov_text_before_arr                                    = CamisIboxBoardRoundMedFit::where('patient_id', '=', $camis_patient_id)->first();
                if ((!isset($gov_text_before_arr->patient_medically_fit_status) || (isset($gov_text_before_arr->patient_medically_fit_status) && ($gov_text_before_arr->patient_medically_fit_status != $patient_medically_fit_status)))) {

                    $updated_data                                           = CamisIboxBoardRoundMedFit::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_medically_fit_status' => $patient_medically_fit_status, 'patient_medically_fit_status_comment' => $patient_medically_fit_status_comment, 'updated_by' => $user_id, 'patient_med_fit_consultant_name' => $request->patient_med_fit_consultant_name, 'medfit_status_update_date' => CurrentDateOnFormat()]);
                    if ($med_fit_set_as_no == 0) {
                        $medfit_governance_description                          = 'Medfit As No';
                    } else {
                        $medfit_governance_description                          = 'Medfit As Yes';
                    }

                    $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_medfit_discharge", "ibox_governance_frontend_functional_names");
                    if ($updated_data->wasRecentlyCreated) {
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);

                        $updated_array                                      = $updated_data->getOriginal();
                        $gov_text_before                                    = array();

                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            $gov_text_after_arr                             = CamisIboxBoardRoundMedFit::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $medfit_governance_description, $gov_text_after_arr, $functional_identity, 1);
                        }
                    } else {
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);

                        if (count($updated_data->getChanges()) > 0) {
                            $updated_array                                  = $updated_data->getOriginal();
                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                if ($gov_text_before_arr) {
                                    $gov_text_before                        = $gov_text_before_arr->toArray();
                                    $gov_text_after_arr                     = CamisIboxBoardRoundMedFit::where('id', '=', $updated_array["id"])->first();
                                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $medfit_governance_description, $gov_text_after_arr, $functional_identity, 2);
                                }
                            }
                        }
                    }
                    $success_array["patient_medically_fit_status"]          = $med_fit_set_as_no;
                } elseif (isset($gov_text_before_arr->patient_medically_fit_status) && ($gov_text_before_arr->patient_medically_fit_status == $patient_medically_fit_status &&  $patient_medically_fit_status_comment != $gov_text_before_arr->patient_medically_fit_status_comment)) {


                    $success_array["updated_date"]                          = date('jS M Y, H:i', strtotime($date_time_now));
                    $success_array["reason_to_reside_text_value_category"]  = $reason_to_reside_text_value_category;
                    $success_array["status"]                                = 1;




                    if ($camis_patient_id != "" && $user_id != "") {
                        $gov_text_before_arr                                    = CamisIboxBoardRoundMedFit::where('patient_id', '=', $camis_patient_id)->first();
                        $updated_data                                           = CamisIboxBoardRoundMedFit::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_medically_fit_status' => $patient_medically_fit_status, 'patient_medically_fit_status_comment' => $patient_medically_fit_status_comment, 'updated_by' => $user_id, 'patient_med_fit_consultant_name' => $request->patient_med_fit_consultant_name]);

                        $medfit_governance_description                          = $patient_medically_fit_status_comment;


                        $functional_identity                                    = 'MedFit Comment';
                        if ($updated_data->wasRecentlyCreated) {
                            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);

                            $updated_array                                      = $updated_data->getOriginal();
                            $gov_text_before                                    = array();

                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                $gov_text_after_arr                             = CamisIboxBoardRoundMedFit::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $medfit_governance_description, $gov_text_after_arr, $functional_identity, 1);
                            }
                        } else {
                            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);

                            if (count($updated_data->getChanges()) > 0) {
                                $updated_array                                  = $updated_data->getOriginal();
                                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                    if ($gov_text_before_arr) {
                                        $gov_text_before                        = $gov_text_before_arr->toArray();
                                        $gov_text_after_arr                     = CamisIboxBoardRoundMedFit::where('id', '=', $updated_array["id"])->first();
                                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $medfit_governance_description, $gov_text_after_arr, $functional_identity, 2);
                                    }
                                }
                            }
                        }

                        $success_array["patient_medically_fit_status"]          = $med_fit_set_as_no;
                    }
                }
            }
        }

        $patient_red_green_bed                               = CamisIboxBoardRoundRedGreenBed::where('patient_id', $camis_patient_id)->first();
        if ($patient_red_green_bed != null) {
            if (is_array(json_decode($patient_red_green_bed->patient_red_green_status_reason_code, true))) {
                $pending_red_bed_reason = array_values(array_keys(array_filter(json_decode($patient_red_green_bed->patient_red_green_status_reason_code, true), function ($value) {
                    return $value === 0;
                })));
            } else {
                $pending_red_bed_reason = array('0' => 1);
            }
            $success_array['patient_red_green_status'] = $patient_red_green_bed->patient_red_green_status;
            $success_array['patient_red_green_status_reason_code'] = $pending_red_bed_reason;
        } else {
            $success_array['patient_red_green_status'] = 0;
            $success_array['patient_red_green_status_reason_code'] = array('0' => 1);
        }
        $success_array["message"]                           = DataUpdatedMessage();
        $patient_red_green_bed                               = CamisIboxBoardRoundRedGreenBed::where('patient_id', $camis_patient_id)->first();
        if ($patient_red_green_bed != null) {
            if (is_array(json_decode($patient_red_green_bed->patient_red_green_status_reason_code, true))) {
                $pending_red_bed_reason = array_values(array_keys(array_filter(json_decode($patient_red_green_bed->patient_red_green_status_reason_code, true), function ($value) {
                    return ((isset($value['is_complete']) && $value['is_complete'] == 0) || $value == 0);
                })));
            } else {
                $pending_red_bed_reason = array('0' => 1);
            }


            $success_array['patient_red_green_status'] = $patient_red_green_bed->patient_red_green_status;
            $success_array['patient_red_green_status_reason_code'] = $pending_red_bed_reason;
        } else {
            $success_array['patient_red_green_status'] = 0;
            $success_array['patient_red_green_status_reason_code'] = array('0' => 1);
        }
        $success_array["reason_to_reside_text_value_category"] = str_replace('.', ',',str_replace('_', ' ', ucwords($success_array["reason_to_reside_text_value_category"])));

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetMedFitForDischarge(Request $request)
    {
        $success_array                                                              = array();
        $camis_patient_id                                                           = $request->camis_patient_id;
        $success_array['status']                                                    = 1;
        $success_array['patient_medically_fit_status']                              = '';
        $success_array['patient_medically_fit_status_comment']                      = '';
        if ($camis_patient_id != '') {
            $result_data_medfit                                                     = CamisIboxBoardRoundMedFit::where('patient_id', $camis_patient_id)->first();

            if (isset($result_data_medfit->patient_medically_fit_status) && $result_data_medfit->patient_medically_fit_status != '') {
                $success_array['patient_medically_fit_status']                      = $result_data_medfit->patient_medically_fit_status;
                $success_array['consultant_name']                                   = $result_data_medfit->patient_med_fit_consultant_name;
                $success_array['patient_medically_fit_status_comment']              = $result_data_medfit->patient_medically_fit_status_comment;;
            }
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdateMedFitForDischargeYes(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundMedFit";
        $date_time_now                                              = CurrentDateOnFormat();

        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_medically_fit_status                               = 1;
        $patient_medically_fit_status_comment                       = $request->patient_medically_fit_status_comment;

        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        $success_array["reason_to_reside_text_value_category"]      = '';
        $success_array["updated_date"]                              = '';
        $success_array["patient_medically_fit_status"]              = '';

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundMedFit::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundMedFit::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_medically_fit_status' => $patient_medically_fit_status, 'patient_medically_fit_status_comment' => $patient_medically_fit_status_comment, 'updated_by' => $user_id, 'patient_med_fit_consultant_name' => $request->patient_med_fit_consultant_name]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
            $medfit_governance_description                          = 'Medfit As Yes';
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_medfit_discharge", "ibox_governance_frontend_functional_names");

            if ($updated_data->wasRecentlyCreated) {
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();

                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundMedFit::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $medfit_governance_description, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundMedFit::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $medfit_governance_description, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["updated_date"]                          = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["patient_medically_fit_status"]          = 1;
            $success_array["status"]                                = 1;

            $history_modal                                          = "App\Models\History\HistoryCamisIboxBoardRoundReasonToReside";
            $patient_reason_to_reside_status                        = 0;
            $reason_to_reside_text_value                            = '';
            $reason_to_reside_text_value_category                   = '';
            $reason_to_reside_master_text_content                   = ReasonToResideGroup::where('id', '=', $patient_reason_to_reside_status)->first();
            if (isset($reason_to_reside_master_text_content->reason_to_reside_text_value) && $reason_to_reside_master_text_content->reason_to_reside_text_value != '') {
                $reason_to_reside_text_value_category               = $reason_to_reside_master_text_content->reason_to_reside_text_value_category;
                $reason_to_reside_text_value                        = $reason_to_reside_master_text_content->reason_to_reside_text_value;
            }

            if ($camis_patient_id != "" && $user_id != "") {
                $gov_text_before_arr                                    = CamisIboxBoardRoundReasonToReside::where('patient_id', '=', $camis_patient_id)->latest('created_at')->first();

                if ($gov_text_before_arr != null && ($gov_text_before_arr->patient_reason_to_reside_status == $patient_reason_to_reside_status)) {
                    $success_array["updated_date"]                          = date('jS M Y, H:i', strtotime($date_time_now));
                    $success_array["reason_to_reside_text_value_category"]  = $reason_to_reside_text_value_category;
                    $success_array["status"]                                = 1;
                    return ReturnArrayAsJsonToScript($success_array);
                }


                if ($gov_text_before_arr == null) {
                    $updated_data                                           = CamisIboxBoardRoundReasonToReside::create(['patient_id' => $camis_patient_id, 'patient_reason_to_reside_status' => $patient_reason_to_reside_status, 'updated_by' => $user_id, 'reason_to_reside_start_date' => CurrentDateOnFormat()]);
                    $success_array['reason_to_reside']                      = ReasonToResideGroup::where('status', '=', 1)->get();
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundReasonToReside::where('id', '=', $updated_array["id"])->first();
                        $functional_identity                            = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_reason_to_reside", "ibox_governance_frontend_functional_names");
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $reason_to_reside_text_value, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {

                    $updated_data = $gov_text_before_arr->fill([
                        'updated_by' => $user_id,
                        'reason_to_reside_end_date' => CurrentDateOnFormat()
                    ]);

                    if ($updated_data->isDirty()) {
                        $updated_data->save();
                    }
                    $success_array['reason_to_reside']                      = ReasonToResideGroup::where('status', '=', 1)->get();

                    if ($updated_data->wasChanged()) {
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                        $success_array["message"]                           = DataUpdatedMessage();

                        if (count($updated_data->getChanges()) > 0) {
                            $updated_array                                  = $updated_data->getOriginal();
                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                if ($gov_text_before_arr) {
                                    $gov_text_before                        = $gov_text_before_arr->toArray();
                                    $gov_text_after_arr                     = CamisIboxBoardRoundEstimatedDischargeDate::where('id', '=', $updated_array["id"])->first();
                                    $functional_identity                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_reason_to_reside", "ibox_governance_frontend_functional_names");
                                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $reason_to_reside_text_value, $gov_text_after_arr, $functional_identity, 2);
                                }
                            }
                        }



                        $updated_data                                           = CamisIboxBoardRoundReasonToReside::create(['patient_id' => $camis_patient_id, 'patient_reason_to_reside_status' => $patient_reason_to_reside_status, 'updated_by' => $user_id, 'reason_to_reside_start_date' => CurrentDateOnFormat()]);
                        $success_array['reason_to_reside']                      = ReasonToResideGroup::where('status', '=', 1)->get();
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                        $updated_array                                      = $updated_data->getOriginal();
                        $gov_text_before                                    = array();

                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            $gov_text_after_arr                             = CamisIboxBoardRoundReasonToReside::where('id', '=', $updated_array["id"])->first();
                            $functional_identity                            = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_reason_to_reside", "ibox_governance_frontend_functional_names");
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $reason_to_reside_text_value, $gov_text_after_arr, $functional_identity, 1);
                        }
                    }
                }
            }
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_desc, $gov_text_after_arr, $functional_identity, $operation)
    {
        $gov_data                                   = array();
        if ($operation == 1) {
            if ($gov_text_after_arr) {
                $gov_text_after                     = $gov_text_after_arr->toArray();
            }

            if (isset($gov_text_after["id"])) {
                $gov_data["gov_text_before"]        = "";
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 2) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {

                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }

        if ($operation == 4) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 5) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 3) {
            if (isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = "";
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if (!empty($gov_data)) {
            if (count($gov_data) > 0) {

                $governance = new GovernanceController;
                $governance->GovernanceStoreCamisData($gov_data);
            }
        }
    }

    public function InsertBoardRoundData($patient_id)
    {
        $ward_id                                                    = $patient_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $patient_query              = CamisIboxWardPatientInformationWithBedDetailsView::select('ibox_ward_id')->where('camis_patient_id', $patient_id)->first();
        if ($patient_query != null) {
            $board_round_text                                           = 'boardround_' . $patient_query->ibox_ward_id . '_' . $user_id;


            if (Session::has('boardround_data') && Session::get('boardround_data') == $board_round_text) {
                $is_board_round                     = 1;
            } else {
                $is_board_round                     = 0;
                $current_time = Carbon::now();

                $current_hour = $current_time->format('H');

                if ($current_hour >= 0 && $current_hour <= 11) {
                    $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                        ->where('patient_id', $patient_id)
                        ->where('ward_id', $patient_query->ibox_ward_id)
                        ->whereDate('updated_at', now()->toDateString())
                        ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '00' AND '11'")
                        ->first();
                } else {
                    $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                        ->where('patient_id', $patient_id)
                        ->where('ward_id', $patient_query->ibox_ward_id)
                        ->whereDate('updated_at', now()->toDateString())
                        ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '12' AND '23'")
                        ->first();
                }
                $is_board_round = ($existing_query !== null) ? 1 : 0;
            }


            if ($is_board_round == 1) {


                $updated_array['ward_id']                     = $patient_query->ibox_ward_id;


                $history_controller                                         = new HistoryController;
                $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientStatus";
                $camis_patient_id                                           = $patient_id;
                $user_id                                                    = Session()->get('LOGGED_USER_ID', '');


                if ($camis_patient_id != "" && $user_id != "" && Session::has('board_round_time') && !empty(Session::has('board_round_time'))) {


                    $boardround_data = Session::get('board_round_time');

                    $gov_text_before_arr                                    = CamisIboxBoardRoundPatientStatus::where('patient_id', '=', $camis_patient_id)->where('ward_id', $patient_query->ibox_ward_id)->first();
                    $updated_data                                           = CamisIboxBoardRoundPatientStatus::updateOrCreate(['patient_id' => $camis_patient_id, 'ward_id' => $patient_query->ibox_ward_id], ['is_board_round' => $is_board_round, 'updated_by' => $user_id, 'board_round_session' => $boardround_data]);
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
                    $functional_identity                                    = 'Patient Board Round Status';

                    if ($updated_data->wasRecentlyCreated) {
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);

                        $updated_array                                      = $updated_data->getOriginal();
                        $gov_text_before                                    = array();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            $gov_text_after_arr                             = CamisIboxBoardRoundPatientStatus::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCallWardRound($camis_patient_id, $gov_text_before, 'Board Round Data Inserted', $gov_text_after_arr, $functional_identity, 1);
                        }
                    } else {

                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);

                        if (count($updated_data->getChanges()) > 0) {
                            $updated_array                                  = $updated_data->getOriginal();
                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                if ($gov_text_before_arr) {
                                    $gov_text_before                        = $gov_text_before_arr->toArray();
                                    $gov_text_after_arr                     = CamisIboxBoardRoundPatientStatus::where('id', '=', $updated_array["id"])->first();
                                    $this->GovernanceBoardRoundUpdatePreCallWardRound($camis_patient_id, $gov_text_before, 'Board Round Data Updated', $gov_text_after_arr, $functional_identity, 2);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function GovernanceBoardRoundUpdatePreCallWardRound($camis_patient_id, $gov_text_before, $gov_desc, $gov_text_after_arr, $functional_identity, $operation)
    {
        $gov_data                                   = array();
        if ($operation == 1) {
            if ($gov_text_after_arr) {
                $gov_text_after                     = $gov_text_after_arr->toArray();
            }

            if (isset($gov_text_after["id"])) {
                $gov_data["gov_text_before"]        = "";
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 2) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {

                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }

        if ($operation == 4) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 5) {
            if ($gov_text_after_arr) {
                $gov_text_after = $gov_text_after_arr->toArray();
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if ($operation == 3) {
            if (isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = "";
                $gov_data["gov_patient_id"]         = $camis_patient_id;
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = $gov_desc;
            }
        }
        if (!empty($gov_data)) {
            if (count($gov_data) > 0) {

                $governance = new GovernanceController;
                $governance->GovernanceStoreCamisData($gov_data);
            }
        }
    }





    public function GetRedGreenBedStatus(Request $request)
    {
        $success_array                                                 = array();
        $camis_patient_id                                              = $request->camis_patient_id;
        $success_array['patient_red_green_status']                     = '';
        $success_array['patient_red_green_status_reason_code']         = '';

        if ($camis_patient_id != '') {
            $result_data                                               = CamisIboxBoardRoundRedGreenBed::where('patient_id', $camis_patient_id)->first();
            if (isset($result_data->patient_red_green_status) && $result_data->patient_red_green_status != 0) {
                $success_array['patient_red_green_status']             = $result_data->patient_red_green_status;
                $success_array['patient_red_green_status_reason_code'] = $result_data->patient_red_green_status_reason_code;
            }
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdateRedGreenBedStatus(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundRedGreenBed";
        $date_time_now                                              = CurrentDateOnFormat();

        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_red_green_status                                   = $request->patient_red_green_status ?? 0;
        $patient_red_green_status_reason_code                       = ($patient_red_green_status == 1) ? $request->patient_red_green_status_reason_code : 0;
        $update_bed_status                                          = '';

        if ($patient_red_green_status == 1) {
            $update_bed_status  = 'Red';
        } else if ($patient_red_green_status == 2) {
            $update_bed_status  = 'Green';
        }

        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "" && $update_bed_status != '') {
            $previous_patient                                           = CamisIboxBoardRoundRedGreenBed::where('patient_id', '=', $camis_patient_id)->where('patient_red_green_status', $patient_red_green_status)->first();
            if ($previous_patient == null || ($previous_patient->patient_red_green_status != $patient_red_green_status) || ($previous_patient->patient_red_green_status_reason_code != $patient_red_green_status_reason_code)) {

                if ($previous_patient == null) {
                    $gov_text_before_arr                                    = CamisIboxBoardRoundRedGreenBed::where('patient_id', '=', $camis_patient_id)->first();
                    $updated_data                                           = CamisIboxBoardRoundRedGreenBed::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_red_green_status' => $patient_red_green_status, 'patient_red_green_status_reason_code' => $patient_red_green_status_reason_code, 'updated_by' => $user_id]);
                    $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_red_green_bed", "ibox_governance_frontend_functional_names");
                    if ($updated_data->wasRecentlyCreated) {
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                        $success_array["message"]                           = DataAddedMessage();
                        $updated_array                                      = $updated_data->getOriginal();
                        $gov_text_before                                    = array();

                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            $gov_text_after_arr                             = CamisIboxBoardRoundRedGreenBed::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 1);
                        }
                    } else {
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                        $success_array["message"]                           = DataUpdatedMessage();
                        if (count($updated_data->getChanges()) > 0) {
                            $updated_array                                  = $updated_data->getOriginal();
                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                if ($gov_text_before_arr) {
                                    $gov_text_before                        = $gov_text_before_arr->toArray();
                                    $gov_text_after_arr                     = CamisIboxBoardRoundRedGreenBed::where('id', '=', $updated_array["id"])->first();
                                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 2);
                                }
                            }
                        }
                    }
                    $success_array["updated_date"]                           = date('jS M Y, H:i', strtotime($date_time_now));
                    $success_array["patient_red_green_status"]               = $patient_red_green_status;
                    $success_array["patient_red_green_status_reason_code"]   = $patient_red_green_status_reason_code;
                    $bed_red_reason = BedRedReason::where('id', $patient_red_green_status_reason_code)->first();

                    if ($patient_red_green_status == 1 && $bed_red_reason != null) {
                        $success_array["patient_red_green_status_reason_text"] = $bed_red_reason->red_text_value;
                    } else {
                        $success_array["patient_red_green_status_reason_text"] = '';
                    }
                    $success_array["update_type"]                           = 'create';
                } else {
                    $gov_text_before_arr                                    = CamisIboxBoardRoundRedGreenBed::where('patient_id', '=', $camis_patient_id)->first();
                    CamisIboxBoardRoundRedGreenBed::where('patient_id', '=', $camis_patient_id)->delete();
                    $updated_data                                           = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
                    $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_red_green_bed", "ibox_governance_frontend_functional_names");
                    $gov_text_before                                        = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                                     = array();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                    $success_array["patient_red_green_status"]               = 0;
                    $success_array["patient_red_green_status_reason_code"]   = 0;
                    $success_array["update_type"]                           = 'remove';
                    $success_array["message"]                               = DataRemovalMessage();
                }
            }
            $success_array["status"]                                  = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }


    public function UpdateRedGreenBedStatusReason(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundRedGreenBed";
        $date_time_now                                              = CurrentDateOnFormat();

        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_red_green_status                                   = $request->patient_red_green_status ?? 0;



        $update_bed_status                                          = '';
        if ($patient_red_green_status == 1) {
            $update_bed_status  = 'Red';
        } else if ($patient_red_green_status == 2) {
            $update_bed_status  = 'Green';
        } else {
            $update_bed_status  = 'Removed';
        }

        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "" && $update_bed_status != '') {


            $patient_red_green_status_reason_code                       = ($patient_red_green_status == 1) ? array_fill_keys($request->patient_red_green_status_reason_code, 0) : array('0' => 1);




            $gov_text_before_arr                                    = CamisIboxBoardRoundRedGreenBed::where('patient_id', '=', $camis_patient_id)->first();
            $reason_data = array();

            $pending_red_bed_reason = array();
            if (isset($gov_text_before_arr) && $gov_text_before_arr->patient_red_green_status == 1) {
                $pending_red_bed_reason = json_decode($gov_text_before_arr->patient_red_green_status_reason_code, true);
            }

            if ($patient_red_green_status == 1) {
                foreach ($request->patient_red_green_status_reason_code as $reason) {

                    if (!array_key_exists($reason, $pending_red_bed_reason)) {
                        $reason_data[$reason] = [
                            'reason_id' => $reason,
                            'created_time' => CurrentDateOnFormat(),
                            'is_complete' => 0,
                            'completed_time' => null,
                        ];
                    } else {
                        $exist_row = $pending_red_bed_reason[$reason];

                        if (!isset($exist_row['is_complete'])) {
                            $exist_row = [
                                'reason_id' => $reason,
                                'created_time' => $gov_text_before_arr->updated_at,
                                'is_complete' => 0,
                                'completed_time' => null,
                            ];
                        }

                        if ((isset($exist_row['is_complete']) && $exist_row['is_complete'] == 1) || $exist_row == 1) {
                            $reason_data[$reason] = [
                                'reason_id' => $reason,
                                'created_time' => CurrentDateOnFormat(),
                                'is_complete' => 0,
                                'completed_time' => null,
                            ];
                        } else {
                            $reason_data[$reason] = $exist_row;
                        }
                    }
                }
            }

            $updated_data                                           = CamisIboxBoardRoundRedGreenBed::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_red_green_status' => $patient_red_green_status, 'patient_red_green_status_reason_code' => json_encode($reason_data), 'updated_by' => $user_id]);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_red_green_bed", "ibox_governance_frontend_functional_names");
            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();

                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundRedGreenBed::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundRedGreenBed::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }

            $pending_red_bed_reason = array_values(array_keys(array_filter($patient_red_green_status_reason_code, function ($value) {
                return ((isset($value['is_complete']) && $value['is_complete'] == 0) || $value === 0);
            })));

            $success_array["updated_date"]                           = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["patient_red_green_status"]               = $patient_red_green_status;
            $success_array["patient_red_green_status_reason_code"]   = $pending_red_bed_reason;
            $bed_red_reason = BedRedReason::whereIn('id', $pending_red_bed_reason)->first();

            if ($patient_red_green_status == 1 && $bed_red_reason != null) {
                $success_array["patient_red_green_status_reason_text"] = $bed_red_reason->red_text_value;
            } else {
                $success_array["patient_red_green_status_reason_text"] = '';
            }




            $success_array["status"]                                  = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function RemoveRedGreenBedStatus(Request $request)
    {
        $history_controller                                          = new HistoryController;
        $history_modal                                               = "App\Models\History\HistoryCamisIboxBoardRoundRedGreenBed";
        $date_time_now                                               = CurrentDateOnFormat();

        $camis_patient_id                                            = $request->camis_patient_id;
        $user_id                                                     = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                    = ErrorOccuredMessage();
        $success_array["status"]                                     = array('0' => 1);

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                     = CamisIboxBoardRoundRedGreenBed::where('patient_id', '=', $camis_patient_id)->first();
            CamisIboxBoardRoundRedGreenBed::where('patient_id', '=', $camis_patient_id)->delete();
            $updated_data                                            = $gov_text_before_arr;
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
            $functional_identity                                     = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_red_green_bed", "ibox_governance_frontend_functional_names");
            $success_array["message"]                                = DataRemovalMessage();
            $gov_text_before                                         = $gov_text_before_arr->toArray();
            $gov_text_after_arr                                      = array();
            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
            $success_array["updated_date"]                           = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["status"]                                 = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }



    public function GetPotentialDefiniteBedStatus(Request $request)
    {
        $success_array                                                  = array();
        $camis_patient_id                                               = $request->camis_patient_id;
        $success_array['patient_potential_definite_status']             = '';
        if ($camis_patient_id != '') {
            $result_data                                                = CamisIboxBoardRoundPotentialDefinite::where('patient_id', $camis_patient_id)->first();

            if (isset($result_data->patient_potential_definite_status) && $result_data->patient_potential_definite_status != 0) {
                $success_array['patient_potential_definite_status']     = $result_data->patient_potential_definite_status;
            }
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdatePotentialDefiniteBedStatus(Request $request)
    {
        $history_controller                                             = new HistoryController;
        $history_modal                                                  = "App\Models\History\HistoryCamisIboxBoardRoundPotentialDefinite";
        $date_time_now                                                  = CurrentDateOnFormat();

        $camis_patient_id                                               = $request->camis_patient_id;
        $patient_potential_definite_date                                = $request->patient_potential_definite_date ?? 0;
        $patient_potential_definite_type                                = $request->patient_potential_definite_type ?? 0;

        $update_bed_status                                              = '';

        $update_bed_status  = GetPotentialDefiniteDischargeType($patient_potential_definite_type, $patient_potential_definite_date);
        $update_pd_status  = GetPotentialDefiniteDischargeTypeStatus($patient_potential_definite_type, $patient_potential_definite_date);


        $user_id                                                      = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                     = ErrorOccuredMessage();
        $success_array["status"]                                      = 0;
        $functional_identity                                          = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_potential_definite", "ibox_governance_frontend_functional_names");

        if ($camis_patient_id != "" && $user_id != "" && $update_bed_status != '') {
            $gov_text_before_arr                                      = CamisIboxBoardRoundPotentialDefinite::where('patient_id', '=', $camis_patient_id)->first();
            $exist                                                    = CamisIboxBoardRoundPotentialDefinite::where('patient_id', '=', $camis_patient_id)->whereDate('potential_definite_date', $patient_potential_definite_date)->first();

            if ($exist) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($exist, $history_modal, 3);
                $success_array["message"]                       = DataRemovalMessage();

                $updated_array                              = $exist->getOriginal();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    if ($gov_text_before_arr) {
                        $gov_text_before                    = $gov_text_before_arr->toArray();
                        $gov_text_after_arr                 = CamisIboxBoardRoundEstimatedDischargeDate::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 3);
                    }
                }
                $patient_potential_definite_status  = 0;
                $exist->delete();
            } else {
                $updated_data                                             = CamisIboxBoardRoundPotentialDefinite::updateOrCreate(['patient_id' => $camis_patient_id], ['potential_definite_date' => $patient_potential_definite_date, 'type' => $patient_potential_definite_type, 'updated_by' => $user_id]);

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                             = DataAddedMessage();
                    $updated_array                                        = $updated_data->getOriginal();
                    $gov_text_before                                      = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                               = CamisIboxBoardRoundPotentialDefinite::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                             = DataUpdatedMessage();

                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                    = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                          = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                       = CamisIboxBoardRoundPotentialDefinite::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            }



            $success_array["patient_potential_definite_status"]       = $update_pd_status;
            $success_array["updated_date"]                            = date('jS M Y, H:i', strtotime($date_time_now));

            $success_array["status"]                                  = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function RemovePotentialDefiniteBedStatus(Request $request)
    {
        $history_controller                                           = new HistoryController;
        $history_modal                                                = "App\Models\History\HistoryCamisIboxBoardRoundPotentialDefinite";
        $camis_patient_id                                             = $request->camis_patient_id;
        $user_id                                                      = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                     = ErrorOccuredMessage();
        $success_array["status"]                                      = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                      = CamisIboxBoardRoundPotentialDefinite::where('patient_id', '=', $camis_patient_id)->first();
            CamisIboxBoardRoundPotentialDefinite::where('patient_id', '=', $camis_patient_id)->delete();
            $updated_data                                             = $gov_text_before_arr;
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
            $functional_identity                                      = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_potential_definite", "ibox_governance_frontend_functional_names");
            $success_array["message"]                                 = DataRemovalMessage();
            $gov_text_before                                          = $gov_text_before_arr->toArray();
            $gov_text_after_arr                                       = array();
            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
            $success_array["status"]                                  = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetEDNBedStatus(Request $request)
    {
        $success_array                                                = array();
        $camis_patient_id                                             = $request->camis_patient_id;
        $success_array['discharge_planning_edn_status']               = '';

        if ($camis_patient_id != '') {
            $result_data                                              = CamisIboxBoardRoundEdn::where('patient_id', $camis_patient_id)->first();

            if (isset($result_data->discharge_planning_edn_status) && $result_data->discharge_planning_edn_status != 0) {
                $success_array['discharge_planning_edn_status']       = $result_data->discharge_planning_edn_status;
            }
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdateEDNBedStatus(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundEdn";
        $date_time_now                                              = CurrentDateOnFormat();

        $camis_patient_id                                           = $request->camis_patient_id;
        $discharge_planning_edn_status                              = $request->discharge_planning_edn_status ?? 0;
        $update_bed_status                                          = '';

        if ($discharge_planning_edn_status == 1) {
            $update_bed_status  = 'Yes';
        } else if ($discharge_planning_edn_status == 2) {
            $update_bed_status  = 'No';
        } else if ($discharge_planning_edn_status == 3) {
            $update_bed_status  = 'Not Applicable';
        }

        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $functional_identity                                        = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_edn_bed_status", "ibox_governance_frontend_functional_names");


        if ($camis_patient_id != "" && $user_id != "" && $update_bed_status != '') {
            $gov_text_before_arr                                    = CamisIboxBoardRoundEdn::where('patient_id', '=', $camis_patient_id)->first();
            $data_exist                                             = CamisIboxBoardRoundEdn::where('patient_id', '=', $camis_patient_id)->where('discharge_planning_edn_status', $discharge_planning_edn_status)->first();
            if ($data_exist) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($data_exist, $history_modal, 3);
                $success_array["message"]                           = DataRemovalMessage();


                $updated_array                                  = $data_exist->getOriginal();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    if ($gov_text_before_arr) {
                        $gov_text_before                        = $gov_text_before_arr->toArray();
                        $gov_text_after_arr                     = CamisIboxBoardRoundEdn::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 3);
                    }
                }

                $discharge_planning_edn_status = 0;
                $data_exist->delete();
            } else {
                $updated_data                                           = CamisIboxBoardRoundEdn::updateOrCreate(['patient_id' => $camis_patient_id], ['discharge_planning_edn_status' => $discharge_planning_edn_status, 'updated_by' => $user_id]);

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundEdn::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();

                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundEdn::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            }


            $success_array["updated_date"]                          = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["discharge_planning_edn_status"]         = $discharge_planning_edn_status;
            $success_array["status"]                                = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function RemoveEDNBedStatus(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundEdn";

        $camis_patient_id                                           = $request->camis_patient_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundEdn::where('patient_id', '=', $camis_patient_id)->first();
            CamisIboxBoardRoundEdn::where('patient_id', '=', $camis_patient_id)->delete();
            $updated_data                                           = $gov_text_before_arr;
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_edn_bed_status", "ibox_governance_frontend_functional_names");
            $success_array["message"]                               = DataRemovalMessage();
            $gov_text_before                                        = $gov_text_before_arr->toArray();
            $gov_text_after_arr                                     = array();
            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
            $success_array["status"]                                = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetTTOBedStatus(Request $request)
    {
        $success_array                                               = array();
        $camis_patient_id                                            = $request->camis_patient_id;
        $success_array['discharge_planning_tto_status']              = '';
        if ($camis_patient_id != '') {
            $result_data                                             = CamisIboxBoardRoundTto::where('patient_id', $camis_patient_id)->first();
            if (isset($result_data->discharge_planning_tto_status) && $result_data->discharge_planning_tto_status != 0) {
                $success_array['discharge_planning_tto_status']      = $result_data->discharge_planning_tto_status;
            }
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdateTTOBedStatus(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundTto";
        $date_time_now                                              = CurrentDateOnFormat();

        $camis_patient_id                                           = $request->camis_patient_id;
        $discharge_planning_tto_status                              = $request->discharge_planning_tto_status ?? 0;
        $update_bed_status                                          = '';
        if ($discharge_planning_tto_status == 1) {
            $update_bed_status  = 'Yes';
        } else if ($discharge_planning_tto_status == 2) {
            $update_bed_status  = 'No';
        } else if ($discharge_planning_tto_status == 3) {
            $update_bed_status  = 'Not Applicable';
        }

        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $functional_identity                                        = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_tto_bed_status", "ibox_governance_frontend_functional_names");


        if ($camis_patient_id != "" && $user_id != "" && $update_bed_status != '') {
            $gov_text_before_arr                                    = CamisIboxBoardRoundTto::where('patient_id', '=', $camis_patient_id)->first();
            $data_exist                                             = CamisIboxBoardRoundTto::where('patient_id', '=', $camis_patient_id)->where('discharge_planning_tto_status', $discharge_planning_tto_status)->first();
            if ($data_exist) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($data_exist, $history_modal, 3);
                $success_array["message"]                           = DataRemovalMessage();
                $updated_array                                  = $data_exist->getOriginal();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    if ($gov_text_before_arr) {
                        $gov_text_before                         = $gov_text_before_arr->toArray();
                        $gov_text_after_arr                      = CamisIboxBoardRoundTto::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 3);
                    }
                }

                $discharge_planning_tto_status = 0;
                $data_exist->delete();
            } else {
                $updated_data                                           = CamisIboxBoardRoundTto::updateOrCreate(['patient_id' => $camis_patient_id], ['discharge_planning_tto_status' => $discharge_planning_tto_status, 'updated_by' => $user_id]);

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundTto::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                         = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                      = CamisIboxBoardRoundTto::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_bed_status, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            }


            $success_array["updated_date"]                           = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["discharge_planning_tto_status"]          = $discharge_planning_tto_status;
            $success_array["status"]                                 = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }


    public function GetDoctorAtNight(Request $request)
    {
        $doctor_at_night_task = CamisIboxBoardRoundPatientTasks::with(['PatientTaskCategory', 'PatientTaskGroup'])->where('patient_id', $request->camis_patient_id)->whereIn('task_category', [0, 9])->where('task_completed_status', 0)->latest()->get();
        $view                 = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.DoctorAtNightData', compact('doctor_at_night_task'));
        $sections             = $view->render();
        return                $sections;
    }

    public function UpdateDoctorAtNight(Request $request)
    {
        $success_array = array();

        $history_controller                                         = new HistoryController;
        $common_camis_controller                                    = new CommonCamisController;
        $date_time_now                                              = CurrentDateOnFormat();
        $task_create_arr                                            = array();
        $tasks_to_be_assigned = $request->tasks_to_be_assigned;
        $all_pending_task_list = CamisIboxBoardRoundPatientTasks::where('patient_id', $request->camis_patient_id)->whereIn('task_category', [0, 9])->where('task_completed_status', 0)->latest()->get();
        $x = 0;
        foreach ($all_pending_task_list as $task) {
            $task_id                                                    = $task->id;
            $camis_patient_id                                           = $request->camis_patient_id ?? '';
            $task_description                                           = $task->task_description ?? '';
            $task_estimated_date_for_completion_in                      = $task->task_estimated_date_for_completion ?? '';
            $task_estimated_time_for_completion_in                      = $task->task_estimated_time_for_completion ?? '';
            $task_group                                                 = $task->task_group ?? '';
            $task_comment                                               = $task->task_comment ?? '';
            $task_priority                                              = $task->task_priority ?? 0;
            $task_priority                                              = ($task_priority > 0) ? 1 : 0;
            $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
            $patient_details                                            = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', '=', $camis_patient_id)->first();
            $task_estimated_date_for_completion = '';

            if ($task_estimated_date_for_completion_in != '' || $task_estimated_time_for_completion_in  != '') {
                if ($task_estimated_date_for_completion_in != '') {
                    $task_estimated_date_for_completion = date('Y-m-d', strtotime($task_estimated_date_for_completion_in));
                } else {
                    $task_estimated_date_for_completion = date('Y-m-d', strtotime($date_time_now));
                }
                if ($task_estimated_time_for_completion_in != '') {
                    $task_estimated_date_for_completion = $task_estimated_date_for_completion . ' ' . date('H:i:00', strtotime($task_estimated_time_for_completion_in));
                } else {
                    $task_estimated_date_for_completion =  $task_estimated_date_for_completion . ' ' . date('H:i:s', strtotime($date_time_now));
                }
            } else {
                $task_estimated_date_for_completion = date('Y-m-d H:i:s', strtotime($date_time_now));
            }

            if ($task_group != '') {
                $task_group_fetch                                       = TaskGroup::where('task_group_name', '=', $task_group)->first();
                if (isset($task_group_fetch->id) && $task_group_fetch->id != '') {
                    $task_group                                         = $task_group_fetch->id;
                } else {
                    $task_group                                         = TaskGroup::insertGetId(['task_group_name' => $task_group, 'status' => 1]);
                }
            }
            if ($task_description != '' && $task_group != '' && $camis_patient_id != '') {
                $task_create_arr[$x]['task_id']                                     = $task_id;
                $task_create_arr[$x]['patient_id']                                  = $camis_patient_id;
                $task_create_arr[$x]['task_group']                                  = $task_group;
                $task_create_arr[$x]['task_comment']                                = $task_comment;
                $task_create_arr[$x]['task_priority']                               = $task_priority;
                $task_create_arr[$x]['task_description']                            = $task_description;
                $task_create_arr[$x]['task_estimated_date_for_completion']          = $task_estimated_date_for_completion;
                $task_create_arr[$x]['task_updated_by']                             = $user_id;
                $task_create_arr[$x]['task_updated_ward']                           = $patient_details->camis_patient_ward_id ?? 0;
                $task_create_arr[$x]['task_updated_at']                             = $date_time_now;
                if ($request->has('tasks_to_be_assigned') && in_array($task_id, $tasks_to_be_assigned)) {
                    $task_create_arr[$x]['task_category']                               = 9;
                    $task_create_arr[$x]['task_doctor_at_night']                        = 1;
                } else {
                    $task_create_arr[$x]['task_category']                               = 0;
                    $task_create_arr[$x]['task_doctor_at_night']                        = 0;
                }
            }

            $x++;
        }
        if (count($task_create_arr) > 0) {
            $this->WardSummaryPatientTaskInsert($task_create_arr, $camis_patient_id);
        }
        $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
        $success_array["status"]                                                = 1;
        $success_array["message"]                                               = DataAddedMessage();


        if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
            $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
            $view                                                                      = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
        } else {
            $view                                                               = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
        }


        $success_array['sections']                                              = $view->render();


        return ReturnArrayAsJsonToScript($success_array);
    }


    public function RemoveTTOBedStatus(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundTto";
        $date_time_now                                              = CurrentDateOnFormat();

        $camis_patient_id                                           = $request->camis_patient_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundTto::where('patient_id', '=', $camis_patient_id)->first();
            CamisIboxBoardRoundTto::where('patient_id', '=', $camis_patient_id)->delete();
            $updated_data                                           = $gov_text_before_arr;
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_tto_bed_status", "ibox_governance_frontend_functional_names");
            $success_array["message"]                               = DataRemovalMessage();
            $gov_text_before                                        = $gov_text_before_arr->toArray();
            $gov_text_after_arr                                     = array();
            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
            $success_array["status"]                                = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetPharmacyStatus(Request $request)
    {
        $process_array                                         = array();
        $success_array                                         = array();
        $camis_patient_id                                      = $request->camis_patient_id;

        $pharmacy_data['pharmacy_drug_history']                = 0;
        $pharmacy_data['pharmacy_drug_history_date']           = '';
        $pharmacy_data['pharmacy_drug_history_date_show']      = '';
        $pharmacy_data['pharmacy_antibiotic_iv_status']        = 0;
        $pharmacy_data['pharmacy_antibiotic_iv_date']          = '';
        $pharmacy_data['pharmacy_antibiotic_iv_date_show']     = '';
        $pharmacy_data['pharmacy_antibiotic_oral_status']      = 0;
        $pharmacy_data['pharmacy_antibiotic_oral_date']        = '';
        $pharmacy_data['pharmacy_antibiotic_oral_date_show']   = '';
        $pharmacy_data['pharmacy_latest_comment']              = '';

        if ($camis_patient_id != '') {
            $success_array['current_date']                     = CurrentDateOnFormat();
            $success_array['current_date_formatted']           = PredefinedDateFormatFor24Hour($success_array['current_date']);
            $success_array['pharmacy_comment_data']            = CamisIboxBoardRoundPharmacyComment::where('patient_id', $camis_patient_id)->latest()->get();

            $pharmacy_data_temp                                = CamisIboxBoardRoundPharmacyData::where('patient_id', $camis_patient_id)->first();

            if (isset($pharmacy_data_temp->id) && $pharmacy_data_temp->id != '') {
                $pharmacy_data = $pharmacy_data_temp->toArray();
            }

            if ($pharmacy_data['pharmacy_drug_history'] != 0 && $pharmacy_data['pharmacy_drug_history_date'] != '') {
                $pharmacy_data['pharmacy_drug_history_date_show']       = 'Updated : ' . PredefinedDateFormatFor24Hour($pharmacy_data['pharmacy_drug_history_date']);
            } else {
                $pharmacy_data['pharmacy_drug_history_date_show']       = '';
            }

            if ($pharmacy_data['pharmacy_antibiotic_iv_status'] == 1 && $pharmacy_data['pharmacy_antibiotic_iv_date'] != '') {
                $pharmacy_data['pharmacy_antibiotic_iv_date_show']      = 'Updated : ' . PredefinedDateFormatFor24Hour($pharmacy_data['pharmacy_antibiotic_iv_date']);
            } else {
                $pharmacy_data['pharmacy_antibiotic_iv_date_show']      = '';
            }

            if ($pharmacy_data['pharmacy_antibiotic_oral_status'] == 1 && $pharmacy_data['pharmacy_antibiotic_oral_date'] != '') {
                $pharmacy_data['pharmacy_antibiotic_oral_date_show']    = 'Updated : ' . PredefinedDateFormatFor24Hour($pharmacy_data['pharmacy_antibiotic_oral_date']);
            } else {
                $pharmacy_data['pharmacy_antibiotic_oral_date_show']    = '';
            }

            $success_array['pharmacy_data']                             = $pharmacy_data;


            $iv_history_data_query = HistoryCamisIboxBoardRoundPharmacyData::where('patient_id', $camis_patient_id)
                ->whereNotNull('pharmacy_antibiotic_iv_date')
                ->orderBy('pharmacy_antibiotic_iv_date', 'asc')
                ->select('pharmacy_antibiotic_iv_date', 'pharmacy_antibiotic_iv_status')
                ->get()
                ->toArray();


            $iv_history_list = [];
            $start_date = null;
            $previous_date = null;

            foreach ($iv_history_data_query as $entry) {
                $date = $entry['pharmacy_antibiotic_iv_date'];
                $status = $entry['pharmacy_antibiotic_iv_status'];

                if ($status == 1) {
                    $start_date = $date;
                } elseif ($status == 0 && $start_date !== null) {
                    $iv_history_list[] = ['start_date' => $start_date, 'end_date' => $date];
                    $start_date = null;
                }
            }

            if ($start_date !== null) {
                $iv_history_list[] = ['start_date' => $start_date, 'end_date' => null];
            }




            $oral_history_data_query = HistoryCamisIboxBoardRoundPharmacyData::where('patient_id', $camis_patient_id)
                ->orderBy('pharmacy_antibiotic_oral_date', 'asc')
                ->whereNotNull('pharmacy_antibiotic_oral_date')
                ->select('pharmacy_antibiotic_oral_date', 'pharmacy_antibiotic_oral_status')
                ->get()
                ->toArray();

            $oral_history_list = [];

            $start_date = null;
            foreach ($oral_history_data_query as $entry) {
                $date = $entry['pharmacy_antibiotic_oral_date'];
                $status = $entry['pharmacy_antibiotic_oral_status'];

                if ($status == 1) {
                    $start_date = $date;
                } elseif ($status == 0 && $start_date !== null) {
                    $oral_history_list[] = ['start_date' => $start_date, 'end_date' => $date];
                    $start_date = null;
                }
            }

            if ($start_date !== null) {
                $oral_history_list[] = ['start_date' => $start_date, 'end_date' => null];
            }


            $view                                                       = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.PharmacyInfo', compact('success_array', 'iv_history_list', 'oral_history_list'));
            $sections                                                   = $view->render();
            return $sections;
        }
        return '';
    }

    public function UpdatePharmacyStatus(Request $request)
    {

        $history_controller                         = new HistoryController;
        $history_modal                              = "App\Models\History\HistoryCamisIboxBoardRoundPharmacyData";
        $history_modal_pharmacy_screened            = "App\Models\History\HistoryCamisDataPhamacyScreened";
        $date_time_now                              = CurrentDateOnFormat();

        $camis_patient_id                           = $request->camis_patient_id;
        $pharmacy_drug_history                      = $request->pharmacy_drug_history ?? 0;
        $patient_screened_val                      = $request->patient_screened_val ?? 0;
        $pharmacy_drug_history_date                 = $request->pharmacy_drug_history_date ?? '';
        $pharmacy_latest_comment                    = $request->pharmacy_latest_comment ?? '';

        $pharmacy_drug_history_date                 = ($pharmacy_drug_history_date == '') ? null : $pharmacy_drug_history_date;
        $update_pharmacy_status                     = '';

        if ($pharmacy_drug_history == 1) {
            $update_pharmacy_status                 = 'Drug History Partial';
        } else if ($pharmacy_drug_history == 2) {
            $update_pharmacy_status                 = 'Drug History Full';
        } else if ($pharmacy_drug_history == 3) {
            $update_pharmacy_status                 = 'Medication In Draft To Be Reviewed';
        } else {
            $update_pharmacy_status                 = 'No Pharmacy Status';
        }
        if ($patient_screened_val == 1) {
            $update_pharmacy_screened_text          = 'Pharmacy Screened';
            $ward_id                                =    CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $camis_patient_id)->first()->ibox_ward_id ?? 0;
        }




        $user_id                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                   = ErrorOccuredMessage();
        $success_array["status"]                    = 0;

        if ($camis_patient_id != "" && $user_id != "" && $patient_screened_val == 1) {
            $gov_text_before_arr_screened_val                    = CamisIboxBoardRoundPharmacyScreened::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data_screened_val                           = CamisIboxBoardRoundPharmacyScreened::updateOrCreate(['patient_id' => $camis_patient_id], ['ward_id' => $ward_id,  'updated_by' => $user_id]);
            $functional_identity                                 = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_pharmacy_status", "ibox_governance_frontend_functional_names");

            if ($updated_data_screened_val->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data_screened_val, $history_modal_pharmacy_screened, 1);
                $success_array["message"]          = DataAddedMessage();
                $updated_array_screened_val                     = $updated_data_screened_val->getOriginal();
                $gov_text_before_screened_val                   = array();
                if (count($updated_array_screened_val) > 0 && isset($updated_array_screened_val["id"])) {
                    $gov_text_after_arr_screened_val            = CamisIboxBoardRoundPharmacyScreened::where('id', '=', $updated_array_screened_val["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before_screened_val, $update_pharmacy_screened_text, $gov_text_after_arr_screened_val, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data_screened_val, $history_modal_pharmacy_screened, 2);
                $success_array["message"]           = DataUpdatedMessage();
                if (count($updated_data_screened_val->getChanges()) > 0) {
                    $updated_array_screened_val                   = $updated_data_screened_val->getOriginal();
                    if (count($updated_array_screened_val) > 0 && isset($updated_data_screened_val["id"])) {
                        if ($gov_text_before_arr_screened_val) {
                            $gov_text_before_screened_val        = $gov_text_before_arr_screened_val->toArray();
                            $gov_text_after_arr_screened_val     = CamisIboxBoardRoundPharmacyScreened::where('id', '=', $updated_array_screened_val["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before_screened_val, $update_pharmacy_screened_text, $gov_text_after_arr_screened_val, $functional_identity, 2);
                        }
                    }
                }
            }
        }

        if ($camis_patient_id != "" && $user_id != "" && $update_pharmacy_status != '') {
            $gov_text_before_arr                    = CamisIboxBoardRoundPharmacyData::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                           = CamisIboxBoardRoundPharmacyData::updateOrCreate(['patient_id' => $camis_patient_id], ['pharmacy_drug_history' => $pharmacy_drug_history, 'pharmacy_drug_history_date' => $pharmacy_drug_history_date, 'pharmacy_latest_comment' => $pharmacy_latest_comment, 'updated_by' => $user_id]);
            $functional_identity                   = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_pharmacy_status", "ibox_governance_frontend_functional_names");

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]          = DataAddedMessage();
                $updated_array                     = $updated_data->getOriginal();
                $gov_text_before                   = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr            = CamisIboxBoardRoundPharmacyData::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_pharmacy_status, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr     = CamisIboxBoardRoundPharmacyData::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_pharmacy_status, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }


            $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["pharmacy_latest_comment"]                   = $pharmacy_latest_comment;
            $success_array["update_pharmacy_status"]                    = $update_pharmacy_status;
            $success_array["status"]                                    = 1;
        }

        if ($pharmacy_latest_comment != '') {
            $history_modal                                          = "App\Models\History\HistoryCamisIboxBoardRoundPharmacyComment";
            $gov_text_before_arr                                    = array();
            $updated_data                                           = ['patient_id' => $camis_patient_id, 'pharmacy_comment' => $pharmacy_latest_comment, 'updated_by' => $user_id];
            $get_id                                                 = CamisIboxBoardRoundPharmacyComment::insertGetId($updated_data);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_pharmacy_comment", "ibox_governance_frontend_functional_names");
            if ($get_id  != '' && $get_id > 0) {
                $updated_data                                       = CamisIboxBoardRoundPharmacyComment::updateOrCreate(['id' => $get_id], ['patient_id' => $camis_patient_id]);
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $gov_text_before                                    = array();
                $gov_text_after_arr                                 = CamisIboxBoardRoundPharmacyComment::where('id', '=', $get_id)->first();
                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $pharmacy_latest_comment, $gov_text_after_arr, $functional_identity, 1);
            }
            $success_array["message"]          = DataAddedMessage();
        }
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        $success_array["pharmacy_latest_comment"]                   = $pharmacy_latest_comment;

        $success_array["status"]                                    = 1;

        return ReturnArrayAsJsonToScript($success_array);
    }



    public function UpdateAntibioticIV(Request $request)
    {
        $history_controller                         = new HistoryController;
        $history_modal                              = "App\Models\History\HistoryCamisIboxBoardRoundPharmacyData";
        $date_time_now                              = CurrentDateOnFormat();

        $camis_patient_id                           = $request->camis_patient_id;
        $pharmacy_antibiotic_iv_status              = $request->pharmacy_antibiotic_iv_status ?? 0;
        $pharmacy_antibiotic_iv_date                = CurrentDateOnFormat();

        $pharmacy_antibiotic_iv_date                = ($pharmacy_antibiotic_iv_date == '') ? null : $pharmacy_antibiotic_iv_date;
        $update_pharmacy_status                     = '';


        if ($pharmacy_antibiotic_iv_status == 1) {
            $update_pharmacy_status                .= 'Antibiotics: IV';
        }

        $user_id                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                   = ErrorOccuredMessage();
        $success_array["status"]                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                    = CamisIboxBoardRoundPharmacyData::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                           = CamisIboxBoardRoundPharmacyData::updateOrCreate(['patient_id' => $camis_patient_id], ['pharmacy_antibiotic_iv_status' => $pharmacy_antibiotic_iv_status, 'pharmacy_antibiotic_iv_date' => $pharmacy_antibiotic_iv_date, 'updated_by' => $user_id]);
            $functional_identity                   = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_pharmacy_status", "ibox_governance_frontend_functional_names");

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]          = DataAddedMessage();
                $updated_array                     = $updated_data->getOriginal();
                $gov_text_before                   = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr            = CamisIboxBoardRoundPharmacyData::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_pharmacy_status, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr     = CamisIboxBoardRoundPharmacyData::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_pharmacy_status, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }

            $success_array["updated_date_timestamp"]                    = 'Since ' . PatientLos(date('jS M Y, H:i', strtotime($date_time_now)));
            $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["update_antibiotic_iv"]                      = $update_pharmacy_status;
            $success_array["status"]                                    = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }


    public function UpdateAntibioticOral(Request $request)
    {
        $history_controller                         = new HistoryController;
        $history_modal                              = "App\Models\History\HistoryCamisIboxBoardRoundPharmacyData";
        $date_time_now                              = CurrentDateOnFormat();

        $camis_patient_id                           = $request->camis_patient_id;
        $pharmacy_antibiotic_oral_status            = $request->pharmacy_antibiotic_oral_status ?? 0;
        $pharmacy_antibiotic_oral_date              = CurrentDateOnFormat();

        $pharmacy_antibiotic_oral_date              = ($pharmacy_antibiotic_oral_date == '') ? null : $pharmacy_antibiotic_oral_date;
        $update_pharmacy_status                     = '';


        if ($pharmacy_antibiotic_oral_status == 1) {
            $update_pharmacy_status                .= 'Antibiotics: ORAL';
        }

        $user_id                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                   = ErrorOccuredMessage();
        $success_array["status"]                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                    = CamisIboxBoardRoundPharmacyData::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                           = CamisIboxBoardRoundPharmacyData::updateOrCreate(['patient_id' => $camis_patient_id], ['pharmacy_antibiotic_oral_status' => $pharmacy_antibiotic_oral_status, 'pharmacy_antibiotic_oral_date' => $pharmacy_antibiotic_oral_date, 'updated_by' => $user_id]);
            $functional_identity                   = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_pharmacy_status", "ibox_governance_frontend_functional_names");

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]          = DataAddedMessage();
                $updated_array                     = $updated_data->getOriginal();
                $gov_text_before                   = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr            = CamisIboxBoardRoundPharmacyData::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_pharmacy_status, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr     = CamisIboxBoardRoundPharmacyData::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $update_pharmacy_status, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }


            $success_array["updated_date_timestamp"]                    = 'Since ' . PatientLos(date('jS M Y, H:i', strtotime($date_time_now)));
            $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["update_antibiotic_oral"]                    = $update_pharmacy_status;
            $success_array["status"]                                    = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }


    public function GetBoardRoundPatientTaskDetails(Request $request)
    {

        $process_array                                         = array();
        $success_array                                         = array();
        $task_id                                               = $request->completed_task_id;
        $success_array['patient_task']                         = CamisIboxBoardRoundPatientTasks::with('PatientTaskGroup')->where('id', $task_id)->first();
        if ($success_array['patient_task'] != null) {

            $success_array["status"]                                                = 1;
            $success_array["message"]                                               = 'Task Details Exists';
            $view                                                                   = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.TaskDetailsView', compact('success_array'));
            $success_array['sections']                                              = $view->render();
        } else {
            $success_array["status"]                                                = 0;
            $success_array["message"]                                               = NotFoundMessage();
        }
        return ReturnArrayAsJsonToScript($success_array);
    }
    public function GetAllowedToBeMoved(Request $request)
    {
        $success_array                                                              = array();
        $camis_patient_id                                                           = $request->camis_patient_id;

        $patient_info                                                               = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $request->camis_patient_id)->first();

        $success_array['patient_current_ward']                                      = $patient_info->ibox_ward_short_name;
        $success_array['allowed_to_move_to']                                        = 0;

        $success_array['patient_allowed_to_be_moved_to']                            = '';
        $success_array['patient_allowed_to_be_moved_comment']                       = '';

        if ($camis_patient_id != '') {
            $success_array["status"]                                                = 1;
            $result_data                                                            = CamisIboxBoardRoundAllowedToMove::where('patient_id', $camis_patient_id)->first();
            if (isset($result_data->patient_allowed_to_be_moved_to) && $result_data->patient_allowed_to_be_moved_to != '') {
                $success_array['patient_allowed_to_be_moved_to']                     = $result_data->patient_allowed_to_be_moved_to;
                $success_array['patient_allowed_to_be_moved_comment']                     = $result_data->patient_allowed_to_be_moved_comment;
                if (strtolower($result_data->patient_allowed_to_be_moved_to) == 'do not move') {
                    $success_array['allowed_to_move_to']                                        = 2;
                } else {
                    $success_array['allowed_to_move_to']                                        = 1;
                }
            }
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdateAllowedToBeMoved(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundAllowedToMove";
        $date_time_now                                              = CurrentDateOnFormat();

        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_allowed_to_be_moved_to                             = $request->patient_allowed_to_be_moved_to;
        $patient_allowed_to_be_moved_from                           = $request->patient_allowed_to_be_moved_from;
        $patient_allowed_to_be_moved_comment                        = $request->patient_allowed_to_be_moved_comment;
        $success_array["patient_allowed_to_be_moved_to"]            = '';
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr        = CamisIboxBoardRoundAllowedToMove::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data               = CamisIboxBoardRoundAllowedToMove::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_allowed_to_be_moved_to' => $patient_allowed_to_be_moved_to, 'patient_allowed_to_be_moved_from' => $patient_allowed_to_be_moved_from, 'patient_allowed_to_be_moved_comment' => $patient_allowed_to_be_moved_comment, 'declined_by' => null, 'accepted_by' => null, 'declined_reason' => null, 'status' => 0, 'accepted_time' => null, 'declined_time' => null, 'updated_by' => $user_id]);

            $functional_identity        = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_allowed_to_move", "ibox_governance_frontend_functional_names");
            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundAllowedToMove::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_allowed_to_be_moved_to, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundAllowedToMove::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_allowed_to_be_moved_to, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["updated_date"]                          = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["updated_date_show"]                     = date('jS M H:i', strtotime($date_time_now));
            $all_wards = Wards::select('id', 'ward_short_name', 'ward_name', 'ward_shown_name')->where('status', 1)->get()->toArray();

            $ward_array = array_reduce($all_wards, function ($carry, $ward_data) {
                $carry[$ward_data['ward_short_name']] = !empty($ward_data['ward_shown_name']) ? $ward_data['ward_shown_name'] : $ward_data['ward_name'];
                return $carry;
            }, []);

            $success_array["patient_allowed_to_be_moved_to"]        = isset($ward_array[$patient_allowed_to_be_moved_to]) ? $ward_array[$patient_allowed_to_be_moved_to] : 'Do Not Move';
            $success_array["status"]                                = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function RemoveAllowedToBeMoved(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundAllowedToMove";
        $camis_patient_id                                           = $request->camis_patient_id;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundAllowedToMove::where('patient_id', '=', $camis_patient_id)->first();
            if (isset($gov_text_before_arr->id) && $gov_text_before_arr->id != '') {
                CamisIboxBoardRoundAllowedToMove::where('patient_id', '=', $camis_patient_id)->delete();
                $updated_data                                       = $gov_text_before_arr;
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
                $functional_identity                                = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_allowed_to_move", "ibox_governance_frontend_functional_names");
                $success_array["message"]                           = DataRemovalMessage();
                $gov_text_before                                    = $gov_text_before_arr->toArray();
                $gov_text_after_arr                                 = array();
                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                $success_array["status"]                            = 1;
            }
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function WardSummaryPatientTaskInsert($patient_task_data, $camis_patient_id)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientTasks";
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $functional_identity                                        = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_task", "ibox_governance_frontend_functional_names");
        $master_task_group                                          = TaskGroup::pluck('task_group_name', 'id')->all();
        $master_task_category                                       = TaskCategory::pluck('task_category_name', 'task_category_index_value')->all();
        $camis_vitalpac_data                                        = CamisIboxPatientInfoVitalpacView::select('totalews', 'time_started_obs')->where('totalews', '>', 0)->where('camis_patient_id', $camis_patient_id)->first();

        if (count($patient_task_data) > 0) {
            foreach ($patient_task_data as $patient_task_each) {

                $patient_task_show_string                                   = '';
                $task_id                                                    = $patient_task_each['task_id'];
                unset($patient_task_each['task_id']);
                if ($task_id != '') {
                    $data_insert_update_delete_status                       = 2;
                    if (isset($patient_task_each['task_completed_status']) && $patient_task_each['task_completed_status'] == 1) {
                        $data_insert_update_delete_status                   = 2;
                    }
                    if (isset($patient_task_each['task_not_applicable_status']) && $patient_task_each['task_not_applicable_status'] == 1) {
                        $data_insert_update_delete_status                   = 3;
                    }
                    $gov_text_before_arr                                    = CamisIboxBoardRoundPatientTasks::where('id', '=', $task_id)->first();
                    if (isset($gov_text_before_arr->id) && $gov_text_before_arr->id != '') {
                        $updated_data                                       = CamisIboxBoardRoundPatientTasks::updateOrCreate(['id' => $task_id], $patient_task_each);
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, $data_insert_update_delete_status);
                        $success_array["message"]                           = DataUpdatedMessage();
                        if (count($updated_data->getChanges()) > 0) {
                            $updated_array                                  = $updated_data->getOriginal();
                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                if ($gov_text_before_arr) {
                                    $gov_text_before                        = $gov_text_before_arr->toArray();
                                    $gov_text_after_arr                     = CamisIboxBoardRoundPatientTasks::where('id', '=', $updated_array["id"])->first();
                                    if (isset($gov_text_after_arr) &&  $gov_text_after_arr->id != '') {
                                        $govern_title =  $gov_text_after_arr->toArray();
                                        if (isset($master_task_category[$govern_title['task_category']]) && $master_task_category[$govern_title['task_category']] != '') {
                                            if ($govern_title['task_category'] == 6) {
                                                $dp_order = $govern_title['task_dp_status_order_value'];
                                            } else {
                                                $dp_order = '';
                                            }

                                            $patient_task_show_string                          .= '#' . $master_task_category[$govern_title['task_category']] . ' ' . $dp_order . ' - ';

                                            $patient_task_show_string_class                     = strtolower($master_task_category[$govern_title['task_category']]);
                                        }
                                        $patient_task_show_string                              .= $govern_title['task_description'];
                                        $patient_task_show_string                              .= ' - ' . PredefinedDateFormatBoardRoundTaskToBeCompleted($govern_title['task_estimated_date_for_completion']);
                                        if (isset($master_task_group[$govern_title['task_group']]) && $master_task_group[$govern_title['task_group']] != '') {
                                            $patient_task_show_string                          .= ' - ' . $master_task_group[$govern_title['task_group']];
                                        }
                                    }




                                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_task_show_string, $gov_text_after_arr, $functional_identity, $data_insert_update_delete_status);
                                }
                            }
                        }
                    }
                } else {
                    if (!isset($patient_task_each['task_dp_status_order_value'])) {
                        $patient_task_each['task_dp_status_order_value'] = 0;
                    }
                    if (CamisIboxBoardRoundPatientTasks::where('task_description', $patient_task_each['task_description'])->where('task_dp_status_order_value', $patient_task_each['task_dp_status_order_value'])->where('task_category', $patient_task_each['task_category'])->where('patient_id', $patient_task_each['patient_id'])->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->doesntExist()) {
                        if ($camis_vitalpac_data != null) {
                            if (isset($camis_vitalpac_data->totalews) && $camis_vitalpac_data->totalews != '') {
                                $patient_task_each['patient_ews_score_on_creation'] = $camis_vitalpac_data->totalews;
                            } else {
                                $patient_task_each['patient_ews_score_on_creation'] = CurrentDateOnFormat();
                            }


                            if (isset($camis_vitalpac_data->time_started_obs) && $camis_vitalpac_data->time_started_obs != '') {
                                $patient_task_each['patient_ews_score_updated_date'] = $camis_vitalpac_data->time_started_obs;
                            } else {
                                $patient_task_each['patient_ews_score_updated_date'] = CurrentDateOnFormat();
                            }
                        }



                        $inserted_task_id                                       = CamisIboxBoardRoundPatientTasks::insertGetId($patient_task_each);
                        $inserted_task_ids[]                                    = $inserted_task_id;
                        $gov_text_after_arr                                     = CamisIboxBoardRoundPatientTasks::where('id', '=', $inserted_task_id)->first();

                        if (isset($gov_text_after_arr->id) && $gov_text_after_arr->id != '') {
                            $updated_data                                       = $gov_text_after_arr;
                            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                            $gov_text_after                                     = $gov_text_after_arr->toArray();
                            $gov_text_before                                    = array();
                            $govern_title                                       = $gov_text_after;
                            if (isset($master_task_category[$govern_title['task_category']]) && $master_task_category[$govern_title['task_category']] != '') {
                                if ($govern_title['task_category'] == 6) {
                                    $dp_order = $govern_title['task_dp_status_order_value'];
                                } else {
                                    $dp_order = '';
                                }
                                $patient_task_show_string                          .= '#' . $master_task_category[$govern_title['task_category']] . ' ' . $dp_order . ' - ';
                                $patient_task_show_string_class                     = strtolower($master_task_category[$govern_title['task_category']]);
                            }
                            $patient_task_show_string                              .= $govern_title['task_description'];
                            $patient_task_show_string                              .= ' - ' . PredefinedDateFormatBoardRoundTaskToBeCompleted($govern_title['task_estimated_date_for_completion']);
                            if (isset($master_task_group[$govern_title['task_group']]) && $master_task_group[$govern_title['task_group']] != '') {
                                $patient_task_show_string                          .= ' - ' . $master_task_group[$govern_title['task_group']];
                            }

                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_task_show_string, $gov_text_after_arr, $functional_identity, 1);
                        }
                    }
                }
            }
        }
    }


    public function WardSummaryPatientTaskRemove($patient_task_data, $camis_patient_id)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientTasks";
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $functional_identity                                        = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_task", "ibox_governance_frontend_functional_names");


        foreach ($patient_task_data as $task) {
            $task_id = $task['task_id'];
            $gov_text_before_arr                                    = CamisIboxBoardRoundPatientTasks::where('id', '=', $task_id)->first();
            if (isset($gov_text_before_arr->id) && $gov_text_before_arr->id != '') {
                $updated_data                                       = CamisIboxBoardRoundPatientTasks::where('id', $task_id)->delete();
                $history_controller->HistoryTableDataInsertFromUpdateCreate($gov_text_before_arr, $history_modal, 3);

                $patient_task_show_string = '';

                if ($task['task_category'] == 6) {
                    if ($task['dp_order'] > 1) {
                        $dp_value = ($task['dp_order'] - 1);
                    } else {
                        $dp_value = 1;
                    }
                    $patient_task_show_string = '#DP ' . $dp_value . ' - ' . $task['des'] . '';
                } else if ($task['task_category'] == 7) {
                    $patient_task_show_string = '#SEPSIS - ' . $task['des'] . '';
                } else if ($task['task_category'] == 8) {
                    $patient_task_show_string = '#AKI - ' . $task['des'] . '';
                } else if ($task['task_category'] == 1) {
                    $patient_task_show_string = '#NOF - ' . $task['des'] . '';
                }



                $gov_text_before                        = $gov_text_before_arr->toArray();
                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_task_show_string, array(), $functional_identity, 3);
            }
        }
    }






    public function UpdatePatientTaskBoardRound(Request $request)
    {

        $success_array                                              = array();
        $history_controller                                         = new HistoryController;
        $common_camis_controller                                    = new CommonCamisController;
        $date_time_now                                              = CurrentDateOnFormat();

        $task_id                                                    = $request->task_id ?? '';
        $camis_patient_id                                           = $request->camis_patient_id ?? '';
        $task_description                                           = $request->task_description ?? '';
        $task_estimated_date_for_completion_in                      = $request->task_estimated_date_for_completion ?? '';
        $task_estimated_time_for_completion_in                      = $request->task_estimated_time_for_completion ?? '';
        $task_group                                                 = $request->task_group ?? '';
        $task_comment                                               = $request->task_comment ?? '';
        $task_priority                                              = $request->task_priority ?? 0;
        $task_category                                              = $request->task_category ?? 0;
        $task_priority                                              = ($task_priority > 0) ? 1 : 0;
        $task_daily                                                 = $request->task_daily ?? 0;
        $task_daily                                                 = ($task_daily > 0) ? 1 : 0;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $task_create_arr                                            = array();
        $patient_details                                            = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', '=', $camis_patient_id)->first();

        $task_estimated_date_for_completion = '';

        if ($task_estimated_date_for_completion_in != '' || $task_estimated_time_for_completion_in  != '') {
            if ($task_estimated_date_for_completion_in != '') {
                $task_estimated_date_for_completion = date('Y-m-d', strtotime($task_estimated_date_for_completion_in));
            } else {
                $task_estimated_date_for_completion = date('Y-m-d', strtotime($date_time_now));
            }
            if ($task_estimated_time_for_completion_in != '') {
                $task_estimated_date_for_completion = $task_estimated_date_for_completion . ' ' . date('H:i:00', strtotime($task_estimated_time_for_completion_in));
            } else {
                $task_estimated_date_for_completion =  $task_estimated_date_for_completion . ' ' . date('H:i:s', strtotime($date_time_now));
            }
        } else {
            $task_estimated_date_for_completion = date('Y-m-d H:i:s', strtotime($date_time_now));
        }

        if ($task_group != '') {
            $task_group_fetch                                       = TaskGroup::where('task_group_name', '=', $task_group)->first();
            if (isset($task_group_fetch->id) && $task_group_fetch->id != '') {
                $task_group                                         = $task_group_fetch->id;
            } else {
                $task_group                                         = TaskGroup::insertGetId(['task_group_name' => $task_group, 'status' => 1]);
            }
        }
        if ($task_description != '' && $task_group != '' && $camis_patient_id != '') {
            $x = 0;
            $task_create_arr[$x]['task_id']                                     = $task_id;
            $task_create_arr[$x]['patient_id']                                  = $camis_patient_id;
            $task_create_arr[$x]['task_group']                                  = $task_group;
            $task_create_arr[$x]['task_comment']                                = $task_comment;
            $task_create_arr[$x]['task_priority']                               = $task_priority;
            $task_create_arr[$x]['task_daily']                                  = $task_daily;
            $task_create_arr[$x]['task_description']                            = $task_description;
            $task_create_arr[$x]['task_estimated_date_for_completion']          = $task_estimated_date_for_completion;
            $task_create_arr[$x]['task_updated_by']                             = $user_id;
            $task_create_arr[$x]['task_updated_ward']                           = $patient_details->camis_patient_ward_id ?? 0;
            $task_create_arr[$x]['task_updated_at']                             = $date_time_now;
            if ($task_category == 9) {
                $task_create_arr[$x]['task_doctor_at_night']                    = 1;
            }
            if ($task_id == '') {
                $task_create_arr[$x]['task_category']                           = $task_category;
                $task_create_arr[$x]['task_created_by']                         = $user_id;
                $task_create_arr[$x]['task_created_ward']                       = $patient_details->camis_patient_ward_id ?? 0;
                $task_create_arr[$x]['task_created_at']                         = $date_time_now;
            } else {
                $task_create_arr[$x]['task_category']                           = $task_category;
            }
        }
        if (count($task_create_arr) > 0) {
            $this->WardSummaryPatientTaskInsert($task_create_arr, $camis_patient_id);
        }
        if ($task_category == 9) {
            $cat = 9;
        } else {
            $cat = 0;
        }
        $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id, $cat);


        if (CamisIboxBoardRoundPatientTasks::whereIn('task_category', [6, 7, 8])->where('patient_id', $camis_patient_id)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->count() > 1) {
            $success_array['complete_dp_task']                                 = 0;
        } else {
            $success_array['complete_dp_task']                                 = 1;
        }



        $success_array["status"]                                                = 1;
        $success_array["message"]                                               = DataAddedMessage();

        if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
            $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
            $view                                             = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
        } else {

            $view                                             = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
        }
        $success_array['sections']                                              = $view->render();

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function CompletePatientTaskWithCategoryBoardRound(Request $request)
    {
        $success_array                                              = array();
        $history_controller                                         = new HistoryController;
        $common_camis_controller                                    = new CommonCamisController;
        $date_time_now                                              = CurrentDateOnFormat();

        $task_id                                                    = $request->task_id ?? '';
        $camis_patient_id                                           = $request->camis_patient_id ?? '';
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $task_create_arr                                            = array();
        $patient_details                                            = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', '=', $camis_patient_id)->first();
        $task_estimated_date_for_completion                         = '';
        $task_extra_data                                            = array();

        if ($request->has('type') && strtolower($request->type) == strtolower('escalation')) {
            if ($request->escalation == 'Yes') {
                $task_extra_data['escalation_status']               = 'Yes';
            } else {
                $task_extra_data['escalation_status']               = 'No';
                $task_extra_data['eol']                             = $request->eol_data;
                $task_extra_data['others']                          = $request->others_data;
                $task_extra_data['escalation_text']                 = $request->escalation_text;
                $dp_flag = CamisIboxBoardRoundPatientFlag::where('patient_id', $camis_patient_id)->where('patient_flag_name', 'ibox_patient_flag_covid_dp')->pluck('id')->toArray();
                CamisIboxBoardRoundPatientFlag::whereIn('id', $dp_flag)->delete();
                CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->whereIn('task_category', [6, 7, 8])->where('task_completed_status', 6)->where('task_not_applicable_status', 6)->where('task_description', '!=', 'Escalation Status')->delete();

                $task_remove_arr    = array();

                $task_to_remove = CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->whereIn('task_category', [6, 7, 8])->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->where('task_description', '!=', 'Escalation Status')->get()->toArray();
                $z = 1;
                if (count($task_to_remove) > 0) {
                    foreach ($task_to_remove as $remove_task) {
                        $task_remove_arr[$z]['task_id']                                 = $remove_task['id'];
                        $task_remove_arr[$z]['task_not_applicable_status']              = 1;
                        $task_remove_arr[$z]['task_not_applicable_by']                  = $user_id;
                        $task_remove_arr[$z]['task_not_applicable_ward']                = $patient_details->camis_patient_ward_id ?? 0;
                        $task_remove_arr[$z]['task_not_applicable_at']                  = CurrentDateOnFormat();
                        $z++;
                    }


                    $this->WardSummaryPatientTaskInsert($task_remove_arr, $camis_patient_id);
                }
            }
        } elseif ($request->has('type') && $request->type == 'resus_status_limitation_plan') {
            $task_extra_data['to_check_resus_status_limitation_plan']             = $request->to_check_resus_status_limitation_plan;
        } elseif ($request->has('type') && $request->type == 'dp_escalation_plan_status') {
            $task_extra_data['escalation_plan']             = $request->dp_escalation_plan;
        } elseif ($request->has('type') && $request->type == 'capullary_blood_glucose') {
            $task_extra_data['capullary_blood_glucose_result']             = $request->capullary_blood_glucose;
        } elseif ($request->has('type') && $request->type == 'working_diagnosis_update') {
            $task_extra_data['working_diagnosis_update_on_ibox']    = $request->working_diagnosis_update;




            $wd_history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundWorkingDiagnosis";
            $patient_working_diagnosis                                     = $request->working_diagnosis_update;
            $success_array["patient_working_diagnosis"]                    = $patient_working_diagnosis;

            if ($camis_patient_id != "" && $user_id != "") {
                $wd_gov_text_before_arr                                    = CamisIboxBoardRoundWorkingDiagnosis::where('patient_id', '=', $camis_patient_id)->first();
                $wd_updated_data                                           = CamisIboxBoardRoundWorkingDiagnosis::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_working_diagnosis' => $patient_working_diagnosis, 'updated_by' => $user_id]);
                $wd_functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_working_diagnosis", "ibox_governance_frontend_functional_names");

                if ($wd_updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($wd_updated_data, $wd_history_modal, 1);

                    $wd_updated_array                                   = $wd_updated_data->getOriginal();
                    $wd_gov_text_before                                    = array();
                    if (count($wd_updated_array) > 0 && isset($wd_updated_array["id"])) {
                        $wd_gov_text_after_arr                             = CamisIboxBoardRoundWorkingDiagnosis::where('id', '=', $wd_updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $wd_gov_text_before, $patient_working_diagnosis, $wd_gov_text_after_arr, $wd_functional_identity, 1);
                    }
                } else {

                    $history_controller->HistoryTableDataInsertFromUpdateCreate($wd_updated_data, $wd_history_modal, 2);

                    if (count($wd_updated_data->getChanges()) > 0) {
                        $wd_updated_array                                  = $wd_updated_data->getOriginal();
                        if (count($wd_updated_array) > 0 && isset($wd_updated_array["id"])) {
                            if ($wd_gov_text_before_arr) {
                                $wd_gov_text_before                        = $wd_gov_text_before_arr->toArray();
                                $wd_gov_text_after_arr                     = CamisIboxBoardRoundWorkingDiagnosis::where('id', '=', $wd_updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $wd_gov_text_before, $patient_working_diagnosis, $wd_gov_text_after_arr, $wd_functional_identity, 2);
                            }
                        }
                    }
                }
            }
        } elseif ($request->has('resuscitation')) {
            $task_extra_data['resuscitation_status_known?']    = $request->resuscitation;
        } elseif ($request->has('tep')) {
            $task_extra_data['is_tep_in_place?']    = $request->tep;
        } elseif ($request->has('reasonable_required')) {
            $task_extra_data['reasonable_adjustments_required?']    = $request->reasonable_required;
        } elseif ($request->has('reasonable_consider')) {
            $task_extra_data['reasonable_adjustments_considered?']    = $request->reasonable_consider;
        } elseif ($request->has('sepsis_status')) {
            $task_extra_data['could_this_be_sepsis?'] = 'No';
        } elseif ($request->has('diabetic')) {
            $task_extra_data['is_diabetes_suspected_or_known?'] = $request->diabetic;
        }




        $current_task = CamisIboxBoardRoundPatientTasks::where('id', $task_id)->first();

        $check_task = CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->where('task_description', $current_task->task_description)->where('task_category', 6)->where(function ($query) {
            $query->where('task_not_applicable_status', 1);
            $query->orWhere('task_completed_status', 1);
        })->latest()->first();
        if ($check_task != null) {
            $dp_value = ($check_task->task_dp_status_order_value + 1);
        } else {
            $dp_value = 1;
        }

        if ($task_id != '' && $camis_patient_id != '') {
            $x = 0;
            $task_create_arr[$x]['task_id']                         = $task_id;
            $task_create_arr[$x]['task_completed_status']           = 1;
            $task_create_arr[$x]['task_completed_by']               = $user_id;



            $task_create_arr[$x]['task_extra_data']                 = json_encode($task_extra_data);
            $task_create_arr[$x]['task_completed_ward']             = $patient_details->camis_patient_ward_id ?? 0;
            $task_create_arr[$x]['task_completed_at']               = $date_time_now;
        }

        if (count($task_create_arr) > 0) {
            $this->WardSummaryPatientTaskInsert($task_create_arr, $camis_patient_id);
        }


        $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
        $success_array["status"]                                    = 1;
        $success_array["message"]                                   = DataAddedMessage();
        if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
            $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
            $view                                             = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
        } else {

            $view                                             = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
        }
        $success_array['sections']                                  = $view->render();

        if (CamisIboxBoardRoundPatientTasks::whereIn('task_category', [6, 7, 8])->where('patient_id', $camis_patient_id)->where('task_not_applicable_status', 0)->where('task_completed_status', 0)->count() > 1) {
            $success_array['complete_dp_task']                                 = 0;
        } else {
            $success_array['complete_dp_task']                                 = 1;
        }
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function CompletePatientTaskBoardRound(Request $request)
    {

        $success_array                                              = array();
        $history_controller                                         = new HistoryController;
        $common_camis_controller                                    = new CommonCamisController;
        $date_time_now                                              = CurrentDateOnFormat();

        $task_id                                                    = $request->task_id ?? '';
        $camis_patient_id                                           = $request->camis_patient_id ?? '';
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $task_create_arr                                            = array();
        $patient_details                                            = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', '=', $camis_patient_id)->first();
        $task_estimated_date_for_completion = '';

        $current_task = CamisIboxBoardRoundPatientTasks::where('id', $task_id)->first();

        $check_task = CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->where('task_description', $current_task->task_description)->where('task_category', 6)->where(function ($query) {
            $query->where('task_not_applicable_status', 1);
            $query->orWhere('task_completed_status', 1);
        })->latest()->first();
        if ($check_task != null) {
            $dp_value = ($check_task->task_dp_status_order_value + 1);
        } else {
            $dp_value = 1;
        }


        if ($task_id != '' && $camis_patient_id != '') {

            $x = 0;
            $task_create_arr[$x]['task_id']                         = $task_id;
            $task_create_arr[$x]['task_completed_status']           = 1;
            $task_create_arr[$x]['task_completed_by']               = $user_id;

            $task_create_arr[$x]['task_completed_ward']             = $patient_details->camis_patient_ward_id ?? 0;
            $task_create_arr[$x]['task_completed_at']               = $date_time_now;
        }

        if (count($task_create_arr) > 0) {
            $this->WardSummaryPatientTaskInsert($task_create_arr, $camis_patient_id);
        }
        $task = CamisIboxBoardRoundPatientTasks::where('id', $request->task_id)
            ->where('task_category', 9)
            ->first();




        $task_count = $task ? 9 : 0;
        $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id, $task_count);
        $success_array["status"]                                    = 1;
        $success_array["message"]                                   = DataAddedMessage();
        if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
            $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
            $view                                             = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
        } else {

            $view                                             = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
        }
        $success_array['sections']                                  = $view->render();

        if (CamisIboxBoardRoundPatientTasks::whereIn('task_category', [6, 7, 8])->where('patient_id', $camis_patient_id)->where('task_not_applicable_status', 0)->where('task_completed_status', 0)->count() > 1) {
            $success_array['complete_dp_task']                                 = 0;
        } else {
            $success_array['complete_dp_task']                                 = 1;
            $dp_flag = CamisIboxBoardRoundPatientFlag::where('patient_id', $camis_patient_id)->where('patient_flag_name', 'ibox_patient_flag_covid_dp')->pluck('id')->toArray();
            CamisIboxBoardRoundPatientFlag::whereIn('id', $dp_flag)->delete();
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function AssignSepsisTask(Request $request)
    {
        $success_array                                              = array();
        $history_controller                                         = new HistoryController;
        $common_camis_controller                                    = new CommonCamisController;
        $date_time_now                                              = CurrentDateOnFormat();
        $task_id                                                    = $request->task_id ?? '';
        $camis_patient_id                                           = $request->camis_patient_id ?? '';
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $task_create_arr                                            = array();
        $patient_details                                            = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', '=', $camis_patient_id)->first();
        $task_estimated_date_for_completion = '';

        $task_extra_details = array();

        $board_round_patient_task = CamisIboxBoardRoundPatientTasks::where('id', $task_id)->first();
        $task_extra_details['could_this_be_sepsis?'] = 'Yes';


        if ($task_id != '' && $camis_patient_id != '') {
            $x = 0;
            $task_create_arr[$x]['task_id']                         = $task_id;
            $task_create_arr[$x]['task_completed_status']           = 1;
            $task_create_arr[$x]['task_extra_data']                 = json_encode($task_extra_details);
            $task_create_arr[$x]['task_completed_by']               = $user_id;
            $task_create_arr[$x]['task_completed_ward']             = $patient_details->camis_patient_ward_id ?? 0;
            $task_create_arr[$x]['task_completed_at']               = $date_time_now;
        }
        if (count($task_create_arr) > 0) {
            $this->WardSummaryPatientTaskInsert($task_create_arr, $camis_patient_id);
        }

        $sepsis_task_list = BoardRoundUserTaskSepsisTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();

        $sepsis_create_arr = array();
        $x                 = 1;

        foreach ($sepsis_task_list as $patient_task) {
            $sepsis_create_arr[$x]['task_group']                              = '';
            $sepsis_create_arr[$x]['task_id']                                 = '';
            $sepsis_create_arr[$x]['patient_id']                              = $camis_patient_id;
            $sepsis_create_arr[$x]['task_group']                              = $patient_task['user_task_group'];
            $sepsis_create_arr[$x]['task_comment']                            = '';
            $sepsis_create_arr[$x]['task_priority']                           = 0;
            $sepsis_create_arr[$x]['task_daily']                              = 0;
            $sepsis_create_arr[$x]['task_category']                           = 7;
            $sepsis_create_arr[$x]['task_dp_status_order_value']               = $board_round_patient_task->task_dp_status_order_value ?? 0;
            $sepsis_create_arr[$x]['task_description']                        = $patient_task['auto_populate_task_name'];
            $sepsis_create_arr[$x]['task_estimated_date_for_completion']      = CurrentDateOnFormat();
            $sepsis_create_arr[$x]['task_updated_by']                         = $user_id;
            $sepsis_create_arr[$x]['task_updated_ward']                       = $patient_details->camis_patient_ward_id ?? 0;
            $sepsis_create_arr[$x]['task_updated_at']                         = $date_time_now;
            $sepsis_create_arr[$x]['task_created_by']                         = $user_id;
            $sepsis_create_arr[$x]['task_created_ward']                       = $patient_details->camis_patient_ward_id ?? 0;
            $sepsis_create_arr[$x]['task_created_at']                         = $date_time_now;
            $x++;
        }

        $this->WardSummaryPatientTaskInsert($sepsis_create_arr, $camis_patient_id);
        $success_array["modal_close"]                                         = 0;


        $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
        $success_array["status"]                                    = 1;
        $success_array["message"]                                   = DataAddedMessage();
        if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
            $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
            $view                                             = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
        } else {
            if (strtolower($patient_details->camis_patient_ward) != 'critc') {
                $view                                             = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
            } else {
                $view                                             = View::make('Dashboards.Camis.WardSummary.UserTaskCCU', compact('success_array'));
            }
        }
        $success_array['sections']                                  = $view->render();
        $success_array['assigned_task']                         = json_encode($sepsis_task_list);
        $success_array["modal_close"]                           = 0;


        return ReturnArrayAsJsonToScript($success_array);
    }


    public function GetVitalPacAKIData(Request $request)
    {
        if ($request->filled('camis_patient_id')) {
            $vitalpac = VitalPacAKIData::where('notification_type', 'AKI')->where('pas_spell_no', $request->camis_patient_id)->first();
            if ($vitalpac && $vitalpac->alert_value && strtolower($vitalpac->alert_value) != strtolower('Not applicable')) {
                return $vitalpac->alert_value;
            } else {
                return 'No Status Documented';
            }
        } else {
            return 'No Status Documented';
        }
    }
    public function AssignAkiTask(Request $request)
    {
        $success_array                                              = array();
        $history_controller                                         = new HistoryController;
        $common_camis_controller                                    = new CommonCamisController;
        $date_time_now                                              = CurrentDateOnFormat();

        $task_id                                                    = $request->task_id ?? '';
        $camis_patient_id                                           = $request->camis_patient_id ?? '';
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $task_create_arr                                            = array();
        $patient_details                                            = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', '=', $camis_patient_id)->first();
        $task_details                                               = CamisIboxBoardRoundPatientTasks::where('id', $task_id)->first()->task_dp_status_order_value;
        $time                                                       = CamisIboxBoardRoundPatientTasks::where('task_dp_status_order_value', $task_details)->orderBy('created_at', 'desc')->first()->created_at;
        $task_estimated_date_for_completion                         = '';

        if ($task_id != '' && $camis_patient_id != '') {
            $x = 0;
            $task_create_arr[$x]['task_id']                         = $task_id;
            $task_create_arr[$x]['task_completed_status']           = 1;
            $task_create_arr[$x]['task_completed_by']               = $user_id;
            $task_create_arr[$x]['task_completed_ward']             = $patient_details->camis_patient_ward_id ?? 0;
            $task_create_arr[$x]['task_completed_at']               = $date_time_now;
        }

        if (count($task_create_arr) > 0) {
            $this->WardSummaryPatientTaskInsert($task_create_arr, $camis_patient_id);
        }

        $aki_task_list = BoardRoundUserTaskAkiAssessmentTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->when(in_array($request->aki_value, ['nill', 'nil']), function ($query) {
            return $query->where('user_task_group', 46);
        })->get()->toArray();
        $aki_create_arr = array();
        $x              = 1;

        foreach ($aki_task_list as $patient_task) {
            $aki_create_arr[$x]['task_group']                              = '';
            $aki_create_arr[$x]['task_id']                                 = '';
            $aki_create_arr[$x]['patient_id']                              = $camis_patient_id;
            $aki_create_arr[$x]['task_group']                              = $patient_task['user_task_group'];
            $aki_create_arr[$x]['task_comment']                            = '';
            $aki_create_arr[$x]['task_priority']                           = 0;
            $aki_create_arr[$x]['task_daily']                              = 0;
            $aki_create_arr[$x]['task_category']                           = 8;
            $aki_create_arr[$x]['task_dp_status_order_value']               = $task_details ?? 0;
            $aki_create_arr[$x]['task_description']                        = $patient_task['auto_populate_task_name'];
            $aki_create_arr[$x]['task_estimated_date_for_completion']      = CurrentDateOnFormat();
            $aki_create_arr[$x]['task_updated_by']                         = $user_id;
            $aki_create_arr[$x]['task_updated_ward']                       = $patient_details->camis_patient_ward_id ?? 0;
            $aki_create_arr[$x]['task_updated_at']                         = $time;
            $aki_create_arr[$x]['task_created_by']                         = $user_id;
            $aki_create_arr[$x]['task_created_ward']                       = $patient_details->camis_patient_ward_id ?? 0;
            $aki_create_arr[$x]['task_created_at']                         = $time;
            $x++;
        }

        $this->WardSummaryPatientTaskInsert($aki_create_arr, $camis_patient_id);
        $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
        $success_array["status"]                                    = 1;
        $success_array["message"]                                   = DataAddedMessage();
        if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
            $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
            $view                                             = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
        } else {

            $view                                             = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
        }
        $success_array['sections']                                  = $view->render();
        $success_array['assigned_task']                             = json_encode($aki_task_list);

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function NotApplicablePatientTaskBoardRound(Request $request)
    {
        $success_array                                              = array();
        $history_controller                                         = new HistoryController;
        $common_camis_controller                                    = new CommonCamisController;
        $date_time_now                                              = CurrentDateOnFormat();

        $task_id                                                    = $request->task_id ?? '';
        $camis_patient_id                                           = $request->camis_patient_id ?? '';
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $task_create_arr                                            = array();
        $patient_details                                            = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', '=', $camis_patient_id)->first();
        $task_estimated_date_for_completion                         = '';

        if (CamisIboxBoardRoundPatientTasks::where('id', $request->task_id)->where('task_description', '!=', 'Review Diabetic Status')->whereNotIn('task_category', [0, 1, 2, 10, 4, 2, 11])->exists()) {
            $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
            $success_array["status"]                                    = 2;
            $success_array["message"]                                   = ActionRestrcited();
            if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
                $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
                $view                                             = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
            } else {

                $view                                             = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
            }
            $success_array['sections']                                  = $view->render();

            return ReturnArrayAsJsonToScript($success_array);
        }

        if ($task_id != '' && $camis_patient_id != '') {
            $x                                                      = 0;
            $task_create_arr[$x]['task_id']                         = $task_id;
            $task_create_arr[$x]['task_not_applicable_status']      = 1;
            $task_create_arr[$x]['task_not_applicable_by']          = $user_id;
            $task_create_arr[$x]['task_not_applicable_ward']        = $patient_details->camis_patient_ward_id ?? 0;
            $task_create_arr[$x]['task_not_applicable_at']          = $date_time_now;
        }

        if (count($task_create_arr) > 0) {
            $this->WardSummaryPatientTaskInsert($task_create_arr, $camis_patient_id);
        }
        $task = CamisIboxBoardRoundPatientTasks::where('id', $request->task_id)
            ->where('task_category', 9)
            ->first();
        $task_count = $task ? 9 : 0;
        $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id, $task_count);
        $success_array["status"]                                    = 1;
        $success_array["message"]                                   = DataAddedMessage();
        if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
            $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
            $view                                             = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
        } else {

            $view                                             = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
        }
        $success_array['sections']                                  = $view->render();

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function CheckBoardRoundPatientTask(Request $request)
    {
        $success_array                                                              = array();
        $task_id                                                                    = $request->task_id;
        $success_array["status"]                                                    = 1;

        if ($task_id != '') {

            $result_data                                                            = CamisIboxBoardRoundPatientTasks::where('id', $task_id)->first();

            if (isset($result_data->id) && $result_data->id != '') {
                if (in_array($result_data->task_category, [6])) {
                    if (CamisIboxBoardRoundPatientTasks::whereIn('task_category', [6, 7, 8])->where('patient_id', $result_data->patient_id)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->count() > 1) {
                        $success_array['dp_exists']                                 = 1;
                    } else {
                        $success_array['dp_exists']                                 = 0;
                    }

                    $success_array['id']                                            = $result_data->id;
                    $success_array["type"]                                          = $result_data->task_category;
                    $success_array["name"]                                          = $result_data->task_description;
                    $success_array["status"]                                        = 2;
                } else {
                    $success_array['id']                                            = $result_data->id;
                    $success_array["type"]                                          = $result_data->task_category;
                    $success_array["name"]                                          = $result_data->task_description;
                    $success_array["status"]                                        = 1;
                }
            }
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetBoardRoundPatientTask(Request $request)
    {
        $success_array                                                              = array();
        $task_id                                                                    = $request->task_id;
        $success_array['id']                                                        = '';
        $success_array['task_description']                                          = '';

        if ($task_id != '') {
            $success_array["status"]                                                = 1;
            $result_data                                                            = CamisIboxBoardRoundPatientTasks::where('id', $task_id)->first();
            if (isset($result_data->id) && $result_data->id != '') {
                if (!in_array($result_data->task_category, [1, 0, 2, 10, 4, 2, 11])) {
                    $success_array['id']                                            = $result_data->id;
                    $success_array["status"]                                        = 2;
                    $success_array["message"]                                       = ActionRestrcited();

                    return ReturnArrayAsJsonToScript($success_array);
                }

                $success_array['id']                                                = $result_data->id;
                $success_array['task_group_id']                                     = $result_data->task_group;
                $success_array['task_group_name']                                   = '';
                $success_array['task_priority']                                     = $result_data->task_priority;
                $success_array['task_category']                                     = $result_data->task_category;
                $success_array['task_daily']                                        = $result_data->task_daily;
                $success_array['task_description']                                  = $result_data->task_description;
                $success_array['task_estimated_date_for_completion']                = $result_data->task_estimated_date_for_completion;
                $success_array['task_estimated_time_for_completion']                = '';
                $success_array['task_comment']                                      = $result_data->task_comment;
                $success_array['patient_id']                                        = $result_data->patient_id;

                if ($success_array['task_estimated_date_for_completion'] != '') {
                    $success_array['task_estimated_time_for_completion']            = date('H:i', strtotime($success_array['task_estimated_date_for_completion']));
                    $success_array['task_estimated_date_for_completion']            = date('Y-m-d', strtotime($success_array['task_estimated_date_for_completion']));
                }

                $task_group_fetch                                                   = TaskGroup::where('id', '=', $success_array['task_group_id'])->first();

                if (isset($task_group_fetch->id) && $task_group_fetch->id != '') {
                    $success_array['task_group_name']                               = $task_group_fetch->task_group_name;
                }
            }
        }

        return ReturnArrayAsJsonToScript($success_array);
    }



    public function GetPatientFlagDetails(Request $request)
    {
        $success_array                                                              = array();
        $camis_patient_id                                                           = $request->camis_patient_id;
        $boardround_flag_name                                                       = $request->boardround_flag_name;
        $success_array['patient_flag_status_value']                                 = 0;
        $success_array['patient_flag_name']                                         = $boardround_flag_name;

        if ($camis_patient_id != '' && $boardround_flag_name != '') {
            $result_data                                                            = CamisIboxBoardRoundPatientFlag::where('patient_id', $camis_patient_id)->where('patient_flag_name', $boardround_flag_name)->first();
            if (isset($result_data->id) && $result_data->id != '') {
                $success_array['patient_flag_status_value']                         = $result_data->patient_flag_status_value;
                $result_additional_data                                             = CamisIboxBoardRoundPatientFlagAdditionalInfo::where('patient_flag_id', $result_data->id)->get();
                if (count($result_additional_data) > 0) {
                    foreach ($result_additional_data as $key => $row) {
                        $success_array[$row->patient_flag_extra_data_field_name]    = $row->patient_flag_extra_data_field_value;
                    }
                }
            }
        }
        if (CamisIboxBoardRoundPatientTasks::whereIn('task_category', [6, 7, 8])->where('patient_id', $camis_patient_id)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->count() > 1) {
            $success_array['dp_exists']                                 = 1;
        } else {
            $success_array['dp_exists']                                 = 0;
        }

        if ($boardround_flag_name == 'ibox_patient_flag_infection_risk') {
            $success_array['infection_control'] = InfectionControl::where('status', 1)->orderBy('infection_list_show_data_name', 'asc')->get();
            $query                                                              = CamisIboxBoardRoundInfectionRisk::where('patient_id', $camis_patient_id)->get()->toArray();
            $in_data = [];
            if (count($query) > 0) {
                foreach ($query as $infection_name) {
                    $in_data[] = ['infection_type' => $infection_name['infection_type'], 'infection_id' => $infection_name['infection_id'], 'infection_text' => $infection_name['infection_name'], 'is_primary' => ($infection_name['is_primary'] == 1) ? 'true' : 'false', 'next_review_date' => $infection_name['next_review_date']];
                }
            }
            $result_data = $in_data;
            $view                                                               = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.FlagsAction.Partials.InfectionDetails', compact('result_data', 'success_array'));
            $success_array['sections']                                          = $view->render();
        }
        $success_array['ipc_comment'] = CamisIboxBoardRoundIpcComment::where('patient_id', $request->camis_patient_id)
            ->first()->comment ?? '';

        $success_array['old_infection_history'] = CamisIboxPatientAlertDetails::where('camis_patient_id', $request->camis_patient_id)
            ->whereNotNull('alert_description')
            ->where('alert_description', '!=', '')
            ->get(['alert_description', 'alert_code'])
            ->map(function ($item) {
                if (!empty($item->alert_code)) {
                    return "{$item->alert_description} ({$item->alert_code})";
                }
                return $item->alert_description;
            })
            ->implode(', ');

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function FetchPatientReasonToReside(Request $request){
        $success_array                                                              = array();
        $camis_patient_id                                                           = $request->camis_patient_id;

        $success_array['status']                = 0;
        $success_array['message']              = 'Something Went Wrong';
        if ($camis_patient_id != '') {
            $success_array['status']                = 1;
            $success_array['message']              = 'Date Fetched';
            $reason_to_reside                                          = ReasonToResideGroup::where('status', 1)->get();

            $patient_current_ward = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', $camis_patient_id)->first()->camis_patient_ward ?? '';
            $patient_current_reason_to_reside = CamisIboxBoardRoundReasonToReside::where('patient_id', $camis_patient_id)
                ->whereNull('reason_to_reside_end_date')
                ->value('patient_reason_to_reside_status') ?? 0;
            $view                                             = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.ReasonToResideData', compact('reason_to_reside', 'patient_current_reason_to_reside', 'patient_current_ward'));

            $success_array['html']                                  = $view->render();
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function UpdatePatientFlagDetails(Request $request)
    {
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

        $patient_flag_dialysis_selected_data                            = $request->patient_flag_dialysis_selected_data ?? '';

        if ($patient_flag_dialysis_selected_data != '') {
            $patient_flag_extra_details_array['patient_flag_dialysis_selected_data'] = $patient_flag_dialysis_selected_data;
        }

        if ($request->has('patient_flag_one_one_care_risk_assessment') && $request->has('patient_flag_one_one_care_agreed_one_one_care')) {
            $patient_flag_extra_details_array['risk_assessment']        = $request->patient_flag_one_one_care_risk_assessment;
            $patient_flag_extra_details_array['agreed_the_one_on_one']  = $request->patient_flag_one_one_care_agreed_one_one_care;
        }

        if ($request->has('patient_flag_cld_date_set') || $request->has('patient_flag_cld_comment')) {
            $patient_flag_extra_details_array['patient_flag_cld_date_set']       = $request->patient_flag_cld_date_set;
            if ($request->filled('patient_flag_cld_comment')) {
                $patient_flag_extra_details_array['patient_flag_cld_comment']    = $request->patient_flag_cld_comment;
            } else {
                $patient_flag_extra_details_array['patient_flag_cld_comment']    = '.';
            }
        }

        if ($request->has('patient_flag_off_the_ward_selected_data')) {
            $patient_flag_extra_details_array['patient_flag_off_the_ward_selected_data']  = $request->patient_flag_off_the_ward_selected_data;
        }

        if ($request->has('flag_ambo_ref')) {
            $patient_flag_extra_details_array['flag_ambo_ref']  = $request->flag_ambo_ref;
        }

        if ($request->has('flag_ambo_time')) {
            $patient_flag_extra_details_array['flag_ambo_time']  = $request->flag_ambo_time;
        }

        if ($request->has('flag_outlier_value')) {
            $patient_flag_extra_details_array['flag_outlier_value']  = $request->flag_outlier_value;
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
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $flag_set_name, $gov_text_after_arr, $functional_identity, 1);
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
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $flag_set_name, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
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
                $primary_infection = array_values(array_filter($infection_list, function ($item) {
                    return in_array($item['action_type'], ['update']) && $item['is_primary'] == 1
                        && !empty($item['infection_id']);
                }));
                if (count($primary_infection) > 0 && isset($primary_infection['0'])) {
                    if ($primary_infection['0']['infection_type'] == 'CANSTAYINBAY') {
                        $ic_text = 'CAN STAY IN BED';
                    } else {
                        $ic_text = $primary_infection['0']['infection_type'];
                    }
                    $success_array['patient_flag_infection_risk_selected_data'] = ucwords(strtolower($ic_text));
                    $success_array['patient_flag_infection_risk_reason_text'] = $primary_infection['0']['infection_text'];
                }

                $infection_controller = new InfectionController;
               $infection_controller->UpdateInfectionListForPatient($request->camis_patient_id, $total_infection);
            }
            $success_array["updated_date"]                          = date('jS M Y, H:i', strtotime($date_time_now));
            $success_array["updated_date_show"]                     = date('jS M H:i', strtotime($date_time_now));
            $success_array["patient_flag_stored_name"]              = $patient_flag_name;

            $success_array["status"]                                = 1;

        }

        $common_camis_controller                                    = new CommonCamisController;
        $success_array['sections']                                  = '';


        $exists_nof_task = CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->where('task_category', 1)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)
            ->pluck('task_description')->toArray();
        if ($patient_flag_name == 'ibox_patient_flag_nof') {
            $nof_flags_list     = BoardRoundUserTaskNofTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->get()->toArray();
            $task_create_arr    = array();
            $x                  = 1;

            foreach ($nof_flags_list as $patient_task) {
                if (array_search($patient_task['auto_populate_task_name'], $exists_nof_task) === false) {
                    $task_create_arr[$x]['task_group']                              = '';
                    $task_create_arr[$x]['task_id']                                 = '';
                    $task_create_arr[$x]['patient_id']                              = $camis_patient_id;
                    $task_create_arr[$x]['task_group']                              = $patient_task['user_task_group'];
                    $task_create_arr[$x]['task_comment']                            = '';
                    $task_create_arr[$x]['task_priority']                           = 0;
                    $task_create_arr[$x]['task_daily']                              = 0;
                    $task_create_arr[$x]['task_category']                           = 1;
                    $task_create_arr[$x]['task_description']                        = $patient_task['auto_populate_task_name'];
                    $task_create_arr[$x]['task_estimated_date_for_completion']      = CurrentDateOnFormat();
                    $task_create_arr[$x]['task_updated_by']                         = $user_id;
                    $task_create_arr[$x]['task_updated_ward']                       = $patient_details->camis_patient_ward_id ?? 0;
                    $task_create_arr[$x]['task_updated_at']                         = $date_time_now;
                    $task_create_arr[$x]['task_created_by']                         = $user_id;
                    $task_create_arr[$x]['task_created_ward']                       = $patient_details->camis_patient_ward_id ?? 0;
                    $task_create_arr[$x]['task_created_at']                         = $date_time_now;
                    $x++;
                }
            }

            $this->WardSummaryPatientTaskInsert($task_create_arr, $camis_patient_id);
            $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
            if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
                $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
                $view                                                                      = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
            } else {
                $view                                                               = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
            }
            $success_array['sections']                                          = $view->render();
            $success_array['message']                                           = 'Records Added Succesfully';
        }

        if ($patient_flag_name == 'ibox_patient_flag_nurse_concern') {

            $check_old_dp_flag = CamisIboxBoardRoundPatientFlag::where('patient_id', $camis_patient_id)->where('patient_flag_name', 'ibox_patient_flag_covid_dp')->first();
            if ($check_old_dp_flag != null) {
                $updated_data                                           = CamisIboxBoardRoundPatientFlag::updateOrCreate(['patient_id' => $camis_patient_id, 'patient_flag_name' => 'ibox_patient_flag_covid_dp'], ['patient_flag_status_value' => 1, 'patient_flag_extra_details' => json_encode(array()), 'updated_by' => $user_id]);
            } else {
                $updated_data                                           = CamisIboxBoardRoundPatientFlag::updateOrCreate(['patient_id' => $camis_patient_id, 'patient_flag_name' => 'ibox_patient_flag_covid_dp'], ['patient_flag_status_value' => 1, 'patient_flag_extra_details' => json_encode(array()), 'flag_created_by' => $user_id, 'flag_created_ward' => $patient_details->camis_patient_ward_id ?? 0, 'flag_updated_ward' => $patient_details->camis_patient_ward_id ?? 0, 'updated_by' => $user_id]);
            }
            $get_id_updated_array                                   = $updated_data->getOriginal();
            $dp_task_list                                           = DpTasks::with('TaskUserGroup')->select('auto_populate_task_name', 'user_task_group')->where('status', 1)->orderBy('id', 'asc')->get()->toArray();
            $task_create_arr                                        = array();
            $x                                                      = 1;
            $z                                                      = 1;
            $task_remove_arr                                        = array();

            $task_to_remove = CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->whereIn('task_category', [6, 7, 8])->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->get()->toArray();
            $last_dp_flag = CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->where('task_category', 6)->orderBy('task_dp_status_order_value', 'desc')->first();
            if ($last_dp_flag) {
                $dp_value = $last_dp_flag->task_dp_status_order_value + 1;
            } else {
                $dp_value = 1;
            }
            if (count($task_to_remove) > 0) {
                foreach ($task_to_remove as $remove_task) {
                    $task_remove_arr[$z]['task_id']                                 = $remove_task['id'];
                    $task_remove_arr[$z]['task_not_applicable_status']              = 1;
                    $task_remove_arr[$z]['task_not_applicable_by']                  = $user_id;
                    $task_remove_arr[$z]['task_not_applicable_ward']                = $patient_details->camis_patient_ward_id ?? 0;
                    $task_remove_arr[$z]['task_not_applicable_at']                  = CurrentDateOnFormat();
                    $z++;
                }
            }



            $used_task_descriptions = [];
            foreach ($dp_task_list as $patient_task) {
                if (in_array($patient_task['auto_populate_task_name'], $used_task_descriptions)) {
                    continue;
                }

                $used_task_descriptions[] = $patient_task['auto_populate_task_name'];

                $task_create_arr[$x]['task_id']                                 = '';
                $task_create_arr[$x]['patient_id']                              = $camis_patient_id;
                $task_create_arr[$x]['task_group']                              = $patient_task['user_task_group'];
                $task_create_arr[$x]['task_comment']                            = '';
                $task_create_arr[$x]['task_priority']                           = 0;
                $task_create_arr[$x]['task_daily']                              = 0;
                $task_create_arr[$x]['task_category']                           = 6;
                $task_create_arr[$x]['task_dp_status_order_value']              = $dp_value;
                $task_create_arr[$x]['task_description']                        = $patient_task['auto_populate_task_name'];
                $task_create_arr[$x]['task_estimated_date_for_completion']      = CurrentDateOnFormat();
                $task_create_arr[$x]['task_updated_by']                         = $user_id;
                $task_create_arr[$x]['task_updated_ward']                       = $patient_details->camis_patient_ward_id ?? 0;
                $task_create_arr[$x]['task_updated_at']                         = $date_time_now;
                $task_create_arr[$x]['task_created_by']                         = $user_id;
                $task_create_arr[$x]['task_created_ward']                       = $patient_details->camis_patient_ward_id ?? 0;
                $task_create_arr[$x]['task_created_at']                         = $date_time_now;
                $task_create_arr[$x]['created_at']                              = $date_time_now;
                $task_create_arr[$x]['updated_at']                              = $date_time_now;
                $x++;
            }

            if (count($task_to_remove) > 0) {
                $this->WardSummaryPatientTaskInsert($task_remove_arr, $camis_patient_id);
            }
            $this->WardSummaryPatientTaskInsert($task_create_arr, $camis_patient_id);

            $sd_flags   = CamisIboxBoardRoundPatientFlag::where('patient_id', $camis_patient_id)->where('patient_flag_name', 'ibox_patient_flag_stepdown')->first();
            if ($sd_flags != null) {
                $sd_flags->delete();
            }
            $check_patient_dp_status = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->whereNotIn('type', [1, 2, 3])->first();
            $check_exist_status = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->first();
            if ($check_patient_dp_status != null || $check_exist_status == null) {
                $history_controller                                         = new HistoryController;
                $history_modal                                              = "App\Models\History\HistoryCamisDPVirtualPatientData";
                $date_time_now                                              = CurrentDateOnFormat();
                $camis_patient_id                                           = $request->camis_patient_id;
                $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
                $success_array["message"]                                   = ErrorOccuredMessage();
                $success_array["status"]                                    = 0;

                if ($camis_patient_id != "" && $user_id != "") {
                    $gov_text_before_arr                                    = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->first();
                    $updated_data                                           = CamisIboxDPVirtualWardPatientStatus::updateOrCreate(['patient_id' => $camis_patient_id], ['type' => 1, 'updated_by' => $user_id, 'entry_type' => 1, 'dp_virtual_ward_entry_time' => $date_time_now]);
                    $functional_identity                                    = 'DP Virtual Ward Data';

                    if ($updated_data->wasRecentlyCreated) {
                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                        $success_array["message"]                           = DataAddedMessage();
                        $updated_array                                      = $updated_data->getOriginal();
                        $gov_text_before                                    = array();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            $dp_additional_comment                                              = new CamisIboxDPVirtualWardComment();
                            $dp_additional_comment->patient_id                                  = $camis_patient_id;
                            $dp_additional_comment->additional_comment                          = '#Nurse Concern';
                            $dp_additional_comment->updated_by                                  = $user_id;
                            $dp_additional_comment->save();
                            $gov_text_after_arr                             = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Enter As New Patients', $gov_text_after_arr, $functional_identity, 1);
                        }
                    } else {

                        $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                        $success_array["message"]                           = DataUpdatedMessage();
                        if (count($updated_data->getChanges()) > 0) {
                            $updated_array                                  = $updated_data->getOriginal();
                            if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                if ($gov_text_before_arr) {
                                    $gov_text_before                        = $gov_text_before_arr->toArray();
                                    $gov_text_after_arr                     = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Enter As New Patients', $gov_text_after_arr, $functional_identity, 2);
                                }
                            }
                        }
                    }
                }
            }


            $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
            if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
                $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
                $view                                             = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
            } else {

                $view                                             = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
            }
            $success_array['sections']                                          = $view->render();
            $success_array['message']                                           = 'Records Added Succesfully';
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function RemovePatientFlagDetails(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientFlag";
        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_flag_name                                          = $request->patient_flag_name;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["flag_name"]                                 = $request->patient_flag_name;
        $patient_details                                            = CamisIboxWardInPatientInformationDetailsView::where('camis_patient_id', '=', $camis_patient_id)->first();

        $success_array["covid_flag"]                                 = 0;
        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundPatientFlag::where('patient_id', '=', $camis_patient_id)->where('patient_flag_name', $patient_flag_name)->first();




            if (isset($gov_text_before_arr->id) && $gov_text_before_arr->id != '') {
                $master_flag_data                                   = BoardRoundFlagList::where('patient_flag_stored_name', '=', $patient_flag_name)->first();

                if (isset($master_flag_data->id) && $master_flag_data->id != '') {
                    $flag_set_name                                  = $master_flag_data->patient_flag_name;
                }


                if ($gov_text_before_arr->patient_flag_name == 'ibox_patient_flag_one_one_care') {
                    $additional_data = json_decode($gov_text_before_arr->patient_flag_extra_details, true);
                    $additional_data['removal_reason'] = $request->one_on_once_comment ?? '';
                    $gov_text_before_arr->patient_flag_extra_details = json_encode($additional_data);
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
                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before,  $flag_set_name, $gov_text_after_arr, $functional_identity, 3);
                $success_array["status"]                            = 1;
                $success_array['sections']                          = '';
                $common_camis_controller                            = new CommonCamisController;

                if ($patient_flag_name == 'ibox_patient_flag_nurse_concern') {
                    // if (CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->where('task_category', 6)->where('task_completed_status', 0)->exists())
                    // {
                    //     CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->where('task_category', 6)->where('task_completed_status', 0)
                    //         ->get()
                    //         ->each(function ($row)
                    //         {
                    //             $row->task_dp_status_order_value += 1;
                    //             $row->save();
                    //         });
                    // }
                    $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);


                    if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
                        $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
                        $view                                             = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
                    } else {

                        $view                                             = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
                    }



                    $success_array['sections']                                      = $view->render();
                    $success_array['message']                                       = 'Records Added Succesfully';
                    $history_controller                                             = new HistoryController;
                    $history_modal                                                  = "App\Models\History\HistoryCamisDPVirtualPatientData";
                    $date_time_now                                                  = CurrentDateOnFormat();
                    $camis_patient_id                                               = $request->camis_patient_id;
                    $user_id                                                        = Session()->get('LOGGED_USER_ID', '');
                    $success_array["message"]                                       = ErrorOccuredMessage();
                    $success_array["status"]                                        = 0;

                    if ($camis_patient_id != "" && $user_id != "") {
                        $gov_text_before_arr                                        = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->where('type', 1)->first();
                        if ($gov_text_before_arr != null) {

                            $updated_data                                           = CamisIboxDPVirtualWardPatientStatus::updateOrCreate(['patient_id' => $camis_patient_id], ['type' => 4, 'updated_by' => $user_id, 'dp_virtual_ward_entry_time' => $date_time_now]);
                            $functional_identity                                    = 'DP Virtual Ward Entry';
                            if ($updated_data->wasRecentlyCreated) {
                                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                                $success_array["message"]                           = DataAddedMessage();
                                $updated_array                                      = $updated_data->getOriginal();
                                $gov_text_before                                    = array();
                                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                    $gov_text_after_arr                             = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Discharged To Ward', $gov_text_after_arr, $functional_identity, 1);
                                }
                            } else {
                                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                                $success_array["message"]                           = DataUpdatedMessage();
                                if (count($updated_data->getChanges()) > 0) {
                                    $updated_array                                  = $updated_data->getOriginal();
                                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                                        if ($gov_text_before_arr) {
                                            $gov_text_before                        = $gov_text_before_arr->toArray();
                                            $gov_text_after_arr                     = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Discharged To Ward', $gov_text_after_arr, $functional_identity, 2);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $this->ActionDischargeToWard($camis_patient_id);
                }

                if ($patient_flag_name == 'ibox_patient_flag_nof' && $request->nof_task_keep != 1) {
                    if (CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->where('task_category', 1)->exists()) {
                        CamisIboxBoardRoundPatientTasks::where('patient_id', $camis_patient_id)->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->where('task_category', 1)->delete();
                    }

                    $common_camis_controller->WardSummaryPatientBoardRoundTaskListOfPatient($success_array, $camis_patient_id);
                    if ($request->has('dp_dashboard') && $request->dp_dashboard == 1) {
                        $success_array['dp_sections']                                              = GetCamisOutstandingTask($success_array['pedning_dp_task'], 6, 6, 'dp_dashboard_task_management_view')->render();
                        $view                                             = View::make('Dashboards.Camis.DeterioratingPatient.Partials.DPTaskModalData', compact('success_array'));
                    } else {

                        $view                                             = View::make('Dashboards.Camis.WardSummary.UserTask', compact('success_array'));
                    }
                    $success_array['sections']                        = $view->render();
                    $success_array['message']                         = 'Records Added Succesfully';
                }
            }


            if ($request->patient_flag_name == 'ibox_patient_flag_infection_risk') {
                $reverse_barrier_history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundReverseBarrier";
                $reverse_barrier_gov_text_before_arr                                        = CamisIboxBoardRoundReverseBarrier::where('patient_id', '=', $camis_patient_id)->first();
                if ($reverse_barrier_gov_text_before_arr != null) {
                    $history_controller->HistoryTableDataInsertFromDelete($reverse_barrier_gov_text_before_arr->toArray(), $reverse_barrier_history_modal, 3);
                    CamisIboxBoardRoundReverseBarrier::where('patient_id', '=', $camis_patient_id)->delete();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $reverse_barrier_gov_text_before_arr->toArray(), '', array(), 'Patient Reverse Barrier', 3);
                }
                $infection_controller = new InfectionController;
                $infection_controller->SaveIPCCommentHistory($camis_patient_id, $comment = '');
                $infection_controller->RemoveAllInfectionForPatient($camis_patient_id);
            }
        }

        return ReturnArrayAsJsonToScript($success_array);
    }


    public function CDTUpdate(&$process_array, &$success_array)
    {
        //        dd($process_array['cdt_status']);
        $camis_patient_id   =  $process_array['camis_patient_id'];
        $cdt_status   =  $process_array['cdt_status'];

        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundCDT";
        $date_time_now                                              = CurrentDateOnFormat();
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $username                                                   = Sentinel::findById($user_id)->username ?? '';

        $success_array["date_time"]                                 = CurrentDateOnFormat();
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        if ($camis_patient_id != "" && $user_id != "") {


            if ($cdt_status == 0) {
                $gov_text_before_arr                                    = CamisIboxBoardRoundCDT::where('patient_id', '=', $camis_patient_id)->first();

                $updated_data                                           = CamisIboxBoardRoundCDT::updateOrCreate(['patient_id' => $camis_patient_id], ['cdt_status' => $cdt_status, 'request_by' => $user_id, 'request_by_username' => $username, 'request_date' => $success_array["date_time"]]);

                $functional_identity                                    = 'Patient CDT Requested';

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundCDT::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Patient CDT Requested', $gov_text_after_arr, 'CDT Status', 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundCDT::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Patient CDT Requested', $gov_text_after_arr, 'CDT Status', 2);
                            }
                        }
                    }
                }
            } elseif ($cdt_status == 3) {
                $gov_text_before_arr                                    = CamisIboxBoardRoundCDT::where('patient_id', '=', $camis_patient_id)->first();

                $updated_data                                           = CamisIboxBoardRoundCDT::updateOrCreate(['patient_id' => $camis_patient_id], ['cdt_status' => $cdt_status, 'request_by' => $user_id, 'request_by_username' => $username, 'request_date' => $success_array["date_time"]]);

                $functional_identity                                    = 'Patient CDT Rejected';

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundCDT::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Patient CDT Rejected', $gov_text_after_arr, 'CDT Status', 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundCDT::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Patient CDT Rejected', $gov_text_after_arr, 'CDT Status', 2);
                            }
                        }
                    }
                }
            }


            //             else {
            //                $gov_text_before_arr                                    = CamisIboxBoardRoundCDT::where('patient_id', '=', $camis_patient_id)->first();
            //                if($gov_text_before_arr != null){
            //                    $updated_data                                           = $gov_text_before_arr;
            //                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
            //                    CamisIboxBoardRoundCDT::where('patient_id', '=', $camis_patient_id)->delete();
            //                    $functional_identity                                    = 'Patient CDT Status Removed';
            //                    $gov_text_before                                        = $gov_text_before_arr->toArray();
            //                    $gov_text_after_arr                                     = array();
            //                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
            //                    $success_array["message"]                               = DataRemovalMessage();
            //                }
            //
            //            }


            $success_array["updated_date"]                          = PredefinedDateFormatShowOnCalendarWithoutDay($date_time_now);
            $success_array["cdt_updated_time"]                          = $username . ' - ' . PredefinedDateFormatFor24Hour($date_time_now);;
            $success_array["updated_date_show"]                     = date('jS M H:i', strtotime($date_time_now));
            $success_array["status"]                                = 1;
            $success_array["cdt_status"]                            = $cdt_status;

            $success_array["camis_patient_id"]                     = $process_array['camis_patient_id'];
        }
    }




    public function UpdateCDTStatus(Request $request)
    {

        $success_array = array();
        $process_array = array();
        $process_array['camis_patient_id']                                           = $request->camis_patient_id;
        $process_array['cdt_status']                                                 = $request->cdt_status;


        $this->CDTUpdate($process_array, $success_array);
        //     dd($success_array);
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function SaveHandOverDetails(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxPatientHandOver";
        $date_time_now                                              = CurrentDateOnFormat();
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));

        if ($request->camis_patient_id != "" && $user_id != "") {
            $data = [
                "patient_id"                          => $request->camis_patient_id,
                "ibox_handover_repositioning_routine" => $request->repositioning_routine ?? '',
                "ibox_handover_skin_conditioning"     => $request->skin_conditioning ?? '',
                "ibox_handover_dressings"             => $request->dressings ?? '',
                "ibox_handover_mobility"              => $request->mobility ?? '',
                "ibox_handover_equipment"             => $request->equipment ?? '',
                "ibox_handover_assistance_needed"     => $request->assistance_needed ?? '',
                "ibox_handover_varience_store"        => $request->varience_store ?? '',
                "ibox_handover_special_diet_comment"  => $request->special_diet_comment ?? '',
                "ibox_handover_obs_varience"          => $request->obs ?? '',
                "ibox_handover_pain_analgesia"        => $request->pain_analgesia ?? '0',
                "ibox_handover_i_continence"          => $request->i_continence ?? '',
                "ibox_handover_s_surface"             => $request->s_surface ?? '',
                "ibox_handover_n_nutrition"           => $request->n_nutrition ?? '',
                "ibox_handover_comment"               => $request->hand_over_comment ?? '',
                'updated_by'                          => $user_id
            ];

            $gov_text_before_arr                                    = CamisIboxPatientHandOver::where('patient_id', '=', $request->camis_patient_id)->first();
            $updated_data                                           = CamisIboxPatientHandOver::updateOrCreate(['patient_id' => $request->camis_patient_id], $data);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
            $functional_identity                                    = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_hand_over", "ibox_governance_frontend_functional_names");

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxPatientHandOver::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($request->camis_patient_id, $gov_text_before, $request->camis_patient_id, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                if ($gov_text_before_arr->camis_patient_id != '' && $request->camis_patient_id == '') {

                    $history_controller->HistoryTableDataInsertFromUpdate($updated_data, $history_modal, 2);
                    $success_array["message"]                        = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                               = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                     = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                  = CamisIboxPatientHandOver::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($request->camis_patient_id, $gov_text_before, $request->camis_patient_id, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
            }

            $success_array["patient_hand_over"]                      = CamisIboxPatientHandOver::where('patient_id', '=', $request->camis_patient_id)->first();
            $success_array["status"]                                 = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetHandOverDetails(Request $request)
    {
        $patient_query              = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_status_value', 1);
            },
            'PatientWiseFlags.PatientFlagList',
            'BoardRoundAdmittingReason' => function ($q) {
                $q->select('id', 'patient_id', 'patient_admitting_reason');
            },
            'BoardRoundSocialHistory' => function ($q) {
                $q->select('id', 'patient_id', 'patient_social_history');
            },
            'BoardRoundPharmacyData' => function ($q) {
                $q->select('id', 'patient_id', 'pharmacy_drug_history', 'pharmacy_antibiotic_iv_status', 'pharmacy_antibiotic_oral_status', 'pharmacy_latest_comment', 'updated_at');
            },
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment');
            },
            'BoardRoundTherapyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_therapy_fit_status');
            },
            'BoardRoundEstimatedDischargeDate' => function ($q) {
                $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
            },
            'PatientHandOver',
            'BoardRoundPatientTasks' => function ($q) {
                $q->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('created_at', 'desc');
            },
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory'
        ])
            ->where('ibox_bed_type', 'Bed')
            ->where('camis_patient_id', '=', $request->patient_id);


        $patient_array                                           = $patient_query->first();

        $patient_array['camis_patient_date_of_birth']            = PredefinedDobDateAlone($patient_array['camis_patient_date_of_birth']);
        $patient_array['los_value']                              = NumberOfDaysBetweenTwoDates($patient_array['camis_patient_admission_date'], date('Y-m-d'));
        $patient_array['camis_patient_los']                      = $patient_array['los_value'] > 1 ? $patient_array['los_value'] . ' Days ' : $patient_array['los_value'] . ' Day ';
        $patient_array['los_ward_value']                         = NumberOfDaysBetweenTwoDates($patient_array['camis_patient_ward_start_date'], date('Y-m-d'));
        $patient_array['camis_patient_los_ward']                 = $patient_array['los_ward_value'] > 1 ? $patient_array['los_ward_value'] . ' Days ' : $patient_array['los_ward_value'] . ' Day ';
        $patient_array['camis_patient_bed_group']                = ucfirst($patient_array['ibox_bed_group_name']) . ' ' . ($patient_array['ibox_bed_group_number'] != 0 ? $patient_array['ibox_bed_group_number'] : '');

        if (isset($patient_array['BoardRoundEstimatedDischargeDate']['patient_estimated_discharge_date'])) {
            $patient_array['BoardRoundEstimatedDischargeDate']['patient_estimated_discharge_date']   = $patient_array['BoardRoundEstimatedDischargeDate']['patient_estimated_discharge_date'] ? PredefinedDateFormatForEDD($patient_array['BoardRoundEstimatedDischargeDate']['patient_estimated_discharge_date']) : '';
        }

        if (isset($patient_array['BoardRoundPatientTasks']) && count($patient_array['BoardRoundPatientTasks']) > 0) {
            for ($i = 0; $i < count($patient_array['BoardRoundPatientTasks']); $i++) {
                $patient_array['BoardRoundPatientTasks'][$i]['task_created_at'] = PredefinedDateFormatOnTask($patient_array['BoardRoundPatientTasks'][$i]['task_created_at']);
            }
        }

        return $patient_array;
    }

    public function PrintHandOverPopUpContent(Request $request)
    {
        $success_array                                                              = array();
        $process_array                                                              = array();

        $success_array['ward_id'] = $request->ward_id;
        $success_array['patient_id'] = $request->patient_id;
        $process_array['patient_details_popup'] =  CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $request->ward_id)->whereNotNull('camis_patient_id')->select('camis_patient_id', 'ibox_ward_id', 'ibox_bed_group_number', 'ibox_bed_group_name', 'camis_consultant_code', 'camis_consultant_name')->get()->toArray();
        $uniqueBedGroups = [];
        $uniqueConsultantGroups = [];
        foreach ($process_array['patient_details_popup'] as $patient) {
            $bedGroupKey = $patient["ibox_bed_group_number"] . "-" . $patient["ibox_bed_group_name"];
            $uniqueBedGroups[$bedGroupKey] = [
                'ibox_bed_group_number' => $patient["ibox_bed_group_number"],
                'ibox_bed_group_name' => $patient["ibox_bed_group_name"],
            ];
            $bedGroupconsultant = $patient["camis_consultant_code"] . "-" . $patient["camis_consultant_name"];
            $uniqueConsultantGroups[$bedGroupconsultant] = [
                'camis_consultant_code' => $patient["camis_consultant_code"],
                'camis_consultant_name' => $patient["camis_consultant_name"],
            ];
        }

        $success_array['consultant'] = array_values($uniqueConsultantGroups);

        $success_array['unique_bed_groups'] = array_values($uniqueBedGroups);

        return view('Dashboards.Camis.WardSummary.WardSummaryModals.HandOverDetailsPrintPopUp', compact('success_array'));
    }



    public function PrintHandOverDetails(Request $request)
    {

        if ($request->bed_group != null) {
            $bed_group          = explode('-', $request->bed_group);
            $bed_group_name     = $bed_group[0];
            $bed_group_number   = (int) $bed_group[1];
        } else {
            $bed_group_name     = '';
            $bed_group_number   = '';
        }


        $ward_id                = (int) $request->ward_id;
        $consultant_code        = $request->consultant;

        $data_array                 = array();
        $ward_patient_list_array    = array();
        $patient_query              = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientHandOver',
            'PatientVitalPacInfo',
            'PatientWiseFlags' => function ($q) {
                $q->where('patient_flag_status_value', 1);
            },
            'PatientWiseFlags.PatientFlagList',
            'BoardRoundAdmittingReason' => function ($q) {
                $q->select('id', 'patient_id', 'patient_admitting_reason');
            },
            'BoardRoundSocialHistory' => function ($q) {
                $q->select('id', 'patient_id', 'patient_social_history');
            },
            'BoardRoundPharmacyData' => function ($q) {
                $q->select('id', 'patient_id', 'pharmacy_drug_history', 'pharmacy_drug_history_date', 'pharmacy_antibiotic_iv_status', 'pharmacy_antibiotic_iv_date', 'pharmacy_antibiotic_oral_status', 'pharmacy_antibiotic_oral_date', 'pharmacy_latest_comment', 'updated_at');
            },
            'BoardRoundMedicallyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment');
            },
            'BoardRoundTherapyFitData' => function ($q) {
                $q->select('id', 'patient_id', 'patient_therapy_fit_status');
            },
            'BoardRoundEstimatedDischargeDate' => function ($q) {
                $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
            },

            'BoardRoundPatientTasks' => function ($q) {
                $q->where('task_completed_status', '=', 0)->where('task_not_applicable_status', '=', 0)->orderBy('created_at', 'desc');
            },
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'RedGreenBed',
            'BoardRoundPatientGoal',
            'BoardRoundPastMedicalHistory'
        ])
            ->whereNotNull('camis_patient_id')->where('ibox_bed_type', 'Bed')
            ->where('ibox_ward_id', '=', $ward_id);

        if ($bed_group_name != '' && $bed_group_number != '') {
            $patient_query->where('ibox_bed_group_name', '=', $bed_group_name);
            $patient_query->where('ibox_bed_group_number', '=', $bed_group_number);
        }

        if ($consultant_code != '') {
            $patient_query->where('camis_consultant_code', $consultant_code);
        }

        $patient_array          = $patient_query->get();

        if (count($patient_array) > 0) {
            $data_array         = $patient_array->toArray();
            array_unshift($data_array, null);
            unset($data_array[0]);
            $data_collection    = collect($data_array);
            $data_group_array   = $data_collection->groupBy(['ibox_ward_name', 'ibox_bed_group_name', 'ibox_bed_group_number']);


            $success_array['patient_details'] = isset($data_group_array) ? $data_group_array : [];
            $success_array['is_page_break']   = $request->is_page_break;
            $success_array['red_bed_reason_list']                                 = BedRedReason::where('status', 1)->pluck('red_text_value', 'id')->toArray();

            $view               = View::make('Dashboards.Camis.WardSummary.WardSummaryModals.HandOverDetailsPrint', compact('success_array'));
            $sections           = $view->render();
            return $sections;
        }
        return '';
    }

    public function GetDeterioratingPatientTimeline(Request $request)
    {
        $camis_patient_id                                 = $request->camis_patient_id;


        $dp_task_list_list                                 = CamisIboxBoardRoundPatientTasks::where('patient_id', $request->camis_patient_id)

            ->whereIn('task_category', [6])
            ->where('task_description', 'Escalation Status')
            ->where('task_not_applicable_status', 0)
            ->pluck('task_created_at', 'task_dp_status_order_value')

            ->toArray();

        $timeline_date_list = array_map(function ($datetime) {
            return date('Y-m-d', strtotime($datetime));
        }, $dp_task_list_list);


        if ($request->filled('date') || count($timeline_date_list) == 0) {
            $task_date                                        =  $request->date;
        } else {
            $task_date                                        =  end($timeline_date_list);
        }

        $success_array                                    = array();
        $query                                            = CamisIboxWardPatientInformationWithBedDetailsFullList::where('camis_patient_id', $camis_patient_id)
            ->select('camis_patient_pas_number', 'camis_patient_name', 'camis_patient_age', 'camis_patient_sex', 'camis_patient_ward_id', 'camis_patient_date_of_birth', 'camis_patient_id')
            ->with('PatientVitalPacInfo')
            ->first();


        if (CamisIboxBoardRoundPatientTasks::where('patient_id', $request->camis_patient_id)->whereIn('task_category', [6, 7, 8])->doesntExist()) {
            $success_array['data']                             = '<div class="No_record_css">' . NotFoundMessage() . '</div>';
            $success_array['message']                          = 'success';
            $success_array['data_count']                       = 0;
        } else {




            $board_round_deteriorating_list                    =   $query->toArray();

            $master_patient_task_list = CamisIboxBoardRoundPatientTasks::with([
                'PatientTaskGroup' => function ($query) {
                    $query->select('id', 'task_group_name');
                },
                'PatientTaskCategory',
            ])
                ->whereIn('task_category', [6])

                ->where('patient_id', $camis_patient_id)
                ->get();




            $virtual_comment_list = CamisIboxDPVirtualWardComment::where('patient_id', $request->camis_patient_id)
                ->get()

                ->toArray();


            $sepsis_aki_task                                    = CamisIboxBoardRoundPatientTasks::with([
                'PatientTaskGroup' => function ($query) {
                    $query->select('id', 'task_group_name');
                },
                'PatientTaskCategory',
            ])
                ->whereIn('task_category', [7, 8])->where('patient_id', $camis_patient_id)->get()->toArray();


            $common_array = [];


            foreach ($timeline_date_list as $key => $date) {

                $next_date = isset($timeline_date_list[$key + 1]) ? $timeline_date_list[$key + 1] : null;


                $start_time = date('Y-m-d 00:00:00', strtotime($date));

                if (isset($next_date)) {
                    $end_time = date('Y-m-d 23:59:59', strtotime($start_time));
                } else {
                    $end_time = date('Y-m-d 23:59:59');
                }

                $parent_task_list = array_filter($master_patient_task_list->toArray(), function ($task) use ($key) {

                    return (strtolower($task['task_description']) == strtolower('Escalation Status') && $task['task_not_applicable_status'] == 1);
                });

                $not_applicable_series = array_column($parent_task_list, 'task_dp_status_order_value');

                $patient_task_list_data = array_filter($master_patient_task_list->toArray(), function ($task) use ($key) {

                    return ($task['task_dp_status_order_value'] == $key);
                });


                $complited_task =  array_filter($master_patient_task_list->toArray(), function ($task) use ($key) {

                    return ($task['task_dp_status_order_value'] > $key && strpos(strtolower($task['task_description']), 'escalation') !== false);
                });

                if (count($complited_task) > 0) {
                    $first_element = key($complited_task);
                    $end_time = $complited_task[$first_element]['task_created_at'];
                }
                if (count($patient_task_list_data) > 0) {
                    $first_element = key($patient_task_list_data);
                    $start_time = $patient_task_list_data[$first_element]['task_created_at'];
                }

                $list_of_sub_task = array_filter($sepsis_aki_task, function ($task) use ($start_time, $end_time) {
                    return $task['task_created_at'] >= $start_time && $task['task_created_at'] < $end_time;
                });



                $list_of_comment = array_filter($virtual_comment_list, function ($task) use ($start_time, $end_time) {
                    $task_updated_at = Carbon::parse($task['updated_at']);

                    return $task_updated_at->between(Carbon::parse($start_time), Carbon::parse($end_time));
                });


                $common_array[$key] = [
                    'patient_task_list'    =>  $patient_task_list_data ?? [],
                    'virtual_comment_list' =>  $list_of_comment ?? [],
                    'patient_details'      => $board_round_deteriorating_list,
                    'list_of_sub_task'     => $list_of_sub_task
                ];
            }



            $selected_date                                     =   $task_date;


            $all_wards                                         =   Wards::pluck('ward_name', 'id')->toArray();
            $view                                              =   View::make('Dashboards.Camis.WardSummary.BoardRoundModals.DeterioratingPatientTimeline', compact('board_round_deteriorating_list', 'selected_date', 'timeline_date_list', 'virtual_comment_list', 'camis_patient_id', 'sepsis_aki_task', 'all_wards', 'common_array'));
            $success_array['data']                             =   $view->render();
            $success_array['message']                          =   'success';
            $success_array['data_count']                       = 1;
        }

        return ReturnArrayAsJsonToScript($success_array);
    }



    public function FetchBoardRoundHistory(Request $request)
    {
        $success_array["status"]                                =   1;
        $success_array["message"]                               =   'ok';
        $success_array["ward_name"]                             =   $request->ward_name;
        $success_array['governance_data']                       =   GovernanceFrontendCamisOperationLogs::where('gov_patient_id', $request->camis_patient_id)->latest()->get();
        $view                                                   =   View::make('Dashboards.Camis.WardSummary.BoardRoundModals.ShowHistory', compact('success_array'));
        $success_array['sections']                              =   $view->render();
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function FetchAneDischargeSummary(Request $request)
    {
        $check_pas_id                       = $request->check_pas_id;
        $symphony_atd_num                   = $request->symphony_atd_num;

        $symphony_form_latest_atd_num = array();
        $symphony_data_clinician_seen      = array();
        $symphony_data_refferal      = array();
        $symphony_data_triage_data      = array();
        $symphony_data_attendance_data      = array();
        $symphony_data_attendance_detail      = array();
        $symphony_data_patient_details      = array();
        $symphony_data_attendance_count      = array();
        $AttendanceNumber = '';
        $all_data_array['type'] = 'symphony';
        $current_attendence_number                  = '';
        $previous_attendence_number                 = '';
        $next_attendence_number                     = '';

        if ($check_pas_id != "") {
            $symphony_form_latest_atd_num           = SymphonyFormLatestAttendanceNUmber::where('pas_number', $check_pas_id)->get();
            if ($request->filled('symphony_atd_num')) {

                $AttendanceNumber = $symphony_atd_num;
            } elseif (isset($symphony_form_latest_atd_num[0]->attendancenumber)) {

                $AttendanceNumber = $symphony_form_latest_atd_num[0]->attendancenumber;
            }

            if ($AttendanceNumber != '') {
                $symphony_data_clinician_seen           = SymphonyDataClinicalSeen::where('attendance_number', $AttendanceNumber)->get()->toArray();
                $symphony_data_refferal                 = SymphonyDataRefferal::where('attendance_number', $AttendanceNumber)->get();
                $symphony_data_triage_data              = SymphonyDataTriageData::where('attendance_number', $AttendanceNumber)->get()->toArray();
                $symphony_data_attendance_data          = SymphonyDataAttendanceData::where('pas_number', $check_pas_id)->get();
                $symphony_data_attendance_detail        = SymphonyDataAttendanceDetail::where('atd_num', $AttendanceNumber)->first();
                $symphony_data_patient_details          = SymphonyDataPatientDetails::where('atd_num', $AttendanceNumber)->first();
            }
            $current_attendence_number                  = $AttendanceNumber;

            $check_key = 0;

            if (!empty($symphony_form_latest_atd_num) && count($symphony_form_latest_atd_num) > 0) {

                foreach ($symphony_form_latest_atd_num as $key_s => $row_s) {

                    if ($row_s->attendancenumber == $current_attendence_number) {
                        $check_key = $key_s;
                        break;
                    }
                }
            }

            if (isset($symphony_form_latest_atd_num[$check_key - 1])) {

                $next_attendence_number                     = $symphony_form_latest_atd_num[$check_key - 1]->attendancenumber;
            }

            if (isset($symphony_form_latest_atd_num[$check_key + 1])) {
                $previous_attendence_number                 = $symphony_form_latest_atd_num[$check_key + 1]->attendancenumber;
            }
        }
        $specialcases_array    = array();

        $special_cases_str  = "";

        if (count($specialcases_array) > 0) {
            $special_cases_str  =   implode(", ", $specialcases_array);
        }

        $all_data_array["current_attendence_number"] = $current_attendence_number;
        $all_data_array["next_attendence_number"] = $next_attendence_number;
        $all_data_array["previous_attendence_number"] = $previous_attendence_number;
        $all_data_array["symphony_form_latest_atd_num"] = $symphony_form_latest_atd_num;
        $all_data_array["symphony_data_clinician_seen"] = $symphony_data_clinician_seen;
        $all_data_array["symphony_data_refferal"] = $symphony_data_refferal;
        $all_data_array["symphony_data_triage_data"] = $symphony_data_triage_data;
        $all_data_array["symphony_data_attendance_data"] = $symphony_data_attendance_data;
        $all_data_array["symphony_data_attendance_detail"] = $symphony_data_attendance_detail;
        $all_data_array["symphony_data_patient_details"] = $symphony_data_patient_details;


        $all_data_array["special_cases_str"] = $special_cases_str;


        $view                                               = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.AnEDischargeData', compact('all_data_array'));
        $returnHTML                                         = $view->render();

        $ret_arra                                           = array();
        $ret_arra['returnHTML']                             = $returnHTML;
        $ret_arra['current_attendence_number']              = $all_data_array["current_attendence_number"];
        $ret_arra['next_attendence_number']                 = $all_data_array["next_attendence_number"];
        $ret_arra['previous_attendence_number']             = $all_data_array["previous_attendence_number"];
        $ret_arr_html                                       = json_encode($ret_arra);
        return $ret_arr_html;
    }

    public function GetWardStatusData(Request $request)
    {
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $ward_id                                                    = $request->camis_ward_id;

        $board_round_text                                           = 'boardround_' . $ward_id . '_' . $user_id;
        $board_round_type                                           = 'boardround_type_' . $ward_id . '_' . $user_id;
        $board_round_doctor_id                                      = 'boardround_doctor_' . $ward_id . '_' . $user_id;
        $board_round_last_patient                                   = 'boardround_last_patient_' . $ward_id . '_' . $user_id;


        $success_array                                              = array();
        if (Session::has('boardround_data') && Session::get('boardround_data') == $board_round_text) {
            $success_array['boardround_resume']                     = 1;
            $success_array['boardround_config']                     = Session::get($board_round_type);
            $success_array['boardround_resume_last_patient']        = (Session::has($board_round_last_patient) && !empty(Session::get($board_round_last_patient))) ? Session::get($board_round_last_patient) : null;
        } else {
            $success_array['boardround_resume']                     = 0;
        }
        $success_array['ward_id']                                   = $ward_id;
        $success_array['user_id']                                   = $user_id;
        if (Session::has($board_round_type) && Session::get($board_round_type) == 'doctor') {
            $success_array['boardround_selected_checkbox']          = Session::get($board_round_doctor_id);
        } else {
            $success_array['boardround_selected_checkbox']          = Session::get($board_round_type);
        }




        return ReturnArrayAsJsonToScript($success_array);
    }

    public function CamisResumeBoardRound(Request $request)
    {
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $ward_id                                                    = $request->camis_ward_id;

        $board_round_text                                           = 'boardround_' . $ward_id . '_' . $user_id;
        $board_round_type                                           = 'boardround_type_' . $ward_id . '_' . $user_id;
        $board_round_doctor_id                                      = 'boardround_doctor_' . $ward_id . '_' . $user_id;
        $board_round_last_patient                                   = 'boardround_last_patient_' . $ward_id . '_' . $user_id;
        $doctor_code = str_replace(' ', '_ibox_', $request->doctor_id);

        $patient = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->whereNotNull('camis_patient_id');
        if ($request->type == 'stranded') {
            $patient = $patient->whereDate('camis_patient_admission_date', '<=', Carbon::now()->subDays(7)->toDateString());
        } elseif ($request->type == 'doctor') {
            $patient = $patient->where('camis_consultant_name', str_replace('_ibox_', ' ', $request->doctor_id));
        }


        $patient = $patient->first();
        if ($request->type != Session::get($board_round_type)) {
            Session::forget($board_round_type);
            Session::put($board_round_last_patient, $patient->camis_patient_id);
        }

        Session::put('boardround_data', $board_round_text);
        Session::put($board_round_type, $request->type);

        if ($request->type == 'doctor') {
            Session::put($board_round_doctor_id, str_replace(' ', '_ibox_', $request->doctor_id));
        }


        if (!Session::has('board_round_time')) {
            Session::put('board_round_time', time());
        }

        $success_array                                          = array();
        $success_array['boardround_resume']                     = 1;
        $success_array['boardround_config']                     = Session::get($board_round_type);
        $success_array['boardround_resume_last_patient']        = (Session::has($board_round_last_patient) && !empty(Session::get($board_round_last_patient))) ? Session::get($board_round_last_patient) : $patient->camis_patient_id;
        self::InsertBoardRoundData($success_array['boardround_resume_last_patient']);
        $success_array['message']                               = 'success';
        $success_array['ward_id']                               = $ward_id;
        $success_array['user_id']                               = $user_id;
        $success_array['boardround_selected_checkbox']          = $request->type;
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function KeepCacheBoardRoundConfig(Request $request)
    {
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $ward_id                                                    = $request->camis_ward_id;

        $board_round_text                                           = 'boardround_' . $ward_id . '_' . $user_id;
        $board_round_type                                           = 'boardround_type_' . $ward_id . '_' . $user_id;
        $board_round_doctor_id                                      = 'boardround_doctor_' . $ward_id . '_' . $user_id;
        $board_round_last_patient                                   = 'boardround_last_patient_' . $ward_id . '_' . $user_id;
        $doctor_code = str_replace(' ', '_ibox_', $request->doctor_id);
        Session::put('_ibox_' . $ward_id . '_' . $user_id . '_' . Session::get($board_round_text), PredefinedDateFormatFor24Hour(CurrentDateOnFormat()) . '_' . Session::get($board_round_text));
        Session::put('_ibox_' . $ward_id . '_' . $user_id . '_' . Session::get($board_round_type), PredefinedDateFormatFor24Hour(CurrentDateOnFormat()) . '_' . Session::get($board_round_type));
        Session::put('_ibox_' . $ward_id . '_' . $user_id . '_' . Session::get($board_round_doctor_id), PredefinedDateFormatFor24Hour(CurrentDateOnFormat()) . '_' . Session::get($board_round_doctor_id));
    }
    public function CamisStartBoardRound(Request $request)
    {
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $ward_id                                                    = $request->camis_ward_id;

        $board_round_text                                           = 'boardround_' . $ward_id . '_' . $user_id;
        $board_round_type                                           = 'boardround_type_' . $ward_id . '_' . $user_id;
        $board_round_doctor_id                                      = 'boardround_doctor_' . $ward_id . '_' . $user_id;
        $board_round_last_patient                                   = 'boardround_last_patient_' . $ward_id . '_' . $user_id;
        $doctor_code = str_replace(' ', '_ibox_', $request->doctor_id);

        Session::put('boardround_data', $board_round_text);
        Session::put($board_round_type, $request->type);

        if (!Session::has('board_round_time')) {
            Session::put('board_round_time', time());
        }

        if (Session::has($board_round_type)) {
            Session::forget($board_round_type);
            Session::put($board_round_type, $request->type);
        } else {
            Session::put($board_round_type, $request->type);
        }


        if (Session::has('type')) {
            Session::forget('type');
            Session::put('type', $request->type);
        } else {
            Session::put('type', $request->type);
        }
        if (Session::has('doctor_id')) {
            Session::forget('doctor_id');
            Session::put('doctor_id', $doctor_code);
        } else {
            Session::put('doctor_id', $doctor_code);
        }



        if ($request->type == 'doctor') {
            if (Session::has($board_round_doctor_id)) {
                Session::forget($board_round_doctor_id);
                Session::put($board_round_doctor_id, $doctor_code);
            } else {
                Session::put($board_round_doctor_id, $doctor_code);
            }
        }

        $patient = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $ward_id)->whereNotNull('camis_patient_id');
        if ($request->type == 'stranded') {
            $patient = $patient->whereDate('camis_patient_admission_date', '<=', Carbon::now()->subDays(7)->toDateString());
        } elseif ($request->type == 'doctor') {
            $patient = $patient->where('camis_consultant_name', str_replace('_ibox_', ' ', $request->doctor_id));
        }
        $current_time = Carbon::now();
        $current_hour = $current_time->format('H');
        if ($request->has('restart_bed_order')) {

            if ($current_hour >= 0 && $current_hour <= 11) {
                $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                    ->where('ward_id', $ward_id)
                    ->whereDate('updated_at', now()->toDateString())
                    ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '00' AND '11'")
                    ->pluck('patient_id')->toArray();
            } else {
                $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                    ->where('ward_id', $ward_id)
                    ->whereDate('updated_at', now()->toDateString())
                    ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '12' AND '23'")
                    ->pluck('patient_id')->toArray();
            }
            $patient = $patient->whereNotIn('camis_patient_id', $existing_query);
        }
        $patient = $patient->first();
        if ($patient != null) {
            Session::put($board_round_last_patient, $patient->camis_patient_id);
        }

        self::InsertBoardRoundData($patient->camis_patient_id);
        $success_array                                          = array();
        $success_array['boardround_resume']                     = 1;
        $success_array['boardround_config']                     = Session::get($board_round_type);
        $success_array['boardround_resume_last_patient']        = $patient->camis_patient_id;
        $success_array['message']                               = 'success';
        $success_array['ward_id']                               = $ward_id;
        $success_array['user_id']                               = $user_id;
        $success_array['boardround_selected_checkbox']          = $request->type;
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetWardRoundUser(Request $request)
    {
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $ward_id                                                    = $request->camis_ward_id;
        $success_array['task_group']                                = BoardRoundGroup::where('status', 1)->orderBy('board_group_name')->get();
        $board_round_user                                           = CamisIboxWardRound::where('ward_id', $ward_id)->where('user_id', $user_id)->select('role')->first();
        if ($board_round_user != null) {
            $success_array['ward_round_user']                       = explode(',', $board_round_user->role);
        } else {
            $success_array['ward_round_user']                       = [];
        }

        $success_array["status"]                                                = 1;
        $success_array["message"]                                               = DataAddedMessage();
        $view                                                                   = View::make('Dashboards.Camis.WardSummary.Modals.AttendanceUserList', compact('success_array'));
        $success_array['sections']                                              = $view->render();
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function SaveWardRoundUser(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardWardRound";
        $date_time_now                                              = CurrentDateOnFormat();
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $ward_id                                                    = $request->camis_ward_id;
        $user_list                                                  = $request->boardround_user;
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;


        $all_patients = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('ibox_bed_type', '=', 'Bed')->where('ibox_ward_id', $ward_id)->pluck('camis_patient_id')->toArray();
        if (Session::has('board_round_time')) {
            $boardround_data = Session::get('board_round_time');
        } else {
            $boardround_data = '';
        }


        $current_time = Carbon::now();
        $current_hour = $current_time->format('H');

        if ($current_hour >= 0 && $current_hour <= 11) {
            $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                ->where('ward_id', $request->camis_ward_id)
                ->whereDate('updated_at', now()->toDateString())
                ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '00' AND '11'")
                ->pluck('patient_id')->toArray();
        } else {
            $existing_query = HistoryCamisIboxBoardRoundPatientStatus::where('is_board_round', 1)
                ->where('ward_id', $request->camis_ward_id)
                ->whereDate('updated_at', now()->toDateString())
                ->whereRaw("SUBSTRING(updated_at, 12, 2) BETWEEN '12' AND '23'")
                ->pluck('patient_id')->toArray();
        }
        $remaing_patients = array_diff($all_patients, $existing_query);


        $medfit_patients = CamisIboxBoardRoundMedFit::whereIn('patient_id', $remaing_patients)->where('patient_medically_fit_status', 1)->pluck('patient_id')->toArray();


        $patient_query = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $remaing_patients)->whereNotIn('camis_patient_id', $medfit_patients)->get()->toArray();
        $missed_patient = array();
        $i = 0;
        foreach ($patient_query as $patient_data) {
            $i++;
            $missed_patient[$i]['patient_id'] = $patient_data['camis_patient_id'];
            $missed_patient[$i]['bed'] = $patient_data['ibox_actual_bed_full_name'];
            $missed_patient[$i]['name'] = $patient_data['camis_patient_name'];
            $missed_patient[$i]['pas_number'] = $patient_data['camis_patient_pas_number'];
            $missed_patient[$i]['consultant'] = $patient_data['camis_consultant_name'];
            $missed_patient[$i]['camis_consultant_code_description'] = $patient_data['camis_consultant_code_description'];
            $missed_patient[$i]['camis_consultant_specialty'] = $patient_data['camis_consultant_specialty'];
        }

        if (count($missed_patient) > 0) {
            $status = 0;
        } else {
            $status = 1;
        }



        $result = CamisIboxWardRound::updateOrCreate(['ward_id' => $ward_id], ['role' => $user_list, 'user_id' => $user_id, 'total_patients' => count($all_patients), 'completed' => count($existing_query), 'status' => $status, 'board_round_session' => $boardround_data, 'missed_patients' => json_encode($missed_patient)]);


        if ($result instanceof CamisIboxWardRound) {
            HistoryCamisIboxBoardWardRound::Create(['ward_id' => $ward_id, 'role' => $user_list, 'user_id' => $user_id, 'created_at' => $result->updated_at, 'updated_at' => $result->updated_at, 'id' => $result->id, 'history_status' => 1, 'total_patients' => count($all_patients), 'completed' => count($existing_query), 'status' => $status, 'board_round_session' => $boardround_data, 'missed_patients' => json_encode($missed_patient)]);


            $success_array["message"]                                   = 'success';
            $success_array["status"]                                    = 1;
            $board_round_text                                           = 'boardround_' . $ward_id . '_' . $user_id;
            $board_round_type                                           = 'boardround_type_' . $ward_id . '_' . $user_id;
            $board_round_doctor_id                                      = 'boardround_doctor_' . $ward_id . '_' . $user_id;
            $board_round_last_patient                                   = 'boardround_last_patient_' . $ward_id . '_' . $user_id;


            $sessionData = Session::all();
            foreach ($sessionData as $key => $value) {
                if (strpos($key, '_ibox_') === 0) {
                    Session::forget($key);
                }
            }

            Session::forget($board_round_text);
            Session::forget($board_round_type);
            Session::forget($board_round_doctor_id);
            Session::forget($board_round_last_patient);
            Session::forget('type');
            Session::forget('doctor_id');
            Session::forget('boardround_data');
            Session::forget('board_round_time');
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function CheckedLockedStatus(Request $request)
    {
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $camis_patient_id                                           = $request->camis_patient_id;
        $browser_id                                                 = $request->browser_id;
        $user                                                       = Sentinel::findById($user_id);
        $locked_user                                                = '' . $user->username . '_' . $camis_patient_id . '_' . $browser_id;
        $success_array                                              = array();
        $locked_key                                                 = 'boardround_lock_' . $camis_patient_id;
        if (Cache::has($locked_key)) {
            if (Cache::get($locked_key) == $locked_user) {
                $success_array['locked']                            = 0;
            } else {
                $data = explode("_", Cache::get($locked_key));
                $success_array['locked']                            = 1;
                $success_array['locked_by']                         = $data['0'];
                $expiration_timestamp = Cache::get($locked_key . ':expiration');
                $remaining_seconds = max(0, $expiration_timestamp - time());
                $success_array['unlocked_after'] = $remaining_seconds;
            }
        } else {
            $success_array['locked']                            = 0;

            $expiration_time_in_seconds = 180;
            $expiration_timestamp = time() + $expiration_time_in_seconds;
            Cache::put($locked_key, $locked_user, $expiration_time_in_seconds);
            Cache::put($locked_key . ':expiration', $expiration_timestamp, $expiration_time_in_seconds);
        }

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function SaveUnlockedStatus(Request $request)
    {
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $camis_patient_id                                           = $request->camis_patient_id;
        $browser_id                                                 = $request->browser_id;
        $user                                                       = Sentinel::findById($user_id);
        $locked_user                                                = '' . $user->username . '_' . $camis_patient_id . '_' . $browser_id;
        $success_array                                              = array();
        $locked_key                                                 = 'boardround_lock_' . $camis_patient_id;
        if (Cache::get($locked_key) == $locked_user) {
            Cache::forget($locked_key);
        }
    }

    public function GetPatientOutstandingTasks(Request $request)
    {
        $patient_id = $request->camis_patient_id;

        $task_list = CamisIboxOutstandingTasks::where('patient_id', $patient_id)->orderBy('display_date_time', 'desc')->get()->toArray();

        $success_array["status"]                                                = 1;
        $success_array["message"]                                               = 'Outstanding Tasks';
        $view                                                                   = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.OutstandingTaskData', compact('task_list'));
        $success_array['sections']                                              = $view->render();

        return ReturnArrayAsJsonToScript($success_array);
    }

    public function GetNextOfKin(Request $request)
    {
        $process_array                                         = array();
        $success_array                                         = array();
        $camis_patient_id                                      = $request->camis_patient_id;
        $patient_nok                                           = CamisIboxBoardRoundNOK::where('id', $camis_patient_id)->first();
        if ($patient_nok != null) {

            $success_array["status"]                                                = 1;
            $success_array["message"]                                               = 'Nok Details';
            $view                                                                   = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.NOKData', compact('patient_nok'));
            $success_array['sections']                                              = $view->render();
        } else {
            $success_array["status"]                                                = 0;
            $success_array["message"]                                               = NotFoundMessage();
        }
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function GetOutstandingTask(Request $request)
    {

        $camis_patient_id                                      = $request->camis_patient_id;
        $camis_category_edit_permission                        = $request->edit_category;
        $camis_category_filter                                 = $request->filter_category;
        $permission                                            = $request->permission;

        $patient = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $camis_patient_id)
            ->with([
                'BoardRoundPatientTasks' => function ($q) {
                    $q->where('task_completed_status', 0)
                        ->where('task_not_applicable_status', 0)
                        ->orderBy('created_at', 'desc');
                },
                'BoardRoundPatientTasks.PatientTaskGroup',
                'BoardRoundPatientTasks.PatientTaskCategory',
            ])
            ->first()->toArray();




        if ($request->has('filter_category') && $request->filled('filter_category')) {
            return GetCamisOutstandingTask($patient['board_round_patient_tasks'], $camis_category_edit_permission, $camis_category_filter, $permission);
        } else {

            if ($camis_category_edit_permission == 6) {
                return GetCamisOutstandingTask($patient['board_round_patient_tasks'], 0, $camis_category_filter);
            }
            return GetCamisOutstandingTask($patient['board_round_patient_tasks'], $camis_category_edit_permission, $camis_category_filter, $permission);
        }
    }


    public function GetPatientWardMovementHistory(Request $request)
    {
        $camis_patient_id     = $request->camis_patient_id;
        $patient = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $camis_patient_id)->first();
        $history_list = $patient->GetWardHistory();
        $view                                                           = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.WardMovementHistoryData', compact('history_list', 'patient'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function PatientOutstandingTask(Request $request)
    {
        $patient_id = $request->patient_id;
        $edit_category = $request->task_category;
        $type = $request->type;

        if ($type == 'doctor_at_night') {
            $patient_task = CamisIboxBoardRoundPatientTasks::where('patient_id', $patient_id)
                ->where('task_doctor_at_night', 1)
                ->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->with(['PatientTaskGroup', 'PatientTaskCategory'])->latest()->get()->toArray();
        } else {
            $patient_task = CamisIboxBoardRoundPatientTasks::where('patient_id', $patient_id)
                ->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->with(['PatientTaskGroup', 'PatientTaskCategory'])->latest()->get()->toArray();
        }

        return GetAllOutstandingTask($patient_task, $edit_category, null, $request->permission);
    }

    public function PatientAllComments(Request $request)
    {

        $camis_patient_id = $request->patient_id;
        $edit_comment = null;
        $delete_comment = null;
        if ($request->type == 'surgical_ward') {
            $comment_list = CamisIboxSurgicalWardsComment::where('patient_id', $camis_patient_id)->get();
        } elseif ($request->type == 'doctor_at_night') {
            $comment_list = CamisIboxDoctorAtNightComment::where('patient_id', $camis_patient_id)->get();
        }


        $view                                                           = View::make('Common.View.AllComment', compact('comment_list', 'camis_patient_id', 'edit_comment', 'delete_comment'));
        $sections                                                       = $view->render();
        return $sections;
    }


    public function SaveDtocPathway(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardPathwayRequirement";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $dtoc_pathway_id                                            = $request->pathway_id;
        $dtoc_pathway_data                                          = DtocPathway::where('id', '=', $request->pathway_id)->first();
        $success_array['dtoc_pathway_text']                         = $dtoc_pathway_data->dtoc_pathway_text ?? '';
        $gov_updated_info = 'Path Way -' . $success_array['dtoc_pathway_text'];

        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundPathwayRequirement::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundPathwayRequirement::updateOrCreate(['patient_id' => $camis_patient_id], ['dtoc_pathway_text' => $dtoc_pathway_data->dtoc_pathway_text ?? '', 'dtoc_pathway_id' => $dtoc_pathway_id, 'updated_by' => $user_id]);
            $functional_identity                                    = 'Pathway Requirement';

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundPathwayRequirement::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_updated_info, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundPathwayRequirement::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $gov_updated_info, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }




            $success_array["status"]                                    = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function FetchBoardRoundPathwayHistory(Request $request)
    {
        $patient = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $request->camis_patient_id)->first();
        $success_array['medfit_dates'] = $patient->MedFitHistoryData();
        $success_array['medfit_history'] = $patient->MedFitDates();
        $success_array['dtoc_current_status_drop'] = DtocCurrentStatus::pluck('dtoc_current_status_text', 'id')->toArray();
        $view = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.ShowPathwayHistory', compact('success_array'));
        $sections = $view->render();
        return $sections;
    }

    public function DtocWardAllCommentList($camis_patient_id)
    {
        $comment_list = CamisIboxBoardRoundDtocComment::where('patient_id', $camis_patient_id)->latest()->get();

        $view                                                           = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.DtocCommentListData', compact('comment_list', 'camis_patient_id'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function GetDischargeLoungeHandover(Request $request)
    {
        $patient_query              = CamisIboxWardPatientInformationWithBedDetailsView::with([

            'BoardRoundAdmittingReason' => function ($q) {
                $q->select('id', 'patient_id', 'patient_admitting_reason');
            },
            'PatientHandOver' => function ($q) {
                $q->select('id', 'patient_id', 'ibox_handover_i_continence', 'ibox_handover_special_diet_comment');
            },
            'BoardRoundPharmacyData' => function ($q) {
                $q->select('id', 'patient_id', 'pharmacy_drug_history', 'pharmacy_antibiotic_iv_status', 'pharmacy_antibiotic_oral_status', 'pharmacy_latest_comment', 'updated_at');
            },
            'PatientVitalPacInfo'
        ])
            ->where('camis_patient_id', '=', $request->camis_patient_id)->first();


        $success_array['patient_data']                                           = $patient_query;
        $handover_query              = CamisIboxBoardRoundDischargeLoungeHandover::where('patient_id', '=', $request->camis_patient_id)->first();

        if ($handover_query != null) {
            $success_array['patient_admit_reason'] = $handover_query->patient_admitting_reason;
            $success_array['patient_diet'] = $handover_query->diet;
            $success_array['patient_continence'] = $handover_query->continence;
            $success_array['patient_ward'] = $handover_query->name_of_ward;
        } else {
            $success_array['patient_admit_reason'] = $patient_query->BoardRoundAdmittingReason ? $patient_query->BoardRoundAdmittingReason->patient_admitting_reason : '';
            $success_array['patient_diet'] = $patient_query->PatientHandOver->ibox_handover_special_diet_comment ?? '';
            $success_array['patient_ward'] = $patient_query->ibox_ward_name ?? '';
            $success_array['patient_continence'] = $patient_query->PatientHandOver->ibox_handover_i_continence ?? '';
        }

        $success_array['handover_data']                                           = $handover_query;

        $view               = View::make('Dashboards.Camis.WardSummary.BoardRoundModals.DischargeLoungeTab', compact('success_array'));
        $sections           = $view->render();
        return $sections;
    }




    public function SaveDischargeLoungeHandover(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundDischargeLoungeHandover";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $updated_data_as_array                                      = $request->except(['_token', 'camis_patient_id']);
        $updated_data_as_array['status']                            = 0;
        $updated_data_as_array['reject_reason']                     = '';
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundDischargeLoungeHandover::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundDischargeLoungeHandover::updateOrCreate(['patient_id' => $camis_patient_id], $updated_data_as_array);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
            $functional_identity                                    = 'Discharge Lounge Handover';

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundDischargeLoungeHandover::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Dischagre Lounge Handover Data Added', $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundDischargeLoungeHandover::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Dischagre Lounge Handover Data Updated', $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function ActionDischargeToWard($camis_patient_id)
    {

        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisDPVirtualPatientData";
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxDPVirtualWardPatientStatus::updateOrCreate(['patient_id' => $camis_patient_id], ['type' => 4, 'updated_by' => $user_id]);
            $functional_identity                                    = 'DP Virtual Ward Data';

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Discharged To Ward', $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Discharged To Ward', $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;



            $history_controller                                         = new HistoryController;
            $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientFlag";

            $patient_data = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $camis_patient_id)->first();
            if (isset($patient_data) && strtolower($patient_data->camis_patient_ward) != 'critc') {
                $patient_flag_name                                          = 'ibox_patient_flag_nurse_concern';
            } else {
                $patient_flag_name                                          = 'ibox_patient_flag_stepdown';
            }
            $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"]                                   = ErrorOccuredMessage();
            $success_array["status"]                                    = 0;

            if ($camis_patient_id != "" && $user_id != "") {
                $gov_text_before_arr                                    = CamisIboxBoardRoundPatientFlag::where('patient_id', '=', $camis_patient_id)->where('patient_flag_name', $patient_flag_name)->first();

                if (isset($gov_text_before_arr->id) && $gov_text_before_arr->id != '') {
                    $master_flag_data                                   = BoardRoundFlagList::where('patient_flag_stored_name', '=', $patient_flag_name)->first();

                    if (isset($master_flag_data->id) && $master_flag_data->id != '') {
                        $flag_set_name                                  = $master_flag_data->patient_flag_name;
                    }
                    CamisIboxBoardRoundPatientFlag::where('id', '=', $gov_text_before_arr->id)->delete();
                    $updated_data                                       = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
                    $functional_identity                                = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_flag", "ibox_governance_frontend_functional_names");
                    $success_array["message"]                           = DataRemovalMessage();
                    $gov_text_before                                    = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                                 = array();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before,  $flag_set_name, $gov_text_after_arr, $functional_identity, 3);
                    $success_array["status"]                            = 1;
                }
            }
        }
    }

    public function GovernanceIboxDataPreCall($gov_text_after_arr, $functional_identity, $gov_text_before, $operation)
    {
        $gov_data               = array();
        $gov_text_after         = array();

        if ($operation == 1) {
            if (isset($id) && $id != '') {

                if ($gov_text_after_arr) {
                    $gov_text_after = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"])) {
                $gov_data["gov_text_before"]        = "";
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = 'CCU Ward Changes';
            }
        }
        if ($operation == 2) {
            if (isset($id) && $id != '') {


                if ($gov_text_after_arr) {
                    $gov_text_after                 = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"])) {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = 'CCU Ward Changes';
            }
        }

        if (!empty($gov_data)) {

            if (count($gov_data) > 0) {

                $governance = new GovernanceController;
                $governance->GovernanceStoreIboxData($gov_data);
            }
        }
    }

    public function ConsultantByBay(Request $request)
    {


        $success_array  = array();
        $process_array  = array();

        $process_array['ward_id'] = $request->ward_id;
        $process_array['consultant'] = $request->consultant ?? '';
        $query = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_id', $process_array['ward_id'])
            ->whereNotNull('camis_patient_id');

        if ($process_array['consultant'] !== '') {
            $query->where('camis_consultant_code', $process_array['consultant']);
        }

        $all_bays = $query->select('ibox_bed_group_name', 'ibox_bed_group_number')->get()->toArray();

        $optionsHtml = '';
        $uniqueBedGroups = [];
        foreach ($all_bays as $patient) {
            $bedGroupKey = $patient["ibox_bed_group_number"] . "-" . $patient["ibox_bed_group_name"];
            $uniqueBedGroups[$bedGroupKey] = [
                'ibox_bed_group_number' => $patient["ibox_bed_group_number"],
                'ibox_bed_group_name' => $patient["ibox_bed_group_name"],
            ];
        }


        $success_array['unique_bed_groups'] = array_values($uniqueBedGroups);

        if (count($success_array['unique_bed_groups']) > 0) {
            foreach ($success_array['unique_bed_groups'] as $bay) {

                $bedGroupNumber = $bay['ibox_bed_group_number'] > 0 ? $bay['ibox_bed_group_number'] : '';

                $optionsHtml .= '<option value="' . $bay['ibox_bed_group_name'] . '-' . $bay['ibox_bed_group_number'] . '">' . $bay['ibox_bed_group_name'] . ' ' . $bedGroupNumber . '</option>';
            }
        }

        return $optionsHtml;
    }

    public function RemoveAllowedToBeMovedByPatient($camis_patient_id)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundAllowedToMove";
        $user_id                                                    = 102;
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundAllowedToMove::where('patient_id', '=', $camis_patient_id)->first();
            if (isset($gov_text_before_arr->id) && $gov_text_before_arr->id != '') {
                CamisIboxBoardRoundAllowedToMove::where('patient_id', '=', $camis_patient_id)->delete();
                $updated_data                                       = $gov_text_before_arr;
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
                $functional_identity                                = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_allowed_to_move", "ibox_governance_frontend_functional_names");
                $success_array["message"]                           = DataRemovalMessage();
                $gov_text_before                                    = $gov_text_before_arr->toArray();
                $gov_text_after_arr                                 = array();
                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, '', $gov_text_after_arr, $functional_identity, 3);
                $success_array["status"]                            = 1;
            }
        }

        return ReturnArrayAsJsonToScript($success_array);
    }


    public function UpdatePatientLevel(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundLevel";
        $date_time_now                                              = CurrentDateOnFormat();

        $camis_patient_id                                           = $request->camis_patient_id;
        $level_id                                                   = $request->level_id;

        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        if ($camis_patient_id != "" && $user_id != "") {


            $previous_itu                                    = CamisIboxBoardRoundLevel::where('patient_id', '=', $camis_patient_id)->where('level', $level_id)->first();
            if (!$previous_itu) {
                $gov_text_before_arr                                    = CamisIboxBoardRoundLevel::where('patient_id', '=', $camis_patient_id)->first();

                $updated_data                                           = CamisIboxBoardRoundLevel::updateOrCreate(['patient_id' => $camis_patient_id], ['level' => $level_id, 'updated_by' => $user_id]);

                $functional_identity                                    = 'Patient Level';

                if ($updated_data->wasRecentlyCreated) {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                    $success_array["message"]                           = DataAddedMessage();
                    $updated_array                                      = $updated_data->getOriginal();
                    $gov_text_before                                    = array();

                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        $gov_text_after_arr                             = CamisIboxBoardRoundLevel::where('id', '=', $updated_array["id"])->first();
                        $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $level_id, $gov_text_after_arr, $functional_identity, 1);
                    }
                } else {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                    $success_array["message"]                           = DataUpdatedMessage();
                    if (count($updated_data->getChanges()) > 0) {
                        $updated_array                                  = $updated_data->getOriginal();
                        if (count($updated_array) > 0 && isset($updated_array["id"])) {
                            if ($gov_text_before_arr) {
                                $gov_text_before                        = $gov_text_before_arr->toArray();
                                $gov_text_after_arr                     = CamisIboxBoardRoundLevel::where('id', '=', $updated_array["id"])->first();
                                $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $level_id, $gov_text_after_arr, $functional_identity, 2);
                            }
                        }
                    }
                }
                $success_array["update_type"]                               = 'create';
            } else {

                $gov_text_before_arr                                    = CamisIboxBoardRoundLevel::where('patient_id', '=', $camis_patient_id)->first();

                $updated_data                                           = CamisIboxBoardRoundLevel::updateOrCreate(['patient_id' => $camis_patient_id], ['level' => 0, 'updated_by' => $user_id]);

                $functional_identity                                    = 'Patient Level';


                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundLevel::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $level_id, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }

                $success_array["update_type"]                           = 'remove';
                $success_array["message"]                               = DataRemovalMessage();
            }


            $success_array["updated_date"]                          = PredefinedDateFormatShowOnCalendarWithoutDay($date_time_now);
            $success_array["updated_time"]                          = PredefinedDateFormatForJust24Hour($date_time_now);;
            $success_array["updated_date_show"]                     = PredefinedDateFormatFor24Hour($date_time_now);
            $success_array["patient_level"]                         = $level_id;
            $success_array["status"]                                = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function UpdateTherapyFitStatus(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundTherapyFit";
        $date_time_now                                              = CurrentDateOnFormat();

        $camis_patient_id                                           = $request->camis_patient_id;
        $therapy_status                                             = $request->therapy_status;

        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        if ($camis_patient_id != "" && $user_id != "") {

            if ($therapy_status == 0) {
                $therapy_text = 'Therapy Fit No';
            } else {
                $therapy_text = 'Therapy Fit Yes';
            }


            $gov_text_before_arr                                    = CamisIboxBoardRoundTherapyFit::where('patient_id', '=', $camis_patient_id)->first();

            $updated_data                                           = CamisIboxBoardRoundTherapyFit::updateOrCreate(['patient_id' => $camis_patient_id], ['patient_therapy_fit_status' => $therapy_status, 'updated_by' => $user_id]);

            $functional_identity                                    = 'Patient Therapy Fit';

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();

                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundTherapyFit::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $therapy_text, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundTherapyFit::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $therapy_text, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }




            $success_array["updated_date"]                          = PredefinedDateFormatShowOnCalendarWithoutDay($date_time_now);
            $success_array["updated_time"]                          = PredefinedDateFormatForJust24Hour($date_time_now);;
            $success_array["updated_date_show"]                     = PredefinedDateFormatFor24Hour($date_time_now);
            $success_array["therapy_status"]                         = $therapy_status;
            $success_array["status"]                                = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }
    public function GetAnePatient(Request $request)
    {
        $sdec_ward_id = Wards::where('ward_short_name', 'RLTSDECIP')->first()->id;
        $current_sdec_patient = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->whereNotNull('camis_patient_pas_number')->where('camis_patient_ward_id', $sdec_ward_id)->pluck('camis_patient_pas_number')->toArray();
        //$ane_patients_to_sdec = CamisAeToSDECWaiting::whereNotIn('symphony_pas_number', $current_sdec_patient)->pluck('symphony_attendance_id')->toArray();

        $ane_patients_to_sdec = CamisAeToSDECWaiting::pluck('symphony_attendance_id')->toArray();


        $attendance_data  = SymphonyAneAttendanceView::when($request->filled('type'), function ($q) use ($request, $ane_patients_to_sdec) {
            if ($request->type == 'sau') {
                return $q->where('symphony_discharge_ward', 'sau inpatient');
            } else {
                return $q->whereIn('symphony_attendance_id', $ane_patients_to_sdec);
            }
        })->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();


        return view('Dashboards.Camis.WardSummary.Modals.SauPatientListData', compact('attendance_data'));
    }
    public function GetAnePatientData(Request $request)
    {

        $still_in_ane_patients_list                                         = SymphonyAttendanceView::where('symphony_still_in_ae', '=', 1)->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();


        if (in_array($request->type, ['with_dta', 'en_ed_now'])) {
            $attendance_data = array();
            foreach ($still_in_ane_patients_list as $row) {
                if ($request->type == 'with_dta') {
                    if (isset($row["symphony_request_date"])) {
                        if ($row["symphony_request_date"] != "") {
                            $attendance_data[] = $row;
                        }
                    }
                } elseif ($request->type == 'en_ed_now') {

                    $attendance_data[] = $row;
                }
            }
        } else {
            $sdec_ward_id = Wards::where('ward_short_name', 'RLTSDECIP')->first()->id;
            $current_sdec_patient = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->whereNotNull('camis_patient_pas_number')->where('camis_patient_ward_id', $sdec_ward_id)->pluck('camis_patient_pas_number')->toArray();
            $ane_patients_to_sdec = CamisAeToSDECWaiting::whereNotIn('symphony_pas_number', $current_sdec_patient)->pluck('symphony_attendance_id')->toArray();



            $attendance_data = SymphonyAneAttendanceView::when($request->filled('type'), function ($q) use ($request, $ane_patients_to_sdec) {
                if ($request->ward == 'sau') {
                    return $q->where('symphony_discharge_ward', 'sau inpatient');
                } else {
                    return $q->where('symphony_attendance_id', $ane_patients_to_sdec);
                }
            })->where('symphony_final_location', 'Patients Awaiting Allocation')->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
        }


        return view('Dashboards.Camis.WardSummary.Modals.SauPatientListData', compact('attendance_data'));
    }

    public function RemoveNurseConcernFlagAction($camis_patient_id)
    {

        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisDPVirtualPatientData";
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;

        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxDPVirtualWardPatientStatus::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxDPVirtualWardPatientStatus::updateOrCreate(['patient_id' => $camis_patient_id], ['type' => 4, 'updated_by' => $user_id]);
            $functional_identity                                    = 'DP Virtual Ward Data';

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Discharged To Ward', $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxDPVirtualWardPatientStatus::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, 'Discharged To Ward', $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;



            $history_controller                                         = new HistoryController;
            $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundPatientFlag";

            $patient_data = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $camis_patient_id)->first();

            $patient_flag_name                                          = 'ibox_patient_flag_nurse_concern';

            $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
            $success_array["message"]                                   = ErrorOccuredMessage();
            $success_array["status"]                                    = 0;

            if ($camis_patient_id != "" && $user_id != "") {
                $gov_text_before_arr                                    = CamisIboxBoardRoundPatientFlag::where('patient_id', '=', $camis_patient_id)->where('patient_flag_name', $patient_flag_name)->first();

                if (isset($gov_text_before_arr->id) && $gov_text_before_arr->id != '') {
                    $master_flag_data                                   = BoardRoundFlagList::where('patient_flag_stored_name', '=', $patient_flag_name)->first();

                    if (isset($master_flag_data->id) && $master_flag_data->id != '') {
                        $flag_set_name                                  = $master_flag_data->patient_flag_name;
                    }
                    CamisIboxBoardRoundPatientFlag::where('id', '=', $gov_text_before_arr->id)->delete();
                    $updated_data                                       = $gov_text_before_arr;
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 3);
                    $functional_identity                                = RetriveSpecificConstantSettingValues("ibox_frontend_governance_camis_patient_flag", "ibox_governance_frontend_functional_names");
                    $success_array["message"]                           = DataRemovalMessage();
                    $gov_text_before                                    = $gov_text_before_arr->toArray();
                    $gov_text_after_arr                                 = array();
                    $this->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before,  $flag_set_name, $gov_text_after_arr, $functional_identity, 3);
                    $success_array["status"]                            = 1;
                }
            }
        }
    }
}
