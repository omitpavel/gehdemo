<?php
    use Illuminate\Support\Facades\Route;
    Route::get('/', function ()
    {
        return view('Auth.User.Login');
    })->name('login.screen');
    Route::get('/csrf-token', function () {
        return response()->json(['token' => csrf_token()]);
    });

    Route::get('users/login', 'Common\ActiveDirectoryController@CheckUser');
    Route::post('users/login', 'Common\ActiveDirectoryController@CheckUser');
    Route::get('/logout', 'Common\ActiveDirectoryController@logout');
    Route::get('home', 'Iboards\Common\DashboardHomeController@index')->name('home');
    Route::get('ane-home', 'Iboards\Common\DashboardHomeController@ane_index')->name('ane_home');
    Route::get('/print', 'Iboards\Common\DashboardHomeController@PrintGlobal')->name('print_global.dashboard');


Route::get('under-construction', function ()
    {
        return view('errors.UnderConstruction');
    });

    Route::prefix('governance')->group(function () {
        Route::post('/frontend/pagelogs', 'Governance\GovernanceController@StorePageLogs');
    });


    Route::prefix('data-auto-load')->group(function () {
        //Symphony
        Route::get('/breach-reason', 'DataAutoLoad\Symphony\BreachReasonDataAutoController@BreachReasonDataAutoInsert');
        Route::get('/attendance-summary', 'DataAutoLoad\Symphony\AttendanceSummaryDataAutoController@AttendanceSummaryDataAutoInsert');
        Route::get('/attendance-summary-hourly', 'DataAutoLoad\Symphony\AttendanceSummaryDataAutoController@AttendanceSummaryHourlyDataAutoInsert');

        Route::get('/attendance-hourly-summary-history', 'DataAutoLoad\Symphony\AttendanceSummaryDataAutoController@AttendanceHourlySummaryDataAutoInsertHistory');
        //Camis
        Route::get('/auto-load-inpatients-daily-summary', 'DataAutoLoad\Camis\CamisDailySummaryController@AutoLoadCamisDailySummary');
        Route::get('/auto-load-inpatients-daily-summary-secondary', 'DataAutoLoad\Camis\CamisDailySummaryController@SecondaryAutoLoadCamisDailySummary');

        Route::get('/potential-definite-date', 'DataAutoLoad\PDDateDataAutoController@PDDataUpdate');
        Route::get('/dp-task-daily-task-summary', 'DataAutoLoad\Camis\CamisDailySummaryController@TaskSummaryAutoInsert');
        Route::get('/dp-task-monthly-task-summary', 'DataAutoLoad\Camis\DPTaskSummaryDataAutoController@MonthlyTaskSummaryAutoInsert');
        Route::get('/bed_name_change', 'DataAutoLoad\Camis\CamisDailySummaryController@BedActualName');
        Route::get('/clear-allowed-to-move', 'DataAutoLoad\Camis\CamisDailySummaryController@ClearAllowedToMove');
        Route::get('/auto-load-inpatients-patient-flag-assign', 'DataAutoLoad\Camis\CamisDailySummaryController@AutoLoadCamisPatientFlagAssign');
        Route::get('/remove-old-pd', 'DataAutoLoad\Camis\CamisDailySummaryController@RemoveOldPotentialDefiniteData');
        Route::get('/remove-old-pd-outpatient', 'DataAutoLoad\Camis\CamisDailySummaryController@RemoveOldPotentialDefiniteDataOutPatient');
        Route::get('/update-discharge-pd', 'DataAutoLoad\Camis\CamisDailySummaryController@UpdateDischargeDateOnMissedPatient');
        Route::get('/hourly-bed-management', 'DataAutoLoad\Camis\CamisDailySummaryController@HourlyBedStatusData');
        Route::get('/update-ic-risk', 'DataAutoLoad\Camis\CamisDailySummaryController@UpdateInfectionControlRisk');


    });
    Route::prefix('log-automation')->group(function ()
{
    Route::get('/daily-health-check', 'DataAutoLoad\ManualJobLogReadController@HealthCheckDaily');
    Route::get('/daily-health-check', 'DataAutoLoad\ManualJobLogReadController@HealthCheckDaily');
    Route::get('/ward-load-time', 'DataAutoLoad\ManualJobLogReadController@WardLoadTime');
    Route::get('/kitchen-time-read', 'DataAutoLoad\ManualJobLogReadController@KitchenTimeRead');
});
Route::group(['prefix' => 'patient-search', 'middleware' => 'userauthentication'], function ()
{
    Route::get('/', 'Iboards\Common\PatientSearchController@Index')->name('global.patient.search');
    Route::post('/dataload', 'Iboards\Common\PatientSearchController@IndexDataLoad')->name('global.patient.search.dataload');
    Route::get('/modal/{id}', 'Iboards\Common\PatientSearchController@Modal')->name('global.patient.search.inpatients.modal');
    Route::get('/modal-print/{id}', 'Iboards\Common\PatientSearchController@ModalPrint')->name('global.patient.search.inpatients.modal-print');
});
Route::group(['prefix' => 'favourites', 'middleware' => 'userauthentication'], function () {
    Route::get('/', 'Iboards\Common\FavouriteController@Index')->name('user.favourites');
    Route::get('/sidebar-management', 'Iboards\Common\FavouriteController@MenuDataAutoLoad')->name('favourites');

    Route::post('/save-data', 'Iboards\Common\FavouriteController@SaveUserFavourites')->name('save.favourites');

});

?>
