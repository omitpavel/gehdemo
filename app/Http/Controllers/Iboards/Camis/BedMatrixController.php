<?php

namespace App\Http\Controllers\Iboards\Camis;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Governance\GovernanceController;
use App\Http\Controllers\Common\HistoryController;
use App\Models\Iboards\Camis\Master\Wards;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPotentialDefinite;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Camis\View\CamisIboxPatientBedReservation;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundBedStatus;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundBayStatus;
use App\Models\Iboards\Camis\Master\BoardRoundFlagList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class BedMatrixController extends Controller
{

    public function Index()
    {
        if(CheckSpecificPermission('camis_list_view_view')){
            return view('Dashboards.Camis.BedMatrix.Index');
        } else {
            Toastr::error('Permission Denied');
            return back();
        }

    }


    public function IndexRefreshDataLoad(Request $request){
        $wards_to_excludes = Wards::where('ward_bed_matrix_status', 0)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();

        $other_ward = Wards::where('ward_type_primary', 16)->pluck('ward_short_name')->toArray();
        $wards_to_exclude = array_merge($wards_to_excludes, $other_ward);
        $all_inpatient = CamisIboxWardPatientInformationWithBedDetailsView::whereNotNull('camis_patient_id')->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('camis_patient_id')->toArray();

        $definite_potential = CamisIboxBoardRoundPotentialDefinite::whereDate('potential_definite_date', date('Y-m-d'))
        ->whereIn('patient_id', $all_inpatient)->get()
        ->toArray();



        $success_array = array();
        $wards_ids = Wards::whereIn('ward_type_primary', [13, 14, 16])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->pluck('id')->toArray();
        $patient_list                       = CamisIboxWardPatientInformationWithBedDetailsView::with('IboxBedStatus')->whereIn('ibox_ward_id', $wards_ids)->whereIn('ibox_ward_id', $wards_ids)->where('ibox_bed_type', '=', 'Bed')->where('disabled_on_all_dashboard_except_ward_summary', 0)->get()->toArray();

        $success_array['total_occupied']['total'] = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            return !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));


        $success_array['total_occupied']['available'] = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){


            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if(strtolower($item['ibox_bed_status_camis']) != 'open'){
                return false;
            }

            return empty($item['camis_patient_id']) && $item['ibox_bed_status_camis'] == 'open' && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));

        $success_array['total_occupied']['occupied'] = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            return !empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));

        $success_array['total_occupied']['restrict'] = count(ArrayFilter($patient_list, function($item)  use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if (
                (!in_array($item['ibox_ward_short_name'], $wards_to_exclude) && empty($item['camis_patient_id']) && isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 2)
            ) {
                return true;
            }
        }));



        $success_array['male_empty']['total']                           = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return (empty($item['bay_gender_value']) || strtolower($item['bay_gender_value']) == strtolower('Male')) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));

        $success_array['male_empty']['available']                       = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if(empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if(strtolower($item['ibox_bed_status_camis']) != 'open'){
                return false;
            }
            return ((empty($item['bay_gender_value']) || strtolower($item['bay_gender_value']) == strtolower('Male')) && empty($item['camis_patient_id']) && strtolower($item['ibox_bed_status_camis']) == 'open' && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));

        $success_array['male_empty']['occupied']                       = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return ((empty($item['bay_gender_value']) || strtolower($item['bay_gender_value']) == strtolower('Male')) && !empty($item['camis_patient_id'])) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));


        $success_array['male_empty']['restrict']                       = count(ArrayFilter($patient_list, function($item)  use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            if (
                (!in_array($item['ibox_ward_short_name'], $wards_to_exclude) && empty($item['camis_patient_id']) && (empty($item['bay_gender_value']) || strtolower($item['bay_gender_value']) == strtolower('Male')) && empty($item['camis_patient_id']) && isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 2)
            ) {
                return true;
            }
        }));



        $success_array['escalation']['total']                           = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return $item['ibox_bed_escalation_status'] == 1 && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));

        $success_array['escalation']['available']                       = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            if(strtolower($item['ibox_bed_status_camis']) != 'open'){
                return false;
            }
            return ($item['ibox_bed_escalation_status'] == 1 && empty($item['camis_patient_id']) && strtolower($item['ibox_bed_status_camis']) == 'open' && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));

        $success_array['escalation']['occupied']                       = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return ($item['ibox_bed_escalation_status'] == 1 && !empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));


        $success_array['escalation']['restrict']                       = count(ArrayFilter($patient_list, function($item)  use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if (
                (!in_array($item['ibox_ward_short_name'], $wards_to_exclude) && empty($item['camis_patient_id']) && $item['ibox_bed_escalation_status'] == 1 && empty($item['camis_patient_id']) && isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 2)
            ) {
                return true;
            }
        }));






        $success_array['female_empty']['total']                         = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return strtolower($item['bay_gender_value']) == strtolower('Female') && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));
        $success_array['female_empty']['available']                     = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            if(strtolower($item['ibox_bed_status_camis']) != 'open'){
                return false;
            }
            return (strtolower($item['bay_gender_value']) == strtolower('Female') && empty($item['camis_patient_id']) && strtolower($item['ibox_bed_status_camis']) == 'open' && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));

        $success_array['female_empty']['occupied']                     = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return (strtolower($item['bay_gender_value']) == strtolower('Female') && !empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));
        $success_array['female_empty']['restrict']                       = count(ArrayFilter($patient_list, function($item)  use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            if (
                (!in_array($item['ibox_ward_short_name'], $wards_to_exclude) && empty($item['camis_patient_id']) && strtolower($item['bay_gender_value']) == strtolower('Female') && empty($item['camis_patient_id']) && isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 2)
            ) {
                return true;
            }
        }));

        $success_array['sr_empty']['total']                             = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return strtolower($item['bay_gender_value']) == strtolower('Side Room') && !in_array($item['ibox_ward_short_name'], $wards_to_exclude);
        }));
        $success_array['sr_empty']['available']                         = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){

            if(empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            if(strtolower($item['ibox_bed_status_camis']) != 'open'){
                return false;
            }
            return (strtolower($item['bay_gender_value']) == strtolower('Side Room') && empty($item['camis_patient_id'])  && strtolower($item['ibox_bed_status_camis']) == 'open' && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));

        $success_array['sr_empty']['occupied']                         = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }
            return (strtolower($item['bay_gender_value']) == strtolower('Side Room') && !empty($item['camis_patient_id']) && !in_array($item['ibox_ward_short_name'], $wards_to_exclude));
        }));

        $success_array['sr_empty']['restrict']                       = count(ArrayFilter($patient_list, function($item) use($wards_to_exclude){
            if(empty($item['camis_patient_id'])  && !in_array($item['ibox_ward_short_name'], $wards_to_exclude) && (isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 1)){
                return false;
            }

            if (
                (!in_array($item['ibox_ward_short_name'], $wards_to_exclude) && empty($item['camis_patient_id']) && strtolower($item['bay_gender_value']) == strtolower('Side Room') && empty($item['camis_patient_id']) && isset($item['ibox_bed_status']['status']) && $item['ibox_bed_status']['status'] == 2)
            ) {
                return true;
            }
        }));

        $success_array['total_poteintial'] = count(ArrayFilter($definite_potential, function($item) {
            return ($item['type'] == 1);
        }));

        $success_array['total_definite'] = count(ArrayFilter($definite_potential, function($item) {
            return ($item['type'] == 2);
        }));

        $wards = Wards::whereIn('ward_type_primary', [13, 16, 14])->where('disabled_on_all_dashboard_except_ward_summary', 0)->where('status', 1)->orderBy('ward_name', 'asc')->get();
        $ward_data = array();
        foreach($wards as $ward){
            $ward_data[$ward->ward_short_name]['ward_short_name'] = $ward->ward_short_name;
            $ward_data[$ward->ward_short_name]['ward_name'] = $ward->ward_name;
            $ward_data[$ward->ward_short_name]['total_bed'] = 0;
            $ward_data[$ward->ward_short_name]['extension_number'] = $ward->extension_number;
            $ward_data[$ward->ward_short_name]['ward_url_name'] = $ward->ward_url_name;

            if ($ward->ward_infection_close_status == 1)
            {
                $ward_data[$ward->ward_short_name]['infection'] = 1;
            } else {
                $ward_data[$ward->ward_short_name]['infection'] = 0;
            }


            $ward_data[$ward->ward_short_name]['restrict_bed'] = 0;
            $ward_data[$ward->ward_short_name]['occupied_bed'] = 0;
            $ward_data[$ward->ward_short_name]['male_bed'] = 0;
            $ward_data[$ward->ward_short_name]['female_bed'] = 0;
            $ward_data[$ward->ward_short_name]['sr_bed'] = 0;
            $ward_data[$ward->ward_short_name]['escalation_bed'] = 0;
            if($ward->ward_type_primary == 13){
                $ward_data[$ward->ward_short_name]['ward_type'] = 'medical';
            } elseif($ward->ward_type_primary == 14){
                $ward_data[$ward->ward_short_name]['ward_type'] = 'surgical';
            } elseif($ward->ward_type_primary == 16){
                $ward_data[$ward->ward_short_name]['ward_type'] = 'others';
            }
        }

        foreach($patient_list as $patient){
            $ward_name = $patient['ibox_ward_short_name'];

            if(!isset($ward_data[$ward_name])){
                continue;
            }
            if(isset($patient['ward']['status']) && isset($patient['ward']['status']) != 1){
                continue;
            }

            if(empty($patient['camis_patient_id'])  && !in_array($patient['ibox_ward_short_name'], $wards_to_exclude) && (isset($patient['ibox_bed_status']['status']) && $patient['ibox_bed_status']['status'] == 1)){
                continue;
            }
            $ward_data[$ward_name]['total_bed']++;

            if(!empty($patient['camis_patient_id'])){
                $ward_data[$ward_name]['occupied_bed']++;
            }





                if (
                    (empty($patient['camis_patient_id']) && isset($patient['ibox_bed_status']['status']) && $patient['ibox_bed_status']['status'] == 2)
                ) {
                    $ward_data[$ward_name]['restrict_bed']++;
                }
                if(empty($patient['camis_patient_id']) && $patient['ibox_bed_status_camis'] == 'open' && (strtolower($patient['bay_gender_value']) == strtolower('Male') || empty($patient['bay_gender_value']))){
                    $ward_data[$ward_name]['male_bed']++;
                }

                if(empty($patient['camis_patient_id']) && $patient['ibox_bed_status_camis'] == 'open' && strtolower($patient['bay_gender_value']) == strtolower('Female')){
                    $ward_data[$ward_name]['female_bed']++;
                }

                if(empty($patient['camis_patient_id']) && $patient['ibox_bed_status_camis'] == 'open' && strtolower($patient['bay_gender_value']) == strtolower('Side Room')){
                    $ward_data[$ward_name]['sr_bed']++;
                }

                if(empty($patient['camis_patient_id']) && $patient['ibox_bed_status_camis'] == 'open' && $patient['ibox_bed_escalation_status'] == 1){
                    $ward_data[$ward_name]['escalation_bed']++;
                }

        }


        $success_array['medical_wards'] = ArrayFilter($ward_data, function($item) {
            return ($item['ward_type'] == 'medical');
        });

        $success_array['surgical_wards'] = ArrayFilter($ward_data, function($item) {
            return ($item['ward_type'] == 'surgical');
        });

        $success_array['others_wards'] = ArrayFilter($ward_data, function($item) {
            return ($item['ward_type'] == 'others');
        });

        $view                                                           = View::make('Dashboards.Camis.BedMatrix.IndexDataLoad', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }



    public function ModalDataLoad(Request $request)
    {
        $ward                                                           = $request->ward_id;
        $process_array                                                  = array();
        $success_array                                                  = array();
        $ward_id                                          = ($ward != '') ? strtolower($ward) : '';

        $patient_array              = CamisIboxWardPatientInformationWithBedDetailsView::with([
            'PatientWiseFlags' => function ($q)
            {
                $q->where('patient_flag_status_value', 1);
            },
            'BoardRoundMedicallyFitData' => function ($q)
            {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment');
            },
            'BoardRoundEstimatedDischargeDate' => function ($q)
            {
                $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
            },
            'IboxBedStatus',
            'BoardRoundPatientTasks',
            'BoardRoundPatientTasks.PatientTaskGroup',
            'AllowedToMove',
            'RedGreenBed',
            'RedGreenBed.RedGreenReason',
            'PotentialDefinite','PatientVitalPacInfo', 'BoardRoundPathwayRequirement', 'ReverseBarrier', 'InfectionRisks'
        ])->where('ibox_ward_short_name', '=', strtoupper($ward_id))->where('ibox_bed_type', '=', 'Bed')->get()->toArray();
        $all_bay_status = CamisIboxBoardRoundBayStatus::where('ward_id', $ward_id)->get()->toArray();
        $ward_patient_surname_array = array();
        $ward_patient_list_array        = array();
        if (count($patient_array) > 0)
        {
            foreach ($patient_array as $key => $val)
            {
                if ($val['camis_patient_surname'] != '')
                {
                    $ward_patient_surname_array[] =  trim($val['camis_patient_surname']);
                }
            }
        }
        $ward_patient_surname_count_values             = array_count_values($ward_patient_surname_array);
        $patient_count = 0;
        foreach($patient_array as $row){
            $patient_count++;
            $bay                         = ($row['ibox_bed_group_number'] != 0) ? $row['ibox_bed_group_name'] . ' ' . $row['ibox_bed_group_number'] : $row['ibox_bed_group_name'];



            if(isset($row['reverse_barrier']['reverse_barrier_status']) && $row['reverse_barrier']['reverse_barrier_status'] == 1){
                $row['reverse_barrier_status'] = 1;

            } else {
                $row['reverse_barrier_status'] = 0;
            }

            $row['patient_bed_bay']                         = ($row['ibox_bed_group_number'] != 0) ? $row['ibox_bed_group_name'] . ' ' . $row['ibox_bed_group_number'] : $row['ibox_bed_group_name'];
            $row['ibox_patient_admit_date_los_value']       = NumberOfDaysBetweenTwoDates($row['camis_patient_admission_date'], date('Y-m-d'));
            $row['ibox_patient_admit_date_los_value_ward']  = NumberOfDaysBetweenTwoDates($row['camis_patient_ward_start_date'], date('Y-m-d'));
            $row['camis_consultant_name']                   = ucwords(strtolower(trim($row['camis_consultant_name'])));
            $row['camis_patient_post_code']                 = trim($row['camis_patient_post_code']);
            $row['camis_consultant_code_description']       = ucwords(strtolower(trim($row['camis_consultant_code_description'])));
            $row['camis_consultant_code_description']       = (strlen($row['camis_consultant_code_description']) < 5) ? strtoupper($row['camis_consultant_code_description']) : $row['camis_consultant_code_description'];
            $row['flags']                                   = $row['patient_wise_flags'];
            $row['ibox_patient_hide_name']                           = 'Patient ' . WardBedShowPatientCharacter($patient_count);

            $bay_status = null;
            foreach ($all_bay_status as $status_row) {
                if ($status_row['ibox_bed_group_id'] == $row['ibox_bed_group_id'] &&
                    $status_row['ibox_bed_group_number'] == $row['ibox_bed_group_number']) {
                    $bay_status = $status_row['status'];
                    break;
                }
            }

            $row['bay_status'] = $bay_status;
            if (!empty($row['camis_patient_surname']))
            {
                $row['ibox_patient_surname_count']                   = $ward_patient_surname_count_values[trim($row['camis_patient_surname'])];
            }
            $ward_patient_list_array[$bay][] = $row;

        }
        $success_array['ward_patient_list_array'] = $ward_patient_list_array;


        $view                                                           = View::make('Dashboards.Camis.BedMatrix.Partials.ModalContent', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }

    public function BedStatusDataLoad(Request $request){
        $success_array = array();
        $success_array['ward_bed_id'] = $request->ward_bed_id;
        $success_array['ward_id'] = $request->ward_id;
        $success_array['bed_status'] = 4;
        $success_array['reserved_for'] = '';
        $success_array['patient_name'] = '';
        $bed_info = CamisIboxBoardRoundBedStatus::where('ward_id', $request->ward_id)->where('ibox_bed_id', $request->ward_bed_id)->first();
        if($bed_info != null){
            $success_array['bed_status'] = $bed_info->status;
            $success_array['reserved_for'] = $bed_info->reserved_for;
            $success_array['patient_name'] = $bed_info->patient_name;
        }
        $success_array['patient_list']                                  = CamisIboxPatientBedReservation::where('data_source', 1)->get()->toArray();
        $view                                                           = View::make('Dashboards.Camis.BedMatrix.Partials.BedStatusData', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }


    public function BayStatusDataLoad(Request $request){

        if($request->ward_id != '' && $request->bed_group_id != '' && $request->bed_group_number != ''){
            return CamisIboxBoardRoundBayStatus::where('ward_id', $request->ward_id)->where('ibox_bed_group_id', $request->bed_group_id)->where('ibox_bed_group_number', $request->bed_group_number)->first()->status ?? 0;
        }
        return 0;
    }

    public function CamisGetAllPatientID(Request $request){
        $patients = CamisIboxPatientBedReservation::where(function($query) use ($request){
            $query->where('pas_number', 'LIKE', '%'.$request->name.'%');
            $query->orWhere('attendance_id', 'LIKE', '%'.$request->name.'%');
            $query->orWhere('patient_id', 'LIKE', '%'.$request->name.'%');
            $query->orWhere('surname', 'LIKE', '%'.$request->name.'%');
            $query->orWhere('forname', 'LIKE', '%'.$request->name.'%');
            $query->orWhere('patient_name', 'LIKE', '%'.$request->name.'%');
        })->get()->toArray();
        $success_array['patient_list']                                  = $patients;
        $view                                                           = View::make('Dashboards.Camis.BedMatrix.Partials.PatientSearch', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }


    public function BayStatusSave(Request $request){
        $history_controller = new HistoryController;
        $history_modal = "App\Models\History\HistoryCamisIboxBoardRoundBayStatus";
        $date_time_now = CurrentDateOnFormat();
        $user_id = Session()->get('LOGGED_USER_ID', '');

        $success_array["message"] = ErrorOccuredMessage();
        $success_array["status"] = 0;
        $success_array["updated_date"] = date('jS M Y, H:i', strtotime($date_time_now));
        $patient_name = '';
        $success_array["patient_found"]                             = 1;

        if ($user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundBayStatus::where('ward_id', '=', $request->ward_id)->where('ibox_bed_group_id', '=', $request->ibox_bed_group_id)->where('ibox_bed_group_number', '=', $request->ibox_bed_group_number)->first();
            $updated_data                                           = CamisIboxBoardRoundBayStatus::updateOrCreate(['ward_id' => $request->ward_id, 'ibox_bed_group_id' => $request->ibox_bed_group_id, 'ibox_bed_group_number' => $request->ibox_bed_group_number], ['status' => $request->status, 'updated_by' => $user_id]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
            $functional_identity                                    = 'Bay Status Update';

            if ($updated_data->wasRecentlyCreated)
            {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"]))
                {
                    $gov_text_after_arr                             = CamisIboxBoardRoundBayStatus::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceIboxDataPreCall($gov_text_after_arr, 'Bay Status Update', $gov_text_before, 1);
                }
            }
            else
            {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0)
                {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"]))
                    {
                        if ($gov_text_before_arr)
                        {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundBayStatus::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceIboxDataPreCall($gov_text_after_arr, 'Bay Status Update', $gov_text_before, 2);
                        }
                    }
                }
            }

            $success_array["status"]                                    = 1;
        }

        if($request->status == 0){
            $success_array["text"]                                    = '';
            $success_array["button_text"]                             = 'BAY OPEN';
        } elseif($request->status == 2){
            $success_array["text"]                                    = 'bay-restricted';
            $success_array["button_text"]                             = 'BAY RESTRICTED';
        } elseif($request->status == 1){
            $success_array["text"]                                    = 'bay-closed';
            $success_array["button_text"]                             = 'BAY CLOSED';
        }
        return $success_array;
    }




    public function BedStatusSave(Request $request){
        $history_controller = new HistoryController;
        $history_modal = "App\Models\History\HistoryCamisIboxBoardRoundBedStatus";
        $date_time_now = CurrentDateOnFormat();
        $user_id = Session()->get('LOGGED_USER_ID', '');

        $success_array["message"] = ErrorOccuredMessage();
        $success_array["status"] = 0;
        $success_array["updated_date"] = date('jS M Y, H:i', strtotime($date_time_now));
        $patient_name = '';
        $success_array["patient_found"]                             = 1;
        $from_ward_id = null;
        $from_ward_name = '';
        $to_ward_name = '';
        if($request->bed_status == 4 && !empty($request->patient_id)){

            $patient_info = CamisIboxPatientBedReservation::with('WardPatient')->where('pas_number', $request->patient_id)->first();
            if($patient_info != null){

                $from_ward_id = $patient_info->WardPatient->ibox_ward_id ?? null;
                $from_ward_name = $patient_info->WardPatient->ibox_ward_short_name ?? 'A&E';
                $to_ward_name = Wards::where('id', $request->ward_id)->first()->ward_short_name ?? '';
                $patient_name = $patient_info->patient_name;
            } else {
                $success_array["message"]                           = DataAddedMessage();
                $success_array["status"]                                    = 1;
                $success_array["patient_found"]                             = 0;
                return $success_array;
            }
        }
        if ($user_id != "") {
            $gov_text_before_arr                                    = CamisIboxBoardRoundBedStatus::where('ibox_bed_id', '=', $request->ward_bed_id)->first();
            $updated_data                                           = CamisIboxBoardRoundBedStatus::updateOrCreate(['ibox_bed_id' => $request->ward_bed_id, 'ward_id' => $request->ward_id], ['status' => $request->bed_status, 'reserved_for' => $request->patient_id, 'move_from_ward_id' => $from_ward_id, 'move_to_ward_name' => $to_ward_name, 'move_from_ward_name' => $from_ward_name, 'patient_name' => $patient_name, 'updated_by' => $user_id]);
            $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal);
            $functional_identity                                    = 'Bed Status Update';

            if ($updated_data->wasRecentlyCreated)
            {
                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 1);
                $success_array["message"]                           = DataAddedMessage();
                $updated_array                                      = $updated_data->getOriginal();
                $gov_text_before                                    = array();
                if (count($updated_array) > 0 && isset($updated_array["id"]))
                {
                    $gov_text_after_arr                             = CamisIboxBoardRoundBedStatus::where('id', '=', $updated_array["id"])->first();
                    $this->GovernanceIboxDataPreCall($gov_text_after_arr, 'Bed Status Update', $gov_text_before, 1);
                }
            }
            else
            {

                $history_controller->HistoryTableDataInsertFromUpdateCreate($updated_data, $history_modal, 2);
                $success_array["message"]                           = DataUpdatedMessage();
                if (count($updated_data->getChanges()) > 0)
                {
                    $updated_array                                  = $updated_data->getOriginal();
                    if (count($updated_array) > 0 && isset($updated_array["id"]))
                    {
                        if ($gov_text_before_arr)
                        {
                            $gov_text_before                        = $gov_text_before_arr->toArray();
                            $gov_text_after_arr                     = CamisIboxBoardRoundBedStatus::where('id', '=', $updated_array["id"])->first();
                            $this->GovernanceIboxDataPreCall($gov_text_after_arr, 'Bed Status Update', $gov_text_before, 2);
                        }
                    }
                }
            }
            if($request->bed_status == 0){
                $success_array["text"] = 'Bed Open: Empty';
            } elseif($request->bed_status == 1){
                $success_array["text"] = 'Bed Closed';
            } elseif($request->bed_status == 2){
                $success_array["text"] = 'Bed Restricted';
            } elseif($request->bed_status == 3){
                $success_array["text"] = 'Bed Out Of Service';
            } elseif($request->bed_status == 4){
                $success_array["text"] = ' Bed Reserved For '.$request->patient_id.'<br>('.$patient_name.')';
            }
            $success_array["status"]                                    = 1;
        }


        return $success_array;
    }

    public function GovernanceIboxDataPreCall($gov_text_after_arr, $functional_identity, $gov_text_before, $operation)
    {
        $gov_data               = array();
        $gov_text_after         = array();

        if ($operation == 1)
        {
            if (isset($id) && $id != '')
            {

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
                $gov_data["gov_description"]        = 'Bed Status Update';
            }
        }
        if ($operation == 2)
        {
            if (isset($id) && $id != '')
            {


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
                $gov_data["gov_description"]        = 'Bed Status Update';
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

    public function PDModal(Request $request)
    {
        $patient_ids = CamisIboxBoardRoundPotentialDefinite::when($request->filled('type'), function ($q) use ($request)
        {
            return $q->where('type', $request->type);
        })->whereDate('potential_definite_date', Carbon::today())->pluck('patient_id')->toArray();

        $success_array['patient_pd_list'] = CamisIboxWardPatientInformationWithBedDetailsView::whereIn('camis_patient_id', $patient_ids)->with([
            'PatientWiseFlags' => function ($q)
            {
                $q->where('patient_flag_status_value', 1);
            },
            'BoardRoundAdmittingReason' => function ($q)
            {
                $q->select('id', 'patient_id', 'patient_admitting_reason');
            },
            'BoardRoundSocialHistory' => function ($q)
            {
                $q->select('id', 'patient_id', 'patient_social_history');
            },
            'BoardRoundPharmacyData' => function ($q)
            {
                $q->select('id', 'patient_id', 'pharmacy_drug_history', 'pharmacy_antibiotic_iv_status', 'pharmacy_antibiotic_oral_status', 'pharmacy_latest_comment', 'updated_at');
            },
            'BoardRoundMedicallyFitData' => function ($q)
            {
                $q->select('id', 'patient_id', 'patient_medically_fit_status', 'patient_medically_fit_status_comment');
            },
            'BoardRoundEstimatedDischargeDate' => function ($q)
            {
                $q->select('id', 'patient_id', 'patient_estimated_discharge_date', 'patient_estimated_discharge_date_comment');
            },
            'PatientHandOver',
            'BoardRoundPatientTasks' => function ($q)
            {
                $q->where('task_completed_status', 0)->where('task_not_applicable_status', 0)->orderBy('id', 'asc');
            },
            'BoardRoundPatientTasks',
            'BoardRoundPatientTasks.PatientTaskGroup',
            'BoardRoundPatientTasks.PatientTaskCategory',
            'AllowedToMove',
            'RedGreenBed',
            'RedGreenBed.RedGreenReason',
            'PotentialDefinite',
            'PatientVitalPacInfo',
        ])->get()->toArray();
        $success_array['show_on_ward_summary_status_check']             = BoardRoundFlagList::where('show_on_normal_ward', 1)->pluck('patient_flag_name', 'patient_flag_stored_name')->toArray();
        $view                                                           = View::make('Dashboards.Camis.BedMatrix.Partials.PDData', compact('success_array'));
        $sections                                                       = $view->render();
        return $sections;
    }


}
