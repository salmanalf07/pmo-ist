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
                        <h4 class="mb-0">In Scope</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width:95%">In Scope</th>
                                        <th class="text-center" style="width:5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailInScope">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idInScope[]" id="idInScope0">
                                        </td>
                                        <td>
                                            <input type="text" name="inScope[]" id="inScope0">
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
                        <button type="button" onclick="addRowInScope()" class="btn btn-warning-soft">Add Row In Scope</button>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-12">
                <div class="card  mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Out Of Scope</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width:95%">Out Of Scope</th>
                                        <th class="text-center" style="width:5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailOutScope">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idOutScope[]" id="idOutScope0">
                                        </td>
                                        <td>
                                            <input type="text" name="outOfScope[]" id="outOfScope0">
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
                        <button type="button" onclick="addRowOutScope()" class="btn btn-warning-soft">Add Row Out Of Scope</button>
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
        defaultDate: "today",
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
                url: '/store_sow/{{$id}}',
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
                        window.location.href = "/project/sow/" + data;
                    }

                },
            });
        });
    })
</script>
<script>
    $(document).ready(function() {
        if ('{{isset($aksiInScope) && $aksiInScope == "EditData"}}') {
            var data = <?php echo json_encode($dataInScope); ?>;
            $('#id').val('{{ isset($dataInScope) ? $id : "" }}');
            for (let j = 0; j < ('{{count($dataInScope)}}' - 1); j++) {
                addRowInScope();
            }

            for (var i = 0; i < '{{count($dataInScope)}}'; i++) {
                $('#idInScope' + i).val(data[i].id);
                $('#inScope' + i).val(data[i].inScope);
            }
        }
        //issues
        if ('{{isset($aksiOutScope) && $aksiOutScope == "EditData"}}') {
            var data = <?php echo json_encode($dataOutScope); ?>;
            $('#id').val('{{ isset($dataOutScope) ? $id : "" }}');
            for (let j = 0; j < ('{{count($dataOutScope)}}' - 1); j++) {
                addRowOutScope();
            }

            for (var i = 0; i < '{{count($dataOutScope)}}'; i++) {
                $('#idOutScope' + i).val(data[i].id);
                $('#outOfScope' + i).val(data[i].outOfScope);
            }
        }
    })
</script>
<script>
    function addRowInScope() {
        var table = document.getElementById("detailInScope");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 1; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 0) {
                newCell5.style.display = "none";
            }
            if (j <= 1) {
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
        for (let j = 2; j <= 2; j++) {
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


        newCell5.addEventListener("click", function() {
            deleteRow(this);
        });
        // cell5.addEventListener("click", function() {
        //     deleteRow(this);
        // });
    }

    function addRowOutScope() {
        var table = document.getElementById("detailOutScope");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 1; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 0) {
                newCell5.style.display = "none";
            }
            if (j <= 1) {
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

            flatpickr(".datepicker", {
                dateFormat: "d-m-Y",
            });
        }
        for (let j = 2; j <= 2; j++) {
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


        newCell5.addEventListener("click", function() {
            deleteRow(this);
        });
        // cell5.addEventListener("click", function() {
        //     deleteRow(this);
        // });
    }

    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        var row = button.closest("tr");
        var inputElement1 = row.querySelector("input[name='idInScope[]']");
        var inputElement = row.querySelector("input[name='idOutScope[]']");
        if (inputElement1 && inputElement1.value) {
            var id = inputElement1.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_projectSow/InScope/' + id,
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
                    url: '/delete_projectSow/OutScope/' + id,
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
</script>
@endsection