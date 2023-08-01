@extends('index')

@section('konten')
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div id="app-content">
    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div>
                <!-- row -->
                <div class="row mb-3">
                    <div class="col-12 mb-3">
                        <form method="post" role="form" id="form-filter" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="selectOne">Employee</label>
                                            <select name="name" id="name" class="select2" aria-label="Default select example" required>
                                                <option value="#" selected>Open this select menu</option>
                                                @foreach($employee as $employees)
                                                <option value="{{$employees->id}}">{{$employees->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- <div class="mb-3 col-3">
                                            <label class="form-label">Date Range</label>
                                            <div class="input-group me-3">
                                                <input type="text" class="form-control float-right" id="reservation">
                                                <div class="input-group-append custom-picker">
                                                    <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="mb-3 col-4">
                                            <label class="form-label">Available Date</label>
                                            <div class="input-group me-3 datepicker">
                                                <input id="availableAt" name="availableAt" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                                <div class="input-group-append custom-picker">
                                                    <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <label class="form-label" for="selectOne">Project Name</label>
                                            <select name="projectId" id="projectId" class="select2" aria-label="Default select example" required>
                                                <option value="#" selected>Open this select menu</option>
                                                @foreach($project as $projects)
                                                <option value="{{$projects->id}}">{{$projects->projectName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 pt-7 col-1">
                                            <button id="clear" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Clear" class="btn btn-danger-soft" style="width:100%">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                    <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-md-flex border-bottom-0">
                                <div class="flex-grow-1">
                                </div>
                                <div class="justify-content-end">
                                    <p>Employee - {{$judul}}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table id="example1" class="table text-nowrap table-centered mt-0" style="width: 100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th>
                                                    No
                                                </th>
                                                <th>Nama Karyawan</th>
                                                <th>Department</th>
                                                <th>Division</th>
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

        $('select.select2:not(.normal)').each(function() {
            $(this).select2({
                dropdownParent: $(this).parent().parent()
            });
        });

        flatpickr("#availableAt", {
            dateFormat: "d/m/Y",
            defaultDate: new Date(),
            allowInput: true, // Mengizinkan input manual
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
                "targets": [0, 5, 6], // table ke 1
            }, {
                targets: [5, 6],
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
                    data: function(row) {
                        if (row.employee.department && row.employee.department.department) {
                            return row.employee.department.department; // Mengembalikan nilai properti name jika ada
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'employeedepartment.department'
                },
                {
                    data: function(row) {
                        if (row.employee.divisi && row.employee.divisi.division) {
                            return row.employee.divisi.division; // Mengembalikan nilai properti name jika ada
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'employee.divisi.division'
                },
                {
                    data: function(row, type) {
                        if (row.project && row.project.projectName) {
                            var data = row.project.projectName;
                            return type === 'display' && data.length > 30 ? data.substring(0, 30) + '..' : data;
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'project.projectName',
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
        $('#availableAt').on('change', function() {
            // var date = $('#reservation').val().split(" - ");
            // if ($(this).attr('id') === 'reservation') {
            //     var dateChange = "true";
            // } else {
            //     var dateChange = "false";
            // }
            // console.log(dateChange);
            $('#example1').data('dt_params', {
                // 'dateChange': dateChange,
                // 'date_st': date[0],
                // 'date_ot': date[1],
                'name': $('#name').val(),
                'projectId': $('#projectId').val(),
                'availableAt': $('#availableAt').val(),

            });
            $('#example1').DataTable().draw();
            // console.log(date)
        });
        $('#name, #projectId').on('change', function() {
            $('#example1').data('dt_params', {
                // 'dateChange': dateChange,
                // 'date_st': date[0],
                // 'date_ot': date[1],
                'name': $('#name').val(),
                'projectId': $('#projectId').val(),

            });
            $('#example1').DataTable().draw();
            // console.log(date)
        });
        $('.col-12').on('click', '#clear', function() {
            $('#name').val('#').trigger('change');
            $('#projectId').val('#').trigger('change');

            $('#example1').data('dt_params', {});
            $('#example1').DataTable().draw();


        });
    });
</script>



@endsection