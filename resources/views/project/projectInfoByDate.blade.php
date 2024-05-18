@extends('index')

@section('konten')
<!-- custom select2 -->
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<style>
    .icon-red path {
        fill: red;
    }
</style>
<div id="app-content">

    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <!-- row -->

            <div class="row mb-3">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="row col-10">
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="selectOne">Customer</label>
                                        <select name="cust_ids" id="cust_ids" class="select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($customer as $customer)
                                            <option value="{{$customer->id}}">{{strtoupper($customer->company)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Project Manager</label>
                                        <select name="pmNames" id="pmNames" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($pm->unique('pmName') as $pmName)
                                            @if($pmName->pm != null)
                                            <option value="{{$pmName->pm->id}}">{{$pmName->pm->name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Contract Status</label>
                                        <select name="conStatuss" id="conStatuss" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            <option value="all">All</option>
                                            <option value="active">Active</option>
                                            <option value="exp">Expired</option>
                                            <option value="none">None</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Project Status</label>
                                        <select name="projStatuss" id="projStatuss" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            <option value="all">All</option>
                                            <option value="progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row col-2 pt-7 ms-3">
                                    <div class="mb-3 col-6">
                                        <button id="clear" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Clear" class="btn btn-danger-soft" style="width:100%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <form method="post" role="form" id="form-print" action="/projInfoByDateExport" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                            @csrf
                                            <input type="text" id="cust_id" name="cust_id" value="#" hidden>
                                            <input type="text" id="pmName" name="pmName" value="#" hidden>
                                            <input type="text" id="conStatus" name="conStatus" value="#" hidden>
                                            <input type="text" id="projStatus" name="projStatus" value="#" hidden>
                                            <button id="export" type="submit" class="btn btn-success-soft" style="width:100%">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20">
                                                    <path fill="currentColor" d="M15.534 1.36L14.309 0H4.662c-.696 0-.965.516-.965.919v3.63H5.05V1.653c0-.154.13-.284.28-.284h6.903c.152 0 .228.027.228.152v4.82h4.913c.193 0 .268.1.268.246v11.77c0 .246-.1.283-.25.283H5.33a.287.287 0 0 1-.28-.284V17.28H3.706v1.695c-.018.6.302 1.025.956 1.025H18.06c.7 0 .939-.507.939-.969V5.187l-.35-.38l-3.116-3.446Zm-1.698.16l.387.434l2.596 2.853l.143.173h-2.653c-.2 0-.327-.033-.38-.1c-.053-.065-.084-.17-.093-.313V1.52Zm-1.09 9.147h4.577v1.334h-4.578v-1.334Zm0-2.666h4.577v1.333h-4.578V8Zm0 5.333h4.577v1.334h-4.578v-1.334ZM1 5.626v10.667h10.465V5.626H1Zm5.233 6.204l-.64.978h.64V14H3.016l2.334-3.51l-2.068-3.156H5.01L6.234 9.17l1.223-1.836h1.727L7.112 10.49L9.449 14H7.656l-1.423-2.17Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <th>Project Id</th>
                                        <th>Customer</th>
                                        <th>Sales</th>
                                        <th>Project Name</th>
                                        <th>SPK</th>
                                        <th>Contract Start Date</th>
                                        <th>Contract End Date</th>
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
            "columnDefs": [{
                "className": "text-center",
                "targets": [0], // table ke 1
            }, {
                targets: [4, 5],
                render: function(oTable) {
                    return moment(oTable).format('DD-MM-YYYY');
                }
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
                    data: 'customer.company',
                    name: 'customer.company',
                    render: function(data, type, row) {
                        var value = type === 'display' && data.length > 15 ? data.substring(0, 15) + '..' : data;
                        return '<div data-toggle="tooltip" title="' + data + '">' + value + '</div>'
                    }
                },
                {
                    data: function(row) {
                        if (row.saless && row.saless.name) {
                            const initials = getInitials(row.saless.name);
                            return '<span class="avatar avatar-md flexCenter">' +
                                '<div id="initial-container">' +
                                '<div class="initial-container" style="font-size:1em" id="initial-circle" data-tooltip="' + row.saless.name + '">' + initials + '</div>' +
                                '</div>' +
                                '</span>';
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'saless.name',
                },
                {
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
                        var value = type === 'display' && data.length > 12 ? data.substring(0, 12) + '..' : data;
                        return '<div data-toggle="tooltip" title="' + data + '">' + value + '</div>'
                    }
                },
                {
                    data: 'contractStart',
                    name: 'contractStart',
                },
                {
                    data: 'contractEnd',
                    name: 'contractEnd',
                    render: function(data, type, row) {
                        var contractEnd = moment(data); // Pastikan Anda sudah mengimpor moment.js jika belum dilakukan sebelumnya.
                        var today = moment();
                        var icon = '';

                        if (contractEnd.isSame(today, 'day') || contractEnd.isBefore(today, 'day')) {
                            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle icon-red" viewBox="0 0 16 16">  <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/><path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/></svg>';
                        }

                        return contractEnd.format('DD-MM-YYYY') + " " + icon;
                    }
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
        $('#cust_ids, #pmNames, #conStatuss, #projStatuss').on('change', function() {

            $('#cust_id').val($('#cust_ids').val());
            $('#pmName').val($('#pmNames').val());
            $('#projStatus').val($('#projStatuss').val());
            $('#conStatus').val($('#conStatuss').val());

            $('#example1').data('dt_params', {
                'cust_id': $('#cust_ids').val(),
                'pmName': $('#pmNames').val(),
                'conStatus': $('#conStatuss').val(),
                'status': $('#projStatuss').val(),
            });
            $('#example1').DataTable().draw();
        });
        $('.col-12').on('click', '#clear', function() {
            $('#cust_id').val('#');
            $('#pmName').val('#');
            $('#projStatus').val('#');
            $('#conStatus').val('#');


            $('#cust_ids').val('#').trigger('change.select2');
            $('#pmNames').val('#').trigger('change.select2');
            $('#projStatuss').val('#').trigger('change.select2');
            $('#conStatuss').val('#').trigger('change.select2');
            $('#example1').data('dt_params', {});
            $('#example1').DataTable().draw();
        });

    })
</script>
@endsection