<?php

namespace App\Http\Controllers\Iboards\Symphony;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\CommonSymphonyController;
use Illuminate\Support\Facades\View;
use App\Models\Iboards\Symphony\View\SymphonyWelcomeDashboardView;
use Brian2694\Toastr\Facades\Toastr;

class EDHomeController extends Controller
{
    public function PageDataLoad(&$process_array, &$success_array)
    {
        $common_controller                                              = new CommonController;
        $common_symphony_controller                                     = new CommonSymphonyController;
        $common_controller->SetDefaultConstantsValue($process_array, $success_array);
        $common_symphony_controller->SetSymphonyDefaultConstantsValue($process_array, $success_array);
        $query_ed_summary_data                                          = SymphonyWelcomeDashboardView::get();
        $success_array["total_patients_ed_now"]                         = 0;
        $success_array["total_patients_ed_now_minors"]                  = 0;
        $success_array["total_patients_ed_now_majors"]                  = 0;
        $success_array["average_waiting_times_majors"]                  = "-";
        $success_array["average_waiting_times_minors"]                  = "-";
        $success_array["total_patients_ed_now_paed_eds"]                = 0;
        $success_array["average_waiting_times_paed_eds"]                = "-";

        if ($query_ed_summary_data)
        {
            foreach ($query_ed_summary_data as $row)
            {
                if ($row->keyvalue == "total_patients_ed_now")
                {
                    if ($row->val != "" && $row->val > 0)
                    {
                        $success_array["total_patients_ed_now"]         = (int)$row->val;
                    }
                }
                if ($row->keyvalue == "total_patients_ed_now_minors")
                {
                    if ($row->val != "" && $row->val > 0)
                    {
                        $success_array["total_patients_ed_now_minors"]  = (int)$row->val;
                    }
                }
                if ($row->keyvalue == "total_patients_ed_now_majors")
                {
                    if ($row->val != "" && $row->val > 0)
                    {
                        $success_array["total_patients_ed_now_majors"]  = (int)$row->val;
                    }
                }
                if ($row->keyvalue == "average_waiting_times_majors")
                {
                    if ($row->val != "" && $row->val > 0)
                    {
                        $success_array["average_waiting_times_majors"]  = ConvertSecondsToHourMinutesWithTextFormated($row->val);
                    }
                }
                if ($row->keyvalue == "average_waiting_times_minors")
                {
                    if ($row->val != "" && $row->val > 0)
                    {
                        $success_array["average_waiting_times_minors"]  = ConvertSecondsToHourMinutesWithTextFormated($row->val);
                    }
                }
            }
        }
    }

    public function Index()
    {
        if (!CheckDashboardPermission('ane_welcome_screen_view'))
        {
            Toastr::error('Permission Denied');
            return back();
        }
        $process_array                                                  = array();
        $success_array                                                  = array();
        $this->PageDataLoad($process_array, $success_array);
        $success_array = json_decode(file_get_contents('demo_data/ane/edhome.json'), true);
        return view('Dashboards.Symphony.EDHome.Index', compact('success_array'));
    }
    public function IndexRefreshDataLoad()
    {
        $process_array                                                  = array();
        $success_array                                                  = array();

        $this->PageDataLoad($process_array, $success_array);
        $success_array = json_decode(file_get_contents('demo_data/ane/edhome.json'), true);
        $view                                                           = View::make('Dashboards.Symphony.EDHome.IndexDataLoad', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }
}
