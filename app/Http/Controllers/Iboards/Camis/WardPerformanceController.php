<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Controller;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsFullList;
use App\Models\History\HistoryCamisIboxBoardWardRound;
use App\Models\Iboards\Camis\Data\CamisIboxCalculatedDailySummary;
use App\Models\Iboards\Camis\Master\Wards;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;

class WardPerformanceController extends Controller
{

    public function Index($ward_id)
    {
        if (CheckSpecificPermission('camis_ward_performance_page_view')) {
            $success_array    = array();
            $ward_details     = Wards::where('ward_url_name', $ward_id)->first();

            return view('Dashboards.Camis.WardPerformance.Index', compact('ward_details'));
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }

    public function WardType()
    {
        if (CheckSpecificPermission('camis_ward_performance_page_view')) {
            return view('Dashboards.Camis.WardPerformance.WardType');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }
    }


    public function IndexRefreshDataLoad(Request $request)
    {
        $success_array    = array();
        $ward_id          = $request->ward_id;
        $ward_details     = Wards::where('ward_url_name', $ward_id)->first();
        $dates_array = $this->GetWeekdays();
        $all_dates = array_unique(array_merge(...array_values($dates_array)));

        if ($ward_details != null) {
            $excludedkeyvalues = [];
            $today = Carbon::now();
            $current_date = Carbon::now()->startOfWeek();
            $date_range = [];


            $last_30_days = [];

            for ($i = 0; $i < 30; $i++) {
                $sub_days = clone $today;
                $current_carbon_date = $sub_days->subDays($i);
                $last_30_days[] = $current_carbon_date->format('Y-m-d');
                $last_30_days_format[] = $current_carbon_date->format('jS M');
            }



            for ($i = 0; $i < 4; $i++) {
                $week_start_date = $current_date->copy()->subWeeks($i);

                for ($j = 0; $j < 5; $j++) {
                    $date = $week_start_date->copy()->addDays($j);

                    if ($date->dayOfWeek != Carbon::SATURDAY && $date->dayOfWeek != Carbon::SUNDAY) {
                        $date_range[] = $date->toDateString();
                    }
                }
            }
            $board_round_history_query = HistoryCamisIboxBoardWardRound::where('ward_id', $ward_details->id)
                ->whereIn(\DB::raw('DATE(created_at)'), $all_dates);
            $board_round_report_query = clone $board_round_history_query;


            $board_round_history = $board_round_report_query->select(
                'status',
                'history_id',

                \DB::raw('SUM(IF(TIME(created_at) < "12:00:00", 1, 0)) AS am_total'),
                \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00", 1, 0)) AS pm_total'),
                \DB::raw('SUM(IF(TIME(created_at) < "12:00:00", 20, 0)) AS am_percentage_total'),
                \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00", 20, 0)) AS pm_percentage_total'),
                \DB::raw('LEAST(20, SUM(IF(TIME(created_at) < "12:00:00", 20, 0)) + SUM(IF(TIME(created_at) >= "12:00:00", 20, 0))) AS total'),
                // \DB::raw('SUM(IF(TIME(created_at) < "12:00:00" AND status = 1, 1, 0)) AS am_total'),
                // \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00" AND status = 1, 1, 0)) AS pm_total'),
                // \DB::raw('SUM(IF(TIME(created_at) < "12:00:00" AND status = 1, 20, 0)) AS am_percentage_total'),
                // \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00" AND status = 1, 20, 0)) AS pm_percentage_total'),
                // \DB::raw('(SUM(IF(TIME(created_at) < "12:00:00" AND status = 1, 20, 0)) + SUM(IF(TIME(created_at) >= "12:00:00" AND status = 1, 20, 0))) / 2 AS total'),
                \DB::raw('DATE(created_at) AS date'),
                \DB::raw('COALESCE(MAX(CASE WHEN TIME(created_at) < "12:00:00" THEN DATE_FORMAT(created_at, "%H:%i") ELSE "00:00" END), "00:00") AS am_time'),
                \DB::raw('COALESCE(MAX(CASE WHEN TIME(created_at) >= "12:00:00" THEN DATE_FORMAT(created_at, "%H:%i") ELSE "00:00" END), "00:00") AS pm_time')
            )
                ->groupBy('status', 'history_id', \DB::raw('DATE(created_at)'))
                ->orderBy('history_id', 'asc')
                ->get();


            $board_round_chart_results = [];
            foreach ($dates_array as $week_name => $date_array) {

                foreach ($date_array as $date) {
                    $board_round_chart_results[$week_name][$date] = [
                        'am' => '00:00',
                        'pm' => '00:00',
                        'am_total' => 0,
                        'pm_total' => 0,
                        'am_percentage_total' => 0,
                        'pm_percentage_total' => 0,
                        'total' => 0,
                        'am_status' => 0,
                        'pm_status' => 0,
                        'date' => $date,
                    ];
                }
            }



            foreach ($board_round_history as $result) {

                $board_round_date = $result->date;
                $filtered_date = array_diff_key($dates_array, ["current_week_partial" => ""]);

                $matches = array_filter(
                    $filtered_date,
                    fn($dates) => in_array($board_round_date, $dates, true)
                );

                $week_name = array_key_first($matches);

                $ward_id = $ward_details->id;

                $am_total = $result->am_total;
                $pm_total = $result->pm_total;
                $pm_percentage_total = ($result->pm_total != 0) ? $result->pm_percentage_total / $result->pm_total : 0;
                $am_percentage_total = ($result->am_total != 0) ? $result->am_percentage_total / $result->am_total : 0;

                $am_status = $result->am_time != '00:00' && $result->status == 1 ? 1 : 2;
                $pm_status = $result->pm_time != '00:00' && $result->status == 1 ? 1 : 2;


                if ($am_total != 0) {

                    $existing_am_status = isset($board_round_chart_results[$week_name][$result->date]['am_status'])
                        && $board_round_chart_results[$week_name][$result->date]['am_status'] == 1;

                    if (!$existing_am_status) {
                        $board_round_chart_results[$week_name][$result->date]['am'] = $result->am_time;
                        $board_round_chart_results[$week_name][$result->date]['am_percentage_total'] = $am_percentage_total;
                        $board_round_chart_results[$week_name][$result->date]['am_total'] = $am_total;
                        $board_round_chart_results[$week_name][$result->date]['am_status'] = $am_status;
                        $board_round_chart_results[$week_name][$result->date]['total'] = (($am_percentage_total + $pm_percentage_total) / 2);
                        $board_round_chart_results[$week_name][$result->date]['date'] = $result->date;
                        $board_round_chart_results[$week_name][$result->date]['ward_id'] = $result->ward_id;
                        $board_round_chart_results[$week_name][$result->date]['board_round_session'] = $result->board_round_session;
                    }
                }
                if ($pm_total != 0) {

                    $existing_pm_status = isset($board_round_chart_results[$week_name][$result->date]['pm_status'])
                        && $board_round_chart_results[$week_name][$result->date]['pm_status'] == 1;

                    if (!$existing_pm_status) {
                        $board_round_chart_results[$week_name][$result->date]['pm'] = $result->pm_time;
                        $board_round_chart_results[$week_name][$result->date]['pm_percentage_total'] = $pm_percentage_total;
                        $board_round_chart_results[$week_name][$result->date]['pm_total'] = $pm_total;
                        $board_round_chart_results[$week_name][$result->date]['pm_status'] = $pm_status;
                        $board_round_chart_results[$week_name][$result->date]['total'] = (($am_percentage_total + $pm_percentage_total) / 2);
                        $board_round_chart_results[$week_name][$result->date]['date'] = $result->date;
                        $board_round_chart_results[$week_name][$result->date]['ward_id'] = $result->ward_id;
                        $board_round_chart_results[$week_name][$result->date]['board_round_session'] = $result->board_round_session;
                    }
                }
                if ($board_round_chart_results[$week_name][$result->date]['am'] != '00:00' || $board_round_chart_results[$week_name][$result->date]['pm'] != '00:00') {
                    $board_round_chart_results[$week_name][$result->date]['total'] = 20;
                }
            }
        }
        $ward_summary_by_week = $board_round_chart_results;



        $frontend_roles = [
            'Matron' => ['title' => 'Matron', 'min_value' => 1],
            'Nursing' => ['title' => 'Nursing Rep', 'min_value' => 5],
            'Consultant' => ['title' => 'Consultant/Reg', 'min_value' => 5],
            'Junior Doctor' => ['title' => 'Junior Dr', 'min_value' => 5],
            'Therapies' => ['title' => 'Therapies', 'min_value' => 5],
            'CDT' => ['title' => 'CDT', 'min_value' => 1],
        ];
        $attendance_query = $board_round_report_query->select(\DB::raw('DATE(created_at) AS date'));



        foreach (array_keys($frontend_roles) as $role) {
            if (strtolower($role) === 'nursing') {
                $attendance_query->addSelect(\DB::raw("SUM(CASE WHEN FIND_IN_SET('Bay Nurse', role) OR FIND_IN_SET('Complex Discharge Nurse', role) OR FIND_IN_SET('Specialist Nurse', role) THEN 1 ELSE 0 END) as `$role`"));
            } else {
                $attendance_query->addSelect(\DB::raw("SUM(CASE WHEN FIND_IN_SET('$role', role) THEN 1 ELSE 0 END) as `$role`"));
            }
        }

        $attendance_query = $attendance_query
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->orderBy('history_id', 'asc')
            ->get()
            ->keyBy('date')
            ->toArray();

        $attendance_results = [];
        foreach ($date_range as $date) {
            foreach (array_keys($frontend_roles) as $role) {
                $attendance_results[$role][$date] = 0;
            }
        }

        foreach ($attendance_query as $result) {
            foreach (array_keys($frontend_roles) as $role) {
                $attendance_results[$role][$result['date']] = intval($result[$role]);
            }
        }

        $board_round_attendance_weeks_split = array_chunk($attendance_results, 5, true);

        $current_week = Carbon::now()->week;
        $previous_weeks = [
            'Week_-1' => Carbon::now()->subWeek()->week,
            'Week_-2' => Carbon::now()->subWeeks(2)->week,
            'Week_-3' => Carbon::now()->subWeeks(3)->week,
        ];

        $attendance_data = [
            'Current_Week' => [],
            'Week_-1' => [],
            'Week_-2' => [],
            'Week_-3' => [],
        ];

        foreach ($board_round_attendance_weeks_split as $data_array) {
            foreach ($data_array as $key => $value) {
                foreach (['Current_Week', 'Week_-1', 'Week_-2', 'Week_-3'] as $week) {
                    if (!isset($attendance_data[$week][$key])) {
                        $attendance_data[$week][$key] = 0;
                    }
                }

                foreach ($value as $date => $count) {
                    $date_time = Carbon::createFromFormat('Y-m-d', $date);
                    $week_number = $date_time->week;

                    if ($week_number == $current_week) {
                        $attendance_data['Current_Week'][$key] += $count;
                    } elseif ($week_number == $previous_weeks['Week_-1']) {
                        $attendance_data['Week_-1'][$key] += $count;
                    } elseif ($week_number == $previous_weeks['Week_-2']) {
                        $attendance_data['Week_-2'][$key] += $count;
                    } elseif ($week_number == $previous_weeks['Week_-3']) {
                        $attendance_data['Week_-3'][$key] += $count;
                    }
                }
            }
        }



        $last_5_weeks = [];
        for ($i = 0; $i < 6; $i++) {
            $week_start_date = $current_date->copy()->subWeeks($i);

            for ($j = 0; $j < 7; $j++) {
                $date = $week_start_date->copy()->addDays($j);

                $last_5_weeks[] = $date->toDateString();
            }
        }

        foreach ($last_5_weeks as $dates) {
            $discharges_by_week[$dates] = [
                'midnight_midday' => 0,
                'midday_4pm' => 0,
                '4pm_midnight' => 0,
            ];
        }




        $in_patient_records = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->whereNull('camis_patient_discharge_date_time')->select('camis_patient_admission_date', 'camis_patient_id', 'camis_patient_sex', 'camis_patient_age')->where('ibox_ward_id', $ward_details->id)
            ->get()->toArray();
        $out_patients_record = CamisIboxWardPatientInformationWithBedDetailsFullList::where('camis_patient_ward_id', $ward_details->id)->whereNotNull('camis_patient_discharge_date_time')->orderBy('camis_patient_discharge_date_time', 'desc')->whereIn(\DB::raw('DATE(camis_patient_discharge_date_time)'), $last_5_weeks)->get()->toArray();


        $average_los = 0;
        $average_discharges_los = 0;
        $male_female_age_wise = [];
        $male_below_25_avg_count = 0;
        $male_below_25_data = [];
        $male_below_26_49_avg_count = 0;
        $male_below_26_49_data = [];
        $male_below_50_74_avg_count = 0;
        $male_below_50_74_data = [];
        $male_below_75_84_avg_count = 0;
        $male_below_75_84_data = [];
        $male_below_85_avg_count = 0;
        $male_below_85_data = [];
        $female_below_25_avg_count = 0;
        $female_below_25_data = [];
        $female_below_26_49_avg_count = 0;
        $female_below_26_49_data = [];
        $female_below_50_74_avg_count = 0;
        $female_below_50_74_data = [];
        $female_below_75_84_avg_count = 0;
        $female_below_75_84_data = [];
        $female_below_85_avg_count = 0;
        $female_below_85_data = [];

        $total_los['0_4'] = 0;
        $total_los['5_6'] = 0;
        $total_los['7_14'] = 0;
        $total_los['15_21'] = 0;
        $total_los['22_plus'] = 0;

        $_7_to_13_stranded = 0;
        $_14_to_20_stranded = 0;
        $_21_more_stranded = 0;

        foreach ($in_patient_records as $row) {
            $admission_date = Carbon::parse($row['camis_patient_admission_date']);
            $average_los += Carbon::now()->diffInDays($admission_date);
            $diffInDays = Carbon::now()->diffInDays($admission_date);

            if ($row['camis_patient_age'] <= 25 && strtolower($row['camis_patient_sex']) == 'male') {
                $male_below_25_data[] = $row;
                $male_below_25_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if ($row['camis_patient_age'] <= 25 && strtolower($row['camis_patient_sex']) == 'female') {
                $female_below_25_data[] = $row;
                $female_below_25_avg_count += Carbon::now()->diffInDays($admission_date);
            }

            if (($row['camis_patient_age'] >= 26 && $row['camis_patient_age'] <= 49) && strtolower($row['camis_patient_sex']) == 'male') {
                $male_below_26_49_data[] = $row;
                $male_below_26_49_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if (($row['camis_patient_age'] >= 26 && $row['camis_patient_age'] <= 49) && strtolower($row['camis_patient_sex']) == 'female') {
                $female_below_26_49_data[] = $row;
                $female_below_26_49_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if (($row['camis_patient_age'] >= 50 && $row['camis_patient_age'] <= 74) && strtolower($row['camis_patient_sex']) == 'male') {
                $male_below_50_74_data[] = $row;
                $male_below_50_74_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if (($row['camis_patient_age'] >= 50 && $row['camis_patient_age'] <= 74) && strtolower($row['camis_patient_sex']) == 'female') {
                $female_below_50_74_data[] = $row;
                $female_below_50_74_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if (($row['camis_patient_age'] >= 75 && $row['camis_patient_age'] <= 84) && strtolower($row['camis_patient_sex']) == 'male') {
                $male_below_75_84_data[] = $row;
                $male_below_75_84_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if (($row['camis_patient_age'] >= 75 && $row['camis_patient_age'] <= 84) && strtolower($row['camis_patient_sex']) == 'female') {
                $female_below_75_84_data[] = $row;
                $female_below_75_84_avg_count += Carbon::now()->diffInDays($admission_date);
            }

            if ($row['camis_patient_age'] >= 85 && strtolower($row['camis_patient_sex']) == 'male') {
                $male_below_85_data[] = $row;
                $male_below_85_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if ($row['camis_patient_age'] >= 85 && strtolower($row['camis_patient_sex']) == 'female') {
                $female_below_85_data[] = $row;
                $female_below_85_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if ($diffInDays <= 4) {
                $total_los['0_4']++;
            } elseif ($diffInDays >= 5 && $diffInDays <= 6) {
                $total_los['5_6']++;
            } elseif ($diffInDays >= 7 && $diffInDays <= 14) {
                $total_los['7_14']++;
            } elseif ($diffInDays >= 15 && $diffInDays <= 21) {
                $total_los['15_21']++;
            } elseif ($diffInDays >= 22) {
                $total_los['22_plus']++;
            }
            if ($diffInDays >= 7 && $diffInDays <= 13) {
                $_7_to_13_stranded++;
            } elseif ($diffInDays >= 14 && $diffInDays <= 20) {
                $_14_to_20_stranded++;
            } elseif ($diffInDays >= 21) {
                $_21_more_stranded++;
            }
        }

        $dis_male_below_25_avg_count = 0;
        $dis_male_below_25_data = [];
        $dis_male_below_26_49_avg_count = 0;
        $dis_male_below_26_49_data = [];
        $dis_male_below_50_74_avg_count = 0;
        $dis_male_below_50_74_data = [];
        $dis_male_below_75_84_avg_count = 0;
        $dis_male_below_75_84_data = [];
        $dis_male_below_85_avg_count = 0;
        $dis_male_below_85_data = [];
        $dis_female_below_25_avg_count = 0;
        $dis_female_below_25_data = [];
        $dis_female_below_26_49_avg_count = 0;
        $dis_female_below_26_49_data = [];
        $dis_female_below_50_74_avg_count = 0;
        $dis_female_below_50_74_data = [];
        $dis_female_below_75_84_avg_count = 0;
        $dis_female_below_75_84_data = [];
        $dis_female_below_85_avg_count = 0;
        $dis_female_below_85_data = [];
        foreach ($out_patients_record as $index => $out_row) {
            $discharge_date = Carbon::parse($out_row['camis_patient_discharge_date_time']);
            $admission_date = Carbon::parse($out_row['camis_patient_admission_date_time']);
            $day_difference = $discharge_date->diffInDays($admission_date);
            if ($index < 101) {

                $average_discharges_los += $day_difference;

                if ($out_row['camis_patient_age'] <= 25 && strtolower($out_row['camis_patient_sex']) == 'male') {
                    $dis_male_below_25_data[] = $out_row;
                    $dis_male_below_25_avg_count += $day_difference;
                }
                if ($out_row['camis_patient_age'] <= 25 && strtolower($out_row['camis_patient_sex']) == 'female') {
                    $dis_female_below_25_data[] = $out_row;
                    $dis_female_below_25_avg_count += $day_difference;
                }
                if (($out_row['camis_patient_age'] >= 26 && $out_row['camis_patient_age'] <= 49) && strtolower($out_row['camis_patient_sex']) == 'male') {
                    $dis_male_below_26_49_data[] = $out_row;
                    $dis_male_below_26_49_avg_count += $day_difference;
                }
                if (($out_row['camis_patient_age'] >= 26 && $out_row['camis_patient_age'] <= 49) && strtolower($out_row['camis_patient_sex']) == 'female') {
                    $dis_female_below_26_49_data[] = $out_row;
                    $dis_female_below_26_49_avg_count += $day_difference;
                }

                if (($out_row['camis_patient_age'] >= 50 && $out_row['camis_patient_age'] <= 74) && strtolower($out_row['camis_patient_sex']) == 'male') {
                    $dis_male_below_50_74_data[] = $out_row;
                    $dis_male_below_50_74_avg_count += $day_difference;
                }
                if (($out_row['camis_patient_age'] >= 50 && $out_row['camis_patient_age'] <= 74) && strtolower($out_row['camis_patient_sex']) == 'female') {
                    $dis_female_below_50_74_data[] = $out_row;
                    $dis_female_below_50_74_avg_count += $day_difference;
                }

                if (($out_row['camis_patient_age'] >= 75 && $out_row['camis_patient_age'] <= 84) && strtolower($out_row['camis_patient_sex']) == 'male') {
                    $dis_male_below_75_84_data[] = $out_row;
                    $dis_male_below_75_84_avg_count += $day_difference;
                }
                if (($out_row['camis_patient_age'] >= 75 && $out_row['camis_patient_age'] <= 84) && strtolower($out_row['camis_patient_sex']) == 'female') {
                    $dis_female_below_75_84_data[] = $out_row;
                    $dis_female_below_75_84_avg_count += $day_difference;
                }

                if ($out_row['camis_patient_age'] >= 85 && strtolower($out_row['camis_patient_sex']) == 'male') {
                    $dis_male_below_85_data[] = $out_row;
                    $dis_male_below_85_avg_count += $day_difference;
                }
                if ($out_row['camis_patient_age'] >= 85 && strtolower($out_row['camis_patient_sex']) == 'female') {
                    $dis_female_below_85_data[] = $out_row;
                    $dis_female_below_85_avg_count += $day_difference;
                }
            }
            if (in_array(date('Y-m-d', strtotime($out_row['camis_patient_discharge_date_time'])), $last_5_weeks)) {
                $hour = (int) Carbon::parse($out_row['camis_patient_discharge_date_time'])->format('H');
                $week_start = $discharge_date->copy()->format('Y-m-d');

                if ($hour >= 0 && $hour < 12) {
                    $discharges_by_week[$week_start]['midnight_midday'] += 1;
                } elseif ($hour >= 12 && $hour < 16) {
                    $discharges_by_week[$week_start]['midday_4pm'] += 1;
                } else {
                    $discharges_by_week[$week_start]['4pm_midnight'] += 1;
                }
            }
        }





        if ($average_los > 0 || count($in_patient_records) > 0) {
            $total_avg_inpatient_los = intval($average_los / count($in_patient_records));
        } else {
            $total_avg_inpatient_los = 0;
        }
        if ($average_discharges_los > 0 || count($out_patients_record) > 0) {
            $total_avg_outpatient_los = intval($average_discharges_los / count($out_patients_record));
        } else {
            $total_avg_outpatient_los = 0;
        }

        if ($dis_male_below_25_avg_count > 0 || count($dis_male_below_25_data) > 0) {
            $male_female_age_wise['below_25']['avg_male_disch'] = intval($dis_male_below_25_avg_count / count($dis_male_below_25_data));
        } else {
            $male_female_age_wise['below_25']['avg_male_disch'] = 0;
        }

        if ($male_below_25_avg_count > 0 || count($male_below_25_data) > 0) {
            $male_female_age_wise['below_25']['avg_male'] = intval($male_below_25_avg_count / count($male_below_25_data));
        } else {
            $male_female_age_wise['below_25']['avg_male'] = 0;
        }
        $male_female_age_wise['below_25']['male_total'] = count($male_below_25_data);


        if ($dis_male_below_26_49_avg_count > 0 || count($dis_male_below_26_49_data) > 0) {
            $male_female_age_wise['below_26_49']['avg_male_disch'] = intval($dis_male_below_26_49_avg_count / count($dis_male_below_26_49_data));
        } else {
            $male_female_age_wise['below_26_49']['avg_male_disch'] = 0;
        }

        if ($male_below_26_49_avg_count > 0 || count($male_below_26_49_data) > 0) {
            $male_female_age_wise['below_26_49']['avg_male'] = intval($male_below_26_49_avg_count / count($male_below_26_49_data));
        } else {
            $male_female_age_wise['below_26_49']['avg_male'] = 0;
        }
        $male_female_age_wise['below_26_49']['male_total'] = count($male_below_26_49_data);



        if ($dis_male_below_50_74_avg_count > 0 || count($dis_male_below_50_74_data) > 0) {
            $male_female_age_wise['below_50_74']['avg_male_disch'] = intval($dis_male_below_50_74_avg_count / count($dis_male_below_50_74_data));
        } else {
            $male_female_age_wise['below_50_74']['avg_male_disch'] = 0;
        }


        if ($male_below_50_74_avg_count > 0 || count($male_below_50_74_data) > 0) {
            $male_female_age_wise['below_50_74']['avg_male'] = intval($male_below_50_74_avg_count / count($male_below_50_74_data));
        } else {
            $male_female_age_wise['below_50_74']['avg_male'] = 0;
        }
        $male_female_age_wise['below_50_74']['male_total'] = count($male_below_50_74_data);



        if ($dis_male_below_75_84_avg_count > 0 || count($dis_male_below_75_84_data) > 0) {
            $male_female_age_wise['below_75_84']['avg_male_disch'] = intval($dis_male_below_75_84_avg_count / count($dis_male_below_75_84_data));
        } else {
            $male_female_age_wise['below_75_84']['avg_male_disch'] = 0;
        }


        if ($male_below_75_84_avg_count > 0 || count($male_below_75_84_data) > 0) {
            $male_female_age_wise['below_75_84']['avg_male'] = intval($male_below_75_84_avg_count / count($male_below_75_84_data));
        } else {
            $male_female_age_wise['below_75_84']['avg_male'] = 0;
        }
        $male_female_age_wise['below_75_84']['male_total'] = count($male_below_75_84_data);





        if ($dis_male_below_85_avg_count > 0 || count($dis_male_below_85_data) > 0) {
            $male_female_age_wise['below_85']['avg_male_disch'] = intval($dis_male_below_85_avg_count / count($dis_male_below_85_data));
        } else {
            $male_female_age_wise['below_85']['avg_male_disch'] = 0;
        }


        if ($male_below_85_avg_count > 0 || count($male_below_85_data) > 0) {
            $male_female_age_wise['below_85']['avg_male'] = intval($male_below_85_avg_count / count($male_below_85_data));
        } else {
            $male_female_age_wise['below_85']['avg_male'] = 0;
        }
        $male_female_age_wise['below_85']['male_total'] = count($male_below_85_data);


        if ($dis_female_below_25_avg_count > 0 || count($dis_female_below_25_data) > 0) {
            $male_female_age_wise['below_25']['avg_female_disch'] = intval($dis_female_below_25_avg_count / count($dis_female_below_25_data));
        } else {
            $male_female_age_wise['below_25']['avg_female_disch'] = 0;
        }

        if ($dis_female_below_26_49_avg_count > 0 || count($dis_female_below_26_49_data) > 0) {
            $male_female_age_wise['below_26_49']['avg_female_disch'] = intval($dis_female_below_26_49_avg_count / count($dis_female_below_26_49_data));
        } else {
            $male_female_age_wise['below_26_49']['avg_female_disch'] = 0;
        }


        if ($dis_female_below_50_74_avg_count > 0 || count($dis_female_below_50_74_data) > 0) {
            $male_female_age_wise['below_50_74']['avg_female_disch'] = intval($dis_female_below_50_74_avg_count / count($dis_female_below_50_74_data));
        } else {
            $male_female_age_wise['below_50_74']['avg_female_disch'] = 0;
        }



        if ($dis_female_below_75_84_avg_count > 0 || count($dis_female_below_75_84_data) > 0) {
            $male_female_age_wise['below_75_84']['avg_female_disch'] = intval($dis_female_below_75_84_avg_count / count($dis_female_below_75_84_data));
        } else {
            $male_female_age_wise['below_75_84']['avg_female_disch'] = 0;
        }



        if ($dis_female_below_85_avg_count > 0 || count($dis_female_below_85_data) > 0) {
            $male_female_age_wise['below_85']['avg_female_disch'] = intval($dis_female_below_85_avg_count / count($dis_female_below_85_data));
        } else {
            $male_female_age_wise['below_85']['avg_female_disch'] = 0;
        }


        if ($female_below_25_avg_count > 0 || count($female_below_25_data) > 0) {
            $male_female_age_wise['below_25']['avg_female'] = intval($female_below_25_avg_count / count($female_below_25_data));
        } else {
            $male_female_age_wise['below_25']['avg_female'] = 0;
        }
        $male_female_age_wise['below_25']['female_total'] = count($female_below_25_data);


        if ($female_below_26_49_avg_count > 0 || count($female_below_26_49_data) > 0) {
            $male_female_age_wise['below_26_49']['avg_female'] = intval($female_below_26_49_avg_count / count($female_below_26_49_data));
        } else {
            $male_female_age_wise['below_26_49']['avg_female'] = 0;
        }
        $male_female_age_wise['below_26_49']['female_total'] = count($female_below_26_49_data);


        if ($female_below_50_74_avg_count > 0 || count($female_below_50_74_data) > 0) {
            $male_female_age_wise['below_50_74']['avg_female'] = intval($female_below_50_74_avg_count / count($female_below_50_74_data));
        } else {
            $male_female_age_wise['below_50_74']['avg_female'] = 0;
        }
        $male_female_age_wise['below_50_74']['female_total'] = count($female_below_50_74_data);


        if ($female_below_75_84_avg_count > 0 || count($female_below_75_84_data) > 0) {
            $male_female_age_wise['below_75_84']['avg_female'] = intval($female_below_75_84_avg_count / count($female_below_75_84_data));
        } else {
            $male_female_age_wise['below_75_84']['avg_female'] = 0;
        }
        $male_female_age_wise['below_75_84']['female_total'] = count($female_below_75_84_data);

        if ($female_below_85_avg_count > 0 || count($female_below_85_data) > 0) {
            $male_female_age_wise['below_85']['avg_female'] = intval($female_below_85_avg_count / count($female_below_85_data));
        } else {
            $male_female_age_wise['below_85']['avg_female'] = 0;
        }
        $male_female_age_wise['below_85']['female_total'] = count($female_below_85_data);






        $patient_tasks = CamisIboxBoardRoundPatientTasks::whereIn('patient_id', array_column($in_patient_records, "camis_patient_id"))->select('task_completed_status', 'task_not_applicable_status')->get()->toArray();
        $count_task['created'] = count($patient_tasks);
        $count_task['completed'] = 0;
        $count_task['outstanding'] = 0;
        foreach ($patient_tasks as $task) {
            if ($task['task_completed_status'] == 1) {
                $count_task['completed']++;
            } else {
                $count_task['outstanding']++;
            }
        }

        $ward_los_string  = $ward_details->ward_short_name . '_ward_los_';

        $daily_summary = CamisIboxCalculatedDailySummary::whereIn('date', $last_30_days)->where('summary_key', 'like', $ward_los_string . '%')->get()->toArray();
        $camis_data = CamisDailySummaryArrayRearrange($daily_summary);

        $_7_to_13_los = array();
        $_14_to_20_los = array();
        $_21_more_los = array();
        foreach ($last_30_days as $date) {
            $_7_to_13_los[$date] = 0;
            $_14_to_20_los[$date] = 0;
            $_21_more_los[$date] = 0;
        }

        foreach ($camis_data as $date_key => $summary) {
            if (isset($summary[$ward_details->ward_short_name . '_ward_los_7_13'])) {
                $_7_to_13_los[$date_key] = $summary[$ward_details->ward_short_name . '_ward_los_7_13'];
            }
            if (isset($summary[$ward_details->ward_short_name . '_ward_los_14_20'])) {
                $_14_to_20_los[$date_key] = $summary[$ward_details->ward_short_name . '_ward_los_14_20'];
            }
            if (isset($summary[$ward_details->ward_short_name . '_ward_los_over_20'])) {
                $_21_more_los[$date_key] = $summary[$ward_details->ward_short_name . '_ward_los_over_20'];
            }
        }







        $weekly_discharges_record = collect($discharges_by_week);

        $discharge_by_week_final_data = [];

        for ($i = 0; $i <= 5; $i++) {
            $week_start = Carbon::now()->startOfWeek()->subWeeks($i)->format('Y-m-d');
            $week_end = Carbon::now()->endOfWeek()->subWeeks($i)->format('Y-m-d');

            $week_label = $i === 0 ? 'current_week' : "previous_week_$i";

            $filtered = $weekly_discharges_record->filter(function ($value, $key) use ($week_start, $week_end) {
                return $key >= $week_start && $key <= $week_end;
            });

            $discharge_by_week_final_data[$week_label] = [
                'midnight_midday' => $filtered->sum('midnight_midday'),
                'midday_4pm' => $filtered->sum('midday_4pm'),
                '4pm_midnight' => $filtered->sum('4pm_midnight'),
            ];
        }






        $board_round_target                             =   $ward_details->ward_daily_goal;








        $success_array["board_round_target"]                                               = $board_round_target;



        $success_array['average_inpatient_los']                                            = intval($total_avg_inpatient_los);
        $success_array['average_outpatient_los']                                           = intval($total_avg_outpatient_los);
        $success_array["attendance_roles_designations"]                                    = $frontend_roles;
        $success_array["task_count"]                                                       = $count_task;
        $success_array["total_los_daywise"]                                                = $total_los;
        $success_array["total_7_13_count"]                                                 = $_7_to_13_stranded;
        $success_array["total_13_20_count"]                                                = $_14_to_20_stranded;
        $success_array["total_21_more_count"]                                              = $_21_more_stranded;


        $success_array["7_13_patients_los"]                                                = $_7_to_13_los;
        $success_array["14_20_patients_los"]                                               = $_14_to_20_los;
        $success_array["20_over_patients_los"]                                             = $_21_more_los;
        $success_array["board_store_search_array"]                                         = $ward_summary_by_week;
        $success_array['boardround_attendance_array']                                      = $attendance_data;
        $success_array['male_female_wise_data']                                            = $male_female_age_wise;
        $success_array['dischagre_by_week']                                                = $discharge_by_week_final_data;
        $success_array['last_30_days']                                                     = $last_30_days_format;



        $view                                                           = View::make('Dashboards.Camis.WardPerformance.IndexDataLoad', compact('success_array'));
        $sections                                                       = $view->render();

        return $sections;
    }

    public function WardTypeDataLoad($ward_type)
    {
        $success_array    = array();
        $dates_array = $this->GetWeekdays();
        $all_dates = array_unique(array_merge(...array_values($dates_array)));

        $success_array['ward_type'] = $ward_type;
        $ward_array = Wards::query()
            ->where('status', 1)
            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
            ->when(
                $ward_type === 'amu',
                fn($q) => $q->whereIn('ward_short_name', ['RLTAMU01', 'RLTAMU02']),

                function ($q) use ($ward_type) {
                    return $q->when($ward_type === 'medical', fn($q) => $q->where('ward_type_primary', 13))
                        ->when($ward_type === 'surgical', fn($q) => $q->where('ward_type_primary', 14))
                        ->when($ward_type === 'others', fn($q) => $q->where('ward_type_primary', 16))
                        ->when(is_numeric($ward_type), fn($q) => $q->where('id', $ward_type))
                        ->whereNotIn('ward_short_name', ['RLTAMU01', 'RLTAMU02']);
                }
            )
            ->pluck('id')
            ->toArray();

        if (count($ward_array) > 0) {
            $excludedkeyvalues = [];
            $today = Carbon::now();
            $current_date = Carbon::now()->startOfWeek();
            $date_range = [];


            $last_30_days = [];

            for ($i = 0; $i < 30; $i++) {
                $sub_days = clone $today;
                $current_carbon_date = $sub_days->subDays($i);
                $last_30_days[] = $current_carbon_date->format('Y-m-d');
                $last_30_days_format[] = $current_carbon_date->format('jS M');
            }



            for ($i = 0; $i < 4; $i++) {
                $week_start_date = $current_date->copy()->subWeeks($i);

                for ($j = 0; $j < 5; $j++) {
                    $date = $week_start_date->copy()->addDays($j);

                    if ($date->dayOfWeek != Carbon::SATURDAY && $date->dayOfWeek != Carbon::SUNDAY) {
                        $date_range[] = $date->toDateString();
                    }
                }
            }
            $board_round_ward_array = Wards::query()->when(
                $ward_type === 'amu',
                fn($q) => $q->whereIn('ward_short_name', ['RLTAMU01', 'RLTAMU02']),

                function ($q) use ($ward_type) {
                    return $q->when($ward_type === 'medical', fn($q) => $q->where('ward_type_primary', 13))
                        ->when($ward_type === 'surgical', fn($q) => $q->where('ward_type_primary', 14))
                        ->when($ward_type === 'others', fn($q) => $q->where('ward_type_primary', 16))
                        ->when(is_numeric($ward_type), fn($q) => $q->where('id', $ward_type))
                        ->whereNotIn('ward_short_name', ['RLTAMU01', 'RLTAMU02']);
                }
            )
                ->where('status', 1)
                ->where('show_on_boardround_dashboard', 1)
                ->where('disabled_on_all_dashboard_except_ward_summary', 0)
                ->pluck('id')->toArray();
            $board_round_history_query = HistoryCamisIboxBoardWardRound::whereIn('ward_id', $board_round_ward_array)
                ->whereIn(\DB::raw('DATE(created_at)'), $all_dates);

            $board_round_report_query = clone $board_round_history_query;

            $board_round_history = $board_round_report_query->select(
                'status',
                'ward_id',
                'history_id',
                \DB::raw('SUM(IF(TIME(created_at) < "12:00:00", 1, 0)) AS am_total'),
                \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00", 1, 0)) AS pm_total'),
                \DB::raw('SUM(IF(TIME(created_at) < "12:00:00", 20, 0)) AS am_percentage_total'),
                \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00", 20, 0)) AS pm_percentage_total'),
                \DB::raw('LEAST(20, SUM(IF(TIME(created_at) < "12:00:00", 20, 0)) + SUM(IF(TIME(created_at) >= "12:00:00", 20, 0))) AS total'),
                // \DB::raw('SUM(IF(TIME(created_at) < "12:00:00" AND status = 1, 1, 0)) AS am_total'),
                // \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00" AND status = 1, 1, 0)) AS pm_total'),
                // \DB::raw('SUM(IF(TIME(created_at) < "12:00:00" AND status = 1, 20, 0)) AS am_percentage_total'),
                // \DB::raw('SUM(IF(TIME(created_at) >= "12:00:00" AND status = 1, 20, 0)) AS pm_percentage_total'),
                // \DB::raw('(SUM(IF(TIME(created_at) < "12:00:00" AND status = 1, 20, 0)) + SUM(IF(TIME(created_at) >= "12:00:00" AND status = 1, 20, 0))) / 2 AS total'),
                \DB::raw('DATE(created_at) AS date'),
                \DB::raw('COALESCE(MAX(CASE WHEN TIME(created_at) < "12:00:00" THEN DATE_FORMAT(created_at, "%H:%i") ELSE "00:00" END), "00:00") AS am_time'),
                \DB::raw('COALESCE(MAX(CASE WHEN TIME(created_at) >= "12:00:00" THEN DATE_FORMAT(created_at, "%H:%i") ELSE "00:00" END), "00:00") AS pm_time')
            )
                ->groupBy('ward_id', 'history_id', 'status', \DB::raw('DATE(created_at)'))
                ->orderBy('history_id', 'asc')
                ->get();
            $board_round_chart_results = [];
            foreach ($dates_array as $week_name => $date_array) {

                foreach ($date_array as $date) {
                    foreach ($ward_array as $ward_id) {
                        $board_round_chart_results[$week_name][date('l', strtotime($date))][$ward_id] = [
                            'am' => '00:00',
                            'pm' => '00:00',
                            'am_total' => 0,
                            'pm_total' => 0,
                            'am_percentage_total' => 0,
                            'pm_percentage_total' => 0,
                            'total' => 0,
                            'am_status' => 0,
                            'pm_status' => 0,
                            'overall_status' => 0,
                            'date' => $date,
                        ];
                    }
                }
            }





            foreach ($board_round_history as $result) {

                $board_round_date = $result->date;
                $filtered_date = array_diff_key($dates_array, ["current_week_partial" => ""]);

                $matches = array_filter(
                    $filtered_date,
                    fn($dates) => in_array($board_round_date, $dates, true)
                );

                $week_name = array_key_first($matches);

                $ward_id = $result->ward_id;

                $am_total = $result->am_total;
                $pm_total = $result->pm_total;
                $pm_percentage_total = ($result->pm_total != 0) ? $result->pm_percentage_total / $result->pm_total : 0;
                $am_percentage_total = ($result->am_total != 0) ? $result->am_percentage_total / $result->am_total : 0;

                $am_status = $result->am_time != '00:00' && $result->status == 1 ? 1 : 2;
                $pm_status = $result->pm_time != '00:00' && $result->status == 1 ? 1 : 2;


                if ($am_total != 0) {

                    $existing_am_status = isset($board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['am_status'])
                        && $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['am_status'] == 1;

                    if (!$existing_am_status) {
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['am'] = $result->am_time;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['am_percentage_total'] = $am_percentage_total;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['am_total'] = $am_total;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['am_status'] = $am_status;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['total'] = (($am_percentage_total + $pm_percentage_total) / 2);
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['date'] = $result->date;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['ward_id'] = $result->ward_id;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['board_round_session'] = $result->board_round_session;
                    }
                }
                if ($pm_total != 0) {

                    $existing_pm_status = isset($board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['pm_status'])
                        && $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['pm_status'] == 1;

                    if (!$existing_pm_status) {
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['pm'] = $result->pm_time;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['pm_percentage_total'] = $pm_percentage_total;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['pm_total'] = $pm_total;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['pm_status'] = $pm_status;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['total'] = (($am_percentage_total + $pm_percentage_total) / 2);
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['date'] = $result->date;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['ward_id'] = $result->ward_id;
                        $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['board_round_session'] = $result->board_round_session;
                    }
                }
                if ($board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['am'] != '00:00' || $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['pm'] != '00:00') {
                    $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['total'] = 20;
                }
                if ($am_status == 1 || $pm_status == 1) {
                    $status = 1;
                } elseif (($am_status == 2 || $pm_status == 2) && ($am_status != 1 && $pm_status != 1)) {
                    $status = 2;
                }
                $board_round_chart_results[$week_name][date('l', strtotime($result->date))][$ward_id]['overall_status'] = $status ?? null;
            }
        }
        $board_round_sum = [];
        foreach ($board_round_chart_results as $week => $board_rounds) {
            foreach ($board_rounds as $day_name => $report_data) {

                $total_none_board_round = count(array_filter($report_data, fn($item) => $item['overall_status'] == 0));
                $total_partial_board_round = count(array_filter($report_data, fn($item) => $item['overall_status'] == 2));
                $total_complete_board_round = count(array_filter($report_data, fn($item) => $item['overall_status'] == 1));
                $total_number_of_boardround = ($total_none_board_round + $total_partial_board_round + $total_complete_board_round);

                if ($total_number_of_boardround > 0) {
                    $percentage_none_board_round = ($total_none_board_round / $total_number_of_boardround) * 100;
                    $percentage_partial_board_round = ($total_partial_board_round / $total_number_of_boardround) * 100;
                    $percentage_complete_board_round = ($total_complete_board_round / $total_number_of_boardround) * 100;
                } else {
                    $percentage_none_board_round = 0;
                    $percentage_partial_board_round = 0;
                    $percentage_complete_board_round = 0;
                }
                $board_round_sum[$week][$day_name]['total_board_round'] = $total_number_of_boardround;
                $board_round_sum[$week][$day_name]['total_none_board_round'] = $total_none_board_round;
                $board_round_sum[$week][$day_name]['total_partial_board_round'] = $total_partial_board_round;
                $board_round_sum[$week][$day_name]['total_complete_board_round'] = $total_complete_board_round;

                $board_round_sum[$week][$day_name]['perc_none_board_round'] = number_format($percentage_none_board_round, 2);
                $board_round_sum[$week][$day_name]['perc_partial_board_round'] = number_format($percentage_partial_board_round, 2);
                $board_round_sum[$week][$day_name]['perc_complete_board_round'] = number_format($percentage_complete_board_round, 2);
            }
        }
        foreach ($board_round_sum as $week_key => &$week_br_data) {



            if ($week_key == 'current_week') {

                $today = date('l');
                $weekdays_names = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                $today_index = array_search($today, $weekdays_names);
                $week_br_data = array_filter($week_br_data, function ($key) use ($weekdays_names, $today_index) {
                    return array_search($key, $weekdays_names) <= $today_index;
                }, ARRAY_FILTER_USE_KEY);
            }

            $overall_board_rounds = array_sum(array_column($week_br_data, 'total_board_round'));
            $overall_none_rounds = array_sum(array_column($week_br_data, 'total_none_board_round'));
            $overall_partial_rounds = array_sum(array_column($week_br_data, 'total_partial_board_round'));
            $overall_complete_rounds = array_sum(array_column($week_br_data, 'total_complete_board_round'));


            if ($overall_board_rounds > 0) {
                $percentage_none_board_round = ($overall_none_rounds / $overall_board_rounds) * 100;
                $percentage_partial_board_round = ($overall_partial_rounds / $overall_board_rounds) * 100;
                $percentage_complete_board_round = ($overall_complete_rounds / $overall_board_rounds) * 100;
            } else {
                $percentage_none_board_round = 0;
                $percentage_partial_board_round = 0;
                $percentage_complete_board_round = 0;
            }


            $board_round_sum[$week_key]['Total'] = [
                'total_board_round' => $overall_board_rounds,
                'total_none_board_round' => $overall_none_rounds,
                'total_partial_board_round' => $overall_partial_rounds,
                'total_complete_board_round' => $overall_complete_rounds,
                'perc_none_board_round' => number_format($percentage_none_board_round, 2),
                'perc_partial_board_round' => number_format($percentage_partial_board_round, 2),
                'perc_complete_board_round' => number_format($percentage_complete_board_round, 2)

            ];
        }
        unset($board_round_sum['current_week_partial']);
        $ward_summary_by_week = $board_round_sum;



        $frontend_roles = [
            'Matron' => ['title' => 'Matron', 'min_value' => 1],
            'Nursing' => ['title' => 'Nursing Rep', 'min_value' => 5],
            'Consultant' => ['title' => 'Consultant/Reg', 'min_value' => 5],
            'Junior Doctor' => ['title' => 'Junior Dr', 'min_value' => 5],
            'Therapies' => ['title' => 'Therapies', 'min_value' => 5],
            'CDT' => ['title' => 'CDT', 'min_value' => 1],
        ];
        $attendance_query_main = $board_round_report_query->select(\DB::raw('DATE(created_at) AS date'));

        foreach (array_keys($frontend_roles) as $role) {
            if (strtolower($role) === 'nursing') {
                $attendance_query_main->addSelect(\DB::raw("SUM(CASE WHEN FIND_IN_SET('Bay Nurse', role) OR FIND_IN_SET('Complex Discharge Nurse', role) OR FIND_IN_SET('Specialist Nurse', role) THEN 1 ELSE 0 END) as `$role`"));
            } else {
                $attendance_query_main->addSelect(\DB::raw("SUM(CASE WHEN FIND_IN_SET('$role', role) THEN 1 ELSE 0 END) as `$role`"));
            }
        }


        $attendance_query_main = $attendance_query_main
            ->groupBy(\DB::raw('DATE(created_at)'), 'ward_id')
            ->orderBy('history_id', 'asc')
            ->get()
            ->toArray();
        $attendance_query = [];

        foreach ($attendance_query_main as $entry) {
            $atd_date = $entry['date'];

            if (!isset($attendance_query[$atd_date])) {
                $attendance_query[$atd_date] = ['date' => $atd_date];
            }

            foreach ($entry as $key => $value) {
                if ($key === 'date') continue;

                if (!isset($attendance_query[$atd_date][$key])) {
                    $attendance_query[$atd_date][$key] = 0;
                }

                $attendance_query[$atd_date][$key] += (int)$value;
            }
        }
        $attendance_results = [];
        foreach ($date_range as $date) {
            foreach (array_keys($frontend_roles) as $role) {
                $attendance_results[$role][$date] = 0;
            }
        }
        foreach ($attendance_query as $result) {
            foreach (array_keys($frontend_roles) as $role) {
                $attendance_results[$role][$result['date']] = intval($result[$role]);
            }
        }

        $board_round_attendance_weeks_split = array_chunk($attendance_results, 5, true);

        $current_week = Carbon::now()->week;
        $previous_weeks = [
            'Week_-1' => Carbon::now()->subWeek()->week,
            'Week_-2' => Carbon::now()->subWeeks(2)->week,
            'Week_-3' => Carbon::now()->subWeeks(3)->week,
        ];

        $attendance_data = [
            'Current_Week' => [],
            'Week_-1' => [],
            'Week_-2' => [],
            'Week_-3' => [],
        ];

        foreach ($board_round_attendance_weeks_split as $data_array) {
            foreach ($data_array as $key => $value) {
                foreach (['Current_Week', 'Week_-1', 'Week_-2', 'Week_-3'] as $week) {
                    if (!isset($attendance_data[$week][$key])) {
                        $attendance_data[$week][$key] = 0;
                    }
                }

                foreach ($value as $date => $count) {
                    $date_time = Carbon::createFromFormat('Y-m-d', $date);
                    $week_number = $date_time->week;

                    if ($week_number == $current_week) {
                        $attendance_data['Current_Week'][$key] += $count;
                    } elseif ($week_number == $previous_weeks['Week_-1']) {
                        $attendance_data['Week_-1'][$key] += $count;
                    } elseif ($week_number == $previous_weeks['Week_-2']) {
                        $attendance_data['Week_-2'][$key] += $count;
                    } elseif ($week_number == $previous_weeks['Week_-3']) {
                        $attendance_data['Week_-3'][$key] += $count;
                    }
                }
            }
        }



        $last_5_weeks = [];
        for ($i = 0; $i < 6; $i++) {
            $week_start_date = $current_date->copy()->subWeeks($i);

            for ($j = 0; $j < 7; $j++) {
                $date = $week_start_date->copy()->addDays($j);

                $last_5_weeks[] = $date->toDateString();
            }
        }

        foreach ($last_5_weeks as $dates) {
            $discharges_by_week[$dates] = [
                'midnight_midday' => 0,
                'midday_4pm' => 0,
                '4pm_midnight' => 0,
            ];
        }


        $in_patient_records = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->whereNull('camis_patient_discharge_date_time')->select('camis_patient_admission_date', 'camis_patient_id', 'camis_patient_sex', 'camis_patient_age')->whereIn('ibox_ward_id', $ward_array)
            ->get()->toArray();
        $out_patients_record = CamisIboxWardPatientInformationWithBedDetailsFullList::when($ward_type == 'surgical', function ($q) {
            return $q->whereRaw("LOWER(ip_admission_type_description) LIKE ?", ['%non-elective%']);
        })->whereIn('camis_patient_ward_id', $ward_array)->whereNotNull('camis_patient_discharge_date_time')->orderBy('camis_patient_discharge_date_time', 'desc')->whereIn(\DB::raw('DATE(camis_patient_discharge_date_time)'), $last_5_weeks)->get()->toArray();


        $average_los = 0;
        $average_discharges_los = 0;
        $male_female_age_wise = [];
        $male_below_25_avg_count = 0;
        $male_below_25_data = [];
        $male_below_26_49_avg_count = 0;
        $male_below_26_49_data = [];
        $male_below_50_74_avg_count = 0;
        $male_below_50_74_data = [];
        $male_below_75_84_avg_count = 0;
        $male_below_75_84_data = [];
        $male_below_85_avg_count = 0;
        $male_below_85_data = [];
        $female_below_25_avg_count = 0;
        $female_below_25_data = [];
        $female_below_26_49_avg_count = 0;
        $female_below_26_49_data = [];
        $female_below_50_74_avg_count = 0;
        $female_below_50_74_data = [];
        $female_below_75_84_avg_count = 0;
        $female_below_75_84_data = [];
        $female_below_85_avg_count = 0;
        $female_below_85_data = [];

        $total_los['0_4'] = 0;
        $total_los['5_6'] = 0;
        $total_los['7_14'] = 0;
        $total_los['15_21'] = 0;
        $total_los['22_plus'] = 0;

        $_7_to_13_stranded = 0;
        $_14_to_20_stranded = 0;
        $_21_more_stranded = 0;

        foreach ($in_patient_records as $row) {
            $admission_date = Carbon::parse($row['camis_patient_admission_date']);
            $average_los += Carbon::now()->diffInDays($admission_date);
            $diffInDays = Carbon::now()->diffInDays($admission_date);

            if ($row['camis_patient_age'] <= 25 && strtolower($row['camis_patient_sex']) == 'male') {
                $male_below_25_data[] = $row;
                $male_below_25_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if ($row['camis_patient_age'] <= 25 && strtolower($row['camis_patient_sex']) == 'female') {
                $female_below_25_data[] = $row;
                $female_below_25_avg_count += Carbon::now()->diffInDays($admission_date);
            }

            if (($row['camis_patient_age'] >= 26 && $row['camis_patient_age'] <= 49) && strtolower($row['camis_patient_sex']) == 'male') {
                $male_below_26_49_data[] = $row;
                $male_below_26_49_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if (($row['camis_patient_age'] >= 26 && $row['camis_patient_age'] <= 49) && strtolower($row['camis_patient_sex']) == 'female') {
                $female_below_26_49_data[] = $row;
                $female_below_26_49_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if (($row['camis_patient_age'] >= 50 && $row['camis_patient_age'] <= 74) && strtolower($row['camis_patient_sex']) == 'male') {
                $male_below_50_74_data[] = $row;
                $male_below_50_74_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if (($row['camis_patient_age'] >= 50 && $row['camis_patient_age'] <= 74) && strtolower($row['camis_patient_sex']) == 'female') {
                $female_below_50_74_data[] = $row;
                $female_below_50_74_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if (($row['camis_patient_age'] >= 75 && $row['camis_patient_age'] <= 84) && strtolower($row['camis_patient_sex']) == 'male') {
                $male_below_75_84_data[] = $row;
                $male_below_75_84_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if (($row['camis_patient_age'] >= 75 && $row['camis_patient_age'] <= 84) && strtolower($row['camis_patient_sex']) == 'female') {
                $female_below_75_84_data[] = $row;
                $female_below_75_84_avg_count += Carbon::now()->diffInDays($admission_date);
            }

            if ($row['camis_patient_age'] >= 85 && strtolower($row['camis_patient_sex']) == 'male') {
                $male_below_85_data[] = $row;
                $male_below_85_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if ($row['camis_patient_age'] >= 85 && strtolower($row['camis_patient_sex']) == 'female') {
                $female_below_85_data[] = $row;
                $female_below_85_avg_count += Carbon::now()->diffInDays($admission_date);
            }
            if ($diffInDays <= 4) {
                $total_los['0_4']++;
            } elseif ($diffInDays >= 5 && $diffInDays <= 6) {
                $total_los['5_6']++;
            } elseif ($diffInDays >= 7 && $diffInDays <= 14) {
                $total_los['7_14']++;
            } elseif ($diffInDays >= 15 && $diffInDays <= 21) {
                $total_los['15_21']++;
            } elseif ($diffInDays >= 22) {
                $total_los['22_plus']++;
            }
            if ($diffInDays >= 7 && $diffInDays <= 13) {
                $_7_to_13_stranded++;
            } elseif ($diffInDays >= 14 && $diffInDays <= 20) {
                $_14_to_20_stranded++;
            } elseif ($diffInDays >= 21) {
                $_21_more_stranded++;
            }
        }

        $dis_male_below_25_avg_count = 0;
        $dis_male_below_25_data = [];
        $dis_male_below_26_49_avg_count = 0;
        $dis_male_below_26_49_data = [];
        $dis_male_below_50_74_avg_count = 0;
        $dis_male_below_50_74_data = [];
        $dis_male_below_75_84_avg_count = 0;
        $dis_male_below_75_84_data = [];
        $dis_male_below_85_avg_count = 0;
        $dis_male_below_85_data = [];
        $dis_female_below_25_avg_count = 0;
        $dis_female_below_25_data = [];
        $dis_female_below_26_49_avg_count = 0;
        $dis_female_below_26_49_data = [];
        $dis_female_below_50_74_avg_count = 0;
        $dis_female_below_50_74_data = [];
        $dis_female_below_75_84_avg_count = 0;
        $dis_female_below_75_84_data = [];
        $dis_female_below_85_avg_count = 0;
        $dis_female_below_85_data = [];
        foreach ($out_patients_record as $index => $out_row) {
            $discharge_date = Carbon::parse($out_row['camis_patient_discharge_date_time']);
            $admission_date = Carbon::parse($out_row['camis_patient_admission_date_time']);
            $day_difference = $discharge_date->diffInDays($admission_date);
            if ($index < 101) {

                $average_discharges_los += $day_difference;

                if ($out_row['camis_patient_age'] <= 25 && strtolower($out_row['camis_patient_sex']) == 'male') {
                    $dis_male_below_25_data[] = $out_row;
                    $dis_male_below_25_avg_count += $day_difference;
                }
                if ($out_row['camis_patient_age'] <= 25 && strtolower($out_row['camis_patient_sex']) == 'female') {
                    $dis_female_below_25_data[] = $out_row;
                    $dis_female_below_25_avg_count += $day_difference;
                }
                if (($out_row['camis_patient_age'] >= 26 && $out_row['camis_patient_age'] <= 49) && strtolower($out_row['camis_patient_sex']) == 'male') {
                    $dis_male_below_26_49_data[] = $out_row;
                    $dis_male_below_26_49_avg_count += $day_difference;
                }
                if (($out_row['camis_patient_age'] >= 26 && $out_row['camis_patient_age'] <= 49) && strtolower($out_row['camis_patient_sex']) == 'female') {
                    $dis_female_below_26_49_data[] = $out_row;
                    $dis_female_below_26_49_avg_count += $day_difference;
                }

                if (($out_row['camis_patient_age'] >= 50 && $out_row['camis_patient_age'] <= 74) && strtolower($out_row['camis_patient_sex']) == 'male') {
                    $dis_male_below_50_74_data[] = $out_row;
                    $dis_male_below_50_74_avg_count += $day_difference;
                }
                if (($out_row['camis_patient_age'] >= 50 && $out_row['camis_patient_age'] <= 74) && strtolower($out_row['camis_patient_sex']) == 'female') {
                    $dis_female_below_50_74_data[] = $out_row;
                    $dis_female_below_50_74_avg_count += $day_difference;
                }

                if (($out_row['camis_patient_age'] >= 75 && $out_row['camis_patient_age'] <= 84) && strtolower($out_row['camis_patient_sex']) == 'male') {
                    $dis_male_below_75_84_data[] = $out_row;
                    $dis_male_below_75_84_avg_count += $day_difference;
                }
                if (($out_row['camis_patient_age'] >= 75 && $out_row['camis_patient_age'] <= 84) && strtolower($out_row['camis_patient_sex']) == 'female') {
                    $dis_female_below_75_84_data[] = $out_row;
                    $dis_female_below_75_84_avg_count += $day_difference;
                }

                if ($out_row['camis_patient_age'] >= 85 && strtolower($out_row['camis_patient_sex']) == 'male') {
                    $dis_male_below_85_data[] = $out_row;
                    $dis_male_below_85_avg_count += $day_difference;
                }
                if ($out_row['camis_patient_age'] >= 85 && strtolower($out_row['camis_patient_sex']) == 'female') {
                    $dis_female_below_85_data[] = $out_row;
                    $dis_female_below_85_avg_count += $day_difference;
                }
            }
            if (in_array(date('Y-m-d', strtotime($out_row['camis_patient_discharge_date_time'])), $last_5_weeks)) {
                $hour = (int) Carbon::parse($out_row['camis_patient_discharge_date_time'])->format('H');
                $week_start = $discharge_date->copy()->format('Y-m-d');

                if ($hour >= 0 && $hour < 12) {
                    $discharges_by_week[$week_start]['midnight_midday'] += 1;
                } elseif ($hour >= 12 && $hour < 16) {
                    $discharges_by_week[$week_start]['midday_4pm'] += 1;
                } else {
                    $discharges_by_week[$week_start]['4pm_midnight'] += 1;
                }
            }
        }





        if ($average_los > 0 || count($in_patient_records) > 0) {
            $total_avg_inpatient_los = intval($average_los / count($in_patient_records));
        } else {
            $total_avg_inpatient_los = 0;
        }
        if ($average_discharges_los > 0 || count($out_patients_record) > 0) {
            $total_avg_outpatient_los = intval($average_discharges_los / count($out_patients_record));
        } else {
            $total_avg_outpatient_los = 0;
        }

        if ($dis_male_below_25_avg_count > 0 || count($dis_male_below_25_data) > 0) {
            $male_female_age_wise['below_25']['avg_male_disch'] = intval($dis_male_below_25_avg_count / count($dis_male_below_25_data));
        } else {
            $male_female_age_wise['below_25']['avg_male_disch'] = 0;
        }

        if ($male_below_25_avg_count > 0 || count($male_below_25_data) > 0) {
            $male_female_age_wise['below_25']['avg_male'] = intval($male_below_25_avg_count / count($male_below_25_data));
        } else {
            $male_female_age_wise['below_25']['avg_male'] = 0;
        }
        $male_female_age_wise['below_25']['male_total'] = count($male_below_25_data);


        if ($dis_male_below_26_49_avg_count > 0 || count($dis_male_below_26_49_data) > 0) {
            $male_female_age_wise['below_26_49']['avg_male_disch'] = intval($dis_male_below_26_49_avg_count / count($dis_male_below_26_49_data));
        } else {
            $male_female_age_wise['below_26_49']['avg_male_disch'] = 0;
        }

        if ($male_below_26_49_avg_count > 0 || count($male_below_26_49_data) > 0) {
            $male_female_age_wise['below_26_49']['avg_male'] = intval($male_below_26_49_avg_count / count($male_below_26_49_data));
        } else {
            $male_female_age_wise['below_26_49']['avg_male'] = 0;
        }
        $male_female_age_wise['below_26_49']['male_total'] = count($male_below_26_49_data);



        if ($dis_male_below_50_74_avg_count > 0 || count($dis_male_below_50_74_data) > 0) {
            $male_female_age_wise['below_50_74']['avg_male_disch'] = intval($dis_male_below_50_74_avg_count / count($dis_male_below_50_74_data));
        } else {
            $male_female_age_wise['below_50_74']['avg_male_disch'] = 0;
        }


        if ($male_below_50_74_avg_count > 0 || count($male_below_50_74_data) > 0) {
            $male_female_age_wise['below_50_74']['avg_male'] = intval($male_below_50_74_avg_count / count($male_below_50_74_data));
        } else {
            $male_female_age_wise['below_50_74']['avg_male'] = 0;
        }
        $male_female_age_wise['below_50_74']['male_total'] = count($male_below_50_74_data);



        if ($dis_male_below_75_84_avg_count > 0 || count($dis_male_below_75_84_data) > 0) {
            $male_female_age_wise['below_75_84']['avg_male_disch'] = intval($dis_male_below_75_84_avg_count / count($dis_male_below_75_84_data));
        } else {
            $male_female_age_wise['below_75_84']['avg_male_disch'] = 0;
        }


        if ($male_below_75_84_avg_count > 0 || count($male_below_75_84_data) > 0) {
            $male_female_age_wise['below_75_84']['avg_male'] = intval($male_below_75_84_avg_count / count($male_below_75_84_data));
        } else {
            $male_female_age_wise['below_75_84']['avg_male'] = 0;
        }
        $male_female_age_wise['below_75_84']['male_total'] = count($male_below_75_84_data);





        if ($dis_male_below_85_avg_count > 0 || count($dis_male_below_85_data) > 0) {
            $male_female_age_wise['below_85']['avg_male_disch'] = intval($dis_male_below_85_avg_count / count($dis_male_below_85_data));
        } else {
            $male_female_age_wise['below_85']['avg_male_disch'] = 0;
        }


        if ($male_below_85_avg_count > 0 || count($male_below_85_data) > 0) {
            $male_female_age_wise['below_85']['avg_male'] = intval($male_below_85_avg_count / count($male_below_85_data));
        } else {
            $male_female_age_wise['below_85']['avg_male'] = 0;
        }
        $male_female_age_wise['below_85']['male_total'] = count($male_below_85_data);


        if ($dis_female_below_25_avg_count > 0 || count($dis_female_below_25_data) > 0) {
            $male_female_age_wise['below_25']['avg_female_disch'] = intval($dis_female_below_25_avg_count / count($dis_female_below_25_data));
        } else {
            $male_female_age_wise['below_25']['avg_female_disch'] = 0;
        }

        if ($dis_female_below_26_49_avg_count > 0 || count($dis_female_below_26_49_data) > 0) {
            $male_female_age_wise['below_26_49']['avg_female_disch'] = intval($dis_female_below_26_49_avg_count / count($dis_female_below_26_49_data));
        } else {
            $male_female_age_wise['below_26_49']['avg_female_disch'] = 0;
        }


        if ($dis_female_below_50_74_avg_count > 0 || count($dis_female_below_50_74_data) > 0) {
            $male_female_age_wise['below_50_74']['avg_female_disch'] = intval($dis_female_below_50_74_avg_count / count($dis_female_below_50_74_data));
        } else {
            $male_female_age_wise['below_50_74']['avg_female_disch'] = 0;
        }



        if ($dis_female_below_75_84_avg_count > 0 || count($dis_female_below_75_84_data) > 0) {
            $male_female_age_wise['below_75_84']['avg_female_disch'] = intval($dis_female_below_75_84_avg_count / count($dis_female_below_75_84_data));
        } else {
            $male_female_age_wise['below_75_84']['avg_female_disch'] = 0;
        }



        if ($dis_female_below_85_avg_count > 0 || count($dis_female_below_85_data) > 0) {
            $male_female_age_wise['below_85']['avg_female_disch'] = intval($dis_female_below_85_avg_count / count($dis_female_below_85_data));
        } else {
            $male_female_age_wise['below_85']['avg_female_disch'] = 0;
        }


        if ($female_below_25_avg_count > 0 || count($female_below_25_data) > 0) {
            $male_female_age_wise['below_25']['avg_female'] = intval($female_below_25_avg_count / count($female_below_25_data));
        } else {
            $male_female_age_wise['below_25']['avg_female'] = 0;
        }
        $male_female_age_wise['below_25']['female_total'] = count($female_below_25_data);


        if ($female_below_26_49_avg_count > 0 || count($female_below_26_49_data) > 0) {
            $male_female_age_wise['below_26_49']['avg_female'] = intval($female_below_26_49_avg_count / count($female_below_26_49_data));
        } else {
            $male_female_age_wise['below_26_49']['avg_female'] = 0;
        }
        $male_female_age_wise['below_26_49']['female_total'] = count($female_below_26_49_data);


        if ($female_below_50_74_avg_count > 0 || count($female_below_50_74_data) > 0) {
            $male_female_age_wise['below_50_74']['avg_female'] = intval($female_below_50_74_avg_count / count($female_below_50_74_data));
        } else {
            $male_female_age_wise['below_50_74']['avg_female'] = 0;
        }
        $male_female_age_wise['below_50_74']['female_total'] = count($female_below_50_74_data);


        if ($female_below_75_84_avg_count > 0 || count($female_below_75_84_data) > 0) {
            $male_female_age_wise['below_75_84']['avg_female'] = intval($female_below_75_84_avg_count / count($female_below_75_84_data));
        } else {
            $male_female_age_wise['below_75_84']['avg_female'] = 0;
        }
        $male_female_age_wise['below_75_84']['female_total'] = count($female_below_75_84_data);

        if ($female_below_85_avg_count > 0 || count($female_below_85_data) > 0) {
            $male_female_age_wise['below_85']['avg_female'] = intval($female_below_85_avg_count / count($female_below_85_data));
        } else {
            $male_female_age_wise['below_85']['avg_female'] = 0;
        }
        $male_female_age_wise['below_85']['female_total'] = count($female_below_85_data);






        $patient_tasks = CamisIboxBoardRoundPatientTasks::whereIn('patient_id', array_column($in_patient_records, "camis_patient_id"))->select('task_completed_status', 'task_not_applicable_status')->get()->toArray();
        $count_task['created'] = count($patient_tasks);
        $count_task['completed'] = 0;
        $count_task['outstanding'] = 0;
        foreach ($patient_tasks as $task) {
            if ($task['task_completed_status'] == 1) {
                $count_task['completed']++;
            } else {
                $count_task['outstanding']++;
            }
        }


        $ward_los_string = $ward_type . '_ward_los_';
        $amu_1 = 'RLTAMU01_ward_los_';
        $amu_2 = 'RLTAMU02_ward_los_';
        $daily_summary = CamisIboxCalculatedDailySummary::whereIn('date', $last_30_days)
            ->when(
                $ward_type === 'amu',
                function ($q) use ($amu_1, $amu_2) {
                    $q->where(function ($q2) use ($amu_1, $amu_2) {
                        $q2->where('summary_key', 'like', $amu_1 . '%')
                            ->orWhere('summary_key', 'like', $amu_2 . '%');
                    });
                },
                function ($q) use ($ward_los_string) {
                    $q->where('summary_key', 'like', $ward_los_string . '%');
                }
            )
            ->get()
            ->toArray();
        $camis_data = CamisDailySummaryArrayRearrange($daily_summary);

        $_7_to_13_los = array();
        $_14_to_20_los = array();
        $_21_more_los = array();
        foreach ($last_30_days as $date) {
            $_7_to_13_los[$date] = 0;
            $_14_to_20_los[$date] = 0;
            $_21_more_los[$date] = 0;
        }

        foreach ($camis_data as $date_key => $summary) {

            if ($ward_type != 'amu') {
                if (isset($summary[$ward_type . '_ward_los_7_13'])) {
                    $_7_to_13_los[$date_key] = $summary[$ward_type . '_ward_los_7_13'];
                }
                if (isset($summary[$ward_type . '_ward_los_14_20'])) {
                    $_14_to_20_los[$date_key] = $summary[$ward_type . '_ward_los_14_20'];
                }
                if (isset($summary[$ward_type . '_ward_los_over_20'])) {
                    $_21_more_los[$date_key] = $summary[$ward_type . '_ward_los_over_20'];
                }
            } else {

                $amu1 = 'RLTAMU01';
                $amu2 = 'RLTAMU02';

                $los_7_13  = ($summary[$amu1 . '_ward_los_7_13']  ?? 0) + ($summary[$amu2 . '_ward_los_7_13']  ?? 0);
                $los_14_20 = ($summary[$amu1 . '_ward_los_14_20'] ?? 0) + ($summary[$amu2 . '_ward_los_14_20'] ?? 0);
                $los_21p   = ($summary[$amu1 . '_ward_los_over_20'] ?? 0) + ($summary[$amu2 . '_ward_los_over_20'] ?? 0);

                if ($los_7_13 !== 0) {
                    $_7_to_13_los[$date_key]  = $los_7_13;
                }
                if ($los_14_20 !== 0) {
                    $_14_to_20_los[$date_key] = $los_14_20;
                }
                if ($los_21p !== 0) {
                    $_21_more_los[$date_key]  = $los_21p;
                }
            }
        }





        $weekly_discharges_record = collect($discharges_by_week);

        $discharge_by_week_final_data = [];

        for ($i = 0; $i <= 5; $i++) {
            $week_start = Carbon::now()->startOfWeek()->subWeeks($i)->format('Y-m-d');
            $week_end = Carbon::now()->endOfWeek()->subWeeks($i)->format('Y-m-d');

            $week_label = $i === 0 ? 'current_week' : "previous_week_$i";

            $filtered = $weekly_discharges_record->filter(function ($value, $key) use ($week_start, $week_end) {
                return $key >= $week_start && $key <= $week_end;
            });

            $discharge_by_week_final_data[$week_label] = [
                'midnight_midday' => $filtered->sum('midnight_midday'),
                'midday_4pm' => $filtered->sum('midday_4pm'),
                '4pm_midnight' => $filtered->sum('4pm_midnight'),
            ];
        }





        $board_round_target                             =   Wards::whereIn('id', $ward_array)->sum('ward_daily_goal');








        $success_array["board_round_target"]                                               = $board_round_target;



        $success_array['average_inpatient_los']                                            = intval($total_avg_inpatient_los);
        $success_array['average_outpatient_los']                                           = intval($total_avg_outpatient_los);
        $success_array["attendance_roles_designations"]                                    = $frontend_roles;
        $success_array["task_count"]                                                       = $count_task;
        $success_array["total_los_daywise"]                                                = $total_los;
        $success_array["total_7_13_count"]                                                 = $_7_to_13_stranded;
        $success_array["total_13_20_count"]                                                = $_14_to_20_stranded;
        $success_array["total_21_more_count"]                                              = $_21_more_stranded;


        $success_array["7_13_patients_los"]                                                = $_7_to_13_los;
        $success_array["14_20_patients_los"]                                               = $_14_to_20_los;
        $success_array["20_over_patients_los"]                                             = $_21_more_los;
        $success_array["board_store_search_array"]                                         = $ward_summary_by_week;
        $success_array['boardround_attendance_array']                                      = $attendance_data;
        $success_array['male_female_wise_data']                                            = $male_female_age_wise;
        $success_array['dischagre_by_week']                                                = $discharge_by_week_final_data;
        $success_array['last_30_days']                                                     = $last_30_days_format;
        $success_array['ward_array']                                                       = $ward_array;
        $success_array['dates_array'] = $dates_array;

        $view                                                           = View::make('Dashboards.Camis.WardPerformance.WardTypeDataLoad', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function WardBoardRoundReport(Request $request)
    {
        $week = $request->week;
        $day_name = $request->day;
        $ward_type = $request->ward_type;
        $date = $this->GetDateByWeekAndDay($week, $day_name);

        $all_wards = Wards::query()->when(
            $ward_type === 'amu',
            fn($q) => $q->whereIn('ward_short_name', ['RLTAMU01', 'RLTAMU02']),

            function ($q) use ($ward_type) {
                return $q->when($ward_type === 'medical', fn($q) => $q->where('ward_type_primary', 13))
                    ->when($ward_type === 'surgical', fn($q) => $q->where('ward_type_primary', 14))
                    ->when($ward_type === 'others', fn($q) => $q->where('ward_type_primary', 16))
                    ->when(is_numeric($ward_type), fn($q) => $q->where('id', $ward_type))
                    ->whereNotIn('ward_short_name', ['RLTAMU01', 'RLTAMU02']);
            }
        )
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
            ->whereDate('created_at', $date)
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
        }
        ksort($board_round_chart_results);
        $view = View::make('Dashboards.Camis.WardPerformance.BoardRoundReportOffcanvasData', compact('board_round_chart_results', 'date'));
        return $view->render();
    }

    function GetWeekdays($weeks = 4)
    {
        $weekdays = [];

        for ($i = 0; $i < $weeks; $i++) {
            $weekKey = $i === 0 ? 'current_week' : "previous_week_$i";

            $monday = Carbon::now()->startOfWeek()->subWeeks($i);
            $friday = $monday->copy()->addDays(4);

            $period = CarbonPeriod::create($monday, $friday);

            $weekdays[$weekKey] = array_map(fn($date) => $date->toDateString(), iterator_to_array($period));
        }

        $today = Carbon::now();
        $monday = $today->copy()->startOfWeek(Carbon::MONDAY);

        $partialPeriod = CarbonPeriod::create($monday, $today);
        $weekdays['current_week_partial'] = array_map(fn($date) => $date->toDateString(), iterator_to_array($partialPeriod));

        return $weekdays;
    }

    function GetDateByWeekAndDay(string $weekKey, string $dayName): ?string
    {

        $dayName = ucfirst(strtolower($dayName));

        $validDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        if (!in_array($dayName, $validDays)) {
            return null;
        }

        if ($weekKey === 'current_week') {
            $weekOffset = 0;
        } elseif (preg_match('/^previous_week_(\d+)$/', $weekKey, $matches)) {
            $weekOffset = (int)$matches[1];
        } else {
            return null;
        }

        $monday = Carbon::now()->startOfWeek(Carbon::MONDAY)->subWeeks($weekOffset);

        $targetDate = $monday->copy()->addDays(array_search($dayName, $validDays));

        return $targetDate->toDateString();
    }
}
