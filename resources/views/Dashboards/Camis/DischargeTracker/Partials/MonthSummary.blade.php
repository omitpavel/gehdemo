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

    </div>
</div>
