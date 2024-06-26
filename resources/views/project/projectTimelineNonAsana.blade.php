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
        </div>
        <!-- col -->
        <div class="col-12">
            <!-- card -->
            <div class="card">
                <!-- card header -->
                <div class="card-header d-md-flex border-bottom-0">
                    @canany(['bisa-tambah','timeline-editor'])
                    <div class="flex-grow-1">
                        <a href="/project/changeprojectTimeline/{{$id}}" class="btn btn-primary">+ Add Or Edit {{$judul}}</a>
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
                            },
                            {
                                "className": "text-end",
                                "targets": [6], // table ke 1
                            },
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
                            // Total over all pages
                            if (api.column(6).data().length) {
                                var total = api
                                    .column(6)
                                    .data()
                                    .reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    })
                            } else {
                                total = 0
                            };
                            $('#totRecord').html("Progress " + Math.round(total / api.column(6).data().length) + "%");
                        },
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
                                // data: function(row) {
                                //     return '<div class="d-flex align-items-center">' +
                                //         '<div class="me-2"> <span>' + row.progProject + '%</span></div>' +
                                //         '<div class="progress flex-auto" style="height: 6px;">' +
                                //         '<div class="progress-bar bg-primary " role="progressbar" style="width: ' + row.progProject + '%;" aria-valuenow="' + row.progProject + '" aria-valuemin="0" aria-valuemax="100">' +
                                //         '</div></div></div>'
                                // },
                                data: function(row) {
                                    return row.progProject + "%"
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
            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                if (confirm('Yakin akan menghapus data ini?')) {
                    // alert("Thank you for subscribing!" + $(this).data('id') );

                    $.ajax({
                        type: 'DELETE',
                        url: '/disconnect_project/' + $(this).data('id'),
                        data: {
                            '_token': "{{ csrf_token() }}",
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