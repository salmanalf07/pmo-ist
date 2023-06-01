@extends('/project/navbarInput')

@section('inputan')
<style>
    .input-80 input {
        width: 80% !important;
    }

    .input-100 input {
        width: 100% !important;
        border: 1px solid black;
        border-radius: 0.2rem;
        height: 2rem;
    }

    .input-100 td {
        padding: 0.5rem;
    }
</style>
<div>
    <!-- row -->

    <div class="row">
        <div class="col-xxl-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Terms Of Payment</h4>

                </div>
                <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                    @csrf
                    <span id="peringatan"></span>
                    <input class="form-control" type="text" name="id" id="id" hidden>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th style="width: 30%;">Name TOP</th>
                                        <th style="width: 20%;">Value</th>
                                        <th style="width: 15%;">Plant BAST</th>
                                        <th style="width: 15%;">Invoice Date</th>
                                        <th style="width: 15%;">Payment Date</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrder">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idtop[]" id="idtop0">
                                        </td>
                                        <td>
                                            <input type="text" name="termsName[]" id="termsName0">
                                        </td>
                                        <td><input type="text" class="number-input text-end" name="termsValue[]" id="termsValue0"></td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="bastDate0" name="bastDate[]" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="invDate0" name="invDate[]" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group me-3 ">
                                                <input id="payDate0" name="payDate[]" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashOne">
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
                        <button type="button" onclick="addRow()" class="btn btn-warning-soft">Add Row</button>
                        <button type="button" class="btn btn-primary-soft add"> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script>
    flatpickr(".datepicker", {
        dateFormat: "d-m-Y",
        defaultDate: "today",
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
                url: '/store_top/{{$id}}',
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
                        window.location.href = "/project/scopeHighLevel/" + data;
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
                $('#idtop' + i).val(data[i].id);
                $('#termsName' + i).val(data[i].termsName);
                $('#termsValue' + i).val(formatNumberr(data[i].termsValue));
                $('#bastDate' + i).val((data[i].bastDate).split("-").reverse().join("-"));
                $('#invDate' + i).val((data[i].invDate).split("-").reverse().join("-"));
                $('#payDate' + i).val((data[i].payDate).split("-").reverse().join("-"));
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
                newCell5.appendChild(childNodes[k].cloneNode(true));
            }

            flatpickr(".datepicker", {
                dateFormat: "d-m-Y",
            });
        }


        newCell5.addEventListener("click", function() {
            deleteRow(this);
        });
        cell5.addEventListener("click", function() {
            deleteRow(this);
        });

        $(".number-input").on("input", function() {
            formatNumber(this);
        });
    }

    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        var row = button.closest("tr");
        row.parentNode.removeChild(row);
    }
</script>
@endsection