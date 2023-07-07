@extends('index')

@section('konten')
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div id="app-content">
    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">{{$judul}}</h3>
                    </div>
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row mb-3">
                    <div class="col-12 mb-3">
                        <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-3">
                                            <label class="form-label" for="selectOne">End Date</label>
                                            <div class="input-group me-3 datepicker">
                                                <input id="dateEnd" name="dateEnd" type="text" class="form-control rounded" data-input aria-describedby="date1">
                                                <div class="input-group-append custom-picker">
                                                    <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <label class="form-label">Progress Project</label>
                                            <select name="progressProj" id="progressProj" class="select2" aria-label="Default select example" required>
                                                <option value="#" selected>Open this select menu</option>
                                                <option value="0">0%</option>
                                                <option value="20">20%</option>
                                                <option value="40">40%</option>
                                                <option value="60">60%</option>
                                                <option value="80">80%</option>
                                                <option value="100">100%</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                        </div>
                                        <div class="mb-3 col-3">
                                            <button id="in" type="button" class="btn btn-primary-soft" style="width:100%">Filter</button>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <button id="clear" type="button" class="btn btn-danger-soft" style="width:100%">Clear</button>
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
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table id="example1" class="table text-nowrap table-centered mt-0" style="width: 100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th>
                                                    No
                                                </th>
                                                <th>Karyawan ID</th>
                                                <th>Nama Karyawan</th>
                                                <th>Email </th>
                                                <th>Manager Langsung</th>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

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
                            <label class="form-label">Karyawan ID <span class="text-danger">*</span></label>
                            <input name="employee_id" id="employee_id" type="text" class="form-control" placeholder="Enter Here" required>
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
                            <label class="form-label">Nama Karyawan <span class="text-danger">*</span></label>
                            <input name="name" id="name" type="text" class="form-control" placeholder="Enter Here" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Division</label>
                            <select name="divisi" id="divisi" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Department</label>
                            <select name="department" id="department" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Direct Manager</label>
                            <select name="direct_manager" id="direct_manager" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
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
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Role</label>
                            <select name="role" id="role" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Skill Level</label>
                            <select name="level" id="level" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
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
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById('form-add').reset();">Close</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- flatpickr -->
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script>
    flatpickr("#dateEnd", {
        dateFormat: "d-m-Y",
        defaultDate: "01-01-1990",
    });
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#taskModal')
        });
        $('#progressProj,#endDate').select2();
    })
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
                url: '{{ url("json_employee") }}'
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
                    data: 'divisi',
                    name: 'divisi'
                },
                {
                    data: 'direct_manager',
                    name: 'direct_manager'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                }
            ],
        });
    });

    //button add
    $(document).on('click', '#adddata', function() {
        $("#in").removeClass("btn btn-primary update");
        $("#in").addClass("btn btn-primary add");
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
                $('#ktp').val(data.ktp);
                $('#npwp').val(data.npwp);
                $('#norek').val(data.norek);
                $('#nohp').val(data.nohp);
                $('#level').val(data.level);
                $('#divisi').val(data.divisi);
                $('#company').val(data.company);
                $('#penempatan').val(data.penempatan);
                $('#direct_manager').val(data.direct_manager);
                $('#role').val(data.role);
                $('#spesialisasi').val(data.spesialisasi);
                if (data.pkwt_start != null) {
                    $('#pkwt_start').val((data.pkwt_start).split("-").reverse().join("-"));
                }
                if (data.pkwt_end != null) {
                    $('#pkwt_end').val((data.pkwt_end).split("-").reverse().join("-"));
                }
                $('#email_ist').val(data.email_ist);
                $('#email').val(data.email);

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
</script>



@endsection