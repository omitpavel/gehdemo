<div class="row ">
    <div class="col-lg-12 ">
        <div class="card-sitrep">
            <div class="safety-content-wrapper">
                <div class="card-sitrep-modal mb-2">
                    <div class="category-header">
                        <label for="" class="form-label mb-0">INDICATORS</label>
                    </div>
                    <div class="content-wrapper">
                        <div class="row gx-4 align-items-center">
                            <div class="col-12 gx-2">
                                <div class="right-side-area">
                                    <div class="">
                                        <div class="row align-items-center ">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <div
                                                    class="d-flex align-items-center justify-content-center">
                                                    <div class="opel-green-circle"></div>
                                                    <div>
                                                        <span>EMS 1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <div
                                                    class="d-flex align-items-center justify-content-center">
                                                    <div class="opel-amber-circle"></div>
                                                    <div>
                                                        <span>EMS 2</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <div
                                                    class="d-flex align-items-center justify-content-center">
                                                    <div class="opel-red-circle"></div>
                                                    <div>
                                                        <span>EMS 3</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <div
                                                    class="d-flex align-items-center justify-content-center">
                                                    <div class="opel-black-circle"></div>
                                                    <div>
                                                        <span>EMS 4</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="safety-content-wrapper">
                <div class="card-sitrep-modal">
                    <div class="category-header">
                        <label for="" class="form-label mb-0">Acuity</label>
                    </div>
                    <div class="content-wrapper">
                        <div class="row gx-4 align-items-center">
                            <div class="col-12 gx-2">
                                <div class="right-side-area">
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center">
                                            <div class="col-lg-2">
                                                    <label for="mt-lg-2"
                                                        class="form-label mb-lg-0">No.
                                                        critically ill/injured
                                                        <br class="d-none d-lg-block">
                                                        req. cardiac arrest/ trauma
                                                        team</label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" name="acuity[critically_ill_injured_cardiactrauma][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" @if($safety_thermometer_view['critically_ill_injured_cardiactrauma'] == 1) selected @endif>EMS 1</option>
                                                    <option value="2" @if($safety_thermometer_view['critically_ill_injured_cardiactrauma'] == 2) selected @endif>EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['critically_ill_injured_cardiactrauma'] == 3) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['critically_ill_injured_cardiactrauma'] > 3) selected @endif>EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">1
                                                </label>
                                                <div class="opel-time-green">
                                                    <input  class="form-control bg-white" min="0" step="1" inputmode="numeric"  pattern="\d*"  oninput="this.value = this.value.replace(/[^0-9]/g, '')"type="text"
                                                        placeholder="" value="{{ ($safety_thermometer_view['critically_ill_injured_cardiactrauma'] == 1) ? $safety_thermometer_view['critically_ill_injured_cardiactrauma'] : '' }}"
                                                        aria-label="default input example" name="acuity[critically_ill_injured_cardiactrauma][green]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">2
                                                </label>
                                                <div class="opel-time-amber">
                                                    <input  class="form-control bg-white" min="0" step="1" inputmode="numeric"  pattern="\d*"  oninput="this.value = this.value.replace(/[^0-9]/g, '')"type="text"
                                                        placeholder="" value="{{ ($safety_thermometer_view['critically_ill_injured_cardiactrauma'] == 2) ? $safety_thermometer_view['critically_ill_injured_cardiactrauma'] : '' }}"
                                                        aria-label="default input example" name="acuity[critically_ill_injured_cardiactrauma][amber]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">3</label>
                                                <div class="opel-time-red">
                                                    <input  class="form-control bg-white" min="0" step="1" inputmode="numeric"  pattern="\d*"  oninput="this.value = this.value.replace(/[^0-9]/g, '')"type="text"
                                                        placeholder="" value="{{ ($safety_thermometer_view['critically_ill_injured_cardiactrauma'] == 3) ? $safety_thermometer_view['critically_ill_injured_cardiactrauma'] : '' }}"
                                                        aria-label="default input example" name="acuity[critically_ill_injured_cardiactrauma][red]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">>3
                                                </label>
                                                <div class="opel-time-black bg-white" min="0" step="1">
                                                    <input  class="form-control" type="text"
                                                        placeholder="" value="{{ ($safety_thermometer_view['critically_ill_injured_cardiactrauma'] > 3) ? $safety_thermometer_view['critically_ill_injured_cardiactrauma'] : '' }}"
                                                        aria-label="default input example" name="acuity[critically_ill_injured_cardiactrauma][black]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">Special
                                                        care
                                                        patients
                                                        <br class="d-none d-lg-block">requiring
                                                        extensive
                                                        staff input</label>
                                            </div>
                                            <div class="col-lg-2 mb-2 mb-lg-0">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" id="special_care_patients_extensive_staff_input_opel" name="acuity[special_care_patients_extensive_staff_input][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" >EMS 1</option>
                                                    <option value="2" >EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['special_care_patients_extensive_staff_input'] == 1) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['special_care_patients_extensive_staff_input'] > 1) selected @endif>EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">&nbsp;
                                                </label>
                                                <div class=" opel-time-green w-100">
                                                    <select class="form-select" id="special_care_patients_extensive_staff_input_green"
                                                        aria-label="Default select example" name="acuity[special_care_patients_extensive_staff_input][green]">
                                                        <option value="">Select </option>
                                                        <option value="1">YES</option>
                                                        <option value="2">NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">&nbsp;
                                                </label>
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="text"
                                                        placeholder="N/A" value="N/A"
                                                        aria-label="default input example" name="acuity[special_care_patients_extensive_staff_input][amber]" readonly>
                                                </div>

                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">1
                                                </label>
                                                <div class="opel-time-red">
                                                    <input  class="form-control bg-white" id="special_care_patients_extensive_staff_input_red" min="0" step="1" inputmode="numeric"  pattern="\d*"  oninput="this.value = this.value.replace(/[^0-9]/g, '')" type="number" name="acuity[special_care_patients_extensive_staff_input][red]"
                                                        placeholder="" value="{{ ($safety_thermometer_view['special_care_patients_extensive_staff_input'] == 1) ? $safety_thermometer_view['special_care_patients_extensive_staff_input'] : '' }}"
                                                        aria-label="default input example">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">>1
                                                </label>
                                                <div class="opel-time-black">
                                                    <input  class="form-control bg-white" id="special_care_patients_extensive_staff_input_black" min="0" step="1" inputmode="numeric"  pattern="\d*"  oninput="this.value = this.value.replace(/[^0-9]/g, '')"type="number" name="acuity[special_care_patients_extensive_staff_input][black]"
                                                        placeholder=""  value="{{ ($safety_thermometer_view['special_care_patients_extensive_staff_input'] > 1) ? $safety_thermometer_view['special_care_patients_extensive_staff_input'] : '' }}"
                                                        aria-label="default input example">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center">
                                            <div class="col-lg-2">
                                                    <label for=""
                                                        class="form-label mb-lg-0">Patient
                                                        safety
                                                        round
                                                        <br class="d-none d-lg-block">identifies
                                                        safety
                                                        concerns
                                                    </label>
                                            </div>
                                            <div class="col-lg-2 mb-2 mb-lg-0">
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" id="safety_round_identifies_concerns_opel" name="acuity[safety_round_identifies_concerns][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1">EMS 1</option>
                                                    <option value="2">EMS 2</option>
                                                    <option value="3">EMS 3</option>
                                                    <option value="4">EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <div class=" opel-time-green w-100">
                                                    <select class="form-select"
                                                        aria-label="Default select example" id="safety_round_identifies_concerns_green" name="acuity[safety_round_identifies_concerns][green]">
                                                        <option value="">Select </option>
                                                        <option value="1">YES</option>
                                                        <option value="2">NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="text"
                                                        placeholder="N/A" value="N/A"
                                                        aria-label="default input example" name="acuity[safety_round_identifies_concerns][amber]" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <div class=" opel-time-red w-100">
                                                    <select class="form-select" id="safety_round_identifies_concerns_red"
                                                        aria-label="Default select example" name="acuity[safety_round_identifies_concerns][red]">
                                                        <option value="">Select </option>
                                                        <option value="1">YES</option>
                                                        <option value="2">NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <div class=" opel-time-black w-100">
                                                    <select class="form-select" id="safety_round_identifies_concerns_black"
                                                        aria-label="Default select example" name="acuity[safety_round_identifies_concerns][black]">
                                                        <option value="">Select </option>
                                                        <option value="1">YES</option>
                                                        <option value="2">NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
