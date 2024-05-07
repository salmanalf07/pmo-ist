<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Summary Per PO Per Sales</title>
    <style>
        @page {
            size: landscape;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 11pt;
        }

        tr,
        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 2px;
        }

        td {
            max-width: 120px;
            word-wrap: break-word;
            overflow: auto;
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

        .text-center {
            text-align: center;
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
                <h2 style="margin-bottom: -0.2em; margin-top:-0.2em">Invoice Summary Per PO Per Sales</h2>
            </td>
        </tr>
        <tr class="no-border">
            <td class="no-border" style="font-weight: bold;">
                PO Date Periode : {{$date_st}} - {{$date_ot}}
            </td>
        </tr>
        <tr class="no-border">
            <td class="no-border" style="font-weight: bold;">
                Invoice Status : {{$statusId}}
            </td>
        </tr>
        <tr class="no-border">
            <td class="no-border" style="font-weight: bold;">
                Terms Total Value : {{number_format($sum,0,'.','.')}}
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
                <th style="width: 25%;">Sales</th>
                <th style="width: 25%;">Customer</th>
                <th style="width: 15%;">PO Value</th>
                <th style="width: 15%;">Invoiced</th>
                <th style="width: 5%;">%</th>
                <th style="width: 15%;">Outstanding</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $lastItem = null;
            $sales = null;
            ?>
            @foreach ($finishData as $data)
            <tr>

                <?php
                $projectValuePPN = $data['projectValuePPN'];

                $sumValue = $data['invoiced'];
                $progresPercen = $data['progresPercen'];
                $outStanding = $data['outstanding'];
                ?>

                @if (!is_null($sales) && $sales == $data['sales'])
                <td></td>
                @else
                <td>
                    {{$data['sales'] ? $data['sales'] : ""}}
                </td>
                @endif
                <td>{{$data['customer']}}</td>
                <td class="text-right">{{is_numeric($projectValuePPN) ? number_format($projectValuePPN, 0, ',', '.') : '$$$'}}</td>
                <td class="text-right">
                    {{ is_numeric($sumValue) ? number_format($sumValue, 0, ',', '.') : $sumValue }}
                </td>
                <td class="text-center">{{$progresPercen}}</td>
                <td class="text-right">{{number_format(($outStanding), 0, ',', '.')}}</td>
            </tr>

            <?php
            $sales = $data['sales'] ? $data['sales'] : "";
            ?>
            @endforeach
        </tbody>


    </table>
    <script>
        function setTotal(id, total) {
            var cell1 = document.getElementById(id);
            cell1.value = total;
        }
    </script>

</body>

</html>