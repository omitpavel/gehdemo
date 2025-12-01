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
                        <label for="" class="form-label mb-0">Inflow</label>
                    </div>
                    <div class="content-wrapper">
                        <div class="row gx-4 align-items-center">
                            <div class="col-12 gx-2">
                                <div class="right-side-area">
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center ">
                                            <div class="col-lg-2">
                                                    <label for=""
                                                        class="form-label mb-lg-0">RATT
                                                        bays
                                                        <br class="d-none d-lg-block">free</label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" name="inflow[ratt_bays_free][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" @if($safety_thermometer_view['ratt_bays_free'] > 3) selected @endif>EMS 1</option>
                                                    <option value="2" @if($safety_thermometer_view['ratt_bays_free'] >= 2 && $safety_thermometer_view['ratt_bays_free'] <= 3) selected @endif>EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['ratt_bays_free'] == 1) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['ratt_bays_free'] < 1) selected @endif>EMS 4</option>
                                                </select>
                                            </div>


                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <label for="" class="form-label">>3</label>
                                                <div class="opel-time-green">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ $safety_thermometer_view['ratt_bays_free'] > 3 ? $safety_thermometer_view['ratt_bays_free'] : '' }}"
                                                        aria-label="default input example" name="inflow[ratt_bays_free][green]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <label for="" class="form-label">2-3</label>
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ ($safety_thermometer_view['ratt_bays_free'] >= 2 && $safety_thermometer_view['ratt_bays_free'] <= 3) ? $safety_thermometer_view['ratt_bays_free'] : '' }}"
                                                        aria-label="default input example" name="inflow[ratt_bays_free][amber]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <label for="" class="form-label">1
                                                </label>
                                                <div class="opel-time-red">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ $safety_thermometer_view['ratt_bays_free'] == 1 ? $safety_thermometer_view['ratt_bays_free'] : '' }}"
                                                        aria-label="default input example" name="inflow[ratt_bays_free][red]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <label for="" class="form-label">0
                                                </label>
                                                <div class="opel-time-black">
                                                    <input class="form-control" type="number" readonly
                                                        value="{{ $safety_thermometer_view['ratt_bays_free'] < 1 ? $safety_thermometer_view['ratt_bays_free'] : '' }}"
                                                        aria-label="default input example" name="inflow[ratt_bays_free][black]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center ">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">No
                                                        patients
                                                        <br class="d-none d-lg-block"> in resus
                                                    </label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" name="inflow[no_patients_in_resus][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" @if($safety_thermometer_view['no_patients_in_resus'] < 1) selected @endif>EMS 1</option>
                                                    <option value="2" @if($safety_thermometer_view['no_patients_in_resus'] == 2) selected @endif>EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['no_patients_in_resus'] == 3) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['no_patients_in_resus'] > 3) selected @endif>EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">0
                                                </label>
                                                <div class="opel-time-green">
                                                    <input class="form-control" type="number" readonly

                                                        aria-label="default input example" name="inflow[no_patients_in_resus][green]"  value="{{ ($safety_thermometer_view['no_patients_in_resus'] == 0) ? $safety_thermometer_view['no_patients_in_resus'] : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">2
                                                </label>
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="number" readonly

                                                        aria-label="default input example"  name="inflow[no_patients_in_resus][amber]"  value="{{ ($safety_thermometer_view['no_patients_in_resus'] == 2) ? $safety_thermometer_view['no_patients_in_resus'] : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">3
                                                </label>
                                                <div class="opel-time-red">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ ($safety_thermometer_view['no_patients_in_resus'] == 3) ? $safety_thermometer_view['no_patients_in_resus'] : '' }}"
                                                        aria-label="default input example"  name="inflow[no_patients_in_resus][red]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">>3
                                                </label>
                                                <div class="opel-time-black">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ ($safety_thermometer_view['no_patients_in_resus'] > 3) ? $safety_thermometer_view['no_patients_in_resus'] : '' }}"
                                                        aria-label="default input example"  name="inflow[no_patients_in_resus][black]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center ">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">No.
                                                        patients
                                                        arriving/hr
                                                        <br class="d-none d-lg-block">over past
                                                        2
                                                        hours
                                                    </label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" name="inflow[patients_arriving_per_hour_last_2_hours][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" @if($safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] < 10) selected @endif>EMS 1</option>
                                                    <option value="2" @if($safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] >= 15 && $safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] <= 19) selected @endif>EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] >= 20 && $safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] <= 25) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] > 25) selected @endif>EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">&lt;10
                                                </label>
                                                <div class="opel-time-green">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ ($safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] < 10) ? $safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] : '' }}"
                                                        aria-label="default input example" name="inflow[patients_arriving_per_hour_last_2_hours][green]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">15 - 19
                                                </label>
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ ($safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] >= 15 && $safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] <= 20) ? $safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] : '' }}"
                                                        aria-label="default input example"  name="inflow[patients_arriving_per_hour_last_2_hours][amber]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">20 - 25
                                                </label>
                                                <div class="opel-time-red">
                                                    <input class="form-control" type="number" readonly
                                                        value="{{ ($safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] >= 20 && $safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] <= 25) ? $safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] : '' }}"
                                                        aria-label="default input example" name="inflow[patients_arriving_per_hour_last_2_hours][red]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">>25
                                                </label>
                                                <div class="opel-time-black">
                                                    <input class="form-control" type="number" readonly
                                                        value="{{ ($safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] > 25) ? $safety_thermometer_view['patients_arriving_per_hour_last_2_hours'] : '' }}"
                                                        aria-label="default input example" name="inflow[patients_arriving_per_hour_last_2_hours][black]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center ">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">Majors
                                                        cubicles
                                                        available
                                                        <br class="d-none d-lg-block">for
                                                        patient
                                                        assessment
                                                    </label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" name="inflow[majors_cubicles_available][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" @if($safety_thermometer_view['majors_cubicles_available'] > 4) selected @endif>EMS 1</option>
                                                    <option value="2" @if($safety_thermometer_view['majors_cubicles_available'] >= 2 && $safety_thermometer_view['majors_cubicles_available'] <= 3) selected @endif>EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['majors_cubicles_available'] == 1) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['majors_cubicles_available'] < 1) selected @endif>EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">>4
                                                </label>
                                                <div class="opel-time-green">
                                                    <input class="form-control" type="number" readonly
                                                          value="{{ ($safety_thermometer_view['majors_cubicles_available'] > 4) ? $safety_thermometer_view['majors_cubicles_available'] : '' }}"
                                                        aria-label="default input example" name="inflow[majors_cubicles_available][green]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">2 - 3
                                                </label>
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="number" readonly
                                                          value="{{ ($safety_thermometer_view['majors_cubicles_available'] >= 2 && $safety_thermometer_view['majors_cubicles_available'] >= 3) ? $safety_thermometer_view['majors_cubicles_available'] : '' }}"
                                                        aria-label="default input example" name="inflow[majors_cubicles_available][amber]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">1
                                                </label>
                                                <div class="opel-time-red">
                                                    <input class="form-control" type="number" readonly
                                                        value="{{ ($safety_thermometer_view['majors_cubicles_available'] == 1) ? $safety_thermometer_view['majors_cubicles_available'] : '' }}"
                                                        aria-label="default input example" name="inflow[majors_cubicles_available][red]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">0
                                                </label>
                                                <div class="opel-time-black">
                                                    <input class="form-control" type="number" readonly
                                                        value="{{ ($safety_thermometer_view['majors_cubicles_available'] == 0) ? $safety_thermometer_view['majors_cubicles_available'] : '' }}"
                                                        aria-label="default input example" name="inflow[majors_cubicles_available][black]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center ">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">Ambulances
                                                        <br class="d-none d-lg-block">en-route</label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" name="inflow[ambulances_en_route][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" @if($safety_thermometer_view['ambulances_en_route'] < 3) selected @endif>EMS 1</option>
                                                    <option value="2" @if($safety_thermometer_view['ambulances_en_route'] >= 3 && $safety_thermometer_view['ambulances_en_route'] <= 4) selected @endif>EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['ambulances_en_route'] == 5) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['ambulances_en_route'] > 6) selected @endif>EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <label for="" class="form-label">&lt;3
                                                </label>
                                                <div class="opel-time-green">
                                                    <input class="form-control bg-white" min="0" step="1" inputmode="numeric"  pattern="\d*"  oninput="this.value = this.value.replace(/[^0-9]/g, '')"type="number"
                                                         value="{{ ($safety_thermometer_view['ambulances_en_route'] < 3) ? $safety_thermometer_view['ambulances_en_route'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulances_en_route][green]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <label for="" class="form-label">3 - 4
                                                </label>
                                                <div class="opel-time-amber">
                                                    <input class="form-control bg-white" min="0" step="1" inputmode="numeric"  pattern="\d*"  oninput="this.value = this.value.replace(/[^0-9]/g, '')"type="number"
                                                         value="{{ ($safety_thermometer_view['ambulances_en_route'] >= 3 && $safety_thermometer_view['ambulances_en_route'] <= 4) ? $safety_thermometer_view['ambulances_en_route'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulances_en_route][amber]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <label for="" class="form-label">5
                                                </label>
                                                <div class="opel-time-red">
                                                    <input class="form-control bg-white" min="0" step="1" inputmode="numeric"  pattern="\d*"  oninput="this.value = this.value.replace(/[^0-9]/g, '')"type="number"
                                                        value="{{ ($safety_thermometer_view['ambulances_en_route'] == 5) ? $safety_thermometer_view['ambulances_en_route'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulances_en_route][red]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <label for="" class="form-label">>6
                                                </label>
                                                <div class="opel-time-black bg-white" min="0" step="1">
                                                    <input class="form-control" type="number"
                                                        value="{{ ($safety_thermometer_view['ambulances_en_route'] > 6) ? $safety_thermometer_view['ambulances_en_route'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulances_en_route][black]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center ">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">Ambulance
                                                        <br class="d-none d-lg-block"> handover
                                                        delay
                                                    </label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" name="inflow[ambulance_handover_delay][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" @if($safety_thermometer_view['ambulance_handover_delay'] < 1) selected @endif>EMS 1</option>
                                                    <option value="2" @if($safety_thermometer_view['ambulance_handover_delay'] >= 15 && $safety_thermometer_view['ambulance_handover_delay'] <= 29) selected @endif>EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['ambulance_handover_delay'] >= 30 && $safety_thermometer_view['ambulance_handover_delay'] <= 59) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['ambulance_handover_delay'] > 60) selected @endif>EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">0
                                                </label>
                                                <div class="opel-time-green">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ ($safety_thermometer_view['ambulance_handover_delay'] < 1) ? $safety_thermometer_view['ambulance_handover_delay'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulance_handover_delay][green]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">15 - 29
                                                    Min</label>
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ ($safety_thermometer_view['ambulance_handover_delay'] >= 15 && $safety_thermometer_view['ambulance_handover_delay'] <= 29) ? $safety_thermometer_view['ambulance_handover_delay'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulance_handover_delay][amber]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">30 - 59 Min
                                                </label>
                                                <div class="opel-time-red">
                                                    <input class="form-control" type="number" readonly
                                                        value="{{ ($safety_thermometer_view['ambulance_handover_delay'] >= 30 && $safety_thermometer_view['ambulance_handover_delay'] <= 59) ? $safety_thermometer_view['ambulance_handover_delay'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulance_handover_delay][red]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">>60
                                                    Min</label>
                                                <div class="opel-time-black">
                                                    <input class="form-control" type="number" readonly
                                                        value="{{ ($safety_thermometer_view['ambulance_handover_delay'] > 60) ? $safety_thermometer_view['ambulance_handover_delay'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulance_handover_delay][black]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center ">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">Ambulances
                                                        held
                                                        <br class="d-none d-lg-block">
                                                    </label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for=""
                                                    class="d-none d-lg-block form-label">&nbsp;
                                                </label>
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" name="inflow[ambulances_held][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1" @if($safety_thermometer_view['ambulances_held'] < 1) selected @endif>EMS 1</option>
                                                    <option value="2" @if($safety_thermometer_view['ambulances_held'] >= 1 && $safety_thermometer_view['ambulances_held'] <= 3) selected @endif>EMS 2</option>
                                                    <option value="3" @if($safety_thermometer_view['ambulances_held'] == 4) selected @endif>EMS 3</option>
                                                    <option value="4" @if($safety_thermometer_view['ambulances_held'] > 4) selected @endif>EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">0
                                                </label>
                                                <div class="opel-time-green">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ ($safety_thermometer_view['ambulances_held'] < 1) ? $safety_thermometer_view['ambulances_held'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulances_held][green]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">1 - 3
                                                </label>
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="number" readonly
                                                         value="{{ ($safety_thermometer_view['ambulances_held'] >= 1 && $safety_thermometer_view['ambulances_held'] <= 3) ? $safety_thermometer_view['ambulances_held'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulances_held][amber]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">4
                                                </label>
                                                <div class="opel-time-red">
                                                    <input class="form-control" type="number" readonly
                                                        value="{{ ($safety_thermometer_view['ambulances_held'] == 4) ? $safety_thermometer_view['ambulances_held'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulances_held][red]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                                                <label for="" class="form-label">>4
                                                </label>
                                                <div class="opel-time-black">
                                                    <input class="form-control" type="number" readonly
                                                        value="{{ ($safety_thermometer_view['ambulances_held'] > 4) ? $safety_thermometer_view['ambulances_held'] : '' }}"
                                                        aria-label="default input example" name="inflow[ambulances_held][black]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-border-bottom">
                                        <div class="row align-items-center ">
                                            <div class="col-lg-2">
                                                <label for=""
                                                        class="form-label mb-lg-0">Patients in
                                                        <br class="d-none d-lg-block">Temporary Escalation Space
                                                    </label>
                                            </div>
                                            <div class="col-lg-2 mb-2 mb-lg-0">
                                                <select class="form-select w-100"
                                                    aria-label="Default select example" id="patients_in_temporary_escalation_space_opel" name="inflow[patients_in_temporary_escalation_space][opel]">
                                                    <option value="0">Select EMS </option>
                                                    <option value="1">EMS 1</option>
                                                    <option value="2">EMS 2</option>
                                                    <option value="3">EMS 3</option>
                                                    <option value="4">EMS 4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <div class=" opel-time-green w-100">
                                                    <select class="form-select"
                                                        aria-label="Default select example"  id="patients_in_temporary_escalation_space_green" name="inflow[patients_in_temporary_escalation_space][green]">
                                                        <option value="">Select </option>
                                                        <option value="1">YES</option>
                                                        <option value="2">NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <div class="opel-time-amber">
                                                    <input class="form-control" type="text"
                                                        placeholder="N/A" value="N/A"
                                                        aria-label="default input example" name="inflow[patients_in_temporary_escalation_space][amber]" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <div class="opel-time-red">
                                                    <input class="form-control" type="text"
                                                        placeholder="N/A" value="N/A"
                                                        aria-label="default input example" name="inflow[patients_in_temporary_escalation_space][red]" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2 mb-md-0">
                                                <div class=" opel-time-black w-100">
                                                    <select class="form-select "
                                                        aria-label="Default select example" name="inflow[patients_in_temporary_escalation_space][black]"  id="patients_in_temporary_escalation_space_black">
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
