@extends('/project/navbarInput')

@section('inputan')
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<style>
    .input-80 input {
        width: 80% !important;
    }

    .input-100 input {
        width: 100% !important;
        border: var(--dashui-border-width) solid var(--dashui-input-border);
        border-radius: 0.2rem;
        height: 2rem;
        padding-left: 1rem;
    }

    .input-100 td {
        padding: 0.5rem;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- row -->
<div class="row">
    <span id="peringatan"></span>
    <div class="col-12 mb-4">
        <div class="card mb-4">
            <!-- card body -->
            <div class="card-body">
                <!-- input -->
                <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <h4 class="mb-4">PROJECT INFORMATION</h4>
                        <input type="hidden" name="weeklyId" id="weeklyId" value="#">
                        <div class="mb-3 col-12">
                            <label class="form-label">Customer Name</label>
                            <input type="text" class="form-control" placeholder="Enter Customer Name" value="{{$project->customer->company}}" disabled>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Project Name</label>
                            <input type="text" class="form-control" placeholder="Enter Project Name" value="{{$project->projectName}}" disabled>
                        </div>
                        <div class=" mb-3 col-6">
                            <label class="form-label">Reporting Period</label>
                            <div class="input-group me-3">
                                <input id="periode" name="periode" type="text" class="form-control rounded datepicker" data-input aria-describedby="date1" required>
                                <div class="input-group-append custom-picker">
                                    <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Overall Progress ( in %)</label>
                            <input type="text" class="form-control" id="overAllProg" name="overAllProg" placeholder="Enter Venue" value="{{$project->overAllProg}}%" disabled>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Current Stage</label>
                            <input type="text" class="form-control" id="currentStage" name="currentStage" placeholder="Enter Current Stage">
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label">Traffic Light</label>
                            <input type="text" id="traficLight" name="traficLight" class="form-control" placeholder="Enter Traffic Light">
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label">Project Status Summary</label>
                            <input type="text" id="projectSummary" name="projectSummary" class="form-control" placeholder="Enter Project Status Summary">
                        </div>
                        <div class=" mb-3 col-4">
                            <label class="form-label">Issued Date</label>
                            <div class="input-group me-3">
                                <input id="issuedDate" name="issuedDate" type="text" class="form-control rounded datepicker" data-input aria-describedby="date1" required>
                                <div class="input-group-append custom-picker">
                                    <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">PM {{$project->customer->company}}</label>
                            <input type="text" id="PMCust" name="PMCust" class="form-control" placeholder="Enter PM {{$project->customer->company}}">
                        </div>
                        <div class="mb-3 col-12 text-end">
                            <button id="projectInformation" type="button" class="btn btn-primary-soft">Save Project Information</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="card mb-4">
            <!-- card body -->
            <div class="card-body">
                <div class="row">
                    <h4><label class="form-label">MILESTONE PROGRESS</label></h4>
                    <div class="mb-3 col-12">
                        <div class="table-responsive">
                            <form method="post" role="form" id="form-milestone" enctype="multipart/form-data">
                                @csrf
                                <table class="table table-centered text-nowrap mb-0" style="border: 1px solid var(--dashui-table-border-color)">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 30%;">Milestone</th>
                                            <th style="width: 25%;" colspan="2">Finish Date</th>
                                            <th style="width: 20%;">Status</th>
                                            <th style="width: 25%;">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailMilestone">
                                        <tr class="input-100">
                                            <td hidden>
                                                <input type="text" name="idmilestone[]" id="idmilestone0">
                                            </td>
                                            <td hidden>
                                                <input type="text" name="idtop[]" id="idtop0">
                                            </td>
                                            <td><input type="text" name="milestone[]" id="milestone0"></td>
                                            <td><input type="text" name="planDate[]" id="planDate0" class="text-center datepicker" data-input aria-describedby="date1"></td>
                                            <td>
                                                <input id="endDate0" name="endDate[]" type="text" class="text-center datepicker" data-input aria-describedby="date1">
                                            </td>
                                            <td><input type="text" name="status[]" id="status0"></td>
                                            <td><input type="text" name="notes[]" id="notes0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="mb-3 text-end">
                        <button id="milestone" type="button" class="btn btn-primary-soft">Save Milestone</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="card mb-4">
            <!-- card body -->
            <div class="card-body">
                <div class="row">
                    <h4><label class="form-label">RISK REGISTER</label></h4>
                    <div class="mb-3 col-12">
                        <div class="table-responsive">
                            <form method="post" role="form" id="form-risk" enctype="multipart/form-data">
                                @csrf
                                <table class="table table-centered text-nowrap mb-0" style="border: 1px solid var(--dashui-table-border-color)">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 10%;">ID</th>
                                            <th style="width: 25%;">Risk Description</th>
                                            <th style="width: 15%;">Risk Response Plan</th>
                                            <th style="width: 10%;">Owner</th>
                                            <th style="width: 15%;">Severity</th>
                                            <th style="width: 10%;">Status</th>
                                            <th style="width: 15%;">Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailRisk">
                                        <tr class="input-100">
                                            <td hidden>
                                                <input type="text" name="idRisk[]" id="idRisk0">
                                            </td>
                                            <td hidden>
                                                <input type="text" name="idRiskRef[]" id="idRiskRef0">
                                            </td>
                                            <td><input type="text" name="idRiskID[]" id="idRiskID0"></td>
                                            <td><input type="text" name="riskDesc[]" id="riskDesc0"></td>
                                            <td><input type="text" name="responPlanRisk[]" id="responPlanRisk0" class="text-center datepicker" data-input aria-describedby="date1"></td>
                                            <td><input type="text" name="ownerRisk[]" id="ownerRisk0"></td>
                                            <td><input type="text" name="severityRisk[]" id="severityRisk0"></td>
                                            <td><input type="text" name="statusRisk[]" id="statusRisk0"></td>
                                            <td>
                                                <input id="dueDateRisk0" name="dueDateRisk[]" type="text" class="text-center datepicker" data-input aria-describedby="date1">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="mb-3 text-end">
                        <button id="saveRisk" type="button" class="btn btn-primary-soft">Save Risk Register</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="card mb-4">
            <!-- card body -->
            <div class="card-body">
                <div class="row">
                    <h4><label class="form-label">ISSUE LOG</label></h4>
                    <div class="mb-3 col-12">
                        <div class="table-responsive">
                            <form method="post" role="form" id="form-issue" enctype="multipart/form-data">
                                @csrf
                                <table class="table table-centered text-nowrap mb-0" style="border: 1px solid var(--dashui-table-border-color)">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 10%;">ID</th>
                                            <th style="width: 25%;">Issue Description</th>
                                            <th style="width: 15%;">Issue Response Plan</th>
                                            <th style="width: 10%;">Owner</th>
                                            <th style="width: 15%;">Severity</th>
                                            <th style="width: 10%;">Status</th>
                                            <th style="width: 15%;">Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailIssue">
                                        <tr class="input-100">
                                            <td hidden>
                                                <input type="text" name="idIssue[]" id="idIssue0">
                                            </td>
                                            <td hidden>
                                                <input type="text" name="idIssueRef[]" id="idIssueRef0">
                                            </td>
                                            <td><input type="text" name="idIssueID[]" id="idIssueID0"></td>
                                            <td><input type="text" name="issueDesc[]" id="issueDesc0"></td>
                                            <td><input type="text" name="responPlanIssue[]" id="responPlanIssue0" class="text-center datepicker" data-input aria-describedby="date1"></td>
                                            <td><input type="text" name="ownerIssue[]" id="ownerIssue0"></td>
                                            <td><input type="text" name="severityIssue[]" id="severity0"></td>
                                            <td><input type="text" name="statusIssue[]" id="statusIssue0"></td>
                                            <td>
                                                <input id="dueDateIssue0" name="dueDateIssue[]" type="text" class="text-center datepicker" data-input aria-describedby="date1">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="mb-3 text-end">
                        <button id="saveIssue" type="button" class="btn btn-primary-soft">Save Issue Log</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="card mb-4">
            <!-- card body -->
            <div class="card-body">
                <div>
                    <!-- input -->
                    <div class="mb-3">
                        <h4><label class="form-label">Progress Report</label></h4>
                        <input type="hidden" id="idProjectProgress" value="#">
                        <textarea name="projectProgressContent" id="projectProgressContent"></textarea>
                    </div>
                    <div class="mb-3 text-end">
                        <button type="button" id="saveProgressReport" data-form="projectProgress" class="btn btn-primary-soft">Save Project Progress</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script>
    $(document).ready(function() {
        //datepicker
        flatpickr("#periode", {
            mode: "range",
            dateFormat: "d-m-Y",
            defaultDate: ["today", new Date().fp_incr(7)],
        });
        flatpickr("#planDate0,#endDate0,#responPlanRisk0,#dueDateRisk0,#responPlanIssue0,#dueDateIssue0,#issuedDate", {
            dateFormat: "d-m-Y",
            defaultDate: "today",
            allowInput: true, // Mengizinkan input manual
        });
    })
    $(document).ready(function() {
        var editor = Jodit.make('#projectProgressContent', {
            "buttons": "bold,italic,underline,strikethrough,eraser,ul,ol,font,fontsize,lineHeight,image,cut,copy,paste,selectall,table,symbols,indent,outdent",
            uploader: {
                insertImageAsBase64URI: true // Menyisipkan gambar sebagai base64 URI
            },
            table: {
                // Konfigurasi tabel
            }
        });


        if ('{{isset($aksi) && $aksi == "EditData"}}') {
            $('#weeklyId').val('{!! isset($data) ? $data->id : "#" !!}');
            $('#issuedDate').val(('{!! isset($data) ? $data->issuedDate : "" !!}').split("-").reverse().join("-"));
            $('#periode').val('{!! isset($data) ? $data->periode : "" !!}');
            $('#PMCust').val('{!! isset($data) ? $data->PMCust : "" !!}');
            $('#currentStage').val('{!! isset($data) ? $data->currentStage : "" !!}');
            $('#traficLight').val('{!! isset($data) ? $data->traficLight : "" !!}');
            var milestone = <?php echo json_encode($milestone); ?>;
            if (milestone.length > 0) {
                for (let i = 0; i < ('{{count($milestone)}}' - 1); i++) {
                    addMilestone();
                }
                for (let i = 0; i < '{{count($milestone)}}'; i++) {
                    const milestoneWeeklyReport = milestone[i].milestone[0] ?? {};

                    $('#idmilestone' + i).val(milestoneWeeklyReport.id ?? "#");
                    $('#idtop' + i).val(milestone[i].id);
                    $('#milestone' + i).val(milestone[i].termsName);
                    $('#planDate' + i).val((milestone[i].bastDate).split("-").reverse().join("-"));
                    $('#endDate' + i).val((milestoneWeeklyReport.finishDate ?? "1900-01-01").split("-").reverse().join("-"));
                    $('#status' + i).val(milestoneWeeklyReport.status ?? "");
                    $('#notes' + i).val(milestoneWeeklyReport.notes ?? "");
                }
            }
            var risk = <?php echo json_encode($risk); ?>;
            if (risk.length > 0) {
                for (let i = 0; i < ('{{count($risk)}}' - 1); i++) {
                    addRiskIssue(detailRisk);
                }
                for (let i = 0; i < '{{count($risk)}}'; i++) {
                    const riskWeeklyReport = risk[i].risk_weekly_report[0] ?? {};

                    $('#idRiskRef' + i).val(risk[i].id);
                    $('#riskDesc' + i).val(risk[i].riskDesc);
                    $('#idRisk' + i).val(riskWeeklyReport.id ?? "#");
                    $('#idRiskID' + i).val(riskWeeklyReport.codeId ?? "");
                    $('#responPlanRisk' + i).val((riskWeeklyReport.responPlan ?? "1900-01-01").split("-").reverse().join("-"));
                    $('#ownerRisk' + i).val(riskWeeklyReport.owner ?? "");
                    $('#severityRisk' + i).val(riskWeeklyReport.severity ?? "");
                    $('#statusRisk' + i).val(riskWeeklyReport.status ?? "");
                    $('#dueDateRisk' + i).val((riskWeeklyReport.dueDate ?? "1900-01-01").split("-").reverse().join("-"));
                }
            }
            var issue = <?php echo json_encode($issue); ?>;
            if (issue.length > 0) {
                for (let i = 0; i < ('{{count($issue)}}' - 1); i++) {
                    addRiskIssue(detailIssue);
                }
                for (let i = 0; i < '{{count($issue)}}'; i++) {
                    const weeklyReport = issue[i]?.issue_weekly_report[0] ?? {};

                    $('#idIssueRef' + i).val(issue[i].id);
                    $('#issueDesc' + i).val(issue[i].issuesDesc);
                    $('#idIssue' + i).val(weeklyReport.id ?? "#");
                    $('#idIssueID' + i).val(weeklyReport.codeId ?? "");
                    $('#responPlanIssue' + i).val((weeklyReport.responPlan ?? "1900-01-01").split("-").reverse().join("-"));
                    $('#ownerIssue' + i).val(weeklyReport.owner ?? "");
                    $('#severityIssue' + i).val(weeklyReport.severity ?? "");
                    $('#statusIssue' + i).val(weeklyReport.status ?? "");
                    $('#dueDateIssue' + i).val((weeklyReport.dueDate ?? "1900-01-01").split("-").reverse().join("-"));

                }
            }
            $('#idProjectProgress').val('{!! isset($projectProgress) ? $projectProgress->id : "#" !!}');
            var editor = new Jodit('#projectProgressContent');
            editor.value = `{!! isset($projectProgress) ? $projectProgress->projectProgress : "" !!}`;

        } else {
            var milestone = <?php echo json_encode($milestone); ?>;
            if (milestone.length > 0) {
                for (let i = 0; i < (milestone.length - 1); i++) {
                    addMilestone();
                }
                for (let i = 0; i < milestone.length; i++) {
                    $('#idmilestone' + i).val("#");
                    $('#idtop' + i).val(milestone[i].id);
                    $('#milestone' + i).val(milestone[i].termsName);
                    $('#planDate' + i).val((milestone[i].bastDate).split("-").reverse().join("-"));
                }
            }

            var risk = <?php echo json_encode($risk); ?>;
            if (risk.length > 0) {
                for (let i = 0; i < ('{{count($risk)}}' - 1); i++) {
                    addRiskIssue(detailRisk);
                }
                for (let i = 0; i < '{{count($risk)}}'; i++) {
                    $('#idRiskRef' + i).val(risk[i].id);
                    $('#riskDesc' + i).val(risk[i].riskDesc);
                }
            }

            var issue = <?php echo json_encode($issue); ?>;
            if (issue.length > 0) {
                for (let i = 0; i < ('{{count($issue)}}' - 1); i++) {
                    addRiskIssue(detailIssue);
                }
                for (let i = 0; i < '{{count($issue)}}'; i++) {
                    $('#idIssueRef' + i).val(issue[i].id);
                    $('#issueDesc' + i).val(issue[i].issuesDesc);
                }
            }
        }
    })
</script>
<script>
    function addMilestone() {
        var table = document.getElementById("detailMilestone");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 6; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j >= 0 && j <= 1) {
                newCell5.style.display = "none";
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            if (j > 1 && j <= 6) {
                var inputs = clonedContent.querySelectorAll('input');
                inputs.forEach(function(input, index) {
                    // if (input.type == "checkbox") {
                    var newId = (input.id).replace(/\d+/g, '') + tableRange;
                    input.id = newId;
                    // console.log(input.id)
                    // }
                });
            }
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);

                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = ""; // Reset input value
                }
            }
            if (clonedContent.querySelector('input.datepicker')) {
                flatpickr("#" + clonedContent.querySelector('input.datepicker').id, {
                    dateFormat: "d-m-Y",
                    defaultDate: "01-01-1900",
                    allowInput: true, // Mengizinkan input manual
                });
            }
        }
    }

    function addRiskIssue(type) {
        var table = document.getElementById($(type).attr('id'));
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 8; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j >= 0 && j <= 1) {
                newCell5.style.display = "none";
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            if (j > 1 && j <= 8) {
                var inputs = clonedContent.querySelectorAll('input');
                inputs.forEach(function(input, index) {
                    // if (input.type == "checkbox") {
                    var newId = (input.id).replace(/\d+/g, '') + tableRange;
                    input.id = newId;
                    // console.log(input.id)
                    // }
                });
            }
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);

                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = ""; // Reset input value
                }
            }
            if (clonedContent.querySelector('input.datepicker')) {
                flatpickr("#" + clonedContent.querySelector('input.datepicker').id, {
                    dateFormat: "d-m-Y",
                    defaultDate: "01-01-1900",
                    allowInput: true, // Mengizinkan input manual
                });
            }
        }
    }
