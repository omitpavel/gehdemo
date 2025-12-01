<input type="hidden" name="ibox_board_round_patient_pharmacy_drug_history" id="ibox_board_round_patient_pharmacy_drug_history" value="{{$success_array['pharmacy_data']['pharmacy_drug_history']}}" />
<input type="hidden" name="ibox_board_round_patient_pharmacy_drug_history_date" id="ibox_board_round_patient_pharmacy_drug_history_date" value="{{$success_array['pharmacy_data']['pharmacy_drug_history_date']}}" />

<input type="hidden" name="ibox_board_round_patient_pharmacy_antibiotic_iv_status" id="ibox_board_round_patient_pharmacy_antibiotic_iv_status" value="{{$success_array['pharmacy_data']['pharmacy_antibiotic_iv_status']}}" />
<input type="hidden" name="ibox_board_round_patient_pharmacy_antibiotic_iv_date" id="ibox_board_round_patient_pharmacy_antibiotic_iv_date" value="{{$success_array['pharmacy_data']['pharmacy_antibiotic_iv_date']}}" />

<input type="hidden" name="ibox_board_round_patient_pharmacy_antibiotic_oral_status" id="ibox_board_round_patient_pharmacy_antibiotic_oral_status" value="{{$success_array['pharmacy_data']['pharmacy_antibiotic_oral_status']}}" />
<input type="hidden" name="ibox_board_round_patient_pharmacy_antibiotic_oral_date" id="ibox_board_round_patient_pharmacy_antibiotic_oral_date" value="{{$success_array['pharmacy_data']['pharmacy_antibiotic_oral_date']}}" />

<input type="hidden" name="ibox_board_round_patient_current_date" id="ibox_board_round_patient_current_date" value="{{ $success_array['current_date'] }}" />
<input type="hidden" name="ibox_board_round_patient_current_date_formatted" id="ibox_board_round_patient_current_date_formatted" value="{{ $success_array['current_date_formatted'] }}" />


<div class="topRow">
    <ul class="redBtnGrouplistTop">
        <li>
            <button data-pharmacy-drug-history-value='1' class="patient_pharmacy_drug_history patient_pharmacy_drug_history_1 innerBtn ibox_buttons button_red_gradiant topRowBtn active" name="partial">
                Drug History Partial
                <svg class="icon patient_drug_history_tick_icon patient_drug_history_tick_icon_1  @if($success_array['pharmacy_data']['pharmacy_drug_history'] != 1) content_display_none @endif" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16" size="14" height="14" width="14">
                    <path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5L12 5z"></path>
                </svg>
            </button>
            <span class="updated patient_drug_history_updated_date patient_drug_history_updated_date_1">@if($success_array['pharmacy_data']['pharmacy_drug_history'] == 1) {{ $success_array['pharmacy_data']['pharmacy_drug_history_date_show'] }} @endif</span>
        </li>
        <li>
            <button data-pharmacy-drug-history-value='2' class="patient_pharmacy_drug_history patient_pharmacy_drug_history_2 innerBtn ibox_buttons button_red_gradiant topRowBtn active" name="full">
                Drug History Full
                <svg class="icon patient_drug_history_tick_icon patient_drug_history_tick_icon_2 @if($success_array['pharmacy_data']['pharmacy_drug_history'] != 2) content_display_none @endif" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16" size="14" height="14" width="14">
                <path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5L12 5z"></path>
            </svg>
            </button>

            <span class="updated patient_drug_history_updated_date patient_drug_history_updated_date_2">@if($success_array['pharmacy_data']['pharmacy_drug_history'] == 2) {{ $success_array['pharmacy_data']['pharmacy_drug_history_date_show'] }} @endif</span>
        </li>
        <li>
            <button data-pharmacy-drug-history-value='3' class="patient_pharmacy_drug_history patient_pharmacy_drug_history_3 innerBtn ibox_buttons button_red_gradiant topRowBtn active" name="reviewed">
                Medication In Draft To Be Reviewed
                <svg class="icon patient_drug_history_tick_icon patient_drug_history_tick_icon_3 @if($success_array['pharmacy_data']['pharmacy_drug_history'] != 3) content_display_none @endif" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16" size="14" height="14" width="14">
                <path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5L12 5z"></path>
            </svg>
            </button>

            <span class="updated patient_drug_history_updated_date patient_drug_history_updated_date_3">@if($success_array['pharmacy_data']['pharmacy_drug_history'] == 3) {{ $success_array['pharmacy_data']['pharmacy_drug_history_date_show'] }} @endif</span>
        </li>
    </ul>
