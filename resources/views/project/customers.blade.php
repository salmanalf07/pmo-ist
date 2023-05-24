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
                                                <th class="ps-1">Company</th>
                                                <th>Category</th>
                                                <th>City</th>
                                                <th>Industry</th>
                                                <th>PIC</th>
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
            <h3 class="offcanvas-title" id="offcanvasExampleLabel">Add Customer</h3>
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
                    <div class="mb-3 mt-3 col-6">
                        <input class="form-cek-input" type="radio" name="radio" value="customer" id="customer" checked>
                        <label class="form-label" for="customer">
                            Customer
                        </label>
                    </div>
                    <div class="mb-3 mt-3 col-6">
                        <input class="form-cek-input" type="radio" name="radio" value="vendor" id="vendor">
                        <label class="form-label" for="vendor">
                            Vendor
                        </label>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label">Company <span class="text-danger">*</span></label>
                        <input name="company" id="company" type="text" class="form-control" placeholder="Enter Hear" required>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label">Address</label>
                        <input name="addres" id="addres" type="text" class="form-control" placeholder="Enter Hear">
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label">City</label>
                        <input name="city" id="city" type="text" class="form-control" placeholder="Enter Hear">
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label">No NPWP</label>
                        <input name="npwp" id="npwp" type="text" class="form-control" placeholder="Enter Hear">
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">PIC</label>
                        <input name="pic" id="pic" type="text" class="form-control" placeholder="Enter Hear">
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">No Telp. PIC</label>
                        <input name="telppic" id="telppic" type="text" class="form-control" placeholder="Enter Hear">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="selectOne">Industri</label>
                        <select name="industry" id="industry" class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="banking">Bangking</option>
                            <option value="goverment">goverment</option>
                            <option value="bumn">BUMN</option>
                        </select>
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
                "targets": [0, 1, 2, 3, 4, 5, 6], // table ke 1
            }, ],
            ajax: {
                url: '{{ url("json_customer") }}'
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'company',
                    name: 'company'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'city',
                    name: 'city'
                },
                {
                    data: 'industry',
                    name: 'industry'
                },
                {
                    data: 'pic',
                    name: 'pic'
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
            url: '{{ url("store_customer") }}',
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
            url: 'edit_customer',
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
            url: 'update_customer/' + id,
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
                url: 'delete_customer/' + $(this).data('id'),
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