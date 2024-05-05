<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Progress per PO Per Sales</title>
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
                <h2 style="margin-bottom: -0.2em; margin-top:-0.2em">Invoice Progress Per PO Per Sales</h2>
            </td>
        </tr>
        <tr class="no-border">
            <td class="no-border" style="font-weight: bold;">
                Project Status : {{$statusId}}
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
                <th style="width: 10%;">Customer</th>
                <th style="width: 10%;">PO Date</th>
                <th style="max-width: 15%;">PO Number</th>
                <th style="width: 10%;">PO Value</th>
                <th style="width: 15%;">Invoiced</th>
                <th style="width: 10%;">%</th>
                <th style="width: 10%;">Outstanding</th>
                <th style="width: 10%;">%</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $lastItem = null;
            $sales = null;
            ?>
            @foreach ($groupedData as $data)
            @foreach (collect($data)->sortBy('noRef') as $terms)
            @if (!is_null($lastItem) && $lastItem == $terms->project->noContract)
            @else
            <tr>

                <?php
                $contractDate = date("d-m-Y", strtotime($terms->project->contractDate));
                $noContract = $terms->project->noContract;
                $projectValuePPN = preg_replace('/[^0-9]/', '', $terms->project->projectValuePPN);
                $termsValuePPN = $terms->termsValuePPN;

                $groupKey = $terms->project->noContract;
                $sumValue = $sumArray[$groupKey] ?? '-';
                $outStanding = $projectValuePPN - $sumValue;
                ?>

                <td>
                    @if (!is_null($sales) && $sales == $terms->project->sales)
                    <!-- Do nothing -->
                    @else
                    {{$terms->project->saless ? $terms->project->saless->name : ""}}
                    @endif
                </td>
                <td class="text-center">{{$terms->project->customer->company}}</td>
                <td class="text-center">{{$contractDate}}</td>
                <td>{{$noContract}}</td>
                <td class="text-right">{{is_numeric($projectValuePPN) ? number_format($projectValuePPN, 0, ',', '.') : '$$$'}}</td>
                <td class="text-right">
                    {{ is_numeric($sumValue) ? number_format($sumValue, 0, ',', '.') : $sumValue }}
                </td>
                <td class="text-center">{{round(($sumValue / $projectValuePPN) * 100, 2)}}</td>
                <td class="text-right">{{number_format(($outStanding), 0, ',', '.')}}</td>
                <td class="text-center">{{round(($outStanding / $projectValuePPN) * 100, 2)}}</td>
            </tr>
            @endif

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