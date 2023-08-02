@extends('index')

@section('konten')
<style>
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
                            <div class="row col-12">
                                <div>
                                    <label class="form-label">Project Manager</label>
                                    <br>
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
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-cardd">
                                <table id="example1" class="table text-nowrap table-centered mt-0" style="width: 100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Customer</th>
                                            <th>ProjectName</th>
                                            <!-- <th>Contract Status</th> -->
                                            <th>% Progress</th>
                                            <th>% invoiced</th>
                                            <th>% Payment</th>
                                            <th># Team</th>
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
                    "targets": [2, 3, 4, 5], // table ke 1
                }, ],
                ajax: {
                    url: '{{ url("json_projectDetail") }}',
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
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'projectName',
                        name: 'projectName',
                        render: function(data, type, row) {
                            return type === 'display' && data.length > 30 ? data.substring(0, 30) + '..' : data;
                        }
                    },
                    {
                        data: 'progress',
                        name: 'progress'
                    },
                    {
                        data: 'invoiced',
                        name: 'invoiced'
                    },
                    {
                        data: 'payment',
                        name: 'payment'
                    },
                    {
                        data: 'team',
                        name: 'team'
                    },
                ],
            });
            $('#company').on('change', function() {
                $('#example1').data('dt_params', {
                    'company': $('#company').val(),
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