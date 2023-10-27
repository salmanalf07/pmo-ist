@extends('index')

@section('konten')
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div id="app-content">
    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div>
                <!-- row -->
                <div class="row">
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
                                                <th>PM Name</th>
                                                <th>Leeson Learned</th>
                                                <th>Upload Date</th>
                                                <th>Status</th>
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
                <h5 class="modal-title" id="taskModalLabel">Add {{$judul}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="reset_from()" aria-label="Close">

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
                        <div class="mb-3 col-6">
                            <label class="form-label">PM Name <span class="text-danger">*</span></label>
                            <select name="pmName" id="pmName" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                                @foreach(collect($pmName)->sortBy('name') as $pmNames)
                                <option value="{{$pmNames->id}}">{{$pmNames->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="select2" aria-label="Default select example" required>
                                <option value="#" selected>Open this select menu</option>
                                @foreach($status as $statuss)
                                <option value="{{$statuss->id}}">{{$statuss->keterangan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Leeson Learned</label>
                            <input name="leesonLearned" id="leesonLearned" type="text" class="form-control" placeholder="Enter Here">
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Upload Date</label>
                            <div class="input-group me-3">
                                <input id="uploadDate" name="uploadDate" type="text" class="form-control rounded datepicker" data-input aria-describedby="date1" required>
                                <div class="input-group-append custom-picker">
                                    <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8"></div>
                        <!-- button -->
                        <div class="col-12">
                            <button id="in" class="btn btn-primary" type="button">Submit</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="modal" aria-label="Close" onclick="reset_from()">Close</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#taskModal'),
            placeholder: 'Select multiple options...',
        });
        flatpickr("#uploadDate", {
            dateFormat: "d-m-Y",
            defaultDate: "01-01-1900",
            allowInput: true, // Mengizinkan input manual
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
                    "targets": [0, 4, 5], // table ke 1
                },
                {
                    targets: 3,
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    },
                },
            ],
            ajax: {
                url: '{{ url("/pmo/json_leesonLearned") }}'
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'pm_names.name',
                    name: 'pm_names.name'
                },
                {
                    data: 'leesonLearned',
                    name: 'leesonLearned'
                },
                {
                    data: 'uploadDate',
                    name: 'uploadDate'
                },
                {
                    data: 'statuss.status',
                    name: 'statuss.status'
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
        $('#role').val(null).trigger('change');
    });

    //add data
    $('.col-12').on('click', '.add', function() {
        var form = document.getElementById("form-add");
        var fd = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '{{ url("/pmo/store_leesonLearned") }}',
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data[1]) {
                    let text = "";
                    var dataa = Object.assign({}, data[0])
                    for (let x in dataa) {
                        text += '<div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">' +
                            '<strong>' + dataa[x] + '</strong>' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>';
                    }
                    $('#peringatan').append(text);
                } else {
                    $('#taskModal').modal('hide');
                    reset_from()
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
            url: '/pmo/edit_leesonLearned',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //isi form
                $('#id').val(data.id);
                $('#pmName').val(data.pmName).trigger('change');
                $('#status').val(data.status).trigger('change');
                $('#leesonLearned').val(data.leesonLearned);
                $('#uploadDate').val((data.uploadDate).split("-").reverse().join("-"));

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
            url: '/pmo/update_leesonLearned/' + id,
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data[1]) {
                    let text = "";
                    var dataa = Object.assign({}, data[0])
                    for (let x in dataa) {
                        text += '<div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">' +
                            '<strong>' + dataa[x] + '</strong>' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>';
                    }
                    $('#peringatan').append(text);
                } else {
                    $('#taskModal').modal('hide');
                    reset_from()
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
                url: '/pmo/delete_leesonLearned/' + $(this).data('id'),
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

    function reset_from() {
        $('#categoryId').val("#").trigger('change');
        $('#typeId').val("#").trigger('change');
        document.getElementById("form-add").reset();
        $('.alert-danger').remove();
    }
</script>



@endsection