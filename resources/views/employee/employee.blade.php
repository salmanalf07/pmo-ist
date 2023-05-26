@extends('index')

@section('konten')
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-md-flex border-bottom-0">
                                <div class="flex-grow-1">
                                    <button id="adddata" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">+ Add {{$judul}}</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table id="example1" class="table text-nowrap table-centered mt-0" style="width: 100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="pe-0">
                                                    No
                                                </th>
                                                <th class="ps-1">Karyawan ID</th>
                                                <th>Divisi</th>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">

    <div class="offcanvas-body" data-simplebar>
        <div class="offcanvas-header px-2 pt-0">
            <h3 class="offcanvas-title" id="offcanvasExampleLabel">Add {{$judul}}</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!-- card body -->
        <div class="container">
            <!-- form -->
            <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                <div class="row">
                    <!-- form group -->
                    @csrf
                    <span id="peringatan"></span>
                    <input class="form-control" type="text" name="id" id="id" hidden>
                    <div class="mb-3 col-12">
                        <label class="form-label">Karyawan ID <span class="text-danger">*</span></label>
                        <input name="employee_id" id="employee_id" type="text" class="form-control" placeholder="Enter Here" required>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label">Nama Karyawan <span class="text-danger">*</span></label>
                        <input name="name" id="name" type="text" class="form-control" placeholder="Enter Here" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Nomor KTP</label>
                        <input name="ktp" id="ktp" type="text" class="form-control" placeholder="Enter Here">
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Nomor NPWP</label>
                        <input name="npwp" id="npwp" type="text" class="form-control" placeholder="Enter Here">
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Nomor Rekening</label>
                        <input name="norek" id="norek" type="text" class="form-control" placeholder="Enter Here">
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">No HP</label>
                        <input name="nohp" id="nohp" type="text" class="form-control" placeholder="Enter Here">
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Level <span class="text-danger">*</span></label>
                        <input name="level" id="level" type="text" class="form-control" placeholder="Enter Here" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Divisi <span class="text-danger">*</span></label>
                        <input name="divisi" id="divisi" type="text" class="form-control" placeholder="Enter Here" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Perusahaan <span class="text-danger">*</span></label>
                        <input name="company" id="company" type="text" class="form-control" placeholder="Enter Here" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Penempatan</label>
                        <input name="penempatan" id="penempatan" type="text" class="form-control" placeholder="Enter Here">
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label">Manajer Langsung <span class="text-danger">*</span></label>
                        <input name="direct_manager" id="direct_manager" type="text" class="form-control" placeholder="Enter Here" required>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <input name="role" id="role" type="text" class="form-control" placeholder="Enter Here" required>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label">Spesialisasi</label>
                        <input name="spesialisasi" id="spesialisasi" type="text" class="form-control" placeholder="Enter Here">
                    </div>
                    <!-- form group -->
                    <div class="mb-3 col-md-6 col-12">
                        <label class="form-label">Tanggal Mulai PKWT <span class="text-danger">*</span></label>
                        <div class="input-group me-3 datepicker">
                            <input id="pkwt_start" name="pkwt_start" type="text" class="form-control rounded" data-input aria-describedby="date2" required>
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="date2" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- form group -->
                    <div class="mb-3 col-md-6 col-12">
                        <label class="form-label">Tanggal Akhir PKWT <span class="text-danger">*</span></label>
                        <div class="input-group me-3 datepicker">
                            <input id="pkwt_end" name="pkwt_end" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label">Email IST <span class="text-danger">*</span></label>
                        <input name="email_ist" id="email_ist" type="text" class="form-control" placeholder="Enter Here" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Email Pribadi <span class="text-danger">*</span></label>
                        <input name="email" id="email" type="text" class="form-control" placeholder="Enter Here" required>
                    </div>
                    <div class="col-md-8"></div>
                    <!-- button -->
                    <div class="col-12">
                        <button id="in" class="btn btn-primary" type="button">Submit</button>
                        <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas" aria-label="Close" onclick="document.getElementById('form-add').reset();">Close</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    jQuery(function() {
        initDatePicker();
    });

    checkIfTodaySelected = function(selDate, dateStr, fp) {
        let today = new Date().toLocaleDateString();
        let selDateDay = new Date(selDate).toLocaleDateString();
        if (selDateDay === today) {
            fp._input.value = "Today"
        }
    }

    function initDatePicker() {
        const fp = jQuery(".datepicker").flatpickr({
            wrap: true,
            altInput: true,
            allowInput: false, // if doesn't need - disable it.
            altFormat: "j F Y",
            dateFormat: "d-m-Y",
            defaultDate: "today",
            onReady: checkIfTodaySelected,
            onValueUpdate: checkIfTodaySelected
        });

    }
</script>
<script>
    $(function() {

        var oTable = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "columnDefs": [{
                "className": "text-center",
                "targets": [0, 1, 2, 3, 4, 5], // table ke 1
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
                    $('#offcanvasRight').offcanvas('hide');
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
                $('#company').val(data.company);
                $('#addres').val(data.addres);
                $('#city').val(data.city);
                $('#npwp').val(data.npwp);
                $('#pic').val(data.pic);
                $('#telppic').val(data.telppic);
                $('#industry').val(data.industry).trigger('change');
                if (data.type === "customer") {
                    $("#customer").prop('checked', true);
                }
                if (data.type === "vendor") {
                    $("#vendor").prop('checked', true);
                }

                id = $('#id').val();

                $('.modal-title').text('Edit Data');
                $("#in").removeClass("btn btn-primary add");
                $("#in").addClass("btn btn-primary update");
                $('#offcanvasRight').offcanvas('show');

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
                    $('#offcanvasRight').offcanvas('hide');
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
</script>



@endsection