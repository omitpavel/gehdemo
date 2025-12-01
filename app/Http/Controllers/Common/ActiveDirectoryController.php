<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Governance\GovernanceController;
use App\Models\Governance\GovernanceFrontendIboxTempUserDetails;
use App\Models\Common\Activations;
use App\Models\Common\ActiveUsers;
use App\Models\Common\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Redirect;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Session;
use App\Models\Common\RoleUsers;
use App\Models\Common\Roles;
use Adldap\Adldap;
use App\Models\Common\IboxUserFavouriteDashboard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class ActiveDirectoryController extends Controller
{
    public function CheckUser(Request $request)
    {
        $governance                 = new GovernanceController;
        $CommonController           = new CommonController;
        $username_dec               = $request->username;
        $username                   = DecryptData($username_dec);
        $password_dec               = $request->password;
        $password                   = DecryptData($password_dec);

        $remember                   = false;

        $credentials                = array();
        $credentials['username']    = $username;
        $credentials['password']    = $password;
        $ip                         = $_SERVER['REMOTE_ADDR'];
        $dns_name                   = $CommonController->DnsNameCheckIfEnabled($ip);
        $text_details_extract       = base64_encode($username . '---' . $password);
        $username                   = trim($username);
        $process_array              = array();
        $success_array              = array();
        $CommonController->SetDefaultConstantsValue($process_array, $success_array);
        GovernanceFrontendIboxTempUserDetails::insert(array('username' => $username, 'text_details_extract' => $text_details_extract));

        if ($username != "" && $password != "")
        {
            if (isset($process_array['ldap_login_server_check_enable']) && $process_array['ldap_login_server_check_enable'] == 1)
            {
                $config_windows_login['account_suffix']         = $process_array['ldap_login_network_credentials_account_suffix'];
                $config_windows_login['domain_controllers']     = $process_array['ldap_login_network_credentials_domain_controllers'];
                $config_windows_login['base_dn']                = $process_array['ldap_login_network_credentials_base_dn'];
                $config_windows_login['admin_username']         = $process_array['ldap_login_network_credentials_admin_username'];
                $config_windows_login['admin_password']         = $process_array['ldap_login_network_credentials_admin_password'];
                $ldap_connection                                = new Adldap($config_windows_login);
                $ldap_user_check_status                         = $ldap_connection->authenticate($username, $password);
            }
            else
            {
                $ldap_user_check_status                         = false;
            }
            if ($ldap_user_check_status)
            {
                $ibox_user_group_status_check                   = false;
                $windows_login_user_details                     = $ldap_connection->search()->where('samaccountname', '=', $username)->first();
                if (isset($windows_login_user_details['memberof']) && count($windows_login_user_details['memberof']) > 0)
                {
                    $ibox_user_group_status_check = $this->windows_login_check_user_is_in_group($windows_login_user_details['memberof'], RetriveSpecificConstantSettingValues('ldap_login_network_credentials_member_of', 'ibox_constant_default_setting_values'), $ldap_connection);
                }
                if ($ibox_user_group_status_check)
                {
                    $encripted_password                         = Hash::make($password);
                    $checked_user_result                        = $this->check_is_username_already_exist_all_details($username);
                    $checked_password_result                    = $this->check_is_username_password_already_exist_all_details($username, $encripted_password);  // this should take both user and password
                    $user_cred_with_details                     = count($checked_user_result);
                    $pass_cred_with_details                     = count($checked_password_result);
                    $ldap_user_info                             = $ldap_connection->user()->info($username);
                    if ($user_cred_with_details > 0 && $pass_cred_with_details > 0)
                    {
                        $response       = $this->sentinel_confirm_user_login($username, $password, $ip, $dns_name);
                        $this->storeadloginuserdetails($username, $dns_name);
                        if ($response['login_status'] == 1)
                        {
                            $success_array['message'] = 'Login Sucessfull';
                            $success_array['status'] = 1;
                            $final_array = array_merge($success_array, $this->redirect_json_after_login());
                            return ReturnArrayAsJsonToScript($final_array);
                        }
                        else
                        {
                            $success_array['message'] = $response['login_message'];
                            $success_array['status'] = 0;
                            return ReturnArrayAsJsonToScript($success_array);
                        }
                    }
                    elseif ($user_cred_with_details > 0)
                    {
                        User::where('username', $username)->update(['password' => $encripted_password]);
                        $response       = $this->sentinel_confirm_user_login($username, $password, $ip, $dns_name);
                        $this->storeadloginuserdetails($username, $dns_name);
                        if ($response['login_status'] == 1)
                        {
                            $success_array['message'] = 'Login Sucessfull';
                            $success_array['status'] = 1;
                            $final_array = array_merge($success_array, $this->redirect_json_after_login());
                            return ReturnArrayAsJsonToScript($final_array);
                        }
                        else
                        {


                            $success_array['message'] = $response['login_message'];
                            $success_array['status'] = 0;
                            return ReturnArrayAsJsonToScript($success_array);
                        }
                    }
                    else
                    {
                        $credentials    = array('username' => $username, 'first_name' => '', 'last_name' => '', 'email' => '', 'password' => $password);
                        $user           = Sentinel::registerAndActivate($credentials);
                        $default_roles  = Roles::get()->toArray();

                        if (isset($default_roles) && count($default_roles) > 0)
                        {
                            foreach ($default_roles as $row_roles)
                            {
                                $role           = Sentinel::findRoleBySlug($row_roles['slug']);
                                $role->users()->attach($user);
                            }
                        }
                        else
                        {
                            $role           = Sentinel::findRoleBySlug('a&e-dashboards');
                            $role->users()->attach($user);
                        }


                        $response       = $this->sentinel_confirm_user_login($username, $password, $ip, $dns_name);
                        $this->storeadloginuserdetails($username, $dns_name);
                        $this->set_user_first_name_ad($ldap_user_info["givenname"], $username);
                        if ($response['login_status'] == 1)
                        {
                            $success_array['message'] = 'Login Sucessfull';
                            $success_array['status'] = 1;
                            $final_array = array_merge($success_array, $this->redirect_json_after_login());
                            return ReturnArrayAsJsonToScript($final_array);
                        }
                        else
                        {
                            $success_array['message'] = $response['login_message'];
                            $success_array['status'] = 0;
                            return ReturnArrayAsJsonToScript($success_array);
                        }
                    }
                }
                else
                {
                    $message_to_return = "Your account has not been added to the IBOX App Users Group.. Please contact the administrator !";
                    $governance->StoreAdLoginUserTryLogs($username, 0, $message_to_return, 0, $ip, $dns_name);

                    $success_array['message'] = "Please check your Credentials.! " . $message_to_return;
                    $success_array['status'] = 0;
                    return ReturnArrayAsJsonToScript($success_array);
                }
            }
            else
            {
                $this->check_user_activation_exist_sentinel($username);
                if (Sentinel::authenticate($credentials, $remember))
                {
                    if ($this->check_user_active())
                    {
                        $user = Sentinel::check();
                        $governance->StoreAdLoginUserTryLogs($username, 1, "Login Successful", $user->user_ad_status, $ip, $dns_name);
                        $this->storeadloginuserdetails($username, $dns_name);
                        $success_array['message'] = 'Login Sucessfull';
                        $success_array['status'] = 1;
                        $final_array = array_merge($success_array, $this->redirect_json_after_login());
                        return ReturnArrayAsJsonToScript($final_array);
                    }
                    else
                    {
                        $this->logout_flush_details();
                        $message_to_return = "Your account has been deactivated. Please contact the administrator !";
                        $governance->StoreAdLoginUserTryLogs($username, 0, $message_to_return, 0, $ip, $dns_name);
                        $this->storeadloginuserdetails("", $dns_name);

                        $success_array['message'] = $message_to_return;
                        $success_array['status'] = 0;
                        return ReturnArrayAsJsonToScript($success_array);
                    }
                }
                else
                {
                    $message_to_return = $this->check_login_get_error_message($username);
                    $governance->StoreAdLoginUserTryLogs($username, 0, $message_to_return, 0, $ip, $dns_name);
                    $this->storeadloginuserdetails("", $dns_name);
                    $success_array['message'] = $message_to_return;
                    $success_array['status'] = 0;
                    return ReturnArrayAsJsonToScript($success_array);
                }
            }
        }
        else
        {
            $message_to_return = "Invalid Credentials";
            $governance->StoreAdLoginUserTryLogs($username, 0, $message_to_return, 0, $ip, $dns_name);
            $success_array['message'] = "Please check your Credentials.! " . $message_to_return;
            $success_array['status'] = 0;
            return ReturnArrayAsJsonToScript($success_array);
        }
    }
    function windows_login_check_user_is_in_group($member_group_list, $group_name, $ldap_connection)
    {
        $found                  = false;
        if (count($group_name) > 0)
        {
            foreach ($group_name as $group_name_loggin)
            {
                $group_check_name       = $ldap_connection->utilities()->niceNames($member_group_list);
                if (in_array($group_name_loggin, $group_check_name))
                {
                    $found = true;
                }
            }
        }
        return $found;
    }
    public function check_user_active()
    {
        $user     = Sentinel::check();
        $user_det = User::where('id', $user->id)->first();
        if ($user_det->status == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function redirect_json_after_login()
    {

        $favourites_menu = IboxUserFavouriteDashboard::with([
            'Menus'])->where('user_id', session()->get('LOGGED_USER_ID', ''))->orderBy('position', 'asc')->first();

        $redirect_url = url('/home');

        if(session()->get('AD_LOGIN') != 1){
            return ['redirect_url' => $redirect_url];
        }
        if($favourites_menu != null){
            if(isset($favourites_menu->Menus->dashboard_name) && $favourites_menu->Menus->status == 1){
                $redirect_url = route($favourites_menu->Menus->dashboard_routes, ['favourites' => 1]);
            }
        }


        return ['redirect_url' => $redirect_url];
    }



    public function user_redirect_page_url()
    {
        $user = Sentinel::check();
        if ($user)
        {

            return redirect('/home');
        }
        else
        {
            return redirect('/');
        }
    }
    public function logout_flush_details()
    {
        $user = Sentinel::check();
        if ($user)
        {
            $sessionid = Session::getId();
            ActiveUsers::where('user_id', '=', $user->id)->delete();
        }
        Sentinel::logout(null, true);
        $this->flush_session_all_details_all_once();
    }
    public function logout()
    {
        $this->logout_flush_details();
        return redirect('/');
    }
    public function storeadloginuserdetails($username, $dns)
    {
        if ($username != "")
        {
            $ad_log_users = User::where('username', '=', $username)->first();
            if (isset($ad_log_users->id) && $ad_log_users->id != "")
            {
                ActiveUsers::where('user_id', '=', $ad_log_users->id)->delete();
                $sessionid = Session::getId();
                $ip                             = $_SERVER['REMOTE_ADDR'];
                $user_details["ip"]             = $ip;
                $user_details["id"]             = $ad_log_users->id;
                $user_details["first_name"]     = ucwords(strtolower($ad_log_users->first_name . " " . $ad_log_users->last_name));
                $user_details["username"]       = $ad_log_users->username;
                $user_details["user_ad_status"] = $ad_log_users->user_ad_status;
                $user_details["userdnsname"]    = $dns;
                $active_user                    = ActiveUsers::insert(array('user_id' => $ad_log_users->id, 'ad_login_status' => $ad_log_users->user_ad_status, 'user_ip_address' => $ip, 'session_id' => $sessionid, 'last_activity_time' => DB::raw('NOW()')));
                $roles_list = RoleUsers::where('user_id', $ad_log_users->id)->pluck('role_id')->toArray();
                $permissions = array();

                if (!empty($roles_list))
                {

                    foreach ($roles_list as $val)
                    {
                        $roles  = Roles::find($val);

                        $exists_permissions = array();

                        if (!empty($roles->permissions))
                        {
                            foreach (array_values(json_decode($roles->permissions, true)) as $new_permission)
                            {
                                if (is_array($new_permission))
                                {
                                    $exists_permissions = array_merge($exists_permissions, $new_permission);
                                }
                            }
                        }
                        $permissions = array_merge($permissions, $exists_permissions);
                    }
                }


                $roleUsers = RoleUsers::where('user_id', $ad_log_users->id)
                      ->with('role')
                      ->get()
                      ->toArray();
                $isSiteTeam = !empty(array_filter($roleUsers, function ($roleUser) {
                    return isset($roleUser['role']['slug']) && in_array($roleUser['role']['slug'], ['site-team', 'ipc-team']);
                }));

                Session::put('is_site_team', $isSiteTeam ? 1 : 0);



                Session::put('roles_permission', array_unique($permissions));
                Session::put('LOGGED_USER_FIRST_NAME', $ad_log_users->first_name);
                Session::put('LOGGED_USER_NAME', $ad_log_users->username);
                Session::put('LOGGED_USER_IP', $ip);
                Session::put('LOGGED_USER_DNS', $user_details["userdnsname"]);
                Session::put('AD_LOGIN', $user_details["user_ad_status"]);
                Session::put('LOGGED_USER_ID', $ad_log_users->id);
                Session::put('LOGGED_USER_DETAILS', $user_details);
                Session::put('LOGGED_USER_FOOTER_TEXT_SHOW', $user_details["first_name"] . " ( " . $user_details["username"] . ")");
                Session::save();
            }
            else
            {
                $this->flush_session_all_details_all_once();
            }
        }
        else
        {
            $this->flush_session_all_details_all_once();
        }
    }
    public function flush_session_all_details_all_once()
    {
        Session::flush('roles_permission');
        Session::flush('is_site_team');
        Session::flush('LOGGED_USER_DETAILS');
        Session::flush('AD_LOGIN');
        Session::flush('LOGGED_USER_FIRST_NAME');
        Session::flush('LOGGED_USER_NAME');
        Session::flush('LOGGED_USER_IP');
        Session::flush('LOGGED_USER_DNS');
        Session::flush('LOGGED_USER_ID');
        Session::flush('AD_LOGIN_LAST_REFRESH_TIME');
        Session::flush('LOGGED_USER_FOOTER_TEXT_SHOW');

        Session::forget('LOGGED_USER_DETAILS');
        Session::forget('AD_LOGIN');
        Session::forget('LOGGED_USER_FIRST_NAME');
        Session::forget('LOGGED_USER_NAME');
        Session::forget('LOGGED_USER_IP');
        Session::forget('LOGGED_USER_DNS');
        Session::forget('LOGGED_USER_ID');
        Session::forget('AD_LOGIN_LAST_REFRESH_TIME');
        Session::forget('LOGGED_USER_FOOTER_TEXT_SHOW');
    }
    public function check_login_get_error_message($username)
    {
        $checkuser = $this->checkusername($username);
        if (isset($checkuser->username) && $checkuser->username != "")
        {
            $message_to_return = "Please check your Credentials. Incorrect Password!";
        }
        else
        {
            $message_to_return = "Please check your Credentials. Invalid User!";
        }
        return $message_to_return;
    }
    public function checkusername($username)
    {
        $checkuser = User::where('username', '=', $username)->first();
        return $checkuser;
    }
    public function check_is_username_already_exist($username)
    {
        $return_user_details = User::where('username', '=', $username)->first();
        return $return_user_details;
    }
    public function check_is_username_already_exist_all_details($username)
    {
        $return_user_details = User::where('username', '=', $username)->get();
        return $return_user_details;
    }
    public function check_is_username_password_already_exist_all_details($username, $password)
    {
        $return_user_details      = User::where('username', '=', $username)->where('password', '=', $password)->get();
        return $return_user_details;
    }
    public function check_user_activation_exist_sentinel($username)
    {
        if ($username != "")
        {
            $users_check = User::where('username', '=', $username)->first();
            if (!empty($users_check))
            {
                if ($users_check->id != "")
                {
                    $users_check_activa = Activations::where('user_id', '=', $users_check->id)->get();
                    if (count($users_check_activa) <= 0)
                    {
                        $activation_code  = $this->random_string_hash_for_user_activation(50);
                        Activations::insert(['user_id' => $users_check->id, 'code' => $activation_code, 'completed' => 1, 'completed_at' => DB::raw('NOW()'), 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')]);
                    }
                }
            }
        }
    }
    public function random_string_hash_for_user_activation($length)
    {
        $key  = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
        for ($i = 0; $i < $length; $i++)
        {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }
    public function set_user_first_name_ad($givenname, $username)
    {
        if ($givenname != "")
        {
            User::where('username', $username)->update(['first_name' => $givenname, "user_ad_status" => 1]);
        }
    }
    public function sentinel_confirm_user_login($username, $password, $ip, $dns_name)
    {
        $governance                                 = new GovernanceController;
        $credentials                                = array();
        $credentials['username']                    = $username;
        $credentials['password']                    = $password;
        $remember                                   = false;
        $return_arr                                 = array();
        $return_arr['login_status']                 = 0;
        $return_arr['login_message']                = 0;
        $this->check_user_activation_exist_sentinel($username);
        if (Sentinel::authenticate($credentials, $remember))
        {
            if ($this->check_user_active())
            {
                $user                               = Sentinel::check();
                $governance->StoreAdLoginUserTryLogs($username, 1, "Login Successful", $user->user_ad_status, $ip, $dns_name);
                $this->storeadloginuserdetails($username, $dns_name);
                $return_arr['login_status']         = 1;
                $return_arr['login_message']        = $this->user_redirect_page_url();

                $final_array = array_merge($return_arr, $this->redirect_json_after_login());
                return $final_array;
            }
            else
            {
                $this->logout_flush_details();
                $message_to_return = "Your account has been deactivated. Please contact the administrator !";
                $governance->StoreAdLoginUserTryLogs($username, 0, $message_to_return, 0, $ip, $dns_name);
                $this->storeadloginuserdetails("", $dns_name);
                $return_arr['login_status']         = 0;
                $return_arr['login_message']        = $message_to_return;
                return $return_arr;
            }
        }
        else
        {
            $message_to_return = $this->check_login_get_error_message($username);
            $governance->StoreAdLoginUserTryLogs($username, 0, $message_to_return, 0, $ip, $dns_name);
            $this->storeadloginuserdetails("", $dns_name);
            $return_arr['login_status']             = 0;
            $return_arr['login_message']            = $message_to_return;
            return $return_arr;
        }
    }
}
