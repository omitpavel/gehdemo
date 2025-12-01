<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="row g-2 mb-2 fixed-height">
                <div class="col-lg-3 col-md-4">
                    {!! AllWardListDropdown('ward_option_tab2') !!}
                </div>
                <div class="col-lg-3 col-md-4 col-10">
                    <div class="form-group">
                        <select  id="flags_selected_data_val_tab2" multiple="multiple" class="3col active">
                            @foreach ($success_array['flag_lists'] as $flag)
                                <option @if (in_array($flag['only_flag_name'], $success_array['flag_selected_array_tab2'])) selected @endif
                                value="{{ $flag['patient_flag_stored_name'] }}">{{ $flag['patient_flag_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 col-2">
                    <button type="button" class="btn btn-dark search_flag_data"><i
                            class="bi bi-search "></i></button>
                </div>
                <div class="col-lg-2 col-md-3 offset-lg-3 {{ PermissionDeniedDiv('bed_flag_dashboard_print') }}">
                    <button type="button" class="btn btn-export w-100  @if (count($success_array['patient_lists']) > 0) @else disabled @endif  {{ DisabledButtonOnRolePermission('bed_flag_dashboard_print') }}"  @if (count($success_array['patient_lists']) > 0) onclick="printBedStatusFlag('bed_flag_div')" @endif><img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt=""
                            width="16" class="me-3">Print</button>
                </div>
            </div>
            <div >
                <div class="row g-2 mb-2">
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-primary d-flex justify-content-between align-items-center">
                            <h6>Number of Patients</h6>
                            <h5 class=" ">{{ $success_array['patient_count'] }}</h5>
                        </div>

                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-darkcyan d-flex justify-content-between align-items-center">
                            <h6>Average LOS in Days</h6>
                            <h5 class=" ">{{ @$success_array['avg_los_patient'] }}</h5>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-maroon d-flex justify-content-between align-items-center">
                            <h6>Average Flags per Patients</h6>
                            <h5 class=" ">{{ @$success_array['avg_flag_patient'] }}</h5>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-purple d-flex justify-content-between align-items-center">
                            <h6>Average Age</h6>
                            <h5 class=" ">{{ @$success_array['avg_age_patient'] }}</h5>
                        </div>
                    </div>

                </div>
                <div id="dataBedStatusFlag">
                @if (count($success_array['patient_lists']) > 0)
                    @foreach ($success_array['patient_lists'] as $ward => $patient_details)
                        <div class="card-bed-flags mb-lg-2">
                            <div class="name-header">
                                <span>{{ $ward }}</span>
                            </div>
                            <table class="breachReasonTable responsiveTable table-bed-flags">
                                <thead>
                                    <tr class="position-relative">
                                        <th width="100">Bed & Bay</th>
                                        <th width="40">Hospital Number</th>
                                        <th width="100">Name</th>
                                        <th width="70" class="text-center">Age</th>
                                        <th width="100" class="text-center">Admission Date</th>
                                        <th width="100" class="text-center">LOS Days</th>
                                        <th width="70" class="text-center">Med Fit</th>
                                        <th width="100">Consultant</th>
                                        <th width="100">Consultant Speciality</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient_details as $patient)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Bed & Bay</div>
                                                @php
                                                    $patient_row = $patient->toArray();

                                                    $bed_group_name = $patient_row['patient_position']['sdec_position']['bed_group']['bed_group_name'] ?? 'Waiting Area';
                                                    $bed_actual_name = $patient_row['patient_position']['sdec_position']['bed_actual_name'] ?? '';
                                                    $current_area = trim($bed_group_name . ' ' . $bed_actual_name);
                                                @endphp

                                                @if(stripos($patient_row['camis_patient_ward'] ?? '', 'RLTSDECIP') !== false)
                                                    @php
                                                        $bed_group_name = $patient_row['patient_position']['sdec_position']['bed_group']['bed_group_name'] ?? 'Waiting Area';
                                                        $bed_actual_name = $patient_row['patient_position']['sdec_position']['bed_actual_name'] ?? '';
                                                        $current_area = trim($bed_group_name . ' ' . $bed_actual_name);
                                                    @endphp

                                                    <span> {{ $current_area}}</span>
                                                @elseif(stripos($patient_row['camis_patient_ward'] ?? '', 'RLTFAU') !== false)
                                                    @php
                                                        $bed_group_name = $patient_row['frailty_position']['frailty_position']['bed_group']['bed_group_name'] ?? 'Waiting Area';
                                                        $bed_actual_name = $patient_row['frailty_position']['frailty_position']['bed_actual_name'] ?? '';
                                                        $current_area = trim($bed_group_name . ' ' . $bed_actual_name);
                                                    @endphp
                                                    <span> {{ $current_area}}</span>

                                                @else
                                                    <span> {{ $patient['ibox_actual_bed_full_name'] }}</span>
                                                @endif

                                                {{ $patient->bed_actual_name }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Hospital Number</div>
                                                {{ $patient->pass_number }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Name</div>
                                                {!! CamisPatientGender($patient->sex, $patient->name) !!}
                                            </td>
                                            <td class="pivoted text-center">
                                                <div class="tdBefore">Age</div>
                                                {{ $patient->camis_patient_age }}
                                            </td>

                                            <td class="pivoted text-center">
                                                <div class="tdBefore">Admission Date</div>
                                                {{ PredefinedDateAloneFormatChange($patient->camis_patient_admission_date) }}
                                            </td>
                                            <td class="pivoted text-center">
                                                <div class="tdBefore">LOS Days</div>
                                                {{ NumberOfDaysBetweenTwoDates($patient->camis_patient_admission_date, date('Y-m-d')) }}
                                            </td>
                                            <td class="pivoted text-center">
                                                <div class="tdBefore">Med Fit</div>
                                                <div class="{{ @$patient->BoardRoundMedicallyFitData->patient_medically_fit_status == 1 ? 'bg-success-data' : 'bg-danger-data' }}">
                                                    {{ @$patient->BoardRoundMedicallyFitData->patient_medically_fit_status == 1 ? 'YES' : 'No' }}
                                                </div>
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Consultant</div>
                                                {{ $patient->con }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Consultant Speciality</div>
                                                {{ ucwords($patient->con_speciality) }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @else
                    <div class="custom_not_found">
                        <p>{{ NotFoundMessage() }}</p>
                    </div>
                @endif
                </div>
            </div>

        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        $('#flags_selected_data_val_tab2').multiselect({
            columns: 1,
            placeholder: 'Select ',
            search: true,
            searchOptions: {
                'default': 'Search'
            },
            selectAll: true
        });
    });
</script>
