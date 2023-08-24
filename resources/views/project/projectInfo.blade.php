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
                                    <div class="row col-10">
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="selectOne">Customer</label>
                                            <select name="cust_id" id="cust_id" class="select2" aria-label="Default select example">
                                                <option value="#" selected>Open this select menu</option>
                                                @foreach($customer as $customer)
                                                <option value="{{$customer->id}}">{{strtoupper($customer->company)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label">Project Manager</label>
                                            <select name="pmName" id="pmName" class="select2" aria-label="Default select example" required>
                                                <option value="#" selected>Open this select menu</option>
                                                @foreach($pm->unique('pmName') as $pmName)
                                                @if($pmName->pm != null)
                                                <option value="{{$pmName->pm->id}}">{{$pmName->pm->name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label">Project Status</label>
                                            <select name="status" id="status" class="select2" aria-label="Default select example" required>
                                                <option value="#" selected>Open this select menu</option>
                                                <option value="all">All</option>
                                                <option value="progress">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row col-2 pt-7 ms-3">
                                        <div class="mb-3 col-12">
                                            <button id="clear" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Clear" class="btn btn-danger-soft" style="width:100%">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                    <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z" />
                                                </svg>
                                            </button>
                                        </div>
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
                                @can('bisa-tambah')
                                <a href="project/inputProject" class="btn btn-primary">Add New</a>
                                @endcan
                            </div>
                            <div class="justify-content-end">
                                <p>Project - {{$judul}}</p>
                            </div>
                        </div>
                        <!-- table -->
                        <div class="table-responsive">
                            <table id="example1" class="table text-nowrap table-centered mt-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Project Name</th>
                                        <th>SPK</th>
                                        <th>Project Manager</th>
                                        <th>Progress</th>
                                        <th></th>
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
                    name: 'customer.company',
                    render: function(data, type, row) {
                        return type === 'display' && data.length > 23 ? data.substring(0, 23) + '..' : data;
                    }
                }, {
                    data: 'projectNamee',
                    name: 'projectNamee',
                },
                {
                    data: function(row) {
                        if (row.noContract && row.noContract) {
                            return row.noContract; // Mengembalikan nilai properti name jika ada
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'noContract',
                    render: function(data, type, row) {
                        return type === 'display' && data.length > 15 ? data.substring(0, 15) + '..' : data;
                    }
                },
                {
                    data: function(row) {
                        if (row.pm && row.pm.name) {
                            return row.pm.name; // Mengembalikan nilai properti name jika ada
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
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
        // $('.col-12').on('click', '#in', function() {
        $('#cust_id, #pmName, #status').on('change', function() {
            $('#example1').data('dt_params', {
                'cust_id': $('#cust_id').val(),
                'pmName': $('#pmName').val(),
                'status': $('#status').val(),
            });
            $('#example1').DataTable().draw();
        });
        $('.col-12').on('click', '#clear', function() {
            $('#cust_id').val('#').trigger('change');
            $('#pmName').val('#').trigger('change');
            $('#status').val('#').trigger('change');
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