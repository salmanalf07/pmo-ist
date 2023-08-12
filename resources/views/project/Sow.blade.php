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
                <div class="card  mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Documentation</h4>

                    </div>
                    <div class="card-body">
                        <div id="inputfile" class="row">
                            <input type="hidden" name="idfile" id="idfile">
                            <div class="mb-3 col-6">
                                <input name="nameFile" id="nameFile" type="text" class="form-control" placeholder="Enter Name File Here">
                            </div>
                            <div class="mb-3 col-6">
                                <input name="link" id="link" type="text" class="form-control" placeholder="Enter Link Here">
                            </div>
                        </div>
                        <div style="display: none;" id="linkDirect" class="row">
                        </div>
                    </div>
                </div>
            </div>
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
                                        <th class="text-center" style="width:5%">No</th>
                                        <th class="text-center" style="width:60%">Description</th>
                                        <th class="text-center" style="width:30%">Remaks</th>
                                        <th class="text-center" style="width:5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailInScope">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idInScope[]" id="idInScope0">
                                        </td>
                                        <td class="text-center">
                                            1
                                        </td>
                                        <td>
                                            <input type="text" name="inScope[]" id="inScope0">
                                        </td>
                                        <td>
                                            <input id="remaksIn0" name="remaksIn[]" type="text">
                                        </td>
                                        <td>
                                            @can('bisa-hapus')
                                            <a href="#!" onclick="deleteRow(this)" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashOne">
                                                <i data-feather="trash-2" class="icon-xs"></i>
                                                <div id="trashOne" class="d-none">
                                                    <span>Delete</span>
                                                </div>
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer  justify-content-between">
                        @can('bisa-tambah')
                        <button type="button" onclick="addRowInScope()" class="btn btn-warning-soft">Add Row In Scope</button>
                        @endcan
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
                                        <th class="text-center" style="width:5%">No</th>
                                        <th class="text-center" style="width:60%">Description</th>
                                        <th class="text-center" style="width:30%">Remaks</th>
                                        <th class="text-center" style="width:5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailOutScope">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idOutScope[]" id="idOutScope0">
                                        </td>
                                        <td class="text-center">
                                            1
                                        </td>
                                        <td>
                                            <input type="text" name="outOfScope[]" id="outOfScope0">
                                        </td>
                                        <td>
                                            <input id="remaksOut0" name="remaksOut[]" type="text">
                                        </td>
                                        <td>
                                            @can('bisa-hapus')
                                            <a href="#!" onclick="deleteRow(this)" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashOne">
                                                <i data-feather="trash-2" class="icon-xs"></i>
                                                <div id="trashOne" class="d-none">
                                                    <span>Delete</span>
                                                </div>
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer  justify-content-between">
                        @can('bisa-tambah')
                        <button type="button" onclick="addRowOutScope()" class="btn btn-warning-soft">Add Row Out Of Scope</button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="justify-content-between">
                            @can('bisa-tambah')
                            <button type="button" class="btn btn-primary-soft add">Save</button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
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

        $(document).on('click', '#buttonUpdateLink', function() {
            $('#linkDirect').hide();
            $('#inputfile').show();
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
                $('#remaksIn' + i).val(data[i].remaks);
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
                $('#remaksOut' + i).val(data[i].remaks);
            }
        }
        if ('{{isset($aksiFile) && $aksiFile == "EditData"}}') {
            var data = <?php echo json_encode($file); ?>;
            $('#idFile').val(data.id);
            $('#nameFile').val(data.nameFile);
            $('#link').val(data.link);
            $('#linkDirect').html('<div class="mb-3 col-9">' +
                '<a href="' + data.link + '" target="_blank" class="btn btn-ghost p-2 pt-0 pb-0" data-template="six">' +
                '<i class="bi bi-link-45deg icon-lg me-1"></i>' + data.nameFile +
                '</a></div>' +
                '<div class="mb-3 col-3">' +
                '<div class="justify-content-between text-end">' +
                '@can("bisa-ubah")' +
                '<button type="button" id="buttonUpdateLink" class="btn btn-warning-soft">Update</button>' +
                '@endcan' +
                '</div');
            $('#linkDirect').show();
            $('#inputfile').hide();
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

        for (let j = 0; j <= 4; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 0) {
                newCell5.style.display = "none";
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            if (j > 1 && j <= 3) {
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
            if (j == 1) {
                newCell5.innerHTML = tableRange + 1;
                newCell5.classList = "text-center";
            }
        }
        // for (let j = 4; j <= 4; j++) {
        //     var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
        //     var newCell5 = row.insertCell(j);
        //     // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
        //     var clonedContent = cell5.cloneNode(true);
        //     var childNodes = clonedContent.childNodes;
        //     // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
        //     for (var k = 0; k < childNodes.length; k++) {
        //         newCell5.appendChild(childNodes[k].cloneNode(true));
        //     }
        // }



        // newCell5.addEventListener("click", function() {
        //     deleteRow(this);
        // });
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

        for (let j = 0; j <= 3; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 0) {
                newCell5.style.display = "none";
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            if (j > 1 && j <= 3) {
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
            if (j == 1) {
                newCell5.innerHTML = tableRange + 1;
                newCell5.classList = "text-center";
            }

            flatpickr(".datepicker", {
                dateFormat: "d-m-Y",
            });
        }
        for (let j = 4; j <= 4; j++) {
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
        // console.log(inputElement1)
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