<?php


namespace App\Http\Controllers\Common;


use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Master\BedRedReason;
use App\Models\Iboards\Camis\View\CamisIboxWardPatientInformationWithBedDetailsView;
use Carbon\Carbon;


class CommonReportController
{


    public function GetTotalOccupideBed($ward_name){
        $total_occupide_beds = CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_name', $ward_name)
                            ->where('ibox_bed_status_camis','open')
                            ->whereNotNull('camis_patient_id')
                            ->where('disabled_on_all_dashboard_except_ward_summary', 0)
                            ->count();
        return $total_occupide_beds;
    }

    public function GetPatientIds($ward_name)
    {
        return CamisIboxWardPatientInformationWithBedDetailsView::where('ibox_ward_name', $ward_name)->where('disabled_on_all_dashboard_except_ward_summary', 0)->pluck('camis_patient_id');
    }


    public function GetLeafletOneStatus($patient_data) {
        $leaflet_one = CamisIboxBoardRoundPatientFlag::whereIn('patient_id', $patient_data)
            ->where('patient_flag_name', 'ibox_patient_flag_leaflet_one')
            ->where('patient_flag_status_value', 1)->count();

        return $leaflet_one;
    }

    public function GetLeafletTwoStatus($patient_data) {
        $leaflet_two = CamisIboxBoardRoundPatientFlag::whereIn('patient_id', $patient_data)
            ->where('patient_flag_name', 'ibox_patient_flag_leaflet_two')
            ->where('patient_flag_status_value', 1)->count();

        return $leaflet_two;
    }

    public function CalculateClickedLess48Hours($patient_data){
        $less_48_hrs = CamisIboxBoardRoundPatientFlag::where('patient_flag_name', 'ibox_patient_flag_leaflet_one')->where('created_at', '<', Carbon::now()->subHours(48))->count();
        return $less_48_hrs;
    }

    public function CalculateClickedGreater48Hours($patient_data){
        $greater_48_hrs = CamisIboxBoardRoundPatientFlag::where('patient_flag_name', 'ibox_patient_flag_leaflet_one')->where('created_at', '>=', Carbon::now()->subHours(48))->count();
        return $greater_48_hrs;
    }

   



    public static function RedBedDashboardExport($patientList)
    {
        $date =  Carbon::now();
        $red_bed_reason_list                                 = BedRedReason::where('status', 1)->pluck('red_text_value', 'id')->toArray();

        return $patientList->map(function ($patient, $index) use($red_bed_reason_list){
            $red_bed_dashboard = '';
            if (isset($patient['RedGreenBed']) && $patient['RedGreenBed']['patient_red_green_status'] == 1){

                $reason_list = json_decode($patient['RedGreenBed']['patient_red_green_status_reason_code'], true);
                uasort($reason_list, function ($a, $b) {
                    if (!isset($a['created_time'])) return -1;
                    if (!isset($b['created_time'])) return 1;

                    $timeA = strtotime($a['created_time']);
                    $timeB = strtotime($b['created_time']);

                    return $timeA <=> $timeB;
                });
                $pending_task = ArrayFilter($reason_list, function($value) {
                    return ((!isset($value['is_complete']) && $value == 0) || (isset($value['is_complete']) && $value['is_complete'] == 0));
                });
                $pending_task_text = '';
                foreach($pending_task as $key => $task){
                    $pending_task_text .= $red_bed_reason_list[$key].', ';
                }

                $red_bed_dashboard = $pending_task_text;
                return [
                    'sn' => $index + 1,
                    'id' => $patient['camis_patient_id'],
                    'ward' => $patient['ibox_ward_name'],
                    'bay_and_bed' => $patient['ibox_actual_bed_full_name'],
                    'name' => $patient['camis_patient_name'],
                    'pas_id' => $patient['camis_patient_pas_number'],
                    'consultant' => $patient['camis_consultant_name'],
                    'medfit' => isset($patient['board_round_medically_fit_data']['patient_medically_fit_status']) && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'Yes' : 'No',
                    'los' => NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date'], date('Y-m-d')),
                    'edd' => isset($patient['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) ? PredefinedDateFormatShowOnCalendarWithoutDay($patient['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) : '',
                    'red_bed' => $red_bed_dashboard
                ];
            }
        });

    }


}
