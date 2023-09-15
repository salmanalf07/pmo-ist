@extends('/project/navbarInput')

@section('inputan')
<!-- row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-md-flex border-bottom-0">
                @canany(['bisa-tambah','highAndNotes-editor'])

                @endcanany
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
                                <th>Highlight And Notes</th>
                                <th>User</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
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
                <h5 class="modal-title" id="taskModalLabel">Add {{$judul}}</h5>
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
                        <input class="form-control" type="text" name="projectId" id="projectId" value="{{$id}}" hidden>
                        <div class="mb-3 col-12">
                            <label class="form-label">Highligh And Notes <span class="text-danger">*</span></label>
                            <textarea name="highAndNote" id="highAndNote" class="form-control" cols="100" rows="10"></textarea>
                        </div>
                        <div class="col-md-8"></div>
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
                    "targets": [0, 3], // table ke 1
                },
                {
                    targets: 3,
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY HH:mm');
                    },
                },
            ],
            ajax: {
                url: '{{ url("json_highAndNotes") }}'
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'highAndNote',
                    name: 'highAndNote'
                },
                {
                    data: 'users.name',
                    name: 'users.name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
            url: '{{ url("store_highAndNotes") }}',
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
            url: '/edit_highAndNotes',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data);

                //isi form
                $('#id').val(data.id);
                $('#highAndNote').val(data.highAndNote);

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
            url: '/update_highAndNotes/' + id,
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
                url: '/delete_highAndNotes/' + $(this).data('id'),
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