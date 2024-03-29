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

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-10 mb-3">
                                        <div class="row">
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Location</label>
                                                <select name="location" id="location" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($location as $locations)
                                                    <option value="{{$locations->id}}">{{$locations->location}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Level</label>
                                                <select name="levell" id="levell" class="select2" aria-label="Default select example">
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($skill as $skills)
                                                    <option value="{{$skills->id}}">{{$skills->skillLevel}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                                                <label class="form-label" for="selectOne">Role</label>
                                                <select name="role" id="role" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($role as $roles)
                                                    <option value="{{$roles->id}}">{{$roles->roleEmployee}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Direct Manager</label>
                                                <select name="directManager" id="directManager" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach(collect($employee)->sortBy('name') as $employe)
                                                    <option value="{{$employe->id}}">{{$employe->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Type Project</label>
                                                <select name="typeProject" id="typeProject" class="select2" aria-label="Default select example">
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($typeProject as $typeProjects)
                                                    <option value="{{$typeProjects->id}}">{{$typeProjects->typeProject}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" id="status" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    <option value="ACTIVE">ACTIVE</option>
                                                    <option value="RESIGN">RESIGN</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 mb-3">
                                        <div class="row">
                                            <div class="mb-3 pt-7 col-6">
                                                <form method="post" role="form" id="form-print" action="/ExportEmpUnassigned " enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                                    @csrf
                                                    <input type="text" id="locations" name="locations" hidden>
                                                    <input type="text" id="levells" name="levells" hidden>
                                                    <input type="text" id="divisi" name="divisi" hidden>
                                                    <input type="text" id="department" name="department" hidden>
                                                    <input type="text" id="rolee" name="rolee" hidden>
                                                    <input type="text" id="directManagerr" name="directManagerr" hidden>
                                                    <input type="text" id="typeProjectt" name="typeProjectt" hidden>
                                                    <input type="text" id="statuss" name="statuss" hidden>
                                                    <button id="export" type="submit" class="btn btn-success-soft" style="width:100%">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20">
                                                            <path fill="currentColor" d="M15.534 1.36L14.309 0H4.662c-.696 0-.965.516-.965.919v3.63H5.05V1.653c0-.154.13-.284.28-.284h6.903c.152 0 .228.027.228.152v4.82h4.913c.193 0 .268.1.268.246v11.77c0 .246-.1.283-.25.283H5.33a.287.287 0 0 1-.28-.284V17.28H3.706v1.695c-.018.6.302 1.025.956 1.025H18.06c.7 0 .939-.507.939-.969V5.187l-.35-.38l-3.116-3.446Zm-1.698.16l.387.434l2.596 2.853l.143.173h-2.653c-.2 0-.327-.033-.38-.1c-.053-.065-.084-.17-.093-.313V1.52Zm-1.09 9.147h4.577v1.334h-4.578v-1.334Zm0-2.666h4.577v1.333h-4.578V8Zm0 5.333h4.577v1.334h-4.578v-1.334ZM1 5.626v10.667h10.465V5.626H1Zm5.233 6.204l-.64.978h.64V14H3.016l2.334-3.51l-2.068-3.156H5.01L6.234 9.17l1.223-1.836h1.727L7.112 10.49L9.449 14H7.656l-1.423-2.17Z" />
                                                        </svg>
                                                    </button>
                                                </form>

                                            </div>
                                            <div class="mb-3 pt-7 col-6">
                                                <button id="clear" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Clear" class="btn btn-danger-soft" style="width:100%">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                        <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                                <th>Status</th>
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
                {
                    data: 'status',
                    name: 'status'
                }
            ],
            order: [
                [3, 'asc'],
                [4, 'asc'],
                [2, 'asc'],
            ]
        });
        $('#divisii, #departmentt, #directManager,#role,#typeProject,#status,#levell, #location').on('change', function() {
            $('#divisi').val($('#divisii').val());
            $('#department').val($('#departmentt').val());
            $('#directManagerr').val($('#directManager').val());
            $('#rolee').val($('#role').val());
            $('#statuss').val($('#status').val());
            $('#typeProjectt').val($('#typeProject').val());
            $('#levells').val($('#levell').val());
            $('#locations').val($('#location').val());

            $('#example1').data('dt_params', {
                'divisii': $('#divisii').val(),
                'departmentt': $('#departmentt').val(),
                'role': $('#role').val(),
                'directManager': $('#directManager').val(),
                'status': $('#status').val(),
                'typeProject': $('#typeProject').val(),
                'levell': $('#levells').val(),
                'location': $('#locations').val(),
            });
            $('#example1').DataTable().draw();
        });
    });
    $('.col-12').on('click', '#clear', function() {
        $('#divisii').val('#').trigger('change');
        $('#departmentt').val('#').trigger('change');
        $('#directManager').val('#').trigger('change');
        $('#role').val('#').trigger('change');
        $('#typeProject').val('#').trigger('change');
        $('#status').val('#').trigger('change');
        $('#levell').val('#').trigger('change');
        $('#location').val('#').trigger('change');

        $('#divisi').val('#');
        $('#department').val('#');
        $('#directManagerr').val('#');
        $('#rolee').val('#');
        $('#statuss').val('#');
        $('#typeProjectt').val('#');
        $('#levells').val('#');
        $('#locations').val('#');

        $('#example1').data('dt_params', {});
        $('#example1').DataTable().draw();
    });
</script>



@endsection