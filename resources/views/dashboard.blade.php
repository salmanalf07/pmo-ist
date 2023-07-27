@extends('index')

@section('konten')
<style>
    .col-xl-2 {
        width: 20%;
    }
</style>
<div id="app-content">
    <div class="app-content-area pt-0 ">
        <div class="bg-primary pt-12 pb-21 "></div>
        <div class="container-fluid mt-n22 ">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                </div>
            </div>
            <div class="row">
                <div class="col-xl-2 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100 card-lift">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0"># On Going Projects</h4>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold">{{$projectOnGoing}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100 card-lift">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0"># New Projects</h4>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold">{{$projectThisYear}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100 card-lift">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Potential Revenue</h4>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold">{{$PotensialRevenue}}</h1>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-2 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100 card-lift">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Revenue New PO</h4>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold">{{$RevenueNewPo}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100 card-lift">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Invoiced</h4>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold">{{$invoiced}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row  -->
            <div class="row ">
                <div class="col-xl-5 col-12 mb-5">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Revenue</h4>
                            <div role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked>
                                <label class="btn btn-outline-white btn-sm" for="btnradio1">All</label>

                                <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
                                <label class="btn btn-outline-white btn-sm" for="btnradio2">1M</label>

                                <input type="radio" class="btn-check" name="btnradio" id="btnradio3">
                                <label class="btn btn-outline-white btn-sm" for="btnradio3">6M</label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio4">
                                <label class="btn btn-outline-white btn-sm" for="btnradio4">1Y</label>
                            </div>

                        </div>
                        <div class="card-body">
                            <div id="revenueChart"></div>
                            <div class="mt-4 px-lg-6 ">
                                <div class="row bg-light rounded-3 ">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="p-4">
                                            <span><i class="mdi mdi-circle small me-1 text-primary"></i>Current Week</span>
                                            <h3 class="mb-0  mt-2">$235,965</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="p-4">
                                            <span><i class="mdi mdi-circle small me-1 text-info"></i>Past Week</span>
                                            <h3 class="mb-0  mt-2">$198,214</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="p-4">
                                            <span>Today's Earning: </span>
                                            <h3 class="mb-0  mt-2">$2,562.30</h3>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 mb-5">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">

                            <h4 class="mb-0">Top Project Value</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table text-nowrap mb-0 table-centered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Customer</th>
                                            <th>Project Name</th>
                                            <th>Project Value</th>
                                            <th>Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($projectByValue as $project)

                                        <tr>
                                            <td>{{substr($project->customer->company, 0, 15)}}</td>
                                            <td>
                                                <h4 class="mb-0 fs-5"><a href="/project/summaryProject/{{$project->id}}" class="text-inherit" target="_blank">{{substr($project->projectName, 0, 25)}}</a></h4>
                                            </td>
                                            <td class="text-end text-dark">{{number_format($project->projectValue,0,',','.')}}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2"> <span>{{$project->overAllProg}}%</span></div>
                                                    <div class="progress flex-auto" style="height: 6px;">
                                                        <div class="progress-bar bg-primary " role="progressbar" style="width:{{$project->overAllProg}}%;" aria-valuenow="{{$project->overAllProg}}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row  -->
            <div class="row ">

                <!-- card  -->
                <div class="col-xl-8 mb-5 ">

                    <div class=" card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Sales Revenue</h4>
                        </div>
                        <div class="card-body pb-0">

                            <div id="salesForecastChart"></div>
                        </div>
                    </div>
                </div>
                <!-- card  -->
                <div class="col-xl-4 mb-5">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Campaign Email Sent</h4>
                            <div class="dropdown dropstart">
                                <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item d-flex align-items-center" href="#!">Action</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center" href="#!">Another action</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center" href="#!">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">

                            <div id="chartCampaignEmail" class="d-flex justify-content-center mt-8"></div>

                            <div class="mt-8">
                                <div class="row row-cols-lg-3 text-center">
                                    <div class="col">
                                        <div>

                                            <i class="text-muted mb-3 icon-sm" data-feather="send"></i>
                                            <h4 class="mb-1">4,567</h4>
                                            <span><i class="mdi mdi-circle small text-warning me-1"></i>Total Sent</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>

                                            <i class="text-muted mb-3 icon-sm" data-feather="flag"></i>
                                            <h4 class="mb-1">2,346</h4>
                                            <span><i class="mdi mdi-circle small text-success me-1"></i>Reached</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>

                                            <i class="text-muted mb-3 icon-sm" data-feather="mail"></i>
                                            <h4 class="mb-1">1,784</h4>
                                            <span><i class="mdi mdi-circle small text-primary me-1"></i>Opened</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script>
    // Assuming $salesRevenue contains the revenue data as an array
    var salesRevenueData = <?php echo json_encode($salesRevenue); ?>;
    // Function to generate a random color
    function getRandomColor() {
        var letters = "0123456789ABCDEF";
        var color = "#";
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    var modifiedData = salesRevenueData.map(item => ({
        name: item.name,
        data: item.data,
        color: getRandomColor() // Generate random colors for each data point
    }));
    var e = {
        series: [{
            name: "Revenue", // Provide a common name for the series
            data: salesRevenueData.map(item => item.data), // Extract data only,
            color: getRandomColor()
        }],
        chart: {
            type: "bar",
            height: 350,
        },
        stroke: {
            show: !0,
            width: 5,
            colors: ["transparent"]
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "110%"
            },

        },
        yaxis: {
            labels: {
                formatter: function(e) {
                    return e + ' B';
                },
            },
            tickAmount: 4,
            min: 0,
        },
        xaxis: {
            categories: salesRevenueData.map(item => item.name), // Provide full names for X-axis labels
            axisTicks: {
                show: false,
                borderType: "solid",
                color: "#acb0c3", // Set the axis ticks color directly
                height: 6,
                offsetX: 0,
                offsetY: 0,
            },
            axisBorder: {
                show: true,
                color: "#acb0c3", // Set the axis border color directly
                offsetX: 0,
                offsetY: 0,
            },
            colors: ["#624bff", "#198754", "#0ea5e9"],
        },
    };

    new ApexCharts(document.querySelector("#salesForecastChart"), e).render();
</script>

<script>
    var e = {
        series: [55, 33, 12],
        labels: ["Total Sent", "Reached", "Opened"],
        chart: {
            width: 350,
            type: "donut"
        },
        colors: ["#f59e0b", "#198754", "#624BFF"],
        plotOptions: {
            pie: {
                donut: {
                    size: "74%"
                }
            }
        },
        dataLabels: {
            enabled: !1
        },
        legend: {
            show: !1
        },
        stroke: {
            show: !0,
            colors: "transparent",
        },
        responsive: [{
            breakpoint: 768,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: "bottom"
                },
            },
        }, ],
    };
    new ApexCharts(
        document.querySelector("#chartCampaignEmail"),
        e
    ).render();
