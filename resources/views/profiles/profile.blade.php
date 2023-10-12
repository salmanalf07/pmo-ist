@extends('/profiles/navbarPmo')

@section('pmo')
<!-- row -->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="row">
            @foreach ($project as $pmName => $projects)
            <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-5">
                <!-- card -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="avatar avatar-md me-3">
                                    <div id="initial-container">
                                        <div class="initial-container" id="initial-circle" data-tooltip="{{$pmName}}"></div>
                                    </div>
                                </span>
                                <a href="#" id="detailModals" data-id="{{$projects[0]->pm?$projects[0]->pm->id:'#'}}"><span class="h5">{{$pmName}}</span></a>
                                <br>
                                <!-- <span class="badge badge-danger-soft">High</span> -->
                            </div>
                        </div>
                        <div class="d-flex justify-content-between
                                  align-items-center mt-6">
                            <!-- img -->
                            <div class="d-flex align-items-center">
                            </div>
                            <!-- message count -->
                            <div>
                                <span class="me-2 align-middle" data-bs-toggle="tooltip" data-placement="top" title="project">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-list-task" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z" />
                                        <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z" />
                                        <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z" />
                                    </svg>
                                    <span class="
                                        fs-6">{{count($projects)}}</span>
                                </span>
                                <span class="align-middle" data-bs-toggle="tooltip" data-placement="top" title="courses">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                                        <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                    </svg>
                                    <span class="
                                        fs-6">12</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Offcanvas -->
<div class="modal fade gd-example-modal-lg" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Detail PM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <!-- card body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-6">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="text-dark fs-4" data-bs-toggle="collapse" href="#taskCard1" aria-expanded="true" aria-controls="taskCard1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down icon-xs">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg> Project <span id="countProject" class="text-muted">(3)</span>
                                    </a>
                                </div>
                                <div class="collapse" id="taskCard1">
                                    <div id="project" class="p-2 mt-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-6">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="text-dark fs-4" data-bs-toggle="collapse" href="#taskCard2" aria-expanded="true" aria-controls="taskCard2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down icon-xs">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg> Courses <span class="text-muted">(3)</span>
                                    </a>
                                </div>
                                <div class="collapse" id="taskCard2">
                                    <div id="courses" class="p-2 mt-4">
                                        <div class="row mb-2 border-bottom pb-2 g-0">
                                            <div class="col-lg-6">
                                                <div class="d-flex">
                                                    <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                                    <label class="form-check-label" for="customCheck4">
                                                        <span class="h5">Initial setup your design </span>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 border-bottom pb-2 g-0">
                                            <div class="col-lg-6">
                                                <div class="d-flex">
                                                    <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                                    <label class="form-check-label" for="customCheck5">
                                                        <span class="h5">Invite your teammates and start
                                                            collaborating </span>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 border-bottom pb-2 g-0">
                                            <div class="col-lg-6">
                                                <div class="d-flex">
                                                    <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                                    <label class="form-check-label" for="customCheck6">
                                                        <span class="h5">Start manage projects on the go </span>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-6">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="text-dark fs-4" data-bs-toggle="collapse" href="#taskCard3" aria-expanded="true" aria-controls="taskCard3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down icon-xs">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg> Certifiction <span class="text-muted">(3)</span>
                                    </a>
                                </div>
                                <div class="collapse" id="taskCard3">
                                    <div id="courses" class="p-2 mt-4">
                                        <div class="row mb-2 border-bottom pb-2 g-0">
                                            <div class="col-lg-6">
                                                <div class="d-flex">
                                                    <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                                    <label class="form-check-label" for="customCheck4">
                                                        <span class="h5">Initial setup your design </span>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 border-bottom pb-2 g-0">
                                            <div class="col-lg-6">
                                                <div class="d-flex">
                                                    <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                                    <label class="form-check-label" for="customCheck5">
                                                        <span class="h5">Invite your teammates and start
                                                            collaborating </span>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 border-bottom pb-2 g-0">
                                            <div class="col-lg-6">
                                                <div class="d-flex">
                                                    <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                                    <label class="form-check-label" for="customCheck6">
                                                        <span class="h5">Start manage projects on the go </span>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <script>
        $(function() {
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
                        $('.modal-title').text('Detail PM' + ' - ' + data[0]['pm']['name']);
                        $('#taskModal').modal('show');

                    },
                    error: function(data) {
                        alert('Gagal Mengeksekusi');
                    }
                });
            });
        });
    </script>

    @endsection