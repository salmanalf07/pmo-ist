<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVOICE STATUS PER PO PER SALES – DETAIL</title>
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
                <h2 style="margin-bottom: -0.2em; margin-top:-0.2em">INVOICE STATUS PER PO PER SALES – DETAIL</h2>
            </td>
        </tr>
        <tr class="no-border">
            <td class="no-border">
                Periode : {{$date_st}} - {{$date_ot}}
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
                <th style="width: 10%;">Sales</th>
                <th style="width: 8%;">Po Date</th>
                <th style="width: 10%;">PO Number</th>
                <th style="width: 10%;">PO Value</th>
                <th style="width: 20%;">Terms Description</th>
                <th style="width: 10%;">Terms Value</th>
                <th style="width: 9%;">BAST Date</th>
                <th style="width: 9%;">Invoice Date</th>
                <th style="width: 14%;">Payment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $lastItem = null;
            $sales = null;
            ?>
            @foreach ( $groupedData as $data)
            @foreach (collect($data)->sortBy('noRef') as $terms )
            <tr>
                @if (!is_null($sales))
                @if ($sales == $terms->project->sales)
                <td></td>
                @else
                <td>{{$terms->project->saless?$terms->project->saless->name:""}}</td>
                @endif
                @else
                <td>{{$terms->project->saless?$terms->project->saless->name:""}}</td>
                @endif

                @if (!is_null($lastItem))
                @if ($lastItem == $terms->project->noContract)
                <td></td>
                <td></td>
                <td></td>
                @else
                <td class="text-center">{{date("d-m-Y", strTotime($terms->project->contractDate))}}</td>
                <td>{{$terms->project->noContract}}</td>
                <td class="text-right">{{number_format($terms->project->poValue, 0, ',', '.')}}</td>
                @endif
                @else
                <td class="text-center">{{date("d-m-Y", strTotime($terms->project->contractDate))}}</td>
                <td>{{$terms->project->noContract}}</td>
                <td class="text-right">{{number_format($terms->project->poValue, 0, ',', '.')}}</td>
                @endif
                <td>{{$terms->termsName}}</td>
                <td class="text-right">{{number_format($terms->termsValue, 0, ',', '.')}}</td>
                <td class="text-center">{{$terms->bastDate == "1990-01-01"|| $terms->bastDate == "1900-01-01" ? "" : date("d-m-Y", strTotime($terms->bastDate))}}</td>
                <td class="text-center">{{$terms->invDate == "1990-01-01"|| $terms->invDate == "1900-01-01" ? "" : date("d-m-Y", strTotime($terms->invDate))}}</td>
                <td class="text-center">{{$terms->payDate == "1990-01-01"|| $terms->payDate == "1900-01-01" ? "" :date("d-m-Y", strTotime($terms->payDate))}}</td>
            </tr>
            <?php
            $lastItem = $terms->project->noContract;
            $sales = $terms->project->sales ? $terms->project->sales : "";
            ?>
            @endforeach
            @endforeach
        </tbody>




    </table>

</body>

</html>