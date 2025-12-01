<input type="hidden" name="ibox_board_round_patient_pharmacy_drug_history" id="ibox_board_round_patient_pharmacy_drug_history" value="{{$success_array['pharmacy_data']['pharmacy_drug_history']}}" />
<input type="hidden" name="ibox_board_round_patient_pharmacy_drug_history_date" id="ibox_board_round_patient_pharmacy_drug_history_date" value="{{$success_array['pharmacy_data']['pharmacy_drug_history_date']}}" />
<input type="hidden" name="patient_screened_date_val" id="patient_screened_date_val" value="{{  date("D jS M Y, H:i") }}" />
<input type="hidden" name="patient_screened_val" id="patient_screened_val" value="" />


<input type="hidden" name="ibox_board_round_patient_current_date" id="ibox_board_round_patient_current_date" value="{{ $success_array['current_date'] }}" />
<input type="hidden" name="ibox_board_round_patient_current_date_formatted" id="ibox_board_round_patient_current_date_formatted" value="{{ $success_array['current_date_formatted'] }}" />
<div class="col-12 ">
    <div class="row g-2 mb-2">
        <div class="col-md-3">
            <button data-pharmacy-drug-history-type='partial' data-pharmacy-drug-history-value='1' type="button" class="btn btn-primary-grey patient_pharmacy_drug_history patient_pharmacy_drug_history_1 @if(isset($success_array['pharmacy_data']['pharmacy_drug_history']) && $success_array['pharmacy_data']['pharmacy_drug_history'] == 1) active @endif" id="patient_pharmacy_drug_history" name="partial">
                DRUG HISTORY
                <br class="d-none d-md-block">
                PARTIAL</button>

                <div class="updated-date-time">
                    <span class="pharmacy_update_time patient_drug_history_updated_date_1">@if(isset($success_array['pharmacy_data']['pharmacy_drug_history']) && $success_array['pharmacy_data']['pharmacy_drug_history'] == 1) {{$success_array['pharmacy_data']['pharmacy_drug_history_date_show']}} @endif</span>
                </div>


        </div>
        <div class="col-md-3">
            <button data-pharmacy-drug-history-type='full' data-pharmacy-drug-history-value='2' type="button" class="btn btn-primary-grey  patient_pharmacy_drug_history patient_pharmacy_drug_history_2 @if(isset($success_array['pharmacy_data']['pharmacy_drug_history']) && $success_array['pharmacy_data']['pharmacy_drug_history'] == 2) active @endif" id="patient_pharmacy_drug_history" name="full">
                DRUG HISTORY
                <br class="d-none d-md-block">
                FULL</button>


                <div class="updated-date-time">
                    <span class="pharmacy_update_time patient_drug_history_updated_date_2">@if(isset($success_array['pharmacy_data']['pharmacy_drug_history']) && $success_array['pharmacy_data']['pharmacy_drug_history'] == 2) {{$success_array['pharmacy_data']['pharmacy_drug_history_date_show']}} @endif</span>
                </div>


        </div>
        <div class="col-md-3">
            <button data-pharmacy-drug-history-type='reviewed' data-pharmacy-drug-history-value='3' type="button" class="btn btn-primary-grey patient_pharmacy_drug_history patient_pharmacy_drug_history_3 @if(isset($success_array['pharmacy_data']['pharmacy_drug_history']) && $success_array['pharmacy_data']['pharmacy_drug_history'] == 3) active @endif" id="patient_pharmacy_drug_history" name="reviewed">
                MEDICATION IN DRAFT
                <br class="d-none d-md-block">
                TO BE REVIEWED</button>

                <div class="updated-date-time">
                    <span class="pharmacy_update_time patient_drug_history_updated_date_3">@if(isset($success_array['pharmacy_data']['pharmacy_drug_history']) && $success_array['pharmacy_data']['pharmacy_drug_history'] == 3) {{$success_array['pharmacy_data']['pharmacy_drug_history_date_show']}} @endif</span>
                </div>

        </div>
        <div class="col-md-3">
            <button  data-patient_screened='1' type="button" class="btn btn-primary-grey  patient_screened " name="full">
                PHARMACIST
                <br class="d-none d-md-block">
                SCREENED</button>

            <div class="updated-date-time">
                <span class="patient_drug_history_updated_date_partial_pharmasict_screen"> </span>
            </div>
        </div>
    </div>

    <div class="mb-2">
        <label class="form-label">Pharmacy
            Comments</label>
        <textarea class="form-control pharmacy_latest_comment pharmacy_content_textarea" id="pharmacy_latest_comment" name="pharmacy_latest_comment"
            rows="6"></textarea>
    </div>

    <div class="pharmacy-history-card">
        <div class="rectangle-block-1 ">
            <div class="row mb-2">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between rectangle-block-2">
                        <p class="mb-0">History
                        </p>
                    </div>
                </div>
            </div>
            <div class="data-area">
                <div class="row mb-2">
                    <div class="col-12 pharmacy-comments-section">
                        <div class="rectangle-block-1">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between rectangle-block-2">
                                        <p class="mb-0 fw-header-500">
                                            Pharmacy Comments
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="pharmacy-comments">
                                <table class="breachReasonTable responsiveTable table-pharmacy-comments">
                                    <thead>
                                    <tr>
                                        <th>Comments</th>
                                        <th>User</th>
                                        <th>Date & Time</th>
                                        <th class="text-center">Copy</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($success_array['pharmacy_comment_data'] as $row)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Comments</div>
                                                <span class='boardround_pharmacy_patient_comment_text_show_{{ $row->id }}'>{{ $row->pharmacy_comment }}</span>
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">User</div>
                                                {{ \Sentinel::findById($row->updated_by)->username ?? '' }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Date & Time</div>
                                                {{ PredefinedDateFormatFor24Hour($row->created_at) }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Copy</div>

                                                <div class="icon-copy data-content-copy boardround_pharmacy_patient_comment_text_copy" data-comment-text-show-id="{{ $row->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                         height="24" viewBox="0 0 31.979 37.093">
                                                        <path id="copy-1-svgrepo-com"
                                                              d="M3,25.865V5.409A3.409,3.409,0,0,1,6.409,2H23.456M13.228,36.093H28.569a3.409,3.409,0,0,0,3.409-3.409V12.228a3.409,3.409,0,0,0-3.409-3.409H13.228a3.409,3.409,0,0,0-3.409,3.409V32.683A3.409,3.409,0,0,0,13.228,36.093Z"
                                                              transform="translate(-1.5 -0.5)" fill="none"
                                                              stroke="#000" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="3" />
                                                    </svg>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty

                                        <tr>
                                            <td class="pivoted text-center" colspan="4">{{ NotFoundMessage() }}</td>
                                        </tr>

                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iv-history">
                    <div class="row gx-2 mb-2">
                        <div class="col-md-6">
                            <div class="iv-header">
                                <h6>Antibiotic IV</h6>
                            </div>
                            <div class="card-history">

                                <table class="breachReasonTable responsiveTable table-history">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>#</th>
                                        <th>Start</th>
                                        <th>End</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($iv_history_list as $data)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">#</div>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Start</div>
                                                @if(isset($data['start_date']) && !empty($data['start_date']))
                                                    {{ PredefinedDateFormatFor24Hour($data['start_date']) }}
                                                @endif
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">End</div>
                                                @if(isset($data['end_date']) && !empty($data['end_date']))
                                                    {{ PredefinedDateFormatFor24Hour($data['end_date']) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="no-records">
                                            <td class="pivoted text-center" colspan="3">{{ NotFoundMessage() }}</td>
                                        </tr>


                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="iv-header">
                                <h6>Antibiotic ORAL</h6>
                            </div>
                            <div class="card-history">
                                <table class="breachReasonTable responsiveTable table-history">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>#</th>
                                        <th>Start</th>
                                        <th>End</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($oral_history_list as $data)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">#</div>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Start</div>
                                                @if(isset($data['start_date']) && !empty($data['start_date']))
                                                    {{ PredefinedDateFormatFor24Hour($data['start_date']) }}
                                                @endif
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">End</div>
                                                @if(isset($data['end_date']) && !empty($data['end_date']))
                                                    {{ PredefinedDateFormatFor24Hour($data['end_date']) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    <tr class="no-records">
                                        <td class="pivoted text-center" colspan="3">{{ NotFoundMessage() }}</td>
                                    </tr>

                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>












</div>
<script>
    $('#pharmacy_latest_comment').on('input', function(){

        $('.camis_patient_ward_summary_boardround_save_pharmacy_info').removeClass('disabled');
    });
</script>

