
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">

            <!-- Nav tabs -->

            <div class="sticky-toprow" id="stickyToprow">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2 {{ PermissionDeniedDiv('pharmacy_dashboard_view') }}">
                        <a class="tab-custom-btn @if ($success_array['tab_type'] == 'pharmacy_list') active @endif" @if(PermitedStatus('pharmacy_dashboard_view'))  onclick="TabType('pharmacy_list');" data-bs-toggle="tab" id="pharmacyListTab" @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif
                           href="#pharmacyList">
                            <div class="tab-active">Pharmacy List</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pharmacy_dashboard_screened_view') }}">
                        <a class="tab-custom-btn @if ($success_array['tab_type'] == 'pharmacy_screened') active @endif"  @if(PermitedStatus('pharmacy_dashboard_screened_view'))  onclick="TabType('pharmacy_screened');"  data-bs-toggle="tab" id="pharmacistScreenedTab" @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif
                           href="#pharmacistScreened">
                            <div class="tab-active">Pharmacist Screened</div>
                        </a>
                    </li>
                </ul>


                <div class="row gx-2 " id="screenedRow">
                    <div class="col-lg-2 col-md-6 mb-2">
                        {!! AllWardListDropdown('ward_id') !!}
                    </div>
                    <div class="col-lg-2 col-md-6 mb-2">
                        <select class="form-select" id="screened_status" aria-label="Default select example">
                            <option {{ $success_array['screened_status'] == 'all_patient' ? 'selected': '' }}  value="all_patient"> All Patient</option>
                            <option {{ $success_array['screened_status'] == '2' ? 'selected': '' }}  value="2">Screened</option>
                            <option  {{ $success_array['screened_status'] == 1 ? 'selected': '' }} value="1">Not Screened</option>
                        </select>
                    </div>
                    <div class="col-lg-8">
                        <div class="row gx-2">
                            <div class="col-md-4 mb-2">
                                <div class="bg-patients-count">
                                    <h6>Total Patients</h6>
                                    <h5>{{ $success_array['total_screened_not_screened'] }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="bg-patients-count">
                                    <h6>Total Not Screened</h6>
                                    <h5>{{  $success_array['total_not_screened'] }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="bg-patients-count">
                                    <h6>Total Screened</h6>
                                    <h5>{{ $success_array['total_screened_patient'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab panes -->

            <div class="tab-content" id="tabcontent">
                <input type="hidden" id="tab_type" value="{{  $success_array['tab_type'] }}">
                <div id="pharmacistScreened" class="tab-pane active">
                    <!-- <div class="custom_not_found">
                        No Records Found !
                    </div> -->
                    <div class="screened-patients-contents">
                        @if (count($success_array['patient_details']) > 0)
                            @foreach ($success_array['patient_details'] as $ward => $patient_info)
                        <div class="card-screened-patients mb-lg-2">
                            <div class="name">
                                <span>{{ $ward }}</span>
                            </div>
                            <table
                                class="breachReasonTable responsiveTable table-screened-patients">
                                <thead>
                                <tr class="position-relative">
                                    <th >Bed</th>
                                    <th >Name</th>
                                    <th >PAS Number</th>
                                    <th >Med Fit</th>
                                    <th >Consultant</th>
                                    <th >Admitted Date</th>
                                    <th width="150px"></th>
                                    <th width="150px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patient_info as $patient)
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">Bed</div>
                                        {{ $patient['ibox_actual_bed_full_name'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Name</div>
                                        {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">PAS Number</div>
                                        {{ $patient['camis_patient_pas_number'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Med Fit</div>
                                        <span class="medfit-text-{{ @$patient->BoardRoundMedicallyFitData->patient_medically_fit_status == 1 ? 'success' : 'danger' }}">{{ @$patient->BoardRoundMedicallyFitData->patient_medically_fit_status == 1 ? 'Yes' : 'No' }}</span>

                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Consultant</div>
                                        {{ $patient['camis_consultant_name'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Admitted Date</div>
                                        {{ PredefinedDateFormatFor24Hour($patient['camis_patient_admission_date_time']) }}

                                    </td>
                                    @if(isset($patient['pharmacy_screened_data']) && $patient['pharmacy_screened_data'] != null)
                                    <td class="pivoted">
                                        <div class="tdBefore"></div>

                                        <div class="bg-history-success">Screened</div>

                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore"></div>
                                        <button  @if(PermitedStatus('pharmacy_screened_history_view'))data-bs-toggle="offcanvas"   data-bs-target="#screenedHistory"  aria-controls="offcanvasRight" @endif onclick="ScreenedHistory('{{ $patient['camis_patient_id'] }}');"  class="btn btn-history">History</button>

                                    </td>
                                    @else
                                        <td class="pivoted">
                                            <div class="tdBefore"></div>

                                            <div class="bg-history-danger">Not Screened</div>

                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore"></div>
                                            <button  class="btn btn-history
                                                                    btn-history-disabled">History</button>
                                        </td>



                                    @endif
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                            @endforeach
                        @else
                            <div class="wards-patients-details">
                                <div class="custom_not_found">
                                    {{ NotFoundMessage() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function ScreenedHistory(patient_id) {
            @if(CheckSpecificPermission('pharmacy_screened_history_view'))
        var url = "{{ route('pharmacy.AllScreenedHistory') }}";

        $('.page-data-loader').show();
        $.ajax({
            url: url,
            type: 'GET',
            data: {patient_id:patient_id},
            success: function (result)
            {
                if(result != '{{PermissionDenied()}}'){

                    $('#screened_patient_data').html(result);
                    $('.page-data-loader').hide();
                } else {
                    $('.page-data-loader').hide();
                    toastr.error('Permission Restricted.');
                }
            }
        });
        @else
        toastr.error('Permission Denied');
        @endif
    }
</script>

<script>
    var windowWidth = window.innerWidth;
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector('.bg-sticky');
                bgSticky.style.top = '185px';
                var stickyHeader = document.querySelectorAll('.sticky-header');
                stickyHeader.forEach(function (header) {
                    header.style.top = '185px';
                })
            }
        }
    }
</script>
<script>
    var windowWidth = window.innerWidth;
    if (windowWidth > 1026) {
        $("#listRow").show();
        $("#screenedRow").show();
        $("#hideBgSticky").removeClass("bg-sticky");
        $(".sticky-toprow").height("92px");



    } else if (windowWidth < 1026) {
        $("#listRow").show();
        $("#screenedRow").show();

        $("#pharmacistScreenedTab").click(function () {
            $("#listRow").show();
            $("#screenedRow").show();
        });
    }
</script>


