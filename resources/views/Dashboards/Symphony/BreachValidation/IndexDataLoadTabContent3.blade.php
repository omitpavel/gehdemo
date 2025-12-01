<div class="row mb-3">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row g-2">
                <div class="col-xxl-9">
                    <div class="row gx-2">
                        <div class="col-xl-8">
                            <div class="row mb-2">
                                <div class="col-lg-8 col-md-8 pe-md-1 mb-2 mb-md-0">
                                    <div class="mb-2 month-select">
                                        <select class="form-select w-100 breach_validation_select_heigh_set" aria-label="Default select example" name="date_picker_tab_3" id="date_picker_tab_3">

                                            @if (count($success_array['month_filter_array']))
                                                @foreach ($success_array['month_filter_array'] as $key => $row)
                                                    <option value="{{ $row['filter_value'] }}" @if ($row['filter_value'] == $success_array['filter_value_selected']) selected @endif>
                                                        {{ $row['filter_text'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="block-conversion">
                                        <div class="rectangle-block-1 ">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="rectangle-block-2">
                                                        <div class="row gx-2 fs-12 align-items-center">
                                                            <div class="col-lg-3 col-md-3 offset-3 col-3 text-center ">
                                                                <p class="mb-0">
                                                                    Month
                                                                </p>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-3">
                                                                <p class="mb-0 lh-sm">
                                                                    Average Past <br> 3 Months
                                                                </p>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-3">
                                                                <p class="mb-0 lh-sm">
                                                                    Average Past <br> 12 Months
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 bottom-section">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <p class="mb-0">
                                                            Total Attendence</p>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <h6 class="fs-5 mb-0 fw-bold text-center">
                                                            {{ $success_array['attendence']['type_1_2_3'] }}</h6>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi {{ $success_array['attendence']['attendence_forcasted_arrow_count_first'] }} fs-3  text-danger me-2"></i>
                                                                <span class=" fs-5 fw-bold">{{ $success_array['attendence']['attendence_forcasted_count_first'] }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi {{ $success_array['attendence']['attendence_forcasted_arrow_count_second'] }} fs-3  text-danger me-2"></i>
                                                                <span class=" fs-5 fw-bold">{{ $success_array['attendence']['attendence_forcasted_count_second'] }}</span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mb-1 mt-1">
                                                <div class="row  align-items-center">
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <p class="mb-0">
                                                            Conversion <br>
                                                            Rate
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <h6 class="mb-0 fs-5 fw-bold text-center">
                                                            {{ $success_array['attendence']['coversion_rate'] }}%</h6>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi {{ $success_array['attendence']['attendence_forcasted_arrow_percentage_first'] }} fs-3 me-2"></i>
                                                                <span class="fs-5 fw-bold">{{ $success_array['attendence']['attendence_forcast_conversion_rate_first'] }}%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi {{ $success_array['attendence']['attendence_forcasted_arrow_percentage_second'] }} fs-3 me-2"></i>
                                                                <span class="fs-5  fw-bold">{{ $success_array['attendence']['attendence_forcast_conversion_rate_second'] }}%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 ps-md-1  text-center">
                                    <div class="rectangle-breach p-0">
                                        <div class="gauge-head pt-2">
                                            <p class="mb-1">PERFORMANCE</p>

                                            <input type="hidden" id="performance_percent_month" value="{{ $success_array['performance']['performance'] }}">
                                            <h4 class="fw-bold mb-0 "> {{ $success_array['performance']['performance'] }}%</h4>
                                        </div>
                                        <div class="performance-chart">
                                            <div class="progress-bg  {{ PerformanceShowGuageBorderColourSetting(round($success_array['performance']['performance'])) }}">
                                                <div class="bar-progress">
                                                    <div class="{{ PerformanceShowGuageColourSetting(round($success_array['performance']['performance'])) }}" style="width: {{ round($success_array['performance']['performance']) }}%">
                                                    </div>
                                                    <div class="bars-ash" style="width: {{ round(100 - $success_array['performance']['performance']) }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rectangle-block">
                                        <div class="d-flex justify-content-between pt-3">
                                            <h6 class="mb-0">Admitted</h6>
                                            <h6 class="fw-bold mb-0">{{ $success_array['performance']['admitted_perc'] }}
                                            </h6>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between d-flex justify-content-between text-nowrap ">
                                            <h6 class="mb-0">Non-Admitted
                                            </h6>
                                            <h6 class="fw-bold mb-0">{{ $success_array['performance']['non_admitted_perc'] }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rectangle-block-1 mb-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between rectangle-block-2">
                                            <p class="mb-0">Total Ambulance
                                                Arrival
                                            </p>
                                            <h6 class="mb-0 fw-header-500 fs-6">
                                                {{ $success_array['ambulance_arrival']['total'] }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-2 align-items-center">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row gx-2 align-items-center ambulance-details-leftside">
                                            <div class="col-md-2 col-2 text-center">
                                                <div class="icon-circle-bg ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 26.713 21.393">
                                                        <g id="ambulance-svgrepo-com" transform="translate(0)">
                                                            <path id="Path_20808" data-name="Path 20808" d="M49.244,239.907h7.4a.728.728,0,0,0,0-1.456h-7.4a.728.728,0,1,0,0,1.456Z" transform="translate(-33.187 -228.67)" fill="#fff" />
                                                            <path id="Path_20809" data-name="Path 20809" d="M332.3,344.578a3.2,3.2,0,1,0-3.2-3.2A3.208,3.208,0,0,0,332.3,344.578Zm0-4.953a1.749,1.749,0,1,1-1.749,1.749A1.751,1.751,0,0,1,332.3,339.624Z" transform="translate(-325.96 -323.185)" fill="#fff" />
                                                            <g id="Group_1922" data-name="Group 1922" transform="translate(0 1.858)">
                                                                <path id="Path_20810" data-name="Path 20810" d="M79.789,344.578a3.2,3.2,0,1,0-3.2-3.2A3.208,3.208,0,0,0,79.789,344.578Zm0-4.953a1.749,1.749,0,1,1-1.749,1.749A1.751,1.751,0,0,1,79.789,339.624Z" transform="translate(-60.277 -325.043)" fill="#fff" />
                                                                <path id="Path_20811" data-name="Path 20811" d="M5.906,129.011h2.8a1.951,1.951,0,0,0,1.949-1.949v-3.17a1.945,1.945,0,0,0-.673-1.474l-1.7-1.652-1.7-4.481-.016-.038A4.256,4.256,0,0,0,2.7,113.728L.73,113.722h0a.728.728,0,0,0,0,1.456l1.968.006a2.8,2.8,0,0,1,2.535,1.638l1.75,4.612a.729.729,0,0,0,.173.264l1.833,1.781.039.035a.492.492,0,0,1,.176.378v3.17a.494.494,0,0,1-.493.493h-2.8a.728.728,0,1,0,0,1.456Z"
                                                                    transform="translate(16.057 -112.307)" fill="#fff" />
                                                                <path id="Path_20812" data-name="Path 20812" d="M171.763,380.314h4.92a.728.728,0,0,0,0-1.456h-4.92a.728.728,0,1,0,0,1.456Z" transform="translate(-159.622 -363.61)" fill="#fff" />
                                                                <path id="Path_20813" data-name="Path 20813" d="M424.274,380.314h3.158a.728.728,0,0,0,0-1.456h-3.158a.728.728,0,0,0,0,1.456Z" transform="translate(-423.546 -363.61)" fill="#fff" />
                                                                <path id="Path_20814" data-name="Path 20814" d="M193.378,98.9a.728.728,0,0,0,.728-.728V89.333a1.285,1.285,0,0,1,1.283-1.283h11.183a1.285,1.285,0,0,1,1.283,1.283v8.691a.728.728,0,1,0,1.456,0V89.333a2.742,2.742,0,0,0-2.739-2.739H195.389a2.742,2.742,0,0,0-2.739,2.739V98.17A.728.728,0,0,0,193.378,98.9Z" transform="translate(-192.65 -86.594)" fill="#fff" />
                                                            </g>
                                                            <path id="Path_20816" data-name="Path 20816" d="M123.81,55.71h3.665a.728.728,0,0,0,.728-.728V53.54a2.56,2.56,0,0,0-5.121,0v1.441A.728.728,0,0,0,123.81,55.71Zm2.937-1.456h-2.208v-.713a1.1,1.1,0,1,1,2.209,0v.713Z" transform="translate(-107.912 -50.98)" fill="#fff" />
                                                            <path id="Path_20818" data-name="Path 20818"
                                                                d="M262.994,147.158h.933a1.8,1.8,0,0,0,1.8-1.8v-.7h.7a1.8,1.8,0,0,0,1.8-1.8v-.933a1.8,1.8,0,0,0-1.8-1.8h-.7v-.7a1.8,1.8,0,0,0-1.8-1.8h-.933a1.8,1.8,0,0,0-1.8,1.8v.7h-.7a1.8,1.8,0,0,0-1.8,1.8v.933a1.8,1.8,0,0,0,1.8,1.8h.7v.7A1.8,1.8,0,0,0,262.994,147.158Zm3.44-5.589a.347.347,0,0,1,.347.347v.933a.347.347,0,0,1-.347.347H265a.728.728,0,0,0-.728.728v1.432a.347.347,0,0,1-.347.347h-.933a.347.347,0,0,1-.347-.347v-1.432a.728.728,0,0,0-.728-.728h-1.433a.347.347,0,0,1-.347-.347v-.933a.347.347,0,0,1,.347-.347h1.433a.728.728,0,0,0,.728-.728v-1.432a.347.347,0,0,1,.347-.347h.933a.347.347,0,0,1,.347.347v1.432a.728.728,0,0,0,.728.728Z"
                                                                transform="translate(-255.02 -133.086)" fill="#fff" />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-10 text-md-center">
                                                <h6 class="mb-0">AMBULANCE
                                                </h6>
                                            </div>
                                            <div class="col-md-3 col-5 offset-2 offset-md-0 text-md-center">
                                                <p class="mb-0 fs-12 lh-sm">
                                                    Over 30 <br class="d-none d-xxl-block">
                                                    Mins
                                                </p>
                                                <h6 class="mb-0 fs-5 fw-bold pt-1"id="total_ambulance_value_over_30_minute_show">{{ $success_array['ambulance_arrival']['min_over_30'] }}
                                                </h6>
                                            </div>
                                            <div class="col-md-3 col-4 offset-1 offset-md-0 text-md-center">
                                                <p class="mb-0 fs-12 lh-sm">
                                                    Over 60 <br class="d-none d-xxl-block">
                                                    Mins
                                                </p>
                                                <h6 class="mb-0 fs-5 fw-bold pt-1"id="total_ambulance_value_over_60_minute_show">{{ $success_array['ambulance_arrival']['min_over_60'] }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row gx-2 align-items-center mb-2 mb-md-0 ambulance-details-rightside">
                                            <div class="col-md-2 col-2 text-center">
                                                <div class="icon-circle-bg position-relative">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 26.531 25.693">
                                                        <g id="home-svgrepo-com" transform="translate(0 -2.79)">
                                                            <path id="Path_20860" data-name="Path 20860" d="M40.722,42.474l-9-7.425a1.127,1.127,0,0,0-1.435,0l-9,7.425a1.127,1.127,0,0,0-.41.869v11.2A1.127,1.127,0,0,0,22,55.674H40a1.127,1.127,0,0,0,1.127-1.127v-11.2A1.125,1.125,0,0,0,40.722,42.474ZM32.2,53.42H29.812V47.179H32.2V53.42Zm6.682,0H34.45V46.052a1.127,1.127,0,0,0-1.127-1.127H28.684a1.127,1.127,0,0,0-1.127,1.127V53.42H23.13V43.875L31,37.379l7.874,6.5Z"
                                                                transform="translate(-17.737 -27.191)" fill="#fff" />
                                                            <path id="Path_20861" data-name="Path 20861"
                                                                d="M26.109,13.021C23.6,11.01,21.231,9.087,18.66,6.97c-.768-.69-1.575-1.343-2.356-1.975-.765-.619-1.555-1.259-2.285-1.915a1.127,1.127,0,0,0-1.508,0c-.73.656-1.52,1.3-2.285,1.915C9.446,5.627,8.639,6.28,7.871,6.97,5.3,9.087,2.934,11.01.423,13.021a1.127,1.127,0,0,0,1.409,1.759C4.357,12.758,6.738,10.825,9.323,8.7l.038-.032c.73-.656,1.52-1.3,2.285-1.915.535-.433,1.082-.876,1.62-1.334.538.458,1.086.9,1.62,1.334.765.619,1.555,1.259,2.285,1.915l.038.032c2.586,2.13,4.966,4.063,7.491,6.086a1.127,1.127,0,0,0,1.409-1.759Z"
                                                                transform="translate(0)" fill="#fff" />
                                                        </g>
                                                    </svg>
                                                    <div class="vertical-line-left">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-4 text-md-center">
                                                <div class="position-relative ">
                                                    <p class="mb-0">HOME</p>
                                                    <h6 class="mb-0  fw-bold">
                                                        {{ $success_array['ambulance_arrival']['home_count'] }} ({{ $success_array['ambulance_arrival']['home_perc'] }} %)
                                                    </h6>

                                                    <div class="vertical-line-right">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-2 text-center">
                                                <div class="icon-circle-bg ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 30.066 26.764">
                                                        <path id="hospital-bed-svgrepo-com"
                                                            d="M27.59,31.515h1.476a1,1,0,0,0,1-1v-3.3a1,1,0,0,0-1-1H4.477v-7.9H6.684a2.05,2.05,0,0,0-.906,1.7V22.86a2.053,2.053,0,0,0,2.051,2.051h1.2a2.053,2.053,0,0,0,2.051-2.051V20.009A2.053,2.053,0,0,0,9.03,17.958h-1.2a2.052,2.052,0,0,0-.316.027,1,1,0,0,0-.735-1.678h-3.3a1,1,0,0,0-1,1v8.9H1a1,1,0,0,0-1,1v3.3a1,1,0,0,0,1,1H2.476v6.45a2.651,2.651,0,1,0,2,0V35.882l4.367-4.367H21.222l4.367,4.367v2.083a2.651,2.651,0,1,0,2,0v-6.45ZM7.779,20.009a.05.05,0,0,1,.05-.05h1.2a.05.05,0,0,1,.05.05v2.852a.05.05,0,0,1-.05.05h-1.2a.05.05,0,0,1-.05-.05ZM3.477,41.07a.65.65,0,1,1,.65-.65A.651.651,0,0,1,3.477,41.07Zm1-8.019V31.515H6.014ZM26.589,41.07a.65.65,0,1,1,.65-.65A.651.651,0,0,1,26.589,41.07Zm-1-8.019-1.537-1.537h1.537Zm2.476-3.538H2v-1.3H28.065Z"
                                                            transform="translate(0 -16.307)" fill="#fff" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-4 text-md-center">
                                                <p class="mb-0">ADMITTED</p>
                                                <h6 class="mb-0 fw-bold">
                                                    {{ $success_array['ambulance_arrival']['admitted_count'] }}
                                                    ({{ $success_array['ambulance_arrival']['admitted_perc'] }}
                                                    %)
                                                </h6>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="rectangle-block-1 mb-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between rectangle-block-2">
                                            <p class="mb-0 fw-header-500">
                                                Breaches</p>
                                            <h6 class="mb-0 fw-header-500 fs-5">
                                                {{ $success_array['breach_data']['total'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-2 align-items-center breach-count-section">
                                    <div class="col-2 text-center">
                                        <div class="icon-circle-bg me-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 32.106 20.725">
                                                <g id="ambulance-svgrepo-com_1_" data-name="ambulance-svgrepo-com (1)" transform="translate(0 0)">
                                                    <path id="Path_20831" data-name="Path 20831"
                                                        d="M31.59,15.836l-3.157-4.013a2.406,2.406,0,0,0-1.891-.92H23.488V9.5A2.408,2.408,0,0,0,21.08,7.09H2.408A2.408,2.408,0,0,0,0,9.5v14.07a2.4,2.4,0,0,0,2.121,2.378,3.781,3.781,0,0,0,6.506.03H23.479a3.782,3.782,0,0,0,6.507-.03,2.4,2.4,0,0,0,2.12-2.378V17.324A2.408,2.408,0,0,0,31.59,15.836ZM5.371,25.4A1.393,1.393,0,1,1,6.765,24,1.393,1.393,0,0,1,5.371,25.4Zm11.313-8.811a1.2,1.2,0,0,1-1.2,1.2h-1.82V19.61a1.2,1.2,0,0,1-1.2,1.2H11.034a1.2,1.2,0,0,1-1.2-1.2V17.788H8.01a1.2,1.2,0,0,1-1.2-1.2V15.163a1.2,1.2,0,0,1,1.2-1.2H9.83v-1.82a1.254,1.254,0,0,1,.023-.234,1.2,1.2,0,0,1,1.181-.97h1.421a1.2,1.2,0,0,1,1.181.97,1.19,1.19,0,0,1,.023.234v1.82h1.82a1.2,1.2,0,0,1,1.2,1.2ZM26.726,25.4A1.393,1.393,0,1,1,28.12,24,1.392,1.392,0,0,1,26.726,25.4ZM29.7,18.44H23.491V13.311h3.053L29.7,17.324l0,1.116Z"
                                                        transform="translate(0 -7.09)" fill="#fff" />
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="position-relative">
                                            <h6>Ambulance</h6>
                                            <h5 class="fw-bold ">{{ $success_array['breach_data']['ambulance']['breach_count'] }} ({{ $success_array['breach_data']['ambulance']['breach_perc'] }}%)
                                            </h5>
                                            <div class="vertical-line-right" style="top: 7px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 text-center">
                                        <div class="icon-circle-bg me-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" id="users-svgrepo-com" width="22" height="22" viewBox="0 0 28.799 26.398">
                                                <path id="Path_20832" data-name="Path 20832"
                                                    d="M33.686,23.086,29.1,20.793a1.263,1.263,0,0,1-.7-1.135V18.035c.11-.134.226-.288.345-.456A10.984,10.984,0,0,0,30.163,14.8a1.9,1.9,0,0,0,1.117-1.736V11.14a1.914,1.914,0,0,0-.48-1.26V7.327a4.3,4.3,0,0,0-1-3.132C28.81,3.07,27.21,2.5,25.04,2.5s-3.77.57-4.756,1.694a4.3,4.3,0,0,0-1,3.132V9.879a1.914,1.914,0,0,0-.48,1.26v1.92a1.909,1.909,0,0,0,.719,1.492A10.073,10.073,0,0,0,21.2,18.025v1.588a1.268,1.268,0,0,1-.661,1.114l-4.282,2.336A4.327,4.327,0,0,0,14,26.863V28.9H36.08V26.958A4.308,4.308,0,0,0,33.686,23.086Z"
                                                    transform="translate(-7.281 -2.5)" fill="#fff" />
                                                <path id="Path_20833" data-name="Path 20833"
                                                    d="M8.631,26.071l4.282-2.336a.55.55,0,0,0,.286-.482V21.9a10.837,10.837,0,0,1-1.6-3.317,2.619,2.619,0,0,1-.8-1.887V14.78a2.622,2.622,0,0,1,.48-1.508V11a5.007,5.007,0,0,1,.046-1.15A6.667,6.667,0,0,0,9.119,9.5c-4.986,0-5.277,4.25-5.28,4.32v2.2a1.671,1.671,0,0,0-.48,1.118v1.658a1.713,1.713,0,0,0,.629,1.327,7.356,7.356,0,0,0,1.749,3.017v1.317a1.043,1.043,0,0,1-.562.919l-3.193,2A3.8,3.8,0,0,0,0,30.716v1.822H6V30.5A5.048,5.048,0,0,1,8.631,26.071Z"
                                                    transform="translate(0 -6.14)" fill="#fff" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <h6>Walk In</h6>
                                        <h5 class="fw-bold ">{{ $success_array['breach_data']['walk_in']['breach_count'] }} ({{ $success_array['breach_data']['walk_in']['breach_perc'] }}%)
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="rectangle-block-1 mb-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between rectangle-block-2">
                                            <p class="mb-0 fw-header-500">
                                                Breach Reason
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <div class="row">
                                            <div class="breach-reason-section">
                                                <table class="table-breach">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                Breach</th>
                                                            <th class="text-center">
                                                                Total </th>
                                                            <th class="text-center">
                                                                Admitted
                                                            </th>
                                                            <th class="text-center">
                                                                Discharge
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($success_array['breach_reason']) > 0)
                                                            @foreach ($success_array['breach_reason'] as $row)
                                                                <tr class="@if ($loop->even) bg-white @else bg-grey @endif">
                                                                    <td>{{ $row['breach_name'] }}</td>
                                                                    <td class="text-center" width='13%'>{{ $row['total_count'] }}</td>
                                                                    <td class="text-center" width='18%'>{{ $row['admitted_count'] }}</td>
                                                                    <td class="text-center" width='20%'>{{ $row['discharged_count'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr class="row-no-data">
                                                                <td colspan="4" class="cell-no-data">
                                                                    <span>{{ NotFoundMessage() }}</span>
                                                                </td>
                                                            </tr>
                                                        @endif

                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rectangle-block-1">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between rectangle-block-2">
                                    <p class="mb-0">Performance By Specialty</p>
                                </div>
                            </div>
                        </div>
                        <div class="row referral-charts" id="seven-col-row">

                                @foreach ($success_array['performance_by_speciality'] as $key => $row)
                                    <div class="@if ($loop->first) col pe-lg-0 border-breach-end @elseif($loop->last) col ps-lg-0 border-breach-end @else col ps-lg-0 pe-lg-0 border-breach-end @endif ">
                                        <div class="">
                                            <div class="header-charts">
                                                <h6 class="mb-0">
                                                    {{ $row['name'] }}
                                                </h6>
                                            </div>
                                            <div class="breach-weekly-chart{{ $loop->iteration }}">
                                                <div id="gehBreachChartMonth{{ $loop->iteration }}"></div>
                                            </div>

                                            <div class="medical-data">
                                                <h6>Performance</h6>
                                                <h6 class="fw-normal">{{ $row['attendance'] }} Referrals
                                                    <br> {{ $row['admitted'] }} Admitted ({{ $row['admitted_perc'] }}%)
                                                    <br> {{ $row['breached'] }} Breached ({{ $row['breached_perc'] }}%)
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                        </div>
                    </div>
                </div>
                <div class="col-xxl-3">
                    <div class="row">
                        <div class="col-lg-12 ">


                            <div class="rectangle-block-1 mb-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between align-items-center rectangle-block-2">
                                            <p class="mb-0 fw-header-500">
                                                All
                                                Attendances</p>
                                            <h6 class="fw-header-500 fs-5 mb-0">
                                                {{ array_sum(array_column($success_array['all_attendence'], 'attendence_count')) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <div class="row">
                                            <div class="attendance-section">
                                                <table class="table-breach">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>0-4 <br class="d-none d-xxl-block">
                                                                Hrs</th>
                                                            <th>4-8 <br class="d-none d-xxl-block">Hrs
                                                            </th>
                                                            <th>8-12 <br class="d-none d-xxl-block">Hrs
                                                            </th>
                                                            <th>12-24 <br class="d-none d-xxl-block">Hrs
                                                            </th>
                                                            <th>24+ <br class="d-none d-xxl-block">Hrs
                                                            </th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($success_array['all_attendence']) > 0)
                                                            @foreach ($success_array['all_attendence'] as $key => $row)
                                                                <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-grey' }}">
                                                                    <td class="">
                                                                        {{ $row['name_show_text'] }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $success_array['all_attendence_hour'][$key . '_zero_to_four'] }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $success_array['all_attendence_hour'][$key . '_four_to_eight'] }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $success_array['all_attendence_hour'][$key . '_eight_to_twelve'] }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $success_array['all_attendence_hour'][$key . '_twelve_to_twenty_four'] }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $success_array['all_attendence_hour'][$key . '_twenty_four_plus'] }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $row['attendence_count'] }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr class="row-no-data">
                                                                <td class="cell-no-data" colspan="4">{{ NotFoundMessage() }}</td>
                                                            </tr>
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rectangle-block-1 mb-2">
                                <div class="row ">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between rectangle-block-2">
                                            <p class="mb-0 fw-header-500">
                                                Past 6 Months
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <div class="row">
                                            <div class="past-seven-days-section">
                                                <table class="table-breach">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                Date</th>
                                                            <th class="text-center">
                                                                Attendance </th>
                                                            <th class="text-center">
                                                                Breaches
                                                            </th>
                                                            <th class="text-center">
                                                                Performance
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @if (count($success_array['past_seven_months']) > 0)
                                                            @foreach ($success_array['past_seven_months'] as $row)
                                                                <tr class="@if ($loop->even) bg-white @else bg-grey @endif">
                                                                    <td>{{ $row['date_val'] }}</td>
                                                                    <td class="text-center">{{ $row['type_1_2_3'] }}</td>
                                                                    <td class="text-center">{{ $row['breaches'] }}</td>
                                                                    <td class="text-center">{{ number_format($row['performance'],2) }}%</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr class="">
                                                                <td colspan="4" class='text-center make-rounded-corners-of-messages'>{{ NotFoundMessage() }}</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rectangle-block-1 mb-2">
                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <div class="row">
                                            <div class="details-section-table">
                                                <table class="table-breach-sp">
                                                    <thead>
                                                        <tr class="pb-4">
                                                            <th class=""></th>
                                                            <th class="text-center">{{ $success_array['ed_attendance_summary_show'][0]['quater'] }}</th>
                                                            <th class="text-center">{{ $success_array['ed_attendance_summary_show'][0]['year'] }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr class="bg-white">
                                                            <td class="">Performance</td>
                                                            <td class="text-center ">{{ $success_array['ed_attendance_summary_show'][1]['quater'] }}%</td>
                                                            <td class="text-center ">{{ $success_array['ed_attendance_summary_show'][1]['year'] }}%</td>
                                                        </tr>
                                                        <tr class="bg-grey">
                                                            <td class="">Breaches</td>
                                                            <td class="text-center">{{ $success_array['ed_attendance_summary_show'][2]['quater'] }}</td>
                                                            <td class="text-center">{{ $success_array['ed_attendance_summary_show'][2]['year'] }}</td>
                                                        </tr>
                                                        <tr class="bg-white">
                                                            <td class="">Attendance</td>
                                                            <td class="text-center">{{ $success_array['ed_attendance_summary_show'][3]['quater'] }}</td>
                                                            <td class="text-center">{{ $success_array['ed_attendance_summary_show'][3]['year'] }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.circle_progress_chart_easy_pie').easyPieChart({
            size: 120,
            barColor: "#17d3e6",
            scaleLength: 0,
            lineWidth: 20,
            trackColor: "#373737",
            lineCap: "circle",
            animate: 2000,
        });
    });
</script>
<script>
    var ane_performance_data = [20, 60, 80, 100];
    var ane_performance_value = <?php echo $success_array['performance']['performance_graph']; ?>;
    var guage_colour_codes = ['#000000', '#FF0000', '#FC8432', '#008000'];
</script>
<script src="{{ asset('asset_v2/Ibox/Js/GaugeChart.js') }}"></script>


@foreach ($success_array['performance_by_speciality'] as $key => $row)
    <script>
        // Breach Dashboard chart-1
        var options = {
            series: [{{ $row['graph_perc'] }}],
            chart: {
                height: 160,
                type: 'radialBar',
                fontFamily: 'Poppins, sans-serif',
            },
            plotOptions: {
                radialBar: {
                    track: {
                        background: '#C8E0F8',
                    },
                    hollow: {
                        size: '40%',
                    },
                    dataLabels: {
                        show: true,
                        value: {
                            formatter: function(val) {
                                return parseInt(val) + "%";
                            },
                            color: '#000',
                            fontSize: '14px',
                            fontWeight: 'bold',
                            show: true,
                            offsetY: -12,
                        }
                    }
                },
            },
            colors: ['#0066FF', '#C8E0F8'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#0066FF', '#8CA5BC'],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            labels: [''],
        };
        if (document.querySelector("#gehBreachChartMonth{{ $loop->iteration }}")) {
            if (chartMonth{{ $loop->iteration }}) {
                chartMonth{{ $loop->iteration }}.destroy();
            }
            var chartMonth{{ $loop->iteration }} = new ApexCharts(document.querySelector("#gehBreachChartMonth{{ $loop->iteration }}"), options);
            chartMonth{{ $loop->iteration }}.render();
        }
    </script>
@endforeach
