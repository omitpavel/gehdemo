<input type="hidden" id="task_category" value="2">
<input type="hidden" id="filtered_task_id" value="">
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">

            <div class="sticky-toprow" id="stickyToprow">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_today_dashboard_view') }}">
                        <a class="tab-custom-btn  {{ DisabledButtonOnRolePermission('pd_dashboard_today_dashboard_view') }}"
                            onclick="DischargeDay('today');" data-bs-toggle="tab" href="#dischargeToday">
                            <div class="tab-active">D/P Discharge Today
                            </div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_tomorrow_dashboard_view') }}">
                        <a class="tab-custom-btn  {{ DisabledButtonOnRolePermission('pd_dashboard_tomorrow_dashboard_view') }}"
                            data-bs-toggle="tab" href="#dischargeTomorrow" onclick="DischargeDay('tomorrow');">
                            <div class="tab-active">D/P Discharge {{ $success_array['tomorrow'] }}</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_day_after_tomorrow_dashboard_view') }}">
                        <a class="tab-custom-btn  {{ DisabledButtonOnRolePermission('pd_dashboard_day_after_tomorrow_dashboard_view') }}"
                            data-bs-toggle="tab" href="#dischargeDayAfterTomorrow"
                            onclick="DischargeDay('day_after_tomorrow');">
                            <div class="tab-active">D/P Discharge {{ $success_array['day_after_tommrow'] }}</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_missed_discharged_view') }}">
                        <a class="tab-custom-btn active {{ DisabledButtonOnRolePermission('pd_dashboard_missed_discharged_view') }}"
                            data-bs-toggle="tab" href="#dischargeDayAfterTomorrow" onclick="MissedDischarged('1', '0');">
                            <div class="tab-active">Failed Discharges</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_missed_discharges_performance_view') }}">
                        <a class="tab-custom-btn  {{ DisabledButtonOnRolePermission('pd_dashboard_missed_discharges_performance_view') }}" data-bs-toggle="tab" href="#dischargeDayAfterTomorrow" onclick="FailedDischargesPerformance('{{ date('Y-m-d', strtotime('-1 day')) }}', '{{ date('Y-m-d', strtotime('-1 day')) }}', 1, 1);">
                            <div class="tab-active">Failed Discharges Performances</div>
                        </a>
                    </li>
                </ul>
                <div class="row g-2 mb-2 pd-top-row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card-date">
                            <div class="card-body">
                                <div class="d-flex align-items-center" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Select Confirmed Discharge Date">
                                    <div class="cyan-circle text-center me-2">
                                        <i class="bi bi-calendar3 "></i>
                                    </div>
                                    <div class="date-box w-90">
                                        @php
                                            use Carbon\Carbon;
                                            $selectedDate = request()->filled('date')
                                                ? request()->date
                                                : Carbon::yesterday()->format('Y-m-d');
                                        @endphp

                                        <input type="hidden" value="{{ $selectedDate }}"
                                            class="start_date_day_summary_val" id="start_date_day_summary_val">

                                        <input type="text" name="datepicker" id="start_date_day_summary"
                                            placeholder="{{ PredefinedYearFormat($selectedDate) }}"
                                            class="hasDatepicker" readonly>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <select class="3col active" multiple="multiple" aria-label="Default select example"
                            id="ward_id_missed">
                            <optgroup label="Medical Wards">
                                @foreach ($success_array['medical_wards'] as $ward)
                                    <option value="{{ $ward['id'] }}"
                                        @if (request()->filled('ward_id_missed') && in_array($ward['id'], request()->ward_id_missed)) selected @endif>
                                        {{ $ward['ward_name'] }}</option>
                                @endforeach

                            </optgroup>
                            <optgroup label="Surgical Wards">
                                @foreach ($success_array['surgical_wards'] as $ward)
                                    <option
                                        value="{{ $ward['id'] }}"@if (request()->filled('ward_id_missed') && in_array($ward['id'], request()->ward_id_missed)) selected @endif>
                                        {{ $ward['ward_name'] }}</option>
                                @endforeach

                            </optgroup>
                            <optgroup label="Others Wards">
                                @foreach ($success_array['other_wards'] as $ward)
                                    <option value="{{ $ward['id'] }}"
                                        @if (request()->filled('ward_id_missed') && in_array($ward['id'], request()->ward_id_missed)) selected @endif>
                                        {{ $ward['ward_name'] }}</option>
                                @endforeach

                            </optgroup>

                        </select>
                    </div>


                    <div class="col-xl-3 col-md-6">
                        <div class="failed-tab-dp-btns" id="pdDischargeSection">
                            <button id="definiteButton" type="button"
                                class="btn btn-primary-grey me-2 discharge_type_definite_button {{ request()->definite == 1 ? 'active' : '' }}"
                                data-type="2"><span class="btn-name">Definite</span> <h5>{{ $success_array['total_definite'] }}</h5> </button>
                            <button id="potentialButton" type="button"
                                class="btn btn-primary-grey discharge_type_potential_button {{ request()->potential == 1 ? 'active' : '' }}"
                                data-type="1"><span class="btn-name">Potential</span> <h5>{{ $success_array['total_potential'] }}</h5></button>
                        </div>
                    </div>

                    <!-- Total Patients Right Side -->
                    <div class="col-xl-2 col-md-4">
                        <div class="bg-patients-count">
                            <h6>Total Patients</h6>
                            <h5>{{ count($success_array['total_patients']) }}</h5>
                        </div>
                    </div>
                    <div class="col-xl-1 col-md-2">
                        <button type="button" class="btn btn-export w-100" onclick="window.open('{{ $success_array['export_url'] }}', '_blank')">
                            <img src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt="" class="me-2" width="15">Export
                        </button>
                    </div>
                </div>
            </div>


            <div class="tab-content" id="tabcontent">
                <div id="dischargeToday" class=" tab-pane active">
                    <div class="failed-discharged-patients">

                        @forelse ($success_array['patient_details'] as $ward => $patients)
                            <div class="card-failed-discharged-patients mb-lg-2">
                                <div class="name-header">
                                    <span>{{ $ward }}</span>
                                </div>
                                <table class="responsiveTable table-failed-discharged-patients">
                                    <thead>
                                        <tr class="position-relative">
                                            <th>Bed</th>
                                            <th>Name</th>
                                            <th>PAS Number</th>
                                            <th>Flagged Date</th>
                                            <th>Discharged Date</th>
                                            <th>Failed Reason</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patients as $patient)
                                            <tr>
                                                <td class="pivoted">
                                                    <div class="tdBefore">Bed</div>
                                                    {{ $patient['bed'] }}
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore">Name</div>
                                                    {{ $patient['name'] }}
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore">PAS Number</div>
                                                    {{ $patient['pas_number'] }}
                                                </td>

                                                <td class="pivoted">
                                                    <div class="tdBefore">Flagged Date
                                                    </div>
                                                    @if ($patient['type'] == 1)
                                                        Potential
                                                    @else
                                                        Definite
                                                    @endif -
                                                    {{ PredefinedYearFormat($patient['potential_definite_date']) }}
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore">Discharge Date</div>
                                                    {{ !empty($patient['discharge_date']) ? PredefinedYearFormat($patient['discharge_date']) : '--' }}
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore">Failed Reason
                                                    </div>
                                                    <span
                                                        class="missed_reason_{{ $patient['patient_id'] }}">@if(isset($patient['missed_reason']['reason_type'])) {{ $patient['missed_reason']['reason_type'] }} - {{ $patient['missed_reason']['reason_text'] }} @endif</span>
                                                </td>

                                                <td
                                                    class="pivoted {{ PermissionDeniedDiv('pd_dashboard_missed_discharged_update') }}">
                                                    <div class="tdBefore">Action</div>
                                                    <button
                                                        class="btn btn-primary-grey {{ DisabledButtonOnRolePermission('pd_dashboard_missed_discharged_update') }} click_add_reason"
                                                        data-patient-id="{{ $patient['patient_id'] }}"
                                                        class="btn btn-primary-grey">{{ !empty($patient['missed_reason']) ? 'Update Reason' : 'Add Reason' }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        @empty
                            <div class="wards-patients-details">
                                <div class="custom_not_found">
                                    {{ NotFoundMessage() }}
                                </div>
                            </div>
                        @endforelse

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var windowWidth = window.innerWidth;
    var bgSticky = document.querySelector('.bg-sticky');
    var noRecords = document.querySelector('.custom_not_found');
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            var bgSticky = document.querySelector('.bg-sticky');
            bgSticky.style.top = '150px';
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function(header) {
                header.style.top = '195px';
            })
        } else {
            if (document.getElementById("stickyToprow")) {
                var noRecords = document.querySelector('.custom_not_found');
                if (noRecords) {
                    if (bgSticky) {
                        bgSticky.style.top = '120px';
                    }
                    noRecords.style.marginTop = '13px';
                }
            }
        }


    }
