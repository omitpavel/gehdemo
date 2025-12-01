<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f3f3f3;
        }

        tr.late {
            background-color: #f8d7da !important;
        }

        tr.late td,
        tr.late th {
            border-color: #f5c2c7;
        }

        td.late-cell {
            background-color: #f8d7da !important;
            border-color: #f5c2c7;
        }
    </style>

</head>

<body>
    <h2>Health Reports</h2>
    <table>
        <tr>
            <th>SN</th>
            <th>Job Name</th>
            <th>Type</th>
            <th>Start Time</th>
            <th>End Time Time</th>
            <th>Processing Time</th>
            <th>Last Run</th>
            <th>Result</th>
        </tr>
        @php
            $x = 1;
        @endphp
        @foreach ($success_array['log_status'] as $row)
            <tr class="{{ !empty($row['is_late']) ? 'late' : '' }}">
                <td>{{ $x }}</td>
                <td>{{ ucwords($row['job_log_name']) }}</td>
                <td>{{ $row['type'] }}</td>
                <td>{{ !empty($row['start_time']) ? date('D jS M Y, H:i:s', strtotime($row['start_time'])) : '--' }}
                </td>
                <td>{{ !empty($row['end_time']) ? date('D jS M Y, H:i:s', strtotime($row['end_time'])) : '--' }}</td>
                <td>{{ TimeDeferInFormat($row['start_time'], $row['end_time']) }}</td>
                <td>
                    @if (!empty($row['start_time']))
                        {{ timeago($row['start_time']) }}

                    @else
                        --
                    @endif
                </td>
                <td class="{{ !empty($row['is_late']) ? 'late-cell' : '' }}">
                    @if (!empty($row['is_late']))
                        Error
                    @else
                        {{ $row['staus'] == 0 ? 'ERROR' : 'SUCCESS' }}
                    @endif

                </td>
            </tr>
            @php
                $x++;
            @endphp
        @endforeach
    </table>
    <br>
    <h2>Other Info</h2>
    <br>
    <table>
        <tr>
            <th colspan="6">{{ $success_array['active_users'] }}</td>
        </tr>
        <tr>
            <th colspan="6">{{ $success_array['ward_load_time'] }}</td>
        </tr>
        <tr>
            <th colspan="6">{{ $success_array['disk_free_space_c'] }}</td>
        </tr>
        <tr>
            <th colspan="6">{{ $success_array['disk_free_space_d'] }}</td>
        </tr>
        @if ($success_array['cpu_usage'] != '')
            <tr>
                <th colspan="6">{{ $success_array['cpu_usage'] }}</td>
            </tr>
        @endif
        @if ($success_array['memory_usage'] != '')
            <tr>
                <th colspan="6">{{ $success_array['memory_usage'] }}</td>
            </tr>
        @endif
    </table>
</body>

</html>
