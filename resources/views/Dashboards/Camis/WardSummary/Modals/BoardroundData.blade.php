<div class="row mb-3">
    <div class="col-12 ">
        <div class="row g-2 mb-2">
            <div class="col-md-12">
                <button type="button" data-boardround-config="bed_order" class="btn btn-primary-grey @if(session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order')) bg-complete @endif {{ Session::get('type') == 'bed_order'? 'active' : '' }} boardround_config_type config_type_bed_order">BOARD ROUND
                    IN BED ORDER
                    <span class="timestamp-complete time_bed_order">@if(session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order')) Completed ( {{ \Illuminate\Support\Str::before(session()->get('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order'), '_') }}) @endif</span>
                </button>
            </div>
            @if(count($success_array['consultnat_list']) > 0)
            <div class="p-2 text-center">
                <p class="mb-0">Board Round With The Following Consultant</p>
            </div>
                @foreach($success_array['consultnat_list'] as $consultant_code => $consultant_name)
                    <div class="col-md-6">
                        <button type="button" data-boardround-config="{{ $consultant_code }}"
                                class="btn btn-primary-grey w-100 boardround_type_other @if(in_array($consultant_code, $success_array['done_board_round']) || session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order')) bg-complete @else @if(session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_'.$consultant_code)) bg-complete @endif @endif {{ Session::get('doctor_id') == $consultant_code ? 'active' : '' }}  boardround_config_type config_type_{{ $consultant_code }}">
                            {{ $consultant_name }}

                            <span class="timestamp-complete time_{{ $consultant_code }}">@if(in_array($consultant_code, $success_array['done_board_round']) || session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order')) Completed ({{ \Illuminate\Support\Str::before(session()->get('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order', CurrentDateOnFormat()), '_') }})  @else @if(session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_'.$consultant_code)) Completed ( {{ \Illuminate\Support\Str::before(session()->get('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_'.$consultant_code), '_') }}) @endif @endif</span>

                        </button>
                    </div>
                @endforeach
            @endif
            {{-- @if(isset($success_array['stranded_patient']) && $success_array['stranded_patient'] > 0)
                <div class="col-md-12">
                    <button type="button" data-boardround-config="stranded" class="btn btn-primary-grey w-100 boardround_type_other @if(session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order') || session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order')) bg-complete @else @if(session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_stranded')) bg-complete @endif @endif {{ Session::get('type') == 'stranded'? 'active' : '' }} boardround_config_type config_type_stranded"> STRANDED
                        <span class="timestamp-complete time_bed_order">@if(session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order') || session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order')) Completed ( {{ \Illuminate\Support\Str::before(session()->get('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_bed_order'), '_') }})   @else @if(session()->has('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_stranded')) Completed ( {{ \Illuminate\Support\Str::before(session()->get('_ibox_'.$success_array['ward_details']['id'].'_'.$success_array['user_id'].'_stranded'), '_') }}) @endif @endif</span>
                    </button>
                </div>
            @endif --}}




        </div>
        @if($success_array['exist_board_round'] = 1 && count($success_array['missed_patient_list']) > 0)
        <input type="hidden" id="missed_boardround_patients" value="{{ count($success_array['missed_patient_list']) }}">
        <div class="missing-patients-card">
            <div class="rectangle-block-1 ">
                <div class="row mb-2">
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center justify-content-between rectangle-block-2">
                            <p class="mb-0">Patients NOT Updated During This Board Round Session</p>
                            <button class="btn btn-primary board_round_restart " data-boardround-missed="1"><i class="bi bi-hand-index-thumb me-2"></i>Update
                                Patients In List Below</button>
                        </div>
                    </div>
                </div>
                <div class="data-area">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-table-listing">
                                <table class="responsiveTable table-listing">
                                    <thead>
                                        <tr class="position-relative">
                                            <th>Bay &amp; Bed No</th>
                                            <th>Patient Name</th>
                                            <th>PAS Number</th>
                                            <th>Patient ID</th>
                                            <th>Consultant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($success_array['missed_patient_list'] as $missed_patient)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Bay &amp; Bed No</div>
                                                {{ $missed_patient['ibox_actual_bed_full_name'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Patient Name</div>
                                                {{ $missed_patient['camis_patient_name'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">PAS Number</div>
                                                {{ $missed_patient['camis_patient_pas_number'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Patient ID</div>
                                                {{ $missed_patient['camis_patient_id'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Consultant</div>
                                                {{ $missed_patient['camis_consultant_name'] }}
                                            </td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
    <input type="hidden" id="missed_boardround_patients" value="0">
    @endif
    </div>
</div>
<input type="hidden" name="is_board_round_done" id='is_board_round_done' value="{{ $success_array['status'] }}" />
