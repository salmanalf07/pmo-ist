@extends('/project/navbarInput')

@section('inputan')
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
        padding-right: 1rem;
    }

    .input-100 td {
        padding: 0.5rem;
    }
</style>
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div>
    <!-- row -->

    <form method="post" role="form" id="form-add" enctype="multipart/form-data">
        @csrf
        <span id="peringatan"></span>
        <input class="form-control" type="text" name="id" id="id" hidden>
        <div class="row">
            <div class="col-xxl-12 col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Risk</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:20%">Risk Description</th>
                                        <th style="width:20%">Trigger Event/Indicator</th>
                                        <th style="width:20%">Risk Response and Description</th>
                                        <th style="width:15%">Contingency Plan</th>
                                        <th style="width:15%">Owner</th>
                                        <th style="width:5%">Status</th>
                                        <th style="width:5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailRisk">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idRisk[]" id="idRisk0">
                                        </td>
                                        <td>
                                            <input type="text" name="riskDesc[]" id="riskDesc0">
                                        </td>
                                        <td>
                                            <input type="text" name="trigerEvent[]" id="trigerEvent0">
                                        </td>
                                        <td>
                                            <input type="text" name="riskResponse[]" id="riskResponse0">
                                        </td>
                                        <td>
                                            <input type="text" name="contiPlan[]" id="contiPlan0">
                                        </td>
                                        <td>
                                            <input type="text" name="riskOwner[]" id="riskOwner0">
                                        </td>
                                        <td>
                                            <select name="statRisk[]" id="statRisk0" class="select2" aria-label="Default select example">
                                                <option value="#" selected>-- select --</option>
                                                <option value="open">Open</option>
                                                <option value="close">Close</option>
                                            </select>
                                        </td>
                                        <td>
                                            @canany(['bisa-hapus','riskIssue-editor'])
                                            <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashOne" onclick="deleteRow(this);">
                                                <i data-feather="trash-2" class="icon-xs"></i>
                                                <div id="trashOne" class="d-none">
                                                    <span>Delete</span>
                                                </div>
                                            </a>
                                            @endcanany
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer  justify-content-between">
                        @canany(['bisa-tambah','riskIssue-editor'])
                        <button type="button" onclick="addRowRisk()" class="btn btn-warning-soft">Add Row Risk</button>
                        @endcanany
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-12">
                <div class="card  mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Issues</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width:20%">Issue Description</th>
                                        <th class="text-center" style="width:20%">Project Impact</th>
                                        <th class="text-center" style="width:20%">Action Plan/Resolution</th>
                                        <th class="text-center" style="width:13%">Issue Type</th>
                                        <th class="text-center" style="width:10%">Date Resolved</th>
                                        <th class="text-center" style="width:12%">Status</th>
                                        <th class="text-center" style="width:5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailIssues">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idIssues[]" id="idIssues0">
                                        </td>
                                        <td>
                                            <input type="text" name="issuesDesc[]" id="issuesDesc0">
                                        </td>
                                        <td>
                                            <input type="text" name="projectImpact[]" id="projectImpact0">
                                        </td>
                                        <td>
                                            <input type="text" name="actionPlan[]" id="actionPlan0">
                                        </td>
                                        <td>
                                            <select name="issuesOwner[]" id="issuesOwner0" class="select2" aria-label="Default select example" onchange="count(this)">
                                                <option value="#" selected>-- select --</option>
                                                <option value="Issue">Issue</option>
                                                <option value="Stopper">Stopper</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="resolvedDate0" name="resolvedDate[]" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <select name="statIssues[]" id="statIssues0" class="select2" aria-label="Default select example">
                                                <option value="#" selected>-- select --</option>
                                                <option value="open">Open</option>
                                                <option value="close">Close</option>
                                            </select>
                                        </td>
                                        <td>
                                            @canany(['bisa-hapus','riskIssue-editor'])
                                            <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashOne" onclick="deleteRow(this);">
                                                <i data-feather="trash-2" class="icon-xs"></i>
                                                <div id="trashOne" class="d-none">
                                                    <span>Delete</span>
                                                </div>
                                            </a>
                                            @endcanany
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer  justify-content-between">
                        <div class="row input-100">
                            <div class="col-6">
                                @canany(['bisa-tambah','riskIssue-editor'])
                                <button type="button" onclick="addRowIssues()" class="btn btn-warning-soft">Add Row Issues</button>
                                @endcanany
                            </div>
                            <div class="col-1 text-end">
                                Stopper
                            </div>
                            <div class="col-2">
                                <input class="text-end" id="totStopper" type="text" placeholder="Count Stopper" readonly>
                            </div>
                            <div class="col-1  text-end">
                                Issue
                            </div>
                            <div class="col-2">
                                <input class="text-end" id="totIssue" type="text" placeholder="Count Issue" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="justify-content-between">
                            @canany(['bisa-tambah','riskIssue-editor'])
                            <button type="button" class="btn btn-primary-soft add">Save</button>
                            @endcanany
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script>
    flatpickr(".datepicker", {
        dateFormat: "d-m-Y",
        defaultDate: "01-01-1900",
        allowInput: true, // Mengizinkan input manual
    });
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    $(function() {
        //add data
        $('.justify-content-between').on('click', '.add', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '/store_riskIssues/{{$id}}',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data[1]) {
                        let text = "";
                        var dataa = Object.assign({}, data[0])
                        for (let x in dataa) {
                            text += "<div class='alert alert-dismissible hide fade in alert-danger show'><strong>Errorr!</strong> " + dataa[x] + "<a href='#' class='close float-close' data-dismiss='alert' aria-label='close'>×</a></div>";
                        }
                        $('#peringatan').append(text);
                    } else {
                        //console.log(data)
                        document.getElementById("form-add").reset();
                        window.location.href = "/project/riskIssues/" + data;
                    }

                },
            });
        });
    })
