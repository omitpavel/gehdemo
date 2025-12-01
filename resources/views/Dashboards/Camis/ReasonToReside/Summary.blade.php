<input type="hidden" id="task_category" value="2">
<input type="hidden" id="filtered_task_id" value="">
<input type="hidden" id="tab_type" value="{{ $success_array['tab_type'] }}">


<div class="col-lg-12">
    <div class="row  ">
        <div class="col-lg-12" id="custom-tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2 {{ PermissionDeniedDiv('r_to_r_view_summery_dashboard_view') }}">
                    <a class="tab-custom-btn {{ $success_array['tab_type'] != 'patient_list' ? 'active' : '' }} {{ DisabledButtonOnRolePermission('r_to_r_view_summery_dashboard_view') }}"
                        id="reason_summary" data-value="reason_summary" onclick="ReasonToResideTab('summery',this.id);"
                        data-bs-toggle="tab" href="#summary">
                        <div class="tab-active">Summary
                        </div>
                    </a>
                </li>
                <li class="mb-2 {{ PermissionDeniedDiv('r_to_r_view_summery_dashboard_view') }}">
                    <a class="tab-custom-btn {{ $success_array['tab_type'] == 'patient_list' ? 'active' : '' }}  {{ DisabledButtonOnRolePermission('r_to_r_view_summery_dashboard_view') }}"
                        id="reason_patients_list" data-value="reason_patients_list"
                        onclick="ReasonToResideTab('patient_list',this.id);" data-bs-toggle="tab" href="#patientList">
                        <div class="tab-active">Patient List</div>
                    </a>
                </li>
            </ul>



            <div class="tab-content" id="tabcontent">
                <input type="hidden" value="{{ $success_array['tab_type'] }}" id="tab_type">
                @if (CheckSpecificPermission('r_to_r_view_summery_dashboard_view'))
                    <div id="summary" class=" tab-pane "
                        @if ($success_array['tab_type'] != 'patient_list') style="display: block;" @else style="display: none;" @endif>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-lg-12">
                                    <div class="row top-carts-section">
                                        <div class="col-12 mb-2">
                                            <div class="card-reason-reside">
                                                <h5 class="mb-2">Reason to Reside - Live</h5>
                                                <div class="border-bottom mb-2"></div>
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-md-4">
                                                        <div class="card-live-status live-bg-blue">
                                                            <h6>Function</h6>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h3>{{ $success_array['live_percentages']['Function'] }}%
                                                                </h3>
                                                                <img src="{{ asset('asset_v2/Template/icons/settings.svg') }}"
                                                                    alt="" width="30">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-md-4">
                                                        <div class="card-live-status live-bg-teal">
                                                            <h6>Physiology</h6>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h3>{{ $success_array['live_percentages']['Physiology'] }}%
                                                                </h3>
                                                                <img src="{{ asset('asset_v2/Template/icons/health.svg') }}"
                                                                    alt="" width="30">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-md-4">
                                                        <div class="card-live-status live-bg-black">
                                                            <h6>Recovery</h6>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h3>{{ $success_array['live_percentages']['Recovery'] }}%
                                                                </h3>
                                                                <img src="{{ asset('asset_v2/Template/icons/recovery.svg') }}"
                                                                    alt="" width="30">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-md-4">
                                                        <div class="card-live-status live-bg-purple">
                                                            <h6>Treatment</h6>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h3>{{ $success_array['live_percentages']['Treatment'] }}%
                                                                </h3>
                                                                <img src="{{ asset('asset_v2/Template/icons/hospital.svg') }}"
                                                                    alt="" width="30">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-md-4">
                                                        <div class="card-live-status live-bg-maroon">
                                                            <h6>Primary Reason - Criteria To Reside</h6>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h3>{{ $success_array['live_percentages']['Primary_Reason_-_Criteria_to_Reside'] }}%
                                                                </h3>
                                                                <img src="{{ asset('asset_v2/Template/icons/primary-reason.svg') }}"
                                                                    alt="" width="30">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-md-4">
                                                        <div class="card-live-status live-bg-ash">
                                                            <h6>Rehabilitation, Reablement and Recovery
                                                                Stage</h6>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h3>{{ $success_array['live_percentages']['Rehabilitation._Reablement_And_Recovery_Stage'] }}%
                                                                </h3>
                                                                <img src="{{ asset('asset_v2/Template/icons/rehabilitation.svg') }}"
                                                                    alt="" width="30">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-12 mb-2">
                                            <div class="card-reason-reside">
                                                <h6 class="mb-2">Ward Summary - Live</h6>
                                                <div class="border-bottom"></div>
                                                <div class="col-md-12" style="padding: 10px 0 0 0">
                                                    <div class="padding-zero" id="reason-ward-chart"></div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="card-reason-reside">
                                                <h6 class="mb-2">Last 30 Days Summary</h6>
                                                <div class="border-bottom"></div>
                                                <div class="padding-zero" id="reason-reside-chart"></div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>
