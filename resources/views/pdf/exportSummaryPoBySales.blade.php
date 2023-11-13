<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALES REPORT – PO RECEIVED PER SALES – SUMMARY</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 9pt;
        }

        tr,
        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 2px;
        }

        #content tr,
        #content th,
        #content td {
            padding: 8px;
            /* Gaya atau properti CSS lainnya bisa ditambahkan di sini */
        }

        th {
            text-align: center;
            background-color: #f2f2f2;
        }

        .sales-name {
            text-align: left;
            font-weight: bold;
        }

        .total-po-value {
            text-align: right;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
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

    <table>
        <tr class="border-top border-left border-right no-border-bottom">
            <td class="border-top border-left border-right no-border-bottom"><img style="margin-bottom: 0.3em;" src="{{ asset('/assets/images/logo-ist.png') }}" width="80" alt="img-ist"></td>
        </tr>
        <tr class="border-top border-left border-right no-border-bottom">
            <td class="border-top border-left border-right no-border-bottom">
                <h2 style="margin-bottom: -0.2em; margin-top:-0.2em">SALES REPORT – PO RECEIVED PER SALES – SUMMARY</h2>
            </td>
        </tr>
        <tr class="no-border">
            <td class="no-border">
                Periode : {{$date_st}} - {{$date_ot}}
            </td>
        </tr>
        <tr class="no-border">
            <td class="no-border" style="font-weight: bold;">
                PO Total Value : {{number_format($sum,0,'.','.')}}
            </td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Printed : {{date("l, d F Y H:i:s", time())}}</td>
        </tr>
    </table>
    <br>
    <table id="content">
        <thead>
            <tr>
                <th>Sales Name</th>
                <th>Customer</th>
                <th>Project Value</th>
                <th>Total Project Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach (collect($salesData)->sortBy('salesName') as $data)
            @if (count($data['customers']) > 0)
            <tr>
                <td rowspan="{{ count($data['customers']) }}">{{ $data['salesName'] }}</td>
                <td>{{ $data['customers'][0]['customer'] }}</td>
                <td class="text-right">{{number_format($data['customers'][0]['totalPOValue'], 0, ',', '.')}}</td>
                @php
                $totalPOValueSum = 0;
                foreach ($data['customers'] as $customer) {
                $totalPOValueSum += $customer['totalPOValue'];
                }
                @endphp
                <td class="text-right" rowspan="{{ count($data['customers']) }}">{{number_format($totalPOValueSum, 0, ',', '.')}}</td>
            </tr>
            @for ($i = 1; $i < count($data['customers']); $i++) <tr>
                <td>{{ $data['customers'][$i]['customer'] }}</td>
                <td class="text-right">{{number_format($data['customers'][$i]['totalPOValue'], 0, ',', '.')}}</td>
                </tr>
                @endfor
                @else
                <tr>
                    <td>{{ $data['salesName'] }}</td>
                    <td></td>
                    <td class="text-right">
                        @if (isset($data['totalPOValue']))
                        {{ $data['totalPOValue'] }}
                        @else
                        N/A <!-- or any default value you want to display -->
                        @endif
                    </td>
                </tr>
                @endif
                @endforeach
        </tbody>




    </table>

</body>

</html>