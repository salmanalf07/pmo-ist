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
        height: 2.4rem;
    }

    .input-100 td {
        padding: 0.5rem;
    }
</style>
<!-- custom select2 -->
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div>
    <!-- row -->
    <form method="post" role="form" id="form-add" enctype="multipart/form-data">
        <div class="row">
            @csrf
            <span id="peringatan"></span>
            <input class="form-control" type="text" name="id" id="id" hidden>
            <div class="col-xxl-12 col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Project Member</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th class="text-start" style="width: 25%;">Name</th>
                                        <th class="text-start" style="width: 15%;">Role</th>
                                        <th style="width: 10%;">AccesType</th>
                                        <th style="width: 15%;">Dept/Div</th>
                                        <th style="width: 10%;">Start Date</th>
                                        <th style="width: 10%;">End Date</th>
                                        <th style="width: 10%;">Plan Mandays</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrder">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idMember[]" id="idMember0">
                                        </td>
                                        <td>
                                            <select name="employee[]" id="employee0" class="select2" aria-label="Default select example" onchange="search_div(this)">
                                                <option selected>Open this select menu</option>
                                                @foreach($employee as $employee)
                                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="role[]" id="role0" class="select2" aria-label="Default select example">
                                                <option selected>Open this select menu</option>
                                                <option value="ProjectManager">Project Manager</option>
                                                <option value="LeadFrontendDeveloper">Lead Frontend Developer</option>
                                                <option value="FrontendDeveloper">Frontend Developer</option>
                                                <option value="LeadBackendDeveloper">Lead Backend Developer</option>
                                                <option value="BackendEngineer">Backend Engineer</option>
                                                <option value="BussinessAnalyst">Bussiness Analyst</option>
                                                <option value="Devops/IntegrationEngineer">Devops / Integration Engineer</option>
                                                <option value="LeadQA">Lead QA</option>
                                                <option value="QATester/QAEngineer">QA Tester / QA Engineer</option>
                                                <option value="TechnicalWriter/UIUXWriter">Technical Writer / UI UX Writer</option>
                                                <option value="UIUXAnalyst/ResearcherDesigner">UI UX Analyst / Researcher Designer</option>
                                                <option value="ScrumMaster">Scrum Master</option>
                                                <option value="FullstackDeveloper">Fullstack Developer</option>
                                                <option value="SystemAnalyst">System Analyst</option>

                                            </select>
                                        </td>
                                        <td>
                                            <select name="accesType[]" id="accesType0" class="select2" aria-label="Default select example">
                                                <option selected>Open this select menu</option>
                                                <option value="Remote">Remote</option>
                                                <option value="Onsite">Onsite</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input id="divisi0" name="divisi[]" type="text" readonly>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="startDate0" name="startDate[]" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="endDate0" name="endDate[]" type="text" onchange="compareDates(this)" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <input id="planMandays0" name="planMandays[]" type="text" onchange="compareDates(this)" class="text-center" value="0">
                                        </td>
                                        <td>
                                            <a href="#!" onclick="deleteRow(this)" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashOne">
                                                <i data-feather="trash-2" class="icon-xs"></i>
                                                <div id="trashOne" class="d-none">
                                                    <span>Delete</span>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer  justify-content-between">
                        <button type="button" onclick="addRow()" class="btn btn-warning-soft">Add Row Member</button>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Partner Member</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th class="text-start" style="width: 30%;">Name</th>
                                        <th class="text-start" style="width: 15%;">Role</th>
                                        <th style="width: 10%;">AccesType</th>
                                        <th style="width: 15%;">Dept/Div</th>
                                        <th style="width: 10%;">Start Date</th>
                                        <th style="width: 10%;">End Date</th>
                                        <th style="width: 10%;">Plan Mandays</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailPartner">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idPartner[]" id="idPartner0">
                                        </td>
                                        <td>
                                            <input id="partner0" name="partner[]" type="text">
                                        </td>
                                        <td>
                                            <select name="rolePartner[]" id="rolePartner0" class="select2" aria-label="Default select example">
                                                <option selected>Open this select menu</option>
                                                <option value="ProjectManager">Project Manager</option>
                                                <option value="LeadFrontendDeveloper">Lead Frontend Developer</option>
                                                <option value="FrontendDeveloper">Frontend Developer</option>
                                                <option value="LeadBackendDeveloper">Lead Backend Developer</option>
                                                <option value="BackendEngineer">Backend Engineer</option>
                                                <option value="BussinessAnalyst">Bussiness Analyst</option>
                                                <option value="Devops/IntegrationEngineer">Devops / Integration Engineer</option>
                                                <option value="LeadQA">Lead QA</option>
                                                <option value="QATester/QAEngineer">QA Tester / QA Engineer</option>
                                                <option value="TechnicalWriter/UIUXWriter">Technical Writer / UI UX Writer</option>
                                                <option value="UIUXAnalyst/ResearcherDesigner">UI UX Analyst / Researcher Designer</option>
                                                <option value="ScrumMaster">Scrum Master</option>
                                                <option value="FullstackDeveloper">Fullstack Developer</option>
                                                <option value="SystemAnalyst">System Analyst</option>

                                            </select>
                                        </td>
                                        <td>
                                            <select name="accesPartner[]" id="accesPartner0" class="select2" aria-label="Default select example">
                                                <option selected>Open this select menu</option>
                                                <option value="Remote">Remote</option>
                                                <option value="Onsite">Onsite</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input id="partnerCorp0" name="partnerCorp[]" type="text">
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="stdatePartner0" name="stdatePartner[]" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="eddatePartner0" name="eddatePartner[]" type="text" onchange="compareDates(this)" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <input id="planManPartner0" name="planManPartner[]" type="text" onchange="compareDates(this)" class="text-center" value="0">
                                        </td>
                                        <td>
                                            <a href="#!" onclick="deleteRow(this)" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashOne">
                                                <i data-feather="trash-2" class="icon-xs"></i>
                                                <div id="trashOne" class="d-none">
                                                    <span>Delete</span>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer  justify-content-between">
                        <button type="button" onclick="addRowPartner()" class="btn btn-warning-soft">Add Row Partner</button>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="justify-content-between">
                            <button type="button" class="btn btn-primary-soft add">Save</button>
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
    });
    $(document).ready(function() {
        $('.select2').select2();
    });

    function compareDates(input) {
        console.log((input.id).match(/\d+/g))
        // var id = (input.id).match(/\d+/g);
        // var dateInInput = input.id === "startDate0" ? input : document.getElementById('startDate' + id);
        // var dateEnfInput = input.id === "endDate0" ? input : document.getElementById('endDate' + id);

        // var dateIn = convertToDate(dateInInput.value);
        // var dateEnf = convertToDate(dateEnfInput.value);

        // if (dateIn.getTime() > dateEnf.getTime()) {
        //     alert("Tanggal  Start Date harus sebelum Tanggal End Date.");
        // } else if (dateIn.getTime() < dateEnf.getTime()) {
        //     // Tanggal valid
        // } else {
        //     alert("Tanggal  Start Date dan Tanggal Plan End Date tidak boleh sama.");
        // }
    }
