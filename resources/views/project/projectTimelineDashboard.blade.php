@extends('/project/navbarInput')

@section('inputan')

<link href="/assets/css/select2Custom.css" rel="stylesheet">
<!-- row -->
<div class="row">
    <div class="col-xxl-12 col-12">
        <div class="card  mb-4">
            <div class="card-header">
                <h4 class="mb-0">Documentation</h4>

            </div>
            <div class="card-body">
                <div id="linkDirect" class="row">
                    @if ($file)
                    <div class="mb-3 col-9">
                        <a href="{{$file->link}}" target="_blank" class="btn btn-ghost p-2 pt-0 pb-0" data-template="six">
                            <i class="bi bi-link-45deg icon-lg me-1"></i>{{$file->nameFile}}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- col -->
        <div class="col-12">
            <!-- card -->
            <div class="card">
                <!-- card header -->
                <div class="card-header d-md-flex border-bottom-0">
                    @canany(['bisa-tambah'])
                    <div class="flex-grow-1">
                        <a href="/project/changeProjMember/{{$id}}" class="btn btn-primary">+ Add Or Edit {{$judul}}</a>
                    </div>
                    @endcanany
                </div>
                <!-- table -->
                <div class="card-body mb-10">
                    <div class="table-responsive">
                        <table id="MemberProject" class="table mb-0 text-nowrap table-hover table-centered">
                            <thead class="table-light">
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            $.ajax({
                url: '/project/json_projectTimeline/{{$id}}', // Ganti dengan URL skrip PHP Anda
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Handle DataTable pertama
                    var MemberProject = response.dataTable1.original.data;

                    // Misalnya, tampilkan DataTables menggunakan library DataTables
                    $('#MemberProject').DataTable({
                        data: MemberProject,
                        processing: true,
                        "autoWidth": false,
                        "responsive": true,
                        "columnDefs": [{
                            targets: [2, 3, 4, 5],
                            render: function(oTable) {
                                return moment(oTable).format('DD-MM-YYYY');
                            },
                        }, ],
                        columns: [{
                                data: 'noRef',
                                title: 'No'
                            }, {
                                data: function(row) {
                                    var value = row.scope.length > 40 ? row.scope.substring(0, 40) + '..' : row.scope;
                                    return '<div data-toggle="tooltip" title="' + row.scope + '">' + value + '</div>'
                                },
                                title: 'Scope Of Work'
                            },
                            {
                                data: 'planStart',
                                title: 'Plan Start Date'
                            },
                            {
                                data: 'planEnd',
                                title: 'Plan End Date'
                            },
                            {
                                data: 'actStart',
                                title: 'Act Start Date'
                            },
                            {
                                data: 'actEnd',
                                title: 'Act End Date'
                            },
                            {
                                data: function(row) {
                                    return '<div class="d-flex align-items-center">' +
                                        '<div class="me-2"> <span>' + row.progProject + '%</span></div>' +
                                        '<div class="progress flex-auto" style="height: 6px;">' +
                                        '<div class="progress-bar bg-primary " role="progressbar" style="width: ' + row.progProject + '%;" aria-valuenow="' + row.progProject + '" aria-valuemin="0" aria-valuemax="100">' +
                                        '</div></div></div>'
                                },
                                title: 'Progress %'
                            },
                        ]
                    });


                },
                error: function(error) {
                    // Tangani kesalahan
                    console.error('Error:', error);
                }
            });
        })
        $(function() {

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