@extends('index')

@section('konten')
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
                                            <div class="card">
                                                <!-- card body -->
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <!-- checkbox -->
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="customCheck1">
                                                                    <span class="h5">Start prototyping in
                                                                        frame for admin dashboard.</span>
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
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                                    </a>
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center ps-4 mt-6">
                                                        <!-- img -->
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/images/avatar/avatar-11.jpg" alt="Image" class="avatar avatar-xs rounded-circle imgtooltip" data-template="one">
                                                            <!-- avatar -->
                                                            <!-- text -->
                                                            <div id="one" class="d-none">
                                                                <span>Paul Haney</span>
                                                            </div>
                                                            <!-- text -->
                                                            <div class="ms-2">
                                                                <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                                    Dec</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <!-- button -->

                                        <div class="d-grid">
                                            <button id="new" type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
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
                                            <!-- card -->
                                            <div class="card">
                                                <!-- card body -->
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <!-- checkbox -->
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="customCheck1">
                                                                    <span class="h5">Start prototyping in
                                                                        frame for admin dashboard.</span>
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
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                                    </a>
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center ps-4 mt-6">
                                                        <!-- img -->
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/images/avatar/avatar-11.jpg" alt="Image" class="avatar avatar-xs rounded-circle imgtooltip" data-template="one">
                                                            <!-- avatar -->
                                                            <!-- text -->
                                                            <div id="one" class="d-none">
                                                                <span>Paul Haney</span>
                                                            </div>
                                                            <!-- text -->
                                                            <div class="ms-2">
                                                                <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                                    Dec</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- card -->
                                            <div class="card">
                                                <!-- card body -->
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <!-- checkbox -->
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="customCheck1">
                                                                    <span class="h5">Start prototyping in
                                                                        frame for admin dashboard.</span>
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
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                                    </a>
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center ps-4 mt-6">
                                                        <!-- img -->
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/images/avatar/avatar-11.jpg" alt="Image" class="avatar avatar-xs rounded-circle imgtooltip" data-template="one">
                                                            <!-- avatar -->
                                                            <!-- text -->
                                                            <div id="one" class="d-none">
                                                                <span>Paul Haney</span>
                                                            </div>
                                                            <!-- text -->
                                                            <div class="ms-2">
                                                                <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                                    Dec</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <!-- button -->
                                        <div class="d-grid">
                                            <button id="progress" type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
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
                                            <!-- card -->
                                            <div class="card">
                                                <!-- card body -->
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <!-- checkbox -->
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="customCheck1">
                                                                    <span class="h5">Start prototyping in
                                                                        frame for admin dashboard.</span>
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
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                                    </a>
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center ps-4 mt-6">
                                                        <!-- img -->
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/images/avatar/avatar-11.jpg" alt="Image" class="avatar avatar-xs rounded-circle imgtooltip" data-template="one">
                                                            <!-- avatar -->
                                                            <!-- text -->
                                                            <div id="one" class="d-none">
                                                                <span>Paul Haney</span>
                                                            </div>
                                                            <!-- text -->
                                                            <div class="ms-2">
                                                                <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                                    Dec</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- card -->
                                            <div class="card">
                                                <!-- card body -->
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <!-- checkbox -->
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="customCheck1">
                                                                    <span class="h5">Start prototyping in
                                                                        frame for admin dashboard.</span>
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
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                                    </a>
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center ps-4 mt-6">
                                                        <!-- img -->
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/images/avatar/avatar-11.jpg" alt="Image" class="avatar avatar-xs rounded-circle imgtooltip" data-template="one">
                                                            <!-- avatar -->
                                                            <!-- text -->
                                                            <div id="one" class="d-none">
                                                                <span>Paul Haney</span>
                                                            </div>
                                                            <!-- text -->
                                                            <div class="ms-2">
                                                                <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                                    Dec</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <!-- button -->
                                        <div class="d-grid">
                                            <button id="submitted" type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
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
                                            <div class="card">
                                                <!-- card body -->
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <!-- checkbox -->
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="customCheck1">
                                                                    <span class="h5">Start prototyping in
                                                                        frame for admin dashboard.</span>
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
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                                    </a>
                                                                    <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center ps-4 mt-6">
                                                        <!-- img -->
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/images/avatar/avatar-11.jpg" alt="Image" class="avatar avatar-xs rounded-circle imgtooltip" data-template="one">
                                                            <!-- avatar -->
                                                            <!-- text -->
                                                            <div id="one" class="d-none">
                                                                <span>Paul Haney</span>
                                                            </div>
                                                            <!-- text -->
                                                            <div class="ms-2">
                                                                <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                                    Dec</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <!-- button -->
                                        <div class="d-grid">
                                            <button id="done" type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
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
            <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="taskModalLabel">Create New {{$judul}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById('form-add').reset();">

                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                                <div class="row">
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
                                        <label for="descriptions" class="form-label">Descriptions</label>
                                        <textarea class="form-control" id="descriptions" rows="3" required></textarea>
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
                                    <div class="mb-2 col-12">
                                        <label class="form-label" for="selectOne">Status</label>
                                        <select name="status" id="status" class="form-select select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            <option value="new">New</option>
                                            <option value="inProgress">In Progress</option>
                                            <option value="submitted">Submitted</option>
                                            <option value="done">Done</option>
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
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#taskModal')
        });
        //datepicker
        flatpickr("#dueDate", {
            dateFormat: "d-m-Y",
            defaultDate: "01-01-1900",
        });
    })
</script>
@endsection