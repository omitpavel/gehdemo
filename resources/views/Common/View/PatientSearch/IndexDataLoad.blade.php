<div class="row">
    <div class="col-lg-12">

        <div class="row gx-2 fixed-height">
            <div class="col-xl-3 col-md-5 mb-2">
                <input class="form-control" type="text" placeholder="Search" id="search_term"
                    aria-label="default input example"  value="{{ request()->search_term }}">
            </div>
            <div class="col-xl-1 col-md-2 mb-2">
                <button class="btn btn-search patient_seacrh_button">Search</button>
            </div>
        </div>



        @if(count($pas_number_wise_patient) > 0)
            @foreach ($pas_number_wise_patient as $pas_number => $patients)
                <div class="card-search-results mb-lg-2">
                    <div class="name-header">
                        <span>{{ $pas_number_wise_patient[$pas_number][0]['patient_name']}}</span>
                    </div>
                    <table class="breachReasonTable responsiveTable table-search-results">
                        <thead>
                            <tr class="position-relative">
                                <th>Hospital Number</th>
                                <th>Attendance ID</th>
                                <th>Inpatient ID</th>
                                <th>Admission Date</th>
                                <th>Discharged Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">Hospital Number</div>
                                        {{ $patient['pas_number'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Attendance ID</div>
                                        @if($patient['data_source'] == 2) {{ $patient['patient_id'] }} @endif
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Inpatient ID</div>
                                        @if($patient['data_source'] == 1) {{ $patient['patient_id'] }} @endif
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Admission Date</div>
                                        {{ PredefinedDateFormatFor24Hour($patient['admission_date']) }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Discharged Date</div>
                                        {{ PredefinedDateFormatFor24Hour($patient['discharge_date']) }}
                                    </td>

                                    <td class="pivoted">
                                        <div class="tdBefore">Info</div>
                                        @if($patient['data_source'] == 1)
                                            <button class="btn btn-info" onclick="PatientInfo('{{ $patient['patient_id'] }}')">IBOX Discharge Summary
                                            </button>
                                        @else
                                            <button class="btn btn-info"  onclick="ANEPatientInfo('{{ $patient['pas_number'] }}','{{ $patient['patient_id'] }}')">A&E Discharge Summary
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <div class="custom_not_found">
                {{ NotFoundMessage() }}
            </div>
        @endif
    </div>
</div>
