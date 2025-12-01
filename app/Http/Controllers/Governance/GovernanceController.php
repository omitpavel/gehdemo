<?php

namespace App\Http\Controllers\Governance;

use App\Http\Controllers\Controller;
use App\Models\Governance\GovernanceFrontendSymphonyOperationLogs;
use App\Models\Governance\GovernanceFrontendSymphonyOperationLogsExtraDetails;
use App\Models\Governance\GovernanceFrontendCamisOperationLogs;
use App\Models\Governance\GovernanceFrontendCamisOperationLogsExtraDetails;
use App\Models\Governance\GovernanceFrontendIboxOperationLogs;
use App\Models\Governance\GovernanceFrontendIboxOperationLogsExtraDetails;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Governance\GovernanceFrontendUserLoginStatus;
use App\Models\Governance\GovernanceFrontendUserPageLogs;
use App\Models\Iboards\Symphony\Data\SymphonyAttendance;
use App\Models\Governance\GovernanceMasterStatus;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Models\Common\User;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Models\Governance\GovernanceUserAdminLogs;

class GovernanceController extends Controller
{
    public function StoreAdLoginUserTryLogs($username, $message_title, $status_message, $ad_user_status, $ip, $dns_name)
    {
        $login_date = CurrentDateOnFormat();
        $log_status_entry = GovernanceFrontendUserLoginStatus::insert(['username' => $username, 'ip_address' => $ip, 'user_dns_name' => $dns_name, 'login_status' => $message_title, 'status_message' => $status_message, 'ad_user_status' => $ad_user_status, 'signin_datetime' => $login_date]);
        return $log_status_entry;
    }

    public function StorePageLogs(Request $request)
    {
        if (Sentinel::check())
        {

            $page_title = $request->pagetitle;
            $page_sub_vale = strpos($request->pageurl, "?");
            $page_url = ($page_sub_vale > 0) ? urlencode(substr($request->pageurl, 0, strpos($request->pageurl, "?"))) : urlencode($request->pageurl);
            $page_url_org = urlencode($request->pageurl);
            $user_name = Session()->get('LOGGED_USER_FIRST_NAME') ?? "";
            $user_ip = Session()->get('LOGGED_USER_IP') ?? "";
            $user_dns = Session()->get('LOGGED_USER_DNS') ?? "";
            $user_username = Session()->get('LOGGED_USER_NAME') ?? "";
            $user_id = Session()->get('LOGGED_USER_ID') ?? "";

            GovernanceFrontendUserPageLogs::insert(['username' => $user_username, 'ip_address' => $user_ip, 'user_first_name' => $user_name, 'user_id' => $user_id, 'user_dns' => $user_dns, 'page_title' => $page_title, 'page_url' => $page_url, 'page_url_org' => $page_url_org]);
        }
        return 1;
    }
    public function GovernanceStoreSymphonyData($gov_det)
    {
        $gov_status_master = GovernanceMasterStatus::pluck('status_plural_name', 'status_val')->all();

        if (!empty($gov_det))
        {
            if (count($gov_det) > 0)
            {
                $gov_user_name                          = Session()->get('LOGGED_USER_FIRST_NAME') ?? "";
                $gov_user_ip                            = Session()->get('LOGGED_USER_IP') ?? "";
                $gov_user_dns_name                      = Session()->get('LOGGED_USER_DNS') ?? "";
                $gov_user_username                      = Session()->get('LOGGED_USER_NAME') ?? "";
                $gov_user_id                            = Session()->get('LOGGED_USER_ID') ?? 0;
                $gov_user_ad_status                     = Session()->get('AD_LOGIN') ?? 0;
                $gov_attendance_id                      = $gov_det["gov_attendance_id"] ?? "";
                $gov_patient_name                       = "";
                $gov_attendance_details                 = "";
                $gov_description                        = $gov_det["gov_description"] ?? "";
                $gov_updation_status                    = $gov_det["gov_updation_status"] ?? 0;
                $gov_text_before                        = $gov_det["gov_text_before"] ?? "";
                $gov_text_after                         = $gov_det["gov_text_after"] ?? "";
                $gov_func_identity                      = $gov_det["gov_func_identity"] ?? "";

                if ($gov_attendance_id != "")
                {
                    $gov_attendance_details_array       = SymphonyAttendance::where("symphony_attendance_id", "=", $gov_attendance_id)->first();
                    if ($gov_attendance_details_array)
                    {
                        if (isset($gov_attendance_details_array->symphony_patient_name))
                        {
                            $gov_patient_name           = $gov_attendance_details_array->symphony_patient_name;
                        }
                        $gov_attendance_details         = json_encode($gov_attendance_details_array);
                    }
                }
                if ($gov_description != '')
                {
                    $gov_description                    = $gov_description . " - " . $gov_func_identity;
                }
                else
                {
                    $gov_description                    = $gov_func_identity;
                }
                if (isset($gov_status_master[$gov_updation_status]))
                {
                    $gov_description                    = $gov_description . " " . $gov_status_master[$gov_updation_status] . ". ";
                }
                else
                {
                    $gov_description                    = $gov_description . ". ";
                }
                $governance_data = array(
                    'gov_user_id' => $gov_user_id,
                    'gov_user_ip' => $gov_user_ip,
                    'gov_user_dns_name' => $gov_user_dns_name,
                    'gov_user_username' => $gov_user_username,
                    'gov_user_name' => $gov_user_name,
                    'gov_user_ad_status' => $gov_user_ad_status,
                    'gov_description' => $gov_description,
                    'gov_updation_status' => $gov_updation_status,
                    'gov_func_identity' => $gov_func_identity,
                    'gov_attendance_id' => $gov_attendance_id,
                    'gov_patient_name' => $gov_patient_name
                );
                $insert_id = GovernanceFrontendSymphonyOperationLogs::insertGetId($governance_data);
                $governance_data_extra_details = array(
                    'gov_operation_logs_id' => $insert_id,
                    'gov_text_before' => $gov_text_before,
                    'gov_text_after' => $gov_text_after,
                    'gov_attendance_details' => $gov_attendance_details
                );
                $res = GovernanceFrontendSymphonyOperationLogsExtraDetails::insert($governance_data_extra_details);
            }
        }
    }



