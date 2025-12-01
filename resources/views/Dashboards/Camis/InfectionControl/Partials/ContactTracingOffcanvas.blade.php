
<div class="contact-patient-details">
    <div class="rectangle-block-1">
        <div class="blue-rectangle-block ">
            <h6 class="mb-0">Primary Patient Details</h6>
        </div>
        <div class="row g-2 p-2">
            <div class="col-md-3">
                <div>
                    <label for="exampleFormControlInput1" class="form-label">Hospital Number</label>
                    <div class="value">{{ $patient_details['camis_patient_pas_number'] ?? '--' }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <div class="value">
                        <div class="patient-gender">

                            @if($patient_details['camis_patient_sex'] == 'female')
                            <img src="{{ asset('asset_v2/Template/icons/female-icon.svg') }}" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Female">
                            @elseif($patient_details['camis_patient_sex'] == 'male')
                            <img src="{{ asset('asset_v2/Template/icons/male-icon.svg') }}" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Male">
                            @endif
                        </div>{{ $patient_details['camis_patient_name'] ?? '--' }}
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div>
                    <label for="exampleFormControlInput1" class="form-label">Ward</label>
                    <div class="value">{{ $patient_details['camis_patient_ward'] ?? '--' }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    <label for="exampleFormControlInput1" class="form-label">Current Bed</label>
                    <div class="value">{{ $patient_details['camis_patient_bed_name'] ?? '--' }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    <label for="exampleFormControlInput1" class="form-label">Patient ID</label>
                    <div class="value">5234345436</div>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    <label for="exampleFormControlInput1" class="form-label">Admission Date</label>
                    <div class="value">{{ $patient_details['camis_patient_admission_date_time'] }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    <label for="exampleFormControlInput1" class="form-label">Discharge Date</label>
                    <div class="value">{{ $patient_details['camis_patient_discharge_date_time'] }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    <label for="exampleFormControlInput1" class="form-label">LOS</label>
                    <div class="value">@if($patient_details['camis_patient_discharge_date_time'] == '--') {{ PatientLos($patient_details['camis_patient_admission_date_time']) }} @else {{ PatientLos($patient_details['camis_patient_admission_date_time'], $patient_details['camis_patient_discharge_date_time']) }} @endif</div>
                </div>
            </div>
        </div>
    </div>
</div>



@if (count($patient_alerts) > 0)
    <div class="infections-wrapper">
        <div class="card-table-listing">
            <table class="responsiveTable table-listing">
                <thead>
                    <tr class="position-relative">
                        <th>Primary Patient Infections</th>
                        <th>Applied Date</th>
                        <th>Refreshed Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patient_alerts as $alert)
                        <tr>
                            <td class="pivoted">
                                <div class="tdBefore">Infections</div>
                                {{ $alert['alert_name'] ?? '--' }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Applied Date</div>
                                {{ $alert['alert_applied'] ?? '--' }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Refreshed Date</div>
                                {{ $alert['alert_refreshed'] ?? '--' }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endif
<div class="contact-tracing-contents">
    <h6>Contact Tracing</h6>
    @if (count($contacts) > 0)
        <div class="patients-details">
            @foreach ($contacts as $ward => $contact)
            <div class="wards-patients-details">
                <div class="name-header">
                    <span>{{ $ward }}</span>
                </div>
                <div class="custom-card">
                    <table class="responsiveTable table-custom">
                        @foreach ($contact as $con)
                        <tbody class="table-patient-tbody">
                            <tr class="table-patient-row-1">
                                <td class="pivoted">
                                    <div class="tdBefore">Hospital Number</div>
                                    <span>{{ $con['contact_pas_number'] ?? '--' }}</span>
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Name</div>
                                    <span>{!! CamisPatientGender($con['camis_contact_patient_sex'], $con['contact_patient_name'] ) !!}</span>
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Discharge Date</div>
                                    <span> {{ $con['camis_patient_discharge_date_time'] ?? '--' }}</span>
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Shared Ward</div>
                                    <span>{{ $con['shared_ward'] ?? '--' }}</span>
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Shared Bay Area</div>
                                    <span>{{ $con['shared_bay_area'] ?? '--' }}</span>
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Patient Bed Name</div>
                                    <span>{{ $con['index_patient_bed_name'] ?? '--' }}</span>
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Contact Patient Bed Name</div>
                                    <span>{{ $con['contact_patient_bed_name'] ?? '--' }}</span>
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Contact Start Time</div>
                                    <span>{{ $con['contact_start_time'] ?? '--' }}</span>
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Contact End Time</div>
                                    <span>{{ $con['contact_end_time'] ?? '--' }}</span>
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Overlap Minutes</div>
                                    <span>{{ $con['overlap_minutes'] ?? '--' }}</span>
                                </td>
                            </tr>
                            <tr class="table-patient-row-2 contact_traced_patient_notes" data-patient-id="{{ $con['camis_patient_id'] ?? '--' }}">
                                <td class="pivoted">
                                    <div class="tdBefore">Notes</div>
                                    <textarea class="form-control cursor-pointer contact_traced_patient_{{ $con['camis_patient_id'] ?? '--' }}" placeholder="">{{ $all_contact_notes[$con['camis_patient_id']] ?? '' }}</textarea>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach


                    </table>
                </div>
            </div>
            @endforeach

        </div>
    @else
        <div class="No_record_css">
            {{ NotFoundMessage() }}
        </div>
    @endif
</div>
