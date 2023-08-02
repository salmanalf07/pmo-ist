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
                <div class="col-xl-12 col-lg-6 mb-5">
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
                                        @foreach($numberOfProject as $data)
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
            </div>
        </div>
    </div>
</div>


@endsection