    public function GovernanceStoreSymphonyDataAutoUpdate($gov_det)
    {
        $gov_status_master                                  = GovernanceMasterStatus::pluck('status_plural_name', 'status_val')->all();
        RetriveConstantSettingValues($process_array, "ibox_constant_default_setting_values");
        if (isset($process_array['ibox_auto_set_admin_id']) && $process_array['ibox_auto_set_admin_id'] != '')
        {
            $auto_user_id                                   = $process_array['ibox_auto_set_admin_id'];
        }
        $breach_auto_set_user_credentials                   = User::where('id', '=', $auto_user_id)->first();
        if (isset($breach_auto_set_user_credentials->id))
        {
            if ($breach_auto_set_user_credentials->id != '')
            {
                if (!empty($gov_det))
                {
                    if (count($gov_det) > 0)
                    {
                        $gov_user_name                          = $breach_auto_set_user_credentials->first_name;
                        $gov_user_ip                            = "";
                        $gov_user_dns_name                      = "";
                        $gov_user_username                      = $breach_auto_set_user_credentials->username;;
                        $gov_user_id                            = $breach_auto_set_user_credentials->id;
                        $gov_user_ad_status                     = 0;

                        $gov_attendance_id                      = $gov_det["gov_attendance_id"] ?? "";
                        $gov_patient_name                       = "";
                        $gov_attendance_details                 = "";
                        $gov_description                        = $gov_det["gov_description"] ?? "";
                        $gov_updation_status                    = $gov_det["gov_updation_status"] ?? 0;
                        $gov_text_before                        = $gov_det["gov_text_before"] ?? "";
                        $gov_text_after                         = $gov_det["gov_text_after"] ?? "";
                        $gov_func_identity                      = $gov_det["gov_func_identity"] ?? "";

                        if ($gov_attendance_id != "")
                        {
                            $gov_attendance_details_array       = SymphonyAttendance::where("symphony_attendance_id", "=", $gov_attendance_id)->first();
                            if ($gov_attendance_details_array)
                            {
                                if (isset($gov_attendance_details_array->symphony_patient_name))
                                {
                                    $gov_patient_name           = $gov_attendance_details_array->symphony_patient_name;
                                }
                                $gov_attendance_details         = json_encode($gov_attendance_details_array);
                            }
                        }
                        if ($gov_description != '')
                        {
                            $gov_description                    = $gov_description . " - " . $gov_func_identity;
                        }
                        else
                        {
                            $gov_description                    = $gov_func_identity;
                        }
                        if (isset($gov_status_master[$gov_updation_status]))
                        {
                            $gov_description                    = $gov_description . " " . $gov_status_master[$gov_updation_status] . ". ";
                        }
                        else
                        {
                            $gov_description                    = $gov_description . ". ";
                        }
                        $governance_data = array(
                            'gov_user_id' => $gov_user_id,
                            'gov_user_ip' => $gov_user_ip,
                            'gov_user_dns_name' => $gov_user_dns_name,
                            'gov_user_username' => $gov_user_username,
                            'gov_user_name' => $gov_user_name,
                            'gov_user_ad_status' => $gov_user_ad_status,
                            'gov_description' => $gov_description,
                            'gov_updation_status' => $gov_updation_status,
                            'gov_func_identity' => $gov_func_identity,
                            'gov_attendance_id' => $gov_attendance_id,
                            'gov_patient_name' => $gov_patient_name
                        );
                        $insert_id = GovernanceFrontendSymphonyOperationLogs::insertGetId($governance_data);
                        $governance_data_extra_details = array(
                            'gov_operation_logs_id' => $insert_id,
                            'gov_text_before' => $gov_text_before,
                            'gov_text_after' => $gov_text_after,
                            'gov_attendance_details' => $gov_attendance_details
                        );
                        $res = GovernanceFrontendSymphonyOperationLogsExtraDetails::insert($governance_data_extra_details);
                    }
                }
            }
        }
    }


