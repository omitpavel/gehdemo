<div class="col-lg-12  ">
    <div class="row">
        <div class="col-xxl-2 col-lg-3 col-md-4 mb-2 pe-lg-2">
            <div>
                <select class="form-select w-100" id="month" aria-label="Default select example">
                    @foreach($success_array['month_list'] as $month)
                        <option value="{{ $month }}" @if($success_array['selected_date'] == $month) selected @endif>{{ $month }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        @if(count($day_summary) > 0)
        <div class="col-lg-12 month-summary">
            <div class="card-medfit  mb-2">
                <div class="date-header">
                    <span>{{ PredefinedDateFormatShowOnCalendarDashboardMonthOnly($success_array['selected_date']) }}</span>
                </div>
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

                        @foreach($month_summary as $authority => $data)

                            @php
                                $p0 += $data['pathway_0'];
                                $p1 += $data['pathway_1'];
                                $p2 += $data['pathway_2'];
                                $p3 += $data['pathway_3'];
                                $total += ($data['pathway_0']+$data['pathway_1']+$data['pathway_2']+$data['pathway_3']);
                            @endphp
                            <tr>
                                <td class="pivoted">
                                    <div class="tdBefore">Authority</div>
                                    {{ $authority }}
                                </td>
                                <td class="pivoted text-center ">
                                    <div class="tdBefore">P0</div>
                                    {{ $data['pathway_0'] }}
                                </td>
                                <td class="pivoted text-center ">
                                    <div class="tdBefore">P1</div>
                                    {{ $data['pathway_1'] }}
                                </td>
                                <td class="pivoted text-center ">
                                    <div class="tdBefore">P2</div>
                                    {{ $data['pathway_2'] }}
                                </td>
                                <td class="pivoted text-center ">
                                    <div class="tdBefore">P3</div>
                                    {{ $data['pathway_3'] }}
                                </td>
                                <td class="pivoted text-center ">
                                    <div class="tdBefore">Total</div>
                                    {{ ($data['pathway_0']+$data['pathway_1']+$data['pathway_2']+$data['pathway_3']) }}
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="pivoted">
                                Total
                            </td>
                            <td class="pivoted text-center ">
                                <div class="tdBefore">P0</div>
                                {{ $p0 }}
                            </td>
                            <td class="pivoted text-center ">
                                <div class="tdBefore">P1</div>
                                {{ $p1 }}
                            </td>
                            <td class="pivoted text-center ">
                                <div class="tdBefore">P2</div>
                                {{ $p2 }}
                            </td>
                            <td class="pivoted text-center ">
                                <div class="tdBefore">P3</div>
                                {{ $p3 }}
                            </td>
                            <td class="pivoted text-center ">
                                <div class="tdBefore">Total</div>
                                {{ $total }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        <div class="col-lg-12 month-list-summary">
            @forelse($day_summary as $date => $data)
            <div class="card-medfit mb-2">
                <div class="date-header">
                    <span>{{ PredefinedDateFormatShowOnCalendarDashboard($date) }}</span>
                </div>
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
                        $p_tbc_total = 0;
                        $p0_total = 0;
                        $p1_total = 0;
                        $p2_total = 0;
                        $p3_total = 0;
                        $total_total = 0;
                    @endphp

                    @foreach($data as $key => $serviceData)
                        <tr>
                            <td class="pivoted">
                                <div class="tdBefore">Authority</div>
                                {{ $key }}
                            </td>

                            <td class="pivoted text-center">
                                <div class="tdBefore">P0</div>
                                {{ $serviceData['pathway_0'] }}
                            </td>
                            <td class="pivoted text-center">
                                <div class="tdBefore">P1</div>
                                {{ $serviceData['pathway_1'] }}
                            </td>
                            <td class="pivoted text-center">
                                <div class="tdBefore">P2</div>
                                {{ $serviceData['pathway_2'] }}
                            </td>
                            <td class="pivoted text-center">
                                <div class="tdBefore">P3</div>
                                {{ $serviceData['pathway_3'] }}
                            </td>
                            <td class="pivoted text-center">
                                <div class="tdBefore">Total</div>
                                {{ ($serviceData['pathway_0']+$serviceData['pathway_1']+$serviceData['pathway_2']+$serviceData['pathway_3']) }}
                            </td>
                        </tr>

                    @php
                        $p0_total += $serviceData['pathway_0'];
                        $p1_total += $serviceData['pathway_1'];
                        $p2_total += $serviceData['pathway_2'];
                        $p3_total += $serviceData['pathway_3'];
                        $total_total += ($serviceData['pathway_0']+$serviceData['pathway_1']+$serviceData['pathway_2']+$serviceData['pathway_3']);
                    @endphp
                    @endforeach
                    <tr>
                        <td class="pivoted">
                            <div class="tdBefore">Total</div>
                            Total
                        </td>
                        <td class="pivoted text-center">
                            <div class="tdBefore">P0</div>
                            {{ $p0_total }}
                        </td>
                        <td class="pivoted text-center">
                            <div class="tdBefore">P1</div>
                            {{ $p1_total }}
                        </td>
                        <td class="pivoted text-center">
                            <div class="tdBefore">P2</div>
                            {{ $p2_total }}
                        </td>
                        <td class="pivoted text-center">
                            <div class="tdBefore">P3</div>
                            {{ $p3_total }}
                        </td>
                        <td class="pivoted text-center">
                            <div class="tdBefore">Total</div>
                            {{ $total_total }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            @empty
                <div class="card-medfit text-center">
                    <div class="custom_not_found">{{ NotFoundMessage() }}</div>
                </div>
            @endforelse
        </div>
    </div>
</div>
