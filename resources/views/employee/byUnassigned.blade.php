@extends('index')

@section('konten')
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div id="app-content">
    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div>
                <!-- row -->
                <div class="row mb-3">
                    <div class="col-12 mb-3">
                        <form method="post" role="form" id="form-filter" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-3">
                                            <label class="form-label" for="selectOne">Division</label>
                                            <select name="divisii" id="divisii" class="select2" aria-label="Default select example" required>
                                                <option value="#" selected>Open this select menu</option>
                                                @foreach($divisi as $divDept)
                                                <option value="{{$divDept->id}}">{{$divDept->division}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <label class="form-label" for="selectOne">Department </label>
                                            <select name="departmentt" id="departmentt" class="select2" aria-label="Default select example" required>
                                                <option value="#" selected>Open this select menu</option>
                                                @foreach($department as $depart)
                                                <option value="{{$depart->id}}">{{$depart->department}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <label class="form-label">Direct Manager</label>
                                            <select name="directManager" id="directManager" class="select2" aria-label="Default select example" required>
                                                <option value="#" selected>Open this select menu</option>
                                                @foreach($employee as $employe)
                                                <option value="{{$employe->id}}">{{$employe->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 pt-7 col-3">
                                            <button id="clear" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Clear" class="btn btn-danger-soft" style="width:100%">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                    <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-md-flex border-bottom-0">
                                <div class="flex-grow-1">

                                </div>
                                <div class="justify-content-end">
                                    <p>Employee - {{$judul}}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table id="example1" class="table text-nowrap table-centered mt-0" style="width: 100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th>
                                                    No
                                                </th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Division</th>
                                                <th>Direct Manager</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- flatpickr -->
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    flatpickr("#dateEnd", {
        dateFormat: "d-m-Y",
        defaultDate: "01-01-1990",
    });

    $(document).ready(function() {
        $('select.select2:not(.normal)').each(function() {
            $(this).select2({
                dropdownParent: $(this).parent().parent()
            });
        });
    });
</script>
<script>
    $(function() {

        var oTable = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"bottom"pi>',
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": false,
            "columnDefs": [{
                "className": "text-center",
                "targets": [0, 5], // table ke 1
            }, ],
            ajax: {
                url: '{{ url("json_ByUnassigned") }}',
                data: function(d) {
                    // Retrieve dynamic parameters
                    var dt_params = $('#example1').data('dt_params');
                    // Add dynamic parameters to the data object sent to the server
                    if (dt_params) {
                        $.extend(d, dt_params);
                    }
                }
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'employee_id',
                    name: 'employee_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: function(row) {
                        if (row.department && row.department.department) {
                            return row.department.department; // Mengembalikan nilai properti name jika ada
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'department.department'
                },
                {
                    data: function(row) {
                        if (row.divisi && row.divisi.division) {
                            return row.divisi.division; // Mengembalikan nilai properti name jika ada
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'divisi.division'
                },
                {
                    data: function(row) {
                        if (row.manager && row.manager.name) {
                            return row.manager.name; // Mengembalikan nilai properti name jika ada
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'manager.name'
                },
            ],
            order: [
                [3, 'asc'],
                [4, 'asc'],
                [2, 'asc'],
            ]
        });
        $('#divisii, #departmentt, #directManager').on('change', function() {
            $('#example1').data('dt_params', {
                'divisii': $('#divisii').val(),
                'departmentt': $('#departmentt').val(),
                'directManager': $('#directManager').val(),
            });
            $('#example1').DataTable().draw();
        });
    });
    $('.col-12').on('click', '#clear', function() {
        $('#divisii').val('#').trigger('change');
        $('#departmentt').val('#').trigger('change');
        $('#directManager').val('#').trigger('change');
        $('#example1').data('dt_params', {});
        $('#example1').DataTable().draw();
    });
</script>



@endsection