</div>

<script src="{{ asset('asset_v2/Generic/Js/billboard.js') }}"></script>
<script>
    function prettyLabel(arr) {
        arr[0] = arr[0].replace(/\./g, ', ').replace(/_/g, ' ');

        arr[0] = arr[0].replace(/\b\w/g, c => c.toUpperCase());
        return arr;
    }

    function getWardLabel(shortName) {
        var wards_array = {!! json_encode($success_array['wards_array']) !!};
        return wards_array[shortName] ?? "--";
    }
</script>
<script>
    // ---------- WARD SUMMARY (BY WARD) ----------
    var ward_dates = {!! json_encode($success_array['all_wards_shortname']) !!};

    var ward_function = {!! json_encode($success_array['function_count_wardwise']) !!};
    var ward_physiology = {!! json_encode($success_array['physiology_count_wardwise']) !!};
    var ward_recovery = {!! json_encode($success_array['recovery_count_wardwise']) !!};
    var ward_treatment = {!! json_encode($success_array['treatment_count_wardwise']) !!};
    var ward_Primary_Reason_Criteria_to_Reside_count_wardwise =
        prettyLabel({!! json_encode($success_array['Primary_Reason_-_Criteria_to_Reside_count_wardwise']) !!});
    var ward_rehab =
        prettyLabel({!! json_encode($success_array['rehabilation_reason_count_wardwise_count_wardwise']) !!});

    // Use the actual series names from the data as the grouped names
    var wardGroupNames = [
        ward_function[0],
        ward_physiology[0],
        ward_recovery[0],
        ward_treatment[0],
        ward_Primary_Reason_Criteria_to_Reside_count_wardwise[0],
        ward_rehab[0]
    ];

    var chartWard = bb.generate({
        bindto: '#reason-ward-chart',
        data: {
            x: 'x',
            columns: [
                ward_dates,
                ward_function,
                ward_physiology,
                ward_recovery,
                ward_treatment,
                ward_Primary_Reason_Criteria_to_Reside_count_wardwise,
                ward_rehab
            ],
            type: 'bar',
            groups: [
                wardGroupNames // all 6 series on the same stacked bar
            ]
        },
        axis: {
            x: {
                type: 'category',
                tick: {
                    rotate: 75,
                    multiline: false,
                    format: function(index) {
                        let shortName = ward_dates[index + 1] ?? null;
                        return getWardLabel(shortName) ?? "--";
                    }
                }
            }
        },
        size: {
            height: 500
        },
        legend: {
            show: true,
            position: 'inset',
            inset: {
                anchor: 'top-right'
            }
        }
    });
</script>

<script>
    // ---------- SUMMARY (BY DATE) ----------
    var dates = {!! json_encode($success_array['all_dates']) !!};
    var physology = {!! json_encode($success_array['physiology_count_datewise']) !!};
    var recovery = {!! json_encode($success_array['recovery_count_datewise']) !!};
    var treatment = {!! json_encode($success_array['treatment_count_datewise']) !!};
    var functions = {!! json_encode($success_array['function_count_datewise']) !!};
    var Primary_Reason_Criteria_to_Reside =
        prettyLabel({!! json_encode($success_array['Primary_Reason_-_Criteria_to_Reside_count_datewise']) !!});
    var rehab_count =
        prettyLabel({!! json_encode($success_array['rehabilation_count_datewise']) !!});

    // Again, take the series names from the data itself
    var dateGroupNames = [
        functions[0],
        physology[0],
        recovery[0],
        treatment[0],
        Primary_Reason_Criteria_to_Reside[0],
        rehab_count[0]
    ];

    var chartDate = bb.generate({
        bindto: '#reason-reside-chart',
        data: {
            x: 'x',
            columns: [
                dates,
                functions,
                physology,
                recovery,
                treatment,
                Primary_Reason_Criteria_to_Reside,
                rehab_count
            ],
            type: 'bar',
            groups: [
                dateGroupNames // all 6 series on the same stacked bar
            ]
        },
        axis: {
            x: {
                type: 'category',
                tick: {
                    rotate: 75,
                    multiline: false
                }
            }
        },
        size: {
            height: 300
        },
        legend: {
            show: true,
            position: 'inset',
            inset: {
                anchor: 'top-right'
            }
        }
    });
</script>
