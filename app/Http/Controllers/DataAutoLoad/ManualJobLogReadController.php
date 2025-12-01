<?php

namespace App\Http\Controllers\DataAutoLoad;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Session;
use Sentinel;
use View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use App\Http\Controllers\Common\HistoryController;
use App\Models\Governance\KichenJobLogFileNameRead;
use App\Models\Governance\LogReplicationAutomatedJobLogStatus;
use App\Models\Common\ActiveUsers;
use App\Models\Common\LogFilesNamesToRead;
use App\Models\Common\User;
use App\Models\Governance\GovernanceFrontendCamisAutomateEntryCheck;
use App\Models\Governance\GovernanceFrontendCamisWardLoadTime;
use App\Models\Iboards\Camis\Master\Wards;
use Carbon\Carbon;

class ManualJobLogReadController extends Controller
{
    public function WardLoadTime()
    {
        $in_data                            = GovernanceFrontendCamisWardLoadTime::where('updated_at_time', '<=', Carbon::now()->subDays(30))->delete();
        $log_test_id                        = RetriveSpecificConstantSettingValues('ibox_auto_set_admin_id', 'ibox_constant_default_setting_values');;
        $selected_ward_all_set              = Wards::where('status', 1)->get();
        $connect_user                       = User::where('id', '=', $log_test_id)->first();
        $base_url_get                       = url('/');
        $selected_ward_all_set_arr          = GovernanceFrontendCamisAutomateEntryCheck::where('logs_type', '=', 1)->orderBy('updated_entry', 'DESC')->first();
        $check_log_entry                    = 0;
        if (isset($selected_ward_all_set_arr->entry_time_check)) {
            if ($selected_ward_all_set_arr->entry_time_check != "") {
                $check1                     = $selected_ward_all_set_arr->entry_time_check;
                $check2                     = date("Y-m-d H:i:s");
                $diffenece_time             = strtotime($check2) - strtotime($check1);
                if ($diffenece_time < 1800) {
                    $check_log_entry        = 1;
                }
            }
        }


        if ($check_log_entry == 0) {
            $check2_enter                   = date("Y-m-d H:i:s");
            $log_data_enter                 = array('logs_type' => 1, 'entry_time_check' => $check2_enter);
            $res                            = GovernanceFrontendCamisAutomateEntryCheck::insert($log_data_enter);
            if (isset($connect_user)) {
                if ($connect_user->id != "") {
                    $user_log_try           = Sentinel::findById($connect_user->id);
                    $load_test_done_at      = date("Y-m-d H:i:s");
                    Sentinel::login($user_log_try);
                    $user                   = Sentinel::check();
                    if (!empty($user)) {
                        foreach ($selected_ward_all_set as $selected_ward_data) {
                            $url_to_test    = $base_url_get . "/inpatients/dashboards/ward-summary/" . $selected_ward_data->ward_url_name;
                            $time_started   = microtime(TRUE);
                            $curl_var       = curl_init($url_to_test);
                            $info           = curl_getinfo($curl_var);
                            curl_close($curl_var);
                            $time_taken     = microtime(TRUE) - $time_started;
                            $time_taken     = substr($time_taken, 0, 5);
                            if ($time_taken > 5) {
                                $time_taken = $time_taken - 1;
                            }
                            $time_taken     = number_format($time_taken, 2);
                            $log_data       = array(
                                'ward_id' => $selected_ward_data->id,
                                'ward_short_name' => $selected_ward_data->ward_short_name,
                                'ward_actual_name' => $selected_ward_data->ward_name,
                                'load_test_done_at' => $load_test_done_at,
                                'load_time_noted' => $time_taken
                            );
                            $res = GovernanceFrontendCamisWardLoadTime::insert($log_data);
                        }
                    }
                }
            }
        }
    }

