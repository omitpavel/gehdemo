

@if($success_array['sankey_link']['total_patients'] > 0)
<div class="col-lg-12">
    <div class="sankey-sticky-toprow">
        <div class="row g-2">
            <div class="col-lg-4">
                <div class="card-date mb-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="cyan-circle text-center me-2">
                                <i class="bi bi-calendar3 "></i>
                            </div>
                            <div class="date-box w-90">
                                <input readonly autocomplete="off" type="text" name="datepicker" placeholder="Select Date" class="datepickerInput" value="" id="daterangepicker" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="start_date" id="start_date" value="{{request()->start_date}}">
            <input type="hidden" name="end_date" id="end_date" value="{{request()->end_date}}">

        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-2 mb-2">
            <div class="col">
                <div class="card-status">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 text-md-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                 viewBox="0 0 37.113 37.355">
                                <path id="user-nurse-svgrepo-com"
                                      d="M28.41,22.387c-.034-.015-.066-.031-.1-.044-.257-.116-.511-.237-.774-.342A11.2,11.2,0,1,0,13.7,22c-.263.1-.517.226-.774.342-.035.013-.066.029-.1.044A18.568,18.568,0,0,0,2.071,37.276a1.867,1.867,0,0,0,3.712.4A14.833,14.833,0,0,1,13.227,26.37l6.07,6.07a1.866,1.866,0,0,0,2.64,0l6.07-6.07A14.833,14.833,0,0,1,35.45,37.681,1.867,1.867,0,0,0,37.3,39.345a1.957,1.957,0,0,0,.205-.011,1.867,1.867,0,0,0,1.654-2.058A18.568,18.568,0,0,0,28.41,22.387ZM13.226,12.452a7.425,7.425,0,0,1,14.782,0ZM20.617,28.48,17,24.864a14.625,14.625,0,0,1,7.232,0Zm0-7.8a7.473,7.473,0,0,1-6.84-4.491H27.457a7.473,7.473,0,0,1-6.84,4.491Z"
                                      transform="translate(-2.06 -1.991)"></path>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6  pt-1 pt-md-0">
                            <h6 class="mb-0 ms-md-2 ">ATTENDANCE <br>TOTAL </h6>
                        </div>
                        <div class="col-lg-4 col-md-3 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">{{ $success_array['attendence_total'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card-status">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 text-md-center">
                            <svg xmlns="http://www.w3.org/2000/svg" id="close-svgrepo-com" width="30"
                                 height="30" viewBox="0 0 44.233 44.233">
                                <path id="Path_20664" data-name="Path 20664"
                                      d="M22.117,0A22.117,22.117,0,1,0,44.233,22.117,22.142,22.142,0,0,0,22.117,0Zm0,41.074A18.957,18.957,0,1,1,41.074,22.117,18.979,18.979,0,0,1,22.117,41.074Z"
                                      transform="translate(0 0)"></path>
                                <path id="Path_20665" data-name="Path 20665"
                                      d="M98.769,85.214a1.58,1.58,0,0,0-2.234,0l-4.543,4.543-4.544-4.544a1.58,1.58,0,0,0-2.234,2.234l4.544,4.544-4.544,4.544a1.58,1.58,0,0,0,2.234,2.234l4.544-4.544,4.544,4.544a1.58,1.58,0,0,0,2.234-2.234l-4.544-4.544,4.544-4.544A1.58,1.58,0,0,0,98.769,85.214Z"
                                      transform="translate(-69.875 -69.875)"></path>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 pt-1 pt-md-0">
                            <h6 class="mb-0 ms-md-2 ">BREACHES <br>TOTAL</h6>
                        </div>
                        <div class="col-lg-4 col-md-3 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">{{ $success_array['breaches'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card-status">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 text-md-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                 viewBox="0 0 41.846 41.846">
                                <g id="Group_1714" data-name="Group 1714"
                                   transform="translate(1.5 1.5)">
                                    <path id="Path_20662" data-name="Path 20662"
                                          d="M33.157,6.612a19.414,19.414,0,1,0,7.111,7.136"
                                          transform="translate(-4 -4)" fill="none" stroke="#000"
                                          stroke-linecap="round" stroke-linejoin="round" stroke-width="3">
                                    </path>
                                    <path id="Path_20663" data-name="Path 20663"
                                          d="M31.61,16.05s-3.29,8.784-4.807,10.3a3.885,3.885,0,1,1-5.494-5.494C22.826,19.34,31.61,16.05,31.61,16.05Z"
                                          transform="translate(-4.466 -4.347)" fill="none" stroke="#000"
                                          stroke-linejoin="round" stroke-width="3">
                                    </path>
                                </g>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 pt-1 pt-md-0">
                            <h6 class="mb-0 ms-md-2 ">PERFORMANCE <br>OVERALL</h6>
                        </div>
                        <div class="col-lg-4 col-md-3 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">{{ $success_array['performance_overall'] }}%</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card-status">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 text-md-center">
                            <svg width="30" height="30" fill="currentColor"
                                 class="bi bi-clipboard2-pulse" viewBox="0 0 16 16">
                                <path
                                    d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z">
                                </path>
                                <path
                                    d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z">
                                </path>
                                <path
                                    d="M9.979 5.356a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.926-.08L4.69 10H4.5a.5.5 0 0 0 0 1H5a.5.5 0 0 0 .447-.276l.936-1.873 1.138 3.793a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h.5a.5.5 0 0 0 0-1h-.128L9.979 5.356Z">
                                </path>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 pt-1 pt-md-0">
                            <h6 class="mb-0 ms-md-2 ">ADMISSIONS <br>OVERALL</h6>
                        </div>
                        <div class="col-lg-4 col-md-3 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">{{ $success_array["admissions"] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card-status">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 text-md-center">
                            <svg width="30" height="30" fill="currentColor"
                                 class="bi bi-clipboard-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z">
                                </path>
                                <path
                                    d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z">
                                </path>
                                <path
                                    d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z">
                                </path>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 pt-1 pt-md-0">
                            <h6 class="mb-0 ms-md-2 ">TOTAL DTA <br>(12+ HOUR)</h6>
                        </div>
                        <div class="col-lg-4 col-md-3 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">{{ $success_array["dta_12_more"] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card-status-chart mb-2" id='custom_card_sankey_element'>
    <div class="card-body custom_card">
        <div class="d-flex align-items-center" >
            <div id="my_dataviz"></div>
        </div>
    </div>
</div>

<div class="ae-sankey-data mb-2" id="sankey_data_table" style="display: none;">

</div>


@else
<div class="col-lg-12">

    <div class="sankey-sticky-toprow">
        <div class="row g-2">
            <div class="col-lg-4">
                <div class="card-date mb-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="cyan-circle text-center me-2">
                                <i class="bi bi-calendar3 "></i>
                            </div>
                            <div class="date-box w-90">
                                <input readonly autocomplete="off" type="text" name="datepicker" placeholder="Select Date" class="datepickerInput" value="" id="daterangepicker" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="start_date" id="start_date" value="{{request()->start_date}}">
            <input type="hidden" name="end_date" id="end_date" value="{{request()->end_date}}">

        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-2 mb-2">
            <div class="col">
                <div class="card-status">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 text-md-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                viewBox="0 0 37.113 37.355">
                                <path id="user-nurse-svgrepo-com"
                                    d="M28.41,22.387c-.034-.015-.066-.031-.1-.044-.257-.116-.511-.237-.774-.342A11.2,11.2,0,1,0,13.7,22c-.263.1-.517.226-.774.342-.035.013-.066.029-.1.044A18.568,18.568,0,0,0,2.071,37.276a1.867,1.867,0,0,0,3.712.4A14.833,14.833,0,0,1,13.227,26.37l6.07,6.07a1.866,1.866,0,0,0,2.64,0l6.07-6.07A14.833,14.833,0,0,1,35.45,37.681,1.867,1.867,0,0,0,37.3,39.345a1.957,1.957,0,0,0,.205-.011,1.867,1.867,0,0,0,1.654-2.058A18.568,18.568,0,0,0,28.41,22.387ZM13.226,12.452a7.425,7.425,0,0,1,14.782,0ZM20.617,28.48,17,24.864a14.625,14.625,0,0,1,7.232,0Zm0-7.8a7.473,7.473,0,0,1-6.84-4.491H27.457a7.473,7.473,0,0,1-6.84,4.491Z"
                                    transform="translate(-2.06 -1.991)"></path>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6  pt-1 pt-md-0">
                            <h6 class="mb-0 ms-md-2 ">ATTENDANCE <br>TOTAL </h6>
                        </div>
                        <div class="col-lg-4 col-md-3 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">0</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card-status">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 text-md-center">
                            <svg xmlns="http://www.w3.org/2000/svg" id="close-svgrepo-com" width="30"
                                height="30" viewBox="0 0 44.233 44.233">
                                <path id="Path_20664" data-name="Path 20664"
                                    d="M22.117,0A22.117,22.117,0,1,0,44.233,22.117,22.142,22.142,0,0,0,22.117,0Zm0,41.074A18.957,18.957,0,1,1,41.074,22.117,18.979,18.979,0,0,1,22.117,41.074Z"
                                    transform="translate(0 0)"></path>
                                <path id="Path_20665" data-name="Path 20665"
                                    d="M98.769,85.214a1.58,1.58,0,0,0-2.234,0l-4.543,4.543-4.544-4.544a1.58,1.58,0,0,0-2.234,2.234l4.544,4.544-4.544,4.544a1.58,1.58,0,0,0,2.234,2.234l4.544-4.544,4.544,4.544a1.58,1.58,0,0,0,2.234-2.234l-4.544-4.544,4.544-4.544A1.58,1.58,0,0,0,98.769,85.214Z"
                                    transform="translate(-69.875 -69.875)"></path>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 pt-1 pt-md-0">
                            <h6 class="mb-0 ms-md-2 ">BREACHES <br>TOTAL</h6>
                        </div>
                        <div class="col-lg-4 col-md-3 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">0</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card-status">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 text-md-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                viewBox="0 0 41.846 41.846">
                                <g id="Group_1714" data-name="Group 1714"
                                transform="translate(1.5 1.5)">
                                    <path id="Path_20662" data-name="Path 20662"
                                        d="M33.157,6.612a19.414,19.414,0,1,0,7.111,7.136"
                                        transform="translate(-4 -4)" fill="none" stroke="#000"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="3">
                                    </path>
                                    <path id="Path_20663" data-name="Path 20663"
                                        d="M31.61,16.05s-3.29,8.784-4.807,10.3a3.885,3.885,0,1,1-5.494-5.494C22.826,19.34,31.61,16.05,31.61,16.05Z"
                                        transform="translate(-4.466 -4.347)" fill="none" stroke="#000"
                                        stroke-linejoin="round" stroke-width="3">
                                    </path>
                                </g>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 pt-1 pt-md-0">
                            <h6 class="mb-0 ms-md-2 ">PERFORMANCE <br>OVERALL</h6>
                        </div>
                        <div class="col-lg-4 col-md-3 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">0%</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card-status">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 text-md-center">
                            <svg width="30" height="30" fill="currentColor"
                                class="bi bi-clipboard2-pulse" viewBox="0 0 16 16">
                                <path
                                    d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z">
                                </path>
                                <path
                                    d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z">
                                </path>
                                <path
                                    d="M9.979 5.356a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.926-.08L4.69 10H4.5a.5.5 0 0 0 0 1H5a.5.5 0 0 0 .447-.276l.936-1.873 1.138 3.793a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h.5a.5.5 0 0 0 0-1h-.128L9.979 5.356Z">
                                </path>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 pt-1 pt-md-0">
                            <h6 class="mb-0 ms-md-2 ">ADMISSIONS <br>OVERALL</h6>
                        </div>
                        <div class="col-lg-4 col-md-3 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">0</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card-status">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 text-md-center">
                            <svg width="30" height="30" fill="currentColor"
                                class="bi bi-clipboard-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z">
                                </path>
                                <path
                                    d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z">
                                </path>
                                <path
                                    d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z">
                                </path>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 pt-1 pt-md-0">
                            <h6 class="mb-0 ms-md-2 ">TOTAL DTA <br>(12+ HOUR)</h6>
                        </div>
                        <div class="col-lg-4 col-md-3 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">0</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="card-status-chart " style="min-height: 20px !important;">
    <div class="card-body">
        <div class="text-center">
            <h6>No Records Found</h6>
        </div>
    </div>
</div>



@endif



<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
<script>
    var windowWidth = window.innerWidth;
    var bgSticky = document.querySelector('.sankey-sticky-toprow');
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            bgSticky.style.top = '87px';

        }

    }
    if ($("#start_date_day_summary").length > 0) {
        $("#start_date_day_summary").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
            maxDate: new Date
        });
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
        }
    });
    var tok = "{{ csrf_token() }}";
    var ajax_refresh_url = "";



    @if(request()->filled('start_date') && request()->filled('end_date'))
        var start = moment('{{request()->start_date}}', 'YYYY-MM-DD');
        var end = moment('{{request()->end_date}}', 'YYYY-MM-DD');
    @else
        var start = moment();
        var end = moment();
    @endif
    function cb(start, end) {
        $('#daterangepicker').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
        if(start.format('YYYY-MM-DD') != '{{request()->start_date}}' || end.format('YYYY-MM-DD') != '{{request()->end_date}}'){
            SankeyChartDataLoad(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }
    }

    $('#daterangepicker').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
        format: 'MMMM D, YYYY'},
        ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
</script>
@if ($success_array['sankey_link']['total_patients'] > 0)
<script>

if (typeof json_data !== 'undefined') {
    let json_data;
}
if (typeof element_custom_card_sankey_element !== 'undefined') {
    let element_custom_card_sankey_element;
}
if (typeof width !== 'undefined') {
    let width;
}
if (typeof height !== 'undefined') {
    let height;
}
if (typeof align !== 'undefined') {
    let align;
}
if (typeof edgeColor !== 'undefined') {
    let edgeColor;
}
if (typeof data !== 'undefined') {
    let data;
}
if (typeof chartContainer !== 'undefined') {
    let chartContainer;
}
if (typeof svg !== 'undefined') {
    let svg;
}
if (typeof customColors !== 'undefined') {
    let customColors;
}

if (typeof customColorScale !== 'undefined') {
    let customColorScale;
}





json_data = {!! json_encode($success_array['sankey']) !!};

json_data.nodes.sort((a, b) => {
    const aLinks = json_data.links.filter(link => link.source === a.id || link.target === a.id);
    const bLinks = json_data.links.filter(link => link.source === b.id || link.target === b.id);
    return bLinks.length - aLinks.length;
});
 element_custom_card_sankey_element = document.getElementById("custom_card_sankey_element");


 var width = element_custom_card_sankey_element.offsetWidth - 50;
var height = (element_custom_card_sankey_element.offsetWidth / 2) - 200;
if (height < 300) {
    height = 500;
}

 align = 'justify';
 edgeColor = 'path';
function createSankeyChart(data, width, height) {

    height = height+20;
     const svg = d3.create("svg")
        .attr("width", width + 'px')
        .attr("height", height + 'px')
        .attr('viewBox', '0 -20 ' + Math.min(width, height) + ' ' + Math.min(width, height))
        .attr('preserveAspectRatio', 'xMinYMin');

    const {
        nodes,
        links
    } = sankey(data);

    svg.append("g")
        .attr("stroke", "#000")
        .selectAll("rect")
        .data(nodes)
        .join("rect")
        .attr("x", (d) => d.x0)
        .attr("y", (d) => d.y0)
        .attr("height", (d) => d.y1 - d.y0)
        .attr("width", (d) => d.x1 - d.x0)
        .attr("fill", color)
        .on("click", highlight_node_links)
        .on("mouseover", function() {
        d3.select(this).classed("cursor_pointer", true);
        })
        .on("mouseout", function() {
            d3.select(this).classed("cursor_pointer", false);
        })
        .append("title")
        .text((d) => {
            const custom_node_name = d.name.split('_').slice(1).join(' ').replace(/_/g, ' ');
            return `${custom_node_name}\nPatients: ${d.value}`;
        });


    const link = svg.append("g")
        .attr("fill", "none")
        .attr("stroke-opacity", 0.5)
        .selectAll("g")
        .data(links)
        .join("g")
        .attr("id", function(d, i) {
            d.id = i;
            return "link-" + i;
        })
        .style("mix-blend-mode", "multiply");

    if (edgeColor === "path") {
        const gradient = link.append("linearGradient")
            .attr("id", (d) => "gradient-" + d.id)
            .attr("gradientUnits", "userSpaceOnUse")
            .attr("x1", (d) => d.source.x1)
            .attr("x2", (d) => d.target.x0);

        gradient.append("stop")
            .attr("offset", "0%")
            .attr("stop-color", (d) => color(d.source));

        gradient.append("stop")
            .attr("offset", "100%")
            .attr("stop-color", (d) => color(d.target));
    }



    link.append("path")
        .attr("d", d3.sankeyLinkHorizontal())
        .attr("stroke", (d) =>
            edgeColor === "none" ?
            "#aaa" :
            edgeColor === "path" ?
            "url(#gradient-" + d.id + ")" :
            edgeColor === "input" ?
            color(d.source) :
            color(d.target)
        )
        .attr("stroke-width", (d) => Math.max(1, d.width));

        link.append("title")
        .text((d) => {
            const source_node_name = d.source.name.split('_').slice(1).join(' ').replace(/_/g, ' ');
            const target_node_name = d.target.name.split('_').slice(1).join(' ').replace(/_/g, ' ');
            return `${source_node_name} → ${target_node_name}\nPatients: ${d.value}`;
        });







    svg.append("g")
        .attr("font-family", "sans-serif")
        .attr("font-size", 10)
        .selectAll("text")
        .data(nodes)
        .join("text")
        .attr("x", (d) => (d.x0 < width / 2 ? d.x1 + 6 : d.x0 - 6))
        .attr("y", (d) => (d.y1 + d.y0) / 2)
        .attr("dy", "0.35em")
        .attr("text-anchor", (d) => (d.x0 < width / 2 ? "start" : "end"))
        .text(d => {
            const nodeName = d.name.split('_').slice(1).join(' ').replace(/_/g, ' ');
            return nodeName;
        });;

    var columnNames = data.column;

    var columnText = svg.selectAll(".column-text")
        .data(columnNames)
        .enter().append("text")
        .attr("class", "column-text")
        .attr("x", function(d, i) {
            var xPosition = (i + 0.5) * (width / columnNames.length);
            return xPosition;
        })
        .attr("y", -7)
        .attr("text-anchor", "middle")
        .text(function(d) {
            return d;
        });

    return svg.node();
}
function highlight_node_links(ev, node) {

    var remainingNodes = [],
        nextNodes = [];

    var stroke_opacity = 0;
    if (d3.select(this).attr("data-clicked") == "1") {
        d3.select(this).attr("data-clicked", "0");
        stroke_opacity = 0.5;
    } else {
        d3.select(this).attr("data-clicked", "1");
        stroke_opacity = 0.9;
    }

    var traverse = [{
            linkType: "sourceLinks",
            nodeType: "target",
        },
        {
            linkType: "targetLinks",
            nodeType: "source",
        },
    ];


    function sanitizeNodeName(name) {
        if (!isNaN(name)) {
            name = "node_" + name;
        } else {
            name = name.replace(/[^a-zA-Z0-9-_]/g, "_");
        }
        return name;
    }



    traverse.forEach(function(step) {
        node[step.linkType].forEach(function(link) {
            remainingNodes.push(link[step.nodeType]);
            highlight_link(link.id, stroke_opacity);
        });

        while (remainingNodes.length) {
            nextNodes = [];
            remainingNodes.forEach(function(node) {
                node[step.linkType].forEach(function(link) {
                    nextNodes.push(link[step.nodeType]);
                    highlight_link(link.id, stroke_opacity);
                });
            });
            remainingNodes = nextNodes;
        }

    });

    var clicked_node_name = sanitizeNodeName(node.node);
    var clicked_node_start = $('#start_date').val();
    var clicked_node_end = $('#end_date').val();

    $("#sankey_data_table").show();
    var tok = "{{ csrf_token() }}";
    var url = "{{ route('sankey-chart.NodeDataLoad') }}";
    $.ajax({
        url: url,
        type: 'POST',
        data: { "samkey_data": clicked_node_name, "_token":tok, "start_date":clicked_node_start, "end_date":clicked_node_end  },
        success: function (result)
        {
            if(result != '{{PermissionDenied()}}'){
                $('#sankey_data_table').html(result);
                $('.page-data-loader').hide();
            } else {
                $('.page-data-loader').hide();
                window.location.href = '{{ route('home') }}';

            }
        }
    });




}

function highlight_link(id, opacity) {
    d3.select("#link-" + id).style("stroke-opacity", opacity);
}


function sankey(data) {
    const sankeyLayout = d3.sankey()
        .nodeId((d) => d.name)
        .nodeAlign(d3[`sankey${align[0].toUpperCase()}${align.slice(1)}`])
        .nodeWidth(15)
        .nodePadding(10)
        .extent([
            [1, 5],
            [width - 1, height - 5]
        ]);

    const {
        nodes,
        links
    } = sankeyLayout(data);

    return {
        nodes,
        links
    };
}


function format(data) {
    const format = d3.format(",.0f");
    return data.units ? (d) => `${format(d)} ${data.units}` : format;
}





 customColors = [
    '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf',
    '#aec7e8', '#ffbb78', '#98df8a', '#ff9896', '#c5b0d5', '#c49c94', '#f7b6d2', '#c7c7c7', '#dbdb8d', '#9edae5',
    '#1b9e77', '#d95f02', '#7570b3', '#e7298a', '#66a61e', '#e6ab02', '#a6761d', '#666666', '#a6cee3', '#1f78b4',
    '#b2df8a', '#33a02c', '#fb9a99', '#e31a1c', '#fdbf6f', '#ff7f00', '#cab2d6', '#6a3d9a', '#ffff99', '#b15928',
    '#a6cee3', '#1f78b4', '#b2df8a', '#33a02c', '#fb9a99', '#e31a1c', '#fdbf6f', '#ff7f00', '#cab2d6', '#6a3d9a',
    '#ffff99', '#b15928', '#8dd3c7', '#ffffb3', '#bebada', '#fb8072', '#80b1d3', '#fdb462', '#b3de69', '#fccde5',
];


customColorScale = d3.scaleOrdinal()
    .range(customColors);

function color(data) {
    const color = customColorScale(data.name);
    return color;
}




data = json_data;
chartContainer = document.getElementById("my_dataviz");

chartContainer.innerHTML = "";

svg = createSankeyChart(json_data, width, height);
chartContainer.appendChild(svg);



</script>

<script>
    function ViewDetails(source, target){


        var admitting_reason_modal = new bootstrap.Offcanvas(document.getElementById('sankeyPatientsDetails'), {
            relatedTarget: 'offcanvasRight',
            backdrop: false
        });

        admitting_reason_modal.show();

        CommonDisableEnableOnOpen();
        var tok = "{{ csrf_token() }}";
        var url = "{{ route('sankey-chart.CategoryWiseDataLoad') }}";
        var clicked_node_start = $('#start_date').val();
        var clicked_node_end = $('#end_date').val();
        $.ajax({
            url: url,
            type: 'POST',
            data: { "source": source, "target": target,"_token":tok, "start_date":clicked_node_start, "end_date":clicked_node_end  },
            success: function (result)
            {
                if(result != '{{PermissionDenied()}}'){
                    $('#datalist_body').html(result);
                    DisableLoaderAndMakeVisibleInnerBody();
                } else {

                    DisableLoaderAndMakeVisibleInnerBody();

                    CloseOffcanvas('sankeyPatientsDetails');

                }
            },
                error: function(textStatus, errorThrown) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    CommonErrorModalPopupOpenOnRequest();
                    CloseOffcanvas('sankeyPatientsDetails');
                }
        });
    }
</script>
@endif
