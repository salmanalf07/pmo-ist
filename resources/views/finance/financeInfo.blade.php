@extends('index')

@section('konten')
<!-- custom select2 -->
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div id="app-content">
    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <!-- row -->

            <div class="row mb-3">
                <div class="col-12 mb-3">
                    <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label class="form-label">Date Range</label>
                                        <div class="input-group me-3">
                                            <input type="text" class="form-control float-right" id="reservation">
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <button id="in" type="button" class="btn btn-primary-soft" style="width:100%">Filter Data</button>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <button id="clear" type="button" class="btn btn-danger-soft" style="width:100%">Clear Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- col -->
                <div class="col-12">
                    <!-- card -->
                    <div class="card">
                        <!-- table -->
                        <div class="table-responsive" style="border:0">
                            <table id="example1" class="table text-nowrap table-centered mt-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Project Name</th>
                                        <th>No Contract</th>
                                        <th>Terms Name</th>
                                        <th>Terms Value</th>
                                        <th>BAST Date</th>
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

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('#reservation').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            },
            function(start, end) {
                dateinn = start.format('YYYY-MM-DD');
                dateenn = end.format('YYYY-MM-DD');
            }
        )
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
            "autoWidth": true,
            "columnDefs": [{
                    "className": "text-end",
                    "targets": [4], // table ke 1
                }, {
                    targets: [5],
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    }
                },
                {
                    targets: [4],
                    render: $.fn.dataTable.render.number('.', '.', 0)
                },
            ],
            ajax: {
                url: '{{ url("json_finance") }}',
                data: function(d) {
                    // Retrieve dynamic parameters
                    var dt_params = $('#example1').data('dt_params');
                    // Add dynamic parameters to the data object sent to the server
                    if (dt_params) {
                        $.extend(d, dt_params);
                    }
                }
            },
            columns: [{
                    data: 'project.customer.company',
                    name: 'project.customer.company'
                },
                {
                    data: 'projectNamee',
                    name: 'projectNamee'
                },
                {
                    data: 'project.noContract',
                    name: 'project.noContract',
                    render: function(data, type, row) {
                        return type === 'display' && data.length > 10 ? data.substring(0, 10) + '...' : data;
                    }
                },
                {
                    data: 'termsName',
                    name: 'termsName',
                    render: function(data, type, row) {
                        return type === 'display' && data.length > 30 ? data.substring(0, 30) + '...' : data;
                    }
                },
                {
                    data: 'termsValue',
                    name: 'termsValue'
                },
                {
                    data: 'bastDate',
                    name: 'bastDate'
                },
            ],
        });
        $('.col-12').on('click', '#in', function() {
            var date = $('#reservation').val().split(" - ");
            $('#example1').data('dt_params', {
                'date_st': date[0],
                'date_ot': date[1],
            });
            $('#example1').DataTable().draw();
        });
        $('.col-12').on('click', '#clear', function() {
            $('#example1').data('dt_params', {});
            $('#example1').DataTable().draw();
        });
    })
</script>
@endsection