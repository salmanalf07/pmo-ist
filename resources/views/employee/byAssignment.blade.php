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
                                            <label class="form-label">Date Range</label>
                                            <div class="input-group me-3">
                                                <input type="text" class="form-control float-right" id="reservation">
                                                <div class="input-group-append custom-picker">
                                                    <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                                </div>
                                            </div>
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
                                                <th>
                                                    No
                                                </th>
                                                <th>Nama Karyawan</th>
                                                <th>Dept/Div</th>
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
                url: '{{ url("json_ByAssignment") }}',
                data: function(d) {
                    // Retrieve dynamic parameters
                    var dt_params = $('#example1').data('dt_params');
                    // Add dynamic parameters to the data object sent to the server
                    if (dt_params) {
                        $.extend(d, dt_params);
                    }
                }
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'employee.name',
                    name: 'employee.name'
                },
                {
                    data: 'employee.divisi.division',
                    name: 'employee.divisi.division'
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
        $('.col-6').on('change', '#reservation', function() {
            var date = $('#reservation').val().split(" - ");
            $('#example1').data('dt_params', {
                'date_st': date[0],
                'date_ot': date[1],
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