</script>
<script>
    e = {
        series: [{
                name: "Current Week",
                data: [31, 40, 28, 51, 42, 109, 100],
            },
            {
                name: "Past Week",
                data: [11, 32, 45, 32, 34, 52, 41],
            },
        ],
        labels: [
            "Jan",
            "Feb",
            "March",
            "April",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ],
        chart: {
            height: 350,
            type: "area",
            toolbar: {
                show: !1
            }
        },
        dataLabels: {
            enabled: !1
        },
        markers: {
            size: 5,
            hover: {
                size: 6,
                sizeOffset: 3
            }
        },
        colors: ["#624bff", "#0dcaf0"],
        stroke: {
            curve: "smooth",
            width: 2
        },
        grid: {
            borderColor: "#acb0c3"
        },
        xaxis: {
            labels: {
                show: !0,
                align: "right",
                minWidth: 0,
                maxWidth: 160,
                style: {
                    fontSize: "12px",
                    fontWeight: 400,
                    colors: ["#acb0c3"],
                    fontFamily: '"Inter", "sans-serif"',
                },
            },
            axisBorder: {
                show: !0,
                color: "#acb0c3",
                height: 1,
                width: "100%",
                offsetX: 0,
                offsetY: 0,
            },
            axisTicks: {
                show: !0,
                borderType: "solid",
                color: "#acb0c3",
                height: 6,
                offsetX: 0,
                offsetY: 0,
            },
        },
        legend: {
            labels: {
                colors: "#acb0c6",
                useSeriesColors: !1,
            },
        },
        yaxis: {
            labels: {
                show: !0,
                align: "right",
                minWidth: 0,
                maxWidth: 160,
                style: {
                    fontSize: "12px",
                    fontWeight: 400,
                    colors: "#acb0c6",
                    fontFamily: '"Inter", "sans-serif"',
                },
            },
        },
    };
    new ApexCharts(
        document.querySelector("#revenueChart"),
        e
    ).render();
</script>

@endsection