</script>
<script>
    $(function() {
        //add data
        $('.card-footer').on('click', '.add', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '/store_projectMember/{{$id}}',
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
                        window.location.href = "/project/projectMember/" + data;
                    }

                },
            });
        });
    })
</script>
<script>
    $(document).ready(function() {
        if ('{{isset($aksi) && $aksi == "EditData"}}') {
            var data = <?php echo json_encode($data); ?>;
            $('#id').val('{{ isset($data) ? $id : "" }}');
            for (let j = 0; j < ('{{count($data)}}' - 1); j++) {
                addRow();
            }

            for (var i = 0; i < '{{count($data)}}'; i++) {
                $('#idMember' + i).val(data[i].id);
                $('#employee' + i).val(data[i].employee).trigger('change');
                $('#role' + i).val(data[i].role).trigger('change');
                $('#startDate' + i).val((data[i].startDate).split("-").reverse().join("-"));
                $('#endDate' + i).val((data[i].endDate).split("-").reverse().join("-"));
                $('#planMandays' + i).val(data[i].planMandays);
            }

            var dataa = <?php echo json_encode($partner); ?>;
            $('#id').val('{{ isset($partner) ? $id : "" }}');
            for (let j = 0; j < ('{{count($partner)}}' - 1); j++) {
                addRowPartner();
            }

            for (var i = 0; i < '{{count($partner)}}'; i++) {
                $('#idPartner' + i).val(dataa[i].id);
                $('#partner' + i).val(dataa[i].partner);
                $('#rolePartner' + i).val(dataa[i].rolePartner).trigger('change');
                $('#partnerCorp' + i).val(dataa[i].partnerCorp);
                $('#stdatePartner' + i).val((dataa[i].stdatePartner).split("-").reverse().join("-"));
                $('#eddatePartner' + i).val((dataa[i].eddatePartner).split("-").reverse().join("-"));
                $('#planManPartner' + i).val(dataa[i].planManPartner);
            }
        }
    })
