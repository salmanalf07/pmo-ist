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
    }

    .input-100 td {
        padding: 0.5rem;
    }

    .percentage-input::after {
        content: '%';
    }
</style>
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div>
    <!-- row -->

    <div class="row">
        <form method="post" role="form" id="form-add" enctype="multipart/form-data">
            @csrf
            <span id="peringatan"></span>
            <input class="form-control" type="text" name="id" id="id" hidden>
            <div class="col-xxl-12 col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Project Operating Cost</h4>
                        <span id="error-message"></span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 20%;">Description</th>
                                        <th class="text-center" style="width: 15%;">Order Date</th>
                                        <th class="text-center" style="width: 20%;">Po Number</th>
                                        <th class="text-center" style="width: 20%;">Amount</th>
                                        <th class="text-center" style="width: 20%;">PIC</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrder">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idCosting[]" id="idCosting0">
                                        </td>
                                        <td>
                                            <input type="text" name="description[]" id="description0">
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="orderDate0" name="orderDate[]" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="poNumber[]" id="poNumber0">
                                        </td>
                                        <td>
                                            <input type="text" name="amount[]" id="amount0" class="number-input text-end" placeholder="0" onchange="hitung2()">
                                        </td>
                                        <td>
                                            <input id="picCosting0" name="picCosting[]" type="text">
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
                                <tfoot>
                                    <tr class="input-100">
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td><input class="text-end" readonly type="text" name="totalCosting" id="totalCosting"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer  justify-content-between">
                        @can('bisa-tambah')
                        <button type="button" onclick="addRow()" class="btn btn-warning-soft">Add Row</button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Project Bonus</h4>
                        <span id="error-message"></span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20%;">Status</th>
                                        <th class="text-center" style="width: 20%;">Submit Date</th>
                                        <th class="text-center" style="width: 20%;">PIC</th>
                                        <th class="text-center" style="width: 20%;">Total Mandays Claim</th>
                                        <th class="text-center" style="width: 20%;">Total Value Claim</th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrder">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idBonus" id="idBonus">
                                        </td>
                                        <td>
                                            <select name="status" id="status" class="select2" aria-label="Default select example">
                                                <option value="#" selected>-- select --</option>
                                                <option value="inProcess">In Process</option>
                                                <option value="circulate">Circulate</option>
                                                <option value="finance">Finance</option>
                                                <option value="done">Done/Paid</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="SubDate" name="SubDate" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input class="text-center" type="text" name="pic" id="pic">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input class="text-center" type="text" name="mandays" id="mandays">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input type="text" name="valueBonus" class="number-input text-end" placeholder="0" id="valueBonus" onchange="hitung2()">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @can('bisa-tambah')
                    <div class="card-footer  justify-content-between">
                        <button type="button" class="btn btn-primary-soft add"> Save</button>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="col-xxl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0" style="width: 50%;">
                                <tr class="input-100">
                                    <td style="width: 20%;" class="text-center"><b>TOTAL</b></td>
                                    <td style="width: 30%;"><input class="text-end" readonly type="text" placeholder="0" name="totAllCosting" id="totAllCosting"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script>
    flatpickr(".datepicker", {
        enableTime: false,
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
        $('.card-footer').on('click', '.add', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '/store_costing/{{$id}}',
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
                        // console.log(data)
                        document.getElementById("form-add").reset();
                        window.location.href = "/project/costing/" + data.projectId;
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
            $('#idBonus').val('{!! isset($data) ? $data->id : "" !!}');
            $('#status').val('{!! isset($data) ? $data->status : "" !!}').trigger('change');
            $('#SubDate').val('{!! isset($data) ? $data->SubDate : "" !!}'.split("-").reverse().join("-"));
            $('#pic').val('{!! isset($data) ? $data->pic : "" !!}');
            $('#mandays').val('{!! isset($data) ? $data->mandays : "" !!}');
            $('#valueBonus').val(formatNumberr('{!! isset($data) && $data->valueBonus > 0 ? $data->valueBonus : "0" !!}'));
            hitung2();

            var costing = <?php echo json_encode($costing); ?>;
            for (let j = 0; j < ('{{count($costing)}}' - 1); j++) {
                addRow();
            }
            for (var i = 0; i < '{{count($costing)}}'; i++) {
                $('#idCosting' + i).val(costing[i].id);
                $('#description' + i).val(costing[i].description);
                $('#orderDate' + i).val((costing[i].orderDate).split("-").reverse().join("-"));
                $('#poNumber' + i).val(costing[i].poNumber);
                $('#picCosting' + i).val(costing[i].pic);
                if (costing[i].amount > 0) {
                    $('#amount' + i).val(formatNumberr(costing[i].amount));
                } else {
                    $('#amount' + i).val(formatNumberr(0));
                }
                hitung2();
            }
            // console.log(data)
        }
    })

    function addRow() {
        var table = document.getElementById("detailOrder");
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

            if (clonedContent.querySelector('input.datepicker')) {
                flatpickr("#" + clonedContent.querySelector('input.datepicker').id, {
                    dateFormat: "d-m-Y",
                    defaultDate: "01-01-1900",
                    allowInput: true, // Mengizinkan input manual
                });
            }
        }

        $(".number-input").on("input", function() {
            formatNumber(this);
        });
    }
    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        var row = button.closest("tr");
        var inputElement = row.querySelector("input[name='idCosting[]']");
        if (inputElement.value) {
            var id = inputElement.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_projectCosting/' + id,
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
        }
        row.parentNode.removeChild(row);
        hitung2();
    }

    function hitung2() {
        var inputElements = document.querySelectorAll("input[id^='amount']");
        var valueBonus = parseFloat($('#valueBonus').val().replaceAll(".", ""));
        var total = 0;

        inputElements.forEach(function(inputElement) {
            var inputValue = parseFloat((inputElement.value).replaceAll(".", ""));
            if (inputValue > 0) {
                total += inputValue;
            }
        });



        if (inputElements.length !== 0) {
            $('#totalCosting').val(formatNumberr(total));
        } else {
            console.log("Tidak ada input yang ditemukan.");
        }

        $('#totAllCosting').val(formatNumberr(valueBonus + total))
    }
</script>
@endsection