<div class="col-lg-12">
    <div class="bed-management">

        <div class="count-details-row">
            <div class="count-details-col">
              <div class="">
                <div class="blue-tile-top">
                  <h6>TOTAL BEDS</h6>
                </div>
                <div class="tile-count-bottom">
                  <div class="row gx-2">
                    <div class="col-3 border-end">
                      <div class="data-details">
                        <p class="header-data-details">Total</p>
                        <h6 class="value-data-details">{{ $success_array['total_occupied']['total'] }}</h6>
                      </div>
                    </div>
                    <div class="col-3 border-end">
                        <div class="data-details">
                          <p class="header-data-details">Rstr.</p>
                          <h6 class="value-data-details">{{ $success_array['total_occupied']['restrict'] }}</h6>
                        </div>
                      </div>
                    <div class="col-3 border-end">
                      <div class="data-details">
                        <p class="header-data-details">Empty</p>
                        <h6 class="value-data-details">{{ $success_array['total_occupied']['available'] }}</h6>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="data-details">
                        <p class="header-data-details">Occ</p>
                        <h6 class="value-data-details">{{ $success_array['total_occupied']['occupied'] }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="count-details-col">
              <div class="">
                <div class="blue-tile-top">
                  <h6>MALE BEDS</h6>
                </div>
                <div class="tile-count-bottom">
                  <div class="row gx-2">
                    <div class="col-3 border-end">
                      <div class="data-details">
                        <p class="header-data-details">Total</p>
                        <h6 class="value-data-details">{{ $success_array['male_empty']['total'] }}</h6>
                      </div>
                    </div>
                    <div class="col-3 border-end">
                        <div class="data-details">
                          <p class="header-data-details">Rstr.</p>
                          <h6 class="value-data-details">{{ $success_array['male_empty']['restrict'] }}</h6>
                        </div>
                      </div>
                    <div class="col-3 border-end">
                      <div class="data-details">
                        <p class="header-data-details">Empty</p>
                        <h6 class="value-data-details">{{ $success_array['male_empty']['available'] }}</h6>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="data-details">
                        <p class="header-data-details">Occ</p>
                        <h6 class="value-data-details">{{ $success_array['male_empty']['occupied'] }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="count-details-col">
              <div class="">
                <div class="blue-tile-top">
                  <h6>FEMALE BEDS</h6>
                </div>
                <div class="tile-count-bottom">
                  <div class="row gx-2">
                    <div class="col-3 border-end">
                      <div class="data-details">
                        <p class="header-data-details">Total</p>
                        <h6 class="value-data-details">{{ $success_array['female_empty']['total'] }}</h6>
                      </div>
                    </div>
                    <div class="col-3 border-end">
                        <div class="data-details">
                          <p class="header-data-details">Rstr.</p>
                          <h6 class="value-data-details">{{ $success_array['female_empty']['restrict'] }}</h6>
                        </div>
                      </div>
                    <div class="col-3 border-end">
                      <div class="data-details">
                        <p class="header-data-details">Empty</p>
                        <h6 class="value-data-details">{{ $success_array['female_empty']['available'] }}</h6>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="data-details">
                        <p class="header-data-details">Occ</p>
                        <h6 class="value-data-details">{{ $success_array['female_empty']['occupied'] }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="count-details-col">
              <div class="">
                <div class="blue-tile-top">
                  <h6>SIDEROOM BEDS</h6>
                </div>
                <div class="tile-count-bottom">
                  <div class="row gx-2">
                    <div class="col-3 border-end">
                      <div class="data-details">
                        <p class="header-data-details">Total</p>
                        <h6 class="value-data-details">{{ $success_array['sr_empty']['total'] }}</h6>
                      </div>
                    </div>
                    <div class="col-3 border-end">
                        <div class="data-details">
                          <p class="header-data-details">Rstr.</p>
                          <h6 class="value-data-details">{{ $success_array['sr_empty']['restrict'] }}</h6>
                        </div>
                      </div>
                    <div class="col-3 border-end">
                      <div class="data-details">
                        <p class="header-data-details">Empty</p>
                        <h6 class="value-data-details">{{ $success_array['sr_empty']['available'] }}</h6>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="data-details">
                        <p class="header-data-details">Occ</p>
                        <h6 class="value-data-details">{{ $success_array['sr_empty']['occupied'] }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="count-details-col">
              <div class="">
                <div class="blue-tile-top">
                  <h6>ESCALATION BEDS</h6>
                </div>
                <div class="tile-count-bottom">
                  <div class="row gx-2">
                    <div class="col-3 border-end">
                      <div class="data-details">
                        <p class="header-data-details">Total</p>
                        <h6 class="value-data-details">{{ $success_array['escalation']['total'] }}</h6>
                      </div>
                    </div>
                    <div class="col-3 border-end">
                        <div class="data-details">
                          <p class="header-data-details">Rstr.</p>
                          <h6 class="value-data-details">{{ $success_array['escalation']['restrict'] }}</h6>
                        </div>
                      </div>
                    <div class="col-3 border-end">
                      <div class="data-details">
                        <p class="header-data-details">Empty</p>
                        <h6 class="value-data-details">{{ $success_array['escalation']['available'] }}</h6>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="data-details">
                        <p class="header-data-details">Occ</p>
                        <h6 class="value-data-details">{{ $success_array['escalation']['occupied'] }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="count-details-col-2">
              <div class="grey-rectangle-1">
                <div class="row gx-2 align-items-center  click_open_definite_discharges cursor_pointer">
                  <div class="col-md-8 col-8">
                    <h6 class="mb-0">DEFINITE <br class="d-none d-md-block">DISCHARGES TODAY</h6>
                  </div>
                  <div class="col-md-4 col-4 text-center border-start">
                    <h5 class="mb-0 text-cyan">{{ $success_array['total_definite'] }}</h5>
                  </div>
                </div>
                <div class="separation"></div>
                <div class="row gx-2 align-items-center  click_open_potential_discharges cursor_pointer">
                  <div class="col-md-8 col-8">
                    <h6 class="mb-0">POTENTIALS <br class="d-none d-md-block">DISCHARGES
                        TODAY
                    </h6>
                  </div>
                  <div class="col-md-4 col-4 text-center border-start">
                    <h5 class="mb-0 text-cyan">{{ $success_array['total_poteintial'] }}</h5>
                  </div>
                </div>
              </div>
            </div>
        </div>




        <div class="row  gx-2">


            <div class="col-xl-4">
                <div class="rectangle-block-1 mb-1 ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="rectangle-block-2">
                                <p class="mb-0 ward-name">MEDICAL WARDS</p>
                            </div>
                        </div>
                    </div>
                    <div class="bed-count-header-row align-items-center mb-2">
                        <div class="bed-count-header-col-1 pe-0">
                        </div>
                        <div class="bed-count-header-col-2 ps-0">
                            <div class="bed-count-header-subrow">
                                <div class="bed-count-subrow-col-1">
                                    <div class="bed-count-header-subcol">
                                        <div class="border-end">
                                            <h6 class="text-center mb-0">Total <br>
                                                Beds</h6>
                                        </div>
                                    </div>
                                    <div class="bed-count-header-subcol">
                                        <div class="border-end">
                                            <h6 class="text-center mb-0">Rstr. <br>
                                                Beds</h6>
                                        </div>
                                    </div>
                                    <div class="bed-count-header-subcol">
                                        <div class="border-end">
                                            <h6 class="text-center mb-0">Occ<br>
                                                Beds</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="bed-count-subrow-col-2">
                                    <div class="header-row">
                                        <div class="empty-col">
                                            <h6>Empty Beds</h6>
                                        </div>
                                    </div>
                                    <div class="empty-count">
                                        <div class="bed-count-header-subcol">
                                            <div class="border-end">
                                                <h6 class="fw-bold text-blue mb-0">M</h6>
                                            </div>
                                        </div>
                                        <div class="bed-count-header-subcol">
                                            <div class="border-end">
                                                <h6 class="fw-bold text-green mb-0">F</h6>
                                            </div>
                                        </div>
                                        <div class="bed-count-header-subcol">
                                            <div class="border-end">
                                                <h6 class="fw-bold text-maroon mb-0">SR</h6>
                                            </div>
                                        </div>
                                        <div class="bed-count-header-subcol">
                                            <div class="">
                                                <h6 class="fw-bold text-orange mb-0">TES</h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white">
                        <div class="bg-total ">
                            <ul class="bed-count-row mb-0">
                                <li class="bed-mngmt-leftside-bg">Total</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['medical_wards'], 'total_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['medical_wards'], 'restrict_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['medical_wards'], 'occupied_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['medical_wards'], 'male_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['medical_wards'], 'female_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['medical_wards'], 'sr_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['medical_wards'], 'escalation_bed')) }}</li>
                            </ul>
                        </div>



                        @foreach ($success_array['medical_wards'] as $row_data)
                        <ul class="bed-count-row">
                            <li @if (CheckSpecificPermission('camis_classic_view')) data-ward-name="{{ $row_data['ward_short_name'] }}" data-extension="{{ $row_data['extension_number'] }}" data-bed-id="{{ $row_data['ward_url_name'] }}" class="bed-mngmt-leftside-bg show_bed" @else class="bed-mngmt-leftside-bg" @endif>{{ $row_data['ward_name'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['total_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['restrict_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['occupied_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['male_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['female_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['sr_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['escalation_bed'] }}</li>
                        </ul>
                        @endforeach


                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="rectangle-block-1 mb-1">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="rectangle-block-2">
                                <p class="mb-0 ward-name">SURGICAL WARDS</p>
                            </div>
                        </div>
                    </div>
                    <div class="bed-count-header-row align-items-center mb-2">
                        <div class="bed-count-header-col-1 pe-0">
                        </div>
                        <div class="bed-count-header-col-2 ps-0">
                            <div class="bed-count-header-subrow">
                                <div class="bed-count-subrow-col-1">
                                    <div class="bed-count-header-subcol">
                                        <div class="border-end">
                                            <h6 class="text-center mb-0">Total <br>
                                                Beds</h6>
                                        </div>
                                    </div>
                                    <div class="bed-count-header-subcol">
                                        <div class="border-end">
                                            <h6 class="text-center mb-0">Rstr. <br>
                                                Beds</h6>
                                        </div>
                                    </div>
                                    <div class="bed-count-header-subcol">
                                        <div class="border-end">
                                            <h6 class="text-center mb-0">Occ<br>
                                                Beds</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="bed-count-subrow-col-2">
                                    <div class="header-row">
                                        <div class="empty-col">
                                            <h6>Empty Beds</h6>
                                        </div>
                                    </div>
                                    <div class="empty-count">
                                        <div class="bed-count-header-subcol">
                                            <div class="border-end">
                                                <h6 class="fw-bold text-blue mb-0">M</h6>
                                            </div>
                                        </div>
                                        <div class="bed-count-header-subcol">
                                            <div class="border-end">
                                                <h6 class="fw-bold text-green mb-0">F</h6>
                                            </div>
                                        </div>
                                        <div class="bed-count-header-subcol">
                                            <div class="border-end">
                                                <h6 class="fw-bold text-maroon mb-0">SR</h6>
                                            </div>
                                        </div>
                                        <div class="bed-count-header-subcol">
                                            <div class="">
                                                <h6 class="fw-bold text-orange mb-0">TES</h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white">
                        <div class="bg-total ">
                            <ul class="bed-count-row mb-0">
                                <li class="bed-mngmt-leftside-bg">Total</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['surgical_wards'], 'total_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['surgical_wards'], 'restrict_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['surgical_wards'], 'occupied_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['surgical_wards'], 'male_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['surgical_wards'], 'female_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['surgical_wards'], 'sr_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['surgical_wards'], 'escalation_bed')) }}</li>
                            </ul>
                        </div>



                        @foreach ($success_array['surgical_wards'] as $row_data)
                        <ul class="bed-count-row">
                            <li @if (CheckSpecificPermission('camis_classic_view')) data-ward-name="{{ $row_data['ward_short_name'] }}" data-extension="{{ $row_data['extension_number'] }}" data-bed-id="{{ $row_data['ward_url_name'] }}" class="bed-mngmt-leftside-bg show_bed" @else class="bed-mngmt-leftside-bg" @endif>{{ $row_data['ward_name'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['total_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['restrict_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['occupied_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['male_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['female_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['sr_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['escalation_bed'] }}</li>
                        </ul>
                        @endforeach


                    </div>
                </div>
                <div class="rectangle-block-1 mb-1 ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="rectangle-block-2">
                                <p class="mb-0 ward-name">OTHER WARDS <span class="fw-normal">(Not
                                        included in Bed Count Above)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bed-count-header-row align-items-center mb-2">
                        <div class="bed-count-header-col-1 pe-0">
                        </div>
                        <div class="bed-count-header-col-2 ps-0">
                            <div class="bed-count-header-subrow">
                                <div class="bed-count-subrow-col-1">
                                    <div class="bed-count-header-subcol">
                                        <div class="border-end">
                                            <h6 class="text-center mb-0">Total <br>
                                                Beds</h6>
                                        </div>
                                    </div>
                                    <div class="bed-count-header-subcol">
                                        <div class="border-end">
                                            <h6 class="text-center mb-0">Rstr. <br>
                                                Beds</h6>
                                        </div>
                                    </div>
                                    <div class="bed-count-header-subcol">
                                        <div class="border-end">
                                            <h6 class="text-center mb-0">Occ<br>
                                                Beds</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="bed-count-subrow-col-2">
                                    <div class="header-row">
                                        <div class="empty-col">
                                            <h6>Empty Beds</h6>
                                        </div>
                                    </div>
                                    <div class="empty-count">
                                        <div class="bed-count-header-subcol">
                                            <div class="border-end">
                                                <h6 class="fw-bold text-blue mb-0">M</h6>
                                            </div>
                                        </div>
                                        <div class="bed-count-header-subcol">
                                            <div class="border-end">
                                                <h6 class="fw-bold text-green mb-0">F</h6>
                                            </div>
                                        </div>
                                        <div class="bed-count-header-subcol">
                                            <div class="border-end">
                                                <h6 class="fw-bold text-maroon mb-0">SR</h6>
                                            </div>
                                        </div>
                                        <div class="bed-count-header-subcol">
                                            <div class="">
                                                <h6 class="fw-bold text-orange mb-0">TES</h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white">
                        <div class="bg-total ">
                            <ul class="bed-count-row mb-0">
                                <li class="bed-mngmt-leftside-bg">Total</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['others_wards'], 'total_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['others_wards'], 'restrict_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['others_wards'], 'occupied_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['others_wards'], 'male_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['others_wards'], 'female_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['others_wards'], 'sr_bed')) }}</li>
                                <li class="bed-mngmt-rightside-list">{{ array_sum(array_column($success_array['others_wards'], 'escalation_bed')) }}</li>
                            </ul>
                        </div>



                        @foreach ($success_array['others_wards'] as $row_data)
                        <ul class="bed-count-row">
                            <li @if (CheckSpecificPermission('camis_classic_view')) data-ward-name="{{ $row_data['ward_short_name'] }}" data-extension="{{ $row_data['extension_number'] }}" data-bed-id="{{ $row_data['ward_url_name'] }}" class="bed-mngmt-leftside-bg show_bed" @else class="bed-mngmt-leftside-bg" @endif>{{ $row_data['ward_name'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['total_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['restrict_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['occupied_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['male_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['female_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['sr_bed'] }}</li>
                            <li class="bed-mngmt-rightside-list">{{ $row_data['escalation_bed'] }}</li>
                        </ul>
                        @endforeach


                    </div>
                </div>
            </div>



            <div class="col-xl-4">


            </div>


























        </div>
    </div>
</div>
