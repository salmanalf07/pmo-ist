<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <table>
        <tr class="border-top border-left border-right border-bottom">
            <td class="border-top border-left border-right">
                <h1 style="margin-bottom: -0.3em;">Plan BAST - {{$title}}</h1>
            </td>
            <td class="text-right border-top border-left border-right"><img style="margin-bottom: 0.3em;" src="{{ asset('/assets/images/logo-ist.png') }}" width="80" alt="img-ist"></td>
        </tr>
        <tr class="no-border">
            <td colspan="2" class="no-border">Printed: {{date("l, d F Y H:i:s", time())}}</td>
        </tr>
        <tr class="border-top border-left border-right no-border-bottom">
            <td class="text-right border-top border-left border-right no-border-bottom" colspan="2">
                Total Plan Invoice : {{number_format($totalPlan,0,'.','.')}} &nbsp;&nbsp; Total Invoiced : {{number_format($totalInv,0,'.','.')}}
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">Customer</th>
                <th style="width: 30%;">Project Name</th>
                <th style="width: 10%;">Target Date</th>
                <th style="width: 10%;">Value</th>
                <th style="width: 25%;">Remaks</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach ($data as $bast)
            <tr>
                <td class="text-center">{{$no++}}</td>
                <td>{{$bast->project->customer->company}}</td>
                <td>{{$bast->project->projectName}}</td>
                <td class="text-center">{{date("d-m-Y",strtotime($bast->bastDate))}}</td>
                <td class="text-right">{{number_format($bast->termsValue,0,'.','.')}}</td>
                <td>{{$bast->remaks}}</td>
                <td>{{$bast->invMain == 1 ? 'Invoiced':''}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>