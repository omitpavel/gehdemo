
<div class="col-lg-12">
    <div class="row">
        <div class="sticky-toprow" id="stickyToprow">
            <div class="row gx-2">
                <div class="col-lg-3 col-md-6 mb-2">
                    {!! AllWardListDropdown('ward_id') !!}
                </div>
            </div>
        </div>

        <div class="dashboard-contents">
            <div class="removed-patients-details">
                @forelse($patients as $key => $patients_list)
                <div class="card-referral mb-lg-2">
                    <div class="name-header">
                        <span>{{ $key }}</span>
                    </div>
                    <table class="responsiveTable table-cdt-referral">
                        <thead>
                        <tr class="position-relative">
                            <th>Bed</th>
                            <th>Name</th>
                            <th>PAS Number</th>
                            <th>Consultant</th>
                            <th>Admitted Date</th>
                            <th>Removed Reason</th>
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
                                    <div class="tdBefore">Consultant</div>
                                    {{ $patient['camis_consultant_name'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Admitted Date
                                    </div>
                                    {{ PredefinedDateFormatFor24Hour($patient['camis_patient_admission_date_time']) }}
                                </td>
                                @php
                                    usort($patient['board_round_c_d_t_comment'], function ($a, $b) {
                                        return strtotime($b['updated_at']) <=> strtotime($a['updated_at']);
                                    });
                                @endphp
                                <td class="pivoted">
                                    <div class="tdBefore">Removed Reason</div>
                                    {{ $patient['board_round_c_d_t_comment']['0']['cdt_comment'] ?? '' }}
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
    var bgSticky = document.querySelector('.bg-sticky');
    var noRecords = document.querySelector('.custom_not_found');
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '185px';
            })

        }
        else{

            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '160px';
            })

        }


    }
</script>
