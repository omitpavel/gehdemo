<?php

namespace App\Http\Controllers\DataAutoLoad\Symphony;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use App\Http\Controllers\Common\HistoryController;
use App\Models\Iboards\Symphony\View\SymphonyAttendanceView;
use App\Models\Iboards\Symphony\View\SymphonyAneAttendanceLiveDataSummaryView;
use App\Models\Iboards\Symphony\Data\SymphonyAttendanceCalculatedDailyEDSummary;
use App\Models\Iboards\Symphony\Data\SymphonyAttendanceCalculatedHourlyEDSummary;
use App\Models\Governance\LogReplicationAutomatedJobLogStatus;

class AttendanceSummaryDataAutoController extends Controller
{
    public function AttendanceSummaryDataAutoInsert()
    {

        $common_controller                                  = new CommonController;
        $common_symphony_controller                         = new CommonSymphonyController;
        $history_controller                                 = new HistoryController;
        $auto_user_id                                       = 0;
        $process_array                                      = array();
        $success_array                                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);
        $automated_job_log                                  = array('replication_job_name'   => 'Automated Calculated Daily Attendance Summary', 'replication_job_start_time' => now());
        $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);
        $process_array["start_date"]                        = CurrentDateOnFormat();


		$days_to_insert										= 15;
		$days_to_insert_plus								= $days_to_insert+3;

		$process_start_date                        			= $process_array["start_date"];
		$process_array["start_date"] 						= date("Y-m-d 00:00:00", strtotime($process_array["start_date"] . " -$days_to_insert_plus days"));
        $process_array["end_date"]  						= date("Y-m-d 23:59:59", strtotime($process_array["start_date"] . " +$days_to_insert_plus days"));
		$total_attendance  = SymphonyAttendanceView::whereBetween('symphony_discharge_date', array($process_array["start_date"], $process_array["end_date"]))->orderBy('symphony_sync_at', 'DESC')->get()->toArray();
        $attendance_array_date                              = array();
        for ($x = 0; $x < $days_to_insert; $x++)
        {
            $date_index_set                                 = date("Y-m-d", strtotime($process_start_date . " -$x days"));
            $attendance_array_date[$date_index_set]         = array();
        }
        if (count($total_attendance) > 0)
        {
            foreach ($total_attendance  as $row)
            {
                $row['symphony_discharge_date_alone']       = date('Y-m-d', strtotime($row['symphony_discharge_date']));
                if (isset($row['symphony_discharge_date_alone']) && $row['symphony_discharge_date_alone'] != '')
                {
                    if (isset($attendance_array_date[$row['symphony_discharge_date_alone']]))
                    {
                        $attendance_array_date[$row['symphony_discharge_date_alone']][] = $row;
                    }
                }
            }
        }


        $attendance_details_array                           = array();
        $key_value_index_arr                                = array();
        $key_value_index_arr[]                              = 'symphony_attendance';

        $key_value_index_arr[]                              = 'symphony_admitted';
        $key_value_index_arr[]                              = 'symphony_discharged';
        $key_value_index_arr[]                              = 'symphony_breached';
        $key_value_index_arr[]                              = 'symphony_breached_admitted';
        $key_value_index_arr[]                              = 'symphony_breached_discharged';
        $key_value_index_arr[]                              = 'symphony_ambulance';
        $key_value_index_arr[]                              = 'symphony_ambulance_admitted';
        $key_value_index_arr[]                              = 'symphony_ambulance_discharged';
        $key_value_index_arr[]                              = 'symphony_ambulance_breached';
        $key_value_index_arr[]                              = 'symphony_walkin';
        $key_value_index_arr[]                              = 'symphony_walkin_admitted';
        $key_value_index_arr[]                              = 'symphony_walkin_discharged';
        $key_value_index_arr[]                              = 'symphony_walkin_breached';

        $key_value_index_arr[]                              = 'symphony_attendance_four_hours_plus';
        $key_value_index_arr[]                              = 'symphony_attendance_three_to_four_hour';
        $key_value_index_arr[]                              = 'symphony_attendance_two_to_three_hour';
        $key_value_index_arr[]                              = 'symphony_attendance_one_to_two_hour';
        $key_value_index_arr[]                              = 'symphony_attendance_less_than_one_hour';




        for ($x = 0; $x < $days_to_insert; $x++)
        {
            $date_index_set                                                                     = date("Y-m-d", strtotime($process_start_date . " -$x days"));
            foreach ($key_value_index_arr as $val)
            {
                $attendance_details_array[$date_index_set][$val]['ed_summary_date']             =  $date_index_set;
                $attendance_details_array[$date_index_set][$val]['ed_summary_key_value']        =  $val;
                $attendance_details_array[$date_index_set][$val]['ed_summary_value']            =  0;
            }
        }

        if (count($attendance_array_date) > 0)
        {
            foreach ($attendance_array_date as $key => $all_atten_arr)
            {
                if (count($all_atten_arr) > 0)
                {
                    $all_admitted_discharge_today                                           =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($all_atten_arr, $process_array);
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance', count($all_atten_arr));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_admitted', count($all_admitted_discharge_today['admitted_patients']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_discharged', count($all_admitted_discharge_today['discharged_patients']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_breached', count($all_admitted_discharge_today['breached_patients']));

                    $all_breached_admitted_discharge_today                                  =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($all_admitted_discharge_today['breached_patients'], $process_array);
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_breached_admitted', count($all_breached_admitted_discharge_today['admitted_patients']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_breached_discharged', count($all_breached_admitted_discharge_today['discharged_patients']));

                    $ambulance_walkin_data_array                                            =  $common_symphony_controller->AmbulanceWalkinArrayProcess($all_atten_arr);
                    $all_ambulance_admitted_discharge_today                                 =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($ambulance_walkin_data_array['ambulance_arrival'], $process_array);
                    $all_walkin_admitted_discharge_today                                    =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($ambulance_walkin_data_array['walkin_arrival'], $process_array);
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_ambulance', count($ambulance_walkin_data_array['ambulance_arrival']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_ambulance_admitted', count($all_ambulance_admitted_discharge_today['admitted_patients']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_ambulance_discharged', count($all_ambulance_admitted_discharge_today['discharged_patients']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_ambulance_breached', count($all_ambulance_admitted_discharge_today['breached_patients']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_walkin', count($ambulance_walkin_data_array['walkin_arrival']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_walkin_admitted', count($all_walkin_admitted_discharge_today['admitted_patients']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_walkin_discharged', count($all_walkin_admitted_discharge_today['discharged_patients']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_walkin_breached', count($all_walkin_admitted_discharge_today['breached_patients']));

                    $all_attendance_today_with_hour_classification                          =  $common_symphony_controller->GetAttendancePatientTimeInDepartment($all_atten_arr, $process_array);
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_four_hours_plus', count($all_attendance_today_with_hour_classification['hour_240']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_three_to_four_hour', count($all_attendance_today_with_hour_classification['hour_180']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_two_to_three_hour', count($all_attendance_today_with_hour_classification['hour_120']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_one_to_two_hour', count($all_attendance_today_with_hour_classification['hour_60']));
                    $this->ValueSetIfExistEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_less_than_one_hour', count($all_attendance_today_with_hour_classification['hour_0']));








                    $attendance_location_specific_today                                     = $common_controller->ArrayColumnCategoryWiseGrouping($all_atten_arr, 'symphony_final_location');
                    $attendance_location_specific_today['Majors']                           = $attendance_location_specific_today['Majors'] ?? array();
                    $attendance_location_specific_today['UTC']                              = $attendance_location_specific_today['UTC'] ?? array();
                    $attendance_location_specific_today['Resus']                            = $attendance_location_specific_today['Resus'] ?? array();
                    $attendance_location_specific_today['Patients Awaiting Allocation']     = $attendance_location_specific_today['Patients Awaiting Allocation'] ?? array();
                    $attendance_location_specific_today['Paed Eds']                         = $attendance_location_specific_today['Paed Eds'] ?? array();
                    $attendance_location_specific_today['Others']                           = $attendance_location_specific_today['Others'] ?? array();
                    $attendance_location_specific_today['Others']                           = array_merge($attendance_location_specific_today['Others'], $attendance_location_specific_today['Patients Awaiting Allocation']);


                    $attendance_location_specific_today_breached_Majors                             =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($attendance_location_specific_today['Majors'], $process_array);
                    $attendance_location_specific_today_breached_UTC                                =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($attendance_location_specific_today['UTC'], $process_array);
                    $attendance_location_specific_today_breached_Resus                              =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($attendance_location_specific_today['Resus'], $process_array);
                    $attendance_location_specific_today_breached_Paed_Eds                              =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($attendance_location_specific_today['Paed Eds'], $process_array);
                    $attendance_location_specific_today_breached_Others                              =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($attendance_location_specific_today['Others'], $process_array);

                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_majors', count($attendance_location_specific_today['Majors']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_admitted_majors', count($attendance_location_specific_today_breached_Majors['admitted_patients']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_discharged_majors', count($attendance_location_specific_today_breached_Majors['discharged_patients']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_breached_majors', count($attendance_location_specific_today_breached_Majors['breached_patients']));


                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_utc', count($attendance_location_specific_today['UTC']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_admitted_utc', count($attendance_location_specific_today_breached_UTC['admitted_patients']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_discharged_utc', count($attendance_location_specific_today_breached_UTC['discharged_patients']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_breached_utc', count($attendance_location_specific_today_breached_UTC['breached_patients']));

                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_resus', count($attendance_location_specific_today['Resus']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_admitted_resus', count($attendance_location_specific_today_breached_Resus['admitted_patients']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_discharged_resus', count($attendance_location_specific_today_breached_Resus['discharged_patients']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_breached_resus', count($attendance_location_specific_today_breached_Resus['breached_patients']));

                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_paed_eds', count($attendance_location_specific_today['Paed Eds']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_admitted_paed_eds', count($attendance_location_specific_today_breached_Paed_Eds['admitted_patients']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_discharged_paed_eds', count($attendance_location_specific_today_breached_Paed_Eds['discharged_patients']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_breached_paed_eds', count($attendance_location_specific_today_breached_Paed_Eds['breached_patients']));

                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_others', count($attendance_location_specific_today['Others']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_admitted_others', count($attendance_location_specific_today_breached_Others['admitted_patients']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_discharged_others', count($attendance_location_specific_today_breached_Others['discharged_patients']));
                    $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_breached_others', count($attendance_location_specific_today_breached_Others['breached_patients']));

































                    $speciality_attendance_data_array                                       =  $common_symphony_controller->PatientAllSpecialityArrayProcess($all_atten_arr);
                    if (count($speciality_attendance_data_array) > 0)
                    {
                        foreach ($speciality_attendance_data_array  as $key_spec => $val_spec)
                        {
                            $all_spec_admitted_discharge                                    =  array();
                            $all_spec_admitted_discharge                                    =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($val_spec, $process_array);
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_speciality_' . $key_spec, count($val_spec));
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_breached_speciality_' . $key_spec, count($all_spec_admitted_discharge['breached_patients']));
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_admitted_speciality_' . $key_spec, count($all_spec_admitted_discharge['admitted_patients']));
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_discharged_speciality_' . $key_spec, count($all_spec_admitted_discharge['discharged_patients']));
                        }
                    }












                    $all_attendance_today_with_category_type_array                          = $common_symphony_controller->GetAnePatientCategorySplitUpArrayWithAllAtdTypesForSummary($all_atten_arr, $process_array);
                    if (count($all_attendance_today_with_category_type_array) > 0)
                    {
                        foreach ($all_attendance_today_with_category_type_array  as $key_type => $val_type)
                        {
                            $all_type_admitted_discharge                                    =  array();
                            $all_type_admitted_discharge                                    =  $common_symphony_controller->AdmittedDischargedBreachedArrayProcess($val_type, $process_array);
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_attendance_attendance_type_' . $key_type, count($val_type));
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_breached_attendance_type_' . $key_type, count($all_type_admitted_discharge['breached_patients']));
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_admitted_attendance_type_' . $key_type, count($all_type_admitted_discharge['admitted_patients']));
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_discharged_attendance_type_' . $key_type, count($all_type_admitted_discharge['discharged_patients']));

                            $attendance_with_hour_classification_attendance_type            =  array();
                            $attendance_with_hour_classification_attendance_type            =  $common_symphony_controller->GetAttendancePatientTimeInDepartment($val_type, $process_array);

                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_four_hours_plus_type_' . $key_type, count($attendance_with_hour_classification_attendance_type['hour_240']));
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_three_to_four_hour_type_' . $key_type, count($attendance_with_hour_classification_attendance_type['hour_180']));
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_two_to_three_hour_type_' . $key_type, count($attendance_with_hour_classification_attendance_type['hour_120']));
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_one_to_two_hour_type_' . $key_type, count($attendance_with_hour_classification_attendance_type['hour_60']));
                            $this->ValueSetEdSummaryArrayInsert($attendance_details_array, $key, 'symphony_less_than_one_hour_type_' . $key_type, count($attendance_with_hour_classification_attendance_type['hour_0']));
                        }
                    }



















                }
            }
        }



        if (count($attendance_details_array) > 0)
        {
            foreach ($attendance_details_array as $key_1 => $val_1)
            {

                if (count($val_1) > 0)
                {
                    foreach ($val_1 as $key_2 => $val_2)
                    {
                        SymphonyAttendanceCalculatedDailyEDSummary::updateOrCreate(['ed_summary_date' => $val_2['ed_summary_date'],'ed_summary_key_value' => $val_2['ed_summary_key_value']], $val_2);
                    }
                }
            }
        }
        $replication_job_end_time                           = date('Y-m-d H:i:s');
        $automated_job_log                                  = array('replication_job_end_time'   => now(), 'replication_job_log_status' => 1);
        LogReplicationAutomatedJobLogStatus::where('id', $automated_job_log_id)->update($automated_job_log);
    }



    public function AttendanceSummaryHourlyDataAutoInsert()
    {

        $common_controller                                  = new CommonController;
        $common_symphony_controller                         = new CommonSymphonyController;
        $history_controller                                 = new HistoryController;
        $auto_user_id                                       = 0;
        $process_array                                      = array();
        $success_array                                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);



        $automated_job_log                                  = array('replication_job_name'   => 'Automated Calculated Hourly Attendance Summary', 'replication_job_start_time' => now());
        $automated_job_log_id                               = LogReplicationAutomatedJobLogStatus::insertGetId($automated_job_log);
        $still_in_ed_hourly_attendance                      = SymphonyAneAttendanceLiveDataSummaryView::get()->toArray();


        if (count($still_in_ed_hourly_attendance) > 0)
        {
            $key_array                                      = array();
            $key_array['ed_summary_date']                   = date('Y-m-d');
            $key_array['ed_summary_time']                   = date('H:00:00');
            $key_array['ed_summary_date_time']              = date('Y-m-d H:00:00');
            foreach ($still_in_ed_hourly_attendance  as $row)
            {
                $key_array[$row['keyvalue']]                = $row['val'];
            }
            SymphonyAttendanceCalculatedHourlyEDSummary::updateOrCreate(['ed_summary_date_time' => $key_array['ed_summary_date_time']], $key_array);
        }

        $number_of_days                                     = 10;
        $process_start_date_summary_hourly                  = CurrentDateOnFormat();
        for ($x = 0; $x < $number_of_days; $x++)
        {
            $start_date_summary_process                     = '';
            $end_date_summary_process                       = '';
            $number_of_days_forecast                        = 10;
            $summary_hourly_data                            = array();
            $start_date_summary_process                     = date("Y-m-d", strtotime($process_start_date_summary_hourly . " -$x days"));
            CalculateStartEndDateAccordingSelection($start_date_summary_process,$end_date_summary_process,"day");

            $start_date_summary_process_forecast            = date("Y-m-d 00:00:00", strtotime($start_date_summary_process . " -10 days"));
            $end_date_summary_process_forecast              = date("Y-m-d 23:59:59", strtotime($start_date_summary_process_forecast . " +9 days"));

            $attendance_arrivals                            = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($start_date_summary_process , $end_date_summary_process))->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
            $attendance_discharges                          = SymphonyAttendanceView::whereBetween('symphony_discharge_date', array($start_date_summary_process , $end_date_summary_process))->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
            $attendance_breached_discharges                 = SymphonyAttendanceView::whereBetween('symphony_estimated_breach_time', array($start_date_summary_process , $end_date_summary_process))->orderBy('symphony_estimated_breach_time', 'ASC')->get()->toArray();
            $attendance_arrivals_forecast                   = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($start_date_summary_process_forecast , $end_date_summary_process_forecast))->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();

            $this->CountOnEveryHourAddPrimaryHourAndDate($summary_hourly_data,$start_date_summary_process);
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $attendance_arrivals, "ane_attendance_arrivals", "symphony_registration_date_time");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $attendance_discharges, "ane_attendance_left_ed", "symphony_discharge_date");
            $common_symphony_controller->CountOnEveryHourArrayConversionBreaches($summary_hourly_data, $attendance_breached_discharges, "ane_attendance_breaches", $process_array,$start_date_summary_process,$end_date_summary_process);
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $attendance_arrivals_forecast, "ane_attendance_forecast", "symphony_registration_date_time");
            $common_controller->CountOnEveryHourArrayConversionYearAverage($summary_hourly_data, "ane_attendance_forecast", $number_of_days_forecast,1);
            $common_controller->CountOnEveryHourArrayConversionAdmittedDischarged($summary_hourly_data, $attendance_discharges,"symphony_discharge_date");




            $ambulance_walkin_hour_arrival_array                        = $common_symphony_controller->AmbulanceWalkinArrayProcess($attendance_arrivals);

            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $ambulance_walkin_hour_arrival_array["ambulance_arrival"], "ane_attendance_ambulance", "symphony_registration_date_time");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $ambulance_walkin_hour_arrival_array["walkin_arrival"], "ane_attendance_walk_in", "symphony_registration_date_time");

            $triage_category_data_array                                 = $this->ArrayColumnCategoryWiseGroupingForTriage($start_date_summary_process,$end_date_summary_process,$attendance_discharges, 'symphony_triage_category', 'symphony_triage_date');


            if(!isset($triage_category_data_array["1"]))
            {
                $triage_category_data_array["1"]  = array();
            }
            if(!isset($triage_category_data_array["2"]))
            {
                $triage_category_data_array["2"]  = array();
            }
            if(!isset($triage_category_data_array["3"]))
            {
                $triage_category_data_array["3"]  = array();
            }
            if(!isset($triage_category_data_array["4"]))
            {
                $triage_category_data_array["4"]  = array();
            }
            if(!isset($triage_category_data_array["5"]))
            {
                $triage_category_data_array["5"]  = array();
            }


            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $triage_category_data_array["1"], "triage_category_1", "symphony_triage_date");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $triage_category_data_array["2"], "triage_category_2", "symphony_triage_date");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $triage_category_data_array["3"], "triage_category_3", "symphony_triage_date");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $triage_category_data_array["4"], "triage_category_4", "symphony_triage_date");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $triage_category_data_array["5"], "triage_category_5", "symphony_triage_date");
            $triage_date_data_processed                                 = $common_controller->ArrayFindInBetweenDateTimeOfFields($attendance_discharges, $start_date_summary_process,$end_date_summary_process, 'symphony_triage_date');
            $ed_clinician_data_processed                                = $common_controller->ArrayFindInBetweenDateTimeOfFields($attendance_discharges, $start_date_summary_process,$end_date_summary_process, 'symphony_seen_date');
            $spec_doctor_data_processed                                 = $common_controller->ArrayFindInBetweenDateTimeOfFields($attendance_discharges, $start_date_summary_process,$end_date_summary_process, 'symphony_refferal_date');
            $common_symphony_controller->TriageCountOnEveryHourArrayConversionTargetTimes($summary_hourly_data, $triage_date_data_processed, "triage", "symphony_triage_date", 15);
            $common_symphony_controller->TriageCountOnEveryHourArrayConversionTargetTimes($summary_hourly_data, $ed_clinician_data_processed, "ed_clinician", "symphony_seen_date", 60);
            $common_symphony_controller->TriageCountOnEveryHourArrayConversionTargetTimes($summary_hourly_data, $spec_doctor_data_processed, "spec_doctor", "symphony_refferal_date", 60);




            if(count($summary_hourly_data) > 0)
            {
                foreach($summary_hourly_data as $row)
                {
                    $key_array                                              = array();
                    $key_array['ed_summary_date']                           = $row['summary_date'];
                    $key_array['ed_summary_time']                           = $row['summary_time'];
                    $key_array['ed_summary_date_time']                      = $row['summary_date_time'];

                    $key_array['ane_attendance_arrivals']                   = $row['ane_attendance_arrivals'] ?? 0;
                    $key_array['ane_attendance_left_ed']                    = $row['ane_attendance_left_ed'] ?? 0;
                    $key_array['ane_attendance_breaches']                   = $row['ane_attendance_breaches'] ?? 0;
                    $key_array['ane_attendance_forecast']                   = $row['ane_attendance_forecast'] ?? 0;
                    $key_array['ane_attendance_discharged']                 = $row['ane_attendance_discharged'] ?? 0;
                    $key_array['ane_attendance_admitted']                   = $row['ane_attendance_admitted'] ?? 0;
                    $key_array['ane_attendance_ambulance']                  = $row['ane_attendance_ambulance'] ?? 0;
                    $key_array['ane_attendance_walk_in']                    = $row['ane_attendance_walk_in'] ?? 0;
                    $key_array['triage_category_1']                         = $row['triage_category_1'] ?? 0;
                    $key_array['triage_category_2']                         = $row['triage_category_2'] ?? 0;
                    $key_array['triage_category_3']                         = $row['triage_category_3'] ?? 0;
                    $key_array['triage_category_4']                         = $row['triage_category_4'] ?? 0;
                    $key_array['triage_category_5']                         = $row['triage_category_5'] ?? 0;
                    $key_array['triage_patients_seen']                      = $row['triage_patients_seen'] ?? 0;
                    $key_array['triage_greater_than']                       = $row['triage_greater_than'] ?? 0;
                    $key_array['triage_avg_time']                           = $row['triage_avg_time'] ?? 0;
                    $key_array['triage_longer_time']                        = $row['triage_longer_time'] ?? 0;
                    $key_array['ed_clinician_patients_seen']                = $row['ed_clinician_patients_seen'] ?? 0;
                    $key_array['ed_clinician_greater_than']                 = $row['ed_clinician_greater_than'] ?? 0;
                    $key_array['ed_clinician_avg_time']                     = $row['ed_clinician_avg_time'] ?? 0;
                    $key_array['ed_clinician_longer_time']                  = $row['ed_clinician_longer_time'] ?? 0;
                    $key_array['spec_doctor_patients_seen']                 = $row['spec_doctor_patients_seen'] ?? 0;
                    $key_array['spec_doctor_greater_than']                  = $row['spec_doctor_greater_than'] ?? 0;
                    $key_array['spec_doctor_avg_time']                      = $row['spec_doctor_avg_time'] ?? 0;
                    $key_array['spec_doctor_longer_time']                   = $row['spec_doctor_longer_time'] ?? 0;
                    SymphonyAttendanceCalculatedHourlyEDSummary::updateOrCreate(['ed_summary_date_time' => $key_array['ed_summary_date_time']], $key_array);
                }
            }
        }
        $automated_job_log                          = array('replication_job_end_time'   => now(), 'replication_job_log_status' => 1);
        LogReplicationAutomatedJobLogStatus::where('id', $automated_job_log_id)->update($automated_job_log);

    }



    public function ValueSetIfExistEdSummaryArrayInsert(&$attendance_details_array, $date_index_set, $key, $value)
    {
        if (isset($attendance_details_array[$date_index_set][$key]['ed_summary_value']))
        {
            $attendance_details_array[$date_index_set][$key]['ed_summary_value']          =  $value;
        }
    }


    public function ValueSetEdSummaryArrayInsert(&$attendance_details_array, $date_index_set, $key, $value)
    {
        $attendance_details_array[$date_index_set][$key]['ed_summary_date']             =  $date_index_set;
        $attendance_details_array[$date_index_set][$key]['ed_summary_key_value']        =  $key;
        $attendance_details_array[$date_index_set][$key]['ed_summary_value']            =  $value;
    }










    public function AttendanceHourlySummaryDataAutoInsertHistory()
    {


        $common_controller                                  = new CommonController;
        $common_symphony_controller                         = new CommonSymphonyController;
        $history_controller                                 = new HistoryController;
        $auto_user_id                                       = 0;
        $process_array                                      = array();
        $success_array                                      = array();
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);









        $start_date_with_month                              = '2024-04-01';
        $number_of_days                                     = (int) date('t',strtotime($start_date_with_month));
        $process_start_date_summary_hourly                  = date('Y-m-01',strtotime($start_date_with_month));

        for ($x = 0; $x < $number_of_days; $x++)
        {
            $start_date_summary_process                     = '';
            $end_date_summary_process                       = '';
            $number_of_days_forecast                        = 10;
            $summary_hourly_data                            = array();
            $start_date_summary_process                     = date("Y-m-d", strtotime($process_start_date_summary_hourly . " +$x days"));
            CalculateStartEndDateAccordingSelection($start_date_summary_process,$end_date_summary_process,"day");

            $start_date_summary_process_forecast            = date("Y-m-d 00:00:00", strtotime($start_date_summary_process . " -10 days"));
            $end_date_summary_process_forecast              = date("Y-m-d 23:59:59", strtotime($start_date_summary_process_forecast . " +9 days"));

            $attendance_arrivals                            = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($start_date_summary_process , $end_date_summary_process))->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
            $attendance_discharges                          = SymphonyAttendanceView::whereBetween('symphony_discharge_date', array($start_date_summary_process , $end_date_summary_process))->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
            $attendance_arrivals_forecast                   = SymphonyAttendanceView::whereBetween('symphony_registration_date_time', array($start_date_summary_process_forecast , $end_date_summary_process_forecast))->orderBy('symphony_registration_date_time', 'ASC')->get()->toArray();
            $attendance_breached_discharges                 = SymphonyAttendanceView::whereBetween('symphony_estimated_breach_time', array($start_date_summary_process , $end_date_summary_process))->orderBy('symphony_estimated_breach_time', 'ASC')->get()->toArray();

            $this->CountOnEveryHourAddPrimaryHourAndDate($summary_hourly_data,$start_date_summary_process);
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $attendance_arrivals, "ane_attendance_arrivals", "symphony_registration_date_time");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $attendance_discharges, "ane_attendance_left_ed", "symphony_discharge_date");
            $common_symphony_controller->CountOnEveryHourArrayConversionBreaches($summary_hourly_data, $attendance_breached_discharges, "ane_attendance_breaches", $process_array,$start_date_summary_process,$end_date_summary_process);

            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $attendance_arrivals_forecast, "ane_attendance_forecast", "symphony_registration_date_time");
            $common_controller->CountOnEveryHourArrayConversionYearAverage($summary_hourly_data, "ane_attendance_forecast", $number_of_days_forecast,1);



            $common_controller->CountOnEveryHourArrayConversionAdmittedDischarged($summary_hourly_data, $attendance_discharges,"symphony_discharge_date");




            $ambulance_walkin_hour_arrival_array                                    = $common_symphony_controller->AmbulanceWalkinArrayProcess($attendance_arrivals);

            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $ambulance_walkin_hour_arrival_array["ambulance_arrival"], "ane_attendance_ambulance", "symphony_registration_date_time");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $ambulance_walkin_hour_arrival_array["walkin_arrival"], "ane_attendance_walk_in", "symphony_registration_date_time");





            $triage_category_data_array                     = $this->ArrayColumnCategoryWiseGroupingForTriage($start_date_summary_process,$end_date_summary_process,$attendance_discharges, 'symphony_triage_category', 'symphony_triage_date');



            if(!isset($triage_category_data_array["1"]))
            {
                $triage_category_data_array["1"]  = array();
            }
            if(!isset($triage_category_data_array["2"]))
            {
                $triage_category_data_array["2"]  = array();
            }
            if(!isset($triage_category_data_array["3"]))
            {
                $triage_category_data_array["3"]  = array();
            }
            if(!isset($triage_category_data_array["4"]))
            {
                $triage_category_data_array["4"]  = array();
            }
            if(!isset($triage_category_data_array["5"]))
            {
                $triage_category_data_array["5"]  = array();
            }


            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $triage_category_data_array["1"], "triage_category_1", "symphony_triage_date");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $triage_category_data_array["2"], "triage_category_2", "symphony_triage_date");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $triage_category_data_array["3"], "triage_category_3", "symphony_triage_date");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $triage_category_data_array["4"], "triage_category_4", "symphony_triage_date");
            $common_controller->CountOnEveryHourArrayConversion($summary_hourly_data, $triage_category_data_array["5"], "triage_category_5", "symphony_triage_date");
            $triage_date_data_processed                                 = $common_controller->ArrayFindInBetweenDateTimeOfFields($attendance_discharges, $start_date_summary_process,$end_date_summary_process, 'symphony_triage_date');
            $ed_clinician_data_processed                                = $common_controller->ArrayFindInBetweenDateTimeOfFields($attendance_discharges, $start_date_summary_process,$end_date_summary_process, 'symphony_seen_date');
            $spec_doctor_data_processed                                 = $common_controller->ArrayFindInBetweenDateTimeOfFields($attendance_discharges, $start_date_summary_process,$end_date_summary_process, 'symphony_refferal_date');
            $common_symphony_controller->TriageCountOnEveryHourArrayConversionTargetTimes($summary_hourly_data, $triage_date_data_processed, "triage", "symphony_triage_date", 15);
            $common_symphony_controller->TriageCountOnEveryHourArrayConversionTargetTimes($summary_hourly_data, $ed_clinician_data_processed, "ed_clinician", "symphony_seen_date", 60);
            $common_symphony_controller->TriageCountOnEveryHourArrayConversionTargetTimes($summary_hourly_data, $spec_doctor_data_processed, "spec_doctor", "symphony_refferal_date", 60);



            if(count($summary_hourly_data) > 0)
            {
                foreach($summary_hourly_data as $row)
                {
                    $key_array                                              = array();
                    $key_array['ed_summary_date']                           = $row['summary_date'];
                    $key_array['ed_summary_time']                           = $row['summary_time'];
                    $key_array['ed_summary_date_time']                      = $row['summary_date_time'];

                    $key_array['ane_attendance_arrivals']                   = $row['ane_attendance_arrivals'] ?? 0;
                    $key_array['ane_attendance_left_ed']                    = $row['ane_attendance_left_ed'] ?? 0;
                    $key_array['ane_attendance_breaches']                   = $row['ane_attendance_breaches'] ?? 0;
                    $key_array['ane_attendance_forecast']                   = $row['ane_attendance_forecast'] ?? 0;
                    $key_array['ane_attendance_discharged']                   = $row['ane_attendance_discharged'] ?? 0;
                    $key_array['ane_attendance_admitted']                   = $row['ane_attendance_admitted'] ?? 0;
                    $key_array['ane_attendance_ambulance']       = $row['ane_attendance_ambulance'] ?? 0;

                    $key_array['ane_attendance_walk_in']                    = $row['ane_attendance_walk_in'] ?? 0;
                    $key_array['triage_category_1']                    = $row['triage_category_1'] ?? 0;
                    $key_array['triage_category_2']                  = $row['triage_category_2'] ?? 0;
                    $key_array['triage_category_3']               = $row['triage_category_3'] ?? 0;
                    $key_array['triage_category_4']                = $row['triage_category_4'] ?? 0;
                    $key_array['triage_category_5']                   = $row['triage_category_5'] ?? 0;

                    $key_array['triage_patients_seen']                      = $row['triage_patients_seen'] ?? 0;
                    $key_array['triage_greater_than']                       = $row['triage_greater_than'] ?? 0;
                    $key_array['triage_avg_time']                           = $row['triage_avg_time'] ?? 0;
                    $key_array['triage_longer_time']                        = $row['triage_longer_time'] ?? 0;
                    $key_array['ed_clinician_patients_seen']                = $row['ed_clinician_patients_seen'] ?? 0;
                    $key_array['ed_clinician_greater_than']                 = $row['ed_clinician_greater_than'] ?? 0;
                    $key_array['ed_clinician_avg_time']                     = $row['ed_clinician_avg_time'] ?? 0;
                    $key_array['ed_clinician_longer_time']                  = $row['ed_clinician_longer_time'] ?? 0;
                    $key_array['spec_doctor_patients_seen']                 = $row['spec_doctor_patients_seen'] ?? 0;
                    $key_array['spec_doctor_greater_than']                  = $row['spec_doctor_greater_than'] ?? 0;
                    $key_array['spec_doctor_avg_time']                      = $row['spec_doctor_avg_time'] ?? 0;
                    $key_array['spec_doctor_longer_time']                   = $row['spec_doctor_longer_time'] ?? 0;
                    SymphonyAttendanceCalculatedHourlyEDSummary::updateOrCreate(['ed_summary_date_time' => $key_array['ed_summary_date_time']], $key_array);
                }
            }
        }
    }






    public function CountOnEveryHourAddPrimaryHourAndDate(&$array_to_process,$date_to_add)
    {
        for ($x = 0; $x < 24; $x++)
        {
            $array_to_process[$x]["hour"]               = ($x < 10) ? "0" . $x : "" . $x;
            $array_to_process[$x]["summary_date"]               = date('Y-m-d',strtotime($date_to_add));
            $array_to_process[$x]["summary_date_time"]               = $array_to_process[$x]["summary_date"].' '.$array_to_process[$x]["hour"] .':00:00';
            $array_to_process[$x]["summary_time"]               = $array_to_process[$x]["hour"] .':00:00';
        }
    }
    public function ArrayColumnCategoryWiseGroupingForTriage($date_check_to_start,$date_check_to_end,$data_array_process, $column_index1,$column_index2)
    {
        $return_array                                                       = array();
        if (count($data_array_process) > 0)
        {
            foreach ($data_array_process as $row)
            {
                if (isset($row[$column_index1]) && isset($row[$column_index2]) && strtotime($date_check_to_start) <= strtotime($row[$column_index2]) && strtotime($date_check_to_end) >= strtotime($row[$column_index2]))
                {
                    if ($row[$column_index1] != null && $row[$column_index1] != "")
                    {
                        $return_array[$row[$column_index1]][]           = $row;
                    }
                }
            }
        }
        return $return_array;
    }


}

