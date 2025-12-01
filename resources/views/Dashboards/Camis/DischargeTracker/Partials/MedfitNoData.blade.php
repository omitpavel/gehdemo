<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2 {{ PermissionDeniedDiv('discharge_tracker_medfit_yes_view') }}">
                    <a class="tab-custom-btn medfit_button {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_yes_view') }} " data-button-content="yes" >
                        <div class="tab-active">Med FIT
                            YES - Live </div>
                    </a>
                </li>
                <li class="mb-2 {{ PermissionDeniedDiv('discharge_tracker_medfit_yes_view') }}">
                    <a class="tab-custom-btn medfit_button  {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_yes_view') }}" data-button-content="yes_day"
                        ><div class="tab-active">Med FIT
                            YES - Day Summary </div> </a>
                </li>
                <li class="mb-2 {{ PermissionDeniedDiv('discharge_tracker_medfit_no_view') }}">
                    <a class="tab-custom-btn medfit_button {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_no_view') }} active " data-button-content="no" href="#medifitNo">
                        <div class="tab-active">Med FIT NO</div>
                    </a>
                </li>
            </ul>


            <div class="tab-content" id="tabcontent">
                <div id="medifitNo" class=" tab-pane active ">
                    <div class="row mb-3">
                        <div class="container-fluid">
                            <div class="col-lg-12">
                                <div class="row mb-2">
                                    <div class="col-xxl-3 col-lg-3 col-md-5 offset-xxl-9 offset-lg-9 offset-md-7 text-end">
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-export w-75 me-2 width-btn-adjust export_medfit_no  {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_no_export_view') }}"> <i class="bi bi-box-arrow-in-right pe-2 text-black"></i>Export</button>

                                            <button type="button"
                                                class="btn btn-export w-75 width-btn-adjust discharge_tracker_medfit_no_print {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_no_print') }}"><i
                                                    class="bi bi-printer pe-2 text-black {{ DisabledButtonOnRolePermission('discharge_tracker_medfit_no_print') }}"></i>Print</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-medfit medfit-no print_medfit_no">
                                    <table class="breachReasonTable responsiveTable table-medfit">
                                        <thead>
                                            <tr class="position-relative">
                                                <th>Ward</th>
                                                <th>PHYSIOLOGY</th>
                                                <th>TREATMENT</th>
                                                <th>RECOVERY</th>
                                                <th>FUNCTION</th>
                                                <th>PR-CTR</th>
                                                <th>RRR Stage</th>
                                                <th>R2R NOT SET</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($success_array['result'] as $key => $data)

                                                <tr>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Ward Name</div>
                                                        {{ $key}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">PHYSIOLOGY</div>
                                                        {{ $data['physiology'] }}
                                                    </td>
                                                    <td class="pivoted text-center">
                                                        <div class="tdBefore">TREATMENT</div>
                                                        {{ $data['treatment'] }}
                                                    </td>
                                                    <td class="pivoted text-center">
                                                        <div class="tdBefore">RECOVERY</div>
                                                        {{ $data['recovery'] }}
                                                    </td>
                                                    <td class="pivoted text-center">
                                                        <div class="tdBefore">FUNCTION</div>
                                                        {{ $data['function'] }}
                                                    </td>
                                                    <td class="pivoted text-center">
                                                        <div class="tdBefore">Primary Reason - Criteria To Reside</div>
                                                        {{ $data['primary_reason'] }}
                                                    </td>
                                                    <td class="pivoted text-center">
                                                        <div class="tdBefore">Rehabilitation, Reablement And Recovery Stage</div>
                                                        {{ $data['rehabilation'] }}
                                                    </td>
                                                    <td class="pivoted text-center">
                                                        <div class="tdBefore">R2R NOT SET</div>
                                                        {{ $data['rr_not_set'] }}
                                                    </td>
                                                    <td class="pivoted text-center">
                                                        <div class="tdBefore">Total</div>
                                                        {{ $data['total'] }}
                                                    </td>
                                                </tr>
                                            @endforeach

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
