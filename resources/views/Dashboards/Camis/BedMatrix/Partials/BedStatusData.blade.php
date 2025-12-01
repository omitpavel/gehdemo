<div class="row gx-2 align-items-center">
    <div class="col-4 mb-2">
        <label class="form-label">Bed Number</label>
    </div>
    <div class="col-8 mb-2">
        <label class="form-label" id="ward_bed_no">315</label>
    </div>
</div>
<div class="row gx-2">
    <div class="col-12 mb-2">
        <label class="form-label">Bed Status</label>
    </div>
</div>
<div class="row row-cols-lg-4">
    <div class="col mb-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="bed_current_status" id="reserverd"
                value="4" @if($success_array['bed_status'] == 4) checked @endif>
            <label class="form-check-label" for="reserverd">
                Reserved
            </label>
        </div>
    </div>
    <div class="col mb-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="bed_current_status" id="empty"
                value="0" @if($success_array['bed_status'] == 0) checked @endif>
            <label class="form-check-label" for="empty">
                Empty
            </label>
        </div>
    </div>


    <div class="col mb-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="bed_current_status" id="restricted"
                value="2" @if($success_array['bed_status'] == 2) checked @endif>
            <label class="form-check-label" for="restricted">
                Restricted
            </label>
        </div>
    </div>
    <div class="col mb-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="bed_current_status" id="closed"
                value="1" @if($success_array['bed_status'] == 1) checked @endif>
            <label class="form-check-label" for="closed">
                Closed
            </label>
        </div>
    </div>

</div>
<div class="row gx-2 align-items-center patient_search_class @if($success_array['bed_status'] != 4) d-none @endif">
    <div class="col-md-4 mb-2">
        <label class="form-label">Patient Search</label>
    </div>
    <div class="col-md-6 col-9 mb-2">
        <div class="position-relative">
            <input type="text" class="form-control " id="patient_search_value" placeholder="" @if($success_array['bed_status'] == 4 && !empty($success_array['reserved_for'])) value="{{ $success_array['reserved_for'] }}" @else value="" @endif>
            <i class="bi bi-search search-icon"></i>
        </div>
    </div>
    <div class="col-md-2 col-3 mb-2">
        <button class="btn btn-search patient_search_button">Search</button>
    </div>
</div>
<div class="modal-popup-loader-content" id="patient_search_loader" style="display: none;"></div>
<div  style="visibility: visible;" class="card-grey patient_search_class_input ward_summary_sub_modal_inner_body @if($success_array['bed_status'] != 4) d-none @endif" id="patient_search_list">
@include('Dashboards.Camis.BedMatrix.Partials.PatientSearch')
</div>

<input type="hidden" id="ward_bed_id" value="{{ $success_array['ward_bed_id'] }}">
<input type="hidden" id="ward_id" value="{{ $success_array['ward_id'] }}">
