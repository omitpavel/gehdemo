<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="sticky-toprow" id="stickyToprow">
                <div class="row row-cols-lg-5 row-cols-md-3 row-cols-1 filters  gx-2">
                    <div class="col mb-2">
                        {!! AllWardListDropdown() !!}
                    </div>
                    <div class="col mb-2">
                        {!! AllWardListDropdown('move_to', 'Move To Ward All') !!}
                    </div>
                    <div class="col mb-2">
                        <select class="form-select" id="type" aria-label="Default select example">
                            <option selected="">Allow To Move All</option>
                            <option value="1" @if(request()->type == 1) selected @endif>Yes</option>
                            <option value="2" @if(request()->type == 2) selected @endif>No</option>
                        </select>
                    </div>
                    <div class="col mb-2">
                        <div class="bg-patients-count">
                            <h6>Total Patients</h6>
                            <h5>{{ $total_patients  }}</h5>
                        </div>
                    </div>
                    <div class="col mb-2">
                        <div class="text-end">
                            <a class="btn btn-export w-100" href="{{ route('allowed_to_move.export') }}?ward_id={{ request()->has('ward_id') ? implode(',', (array) request()->ward_id) : '' }}&move_to={{ request()->has('move_to') ? implode(',', (array) request()->move_to) : '' }}&type={{ request()->type }}"><img src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt="" width="16" class="me-3">Export</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="other-dashboard-contents">
                @forelse($patients as $key => $patients_list)
                    <div class="card-allow-to-move mb-lg-2">
                        <div class="name-header">
                            <span>{{ $key }}</span>
                        </div>
                        <table class="responsiveTable table-moved-patients">
                            <thead>
                                <tr class="position-relative">
                                    <th>Bed &amp; Bay</th>
                                    <th>Name</th>
                                    <th>PAS Number</th>
                                    <th>Med Fit</th>
                                    <th>Consultant</th>
                                    <th>Admitted Date</th>
                                    <th>Ward</th>
                                    <th>Move To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patients_list as $patient)

                                    <tr>
                                        <td class="pivoted">
                                            <div class="tdBefore">Bed</div>
                                            {{ $patient['ibox_actual_bed_full_name'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Name</div>
                                            {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">PAS Number</div>
                                            {{ $patient['camis_patient_pas_number'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Med Fit</div>
                                            <span class="{{ @$patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'medifit-text-success' : 'medifit-text-danger' }}">
                                                @if(isset($patient['board_round_medically_fit_data']['patient_medically_fit_status']) && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)
                                                    Yes {{ isset($patient['board_round_medically_fit_data']['updated_at']) ? '- '.PredefinedDateFormatWithoutYear($patient['board_round_medically_fit_data']['updated_at']).'' : '' }}
                                                @else
                                                No
                                                @endif
                                            </span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Consultant</div>
                                            {{ $patient['camis_consultant_name'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Admitted Date</div>
                                            {{ PredefinedDateFormatFor24Hour($patient['camis_patient_admission_date_time']) }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Ward</div>
                                            {!! $all_wards[$patient['allowed_to_move']['patient_allowed_to_be_moved_from']] ?? '<span class="text-not-move">Do Not Move</span>' !!}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Move To</div>
                                            {!! $all_wards[$patient['allowed_to_move']['patient_allowed_to_be_moved_to']] ?? '<span class="text-not-move">Do Not Move</span>' !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="patients-details">
                        <div class="custom_not_found">{{ NotFoundMessage() }}</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<script>
    var windowWidth = window.innerWidth;
    if (windowWidth > 1025 && windowWidth < 1200) {
        if (document.getElementById("stickyToprow")) {
            if (document.querySelector(".custom_not_found")) {
                var
                    noRecords = document.querySelector('.custom_not_found');
                noRecords.style.marginTop = '95px';
            }
        }
    } else if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector('.bg-sticky');
                bgSticky.style.top = '185px';
                var stickyHeader = document.querySelectorAll('.sticky-header');
                stickyHeader.forEach(function (header) {
                    header.style.top = '185px';
                })
            }
        }
        if (document.getElementById("stickyToprow")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector('.custom_not_found');
                noRecords.style.marginTop = '45px';
            }
        }
    }
</script>
