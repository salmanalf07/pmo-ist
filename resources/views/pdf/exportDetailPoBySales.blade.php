<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALES REPORT – PO RECEIVED PER SALES – DETAIL</title>
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
        td,
        th {
            border: 1px solid #dddddd;
            border-collapse: collapse;
            border: 1px solid black;
            padding: 2px;
        }

        th {
            text-align: center;
            background-color: #f2f2f2;
        }

        #content tr,
        #content th,
        #content td {
            padding: 8px;
            /* Gaya atau properti CSS lainnya bisa ditambahkan di sini */
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
    <table>
        <tr class="border-top border-left border-right no-border-bottom">
            <td class="border-top border-left border-right no-border-bottom"><img style="margin-bottom: 0.3em;" src="{{ asset('/assets/images/logo-ist.png') }}" width="80" alt="img-ist"></td>
        </tr>
        <tr class="border-top border-left border-right no-border-bottom">
            <td class="border-top border-left border-right no-border-bottom">
                <h2 style="margin-bottom: -0.3em; margin-top:-0.3em">SALES REPORT – PO RECEIVED PER SALES – DETAIL</h2>
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
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">Sales</th>
                <th style="width: 10%;">PO Date</th>
                <th style="width: 15%;">PO Number</th>
                <th style="width: 10%;">PO Value</th>
                <th style="width: 10%;">Customer</th>
                <th style="width: 25%;">Project Name</th>
                <th style="width: 15%;">Project Manager</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach (collect($data)->sortBy('contractDate') as $sales)
            <tr>
                <td class="text-center">{{$no++}}</td>
                <td>{{$sales->saless ? $sales->saless->name :""}}</td>
                <td class="text-center">{{date("d-m-Y",strtotime($sales->contractDate))}}</td>
                <td>{{$sales->noContract}}</td>
                <td class="text-right">{{number_format($sales->projectValue,0,'.','.')}}</td>
                <td>{{$sales->customer->company}}</td>
                <td>{{$sales->projectName}}</td>
                <td>{{$sales->pm? $sales->pm->name : ""}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>