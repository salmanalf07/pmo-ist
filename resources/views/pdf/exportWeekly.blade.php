<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            margin-top: 130px;
            margin-bottom: 130px;
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

        hr {
            color: #FF8C00;
            border: none;
            background-color: #FF8C00;
            height: 5px;
        }

        div {
            display: block;
        }

        .colorBase {
            background-color: #F4B083;
        }

        .text-white {
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .noBorder {
            border: 0px !important;
        }

        .noright {
            border-right: 0px !important;
        }

        .noleft {
            border-left: 0px !important;
        }

        .nobottom {
            border-bottom: 0px !important;
        }

        .notop {
            border-top: 0px !important;
        }

        .header {
            text-align: left;
            position: fixed;
            width: 100%;
            margin-top: -100px;
        }

        .logo {
            max-width: 80px;
            float: left;
        }

        .title-container {
            display: inline-block;
            margin-left: 20px;
            /* Sesuaikan jarak antara logo dan teks besar */
            vertical-align: top;
        }

        .title {
            font-size: 16pt;
            text-align: center;
            margin-bottom: 0px;
            margin-top: 20px;
        }

        .subtitle {
            font-size: 6pt;
            text-align: center;
            display: block;
            margin-top: 0px;
        }

        .garis {
            margin-top: 30px;
        }

        .content {
            margin-top: 10px;
        }

        .mb-2 {
            margin-bottom: 2em;
        }
    </style>
</head>

<body>
    <div class="header">
        <img class="logo" src="{{asset('/assets/images/logo-ist.png')}}" alt="Logo">
        <h1 class="title"><span style="color: #FF8C00;">PROJECT PROGRESS</span> <span style="color: gray;">REPORT</span></h1>
        <div class="garis">
            <hr>
        </div>
    </div>
    <div class="content">
        <div class="mb-2">
            <table>
                <thead>
                    <tr style="display: hidden" class="noBorder">
                        <th class="noBorder" style="width: 30%;"></th>
                        <th class="noBorder" style="width: 70%;"></th>
                    </tr>
                    <tr>
                        <th class="colorBase text-left" colspan="2">PROJECT INFORMATION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Customer Name</td>
                        <td>{{$data->project->customer->company}}</td>
                    </tr>
                    <tr>
                        <td>Project Name</td>
                        <td>{{$data->project->shortProjectName}}</td>
                    </tr>
                    <tr>
                        <td>Reporting Period</td>
                        <td>{{$data->periode}}</td>
                    </tr>
                    <tr>
                        <td>Overall Progress (in %)</td>
                        <td>{{$data->project->overAllProg}}%</td>
                    </tr>
                    <tr>
                        <td>Current Stage</td>
                        <td>{{$data->currentStage}}</td>
                    </tr>
                    <tr>
                        <td>Traffic Light</td>
                        <td>{{$data->traficLight}}</td>
                    </tr>
                    <tr>
                        <td>Project Status Summary</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mb-2">
            <table>
                <thead>
                    <tr>
                        <th colspan="6" class="colorBase text-left">MILESTONE PROGRESS</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center" style="width: 40%">Milestone</th>
                        <th class="text-center" colspan="2" style="width: 20%">Finish Date</th>
                        <th class="text-center" style="width: 15%">Status</th>
                        <th class="text-center" style="width: 20%">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data->milestone) >1)
                    <?php $no = 1 ?>
                    @foreach ( collect($data->milestone)->sortBy('topProject.noRef') as $milestone)
                    <tr>
                        <td class="text-center">{{$no++}}</td>
                        <td>{{$milestone->topProject->termsName}}</td>
                        <td class="text-center">{{date('d-M-Y', strtotime($milestone->topProject->bastDate))}}</td>
                        <td class="text-center">{{date('d-M-Y', strtotime($milestone->finishDate))}}</td>
                        <td>{{$milestone->status}}</td>
                        <td>{{$milestone->notes}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center">-</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
        <div class="mb-2">
            <table>
                <thead>
                    <tr>
                        <th class="colorBase text-left" colspan="7">RISK REGISTER</th>
                    </tr>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 40%;">Risk Description</th>
                        <th style="width: 10%;">Risk Response Plan</th>
                        <th style="width: 10%;">Owner</th>
                        <th style="width: 10%;">Severity</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 10%;">Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data->risk) >1)
                    @foreach ($data->risk as $risk)
                    <tr>
                        <td class="text-center">{{$risk->codeId}}</td>
                        <td>{{$risk->issue->issuesDesc}}</td>
                        <td class="text-center">{{date('d-M-Y', strtotime($risk->responPlan))}}</td>
                        <td>{{$risk->owner}}</td>
                        <td>{{$risk->severity}}</td>
                        <td>{{$risk->status}}</td>
                        <td class="text-center">{{date('d-M-Y', strtotime($risk->dueDate))}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center">-</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
        <div class="mb-2" style="page-break-inside: avoid !important;">
            <table>
                <thead>
                    <tr>
                        <th class="colorBase text-left" colspan="7">ISSUE LOG</th>
                    </tr>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 40%;">Issue Description</th>
                        <th style="width: 10%;">Issue Response Plan</th>
                        <th style="width: 10%;">Owner</th>
                        <th style="width: 10%;">Severity</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 10%;">Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data->issue) >1)
                    @foreach ($data->issue as $issue)
                    <tr>
                        <td class="text-center">{{$issue->codeId}}</td>
                        <td>{{$issue->issue->issuesDesc}}</td>
                        <td class="text-center">{{date('d-M-Y', strtotime($issue->responPlan))}}</td>
                        <td>{{$issue->owner}}</td>
                        <td>{{$issue->severity}}</td>
                        <td>{{$issue->status}}</td>
                        <td class="text-center">{{date('d-M-Y', strtotime($issue->dueDate))}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center">-</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
        <div class="mb-2" style="page-break-inside: avoid !important;">
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left;" class="colorBase ">PROJECT PROGRESS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo isset($data->projectProgress) ? $data->projectProgress->projectProgress : '-' ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mb-2" style="page-break-inside: avoid !important;">
            <table>
                <thead style="text-align: left;">
                    <tr>
                        <th colspan="2" class="colorBase" style="text-align: left;">
                            <h3>Project Management Plan Sign-Off </h3>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align: left;">Isssued Date : {{date('d-F-Y', strtotime($data->issuedDate))}} </th>
                    </tr>
                </thead>
                <tbody style="font-weight: bold;">
                    <tr class="nobottom">
                        <td style="width: 50%; text-align: center;" class="nobottom noright">Prepared by,</td>
                        <td style="width: 50%; text-align: center;" class="nobottom noleft">Agreed by,</td>
                    </tr>
                    <tr class="notop nobottom">
                        <td style="height: 80px;" class="notop nobottom noright"></td>
                        <td style="height: 80px;" class="notop nobottom noleft"></td>
                    </tr>
                    <tr class="notop">
                        <td style="text-align: center;" class="noright notop">(Project Manager IST)</td>
                        <td style="text-align: center;" class="noleft notop">(Project Manager Customer)</td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>
</body>

</html>