@extends('index')

@section('konten')
<!-- custom select2 -->
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div id="app-content">

    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <!-- row -->

            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100 card-lift">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Pipeline Project</h4>
                                </div>
                                <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                                    <i data-feather="briefcase" height="20" width="20"></i>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class=" mb-1 fw-bold">18</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100 card-lift">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">On Going Project</h4>
                                </div>
                                <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                                    <i data-feather="list" height="20" width="20"></i>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class="  mb-1 fw-bold">132</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100 card-lift">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Completed</h4>
                                </div>
                                <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                                    <i data-feather="users" height="20" width="20"></i>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class="  mb-1 fw-bold">12</h1>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100 card-lift">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Overdue</h4>
                                </div>
                                <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                                    <i data-feather="target" height="20" width="20"></i>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class="  mb-1 fw-bold">76%</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 mb-3">
                    <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="selectOne">Customer</label>
                                        <select name="cust_id" id="cust_id" class="select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($customer as $customer)
                                            <option value="{{$customer->id}}">{{strtoupper($customer->company)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Project Manager</label>
                                        <select name="pmName" id="pmName" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($employee as $pmName)
                                            <option value="{{$pmName->id}}">{{$pmName->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <button id="in" type="button" class="btn btn-primary-soft" style="width:100%">Filter Data</button>
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
                        <div class="card-header d-md-flex border-bottom-0">
                            <div class="flex-grow-1">
                                <a href="project/inputProject" class="btn btn-primary">+ Add {{$judul}}</a>
                            </div>
                        </div>
                        <!-- table -->
                        <div class="table-responsive">
                            <table id="example1" class="table text-nowrap table-centered mt-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Customer</th>
                                        <th>Project Manager</th>
                                        <th>Progress</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-md-12 col-12 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="mb-0">Project By Sector</h4>
                            <div class="row row-cols-lg-3  my-8">
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Desktop</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-info mb-0 ">51.5%</h4>
                                            <span class="text-info">201,434</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Mobile</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-success mb-0 ">34.4%</h4>
                                            <span class="text-success">134,693</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Tablet</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-warning mb-0 ">20.8%</h4>
                                            <span class="text-warning">81,525</span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="mt-6 mb-3">
                                <div class="progress" style="height: 40px;">
                                    <div class="progress-bar bg-info" role="progressbar" aria-label="Segment one" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-success" role="progressbar" aria-label="Segment two" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-warning" role="progressbar" aria-label="Segment three" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12 col-12 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="mb-0">Project By Type</h4>
                            <div class="row row-cols-lg-3  my-8">
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Desktop</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-info mb-0 ">51.5%</h4>
                                            <span class="text-info">201,434</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Mobile</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-success mb-0 ">34.4%</h4>
                                            <span class="text-success">134,693</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Tablet</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-warning mb-0 ">20.8%</h4>
                                            <span class="text-warning">81,525</span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="mt-6 mb-3">
                                <div class="progress" style="height: 40px;">
                                    <div class="progress-bar bg-info" role="progressbar" aria-label="Segment one" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-success" role="progressbar" aria-label="Segment two" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-warning" role="progressbar" aria-label="Segment three" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
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
                "targets": [3], // table ke 1
            }],
            ajax: {
                url: '{{ url("json_project") }}',
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
                    data: 'projectNamee',
                    name: 'projectNamee'
                },
                {
                    data: 'customer.company',
                    name: 'customer.company'
                },
                {
                    data: 'pm.name',
                    name: 'pm.name'
                },
                {
                    data: 'progress',
                    name: 'progress'
                },
            ],
        });
        $('.col-12').on('click', '#in', function() {
            $('#example1').data('dt_params', {
                'cust_id': $('#cust_id').val(),
                'pmName': $('#pmName').val(),
            });
            $('#example1').DataTable().draw();
        });
    })
</script>
@endsection