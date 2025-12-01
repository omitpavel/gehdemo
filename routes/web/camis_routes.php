<?php

use Illuminate\Support\Facades\Route;

Route::get('/ward/dashboard', 'Iboards\Common\DashboardHomeController@WardDashboard')->name('ward.dashboard');
Route::get('/virtual/wards', 'Iboards\Common\DashboardHomeController@VirtualWard')->name('virtual.ward');
Route::get('/sites/dashboard', 'Iboards\Common\DashboardHomeController@site')->name('site.dashboard');
Route::get('/report/dashboard', 'Iboards\Common\DashboardHomeController@ReportDashboard')->name('report.dashboard');
Route::group(['prefix' => 'inpatients', 'middleware' => 'userauthentication'], function ()
{
    Route::prefix('dashboards')->group(function ()
    {
        Route::get('/', 'Iboards\Common\DashboardHomeController@WardDashboard')->name('ward.dashboard');
        Route::post('/patient-details-summary', 'Common\CommonCamisController@GetPatientDetailsInformationSummary')->name('GetPatientDetailsInformationSummary');
        Route::post('/patient-board-round-summary', 'Common\CommonCamisController@GetBoardRoundSummery')->name('GetBoardRoundSummery');


        Route::get('/pd-discharges', 'Iboards\Camis\PdDischargesController@Index')->name('site.pd_discharge');
        Route::get('/pd-discharges-content', 'Iboards\Camis\PdDischargesController@IndexRefreshDataLoad')->name('pd.content');
        Route::get('/pd-discharges-content-missed', 'Iboards\Camis\PdDischargesController@MissedDischargedPatients')->name('pd.missed');
        Route::get('/pd-discharges-missed-export', 'Iboards\Camis\PdDischargesController@MissedExport')->name('pd.missed.export');
        Route::get('/pd-discharges-performance', 'Iboards\Camis\PdDischargesController@MissedDischargedPerformance')->name('pd.missed.performance');
        Route::post('/pd-discharges-missed-ajax-data', 'Iboards\Camis\PdDischargesController@ReasonHistoryAjaxData')->name('pd.missed.ajax');

        Route::post('/pd-discharges-save-missed-reason', 'Iboards\Camis\PdDischargesController@SaveMissedReason')->name('pd.save.missed.reason');


        Route::get('/stranded-patients', 'Iboards\Camis\StrandedPatientsController@Index')->name('site.stranded_patients');
        Route::get('/stranded-patients-content', 'Iboards\Camis\StrandedPatientsController@IndexRefreshDataLoad')->name('site.stranded_patients.content');
        Route::get('/stranded-patients-export', 'Iboards\Camis\StrandedPatientsController@export')->name('site.stranded_patients.export');


        Route::prefix('ward-summary')->group(function ()
        {
            Route::post('/fetch-patient-priority-task-boadround', 'Iboards\Camis\WardSummaryController@FetchPatientPriorityTask')->name('FetchPatientPriorityTask');
            //Sdec Ward
            Route::get('/sdec', 'Iboards\Camis\WardSummaryController@SDECWard')->name('ward.sdec');
            Route::get('/sdec-data-load', 'Iboards\Camis\WardSummaryController@SDECWardDataLoad')->name('ward.sdec.dataload');
            Route::get('/sdec-board-round/{patient_id}', 'Iboards\Camis\WardSummaryController@SdecBoardRound')->name('ward.sdec.boardround');
            Route::get('/sdec-board-round-data/{patient_id}', 'Iboards\Camis\WardSummaryController@SdecBoardRoundData')->name('ward.sdec.boardround.data');
            Route::get('/fetch-sdec-movement-history', 'Iboards\Camis\WardSummaryController@FetchSDECMovementHistory')->name('ward.sdec.movement.history');
            Route::post('/update-sdec-postion', 'Iboards\Camis\WardSummaryController@UpdateSDECPostion')->name('update.sdec.position');

            Route::get('/discharge-lounge', 'Iboards\Camis\WardSummaryController@DischargeLoungeWard')->name('ward.discharge.lounge');
            Route::get('/discharge-lounge-data-load', 'Iboards\Camis\WardSummaryController@DischargeLoungeWardDataLoad')->name('ward.discharge.lounge.dataload');
            Route::get('/discharge-lounge-board-round/{patient_id}', 'Iboards\Camis\WardSummaryController@DischargeLoungeBoardRound')->name('ward.discharge.lounge.boardround');
            Route::get('/discharge-lounge-board-round-data/{patient_id}', 'Iboards\Camis\WardSummaryController@DischargeLoungeBoardRoundData')->name('ward.discharge.lounge.boardround.data');
            Route::get('/fetch-discharge-lounge-movement-history', 'Iboards\Camis\WardSummaryController@FetchDischargeLoungeMovementHistory')->name('ward.discharge.lounge.movement.history');
            Route::post('/update-discharge-lounge-postion', 'Iboards\Camis\WardSummaryController@UpdateDischargeLoungePostion')->name('update.discharge.lounge.position');



            Route::get('/frailty', 'Iboards\Camis\WardSummaryController@FrailtyWard')->name('ward.frailty');
            Route::get('/frailty-data-load', 'Iboards\Camis\WardSummaryController@FrailtyWardDataLoad')->name('ward.frailty.dataload');
            Route::get('/frailty-board-round/{patient_id}', 'Iboards\Camis\WardSummaryController@FrailtyBoardRound')->name('ward.frailty.boardround');
            Route::get('/frailty-board-round-data/{patient_id}', 'Iboards\Camis\WardSummaryController@FrailtyBoardRoundData')->name('ward.frailty.boardround.data');
            Route::get('/fetch-frailty-movement-history', 'Iboards\Camis\WardSummaryController@FetchFrailtyMovementHistory')->name('ward.frailty.movement.history');
            Route::post('/update-frailty-postion', 'Iboards\Camis\WardSummaryController@UpdateFrailtyPostion')->name('update.frailty.position');


            Route::post('/fetch-reason-to-reside-patients', 'Iboards\Camis\WardSummaryController@FetchPatientReasonToReside')->name('FetchPatientReasonToReside');




            Route::post('/update-cdt-status', 'Iboards\Camis\WardSummaryController@UpdateCDTStatus')->name('UpdateCDTStatus');
            Route::post('/keep-cache-ward-round-config', 'Iboards\Camis\WardSummaryController@KeepCacheBoardRoundConfig')->name('KeepCacheBoardRoundConfig');
            Route::post('/get-ward-round-config', 'Iboards\Camis\WardSummaryController@BoardRoundConfig')->name('BoardRoundConfig');
            Route::post('/get-ward-round-user', 'Iboards\Camis\WardSummaryController@GetWardRoundUser')->name('GetWardRoundUser');
            Route::post('/save-ward-round-user', 'Iboards\Camis\WardSummaryController@SaveWardRoundUser')->name('SaveWardRoundUser');
            Route::get('/ward-performance/{ward}', 'Iboards\Camis\WardPerformanceController@Index')->name('ward.ward-performance');

            Route::get('/ward-performance-ward-type', 'Iboards\Camis\WardPerformanceController@WardType')->name('wardtype.ward-performance');
            Route::get('/ward-performance-wardtype/refresh/{ward_type}', 'Iboards\Camis\WardPerformanceController@WardTypeDataLoad')->name('wardtype.ward-performance.load');
            Route::get('/ward-boardround-report-by-date', 'Iboards\Camis\WardPerformanceController@WardBoardRoundReport')->name('wardtype.ward-boardround');


            Route::get('/ward-performance-data-load/refresh', 'Iboards\Camis\WardPerformanceController@IndexRefreshDataLoad')->name('ward.ward-performance.refresh');
            Route::get('/boardround/{ward?}/patient_id/{patient_id}', 'Iboards\Camis\WardSummaryController@Boardround')->name('ward.boardround');
            Route::get('/data-refresh/{ward}', 'Iboards\Camis\WardSummaryController@IndexRefreshDataLoad');
            Route::post('/get-doctor-tasks', 'Iboards\Camis\WardSummaryController@GetDoctorTasks')->name('GetDoctorTasks');
            Route::post('/ward-status-data', 'Iboards\Camis\WardSummaryController@GetWardStatusData')->name('ward_summery.status_data');
            Route::post('/ward-start-board-round', 'Iboards\Camis\WardSummaryController@CamisStartBoardRound')->name('CamisStartBoardRound');
            Route::post('/ward-resume-board-round', 'Iboards\Camis\WardSummaryController@CamisResumeBoardRound')->name('CamisResumeBoardRound');
            Route::post('/ward-alloting-bed-nurse', 'Iboards\Camis\WardSummaryController@AllotingBedNurse')->name('AllotingBedNurse');
            Route::post('/fetch-pd-patients', 'Iboards\Camis\WardSummaryController@FetchPDPatients')->name('FetchPDPatients');
            Route::post('/fetch-allowed-to-move-in-patients', 'Iboards\Camis\WardSummaryController@FetchAllowedToMoveIn')->name('FetchAllowedToMoveIn');
            Route::post('/fetch-allowed-to-move-out-patients', 'Iboards\Camis\WardSummaryController@FetchAllowedToMoveOut')->name('FetchAllowedToMoveOut');
            Route::post('/content-ane-patients-data', 'Iboards\Camis\WardSummaryController@GetAnePatientData')->name('Ward.GetAnePatientData');
            Route::post('/content-sau-patients', 'Iboards\Camis\WardSummaryController@GetAnePatient')->name('Ward.GetSauPatient');
            Route::get('/{ward}', 'Iboards\Camis\WardSummaryController@Index')->name('ward.ward-details');


            Route::prefix('board-round')->group(function ()
            {
                Route::get('DtocWardAllCommentList/{id}', 'Iboards\Camis\WardSummaryController@DtocWardAllCommentList')->name('BoardRoundDtocWardAllComment');

                Route::post('/discharge-lounge-handover', 'Iboards\Camis\WardSummaryController@GetDischargeLoungeHandover')->name('GetDischargeLoungeHandover');
                Route::post('/save-discharge-lounge-handover', 'Iboards\Camis\WardSummaryController@SaveDischargeLoungeHandover')->name('SaveDischargeLoungeHandover');

                Route::post('/fetch-patient-outstanding-task', 'Iboards\Camis\WardSummaryController@GetPatientOutstandingTasks')->name('GetPatientOutstandingTasks');
                Route::post('/fetch-next-of-kin', 'Iboards\Camis\WardSummaryController@GetNextOfKin')->name('GetNextOfKin');
                Route::post('/patient-info', 'Iboards\Camis\WardSummaryController@BoardRoundPatientInfo');
                Route::post('/checked-locked-status', 'Iboards\Camis\WardSummaryController@CheckedLockedStatus')->name('CheckedLockedStatus');
                Route::post('/save-unlocked-status', 'Iboards\Camis\WardSummaryController@SaveUnlockedStatus')->name('board_round_save_unlocked_status');
                Route::post('/fetch-admitting-reason', 'Iboards\Camis\WardSummaryController@GetPatientAdmittingReason')->name('GetPatientAdmittingReason');
                Route::post('/update-admitting-reason', 'Iboards\Camis\WardSummaryController@UpdatePatientAdmittingReason')->name('UpdatePatientAdmittingReason');
                Route::post('/fetch-patient-cdt-comment', 'Iboards\Camis\WardSummaryController@GetPatientCDTDetails')->name('GetPatientCDTDetails');
                Route::post('/fetch-patient-goal', 'Iboards\Camis\WardSummaryController@GetPatientGoal')->name('GetPatientGoal');
                Route::post('/update-patient-goal', 'Iboards\Camis\WardSummaryController@UpdatePatientGoal')->name('UpdatePatientGoal');

                Route::post('/fetch-past-medical-history', 'Iboards\Camis\WardSummaryController@GetPatientPastMedicalHistory')->name('GetPatientPastMedicalHistory');
                Route::post('/update-past-medical-history', 'Iboards\Camis\WardSummaryController@UpdatePatientPastMedicalHistory')->name('UpdatePatientPastMedicalHistory');

                Route::post('/fetch-social-history', 'Iboards\Camis\WardSummaryController@GetPatientSocialHistory')->name('GetPatientSocialHistory');
                Route::post('/update-social-history', 'Iboards\Camis\WardSummaryController@UpdatePatientSocialHistory')->name('UpdatePatientSocialHistory');

                Route::post('/fetch-working-diagnosis', 'Iboards\Camis\WardSummaryController@GetPatientWorkingDiagnosis')->name('GetPatientWorkingDiagnosis');
                Route::post('/update-working-diagnosis', 'Iboards\Camis\WardSummaryController@UpdatePatientWorkingDiagnosis')->name('UpdatePatientWorkingDiagnosis');

                Route::post('/fetch-estimated-discharge-date', 'Iboards\Camis\WardSummaryController@GetEstimatedDischargeDate')->name('GetEstimatedDischargeDate');
                Route::post('/update-estimated-discharge-date', 'Iboards\Camis\WardSummaryController@UpdateEstimatedDischargeDate')->name('UpdateEstimatedDischargeDate');

                Route::post('/fetch-reason-to-reside', 'Iboards\Camis\WardSummaryController@GetReasonToReside')->name('GetReasonToReside');
                Route::post('/update-reason-to-reside', 'Iboards\Camis\WardSummaryController@UpdateReasonToReside')->name('UpdateReasonToReside');

                Route::post('/fetch-medfit-for-discharge', 'Iboards\Camis\WardSummaryController@GetMedFitForDischarge')->name('GetMedFitForDischarge');
                Route::post('/update-medfit-for-discharge-yes', 'Iboards\Camis\WardSummaryController@UpdateMedFitForDischargeYes')->name('UpdateMedFitForDischargeYes');

                Route::post('/fetch-patient-acuity', 'Iboards\Camis\WardSummaryController@GetPatientAcuity');
                Route::post('/update-patient-acuity', 'Iboards\Camis\WardSummaryController@UpdatePatientAcuity')->name('UpdatePatientAcuity');
                Route::post('/remove-patient-acuity', 'Iboards\Camis\WardSummaryController@RemovePatientAcuity');

                Route::post('/update-therapy-fit-status', 'Iboards\Camis\WardSummaryController@UpdateTherapyFitStatus')->name('UpdateTherapyFitStatus');

                Route::post('/fetch-red-green-bed-status', 'Iboards\Camis\WardSummaryController@GetRedGreenBedStatus')->name('GetRedGreenBedStatus');
                Route::post('/update-red-green-bed-status', 'Iboards\Camis\WardSummaryController@UpdateRedGreenBedStatus')->name('UpdateRedGreenBedStatus');
                Route::post('/update-red-green-bed-status-reason', 'Iboards\Camis\WardSummaryController@UpdateRedGreenBedStatusReason')->name('UpdateRedGreenBedStatusReason');
                Route::post('/remove-red-green-bed-status', 'Iboards\Camis\WardSummaryController@RemoveRedGreenBedStatus')->name('RemoveRedGreenBedStatus');


                Route::post('/fetch-potential-definite-bed-status', 'Iboards\Camis\WardSummaryController@GetPotentialDefiniteBedStatus');
                Route::post('/update-potential-definite-bed-status', 'Iboards\Camis\WardSummaryController@UpdatePotentialDefiniteBedStatus')->name('UpdatePotentialDefiniteBedStatus');
                Route::post('/remove-potential-definite-bed-status', 'Iboards\Camis\WardSummaryController@RemovePotentialDefiniteBedStatus')->name('RemovePotentialDefiniteBedStatus');

                Route::post('/fetch-edn-bed-status', 'Iboards\Camis\WardSummaryController@GetEDNBedStatus');
                Route::post('/update-edn-bed-status', 'Iboards\Camis\WardSummaryController@UpdateEDNBedStatus')->name('UpdateEDNBedStatus');
                Route::post('/remove-edn-bed-status', 'Iboards\Camis\WardSummaryController@RemoveEDNBedStatus');

                Route::post('/fetch-tto-bed-status', 'Iboards\Camis\WardSummaryController@GetTTOBedStatus')->name('GetTTOBedStatus');
                Route::post('/update-tto-bed-status', 'Iboards\Camis\WardSummaryController@UpdateTTOBedStatus')->name('UpdateTTOBedStatus');
                Route::post('/remove-tto-bed-status', 'Iboards\Camis\WardSummaryController@RemoveTTOBedStatus');

                Route::post('/fetch-pharmacy-status', 'Iboards\Camis\WardSummaryController@GetPharmacyStatus')->name('GetPharmacyStatus');
                Route::post('/update-pharmacy-status', 'Iboards\Camis\WardSummaryController@UpdatePharmacyStatus')->name('UpdatePharmacyStatus');
                Route::post('/update-antibiotic-iv', 'Iboards\Camis\WardSummaryController@UpdateAntibioticIV')->name('UpdateAntibioticIV');
                Route::post('/update-antibiotic-oral', 'Iboards\Camis\WardSummaryController@UpdateAntibioticOral')->name('UpdateAntibioticOral');

                Route::post('/fetch-doctor-at-night', 'Iboards\Camis\WardSummaryController@GetDoctorAtNight')->name('GetDoctorAtNight');
                Route::post('/update-doctor-at-night', 'Iboards\Camis\WardSummaryController@UpdateDoctorAtNight')->name('UpdateDoctorAtNight');

                Route::post('/fetch-allowed-to-be-moved', 'Iboards\Camis\WardSummaryController@GetAllowedToBeMoved')->name('GetAllowedToBeMoved');
                Route::post('/update-allowed-to-be-moved', 'Iboards\Camis\WardSummaryController@UpdateAllowedToBeMoved')->name('UpdateAllowedToBeMoved');
                Route::post('/remove-allowed-to-be-moved', 'Iboards\Camis\WardSummaryController@RemoveAllowedToBeMoved')->name('RemoveAllowedToBeMoved');



                Route::post('/fetch-patient-wise-ward-history', 'Iboards\Camis\WardSummaryController@GetPatientWardMovementHistory')->name('GetPatientWardMovementHistory');


                Route::post('/fetch-patient-task-boadround', 'Iboards\Camis\WardSummaryController@GetBoardRoundPatientTask')->name('GetBoardRoundPatientTask');
                Route::post('/fetch-patient-task-boadround-details', 'Iboards\Camis\WardSummaryController@GetBoardRoundPatientTaskDetails')->name('GetBoardRoundPatientTaskDetails');
                Route::post('/check-patient-task-boadround', 'Iboards\Camis\WardSummaryController@CheckBoardRoundPatientTask')->name('CheckBoardRoundPatientTask');
                Route::post('/update-patient-task-boadround', 'Iboards\Camis\WardSummaryController@UpdatePatientTaskBoardRound')->name('UpdatePatientTaskBoardRound');
                Route::post('/complete-patient-task-boadround', 'Iboards\Camis\WardSummaryController@CompletePatientTaskBoardRound')->name('CompletePatientTaskBoardRound');
                Route::post('/complete-task-with-category', 'Iboards\Camis\WardSummaryController@CompletePatientTaskWithCategoryBoardRound')->name('CompletePatientTaskWithCategoryBoardRound');
                Route::post('/not-applicable-patient-task-boadround', 'Iboards\Camis\WardSummaryController@NotApplicablePatientTaskBoardRound')->name('NotApplicablePatientTaskBoardRound');
                Route::post('/assign-aki-task', 'Iboards\Camis\WardSummaryController@AssignAkiTask')->name('AssignAkiTask');
                Route::post('/assign-sepsis-task', 'Iboards\Camis\WardSummaryController@AssignSepsisTask')->name('AssignSepsisTask');
                Route::post('/fetch-outstanding-task', 'Iboards\Camis\WardSummaryController@GetOutstandingTask');
                Route::post('/fetch-patient-ic-flag-details', 'Iboards\Camis\WardSummaryController@GetPatientICFlagDetails')->name('GetPatientICFlagDetails');
                Route::post('/fetch-patient-flag-details', 'Iboards\Camis\WardSummaryController@GetPatientFlagDetails')->name('GetPatientFlagDetails');
                Route::post('/update-patient-flag-details', 'Iboards\Camis\WardSummaryController@UpdatePatientFlagDetails')->name('UpdatePatientFlagDetails');
                Route::post('/remove-patient-flag-details', 'Iboards\Camis\WardSummaryController@RemovePatientFlagDetails')->name('RemovePatientFlagDetails');
                Route::post('/fetch-deteriorating_patient_timeline', 'Iboards\Camis\WardSummaryController@GetDeterioratingPatientTimeline')->name('GetDeterioratingPatientTimeline');

                Route::post('/fetch-inpatients-board-round-history', 'Iboards\Camis\WardSummaryController@FetchBoardRoundHistory')->name('FetchBoardRoundHistory');
                Route::post('/fetch-ane-discharge-summary', 'Iboards\Camis\WardSummaryController@FetchAneDischargeSummary')->name('FetchAneDischargeSummary');
                Route::post('/save-dtoc-pathway', 'Iboards\Camis\WardSummaryController@SaveDtocPathway')->name('SaveDtocPathway');
                Route::post('/fetch-aki-vitalpac', 'Iboards\Camis\WardSummaryController@GetVitalPacAKIData')->name('GetVitalPacAKIData');
                Route::post('/fetch-inpatients-board-round-pathway-history', 'Iboards\Camis\WardSummaryController@FetchBoardRoundPathwayHistory')->name('FetchBoardRoundPathwayHistory');
                Route::post('/update-patient-level', 'Iboards\Camis\WardSummaryController@UpdatePatientLevel')->name('UpdatePatientLevel');
            });
        });


        Route::prefix('hand-over')->group(function ()
        {
            Route::get('/get-hand-over-details', 'Iboards\Camis\WardSummaryController@GetHandOverDetails')->name('handover.details');
            Route::any('/hand-over-details-Modal', 'Iboards\Camis\WardSummaryController@HandOverDetailsModal')->name('HandOverDetailsModal');
            Route::post('/save-hand-over-details', 'Iboards\Camis\WardSummaryController@SaveHandOverDetails')->name('handover.save');
            Route::get('print-hand-over-details', 'Iboards\Camis\WardSummaryController@PrintHandOverDetails')->name('handover.print');
            Route::get('Print-HandOver-PopUp-Content', 'Iboards\Camis\WardSummaryController@PrintHandOverPopUpContent')->name('PrintHandOverPopUpContent');
            Route::get('HandOver-PopUp-Content-Filter', 'Iboards\Camis\WardSummaryController@ConsultantByBay')->name('ConsultantByBay');
        });



        Route::prefix('reason-to-reside')->group(function ()
        {
            Route::get('/summary', 'Iboards\Camis\ReasonToResideController@GetIndex')->name('reason_reside.dashboard');
            Route::get('/content', 'Iboards\Camis\ReasonToResideController@IndexRefreshDataLoad')->name('reason_to_reside.content');
        });

        Route::prefix('pharmacy-dashboard')->group(function ()
        {
            Route::get('/', 'Iboards\Camis\PharmacyDashboardController@Index')->name('pharmacy.dashboard');
            Route::get('/content', 'Iboards\Camis\PharmacyDashboardController@IndexRefreshDataLoad')->name('pharmacy.content');
            Route::get('/all-comment', 'Iboards\Camis\PharmacyDashboardController@AllComment')->name('pharmacy.AllComment');
            Route::get('/all-screened-history', 'Iboards\Camis\PharmacyDashboardController@AllScreenedHistory')->name('pharmacy.AllScreenedHistory');
            Route::get('/pharmacy-history', 'Iboards\Camis\PharmacyDashboardController@PharmacyHistory')->name('pharmacy.PharmacyHistory');
            Route::get('/pharmacy-task-by-group', 'Iboards\Camis\PharmacyDashboardController@TaskByGroup')->name('pharmacy.TaskByGroup');
        });

        Route::prefix('discharged-patients')->group(function ()
        {
            Route::get('/summary', 'Iboards\Camis\DischargesPatientController@GetIndex')->name('discharges_patient.dashboard');
            Route::get('/content', 'Iboards\Camis\DischargesPatientController@IndexRefreshDataLoad')->name('discharges_patient.content');
            Route::get('/export', 'Iboards\Camis\DischargesPatientController@Export')->name('site.discharges_patient.export');
            Route::get('/modal/{id}', 'Iboards\Camis\DischargesPatientController@Modal')->name('site.discharges_patient.modal');
            Route::get('/modal-print/{id}', 'Iboards\Camis\DischargesPatientController@ModalPrint')->name('site.discharges_patient.modal-print');
            Route::post('/get-comment-history', 'Iboards\Camis\DischargesPatientController@GetCommentHistory')->name('site.discharges_patient.getcomments');
            Route::post('/save-comment-history', 'Iboards\Camis\DischargesPatientController@SaveCommentHistory')->name('site.discharges_patient.savecomments');
        });

        Route::prefix('board-round')->group(function ()
        {
            Route::get('/summery', 'Iboards\Camis\BoardRoundReportController@Index')->name('board_round.dashboard');
            Route::get('/content', 'Iboards\Camis\BoardRoundReportController@IndexRefreshDataLoad')->name('board_round.content');
            Route::post('/fetch-partial-patient-list', 'Iboards\Camis\BoardRoundReportController@FetchPatialPatientList')->name('FetchPatialPatientList');
        });


    });



    Route::group(['prefix' => 'discharge-tracker', 'middleware' => 'userauthentication', 'as' => 'discharged.'], function ()
    {
        Route::get('/', 'Iboards\Camis\DischargeTrackerController@Index')->name('index');
        Route::post('complex-discharge-data-load', 'Iboards\Camis\DischargeTrackerController@DischargeTrackerDataLoad')->name('complex.data.load');
        Route::post('complex-discharge-data-print', 'Iboards\Camis\DischargeTrackerController@DischargeTrackerPrint')->name('complex.data.print');
        Route::post('complex-discharge-from-cdt-data-load', 'Iboards\Camis\DischargeTrackerController@DischargeFromCDTDataLoad')->name('discharges.from.cdt');
        Route::post('fetch-patient-dtoc-info-global', 'Iboards\Camis\DischargeTrackerController@FetchGlobalDtocInfo')->name('fetch.dtoc.info.global');
        Route::post('fetch-patient-dtoc-info-referral', 'Iboards\Camis\DischargeTrackerController@FetchReferralDtocInfo')->name('fetch.dtoc.info.referral');
        Route::post('fetch-patient-dtoc-info', 'Iboards\Camis\DischargeTrackerController@FetchDtocInfo')->name('fetch.dtoc.info');
        Route::post('fetch-patient-dtoc-current-service', 'Iboards\Camis\DischargeTrackerController@FetchDtocCurrentService')->name('fetch.current.service');
        Route::post('save-patient-dtoc-info', 'Iboards\Camis\DischargeTrackerController@SaveDtocInfo')->name('save.dtoc.info');
        Route::post('fetch-patient-dtoc-comment', 'Iboards\Camis\DischargeTrackerController@FetchDtocComment')->name('fetch.dtoc.comment');
        Route::post('save-tu-as-default', 'Iboards\Camis\DischargeTrackerController@SaveTUAsDefault')->name('save.tu.default');
        Route::post('comment-history', 'Iboards\Camis\DischargeTrackerController@CommentHistory')->name('comment.history');
        Route::get('export', 'Iboards\Camis\DischargeTrackerController@Export')->name('export');
        Route::get('DtocWardAllCommentList/{id}', 'Iboards\Camis\DischargeTrackerController@DtocWardAllCommentList')->name('DtocWardAllCommentList');
        Route::post('fetch-patient-cdt-comment', 'Iboards\Camis\DischargeTrackerController@FetchCDTComment')->name('fetch.cdt.comment');
        Route::post('save-patient-cdt-comment', 'Iboards\Camis\DischargeTrackerController@SaveCDTComment')->name('save.cdt.comment');



        Route::get('removed-patients', 'Iboards\Camis\DischargeTrackerController@RemovedPatients')->name('removed_patients');
        Route::get('removed-patients-data-load', 'Iboards\Camis\DischargeTrackerController@RemovedPatientDataLoad')->name('removed_patients.dataLoad');


        Route::get('referral', 'Iboards\Camis\DischargeTrackerController@ReferralTab')->name('referral');
        Route::post('referral-data-load', 'Iboards\Camis\DischargeTrackerController@ReferralDataLoad')->name('referral.data.load');
        Route::post('referral-save-status', 'Iboards\Camis\DischargeTrackerController@ReferralSaveStatus')->name('referral.save.status');
        Route::post('removed-from-cdt', 'Iboards\Camis\DischargeTrackerController@RemovedPatientFormCDT')->name('RemovedPatientFormCDT');

        Route::get('medfit', 'Iboards\Camis\DischargeTrackerController@MedfitTab')->name('medfit');
        Route::post('medfit-data-load', 'Iboards\Camis\DischargeTrackerController@MedfitDataLoad')->name('medfit.data.load');
        Route::get('medfit_no/export', 'Iboards\Camis\DischargeTrackerController@MedfitNoExport')->name('medfit_no.export');
        Route::get('medfit_yes/export', 'Iboards\Camis\DischargeTrackerController@MedfitYesExport')->name('medfit_yes.export');
        Route::post('medfit_yes/dataload', 'Iboards\Camis\DischargeTrackerController@MedfitYesContentLoad')->name('medfit.yes.contentload');


        Route::get('monthsummary', 'Iboards\Camis\DischargeTrackerController@MonthSummary')->name('month.summary');
        Route::post('month-summary-data-load', 'Iboards\Camis\DischargeTrackerController@MonthSummaryDataLoad')->name('month.data.load');

        Route::get('monthlistsummary', 'Iboards\Camis\DischargeTrackerController@MonthListSummary')->name('monthlist.summary');
        Route::post('month-list-summary-data-load', 'Iboards\Camis\DischargeTrackerController@MonthListSummaryDataLoad')->name('monthlist.data.load');

        Route::post('save-comment', 'Iboards\Camis\DischargeTrackerController@SaveComment')->name('save.comment');
        Route::post('update-comment', 'Iboards\Camis\DischargeTrackerController@UpdateComment')->name('update.comment');
        Route::post('remove-comment', 'Iboards\Camis\DischargeTrackerController@RemoveComment')->name('remove.comment');
        Route::post('action-na-comment', 'Iboards\Camis\DischargeTrackerController@NotApplicableComment')->name('na.comment');


        Route::get('patient-search', 'Iboards\Camis\DischargeTrackerController@PatientSearch')->name('patient.search');
        Route::post('patient-search-data-load', 'Iboards\Camis\DischargeTrackerController@PatientSearchDataLoad')->name('search.data.load');

        Route::get('discharges', 'Iboards\Camis\DischargeTrackerController@Discharges')->name('dischargepatient');
        Route::post('discharges/dataload', 'Iboards\Camis\DischargeTrackerController@DischargeDataLoad')->name('discharges.dataload');
        Route::post('discharges/datasaved', 'Iboards\Camis\DischargeTrackerController@DischargeDataSave')->name('discharges.datasave');

        Route::post('/fetch-medfit-timeline', 'Iboards\Camis\DischargeTrackerController@GetMedfitTimeline')->name('medfittimeline');

        Route::get('dh-complex-discharge', 'Iboards\Camis\DischargeTrackerController@PerformanceTab')->name('performance');
        Route::get('dh-complex-discharge-data-load', 'Iboards\Camis\DischargeTrackerController@IndexRefreshDataLoad')->name('performance.data.load');
        Route::get('cdt-performance-offcanvas-in-patient-list', 'Iboards\Camis\DischargeTrackerController@CDTPerformanceOffcanvasInPatientList')->name('performance.offcanvas.inpatient');

        Route::get('cdt-performance-offcanvas-discharged-today-offcanvas', 'Iboards\Camis\DischargeTrackerController@DischargeTodayOffcanvas')->name('performance.offcanvas.dischargetoday');

        Route::get('cdt-performance-offcanvas-cdt-pending-offcanvas', 'Iboards\Camis\DischargeTrackerController@CDTPendingOffcanvas')->name('performance.offcanvas.cdtpending');
        Route::get('cdt-performance-patient-export', 'Iboards\Camis\DischargeTrackerController@CDTPerformancePatientExport')->name('performance.cdt.export');

        Route::get('performanceLosExport', 'Iboards\Camis\DischargeTrackerController@PerformanceLosExport')->name('PerformanceLosExport');
        Route::get('performancePatientListExport', 'Iboards\Camis\DischargeTrackerController@PerformancePatientListExport')->name('PerformancePatientListExport');
        Route::get('PatientListOfPerformance', 'Iboards\Camis\DischargeTrackerController@PatientListOfPerformance')->name('PatientListOfPerformance');
        Route::post('PatientListByCurrentProvider', 'Iboards\Camis\DischargeTrackerController@PatientListByCurrentProvider')->name('PatientListByCurrentProvider');
        Route::post('/fetch-cdt-timeline', 'Iboards\Camis\DischargeTrackerController@GetCDTTimeline')->name('GetCDTTimeline');
        Route::post('/fetch-pathway-count', 'Iboards\Camis\DischargeTrackerController@PathwayCount')->name('get.pathway.count');


        Route::post('/get-cdt-comment-history', 'Iboards\Camis\DischargeTrackerController@GetCDTCommentHistory')->name('get.cdtcomments');
        Route::post('/save-cdt-comment-history', 'Iboards\Camis\DischargeTrackerController@ReviewTabSaveCDTComment')->name('save.cdtcomments');
        Route::post('/remove-cdt-comment-history', 'Iboards\Camis\DischargeTrackerController@RemoveCDTCommentHistory')->name('remove.cdtcomments.history');
        Route::post('/delete-cdt-comment-history', 'Iboards\Camis\DischargeTrackerController@DeleteCDTCommentHistory')->name('delete.cdtcomments.history');

        Route::post('/ed-referral', 'Iboards\Camis\DischargeTrackerController@EDReferral')->name('ed_referral');
        Route::post('/ed-referral-patient-search', 'Iboards\Camis\DischargeTrackerController@EDReferralPatientSearch')->name('ed_referral.listsearch');
        Route::post('/search-ed-patient', 'Iboards\Camis\DischargeTrackerController@SearchEDPatient')->name('search.ed.patient');
        Route::post('/ed_referral-save-patient', 'Iboards\Camis\DischargeTrackerController@EDReferralSavePatient')->name('save.ed.patient');
        Route::post('/ed_referral-remove-patient', 'Iboards\Camis\DischargeTrackerController@EDReferralRemovePatient')->name('remove.ed.patient');
        Route::post('/other-notes', 'Iboards\Camis\DischargeTrackerController@OtherNotes')->name('other.notes');
        Route::post('/save-other-notes', 'Iboards\Camis\DischargeTrackerController@SaveOtherNotes')->name('save.other.notes');
    });

    Route::group(['prefix' => 'infection-control', 'middleware' => 'userauthentication', 'as' => 'infection.'], function ()
    {
        Route::get('ic-patients', 'Iboards\Camis\InfectionController@Index')->name('index');
        Route::post('ic-patients-data-load', 'Iboards\Camis\InfectionController@IndexDataLoad')->name('indexdataload');
        Route::post('ic-patients-assign-reverse', 'Iboards\Camis\InfectionController@AssignReverseBarrier')->name('assignreversebarrier');

        Route::get('side-room-patients', 'Iboards\Camis\InfectionController@SideRoomPatients')->name('sideroom.patients');
        Route::post('side-room-data-load', 'Iboards\Camis\InfectionController@SideRoomPatientsDataLoad')->name('sideroom.patients.dataload');


        Route::get('ipc-side-room-patients', 'Iboards\Camis\InfectionController@IPCSideRoomPatients')->name('ipc.sideroom.patients');
        Route::post('ipc-side-room-data-load', 'Iboards\Camis\InfectionController@IPCSideRoomPatientsDataLoad')->name('ipc.sideroom.patients.dataload');
        Route::post('ipc-side-room-patient-flag', 'Iboards\Camis\InfectionController@IPCSideRoomPatientFlag')->name('ipc.sideroom.patients.flag');
        Route::post('/update-patient-flag-details', 'Iboards\Camis\InfectionController@UpdatePatientFlagDetails')->name('UpdatePatientFlagDetails');
        Route::post('get-scub-patient', 'Iboards\Camis\InfectionController@GetScubPatient')->name('ipc.scub.patients');
        Route::post('save-scub-patient', 'Iboards\Camis\InfectionController@SaveScubPatient')->name('ipc.scub.save');
        Route::post('remove-scub-patient', 'Iboards\Camis\InfectionController@RemoveScubPatient')->name('ipc.scub.remove');


        Route::get('covid-wards', 'Iboards\Camis\InfectionController@CovidWards')->name('covid.ward');
        Route::post('covid-wards-data-load', 'Iboards\Camis\InfectionController@CovidWardDataLoad')->name('covidward.dataload');
        Route::post('ic-patients/infection-close-status', 'Iboards\Camis\InfectionController@SaveInfectionCloseStatus')->name('close.status');

        Route::get('covid-sitrep', 'Iboards\Camis\InfectionController@CovidSitrep')->name('covid.sitrep');
        Route::post('covid-sitrep-data', 'Iboards\Camis\InfectionController@CovidSitrepData')->name('covid.dataload');
        Route::post('ic-sideroom-infection-history', 'Iboards\Camis\InfectionController@GetIPCInfectionHistory')->name('ipc.infection.history');

        Route::get('ic-patients-refresh', 'Iboards\Camis\InfectionController@IndexRefreshDataLoad')->name('patient.refresh');
        Route::get('ic-sideroom-patients', 'Iboards\Camis\InfectionController@GetSideroomPatients')->name('sideroom');
        Route::post('ic-sideroom-comment-history', 'Iboards\Camis\InfectionController@GetIPCCommentHistory')->name('ipc.comment.history');
        Route::post('ic-sideroom-comment-save', 'Iboards\Camis\InfectionController@SaveIPCCommentHistory')->name('ipc.comment.save');
        Route::get('contact-tracing', 'Iboards\Camis\InfectionController@ContactTracing')->name('contact.tracing');
        Route::post('contact-tracing-dataload', 'Iboards\Camis\InfectionController@ContactTracingDataload')->name('contact.tracing.dataload');
        Route::post('contact-tracing-patinet', 'Iboards\Camis\InfectionController@ContactTracingPatient')->name('contact.tracing.patient');
        Route::post('/other-notes', 'Iboards\Camis\InfectionController@ContactTracingOtherNotes')->name('contact.tracing.other.notes');
        Route::post('/save-other-notes', 'Iboards\Camis\InfectionController@ContactTracingSaveOtherNotes')->name('contact.tracing.save.other.notes');

    });


    Route::prefix('allowed-to-move-patients')->group(function ()
    {
        Route::get('/', 'Iboards\Camis\AllowedToMoveController@Index')->name('allowed_to_move.dashboard');
        Route::post('/content', 'Iboards\Camis\AllowedToMoveController@IndexRefreshDataLoad')->name('allowed_to_move.dataload');
        Route::get('/export', 'Iboards\Camis\AllowedToMoveController@Export')->name('allowed_to_move.export');
    });
    Route::group(['prefix' => 'report'], function ()
    {




        Route::get('/siteoverview', 'Iboards\Camis\SiteOverviewController@Index')->name('inpatients.siteoverview');
        Route::get('/siteoverview/dataload', 'Iboards\Camis\SiteOverviewController@IndexDataLoad')->name('inpatients.siteoverview.dataload');
        Route::get('/siteoverview-bed-data', 'Iboards\Camis\SiteOverviewController@BedWisePatientList')->name('inpatients.siteoverview.bedwisepatient');

        Route::get('/siteoverview-medfit-data', 'Iboards\Camis\SiteOverviewController@MedfitPatientPatientList')->name('inpatients.siteoverview.medfit_patient');
        Route::get('/siteoverview-therapy-data', 'Iboards\Camis\SiteOverviewController@TherapyPatientPatientList')->name('inpatients.siteoverview.therapy_patient');


        Route::get('/siteoverview-boardround-report', 'Iboards\Camis\SiteOverviewController@WardBoardRoundReport')->name('inpatients.siteoverview.boardroundreport');
        Route::get('/siteoverview-boardround-discharge-report', 'Iboards\Camis\SiteOverviewController@DischargePatientList')->name('inpatients.siteoverview.discharge');
        Route::get('/siteoverview-symphony-ane-report', 'Iboards\Camis\SiteOverviewController@SymphonyAnePatient')->name('inpatients.siteoverview.ane');
        Route::get('/site-office', 'Iboards\Camis\SiteOfficeController@Index')->name('site.office');
        Route::get('/site-office-dataload', 'Iboards\Camis\SiteOfficeController@IndexRefreshDataLoad')->name('site.office.dataload');
        Route::post('/site-office-report-save', 'Iboards\Camis\SiteOfficeController@SaveOfficeTextReport')->name('site.office.report.save');
        //        Route::prefix('surgical-wards')->group(function(){
        //            Route::get('/', 'Iboards\Camis\SurgicalWardController@Index')->name('surgical.ward');
        //            Route::post('save-comments', 'Iboards\Camis\SurgicalWardController@SaveSurgicalWardsComment')->name('surgical.save.comment');
        //            Route::post('update-comments', 'Iboards\Camis\SurgicalWardController@UpdateSurgicalWardsComment')->name('surgical.update.comment');;
        //            Route::post('delete-comments', 'Iboards\Camis\SurgicalWardController@DeleteSurgicalWardsComment')->name('surgical.delete.comment');;
        //            Route::post('/refresh/surgical-wards', 'Iboards\Camis\SurgicalWardController@IndexRefreshDataLoad')->name('surgical.ward.refresh');
        //        });

        Route::prefix('bed-status-flags')->group(function ()
        {
            Route::get('/', 'Iboards\Camis\BedStatusFlagController@Index')->name('bed.status.flag');
            Route::post('/filter', 'Iboards\Camis\BedStatusFlagController@BedStatusFlagFilter')->name('bed.status.flag.filter');
        });

        //        Route::prefix('doctor-at-night')->group(function(){
        //            Route::get('/', 'Iboards\Camis\DoctorAtNightController@Index')->name('doctor.at.night');
        //            Route::post('/save-comments', 'Iboards\Camis\DoctorAtNightController@SaveDoctorAtNightComment')->name('doctor.at.night.save.comment');
        //            Route::post('/update-comments', 'Iboards\Camis\DoctorAtNightController@UpdateDoctorAtNightComment')->name('doctor.at.night.update.comment');
        //            Route::post('/delete-comments', 'Iboards\Camis\DoctorAtNightController@DeleteDoctorAtNightComment')->name('doctor.at.night.delete.comment');
        //            Route::post('/filter', 'Iboards\Camis\DoctorAtNightController@FilterDoctorAtNightData')->name('doctor.at.night.filter');
        //        });



        Route::prefix('deteriorating')->group(function ()
        {
            Route::get('new-patient', 'Iboards\Camis\DeterioratingPatientController@Index')->name('new.patient');
            Route::get('new-patient/dataload', 'Iboards\Camis\DeterioratingPatientController@NewPatientDataLoad')->name('new.patient.dataload');

            Route::get('reviewed-patient', 'Iboards\Camis\DeterioratingPatientController@ReviewedPatients')->name('reviewed.patient');
            Route::get('reviewed-patient/dataload', 'Iboards\Camis\DeterioratingPatientController@ReviewedPatientDataLoad')->name('reviewed.patient.dataload');

            Route::get('stepdown-patient', 'Iboards\Camis\DeterioratingPatientController@StepdownPatients')->name('stepdown.patient');
            Route::get('stepdown-patient/dataload', 'Iboards\Camis\DeterioratingPatientController@StepdowndPatientDataLoad')->name('stepdown.patient.dataload');


            Route::get('removed-patient', 'Iboards\Camis\DeterioratingPatientController@RemovedPatients')->name('removed.patient');
            Route::get('removed-patient/dataload', 'Iboards\Camis\DeterioratingPatientController@RemovedPatientDataLoad')->name('removed.patient.dataload');


            Route::get('all-patient', 'Iboards\Camis\DeterioratingPatientController@AllPatients')->name('all.patient');
            Route::get('all-patient/dataload', 'Iboards\Camis\DeterioratingPatientController@AllPatientsDataLoad')->name('all.patient.dataload');


            Route::post('action/discharge_to_ward', 'Iboards\Camis\DeterioratingPatientController@ActionDischargeToWard')->name('dp.action.discharge_to_ward');
            Route::post('action/reviewed_patients', 'Iboards\Camis\DeterioratingPatientController@ActionReviewedPatient')->name('dp.action.reviewedpatient');
            Route::post('action/removed_patients', 'Iboards\Camis\DeterioratingPatientController@ActionRemovedPatient')->name('dp.action.removedpatient');
            Route::post('action/stepdown', 'Iboards\Camis\DeterioratingPatientController@ActionStepDownPatient')->name('dp.action.stepdown');
            Route::post('/save-comments', 'Iboards\Camis\DeterioratingPatientController@SaveDpComment')->name('dp.save.comment');
            Route::post('/update-comments', 'Iboards\Camis\DeterioratingPatientController@UpdateDpComment')->name('dp.update.comment');
            Route::post('/delete-comments', 'Iboards\Camis\DeterioratingPatientController@DeleteDpComment')->name('dp.delete.comment');
            Route::post('/fetch-all-comments', 'Iboards\Camis\DeterioratingPatientController@FetchAllComments')->name('dp.all.comments');
            Route::post('/daily-plan-history', 'Iboards\Camis\DeterioratingPatientController@DailyPlanHistory')->name('daily.plan.history');
            Route::get('patient-task-details', 'Iboards\Camis\DeterioratingPatientController@DpTaskDetail')->name('patient.task.details');
            Route::get('patient-task/detail/filter', 'Iboards\Camis\DeterioratingPatientController@DpTaskFilter')->name('task_details.filter');


            Route::get('patient-search', 'Iboards\Camis\DeterioratingPatientController@PatientSearch')->name('patient.search');
            Route::post('patient-search/data', 'Iboards\Camis\DeterioratingPatientController@PatientSearchData')->name('get.patient.search.data');
            Route::get('patient-export-tasks/{id}', 'Iboards\Camis\DeterioratingPatientController@ExportPatientDpTasks')->name('export.dp_patient_task');



            Route::get('patient-task-summary', 'Iboards\Camis\DeterioratingPatientController@PatientTaskSummary')->name('patient.task.summary');
            Route::get('patient-task/summary/filter', 'Iboards\Camis\DeterioratingPatientController@TaskSummaryFilter')->name('task_summary.filter');

            Route::get('dp-summary', 'Iboards\Camis\DeterioratingPatientController@DPSummaryMenu')->name('DPSummaryMenu');
            Route::post('dp-summary-dataload', 'Iboards\Camis\DeterioratingPatientController@DPSummaryData')->name('DPSummaryMenu.data.load');


            Route::post('/dp-patient/status', 'Iboards\Camis\DeterioratingPatientController@DpPatientStatus')->name('dp.status');

            Route::post('/fetch-dp-task-list', 'Iboards\Camis\DeterioratingPatientController@FetchDPTaskList')->name('FetchDPTaskList');
            Route::post('/update-dp-task-list', 'Iboards\Camis\DeterioratingPatientController@UpdateDPTaskList')->name('UpdateDPTaskList');

        });

        Route::get('/virtual-ward-leaflet', 'Iboards\Camis\VirtualWardLeafletController@Index')->name('virtual.ward.leaflet');
        Route::get('/leaflet-page-refresh', 'Iboards\Camis\VirtualWardLeafletController@IndexRefreshDataLoad')->name('leaflet.page.refresh');
    });

    Route::post('/pd-modal-data', 'Iboards\Camis\BedMatrixController@PDModal')->name('bed.matrix.pd_modal');
    Route::get('/bedmatrix', 'Iboards\Camis\BedMatrixController@Index')->name('bed.matrix');
    Route::post('/refresh/bedmatrix', 'Iboards\Camis\BedMatrixController@IndexRefreshDataLoad')->name('bed.matrix.ajax');
    Route::post('/modal/bedmatrix', 'Iboards\Camis\BedMatrixController@ModalDataLoad')->name('bed.matrix.modal');
    Route::post('/modal/bedstatus', 'Iboards\Camis\BedMatrixController@BedStatusDataLoad')->name('bed.matrix.bedstatus');
    Route::post('/modal/baystatus', 'Iboards\Camis\BedMatrixController@BayStatusDataLoad')->name('bed.matrix.baystatus');
    Route::post('/inpatients-all-patient-id', 'Iboards\Camis\BedMatrixController@CamisGetAllPatientID')->name('CamisGetAllPatientID');
    Route::post('/bedstatus/save', 'Iboards\Camis\BedMatrixController@BedStatusSave')->name('SaveBedStatus');
    Route::post('/baystatus/save', 'Iboards\Camis\BedMatrixController@BayStatusSave')->name('SaveBayStatus');
    Route::get('/red-bed-dashboard', 'Iboards\Camis\RedBedDashboardController@Index')->name('red.bed.dashboard');
    Route::get('/red-bed-export', 'Iboards\Camis\RedBedDashboardController@RedBedExport')->name('red.bed.export');
    Route::post('/refresh/red-bed-reason-list', 'Iboards\Camis\RedBedDashboardController@RedBedReasonList')->name('red.bed.reasonlist');
    Route::post('/refresh/red-bed-update-reason', 'Iboards\Camis\RedBedDashboardController@ApproveReason')->name('red.bed.updatereason');
    Route::post('/refresh/red-bed-reason-performance', 'Iboards\Camis\RedBedDashboardController@RedBedPerformance')->name('red.bed.performance');
    Route::post('/refresh/red-bed-reason-performance-right-section', 'Iboards\Camis\RedBedDashboardController@RedBedPerformanceRightSection')->name('red.bed.performance.right.section');
    Route::post('/refresh/red-bed-reason-performance-patient-list', 'Iboards\Camis\RedBedDashboardController@RedBedPerformancePatientList')->name('red.bed.performance.patient_list');

    Route::prefix('notification')->group(function ()
    {
        Route::get('/', 'Iboards\Camis\NotificationController@Index')->name('notification.index');
        Route::post('/dataload', 'Iboards\Camis\NotificationController@IndexDataload')->name('notification.refresh');
        Route::post('/topcount', 'Iboards\Camis\NotificationController@TopCount')->name('notification.topcount');
        Route::get('/offcanvas-data', 'Iboards\Camis\NotificationController@OffcanvasDataLoad')->name('notification.offcanvas');
        Route::post('/approve/single', 'Iboards\Camis\NotificationController@SingleApprove')->name('notification.single.approve');
        Route::get('/approve/all', 'Iboards\Camis\NotificationController@AllApprove')->name('notification.all.approve');


        Route::post('/notification-move-to-action', 'Iboards\Camis\NotificationController@MoveToNotificationAction')->name('notification.move.to.action');


    });


    Route::group(['prefix' => 'virtual-ward'], function ()
    {
        Route::get('/{virtualward}', 'Iboards\Camis\VirtualWardController@index')->name('virtual.ward.summary');
        Route::post('/wardfilter', 'Iboards\Camis\VirtualWardController@WardFilter')->name('virtual.ward.filter');
    });

    Route::post('/patient-outstanding-task', 'Iboards\Camis\WardSummaryController@PatientOutstandingTask')->name('show.outstanding.task');
    Route::post('/patient-all-comments', 'Iboards\Camis\WardSummaryController@PatientAllComments')->name('show.all_comments');
});
