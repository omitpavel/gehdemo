



<div class="bg-sticky"></div>
<div class="patients-details">

    @if(count($success_array['all_patients']) > 0)
        @forelse($success_array['all_wards'] as $wards)
            @php
                $patientsInWard = array_values(array_filter($success_array['all_patients'], function($item) use($wards) { return $item['camis_patient_ward'] == $wards; }));
            @endphp
            @if(count($patientsInWard) > 0)
                <div class="wards-patients-details">
                    <div class="sticky-header">
                        <div class="name-header">
                            {{ $success_array['ward_list'][$wards] ?? '--'  }}
                        </div>
                    </div>
                    <div class="custom-card">
                        <table class="breachReasonTable responsiveTable table-custom">
                            @foreach(array_values(array_filter($success_array['all_patients'], function($item) use($wards) { return $item['camis_patient_ward'] == $wards; })) as $patient)
                                <tbody class="table-patient-tbody">

                                <tr class="table-patient-row-1 " data-camis-patient-id="{{ $patient['camis_patient_id'] }}">
                                    <td class="pivoted">
                                        <div class="tdBefore">Bay & Bed</div>
                                        <span>{{ $patient['camis_patient_bed_name'] }}</span>
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">First Name</div>
                                        {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_forename']) !!}

                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Surname</div>
                                        <span>{{ $patient['camis_patient_surname'] }}</span>
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Hospital Number</div>
                                        <span>{{ $patient['camis_patient_pas_number'] }}</span>
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Ward</div>
                                        <span>{{ $success_array['ward_list'][$patient['camis_patient_ward']] ?? '--' }}</span>
                                    </td>


                                    <td class="pivoted">
                                        <div class="tdBefore">NHS Number</div>
                                        <span>{{ $patient['camis_patient_nhs_number'] }}</span>
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Admit Date</div>
                                        <span>{{ !empty($patient['camis_patient_admission_date']) ? PredefinedDateFormatForEDD($patient['camis_patient_admission_date']) : '--' }}</span>
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Discharge Date</div>
                                        <span>{{ !empty($patient['camis_patient_discharge_date']) ? PredefinedDateFormatForEDD($patient['camis_patient_discharge_date']) : '--' }}</span>
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Med Fit</div>
                                        <span>
                                                {{ @$patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'Yes - '.PredefinedDateFormatMedFitDate(@$patient['board_round_medically_fit_data']['updated_at']).'' : 'No' }}
                                            </span>
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">DOB</div>
                                        <span>{{ PredefinedDateFormatShowOnCalendarWithoutDay($patient['camis_patient_date_of_birth']) }}</span>
                                    </td>



                                    <td class="pivoted">
                                        <div class="tdBefore">Pathway</div>
                                        <span id="dtoc_pathway_text_{{ $patient['camis_patient_id'] }}">@if(isset($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text'])) {{ \Illuminate\Support\Str::limit($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text'], 200, '...') }} @else -- @endif</span>
                                    </td>



                                    <td class="pivoted">
                                        <div class="tdBefore">Reason Code</div>
                                        <span id="dtoc_reason_text_{{ $patient['camis_patient_id'] }}">@if(isset($patient['board_round_pathway_requirement']['dtoc_authority']['dtoc_authority_text'])) {{ \Illuminate\Support\Str::limit($patient['board_round_pathway_requirement']['dtoc_authority']['dtoc_authority_text'], 200, '...') }} @else @if(isset($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value'])) {{ \Illuminate\Support\Str::limit($patient['board_round_reason_to_reside']['reason_to_reside_category']['reason_to_reside_text_value'], 200, '...') }} @else -- @endif @endif</span>
                                    </td>
                                </tr>
                                <tr class="table-patient-row-2">
                                    <td class="pivoted spl-cell" rowspan="3" >
                                        <div class="header-comment">
                                            <p class="flex-grow-1">Comments</p>
                                            <button class="btn btn-assign-task click_open_other_comment_offcanvas" id="insert_comment_id_{{ $patient['camis_patient_id'] }}" data-patient-id="{{ $patient['camis_patient_id'] }}" readonly>Other Notes
                                            </button>
                                            <button data-bs-toggle="offcanvas" data-bs-target="#viewAllComments"
                                                    aria-controls="offcanvasRight" onclick="ViewAllComment('{{ $patient['camis_patient_id'] }}');"
                                                    class="btn btn-assign-task w-auto">View All
                                            </button>
                                            <button class="btn btn-assign-task w-auto patient_cdt_timeline"  data-patient-id="{{ $patient['camis_patient_id'] }}">CDT Timeline
                                            </button>
                                        </div>
                                        @if(isset($patient['board_round_dtoc_comments']) && count($patient['board_round_dtoc_comments']) > 0)
                                            <div class="card-col-grp" id="comment_list_{{ $patient['camis_patient_id'] }}">
                                                {!! app('App\Http\Controllers\Iboards\Camis\DischargeTrackerController')->DtocWardCommentList($patient['camis_patient_id']) !!}

                                            </div>
                                        @else
                                            <div class="card-col-grp" id="comment_list_{{ $patient['camis_patient_id'] }}" style="overflow-y: hidden;">
                                                <div class="custom_not_founds" style="position: relative;top: 40%;text-align: center;">{{ NotFoundMessage() }}</div>
                                            </div>

                                        @endif
                                    </td>

                                </tr>

                                </tbody>
                            @endforeach
                        </table>

                    </div>
                </div>
            @endif
        @empty
            <div class="custom_not_found">{{ NotFoundMessage() }}</div>
        @endforelse
    @else
        <div class="pt-4 custom_not_found">{{ NotFoundMessage() }}</div>
    @endif

</div>
<script>
    var windowWidth = window.innerWidth;
    var bgSticky = document.querySelector('.bg-sticky');
    var noRecords = document.querySelector('.custom_not_found');
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            var bgSticky = document.querySelector('.bg-sticky');
            if(bgSticky){
                bgSticky.style.top = '135px';
            }
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '135px';
            })


            if (document.getElementById("stickyToprow")) {
                var noRecords = document.querySelector('.custom_not_found');
                if (noRecords) {
                    if(bgSticky){
                        bgSticky.style.top = '60px';
                    }
                    noRecords.style.marginTop = '40px';
                }

            }


        }
        else{
            document.getElementById("stickyToprow").style.top = "60px";
            var bgSticky = document.querySelector('.bg-sticky');
            if(bgSticky){
                bgSticky.style.top = '110px';
            }
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '110px';
            })


            if (document.getElementById("stickyToprow")) {
                var noRecords = document.querySelector('.custom_not_found');
                if (noRecords) {
                    if(bgSticky){
                        bgSticky.style.top = '60px';
                    }
                    noRecords.style.marginTop = '40px';
                }

            }
        }


    }



</script>
