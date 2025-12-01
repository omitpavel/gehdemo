<?php

namespace App\Models\Common;

use App\Models\History\HistoryCamisIboxBoardRoundPharmacyComment;
use App\Models\Iboards\Camis\Master\Wards;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundDischargeLoungeHandover;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundDtocComment;
use App\Models\Iboards\Camis\Data\CamisIboxDoctorAtNightComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundAdmittingReason;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundSocialHistory;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPharmacyData;
use App\Models\Iboards\Camis\Data\CamisIboxDPVirtualWardPatientStatus;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMedFit;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundEstimatedDischargeDate;
use App\Models\Iboards\Camis\Data\CamisIboxPatientHandOver;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientTasks;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundAllowedToMove;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundRedGreenBed;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPotentialDefinite;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundReasonToReside;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundTto;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundEdn;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundWorkingDiagnosis;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundCareRequirement;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPathwayRequirement;
use App\Models\Iboards\Camis\Data\CamisIboxSurgicalWardsComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundMedFitDatesHistory;
use App\Models\Iboards\Camis\Data\CamisIboxDischargeAssigned;
use App\Models\Iboards\Camis\Data\CamisIboxDischargePatientDataStored;
use App\Models\Iboards\Camis\Data\CamisIboxDPVirtualWardComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPharmacyComment;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundBedStatus;
use App\Models\Iboards\Camis\View\CamisIboxPatientInfoVitalpacView;
use App\Models\Iboards\Camis\View\PatientListWardBeforeDischargeLounge;
use App\Models\Iboards\Camis\View\CamisIboxInfectedPatients;
use App\Models\History\HistoryCamisIboxBoardRoundPatientFlag;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPastMedicalHistory;
use App\Models\Iboards\Camis\Data\CamisIboxBoardRoundPatientGoal;
use Illuminate\Support\Facades\DB;