</script>
<script>
    $(document).ready(function() {
        if ('{{isset($aksiRisk) && $aksiRisk == "EditData"}}') {
            var data = <?php echo json_encode($dataRisk); ?>;
            $('#id').val('{{ isset($dataRisk) ? $id : "" }}');
            for (let j = 0; j < ('{{count($dataRisk)}}' - 1); j++) {
                addRowRisk();
            }

            for (var i = 0; i < '{{count($dataRisk)}}'; i++) {
                $('#idRisk' + i).val(data[i].id);
                $('#riskDesc' + i).val(data[i].riskDesc);
                $('#trigerEvent' + i).val(data[i].trigerEvent);
                $('#riskResponse' + i).val(data[i].riskResponse);
                $('#contiPlan' + i).val(data[i].contiPlan);
                $('#riskOwner' + i).val(data[i].riskOwner);
                $('#statRisk' + i).val(data[i].statRisk).trigger('change');
            }
        }
        //issues
        if ('{{isset($aksiIssues) && $aksiIssues == "EditData"}}') {
            var data = <?php echo json_encode($dataIssues); ?>;
            $('#id').val('{{ isset($dataIssues) ? $id : "" }}');
            for (let j = 0; j < ('{{count($dataIssues)}}' - 1); j++) {
                addRowIssues();
            }

            for (var i = 0; i < '{{count($dataIssues)}}'; i++) {
                $('#idIssues' + i).val(data[i].id);
                $('#issuesDesc' + i).val(data[i].issuesDesc);
                $('#projectImpact' + i).val(data[i].projectImpact);
                $('#actionPlan' + i).val(data[i].actionPlan);
                $('#issuesOwner' + i).val(data[i].issuesOwner).trigger('change');
                $('#resolvedDate' + i).val((data[i].resolvedDate).split("-").reverse().join("-"));
                $('#statIssues' + i).val(data[i].statIssues).trigger('change');
            }
        }
    })
