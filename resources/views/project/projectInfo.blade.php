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
                                            <input type="text" id="custId" name="custId" value="#" hidden>
                                            <select name="cust_id[]" id="cust_id" multiple="multiple" class="select2" aria-label="Default select example">
                                                @foreach($customer as $customer)
                                                <option value="{{$customer->id}}">{{strtoupper($customer->company)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label">Project Manager</label>
                                            <input type="text" id="pmId" name="pmId" value="#" hidden>
                                            <select name="pmName[]" id="pmName" multiple="multiple" class="select2" aria-label="Default select example" required>
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
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="selectOne">Sales</label>
                                            <input type="text" id="salesId" name="salesId" value="#" hidden>
                                            <select name="sales[]" id="sales" multiple="multiple" class="select2" aria-label="Default select example">
                                                @foreach(collect($sales->unique('sales'))->sortBy('sales->name') as $sales)
                                                @if($sales->saless != null)
                                                <option value="{{$sales->saless['id']}}">{{$sales->saless['name']}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label">Project Sponsors</label>
                                            <input type="text" id="sponsor" name="sponsor" value="#" hidden>
                                            <select name="sponsors[]" id="sponsors" multiple="multiple" class="select2" aria-label="Default select example" required>
                                                @foreach($sponsors->unique('sponsorId') as $sponsor)
                                                @if($sponsor->employee != null)
                                                <option value="{{$sponsor->sponsorId}}">{{$sponsor->employee['name']}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label">Has Asana</label>
                                            <select name="hasAsana" id="hasAsana" class="select2" aria-label="Default select example" required>
                                                <option value="#" selected>Open this select menu</option>
                                                <option value="all">All</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
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
                                    <tr class="two-rows">
                                        <th rowspan="2">Project Id</th>
                                        <th rowspan="2">Customer</th>
                                        <th rowspan="2">Project Name</th>
                                        <th rowspan="2">SPK</th>
                                        <th rowspan="2">Project Manager</th>
                                        <th class="text-center" colspan="2">Progress</th>
                                        <th rowspan="2"></th>
                                    </tr>
                                    <tr class="normal-row">
                                        <th>Project</th>
                                        <th>Invoice</th>
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
        $('select.select2:not(.normal)').each(function() {
            var elementId = $(this).attr('id'); // Get the ID of the current select element

            // Check if the ID matches a specific condition
            if (['sales', 'cust_id', 'pmName', 'sponsors'].includes(elementId)) {
                $(this).select2({
                    dropdownParent: $(this).parent().parent(),
                    placeholder: 'Select multiple options...'
                });
            } else {
                $(this).select2({
                    dropdownParent: $(this).parent().parent()
                });
            }

        });
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
            "order": [],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": false,
            "columnDefs": [{
                "className": "text-center",
                "targets": [0], // table ke 1
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
                    data: 'noProject',
                },
                {
                    data: function(row, type) {
                        if (row.cust_id != "#") {
                            var value = type === 'display' && row.customer.company.length > 23 ? row.customer.company.substring(0, 23) + '..' : row.customer.company;
                            return '<div data-toggle="tooltip" title="' + row.customer.company + '">' + value + '</div>'
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'customer.company',
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
                        var value = type === 'display' && data.length > 15 ? data.substring(0, 15) + '..' : data;
                        return '<div data-toggle="tooltip" title="' + data + '">' + value + '</div>'
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
                    data: 'progressInv',
                    name: 'progressInv'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                }
            ],
        });
        // $('.col-12').on('click', '#in', function() {
        $('#cust_id, #pmName, #status, #sales, #sponsors, #hasAsana').on('change', function() {
            $('#salesId').val($('#sales').val());
            $('#pmId').val($('#pmName').val());
            $('#custId').val($('#cust_id').val());
            $('#sponsor').val($('#sponsors').val());

            $('#example1').data('dt_params', {
                'cust_id': $('#custId').val(),
                'pmName': $('#pmId').val(),
                'status': $('#status').val(),
                'salesId': $('#salesId').val(),
                'sponsors': $('#sponsor').val(),
                'hasAsana': $('#hasAsana').val(),
            });
            $('#example1').DataTable().draw();
        });
        $('.col-12').on('click', '#clear', function() {
            $('#sales').val('#').trigger('change');
            $('#cust_id').val('#').trigger('change');
            $('#pmName').val('#').trigger('change');
            $('#status').val('#').trigger('change');
            $('#sponsors').val('#').trigger('change');
            $('#hasAsana').val('#').trigger('change');

            $('#salesId').val("#");
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