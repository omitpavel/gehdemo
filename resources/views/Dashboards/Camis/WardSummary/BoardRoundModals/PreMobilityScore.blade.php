<div class="mobile-score-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camis_patient_ward_summary_boardround_pre_mobility_score"
        aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog" style="visibility: visible;">
    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel">PRE MOBILE SCORE</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100 pre-admission-cancel" aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
            <button type="button" class="d-none" data-bs-dismiss="offcanvas" data-bs-target="#camis_patient_ward_summary_boardround_pre_mobility_score" aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="row mobile-score">
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
                        <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="movement_scale_score_pre_admission" value="8">
                    </div>
                </div>
                <div class="list-block">
                    <ul class="score-list">
                        <li>Score of 8 (Walk 7.5 Meters)</li>
                        <li>1. Distance can be cumulative within 1 treatment episode. Seated rest breaks are
                            allowed </li>
                    </ul>
                    <div class="radio-box">
                        <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="movement_scale_score_pre_admission" value="7" >
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
                        <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="movement_scale_score_pre_admission"
                        value="6" >
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
                        <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="movement_scale_score_pre_admission"
                        value="5" >
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
                        <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="movement_scale_score_pre_admission"
                        value="4" >
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
                        <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="movement_scale_score_pre_admission"
                        value="3" >
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
                        <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="movement_scale_score_pre_admission"
                        value="2" >
                    </div>
                </div>
                <div class="list-block">
                    <ul class="score-list">
                        <li>Score of 1 (Lay in Bed)</li>
                    </ul>
                    <div class="radio-box">
                        <input class="form-check-input ibox_boardround_movement_scale_score" type="radio" name="movement_scale_score_pre_admission"
                        value="1" >
                    </div>
                </div>
            </div>
            <div id="grey-btns-group">
                <div class="col-lg-10 offset-lg-1">
                    <div class="row ibox_modal_footer_button_class">
                        <div class="col-lg-4 col-md-4 mb-2 pe-md-1">
                            <button class="btn btn-breach-grey w-100 all_modal_save_button_for_js bottom-save-button camis_ibox_save_pre_mobility_score"><img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt=""
                                    class="btn-icon-modal" width="18" height="18"><span>SAVE</span>
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-2 ps-md-1 pe-md-1">
                            <button class="btn btn-breach-grey w-100 pre-admission-cancel"><img src="{{ asset('asset_v2/Template/icons/speed.svg') }}" alt=""
                                    class="btn-icon-modal" width="16" height="16"><span>Mobility Score</span>
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-2 ps-md-1">
                            <button class="btn btn-breach-grey w-100  pre-admission-cancel"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                    class="btn-icon-modal" width="12" height="12"><span>CANCEL</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
