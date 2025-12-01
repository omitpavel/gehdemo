<div class="row gx-2">
    <div class="col-xl-8">
        <div class="card-discharge-timeline">
            <table
                class="breachReasonTable responsiveTable table-dischages-timeline">
                <thead>
                <tr class="position-relative">
                    <th>Date</th>
                    <th>Pathway</th>
                    <th>Current Status</th>
                    <th>LOS</th>
                    <th>Med Fit</th>
                    <th>Reason Code</th>
                    <th>Delay Days</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($success_array['medfit_dates'] as $medfit_data)
                        <tr>
                            <td class="pivoted">
                                <div class="tdBefore">Date</div>
                                {{ PredefinedDateFormatForEDD($medfit_data->updated_at) }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Pathway</div>
                                {{ $medfit_data->dtoc_info_stored_pathway ?? '--' }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Current Status</div>
                                @if(isset($success_array['dtoc_current_status_drop'][$medfit_data->dtoc_info_stored_current_status]) && !empty($success_array['dtoc_current_status_drop'][$medfit_data->dtoc_info_stored_current_status])) {{ $success_array['dtoc_current_status_drop'][$medfit_data->dtoc_info_stored_current_status] }} @else -- @endif
                            </td>

                            <td class="pivoted text-center">
                                <div class="tdBefore">LOS</div>
                                {{ @$medfit_data->los}}
                            </td>
                            <td class="pivoted text-center">
                                <div class="tdBefore">Med Fit</div>
                                @if($medfit_data->medfit_status_update == 0)
                                    <span class="medfit-text-danger">NO</span>
                                @else
                                    <span class="medfit-text-success">YES</span>
                                @endif
                            </td>
                            <td class="pivoted text-center"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $medfit_data->dtoc_info_stored_authority_text }}">
                                <div class="tdBefore">Reason Code</div>
                                {{ substr($medfit_data->dtoc_info_stored_authority_text,0,2) }}
                            </td>
                            <td class="pivoted text-center">
                                <div class="tdBefore">Delay Days</div>
                                {{$medfit_data->dtos}} @if($medfit_data->pause_status != "" ) - {{$medfit_data->pause_status}} @endif
                            </td>
                        </tr>
                    @empty
                       <tr class="no-records-row">
                            <td class="pivoted no-records-cell" colspan="7">
                                <div class="tdBefore"></div>
                                {{ NotFoundMessage() }}
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card-discharge-timeline medfit">
            <div class="p-2">
                <h6 class="mb-0">Med Fit History</h6>
            </div>
            <table class="breachReasonTable responsiveTable table-medfit-timeline">
                <thead>
                <tr class="position-relative">
                    <th>Consultant</th>
                    <th>Med Fit</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($success_array['medfit_history'] as $medfit_data)
                    <tr>
                        <td class="pivoted">
                            <div class="tdBefore">Consultant</div>
                            {{ $medfit_data->consultant_name_med_fit ?? '--' }}
                        </td>
                        <td class="pivoted text-center">
                            <div class="tdBefore">Med Fit</div>
                            @if($medfit_data->medfit_status_update == 0)
                                <span class="medfit-text-danger">NO</span>
                            @else
                                <span class="medfit-text-success">YES</span>
                            @endif
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Date</div>
                            {{ PredefinedDateFormatFor24Hour($medfit_data->medfit_updated_date) }}
                        </td>
                    </tr>
                @empty
                    <tr class="no-records-row">
                        <td class="pivoted no-records-cell" colspan="3">
                            <div class="tdBefore"></div>
                            {{ NotFoundMessage() }}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
