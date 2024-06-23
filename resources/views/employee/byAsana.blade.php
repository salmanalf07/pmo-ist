@extends('index')

@section('konten')
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<style>
    .icon-green path {
        fill: green;
    }
</style>
<div id="app-content">
    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div>
                <!-- row -->
                <!-- <div class="row mb-3">
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">


                                    <div class="mb-3 col-10">
                                        <div class="row">
                                            <div class="mb-3 col-3">
                                                <label class="form-label" for="selectOne">Employee</label>
                                                <select name="name[]" id="name" multiple="multiple" class="select2" aria-label="Default select example">
                                                    @foreach(collect($employee)->sortBy('name') as $employees)
                                                    <option value="{{$employees->id}}">{{$employees->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Department</label>
                                                <select name="department" id="department" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($department as $departments)
                                                    <option value="{{$departments->id}}">{{$departments->department}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Division</label>
                                                <select name="division" id="division" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($division as $divisions)
                                                    <option value="{{$divisions->id}}">{{$divisions->division}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Location</label>
                                                <select name="location" id="location" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($location as $locations)
                                                    <option value="{{$locations->id}}">{{$locations->location}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Level</label>
                                                <select name="levell" id="levell" class="select2" aria-label="Default select example">
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($skill as $skills)
                                                    <option value="{{$skills->id}}">{{$skills->skillLevel}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label" for="selectOne">Role</label>
                                                <select name="role" id="role" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($role as $roles)
                                                    <option value="{{$roles->id}}">{{$roles->roleEmployee}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label" for="selectOne">Direct Manager</label>
                                                <select name="directManager" id="directManager" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach(collect($employee)->sortBy('name') as $directManager)
                                                    <option value="{{$directManager->id}}">{{$directManager->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Type Project</label>
                                                <select name="typeProject" id="typeProject" class="select2" aria-label="Default select example">
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($typeProject as $typeProjects)
                                                    <option value="{{$typeProjects->id}}">{{$typeProjects->typeProject}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-2">
                                                <label class="form-label">Status</label>
                                                <select name="status" id="status" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    <option value="ACTIVE">ACTIVE</option>
                                                    <option value="RESIGN">RESIGN</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label">Contract Progress</label>
                                                <select name="overAllProg" id="overAllProg" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    <option value="all">All</option>
                                                    <option value="progress">In Progress</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-2">
                                                <label class="form-label">Available Date</label>
                                                <div class="input-group me-3 datepicker">
                                                    <input id="availableAt" name="availableAt" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                                    <div class="input-group-append custom-picker">
                                                        <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-2">
                                                <label class="form-label">Active Date</label>
                                                <div class="input-group me-3 datepicker">
                                                    <input id="activeAt" name="activeAt" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                                    <div class="input-group-append custom-picker">
                                                        <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <label class="form-label" for="selectOne">Customer</label>
                                                <select name="customer" id="customer" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                    @foreach($customer as $customers)
                                                    <option value="{{$customers->id}}">{{$customers->company}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="selectOne">Contract Name</label>
                                                <select name="projectId" id="projectId" class="select2" aria-label="Default select example" required>
                                                    <option value="#" selected>Open this select menu</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-2">
                                        <form method="post" role="form" id="form_export" enctype="multipart/form-data" target="_blank">
                                            @csrf
                                            <input type="text" id="namee" name="namee" value="#" hidden>
                                            <input type="text" id="locations" name="locations" value="#" hidden>
                                            <input type="text" id="departments" name="departments" value="#" hidden>
                                            <input type="text" id="divisions" name="divisions" value="#" hidden>
                                            <input type="text" id="levells" name="levells" value="#" hidden>
                                            <input type="text" id="rolee" name="rolee" value="#" hidden>
                                            <input type="text" id="activeAtt" name="activeAtt" value="#" hidden>
                                            <input type="text" id="availableAtt" name="availableAtt" value="#" hidden>
                                            <input type="text" id="dateRangee" name="dateRangee" value="#" hidden>
                                            <input type="text" id="projectIdd" name="projectIdd" value="#" hidden>
                                            <input type="text" id="customerr" name="customerr" value="#" hidden>
                                            <input type="text" id="directManagerr" name="directManagerr" value="#" hidden>
                                            <input type="text" id="typeProjectt" name="typeProjectt" value="#" hidden>
                                            <input type="text" id="statuss" name="statuss" value="#" hidden>
                                            <input type="text" id="overAllProgs" name="overAllProgs" value="#" hidden>

                                            <div class="row">
                                                <div class="mb-3 pt-7 col-6">
                                                    <button id="export_excel" type="submit" class="btn btn-success-soft" style="width:100%">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20">
                                                            <path fill="currentColor" d="M15.534 1.36L14.309 0H4.662c-.696 0-.965.516-.965.919v3.63H5.05V1.653c0-.154.13-.284.28-.284h6.903c.152 0 .228.027.228.152v4.82h4.913c.193 0 .268.1.268.246v11.77c0 .246-.1.283-.25.283H5.33a.287.287 0 0 1-.28-.284V17.28H3.706v1.695c-.018.6.302 1.025.956 1.025H18.06c.7 0 .939-.507.939-.969V5.187l-.35-.38l-3.116-3.446Zm-1.698.16l.387.434l2.596 2.853l.143.173h-2.653c-.2 0-.327-.033-.38-.1c-.053-.065-.084-.17-.093-.313V1.52Zm-1.09 9.147h4.577v1.334h-4.578v-1.334Zm0-2.666h4.577v1.333h-4.578V8Zm0 5.333h4.577v1.334h-4.578v-1.334ZM1 5.626v10.667h10.465V5.626H1Zm5.233 6.204l-.64.978h.64V14H3.016l2.334-3.51l-2.068-3.156H5.01L6.234 9.17l1.223-1.836h1.727L7.112 10.49L9.449 14H7.656l-1.423-2.17Z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="mb-3 pt-7 col-6">
                                                    <button id="export_gantt" type="submit" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Gantt Chart" class="btn btn-primary-soft" style="width:100%">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-steps" viewBox="0 0 16 16">
                                                            <path d="M.5 0a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-1 0V.5A.5.5 0 0 1 .5 0zM2 1.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="mb-3 pt-7 col-12">
                                            <button id="clear" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Clear" class="btn btn-danger-soft" style="width:100%">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                    <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex border-bottom-0">
                            <div class="flex-grow-1">
                            </div>
                            <div class="justify-content-end">
                                <p>Employee - {{$judul}}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table id="example1" class="table text-nowrap table-centered mt-0" style="width: 100%">
                                    <thead class="table-light">
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- flatpickr -->
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        flatpickr("#availableAt,#activeAt", {
            dateFormat: "d/m/Y",
            defaultDate: new Date(),
            allowInput: true, // Mengizinkan input manual
        });

        $('select.select2:not(.normal)').each(function() {
            var elementId = $(this).attr('id'); // Get the ID of the current select element

            // Check if the ID matches a specific condition
            if (elementId === 'name') {
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

        $("#export_excel").click(function() {
            $("#form_export").attr("action", "/ExportEmpByAsign");
            $("#form_export").submit();
        });

        $("#export_gantt").click(function() {
            $("#form_export").attr("action", "/GanttEmpByAsign");
            $("#form_export").submit();
        });
    })
</script>
<script>
    $(function() {

        var oTable = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"bottom"pi>',
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": false,
            "columnDefs": [{
                    targets: [5, 6],
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    }
                },
                {
                    targets: [7],
                    className: 'text-center'
                }
            ],
            ajax: {
                url: '/json_ByAsana',
                data: function(d) {
                    // Retrieve dynamic parameters
                    var dt_params = $('#example1').data('dt_params');
                    // Add dynamic parameters to the data object sent to the server
                    if (dt_params) {
                        $.extend(d, dt_params);
                    }
                }
            },
            columns: [{
                    data: 'assignees.name',
                    title: 'Employee By Asana',
                },
                {
                    data: 'projectName',
                    title: 'Project Name'
                },
                {
                    data: 'sectionCol',
                    title: 'Section Name'
                },
                {
                    data: 'typeTask',
                    title: 'Type Task',
                },
                {
                    data: 'taskNames',
                    title: 'Task Name'
                },
                {
                    data: 'start_on',
                    title: 'Start Date'
                },
                {
                    data: 'due_on',
                    title: 'End Date'
                },
                {
                    data: 'status',
                    title: 'Status',
                    render: function(data, type, row) {
                        var icon = '';
                        if (data == 1) {
                            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle icon-green" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/></svg>';
                        }
                        return icon;
                    }
                },
            ],
        });
        $('#activeAt').on('change', function() {
            $('#namee').val($('#name').val());
            $('#projectIdd').val($('#projectId').val());
            $('#customerr').val($('#customer').val());
            $('#activeAtt').val($('#activeAt').val());
            $('#rolee').val($('#role').val());
            $('#directManagerr').val($('#directManager').val());
            $('#statuss').val($('#status').val());
            $('#typeProjectt').val($('#typeProject').val());
            $('#levells').val($('#levell').val());
            $('#locations').val($('#location').val());
            $('#overAllProgs').val($('#overAllProg').val());

            $('#example1').data('dt_params', {
                // 'dateChange': dateChange,
                // 'date_st': date[0],
                // 'date_ot': date[1],
                'activeAt': $('#activeAtt').val(),
                'name': $('#namee').val(),
                'projectId': $('#projectIdd').val(),
                'customer': $('#customerr').val(),
                'role': $('#rolee').val(),
                'directManager': $('#directManagerr').val(),
                'typeProject': $('#typeProjectt').val(),
                'status': $('#statuss').val(),
                'levell': $('#levells').val(),
                'location': $('#locations').val(),
                'overAllProg': $('#overAllProgs').val(),
                'department': $('#departments').val(),
                'division': $('#divisions').val(),

            });
            $('#example1').DataTable().draw();
            // console.log(date)
        });
        $('#availableAt').on('change', function() {
            $('#namee').val($('#name').val());
            $('#projectIdd').val($('#projectId').val());
            $('#customerr').val($('#customer').val());
            $('#availableAtt').val($('#availableAt').val());
            $('#rolee').val($('#role').val());
            $('#directManagerr').val($('#directManager').val());
            $('#statuss').val($('#status').val());
            $('#typeProjectt').val($('#typeProject').val());
            $('#levells').val($('#levell').val());
            $('#locations').val($('#location').val());
            $('#overAllProgs').val($('#overAllProg').val());

            $('#example1').data('dt_params', {
                // 'dateChange': dateChange,
                // 'date_st': date[0],
                // 'date_ot': date[1],
                'availableAt': $('#availableAtt').val(),
                'name': $('#namee').val(),
                'projectId': $('#projectIdd').val(),
                'customer': $('#customerr').val(),
                'role': $('#rolee').val(),
                'directManager': $('#directManagerr').val(),
                'typeProject': $('#typeProjectt').val(),
                'status': $('#statuss').val(),
                'levell': $('#levells').val(),
                'location': $('#locations').val(),
                'overAllProg': $('#overAllProgs').val(),
                'department': $('#departments').val(),
                'division': $('#divisions').val(),

            });
            $('#example1').DataTable().draw();
            // console.log(date)
        });
        $('#name, #projectId,#customer,#role, #directManager, #typeProject, #status, #levell, #location, #overAllProg,#department,#division').on('change', function() {
            $('#namee').val($('#name').val());
            $('#projectIdd').val($('#projectId').val());
            $('#customerr').val($('#customer').val());
            $('#rolee').val($('#role').val());
            $('#directManagerr').val($('#directManager').val());
            $('#statuss').val($('#status').val());
            $('#typeProjectt').val($('#typeProject').val());
            $('#levells').val($('#levell').val());
            $('#locations').val($('#location').val());
            $('#overAllProgs').val($('#overAllProg').val());
            $('#departments').val($('#department').val());
            $('#divisions').val($('#division').val());

            $('#example1').data('dt_params', {
                // 'dateChange': dateChange,
                // 'date_st': date[0],
                // 'date_ot': date[1],
                'availableAt': $('#availableAtt').val(),
                'activeAt': $('#activeAtt').val(),
                'name': $('#namee').val(),
                'projectId': $('#projectIdd').val(),
                'customer': $('#customerr').val(),
                'role': $('#rolee').val(),
                'directManager': $('#directManagerr').val(),
                'typeProject': $('#typeProjectt').val(),
                'status': $('#statuss').val(),
                'levell': $('#levells').val(),
                'location': $('#locations').val(),
                'overAllProg': $('#overAllProgs').val(),
                'department': $('#departments').val(),
                'division': $('#divisions').val(),

            });
            $('#example1').DataTable().draw();
            // console.log(date)
        });
        $('.col-12').on('click', '#clear', function() {
            $('#name').val('#').trigger('change.select2');
            $('#projectId').val('#').trigger('change.select2');
            $('#customer').val('#').trigger('change.select2');
            $('#role').val('#').trigger('change.select2');
            $('#directManager').val('#').trigger('change.select2');
            $('#typeProject').val('#').trigger('change.select2');
            $('#status').val('#').trigger('change.select2');
            $('#levell').val('#').trigger('change.select2');
            $('#location').val('#').trigger('change.select2');
            $('#overAllProg').val('#').trigger('change.select2');
            $('#department').val('#').trigger('change.select2');
            $('#division').val('#').trigger('change.select2');

            $('#namee').val('#');
            $('#projectIdd').val('#');
            $('#customerr').val('#');
            $('#roles').val('#');
            $('#directManagerr').val('#');
            $('#typeProjectt').val('#');
            $('#statuss').val('#');
            $('#levells').val('#');
            $('#locations').val('#');
            $('#overAllProgs').val('#');
            $('#dateRangee').val('#');
            $('#departments').val("#");
            $('#divisions').val("#");

            $('#example1').data('dt_params', {});
            $('#example1').DataTable().draw();


        });
    });
</script>



@endsection