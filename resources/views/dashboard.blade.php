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
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div id="app-content">
    <div class="app-content-area pt-0 ">
        <div class="pt-12 pb-21 "></div>
        <div class="container-fluid mt-n22 ">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row col-10">
                                <div class="col-4">
                                    <label class="form-label" for="selectOne">Filter By Year</label>
                                    <select name="year" id="year" class="select2" aria-label="Default select example">
                                        <option value="#" selected>Open this select menu</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                    </select>
                                </div>
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
                                    <h4 class="mb-0"># On Going Projects</h4>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1" id="detailModals" data-modal="projectOnGoing">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold" id="projectOnGoing">0</h1>
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
                            <div class="lh-1" id="detailModals" data-modal="projectThisYear">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold" id="projectThisYear">0</h1>
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
                                <h1 class="d-flex justify-content-center mb-1 fw-bold" id="PotensialRevenue">0</h1>
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
                                <h1 class="d-flex justify-content-center mb-1 fw-bold" id="RevenueNewPo">0</h1>
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
                                <h1 class="d-flex justify-content-center mb-1 fw-bold" id="invoiced">0</h1>
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
                                            <th class="text-end">Project Value</th>
                                            <th>Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody id="projectByValue">
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
                                                <th>Sales Name</th>
                                                <th class="text-end">Revenue Value</th>
                                            </tr>
                                        </thead>
                                        <tbody id="salesRevenue">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card  -->
                <div class="col-xl-6 mb-5">
                    <div class="card h-50 mb-5">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Revenue By Sector</h4>
                            <div class="dropdown dropstart">
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart">
                                <div id="chartCampaignEmail" class="d-flex justify-content-center"></div>
                            </div>

                            <div class="mt-8">
                                <div class="row row-cols-lg-3 text-center" id="chartSecRevenue">


                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card h-50">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Number Of Customer Per Year</h4>
                            <div class="dropdown dropstart">
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chartSumCustomer">
                                <div id="summaryCustomer" class="d-flex justify-content-center mt-2"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade gd-example-modal-xl" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Detail Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <!-- card body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-6">
                            <div class="table-responsive">
                                <table class="table text-nowrap mb-0 table-centered">
                                    <thead class="table-light" style="position: sticky;top: 0;">
                                        <tr>
                                            <th>Project Name</th>
                                            <th>Customer</th>
                                            <th class="text-end">Project Value</th>
                                            <th>Contract PO/SPP/SO number</th>
                                            <th>Contract Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailProjectTable">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- button -->
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    function getRandomColor() {
        var letters = "0123456789ABCDEF";
        var color = "#";
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    $(document).ready(function() {
        $('select.select2:not(.normal)').each(function() {
            var elementId = $(this).attr('id'); // Get the ID of the current select element

            // Check if the ID matches a specific condition
            if (elementId === 'sales') {
                $(this).select2({
                    dropdownParent: $(this).parent().parent(),
                    placeholder: 'Select multiple options...'
                });
            } else {
                $(this).select2({
                    dropdownParent: $(this).parent().parent()
                });
            }

        });
        const d = new Date();
        $('#year').val(d.getFullYear()).trigger('change');
        get_executive_dashboard(d.getFullYear())
    })
    $(function() {
        $('#year').on('change', function(e) {
            e.preventDefault();
            get_executive_dashboard($(this).val())
        });

        $(document).on('click', '#detailModals', function(e) {
            e.preventDefault();
            var filter = $(this).data('modal');
            $.ajax({
                type: 'POST',
                url: '/detailProjectDetail',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'filter': filter,
                    'year': $('#year').val()
                },
                success: function(data) {
                    if (data.length > 0) {
                        let text = "";
                        var dataa = Object.assign({}, data)
                        for (let x in dataa) {
                            text += '<tr>' +
                                '<td><h4 class="mb-0 fs-5"><a href="/project/summaryProject/' + dataa[x].id + '" data-toggle="tooltip" title="' + dataa[x].projectName + '" class="text-inherit" target="_blank">' + dataa[x].projectName.substring(0, 25) + '</a></h4></td>' +
                                '<td data-toggle="tooltip" title="' + dataa[x].customer.company + '">' + dataa[x].customer.company.substring(0, 15) + '</td>' +
                                '<td class="text-end text-dark">' + formatNumberr(dataa[x].projectValuePPN) + '</td>' +
                                '<td data-toggle="tooltip" title="' + dataa[x].noContract + '">' + dataa[x].noContract.substring(0, 15) + '</td>' +
                                '<td>' + moment(dataa[x].contractDate).format('DD-MM-YYYY') + '</td>' +
                                '</tr>';
                        }
                        $('#detailProjectTable').html(text);
                    } else {
                        $('#detailProjectTable').html("")
                    }
                    $('#taskModal').modal('show');

                },
                error: function(data) {
                    alert('Gagal Mengeksekusi');
                }
            });
        });
    })

    function get_executive_dashboard(year) {
        $.ajax({
            type: 'POST',
            url: 'get_executive_dashboard/' + year,
            data: {
                '_token': "{{ csrf_token() }}",
            },
            success: function(data) {
                $('#projectOnGoing').html(data.projectOnGoing);
                $('#RevenueNewPo').html(data.RevenueNewPo);
                $('#projectThisYear').html(data.projectThisYear);
                $('#PotensialRevenue').html(data.PotensialRevenue);
                $('#invoiced').html(data.invoiced);

                if (data.projectByValue.length > 0) {
                    let text = "";
                    var dataa = Object.assign({}, data.projectByValue)
                    for (let x in dataa) {
                        text += '<tr>' +
                            '<td data-toggle="tooltip" title="' + dataa[x].customer.company + '">' + dataa[x].customer.company.substring(0, 15) + '</td>' +
                            '<td><h4 class="mb-0 fs-5"><a href="/project/summaryProject/' + dataa[x].id + '" data-toggle="tooltip" title="' + dataa[x].projectName + '" class="text-inherit" target="_blank">' + dataa[x].projectName.substring(0, 25) + '</a></h4></td>' +
                            '<td class="text-end text-dark">' + formatNumberr(dataa[x].projectValuePPN) + '</td>' +
                            '<td>' +
                            '<div class="d-flex align-items-center">' +
                            '<div class="me-2"> <span>' + dataa[x].overAllProg + '%</span></div>' +
                            '<div class="progress flex-auto" style="height: 6px;">' +
                            '<div class="progress-bar bg-primary " role="progressbar" style="width:' + dataa[x].overAllProg + '%;" aria-valuenow="' + dataa[x].overAllProg + '" aria-valuemin="0" aria-valuemax="100">' +
                            '</div></div></div></td>' +
                            '</tr>';
                    }
                    $('#projectByValue').html(text);
                } else {
                    $('#projectByValue').html("")
                }

                if (data.salesRevenue.length > 0) {
                    let salesRevenue = "";

                    data.salesRevenue.sort((a, b) => b.revenue - a.revenue); // Sorting the array by revenue in descending order

                    for (let salesRevenues of data.salesRevenue) {
                        salesRevenue += '<tr>' +
                            '<td>' +
                            '<div class="row">' +
                            '<div class="col-2">' +
                            '<span class="avatar avatar-md flexCenter">' +
                            '<div id="initial-container">' +
                            '<div class="initial-container" style="font-size:1em;background-color: ' + getRandomColor() + '" id="initial-circle" data-tooltip="' + salesRevenues.name + '">' + salesRevenues.initial + '</div>' +
                            '</div>' +
                            '</span>' +
                            '</div>' +
                            '<div class="col-10 flexCenter" style="justify-content:left;">' +
                            salesRevenues.name +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '<td class="text-end text-dark">' + formatNumberr(salesRevenues.revenue) + '</td>' +
                            '</tr>';
                    }

                    $('#salesRevenue').html(salesRevenue); // Replace 'yourTableId' with the actual ID of your table element
                } else {
                    $('#salesRevenue').html(""); // Replace 'yourTableId' with the actual ID of your table element
                }


                if (data.salesRevenue.length > 0) {

                    var salesRevenueData = data.salesRevenue;
                    // console.log(salesRevenueData)

                    var dataSalesRevenue = [];

                    // Iterate through the salesRevenueData array and create objects in the required format
                    for (var value of salesRevenueData) {
                        dataSalesRevenue.push({
                            name: value.name,
                            data: [value.data],
                            color: getRandomColor()
                        });
                    }
                    e = {
                        series: dataSalesRevenue,
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
                }

                if (data.custTypeRevenue.length > 0) {
                    $('#chartSecRevenue').html("");
                    var custTypeRevenue = data.custTypeRevenue;

                    var e = {
                        series: [{
                            data: custTypeRevenue.map(obj => parseFloat(obj.totalRevenue.replace(" B", "")))
                        }],
                        chart: {
                            type: 'bar',
                            height: 280,
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: true
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: custTypeRevenue.map(obj => obj.customerType),
                            labels: {
                                rotate: -15,
                            },
                        },
                        yaxis: {
                            title: {
                                text: 'Revenue (in Billions)',
                            },
                            labels: {
                                formatter: function(val) {
                                    return val + " B";
                                }
                            },
                            tickAmount: 2,
                            min: 0,
                        },
                        fill: {
                            opacity: 1,
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function(val) {
                                    return val + " B";
                                }
                            },

                        }
                    };

                    $('#chartCampaignEmail').html("");
                    new ApexCharts(
                        document.querySelector("#chartCampaignEmail"),
                        e
                    ).render();
                } else {
                    // Remove the element with id "chartCampaignEmail"
                    $('#chartCampaignEmail').remove();

                    // Get the parent element with id "chart"
                    var chartParentElement = $('#chart');

                    // Create a new element with the same id and content
                    var newChartCampaignEmailElement = $('<div id="chartCampaignEmail" class="d-flex justify-content-center mt-8"></div>');

                    // Add the new element back to the parent
                    chartParentElement.append(newChartCampaignEmailElement);

                    // Clear the content of the element with id "chartSecRevenue"
                    $('#chartSecRevenue').html("");

                }

                if (data.summaryCustomer.length > 0) {
                    $('#summaryCustomer').html("");
                    var summaryCustomer = data.summaryCustomer;
                    var color = [
                        "#624bff",
                        "#f59e0b",
                        "#0ea5e9",
                        "#20c997",
                    ];


                    var e = {
                        series: [{
                            data: summaryCustomer.map(obj => obj.unique_customers)
                        }],
                        chart: {
                            type: 'bar',
                            height: 280,
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded',
                            },
                        },
                        dataLabels: {
                            enabled: true
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: summaryCustomer.map(obj => obj.year),
                            labels: {
                                rotate: -15,
                            },
                        },
                        yaxis: {
                            title: {
                                text: 'Customer',
                            },
                            tickAmount: 2,
                            min: 0,
                        },
                        fill: {
                            opacity: 1,
                        },
                        tooltip: {
                            enabled: true,

                        }
                    };

                    $('#summaryCustomer').html("");
                    new ApexCharts(
                        document.querySelector("#summaryCustomer"),
                        e
                    ).render();
                } else {
                    // Remove the element with id "summaryCustomer"
                    $('#summaryCustomer').remove();

                    // Get the parent element with id "chart"
                    var chartParentElement = $('#chartSumCustomer');

                    // Create a new element with the same id and content
                    var newCartSumCustomerElement = $('<div id="summaryCustomer" class="d-flex justify-content-center mt-8"></div>');

                    // Add the new element back to the parent
                    chartParentElement.append(newCartSumCustomerElement);

                    // Clear the content of the element with id "chartSecRevenue"
                    $('#summaryCustomer').html("");

                }

                var invByMonth = data.invByMonth;
                var payByMonth = data.payByMonth;
                var total = 0;

                invByMonth.forEach(function(datas) {
                    // Tambahkan key baru "newKey" dengan nilai "customValue" ke setiap objek datas
                    total += parseInt(datas["totalRevenue"]);

                });
                var totalpay = 0;

                payByMonth.forEach(function(datas) {
                    // Tambahkan key baru "newKey" dengan nilai "customValue" ke setiap objek datas
                    totalpay += parseInt(datas["totalpayRevenue"]);

                });
                // Langkah 1: Dapatkan referensi ke elemen div tujuan
                $('#invByMonth').html("");
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
                $('#revenueChart').html("");
                new ApexCharts(
                    document.querySelector("#revenueChart"),
                    e
                ).render();


            }
        });
    }
</script>

<script>

</script>
<script>

</script>

@endsection