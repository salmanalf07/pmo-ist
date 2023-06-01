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
                    <h4 class="mb-0">Scope High Level</h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-centered text-nowrap mb-0">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th style="width: 35%;">Scope Of Work</th>
                                    <th style="width: 20%;">Plan Start Date</th>
                                    <th style="width: 20%;">Plan End Date</th>
                                    <th style="width: 20%;">Progress %</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody id="detailOrder">
                                <tr class="input-100">
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td>
                                        <div class="input-group me-3">
                                            <input id="pkwt_end" name="pkwt_end" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group me-3">
                                            <input id="pkwt_end" name="pkwt_end" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                        </div>
                                    </td>
                                    <td><input type="text"></td>
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
                <div class="card-footer  justify-content-between d-flex">
                    <button type="button" onclick="addRow()" class="btn btn-warning">Add Row</button>
                    <a href="#!" class="btn btn-primary">Save & Next</a>
                </div>
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
    function addRow() {
        var table = document.getElementById("detailOrder");
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let i = 0; i <= 0; i++) {
            var cell = row.insertCell(i)
            var newInput = document.createElement("input"); // Membuat elemen input baru
            newInput.type = "text"; // Mengatur tipe input menjadi teks
            if (i >= "1") {
                newInput.className = "number-input";
            }
            (cell).appendChild(newInput);
        }

        for (let j = 1; j <= 4; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;

            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                newCell5.appendChild(childNodes[k].cloneNode(true));
            }

            flatpickr(".datepicker", {
                dateFormat: "d-m-Y",
                defaultDate: "today",
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