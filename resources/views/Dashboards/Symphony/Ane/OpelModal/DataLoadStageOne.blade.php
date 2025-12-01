

    <div class="col-lg-12 ">
        <div class="card-sitrep-modal">
            <div class="row g-2 mb-2">
                <div class="col-lg-4">
                    <div class="">
                        <label for="" class="form-label mb-0">Date</label>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form-control item_disabled">
                        <input type="hidden" id='ane_opel_stage_one_date_selected' value ='{{ $success_array['set_date_format'] }}' placeholder="" aria-label="default input example">
                        <span id="ed_opel_date">{{ $success_array['set_date'] }}</span>
                    </div>
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-lg-4">
                    <div class="">
                        <label for="" class="form-label mb-0">Hour</label>
                    </div>
                </div>
                <div class="col-lg-8">
                    <select class="form-select" aria-label="Default select example" id='ane_opel_stage_one_hour_selected'>
                        @foreach ($success_array['time_options'] as $row)
                            <option @if ($row == $success_array['set_time']) selected='selected' @endif value="{{ $row }}">{{ $row }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row g-2 align-items-center">
                <div class="col-lg-4">
                    <div class="">
                        <label for="" class="form-label mb-0">Completed by</label>
                    </div>
                </div>
                <div class="col-lg-8">
                    <input class="form-control" type="text" placeholder=""
                        aria-label="default input example"  id="ane_opel_stage_one_completed_by">
                </div>
                <div class="col-lg-4">
                    <div class="">
                        <label for="" class="form-label mb-0">No. Patients in ED</label>
                    </div>
                </div>
                <div class="col-lg-8">
                    <input class="form-control" type="text" placeholder=""
                        aria-label="default input example"  id="ane_opel_stage_one_no_patients_in_ed" value="{{ is_numeric($safety_thermometer_view['in_ed']) ? $safety_thermometer_view['in_ed'] : '' }}" readonly>
                </div>
                <div class="col-lg-4">
                    <div class="">
                        <label for="" class="form-label mb-0">No. Patients Waiting for a Bed
                        </label>
                    </div>
                </div>
                <div class="col-lg-8">
                    <input class="form-control" type="text" placeholder=""
                        aria-label="default input example" id="ane_opel_stage_one_no_patients_awaiting_bed" value="{{ is_numeric($safety_thermometer_view['patients_waiting_for_bed']) ? $safety_thermometer_view['patients_waiting_for_bed'] : '' }}" readonly>
                </div>
            </div>
        </div>
    </div>
