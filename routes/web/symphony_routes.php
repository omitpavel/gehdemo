<?php

use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'ane', 'middleware' => 'userauthentication'], function () {
    Route::prefix('dashboards')->group(function () {
        Route::prefix('site')->group(function ()
        {
            Route::get('/overview', 'Iboards\Camis\SiteController@Index')->name('site.overview');
            Route::post('/filter-data', 'Iboards\Camis\SiteController@GetDateFilterData')->name('filter_data.siteoverview');
            Route::post('/IndexRefreshDataLoad', 'Iboards\Camis\SiteController@IndexRefreshDataLoad')->name('IndexRefreshDataLoad.siteoverview');
        });
        //ED Welcome Screen
        Route::prefix('ed-home')->group(function () {
            Route::get('/', 'Iboards\Symphony\EDHomeController@Index')->name('ed.home');
            Route::post('/', 'Iboards\Symphony\EDHomeController@Index');
            Route::get('/content-data-load', 'Iboards\Symphony\EDHomeController@IndexRefreshDataLoad');
            Route::post('/content-data-load', 'Iboards\Symphony\EDHomeController@IndexRefreshDataLoad');
        });

        //ED Performance
        Route::get('/ed-performance', 'Iboards\Symphony\EDPerformanceController@Index')->name('ed.performance');
        Route::prefix('ed-opel')->group(function ()
        {
            Route::get('/', 'Iboards\Symphony\EDOpelController@Index')->name('ed.opel.dashboard');
            Route::post('/content-data-load', 'Iboards\Symphony\EDOpelController@IndexRefreshDataLoad')->name('ed.opel.dataload');
        });
        //A&E Live Status
        Route::prefix('accident-and-emergency')->group(function () {
            Route::get('/', 'Iboards\Symphony\AneController@Index')->name('ane.livestatus');
            Route::post('/', 'Iboards\Symphony\AneController@Index');
            Route::get('/content-data-load', 'Iboards\Symphony\AneController@IndexRefreshDataLoad');
            Route::post('/content-data-load', 'Iboards\Symphony\AneController@IndexRefreshDataLoad');
            Route::post('/content-sau-patients', 'Iboards\Symphony\AneController@GetSauPatient')->name('GetSauPatient');
            Route::post('/ane-dta-comment-details', 'Iboards\Symphony\AneController@GetAneDtaCommentsDetails');
            Route::post('/ane-dta-comment-save', 'Iboards\Symphony\AneController@AneDtaCommentsSave');
            Route::post('/ane-dta-comment-delete', 'Iboards\Symphony\AneController@AneDtaCommentsDelete');
            Route::post('/ane-opel-data-details', 'Iboards\Symphony\AneController@GetAneOpelDataDetails');
            Route::post('/ane-opel-data-details-save', 'Iboards\Symphony\AneController@GetAneOpelDataDetailsSave');
            Route::get('/get-details-by-attendance', 'Iboards\Symphony\AneController@GetPatientByIdFromBarChart')->name('GetPatientByIdFromBarChart');
            Route::get('/get-details-by-speciality', 'Iboards\Symphony\AneController@GetDetailsBySpeciality')->name('GetDetailsBySpeciality');

            Route::post('/ane-opel-modal-stage-one-load', 'Iboards\Symphony\AneController@AneOpelStatusModalLoadOne')->name('ane.opel.data.load.stage.one');
            Route::post('/ane-opel-modal-stage-two-load', 'Iboards\Symphony\AneController@AneOpelStatusModalLoadTwo')->name('ane.opel.data.load.stage.two');
            Route::post('/ane-opel-modal-stage-three-load', 'Iboards\Symphony\AneController@AneOpelStatusModalLoadThree')->name('ane.opel.data.load.stage.three');
            Route::post('/ane-opel-modal-stage-four-load', 'Iboards\Symphony\AneController@AneOpelStatusModalLoadFour')->name('ane.opel.data.load.stage.four');


            Route::post('/ane-opel-modal-stage-five-load', 'Iboards\Symphony\AneController@AneOpelStatusModalLoadFive')->name('ane.opel.data.load.stage.five');
            Route::post('/ane-opel-modal-stage-six-load', 'Iboards\Symphony\AneController@AneOpelStatusModalLoadSix')->name('ane.opel.data.load.stage.six');
            Route::post('/ane-opel-modal-stage-seven-load', 'Iboards\Symphony\AneController@AneOpelStatusModalLoadSeven')->name('ane.opel.data.load.stage.seven');

            Route::post('/ane-opel-modal-save-ed-thermometer', 'Iboards\Symphony\AneController@AneOpelModalSaveEDThermometer')->name('ane.opel.modal.save.ed.thermometer');



        });

        //ED Activity
        Route::prefix('activity-profile')->group(function () {
            Route::get('/', 'Iboards\Symphony\ActivityProfileController@Index')->name('activity.flow');
            Route::post('/', 'Iboards\Symphony\ActivityProfileController@Index');
            Route::post('/content-data-load', 'Iboards\Symphony\ActivityProfileController@ContentDataLoad');
        });

        //Ambulance Arrivals
        Route::prefix('ambulance-arrivals')->group(function () {
            Route::get('/', 'Iboards\Symphony\AmbulanceArrivalsController@Index')->name('ambulance.arrivals');
            Route::post('/', 'Iboards\Symphony\AmbulanceArrivalsController@Index');
            Route::post('/content-data-load', 'Iboards\Symphony\AmbulanceArrivalsController@ContentDataLoad');
        });

        //ED Overview
        Route::prefix('ed-overview')->group(function () {
            Route::get('/', 'Iboards\Symphony\EDOverviewController@Index')->name('ed.overview');
            Route::post('/', 'Iboards\Symphony\EDOverviewController@Index');
            Route::post('/content-data-load', 'Iboards\Symphony\EDOverviewController@ContentDataLoad');
            Route::post('/summary-speciality-specific-data', 'Iboards\Symphony\EDOverviewController@SummarySpecialitySpecificData');
        });

        //Referral To Speciality
        Route::prefix('referral-to-speciality')->group(function () {
            Route::get('/', 'Iboards\Symphony\ReferralToSpecialityController@Index')->name('speciality.referral');
            Route::post('/', 'Iboards\Symphony\ReferralToSpecialityController@Index');
            Route::post('/content-data-load', 'Iboards\Symphony\ReferralToSpecialityController@ContentDataLoad');
        });

        //Breach validation
        Route::prefix('breach-validation')->group(function () {
            Route::get('/', 'Iboards\Symphony\BreachValidationController@Index')->name('breach.validation');
            Route::post('/', 'Iboards\Symphony\BreachValidationController@Index');
            Route::post('/content-data-load', 'Iboards\Symphony\BreachValidationController@ContentDataLoad');
            Route::post('/breach-content-data-load', 'Iboards\Symphony\BreachValidationController@BreachContentDataLoad');
            Route::post('/breach-reason-data-store', 'Iboards\Symphony\BreachValidationController@BreachReasonDataStore');
            Route::post('/breach-dashboard-ambulance-data-store', 'Iboards\Symphony\BreachValidationController@BreachAmbulanceDataStore');
        });

        Route::prefix('sankey-charts')->group(function ()
        {
            Route::get('/', 'Iboards\Symphony\SankeyController@Index')->name('dashboards.sankey-chart');
            Route::post('/content-data-load', 'Iboards\Symphony\SankeyController@ContentDataLoad')->name('sankey-chart.dataload');
            Route::post('/node-data-load', 'Iboards\Symphony\SankeyController@NodeDataLoad')->name('sankey-chart.NodeDataLoad');
            Route::post('/categoryWise-data-load', 'Iboards\Symphony\SankeyController@CategoryWiseDataLoad')->name('sankey-chart.CategoryWiseDataLoad');
        });
    });
});
