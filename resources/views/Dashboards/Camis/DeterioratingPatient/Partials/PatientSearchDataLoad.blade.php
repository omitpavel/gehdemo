@if (count($patient_details) > 0)
    <div class="col-lg-12  ">
        <div class="patients-search">
            <table class="breachReasonTable responsiveTable table-search-patient">
                <thead>
                    <tr class="position-relative">
                        <th>Hospital Number</th>
                        <th>Surname</th>
                        <th>Forename</th>
                        <th>Episode ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patient_details as $value)

                        <tr>
                            <td class="pivoted">
                                <div class="tdBefore">Hospital Number</div>
                                {{ $value['camis_patient_pas_number'] }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Surname</div>
                                {{  ucwords(strtolower($value['camis_patient_surname'])) }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Forename</div>
                                {{ ucwords(strtolower($value['camis_patient_forename'])) }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Episode ID</div>
                                <div class="table-btns ">
                                    <button class="btn btn-search me-2" onclick="dp_patient_timeline('{{ $value['camis_patient_id'] }}');">{{  $value['camis_patient_id'] }}</button>
                                    <a @if($value['board_round_patient_tasks_count'] >0 ) href="{{ route('export.dp_patient_task',  $value['camis_patient_id']) }}" class="btn btn-export" @else
                                        class="btn btn-export dp_no_task" @endif> <img src="{{ asset('asset_v2/Template/icons/export-2.svg') }}"
                                            alt="" class="me-3" width="18">Export DP
                                        Tasks</a>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="col-lg-12">
        <div class="patients-search">
            <div class="custom_not_found">
                {{ NotFoundMessage() }}
            </div>
        </div>
    </div>
@endif


<div class="timeline-status modal fade camis_ward_summary_boardround_sub_inner_popup_common_class" id="timeline" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel"  style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">

                <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="">
                        <h6 class="mb-0" id="offcanvasRightLabel">DETERIORATING PATIENT TIMELINE</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="btn-custom-print  ">
                            <button class="btn btn-grey w-100 print_dp_timeline " id="print_dp_timeline"><img src="{{ asset('asset_v2/Template/icons/print.svg') }}" class="me-3" width="16" alt="">PRINT</button>
                        </div>
                        <div class="">
                            <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                                CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body">

                <div class="dp_print_section"  id="dp_task">

                </div>
            </div>
        </div>
    </div>
</div>