</script>
<script>
    $(function() {
        $('.text-end').on('click', '#projectInformation', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);

            $.ajax({
                type: 'POST',
                url: '/project_information/{{$id}}',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#weeklyId').val(data.weeklyId);
                    alert('Data berhasil disimpan')

                    // window.location.href = "/project/moms/" + data.id;

                },
                error: function(data) {
                    alert('Data gagal disimpan')
                    // window.location.href = "/project/moms/" + data.id;

                },
            });
        })

        $('.text-end').on('click', '#milestone', function() {
            if ($('#weeklyId').val() != "#") {
                var form = document.getElementById("form-milestone");
                var fd = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: '/storeMilestone/' + $('#weeklyId').val(),
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Mengasumsikan respons berisi array data dengan topId dan id
                        var responseData = response.data;

                        // Loop melalui setiap elemen topId pada halaman
                        $('[id^="idtop"]').each(function() {
                            var currentTopId = $(this).val();

                            // Cari data yang sesuai dari respons
                            var matchedData = responseData.find(function(item) {
                                return item.topId === currentTopId;
                            });

                            // Jika data ditemukan, tetapkan ID ke elemen sesuai
                            if (matchedData) {
                                // Ambil karakter unik dari ID sebagai basis pencarian
                                var idSuffix = $(this).attr('id').replace('idtop', '');
                                // Setel nilai elemen "idmilestone" dan "idtop" yang memiliki ID dengan karakter unik yang sesuai
                                $('#idmilestone' + idSuffix).val(matchedData.id);
                            }
                        });
                        alert('Data berhasil disimpan');
                        // window.location.href = "/project/moms/" + data.id;

                    },
                    error: function(data) {
                        alert('Data gagal disimpan')
                        // window.location.href = "/project/moms/" + data.id;

                    },
                });
            } else {
                alert('Harap mengisi Project Information & save')
            }
        })

        $('.text-end').on('click', '#saveRisk', function() {
            if ($('#weeklyId').val() != "#" && '{{count($risk)}}' > 0) {
                var form = document.getElementById("form-risk");
                var fd = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: '/storeWeekRisk/' + $('#weeklyId').val(),
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Mengasumsikan respons berisi array data dengan topId dan id
                        var responseData = response.data;

                        // Loop melalui setiap elemen topId pada halaman
                        $('[id^="idRiskRef"]').each(function() {
                            var riskIssueId = $(this).val();

                            // Cari data yang sesuai dari respons
                            var matchedData = responseData.find(function(item) {
                                return item.riskIssueId === riskIssueId;
                            });

                            // Jika data ditemukan, tetapkan ID ke elemen sesuai
                            if (matchedData) {
                                // Ambil karakter unik dari ID sebagai basis pencarian
                                var idSuffix = $(this).attr('id').replace('idRiskRef', '');
                                // Setel nilai elemen "idmilestone" dan "idtop" yang memiliki ID dengan karakter unik yang sesuai
                                $('#idRisk' + idSuffix).val(matchedData.id);
                            }
                        });
                        alert('Data berhasil disimpan');
                        // window.location.href = "/project/moms/" + data.id;

                    },
                    error: function(data) {
                        alert('Data gagal disimpan')
                        // window.location.href = "/project/moms/" + data.id;

                    },
                });
            } else {
                alert('Harap mengisi Project Information & save / Tidak ada Risk')
            }
        })

        $('.text-end').on('click', '#saveIssue', function() {
            if ($('#weeklyId').val() != "#" && '{{count($issue)}}' > 0) {
                var form = document.getElementById("form-issue");
                var fd = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: '/storeWeekIssue/' + $('#weeklyId').val(),
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Mengasumsikan respons berisi array data dengan topId dan id
                        var responseData = response.data;

                        // Loop melalui setiap elemen topId pada halaman
                        $('[id^="idIssueRef"]').each(function() {
                            var riskIssueId = $(this).val();

                            // Cari data yang sesuai dari respons
                            var matchedData = responseData.find(function(item) {
                                return item.riskIssueId === riskIssueId;
                            });

                            // Jika data ditemukan, tetapkan ID ke elemen sesuai
                            if (matchedData) {
                                // Ambil karakter unik dari ID sebagai basis pencarian
                                var idSuffix = $(this).attr('id').replace('idIssueRef', '');
                                // Setel nilai elemen "idmilestone" dan "idtop" yang memiliki ID dengan karakter unik yang sesuai
                                $('#idIssue' + idSuffix).val(matchedData.id);
                            }
                        });
                        alert('Data berhasil disimpan');
                        // window.location.href = "/project/moms/" + data.id;

                    },
                    error: function(data) {
                        alert('Data gagal disimpan')
                        // window.location.href = "/project/moms/" + data.id;

                    },
                });
            } else {
                alert('Harap mengisi Project Information & save / tidak ada Issue')
            }
        })

        $(document).on('click', '#saveProgressReport', function(e) {
            e.preventDefault();
            if ($('#weeklyId').val() != "#") {
                var key = $(this).data('form');
                // alert(uid)
                if (key === 'projectProgress') {
                    var uid = $('#idProjectProgress').val();
                    var content = $('#projectProgressContent').val();
                }

                $.ajax({
                    type: 'POST',
                    url: '/storeProjectProgress',
                    data: {
                        key: key,
                        uid: uid,
                        konten: content,
                        wReportId: $('#weeklyId').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.message);
                        if (data.key === 'projectProgress') {
                            $('#idProjectProgress').val(data.post);
                        }
                    },
                    error: function(data) {
                        alert(data.message);
                    }
                });
            } else {
                alert('Harap mengisi Project Information & save')
            }
        })

    })
</script>



@endsection