</script>
<script>
    function addRow() {
        var table = document.getElementById("detailOrder");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j < 1; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var selectElement = cell5.querySelector('input');
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            newCell5.style.display = "none";
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);

                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = ""; // Reset input value
                }
            }
        }

        for (let j = 1; j <= 3; j++) {
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
                clonedNode.addEventListener("change", function() {
                    search_div(this);
                });
            });
        }

        // Mengaktifkan kembali Select2 pada semua elemen select setelah pengklonan
        $('select').select2();

        for (let j = 4; j <= 8; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;

            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            if (j == 4 || j == 5 || j == 6 || j == 7) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;

            }
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);

                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = ""; // Reset input value
                    clonedNode.addEventListener("change", function() {
                        compareDates(this);
                    });
                }
            }
            if (j == 8) {
                cell5.addEventListener("click", function() {
                    deleteRow(this);
                });
                newCell5.addEventListener("click", function() {
                    deleteRow(this);
                });
            }
            if (clonedContent.querySelector('input.datepicker')) {
                flatpickr("#" + clonedContent.querySelector('input.datepicker').id, {
                    dateFormat: "d-m-Y",
                    defaultDate: "01-01-1900",
                });
            }
        }
    }

    function addRowPartner() {
        var table = document.getElementById("detailPartner");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 1; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var selectElement = cell5.querySelector('input');
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            if (j == 0) {
                newCell5.style.display = "none";
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

        for (let j = 2; j <= 3; j++) {
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
                clonedNode.addEventListener("change", function() {
                    search_div(this);
                });
            });
        }

        // Mengaktifkan kembali Select2 pada semua elemen select setelah pengklonan
        $('select').select2();

        for (let j = 4; j <= 8; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;

            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            if (j == 4 || j == 5 || j == 6 || j == 7) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;

            }
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);

                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = ""; // Reset input value
                    clonedNode.addEventListener("change", function() {
                        compareDates(this);
                    });
                }
            }
            if (j == 8) {
                // cell5.addEventListener("click", function() {
                //     deleteRow(this);
                // });
                newCell5.addEventListener("click", function() {
                    deleteRow(this);
                });
            }
            if (clonedContent.querySelector('input.datepicker')) {
                flatpickr("#" + clonedContent.querySelector('input.datepicker').id, {
                    dateFormat: "d-m-Y",
                    defaultDate: "01-01-1900",
                });
            }
        }
    }

    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        var row = button.closest("tr");
        var inputElement = row.querySelector("input[name='idMember[]']");
        var inputElement1 = row.querySelector("input[name='idPartner[]']");
        if (inputElement && inputElement.value) {
            var id = inputElement.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_projectMember/' + id,
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
        if (inputElement1 && inputElement1.value) {
            var id = inputElement1.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_projectPartner/' + id,
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

    function search_div(i) {
        //console.log(i.id);
        var matches = i.id.match(/\d+/);
        var employee = $('#employee' + matches[0]).val();
        $.ajax({
            type: 'POST',
            url: '/search_employee',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': employee,

            },
            success: function(data) {
                $('#divisi' + matches).val(data.divisi);
            },
        });
    };
</script>
@endsection