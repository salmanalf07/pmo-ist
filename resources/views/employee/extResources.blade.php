@extends('index')

@section('konten')
<link href="/assets/css/select2Custom.css" rel="stylesheet">
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
                <div class="row mb-3">
                    <div class="col-12 mb-3">
                        <form method="post" role="form" id="form-filter" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="selectOne">Company</label>
                                            <select name="company" id="company" class="select2" aria-label="Default select example" required>
                                                <option value="#" selected>Open this select menu</option>
                                                @foreach($company->unique('company') as $company)
                                                <option value="{{$company->company}}">{{$company->company}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                        </div>
                                        <div class="mb-3 col-3">
                                            <button id="inn" type="button" class="btn btn-primary-soft" style="width:100%">Filter</button>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <button id="clear" type="button" class="btn btn-danger-soft" style="width:100%">Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table id="example1" class="table text-nowrap table-centered mt-0" style="width: 100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Karyawan</th>
                                                <th>Company</th>
                                                <th>Customer</th>
                                                <th>Project Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
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
<!-- flatpickr -->
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
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
            "autoWidth": false,
            "columnDefs": [{
                "className": "text-center",
                "targets": [0, 4, 5], // table ke 1
            }, {
                targets: [4, 5],
                render: function(oTable) {
                    return moment(oTable).format('DD-MM-YYYY');
                }
            }, ],
            ajax: {
                url: '{{ url("json_ExtResources") }}',
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
                    data: 'employee.name',
                    name: 'employee.name'
                },
                {
                    data: 'employee.company',
                    name: 'employee.company'
                },
                {
                    data: 'project.customer.company',
                    name: 'project.customer.company'
                },
                {
                    data: 'project.projectName',
                    name: 'project.projectName',
                    render: function(data, type, row) {
                        return type === 'display' && data.length > 30 ? data.substring(0, 30) + '..' : data;
                    }
                },
                {
                    data: 'startDate',
                    name: 'startDate'
                },
                {
                    data: 'endDate',
                    name: 'endDate'
                },
            ],
        });
        $('.col-3').on('click', '#inn', function() {
            $('#example1').data('dt_params', {
                'company': $('#company').val(),
            });
            $('#example1').DataTable().draw();
            // console.log(date)
        });
        $('.col-12').on('click', '#clear', function() {
            $('#example1').data('dt_params', {});
            $('#example1').DataTable().draw();
        });
    });
</script>



@endsection