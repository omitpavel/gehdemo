<div class="row mb-3">
    <input type="hidden" name="handover_ward_id" id="ward_id" value="{{ $success_array['ward_id'] }}">
    <input type="hidden" name="patient_id" id="patient_id" value="{{ $success_array['patient_id'] }}">
    <div class="col-12 ">
        <div class="mb-2">
            <select class="form-select" aria-label="Default select example" id="consultant_dropdown">
                <option value="">All Consultant </option>
                @foreach($success_array['consultant'] as $consultant)

                    <option  value="{{ $consultant['camis_consultant_code'] }}">{{ $consultant['camis_consultant_name'] }}</option>
                @endforeach

            </select>
        </div>
        <div class="mb-2">
            <select class="form-select" aria-label="Default select example" id="bed_group_dropdown">
                <option value="">All Bay </option>
                @foreach($success_array['unique_bed_groups'] as $bay)
                    <option  value="{{ $bay['ibox_bed_group_name'] }}-{{ $bay['ibox_bed_group_number'] }}">{{ $bay['ibox_bed_group_name'] }} {{ $bay['ibox_bed_group_number'] > 0 ? $bay['ibox_bed_group_number'] :''  }} </option>
                @endforeach
            </select>
        </div>
        <div class="mb-2 mt-3">
            <input  type="checkbox" name="hand_over_bay_break" id="hand_over_bay_break" value="1" >
            <label class="pl-1">Page Break After Each Bay</label>
        </div>
    </div>
</div>

