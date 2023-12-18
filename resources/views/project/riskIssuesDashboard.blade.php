@extends('/project/navbarInput')

@section('inputan')

<link href="/assets/css/select2Custom.css" rel="stylesheet">
<!-- row -->
<div class="row">
    <div class="col-xxl-12 col-12 mb-5">
        <!-- col -->
        <div class="col-12">
            <!-- card -->
            <div class="card">
                <!-- card header -->
                <div class="card-header d-md-flex border-bottom-0">
                    @canany(['bisa-tambah','riskIssue-editor'])
                    <div class="flex-grow-1">
                        <a href="/project/changeriskIssues/{{$id}}" class="btn btn-primary">+ Add Or Edit {{$judul}}</a>
                    </div>
                    @endcanany
                </div>
                <!-- table -->
                <div class="card-body mb-10">
                    <div class="table-responsive">
                        <table id="riskData" class="table mb-0 text-nowrap table-hover table-centered">
                            <thead class="table-light">
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-xxl-12 col-12">
        <!-- col -->
        <div class="col-12">
            <!-- card -->
            <div class="card">
                <!-- card header -->
                <div class="card-header d-md-flex border-bottom-0">
                </div>
                <div class="card-body mb-10">
                    <div class="table-responsive">
                        <table id="issuesData" class="table mb-0 text-nowrap table-hover table-centered">
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
                url: '/project/json_riskIssues/{{$id}}', // Ganti dengan URL skrip PHP Anda
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Handle DataTable pertama
                    var riskData = response.dataTable1.original.data;

                    // Misalnya, tampilkan DataTables menggunakan library DataTables
                    $('#riskData').DataTable({
                        data: riskData,
                        processing: true,
                        "autoWidth": false,
                        "responsive": true,
                        columns: [{
                                data: function(row) {
                                    var value = row.riskDesc.length > 40 ? row.riskDesc.substring(0, 40) + '..' : row.riskDesc;
                                    return '<div data-toggle="tooltip" title="' + row.riskDesc + '">' + value + '</div>'
                                },
                                title: 'Risk Description'
                            },
                            {
                                data: 'trigerEvent',
                                title: 'Trigger Event/Indicator'
                            },
                            {
                                data: 'riskResponse',
                                title: 'Risk Response and Description'
                            },
                            {
                                data: 'contiPlan',
                                title: 'Contingency Plan'
                            },
                            {
                                data: 'riskOwner',
                                title: 'Owner'
                            },
                            {
                                data: 'statRisk',
                                title: 'Status'
                            },
                        ]
                    });

                    // Handle DataTable pertama
                    var issuesData = response.dataTable2.original.data;

                    // Misalnya, tampilkan DataTables menggunakan library DataTables
                    $('#issuesData').DataTable({
                        data: issuesData,
                        processing: true,
                        "autoWidth": false,
                        "responsive": true,
                        "columnDefs": [{
                            targets: [4],
                            render: function(oTable) {
                                return moment(oTable).format('DD-MM-YYYY');
                            },
                        }, ],
                        columns: [{
                                data: function(row) {
                                    var value = row.issuesDesc.length > 40 ? row.issuesDesc.substring(0, 40) + '..' : row.issuesDesc;
                                    return '<div data-toggle="tooltip" title="' + row.issuesDesc + '">' + value + '</div>'
                                },
                                title: 'Issue Description'
                            },
                            {
                                data: 'projectImpact',
                                title: 'Project Impact'
                            },
                            {
                                data: 'actionPlan',
                                title: 'Action Plan/Resolution'
                            },
                            {
                                data: function(row) {
                                    return row.issuesOwner == "#" ? "" : row.issuesOwner;
                                },
                                title: 'Issue Type'
                            },
                            {
                                data: 'resolvedDate',
                                title: 'Date Resolved'
                            },
                            {
                                data: function(row) {
                                    return row.statIssues == "#" ? "" : row.statIssues;
                                },
                                title: 'Status'
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