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

                            <h4 class="mb-0">Employee By Department</h4>

                        </div>
                        <div class="card-body">
                            <div id="visitorBlog"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-6 mb-5">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table id="resource" class="table text-nowrap mb-0 table-centered">
                                    <thead class="table-light" style="position: sticky;top: 0;">
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Project Name</th>
                                            <th>Total Participant</th>
                                            <th>Member</th>
                                            <th>Partner</th>
                                            <th>PM</th>
                                            <th>BA</th>
                                            <th>FE</th>
                                            <th>BE</th>
                                            <th>UI/UX</th>
                                            <th>DEVOPS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(collect($projectMember)->sortBy('customerName') as $projectMember)
                                        <tr>
                                            <td>{{substr($projectMember['customerName'], 0, 25)}}</td>
                                            <td><a href="/project/summaryProject/{{$projectMember['projectId']}}" class="text-inherit" target="_blank">{{substr($projectMember['projectName'], 0, 25)}}</a></td>
                                            <td class="text-center">{{$projectMember['totalMembers'] + $projectMember['totalPartner']}}</td>
                                            <td class="text-center">{{$projectMember['totalMembers']}}</td>
                                            <td class="text-center">{{$projectMember['totalPartner']}}</td>
                                            <td class="text-center">{{isset($projectMember['Project manager'])?$projectMember['Project manager']:""}}</td>
                                            <td class="text-center">{{isset($projectMember['Business Analyst'])?$projectMember['Business Analyst']:""}}</td>
                                            <td class="text-center">{{isset($projectMember['Front End Developer'])?$projectMember['Front End Developer']:""}}</td>
                                            <td class="text-center">{{isset($projectMember['Back End Developer'])?$projectMember['Back End Developer']:""}}</td>
                                            <td class="text-center">{{isset($projectMember['UI/UX Developer'])?$projectMember['UI/UX Developer']:""}}</td>
                                            <td class="text-center">{{isset($projectMember['Production Support'])?$projectMember['Production Support']:""}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-6 mb-5 ">

                    <div class=" card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Grafic by level</h4>
                        </div>
                        <div class="card-body pb-0">

                            <div id="employeeCount"></div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 mb-5">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <h4>Employee By Region</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table text-nowrap mb-0 table-centered">
                                    <thead class="table-light" style="position: sticky;top: 0;">
                                        <tr>
                                            <th>City</th>
                                            <th class="text-center">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($totalRegion as $region)
                                        <tr>
                                            <td>{{$region->region != ""?$region->region->location:"Undefined"}}</td>
                                            <td class="text-center">{{$region->totalregion}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12 col-12 mb-5">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center ">

                            <h3 class="mb-0">Resource By Role</h3>
                            <div class="d-flex align-items-center">
                                <div class="col">
                                    <span>Sort By Value:</span>
                                </div>
                                <div class="col-auto ms-2">
                                    <select id="filter" class="form-select form-select-sm" onchange="get_chart()">
                                        <option selected value="#">Default</option>
                                        <option value="asc">Small To Large</option>
                                        <option value="dsc">Large To Small</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row row-cols-lg-4  my-8" id="presentase">
                            </div>
                            <div class="mt-6 mb-3">
                                <div class="progress" style="height: 40px;" id="chartBar">
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
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#filter").val("#").trigger('change');
    })
    $(function() {
        var oTable = $('#resource').DataTable({
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": false,
        });

    });

    function get_chart() {
        var value = $("#filter").val();
        console.log(value);

        $.ajax({
            type: 'POST',
            url: '/get_chart_resource',
            data: {
                '_token': "{{ csrf_token() }}",
                'filter': value
            },
            success: function(data) {
                $('#presentase').empty();
                $('#chartBar').empty();

                let text = "";
                let textt = "";
                var dataa = Object.assign({}, data)
                for (let x in dataa) {
                    text += '<div class="col">' +
                        '<div><h4 class="mb-3">' + dataa[x].name + '</h4>' +
                        '<div class="lh-1">' +
                        '<h4 class="fs-2 fw-bold mb-0 " style="color:' + dataa[x].color + ';">' + dataa[x].persen + '%</h4>' +
                        '<span style="color:' + dataa[x].color + ';">' + dataa[x].data + '</span>' +
                        '</div></div></div>';
                    textt += '<div class="progress-bar" style="background-color: ' + dataa[x].color + ';width: ' + dataa[x].persen + '%" role="progressbar" aria-label="Segment one" aria-valuenow="' + dataa[x].persen + '" aria-valuemin="0" aria-valuemax="100"></div>';
                }
                $('#presentase').append(text);
                $('#chartBar').append(textt);

            }
        });
    };
</script>
<script>
    var employeeByDept = <?php echo json_encode($employeeByDept); ?>;

    e = {
        series: [{
            name: "Department",
            data: employeeByDept.map(obj => obj.totalDepartment),
        }, ],
        chart: {
            toolbar: {
                show: !1
            },
            type: "bar",
            height: 300,
            stacked: !0,
        },
        legend: {
            show: !1
        },
        colors: ["#624bff", "#637381"],
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "90%",
                borderRadius: 4,
                endingShape: "rounded",
            },
        },
        dataLabels: {
            enabled: !1
        },
        stroke: {
            show: !0,
            width: 1,
            colors: ["transparent"]
        },
        grid: {
            borderColor: "#637381",
            strokeDashArray: 2,
            xaxis: {
                lines: {
                    show: !1
                }
            },
        },
        xaxis: {
            categories: employeeByDept.map(obj => {
                if (obj.department != null) {
                    return obj.department.department;
                } else {
                    return "";
                }
            }),
            axisBorder: {
                show: !1
            },
            axisTicks: {
                show: !0,
                borderType: "solid",
                color: "#637381",
                width: 6,
                offsetX: 0,
                offsetY: 0,
            },
            labels: {
                offsetX: 0,
                offsetY: 5,
                style: {
                    fontSize: "13px",
                    fontWeight: 400,
                    fontFamily: '"Inter", "sans-serif"',
                    colors: ["#637381"],
                },
            },
        },
        grid: {
            borderColor: "#637381",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: !1
                }
            },
            yaxis: {
                lines: {
                    show: !0
                }
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: -10
            },
        },
        yaxis: {
            title: {
                text: void 0
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    endingShape: "rounded",
                    columnWidth: "80%",
                },
            },
            labels: {
                style: {
                    fontSize: "13px",
                    fontWeight: 400,
                    fontFamily: '"Inter", "sans-serif"',
                    colors: ["#637381"],
                },
                offsetX: -10,
            },
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(e) {
                    return e + " person ";
                },
            },
            marker: {
                show: !0
            },
        },
    };
    new ApexCharts(
        document.querySelector("#visitorBlog"),
        e
    ).render();
</script>

<script>
    var salesRevenueData = <?php echo json_encode($totalLevel); ?>;
    // console.log(salesRevenueData)
    var color = [
        "#624bff",
        "#f59e0b",
        "#20c997",
    ];
    var count = 0;

    var data = [];

    // Iterate through the salesRevenueData array and create objects in the required format
    for (var value of salesRevenueData) {
        data.push({
            name: value.name,
            data: [value.data],
            color: color[count],
        });
        count += 1
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
                    return e;
                },
            },
        },
        fill: {
            opacity: 1
        },
    };
    new ApexCharts(
        document.querySelector("#employeeCount"),
        e
    ).render();
</script>
@endsection