</div>
<div class="antiBioticRow">
    <div class="box antibiotContBox">
        <span class="head">Antibiotics :</span>
    </div>
    <div class="box">
        <button class="innerBtn patient_pharmacy_antibiotic_iv ibox_buttons button_light_blue_gradiant antiBioticBtn active" name="iv">
            IV
            <svg class="icon patient_pharmacy_antibiotic_iv_tick @if($success_array['pharmacy_data']['pharmacy_antibiotic_iv_status'] != 1) content_display_none @endif"  stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16" size="14" height="14" width="14">
                <path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5L12 5z"></path>
            </svg>
        </button>
        <span class="updated patient_pharmacy_antibiotic_iv_updated_date">{{ $success_array['pharmacy_data']['pharmacy_antibiotic_iv_date_show']  }}</span>
    </div>
    <div class="box">
        <button class="innerBtn patient_pharmacy_antibiotic_oral ibox_buttons button_light_blue_gradiant antiBioticBtn active" name="oral">
            Oral
            <svg class="icon patient_pharmacy_antibiotic_oral_tick @if($success_array['pharmacy_data']['pharmacy_antibiotic_oral_status'] != 1) content_display_none @endif"   stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16" size="14" height="14" width="14">
                <path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5L12 5z"></path>
            </svg>
        </button>
        <span class="updated patient_pharmacy_antibiotic_oral_updated_date">{{ $success_array['pharmacy_data']['pharmacy_antibiotic_oral_date_show']  }}</span>
    </div>
</div>
<div class="pharmacyCommentwrap">
    <textarea name="pharmacy_latest_comment" id='pharmacy_latest_comment' class='pharmacy_latest_comment form-control' placeholder="Pharmacy Comments"></textarea>
</div>

@if (count($success_array['pharmacy_comment_data']) > 0)
    <div class="commentsTable">
        <table class="responsiveTable">
            <thead>
                <tr>
                    <th width='55%'>Comments</th>
                    <th>User</th>
                    <th>Date &amp; Time</th>
                    <th>Copy</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($success_array['pharmacy_comment_data'] as $row)
                    <tr>
                        <td class="pivoted">
                            <div class="tdBefore">Comments</div>
                            <span class='boardround_pharmacy_patient_comment_text_show_{{ $row->id }}'>{{ $row->pharmacy_comment }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">User</div>
                            {{ $row->pharmacy_comment }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Date &amp; Time</div>
                            {{ PredefinedDateFormatFor24Hour($row->created_at) }}
                        </td>
                        <td class="copycell pivoted boardround_pharmacy_patient_comment_text_copy" data-comment-text-show-id="{{ $row->id }}">
                            <div class="tdBefore">Copy</div>
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" size="20" color="#000" height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="color: rgb(0, 0, 0)">
                                <path d="M832 64H296c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h496v688c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8V96c0-17.7-14.3-32-32-32zM704 192H192c-17.7 0-32 14.3-32 32v530.7c0 8.5 3.4 16.6 9.4 22.6l173.3 173.3c2.2 2.2 4.7 4 7.4 5.5v1.9h4.2c3.5 1.3 7.2 2 11 2H704c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32zM350 856.2L263.9 770H350v86.2zM664 888H414V746c0-22.1-17.9-40-40-40H232V264h432v624z">
                                </path>
                            </svg>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
