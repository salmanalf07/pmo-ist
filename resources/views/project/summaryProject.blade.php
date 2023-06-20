@extends('/project/navbarInput')

@section('inputan')
<style>
    #initial-container {
        position: relative;
        display: inline-block;
    }

    #initial-circle {
        position: relative;
        width: 2em;
        height: 2em;
        border-radius: 50%;
        background-color: #f1f1f1;
        color: #333;
        font-size: 1em;
        font-weight: bold;
        text-align: center;
        line-height: 2em;
        cursor: pointer;
    }

    #initial-circle::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 30%;
        transform: translateX(-20%);
        background-color: rgba(0, 0, 0, 0.8);
        color: #fff;
        padding: 3px 12px;
        font-size: 8pt;
        border-radius: 4px;
        white-space: nowrap;
        visibility: hidden;
        opacity: 0;
        transition: visibility 0s, opacity 0.3s linear;
    }

    #initial-circle:hover::before {
        visibility: visible;
        opacity: 1;
    }
</style>
<div>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-12">
            <!-- card -->
            <div class="card mb-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="mb-2 col-12 h3">
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
                        <br>
                        <span class="h5">Project Member</span>
                        <br>
                        <div class="avatar-group">
                            <span class="avatar avatar-sm">
                                <div id="initial-container">
                                    <div class="initial-container" id="initial-circle" data-tooltip="SALMAN ALF"></div>
                                </div>
                            </span>
                            <span class="avatar avatar-sm">
                                <div id="initial-container">
                                    <div class="initial-container" id="initial-circle" data-tooltip="ANWAR NASIHIN"></div>
                                </div>
                            </span>
                            <span class="avatar avatar-sm">
                                <div id="initial-container">
                                    <div class="initial-container" id="initial-circle" data-tooltip="YOVAN ANDIKA"></div>
                                </div>
                            </span>
                            <!-- <span class="avatar avatar-sm avatar-primary">
                                <span class="avatar-initials rounded-circle
                        fs-6">+5</span>
                            </span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getInitials(name) {
        const words = name.split(' ');
        let initials = '';

        for (let i = 0; i < words.length; i++) {
            const word = words[i];
            if (word[0] === word[0].toUpperCase()) {
                initials += word[0];
            }
        }

        return initials.substring(0, 2);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const initialContainers = document.getElementsByClassName('initial-container');
        for (let i = 0; i < initialContainers.length; i++) {
            const div = initialContainers[i];
            const name = div.dataset.tooltip;
            const initials = getInitials(name);
            div.setAttribute('id', 'initial-circle');
            div.innerHTML = initials;
        }
    });
</script>
@endsection