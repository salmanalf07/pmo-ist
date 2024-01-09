<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Invoice Monthly By Customer</title>
    <style>
        @page {
            size: landscape;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10pt;
        }

        tr,
        td,
        th {
            border-collapse: collapse;
            border: 1px solid black;
            padding: 5px;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center;
        }

        .border-top {
            border-top: 0px;
        }

        .border-left {
            border-left: 0px;
        }

        .border-right {
            border-right: 0px;
        }

        .border-bottom {
            border-bottom: 2px solid black;
        }

        .no-border-bottom {
            border-bottom: 0px;
        }

        .no-border {
            border: 0px
        }
    </style>
</head>

<body>
    <h3>
        Plan Invoice Monthly By Customer - {{$year}}
    </h3>
    <table>
        <thead>
            <tr style="background-color: #F4B083">
                <th rowspan="2">Customer</th>
                <th rowspan="2">Total Project</th>
                <th colspan="{{count($months)}}">Plan Invoice (Dalam Miliyar)</th>
            </tr>
            <tr style="background-color: #F4B083">
                @foreach ($months as $month)
                <th>{{$month}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
            $monthlyTotals = array_fill_keys($months, 0);
            $totalRow = 0;
            $totalcountProject = 0; // Menambahkan variabel untuk total anggota proyek
            @endphp

            @foreach ($result as $cust => $data)
            <tr>
                <td>{{$cust}}</td>
                <td style="text-align: center">{{$data['countProject']}}</td>

                @php
                $rowTotal = 0;
                @endphp

                @foreach ($months as $loopedMonth)
                @php
                $found = false;
                $monthTotal = 0;
                @endphp

                @foreach ($data['top'] as $tops)
                @if(strtotime($tops['month']) == strtotime($loopedMonth))
                <td style="text-align: right">{{ number_format(round($tops['totalValue'] / 1000000000, 2), 2, '.', '') }}</td>
                @php
                $found = true;
                $monthTotal += $tops['totalValue'];
                $totalRow += $tops['totalValue'];
                $rowTotal += $tops['totalValue'];
                $monthlyTotals[$loopedMonth] += $tops['totalValue'];
                break;
                @endphp
                @endif
                @endforeach

                @if(!$found)
                <td style="text-align: right">0</td>
                @endif
                @endforeach

                <!-- Menambahkan nilai anggota proyek ke total anggota proyek -->
                @php
                $totalcountProject += $data['countProject'];
                @endphp
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="font-weight:bold">
                <td style="text-align: right">Total</td>

                <!-- Menampilkan total anggota proyek di kolom footer -->
                <td style="text-align: center">{{ $totalcountProject }}</td>

                @foreach ($months as $loopedMonth)
                <!-- Menampilkan total bulanan di kolom footer -->
                <td style="text-align: right">{{ number_format(round($monthlyTotals[$loopedMonth] / 1000000000, 2), 2, '.', '') }}</td>
                @endforeach
            </tr>
        </tfoot>

    </table>
</body>

</html>