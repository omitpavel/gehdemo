<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2">
                    <a  onclick="DailySummaryData('{{ date('Y-m-01') }}', '{{ date('Y-m-d') }}');" class="tab-custom-btn " data-bs-toggle="tab" href="#dailySummary">
                        <div class="tab-active">Task Details</div>
                    </a>
                </li>
                <li class="mb-2">
                    <a  onclick="WardSummaryData('{{ \Carbon\Carbon::now()->format('F Y') }}');" class="tab-custom-btn active" data-bs-toggle="tab" href="#wardSummary">
                        <div class="tab-active">Ward Summary</div>
                    </a>
                </li>

            </ul>
            <div class="tab-content" id="tabcontent">
                <div id="wardSummary" class=" tab-pane active ">
                    <div class="row gx-2 date-range">
                        <div class="col-lg-4 col-md-4 mb-2">
                            <select class="form-select w-100" id="month" aria-label="Default select example">
                                @foreach($success_array['month_list'] as $month)
                                    <option value="{{ $month }}" @if($success_array['selected_date'] == $month) selected @endif>{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container-fluid">
                            <div class="col-lg-12">
                                <div class="card-dp-wards mb-2">
                                    <table class="breachReasonTable responsiveTable table-dp-wards">
                                        <thead>
                                        <tr class="position-relative">
                                            <th rowspan="2">DIRECTORATE</th>
                                            <th rowspan="2">WARD</th>
                                            @foreach($success_array['previous_5_month'] as $month_name)
                                                <th colspan="2" class="bgblue-column">{{ $month_name }}
                                                </th>

                                            @endforeach
                                            <th rowspan="2"></th>
                                        </tr>
                                        <tr>
                                            <th> # Task List Completed </th>
                                            <th> Compliance <br>(12 Hours) </th>
                                            <th> # Task List Completed </th>
                                            <th> Compliance <br>(12 Hours) </th>
                                            <th> # Task List Completed </th>
                                            <th> Compliance <br>(12 Hours) </th>
                                            <th> # Task List Completed </th>
                                            <th> Compliance <br>(12 Hours) </th>
                                            <th> # Task List Completed </th>
                                            <th> Compliance <br>(12 Hours) </th>
                                            <th> # Task List Completed </th>
                                            <th class="spl-th"> Compliance <br>(12 Hours) </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @php
                                            $sum_of_task = array();
                                            foreach(array_values(array_keys(array_values($success_array['all_data'][array_key_first($success_array['all_data'])])['0'])) as $month_array){
                                                $sum_of_task[$month_array]['created_task'] = 0;
                                                $sum_of_task[$month_array]['completed_task'] = 0;
                                            }
                                        @endphp
                                        @foreach ($success_array['all_data'] as $key => $ward_wise_data)
                                            @php
                                                ksort($ward_wise_data);
                                            @endphp
                                            @foreach ($ward_wise_data as $ward_name => $ward_details)
                                                <tr>

                                                        @if($key == 13)
                                                        <td rowspan="{{ count($ward_wise_data) }}" class="pivoted text-start @if(!$loop->first) spl-td @endif">
                                                            <div class="tdBefore">DIRECTORATE
                                                            </div>
                                                                MEDICAL

                                                            </td>
                                                        @elseif($key == 14)
                                                        <td rowspan="{{ count($ward_wise_data) }}" class="pivoted text-start  @if(!$loop->first) spl-td @endif">
                                                            <div class="tdBefore">DIRECTORATE
                                                            </div>
                                                            SURGICAL
                                                        </td>
                                                        @elseif($key == 20)
                                                        <td rowspan="{{ count($ward_wise_data) }}" class="pivoted text-start  @if(!$loop->first) spl-td @endif">
                                                            <div class="tdBefore">DIRECTORATE
                                                            </div>
                                                            ASSESSMENT
                                                        </td>
                                                        @elseif($key == 16)
                                                            <td rowspan="{{ count($ward_wise_data) }}" class="pivoted text-start  @if(!$loop->first) spl-td @endif">
                                                                <div class="tdBefore">DIRECTORATE
                                                                </div>
                                                                OTHER
                                                            </td>
                                                        @endif
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Category
                                                        </div>

                                                        {{ $success_array['all_ward_with_name'][$ward_name] }}
                                                    </td>
                                                    @php
                                                        $previous_percentage = null;
                                                    @endphp

                                                    @foreach($ward_details as $month_array => $month_data)

                                                        @php

                                                            $sum_of_task[$month_array]['created_task'] += $month_data['created_task'];
                                                            $sum_of_task[$month_array]['completed_task'] += $month_data['completed_task'];
                                                        @endphp
                                                        <td class="pivoted text-center">
                                                            <div class="tdBefore"># Task List Completed</div>
                                                            {{ $month_data['completed_task'] }}
                                                        </td>
                                                        <td class="pivoted text-center">
                                                            <div class="tdBefore">Compliance <br>(12 Hours)</div>
                                                            @php
                                                                $percentage = intval(($month_data['created_task'] != 0) ? ($month_data['completed_task'] / $month_data['created_task']) * 100 : 0);
                                                                if ($previous_percentage !== null) {
                                                                    if ($percentage > $previous_percentage) {
                                                                        $icon_class = 'icon-up';
                                                                    } elseif ($percentage < $previous_percentage) {
                                                                        $icon_class = 'icon-down';
                                                                    } else {
                                                                        $icon_class = 'icon-two-end';
                                                                    }
                                                                }
                                                                $previous_percentage = $percentage;
                                                            @endphp
                                                            {{ $percentage }}%
                                                        </td>
                                                    @endforeach

                                                    <td class="pivoted text-center">
                                                        <div class="tdBefore"></div>
                                                        <div class="{{ isset($icon_class) ? $icon_class : '' }}"></div>
                                                    </td>

                                                </tr>
                                            @endforeach

                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="pivoted text-start">
                                                <div class="tdBefore">DIRECTORATE
                                                </div>
                                                OVERALL TRUST COMPLIANCE <br>(12 Hours)
                                            </td>
                                            @php
                                                $previous_percentage = null;
                                            @endphp
                                            @foreach($sum_of_task as $month_sum_data)
                                                <td class="pivoted text-center">
                                                    <div class="tdBefore"># Task List
                                                        Completed
                                                    </div>
                                                    {{ $month_sum_data['completed_task'] }}
                                                </td>
                                                <td class="pivoted text-center">
                                                    <div class="tdBefore">Compliance <br>(12 Hours)</div>
                                                    @php
                                                        $percentage = intval(($month_sum_data['created_task'] != 0) ? ($month_sum_data['completed_task'] / $month_sum_data['created_task']) * 100 : 0);
                                                        if ($previous_percentage !== null) {
                                                            if ($percentage > $previous_percentage) {
                                                                $icon_class = 'icon-up';
                                                            } elseif ($percentage < $previous_percentage) {
                                                                $icon_class = 'icon-down';
                                                            } else {
                                                                $icon_class = 'icon-two-end';
                                                            }
                                                        }
                                                        $previous_percentage = $percentage;
                                                    @endphp
                                                    {{ $percentage }}%
                                                </td>
                                            @endforeach
                                            <td class="pivoted text-center">
                                                <div class="tdBefore"></div>
                                                <div class="{{ isset($icon_class) ? $icon_class : '' }}"></div>
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



