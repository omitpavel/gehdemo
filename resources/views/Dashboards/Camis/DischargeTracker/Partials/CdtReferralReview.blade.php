<input type="hidden" id="tab" value="{{ $tab }}">
<input type="hidden" id="patient_id" value="">
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">

            <!-- Nav tabs -->

            <div class="sticky-toprow" id="stickyToprow">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2">
                        <a class="tab-custom-btn @if ($tab == 'pending') active @endif"
                            onclick="DataPageLoad('pending');">
                            <div class="tab-active">Referral</div>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="tab-custom-btn @if ($tab == 'review') active @endif"
                            onclick="DataPageLoad('review');">
                            <div class="tab-active">To Review</div>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="tab-custom-btn @if ($tab == 'reject') active @endif"
                            onclick="DataPageLoad('reject');">
                            <div class="tab-active">Rejected</div>
                        </a>
                    </li>
                </ul>
                <div class="row gx-2 referral-filters">
                    <div class="col-lg-3 col-md-4 mb-2">
                        {!! AllWardListDropdown('ward_id') !!}
                    </div>
                    <div class="col-lg-3 col-md-5 mb-2">
                        <div class="d-flex justify-content-between">
                            <input class="form-control" type="text" id="referral_search_text" placeholder=""
                                aria-label="default input example" value="{{ request()->search_text }}">
                            <button type="button" class="btn btn-dark ms-2" id="referral_search_button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 mb-2">
                        <button type="button" class="btn btn-export w-100"
                            onclick="DataPageLoad('{{ request()->tab }}', '', '');">
                            <img src="{{ asset('asset_v2/Template/icons/reset.svg') }}" alt="" width="16"
                                class="me-1">Reset Search
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab panes -->

            <div class="tab-content" id="tabcontent">
                <div class="tab-pane active show" role="tabpanel">
                    <div class="dashboard-contents">
                        <div class="review-contents">
                            <div class="card-custom-table">
                                @forelse($patients as $key => $patients_list)
                                    <div class="ward-patients-wrapper">
                                        <div class="name-header">
                                            <span>{{ $key }}</span>
                                        </div>
                                        <div class="custom-card">
                                            <table class="responsiveTable table-custom">


                                                @foreach ($patients_list as $patient)
                                                    <tbody
                                                        class="table-patient-tbody tbody_id_{{ $patient['camis_patient_id'] }}">
                                                        <tr class="table-patient-row-1">
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Bay &amp; Bed</div>
                                                                <span>{{ $patient['ibox_actual_bed_full_name'] }}</span>
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Name</div>
                                                                {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Hospital Number</div>
                                                                <span>{{ $patient['camis_patient_pas_number'] }}</span>
                                                            </td>

                                                            <td class="pivoted">
                                                                <div class="tdBefore">Admitted Date</div>
                                                                <span>{{ PredefinedDateFormatFor24Hour($patient['camis_patient_admission_date_time']) }}</span>
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Referral Requested
                                                                </div>
                                                                <span>{{ PredefinedDateFormatFor24Hour($patient['board_round_cdt']['request_date']) }}
                                                                    ({{ $patient['board_round_cdt']['request_by_username'] ?? '' }})
                                                                </span>
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Referral To Reviewed
                                                                </div>
                                                                <span>{{ PredefinedDateFormatFor24Hour($patient['board_round_cdt']['to_be_review_date']) }}
                                                                    ({{ $patient['board_round_cdt']['reviewed_by_username'] ?? '' }})
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $patient['board_round_c_d_t_comment_history'] =
                                                                $patient['board_round_c_d_t_comment_history'] ?? [];
                                                            usort(
                                                                $patient['board_round_c_d_t_comment_history'],
                                                                function ($a, $b) {
                                                                    return $b['history_id'] <=> $a['history_id'];
                                                                },
                                                            );
                                                        @endphp
                                                        <tr class="table-patient-row-2">
                                                            <td class="pivoted">
                                                                <div class="note-grp">
                                                                    <div class="tdBefore">Review Reason
                                                                    </div>
                                                                    <div
                                                                        class="wrapper-buttons  {{ PermissionDeniedDiv('discharge_tracker_referral_update') }}">
                                                                        <button
                                                                            class="btn btn-approve {{ DisabledButtonOnRolePermission('discharge_tracker_referral_update') }} cdt_approval_button"
                                                                            data-status="1"
                                                                            data-patient_id="{{ $patient['camis_patient_id'] }}">Accept
                                                                        </button>
                                                                        <button
                                                                            onclick="ActionButton('{{ $patient['camis_patient_id'] }}', 2);"
                                                                            class="btn btn-reject {{ DisabledButtonOnRolePermission('discharge_tracker_referral_update') }}">Reject</button>
                                                                        <button class="btn btn-blue-gradient  review_reason_{{ $patient['camis_patient_id'] }}"
                                                                            onclick="CDTComments('{{ $patient['camis_patient_id'] }}');"  data-history-id="{{ $patient['board_round_c_d_t_comment_history']['0']['history_id'] ?? '' }}" data-id="{{ $patient['board_round_c_d_t_comment_history']['0']['id'] ?? '' }}">Update
                                                                            Review Reason
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <textarea onclick="CDTComments('{{ $patient['camis_patient_id'] }}');"
                                                                    class="form-control review_reason_{{ $patient['camis_patient_id'] }}"
                                                                    data-id="{{ $patient['board_round_c_d_t_comment_history']['0']['id'] ?? '' }}" data-history-id="{{ $patient['board_round_c_d_t_comment_history']['0']['history_id'] ?? '' }}" readonly>{{ $patient['board_round_c_d_t_comment_history']['0']['cdt_comment'] ?? '' }}</textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                @endforeach

                                            </table>
                                        </div>
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
            stickyHeader.forEach(function(header) {
                header.style.top = '185px';
            })
            if (document.getElementById("stickyToprow")) {
                var noRecords = document.querySelector('.custom_not_found');

                if (noRecords) {
                    noRecords.style.marginTop = '40px';
                }

            }
        } else {

            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function(header) {
                header.style.top = '160px';
            })
            if (document.getElementById("stickyToprow")) {
                var noRecords = document.querySelector('.custom_not_found');

                if (noRecords) {
                    noRecords.style.marginTop = '40px';
                }

            }
        }


    }
</script>
