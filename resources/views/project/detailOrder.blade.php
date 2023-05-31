@extends('/project/navbarInput')

@section('inputan')
<style>
    .input-100 input {
        width: 100% !important;
        border: 1px solid grey;
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
                                    <td>
                                        <input type="text">
                                    </td>
                                    <td><input type="text" class="number-input"></td>
                                    <td>
                                        <input type="text" class="number-input">
                                    </td>
                                    <td><input type="text" class="number-input"></td>
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
        <div class="col-xxl-3 col-12">
            <div class="card mb-4 mt-4 mt-xxl-0">
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between mb-3">
                            <span>Sub Total :</span>
                            <span>$340.00</span>

                        </li>
                        <li class="d-flex justify-content-between mb-3">
                            <span>PPN : </span>
                            <span class="text-success">-$51.00</span>

                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between">
                            <span class="text-dark">Total</span>
                            <span class="text-primary ">$368.00</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    function addRow() {
        var table = document.getElementById("detailOrder");
        var lastRow = table.rows[table.rows.length - 1];
        var cell4 = lastRow.cells[4]; // Mengambil sel keempat (cell 4)

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let i = 0; i <= 3; i++) {
            var cell = row.insertCell(i)
            var newInput = document.createElement("input"); // Membuat elemen input baru
            newInput.type = "text"; // Mengatur tipe input menjadi teks
            if (i >= "1") {
                newInput.className = "number-input";
            }
            (cell).appendChild(newInput);
        }

        var newCell4 = row.insertCell(4);
        // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
        var clonedContent = cell4.cloneNode(true);
        var childNodes = clonedContent.childNodes;

        // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
        for (var i = 0; i < childNodes.length; i++) {
            newCell4.appendChild(childNodes[i].cloneNode(true));
        }
        newCell4.addEventListener("click", function() {
            deleteRow(this);
        });
        cell4.addEventListener("click", function() {
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