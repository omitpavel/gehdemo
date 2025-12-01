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
                                        <div class="row align-items-center">
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
                        <label for="" class="form-label mb-0">Outflow</label>
                    </div>
                    <div class="content-wrapper">
                        <div class="row gx-4 align-items-center">
                            <div class="col-12 gx-2">
                                <div class="right-side-area">
                                    <div class="row-border-bottom">
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">No.
                                                        patients
                                                        waiting
                                                        <br class="d-none d-lg-block">for a
                                                        bed</label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" name="outflow[patients_waiting_for_bed][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" >EMS 1</option>
                                                    <option value="2" @if($safety_thermometer_view['patients_waiting_for_bed'] >= 1 && $safety_thermometer_view['patients_waiting_for_bed'] <= 4) selected @endif>EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['patients_waiting_for_bed'] >= 5 && $safety_thermometer_view['patients_waiting_for_bed'] <= 7) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['patients_waiting_for_bed'] > 8) selected @endif>EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">
                                                </label>
                                                <div class="opel-time-green">
                                                    <input class="form-control" type="text"
                                                        placeholder="N/A" value="N/A"
                                                        aria-label="default input example" name="outflow[patients_waiting_for_bed][green]" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">1 - 4
                                                </label>
                                                <div class="opel-time-amber">
                                                    <input readonly class="form-control"  type="number"   name="outflow[patients_waiting_for_bed][amber]"
                                                          value="{{ ($safety_thermometer_view['critically_ill_injured_cardiactrauma'] >= 1 && $safety_thermometer_view['critically_ill_injured_cardiactrauma'] <= 4) ? $safety_thermometer_view['critically_ill_injured_cardiactrauma'] : '' }}"
                                                        aria-label="default input example">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">5 - 8
                                                </label>
                                                <div class="opel-time-red">
                                                    <input readonly class="form-control"  type="number"   name="outflow[patients_waiting_for_bed][red]"
                                                         value="{{ ($safety_thermometer_view['critically_ill_injured_cardiactrauma'] >= 5 && $safety_thermometer_view['critically_ill_injured_cardiactrauma'] <= 8) ? $safety_thermometer_view['critically_ill_injured_cardiactrauma'] : '' }}"
                                                        aria-label="default input example">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">>8
                                                </label>
                                                <div class="opel-time-black">
                                                    <input readonly class="form-control"  type="number"   name="outflow[patients_waiting_for_bed][black]"
                                                         value="{{ ($safety_thermometer_view['critically_ill_injured_cardiactrauma'] > 8) ? $safety_thermometer_view['critically_ill_injured_cardiactrauma'] : '' }}"
                                                        aria-label="default input example">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">Patients in
                                                        department
                                                        <br class="d-none d-lg-block">>12 hours
                                                        from
                                                        arrival</label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" name="outflow[patients_in_department_over_12_hours][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" @if($safety_thermometer_view['patients_in_department_over_12_hours'] < 1) selected @endif>EMS 1</option>
                                                    <option value="2" >EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['patients_in_department_over_12_hours'] == 4) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['patients_in_department_over_12_hours'] > 4) selected @endif>EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">0
                                                </label>
                                                <div class="opel-time-green">
                                                    <input readonly class="form-control" type="number"   name="outflow[patients_in_department_over_12_hours][green]"
                                                         value="{{ ($safety_thermometer_view['patients_in_department_over_12_hours'] < 1) ? $safety_thermometer_view['patients_in_department_over_12_hours'] : '' }}"
                                                        aria-label="default input example">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">
                                                </label>
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="text"
                                                        placeholder="N/A" value="N/A"
                                                        aria-label="default input example" name="outflow[patients_in_department_over_12_hours][amber]" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">4
                                                </label>
                                                <div class="opel-time-red">
                                                    <input readonly class="form-control"  type="number"   name="outflow[patients_in_department_over_12_hours][red]"
                                                         value="{{ ($safety_thermometer_view['patients_in_department_over_12_hours'] == 4) ? $safety_thermometer_view['patients_in_department_over_12_hours'] : '' }}"
                                                        aria-label="default input example">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">>4
                                                </label>
                                                <div class="opel-time-black">
                                                    <input readonly class="form-control"  type="number"   name="outflow[patients_in_department_over_12_hours][black]"
                                                         value="{{ ($safety_thermometer_view['patients_in_department_over_12_hours'] > 4) ? $safety_thermometer_view['patients_in_department_over_12_hours'] : '' }}"
                                                        aria-label="default input example">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">Closure
                                                        of
                                                        <br class="d-none d-lg-block"> internal
                                                        ED
                                                        area</label>
                                            </div>
                                            <div class="col-lg-2 mb-2 mb-lg-0">
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" id="closure_of_internal_ed_area_opel" name="outflow[closure_of_internal_ed_area][opel]">
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
                                                        aria-label="Default select example" id="closure_of_internal_ed_area_green" name="outflow[closure_of_internal_ed_area][green]">
                                                        <option value="">Select</option>
                                                        <option value="1">YES</option>
                                                        <option value="2">NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="text"
                                                        placeholder="N/A" value="N/A"
                                                        aria-label="default input example" name="outflow[closure_of_internal_ed_area][amber]" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <div class="opel-time-red">
                                                    <input class="form-control" type="text"
                                                        placeholder="N/A" value="N/A"
                                                        aria-label="default input example" name="outflow[closure_of_internal_ed_area][red]" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <div class=" opel-time-black w-100">
                                                    <select class="form-select"
                                                        aria-label="Default select example" id="closure_of_internal_ed_area_black" name="outflow[closure_of_internal_ed_area][black]">
                                                        <option value="">Select</option>
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
