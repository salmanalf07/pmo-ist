@extends('index')

@section('konten')
<style>
    .col-xl-2 {
        width: 20%;
    }

    .table-card {
        max-height: 500px;
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
                            <h4 class="mb-0">Total Invoice</h4>
                        </div>
                        <div class="card-body">
                            <div id="revenueChart"></div>
                            <div class="mt-4 px-lg-6 " id="invByMonth">
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
                                    <thead class="table-light" style="position: sticky;top: 0;">
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
                <div class="col-xl-6 mb-5 ">

                    <div class=" card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Revenue By Sales</h4>
                        </div>
                        <div class="card-body pb-0">

                            <div id="salesForecastChart"></div>
                            <div class="card-body mb-4">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered">
                                        <thead class="table-light" style="position: sticky;top: 0;">
                                            <tr>
                                                <th></th>
                                                <th>Sales Name</th>
                                                <th>Revenue Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($salesRevenue as $salesRevenues)
                                            <tr>
                                                <td>
                                                    <span class="avatar avatar-md flexCenter">
                                                        <div id="initial-container">
                                                            <div class="initial-container" style="font-size:1em" id="initial-circle" data-tooltip="{{$salesRevenues['name']}}">{{$salesRevenues['initial']}}</div>
                                                        </div>
                                                    </span>
                                                </td>
                                                <td>
                                                    {{$salesRevenues['name']}}
                                                </td>
                                                <td class="text-end text-dark">{{number_format($salesRevenues['revenue'],0,',','.')}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card  -->
                <div class="col-xl-6 mb-5">
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
    // console.log(salesRevenueData)

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
                horizontal: false,
                columnWidth: "90%",
                dataLabels: {
                    position: "center",
                    enabled: false // Menyembunyikan data labels pada chart balok
                }
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
        },
        yaxis: {
            show: false,
            labels: {
                formatter: function(e) {
                    return e + " M";
                },
            },
        },
        fill: {
            opacity: 1
        },
        legend: {
            show: false,
        },
    };
    // new ApexCharts(
    //     document.querySelector("#salesForecastChart"),
    //     e
    // ).render();
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

        colors: [
            "#624bff",
            "#f59e0b",
            "#0ea5e9",
            "#20c997",
        ],
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
    var invByMonth = <?php echo json_encode($invByMonth); ?>;
    var payByMonth = <?php echo json_encode($payByMonth); ?>;
    var total = 0;

    invByMonth.forEach(function(data) {
        // Tambahkan key baru "newKey" dengan nilai "customValue" ke setiap objek data
        total += parseInt(data["totalRevenue"]);

    });
    var totalpay = 0;

    payByMonth.forEach(function(data) {
        // Tambahkan key baru "newKey" dengan nilai "customValue" ke setiap objek data
        totalpay += parseInt(data["totalpayRevenue"]);

    });
    // Langkah 1: Dapatkan referensi ke elemen div tujuan
    var divTujuan = document.getElementById("invByMonth");

    // Langkah 2: Gunakan innerHTML untuk menambahkan elemen div baru beserta kontennya
    divTujuan.innerHTML += '<div class="row bg-light rounded-3 ">' +
        '<div class="col-lg-12 col-md-6">' +
        '<div class="p-4"><span><i class="mdi mdi-circle small me-1 text-primary"></i>Total Invoice</span>' +
        '<h3 class="mb-0  mt-2">Rp. ' + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '</h3></div></div></div>' +
        '<div class="row bg-light rounded-3 ">' +
        '<div class="col-lg-12 col-md-6">' +
        '<div class="p-4"><span><i class="mdi mdi-circle small me-1 text-primary"></i>Total Payment</span>' +
        '<h3 class="mb-0  mt-2">Rp. ' + totalpay.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '</h3></div></div></div>';


    e = {
        series: [{
                name: "Total Invoice",
                data: invByMonth.map(obj => obj.totalRevenue),
            },
            {
                name: "Total Payment",
                data: payByMonth.map(obj => obj.totalpayRevenue),
            }
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
                show: true
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
                    fontSize: "15px",
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
                show: false,
                align: "right",
                minWidth: 0,
                maxWidth: 160,
                style: {
                    fontSize: "12px",
                    fontWeight: 400,
                    colors: "#acb0c6",
                    fontFamily: '"Inter", "sans-serif"',
                },
                formatter: function(value) {
                    // Format value to display thousands separator
                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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