@extends('/project/navbarInput')

@section('inputan')

<link href="/assets/css/select2Custom.css" rel="stylesheet">
<!-- row -->
<div class="row">
    <div class="col-xxl-12 col-12">
        <div class="col-12">
            <!-- card -->
            <div class="card">
                <!-- table -->
                <div class="card-body mb-10">
                    <div class="table-responsive">
                        <table id="MemberProject" class="table mb-0 text-nowrap table-hover table-centered">
                            <thead class="table-light">
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <script>
        $(function() {
            var oTable = $('#MemberProject').DataTable({
                processing: true,
                serverSide: true,
                "autoWidth": false,
                "responsive": true,
                'orderBy': [
                    [0, 'asc']
                ],
                "columnDefs": [{
                        targets: [2, 3],
                        render: function(oTable) {
                            return moment(oTable).format('DD-MM-YYYY');
                        },
                    },
                    {
                        "className": "text-end",
                        "targets": [4], // table ke 1
                    },
                    {
                        "className": "text-center",
                        "targets": [0], // table ke 1
                    },
                ],
                ajax: {
                    url: '/project/json_section/{{$section}}'
                },
                columns: [{
                        data: 'ref',
                        title: 'No'
                    },
                    {
                        data: 'sectionName',
                        title: 'Section Name'
                    },
                    {
                        data: 'start_on',
                        title: 'Start On'
                    },
                    {
                        data: 'due_on',
                        title: 'Due On'
                    },
                    {
                        data: function(row) {
                            return row.progress == null ? "0%" : row.progress + "%"
                        },
                        title: 'Progress %'
                    },
                    {
                        data: function(row) {
                            return row.status == 1 ? "Completed" : ''
                        },
                        title: 'Status'
                    },
                ]
            });
        })
    </script>
    @endsection