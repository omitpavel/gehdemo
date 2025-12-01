<div class="offcanvas-header card-header fw-bold">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div class="">
            <h6 class="mb-0" id="current_provider_title">Patient By Current Provider</h6>
        </div>
        <div class="d-flex align-items-center">
            <div class="btn-custom-print {{ PermissionDeniedDiv('discharge_tracker_performance_current_provider_export_view') }}">
                <button class="btn btn-primary-grey"  @if(PermitedStatus('discharge_tracker_performance_current_provider_export_view'))   @if (isset($success_array['current_provider_patient_list']) && count($success_array['current_provider_patient_list']) > 0) onclick="location.href='{{ route('discharged.PerformanceLosExport','current_provider') }}';" @endif @else  onclick="CommonLoginModalPopupOpenOnRequest();" @endif><img src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt="" class="btn-icon-modal" width="16" height="16"><span class="d-none d-md-block">EXPORT</span>
                </button>
            </div>
            <div class="btn-custom-print {{ PermissionDeniedDiv('discharge_tracker_performance_export_print') }}">
                <button class="btn btn-primary-grey export_patient_list_los_21_more @if(PermitedStatus('discharge_tracker_performance_export_print'))  @if (isset($success_array['current_provider_patient_list']) && count($success_array['current_provider_patient_list']) > 0) print_current_provider_patient @endif @endif"  @if(!PermitedStatus('discharge_tracker_performance_export_print')) onclick="CommonLoginModalPopupOpenOnRequest();" @endif><img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="btn-icon-modal" width="16" height="16"><span class="d-none d-md-block">PRINT</span>
                </button>

            </div>
            <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('current_provider_patient_list');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
</div>
<div class="modal-popup-loader-content" style="display: none;"></div>
<div class="offcanvas-body current_provider_list" id="current_provider_list">
    <div class="card-table-listing discharge-patient-offcanvas">
        <table class="breachReasonTable responsiveTable table-listing">
            <thead>
            <tr class="position-relative">
                <th>Ward Name</th>
                <th>Bay & Bed</th>
                <th>Hospital Number</th>
                <th>Patient Name</th>
                <th class='text-center'>Med Fit</th>
                <th class='text-center'>LOS</th>
                <th>Pathway</th>
                <th>Reason Code</th>
            </tr>
            </thead>
            <tbody>
            @if (isset($success_array['current_provider_patient_list']) && count($success_array['current_provider_patient_list']) > 0)
                @foreach ($success_array['current_provider_patient_list'] as $row)
                    <tr>
                        <td class="pivoted">
                            <div class="tdBefore">Ward Name</div>
                            {{ $row['ward_name'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Bay & Bed</div>
                            {{ $row['camis_patient_bed_name'] ?? 'Bed Unassigned' }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Hospital Number</div>
                            {{ $row['pas_id'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Patient Name</div>
                            {!! CamisPatientGender($row['camis_patient_sex'], $row['camis_patient_name']) !!}
                        </td>

                        <td class="pivoted text-center">
                            <div class="tdBefore">Med Fit</div>
                            {{ $row['camis_patient_medfit'] }}
                        </td>
                        <td class="pivoted  text-center">
                            <div class="tdBefore ">LOS</div>
                            {{ $row['los'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Pathway</div>
                            {{ $row['dtoc_pathway_text'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Reason Code</div>
                            {{ $row['reason_code'] }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="no-records-row">
                    <td class="pivoted no-records-cell" colspan="8">
                        <div class="tdBefore"></div>
                        {{ NotFoundMessage() }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
<div class="offcanvas-footer">
    <div class="row gx-2 ">
        <div class="col-lg-2 col-md-4 offset-lg-3 {{ PermissionDeniedDiv('discharge_tracker_performance_current_provider_export_view') }}">
            <button class="btn btn-primary-grey mb-2 mb-md-0" @if(PermitedStatus('discharge_tracker_performance_current_provider_export_view'))   @if (isset($success_array['current_provider_patient_list']) && count($success_array['current_provider_patient_list']) > 0) onclick="location.href='{{ route('discharged.PerformanceLosExport','current_provider') }}';" @endif @else  onclick="CommonLoginModalPopupOpenOnRequest();" @endif ><img src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt="" class="btn-icon-modal" width="16" height="16"><span>EXPORT</span>
            </button>
        </div>
        <div class="col-lg-2 col-md-4 {{ PermissionDeniedDiv('discharge_tracker_performance_export_print') }}">
            <button class="btn btn-primary-grey mb-2 mb-md-0 @if(PermitedStatus('discharge_tracker_performance_export_print'))  @if (isset($success_array['current_provider_patient_list']) && count($success_array['current_provider_patient_list']) > 0) print_current_provider_patient @endif @endif"   @if(!PermitedStatus('discharge_tracker_performance_export_print'))  onclick="CommonLoginModalPopupOpenOnRequest();" @endif><img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="btn-icon-modal" width="16" height="16"><span>PRINT</span>
            </button>
        </div>
        <div class="col-lg-2 col-md-4">
            <button  onclick="CloseOffcanvas('current_provider_patient_list');" class="btn btn-primary-grey mb-2 mb-md-0"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="14" height="14"><span>CLOSE</span>
            </button>
        </div>
    </div>
</div>
