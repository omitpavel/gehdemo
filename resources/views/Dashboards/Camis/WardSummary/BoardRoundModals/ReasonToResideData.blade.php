@if (in_array($patient_current_ward, ['RLTFEL', 'RLTARBWARD']))
    <div class="spl-wards-reasons">
        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Primary Reason - Criteria To Reside</h6>
            </div>



            @if (!empty($reason_to_reside))

                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Primary_Reason_-_Criteria_to_Reside') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="Primary_Reason_-_Criteria_to_Reside_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif ></li>
                                <li> <label
                                        for="Primary_Reason_-_Criteria_to_Reside_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}
                                    </label></li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>

        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Rehabilitation, reablement and recovery stage</h6>
            </div>
            @if (!empty($reason_to_reside))
                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) ==
                            strtolower('Rehabilitation._Reablement_And_Recovery_Stage') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="recovery_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="recovery_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>
                                </li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>
    </div>
    <div class="disabled-effects">
        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Physiology</h6>
            </div>



            @if (!empty($reason_to_reside))

                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Physiology') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="physiology_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="physiology_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}
                                    </label></li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>

        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Recovery</h6>
            </div>
            @if (!empty($reason_to_reside))
                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Recovery') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="recovery_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="recovery_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>
                                </li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>

        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Treatment</h6>
            </div>
            @if (!empty($reason_to_reside))
                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Treatment') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="treatment_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="treatment_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>
                                </li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Function</h6>
            </div>
            @if (!empty($reason_to_reside))
                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Function') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="function_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="function_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>
                                </li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@else
    <div class="spl-wards-reasons">
        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Physiology</h6>
            </div>



            @if (!empty($reason_to_reside))

                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Physiology') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="physiology_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="physiology_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}
                                    </label></li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>

        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Recovery</h6>
            </div>
            @if (!empty($reason_to_reside))
                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Recovery') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="recovery_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="recovery_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>
                                </li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>

        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Treatment</h6>
            </div>
            @if (!empty($reason_to_reside))
                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Treatment') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="treatment_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="treatment_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>
                                </li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Function</h6>
            </div>
            @if (!empty($reason_to_reside))
                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Function') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="function_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="function_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>
                                </li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <div class="disabled-effects">
        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Primary Reason - Criteria To Reside</h6>
            </div>



            @if (!empty($reason_to_reside))

                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Primary_Reason_-_Criteria_to_Reside') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="Primary_Reason_-_Criteria_to_Reside_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="Primary_Reason_-_Criteria_to_Reside_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}
                                    </label></li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>

        <div class="reason-content-block">
            <div class="header-primary">
                <h6>Rehabilitation, reablement and recovery stage</h6>
            </div>
            @if (!empty($reason_to_reside))
                @foreach ($reason_to_reside as $key => $row_reason)
                    @if (strtolower($row_reason->reason_to_reside_text_value_category) ==
                            strtolower('Rehabilitation._Reablement_And_Recovery_Stage') &&
                            $row_reason->reason_to_reside_board_round_show_status == 1)
                        <div class="reasons-list-block">

                            <ul class="reason-list">
                                <li> <input id="recovery_{{ $key }}"
                                        class="form-check-input ibox_board_round_content_patient_reason_to_reside"
                                        type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                        value="{{ $row_reason->id }}"  @if($patient_current_reason_to_reside == $row_reason->id) checked @endif></li>
                                <li> <label
                                        for="recovery_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>
                                </li>

                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>
    </div>
@endif
