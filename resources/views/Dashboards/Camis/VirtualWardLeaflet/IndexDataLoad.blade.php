<div class="col-lg-12  ">
    <div class="row g-2 mb-2">
        <div class="col-xxl-5 col-md-6">
            <div class="card-virtual-ward">
                <p>Total Occupied Beds</p>
                <div class="row">
                    <div class="col-lg-6 pe-lg-1 mb-2">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-8 pe-0">
                                <div class="text-bed-occupied">
                                    <input type="text" id="" class="form-control"
                                           placeholder="Bed Occupied" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 ps-0">
                                <div class="text-leaflet cyan-input">
                                    <input type="text" id="" class="form-control" placeholder="{{$success_array['total_beds']}}" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 ps-lg-1">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-8 pe-0">
                                <div class="text-bed-occupied">
                                    <input type="text" id="" class="form-control"
                                           placeholder="Leaflet 01" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 ps-0">
                                <div class="text-leaflet maroon-input">
                                    <input type="text" id="" class="form-control" placeholder="{{$success_array['total_beds_leaflet_one_clicked_percentage']}}%" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-5 col-md-6">
            <div class="card-virtual-ward">
                <p>Leaflet 01 on Admission</p>
                <div class="row">
                    <div class="col-lg-6 pe-lg-1 mb-2">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-8 pe-0">
                                <div class="text-bed-occupied">
                                    <input type="text" id="" class="form-control"
                                           placeholder="Clicked < 48 Hours" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 ps-0">
                                <div class="text-leaflet green-input">
                                    <input type="text" id="" class="form-control" placeholder="{{ $success_array['leaflet_less_48_hrs'] }}%" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 ps-lg-1">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-8 pe-0">
                                <div class="text-bed-occupied">
                                    <input type="text" id="" class="form-control"
                                           placeholder="Clicked > 48 Hours" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 ps-0">
                                <div class="text-leaflet orange-input">
                                    <input type="text" id="" class="form-control" placeholder="{{$success_array['leaflet_greater_48_hrs']}}%" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gx-2 mb-2">
        <div class="col-xxl-6">
            <div class="card-leaflet-table">
                <div class="leaflet-assessment-ward">
                    <table class="breachReasonTable responsiveTable table-leaflet-ward">
                        <thead>
                        <tr class="position-relative">
                            <th rowspan="2">ASSESSMENT <br> WARDS</th>
                            <th rowspan="2">Occupied Beds </th>
                            <th colspan="4" class="bg-thead-custom text-center">Leaflet 01 </th>
                            <th colspan="2" class="bg-thead-blue text-center">Leaflet 02 </th>
                        </tr>
                        <tr>
                            <th class="fs-12">Clicked < 48 Hours</th>
                            <th class="fs-12">Clicked > 48 Hours</th>
                            <th class="fs-12">Not Clicked</th>
                            <th class="fs-12">Clicked</th>
                            <th class="fs-12">Not Clicked</th>
                            <th class="fs-12">Clicked</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($success_array['leaflet_info_details']['Assessment']['Assessment']) && count($success_array['leaflet_info_details']['Assessment']['Assessment']) > 0)
                            @foreach($success_array['leaflet_info_details']['Assessment']['Assessment'] as $ward)
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">ASSESSMENT WARDS</div>
                                        {{$ward['ward_name']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Occupied Beds</div>
                                        {{$ward['bed_occupied_ward_total']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Clicked < 48 Hours</div>
                                        0
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Clicked > 48 Hours</div>
                                        {{$ward['bed_occupied_leaflet_one_clicked']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Not Clicked</div>
                                        {{$ward['bed_occupied_leaflet_one_not_clicked']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Clicked </div>
                                        {{$ward['bed_occupied_leaflet_one_clicked_percentage']}}%
                                    </td>
                                    <td class="completion-row pivoted text-center">
                                        <div class="tdBefore">Leaflet 02 Not Clicked</div>
                                        {{$ward['bed_occupied_leaflet_two_not_clicked']}}
                                    </td>
                                    <td class="completion-row pivoted text-center">
                                        <div class="tdBefore">Leaflet 02 Clicked </div>
                                        {{$ward['bed_occupied_leaflet_two_clicked']}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        <tr>
                            <td class="pivoted">
                                <div class="tdBefore">ASSESSMENT WARDS</div>
                                Total
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Occupied Beds</div>
                                {{$success_array['leaflet_info_details']['Assessment']['total_Assessment_beds'] ?? '0'}}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Clicked < 48 Hours</div>
                                0
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Clicked > 48 Hours</div>
                                {{$success_array['leaflet_info_details']['Assessment']['total_Assessment_leaflet_one_clicked_beds'] ?? '0'}}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Not Clicked</div>
                                {{$success_array['leaflet_info_details']['Assessment']['total_Assessment_leaflet_one_not_clicked_beds'] ?? '0'}}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Clicked </div>
                                {{$success_array['leaflet_info_details']['Assessment']['total_Assessment_leaflet_one_clicked_beds_percentage'] ?? '0'}}%
                            </td>
                            <td class="completion-row pivoted text-center">
                                <div class="tdBefore">Leaflet 02 Not Clicked</div>
                                {{$success_array['leaflet_info_details']['Assessment']['total_Assessment_leaflet_two_not_clicked_beds'] ?? '0'}}
                            </td>
                            <td class="completion-row pivoted text-center">
                                <div class="tdBefore">Leaflet 02 Clicked </div>
                                {{$success_array['leaflet_info_details']['Assessment']['total_Assessment_leaflet_two_clicked_beds'] ?? '0'}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-leaflet-table">
                <div class="leaflet-medical-ward">
                    <table class="breachReasonTable responsiveTable table-leaflet-ward">
                        <thead>
                        <tr class="position-relative">
                            <th rowspan="2">MEDICAL <br> WARDS</th>
                            <th rowspan="2">Occupied Beds </th>
                            <th colspan="4" class="bg-thead-black text-center">Leaflet 01 </th>
                            <th colspan="2" class="bg-thead-grey text-center">Leaflet 02 </th>
                        </tr>
                        <tr>
                            <th class="fs-12">Clicked < 48 Hours</th> <th class="fs-12">Clicked
                                >
                                48
                                Hours</th>
                            <th class="fs-12">Not Clicked</th>
                            <th class="fs-12">Clicked</th>
                            <th class="fs-12">Not Clicked</th>
                            <th class="fs-12">Clicked</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($success_array['leaflet_info_details']['Medical']['Medical']) && count($success_array['leaflet_info_details']['Medical']['Medical']) > 0)
                            @foreach($success_array['leaflet_info_details']['Medical']['Medical'] as $ward)
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">MEDICAL WARDS</div>
                                        {{$ward['ward_name']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Occupied Beds</div>
                                        {{$ward['bed_occupied_ward_total']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Clicked < 48 Hours</div>
                                        0
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Clicked > 48 Hours</div>
                                        {{$ward['bed_occupied_leaflet_one_clicked']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Not Clicked</div>
                                        {{$ward['bed_occupied_leaflet_one_not_clicked']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Clicked </div>
                                        {{$ward['bed_occupied_leaflet_one_clicked_percentage']}}%
                                    </td>
                                    <td class="completion-row pivoted text-center">
                                        <div class="tdBefore">Leaflet 02 Not Clicked</div>
                                        {{$ward['bed_occupied_leaflet_two_not_clicked']}}
                                    </td>
                                    <td class="completion-row pivoted text-center">
                                        <div class="tdBefore">Leaflet 02 Clicked </div>
                                        {{$ward['bed_occupied_leaflet_two_clicked']}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td class="pivoted">
                                <div class="tdBefore">MEDICAL WARDS</div>
                                Total
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Occupied Beds</div>
                                {{$success_array['leaflet_info_details']['Medical']['total_Medical_beds']}}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Clicked < 48 Hours</div>
                                0
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Clicked > 48 Hours</div>
                                {{$success_array['leaflet_info_details']['Medical']['total_Medical_leaflet_one_clicked_beds']}}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Not Clicked</div>
                                {{$success_array['leaflet_info_details']['Medical']['total_Medical_leaflet_one_not_clicked_beds']}}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Clicked </div>
                                {{$success_array['leaflet_info_details']['Medical']['total_Medical_leaflet_one_clicked_beds_percentage']}}%
                            </td>
                            <td class="completion-row pivoted text-center">
                                <div class="tdBefore">Leaflet 02 Not Clicked</div>
                                {{$success_array['leaflet_info_details']['Medical']['total_Medical_leaflet_two_not_clicked_beds']}}
                            </td>
                            <td class="completion-row pivoted text-center">
                                <div class="tdBefore">Leaflet 02 Clicked </div>
                                {{$success_array['leaflet_info_details']['Medical']['total_Medical_leaflet_two_clicked_beds']}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card-leaflet-table">
                <div class="leaflet-surgical-ward">
                    <table class="breachReasonTable responsiveTable table-leaflet-ward">
                        <thead>
                        <tr class="position-relative">
                            <th rowspan="2">SURGICAL <br> WARDS</th>
                            <th rowspan="2">Occupied Beds </th>
                            <th colspan="4" class="bg-thead-darkcyan text-center">Leaflet 01
                            </th>
                            <th colspan="2" class="bg-thead-cyan text-center">Leaflet 02 </th>
                        </tr>
                        <tr>
                            <th class="fs-12">Clicked < 48 Hours</th> <th class="fs-12">Clicked
                                >
                                48
                                Hours</th>
                            <th class="fs-12">Not Clicked</th>
                            <th class="fs-12">Clicked</th>
                            <th class="fs-12">Not Clicked</th>
                            <th class="fs-12">Clicked</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($success_array['leaflet_info_details']['Surgical']['Surgical']) && count($success_array['leaflet_info_details']['Surgical']['Surgical']) > 0)
                            @foreach($success_array['leaflet_info_details']['Surgical']['Surgical'] as $ward)
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">SURGICAL WARDS</div>
                                        {{$ward['ward_name']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Occupied Beds</div>
                                        {{$ward['bed_occupied_ward_total']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Clicked < 48 Hours</div>
                                        0
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Clicked > 48 Hours</div>
                                        {{$ward['bed_occupied_leaflet_one_clicked']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Not Clicked</div>
                                        {{$ward['bed_occupied_leaflet_one_not_clicked']}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Leaflet 01 Clicked </div>
                                        {{$ward['bed_occupied_leaflet_one_clicked_percentage']}}%
                                    </td>
                                    <td class="completion-row pivoted text-center">
                                        <div class="tdBefore">Leaflet 02 Not Clicked</div>
                                        {{$ward['bed_occupied_leaflet_two_not_clicked']}}
                                    </td>
                                    <td class="completion-row pivoted text-center">
                                        <div class="tdBefore">Leaflet 02 Clicked </div>
                                        {{$ward['bed_occupied_leaflet_two_clicked']}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td class="pivoted">
                                <div class="tdBefore">SURGICAL WARDS</div>
                                Total
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Occupied Beds</div>
                                {{$success_array['leaflet_info_details']['Surgical']['total_Surgical_beds']}}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Clicked < 48 Hours</div>
                                0
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Clicked > 48 Hours</div>
                                {{$success_array['leaflet_info_details']['Surgical']['total_Surgical_leaflet_one_clicked_beds']}}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Not Clicked</div>
                                {{$success_array['leaflet_info_details']['Surgical']['total_Surgical_leaflet_one_not_clicked_beds']}}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Leaflet 01 Clicked </div>
                                {{$success_array['leaflet_info_details']['Surgical']['total_Surgical_leaflet_one_clicked_beds_percentage']}}%
                            </td>
                            <td class="completion-row pivoted text-center">
                                <div class="tdBefore">Leaflet 02 Not Clicked</div>
                                {{$success_array['leaflet_info_details']['Surgical']['total_Surgical_leaflet_two_not_clicked_beds']}}
                            </td>
                            <td class="completion-row pivoted text-center">
                                <div class="tdBefore">Leaflet 02 Clicked </div>
                                {{$success_array['leaflet_info_details']['Surgical']['total_Surgical_leaflet_two_clicked_beds']}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
