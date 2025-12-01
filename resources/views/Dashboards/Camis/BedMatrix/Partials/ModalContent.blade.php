@if (count($success_array['ward_patient_list_array']) > 0)
    @foreach ($success_array['ward_patient_list_array'] as $key => $pat_list_array)

        <div class="side-room ">
            <div class="row gx-2 {{ PermissionDeniedDiv('camis_boardround_view') }}" id="spl-cols">
                <div class="col-12">
                    <div class="row gx-2">
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-2">
                            <div class="wrapper-head @if(GetBayStatus($pat_list_array['0']['ibox_ward_id'], $pat_list_array['0']['ibox_bed_group_number'], $pat_list_array['0']['ibox_bed_group_id']) == 1) bay-closed @elseif(GetBayStatus($pat_list_array['0']['ibox_ward_id'], $pat_list_array['0']['ibox_bed_group_number'], $pat_list_array['0']['ibox_bed_group_id']) == 2) bay-restricted @endif gx-2" id="bay_class_{{ $pat_list_array['0']['ibox_ward_id'] }}_{{ $pat_list_array['0']['ibox_bed_group_number'] }}_{{ $pat_list_array['0']['ibox_bed_group_id'] }}">
                                <div class="header-left">{{ $key }}</div>
                                <div class="status-bay">
                                    <button class="btn btn-primary-grey click_open_close_bay_restriction" @if (count($pat_list_array) > 0) data-ward_id="{{ $pat_list_array['0']['ibox_ward_id'] }}" data-bed_group_number="{{ $pat_list_array['0']['ibox_bed_group_number'] }}" data-bed_group_id="{{ $pat_list_array['0']['ibox_bed_group_id'] }}" @else data-ward_id="" data-bed_group_number="0" data-bed_group_id="0" @endif id="bay_status_{{ $pat_list_array['0']['ibox_ward_id'] }}_{{ $pat_list_array['0']['ibox_bed_group_number'] }}_{{ $pat_list_array['0']['ibox_bed_group_id'] }}"> @if(GetBayStatus($pat_list_array['0']['ibox_ward_id'], $pat_list_array['0']['ibox_bed_group_number'], $pat_list_array['0']['ibox_bed_group_id']) == 0) BAY OPEN @elseif(GetBayStatus($pat_list_array['0']['ibox_ward_id'], $pat_list_array['0']['ibox_bed_group_number'], $pat_list_array['0']['ibox_bed_group_id']) == 1) BAY CLOSE @else BAY Restricted @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                @if (count($pat_list_array) > 0)
                        @foreach ($pat_list_array as $pat_data)
                            @if ($pat_data['camis_patient_id'] != '')
                                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-2">
                                    <div class="medical-details-card ">
                                        <div class="row">
                                            <div class="col-9 pe-0 ps-0">
                                                <div class="ward-header-row @if($pat_data['reverse_barrier_status'] == 1) bg-reverse-barrier @endif">
                                                        <div class="header-col-1 bg-blue-bed-no">
                                                            <h6 class="mb-0 text-center">{{ $pat_data['ibox_bed_no'] }}</h6>
                                                        </div>
                                                        @if(isset($pat_data['allowed_to_move']['patient_allowed_to_be_moved_to']) && $pat_data['allowed_to_move']['patient_allowed_to_be_moved_to'] == 'Do Not Move')
                                                            <div class="header-col-1 bg-red">
                                                                <img src="{{ asset('asset_v2/Template/icons/lock.svg') }}" alt="Bed Lock"  data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" title="Do Not Move">
                                                            </div>
                                                        @endif
                                                        @if(in_array($pat_data['ibox_ward_short_name'], ['RLTAMU01', 'RLTAMU02']))
                                                            <div class="header-col-3   @if($pat_data['ibox_patient_admit_date_los_value'] >= 21) bed_black_background @elseif($pat_data['ibox_patient_admit_date_los_value'] >= 5 && $pat_data['ibox_patient_admit_date_los_value'] < 21) bed_red_background @elseif($pat_data['ibox_patient_admit_date_los_value'] >= 3 && $pat_data['ibox_patient_admit_date_los_value'] < 5) bed_amber_background @else bg-dark-blue @endif">
                                                                <span>LOS  {{ $pat_data['ibox_patient_admit_date_los_value'] }} Days </span>
                                                            </div>
                                                        @else
                                                            <div class="header-col-3   @if($pat_data['ibox_patient_admit_date_los_value'] >= 21) bed_black_background @elseif($pat_data['ibox_patient_admit_date_los_value'] >= 7) bed_red_background @else bg-dark-blue @endif">
                                                                <span>LOS @if($pat_data['ibox_ward_short_name'] == 'RLTSAUIP') {{ $pat_data['ibox_patient_admit_date_los_value_hour'] }} Hours @else {{ $pat_data['ibox_patient_admit_date_los_value'] }} Days @endif</span>
                                                            </div>
                                                        @endif



                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="card-medical">
                                                        <div class="patient-data-table">

                                                            <div class="patient-data">
                                                                <div class="gender-icon">
                                                                   @if (strtolower($pat_data['camis_patient_sex']) == 'male')
                                                                        <img src="{{ asset('asset_v2/Template/icons/gender-male.svg') }}" alt=""  data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="Male">
                                                                    @elseif (strtolower($pat_data['camis_patient_sex']) == 'female')
                                                                        <img src="{{ asset('asset_v2/Template/icons/gender-female.svg') }}" alt=""  data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="Female">
                                                                    @endif
                                                                </div>
                                                                <div class="name">
                                                                    <span class="patient_name_hide_on_request @if ($pat_data['ibox_patient_surname_count'] > 1) SurNameRepeat @endif">{{ $pat_data['ibox_patient_hide_name'] }}</span>
                                                                    <span class="content_display_none patient_name_show_on_request @if ($pat_data['ibox_patient_surname_count'] > 1) SurNameRepeat @endif"> {{ $pat_data['camis_patient_name'] }}</span>
                                                                    <span class="pass-id">({{ $pat_data['camis_patient_pas_number'] }})</span>
                                                                </div>
                                                            </div>
                                                            <div class="edd-data">
                                                                <div class="label-edd">
                                                                    <span>EDD</span>
                                                                </div>
                                                                <div class="value-edd">
                                                                    @if(isset($pat_data['board_round_estimated_discharge_date']))
                                                                        <span class="fw-bold @if(\Carbon\Carbon::parse($pat_data['board_round_estimated_discharge_date']['patient_estimated_discharge_date'])->isPast()) text-danger @else text-success @endif">{{ PredefinedDateFormatForEDD($pat_data['board_round_estimated_discharge_date']['patient_estimated_discharge_date']) }}</span>
                                                                    @else
                                                                        <span class="fw-bold text-danger">No EDD Set</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="medfit-data">
                                                                <div class="label-medfit">
                                                                    <span>MED FIT</span>
                                                                </div>
                                                                <div class="value-medfit">
                                                                    @if(isset($pat_data['board_round_medically_fit_data']['patient_medically_fit_status']))
                                                                        @if($pat_data['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)
                                                                            <span class="fw-bold text-success">Yes</span>
                                                                        @else
                                                                            <span class="fw-bold text-danger">No</span>
                                                                        @endif
                                                                    @else
                                                                        <span class="fw-bold text-danger">No</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="doctor-data" >
                                                                <div class="name @if(strtolower($pat_data['ibox_ward_short_name']) == 'talb' && $pat_data['camis_consultant_code_group'] == 'Haematology') TALB_Haematology_consultant_color @elseif(strtolower($pat_data['ibox_ward_short_name']) == 'talb' && $pat_data['camis_consultant_code_group'] == 'Oncology') TALB_Oncology_consultant_color @endif ">
                                                                    <span @if(!empty($pat_data['camis_consultant_code_description']))  data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $pat_data['camis_consultant_code_description'] }}" @endif>{{ \Illuminate\Support\Str::limit($pat_data['camis_consultant_name'], 28, '...') }}</span>

                                                                </div>
                                                            </div>
                                                            @if($pat_data['reverse_barrier_status'] == 1)
                                                                <div class="barrier-data">
                                                                    <div class="content">
                                                                        <span>Reverse Barrier</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 ps-0 pe-0 bg-col-grey">
                                                <div class="bg-blue @if($pat_data['reverse_barrier_status'] == 1) bg-reverse-barrier @endif">
                                                    <div class="row w-100">
                                                        <div class="col-12 p-0">
                                                            <div class="task-row">
                                                                @if(isset($pat_data['potential_definite']) && ($pat_data['potential_definite']['potential_definite_date'] != null))

                                                                @php
                                                                    $pd_date = \Carbon\Carbon::parse($pat_data['potential_definite']['potential_definite_date']);
                                                                    $today = \Carbon\Carbon::today();
                                                                    $tomorrow = \Carbon\Carbon::tomorrow();
                                                                @endphp
                                                                <div class="task-col-1">
                                                                    <div class="white-round">
                                                                        @if($pat_data['potential_definite']['type'] == 1)
                                                                            <span data-bs-toggle="tooltip"
                                                                                  data-bs-placement="bottom" @if($pd_date->isToday())
                                                                                  title="Potential Discharges Today"
                                                                                  @elseif($pd_date->isSameDay($tomorrow))
                                                                                  title="Potential Discharges On {{ $pd_date->format('l') }}"
                                                                                  @elseif($pd_date->gt($tomorrow))
                                                                                  title="Potential Discharges On {{ $pd_date->format('l') }}"
                                                                                  @else
                                                                                  title="Potential Discharges On {{ PredefinedDateFormatForPD($pd_date->format('Y-m-d')) }}"
                                                                            @endif>P</span>
                                                                        @elseif($pat_data['potential_definite']['type'] == 2)
                                                                            <span data-bs-toggle="tooltip"
                                                                                  data-bs-placement="bottom" @if($pd_date->isToday())
                                                                                  title="Definite Discharges Today"
                                                                                  @elseif($pd_date->isSameDay($tomorrow))
                                                                                  title="Definite Discharges On {{ $pd_date->format('l') }}"
                                                                                  @elseif($pd_date->gt($tomorrow))
                                                                                  title="Definite Discharges On {{ $pd_date->format('l') }}"
                                                                                  @else
                                                                                  title="Definite Discharges On {{ PredefinedDateFormatForPD($pd_date->format('Y-m-d')) }}"
                                                                            @endif>D</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @endif

                                                                @if(isset($pat_data['red_green_bed']) && count($pat_data['red_green_bed']) > 0)
                                                                    <div class="task-col-1" @if(isset($pat_data['red_green_bed']['red_green_reason']['red_text_value'])) data-bs-toggle="tooltip" data-bs-placement="top" title="{{$pat_data['red_green_bed']['red_green_reason']['red_text_value']}}" @endif>
                                                                        @if($pat_data['red_green_bed']['patient_red_green_status'] == 1)

                                                                            <div class="red-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Red Bed">
                                                                                <span>{{ floor(abs(time() - strtotime($pat_data['red_green_bed']['updated_at'])) / (60 * 60 * 24)) }}</span>
                                                                            </div>

                                                                        @else
                                                                            <div class="green-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Green Bed">
                                                                                <span>{{ floor(abs(time() - strtotime($pat_data['red_green_bed']['updated_at'])) / (60 * 60 * 24)) }}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else

                                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-2 update_bed_status" data-ward-bed-id="{{ $pat_data['ibox_ward_bed_id'] }}"  data-ward-id="{{ $pat_data['ibox_ward_id'] }}"  data-ward-bed-no=": {{ $pat_data['ibox_actual_bed_full_name'] }}">
                                    <div class="medical-details-card cursor-pointer">
                                        <div class="row">
                                            <div
                                                class="col-xl-12 col-lg-12 col-md-12 col-12 @if(isset($pat_data['ibox_bed_status']['status']) && $pat_data['ibox_bed_status']['status'] == 0 || $pat_data['ibox_bed_status_camis'] == 'open')  bg-bed-empty @else bg-bed-closed @endif
                                                justify-content-between ps-2">
                                                <h6 class="mb-0 text-center">{{ $pat_data['ibox_bed_no'] }}</h6>
                                                <div>
                                                    <i class="bi bi-hand-index-thumb me-2"></i>
                                                    <span class="text-notification">On click to set status</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-medical">
                                            <div class="closed-message">
                                                <span id="ward_close_status_{{ $pat_data['ibox_ward_bed_id'] }}">
                                                    @if(isset($pat_data['ibox_bed_status']['status']))
                                                        @if($pat_data['ibox_bed_status']['status'] == 0)
                                                            Bed Open: Empty
                                                        @elseif($pat_data['ibox_bed_status']['status'] == 1)
                                                            Bed Closed
                                                        @elseif($pat_data['ibox_bed_status']['status'] == 2)
                                                            Bed Restricted
                                                        @elseif($pat_data['ibox_bed_status']['status'] == 3)
                                                            Bed Out Of Service
                                                        @elseif($pat_data['ibox_bed_status']['status'] == 4)
                                                            Bed Reserved @if(!empty($pat_data['ibox_bed_status']['reserved_for'])) For {{ $pat_data['ibox_bed_status']['reserved_for'] }}<br>({{ $pat_data['ibox_bed_status']['patient_name'] }}) @endif
                                                        @endif
                                                    @else

                                                    @if ($pat_data['ibox_bed_status_camis'] == 'open') Bed Open: Empty @else Bed Closed: {{ ucfirst(strtolower($pat_data['ibox_bed_status_camis'])) }} @endif

                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                @endif
            </div>
        </div>
    @endforeach
@endif