    public function GovernanceStoreCamisData($gov_det)
    {
        $gov_status_master = GovernanceMasterStatus::pluck('status_plural_name', 'status_val')->all();

        if (!empty($gov_det))
        {
            if (count($gov_det) > 0)
            {
                $auto_id                                = User::where('id', RetriveSpecificConstantSettingValues('ibox_auto_set_admin_id','ibox_constant_default_setting_values'))->first();

                $gov_user_name                          = Session()->get('LOGGED_USER_FIRST_NAME') ?? "";
                $gov_user_ip                            = Session()->get('LOGGED_USER_IP') ?? "";
                $gov_user_dns_name                      = Session()->get('LOGGED_USER_DNS') ?? "";
                if (Session()->has('LOGGED_USER_NAME'))
                {
                    $gov_user_username = Session()->get('LOGGED_USER_NAME');
                } else {
                    $gov_user_username = $auto_id->username  ?? '';
                }
                $gov_user_id                            = Session()->get('LOGGED_USER_ID') ?? RetriveSpecificConstantSettingValues('ibox_auto_set_admin_id','ibox_constant_default_setting_values');
                $gov_user_ad_status                     = Session()->get('AD_LOGIN') ?? 0;
                $gov_patient_id                         = $gov_det["gov_patient_id"] ?? "";
                $gov_pass_number                         = "";
                $gov_patient_name                       = "";
                $gov_patient_ward_id                    = 0;
                $gov_patient_ward_name                  = "";
                $gov_patient_bed_actual_name            = "";
                $gov_patient_ibox_bed_actual_name       = "";
                $gov_patient_details                    = "";
                $gov_attendance_details                 = "";
                $gov_description                        = $gov_det["gov_description"] ?? "";
                $gov_updation_status                    = $gov_det["gov_updation_status"] ?? 0;
                $gov_text_before                        = $gov_det["gov_text_before"] ?? "";
                $gov_text_after                         = $gov_det["gov_text_after"] ?? "";
                $gov_func_identity                      = $gov_det["gov_func_identity"] ?? "";




                if ($gov_patient_id != "")
                {

                    $gov_camis_details_array      = CamisIboxWardPatientInformationWithBedDetailsView::with('PatientPosition.SdecPosition.bedGroup')->where('camis_patient_id', '=', $gov_patient_id)->first();



                    if ($gov_camis_details_array)
                    {
                        if (isset($gov_camis_details_array->camis_patient_name))
                        {
                            if($gov_camis_details_array->camis_patient_ward_id != 13888){
                                $gov_patient_name           = $gov_camis_details_array->camis_patient_name;
                                $gov_pass_number             = $gov_camis_details_array->camis_patient_pas_number;
                                $gov_patient_ward_id           = $gov_camis_details_array->ibox_ward_id;
                                $gov_patient_ward_name           = $gov_camis_details_array->ibox_ward_name;
                                $gov_patient_bed_actual_name           = $gov_camis_details_array->ibox_bed_actual_name;
                                $gov_patient_ibox_bed_actual_name           = $gov_camis_details_array->ibox_actual_bed_full_name;
                            } else {

                                if(isset($gov_camis_details_array->PatientPosition->SdecPosition->bedGroup)){
                                    $bed_name = $gov_camis_details_array->PatientPosition->SdecPosition->bedGroup->bed_group_name.' '.$gov_camis_details_array->PatientPosition->SdecPosition->bed_actual_name;
                                } else {
                                    $bed_name = '';
                                }


                                $gov_patient_name           = $gov_camis_details_array->camis_patient_name;
                                $gov_pass_number             = $gov_camis_details_array->camis_patient_pas_number;
                                $gov_patient_ward_id           = $gov_camis_details_array->camis_patient_ward_id;
                                $gov_patient_ward_name           = 'SDEC';
                                $gov_patient_bed_actual_name           = $bed_name;
                                $gov_patient_ibox_bed_actual_name           = $bed_name;
                            }

                        }
                        $gov_patient_details         = json_encode($gov_camis_details_array);
                    }
                }
                if ($gov_description != '')
                {
                    $gov_description                    = $gov_description . " - " . $gov_func_identity;
                }
                else
                {
                    $gov_description                    = $gov_func_identity;
                }
                if (isset($gov_status_master[$gov_updation_status]))
                {
                    $gov_description                    = $gov_description . " " . $gov_status_master[$gov_updation_status] . ". ";
                }
                else
                {
                    $gov_description                    = $gov_description . ". ";
                }
                $governance_data = array(
                    'gov_user_id' => $gov_user_id,
                    'gov_user_ip' => $gov_user_ip,
                    'gov_user_dns_name' => $gov_user_dns_name,
                    'gov_user_username' => $gov_user_username,
                    'gov_user_name' => $gov_user_name,
                    'gov_user_ad_status' => $gov_user_ad_status,
                    'gov_description' => $gov_description,
                    'gov_updation_status' => $gov_updation_status,
                    'gov_func_identity' => $gov_func_identity,
                    'gov_patient_id' => $gov_patient_id,
                    'gov_pass_number' => $gov_pass_number,
                    'gov_patient_name' => $gov_patient_name,
                    'gov_patient_ward_id' => $gov_patient_ward_id,
                    'gov_patient_ward_name' => $gov_patient_ward_name,
                    'gov_patient_bed_actual_name' => $gov_patient_bed_actual_name,
                    'gov_patient_ibox_bed_actual_name' => $gov_patient_ibox_bed_actual_name
                );
                $insert_id = GovernanceFrontendCamisOperationLogs::insertGetId($governance_data);
                $governance_data_extra_details = array(
                    'gov_operation_logs_id' => $insert_id,
                    'gov_text_before' => $gov_text_before,
                    'gov_text_after' => $gov_text_after,
                    'gov_patient_details' => $gov_patient_details
                );
                $res = GovernanceFrontendCamisOperationLogsExtraDetails::insert($governance_data_extra_details);
            }
        }
    }


