@extends('index')

@section('konten')
<div id="app-content">

    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <!-- row -->
            <div class="row">
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
                "targets": [3], // table ke 1
            }],
            ajax: {
                url: '{{ url("json_project") }}'
            },
            columns: [{
                    data: 'projectName',
                    name: 'projectName'
                },
                {
                    data: 'customer[0].company',
                    name: 'customer[0].company'
                },
                {
                    data: 'p_m[0].name',
                    name: 'p_m[0].name'
                },
                {
                    data: 'progress',
                    name: 'progress'
                },
            ],
        });
    })
</script>
@endsection