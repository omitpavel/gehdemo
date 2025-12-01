

@if(isset($success_array['mobility_score']['movement_scale_score_pre_admission']) && !empty($success_array['mobility_score']['movement_scale_score_pre_admission']))
    <div class="bg-score-value">
        <h6 class="mb-0">Mobility Pro Admission Score Value : {{GetMobilityScoreTextFromNumber($success_array['mobility_score']['movement_scale_score_pre_admission'])}}</h6>
    </div>
@endif







<div class="content-block">
    <div class="header-primary">
        <h6>WALK</h6>
    </div>
    <div class="border-blue"></div>
    <div class="list-block">
        <ul class="score-list">
            <li>Score of 8 (Walk 75Meters)</li>
            <li>1. Distance can be cumulative within 1 treatment episode. Seated rest breaks are
                allowed
            </li>
        </ul>
        <div class="radio-box">
            <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="ibox_boardround_movement_scale_score" value="8" @if(isset($success_array['mobility_score']['movement_scale_score_value']) && $success_array['mobility_score']['movement_scale_score_value'] == 8) checked="checked" @endif>
        </div>
    </div>
    <div class="list-block">
        <ul class="score-list">
            <li>Score of 8 (Walk 7.5 Meters)</li>
            <li>1. Distance can be cumulative within 1 treatment episode. Seated rest breaks are
                allowed </li>
        </ul>
        <div class="radio-box">
            <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="ibox_boardround_movement_scale_score" value="7" @if(isset($success_array['mobility_score']['movement_scale_score_value']) && $success_array['mobility_score']['movement_scale_score_value'] == 7) checked="checked" @endif>
        </div>
    </div>
    <div class="list-block">
        <ul class="score-list">
            <li>Score of 6 (Walk 10 Steps or More) </li>
            <li>1. Distance can be cumulative within 1 treatment episode. Seated rest breaks are
                allowed
            </li>
        </ul>
        <div class="radio-box">
            <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="ibox_boardround_movement_scale_score"
            value="6" @if(isset($success_array['mobility_score']['movement_scale_score_value']) && $success_array['mobility_score']['movement_scale_score_value'] == 6) checked="checked" @endif>
        </div>
    </div>
</div>
<div class="content-block">
    <div class="header-primary">
        <h6>STAND</h6>
    </div>
    <div class="border-blue"></div>
    <div class="list-block">
        <ul class="score-list">
            <li>Score of 5 (Stand 1 or More Minutes)</li>
            <li>1. Minute or more can be made up of cumulative performance during 1 treatment
                episode.
            </li>
        </ul>
        <div class="radio-box">
            <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="ibox_boardround_movement_scale_score"
            value="5" @if(isset($success_array['mobility_score']['movement_scale_score_value']) && $success_array['mobility_score']['movement_scale_score_value'] == 5) checked="checked" @endif>
        </div>
    </div>
</div>
<div class="content-block">
    <div class="header-primary">
        <h6>CHAIR</h6>
    </div>
    <div class="border-blue"></div>
    <div class="list-block">
        <ul class="score-list">
            <li>Score of 4 (Move to Chair/Commode)</li>
            <li>1. Score of 4 is given if patient is not dependent on hoist or assistance of 3 or
                more
                people to transfer to chair or commode.</li>
        </ul>
        <div class="radio-box">
            <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="ibox_boardround_movement_scale_score"
            value="4" @if(isset($success_array['mobility_score']['movement_scale_score_value']) && $success_array['mobility_score']['movement_scale_score_value'] == 4) checked="checked" @endif>
        </div>
    </div>
</div>
<div class="content-block">
    <div class="header-primary">
        <h6>BED</h6>
    </div>
    <div class="border-blue"></div>
    <div class="list-block">
        <ul class="score-list">
            <li>Score of 3 (Sit at edge of bed)</li>
            <li>1. Duration does not influence score. <br> 2. Score of 3 if requiring support of 2
                people or less.</li>
        </ul>
        <div class="radio-box">
            <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="ibox_boardround_movement_scale_score"
            value="3" @if(isset($success_array['mobility_score']['movement_scale_score_value']) && $success_array['mobility_score']['movement_scale_score_value'] == 3) checked="checked" @endif>
        </div>
    </div>
    <div class="list-block">
        <ul class="score-list">
            <li>Score of 2 (Bed Activities / Dependent Transfer) </li>
            <li>1. Dependent transfer from bed to chair using hoist or 3 or more people. <br> 2.
                Lateral
                transfer from bed to stretcher / trolley. <br> 3. Activities performed in bed. Eg:
                range
                of
                movement exercises. <br> 4. Turning self or rolling in bed activity or passively
                with
                staff. <br>
                5. Use of tilt table.</li>
        </ul>
        <div class="radio-box">
            <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="ibox_boardround_movement_scale_score"
            value="2" @if(isset($success_array['mobility_score']['movement_scale_score_value']) && $success_array['mobility_score']['movement_scale_score_value'] == 2) checked="checked" @endif>
        </div>
    </div>
    <div class="list-block">
        <ul class="score-list">
            <li>Score of 1 (Lay in Bed)</li>
        </ul>
        <div class="radio-box">
            <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="ibox_boardround_movement_scale_score"
            value="1" @if(isset($success_array['mobility_score']['movement_scale_score_value']) && $success_array['mobility_score']['movement_scale_score_value'] == 1) checked="checked" @endif>
        </div>
    </div>
</div>

<div class="radio-btn-grp mb-3">
    <div class="row">
        <div class="col-lg-6 col-md-6 pe-md-1 mb-2">
            <button class="btn bg-radio-btn w-100">
                Assistance 1<input class="form-check-input ibox_boardround_movement_scale_assistance" type="radio" name="ibox_boardround_movement_scale_assistance" value="Assistance 1"  @if(isset($success_array['mobility_score']['movement_scale_assistance']) && $success_array['mobility_score']['movement_scale_assistance'] == 'Assistance 1') checked="checked" @endif>
            </button>
        </div>
        <div class="col-lg-6 col-md-6 ps-md-1 mb-2">
            <button class="btn bg-radio-btn w-100">
                Assistance 2<input class="form-check-input ibox_boardround_movement_scale_assistance" type="radio" name="ibox_boardround_movement_scale_assistance" value="Assistance 2" @if(isset($success_array['mobility_score']['movement_scale_assistance']) && $success_array['mobility_score']['movement_scale_assistance'] == 'Assistance 2') checked="checked" @endif>
            </button>
        </div>
        <div class="col-lg-6 col-md-6 pe-md-1 mb-2">
            <button class="btn bg-radio-btn w-100">
                Walking Aid Required<input class="form-check-input ibox_boardround_movement_scale_assistance_required" type="radio" name="ibox_boardround_movement_scale_assistance_required" value="Walking Aid Required" @if(isset($success_array['mobility_score']['movement_scale_assistance_required']) && $success_array['mobility_score']['movement_scale_assistance_required'] == 'Walking Aid Required') checked="checked" @endif>
            </button>
        </div>
        <div class="col-lg-6 col-md-6 ps-md-1 mb-2">
            <button class="btn bg-radio-btn w-100">
                Independent Mobility<input class="form-check-input ibox_boardround_movement_scale_assistance_required" type="radio"  name="ibox_boardround_movement_scale_assistance_required" value="Independent Mobility" @if(isset($success_array['mobility_score']['movement_scale_assistance_required']) && $success_array['mobility_score']['movement_scale_assistance_required'] == 'Independent Mobility') checked="checked" @endif>
            </button>
        </div>
    </div>

</div>
