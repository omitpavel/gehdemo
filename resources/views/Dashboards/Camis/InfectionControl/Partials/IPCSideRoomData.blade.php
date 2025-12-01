<input type="hidden" id="ipc_edit_patient_id" value="">
<div class="col-lg-12">
    <div class="ipc-filters" id="ipcFilters">
        <div class="row row-cols-xl-5 row-cols-md-3 row-cols-1 gx-2">
            <div class="col mb-2">
                <select class="3col active"  multiple="multiple" aria-label="Default select example" id="ward_id">
                    <optgroup label="Medical Wards">
                        @foreach ($medical_wards as $ward)
                        <option value="{{ $ward['id'] }}" @if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif >
                            {{ $ward['ward_name'] }}</option>
                        @endforeach

                    </optgroup>
                    <optgroup label="Surgical Wards">
                        @foreach ($surgical_wards as $ward)
                        <option value="{{ $ward['id'] }}"@if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                            {{ $ward['ward_name'] }}</option>
                        @endforeach

                    </optgroup>
                    <optgroup label="Womens & Childrens Wards">
                        @foreach ($womens_wards as $ward)
                        <option value="{{ $ward['id'] }}"@if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                            {{ $ward['ward_name'] }}</option>
                        @endforeach

                    </optgroup>
                    <optgroup label="Others Wards">
                        @foreach ($other_wards as $ward)
                        <option value="{{ $ward['id'] }}" @if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                            {{ $ward['ward_name'] }}</option>
                        @endforeach

                    </optgroup>

                </select>



            </div>
            <div class="col mb-2">
                <button id="" type="button" class="btn btn-ipc-green {{ request()->can_be_move == 1 ? 'active' : '' }}">Can Be Moved
                    <img src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt="" width="20px">
                </button>
            </div>
            <div class="col mb-2">
                <button id="" type="button" class="btn btn-ipc-red {{ request()->can_not_be_move == 1 ? 'active' : '' }}">Not To Be Moved
                    <img src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt="" width="20px">
                </button>
            </div>
            <div class="col mb-2">
                <div class="bg-patients-count">
                    <h6>Can Be Moved</h6>
                    <h5 class="count-moved">{{ $can_be_moved_count }}</h5>
                </div>
            </div>
            <div class="col mb-2">
                <div class="bg-patients-count">
                    <h6>Not To Be Moved</h6>
                    <h5 class="count-not-moved">{{ $can_not_be_moved_count }}</h5>
                </div>
            </div>
        </div>

    </div>
    <div class="ipc-content-wrapper"  id="ipcCcontentWrapper">
        @if(count($ipc_patient_list) > 0)
            @foreach ($ipc_patient_list as $ward_type => $ward_type_data )


                <div class="card-ipc">
                    <div class="ipc-ward-header">
                        <h6>{{ $ward_type }}</h6>
                    </div>
                    @foreach ($ward_type_data as $row_number => $ward_data)

                        <div class="ipc-wrapper">
                            @php
                                $ward_array = [];
                                foreach ($ward_data as $ward_full_name_key => $ward_full_value) {
                                    foreach ($ward_full_value as $ward_key_value => $ward_key_value_data) {

                                        $ward_array[] = $ward_key_value_data;
                                    }
                                }


                            @endphp
                            <table class="responsiveTable table-ipc-sideroom @if(count($ward_array) < 6) w-{{ count($ward_array) }} @endif">
                                <thead>
                                    <tr>
                                        @foreach ($ward_data as $ward_key_data => $ward_value_data)
                                            <th colspan="{{ count($ward_value_data) }}" class="text-center">
                                                {{ $ward_key_data }}
                                            </th>
                                        @endforeach
                                    </tr>
                                    <tr >
                                        @foreach ($ward_array as $ward_name => $bed_name)

                                            <th  class="th_scub_bed_{{ $bed_name['scub_ward_id'] }} @if(isset($bed_name['camis_patient_id']) && !empty($bed_name['camis_patient_id'])) cursor_pointer click_open_infection_offcanvas reverse_barrier_bed_name_class_{{ $bed_name['camis_patient_id'] }} @if($bed_name['reverse_barrier_status'] == 1) bg-reverse-barrier is_reverse_barrier @endif @if($bed_name['is_infected_bg'] == 1) is_infected @endif" data-patient-id="{{ $bed_name['camis_patient_id'] }}" @endif data-patient-flag-stored-name="ibox_patient_flag_infection_risk"  data-patient-flag-show-name="Infection Risk">
                                                <div class="spl-th">
                                                    <div>{{ $bed_name['ibox_actual_bed_full_name'] }}</div>
                                                    @if(isset($bed_name['camis_patient_id']) && !empty($bed_name['camis_patient_id']))
                                                        <i class="bi bi-hand-index-thumb"></i>
                                                    @endif
                                                </div>

                                            </th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>


                                    <tr>
                                        @foreach ($ward_data as $bed_key => $patient_bed)
                                            <td class="sm-ward-name">
                                                <span>{{ $bed_key }}</span>
                                            </td>
                                            @foreach ($patient_bed as $sideroom_name => $patient)

                                                @if($patient['camis_patient_id'] != '')

                                                    <td class="pivoted  ipc_scub_ward_bed_id_{{ $patient['scub_ward_id'] }}">
                                                        <div class="sm-sideroom-wrapper @if(isset($patient['camis_patient_id']) && !empty($patient['camis_patient_id'])) cursor_pointer click_open_infection_offcanvas reverse_barrier_bed_name_class_{{ $patient['camis_patient_id'] }} @if($patient['reverse_barrier_status'] == 1) bg-reverse-barrier is_reverse_barrier @endif @if($patient['is_infected_bg'] == 1) is_infected @endif"  data-patient-id="{{ $patient['camis_patient_id'] }}" @endif data-patient-flag-stored-name="ibox_patient_flag_infection_risk"  data-patient-flag-show-name="Infection Risk">
                                                            <div class="spl-th">
                                                                <div class="tdBefore">{{ $patient['ibox_actual_bed_full_name'] }} </div>
                                                                <i class="bi bi-hand-index-thumb"></i>
                                                            </div>
                                                        </div>
                                                        <div class="ipc-patient-details">

                                                            <div>
                                                                <div class="patient-gender">
                                                                    @if (strtolower($patient['camis_patient_sex']) == 'male')
                                                                        <img src="{{ asset('asset_v2/Template/icons/gender-male.svg') }}" alt=""  data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="Male">
                                                                    @elseif(strtolower($patient['camis_patient_sex']) == 'female')
                                                                        <img src="{{ asset('asset_v2/Template/icons/gender-female.svg') }}" alt=""  data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title="Female">
                                                                    @endif


                                                                </div>
                                                                <span class="name-span">{{ $patient['camis_patient_name'] }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="sub-title">Hospital Number:</span>
                                                                <span>{{ $patient['camis_patient_pas_number'] }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="sub-title">Con:</span>
                                                                <span>{{ $patient['camis_consultant_name'] }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="sub-title">LOS:</span>
                                                                <span>{{ $patient['los'] }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="sub-title">Admission:</span>
                                                                <span>{{ $patient['camis_patient_admission_date_time'] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="infection-details">
                                                            <div class="isolation-reason-symbol">
                                                                <div class="alert  bg-green infectied_div_green_{{ $patient['camis_patient_id'] }} @if($patient['is_infected'] != 0) d-none @endif" role="alert">Can be moved
                                                                </div>
                                                                <div class="alert  bg-red infectied_div_red_{{ $patient['camis_patient_id'] }} @if($patient['is_infected'] != 1) d-none @endif" role="alert">Not to be moved
                                                                </div>
                                                            </div>
                                                            <div class="reverse-barrier-section ">
                                                                <div class="alert  bg-red reverse_barrier_bed_list_class_{{ $patient['camis_patient_id'] }} @if($patient['reverse_barrier_status'] != 1) d-none @endif" role="alert">Reverse Barrier
                                                                </div>
                                                            </div>
                                                            @if(isset($patient['camis_patient_ward']) && $patient['camis_patient_ward'] == 'SCUB')
                                                                <div class="update-details-section click_update_scub_ward" data-scub_ward_id="{{ $patient['scub_ward_id'] }}">
                                                                    <button class="btn btn-update-details " >Update Details</button>
                                                                </div>
                                                            @endif
                                                            <div class="patient_infection_icon_{{ $patient['camis_patient_id'] }}">
                                                                @include('Dashboards.Camis.InfectionControl.Partials.IPCPatientInfectionIcon')
                                                            </div>
                                                        </div>
                                                    </td>

                                                @else

                                                    <td class="pivoted  ipc_scub_ward_bed_id_{{ $patient['scub_ward_id'] }}">
                                                        <div class="sm-sideroom-wrapper">
                                                            <div class="tdBefore">{{ $patient['ibox_actual_bed_full_name'] }}</div>
                                                        </div>
                                                        <div class="ipc-empty-bed">
                                                            @if(isset($patient['camis_patient_ward']) && $patient['camis_patient_ward'] == 'SCUB')
                                                                <div class="add-btn-wrap click_update_scub_ward"  data-scub_ward_id="{{ $patient['scub_ward_id'] }}">
                                                                    <button class="btn btn-primary-grey" >Add Patient</button>
                                                                </div>


                                                            @endif


                                                            @if(isset($patient['ibox_bed_status']['status']))
                                                                @if($patient['ibox_bed_status']['status'] == 0)
                                                                <h6>Bed Open</h6> <h6 class="mb-0">Empty</h6>
                                                                @elseif($patient['ibox_bed_status']['status'] == 1)
                                                                    <h6>Bed Closed</h6>
                                                                @elseif($patient['ibox_bed_status']['status'] == 2)
                                                                    <h6>Bed Restricted</h6>
                                                                @elseif($patient['ibox_bed_status']['status'] == 3)
                                                                    <h6 >Bed Out Of Service</h6>
                                                                @elseif($patient['ibox_bed_status']['status'] == 4)
                                                                    <h6>Bed Reserved</h6> @if(!empty($patient['ibox_bed_status']['reserved_for'])) <h6 class="mb-0">For {{ $patient['ibox_bed_status']['reserved_for'] }}</h6><h6 class="mb-0">({{ $patient['ibox_bed_status']['patient_name'] }})</h6> @endif
                                                                @endif
                                                            @else

                                                            @if ($patient['ibox_bed_status_camis'] == 'open') <h6>Bed Open</h6> <h6 class="mb-0">Empty</h6> @else <h6>Bed Closed</h6> <h6 class="mb-0">{{ ucfirst(strtolower($patient['ibox_bed_status_camis'])) }}</h6> @endif

                                                            @endif

                                                        </div>
                                                    </td>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tr>
                                </tbody>


                            </table>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="custom_not_found">{{ NotFoundMessage() }}</div>
        @endif
    </div>
</div>
<script>
    var windowWidth = window.innerWidth;
        if (windowWidth > 1199) {
            if (document.getElementById("marquee-content")) {
                document.getElementById("ipcFilters").style.top = "85px";
            }
            if (document.getElementById("ipcFilters")) {
                if (document.querySelector(".custom_not_found")) {
                    var noRecords = document.querySelector('.custom_not_found');
                    noRecords.style.marginTop = '40px';
                }
            }
        } else if (windowWidth > 1025 && windowWidth < 1200) {
            if (document.getElementById("marquee-content")) {
                document.getElementById("ipcFilters").style.top = "85px";
                document.getElementById("ipcFilters").style.height = "105px";
                document.getElementById("ipcCcontentWrapper").style.marginTop = "95px";
            } else {
                document.getElementById("ipcFilters").style.top = "64px";
                document.getElementById("ipcFilters").style.height = "100px";
                document.getElementById("ipcCcontentWrapper").style.marginTop = "99px";
            }
        }
</script>
