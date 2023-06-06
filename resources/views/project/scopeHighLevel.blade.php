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
<div>
    <!-- row -->

    <div class="row">
        <div class="col-xxl-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Scope High Level</h4>
                    <span id="error-message"></span>
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
                                        <th style="width: 35%;">Scope Of Work</th>
                                        <th class="text-center" style="width: 20%;">Plan Start Date</th>
                                        <th class="text-center" style="width: 20%;">Plan End Date</th>
                                        <th class="text-center" style="width: 20%;">Progress %</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrder">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idScope[]" id="idScope0">
                                        </td>
                                        <td>
                                            <input type="text" name="scope[]" id="scope0">
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="planStart0" name="planStart[]" type="text" class="text-center datepicker" onchange="compareDates(this)" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="planEnd0" name="planEnd[]" type="text" class="text-center datepicker" onchange="compareDates(this)" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <input class="text-center" type="text" name="progProject[]" id="progProject0" onchange="addPercentage(this)">
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
                                <tfoot>
                                    <tr class="input-100">
                                        <td colspan="3" class="text-end fw-bold">OverAll Progress</td>
                                        <td><input class="text-center" type="text" name="overAllProg" id="overAllProg"></td>
                                    </tr>
                                </tfoot>
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

    function compareDates(input) {
        console.log((input.id).match(/\d+/g))
        // var id = (input.id).match(/\d+/g);
        // var dateInInput = input.id === "planStart0" ? input : document.getElementById('planStart' + id);
        // var dateEnfInput = input.id === "planEnd0" ? input : document.getElementById('planEnd' + id);

        // var dateIn = convertToDate(dateInInput.value);
        // var dateEnf = convertToDate(dateEnfInput.value);

        // if (dateIn.getTime() > dateEnf.getTime()) {
        //     alert("Tanggal Plan Start harus sebelum Tanggal Plan End.");
        // } else if (dateIn.getTime() < dateEnf.getTime()) {
        //     // Tanggal valid
        // } else {
        //     alert("Tanggal Plan Start dan Tanggal Plan End tidak boleh sama.");
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
                url: '/store_scopeHighLevel/{{$id}}',
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
                $('#idScope' + i).val(data[i].id);
                $('#scope' + i).val(data[i].scope);
                $('#planStart' + i).val((data[i].planStart).split("-").reverse().join("-"));
                $('#planEnd' + i).val((data[i].planEnd).split("-").reverse().join("-"));
                $('#progProject' + i).val(data[i].progProject + '%');
                $('#overAllProg').val('{{$overAllProg->overAllProg}}' + '%');
            }
        }

        //hitung overAll
        $('#detailOrder').on('input', '[id^="progProject"]', function() {

            var inputElements = document.querySelectorAll("input[id^='progProject']");
            var total = 0;

            inputElements.forEach(function(inputElement) {
                var inputValue = parseFloat((inputElement.value).replace("%", "").trim());
                total += inputValue;
            });

            if (inputElements.length !== 0) {
                var average = total / inputElements.length;
                $('#overAllProg').val(Math.round(average) + '%');
            } else {
                console.log("Tidak ada input yang ditemukan.");
            }

        })


    })
</script>
<script>
    function addRow() {
        var table = document.getElementById("detailOrder");
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
            if (j <= 4) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
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
        var inputElement = row.querySelector("input[name='idScope[]']");
        if (inputElement) {
            var id = inputElement.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_scopeHighLevel/' + id,
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
        var inputElements = document.querySelectorAll("input[id^='progProject']");
        var total = 0;

        inputElements.forEach(function(inputElement) {
            var inputValue = parseFloat((inputElement.value).replace("%", "").trim());
            total += inputValue;
        });

        if (inputElements.length !== 0) {
            var average = total / inputElements.length;
            $('#overAllProg').val(Math.round(average) + '%');
        } else {
            console.log("Tidak ada input yang ditemukan.");
        }
    }
</script>
@endsection