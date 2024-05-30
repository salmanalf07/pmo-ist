@extends('index')

@section('konten')
<!-- custom select2 -->
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<style>
    .icon-green path {
        fill: green;
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
                                <div class="row col-7">
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Date Range</label>
                                        <div class="input-group me-3">
                                            <input type="text" class="form-control float-right" id="reservation">
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="selectOne">Sales</label>
                                        <select name="sales[]" id="sales" multiple="multiple" class="select2" aria-label="Default select example">
                                            @foreach(collect($employee->unique('sales'))->sortBy('sales->name') as $employees)
                                            @if($employees->saless != null)
                                            <option value="{{$employees->saless['id']}}">{{$employees->saless['name']}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row col-5 pt-7 ms-3">
                                    <div class="mb-3 col-3">
                                        <button id="clear" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Clear" class="btn btn-danger-soft" style="width:100%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <form method="post" role="form" id="form-print" action="financeTermsStatExport" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                            @csrf
                                            <input type="text" id="date_st" name="date_st" hidden>
                                            <input type="text" id="date_ot" name="date_ot" hidden>
                                            <input type="text" id="salesId" name="salesId" value="#" hidden>
                                            <button id="export" type="submit" class="btn btn-success-soft" style="width:100%">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20">
                                                    <path fill="currentColor" d="M15.534 1.36L14.309 0H4.662c-.696 0-.965.516-.965.919v3.63H5.05V1.653c0-.154.13-.284.28-.284h6.903c.152 0 .228.027.228.152v4.82h4.913c.193 0 .268.1.268.246v11.77c0 .246-.1.283-.25.283H5.33a.287.287 0 0 1-.28-.284V17.28H3.706v1.695c-.018.6.302 1.025.956 1.025H18.06c.7 0 .939-.507.939-.969V5.187l-.35-.38l-3.116-3.446Zm-1.698.16l.387.434l2.596 2.853l.143.173h-2.653c-.2 0-.327-.033-.38-.1c-.053-.065-.084-.17-.093-.313V1.52Zm-1.09 9.147h4.577v1.334h-4.578v-1.334Zm0-2.666h4.577v1.333h-4.578V8Zm0 5.333h4.577v1.334h-4.578v-1.334ZM1 5.626v10.667h10.465V5.626H1Zm5.233 6.204l-.64.978h.64V14H3.016l2.334-3.51l-2.068-3.156H5.01L6.234 9.17l1.223-1.836h1.727L7.112 10.49L9.449 14H7.656l-1.423-2.17Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="mb-3 col-5">
                                        <p class="p-2 rounded-2 text-center  bg-primary-soft" id="totRecord"></p>
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

                            </div>
                            <div class="justify-content-end">
                                <p>Finance - {{$judul}}</p>
                            </div>
                        </div>
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
                                        <th>BAST</th>
                                        <th>Invoice</th>
                                        <th>Payment</th>
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
            if (elementId === 'sales') {
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

        $('#reservation').daterangepicker({
            startDate: moment().startOf('month'), // Mengatur tanggal awal ke awal bulan ini
            endDate: moment().endOf('month'), // Mengatur tanggal akhir ke akhir bulan ini
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function(start, end) {
            var dateinn = start.format('YYYY-MM-DD');
            var dateenn = end.format('YYYY-MM-DD');
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
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": true,
            "columnDefs": [{
                    "className": "text-end",
                    "targets": [4], // table ke 1
                },
                {
                    "className": "text-center",
                    "targets": [5, 6, 7], // table ke 1
                },
                {
                    targets: [4],
                    render: $.fn.dataTable.render.number('.', '.', 0)
                },
            ],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();
                // Remove the formatting to get integer data for summation
                var intVal = function(i) {

                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;

                };

                // Total over all pages

                if (api.column(4).data().length) {
                    var total = api
                        .column(4)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        })
                } else {
                    total = 0
                };

                $('#totRecord').html(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            },
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
                    name: 'project.customer.company',
                    render: function(data, type, row) {
                        var value = type === 'display' && data.length > 10 ? data.substring(0, 10) + '...' : data;
                        return '<div data-toggle="tooltip" title="' + data + '">' + value + '</div>'
                    }
                },
                {
                    data: 'projectNamee',
                    name: 'projectNamee'
                },
                {
                    data: 'project.noContract',
                    name: 'project.noContract',
                    render: function(data, type, row) {
                        if (data != null) {
                            var value = type === 'display' && data.length > 10 ? data.substring(0, 10) + '...' : data;
                            return '<div data-toggle="tooltip" title="' + data + '">' + value + '</div>'
                        }
                        return '';
                    }
                },
                {
                    data: 'termsName',
                    name: 'termsName',
                    render: function(data, type, row) {
                        if (data != null) {
                            var value = type === 'display' && data.length > 10 ? data.substring(0, 10) + '...' : data;
                            return '<div data-toggle="tooltip" title="' + data + '">' + value + '</div>'
                        }
                        return '';
                    }
                },
                {
                    data: 'termsValuePPN',
                    name: 'termsValuePPN',
                },
                {
                    data: 'bastMain',
                    name: 'bastMain',
                    render: function(data, type, row) {
                        var icon = '';
                        if (data == 1) {
                            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle icon-green" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/></svg>';
                        }
                        return icon;
                    }
                },
                {
                    data: 'invMain',
                    name: 'invMain',
                    render: function(data, type, row) {
                        var icon = '';
                        if (data == 1) {
                            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle icon-green" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/></svg>';
                        }
                        return icon;
                    }
                },
                {
                    data: 'payMain',
                    name: 'payMain',
                    render: function(data, type, row) {
                        var icon = '';
                        if (data == 1) {
                            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle icon-green" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/></svg>';
                        }
                        return icon;
                    }
                },
            ],
        });
        $('.col-12').on('click', '#clear', function() {
            $('#sales').val('#').trigger('change');

            $('#date_st').val("#");
            $('#date_ot').val("#");
            $('#salesId').val("#");
            $('#example1').data('dt_params', {});
            $('#example1').DataTable().draw();
        });
        $('.col-12').on('change', '#reservation', function() {
            var date = $('#reservation').val().split(" - ");
            $('#date_st').val(date[0])
            $('#date_ot').val(date[1])
            $('#example1').data('dt_params', {
                'date_st': $('#date_st').val(),
                'date_ot': $('#date_ot').val(),
                'salesId': $('#salesId').val(),
            });
            $('#example1').DataTable().draw();
            // console.log(date)
        });
        $('.col-12').on('change', '#sales', function() {
            $('#salesId').val($('#sales').val());
            $('#example1').data('dt_params', {
                'date_st': $('#date_st').val(),
                'date_ot': $('#date_ot').val(),
                'salesId': $('#salesId').val(),
            });
            $('#example1').DataTable().draw();
            // console.log(date)
        });
    })
</script>
@endsection