<?php

namespace App\Http\Controllers\Iboards\Common;

use App\Models\Iboards\Camis\Data\CamisIboxPatientInformationDetails;
use Sentinel;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use App\Models\Iboards\Camis\View\IboxFullPatientSearch;
use App\Models\Common\InPatientDetailHistory;
use App\Models\Iboards\Camis\Master\Wards;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use View;


class PatientSearchController extends Controller
{


    public function Index()
    {

        return view('Common.View.PatientSearch.Index');
    }

    public function IndexDataLoad(Request $request){

        $patient_info       = IboxFullPatientSearch::when($request->filled('search_term'), function ($query) use ($request) {
                                return $query->where(function ($q) use ($request) {
                                    $q->where('pas_number', 'like', '%' . $request->search_term . '%')
                                        ->orWhere('patient_name', 'like', '%' . $request->search_term . '%')
                                        ->orWhere('surname', 'like', '%' . $request->search_term . '%')
                                        ->orWhere('forename', 'like', '%' . $request->search_term . '%')
                                        ->orWhere('patient_id', 'like', '%' . $request->search_term . '%');
                                });
                            })->unless($request->filled('search_term'), function ($q)
                            {
                                return $q->where('pas_number', '');
                            })->limit(250)->get()->toArray();

        $all_wards                              = Wards::where('status', '=', 1)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('ward_short_name')->toArray();
        $patient_info = array_filter($patient_info, function($item) use ($all_wards) {
            if ($item['data_source'] == 1 && isset($item['ward']) && !empty($item['ward'])) {
                return in_array($item['ward'], $all_wards);
            }
            return true;
        });

        $pas_number_wise_patient = array_reduce($patient_info, function ($carry, $item) {
            $ward_name = $item['pas_number'];

            $carry[$ward_name][] = $item;

            return $carry;
        }, []);
        ksort($pas_number_wise_patient);
        return view('Common.View.PatientSearch.IndexDataLoad', compact('pas_number_wise_patient'));
    }

    public function Modal($id)
    {

        $patient_array      = InPatientDetailHistory::with([
            'BoardRoundPatientTasks' =>function($q){
                $q->where('task_completed_status',1)->get();
            },
            'BoardRoundCareRequirement' =>function($q){
                $q->with('PathwayGroup');
            },
            'BoardRoundPathwayRequirement' =>function($q){
                $q->with('DtocPathway','DtocAuthority','DtocStatus');
            },
            'BoardRoundAdmittingReason','BoardRoundSocialHistory','BoardRoundPatientGoal','BoardRoundPastMedicalHistory',
            'PatientWiseFlags',
            'BoardRoundPharmacyData','PatientHandOver','BoardRoundMedicallyFitData',
            'BoardRoundDtocComments',

            'PotentialDefinite',

        ])->where('camis_patient_id', $id)
            ->first();

        return view('Common.View.CommonDischargeSummaryData', compact('patient_array'));
    }

    public function ModalPrint($id)
    {
        $patient_array      = InPatientDetailHistory::with([
            'BoardRoundPatientTasks' =>function($q){
                $q->where('task_completed_status',1)->get();
            },
            'BoardRoundCareRequirement' =>function($q){
                $q->with('PathwayGroup');
            },
            'BoardRoundPathwayRequirement' =>function($q){
                $q->with('DtocPathway','DtocAuthority','DtocStatus');
            },
            'BoardRoundAdmittingReason','BoardRoundSocialHistory','BoardRoundWorkingDiagnosis',
            'PatientWiseFlags',
            'BoardRoundPharmacyData','PatientHandOver','BoardRoundMedicallyFitData',
            'BoardRoundDtocComments',

            'PotentialDefinite'
        ])->where('camis_patient_id', $id)
        ->first();

        return view('Common.View.CommonDischargeSummaryPrint', compact('patient_array'));
    }


}