class InPatientDetailHistory extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_in_patient_information_details_history';


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".ibox_in_patient_information_details_history";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
    }

    public function GetTableNameWithConnection()
    {
        $connectionName = $this->ReturnDatabaseName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }


    public function HistoryCamisIboxBoardRoundPatientFlag()
    {
        return $this->hasMany(CamisIboxInfectedPatients::class, 'camis_patient_id', 'camis_patient_id');
    }


    public function PatientWiseFlags()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientFlag::class,'patient_id','camis_patient_id');
    }

    public function DischargeLoungeData()
    {
        return $this->hasOne(CamisIboxDischargePatientDataStored::class,'patient_id','camis_patient_id');
    }

    public function PatientListBeforeDischargeLounge()
    {
        return $this->hasMany(PatientListWardBeforeDischargeLounge::class,'ipe_epinumber','camis_patient_id');
    }

    public function BoardRoundAdmittingReason()
    {
        return $this->hasOne(CamisIboxBoardRoundAdmittingReason::class, 'patient_id', 'camis_patient_id');
    }
    public function BoardRoundPastMedicalHistory()
    {
        return $this->hasOne(CamisIboxBoardRoundPastMedicalHistory::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundPatientGoal()
    {
        return $this->hasOne(CamisIboxBoardRoundPatientGoal::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundSocialHistory()
    {
        return $this->hasOne(CamisIboxBoardRoundSocialHistory::class, 'patient_id', 'camis_patient_id');
    }

    public function IboxBedStatus()
    {
        return $this->hasOne(CamisIboxBoardRoundBedStatus::class, 'ibox_bed_id', 'ibox_ward_bed_id');
    }

    public function BoardRoundPharmacyData()
    {
        return $this->hasOne(CamisIboxBoardRoundPharmacyData::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundPharmacyComment()
    {
        return $this->hasMany(CamisIboxBoardRoundPharmacyComment::class,'patient_id','camis_patient_id');
    }

    public function BoardRoundPharmacyCommentHistory()
    {
        return $this->hasMany(HistoryCamisIboxBoardRoundPharmacyComment::class,'patient_id','camis_patient_id');
    }


    public function Ward()
    {
        return $this->belongsTo(Wards::class, 'ibox_ward_id', 'id');
    }

    public function BoardRoundMedicallyFitData()
    {
        return $this->hasOne(CamisIboxBoardRoundMedFit::class, 'patient_id', 'camis_patient_id');
    }


    public function BoardRoundEstimatedDischargeDate()
    {
        return $this->hasOne(CamisIboxBoardRoundEstimatedDischargeDate::class, 'patient_id', 'camis_patient_id');
    }

    public function PatientHandOver()
    {
        return $this->hasOne(CamisIboxPatientHandOver::class, 'patient_id', 'camis_patient_id');
    }


    public function PatientDischargeLoungeHandOver()
    {
        return $this->hasOne(CamisIboxBoardRoundDischargeLoungeHandover::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundPatientTasks()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientTasks::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundDtocComments()
    {
        return $this->hasMany(CamisIboxBoardRoundDtocComment::class, 'patient_id', 'camis_patient_id');
    }

    public function AllowedToMove()
    {
        return $this->hasOne(CamisIboxBoardRoundAllowedToMove::class,'patient_id','camis_patient_id');
    }

    public function RedGreenBed()
    {
        return $this->hasOne(CamisIboxBoardRoundRedGreenBed::class,'patient_id','camis_patient_id');
    }

    public function PotentialDefinite()
    {
        return $this->hasOne(CamisIboxBoardRoundPotentialDefinite::class,'patient_id','camis_patient_id');
    }

    public function BoardRoundReasonToReside(){
        return $this->hasOne(CamisIboxBoardRoundReasonToReside::class,'patient_id','camis_patient_id')->latest('created_at')->whereNull('reason_to_reside_end_date');;
    }

    public function BoardRoundEdn(){
        return $this->hasOne(CamisIboxBoardRoundEdn::class,'patient_id','camis_patient_id');
    }

    public function BoardRoundTto(){
        return $this->hasOne(CamisIboxBoardRoundTto::class,'patient_id','camis_patient_id');
    }

    public function BoardRoundWorkingDiagnosis(){
        return $this->hasOne(CamisIboxBoardRoundWorkingDiagnosis::class,'patient_id','camis_patient_id');
    }



    public function SurgicalWardComment(){
        return $this->hasMany(CamisIboxSurgicalWardsComment::class,'patient_id','camis_patient_id');
    }
    public function DoctorAtNightComment(){
        return $this->hasMany(CamisIboxDoctorAtNightComment::class,'patient_id','camis_patient_id');
    }

    public function getCovidStatusAttribute()
    {
        return HistoryCamisIboxBoardRoundPatientFlag::where('camis_patient_id', $this->camis_patient_id)
            ->where('patient_flag_name', 'ibox_patient_flag_infection_risk')
            ->whereJsonContains('patient_flag_extra_details->patient_flag_infection_risk_reason_id', 30)
            ->exists() ? 1 : 0;
    }

    public function BoardRoundCareRequirement()
    {
        return $this->hasOne(CamisIboxBoardRoundCareRequirement::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundPathwayRequirement()
    {
        return $this->hasOne(CamisIboxBoardRoundPathwayRequirement::class, 'patient_id', 'camis_patient_id');
    }

    public function MedfitHistory()
    {
        return $this->hasMany(CamisIboxBoardRoundMedFitDatesHistory::class, 'id', 'camis_patient_id');
    }

    public function DischargeData()
    {
        return $this->hasOne(CamisIboxDischargeAssigned::class, 'camis_patient_id', 'camis_patient_id');
    }


    public function GetWardHistory()
    {
        $results = DB::connection('mysql_camis_data')->select('CALL sp_aande_patient_ward_history(?)', [$this->camis_patient_id]);

        return $results;
    }

    public function DPVirtualWardStatus(){
        return $this->hasOne(CamisIboxDPVirtualWardPatientStatus::class, 'patient_id', 'camis_patient_id');
    }

    public function DPVirtualWardComment(){
        return $this->hasMany(CamisIboxDPVirtualWardComment::class, 'patient_id', 'camis_patient_id');
    }


    public function PatientVitalPacInfo()
    {
        return $this->belongsTo(CamisIboxPatientInfoVitalpacView::class, 'camis_patient_id','camis_patient_id')
            ->select(['camis_patient_id','totalews', 'patient_weight_details','herat_rate_val','temperature_val','respiratory_rate_val','bp_systolic_val','oxygen_val','avpu_val','sats_val','time_started_obs','patient_weight_details','sepsis_alert','must_Score', 'alert_value', 'time_of_reading']);
    }

    public function MedFitDates()
    {
        $results = DB::connection('mysql_camis_data')->select('CALL sp_aande_medfit_dates(?)', [$this->camis_patient_id]);

        return $results;
    }

    public function MedFitHistoryData()
    {
        $results = DB::connection('mysql_camis_data')->select('CALL sp_aande_medfit_history(?)', [$this->camis_patient_id]);

        return $results;
    }



}
