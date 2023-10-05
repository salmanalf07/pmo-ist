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
                                    <tr>
                                        <th style="width: 25%;">Name TOP</th>
                                        <th class="text-center" style="width: 13%;">Value</th>
                                        <th class="text-center" style="width: 13%;">Plan BAST</th>
                                        <th class="text-center" style="width: 13%;">Invoice Date</th>
                                        <th class="text-center" style="width: 13%;">Payment Date</th>
                                        <th class="text-center" style="width: 18%;">Remarks</th>
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
                                            <input style="width: 84% !important;" id="bastDate0" name="bastDate[]" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            <input type="hidden" class="hideng" id="bastMain0" name="bastMain[]" value="0">
                                            <input class="form-check-inputt" style="width: 1.35rem !important;" type="checkbox" id="bastMain0" name="bastMain[]" onclick="toggleCheckbox(this)" title="Main BAST">
                                        </td>
                                        <td>
                                            <div>
                                                <input style="width: 84% !important;" id="invDate0" name="invDate[]" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                                <input type="hidden" class="hideng" id="invMain0" name="invMain[]" value="0">
                                                <input class="form-check-inputt" style="width: 1.35rem !important;" type="checkbox" id="invMain0" name="invMain[]" onclick="toggleCheckbox(this)" title="Main Invoice">
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input style="width: 84% !important;" id="payDate0" name="payDate[]" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                                <input type="hidden" class="hideng" id="payMain0" name="payMain[]" value="0">
                                                <input class="form-check-inputt" style="width: 1.35rem !important;" type="checkbox" id="payMain0" name="payMain[]" onclick="toggleCheckbox(this)" title="Main Payment">
                                            </div>
                                        </td>
                                        <td>
                                            <input id="remaks0" name="remaks[]" type="text">
                                        </td>
                                        <td>
                                            @canany(['bisa-hapus','top-editor'])
                                            <a href="#!" onclick="deleteRow(this)" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashOne">
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
                                @canany(['bisa-tambah','top-editor'])
                                <button type="button" onclick="addRow()" class="btn btn-warning-soft">Add Row</button>
                                <button type="button" class="btn btn-primary-soft add"> Save</button>
                                @endcanany
                            </div>
                            <div class="col-3">
                                <input class="text-end" id="totInvoiced" type="text" placeholder="Total Invoiced" readonly>
                            </div>
                            <div class="col-3">
                                <input class="text-end" id="totPayment" type="text" placeholder="Total Payment" readonly>
                            </div>
                        </div>
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
        defaultDate: "01-01-1900",
        allowInput: true, // Mengizinkan input manual
    });
</script>
<script>
    $(function() {
        //add data
        $('.card-footer').on('click', '.add', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            var totalValue = 0;

            // Hitung total nilai
            $('input[name^="termsValue\[\]"]').each(function() {
                var value = parseFloat($(this).val().replaceAll(".", ""));
                if (!isNaN(value)) {
                    totalValue += value;
                }
            });
            // if (totalValue != '{{$projectValue}}') {
            //     alert('Total terms value tidak  sesuai dengan project value');
            // } else {
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
                        window.location.href = "/project/top/" + data;
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
            $('#id').val('{{ isset($data) ? $id : "" }}');
            for (let j = 0; j < ('{{count($data)}}' - 1); j++) {
                addRow();
            }

            for (var i = 0; i < '{{count($data)}}'; i++) {
                $('#idtop' + i).val(data[i].id);
                $('#termsName' + i).val(data[i].termsName);
                $('#termsValue' + i).val(formatNumberr(data[i].termsValue));
                $('#bastDate' + i).val((data[i].bastDate).split("-").reverse().join("-"));
                if (data[i].bastMain != 0) {
                    $(".form-check-inputt#bastMain" + i).trigger('click');
                }
                $('#invDate' + i).val((data[i].invDate).split("-").reverse().join("-"));
                if (data[i].invMain != 0) {
                    $(".form-check-inputt#invMain" + i).trigger('click');
                }
                $('#payDate' + i).val((data[i].payDate).split("-").reverse().join("-"));
                if (data[i].payMain != 0) {
                    $(".form-check-inputt#payMain" + i).trigger('click');
                }
                $('#remaks' + i).val(data[i].remaks);
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

        for (let j = 0; j <= 7; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 0) {
                newCell5.style.display = "none";
            }
            if (j <= 6) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            if (j == 3 || j == 4 || j == 5) {
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

            if (clonedContent.querySelector('input.form-check-inputt')) {
                $('.form-check-inputt#' + clonedContent.querySelector('input.form-check-inputt').id).prop("checked", false);
            }
            if (clonedContent.querySelector('input.datepicker')) {
                flatpickr("#" + clonedContent.querySelector('input.datepicker').id, {
                    dateFormat: "d-m-Y",
                    defaultDate: "01-01-1900",
                    allowInput: true, // Mengizinkan input manual
                });
            }
        }


        newCell5.addEventListener("click", function() {
            deleteRow(this);
        });
        // cell5.addEventListener("click", function() {
        //     deleteRow(this);
        // });

        $(".number-input").on("input", function() {
            formatNumber(this);
        });
    }

    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        var row = button.closest("tr");
        var inputElement = row.querySelector("input[name='idtop[]']");
        if (inputElement && inputElement.value) {
            var id = inputElement.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_top/' + id,
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
    }

    function toggleCheckbox(button) {
        if (button.checked) {
            button.value = 1;
            $('.hideng#' + button.id).prop('disabled', true);
            //console.log("Checkbox checked " + button.id + "+" + button.value);

            if ((button.id).replace(/[0-9]/g, '') == "invMain") {
                findTotal('#termsValue', '#invMain', '#totInvoiced');
            }
            if ((button.id).replace(/[0-9]/g, '') == "payMain") {
                findTotal('#termsValue', '#payMain', '#totPayment');
            }

        } else {
            $('.hideng#' + button.id).prop('disabled', false);
            button.value = 0;
            if ((button.id).replace(/[0-9]/g, '') == "invMain") {
                findTotal('#termsValue', '#invMain', '#totInvoiced');
            }
            if ((button.id).replace(/[0-9]/g, '') == "payMain") {
                findTotal('#termsValue', '#payMain', '#totPayment');
            }
        }
    }

    function findTotal(tablee, search, to) {
        //var arr = document.getElementsByName('total_price[]');
        var table = document.getElementById('detailOrder');
        var rowCount = table.rows.length;
        //console.log(rowCount);
        var tot = 0;
        for (var i = 0; i < rowCount; i++) {
            if (parseFloat($(tablee + i).val()) && $('.form-check-inputt' + search + i).val() == 1) {
                var total_p = $(tablee + i).val().replaceAll(".", "");
                //console.log(total_p);
                tot += parseFloat(total_p);
            }
            // console.log($('.form-check-inputt' + search + i).val());
        }
        $(to).val(formatNumberr(tot));
    }
</script>
@endsection