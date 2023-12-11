<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExportMom</title>
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
            color: #F4B083;
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
    </style>
</head>

<body>
    <div class="header">
        <img class="logo" src="{{asset('/assets/images/logo-ist.png')}}" alt="Logo">
        <h1 class="title">MINUTES OF MEETING</h1>
        <h2 class="subtitle">PMO-DOC-MOM-v1.0</h2>
        <div class="garis">
            <hr>
        </div>
    </div>
    <div class="content">
        <div>
            <h3>Project Meeting Information</h3>
            <table>
                <thead>
                    <tr style="display: hidden" class="noBorder">
                        <th class="noBorder" style="width: 15%;"></th>
                        <th class="noBorder" style="width: 5%;"></th>
                        <th class="noBorder" style="width: 6%;"></th>
                        <th class="noBorder" style="width: 23%;"></th>
                        <th class="noBorder" style="width: 11%;"></th>
                        <th class="noBorder" style="width: 6%;"></th>
                        <th class="noBorder" style="width: 34%;"></th>
                    </tr>
                    <tr>
                        <th class="colorBase " colspan="8">PROJECT MEETING INFORMATION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="noright">Customer Name</td>
                        <td class="text-center noright noleft">:</td>
                        <td class="noleft" colspan="6">{{$project->customer->company}}</td>
                    </tr>
                    <tr>
                        <td class="noright">Project Name</td>
                        <td class="text-center noright noleft">:</td>
                        <td class="noleft" colspan="6">{{$project->projectName}}</td>
                    </tr>
                    <tr>
                        <td class="noright">Date</td>
                        <td class="text-center noleft noright">:</td>
                        <td class="noleft noright" colspan="2">{{date("d-F-Y",strtotime($data->dateMom))}}</td>
                        <td class="text-center">Time:</td>
                        <td colspan="3">{{$data->timeMom}}</td>
                    </tr>
                    <tr>
                        <td class="noright">Venue</td>
                        <td class="text-center noleft noright">:</td>
                        <td class="noleft" colspan="6">{{$data->venue}}</td>
                    </tr>
                    <tr>
                        <td class="noright">Agenda</td>
                        <td class="text-center noleft noright">:</td>
                        <td class="noleft" colspan="6"><?php echo $data->agenda ?></td>
                    </tr>
                    <tr>
                        <td class="noright">Lead by</td>
                        <td class="text-center noleft noright">:</td>
                        <td class="noleft" colspan="6">{{$data->chairedBy}}</td>
                    </tr>
                    <tr>
                        <td class="noright" style="vertical-align: top;" rowspan="{{$for+1}}">Attendees</td>
                        <td class="text-center noleft" style="vertical-align: top;" rowspan="{{$for+1}}">:</td>
                        <td class="text-center" style="background-color: #F4B083;font-weight:bold" colspan="3">{{$project->customer->company}}</td>
                        <td class="text-center" style="background-color: #F4B083;font-weight:bold" colspan="3">IST</td>
                    </tr>
                    @for ($i=0; $i < $for; $i++) <tr>
                        <td class="text-center">{{$i+1}}.</td>
                        <td colspan="2">{{isset($partCust[$i]->name)?$partCust[$i]->name." - ".$partCust[$i]->email:""}}</td>
                        <td class="text-center">{{$i+1}}.</td>
                        <td colspan="2">{{isset($partMii[$i]->name)?$partMii[$i]->name." - ".$partMii[$i]->email:""}}</td>
                        </tr>
                        @endfor
                </tbody>
            </table>
        </div>
        <div style="page-break-inside: avoid !important;">
            <h3>Minutes Of Meeting</h3>
            <table>
                <thead>
                    <tr>
                        <th class="colorBase ">Minutes Of Meeting</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo isset($discussion->discussion) ? $discussion->discussion : '' ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="page-break-inside: avoid !important;">
            <h3>Meeting Follow-Up</h3>
            <table>
                <thead>
                    <tr class="noBorder">
                        <th class="noBorder" style="width: 5%;"></th>
                        <th class="noBorder" style="width: 20%;"></th>
                        <th class="noBorder" style="width: 20%;"></th>
                        <th class="noBorder" style="width: 20%;"></th>
                        <th class="noBorder" style="width: 35%;"></th>
                    </tr>
                    <tr>
                        <th colspan="5" class="colorBase">MEETING FOLLOW UP</th>
                    </tr>
                    <tr style="background-color: #F4B083;font-weight:bold">
                        <th>No.</th>
                        <th>Action</th>
                        <th>PIC</th>
                        <th>Target Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    @foreach ( $meetingFu as $dataa )
                    <tr>
                        <td class="text-center">{{$no++}}</td>
                        <td>{{$dataa->action}}</td>
                        <td>{{$dataa->pic}}</td>
                        <td class="text-center">{{date("d-F-Y",strtotime($dataa->targetDate))}}</td>
                        <td>{{$dataa->notes}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="page-break-inside: avoid !important;">
            <h3></h3>
            <table>
                <thead>
                    <tr style="background-color: #F4B083;font-weight:bold">
                        <th style="text-align:left" colspan="3">MINUTE SIGN-OFF</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="noright">Issued Date</td>
                        <td class="noleft" colspan="2">: {{date("d-F-Y",strtotime($data->dateMom))}}</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td class="noright" style="text-align: center;font-weight:bold;width:30%">
                            Prepared by,
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            ({{$project->pm->name}})
                        </td>
                        <td class="noleft noright" style="width: 40%;"></td>
                        <td class="noleft" style="text-align: center;font-weight:bold;width:30%">
                            Agreed by,
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            ({{$data->pmCust}})
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>