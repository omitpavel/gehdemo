<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Controller;
use App\Models\History\HistoryCamisIboxBoardWardRound;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\Master\WardType;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsFullList;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Brian2694\Toastr\Facades\Toastr;
class BoardRoundReportController extends Controller
{
    public function Index(Request $request)
    {
        if(!CheckDashboardPermission('board_round_dashboard_')){
            Toastr::error('Permission Denied');
            return back();
        }
        return view('Dashboards.Camis.BoardRound.Index');
    }

    public function IndexRefreshDataLoad(Request $request)
    {

        $process_array                                                  = array();
        $success_array                                                  = array();

        if($request->start_date != null && $request->end_date != null){
            $process_array['start_date'] = $request->start_date;
            $process_array['end_date'] = $request->end_date;

        }

        if($request->filled('ward_id')){
            $process_array['ward_id']                                   = $request->ward_id;
        } else {
            $process_array['ward_id']                                   = 'all';
        }

        if($request->tab_type != null){
            $process_array['tab_type']                                   = $request->tab_type;
        } else {
            $process_array['tab_type']                                   = '';
        }
        if ($request->attendence_week_data != null)
        {
            $process_array['attendence_week_data']                       = $request->attendence_week_data;
        }else{
            $process_array['attendence_week_data']                       = Carbon::now()->startOfWeek()->format('Y-m-d');
        }



        if($process_array['tab_type'] == ''){
            if(CheckAnyPermission(['board_round_dashboard_attendance_view','board_round_dashboard_today_view','board_round_dashboard_all_view','board_round_dashboard_current_week_view','board_round_dashboard_week_summary_view'])){
                $process_array['tab_type']                                   = 'current';

            } else if((CheckAnyPermission(['board_round_dashboard_current_week_view'])) ){
                $process_array['tab_type']                                   = 'current';
            }


            else if((CheckAnyPermission(['board_round_dashboard_week_summary_view'])) ){
                $process_array['tab_type']                                   = 'week';


            }
            elseif(CheckAnyPermission(['board_round_dashboard_month_summary_view'])){
                $process_array['tab_type']                                   = 'month';

            }
            else if((CheckAnyPermission(['board_round_dashboard_attendance_view'])) ){
                $process_array['tab_type']                                   = 'attendence';


            }
            else if((CheckAnyPermission(['board_round_dashboard_today_view'])) ){
                $process_array['tab_type']                                   = 'today';
            }
            else if((CheckAnyPermission(['board_round_dashboard_all_view']))){
                $process_array['tab_type']                                   = 'all';
            }
            else{
                return PermissionDenied();
            }
        }


        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        if ($process_array['tab_type'] == 'current')
        {
            $process_array['week_start']                                 = Carbon::now()->startOfWeek()->format('Y-m-d');
            $process_array['week_end']                                   = Carbon::now()->endOfWeek()->format('Y-m-d');
        }elseif($process_array['tab_type'] == 'week'){
            if ($request->attendence_week_date != null)
            {
                $process_array['attendence_week_date']                       = Carbon::parse($request->attendence_week_date);
            }else{
                $process_array['attendence_week_date']                       = Carbon::now();
            }
            $process_array['week_start']                                 =  $process_array['attendence_week_date']->startOfWeek()->format('Y-m-d');
            $process_array['week_end']                                   =  $process_array['attendence_week_date']->endOfWeek()->format('Y-m-d');
        }elseif($process_array['tab_type'] == 'month'){


            $process_array['include_weekend']                               =  $request->include_weekend;

            if ($request->filled('selected_date')) {
                $process_array['selected_date']                                 =  $request->selected_date;
            } else {
                $process_array['selected_date'] = date('F Y');
            }
        }
        $this->PageDataLoad($process_array, $success_array);

        $return_value = match ($process_array['tab_type']) {
            "current" => 'IndexDataLoadTab1',
            'month' => 'IndexDataLoadTab6',
            'week' => 'IndexDataLoadTab2',
            'attendence' => 'IndexDataLoadTab3',
            'today' => 'IndexDataLoadTab4',
            'all' => 'IndexDataLoadTab5'
        };


        $view                                                           = View::make('Dashboards.Camis.BoardRound.'.$return_value, compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;

    }
    private function WardToIDArrayList($id){
        $wards = Wards::whereIn('id', $id)->where('status', 1)
            ->where('show_on_boardround_dashboard', 1)
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->pluck('id')->toArray();
            return $wards;
    }
    public function PageDataLoad(&$process_array, &$success_array)
    {

        $success_array                                  = array();

        $success_array["script_error_message"]          = ErrorOccuredMessage();
        $success_array['wards']                         = Wards::where('status',1)->where('show_on_boardround_dashboard', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->orderBy('ward_name', 'asc')->get();
        if($process_array['ward_id'] != 'all'){
            $success_array['selected_ward_id']          = $this->WardToIDArrayList($process_array['ward_id']);
        } else {
            $success_array['selected_ward_id']          = $success_array['wards']->where('show_on_boardround_dashboard', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('id')->toArray();
        }
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $now = Carbon::now();
        $last12Weeks = [];

        $all_wards_list = Wards::where('status',1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('show_on_boardround_dashboard', 1)->orderBy('ward_name', 'asc')->pluck('ward_name', 'id')->toArray();
        $all_wards_type = Wards::where('status',1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('show_on_boardround_dashboard', 1)->orderBy('ward_name', 'asc')->pluck('ward_type_primary', 'id')->toArray();

        $master_ward_type = WardType::where('status',1)->pluck('ward_type', 'id')->toArray();


        $all_wards = array_keys($all_wards_list);

        for ($i = 0; $i < 12; $i++) {
            $startOfWeek = $now->copy()->subWeeks($i)->startOfWeek();
            $last12Weeks[] = $startOfWeek;
        }
        $success_array['last_12_weeks'] = $last12Weeks;

        if (($process_array['tab_type'] == 'current') || ($process_array['tab_type'] == 'week')){

            $weekDays = [];
            for ($i = 0; $i < 5; $i++) {
                $weekDays[] = Carbon::parse($process_array['week_start'])->copy()->addDays($i)->format('Y-m-d');
            }



            $board_round_history  = HistoryCamisIboxBoardWardRound::select(
                'ward_id','history_id','status',\DB::raw('MAX(board_round_session) AS board_round_session'),\DB::raw('MIN(history_id) AS min_history_id'),
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
            ->whereIn(\DB::raw('DATE(created_at)'), $weekDays)
            ->groupBy('history_id','ward_id', 'status', \DB::raw('DATE(created_at)'))
            ->orderBy('history_id', 'asc')
            ->get();
            $date_range = $weekDays;
            $board_round_chart_results = [];
             foreach ($all_wards as $ward_id) {
                foreach ($date_range as $date) {

                    $ward_type = strtolower($master_ward_type[$all_wards_type[$ward_id]]);



                    $ward_name = $all_wards_list[$ward_id];
                    $board_round_chart_results[$ward_type][$ward_name][$date] = [
                        'am' => '00:00',
                        'pm' => '00:00',
                        'am_total' => 0,
                        'pm_total' => 0,
                        'am_percentage_total' => 0,
                        'pm_percentage_total' => 0,
                        'total' => 0,
                        'date' => $date,
                        'am_status' => 0,
                        'pm_status' => 0,
                        'board_round_session' => '',
                        'ward_id' => $ward_id,
                        'ward_name' => $all_wards_list[$ward_id],
                    ];
                }
            }
            foreach ($board_round_history as $result) {


                $am_total = $result->am_total;
                $pm_total = $result->pm_total;
                $pm_percentage_total = ($result->pm_total != 0) ? $result->pm_percentage_total / $result->pm_total : 0;
                $am_percentage_total = ($result->am_total != 0) ? $result->am_percentage_total / $result->am_total : 0;
                if(!isset($all_wards_list[$result->ward_id])){
                    continue;
                }
                $ward_name = $all_wards_list[$result->ward_id];

                $ward_type = strtolower($master_ward_type[$all_wards_type[$result->ward_id]]);



                $am_status = $result->am_time != '00:00' && $result->status == 1 ? 1 : 2;
                $pm_status = $result->pm_time != '00:00' && $result->status == 1 ? 1 : 2;


                if ($am_total != 0) {
                    $existing_am_status = isset($board_round_chart_results[$ward_type][$ward_name][$result->date]['am_status'])
                        && $board_round_chart_results[$ward_type][$ward_name][$result->date]['am_status'] == 1;

                    if (!$existing_am_status) {
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['am'] = $result->am_time;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['am_percentage_total'] = $am_percentage_total;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['am_total'] = $am_total;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['am_status'] = $am_status;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['total'] = (($am_percentage_total + $pm_percentage_total) / 2);
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['date'] = $result->date;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['status'] = $result->status;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['ward_name'] = $all_wards_list[$result->ward_id];
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['ward_id'] = $result->ward_id;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['board_round_session'] = $result->board_round_session;
                    }
                }

                if ($pm_total != 0) {
                    $existing_pm_status = isset($board_round_chart_results[$ward_type][$ward_name][$result->date]['pm_status'])
                        && $board_round_chart_results[$ward_type][$ward_name][$result->date]['pm_status'] == 1;

                    if (!$existing_pm_status) {
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['pm'] = $result->pm_time;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['pm_percentage_total'] = $pm_percentage_total;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['pm_total'] = $pm_total;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['pm_status'] = $pm_status;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['status'] = $result->status;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['total'] = (($am_percentage_total + $pm_percentage_total) / 2);
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['date'] = $result->date;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['ward_name'] = $all_wards_list[$result->ward_id];
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['ward_id'] = $result->ward_id;
                        $board_round_chart_results[$ward_type][$ward_name][$result->date]['board_round_session'] = $result->board_round_session;
                    }
                }
                if($board_round_chart_results[$ward_type][$ward_name][$result->date]['am'] != '00:00' || $board_round_chart_results[$ward_type][$ward_name][$result->date]['pm'] != '00:00'){
                    $board_round_chart_results[$ward_type][$ward_name][$result->date]['total'] = 20;
                }


            }

            $success_array['weekly_days'] = $weekDays;
            $success_array['weekly_summery_data'] = $board_round_chart_results;
        }

        if($process_array['tab_type'] == 'month'){
            $current_date = Carbon::now();

            $last_12_months = [];
            for ($i = 0; $i < 12; $i++) {
                $last_12_months[] = $current_date->format('F Y');
                $current_date->subMonth();
            }
            $success_array['last_12_month'] = $last_12_months;
            $carbon_date = Carbon::createFromFormat('F Y', $process_array['selected_date']);
            $success_array['selected_date'] = $process_array['selected_date'];
            $success_array['include_weekend'] = $process_array['include_weekend'];

            $month = $carbon_date->format('m');
            $year = $carbon_date->format('Y');
            $days = $this->GetDaysOfMonth($year, $month, $process_array['include_weekend']);
            $records = HistoryCamisIboxBoardWardRound::whereIn(\DB::raw("DATE(updated_at)"), $days)
                        //->selectRaw("id,ward_id,status, DATE_FORMAT(updated_at, '%Y-%m-%d') as updated_at")
                        ->selectRaw("id,ward_id,status, updated_at")
                        ->get()->toArray();

            $am_records = ArrayFilter($records, function($item) {
                $updatedAt = Carbon::parse($item['updated_at']);
                return $updatedAt->hour < 12;
            });

            $pm_records = ArrayFilter($records, function($item) {
                $updatedAt = Carbon::parse($item['updated_at']);
                return $updatedAt->hour >= 12;
            });
            $all_wards_list = Wards::with('PrimaryWardType')->where('status',1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('show_on_boardround_dashboard', 1)->orderBy('ward_name', 'asc')->get()->toArray();
            $month_report = [];
            foreach($all_wards_list as $ward){
                $ward_type = strtolower($ward['primary_ward_type']['ward_type']);
                $month_report[$ward_type][$ward['ward_name']]['completed']['am'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['completed']['pm'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['partial']['am'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['partial']['pm'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['not_start']['am'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['not_start']['pm'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['not_start']['total'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['percent']['am'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['percent']['pm'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['percent']['total'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['percent']['am_percent'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['percent']['pm_percent'] = 0;
                $month_report[$ward_type][$ward['ward_name']]['percent']['total_percent'] = 0;
            }

            foreach($days as $date){
                foreach($all_wards_list as $ward){
                    $ward_type = strtolower($ward['primary_ward_type']['ward_type']);

                    $am_record_date_ward_complete = ArrayFilter($am_records, function($item) use($date, $ward){
                        $update_date = date('Y-m-d', strtotime($item['updated_at']));
                        return ($date == $update_date && $item['ward_id'] == $ward['id'] && $item['status'] == 1);
                    });
                    $am_record_date_ward_partial = ArrayFilter($am_records, function($item) use($date, $ward){
                        $update_date = date('Y-m-d', strtotime($item['updated_at']));
                        return ($date == $update_date && $item['ward_id'] == $ward['id'] && $item['status'] == 0);
                    });

                    $pm_record_date_ward_complete = ArrayFilter($pm_records, function($item) use($date, $ward){
                        $update_date = date('Y-m-d', strtotime($item['updated_at']));
                        return ($date == $update_date && $item['ward_id'] == $ward['id'] && $item['status'] == 1);
                    });
                    $pm_record_date_ward_partial = ArrayFilter($pm_records, function($item) use($date, $ward){
                        $update_date = date('Y-m-d', strtotime($item['updated_at']));
                        return ($date == $update_date && $item['ward_id'] == $ward['id'] && $item['status'] == 0);
                    });

                    if(count($am_record_date_ward_complete) > 0){
                        $month_report[$ward_type][$ward['ward_name']]['completed']['am']++;
                        $month_report[$ward_type][$ward['ward_name']]['percent']['am_percent']++;
                        $month_report[$ward_type][$ward['ward_name']]['percent']['am'] += 20;
                    } elseif(count($am_record_date_ward_complete) < 1 && count($am_record_date_ward_partial) > 0){
                        $month_report[$ward_type][$ward['ward_name']]['partial']['am']++;
                        $month_report[$ward_type][$ward['ward_name']]['percent']['am_percent']++;
                        $month_report[$ward_type][$ward['ward_name']]['percent']['am'] += 20;
                    } else {
                        $month_report[$ward_type][$ward['ward_name']]['not_start']['am']++;
                    }

                    if(count($pm_record_date_ward_complete) > 0){
                        $month_report[$ward_type][$ward['ward_name']]['completed']['pm']++;
                        $month_report[$ward_type][$ward['ward_name']]['percent']['pm_percent']++;
                        $month_report[$ward_type][$ward['ward_name']]['percent']['pm'] += 20;
                    } elseif(count($pm_record_date_ward_complete) < 1 && count($pm_record_date_ward_partial) > 0){
                        $month_report[$ward_type][$ward['ward_name']]['partial']['pm']++;
                        $month_report[$ward_type][$ward['ward_name']]['percent']['pm_percent']++;
                        $month_report[$ward_type][$ward['ward_name']]['percent']['pm'] += 20;
                    } else {
                        $month_report[$ward_type][$ward['ward_name']]['not_start']['pm']++;
                    }


                    if(count($am_record_date_ward_complete) < 1 && count($am_record_date_ward_partial) < 1 && count($pm_record_date_ward_complete) < 1 && count($pm_record_date_ward_partial) < 1){

                        $month_report[$ward_type][$ward['ward_name']]['not_start']['total']++;
                    }

                    if(count($am_record_date_ward_complete) > 0 || count($am_record_date_ward_partial) > 0 || count($pm_record_date_ward_complete) > 0 || count($pm_record_date_ward_partial) > 0){
                        $month_report[$ward_type][$ward['ward_name']]['percent']['total'] += 20;
                        $month_report[$ward_type][$ward['ward_name']]['percent']['total_percent']++;
                    }
                    $month_report[$ward_type][$ward['ward_name']]['percent']['pm'] = ceil(($month_report[$ward_type][$ward['ward_name']]['percent']['pm_percent'] / count($days)) * 100);
                    $month_report[$ward_type][$ward['ward_name']]['percent']['am'] = ceil(($month_report[$ward_type][$ward['ward_name']]['percent']['am_percent'] / count($days)) * 100);
                    $month_report[$ward_type][$ward['ward_name']]['percent']['total'] = ceil(($month_report[$ward_type][$ward['ward_name']]['percent']['total_percent'] / count($days)) * 100);

                }
            }
            $success_array['number_of_days'] = count($days);
            uksort($month_report, function($a, $b) {
                $priority = ['medical', 'surgical'];
                if (in_array($a, $priority) && !in_array($b, $priority)) {
                    return -1;
                } elseif (!in_array($a, $priority) && in_array($b, $priority)) {
                    return 1;
                }

                return strcmp($a, $b);
            });
            $success_array['month_report'] = $month_report;
        }

        if ($process_array['tab_type'] == 'attendence'){

            $attendance_query = HistoryCamisIboxBoardWardRound::select('ward_id')
            ->whereBetween(\DB::raw('DATE(created_at)'), [$process_array['attendence_week_data'], \DB::raw('DATE_ADD(created_at, INTERVAL 6 DAY)')])
            ->groupBy('ward_id');

            $frontend_roles = [
                'Matron' => ['title' => 'Matron', 'min_value' => 1],
                'Nursing' => ['title' => 'Nursing Rep', 'min_value' => 5],
                'Consultant' => ['title' => 'Consultant/Reg', 'min_value' => 5],
                'Junior Doctor' => ['title' => 'Junior Dr', 'min_value' => 5],
                'Therapies' => ['title' => 'Therapies','min_value' => 5],
                'CDT' => ['title' => 'CDT', 'min_value' => 1],
            ];

            foreach (array_keys($frontend_roles) as $role) {
                if (strtolower($role) === 'nursing') {
                    $attendance_query->addSelect(\DB::raw("SUM(CASE WHEN FIND_IN_SET('Bay Nurse', role) OR FIND_IN_SET('Complex Discharge Nurse', role) OR FIND_IN_SET('Specialist Nurse', role) THEN 1 ELSE 0 END) as `$role`"));
                } else {
                    $attendance_query->addSelect(\DB::raw("SUM(CASE WHEN FIND_IN_SET('$role', role) THEN 1 ELSE 0 END) as `$role`"));
                }
            }

            $attendance_query = $attendance_query->get()->toArray();
            $attendance_results = [];
            foreach ($all_wards as $ward_id) {
                foreach (array_keys($frontend_roles) as $role) {
                    $ward_name = $all_wards_list[$ward_id];
                    $ward_type = strtolower($master_ward_type[$all_wards_type[$ward_id]]);

                    $attendance_results[$ward_type][$ward_name] = ['ward_id' => $ward_id] + array_fill_keys(array_keys($frontend_roles), 0);
                }
            }

            foreach ($attendance_query as $result) {
                if(!isset($all_wards_list[$result['ward_id']])){
                    continue;
                }
                $ward_id = $result['ward_id'];
                $ward_name = $all_wards_list[$result['ward_id']];
                $ward_type = strtolower($master_ward_type[$all_wards_type[$ward_id]]);
                $attendance_results[$ward_type][$ward_name] = $result;

            }

            $success_array['roles'] = array_keys($frontend_roles);
            $success_array['table_heads'] = $frontend_roles;
            $success_array['attendance'] = $attendance_results;

        }

       elseif($process_array['tab_type'] == 'today')
        {
            $success_array['ward_round_history']        = HistoryCamisIboxBoardWardRound::latest()->whereIn('ward_id', $success_array['selected_ward_id'])->whereDate('created_at', Carbon::today())->get();
        }elseif($process_array['tab_type'] == 'all'){

             $all_tab_data       = HistoryCamisIboxBoardWardRound::latest()->whereIn('ward_id', $success_array['selected_ward_id']);
            if($process_array['start_date'] == $process_array['end_date']){
                $all_tab_data =  $all_tab_data->whereDate('created_at', $process_array['start_date']);
            } else {
                $all_tab_data =  $all_tab_data->whereBetween('created_at',[$process_array['start_date'],$process_array['end_date']]);
            }

            $success_array['ward_round_history'] = $all_tab_data->get();

        }
        $success_array['tab_type']  = $process_array['tab_type'];
        return $success_array;


    }

    public function FetchPatialPatientList(Request $request){
        $ward_id = $request->ward_id;
        $session = $request->session;
        $date = $request->date;
        $time = $request->time;
        $missed_board_round_patients = HistoryCamisIboxBoardWardRound::whereDate('created_at', $date)->where('ward_id', $ward_id)->where(function ($query) use ($time) {
            if ($time === 'am') {
                $query->whereTime('created_at', '>=', '00:00:00')
                      ->whereTime('created_at', '<=', '11:59:59');
            } elseif ($time === 'pm') {
                $query->whereTime('created_at', '>=', '12:00:00')
                      ->whereTime('created_at', '<=', '23:59:59');
            }
        })->select('missed_patients')->orderBy('created_at', 'desc')->first();

        if(isset($missed_board_round_patients->missed_patients) && !empty($missed_board_round_patients->missed_patients) && is_array(json_decode($missed_board_round_patients->missed_patients, true))){
            $patient = json_decode($missed_board_round_patients->missed_patients, true);
            $has_long_key = false;
            foreach ($patient as $key) {
                if (isset($key['bed'])) {
                    $has_long_key = true;
                    break;
                }
            }
            if ($has_long_key) {
                $patients_list = $patient;
            } else {
                $patients_list = CamisIboxWardPatientInformationWithBedDetailsFullList::whereIn('camis_patient_id', $patient)->get()->toArray();
            }

        } else {
            $patients_list = [];
        }

        $html_view                                                      = View::make('Dashboards.Camis.BoardRound.MissedBoardRoundData', compact('patients_list'));
        $success_array['html_sections']                                 = $html_view->render();
        return ReturnArrayAsJsonToScript($success_array);
    }


    private function GetDaysOfMonth($year, $month, $include_weekend){
        $start = Carbon::create($year, $month, 1);

        $end = ($year == now()->year && $month == now()->month)
            ? now()
            : $start->copy()->endOfMonth();

        $period = CarbonPeriod::create($start, $end);

        $days = [];

        foreach ($period as $date) {
            if ($include_weekend == 0 && in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                continue;
            }

            $days[] = $date->toDateString();
        }

        return $days;
    }


}