</script>
<script>
    var windowWidth = window.innerWidth;
    $("#hideRow").show();
    $("#hideBgSticky").addClass("bg-sticky");
</script>

<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
<script>
    $(function() {

        var start = '{{ request()->date }}' ? moment('{{ request()->date }}') : null;



        function MissedDischarged() {
            var url = "{{ route('pd.missed') }}";
            $('.page-data-loader').show();
            var ward_id_missed = $('#ward_id_missed').val();
            var date = $('#start_date_day_summary_val').val() ||
                '{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}';

            var definite_type = $('.discharge_type_definite_button').hasClass('active') ? 1 : 0;
            var potential_type = $('.discharge_type_potential_button').hasClass('active') ? 1 : 0;
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "ward_id_missed": ward_id_missed,
                    "definite": definite_type,
                    "potential": potential_type,
                    "date": date
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('#contentSection_data').html(result);
                        $('#contentSection_data').show();
                        MultiSelectJs('ward_id_missed', 'Ward');
                        $('.page-data-loader').hide();

                    } else {
                        $('.page-data-loader').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }

                }
            });
        }

        function cb(start) {
            $('#start_date_day_summary_val').val(start.format('YYYY-MM-DD'));
            $('#start_date_day_summary').val(start.format('ddd MMMM D, YYYY'));


            if (start.format('YYYY-MM-DD') != '{{ request()->date }}') {
                MissedDischarged();
            }
        }
        $('#start_date_day_summary').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            maxDate: moment(),
            startDate: start || moment(),
            locale: {
                format: 'ddd MMMM D, YYYY'
            }
        }, cb);

        if (!start) {
            $('#start_date_day_summary').val('Select Date');
        }

    });
</script>
