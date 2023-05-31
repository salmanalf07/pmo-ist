@extends('/project/navbarInput')

@section('inputan')
<style>
    .input-80 input {
        width: 80% !important;
    }

    .input-100 input {
        width: 100% !important;
        border: 1px solid grey;
        border-radius: 0.2rem;
        height: 2.4rem;
    }

    .input-100 td {
        padding: 0.5rem;
    }
</style>
<!-- custom select2 -->
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div>
    <!-- row -->

    <div class="row">
        <div class="col-xxl-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Project Member</h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-centered text-nowrap mb-0">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th style="width: 35%;">Name</th>
                                    <th style="width: 20%;">Role</th>
                                    <th style="width: 20%;">Dept/Div</th>
                                    <th style="width: 20%;">Competency</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody id="detailOrder">
                                <tr class="input-100">
                                    <td>
                                        <select name="customer" id="customer" class="select2" aria-label="Default select example">
                                            <option selected>Open this select menu</option>
                                            <option value="banking">Bangking</option>
                                            <option value="goverment">goverment</option>
                                            <option value="bumn">BUMN</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="role" id="role" class="select2" aria-label="Default select example">
                                            <option selected>Open this select menu</option>
                                            <option value="banking">Bangking</option>
                                            <option value="goverment">goverment</option>
                                            <option value="bumn">BUMN</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" readonly>
                                    </td>
                                    <td>
                                        <input type="text" readonly>
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
                <div class="card-footer  justify-content-between d-flex">
                    <button type="button" onclick="addRow()" class="btn btn-warning">Add Row</button>
                    <a href="#!" class="btn btn-primary">Save & Next</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    function addRow() {
        var table = document.getElementById("detailOrder");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");


        for (let j = 0; j <= 1; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);

            // Mengklon elemen select dari sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('select');
            var clonedSelect = selectElement.cloneNode(true);
            clonedSelect.id = (selectElement.id).replace(/\d+/g, '') + tableRange;

            // Menambahkan elemen select yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            newCell5.appendChild(clonedSelect);

            // Menghapus Select2 dari elemen select yang dikloning (jika sudah ada)
            if ($(clonedSelect).hasClass('select2-hidden-accessible')) {
                $(clonedSelect).select2('destroy');
            }

            // Mengaktifkan kembali Select2 pada elemen select yang baru
            $(clonedSelect).select2();

            // Menyalin nilai yang dipilih dari elemen asli ke elemen yang dikloning
            var selectedOptions = Array.from(selectElement.selectedOptions);
            selectedOptions.forEach(option => {
                $(clonedSelect).find(`option[value="${option.value}"]`).prop('selected', true);
            });
        }

        // Mengaktifkan kembali Select2 pada semua elemen select setelah pengklonan
        $('select').select2();

        for (let j = 2; j <= 4; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;

            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                newCell5.appendChild(childNodes[k].cloneNode(true));
            }

            if (j == 4) {
                cell5.addEventListener("click", function() {
                    deleteRow(this);
                });
                newCell5.addEventListener("click", function() {
                    deleteRow(this);
                });
            }
        }
    }

    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        var row = button.closest("tr");
        row.parentNode.removeChild(row);
    }
</script>
@endsection