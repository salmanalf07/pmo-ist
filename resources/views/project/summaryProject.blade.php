@extends('/project/navbarInput')

@section('inputan')
<div>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-12">
            <!-- card -->
            <div class="card mb-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="mb-2 col-12 h3" style="font-size: 1.2rem;">
                            <span>{{$data->projectName}}</span>
                            <br>
                            <?php
                            // Mendapatkan tanggal saat ini
                            $currentDate = date('Y-m-d');

                            // Menghitung 1 bulan sebelum tanggal yang ditentukan
                            $oneMonthBeforeCustomDate = date('Y-m-d', strtotime('-1 month', strtotime($data->contractEnd)));

                            // Memeriksa apakah tanggal saat ini berada di dalam rentang 1 bulan
                            if ($currentDate >= $oneMonthBeforeCustomDate) {
                                // Jika iya, ubah warna teks menjadi merah
                                echo '<span class="h5">Contract Start Date (' . date("d M Y", strtotime($data->contractStart)) . ') – Contract End Date (<span style="color: red;">' . date("d M Y", strtotime($data->contractEnd)) . '</span>)</span>';
                            } else {
                                echo '<span class="h5">Contract Start Date (' . date("d M Y", strtotime($data->contractStart)) . ') – Contract End Date (' . date("d M Y", strtotime($data->contractEnd)) . ')</span>';
                            }
                            ?>

                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                            <!-- card -->
                            <div class="card h-100 card-lift">
                                <!-- card body -->
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Progress</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase">
                                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div class="lh-1">
                                        <h1 class=" mb-1 fw-bold">{{$data->overAllProg}}%</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                            <!-- card -->
                            <div class="card h-100 card-lift">
                                <!-- card body -->
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Invoiced</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48" />
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div class="lh-1">
                                        <h1 class=" mb-1 fw-bold">{{$invoiced}}%</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                            <!-- card -->
                            <div class="card h-100 card-lift">
                                <!-- card body -->
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Payment</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 1v22m5-18H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div class="lh-1">
                                        @if($payment == 0)
                                        <h1 class=" mb-1 fw-bold text-danger">{{$payment}}%</h1>
                                        @elseif($payment > 0 && $payment < 50) <h1 class=" mb-1 fw-bold text-warning">{{$payment}}%</h1>
                                            @elseif ($payment >= 50 && $payment <= 100) <h1 class=" mb-1 fw-bold">{{$payment}}%</h1>
                                                @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                            <!-- card -->
                            <div class="card h-100 card-lift">
                                <!-- card body -->
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Status</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                    <path d="m23 6l-9.5 9.5l-5-5L1 18" />
                                                    <path d="M17 6h6v6" />
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div class="lh-1">
                                        <h3 class=" mb-1 fw-bold {{$color}}">{{$status}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <span class="h5">Project Member</span>
                        <br>
                        <div class="avatar-group">
                            @foreach($employee as $dataa)
                            <span class="avatar avatar-md">
                                <div id="initial-container">
                                    <div class="initial-container" id="initial-circle" data-tooltip="{{$dataa['employees']['name']}}"></div>
                                </div>
                            </span>
                            @endforeach
                            @if($employeeCount > 0)
                            <span class="avatar avatar-md">
                                <div id="initial-container">
                                    <div class="initial-container" id="initial-circle" data-tooltip="+ {{$employeeCount}}"></div>
                                </div>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection