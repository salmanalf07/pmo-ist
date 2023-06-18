@extends('index')

@section('konten')
<style>
    #initial-container {
        position: relative;
        display: inline-block;
    }

    #initial-circle {
        position: relative;
        width: 2em;
        height: 2em;
        border-radius: 50%;
        background-color: #f1f1f1;
        color: #333;
        font-size: 1em;
        font-weight: bold;
        text-align: center;
        line-height: 2em;
        cursor: pointer;
    }

    #initial-circle::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 30%;
        transform: translateX(-20%);
        background-color: rgba(0, 0, 0, 0.8);
        color: #fff;
        padding: 3px 12px;
        font-size: 8pt;
        border-radius: 4px;
        white-space: nowrap;
        visibility: hidden;
        opacity: 0;
        transition: visibility 0s, opacity 0.3s linear;
    }

    #initial-circle:hover::before {
        visibility: visible;
        opacity: 1;
    }
</style>
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div id="app-content">
    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ps-9">
                    <div class="task-kanban-container">
                        <!-- card -->
                        <div class="me-6 task-card">
                            <!-- card body -->
                            <!-- card body -->
                            <div class="card-body">
                                <!-- task list -->
                                <div class="task-list">
                                    <!-- content -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <!-- heading -->
                                            <h4 class="mb-0">New</h4>
                                        </div>
                                    </div>
                                    <!-- task kanban -->
                                    <div class="task-kanban">
                                        <div id="new">
                                            <!-- card -->
                                            @foreach($new as $new)
                                            <div class="card">
                                                <!-- card body -->
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <!-- checkbox -->
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="customCheck1">
                                                                    <span class="h6">{{$new->customer->company}}</span>
                                                                    <br>
                                                                    <span class="h5">{{$new->projectName}}</span>
                                                                    <br>
                                                                    @if($new->priority == "low")
                                                                    <span class="badge badge-info-soft">Low</span>
                                                                    @elseif($new->priority == "medium")
                                                                    <span class="badge badge-warning-soft">Medium</span>
                                                                    @elseif($new->priority == "high")
                                                                    <span class="badge badge-danger-soft">High</span>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <!-- dropdown -->
                                                            <div class="dropdown dropstart">
                                                                <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i data-feather="more-horizontal" class="icon-xxs"></i>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownTask1">
                                                                    <a class="dropdown-item d-flex align-items-center" id="edit" data-id="{{$new->id}}" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                                    </a>
                                                                    <a class="dropdown-item d-flex align-items-center" id="delete" data-id="{{$new->id}}" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center ps-4 mt-6">
                                                        <!-- img -->
                                                        <div class="d-flex align-items-center">
                                                            <div id="initial-container">
                                                                <div class="initial-container" id="initial-circle" data-tooltip="{{isset($new->employee->name)?$new->employee->name:''}}"></div>
                                                            </div>
                                                            <!-- text -->
                                                            <div class="ms-2">
                                                                <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>{{date("d-m-Y", strtotime(str_replace('-', '-', $new->dueDate)))}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <!-- button -->

                                        <div class="d-grid">
                                            <button id="adddata" type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
                                                <i class="fe fe-plus-circle me-1"></i>Add Task</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="me-6  mb-4 task-card">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- task list -->
                                <div class="task-list">
                                    <!-- content -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <!-- task list -->
                                            <h4 class="mb-0">In Progress</h4>
                                        </div>

                                    </div>
                                    <!-- task kanban -->
                                    <div class="task-kanban">
                                        <div id="progresss">
                                            <!-- card -->
                                            @foreach($inProgress as $inProgress)
                                            <div class="card">
                                                <!-- card body -->
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <!-- checkbox -->
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="customCheck1">
                                                                    <span class="h6">{{$inProgress->customer->company}}</span>
                                                                    <br>
                                                                    <span class="h5">{{$inProgress->projectName}}</span>
                                                                    <br>
                                                                    @if($inProgress->priority == "low")
                                                                    <span class="badge badge-info-soft">Low</span>
                                                                    @elseif($inProgress->priority == "medium")
                                                                    <span class="badge badge-warning-soft">Medium</span>
                                                                    @elseif($inProgress->priority == "high")
                                                                    <span class="badge badge-danger-soft">High</span>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <!-- dropdown -->
                                                            <div class="dropdown dropstart">
                                                                <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i data-feather="more-horizontal" class="icon-xxs"></i>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownTask1">
                                                                    <a class="dropdown-item d-flex align-items-center" id="edit" data-id="{{$inProgress->id}}" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                                    </a>
                                                                    <a class="dropdown-item d-flex align-items-center" id="delete" data-id="{{$inProgress->id}}" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center ps-4 mt-6">
                                                        <!-- img -->
                                                        <div class="d-flex align-items-center">
                                                            <div id="initial-container">
                                                                <div class="initial-container" id="initial-circle" data-tooltip="{{isset($inProgress->employee->name)?$inProgress->employee->name:''}}"></div>
                                                            </div>
                                                            <!-- text -->
                                                            <div class="ms-2">
                                                                <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>{{date("d-m-Y", strtotime(str_replace('-', '-', $inProgress->dueDate)))}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <!-- button -->
                                        <div class="d-grid">
                                            <button id="adddata" type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
                                                <i class="fe fe-plus-circle me-1"></i>Add Task</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="me-6 mb-4 task-card">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- task list -->
                                <div class="task-list">
                                    <!-- content -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <!-- task list -->
                                            <h4 class="mb-0">Submitted</h4>
                                        </div>

                                    </div>
                                    <!-- task kanban -->
                                    <div class="task-kanban">
                                        <div id="submittedd">
                                            <!-- card -->
                                            @foreach($submitted as $submitted)
                                            <div class="card">
                                                <!-- card body -->
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <!-- checkbox -->
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="customCheck1">
                                                                    <span class="h6">{{$submitted->customer->company}}</span>
                                                                    <br>
                                                                    <span class="h5">{{$submitted->projectName}}</span>
                                                                    <br>
                                                                    @if($submitted->priority == "low")
                                                                    <span class="badge badge-info-soft">Low</span>
                                                                    @elseif($submitted->priority == "medium")
                                                                    <span class="badge badge-warning-soft">Medium</span>
                                                                    @elseif($submitted->priority == "high")
                                                                    <span class="badge badge-danger-soft">High</span>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <!-- dropdown -->
                                                            <div class="dropdown dropstart">
                                                                <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i data-feather="more-horizontal" class="icon-xxs"></i>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownTask1">
                                                                    <a class="dropdown-item d-flex align-items-center" id="edit" data-id="{{$submitted->id}}" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                                    </a>
                                                                    <a class="dropdown-item d-flex align-items-center" id="delete" data-id="{{$submitted->id}}" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center ps-4 mt-6">
                                                        <!-- img -->
                                                        <div class="d-flex align-items-center">
                                                            <div id="initial-container">
                                                                <div class="initial-container" id="initial-circle" data-tooltip="{{isset($submitted->employee->name)?$submitted->employee->name:''}}"></div>
                                                            </div>
                                                            <!-- text -->
                                                            <div class="ms-2">
                                                                <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>{{date("d-m-Y", strtotime(str_replace('-', '-', $submitted->dueDate)))}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <!-- button -->
                                        <div class="d-grid">
                                            <button id="adddata" type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
                                                <i class="fe fe-plus-circle me-1"></i>Add Task</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="me-6  mb-4 task-card">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- task list -->
                                <div class="task-list">
                                    <!-- content -->
                                    <div class="d-flex justify-clearcontent-between align-items-center mb-3">
                                        <div>
                                            <!-- task list -->
                                            <h4 class="mb-0">Done</h4>
                                        </div>

                                    </div>
                                    <!-- task kanban -->
                                    <div class="task-kanban">
                                        <div id="done">
                                            <!-- card -->
                                            @foreach($done as $done)
                                            <div class="card">
                                                <!-- card body -->
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <!-- checkbox -->
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="customCheck1">
                                                                    <span class="h6">{{$done->customer->company}}</span>
                                                                    <br>
                                                                    <span class="h5">{{$done->projectName}}</span>
                                                                    <br>
                                                                    @if($done->priority == "low")
                                                                    <span class="badge badge-info-soft">Low</span>
                                                                    @elseif($done->priority == "medium")
                                                                    <span class="badge badge-warning-soft">Medium</span>
                                                                    @elseif($done->priority == "high")
                                                                    <span class="badge badge-danger-soft">High</span>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <!-- dropdown -->
                                                            <div class="dropdown dropstart">
                                                                <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i data-feather="more-horizontal" class="icon-xxs"></i>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownTask1">
                                                                    <a class="dropdown-item d-flex align-items-center" id="edit" data-id="{{$done->id}}" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                                    </a>
                                                                    <a class="dropdown-item d-flex align-items-center" id="delete" data-id="{{$done->id}}" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center ps-4 mt-6">
                                                        <!-- img -->
                                                        <div class="d-flex align-items-center">
                                                            <div id="initial-container">
                                                                <div class="initial-container" id="initial-circle" data-tooltip="{{isset($done->employee->name)?$done->employee->name:''}}"></div>
                                                            </div>
                                                            <!-- text -->
                                                            <div class="ms-2">
                                                                <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>{{date("d-m-Y", strtotime(str_replace('-', '-', $done->dueDate)))}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <!-- button -->
                                        <div class="d-grid">
                                            <button id="adddata" type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
                                                <i class="fe fe-plus-circle me-1"></i>Add Task</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true" data-bs-focus="false">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="taskModalLabel">Create New {{$judul}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById('form-add').reset();">

                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="id" name="id">
                                <div class="row">
                                    <span id="peringatan"></span>
                                    <div class="mb-2 col-12">
                                        <label class="form-label" for="selectOne">Customer</label>
                                        <select name="customerId" id="customerId" class="select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($customer as $customer)
                                            <option value="{{$customer->id}}">{{strtoupper($customer->company)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2 col-12">
                                        <label class="form-label">Project Name</label>
                                        <input name="projectName" id="projectName" type="text" class="form-control" placeholder="Enter Here">
                                    </div>
                                    <div class="mb-2 col-12">
                                        <label for="description" class="form-label">Descriptions</label>
                                        <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-2 col-6">
                                        <label class="form-label">Value</label>
                                        <input name="value" id="value" type="text" class="form-control number-input" value="0" placeholder="Enter Here" required>
                                    </div>
                                    <div class="mb-2 col-6">
                                        <label class="form-label">Due Date</label>
                                        <div class="input-group me-3 datepicker">
                                            <input id="dueDate" name="dueDate" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2 col-6">
                                        <label class="form-label" for="selectOne">Status</label>
                                        <select name="status" id="status" class="form-select select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            <option value="new">New</option>
                                            <option value="inProgress">In Progress</option>
                                            <option value="submitted">Submitted</option>
                                            <option value="done">Done</option>
                                        </select>
                                    </div>
                                    <div class="mb-2 col-6">
                                        <label class="form-label" for="selectOne">Priority</label>
                                        <select name="priority" id="priority" class="form-select select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="assignTo" class="form-label">Assign To</label>
                                        <select name="asignTo" id="asignTo" class="select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($employee as $employee)
                                            <option value="{{$employee->id}}">{{strtoupper($employee->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal" onclick="document.getElementById('form-add').reset();">Cancel</button>
                                        <button id="in" type="button" class="btn btn-primary">Create
                                            Task</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    function getInitials(name) {
        const words = name.split(' ');
        let initials = '';

        for (let i = 0; i < words.length; i++) {
            const word = words[i];
            if (word[0] === word[0].toUpperCase()) {
                initials += word[0];
            }
        }

        return initials.substring(0, 2);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const initialContainers = document.getElementsByClassName('initial-container');
        for (let i = 0; i < initialContainers.length; i++) {
            const div = initialContainers[i];
            const name = div.dataset.tooltip;
            const initials = getInitials(name);
            div.setAttribute('id', 'initial-circle');
            div.innerHTML = initials;
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#taskModal')
        });
        //datepicker
        flatpickr("#dueDate", {
            dateFormat: "d-m-Y",
            defaultDate: "01-01-1900",
            // static: true
        });
    })

    $(function() {
        $(document).on('click', '#adddata', function() {
            $("#in").removeClass("btn btn-primary update");
            $("#in").addClass("btn btn-primary add");
        });
        //add data
        $('.col-12').on('click', '.add', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '{{ url("store_pipeline") }}',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data[1]) {
                        let text = "";
                        var dataa = Object.assign({}, data[0])
                        for (let x in dataa) {
                            text += "<div class='alert alert-dismissible hide fade in alert-danger show'><strong>Errorr!</strong> " + dataa[x] + "<a href='#' class='close float-close' data-dismiss='alert' aria-label='close'>×</a></div>";
                        }
                        $('#peringatan').append(text);
                    } else {
                        $('#taskModal').modal('hide');
                        document.getElementById('form-add').reset()
                        location.reload();
                    }

                },
            });
        });
        $(document).on('click', '#edit', function(e) {
            e.preventDefault();
            var uid = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: 'edit_pipeline',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': uid,
                },
                success: function(data) {
                    //console.log(data);

                    //isi form
                    $('#id').val(data.id);
                    $('#projectName').val(data.projectName);
                    $('#customerId').val(data.customerId).trigger('change');
                    $('#description').val(data.description);
                    $('#value').val(formatNumberr(data.value));
                    if (data.dueDate != null) {
                        $('#dueDate').val((data.dueDate).split("-").reverse().join("-"));
                    }
                    $('#status').val(data.status).trigger('change');
                    $('#priority').val(data.priority).trigger('change');
                    $('#asignTo').val(data.asignTo).trigger('change');

                    id = $('#id').val();

                    $("#in").removeClass("btn btn-primary add");
                    $("#in").addClass("btn btn-primary update");
                    $('#taskModal').modal('show');


                },
            });

        });
        //end edit
        //update
        $('.col-12').on('click', '.update', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            $.ajax({
                type: 'POST',
                url: 'update_pipeline/' + id,
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data[1]) {
                        let text = "";
                        var dataa = Object.assign({}, data[0])
                        for (let x in dataa) {
                            text += "<div class='alert alert-dismissible hide fade in alert-danger show'><strong>Errorr!</strong> " + dataa[x] + "<a href='#' class='close float-close' data-dismiss='alert' aria-label='close'>×</a></div>";
                        }
                        $('#peringatan').append(text);
                    } else {
                        $('#taskModal').modal('hide');
                        document.getElementById('form-add').reset()
                        location.reload();
                    }
                }
            });
        });
        //end update
        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            if (confirm('Yakin akan menghapus data ini?')) {
                // alert("Thank you for subscribing!" + $(this).data('id') );

                $.ajax({
                    type: 'DELETE',
                    url: 'delete_pipeline/' + $(this).data('id'),
                    data: {
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        alert("Data Berhasil Dihapus");
                        location.reload();
                    }
                });

            } else {
                return false;
            }
        });
    })
</script>
@endsection