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
                        </div>
                        <div class="card-body">
                            <div id="revenueChart"></div>
                            <div class="mt-4 px-lg-6 ">
                                <div class="row bg-light rounded-3 ">
                                    <div class="col-lg-12 col-md-6">
                                        <div class="p-4">
                                            <span><i class="mdi mdi-circle small me-1 text-primary"></i>Current Week</span>
                                            <h3 class="mb-0  mt-2">$235,965</h3>
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
                <div class="col-xl-7 mb-5 ">

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
                <div class="col-xl-5 mb-5">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Revenue By Sector</h4>
                            <div class="dropdown dropstart">
                            </div>
                        </div>
                        <div class="card-body">

                            <div id="chartCampaignEmail" class="d-flex justify-content-center mt-8"></div>

                            <div class="mt-8">
                                <div class="row row-cols-lg-3 text-center" id="chartSecRevenue">


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
    var salesRevenueData = <?php echo json_encode($salesRevenue); ?>;

    function getRandomColor() {
        var letters = "0123456789ABCDEF";
        var color = "#";
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    var data = [];

    // Iterate through the salesRevenueData array and create objects in the required format
    for (var value of salesRevenueData) {
        data.push({
            name: value.name,
            data: [value.data],
            color: getRandomColor()
        });
    }
    e = {
        series: data,
        chart: {
            type: "bar",
            height: 350,
            toolbar: {
                show: 1
            }
        },
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "90%"
            }
        },
        stroke: {
            show: !0,
            width: 5,
            colors: ["transparent"]
        },
        grid: {
            borderColor: "#acb0c3"
        },
        xaxis: {
            categories: [""],
            axisTicks: {
                show: !1,
                borderType: "solid",
                color: "#acb0d5",
                height: 6,
                offsetX: 0,
                offsetY: 0,
            },
            axisBorder: {
                show: !0,
                color: "#acb0d5",
                offsetX: 0,
                offsetY: 0,
            },
            title: {
                text: "Total Forecasted Value",
                offsetX: 0,
                offsetY: -30,
                style: {
                    color: "#acb0d5",
                    fontSize: "12px",
                    fontWeight: 400,
                    fontFamily: '"Inter", "sans-serif"',
                },
            },
        },
        yaxis: {
            labels: {
                formatter: function(e) {
                    return e + " B";
                },
            },
            tickAmount: 4,
            min: 0,
        },
        fill: {
            opacity: 1
        },
        legend: {
            show: !0,
            position: "bottom",
            horizontalAlign: "center",
            fontWeight: 500,
            offsetX: 0,
            offsetY: -14,
            itemMargin: {
                horizontal: 8,
                vertical: 0
            },
            markers: {
                width: 10,
                height: 10
            },
        },
        // colors: ["#624bff", "#198754", "#0ea5e9"],
    };
    new ApexCharts(
        document.querySelector("#salesForecastChart"),
        e
    ).render();
</script>

<script>
    var custTypeRevenue = <?php echo json_encode($custTypeRevenue); ?>;

    // Menggunakan perulangan untuk menambahkan data dengan key baru ke custTypeRevenue
    custTypeRevenue.forEach(function(data) {
        // Tambahkan key baru "newKey" dengan nilai "customValue" ke setiap objek data
        data["color"] = getRandomColor();

        // Langkah 1: Dapatkan referensi ke elemen div tujuan
        var divTujuan = document.getElementById("chartSecRevenue");

        // Langkah 2: Gunakan innerHTML untuk menambahkan elemen div baru beserta kontennya
        divTujuan.innerHTML += '<div class="col">' +
            '<div><h4 class="mb-1">' + data["totalRevenue"] + '</h4>' +
            '<span><i class="mdi mdi-circle small me-1" style="color:' + data["color"] + '"></i>' + data["customerType"] + '</span></div></div>';
    });


    var e = {
        series: custTypeRevenue.map(obj => {
            // Hapus " B" dari totalRevenue dan konversi ke tipe numerik
            return parseFloat(obj.totalRevenue.replace(" B", ""));
        }),
        labels: custTypeRevenue.map(obj => obj.customerType),
        chart: {
            width: 350,
            type: "donut"
        },

        colors: custTypeRevenue.map(obj => obj.color),
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
        yaxis: {
            labels: {
                formatter: function(e) {
                    return e + " B";
                },
            },
            tickAmount: 4,
            min: 0,
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
        }, ],
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