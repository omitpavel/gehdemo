<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2 {{ PermissionDeniedDiv('discharge_tracker_medfit_yes_view') }}">
                    <a class="tab-custom-btn medfit_button  {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_yes_view') }}" data-button-content="yes"
                        ><div class="tab-active">Med FIT
                            YES - Live</div> </a>
                </li>
                <li class="mb-2 {{ PermissionDeniedDiv('discharge_tracker_medfit_yes_view') }}">
                    <a class="tab-custom-btn medfit_button active {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_yes_view') }}" data-button-content="yes_day"
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
                                    <div class="col-lg-3 col-md-6 mb-2">
                                        <div class="card-date">
                                          <div class="card-body">
                                            <div class="d-flex align-items-center">
                                              <div class="cyan-circle text-center me-2">
                                                <i class="bi bi-calendar3 "></i>
                                              </div>
                                              <div class="date-box w-90">
                                                <input type="text" name="datepicker" id="date_picker" placeholder="{{ PredefinedYearFormat($success_array['selected_date'] ) }}"  class="hasDatepicker">
                                              </div>

                                            </div>

                                          </div>
                                        </div>
                                      </div>
                                    <div class="col-lg-3 col-md-6 mb-2">
                                        <div class="bg-patients-count">
                                          <h6>Pending Referral</h6>
                                          <h5>{{ $success_array['cdt_patients'] }}</h5>
                                        </div>
                                      </div>
                                      <div class="col-xl-3 col-md-4 mb-2">
                                        <div class="bg-patients-count">
                                          <h6>Total (inc Pending)</h6>
                                          <h5>{{ (array_sum(array_column($success_array['medfit_data'], 'total'))+$success_array['cdt_patients']) }}</h5>
                                        </div>
                                      </div>
                                    <div class="col-lg-3 col-md-6 text-end mb-2">
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
                                            @foreach($success_array['medfit_data'] as $key => $data)

                                                @php
                                                    $p0 += $data['pathway_0'];
                                                    $p1 += $data['pathway_1'];
                                                    $p2 += $data['pathway_2'];
                                                    $p3 += $data['pathway_3'];
                                                    $total += $data['total'];
                                                @endphp
                                                <tr>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Service</div>
                                                        {{ $key }}
                                                    </td>

                                                    <td class="pivoted text-center cursor_pointer">
                                                        <div class="tdBefore">P0</div>
                                                        {{ $data['pathway_0'] }}
                                                    </td>
                                                    <td class="pivoted text-center cursor_pointer" >
                                                        <div class="tdBefore">P1</div>
                                                        {{ $data['pathway_1'] }}
                                                    </td>
                                                    <td class="pivoted text-center cursor_pointer" >
                                                        <div class="tdBefore">P2</div>
                                                        {{ $data['pathway_2'] }}
                                                    </td>
                                                    <td class="pivoted text-center cursor_pointer" >
                                                        <div class="tdBefore">P3</div>
                                                        {{ $data['pathway_3'] }}
                                                    </td>
                                                    <td class="pivoted text-center cursor_pointer">
                                                        <div class="tdBefore">Total</div>
                                                        {{ $data['total'] }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td class="pivoted">
                                                    Total
                                                </td>
                                                <td class="pivoted text-center cursor_pointer">
                                                    <div class="tdBefore">P0</div>
                                                    {{ $p0 }}
                                                </td>
                                                <td class="pivoted text-center cursor_pointer">
                                                    <div class="tdBefore">P1</div>
                                                    {{ $p1 }}
                                                </td>
                                                <td class="pivoted text-center cursor_pointer">
                                                    <div class="tdBefore">P2</div>
                                                    {{ $p2 }}
                                                </td>
                                                <td class="pivoted text-center cursor_pointer">
                                                    <div class="tdBefore">P3</div>
                                                    {{ $p3 }}
                                                </td>
                                                <td class="pivoted text-center cursor_pointer">
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
</div>
<input type="hidden" value="{{ $success_array['selected_date'] }}" id="date_picker_val">
<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
<script>
    $(function() {

            @if(!empty(request()->date))
        var start = moment('{{$success_array['selected_date']}}', 'YYYY-MM-DD');
            @else
        var start = moment().endOf('day');
        @endif

        function cb(start) {
            $('#date_picker_val').val(start.format('YYYY-MM-DD'));
            $('#date_picker').val(start.format('ddd MMMM D, YYYY'));
            if(start.format('YYYY-MM-DD') != '{{request()->date}}'){
               DataPageLoad();
            }
        }

        function DataPageLoad(){
            var token               = "{{ csrf_token() }}";
            if (!$('#patientDetails').hasClass('show')) {
                $('.page-data-loader').show();
            }else{
                $('.page-data-loader').hide();
            }
            var date = $('#date_picker_val').val();
            setTimeout(function() {
                $.ajax({
                    _token: token,
                    url: "{{ route('discharged.medfit.data.load') }}",
                    type: 'POST',
                    data: { "_token": token, "tab": "yes_day", "date": date, },
                    success: function (response)
                    {
                        if(response != "" && response != "{{ PermissionDenied() }}"){

                            $('#contentSection_data').html(response);
                            $('.page-data-loader').hide();
                        } else {
                            $('.page-data-loader').hide();
                            PermissionDeniedAlert();
                        }
                    },
                    error: function(status, err){
                        $('.page-data-loader').hide();
                    }
                });
            },2000)
        }
        $('#date_picker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            startDate: start,
            maxDate: moment(),
            locale: {
                format: 'ddd MMMM D, YYYY'
            }
        }, cb);



    });
</script>
