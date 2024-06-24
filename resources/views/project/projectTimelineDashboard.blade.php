@extends('/project/navbarInput')

@section('inputan')

<link href="/assets/css/select2Custom.css" rel="stylesheet">
<!-- row -->
<div class="row">
    <div class="col-xxl-12 col-12">
        <!-- <div class="card  mb-4">
            <div class="card-header">
                <h4 class="mb-0">Documentation</h4>

            </div>
            <div class="card-body">
                <div id="linkDirect" class="row">
                    @if ($file)
                    @foreach ($file as $files)
                    <div class="mb-3 col-9">
                        <a href="{{$files->link}}" target="_blank" class="btn btn-ghost p-2 pt-0 pb-0" data-template="six">
                            <i class="bi bi-link-45deg icon-lg me-1"></i>{{$files->nameFile}}
                        </a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div> -->
        <!-- col -->
        <div class="col-12">
            <!-- card -->
            <div class="card">
                <!-- card header -->
                <div class="card-header d-md-flex border-bottom-0">
                    @canany(['bisa-tambah','timeline-editor'])
                    <div class="flex-grow-1">
                        <button id="adddata" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">+ Connect Project</button>
                    </div>
                    @endcanany
                    <div style="width: 15em;">
                        <p class="p-2 rounded-2 text-center  bg-primary-soft" style="height: 2.8em;" id="totRecord"></p>
                    </div>
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
    <!-- Offcanvas -->
    <div class="modal fade gd-example-modal-lg" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true" data-bs-focus="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Connect Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="reset_from()" aria-label="Close">

                    </button>
                </div>

                <!-- card body -->
                <div class="modal-body">
                    <!-- form -->
                    <form method="post" action="/store_connectProject/{{$id}}" role="form" id="form-add" enctype="multipart/form-data">
                        <div class="row">
                            <!-- form group -->
                            @csrf
                            <span id="peringatan"></span>
                            <div class="mb-3 col-12">
                                <label class="form-label" for="selectOne">Project</label>
                                <select name="project[]" id="project" class="select2" multiple="multiple" aria-label="Default select example" required>
                                    @foreach($getProjectAsana as $data)
                                    <option value="{{$data->id}}">{{$data->archived == 1 ? '[Archived] - ' : ''}}{{$data->projectName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8"></div>
                            <!-- button -->
                            <div class="col-12">
                                <button id="in" class="btn btn-primary" type="submit">Connect</button>
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

            $.ajax({
                url: '/project/json_projectTimelineAsana/{{$id}}', // Ganti dengan URL skrip PHP Anda
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
                                targets: [2, 3],
                                render: function(oTable) {
                                    return moment(oTable).format('DD-MM-YYYY');
                                },
                            },
                            {
                                "className": "text-end",
                                "targets": [4], // table ke 1
                            },
                            {
                                "className": "text-center",
                                "targets": [6], // table ke 1
                            },
                            {
                                targets: 5, // Indeks kolom 'status'
                                render: function(data, type, row) {
                                    var color = '';
                                    switch (data) {
                                        case 'On Track':
                                            color = 'green';
                                            break;
                                        case 'At Risk':
                                            color = 'orange';
                                            break;
                                        case 'Off Track':
                                            color = 'red';
                                            break;
                                        case 'On Hold':
                                            color = 'blue';
                                            break;
                                        case 'Completed':
                                            color = 'green';
                                            break;
                                    }
                                    return '<span style="color:' + color + '">' + data + '</span>';
                                }
                            }
                        ],
                        footerCallback: function(row, data, start, end, display) {
                            var api = this.api();
                            // Remove the formatting to get integer data for summation
                            var intVal = function(i) {

                                const regex = /\d+/;
                                return typeof i === 'string' ?
                                    i.match(regex) * 1 :
                                    typeof i === 'number' ?
                                    i : 0;

                            };

                            var data = api.column(4).data();

                            if (data.length) {
                                var total;
                                if (data.length === 1) {
                                    total = intVal(data[0]);
                                } else {
                                    total = data.reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    });
                                }
                            } else {
                                total = 0;
                            }

                            $('#totRecord').html("Progress " + Math.round(total / api.column(4).data().length) + "%");
                        },
                        columns: [{
                                data: function(row) {
                                    var value = row.projectName.length > 30 ? row.projectName.substring(0, 30) + '..' : row.projectName;
                                    return '<div data-toggle="tooltip" title="' + row.projectName + '">' + value + '</div>'
                                },
                                title: 'Project Name'
                            },
                            {
                                data: function(row) {
                                    if (!row.pm) {
                                        return '';
                                    }
                                    var value = row.pm.name.length > 20 ? row.pm.name.substring(0, 20) + '..' : row.pm.name;
                                    return '<div data-toggle="tooltip" title="' + row.pm.name + '">' + value + '</div>'
                                },
                                title: 'PM'
                            },
                            {
                                data: 'startDate',
                                title: 'Start Date'
                            },
                            {
                                data: 'dueDate',
                                title: 'Due Date'
                            },
                            {
                                data: function(row) {
                                    return row.progress == null ? "0%" : row.progress + "%"
                                },
                                title: 'Progress %'
                            },
                            {
                                data: function(row) {
                                    return row.status == null ? "" : row.statuss.name
                                },
                                title: 'Status'
                            },
                            {
                                data: 'aksi',
                                title: 'Action'
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
            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                if (confirm('Yakin akan menghapus data ini?')) {
                    // alert("Thank you for subscribing!" + $(this).data('id') );

                    $.ajax({
                        type: 'DELETE',
                        url: '/disconnect_project/' + $(this).data('id'),
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'projectId':$(this).data('project')
                        },
                        success: function(data) {
                            alert("Data Berhasil Dihapus");
                            location.reload();
                        }
                    });

                } else {
                    return false;
                }
            });
        });

        function reset_from() {
            $('#project').val(null).trigger('change');
            document.getElementById("form-add").reset();
            $('.alert-danger').remove();
        }
    </script>
    @endsection