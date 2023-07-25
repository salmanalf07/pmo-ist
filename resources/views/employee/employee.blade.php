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
                                    <button id="adddata" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">Add New</button>
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
                                                <th>Action</th>
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
<!-- Offcanvas -->
<div class="modal fade gd-example-modal-lg" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="reset_form()">

                </button>
            </div>
            <!-- card body -->
            <div class="modal-body">
                <!-- form -->
                <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                    <div class="row">
                        <!-- form group -->
                        @csrf
                        <span id="peringatan"></span>
                        <input class="form-control" type="text" name="id" id="id" hidden>
                        <div class="mb-3 col-12">
                            <h4>Employee</h4>
                        </div>
                        <div class="mb-3 col-8">
                            <label class="form-label">Employee ID <span class="text-danger">*</span></label>
                            <input name="employee_id" id="employee_id" type="text" class="form-control" placeholder="Enter Here">
                        </div>
                        <div class="form-check form-switch mb-3 col-4" style="padding-top: 2.5rem;padding-left: 4rem !important;">
                            <input class="form-check-input" type="checkbox" role="switch" id="typeEmployee" name="typeEmployee" onclick="toggleCheckbox(this)" value="0">
                            <label class="form-check-label" for="typeEmployee">Type Employee</label>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Company</label>
                            <input name="company" id="company" type="text" class="form-control" placeholder="Enter Here" value="PT Infosys Solusi Terpadu" readonly>
                        </div>
                        <div class="mb-3 col-6"></div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Employee Name <span class="text-danger">*</span></label>
                            <input name="name" id="name" type="text" class="form-control" placeholder="Enter Here" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Division</label>
                            <select name="divisi" id="divisi" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                                @foreach($divisi as $divisi)
                                <option value="{{$divisi->id}}">{{$divisi->division}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Department</label>
                            <select name="department" id="department" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                                @foreach($department as $department)
                                <option value="{{$department->id}}">{{$department->department}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Direct Manager</label>
                            <select name="direct_manager" id="direct_manager" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                                @foreach($employee as $employee)
                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                        </div>
                        <div class="mb-3 col-12">
                            <hr>
                        </div>
                        <div class="mb-3 col-12">
                            <h4>Location</h4>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Employment Location </label>
                            <select name="penempatan" id="penempatan" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                                @foreach($location as $location)
                                <option value="{{$location->id}}">{{$location->location}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                        </div>
                        <div class="mb-3 col-12">
                            <hr>
                        </div>
                        <div class="mb-3 col-12">
                            <h4>Technical Skill</h4>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Technical Specialization</label>
                            <select name="spesialisasi" id="spesialisasi" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                                @foreach($specialization as $specialization)
                                <option value="{{$specialization->id}}">{{$specialization->specialization}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Role</label>
                            <select name="role" id="role" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                                @foreach($role as $role)
                                <option value="{{$role->id}}">{{$role->roleEmployee}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Skill Level</label>
                            <select name="level" id="level" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                                @foreach($skill as $skill)
                                <option value="{{$skill->id}}">{{$skill->skillLevel}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Rate</label>
                            <input name="rate" id="rate" type="text" class="form-control" placeholder="Enter Here">
                        </div>
                        <div class="mb-5 col-12"></div>
                        <!-- button -->
                        <div class="col-12">
                            <button id="in" class="btn btn-primary" type="button">Submit</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="modal" aria-label="Close" onclick="reset_form()">Close</button>
                        </div>
                    </div>
                </form>

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
                url: '{{ url("json_employee") }}',
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
                    data: 'aksi',
                    name: 'aksi'
                }
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

    //button add
    $(document).on('click', '#adddata', function() {
        $("#in").removeClass("btn btn-primary update");
        $("#in").addClass("btn btn-primary add");
    });
    $('.col-12').on('click', '#clear', function() {
        $('#divisii').val('#').trigger('change');
        $('#departmentt').val('#').trigger('change');
        $('#directManager').val('#').trigger('change');
        $('#example1').data('dt_params', {});
        $('#example1').DataTable().draw();
    });

    //add data
    $('.col-12').on('click', '.add', function() {
        var form = document.getElementById("form-add");
        var fd = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '{{ url("store_employee") }}',
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
                    $('#taskModal').modal('hide');
                    document.getElementById("form-add").reset();
                    $('#example1').DataTable().ajax.reload();
                }

            },
        });
    });
    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        var uid = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'edit_employee',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data);

                //isi form
                $('#id').val(data.id);
                $('#employee_id').val(data.employee_id);
                $('#name').val(data.name);
                $('#level').val(data.level).trigger('change');
                $('#divisi').val(data.divisi.id).trigger('change');
                $('#company').val(data.company).trigger('change');
                $('#department').val(data.department).trigger('change');
                $('#penempatan').val(data.penempatan).trigger('change');
                $('#direct_manager').val(data.direct_manager).trigger('change');
                $('#role').val(data.role).trigger('change');
                $('#spesialisasi').val(data.spesialisasi).trigger('change');

                id = $('#id').val();

                $('.modal-title').text('Edit Data');
                $("#in").removeClass("btn btn-primary add");
                $("#in").addClass("btn btn-primary update");
                $('#taskModal').modal('show');


            },
        });

    });
    //end edit
    //update
    $('.col-12').on('click', '.update', function() {
        var form = document.getElementById("form-add");
        var fd = new FormData(form);
        $.ajax({
            type: 'POST',
            url: 'update_employee/' + id,
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
                    $('#taskModal').modal('hide');
                    document.getElementById("form-add").reset();
                    $('#example1').DataTable().ajax.reload();
                }
            }
        });
    });
    //end update
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        if (confirm('Yakin akan menghapus data ini?')) {
            // alert("Thank you for subscribing!" + $(this).data('id') );

            $.ajax({
                type: 'DELETE',
                url: 'delete_employee/' + $(this).data('id'),
                data: {
                    '_token': "{{ csrf_token() }}",
                },
                success: function(data) {
                    alert("Data Berhasil Dihapus");
                    $('#example1').DataTable().ajax.reload();
                }
            });

        } else {
            return false;
        }
    });

    function toggleCheckbox(button) {
        if (button.checked) {
            button.value = 1;
            $('#company').val('');
            document.getElementById("company").readOnly = false;
            // console.log(button.value);
        } else {
            button.value = 0;
            $('#company').val('PT Infosys Solusi Terpadu');
            document.getElementById("company").readOnly = true;
            // console.log(button.value);
        }
    }

    function reset_form() {
        document.getElementById('form-add').reset();
        $(".select2").val("#").trigger("change");
    }
</script>



@endsection