
<select class="3col active"  multiple="multiple" aria-label="Default select example" id="{{ $id }}">
    <optgroup label="Medical Wards">
        @foreach ($medical_wards as $ward)
        <option value="{{ $ward['ward_short_name'] }}" @if (request()->filled($id) && in_array($ward['ward_short_name'], request()->$id)) selected @endif >
            {{ $ward['ward_name'] }}</option>
        @endforeach

    </optgroup>
    <optgroup label="Surgical Wards">
        @foreach ($surgical_wards as $ward)
        <option value="{{ $ward['ward_short_name'] }}"@if (request()->filled($id) && in_array($ward['ward_short_name'], request()->$id)) selected @endif>
            {{ $ward['ward_name'] }}</option>
        @endforeach

    </optgroup>
    <optgroup label="Others Wards">
        @foreach ($other_wards as $ward)
        <option value="{{ $ward['ward_short_name'] }}" @if (request()->filled($id) && in_array($ward['ward_short_name'], request()->$id)) selected @endif>
            {{ $ward['ward_name'] }}</option>
        @endforeach

    </optgroup>

</select>