    public function beliefmedia_recurse_copy($src, $dst)
    {

        if (!is_dir($src)) {
            return false;
        }

        $dir = opendir($src);
        if ($dir === false) {
            return false;
        }

        if (!file_exists($dst)) {
            mkdir($dst, 0755, true);
        }

        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->beliefmedia_recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    public function convert_time_by_seconds($interval)
    {
        if ($interval < 0) {
            return false;
        }
        $seconds_n_miliseconds = explode('.', $interval);
        $interval = $seconds_n_miliseconds[0];

        $hours = floor($interval / (60 * 60));
        $minutes = floor(($interval - ($hours * 60 * 60)) / 60);
        $seconds = floor(($interval - ($hours * 60 * 60)) - ($minutes * 60));
        $ms = empty($seconds_n_miliseconds[1]) ? 0 : $seconds_n_miliseconds[1];

        if ($hours > 0) {
            $return_text        =   "$hours Hours and $minutes Minutes and $seconds Seconds ( $interval seconds total )";
        } else if ($minutes > 0) {
            $return_text        =   "$minutes Minutes and $seconds Seconds ( $interval seconds total )";
        } else {
            $return_text        =   "$interval seconds total ";
        }
        return $return_text;
    }


    public function get_server_memory_usage()
    {

        $free = shell_exec('free');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_usage = $mem[2] / $mem[1] * 100;

        return $memory_usage;
    }
    public function get_server_cpu_usage()
    {
        $load = sys_getloadavg();
        return $load[0];
    }
    public function KitchenTimeRead()
    {
        $this->HealthCheckDaily();
        $loggined_user_data             = ActiveUsers::where('last_activity_time', '>=', Carbon::now()->subMinutes(5))->get();
        $report_data_1                  = GovernanceFrontendCamisWardLoadTime::select("load_time_noted")->orderBy('load_test_done_at', 'desc')->limit(30)->get();

        $times_arr          = array();
        if (!empty($report_data_1)) {
            foreach ($report_data_1 as $dt) {
                $times_arr[]    = $dt->load_time_noted;
            }
        }


        $total_sec          =   0;
        if (count($times_arr) > 0) {
            $total_sec      = array_sum($times_arr) / 30;
        }





        $health_check_log_file_read_array               = array();
        $job_log_data_info                              = array();
        $health_check_log_file_read                     = LogFilesNamesToRead::get();
        if (!empty($health_check_log_file_read)) {
            foreach ($health_check_log_file_read as $row) {
                $health_check_log_file_read_array[]                                 = $row->file_name_read_to_show;
                $job_log_data_info[$row->file_name_read_to_show]['job_log_name']    = $row->file_name_read_to_show;
                $job_log_data_info[$row->file_name_read_to_show]['start_time']      = '';
                $job_log_data_info[$row->file_name_read_to_show]['end_time']        = '';
                $job_log_data_info[$row->file_name_read_to_show]['staus']           = 0;
                $job_log_data_info[$row->file_name_read_to_show]['type']            = '';
                $job_log_data_info[$row->file_name_read_to_show]['updated']         = 0;
                $job_log_data_info[$row->file_name_read_to_show]['current_time']    = CurrentDateOnFormat();
                $job_log_data_info[$row->file_name_read_to_show]['interval_in_minutes']    = (int) $row->interval_in_minutes;
            }
        }
        $date_log_retrive   = date('Y-m-d');
        $date_log_retrive_3 =  date('Y-m-d 00:00:00', strtotime($date_log_retrive . ' - 3 days'));


        $log_data_read = LogReplicationAutomatedJobLogStatus::whereIn('replication_job_name', $health_check_log_file_read_array)->where('replication_job_start_time', '>=', $date_log_retrive_3)->where('replication_job_start_time', '>=', $date_log_retrive_3)->orderBy('replication_job_start_time', 'desc')->get()->toArray();
        if (!empty($log_data_read)) {
            foreach ($log_data_read as $row) {
                if (isset($job_log_data_info[$row['replication_job_name']]['updated']) && $job_log_data_info[$row['replication_job_name']]['updated'] == 0) {

                    if ($row['type'] == 1) {
                        $job_log_data_info[$row['replication_job_name']]['start_time']      = $row['replication_job_start_time'];
                        $job_log_data_info[$row['replication_job_name']]['end_time']        = $row['replication_job_end_time'];
                        $job_log_data_info[$row['replication_job_name']]['staus']           = $row['replication_job_log_status'];
                        $job_log_data_info[$row['replication_job_name']]['type']            = 'APACHE HOP';
                        $job_log_data_info[$row['replication_job_name']]['updated']         = 1;
                    } else {
                        if ($row['replication_job_end_time'] != '') {
                            $job_log_data_info[$row['replication_job_name']]['start_time']      = $row['replication_job_start_time'];
                            $job_log_data_info[$row['replication_job_name']]['end_time']        = $row['replication_job_end_time'];
                            $job_log_data_info[$row['replication_job_name']]['staus']           = $row['replication_job_log_status'];
                            $job_log_data_info[$row['replication_job_name']]['type']            = 'PHP';
                            $job_log_data_info[$row['replication_job_name']]['updated']         = 1;
                        }
                    }
                }
            }
        }
        foreach ($job_log_data_info as $k => $v) {
            $interval = isset($v['interval_in_minutes']) ? (int) $v['interval_in_minutes'] : 5;
            if (!empty($v['start_time'])) {
                $minsSinceLast = Carbon::parse($v['start_time'])->diffInMinutes(Carbon::now());
                $job_log_data_info[$k]['is_late'] = ($minsSinceLast > $interval);
                $job_log_data_info[$k]['last_run_minutes'] = $minsSinceLast;
            } else {
                $job_log_data_info[$k]['is_late'] = true;
                $job_log_data_info[$k]['last_run_minutes'] = null;
            }
        }
        $success_array                                      = array();
        $usercount                                          = count($loggined_user_data);
        $success_array["log_status"]                        = $job_log_data_info;
        $success_array["disk_free_space_c"]                 = "Disk Free Space C : " . number_format((disk_free_space("C:") / (1024 * 1024 * 1024)), 2) . ' GB';
        $success_array["disk_free_space_d"]                 = "Disk Free Space D : " . number_format((disk_free_space("D:") / (1024 * 1024 * 1024)), 2) . ' GB';
        $success_array["active_users"]                      = "Active Users : $usercount.";
        $success_array["ward_load_time"]                    = "Average Ward Load Time : " . number_format($total_sec, 2) . " Seconds.";




        $cpuLoad = getServerLoad();
        if (is_null($cpuLoad)) {
            $success_array["cpu_usage"]                    = '';
        } else {
            $success_array["cpu_usage"]                    = "CPU USAGE : " . $cpuLoad . ' %';
        }
        $memUsage = getServerMemoryUsage(false);
        $success_array["memory_usage"]                    = "MEMORY USAGE : " . number_format(getServerMemoryUsage(true), 0) . ' %';
        return view('Common.View.healthcheck', compact('success_array'));
    }


    public function HealthCheckDaily()
    {
        $this->WardLoadTime();


        $src_from_move                  = RetriveSpecificConstantSettingValues('source_path', 'logs_automate_files_path');
        $dest_from_move                 = RetriveSpecificConstantSettingValues('destination_path_move', 'logs_automate_files_path');
        $dest_from_path                 = RetriveSpecificConstantSettingValues('destination_path', 'logs_automate_files_path');

        $this->beliefmedia_recurse_copy($src_from_move, $dest_from_move);
        $selected_ward_all_set_arr      = LogFilesNamesToRead::where('read_status', '=', 1)->get();
        $today = Carbon::now()->format('Y-m-d');
        if (count($selected_ward_all_set_arr) > 0) {
            foreach ($selected_ward_all_set_arr as $row_files) {
                $key_file               = $row_files->file_name_read_to_show;
                $filenames              = $row_files->file_name_read_pick_log;
                $log_name_status        = $key_file;
                $file_path_to_read      = $dest_from_path . "\\" . $filenames;

                if (!file_exists($file_path_to_read)) {
                    continue;
                }

                $offset                 = 0;
                $find                   = "HopRun exit.";
                $find1                  = "Processing ended";
                $find_length            = strlen($find);
                $count_occurance        = 1;
                $file_contents          = $this->lastLines($file_path_to_read, 100);


                $file_contents_str      = implode(" ", $file_contents);
                //  dd($file_contents_str  );



                $content = $this->readLastLines($file_path_to_read, 200);
                // Split each run by markers
                preg_match_all('/==\=\[Starting HopRun\].*?HopRun exit\./s', $content, $matches);
                $runs = $matches[0] ?? [];

                // Loop backward to find last fully completed run
                for ($i = count($runs) - 1; $i >= 0; $i--) {
                    $run = $runs[$i];

                    // Check if it's a completed execution (has "Workflow execution finished" and result=[true|false])
                    if (
                        preg_match('/Workflow execution finished/i', $run) &&
                        preg_match('/result=\[(true|false)\]/i', $run, $resMatch)
                    ) {
                        $result = strtolower($resMatch[1]) === 'true';

                        // Extract timestamps and duration
                        $start  = null;
                        $end    = null;
                        $dur    = null;

                        if (preg_match('/(\d{4}\/\d{2}\/\d{2}\s+\d{2}:\d{2}:\d{2}).*?- Start of workflow execution/', $run, $m1)) {
                            $start = $m1[1];
                        }
                        if (preg_match('/(\d{4}\/\d{2}\/\d{2}\s+\d{2}:\d{2}:\d{2}).*?- Workflow execution finished/', $run, $m2)) {
                            $end = $m2[1];
                        }
                        if (preg_match('/Workflow duration\s*:\s*([0-9.]+)\s*seconds/i', $run, $m3)) {
                            $dur = (float) $m3[1];
                        }

                        if ($start != "" && $end != "") {

                            $automated_job_log                                  = array('replication_job_name' => $log_name_status, 'replication_job_start_time' => $start, 'replication_job_end_time'   => $end, 'replication_job_log_status' => $result, 'type' => 1);
                            $existing_log                   = LogReplicationAutomatedJobLogStatus::updateOrCreate(['replication_job_name' => $log_name_status, 'replication_job_start_time' => $start], ['replication_job_end_time'   => $end, 'replication_job_log_status' => $result, 'type' => 1]);
                        } else {
                            if ($result == 0) {

                                if ($start == '') {
                                    $start = null;
                                }
                                if ($end == '') {
                                    $end = null;
                                }
                                $automated_job_log                                  = array('replication_job_name' => $log_name_status, 'replication_job_start_time' => $start, 'replication_job_end_time'   => $end, 'replication_job_log_status' => $result, 'type' => 1);
                                $existing_log                                       = LogReplicationAutomatedJobLogStatus::whereDate('created_at', $today)->where('replication_job_name', $log_name_status)->first();
                                if ($existing_log) {
                                    $existing_log->update($automated_job_log);
                                } else {
                                    LogReplicationAutomatedJobLogStatus::create($automated_job_log);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function lastLines($file, $lines)
    {
        $size = filesize($file);
        $fd = fopen($file, 'r+');
        $pos = $size;
        $n = 0;
        while ($n < $lines + 1 && $pos > 0) {
            fseek($fd, $pos);
            $a = fread($fd, 1);
            if ($a === "\n") {
                ++$n;
            };
            $pos--;
        }
        $ret = array();
        for ($i = 0; $i < $lines; $i++) {
            array_push($ret, fgets($fd));
        }
        return $ret;
    }

    public function readLastLines(string $filePath, int $numLines): string
    {
        $fp = fopen($filePath, 'rb');
        if (!$fp) {
            throw new RuntimeException("Unable to open file: {$filePath}");
        }

        $buffer = '';
        $chunkSize = 4096;
        $pos = -1;
        $lines = 0;
        $fileSize = filesize($filePath);

        while ($lines < $numLines && -$pos < $fileSize) {
            $seek = max($pos - $chunkSize, -$fileSize);
            $readSize = abs($pos - $seek);
            fseek($fp, $seek, SEEK_END);
            $chunk = fread($fp, $readSize);
            $buffer = $chunk . $buffer;
            $lines = substr_count($buffer, "\n");
            $pos = $seek;
        }

        fclose($fp);

        $bufferLines = explode("\n", $buffer);
        if (count($bufferLines) > $numLines) {
            $bufferLines = array_slice($bufferLines, -$numLines);
        }

        return implode("\n", $bufferLines);
    }
}
