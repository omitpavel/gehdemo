<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2 {{ PermissionDeniedDiv('discharge_tracker_medfit_yes_view') }}">
                    <a class="tab-custom-btn medfit_button active {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_yes_view') }}" data-button-content="yes"
                        ><div class="tab-active">Med FIT
                            YES - Live</div> </a>
                </li>
                <li class="mb-2 {{ PermissionDeniedDiv('discharge_tracker_medfit_yes_view') }}">
                    <a class="tab-custom-btn medfit_button  {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_yes_view') }}" data-button-content="yes_day"
                        ><div class="tab-active">Med FIT
                            YES - Day Summary </div> </a>
                </li>
                <li class="mb-2 {{ PermissionDeniedDiv('discharge_tracker_medfit_no_view') }}">
                    <a class="tab-custom-btn medfit_button {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_no_view') }}"  data-button-content="no" href="#medfitNo">
                        <div class="tab-active">Med FIT NO</div>
                    </a>
                </li>
            </ul>

            <input hidden id="medfit_data" value="">
            <div class="tab-content" id="tabcontent">
                <div id="medfitYes" class=" tab-pane active ">
                    <div class="row ">
                        <div class="container-fluid">
                            <div class="col-lg-12">
                                <div class="row gx-2 medically-fit">
                                    <div class="col-xl-1 col-lg-1 mb-2">
                                        <div class="live">
                                          <div class="circle"></div>LIVE
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-4 mb-2">
                                        <div class="bg-patients-count">
                                          <h6>Pending Referral</h6>
                                          <h5>{{ count($cdt_count) }}</h5>
                                        </div>
                                      </div>
                                      <div class="col-xl-3 col-md-4 mb-2">
                                        <div class="bg-patients-count">
                                          <h6>Total (inc Pending)</h6>
                                          <h5>{{ (array_sum(array_column($success_array, 'total'))+count($cdt_count)) }}</h5>
                                        </div>
                                      </div>
                                    <div
                                        class="col-xl-3 col-lg-3 col-md-4 offset-xl-2 text-end mb-2">
                                        <div class="row gx-2">
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <button type="button"
                                                    class="btn btn-export w-100 export_medfit_yes {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_yes_export_view') }}">
                                                    <img src="{{ asset('asset_v2/Template') }}/icons/export.svg" alt="" class="me-2" width="15">
                                                    Export</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <button type="button"
                                                    class="btn btn-export w-100 discharge_tracker_medfit_yes_print  {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_yes_print') }}">
                                                    <img src="{{ asset('asset_v2/Template') }}/icons/print.svg" alt="" class="me-2" width="16">
                                                    Print</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-medfit medfit_yes_print_content">
                                    <table class="breachReasonTable responsiveTable table-medfit">
                                        <thead>
                                            <tr class="position-relative">
                                                <th>Authority</th>
                                                <th>P0</th>
                                                <th>P1</th>
                                                <th>P2</th>
                                                <th>P3</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $p0 = 0;
                                                $p1 = 0;
                                                $p2 = 0;
                                                $p3 = 0;
                                                $total = 0;
                                            @endphp
                                            @foreach($success_array as $data)

                                                @php
                                                    $p0 += $data['p0'];
                                                    $p1 += $data['p1'];
                                                    $p2 += $data['p2'];
                                                    $p3 += $data['p3'];
                                                    $total += $data['total'];
                                                @endphp
                                                <tr>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Service</div>
                                                        {{ !empty($data['service']) ? $data['service'] : 'No Authority Assigned' }}
                                                    </td>

                                                    <td class="pivoted text-center cursor_pointer"  onclick="GetMedfitList('{{ $data['service'] }}', 'P0');">
                                                        <div class="tdBefore">P0</div>
                                                        {{ $data['p0'] }}
                                                    </td>
                                                    <td class="pivoted text-center cursor_pointer"  onclick="GetMedfitList('{{ $data['service'] }}', 'P1');">
                                                        <div class="tdBefore">P1</div>
                                                        {{ $data['p1'] }}
                                                    </td>
                                                    <td class="pivoted text-center cursor_pointer"  onclick="GetMedfitList('{{ $data['service'] }}', 'P2');">
                                                        <div class="tdBefore">P2</div>
                                                        {{ $data['p2'] }}
                                                    </td>
                                                    <td class="pivoted text-center cursor_pointer"  onclick="GetMedfitList('{{ $data['service'] }}', 'P3');">
                                                        <div class="tdBefore">P3</div>
                                                        {{ $data['p3'] }}
                                                    </td>
                                                    <td class="pivoted text-center cursor_pointer" onclick="GetMedfitList('{{ $data['service'] }}', 'TOTAL');">
                                                        <div class="tdBefore">Total</div>
                                                        {{ $data['total'] }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td class="pivoted">
                                                    Total
                                                </td>
                                                <td class="pivoted text-center cursor_pointer" onclick="GetMedfitList('TOTAL', 'P0');">
                                                    <div class="tdBefore">P0</div>
                                                    {{ $p0 }}
                                                </td>
                                                <td class="pivoted text-center cursor_pointer" onclick="GetMedfitList('TOTAL', 'P1');">
                                                    <div class="tdBefore">P1</div>
                                                    {{ $p1 }}
                                                </td>
                                                <td class="pivoted text-center cursor_pointer" onclick="GetMedfitList('TOTAL', 'P2');">
                                                    <div class="tdBefore">P2</div>
                                                    {{ $p2 }}
                                                </td>
                                                <td class="pivoted text-center cursor_pointer" onclick="GetMedfitList('TOTAL', 'P3');">
                                                    <div class="tdBefore">P3</div>
                                                    {{ $p3 }}
                                                </td>
                                                <td class="pivoted text-center cursor_pointer" onclick="GetMedfitList('TOTAL', 'TOTAL');">
                                                    <div class="tdBefore">Total</div>
                                                    {{ $total }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div id="summary_table_data_print">

    </div>
</div>
