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
<script>
    $(function() {
        var oTable = $('#example1').DataTable({
            processing: true,
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"bottom"pi>',
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": false,
        });


        $(document).on('click', '#detailModals', function(e) {
            e.preventDefault();
            var uid = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '/detail_pm',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': uid,
                },
                success: function(data) {
                    $('#project').text('');
                    let text = "";
                    for (let i = 0; i < data.length; i++) {
                        text +=
                            '<div class="row mb-2 border-bottom pb-2 g-0">' + '<div class="col-lg-12">' + '<div class="d-flex">' +
                            '<div class="me-2"><i class="mdi mdi-drag"></i></div>' +
                            '<label class="form-check-label" for="customCheck1">' +
                            '<span class="h5">' + data[i]['projectName'] + '  -  ' + data[i]['customer']['company'] +
                            '<div class="d-flex align-items-center">' +
                            '<div class="me-2"> <span>Progress ' + data[i]['overAllProg'] + '%</span></div>' +
                            '<div class="progress" style="height: 6px;width:10em">' +
                            '<div class="progress-bar bg-primary " role="progressbar" style="width: ' + data[i]['overAllProg'] + '%;" aria-valuenow="' + data[i]['overAllProg'] + '" aria-valuemin="0" aria-valuemax="100">' +
                            '</div></div></div>' +
                            '</span>' +
                            '</label>' + '</div></div></div>';
                    }
                    $('#project').append(text);
                    $('#countProject').text('(' + data.length + ')');
                    $('.modal-title').text('Detail PM' + ' - ' + (data[0]['pm'] ? data[0]['pm']['name'] : ""));
                    $('#taskModal').modal('show');

                },
                error: function(data) {
                    alert('Gagal Mengeksekusi');
                }
            });
        });
    });
</script>
<script>
    var pmData = <?php echo json_encode($data); ?>;
    var options = {
        series: [{
            name: 'Number Of Project',
            type: 'column',
            data: pmData.map(obj => obj.countProject)
        }, {
            name: 'Revenue',
            type: 'line',
            data: pmData.map(obj => obj.valueProject)
        }],
        chart: {
            height: 350,
            type: 'line',
        },
        stroke: {
            width: [0, 4]
        },
        title: {
            // text: 'Traffic Sources'
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [1],
            formatter: function(val, opts) {
                // Format the data label here
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        },
        labels: pmData.map(obj => obj.name),
        xaxis: {
            labels: {
                show: false,
                align: "right",
            }
        },
        yaxis: [{
            title: {
                text: 'Number Of Projects',
            },
            labels: {
                show: false,
            }

        }, {
            opposite: true,
            title: {
                text: 'Revenue'
            },
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
        }]
    };

    var chart = new ApexCharts(document.querySelector("#visitorBlog"), options);
    chart.render();
</script>

@endsection