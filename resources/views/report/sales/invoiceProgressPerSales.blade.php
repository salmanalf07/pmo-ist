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
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="row col-7">
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
                                    <div class="mb-3 col-6">
                                        <label class="form-label">PO Date Range</label>
                                        <div class="input-group me-3">
                                            <input type="text" class="form-control float-right" id="reservation">
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Invoice Progress</label>
                                        <select name="status" id="status" class="select2" aria-label="Default select example" required>
                                            <option value="all">All</option>
                                            <option value="progress">In Progress</option>
                                            <option value="completed">Completed</option>
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
                                    <div class="mb-3 col-3">
                                        <form method="post" role="form" id="form-print" action="/r_sales/exportInvoiceProgressPerSales" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                            @csrf
                                            <input type="text" id="salesId" name="salesId" value="#" hidden>
                                            <input type="text" id="statusId" name="statusId" value="#" hidden>
                                            <input type="text" id="date_st" name="date_st" value="#" hidden>
                                            <input type="text" id="date_ot" name="date_ot" value="#" hidden></input>
                                            <button id="export" type="submit" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Invoice Progress" class="btn btn-secondary-soft mb-5" style="width:100%">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="red" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z" />
                                                </svg>
                                            </button>
                                            <button type="submit" formaction="/r_sales/exportInvoiceSummaryPerSales" class="btn btn-secondary-soft" style="width:100%" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Invoice Summary"> <!-- Ubah URL pada formaction sesuai kebutuhan -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="blue" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z" />
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                    <div class="mb-3 col-6">
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
                                <p>{{$judul}}</p>
                            </div>
                        </div>
                        <!-- table -->
                        <div class="table-responsive" style="border:0">
                            <table id="example1" class="table text-nowrap table-centered mt-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="text-align: center;">Sales Name</th>
                                        <th style="text-align: center;">Customer</th>
                                        <th style="text-align: center;">Project Name</th>
                                        <th style="text-align: center;">PO Date</th>
                                        <th style="text-align: center;">PO Number</th>
                                        <th style="text-align: center;">PO Value</th>
                                        <th style="text-align: center;">Invoiced</th>
                                        <th style="text-align: center;">%</th>
                                        <th style="text-align: center;">Outstanding</th>
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
                    "targets": [5, 6, 7, 8], // table ke 1
                }, {
                    targets: [3],
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    }
                },
                {
                    targets: [5, 6, 7, 8],
                    render: $.fn.dataTable.render.number('.', '.', 0)
                },
            ],
            order: [
                [0, 'asc']
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

                $('#totRecord').html(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            },
            ajax: {
                url: '/r_sales/json_invoiceProgressPerSales',
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
                    data: 'sales',
                    render: function(data, type, row) {
                        if (data != null) {
                            var value = type === 'display' && data.length > 15 ? data.substring(0, 15) : data;
                            return '<div data-toggle="tooltip" title="' + data + '">' + value + '</div>'
                        }
                        return '';
                    }
                },
                {
                    data: 'customer',
                    name: 'customer',
                },
                {
                    data: 'projectNamee',
                    name: 'projectNamee',
                },
                {
                    data: 'contractDate',
                    name: 'contractDate',
                },
                {
                    data: 'noContract',
                    name: 'noContract',
                    render: function(data, type, row) {
                        if (data != null) {
                            var value = type === 'display' && data.length > 10 ? data.substring(0, 10) + '..' : data;
                            return '<div data-toggle="tooltip" title="' + data + '">' + value + '</div>'
                        }
                        return '';
                    }
                },
                {
                    data: 'projectValuePPN',
                    name: 'projectValuePPN',
                },
                {
                    data: 'invoiced',
                    name: 'invoiced',
                },
                {
                    data: 'progresPercen',
                    name: 'progresPercen',
                },
                {
                    data: 'outstanding',
                    name: 'outstanding',
                },
            ],
        });
        $('.col-12').on('click', '#clear', function() {
            $('#sales').val('#').trigger('change');
            $('#status').val('#').trigger('change');

            $('#statusId').val('#');
            $('#salesId').val("#");
            $('#date_st').val("#");
            $('#date_ot').val("#");
            $('#example1').data('dt_params', {});
            $('#example1').DataTable().draw();
        });
        $('#sales, #status').on('change', function() {
            $('#salesId').val($('#sales').val());
            $('#statusId').val($('#status').val());
            $('#example1').data('dt_params', {
                'salesId': $('#salesId').val(),
                'statusId': $('#status').val(),
                'date_st': $('#date_st').val(),
                'date_ot': $('#date_ot').val(),
            });
            $('#example1').DataTable().draw();
            // console.log(date)
        });

        $('.col-12').on('change', '#reservation', function() {
            var date = $('#reservation').val().split(" - ");
            $('#date_st').val(date[0]);
            $('#date_ot').val(date[1]);
            $('#example1').data('dt_params', {
                'date_st': $('#date_st').val(),
                'date_ot': $('#date_ot').val(),
                'salesId': $('#salesId').val(),
                'statusId': $('#status').val(),
            });
            $('#example1').DataTable().draw();
            // console.log(date)
        });

    })
</script>
@endsection