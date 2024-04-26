@extends('/project/navbarInput')

@section('inputan')
<style>
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

    .input-total {
        width: 50%;
        line-height: normal;
        border: 0;
        color: var(--dashui-body-color)
    }
</style>
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
                        <h4 class="mb-0">Detail Order</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 30%;">Item</th>
                                        <th style="width: 10%;">Category</th>
                                        <th class="text-center" style="width: 10%;">Quantity</th>
                                        <th class="text-center" style="width: 10%;">Unit</th>
                                        <th class="text-end" style="width: 10%;">Rev</th>
                                        <th class="text-end" style="width: 15%;">COGS</th>
                                        <th class="text-center" style="width: 10%;">GP %</th>
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
                                        <td>
                                            <select name="categoryId[]" id="categoryId0" class="select2" aria-label="Default select example">
                                                <option value="#" selected>Open this select menu</option>
                                                @foreach($categoryOrder as $categorys)
                                                <option value="{{$categorys->id}}">{{$categorys->category}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input name="qty[]" id="qty0" type="text" class="text-center">
                                        </td>
                                        <td>
                                            <input name="unit[]" id="unit0" type="text">
                                        </td>
                                        <td><input name="rev[]" id="rev0" placeholder="0" type="text" class="number-input text-end"></td>
                                        <td>
                                            <input name="cogs[]" id="cogs0" placeholder="0" type="text" class="number-input text-end">
                                        </td>
                                        <td><input name="gp[]" id="gp0" type="text" class="number-input text-center"></td>
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
                    @canany(['bisa-tambah','detailOrder-editor'])
                    <div class="card-footer  justify-content-between">
                        <button type="button" onclick="addRow()" class="btn btn-warning-soft">Add Row</button>
                        <button type="button" class="btn btn-primary-soft add"> Save</button>
                    </div>
                    @endcanany

                </div>
            </div>
            <div class="col-xxl-8 col-12">
            </div>
            <div class="col-xxl-4 col-12">
                <div class="card mb-4 mt-4 mt-xxl-0">
                    <div class="card-body pb-2">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between mb-3">
                                <span>Total Rev :</span>
                                <input name="subTotalRev" id="subTotalRev" class="text-end input-total" type="text" value="0" readonly>

                            </li>
                            <li class="d-flex justify-content-between mb-3">
                                <span>Total COGS :</span>
                                <input name="subTotalCogs" id="subTotalCogs" class="text-end input-total" type="text" value="0" readonly>
                            </li>

                        </ul>
                    </div>
                    <div class="card-footer">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between mb-3">
                                <span>Total GP </span>
                                <input name="subTotalGp" id="subTotalGp" class="text-end input-total fw-bold" type="text" value="0" readonly>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-dark">Total GP %</span>
                                <input name="totalGpp" id="totalGpp" class="text-end input-total fw-bold" type="text" value="0" readonly>
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
    $(document).ready(function() {
        $('.select2').select2();
    });
    $(function() {
        //add data
        $('.card-footer').on('click', '.add', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);

            // Hitung total nilai
            // if (parseFloat($('#subTotalRev').val().replaceAll(".", "")) != '{{$projectValue}}') {
            //     alert('Total rev tidak  sesuai dengan project value');
            // } else {
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
                        window.location.href = "/project/detailOrder/" + data[0].projectId;
                    }

                },
            });
            // }
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
            $('#totalGpp').val('{{ isset($data) ? $data->totalGpp : "" }}' + '%');
            for (let j = 0; j < (data.detail_order.length - 1); j++) {
                addRow();
            }

            for (var i = 0; i < data.detail_order.length; i++) {
                $('#idor' + i).val(data.detail_order[i].id);
                $('#item' + i).val(data.detail_order[i].item);
                $('#categoryId' + i).val(data.detail_order[i].categoryId).trigger('change');
                $('#qty' + i).val(data.detail_order[i].qty);
                $('#unit' + i).val(data.detail_order[i].unit);
                $('#rev' + i).val(formatNumberr(data.detail_order[i].rev)).change();
                $('#cogs' + i).val(formatNumberr(data.detail_order[i].cogs));
                $('#gp' + i).val(data.detail_order[i].gp + '%');
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

        for (let j = 0; j <= 1; j++) {
            var cell5 = lastRow.cells[j];
            var selectElement = cell5.querySelector('input');
            var newCell5 = row.insertCell(j);
            var clonedContent = cell5.cloneNode(true);
            clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            if (j == 0) {
                newCell5.style.display = "none";
            }
            for (var k = 0; k < clonedContent.childNodes.length; k++) {
                var clonedNode = clonedContent.childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);
                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = "";
                }
            }
        }
        // Code for cloning elements in columns 1 to 3 (indexes 1 to 3)
        for (let j = 2; j <= 2; j++) {
            var cell5 = lastRow.cells[j];
            var newCell5 = row.insertCell(j);
            var selectElement = cell5.querySelector('select');
            var clonedSelect = selectElement.cloneNode(true);
            clonedSelect.id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            newCell5.appendChild(clonedSelect);
            if ($(clonedSelect).hasClass('select2-hidden-accessible')) {
                $(clonedSelect).select2('destroy');
            }
            $(clonedSelect).select2();
            var selectedOptions = Array.from(selectElement.selectedOptions);
            selectedOptions.forEach(option => {
                $(clonedSelect).find(`option[value="#"]`).prop('selected', true);
                clonedNode.addEventListener("change", function() {
                    search_div(this);
                });
            });
        }

        for (let j = 3; j <= 8; j++) {
            var cell5 = lastRow.cells[j];
            var newCell5 = row.insertCell(j);
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 3 || j == 4 || j == 5 || j == 6 || j == 7) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);
                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = "";
                    clonedNode.addEventListener("change", function() {
                        compareDates(this);
                    });
                }
            }
        }

        // Re-enable Select2 for all elements with class 'select2'
        $('.select2').select2();


        $(".number-input").on("input", function() {
            formatNumber(this);
        });
    }

    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        var row = button.closest("tr");
        var inputElement = row.querySelector("input[name='idor[]']");
        if (inputElement.value) {
            var id = inputElement.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_detailOrder/' + id,
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
            $('#gp' + index).val(Math.round(gp) + '%');
            findTotal('#rev', '#subTotalRev');
            findTotal('#cogs', '#subTotalCogs');

            var SubTotalGp = parseFloat($('#subTotalRev').val().replace(/\./g, "")) - parseFloat($('#subTotalCogs').val().replace(/\./g, ""))
            $('#subTotalGp').val(formatNumberr(SubTotalGp));
            var totalGpp = ((parseFloat($('#subTotalRev').val().replace(/\./g, "")) - parseFloat($('#subTotalCogs').val().replace(/\./g, ""))) / parseFloat($('#subTotalRev').val().replace(/\./g, ""))) * 100
            $('#totalGpp').val(Math.round(totalGpp) + '%');
            // console.log(gp);
        });
    });

    function hitung2() {
        findTotal('#rev', '#subTotalRev');
        findTotal('#cogs', '#subTotalCogs');

        var SubTotalGp = parseFloat($('#subTotalRev').val().replace(/\./g, "")) - parseFloat($('#subTotalCogs').val().replace(/\./g, ""))
        $('#subTotalGp').val(formatNumberr(SubTotalGp));
        var totalGpp = ((parseFloat($('#subTotalRev').val().replace(/\./g, "")) - parseFloat($('#subTotalCogs').val().replace(/\./g, ""))) / parseFloat($('#subTotalRev').val().replace(/\./g, ""))) * 100
        $('#totalGpp').val(Math.round(totalGpp) + '%');
    }

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