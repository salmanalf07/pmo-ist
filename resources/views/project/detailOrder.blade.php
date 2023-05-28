@extends('/project/navbarInput')

@section('inputan')
<style>
    .input-80 td {
        padding: 5px;
    }

    .input-80 input {
        width: 100% !important;
    }

    .input-100 td {
        padding: 0;
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
    }

    .input-100 input {
        width: 100% !important;
    }
</style>
<div>
    <!-- row -->

    <div class="row">
        <div class="col-lg-12 col-12">
            <!-- card -->
            <div class="card mb-4">
                <!-- card body -->
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <!-- cpation on top -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 5% !important;" scope="col">No</th>
                                        <th style="width: 35% !important;" scope="col">Item</th>
                                        <th style="width: 20% !important;" scope="col">Rev</th>
                                        <th style="width: 20% !important;" scope="col">COGS</th>
                                        <th style="width: 20% !important;" scope="col">GP %</th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrder">
                                    <tr class="input-100">
                                        <td class="text-center">1</td>
                                        <td><input type="text"></td>
                                        <td><input type="text" class="number-input"></td>
                                        <td><input type="text" class="number-input"></td>
                                        <td><input type="text" class="number-input"></td>
                                    </tr>
                                </tbody>
                                <tfoot class="input-80">
                                    <tr>
                                        <th colspan="2" class="text-end">Sub Total</th>
                                        <td><input type="text" readonly></td>
                                        <td><input type="text" readonly></td>
                                        <td><input type="text" readonly></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-end">PPN</th>
                                        <td><input type="text" readonly></td>
                                        <td><input type="text" readonly></td>
                                        <td><input type="text" readonly></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-end">Total</th>
                                        <td><input type="text" readonly></td>
                                        <td><input type="text" readonly></td>
                                        <td><input type="text" readonly></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="mb-3 col-1" style="width: 10%;">
                                <button type="button" onclick="addRow()" class="btn btn-warning">Add Row</button>
                            </div>
                            <div class="mb-3 col-1" style="width: 12%;">
                                <button type="button" onclick="removeRow()" class="btn btn-danger">Remove Row</button>
                            </div>
                            <div class="mb-3 col-1" style="width: 15%;">
                                <button type="submit" class="btn btn-primary"> Save & Next</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    function addRow() {
        var table = document.getElementById("detailOrder");
        var lastRow = table.rows[table.rows.length - 1]; // Mendapatkan row terakhir
        var cell1Last = lastRow.cells[0]; // Mengambil sel pertama pada row terakhir
        var newData = parseInt(cell1Last.innerHTML); // Mengambil data dari sel pertama dan mengubahnya ke tipe integer
        var result = newData + 1;

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");
        var cell0 = row.insertCell(0);
        cell0.innerHTML = result;
        cell0.classList.add("text-center");

        for (let i = 1; i <= 4; i++) {
            var cell = row.insertCell(i)
            var newInput = document.createElement("input"); // Membuat elemen input baru
            newInput.type = "text"; // Mengatur tipe input menjadi teks
            if (i >= "2") {
                newInput.className = "number-input";
            }
            (cell).appendChild(newInput);
        }
        $(".number-input").on("input", function() {
            formatNumber(this);
        });
    }

    function removeRow() {
        var table = document.getElementById("detailOrder");
        var lastRowIndex = table.rows.length - 1;

        if (lastRowIndex > 0) {
            table.deleteRow(lastRowIndex);
        }
    }
</script>
@endsection