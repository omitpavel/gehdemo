<div class="col-lg-12">
    <div class="side-room-filters" id="sideroomFilters">
        <div class="row row-cols-xl-5 row-cols-md-3 row-cols-1 gx-2">
            <div class="col mb-2">
                <div class="">



                    <select class="3col active" multiple="multiple" aria-label="Default select example" id="ward_id">
                        <optgroup label="Medical Wards">
                            @foreach ($medical_wards as $ward)
                                <option value="{{ $ward['id'] }}" @if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                                    {{ $ward['ward_name'] }}</option>
                            @endforeach

                        </optgroup>
                        <optgroup label="Surgical Wards">
                            @foreach ($surgical_wards as $ward)
                                <option value="{{ $ward['id'] }}"@if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                                    {{ $ward['ward_name'] }}</option>
                            @endforeach

                        </optgroup>
                        <optgroup label="Womens & Childrens Wards">
                            @foreach ($womens_wards as $ward)
                                <option value="{{ $ward['id'] }}"@if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                                    {{ $ward['ward_name'] }}</option>
                            @endforeach

                        </optgroup>
                        <optgroup label="Others Wards">
                            @foreach ($other_wards as $ward)
                                <option value="{{ $ward['id'] }}" @if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                                    {{ $ward['ward_name'] }}</option>
                            @endforeach

                        </optgroup>

                    </select>


                </div>
            </div>
            <div class="col mb-2">
                <div class="">
                    <select class="form-select w-100" id="query_type_show" name="query_type_show"
                        aria-label="Default select example">
                        <option value="">All</option>
                        <option value="red" @if (isset($success_array['query_type_show']) && $success_array['query_type_show'] == 'red') selected @endif>Not to be moved
                        </option>
                        <option value="green" @if (isset($success_array['query_type_show']) && $success_array['query_type_show'] == 'green') selected @endif>Can be moved</option>

                    </select>
                </div>
            </div>
            <div class="col mb-2">
                <div class="bg-patients-count">
                    <h6>Total Patients</h6>
                    <h5>0</h5>
                </div>
            </div>
            <div class="col mb-2">
                <div class="bg-patients-count">
                    <h6>Can Be Moved</h6>
                    <h5>0</h5>
                </div>
            </div>
            <div class="col mb-2">
                <div class="bg-patients-count">
                    <h6>Not To Be Moved</h6>
                    <h5>0</h5>
                </div>
            </div>
        </div>
    </div>



    <div class="side-room-data">
        @if (isset($success_array['ic_sideroom_patient_list_arr']) && count($success_array['ic_sideroom_patient_list_arr']) > 0)
            @foreach ($success_array['ic_sideroom_patient_list_arr'] as $ward_type => $patients_data)
                <div class="card-wards-group">
                    <div class="wards-group-name">
                        <h6>{{ $ward_type }}</h6>
                    </div>

                    <div class="card-side-room">
                        <table class="responsiveTable table-infection-control">
                            <thead>
                                <tr>
                                    <th>Bed</th>
                                    <th>Name</th>
                                    <th>PAS Number</th>
                                    <th>Able to Move</th>
                                    <th>Consultant</th>
                                    <th>Primary Risk</th>
                                    <th>Other Risk</th>
                                    <th>LOS</th>
                                    <th>Admitted Date</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($patients_data as $ward_key => $ward_data)
                                    <tr>
                                        <td colspan="9">
                                            <div class="name-header">
                                                <span>{{ $ward_key }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach ($ward_data as $patient_data)
                                        @php
                                            $is_infected = false;
                                        @endphp
                                        @if (isset($patient_data['infection_risks']) && is_array($patient_data['infection_risks']))
                                            @php
                                                $infection_risks = $patient_data['infection_risks'];

                                                $primary_flag = array_values(array_filter($infection_risks, function ($item) {
                                                    return !empty($item['is_primary']) && $item['is_primary'] == 1;
                                                }));
                                                $other_flag = array_values(array_filter($infection_risks, function ($item) {
                                                    return $item['is_primary'] == 0;
                                                }));
                                                if (count($primary_flag) > 0) {
                                                    if (
                                                        in_array($primary_flag['0']['infection_type'], [
                                                            'QUERY',
                                                            'CONFIRMED',
                                                        ])
                                                    ) {
                                                        $is_infected = true;
                                                    }
                                                }
                                                $others_flag = '';

                                                if (count($other_flag) > 0) {
                                                    $others = [];

                                                    foreach ($other_flag as $of_key => $of_value) {

                                                        $others[] =
                                                            $of_value['infection_name'] .
                                                            ' - ' .
                                                            $of_value['infection_type'];
                                                    }
                                                    $others_flag = implode(', ', $others);

                                                }

                                            @endphp
                                        @else
                                            @php
                                                $primary_flag = '';
                                                $others_flag = '';
                                            @endphp
                                        @endif
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Bay & Bed</div>
                                                {{ $patient_data['ibox_actual_bed_full_name'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Name</div>


                                                {!! !empty($patient_data['camis_patient_id'])
                                                    ? CamisPatientGender($patient_data['camis_patient_sex'], $patient_data['camis_patient_name'])
                                                    : '--' !!}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">PAS Number</div>
                                                {{ !empty($patient_data['camis_patient_id']) ? $patient_data['camis_patient_pas_number'] : '--' }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Able to Move</div>
                                                @if (!empty($patient_data['camis_patient_id']))
                                                    @if (!$is_infected)
                                                        <div class="alert  bg-green" role="alert">Can be moved</div>
                                                    @else
                                                        <div class="alert  bg-red" role="alert">Not to be moved</div>
                                                    @endif
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Consultant</div>
                                                {{ !empty($patient_data['camis_patient_id']) ? $patient_data['camis_consultant_name'] : '--' }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Primary Risk</div>
                                                @if (isset($primary_flag['0']))
                                                    {{ $primary_flag['0']['infection_name'] }} -
                                                    {{ $primary_flag['0']['infection_type'] }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Other Risk</div>
                                                {{ !empty($others_flag) ? $others_flag : '--' }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">LOS</div>
                                                @if (!empty($patient_data['camis_patient_id']))
                                                    {{ NumberOfDaysBetweenTwoDates($patient_data['camis_patient_admission_date'], date('Y-m-d')) }}
                                                    Days
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Admitted Date</div>
                                                @if (!empty($patient_data['camis_patient_id']))
                                                    {{ PredefinedDateFormatFor24Hour($patient_data['camis_patient_admission_date_time']) }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
    </div>













</div>
@endforeach
@else
<div class="custom_not_found">{{ NotFoundMessage() }}</div>
@endif
</div>


</div>
<script>
    var windowWidth = window.innerWidth;
    if (windowWidth > 1199) {
        if (
            document.getElementById("marquee-content")
        ) {
            document.getElementById("sideroomFilters").style.top = "85px";
            if (document.querySelector(".side-room-data")) {
                var bgSticky = document.querySelectorAll(".card-wards-group .wards-group-name");
                bgSticky.forEach(function(header) {
                    header.style.top = "140px";
                });
                var stickyHeader = document.querySelectorAll(".card-side-room .table-infection-control thead tr");
                stickyHeader.forEach(function(header) {
                    header.style.top = "172px";
                });
            }
        }
        if (document.getElementById("sideroomFilters")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector(".custom_not_found");
                noRecords.style.marginTop = "45px";
            }
        }
    } else if (windowWidth > 1025 && windowWidth < 1200) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("sideroomFilters").style.top = "85px";
            if (document.querySelector(".side-room-data")) {
                var bgSticky = document.querySelectorAll(".card-wards-group .wards-group-name");
                bgSticky.forEach(function(header) {
                    header.style.top = "179px";
                });
                var stickyHeader = document.querySelectorAll(".card-side-room .table-infection-control thead tr");
                stickyHeader.forEach(function(header) {
                    header.style.top = "213px";
                });
            }
        }
        if (document.getElementById("sideroomFilters")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector(".custom_not_found");
                noRecords.style.marginTop = "85px";
            }
        }
    }
</script>
