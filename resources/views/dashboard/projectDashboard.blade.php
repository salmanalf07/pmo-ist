@extends('index')

@section('konten')
<style>
    .icon-red path {
        fill: red;
    }

    .icon-green path {
        fill: green;
    }

    .icon-yellow path {
        fill: yellow;
    }

    .col-xl-2 {
        width: 20%;
    }

    .table-card {
        max-height: 43em;
        /* Adjust the height as per your requirement */
        overflow-y: auto;
        /* Enable vertical scrolling */
    }

    .col {
        width: 25%;
    }
</style>
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div id="app-content">
    <div class="app-content-area pt-0 ">
        <div class="pt-12 pb-21 "></div>
        <div class="container-fluid mt-n22 ">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                </div>
            </div>
            <!-- row  -->
            <div class="row ">
                <div class="col-xl-7 col-lg-6 mb-5">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">

                            <h4 class="mb-0">Utilization</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table text-nowrap mb-0 table-centered">
                                    <thead class="table-light" style="position: sticky;top: 0;">
                                        <tr>
                                            <th>Project Manager</th>
                                            <th class="text-center">Number of Project</th>
                                            <th class="text-center">%</th>
                                            <th class="text-end">Total Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(collect($numberOfProject)->sortByDesc('revenue') as $data)
                                        <tr>
                                            <td>{{$data['name']}}</td>
                                            <td class="text-center">{{$data['numberOfProject']}}</td>
                                            <td class="text-center">{{$data['persen']}}</td>
                                            <td class="text-end">{{number_format($data['revenue'],0,',','.')}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 mb-5">
                    <div class="card h-100" style="background-color: grey;">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 mb-5">
                    <div class="card h-100">
                        <div class="card-header d-md-flex border-bottom-0">
                            <div class="row col-4">
                                <div>
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
                        <div class="card-body">
                            <div class="table-responsive table-cardd">
                                <table id="example1" class="table text-nowrap table-centered mt-0" style="width: 100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Customer</th>
                                            <th>ProjectName</th>
                                            <th>Contract Status</th>
                                            <th>Progress</th>
                                            <th>invoiced</th>
                                            <th>Payment</th>
                                            <th>Team</th>
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
                    "targets": [2, 3, 4, 5, 6], // table ke 1
                }, ],
                ajax: {
                    url: '{{ url("json_projectDetail") }}',
                    data: function(d) {
                        // Retrieve dynamic parameters
                        var dt_params = $('#example1').data('dt_params');
                        // Add dynamic parameters to the data object sent to the server
                        console.log(dt_params);
                        if (dt_params) {
                            $.extend(d, dt_params);
                        }
                    }
                },
                columns: [{
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'projectNamee',
                        name: 'projectNamee',
                    },
                    {
                        data: 'contractEnd',
                        name: 'contractEnd',
                        render: function(data, type, row) {
                            var contractEnd = moment(data); // Pastikan Anda sudah mengimpor moment.js jika belum dilakukan sebelumnya.
                            var today = moment();
                            var icon = '';

                            // Hitung selisih antara tanggal kontrak berakhir dengan tanggal hari ini dalam satuan hari.
                            var diffInDays = contractEnd.diff(today, 'days');

                            if (diffInDays > 0) {
                                // Jika selisih lebih dari 0, maka tampilkan ikon hijau.
                                icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle icon-green" viewBox="0 0 16 16"> <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm2.97 5.97l-4.267 4.268L5.03 7.636a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l5-5a.75.75 0 1 0-1.06-1.06z"/> </svg>';
                            } else if (diffInDays >= -30) {
                                // Jika selisih kurang dari atau sama dengan 30 hari, tampilkan ikon kuning.
                                icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle icon-yellow" viewBox="0 0 16 16"> <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm2.97 5.97l-4.267 4.268L5.03 7.636a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l5-5a.75.75 0 1 0-1.06-1.06z"/> </svg>';
                            } else {
                                // Selain dari dua kondisi di atas, tampilkan ikon merah.
                                icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle icon-red" viewBox="0 0 16 16"> <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm2.97 5.97l-4.267 4.268L5.03 7.636a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l5-5a.75.75 0 1 0-1.06-1.06z"/> </svg>';
                            }

                            return icon;
                        }
                    },
                    {
                        data: 'progress',
                        name: 'progress'
                    },
                    {
                        data: 'invoiced',
                        name: 'invoiced',
                        render: function(data, type, row) {
                            return data + "%";
                        }
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        render: function(data, type, row) {
                            return data + "%";
                        }
                    },
                    {
                        data: 'team',
                        name: 'team'
                    },
                ],
            });
            $('#pmName').on('change', function() {
                $('#example1').data('dt_params', {
                    'pmName': $('#pmName').val(),
                });
                $('#example1').DataTable().draw();
                // console.log(date)
            });
            $('.col-12').on('click', '#clear', function() {
                $('#company').val('#').trigger('change');
                $('#example1').data('dt_params', {});
                $('#example1').DataTable().draw();
            });
        });
    </script>
    @endsection