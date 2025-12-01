<div class="col-lg-12">
    <div class="fixed-section">
        <div id="">
            <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2" onclick="TabSwitcher('only_infected');">
                    <a class="tab-custom-btn @if(request()->tab == 'only_infected') active @endif" >
                        <div class="tab-active">Inpatients With Infections</div>
                    </a>
                </li>
                <li class="mb-2"  onclick="TabSwitcher('all_patients');">
                    <a class="tab-custom-btn @if(request()->tab == 'all_patients') active @endif">
                        <div class="tab-active">All Inpatients</div>
                    </a>
                </li>
                <li class="mb-2"  onclick="TabSwitcher('all_patients_filter');">
                    <a class="tab-custom-btn @if(request()->tab == 'all_patients_filter') active @endif">
                        <div class="tab-active">All Patients</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="row gx-2">
            @if(request()->tab != 'all_patients_filter')
            <div class="col-xxl-3 col-md-4 mb-2">
                <div class="search-fields">
                    <label for="search_text" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search_text" aria-describedby="" value="{{ request()->search_text }}">
                </div>

            </div>


            <div class="col-xxl-3 col-md-3 mb-2">
                <div class="search-fields">
                    <label for="name" class="form-label">Search By Infection</label>
                    <select class="3col active" aria-label="Default select example" id="infection"  multiple="multiple">
                        @foreach ($success_array['all_infections'] as $item)
                            <option value="{{ $item }}" @if(request()->filled('infection') && in_array($item, request()->infection)) selected @endif>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="col-xxl-3 col-md-3 mb-2">
                <div class="search-fields">
                    <label for="name-label" class="form-label">Search By Wards </label>
                {!! AllWardListDropdownShortName() !!}
                </div>
            </div>

            <div class="col-xxl-1 col-md-2 mb-2">
                <div class="pt-1 mt-md-3">
                    <button class="btn btn-search w-100 search_data"><img src="{{ asset('asset_v2/Template/icons/search.svg') }}" alt=""
                            class="me-2" width="15" height="15"> Search</button>
                </div>
            </div>
            @else
            <div class="col-xxl-3 col-lg-3 col-md-6 mb-2">
                <div class="search-fields">
                    <label for="search_text" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search_text" aria-describedby="" value="{{ request()->search_text }}">
                </div>

            </div>
            <div class="col-xxl-1 col-lg-2 col-md-2 mb-2">
                <div class="pt-1 mt-md-3">
                    <button class="btn btn-search w-100 search_data"><img src="{{ asset('asset_v2/Template/icons/search.svg') }}" alt=""
                            class="me-2" width="15" height="15"> Search</button>
                </div>
            </div>
            @endif
            <div class="borderline-bottom"></div>
        </div>
    </div>
    <div class="patients-tracing mb-2">
        @if (count($success_array['patients_list']) > 0)
            @foreach ($success_array['patients_list'] as $ward_name => $patients)



            <div class="card-tracing-details">
                <div class="name-header">
                    <span>{{ $ward_name }}</span>
                </div>



                <table class="responsiveTable table-contact-tracing">
                    <thead>
                        <tr class="position-relative">
                            <th>Hospital Number</th>
                            <th>Name</th>
                            <th>Ward</th>
                            <th>Bay & Bed</th>
                            <th>Infection</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($patients as $row)
                        {{-- <tr class="@if(strtolower($row['patient_covid_main_details']['covid_result']) == 'positive' ) bg-red @else bg-green @endif bg-red"> --}}
                            <td class="pivoted">
                                <div class="tdBefore">Hospital Number</div>
                                {{ $row['camis_patient_pas_number'] }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Name</div>
                                <div class="patient-gender">

                                    @if($row['camis_patient_sex'] == 'female')
                                    <img src="{{ asset('asset_v2/Template/icons/female-icon.svg') }}" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Female">
                                    @elseif($row['camis_patient_sex'] == 'male')
                                    <img src="{{ asset('asset_v2/Template/icons/male-icon.svg') }}" alt=""  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Male">
                                    @endif
                                </div> {{ $row['camis_patient_name'] }}
                            </td>

                            <td class="pivoted">
                                <div class="tdBefore">Ward</div>
                                {{ $row['ward_name'] }}
                            </td>

                            <td class="pivoted">
                                <div class="tdBefore">Applied Time</div>
                                {{ $row['bed_name'] }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Status</div>
                            {{ $row['alert'] }} @if(!empty($row['alert_code'])) {{ $row['alert_code'] }} @endif
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Action</div>
                                <button class="btn btn-trace click_open_inpatient_trace" data-patient-id="{{ $row['camis_patient_id'] }}">Trace</button>
                            </td>
                        </tr>

                    @empty
                    <tr class="blank-row">
                        <td class="text-center" colspan="8">{{ NotFoundMessage() }}</td>
                    </tr>

                    @endforelse
                    </tbody>
                </table>
            </div>
            @endforeach
        @else
        <div class="custom_not_found">
            {{ NotFoundMessage() }}
        </div>
        @endif
    </div>
</div>
<script>
$(function() {
    var available_pas_number_patients = <?php echo $success_array['pas_number_pat_list']; ?>;
    $("#name").autocomplete({
        source: available_pas_number_patients
    });

    var available_patient_name_patients = <?php echo $success_array['patient_name_pat_list']; ?>;
    $("#name").autocomplete({
        source: available_patient_name_patients
    });
});
</script>
<script>
    var windowWidth = window.innerWidth;
    var bgSticky = document.querySelector('.bg-sticky');
    var noRecords = document.querySelector('.custom_not_found');
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {

            var noRecords = document.querySelector('.fixed-section');
            if (noRecords) {
                noRecords.style.top = '85px';
            }
        }



    }
</script>
