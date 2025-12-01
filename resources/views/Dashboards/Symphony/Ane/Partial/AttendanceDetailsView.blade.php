
<div class="row g-2">
    <div class="col-md-12">
        <label for="" class="form-label">Patient Name </label>
        <input type="text" readonly class="form-control" id="" aria-describedby="" value="{{ $success_array['attendance_data']['symphony_patient_name'] }}" placeholder="Nurse/Dr">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Attendance ID </label>
        <input type="text" readonly class="form-control" id="" aria-describedby="" value="{{ $success_array['attendance_data']['symphony_attendance_id'] }}" placeholder="Nurse/Dr">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Pas Number</label>
        <input type="text" readonly class="form-control" id="" aria-describedby="" value="{{ $success_array['attendance_data']['symphony_pas_number'] }}" placeholder="Nurse/Dr">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">First Location</label>
        <input type="text" readonly class="form-control" id="" aria-describedby="" value="{{ $success_array['attendance_data']['symphony_first_location'] }}" placeholder="Nurse/Dr">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Final Location</label>
        <input type="text" readonly class="form-control" id="" aria-describedby="" value="{{ $success_array['attendance_data']['symphony_final_location'] }}" placeholder="Nurse/Dr">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Department</label>
        <input type="text" readonly class="form-control" id="" aria-describedby="" value="{{ $success_array['attendance_data']['symphony_atd_type'] }}" placeholder="Nurse/Dr">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Triage Category</label>
        <input type="text" readonly class="form-control" id="" aria-describedby="" value="{{ $success_array['attendance_data']['symphony_triage_category'] }}" placeholder="Nurse/Dr">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Triage Date</label>
        <input type="text" readonly  value="{{  PredefinedDateFormatFor24Hour($success_array['attendance_data']['symphony_triage_date']) }}" class="form-control" id="" aria-describedby=""
               placeholder="">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Seen  By ED Dr Date</label>
        <input type="text" readonly  value="{{  PredefinedDateFormatFor24Hour($success_array['attendance_data']['symphony_seen_date']) }}" class="form-control" id="" aria-describedby=""
               placeholder="">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Registration Date & Time</label>
        <input type="text" readonly  value="{{ PredefinedDateFormatFor24Hour($success_array['attendance_data']['symphony_registration_date_time']) }}" class="form-control" id="" aria-describedby=""
               placeholder="">
    </div>


    <div class="col-md-6">
        <label for="" class="form-label">Seen  By ED Dr</label>
        <input type="text" readonly  value="{{ ($success_array['attendance_data']['symphony_seen_by']) }}" class="form-control" id="" aria-describedby=""
               placeholder="">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Seen  By ED Dr Date</label>
        <input type="text" readonly  value="{{  PredefinedDateFormatFor24Hour($success_array['attendance_data']['symphony_seen_date']) }}" class="form-control" id="" aria-describedby=""
               placeholder="">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Arrival Mode</label>
        <input type="text" readonly  value="{{ ($success_array['attendance_data']['symphony_arrival_mode']) }}" class="form-control" id="" aria-describedby=""
               placeholder="">
    </div>

    @if(isset($success_array['attendance_data']['symphony_request_date']))
    <div class="col-md-6">
        <label for="" class="form-label">DTA Date/Time</label>
        <input type="text" readonly  value="{{  PredefinedDateFormatFor24Hour($success_array['attendance_data']['symphony_request_date']) }}" class="form-control" id="" aria-describedby=""
               placeholder="">
    </div>
    @endif



</div>
