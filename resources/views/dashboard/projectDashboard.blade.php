@extends('index')

@section('konten')
<div id="app-content">
    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">

                            <h4 class="mb-0">Visitors</h4>
                            <div>

                                <div>
                                    <select class="form-select form-select-sm">
                                        <option selected="">Today</option>
                                        <option value="Yesterday">Yesterday</option>
                                        <option value="Last 7 Days">Last 7 Days</option>
                                        <option value="Last 30 Days">Last 30 Days</option>
                                        <option value="This Month">This Month</option>
                                        <option value="Last Month">Last Month</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div id="visitorBlog"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-6 col-md-12 col-12 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="mb-0">Project By Sector</h4>
                            <div class="row row-cols-lg-3  my-8">
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Desktop</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-info mb-0 ">51.5%</h4>
                                            <span class="text-info">201,434</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Mobile</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-success mb-0 ">34.4%</h4>
                                            <span class="text-success">134,693</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Tablet</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-warning mb-0 ">20.8%</h4>
                                            <span class="text-warning">81,525</span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="mt-6 mb-3">
                                <div class="progress" style="height: 40px;">
                                    <div class="progress-bar bg-info" role="progressbar" aria-label="Segment one" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-success" role="progressbar" aria-label="Segment two" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-warning" role="progressbar" aria-label="Segment three" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12 col-12 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="mb-0">Project By Type</h4>
                            <div class="row row-cols-lg-3  my-8">
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Desktop</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-info mb-0 ">51.5%</h4>
                                            <span class="text-info">201,434</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Mobile</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-success mb-0 ">34.4%</h4>
                                            <span class="text-success">134,693</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mb-3">Tablet</h4>
                                        <div class="lh-1">
                                            <h4 class="fs-2 fw-bold text-warning mb-0 ">20.8%</h4>
                                            <span class="text-warning">81,525</span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="mt-6 mb-3">
                                <div class="progress" style="height: 40px;">
                                    <div class="progress-bar bg-info" role="progressbar" aria-label="Segment one" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-success" role="progressbar" aria-label="Segment two" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-warning" role="progressbar" aria-label="Segment three" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection