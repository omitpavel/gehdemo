<?php


namespace App\Http\Controllers\Iboards\Camis;


use App\Http\Controllers\Common\CommonCamisController;
use App\Http\Controllers\Common\CommonController;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use App\Models\Iboards\Camis\Master\DpTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskAkiAssessmentTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskNofTasks;
use App\Models\Iboards\Camis\Master\BoardRoundUserTaskSepsisTasks;
use App\Models\Iboards\Camis\View\CamisIboxPatientInfoVitalpacView;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use View;
use Sentinel;
class VirtualWardController
{
      public function index($ward, Request $request)
      {
            if(CheckSpecificPermission('virtual_ward_dashboard_view')){

                $process_array                                                  = array();
                $success_array                                                  = array();
                $success_array["ward"]                                          = ($ward != '') ? strtolower($ward) : '';

                $this->PageDataLoad($process_array, $success_array);
                if(!@$success_array['url'])
                        return view('Dashboards.Camis.VirtualWard.Index', compact('success_array'));
                else
                        return view('errors.404');
            } else {
                Toastr::error('Permission Denied');
                return back();
            }
      }

      public function PageDataLoad(&$process_array, &$success_array)
      {
        $success_array['show_on_ward_summary_status_check']             = BoardRoundFlagList::where('show_on_normal_ward', 1)->pluck('patient_flag_name', 'patient_flag_stored_name')->toArray();
          $common_controller                                              = new CommonController;
          $common_camis_controller                                        = new CommonCamisController;
          if (strtolower($success_array['ward']) === 'one-to-one-care') {
              $patient_flags = CamisIboxBoardRoundPatientFlag::where(['patient_flag_name' => 'ibox_patient_flag_one_one_care', 'patient_flag_status_value' => 1])->pluck('patient_id');
              $success_array['patient_ids'] = $patient_flags;

              if($patient_flags) {
                  $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

              }
          }
          elseif (strtolower($success_array['ward']) === 'palliative-care') {
            $patient_flags = CamisIboxBoardRoundPatientFlag::where(['patient_flag_name' => 'ibox_patient_flag_palliative_care', 'patient_flag_status_value' => 1])->pluck('patient_id');
            $success_array['patient_ids'] = $patient_flags;

            if($patient_flags) {
                $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

            }
        }
          elseif (strtolower($success_array['ward']) === 'frailty') {
              $patient_flags = CamisIboxBoardRoundPatientFlag::where(['patient_flag_name' => 'ibox_patient_flag_frailty', 'patient_flag_status_value' => 1])->pluck('patient_id');
              $success_array['patient_ids'] = $patient_flags;

              if($patient_flags) {

                  $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

              }
          }
          elseif (strtolower($success_array['ward']) === 'amhat') {
            $patient_flags = CamisIboxBoardRoundPatientFlag::where(['patient_flag_name' => 'ibox_patient_flag_amhat', 'patient_flag_status_value' => 1])->pluck('patient_id');
            $success_array['patient_ids'] = $patient_flags;

            if($patient_flags) {

                $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

            }
        }
          elseif (strtolower($success_array['ward']) === 'diabetics-status') {
              $patient_flags = CamisIboxBoardRoundPatientFlag::where(['patient_flag_name' => 'ibox_patient_flag_diabetic_foot', 'patient_flag_status_value' => 1])->pluck('patient_id');
              $success_array['patient_ids'] = $patient_flags;

              if($patient_flags) {
                  $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

              }
          }
          elseif (strtolower($success_array['ward']) === 'dementia-delirium') {
              $patient_flags = CamisIboxBoardRoundPatientFlag::where('patient_flag_name', 'ibox_patient_flag_dementia')
                                                              ->orWhere('patient_flag_name', 'ibox_patient_flag_delerium')
                                                              ->where('patient_flag_status_value', 1)
                                                              ->pluck('patient_id');
              $success_array['patient_ids'] = $patient_flags;

              if($patient_flags) {
                  $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

              }
          }
          elseif (strtolower($success_array['ward']) === 'risk-of-falls') {

              $patient_flags = CamisIboxBoardRoundPatientFlag::where(['patient_flag_name' => 'ibox_patient_flag_risk_of_falls', 'patient_flag_status_value' => 1])->pluck('patient_id');
              $success_array['patient_ids'] = $patient_flags;

              if($patient_flags) {
                  $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

              }
          }
          elseif (strtolower($success_array['ward']) === 'pressure-ulcer') {
              $patient_flags = CamisIboxBoardRoundPatientFlag::where(['patient_flag_name' => 'ibox_patient_flag_pressure_ulc', 'patient_flag_status_value' => 1])->pluck('patient_id');
              $success_array['patient_ids'] = $patient_flags;

              if($patient_flags) {
                  $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

              }
          }
          elseif (strtolower($success_array['ward']) === 'amber-care-eol') {
              $patient_flags = CamisIboxBoardRoundPatientFlag::where('patient_flag_name', 'ibox_patient_flag_amber_care')
                  ->orWhere('patient_flag_name', 'ibox_patient_flag_end_of_life')
                  ->where('patient_flag_status_value', 1)
                  ->pluck('patient_id');
              $success_array['patient_ids'] = $patient_flags;

              if($patient_flags) {
                  $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

              }
          }
          elseif (strtolower($success_array['ward']) === 'sova-dols-ld') {
              $patient_flags = CamisIboxBoardRoundPatientFlag::where('patient_flag_name', 'ibox_patient_flag_sova')
                  ->orWhere('patient_flag_name', 'ibox_patient_flag_dols')
                  ->orWhere('patient_flag_name', 'ibox_patient_flag_ld')
                  ->where('patient_flag_status_value', 1)
                  ->pluck('patient_id');
              $success_array['patient_ids'] = $patient_flags;

              if($patient_flags) {
                  $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

              }
          }
          elseif (strtolower($success_array['ward']) === 'nutrition-risk') {
              $patient_flags = CamisIboxBoardRoundPatientFlag::where(['patient_flag_name' => 'ibox_patient_flag_nutrition_risk', 'patient_flag_status_value' => 1])->pluck('patient_id');
              $success_array['patient_ids'] = $patient_flags;

              if($patient_flags) {
                  $common_camis_controller->GetVirtualWardPatientInformation($process_array, $success_array);

              }
          }
          else{
            $success_array['url'] = 'false';
          }

            $dp_task = DpTasks::pluck('auto_populate_task_name')->toArray();
            $board_round_user_task_aki_assesment_task = BoardRoundUserTaskAkiAssessmentTasks::pluck('auto_populate_task_name')->toArray();
            $board_round_user_task_nof_task = BoardRoundUserTaskNofTasks::pluck('auto_populate_task_name')->toArray();
            $board_round_user_task_sepsis_task = BoardRoundUserTaskSepsisTasks::pluck('auto_populate_task_name')->toArray();

      }

    public function WardFilter(Request $request)
    {
        $process_array                                                  = array();
        $success_array                                                  = array();
        $ward = $request->virtual_ward_name;
        $ward_id = $request->ward_id;
        $success_array["ward"]                                          = ($ward != '') ? strtolower($ward) : '';
        $success_array["ward_id"]                                       = $ward_id;

        $this->PageDataLoad($process_array, $success_array);


        $view = View::make('Dashboards.Camis.VirtualWard.IndexDataLoad', compact('success_array'));
        $sections = $view->render();

        return $sections;

    }


}
