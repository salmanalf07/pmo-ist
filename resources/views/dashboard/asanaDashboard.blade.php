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
                <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                    <!-- card -->
                    <div class="card h-100 card-lift">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0"># Incomplete Project</h4>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1" id="detailModals" data-modal="projectOnGoing">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold" id="incompleteProject">0</h1>
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
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0"># Complete Project</h4>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1" id="detailModals" data-modal="completeProject">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold" id="completeProject">0</h1>
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
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0"># Overdue Projects</h4>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold" id="overdueProject">0</h1>
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
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0"># Upcoming End Projects
                                    </h4>
                                </div>
                            </div>
                            <!-- project number -->
                            <div class="lh-1">
                                <h1 class="d-flex justify-content-center mb-1 fw-bold" id="upcomingEndProject">0</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row  -->
            <div class="row ">
                <!-- card  -->
                <div class="col-xl-6 mb-5">
                    <div class="card mb-5">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Projects By Project Manager</h4>
                            <div class="dropdown dropstart">
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart">
                                <div id="projByPM" class="d-flex justify-content-center"></div>
                            </div>

                            <div class="mt-8">
                                <div class="row row-cols-lg-3 text-center" id="chartProjByPM">


                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- card  -->
                </div>
                <div class="col-xl-6 mb-5">
                    <div class="card mb-5">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Projects By Sales</h4>
                            <div class="dropdown dropstart">
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart">
                                <div id="projBySales" class="d-flex justify-content-center"></div>
                            </div>

                            <div class="mt-8">
                                <div class="row row-cols-lg-3 text-center" id="chartProjBySales">


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-6 mb-5">
                    <div class="card mb-5">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Projects By Customer</h4>
                            <div class="dropdown dropstart">
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart">
                                <div id="projByCust" class="d-flex justify-content-center"></div>
                            </div>

                            <div class="mt-8">
                                <div class="row row-cols-lg-3 text-center" id="chartProjByCustomer">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mb-5">
                    <div class="card mb-5">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Projects By Status</h4>
                            <div class="dropdown dropstart">
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart">
                                <div id="chartByStatus" class="d-flex justify-content-center mt-8"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-6 mb-5">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Total Assigned</h4>
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
            get_asanaDashboard(d.getFullYear())
        })
        $(function() {
            $('#year').on('change', function(e) {
                e.preventDefault();
                get_asanaDashboard($(this).val())
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

        function get_asanaDashboard(year) {
            $.ajax({
                type: 'POST',
                url: '/json_asanaDashboard/' + year,
                data: {
                    '_token': "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('#incompleteProject').html(data.incompleteProject);
                    $('#completeProject').html(data.completeProject);
                    $('#overdueProject').html(data.overdueProject);
                    $('#upcomingEndProject').html(data.upcomingEndProject);

                    if (data.projectByPM.length > 0) {
                        $('#chartProjByPM').html("");
                        var projByPM = data.projectByPM;
                        var dataprojByPM = [];

                        // Iterate through the salesRevenueData array and create objects in the required format
                        for (var value of projByPM) {
                            dataprojByPM.push({
                                y: value.total_projects,
                                x: getInitials(value.pm),
                                fillColor: getRandomColor(),
                                fullName: value.pm // Storing full name for tooltip
                            });
                        }

                        var e = {
                            series: [{
                                data: dataprojByPM
                            }],
                            chart: {
                                type: 'bar',
                                height: 250,
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                },
                            },
                            dataLabels: {
                                enabled: true
                            },
                            tooltip: {
                                custom: function({
                                    series,
                                    seriesIndex,
                                    dataPointIndex,
                                    w
                                }) {
                                    var dataPoint = w.config.series[seriesIndex].data[dataPointIndex];
                                    return '<div class="arrow_box" sytle="padding: 10px">' +
                                        '<span><strong>' + dataPoint.fullName + '</strong><br>Project Count: ' + dataPoint.y + '</span>' +
                                        '</div>';
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Project Count'
                                },
                                min: 0,
                                tickAmount: 4
                            }
                        };

                        $('#projByPM').html("");
                        new ApexCharts(
                            document.querySelector("#projByPM"),
                            e
                        ).render();
                    } else {
                        // Remove the element with id "projByPM"
                        $('#projByPM').remove();

                        // Get the parent element with id "chart"
                        var chartParentElement = $('#chart');

                        // Create a new element with the same id and content
                        var newChartCampaignEmailElement = $('<div id="projByPM" class="d-flex justify-content-center mt-8"></div>');

                        // Add the new element back to the parent
                        chartParentElement.append(newChartCampaignEmailElement);

                        // Clear the content of the element with id "chartSecRevenue"
                        $('#chartProjByPM').html("");

                    }

                    if (data.projectBySales.length > 0) {
                        $('#chartProjBySales').html("");
                        var projBySales = data.projectBySales;
                        var dataprojBySales = [];

                        // Iterate through the salesRevenueData array and create objects in the required format
                        for (var value of projBySales) {
                            dataprojBySales.push({
                                y: value.total_projects,
                                x: getInitials(value.sales),
                                fillColor: getRandomColor(),
                                fullName: value.sales // Storing full name for tooltip
                            });
                        }

                        var e = {
                            series: [{
                                data: dataprojBySales
                            }],
                            chart: {
                                type: 'bar',
                                height: 250,
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                },
                            },
                            dataLabels: {
                                enabled: true
                            },
                            tooltip: {
                                custom: function({
                                    series,
                                    seriesIndex,
                                    dataPointIndex,
                                    w
                                }) {
                                    var dataPoint = w.config.series[seriesIndex].data[dataPointIndex];
                                    return '<div class="arrow_box" sytle="padding: 10px">' +
                                        '<span><strong>' + dataPoint.fullName + '</strong><br>Project Count: ' + dataPoint.y + '</span>' +
                                        '</div>';
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Project Count'
                                },
                                min: 0,
                                tickAmount: 4
                            }
                        };

                        $('#projBySales').html("");
                        new ApexCharts(
                            document.querySelector("#projBySales"),
                            e
                        ).render();
                    } else {
                        // Remove the element with id "projBySales"
                        $('#projBySales').remove();

                        // Get the parent element with id "chart"
                        var chartParentElement = $('#chart');

                        // Create a new element with the same id and content
                        var newChartCampaignEmailElement = $('<div id="projBySales" class="d-flex justify-content-center mt-8"></div>');

                        // Add the new element back to the parent
                        chartParentElement.append(newChartCampaignEmailElement);

                        // Clear the content of the element with id "chartSecRevenue"
                        $('#chartProjBySales').html("");

                    }

                    if (data.projectByCust.length > 0) {
                        $('#chartProjByCustomer').html("");
                        var projByCust = data.projectByCust;
                        var dataprojByCust = [];

                        // Iterate through the salesRevenueData array and create objects in the required format
                        for (var value of projByCust) {
                            dataprojByCust.push({
                                y: value.total_projects,
                                x: getInitials(value.customer),
                                fillColor: getRandomColor(),
                                fullName: value.customer // Storing full name for tooltip
                            });
                        }

                        var e = {
                            series: [{
                                data: dataprojByCust
                            }],
                            chart: {
                                type: 'bar',
                                height: 250,
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                },
                            },
                            dataLabels: {
                                enabled: true
                            },
                            tooltip: {
                                custom: function({
                                    series,
                                    seriesIndex,
                                    dataPointIndex,
                                    w
                                }) {
                                    var dataPoint = w.config.series[seriesIndex].data[dataPointIndex];
                                    return '<div class="arrow_box" sytle="padding: 10px">' +
                                        '<span><strong>' + dataPoint.fullName + '</strong><br>Project Count: ' + dataPoint.y + '</span>' +
                                        '</div>';
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Project Count'
                                },
                                min: 0,
                                tickAmount: 4
                            }
                        };

                        $('#projByCust').html("");
                        new ApexCharts(
                            document.querySelector("#projByCust"),
                            e
                        ).render();
                    } else {
                        // Remove the element with id "projByCust"
                        $('#projByCust').remove();

                        // Get the parent element with id "chart"
                        var chartParentElement = $('#chart');

                        // Create a new element with the same id and content
                        var newChartCampaignEmailElement = $('<div id="projByCust" class="d-flex justify-content-center mt-8"></div>');

                        // Add the new element back to the parent
                        chartParentElement.append(newChartCampaignEmailElement);

                        // Clear the content of the element with id "chartSecRevenue"
                        $('#chartProjByCustomer').html("");

                    }

                    if (data.projectByStatus.length > 0) {
                        $('#chartByStatus').html(""); // Clear previous chart content

                        var projByStatus = data.projectByStatus; // Assuming data is properly populated

                        var names = projByStatus.map(item => item.status); // Array of status names
                        var projectCounts = projByStatus.map(item => item.total_projects); // Array of project counts
                        var colors = {
                            'On Track': '#90ee90', // light green
                            'On Hold': '#0000ff', // blue
                            'Off Track': '#ff0000', // red
                            'Completed': '#006400', // dark green
                            'At Risk': '#ffff00' // yellow
                        };

                        // Map each status name to its corresponding color from the colors object
                        var colorValues = names.map(status => colors[status]);

                        var options = {
                            series: [10, 20, 30], // Contoh data statis
                            chart: {
                                type: 'pie',
                                height: 280
                            },
                            labels: ['Label1', 'Label2', 'Label3'],
                            colors: ['#90ee90', '#0000ff', '#ff0000'],
                            tooltip: {
                                custom: function({
                                    series,
                                    seriesIndex,
                                    dataPointIndex,
                                    w
                                }) {
                                    return '<div class="arrow_box">' +
                                        '<span><strong>' + names[seriesIndex] + '</strong><br>Project Count: ' + series[seriesIndex] + '</span>' +
                                        '</div>';
                                }
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#chartByStatus"), options);
                        chart.render();
                    } else {
                        $('#chartByStatus').remove();

                        // Get the parent element with id "chart"
                        var chartParentElement = $('#chart');

                        // Create a new element with the same id and content
                        var newChartCampaignEmailElement = $('<div id="chartByStatus" class="d-flex justify-content-center mt-8"></div>');

                        // Add the new element back to the parent
                        chartParentElement.append(newChartCampaignEmailElement);

                        // Clear the content of the element with id "chartSecRevenue"
                        $('#chartProjByStatus').html("");
                    }
                }
            });
        }
    </script>

    <script>

    </script>
    <script>

    </script>

    @endsection