@extends('/project/navbarInput')

@section('inputan')

<link href="/assets/css/select2Custom.css" rel="stylesheet">
<!-- row -->
<div class="row">
    <!-- col -->
    <div class="col-12">
        <!-- card -->
        <div class="card">
            <!-- card header -->
            <div class="card-header d-md-flex border-bottom-0">
                @can('bisa-tambah')
                <div class="flex-grow-1">
                    <button id="adddata" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">+ Add {{$judul}}</button>
                </div>
                @endcan
            </div>
            <!-- table -->
            <div class="card-body">
                <div class="table-responsive overflow-y-hidden table-card">
                    <table id="example1" class="table mb-0 text-nowrap table-hover table-centered">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Modified</th>
                                <th>Uploaded by</th>
                                <th>Options</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
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
                        <label class="form-label">Type File</label>
                        <select name="type" id="type" class="select2" aria-label="Default select example" required>
                            <option value="#" selected>Open this select menu</option>
                            @foreach($doc as $doc)
                            <option value="{{$doc->id}}">{{$doc->docType}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label">Link <span class="text-danger">*</span></label>
                        <input name="link" id="link" type="text" class="form-control" placeholder="Enter Here" required>
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
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#offcanvasRight')
        });
    })
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
                    "targets": [0, 1, 2, 3, 4], // table ke 1
                },
                {
                    targets: 1,
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    },
                },
            ],
            ajax: {
                url: '/json_documentation/{{$id}}'
            },
            columns: [{
                    data: function(row) {
                        if (row.document && row.document.docType) {
                            return row.document.docType; // Mengembalikan nilai properti name jika ada
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'document.docType'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'linkFile',
                    name: 'linkFile',
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                }
            ],
        });

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
                url: '/store_documentation/{{$id}}',
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
                url: '/edit_documentation/{{$id}}',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': uid,
                },
                success: function(data) {
                    //console.log(data);

                    //isi form
                    $('#id').val(data.id);
                    $('#nameFile').val(data.nameFile);
                    $('#link').val(data.link);

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
                url: '/update_documentation/' + id,
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
                    url: '/delete_documentation/' + $(this).data('id'),
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
    });
</script>
@endsection