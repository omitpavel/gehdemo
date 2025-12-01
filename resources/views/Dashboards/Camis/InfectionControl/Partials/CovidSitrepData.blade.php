<div class="col-lg-12">
    <div class="row row-cols-xl-5 row-cols-lg-3 row-cols-md-3 row-cols-1 gx-2 fs-13">
        <div class="col mb-2">
             <select class="form-select w-100" aria-label="Default select example" id="ward_name">
                 <option value="">Select Ward</option>
                 @foreach($success_array['all_ward_details'] as $ward)
                    <option value="{{ $ward->id }}" @if($success_array['selected_ward_id'] == $ward->id) selected @endif>{{ $ward->ward_name }}</option>
                 @endforeach
             </select>
        </div>
        @if (isset($success_array['ic_covid_patient_list_arr_all']))
            <div class="col mb-2">
                <div class="bg-primary d-flex justify-content-between align-items-center p-2">
                    <h6>Number of Swab Overdue</h6>
                    <h6 class=" ">{{ $success_array['ic_covid_patient_list_arr_all']['swab_overdue'] }}</h6>
                </div>

            </div>
            <div class="col mb-2 ">
                <div class="bg-darkcyan d-flex justify-content-between align-items-center p-2">
                    <h6>Number of COVID-19 Exposed</h6>
                    <h6 class=" ">{{ $success_array['ic_covid_patient_list_arr_all']['covid_exposed_query'] }}</h6>
                </div>
            </div>
            <div class="col mb-2 ">
                <div class="bg-maroon d-flex justify-content-between align-items-center p-2">
                    <h6>Number of COVID-19 Query</h6>
                    <h6 class=" ">{{ $success_array['ic_covid_patient_list_arr_all']['covid_positive_query'] }}</h6>
                </div>
            </div>
            <div class="col mb-2 ">
                <div class="bg-purple d-flex justify-content-between align-items-center p-2">
                    <h6>Number of Positive</h6>
                    <h6 class=" ">{{ $success_array['ic_covid_patient_list_arr_all']['covid_positive_confirmed'] }}</h6>
                </div>
            </div>
        @endif

    </div>
    <div class="covid19-sitrep">
        @if (isset($success_array['ic_covid_patient_list_arr_all']['ic_covid_data_group_array']) && count($success_array['ic_covid_patient_list_arr_all']['ic_covid_data_group_array'])>0)
            <table class="breachReasonTable responsiveTable table-infection-control">
                <thead>
                    <tr class="position-relative">
                        <th>Bed</th>
                        <th>Name</th>
                        <th>PAS Number</th>
                        <th>Age</th>
                        <th>Consultant</th>
                        <th>Risk Status</th>
                        <th>Risk Reason</th>
                        <th>LOS</th>
                        <th>Admitted Date</th>

                    </tr>
                </thead>
                <tbody>
                    @if (isset($success_array))
                        @if (isset($success_array['ic_covid_patient_list_arr_all']['ic_covid_data_group_array']) && count($success_array['ic_covid_patient_list_arr_all']['ic_covid_data_group_array'])>0)
                            @foreach ($success_array['ic_covid_patient_list_arr_all']['ic_covid_data_group_array'] as $ward_key => $ward_data)
                                <tr class="bg-blue">
                                    <td colspan="9">{{ $ward_key }}</td>
                                </tr>
                                @foreach ($ward_data['data'] as $patient_data)
                                    <tr>
                                        <td class="pivoted">
                                            <div class="tdBefore">Bed</div>
                                            {{ $patient_data['ibox_actual_bed_full_name'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Name</div>
                                            {!! CamisPatientGender($patient_data['camis_patient_sex'], $patient_data['camis_patient_name']) !!}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">PAS Number</div>
                                            {{ $patient_data['camis_patient_pas_number'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Age</div>
                                            {{ $patient_data['camis_patient_age'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Consultant</div>
                                            {{ $patient_data['camis_consultant_name'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Risk Status</div>
                                            {{ $patient_data['patient_flag_infection_risk_status'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Risk Reason</div>
                                            {{ $patient_data['patient_flag_infection_risk_reason'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">LOS</div>
                                            {{ NumberOfDaysBetweenTwoDates($patient_data['camis_patient_admission_date'], date('Y-m-d')) }} Days
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Admitted Date</div>
                                            {{ PredefinedDateFormatFor24Hour($patient_data['camis_patient_admission_date_time']) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                        <tr>
                            <td colspan="9" class="text-center">{{ NotFoundMessage() }}</td>
                        </tr>
                        @endif
                    @endif
                </tbody>


            </table>
        @else
            <div class="custom_not_found">{{ NotFoundMessage() }}</div>
        @endif
    </div>

</div>
