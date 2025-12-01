<div id="ImagePosition">
    <div class="img-position" id="img-position">
        <div class="text-center ane-image">
            <img src="{{ asset('asset_v2/Template/images/') }}{{ '/' . $success_array['opel_image'] . '.png' }}" alt="" class="img-fluid" id="theImage">
        </div>
        <div class="text-dta">
            <h6>WITH <br> DTA</h6>
            <h2  style="z-index: 4;cursor: pointer;" onclick="GetDetailsBySpecialityGraph('dta','all');">{{ $success_array['main_graph']['with_dta'] }}</h2>
        </div>
        <div class="text-ed">
            <h6>IN ED <br> NOW</h6>
            <h2  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('in_ed','all');">{{ $success_array['bar_graph']['in_ed_now'] }}</h2>
        </div>
        <div  class="text-opel " type="button" data-bs-toggle="modal" data-bs-target="#navigationModal">
            <h6 class="fw-bold  font_text_color_{{ $success_array['opel_status'] }}" id="opel_current">
                {{-- @if ($success_array['main_graph']['ane_opel_status_data_show_status'] != 0 && $success_array['main_graph']['ane_opel_status_data'] > 0)
                    {{ $success_array['main_graph']['ane_opel_status_data'] }}
                @else
                    &nbsp; &nbsp;  &nbsp;
                @endif --}}
                {{ $success_array['opel_status'] }}
            </h6>
        </div>
        <div class="text-triage">
            <div class="triage-details">
                <h6>TRIAGE<br> &gt;15 MINS</h6>
                <h2  style="z-index: 4;cursor: pointer;"
                   onclick="GetDetailsBySpecialityGraph('triage','all');">{{ $success_array['main_graph']['last_15_min_triage_count'] ?? 0 }}</h2>
            </div>
        </div>
        <div class="cyan-shape-1" >
            <img src="{{ asset('asset_v2/Template') }}/images/ane-cyan-shape.svg" alt="">
            <div class="text-paeds"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('in_ed','{{ $success_array['main_graph']['graph_data']['in_ed_now']['UTC']['key'] }}');">
                <h6>UTC</h6>
                <h2>{{ $success_array['main_graph']['graph_data']['in_ed_now']['UTC']['value'] ?? 0 }}</h2>
            </div>
        </div>
        <div class="cyan-shape-2" >
            <img src="{{ asset('asset_v2/Template') }}/images/ane-cyan-shape.svg" alt="">
            <div class="text-minor"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('in_ed','{{ $success_array['main_graph']['graph_data']['in_ed_now']['Majors']['key'] }}');">
                <h6>MAJORS</h6>
                <h2>{{ $success_array['main_graph']['graph_data']['in_ed_now']['Majors']['value'] ?? 0 }}</h2>
            </div>
        </div>
        <div class="cyan-shape-3"   >
            <img src="{{ asset('asset_v2/Template') }}/images/ane-cyan-shape.svg" alt="">
            <div class="text-major"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('in_ed','{{ $success_array['main_graph']['graph_data']['in_ed_now']['Resus']['key'] }}');">
                <h6>RESUS</h6>
                <h2>{{ $success_array['main_graph']['graph_data']['in_ed_now']['Resus']['value'] ?? 0 }}</h2>
            </div>
        </div>
        <div class="cyan-shape-4" >
            <img src="{{ asset('asset_v2/Template') }}/images/ane-cyan-shape.svg" alt="">
            <div class="text-resus"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('in_ed','{{ $success_array['main_graph']['graph_data']['in_ed_now']['Paeds']['key'] }}');">
                <h6>PAEDS</h6>
                <h2>{{ $success_array['main_graph']['graph_data']['in_ed_now']['Paeds']['value'] ?? 0 }}</h2>
            </div>
        </div>
        <div class="cyan-shape-5" >
            <img src="{{ asset('asset_v2/Template') }}/images/ane-cyan-shape.svg" alt="">
            <div class="text-custom"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('in_ed','{{ $success_array['main_graph']['graph_data']['in_ed_now']['Others']['key'] }}');">
                <h6>OTHERS</h6>
                <h2>{{ $success_array['main_graph']['graph_data']['in_ed_now']['Others']['value'] ?? 0 }}</h2>
            </div>
        </div>
        <div class="blue-shape-1" >
            <img src="{{ asset('asset_v2/Template') }}/images/ane-blue-shape.svg" alt="">
            <div class="text-paeds"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('dta','{{ $success_array['main_graph']['graph_data']['with_dta']['UTC']['key'] }}');">
                <h2>{{ $success_array['main_graph']['graph_data']['with_dta']['UTC']['value'] ?? 0 }}</h2>
                <h6>UTC</h6>
            </div>
        </div>
        <div class="blue-shape-2" >
            <img src="{{ asset('asset_v2/Template') }}/images/ane-blue-shape.svg" alt="">
            <div class="text-minor"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('dta','{{ $success_array['main_graph']['graph_data']['with_dta']['Majors']['key'] }}');">
                <h2>{{ $success_array['main_graph']['graph_data']['with_dta']['Majors']['value'] ?? 0 }}</h2>
                <h6>MAJORS</h6>
            </div>
        </div>
        <div class="blue-shape-3" >
            <img src="{{ asset('asset_v2/Template') }}/images/ane-blue-shape.svg" alt="">
            <div class="text-major"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('dta','{{ $success_array['main_graph']['graph_data']['with_dta']['Resus']['key'] }}');">
                <h2>{{ $success_array['main_graph']['graph_data']['with_dta']['Resus']['value'] ?? 0 }}</h2>
                <h6>RESUS</h6>
            </div>
        </div>
        <div class="blue-shape-4" >
            <img src="{{ asset('asset_v2/Template') }}/images/ane-blue-shape.svg" alt="">
            <div class="text-resus"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('dta','{{ $success_array['main_graph']['graph_data']['with_dta']['Paeds']['key'] }}');">
                <h2>{{ $success_array['main_graph']['graph_data']['with_dta']['Paeds']['value'] ?? 0 }}</h2>
                <h6>PAEDS</h6>
            </div>
        </div>
        <div class="blue-shape-5" >
            <img src="{{ asset('asset_v2/Template') }}/images/ane-blue-shape.svg" alt="">
            <div class="text-custom"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('dta','{{ $success_array['main_graph']['graph_data']['with_dta']['Others']['key'] }}');">
                <h2>{{ $success_array['main_graph']['graph_data']['with_dta']['Others']['value'] ?? 0 }}</h2>
                <h6>OTHERS</h6>
            </div>
        </div>
        <div class="wrapper-left-box  click_open_sau_offcanvas cursor_pointer" data-type='sdec' data-title='Patients To SDEC'>
            <div class="dta-box">
                <h6 class="mb-2">Patients <br>To SDEC</h6>
            </div>
            <div class="bottom-box">
                <h6>{{ $success_array['content']['todays_discharged_sdec_patients_count'] }}</h6>
            </div>
        </div>
        <div class="wrapper-right-box click_open_sau_offcanvas cursor_pointer"  data-type='sau' data-title='Patients To SAU'>
            <div class="location-box">
                <h6 class="mb-2">Patients <br>To SAU</h6>
            </div>
            <div class="bottom-box">
                <h6>{{ $success_array['bar_graph']['patient_assigned_no_patient_reception'] }}</h6>
                {{--            <h6>{{ $success_array['main_graph']['graph_data']['triage']['Others']['value'] + $success_array['main_graph']['graph_data']['with_dta']['Others']['value'] + $success_array['main_graph']['graph_data']['in_ed_now']['Others']['value'] }}</h6>--}}
            </div>
        </div>
    </div>
    <div class="ane-values-section">

        <div class="row gx-2 breach-count-row mb-md-2">
            <div class="col-md-2 col-4 offset-md-1 mb-1 mb-md-0">
                <div class="shape-box-blue"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('triage','{{ $success_array['main_graph']['graph_data']['triage']['UTC']['key'] }}');">
                    <div class="count-details">
                        <h6 class="header-count">{{ strtoupper($success_array['main_graph']['graph_data']['triage']['UTC']['key']) }}</h6>
                        <h6 class="value-count">{{ $success_array['main_graph']['graph_data']['triage']['UTC']['value'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-1 mb-md-0">
                <div class="shape-box-blue"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('triage','{{ $success_array['main_graph']['graph_data']['triage']['Majors']['key'] }}');">
                    <div class="count-details">
                        <h6 class="header-count">{{ strtoupper($success_array['main_graph']['graph_data']['triage']['Majors']['key']) }}</h6>
                        <h6 class="value-count">{{ $success_array['main_graph']['graph_data']['triage']['Majors']['value'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-1 mb-md-0">
                <div class="shape-box-blue"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('triage','{{ $success_array['main_graph']['graph_data']['triage']['Resus']['key'] }}');">
                    <div class="count-details">
                        <h6 class="header-count">{{ strtoupper($success_array['main_graph']['graph_data']['triage']['Resus']['key']) }}</h6>
                        <h6 class="value-count">{{ $success_array['main_graph']['graph_data']['triage']['Resus']['value'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-1 mb-md-0">
                <div class="shape-box-blue"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('triage','{{ $success_array['main_graph']['graph_data']['triage']['Paeds']['key'] }}');">
                    <div class="count-details">
                        <h6 class="header-count">{{ strtoupper($success_array['main_graph']['graph_data']['triage']['Paeds']['key']) }}</h6>
                        <h6 class="value-count">{{ $success_array['main_graph']['graph_data']['triage']['Paeds']['value'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-1 mb-md-0">
                <div class="shape-box-blue"  style="cursor: pointer;" onclick="GetDetailsBySpecialityGraph('triage','{{ $success_array['main_graph']['graph_data']['triage']['Others']['key'] }}');">
                    <div class="count-details">
                        <h6 class="header-count">{{ strtoupper($success_array['main_graph']['graph_data']['triage']['Others']['key']) }}</h6>
                        <h6 class="value-count">{{ $success_array['main_graph']['graph_data']['triage']['Others']['value'] ?? 0 }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-lg-12 col-md-12">
                <div class="bg-assign-total">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-9">
                            <h6>ASSIGNED SPECIALITIES</h6>
                        </div>
                        <div class="col-lg-4 col-md-4 col-3 text-end">
                            <h6>{{ $success_array['content']['speciality_counts_total'] }}</h6>
                        </div>
                    </div>
                </div>
                <div class="bg-assigned-details">
                    <div class="row">
                        @if (count($success_array['content']['speciality_counts']) > 0)
                            @foreach ($success_array['content']['speciality_counts'] as $key => $val)
                        <div class="col-lg-3 col-md-3 col-4"   style="cursor: pointer;" onclick="GetDetailsBySpeciality('{{ $key }}','speciality');">
                            <div class="admission-count-topbox">
                                <h6>{{ $key }}</h6>
                            </div>
                            <div class="admission-count-bottombox" >
                                <h4>{{ $val }}</h4>
                            </div>
                        </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

