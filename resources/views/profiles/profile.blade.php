@extends('/profiles/navbarPmo')

@section('pmo')
<style>
    table.dataTable td {
        font-size: 1.1em;
    }

    table.dataTable tr.dtrg-level-0 td {
        font-size: 1.1em;
    }
</style>
<!-- row -->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header d-md-flex border-bottom-0">
                        <div class="card-body">
                            <div id="visitorBlog"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table id="example1" class="table text-nowrap table-centered mt-0" style="width: 100%">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>Name</th>
                                        <th class="text-center">Number Of Project</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1 ?>
                                    @foreach ($project as $pmName => $projects)
                                    <tr>
                                        <td class="text-center">{{$no++}}</td>
                                        <td>
                                            <span class="avatar avatar-lg" style="margin-right: 0.5em;">
                                                <img alt="avatar" src="{{asset('assets/images/avatar/avatar-11.jpg')}}" class="rounded-circle">
                                            </span>
                                            {{$pmName}} <a style="margin-left: 0.5em;" href="#" id="detailModals" data-id="{{$projects[0]->pm?$projects[0]->pm->id:'#'}}" data-bs-toggle="tooltip" data-placement="top" title="Detail Data"><i class="bi bi-info-circle"></i>
                                        </td>
                                        <td class="text-center">{{count($projects)}}</td>
                                        <td>{{number_format($projects->sum('projectValue'), 0, '', '.');}}</td>
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
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script>

@endsection