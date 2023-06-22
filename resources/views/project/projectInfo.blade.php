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
                                        <th>Customer</th>
                                        <th>Project Name</th>
                                        <th>Project Manager</th>
                                        <th>Progress</th>
                                        <th>Aksi</th>
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
                    data: 'customer.company',
                    name: 'customer.company'
                }, {
                    data: 'projectNamee',
                    name: 'projectNamee'
                },
                {
                    data: 'pm.name',
                    name: 'pm.name'
                },
                {
                    data: 'progress',
                    name: 'progress'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                }
            ],
        });
        $('.col-12').on('click', '#in', function() {
            $('#example1').data('dt_params', {
                'cust_id': $('#cust_id').val(),
                'pmName': $('#pmName').val(),
            });
            $('#example1').DataTable().draw();
        });
        $('.col-12').on('click', '#clear', function() {
            $('#cust_id').val('#').trigger('change'),
                $('#pmName').val('#').trigger('change'),
                $('#example1').data('dt_params', {});
            $('#example1').DataTable().draw();
        });

        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            if (confirm('Yakin akan menghapus data ini?')) {
                // alert("Thank you for subscribing!" + $(this).data('id') );

                $.ajax({
                    type: 'DELETE',
                    url: 'delete_project/' + $(this).data('id'),
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
    })
</script>
@endsection