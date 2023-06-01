@extends('/project/navbarInput')

@section('inputan')
<style>
    .input-100 input {
        width: 100% !important;
        border: var(--dashui-border-width) solid var(--dashui-input-border);
        border-radius: 0.2rem;
        height: 2rem;
    }

    .input-100 td {
        padding: 0.5rem;
    }

    .input-total {
        width: 50%;
        line-height: normal;
        border: 0;
        color: var(--dashui-body-color)
    }
</style>
<div>
    <!-- row -->

    <form method="post" role="form" id="form-add" enctype="multipart/form-data">
        <div class="row">
            @csrf
            <span id="peringatan"></span>
            <input class="form-control" type="text" name="id" id="id" hidden>
            <div class="col-xxl-9 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Detail Order</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th style="width: 35%;">Item</th>
                                        <th style="width: 20%;">Rev</th>
                                        <th style="width: 20%;">COGS</th>
                                        <th style="width: 20%;">GP %</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrder">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input name="idor[]" id="idor0">
                                        </td>
                                        <td>
                                            <input name="item[]" id="item0" type="text">
                                        </td>
                                        <td><input name="rev[]" id="rev0" placeholder="0" type="text" class="number-input text-end"></td>
                                        <td>
                                            <input name="cogs[]" id="cogs0" placeholder="0" type="text" class="number-input text-end">
                                        </td>
                                        <td><input name="gp[]" id="gp0" type="text" class="number-input text-end"></td>
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
                </div>
            </div>
            <div class="col-xxl-3 col-12">
                <div class="card mb-4 mt-4 mt-xxl-0">
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between mb-3">
                                <span>Sub Total Rev :</span>
                                <input name="subTotalRev" id="subTotalRev" class="text-end input-total" type="text" value="0" readonly>

                            </li>
                            <li class="d-flex justify-content-between mb-3">
                                <span>Sub Total COGS :</span>
                                <input name="subTotalCogs" id="subTotalCogs" class="text-end input-total" type="text" value="0" readonly>
                            </li>
                            <li class="d-flex justify-content-between mb-3">
                                <span>Sub Total GP % :</span>
                                <input name="subTotalGp" id="subTotalGp" class="text-end input-total" type="text" value="0" readonly>

                            </li>

                        </ul>
                    </div>
                    <div class="card-footer">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between">
                                <span class="text-dark">Total</span>
                                <input name="grandTotal" id="grandTotal" class="text-end input-total fw-bold" type="text" value="0" readonly>
                            </li>
                        </ul>
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
        $('.card-footer').on('click', '.add', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '/store_detailOrder/{{$id}}',
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
                        window.location.href = "/project/top/" + data[0].projectId;
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
            $('#id').val('{{ isset($data) ? $data->id : "" }}');
            $('#subTotalRev').val(formatNumberr('{{ isset($data) ? $data->subTotalRev : "" }}'));
            $('#subTotalCogs').val(formatNumberr('{{ isset($data) ? $data->subTotalCogs : "" }}'));
            $('#subTotalGp').val(formatNumberr('{{ isset($data) ? $data->subTotalGp : "" }}'));
            $('#grandTotal').val(formatNumberr('{{ isset($data) ? $data->grandTotal : "" }}'));
            for (let j = 0; j < (data.detail_order.length - 1); j++) {
                addRow();
            }

            for (var i = 0; i < data.detail_order.length; i++) {
                $('#idor' + i).val(data.detail_order[i].id);
                $('#item' + i).val(data.detail_order[i].item);
                $('#rev' + i).val(formatNumberr(data.detail_order[i].rev));
                $('#cogs' + i).val(formatNumberr(data.detail_order[i].cogs));
                $('#gp' + i).val(data.detail_order[i].gp);
            }
        }
    })
</script>
<script>
    function addRow() {
        var table = document.getElementById("detailOrder");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];
        var cell4 = lastRow.cells[5]; // Mengambil sel keempat (cell 4)

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 5; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            if (j == 0) {
                newCell5.style.display = "none";
            }
            if (j <= 4) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            var childNodes = clonedContent.childNodes;

            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                newCell5.appendChild(childNodes[k].cloneNode(true));
            }
            if (j == 5) {
                cell5.addEventListener("click", function() {
                    deleteRow(this);
                });
                newCell5.addEventListener("click", function() {
                    deleteRow(this);
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
        row.parentNode.removeChild(row);
    }

    $(document).ready(function() {
        // Event listener ketika input rev[] atau cogs[] berubah
        $('#detailOrder').on('input', '[id^="rev"], [id^="cogs"]', function() {
            var inputId = $(this).attr('id'); // Mendapatkan ID input yang sedang berubah
            var index = inputId.match(/\d+/)[0]; // Mengambil nomor indeks dari ID input

            // Mengambil nilai dari input rev[] dan cogs[] dengan ID yang sesuai
            var revString = $('#rev' + index + '[type="text"]').val();
            var cogsString = $('#cogs' + index + '[type="text"]').val();

            // Mengganti format angka revString dan cogsString
            var rev = parseFloat(revString.replace(/\./g, ""));
            var cogs = parseFloat(cogsString.replace(/\./g, ""));

            // Melakukan perhitungan gross profit (rev - cogs)
            var gp = ((rev - cogs) / rev) * 100;

            // Menampilkan hasil perhitungan di input gp[] dengan ID yang sesuai
            $('#gp' + index).val(Math.round(gp));
            findTotal('#rev', '#subTotalRev');
            findTotal('#cogs', '#subTotalCogs');

            var SubTotalGp = parseFloat($('#subTotalRev').val().replace(/\./g, "")) - parseFloat($('#subTotalCogs').val().replace(/\./g, ""))
            $('#subTotalGp').val(formatNumberr(SubTotalGp));
            var GrandTotal = parseFloat($('#subTotalRev').val().replace(/\./g, "")) + parseFloat($('#subTotalCogs').val().replace(/\./g, ""))
            $('#grandTotal').val(formatNumberr(GrandTotal));
        });
    });

    function findTotal(tablee, to) {
        //var arr = document.getElementsByName('total_price[]');
        var table = document.getElementById('detailOrder');
        var rowCount = table.rows.length;
        //console.log(rowCount);
        var tot = 0;
        for (var i = 0; i < rowCount; i++) {
            if (parseFloat($(tablee + i).val())) {
                var total_p = $(tablee + i).val().replaceAll(".", "");
                //console.log(total_p);
                tot += parseFloat(total_p);
            }
        }
        $(to).val(formatNumberr(tot));
    }
</script>
@endsection