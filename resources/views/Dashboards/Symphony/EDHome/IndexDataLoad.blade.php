<div class="main-panel page-content  h-100" id="page-content">
    <div class="row align-items-center h-100">
        <div class="col-lg-12 ">
            <div class="card-welcome">
                <div class="card-body">
                    <div class="row pb-lg-4 mt-2 align-items-center pt-20">
                        <div class="col-lg-4 mb-2 text-center">
                            <a data-toggle="Home" title="Home" href="{{ route('ane_home') }}">
                                <img src="{{ asset('asset_v2/Ibox/Images/geh_logo_welcome_screen.png') }}" alt="">
                            </a>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <div class="row align-items-center p-2" id="bluebox-ed">
                                <div class="col-lg-8 col-md-8 col-8 count-box-ed">
                                    <div class="d-flex justify-content-around">
                                        <h5 class="fw-bold mb-0 pt-2">ED</h5>
                                        <div class="border-end"></div>
                                        <h6 class="ps-0 mb-0">Total <br> Patients</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-4 count-bluebox">
                                    <h5 class="mb-1 mt-1">{{ $success_array['total_patients_ed_now'] }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <div class="text-lg-end text-center">
                                <a data-toggle="Home" title="Home" href="{{ url('/home') }}">
                                    <h5>WELCOME TO <br class="d-none d-lg-block"> GEORGE ELIOT HOSPITAL<br>
                                        <span class="text-primary">EMERGENCY  DEPARTMENT</span>
                                    </h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-lg-2 pt-40 mt-3 mt-lg-0" id="bg-blue">
                        <div class="col-lg-4 mb-2">
                            <h6 class="header-department  ed-home-title-height ed-home-title-line-height">URGENT TREATMENT CENTRE</h6>
                            <div class="row align-items-center">
                                <div class=" col-xxl-10 col-xl-9 col-lg-9 col-md-10 col-9 pe-0 align-self-center">
                                    <div class="count-box">
                                        <div class="">
                                            <h6 class="mb-0">Total Patients</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-2 col-3 ps-0 align-self-center">
                                    <div class="count-bluebox">
                                        <h5 class="mb-0">{{ $success_array['total_patients_ed_now_minors'] }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-lg-12 col-md-12 align-self-center">
                                    <div class="count-box-waiting">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0">Longest Wait</h6>
                                            <h6 class="mb-0">{{ $success_array['average_waiting_times_minors'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-2">
                            <h6 class="header-department ed-home-title-height ed-home-title-line-height">PAEDIATRIC</h6>
                            <div class="row align-items-center">
                                <div class="col-xxl-10 col-xl-9 col-lg-9 col-md-10 col-9 pe-0 align-self-center">
                                    <div class="count-box">
                                        <div class="">
                                            <h6 class="mb-0">Total Patients</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-2 col-3 ps-0 align-self-center">
                                    <div class="count-bluebox">
                                        <h5 class="mb-0">{{ $success_array['total_patients_ed_now_paed_eds'] }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-lg-12 col-md-12 align-self-center">
                                    <div class="count-box-waiting">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0">Longest Wait</h6>
                                            <h6 class="mb-0">{{ $success_array['average_waiting_times_paed_eds'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <h6 class="header-department ed-home-title-height ed-home-title-line-height">A&E</h6>
                            <div class="row align-items-center">
                                <div class="col-xxl-10 col-xl-9 col-lg-9 col-md-10 col-9 pe-0 align-self-center">
                                    <div class="count-box">
                                        <div class="">
                                            <h6 class="mb-0">Total Patients</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-2 col-3 ps-0 align-self-center">
                                    <div class="count-bluebox">
                                        <h5 class="mb-0">{{ $success_array['total_patients_ed_now_majors'] }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-lg-12 col-md-12 align-self-center">
                                    <div class="count-box-waiting">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0">Longest Wait</h6>
                                            <h6 class="mb-0">{{ $success_array['average_waiting_times_majors'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-center mt-4 welcome-text">Please note that all patients are seen in order of medical priority and not time of arrival. These times may vary if the department has a significant Emergency or you have been referred into the hospital to a speciality via your GP - please ask a member of staff for more information if this is the case.</p>
                </div>
            </div>
        </div>
    </div>
</div>