    public function GovernanceStoreIboxData($gov_det)
    {
        $gov_status_master = GovernanceMasterStatus::pluck('status_plural_name', 'status_val')->all();

        if (!empty($gov_det))
        {
            if (count($gov_det) > 0)
            {
                $gov_user_name                          = Session()->get('LOGGED_USER_FIRST_NAME') ?? "";
                $gov_user_ip                            = Session()->get('LOGGED_USER_IP') ?? "";
                $gov_user_dns_name                      = Session()->get('LOGGED_USER_DNS') ?? "";
                $gov_user_username                      = Session()->get('LOGGED_USER_NAME') ?? "";
                $gov_user_id                            = Session()->get('LOGGED_USER_ID') ?? 0;
                $gov_user_ad_status                     = Session()->get('AD_LOGIN') ?? 0;
                $gov_patient_name                       = "";
                $gov_attendance_details                 = "";
                $gov_description                        = $gov_det["gov_description"] ?? "";
                $gov_updation_status                    = $gov_det["gov_updation_status"] ?? 0;
                $gov_text_before                        = $gov_det["gov_text_before"] ?? "";
                $gov_text_after                         = $gov_det["gov_text_after"] ?? "";
                $gov_func_identity                      = $gov_det["gov_func_identity"] ?? "";


                if ($gov_description != '')
                {
                    $gov_description                    = $gov_description . " - " . $gov_func_identity;
                }
                else
                {
                    $gov_description                    = $gov_func_identity;
                }


                if (isset($gov_status_master[$gov_updation_status]))
                {
                    $gov_description                    = $gov_description . " " . $gov_status_master[$gov_updation_status] . ". ";
                }
                else
                {
                    $gov_description                    = $gov_description . ". ";
                }


                $governance_data = array(
                    'gov_user_id' => $gov_user_id,
                    'gov_user_ip' => $gov_user_ip,
                    'gov_user_dns_name' => $gov_user_dns_name,
                    'gov_user_username' => $gov_user_username,
                    'gov_user_name' => $gov_user_name,
                    'gov_user_ad_status' => $gov_user_ad_status,
                    'gov_description' => $gov_description,
                    'gov_updation_status' => $gov_updation_status,
                    'gov_func_identity' => $gov_func_identity,
                );
                $insert_id = GovernanceFrontendIboxOperationLogs::insertGetId($governance_data);
                $governance_data_extra_details = array(
                    'gov_operation_logs_id' => $insert_id,
                    'gov_text_before' => $gov_text_before,
                    'gov_text_after' => $gov_text_after
                );
                $res = GovernanceFrontendIboxOperationLogsExtraDetails::insert($governance_data_extra_details);
            }
        }
    }
    public function GovernanceStoreCamisMasterData($gov_det)
    {
        $gov_status_master  =   GovernanceMasterStatus::pluck('status_plural_name', 'status_val')->all();

        if (!empty($gov_det))
        {
            if (count($gov_det) > 0)
            {
                $gov_description = "";
                $gov_text_before = "";
                $gov_text_after = "";
                $gov_updation_status = 0;
                $gov_func_identity = "";
                $gov_user_name = "";
                $gov_user_username = "";
                $gov_user_ip = "";
                $gov_user_id = 0;
                $gov_user_ad_status = 0;
                $gov_user_dns_name = "";

                if (Session()->has('LOGGED_USER_FIRST_NAME'))
                {
                    $gov_user_name = Session()->get('LOGGED_USER_FIRST_NAME');
                }
                if (Session()->has('LOGGED_USER_IP'))
                {
                    $gov_user_ip = Session()->get('LOGGED_USER_IP');
                }
                if (Session()->has('LOGGED_USER_DNS'))
                {
                    $gov_user_dns_name = Session()->get('LOGGED_USER_DNS');
                }
                if (Session()->has('LOGGED_USER_NAME'))
                {
                    $gov_user_username = Session()->get('LOGGED_USER_NAME');
                }
                if (Session()->has('LOGGED_USER_ID'))
                {
                    $gov_user_id = Session()->get('LOGGED_USER_ID');
                }
                if (Session()->has('AD_LOGIN'))
                {
                    $gov_user_ad_status = Session()->get('AD_LOGIN');
                }
                if (isset($gov_det["gov_description"]))
                {
                    $gov_description = $gov_det["gov_description"];
                }
                if (isset($gov_det["gov_updation_status"]))
                {
                    $gov_updation_status = $gov_det["gov_updation_status"];
                }
                if (isset($gov_det["gov_text_before"]))
                {
                    $gov_text_before = $gov_det["gov_text_before"];
                }
                if (isset($gov_det["gov_text_after"]))
                {
                    $gov_text_after = $gov_det["gov_text_after"];
                }
                if (isset($gov_det["gov_func_identity"]))
                {
                    $gov_func_identity = $gov_det["gov_func_identity"];
                }

                if (isset($gov_status_master[$gov_updation_status]))
                {
                    $gov_description        =   $gov_description . " - " . $gov_func_identity . " " . $gov_status_master[$gov_updation_status] . ". ";
                }
                else
                {
                    $gov_description        =   $gov_description . " - " . $gov_func_identity . ". ";
                }

                $governance_data = array(
                    'gov_user_id'           => $gov_user_id,
                    'gov_user_ip'           => $gov_user_ip,
                    'gov_user_dns_name'     => $gov_user_dns_name,
                    'gov_user_username'     => $gov_user_username,
                    'gov_user_name'         => $gov_user_name,
                    'gov_user_ad_status'    => $gov_user_ad_status,
                    'gov_description'       => $gov_description,
                    'gov_updation_status'   => $gov_updation_status,
                    'gov_text_before'       => $gov_text_before,
                    'gov_text_after'        => $gov_text_after,
                    'gov_func_identity'     => $gov_func_identity
                );
                $res = GovernanceUserAdminLogs::insert($governance_data);
            }
        }
    }
}
