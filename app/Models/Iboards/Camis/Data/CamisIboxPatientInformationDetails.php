<?php

namespace App\Models\Iboards\Camis\Data;

use App\Models\Iboards\Camis\Master\Wards;
use Illuminate\Database\Eloquent\Model;
use DB;

class CamisIboxPatientInformationDetails extends Model
{
    protected $guarded      = [];
    protected $connection   = 'mysql_camis_data';
    protected $table        = 'ibox_in_patient_information_details';


    public function GetTableNameWithConnection()
    {
        $connectionName = $this->getConnectionName();
        $tableName = $this->getTable();
        return $connectionName . '.' . $tableName;
    }

    public function BoardRoundPotentialDefinite($status = null)
    {
        $query = $this->hasOne(CamisIboxBoardRoundPotentialDefinite::class, 'camis_patient_id', 'patient_id');

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        return $query;
    }
    public function DischargeAssignedData()
    {
        return $this->hasOne(CamisIboxDischargeAssigned::class,'camis_patient_id','camis_patient_id');
    }
    public function OtherNotes()
    {
        return $this->hasOne(CamisIboxBoardRoundDischargeComment::class,'patient_id','camis_patient_id');
    }
    public function PatientPosition()
    {
        return $this->hasOne(CamisIboxSdecPosition::class,'camis_patient_id','camis_patient_id');
    }
    public function BoardRoundCDTComment()
    {
        return $this->hasMany(CamisIboxBoardRoundCDTComment::class,'patient_id','camis_patient_id');
    }
    public function BoardRoundCdt(){
        return $this->hasOne(CamisIboxBoardRoundCDT::class,'patient_id','camis_patient_id');
    }
    public function DischargeData()
    {
        return $this->hasOne(CamisIboxDischargeAssigned::class, 'camis_patient_id', 'camis_patient_id');
    }

    public function BoardRoundPatientGoal()
    {
        return $this->hasOne(CamisIboxBoardRoundPatientGoal::class, 'patient_id', 'camis_patient_id');
    }
    public function PatientTasks()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientTasks::class,'patient_id', 'camis_patient_id');
    }

    public function PatientIncompleteTasks()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientTasks::class,'patient_id','camis_patient_id');
    }



    public function MedicalFitStatus()
    {
        return $this->hasOne(CamisIboxBoardRoundMedFit::class, 'patient_id');

    }



    public function AdmittingReason()
    {
        return $this->hasOne(CamisIboxBoardRoundAdmittingReason::class, 'camis_patient_id', 'patient_id');

    }

    public function AllowedToMove()
    {
        return $this->hasOne(CamisIboxBoardRoundAllowedToMove::class, 'camis_patient_id', 'patient_id');

    }


    public function DischargePlanningEdn()
    {
        return $this->hasOne(CamisIboxBoardRoundEdn::class, 'camis_patient_id', 'patient_id');

    }

    public function EstimatedDischargeDate()
    {
        return $this->hasOne(CamisIboxBoardRoundEstimatedDischargeDate::class, 'camis_patient_id', 'patient_id');

    }

    public function PatientFlag()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientFlag::class,  'patient_id');

    }

    public function PatientFlagAdditionalInfo()
    {
        return $this->hasOne(CamisIboxBoardRoundPatientFlagAdditionalInfo::class, 'camis_patient_id', 'patient_id');

    }

    public function PatientTask()
    {
        return $this->hasOne(CamisIboxBoardRoundPatientTasks::class, 'camis_patient_id', 'patient_id');

    }

    public function PharmacyComment()
    {
        return $this->hasOne(CamisIboxBoardRoundPharmacyComment::class, 'camis_patient_id', 'patient_id');

    }

    public function PharmacyData()
    {
        return $this->hasOne(CamisIboxBoardRoundPharmacyData::class, 'camis_patient_id', 'patient_id');

    }

    public function ReasonToReside()
    {
        return $this->hasOne(CamisIboxBoardRoundReasonToReside::class, 'camis_patient_id', 'patient_id');

    }

    public function RedGreenBed()
    {
        return $this->hasOne(CamisIboxBoardRoundRedGreenBed::class, 'camis_patient_id', 'patient_id');

    }

    public function SocialHistory()
    {
        return $this->hasOne(CamisIboxBoardRoundSocialHistory::class, 'camis_patient_id', 'patient_id');

    }

    public function RoundTto()
    {
        return $this->hasOne(CamisIboxBoardRoundTto::class, 'camis_patient_id', 'patient_id');

    }

    public function WorkingDiagonosis()
    {
        return $this->hasOne(CamisIboxBoardRoundWorkingDiagnosis::class, 'camis_patient_id', 'patient_id');

    }
    public function BoardRoundWorkingDiagnosis(){
        return $this->hasOne(CamisIboxBoardRoundWorkingDiagnosis::class,'patient_id','camis_patient_id');
    }

    public function BoardRoundMedicallyFitData()
    {
        return $this->hasOne(CamisIboxBoardRoundMedFit::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundTherapyFitData()
    {
        return $this->hasOne(CamisIboxBoardRoundTherapyFit::class, 'patient_id', 'camis_patient_id');
    }
    public function BoardRoundDtocComments()
    {
        return $this->hasMany(CamisIboxBoardRoundDtocComment::class, 'patient_id', 'camis_patient_id');
    }
    public function PotentialDefinite()
    {
        return $this->hasOne(CamisIboxBoardRoundPotentialDefinite::class,'patient_id','camis_patient_id');
    }

    public function PatientWiseFlags()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientFlag::class,'patient_id','camis_patient_id');
    }

    public function BoardRoundPharmacyData()
    {
        return $this->hasOne(CamisIboxBoardRoundPharmacyData::class, 'patient_id', 'camis_patient_id');
    }

    public function PatientHandOver()
    {
        return $this->hasOne(CamisIboxPatientHandOver::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundPharmacyComment()
    {
        return $this->hasMany(CamisIboxBoardRoundPharmacyComment::class,'patient_id','camis_patient_id');
    }

    public function PatientWard()
    {
        return $this->belongsTo(Wards::class,'camis_patient_ward_id');
    }

    public function BoardRoundPatientTasks()
    {
        return $this->hasMany(CamisIboxBoardRoundPatientTasks::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundCareRequirement()
    {
        return $this->hasOne(CamisIboxBoardRoundCareRequirement::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundPathwayRequirement()
    {
        return $this->hasOne(CamisIboxBoardRoundPathwayRequirement::class, 'patient_id', 'camis_patient_id');
    }

    public function BoardRoundAdmittingReason()
    {
        return $this->hasOne(CamisIboxBoardRoundAdmittingReason::class, 'patient_id', 'camis_patient_id');
    }
    public function BoardRoundSocialHistory()
    {
        return $this->hasOne(CamisIboxBoardRoundSocialHistory::class, 'patient_id', 'camis_patient_id');
    }


    public static function ReturnTableName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names").".ibox_in_patient_information_details";
    }

    public static function ReturnDatabaseName()
    {
        return RetriveSpecificConstantSettingValues("mysql_camis_data","ibox_constant_database_names");
    }

    public function GetPatientDischargeHistoryByPassId($pas_id)
    {
        $results = DB::connection('mysql_camis_data')->select('CALL sp_dtoc_patient_discharge_history(?)', [$pas_id]);

        return $results;
    }

}