</script>
<script>
    function addRowRisk() {
        var table = document.getElementById("detailRisk");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 5; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 0) {
                newCell5.style.display = "none";
            }
            if (j <= 5) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);

                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = ""; // Reset input value
                }
            }

        }
        for (let j = 6; j <= 6; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);

            // Mengklon elemen select dari sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('select');
            var clonedSelect = selectElement.cloneNode(true);
            clonedSelect.id = (selectElement.id).replace(/\d+/g, '') + tableRange;

            // Menambahkan elemen select yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            newCell5.appendChild(clonedSelect);

            // Menghapus Select2 dari elemen select yang dikloning (jika sudah ada)
            if ($(clonedSelect).hasClass('select2-hidden-accessible')) {
                $(clonedSelect).select2('destroy');
            }

            // Mengaktifkan kembali Select2 pada elemen select yang baru
            $(clonedSelect).select2();

            // Menyalin nilai yang dipilih dari elemen asli ke elemen yang dikloning
            var selectedOptions = Array.from(selectElement.selectedOptions);
            selectedOptions.forEach(option => {
                $(clonedSelect).find(`option[value="${option.value}"]`).prop('selected', true);
            });
        }
        for (let j = 7; j <= 7; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                newCell5.appendChild(childNodes[k].cloneNode(true));
            }
        }
        // Mengaktifkan kembali Select2 pada semua elemen select setelah pengklonan
        $('.select2').select2();

    }

    function addRowIssues() {
        var table = document.getElementById("detailIssues");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 3; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 0) {
                newCell5.style.display = "none";
            }
            if (j <= 3) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);

                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = ""; // Reset input value
                }
            }

        }
        for (let j = 4; j <= 4; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);

            // Mengklon elemen select dari sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('select');
            var clonedSelect = selectElement.cloneNode(true);
            clonedSelect.id = (selectElement.id).replace(/\d+/g, '') + tableRange;

            // Menambahkan elemen select yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            newCell5.appendChild(clonedSelect);

            // Menghapus Select2 dari elemen select yang dikloning (jika sudah ada)
            if ($(clonedSelect).hasClass('select2-hidden-accessible')) {
                $(clonedSelect).select2('destroy');
            }

            // Mengaktifkan kembali Select2 pada elemen select yang baru
            $(clonedSelect).select2();

            // Menyalin nilai yang dipilih dari elemen asli ke elemen yang dikloning
            var selectedOptions = Array.from(selectElement.selectedOptions);
            selectedOptions.forEach(option => {
                $(clonedSelect).find(`option[value="#"]`).prop('selected', true);
            });

            // newCell5.addEventListener("change", function() {
            //     count(this);
            // });
        }
        for (let j = 5; j <= 5; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;

            if (j == 5) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
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
        for (let j = 6; j <= 6; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);

            // Mengklon elemen select dari sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('select');
            var clonedSelect = selectElement.cloneNode(true);
            clonedSelect.id = (selectElement.id).replace(/\d+/g, '') + tableRange;

            // Menambahkan elemen select yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            newCell5.appendChild(clonedSelect);

            // Menghapus Select2 dari elemen select yang dikloning (jika sudah ada)
            if ($(clonedSelect).hasClass('select2-hidden-accessible')) {
                $(clonedSelect).select2('destroy');
            }

            // Mengaktifkan kembali Select2 pada elemen select yang baru
            $(clonedSelect).select2();

            // Menyalin nilai yang dipilih dari elemen asli ke elemen yang dikloning
            var selectedOptions = Array.from(selectElement.selectedOptions);
            selectedOptions.forEach(option => {
                $(clonedSelect).find(`option[value="${option.value}"]`).prop('selected', true);
            });
        }
        for (let j = 7; j <= 7; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                newCell5.appendChild(childNodes[k].cloneNode(true));
            }
        }
        // Mengaktifkan kembali Select2 pada semua elemen select setelah pengklonan
        $('.select2').select2();

    }

    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        var row = button.closest("tr");
        var inputElement1 = row.querySelector("input[name='idRisk[]']");
        var inputElement = row.querySelector("input[name='idIssues[]']");
        if (inputElement1 && inputElement1.value) {
            var id = inputElement1.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_projectMember/risk/' + id,
                    data: {
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        alert("Data Berhasil Dihapus");
                    }
                });

            } else {
                return false;
            }
        } else {
            row.parentNode.removeChild(row);
        }
        if (inputElement && inputElement.value) {
            var id = inputElement.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_projectMember/issues/' + id,
                    data: {
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        alert("Data Berhasil Dihapus");
                    }
                });

            } else {
                return false;
            }
        } else {
            row.parentNode.removeChild(row);
        }

    }

    function count(button) {
        var array = document.getElementsByName("issuesOwner[]"); // Mengambil elemen dengan atribut name "arra[]"

        var stopper = 0;
        var issue = 0;
        for (let i = 0; i <= array.length; i++) {
            if ($('#' + (button.id).replace(/[0-9]/g, '') + [i]).val() == "Issue") {
                issue += 1
            }
            if ($('#' + (button.id).replace(/[0-9]/g, '') + [i]).val() == "Stopper") {
                stopper += 1
            }
        }
        $('#totStopper').val(stopper);
        $('#totIssue').val(issue);
    }
</script>
@endsection