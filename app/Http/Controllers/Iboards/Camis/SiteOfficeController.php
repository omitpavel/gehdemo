<?php


namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Iboards\Symphony\Data\OpelCurrentStatus;
use App\Models\Iboards\Camis\Data\CamisIboxSiteOfficeText;
use App\Http\Controllers\Governance\GovernanceController;
use App\Http\Controllers\Common\HistoryController;
use DB;
use App\Models\History\HistoryCamisIboxSiteOfficeText;
use Brian2694\Toastr\Facades\Toastr;
class SiteOfficeController extends Controller
{
    public function Index()
    {
        if(CheckDashboardPermission('site_office_report_view')){
            return view('Dashboards.Camis.SiteOffice.Index');
        } elseif(CheckDashboardPermission('flow_dashboard_patient_search_view')){
            Toastr::error('Permission Denied');
            return redirect()->route('global.patient.search');
        }

    }

    public function IndexRefreshDataLoad(Request $request){

        $success_array                              = array();

        $success_array                              = array();
        $check_date                                 = date("Y-m-d");
        $office_text                                = HistoryCamisIboxSiteOfficeText::orderBy('updated_at', 'desc')->first();


        $ane_opel_status                            = OpelCurrentStatus::where('ane_opel_status_data_type', 1)->first();
        $ward_opel_status                           = OpelCurrentStatus::where('ane_opel_status_data_type', 2)->first();


        $breachs_all                                =   DB::connection('mysql_camis_data')->select('CALL sp_ibox_text_dashboard_breachs()');
        $breaches_sum                               =   0;
        $breaches_text                              =   "";
        $arr_cnt                                    =   0;
        if(!empty($breachs_all))
        {
            $breaches_text                          .=  "( ";
            $ct_cnt                                 =   count($breachs_all);
            foreach ($breachs_all as $row1)
            {
                $arr_cnt++;
                $breaches_sum                       =   $breaches_sum+$row1->val;
                $breaches_text                      .=  $row1->keyvalue." : ".$row1->val;
                if($ct_cnt != $arr_cnt)
                {
                    $breaches_text                      .=  ", ";
                }
            }
            $breaches_text                          .=  " )";
        }

        $office_text_vars                           =   DB::connection('mysql_camis_data')->select('CALL sp_ibox_text_dashboard()');
        $show_val                                   =   array();
        foreach($office_text_vars as $row)
        {
           $show_val[$row->keyvalue]      =   $row->val;
        }

        if($show_val["performance"] == "")
        {
            $show_val["performance"]    =   100;
        }
        if(!isset($show_val["Non_Admitted_performance"]) || $show_val["Non_Admitted_performance"] == "")
        {
            $show_val["Non_Admitted_performance"]    =   100;
        }
        if(!isset($show_val["NEL_Admissions"]) || $show_val["NEL_Admissions"] == "")
        {
            $show_val["NEL_Admissions"]    =   0;
        }
        if(!isset($show_val["EL_Admissions"]) || $show_val["EL_Admissions"] == "")
        {
            $show_val["EL_Admissions"]    =   0;
        }

        $findon_text                                =   "";
        $itu_text                                   =   "";
        $mdsu_text                                  =   "";
        $nhc_text                                   =   "";
        $altp_text                                  =   "";


        if($show_val["FINE_closed"] == 1)
        {
            $findon_text                              =   "Closed";
        }
        else
        {
            $findon_text                              =   $show_val["FINE"];
        }
        if($show_val["CRITC_closed"] == 1)
        {
            $itu_text                              =   "Closed";
        }
        else
        {
            $itu_text                              =   $show_val["CRITC"];
        }
        if($show_val["MDSU_closed"] == 1)
        {
            $mdsu_text                              =   "Closed";
        }
        else
        {
            $mdsu_text                              =   $show_val["MDSU"];
        }
        if($show_val["NHC_closed"] == 1)
        {
            $nhc_text                              =   "Closed";
        }
        else
        {
            $nhc_text                              =   $show_val["NHC"];
        }
        if($show_val["ALTP_closed"] == 1)
        {
            $altp_text                              =   "Closed";
        }
        else
        {
            $altp_text                              =   $show_val["ALTP"];
        }
        if(!isset($show_val["Total_empty_beds"])){
            $show_val["Total_empty_beds"] = 0;
        }

        if(!isset($show_val["Definite_Dischagre_Today"])){
            $show_val["Definite_Dischagre_Today"] = 0;
        }

        if(!isset($show_val["Potential_Dischagre_Today"])){
            $show_val["Potential_Dischagre_Today"] = 0;
        }

        if(!isset($show_val["Position"])){
            $show_val["Position"] = 0;
        }

        if(!isset($show_val["Today_Dischagres"])){
            $show_val["Today_Dischagres"] = 0;
        }

        if(!isset($show_val["Ambulance"])){
            $show_val["Ambulance"] = 0;
        }


        $text_create_show_case                      =   "";
        $text_create_show_case                      .=   "<b>ANE OPEL $ane_opel_status->ane_opel_status_data</b> (Updated At ".PredefinedDateFormatFor24Hour($ane_opel_status->ane_opel_status_data_updated_date_time).")<br><br>";
        $text_create_show_case                      .=   "<b>WARD OPEL $ward_opel_status->ane_opel_status_data</b> (Updated At ".PredefinedDateFormatFor24Hour($ward_opel_status->ane_opel_status_data_updated_date_time).")<br><br>";
        $text_create_show_case                      .=   "Attenders : ".$show_val["attendance_today_all"]."<br>";
        $text_create_show_case                      .=   "Overall Perf : ".number_format($show_val["performance"],2)."%<br>";
        $text_create_show_case                      .=   "Non-admitted performance : ".number_format($show_val["Non_Admitted_performance"],2)."%<br><br>";
        $text_create_show_case                      .=   "<b>Admissions</b><br><br>";
        $text_create_show_case                      .=   "NEL : ".$show_val["NEL_Admissions"]."<br>";
        $text_create_show_case                      .=   "EL : ".$show_val["EL_Admissions"]."<br><br>";
        $text_create_show_case                      .=   "<b>Capacity</b><br><br>";
        $text_create_show_case                      .=   "Beds Available Now : ".$show_val["Total_empty_beds"]."<br>";
        $text_create_show_case                      .=   "Confirmed discharges : ".$show_val["Definite_Dischagre_Today"]."<br>";
        $text_create_show_case                      .=   "Potential discharges : ".$show_val["Potential_Dischagre_Today"]."<br>";
        $text_create_show_case                      .=   "Position (incl. 50% pot.) : ".$show_val["Position"]."<br>";
        $text_create_show_case                      .=   "Finedon : ".$findon_text."<br>";
        $text_create_show_case                      .=   "ITU/HDU : ".$itu_text."<br>";
        $text_create_show_case                      .=   "MDSU : ".$mdsu_text."<br>";
        $text_create_show_case                      .=   "NHC : ".$nhc_text."<br>";
        $text_create_show_case                      .=   "Althorp : ".$altp_text."<br>";
        $text_create_show_case                      .=   "Total discharges today :".$show_val["Today_Dischagres"]."<br><br>";

        $text_create_show_case                      .=   "<b>* ANE Status * OPEL ".$ane_opel_status->ane_opel_status_data."</b><br><b>* WARD Status * OPEL ".$ward_opel_status->ane_opel_status_data."</b><br>";
        $text_create_show_case                      .=   "Breaches : ".$breaches_sum." ".$breaches_text."<br>";
        $text_create_show_case                      .=   "Pts Currently In ED : ".$show_val["in_ed_now"]."<br>";
        $text_create_show_case                      .=   "Pts Through ED : ".$show_val["attendance_ed_today"]."<br>";
        $text_create_show_case                      .=   "Pts Referred : ".$show_val["patients_with_referal"]."<br>";
        $text_create_show_case                      .=   "Pts With DTA : ".$show_val["patients_with_dta"]."<br>";
        $text_create_show_case                      .=   "Time to initial assessment: ".round($show_val["avg_triage_time"])." Minutes<br>";
        $text_create_show_case                      .=   "Time to see ED clinician: ".round($show_val["avg_ed_seen_time"])." Minutes<br>";
        $text_create_show_case                      .=   "Time to see spec: ".round($show_val["avg_speciality_time"])." Minutes<br>";
        $text_create_show_case                      .=   "Working to time: ".round($show_val["working_time"])." Minutes<br>";
        $text_create_show_case                      .=   "Ambulances Arrival : ".round($show_val["Ambulance"])."<br><br>";

        $text_create_show_case                      .=   "COA - 1 T&0 - Bed Allocated On Abington<br>";
        $text_create_show_case                      .=   "ACC - 0<br>";
        $text_create_show_case                      .=   "PAR - Normal Working<br>";
        $text_create_show_case                      .=   "Walter Tull Trollies - 5 Empty<br><br>";

        $text_create_show_case                      .=   "Maternity - GREEN<br>";
        $text_create_show_case                      .=   "Paediatrics - GREEN<br><br>";

        $text_create_show_case                      .=   "Full Capacity Protocol Areas: 0<br><br>";

        $text_create_show_case                      .=   "Staffing 17RNs & 10HCAs Short<br><br>";

        $text_create_show_case                      .=   "<b>Issues/plans</b><br><br><br><br>";




        $success_array["text_create_show_case"]    = $text_create_show_case;
        $success_array["office_text"]              = $office_text;


        $view                                                           = View::make('Dashboards.Camis.SiteOffice.IndexDataLoad', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;

    }


    public function SaveOfficeTextReport(Request $request)
    {


        $history_controller                     = new HistoryController;
        $history_opel_status                    = "App\Models\History\HistoryCamisIboxSiteOfficeText";
        $success_array                          = array();
        $updated_date_time                      = CurrentDateOnFormat();
        $text_reports                           = $request->text_office_reports;
        $user_id = Session()->get('LOGGED_USER_ID', '');
        $success_array["message"] = ErrorOccuredMessage();

        if ($user_id != "")
        {
            if ($text_reports != "")
            {
                $user_info_update       = 0;
                $gov_text_before_arr    = CamisIboxSiteOfficeText::first();
                $previous_id = $gov_text_before_arr->id ?? 1;
                $office_text_reports_update_details = CamisIboxSiteOfficeText::updateOrCreate(['id' => $previous_id], ['office_text' => $text_reports, 'updated_by' => $user_id]);


                if ($office_text_reports_update_details->wasRecentlyCreated)
                {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($office_text_reports_update_details, $history_opel_status);
                    $success_array["message"] = DataAddedMessage();
                    $updated_array      = $office_text_reports_update_details->getOriginal();
                    $gov_text_before    = array();
                    if (count($updated_array) > 0 && isset($updated_array["id"]))
                    {
                        $this->GovernanceOpelDataPreCall($updated_array["id"], $gov_text_before, 1);
                    }
                }
                else
                {
                    $history_controller->HistoryTableDataInsertFromUpdateCreate($office_text_reports_update_details, $history_opel_status, 2);

                    $updated_array      = $office_text_reports_update_details->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"]))
                    {
                        if ($gov_text_before_arr)
                        {
                            $gov_text_before = $gov_text_before_arr->toArray();
                            $this->GovernanceOpelDataPreCall($updated_array["id"], $gov_text_before, 2);
                        }
                    }

                    $success_array["message"] = DataUpdatedMessage();
                }

            }
        }
        $success_array["status"] = 1;
        $success_array['previous_text']  = HistoryCamisIboxSiteOfficeText::orderBy('updated_at', 'desc')->first()->office_text ?? '';
        return ReturnArrayAsJsonToScript($success_array);

    }

    public function GovernanceOpelDataPreCall($id, $gov_text_before, $operation)
    {
        $gov_data               = array();
        $gov_text_after         = array();

        $functional_identity    = 'Site Office Text Reports';
        if ($operation == 1)
        {
            if (isset($id) && $id != '')
            {
                $gov_text_after_arr = CamisIboxSiteOfficeText::where('id', '=', $id)->first();
                if ($gov_text_after_arr)
                {
                    $gov_text_after = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"]))
            {
                $gov_data["gov_text_before"]        = "";
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = 'OPEL Status';
            }
        }
        if ($operation == 2)
        {
            if (isset($id) && $id != '')
            {
                $gov_text_after_arr                 = CamisIboxSiteOfficeText::where('id', '=', $id)->first();

                if ($gov_text_after_arr)
                {
                    $gov_text_after                 = $gov_text_after_arr->toArray();
                }
            }
            if (isset($gov_text_after["id"]) && isset($gov_text_before["id"]))
            {
                $gov_data["gov_text_before"]        = json_encode($gov_text_before);
                $gov_data["gov_text_after"]         = json_encode($gov_text_after);
                $gov_data["gov_updation_status"]    = $operation;
                $gov_data["gov_func_identity"]      = $functional_identity;
                $gov_data["gov_description"]        = 'Site Office Reports';
            }
        }

        if (!empty($gov_data))
        {

            if (count($gov_data) > 0)
            {

                $governance = new GovernanceController;
                $governance->GovernanceStoreIboxData($gov_data);
            }
        }
    }

}
