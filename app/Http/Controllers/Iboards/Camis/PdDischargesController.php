<?php

namespace App\Http\Controllers\Iboards\Camis;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Common\HistoryController;
use App\Http\Controllers\Controller;
use App\Models\Common\FlashMessage;
use App\Models\Common\User;
use App\Models\History\HistoryCamisIboxBoardRoundMissedPotentialDefinite;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMissedPotentialDefinite;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPotentialDefinite;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMedFit;
use App\Models\Iboards\Camis\Data\CamisIboxCalculatedDailySummary;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Master\MissedDischargedReason;
use App\Models\Iboards\Camis\Master\TaskCategory;
use App\Models\Iboards\Camis\Master\TaskGroup;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Arr;

class PdDischargesController extends Controller
{
    public function Index()
    {
        if (!CheckDashboardPermission('pd_dashboard_')) {
            Toastr::error('Permission Denied');
            return back();
        }
        return view('Dashboards.Camis.PDDischarge.Index');
    }

    public function IndexRefreshDataLoad(Request $request)
    {
        $process_array                                                  = array();
        $success_array                                                  = array();

        if ($request->discharge_day != null) {
            $process_array['discharge_day']                             = $request->discharge_day;
        } else {
            $process_array['discharge_day']                             = 'today';
        }

        if ($request->filled('ward_id')) {

            $process_array['ward_id']                                   = $request->ward_id;
        } else {
            $process_array['ward_id']                                   = 'all';
        }

        if ($request->task_type != null) {
            $process_array['task_type']                                 = $request->task_type;
        } else {
            $process_array['task_type']                                 = 'all';
        }

        if ($request->medfit_type != null) {
            $process_array['medfit_type']                                 = $request->medfit_type;
        } else {
            $process_array['medfit_type']                                 = 'all';
        }



        if ($request->discharge_type != null) {
            $process_array['discharge_type']                            = $request->discharge_type;
        } else {
            $process_array['discharge_type']                            = 'all';
        }

        if ($request->discharge_day == null) {
            if (CheckAnyPermission(['pd_dashboard_today_dashboard_view', 'pd_dashboard_tomorrow_dashboard_view'])) {
                $process_array['discharge_day']                             = 'today';
                $this->PageDataLoad($process_array, $success_array);
            } else if ((CheckAnyPermission(['pd_dashboard_today_dashboard_view']))) {

                $process_array['discharge_day']                             = 'today';

                $this->PageDataLoad($process_array, $success_array);
            } else if ((CheckAnyPermission(['pd_dashboard_tomorrow_dashboard_view']))) {

                $process_array['discharge_day']                             = 'tomorrow';
                $this->PageDataLoad($process_array, $success_array);
            } else if ((CheckAnyPermission(['pd_dashboard_missed_discharged_view']))) {

                $process_array['discharge_day']                             = 'tomorrow';
                $this->PageDataLoad($process_array, $success_array);
            } else {
                return PermissionDenied();
            }
        } else {
            $process_array['discharge_day']                             = $request->discharge_day;
            $this->PageDataLoad($process_array, $success_array);
        }
        $success_array['missed_discharge_reasons'] = MissedDischargedReason::where('status', 1)
            ->orderBy('reason_type', 'asc')
            ->orderBy('reason_text', 'asc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->id => $item->reason_type . ' - ' . $item->reason_text
                ];
            })
            ->toArray();

        $view                                                           = View::make('Dashboards.Camis.PDDischarge.IndexDataLoad', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function ReasonHistoryAjaxData(Request $request)
    {
        $missed_discharge_reasons = MissedDischargedReason::where('status', 1)
            ->orderBy('reason_type', 'asc')
            ->orderBy('reason_text', 'asc')
            ->get()
            ->toArray();
        $success_array['missed_discharge_reasons'] = [];
        foreach ($missed_discharge_reasons as $key => $value) {
            $success_array['missed_discharge_reasons'][$value['reason_type']][$value['id']] = $value['reason_text'];
        }


        $pd_data = CamisIboxBoardRoundMissedPotentialDefinite::with('MissedReason')->where('patient_id', $request->camis_patient_id)->first();
        if ($pd_data) {
            $success_array['selected_reason'] = $pd_data->missed_reason;
        } else {
            $success_array['selected_reason'] = null;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }

    public function MissedDischargedPerformance(Request $request)
    {
        if (!CheckDashboardPermission('pd_dashboard_missed_discharges_performance_view')) {
            return PermissionDenied();
        }
        $success_array                                                  = array();
        $success_array['definite_status']                                   = $request->definite_status;
        $success_array['potential_status']                                   = $request->potential_status;
        $success_array['today']                                         = Carbon::now();
        $success_array['tomorrow']                                      = $success_array['today']->addDay()->format('l');
        $success_array['day_after_tommrow']                             = $success_array['today']->addDay(1)->format('l');

        if ($request->filled('start_date')) {
            $start_date = $request->start_date;
        } else {
            $start_date = Carbon::now()->format('Y-m-d');
        }
        if ($request->filled('end_date')) {
            $end_date = $request->end_date;
        } else {
            $end_date = Carbon::now()->format('Y-m-d');
        }
        $total_discharges = CamisIboxCalculatedDailySummary::whereBetween('date', [$start_date, $end_date])->where('summary_key', 'all_ward_discharges')->sum('summary_value');
        $total_admissions = CamisIboxCalculatedDailySummary::whereBetween('date', [$start_date, $end_date])->where('summary_key', 'all_ward_admissions')->sum('summary_value');
        if ($total_admissions > 0) {
            $success_array['discharge_percentage'] = number_format(($total_discharges / $total_admissions) * 100, 2);
        } else {
            $success_array['discharge_percentage'] = 0;
        }
        $success_array['total_discharges'] = $total_discharges;
        $all_row = CamisIboxBoardRoundMissedPotentialDefinite::whereBetween('potential_definite_date', [$start_date, $end_date])->with(['MissedReason', 'Ward.PrimaryWardType']);
        $success_array['total_definite'] = (clone $all_row)->where('type', 2)->count();
        $success_array['total_potential'] = (clone $all_row)->where('type', 1)->count();

        if ($success_array['definite_status'] == 1 && $success_array['potential_status'] == 1) {
            $all_row->where(function($q){
                $q->where('type', 1)
                  ->orWhere('type', 2);
            });
        } else if ($success_array['potential_status'] == 1 && $success_array['definite_status'] == 0) {
            $all_row->where('type', 1);
        }else if ($success_array['potential_status'] == 0 && $success_array['definite_status'] == 1) {
            $all_row->where('type', 2);
        }


        $query = $all_row->get()->toArray();

        $success_array['total_failed_discharge'] = count($query);


        $all_main_group = MissedDischargedReason::groupBy('reason_type')
            ->pluck('reason_type')
            ->unique()
            ->toArray();

        $patient_by_group = array_reduce($query, function ($carry, $item) use ($request) {
            $reason_type = $item['missed_reason']['reason_type'] ?? 'Reason to be Confirmed';

            if (!isset($carry[$reason_type])) {
                $carry[$reason_type] = [
                    'patients'          => 0,
                    'lost_days'         => 0,
                    'failed_discharges' => 0,
                ];
            }

            $carry[$reason_type]['patients']++;
            $carry[$reason_type]['failed_discharges']++;

            $discharge_date = !empty($item['discharge_date'])
                ? $item['discharge_date']
                : $request->end_date;

            $lost_days = Carbon::parse($item['potential_definite_date'])
                ->diffInDays(Carbon::parse($discharge_date));

            $carry[$reason_type]['lost_days'] += $lost_days;

            return $carry;
        }, []);

        foreach ($all_main_group as $group) {
            if (!isset($patient_by_group[$group])) {
                $patient_by_group[$group] = [
                    'patients'          => 0,
                    'lost_days'         => 0,
                    'failed_discharges' => 0,
                ];
            }
        }

        $patient_by_group = array_replace(array_fill_keys($all_main_group, []), $patient_by_group);

        $success_array['categories']       = array_keys($patient_by_group);
        $success_array['patients_series']  = array_values(array_column($patient_by_group, 'patients'));
        $success_array['days_series']      = array_values(array_column($patient_by_group, 'lost_days'));
        $success_array['failed_series']    = array_values(array_column($patient_by_group, 'failed_discharges'));
        $success_array['total_lost_days'] = array_sum(array_values(array_column($patient_by_group, 'lost_days')));
        $success_array['avg_lost_days'] = array_sum(array_values(array_column($patient_by_group, 'patients'))) > 0
        ? number_format(($success_array['total_lost_days'] / array_sum(array_values(array_column($patient_by_group, 'patients')))), 2)
        : 0;

        $max_patients = max(array_column($patient_by_group, 'patients'));
        $top_groups = array_keys(array_filter($patient_by_group, fn($v) => $v['patients'] === $max_patients));

        $common_group = $top_groups[0] ?? null;
        $success_array['most_common_reason'] = count($query) > 0 ? $common_group : '--';


        $success_array['total_failed_discharges'] = array_sum(array_values(array_column($patient_by_group, 'patients')));

        if ($total_discharges > 0) {
            $success_array['failed_discharge_percentage'] = number_format(( $success_array['total_failed_discharges']/ $total_discharges) * 100, 2);
        } else {
            $success_array['failed_discharge_percentage'] = 0;
        }
        $success_array['patient_by_ward'] = ['medical' => ['patients' => 0, 'delay_days' => 0], 'surgical' => ['patients' => 0, 'delay_days' => 0], 'others' => ['patients' => 0, 'delay_days' => 0]];
        $missed_all_reason = MissedDischargedReason::where('status', 1)->get()->toArray();
        $success_array['failed_patient_by_subcategory'] = ['Reason to be Confirmed' => 0];
        $all_reasons = [];
        foreach($missed_all_reason as $reason){
            $all_reasons[$reason['reason_type']][$reason['reason_text']]['patients'] = 0;
            $all_reasons[$reason['reason_type']][$reason['reason_text']]['delay_days'] = 0;
        }
        $all_reasons['Reason to be Confirmed']['Reason to be Confirmed']['patients'] = 0;
        $all_reasons['Reason to be Confirmed']['Reason to be Confirmed']['delay_days'] = 0;
        $all_patients = [];
        foreach($query as $row){
            $main_reason = $row['missed_reason']['reason_type'] ?? 'Reason to be Confirmed';
            $sub_reason = $row['missed_reason']['reason_text'] ?? 'Reason to be Confirmed';


            $discharge_date_row = !empty($row['discharge_date'])
                ? $row['discharge_date']
                : $request->end_date;

            $lost_days_row = Carbon::parse($row['potential_definite_date'])
                ->diffInDays(Carbon::parse($discharge_date_row));

            $ward_type = $row['ward']['primary_ward_type']['ward_type'] ?? 'others';
            if(isset($success_array['patient_by_ward'][strtolower($ward_type)])){
                $success_array['patient_by_ward'][strtolower($ward_type)]['patients']++;
                $success_array['patient_by_ward'][strtolower($ward_type)]['delay_days'] += $lost_days_row;

            }
            if(isset($all_reasons[$main_reason][$sub_reason]['patients'])){
                $all_reasons[$main_reason][$sub_reason]['patients']++;
                $all_reasons[$main_reason][$sub_reason]['delay_days'] += $lost_days_row;
            }
            $patient['pas_number'] = $row['pas_number'] ?? '';
            $patient['patient_id'] = $row['patient_id'] ?? '';
            $patient['ward'] = $row['ward']['ward_name'] ?? '';
            $patient['bed'] = $row['bed'] ?? '';
            $patient['main_reason'] = $main_reason;
            $patient['sub_reason'] = $sub_reason;
            $patient['lost_days_row'] = $lost_days_row;
            $patient['pd_type'] = isset($row['type']) && (int)$row['type'] === 1 ? 'Potential' : 'Definite';
            $patient['potential_definite_date'] = PredefinedDateFormatForPD($row['potential_definite_date']);
            $patient['discharge_date'] = !empty($row['discharge_date']) ? PredefinedDateFormatForPD($row['discharge_date']) : '--';
            $all_patients[] = $patient;
        }

        $success_array['all_failed_patients'] = $all_patients;
        $success_array['failed_patient_by_subcategory'] = array_filter(array_map(function ($reasons) {
            return array_filter($reasons, fn($r) => $r['patients'] > 0);
        }, $all_reasons), fn($reasons) => !empty($reasons));

        $view                                                           = View::make('Dashboards.Camis.PDDischarge.MissedDischargedPerformance', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function MissedDischargedPatients(Request $request)
    {
        if (!CheckDashboardPermission('pd_dashboard_missed_discharged_view')) {
            return PermissionDenied();
        }
        $success_array                                                  = array();
        $success_array['today']                                         = Carbon::now();
        $success_array['tomorrow']                                      = $success_array['today']->addDay()->format('l');
        $success_array['day_after_tommrow']                             = $success_array['today']->addDay(1)->format('l');
        $ward_list = Wards::with('PrimaryWardType')->where('status', 1)

            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ward_name', 'asc')
            ->get()->toArray();

        $medical_wards = [];
        $surgical_wards = [];
        $other_wards = [];
        foreach ($ward_list as $item) {
            if (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'medical') {
                $medical_wards[] = $item;
            } elseif (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'surgical') {
                $surgical_wards[] = $item;
            } elseif (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'others') {
                $other_wards[] = $item;
            }
        }
        $data = $request->validate([
            'ward_id_missed'      => ['array'],
            'ward_id_missed.*'    => ['integer'],
            'definite'  => ['required', 'integer'],
            'potential'   => ['required', 'integer'],
            'date' => ['required', 'date_format:Y-m-d'],
        ]);
        $wardIds = collect($ward_list ?? [])->pluck('id')->all();
        $query = CamisIboxBoardRoundMissedPotentialDefinite::with(['Ward' => function ($query) {
            $query->select('id', 'ward_name');
        }, 'MissedReason'])
            ->whereNotNull('patient_id')
            ->whereIn('ward_id', $wardIds)
            ->whereDate('potential_definite_date', $data['date']);
        if (!empty($data['ward_id_missed'])) {
            $query->whereIn('ward_id', $data['ward_id_missed']);
        }

        $success_array['total_definite'] = (clone $query)->where('type', 2)->count();
        $success_array['total_potential'] = (clone $query)->where('type', 1)->count();



        if ($data['definite'] == 1 && $data['potential'] == 1) {
        } else {
            if ($data['definite'] == 0 && $data['potential'] == 0) {
                $query->where('type', 0);
            } else {

                if (!empty($data['definite']) && $data['definite'] == '1') {
                    $query->where('type', 2);
                } elseif (!empty($data['potential']) && $data['potential'] == '1') {
                    $query->where('type', 1);
                }
            }
        }





        $all_patients = $query->get()->toArray();

        $success_array['medical_wards'] = $medical_wards;
        $success_array['surgical_wards'] = $surgical_wards;
        $success_array['other_wards'] = $other_wards;
        $success_array['total_patients'] = $all_patients;
        $patients = array_reduce($all_patients, function ($carry, $item) {
            $ward_name = $item['ward']['ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($patients);
        $success_array['patient_details'] = $patients;
        $params = [
            'ward_id_missed'     => collect($data['ward_id_missed'] ?? [])
                ->filter()
                ->implode(','),
            'definite' => $data['definite'] ?? null,
            'potential'  => $data['potential'] ?? null,
            'date'  => $data['date'] ?? null,
        ];

        $params = Arr::where($params, fn($v) => $v !== null && $v !== '');

        $success_array['export_url'] = route('pd.missed.export', $params);
        $view                                                           = View::make('Dashboards.Camis.PDDischarge.MissedDischarged', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }


    public function MissedExport(Request $request)
    {
        if (!CheckDashboardPermission('pd_dashboard_missed_discharged_view')) {
            Toastr::error('Permission Denied');
            return back();
        }


        $ward_list = Wards::with('PrimaryWardType')
            ->where('status', 1)
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ward_name', 'asc')
            ->get()
            ->toArray();


        $v = Validator::make($request->all(), [
            'ward_id_missed' => [
                'nullable',
                function ($attr, $value, $fail) {
                    if (is_array($value)) {
                        foreach ($value as $v) {
                            if (!is_numeric($v)) {
                                return $fail('ward_id_missed must contain integers.');
                            }
                        }
                    } elseif (is_string($value)) {
                        if (!preg_match('/^\s*\d+(\s*,\s*\d+)*\s*$/', $value)) {
                            return $fail('ward_id_missed must be a comma-separated list of integers.');
                        }
                    } elseif (!is_null($value)) {
                        return $fail('ward_id_missed must be an array or a comma-separated string.');
                    }
                },
            ],
            'definite'  => ['required', 'integer'],
            'potential'   => ['required', 'integer'],
            'date'               => ['nullable', 'date_format:Y-m-d'],
        ]);

        if ($v->fails()) {
            Toastr::error($v->errors()->first());
            return back()->withErrors($v)->withInput();
        }

        $data = $v->validated();
        $data['date'] = $data['date'] ?? Carbon::yesterday()->format('Y-m-d');

        $wardIdInput = $data['ward_id_missed'] ?? null;
        $wardIdList = collect(is_string($wardIdInput) ? explode(',', $wardIdInput) : (array)$wardIdInput)
            ->map(fn($v) => trim((string)$v))
            ->filter(fn($v) => $v !== '' && ctype_digit($v))
            ->map(fn($v) => (int)$v)
            ->unique()
            ->values()
            ->all();

        $validWardIds = collect($ward_list)->pluck('id')->map(fn($v) => (int)$v)->all();
        $wardIdList   = array_values(array_intersect($wardIdList, $validWardIds));


        $query = CamisIboxBoardRoundMissedPotentialDefinite::with(['Ward' => function ($query) {
            $query->select('id', 'ward_name');
        }, 'MissedReason'])
            ->whereNotNull('patient_id')
            ->whereIn('ward_id', $validWardIds)
            ->whereDate('potential_definite_date', $data['date']);
        if (!empty($wardIdList)) {
            $query->whereIn('ward_id', $wardIdList);
        }

        if ($data['definite'] == 1 && $data['potential'] == 1) {
        } else {
            if ($data['definite'] == 0 && $data['potential'] == 0) {
                $query->where('type', 0);
            } else {

                if (!empty($data['definite']) && $data['definite'] == '1') {
                    $query->where('type', 2);
                } elseif (!empty($data['potential']) && $data['potential'] == '1') {
                    $query->where('type', 1);
                }
            }
        }







        $all_patients = $query->get()
            ->toArray();


        $heading = ["Ward", "Bay & Bed", "Name", "PAS Number", "Flag Date", "Discharge Date", "Missed Discharged Reason"];

        $dischargeList = collect($all_patients)->map(function ($p) {
            $typeLabel = (isset($p['type']) && (int)$p['type'] === 1)
                ? 'Potential'
                : 'Definite';

            $dateStr = isset($p['potential_definite_date'])
                ? PredefinedDateFormatForPD($p['potential_definite_date'])
                : '';

            $reasonType = ['missed_reason']['reason_type'] ?? '';
            $reasonText = ['missed_reason']['reason_text'] ?? '';
            $reason = trim($reasonType . ($reasonType && $reasonText ? ' - ' : '') . $reasonText);

            return [
                $p['ward']['ward_name'] ?? '',
                $p['bed'] ?? '',
                $p['name'] ?? '',
                $p['pas_number'] ?? '',
                trim($typeLabel . ($dateStr ? ' - ' . $dateStr : '')),
                !empty($p['discharge_date']) ? PredefinedDateFormatFor24Hour($p['discharge_date']) : '--',
                $reason,
            ];
        })->values();

        $name = 'Missed Discharged';

        return ExportFunction($dischargeList, $heading, $name);
    }


    public function SaveMissedReason(Request $request)
    {
        $history_controller                                         = new HistoryController;
        $history_modal                                              = "App\Models\History\HistoryCamisIboxBoardRoundMissedPotentialDefinite";
        $date_time_now                                              = CurrentDateOnFormat();
        $camis_patient_id                                           = $request->camis_patient_id;
        $patient_review_reason                                     = $request->patient_review_reason;
        $user_id                                                    = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"]                                   = ErrorOccuredMessage();
        $success_array["status"]                                    = 0;
        $success_array["updated_date"]                              = date('jS M Y, H:i', strtotime($date_time_now));


        $missed_discharge_reasons = MissedDischargedReason::where('status', 1)
            ->orderBy('reason_type', 'asc')
            ->orderBy('reason_text', 'asc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->id => $item->reason_type . ' - ' . $item->reason_text
                ];
            })
            ->toArray();


        $success_array["patient_review_reason"]                     = $missed_discharge_reasons[$patient_review_reason] ?? '';
        $ward_summary                                               = new WardSummaryController();
        if ($camis_patient_id != "" && $user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundMissedPotentialDefinite::where('patient_id', '=', $camis_patient_id)->first();
            $updated_data                                           = CamisIboxBoardRoundMissedPotentialDefinite::updateOrCreate(['patient_id' => $camis_patient_id], ['missed_reason' => $patient_review_reason, 'updated_by' => $user_id]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
            $functional_identity                                    = 'Missed Date Potential/Definite Status';

            if ($updated_data->wasRecentlyCreated) {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"])) {
                    $gov_text_after_arr                             = CamisIboxBoardRoundMissedPotentialDefinite::where('id', '=', $updated_array["id"])->first();
                    $ward_summary->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_review_reason, $gov_text_after_arr, $functional_identity, 1);
                }
            } else {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0) {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"])) {
                        if ($gov_text_before_arr) {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundMissedPotentialDefinite::where('id', '=', $updated_array["id"])->first();
                            $ward_summary->GovernanceBoardRoundUpdatePreCall($camis_patient_id, $gov_text_before, $patient_review_reason, $gov_text_after_arr, $functional_identity, 2);
                        }
                    }
                }
            }
            $success_array["status"]                                    = 1;
        }
        return ReturnArrayAsJsonToScript($success_array);
    }


    public function ReasonHistoryData(Request $request)
    {
        $patient_info = CamisIboxWardPatientInformationWithBedDetailsView::where('camis_patient_id', $request->camis_patient_id)->first();
        $history_data = HistoryCamisIboxBoardRoundMissedPotentialDefinite::where('patient_id', $request->camis_patient_id)->where('updated_at', '>=', $patient_info->camis_patient_admission_date_time)->whereNotNull('missed_reason')->orderBy('created_at', 'desc')->get();
        $users = User::pluck('username', 'id')->toArray();
        $view                                                           = View::make('Dashboards.Camis.PDDischarge.ModalData', compact('history_data', 'users'));
        $sections                                                       = $view->render();
        return $sections;
    }
    public function PageDataLoad(&$process_array, &$success_array)
    {

        $success_array                                  = array();
        $flash_message                                  = FlashMessage::where('status', 1)->first();
        $success_array["script_error_message"]          = ErrorOccuredMessage();
        $success_array["flash_message"]                 = $flash_message != null ? $flash_message->message : '';
        $success_array['today']                                         = Carbon::now();
        $success_array['tomorrow']                                      = $success_array['today']->addDay()->format('l');
        $success_array['day_after_tommrow']                             = $success_array['today']->addDay(1)->format('l');
        $success_array['show_on_ward_summary_status_check']             = BoardRoundFlagList::where('show_on_normal_ward', 1)->pluck('patient_flag_name', 'patient_flag_stored_name')->toArray();
        $ward_list = Wards::with('PrimaryWardType')->where('status', 1)

            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->orderBy('ward_name', 'asc')
            ->get()->toArray();

        $medical_wards = [];
        $surgical_wards = [];
        $other_wards = [];
        foreach ($ward_list as $item) {
            if (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'medical') {
                $medical_wards[] = $item;
            } elseif (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'surgical') {
                $surgical_wards[] = $item;
            } elseif (isset($item['primary_ward_type']['ward_type']) && strtolower($item['primary_ward_type']['ward_type']) == 'others') {
                $other_wards[] = $item;
            }
        }
        $success_array['medical_wards'] = $medical_wards;
        $success_array['surgical_wards'] = $surgical_wards;
        $success_array['other_wards'] = $other_wards;
        if ($process_array['discharge_type'] == 'all') {
            if ($process_array['discharge_day'] == 'today') {
                $type  = [1, 2];
                $date = Carbon::now()->toDateString();
            } elseif ($process_array['discharge_day'] == 'tomorrow') {
                $type  = [1, 2];
                $date = Carbon::now()->addDay()->toDateString();
            } elseif ($process_array['discharge_day'] == 'day_after_tomorrow') {
                $type  = [1, 2];
                $date = Carbon::now()->addDay(2)->toDateString();
            }
        } else {
            if ($process_array['discharge_type'] == 'potential') {
                $type  = [1];
            } else {
                $type  = [2];
            }
            if ($process_array['discharge_day'] == 'today') {

                $date = Carbon::now()->toDateString();
            } elseif ($process_array['discharge_day'] == 'tomorrow') {

                $date = Carbon::now()->addDay()->toDateString();
            } elseif ($process_array['discharge_day'] == 'day_after_tomorrow') {

                $date = Carbon::now()->addDay(2)->toDateString();
            }
        }

        $success_array['task_group']   = TaskGroup::where('status', 1)->latest()->get();

        if ($process_array['task_type'] == 'all') {
            $category_id = TaskCategory::where('status', 1)->pluck('id')->toArray();
        } else {
            $category_id = [2];
        }
        $definite = CamisIboxBoardRoundPotentialDefinite::whereDate('potential_definite_date', $date)
            ->whereIn('type', $type)
            ->pluck('patient_id')
            ->toArray();

        $site_task = CamisIboxBoardRoundPatientTasks::where('task_category', 2)->where('task_completed_status', 0)
            ->where('task_not_applicable_status', 0)
            ->pluck('patient_id')
            ->toArray();


        $medfit_yes = CamisIboxBoardRoundMedFit::where('patient_medically_fit_status', 1)
            //->whereDate('potential_date', '=', $date)
            ->pluck('patient_id')
            ->toArray();

        if ($process_array['medfit_type'] == 1) {
            $patient_id = array_intersect($definite, $medfit_yes);
        } elseif ($process_array['medfit_type'] == 0) {
            $patient_id = array_diff($definite, $medfit_yes);
        } else {
            $patient_id = $definite;
        }

        if ($process_array['ward_id'] == 'all') {
            $ward_id = array_column($ward_list, 'id');
        } else {
            $ward_id = $process_array['ward_id'];
        }

        $patient_array = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_ward_id', $ward_id)
            ->when($process_array['task_type'] != 'all', function ($q) use ($site_task) {

                return $q->whereIn('camis_patient_id', $site_task);
            })

            ->with([
                'PotentialDefinite',

                'BoardRoundMedicallyFitData' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment');
                },
                'BoardRoundEstimatedDischargeDate' => function ($q) {
                    $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
                },
                'BoardRoundPatientTasks' => function ($q) {
                    $q->where('task_completed_status', 0)
                        ->where('task_not_applicable_status', 0)->orderBy('created_at', 'desc');
                },
                'BoardRoundPatientTasks.PatientTaskGroup',
                'BoardRoundPatientTasks.PatientTaskCategory',
                'PotentialDefinite',
                'PatientVitalPacInfo',
                'PatientWiseFlags',
                'BoardRoundEdn',
                'BoardRoundTto'

            ])->whereIn('camis_patient_id', $patient_id)->withCount(['BoardRoundPatientTasks' => function ($q) {
                $q->where('task_completed_status', 0)
                    ->where('task_not_applicable_status', 0);
            }])
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();

        $ward_wise_patients = array_reduce($patient_array, function ($carry, $item) {
            $ward_name = $item['ibox_ward_name'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($ward_wise_patients);

        $process_array['today']                                         = Carbon::now();
        $success_array['tomorrow']                                      = $process_array['today']->addDay()->format('l');
        $success_array['day_after_tommrow']                             = $process_array['today']->addDay(1)->format('l');
        $success_array['today'] =  Carbon::now()->format('l');
        $success_array['date'] =  Carbon::now();
        $success_array['total_patients']      = $patient_array;
        $success_array['patient_details']     = $ward_wise_patients;
        $success_array['discharge_type']   = $process_array['discharge_type'];

        $success_array['categorys']         = $category_id;
        $success_array['tab_type']         =  $process_array['discharge_day'];
        return $success_array;
    }
}
