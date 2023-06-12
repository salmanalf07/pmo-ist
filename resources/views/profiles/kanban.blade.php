@extends('/profiles/navbarPmo')

@section('pmo')

<div class="row">
    <div class="col-12">
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
                                <h4 class="mb-0">To Do</h4>
                            </div>
                            <div class="d-flex align-items-center">
                                <!-- dropdown -->
                                <div class="dropdown dropstart">
                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownboardOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-feather="more-horizontal" class="icon-xxs"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownboardOne">
                                        <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="users"></i>Edit
                                            Column
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="user-x"></i>Manage</a>
                                        <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="clipboard"></i>Copy
                                            Column link
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="edit"></i>Archive
                                            All Cards</a>
                                        <a class="dropdown-item d-flex align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete
                                            column</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- task kanban -->
                        <div class="task-kanban">
                            <div id="do">
                                <!-- card -->
                                <div class="card">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <!-- checkbox -->
                                                <div class="form-check custom-checkbox">
                                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                                    <label class="form-check-label" for="customCheck1">
                                                        <span class="h5">Start prototyping in
                                                            frame for admin dashboard.</span>
                                                        <br>
                                                        <span class="badge badge-danger-soft">High</span>
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
                                                        <a class="dropdown-item d-flex 
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="check-square"></i>Mark
                                                            Complete</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="eye"></i>View
                                                            Details
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="maximize-2"></i>Open in
                                                            New Tab</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                            task</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="link"></i>Copy
                                                            task link</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete task
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between
                                  align-items-center ps-4 mt-6">
                                            <!-- img -->
                                            <div class="d-flex align-items-center">
                                                <img src="../assets/images/avatar/avatar-11.jpg" alt="Image" class="avatar avatar-xs
                                      rounded-circle imgtooltip" data-template="one">
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
                                            <!-- message count -->
                                            <div>
                                                <span class="me-2 align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="paperclip"></i>
                                                    <span class="
                                        fs-6">2</span>
                                                </span>
                                                <span class="align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="message-square"></i>
                                                    <span class="
                                        fs-6">12</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <!-- button -->

                            <div class="d-grid">
                                <button type="button" class="btn btn-secondary
                             btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
                                    <i class="fe fe-plus-circle me-1"></i>Add
                                    Task</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="
                     me-6  mb-4 task-card">
                <!-- card body -->
                <div class="card-body">
                    <!-- task list -->
                    <div class="task-list">
                        <!-- content -->
                        <div class="d-flex justify-content-between
                          align-items-center mb-3">
                            <div>
                                <!-- task list -->
                                <h4 class="mb-0">In Progress</h4>
                            </div>
                            <div class="d-flex align-items-center">
                                <!-- dropdown -->
                                <div class="dropdown dropstart">
                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownboardTwo" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-feather="more-horizontal" class="icon-xxs"></i>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownboardTwo">
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="users"></i>Edit
                                            Column
                                        </a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="user-x"></i>Manage</a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="clipboard"></i>Copy
                                            Column link
                                        </a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="edit"></i>Archive
                                            All Cards</a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete
                                            column</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- task kanban -->
                        <div class="task-kanban">
                            <div id="progress">
                                <!-- card -->
                                <div class="card">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <!-- checkbox -->
                                                <div class="form-check custom-checkbox">
                                                    <input type="checkbox" class="form-check-input" id="customCheck3">
                                                    <label class="form-check-label" for="customCheck3">
                                                        <span class="h5">Website launch
                                                            planning</span>
                                                        <br>
                                                        <span class="badge badge-warning-soft">Medium</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <!-- dropdown -->
                                                <div class="dropdown dropstart">
                                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="more-horizontal" class="icon-xxs"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownTask3">
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="check-square"></i>Mark
                                                            Complete</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="eye"></i>View
                                                            Details
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="maximize-2"></i>Open in
                                                            New Tab</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                            task</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="link"></i>Copy
                                                            task link</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon
                                            " data-feather="trash-2"></i>Delete task
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between
                                  align-items-center ps-4 mt-6">
                                            <!-- img -->
                                            <div class="d-flex align-items-center">
                                                <img src="../assets/images/avatar/avatar-3.jpg" alt="Image" class="avatar avatar-xs
                                      rounded-circle imgtooltip" data-template="three">
                                                <!-- avatar -->
                                                <!-- text -->
                                                <div id="three" class="d-none">
                                                    <span>Charlie Holland</span>
                                                </div>
                                                <!-- text -->
                                                <div class="ms-2">
                                                    <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                        Dec</span>
                                                </div>
                                            </div>
                                            <!-- message count -->
                                            <div>
                                                <span class="me-2 align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="paperclip"></i>
                                                    <span class="
                                        fs-6">6</span>
                                                </span>
                                                <span class="align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="message-square"></i>
                                                    <span class="
                                        fs-6">16</span>
                                                </span>
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
                                                <div class="form-check custom-checkbox">
                                                    <input type="checkbox" class="form-check-input" id="customCheck4">
                                                    <label class="form-check-label" for="customCheck4">
                                                        <span class="h5">Intial
                                                            wireframe of website
                                                            design</span>
                                                        <br>
                                                        <span class="badge badge-info-soft">Low</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <!-- dropdown -->
                                                <div class="dropdown dropstart">
                                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="more-horizontal" class="icon-xxs"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownTask4">
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="check-square"></i>Mark
                                                            Complete</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="eye"></i>View
                                                            Details
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="maximize-2"></i>Open in
                                                            New Tab</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                            task</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="link"></i>Copy
                                                            task link</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon
                                            " data-feather="trash-2"></i>Delete task
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between
                                  align-items-center ps-4 mt-4">
                                            <!-- img -->
                                            <div class="d-flex align-items-center">
                                                <img src="../assets/images/avatar/avatar-4.jpg" alt="Image" class="avatar avatar-xs
                                      rounded-circle imgtooltip" data-template="four">
                                                <!-- avatar -->
                                                <!-- text -->
                                                <div id="four" class="d-none">
                                                    <span>Gillbert Farr</span>

                                                </div>

                                                <!-- text -->
                                                <div class="ms-2">
                                                    <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                        Dec</span>
                                                </div>
                                            </div>
                                            <!-- message count -->
                                            <div>
                                                <span class="me-2 align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="paperclip"></i>
                                                    <span class="
                                        fs-6">5</span>
                                                </span>
                                                <span class="align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="message-square"></i>
                                                    <span class="
                                        fs-6">8</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <!-- button -->
                            <div class="d-grid">
                                <button type="button" class="btn btn-secondary
                             btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
                                    <i class="fe fe-plus-circle me-1"></i>Add
                                    Task</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="
                     me-6 mb-4 task-card">
                <!-- card body -->
                <div class="card-body">
                    <!-- task list -->
                    <div class="task-list">
                        <!-- content -->
                        <div class="d-flex justify-content-between
                          align-items-center mb-3">
                            <div>
                                <!-- task list -->
                                <h4 class="mb-0">Review</h4>
                            </div>
                            <div class="d-flex align-items-center">
                                <!-- dropdown -->
                                <div class="dropdown dropstart">
                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownboardThree" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-feather="more-horizontal" class="icon-xxs"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownboardThree">
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="users"></i>Edit
                                            Column
                                        </a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="user-x"></i>Manage</a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="clipboard"></i>Copy
                                            Column link
                                        </a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="edit"></i>Archive
                                            All Cards</a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete
                                            column</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- task kanban -->
                        <div class="task-kanban">
                            <div id="review">
                                <!-- card -->
                                <div class="card">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div class="form-check custom-checkbox">
                                                    <input type="checkbox" class="form-check-input" id="customCheck10">
                                                    <label class="form-check-label" for="customCheck10">
                                                        <span class="h5">Intial
                                                            wireframe of website
                                                            design</span>
                                                        <br>
                                                        <span class="badge badge-danger-soft">High</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <!-- dropdown -->
                                                <div class="dropdown dropstart">
                                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask10" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="more-horizontal" class="icon-xxs"></i>
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="dropdownTask10">
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="check-square"></i>Mark
                                                            Complete</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="eye"></i>View
                                                            Details
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="maximize-2"></i>Open in
                                                            New Tab</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                            task</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="link"></i>Copy
                                                            task link</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon
                                            " data-feather="trash-2"></i>Delete task
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between
                                  align-items-center ps-4 mt-4">
                                            <!-- img -->
                                            <div class="d-flex align-items-center">
                                                <img src="../assets/images/avatar/avatar-12.jpg" alt="Image" class="avatar avatar-xs
                                      rounded-circle imgtooltip" data-template="seven">
                                                <!-- avatar -->
                                                <!-- text -->
                                                <div id="seven" class="d-none">
                                                    <span>Nishant Luka</span>
                                                </div>
                                                <!-- text -->
                                                <div class="ms-2">
                                                    <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                        Dec</span>
                                                </div>
                                            </div>
                                            <!-- message count -->
                                            <div>
                                                <span class="me-2 align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="paperclip"></i>
                                                    <span class="
                                        fs-6">12</span>
                                                </span>
                                                <span class="align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="message-square"></i>
                                                    <span class="
                                        fs-6">22</span>
                                                </span>
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
                                                <div class="form-check custom-checkbox">
                                                    <input type="checkbox" class="form-check-input" id="customCheck9">
                                                    <label class="form-check-label" for="customCheck9">
                                                        <span class="h5">Start
                                                            prototyping in framer for

                                                            admin dashboard.</span>
                                                        <br>
                                                        <span class="badge badge-danger-soft">High</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <!-- dropdown -->
                                                <div class="dropdown dropstart">
                                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask9" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="more-horizontal" class="icon-xxs"></i>
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="dropdownTask9">
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="check-square"></i>Mark
                                                            Complete</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="eye"></i>View
                                                            Details
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="maximize-2"></i>Open in
                                                            New Tab</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                            task</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="link"></i>Copy
                                                            task link</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon
                                            " data-feather="trash-2"></i>Delete task
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between
                                  align-items-center ps-4 mt-4">
                                            <!-- img -->
                                            <div class="d-flex align-items-center">
                                                <img src="../assets/images/avatar/avatar-10.jpg" alt="Image" class="avatar avatar-xs
                                      rounded-circle imgtooltip" data-template="eight">
                                                <!-- avatar -->
                                                <!-- text -->
                                                <div id="eight" class="d-none">
                                                    <span>Florin Pop</span>

                                                </div>
                                                <!-- text -->
                                                <div class="ms-2">
                                                    <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                        Dec</span>
                                                </div>
                                            </div>
                                            <!-- message count -->
                                            <div>
                                                <span class="me-2 align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="paperclip"></i>
                                                    <span class="
                                        fs-6">9</span>
                                                </span>
                                                <span class="align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="message-square"></i>
                                                    <span class="
                                        fs-6">18</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <!-- button -->
                            <div class="d-grid">
                                <button type="button" class="btn btn-secondary
                             btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
                                    <i class="fe fe-plus-circle me-1"></i>Add
                                    Task</button>
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
                        <div class="d-flex justify-content-between
                          align-items-center mb-3">
                            <div>
                                <!-- task list -->
                                <h4 class="mb-0">Done</h4>
                            </div>
                            <div class="d-flex align-items-center">
                                <!-- dropdown -->
                                <div class="dropdown dropstart">
                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownboardFour" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-feather="more-horizontal" class="icon-xxs"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownboardFour">
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="users"></i>Edit
                                            Column
                                        </a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="user-x"></i>Manage</a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="clipboard"></i>Copy
                                            Column link
                                        </a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon " data-feather="edit"></i>Archive
                                            All Cards</a>
                                        <a class="dropdown-item
                                  d-flex
                                  align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="trash-2"></i>Delete
                                            column</a>
                                    </div>
                                </div>
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
                                                <div class="form-check custom-checkbox">
                                                    <input type="checkbox" class="form-check-input" id="customCheck11">
                                                    <label class="form-check-label" for="customCheck11">
                                                        <span class="h5">Intial
                                                            wireframe of website
                                                            design</span>
                                                        <br>
                                                        <span class="badge badge-danger-soft">High</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <!-- dropdown -->
                                                <div class="dropdown dropstart">
                                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask11" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="more-horizontal" class="icon-xxs"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownTask11">
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="check-square"></i>Mark
                                                            Complete</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="eye"></i>View
                                                            Details
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="maximize-2"></i>Open in
                                                            New Tab</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                            task</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="link"></i>Copy
                                                            task link</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon
                                            " data-feather="trash-2"></i>Delete task
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between
                                  align-items-center ps-4 mt-4">
                                            <!-- img -->
                                            <div class="d-flex align-items-center">
                                                <img src="../assets/images/avatar/avatar-12.jpg" alt="Image" class="avatar avatar-xs
                                      rounded-circle imgtooltip" data-template="tweleve">
                                                <!-- avatar -->
                                                <!-- text -->
                                                <div id="tweleve" class="d-none">
                                                    <span>Shrey Mojan</span>

                                                </div>
                                                <!-- text -->
                                                <div class="ms-2">
                                                    <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                        Dec</span>
                                                </div>
                                            </div>
                                            <!-- message count -->
                                            <div>
                                                <span class="me-2 align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="paperclip"></i>
                                                    <span class="
                                        fs-6">12</span>
                                                </span>
                                                <span class="align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="message-square"></i>
                                                    <span class="
                                        fs-6">22</span>
                                                </span>
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
                                                <div class="form-check custom-checkbox">
                                                    <input type="checkbox" class="form-check-input" id="customCheck12">
                                                    <label class="form-check-label" for="customCheck12">
                                                        <span class="h5">Start
                                                            prototyping in framer for

                                                            admin dashboard.</span>
                                                        <br>
                                                        <span class="badge badge-danger-soft">High</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <!-- dropdown -->
                                                <div class="dropdown dropstart">
                                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask12" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="more-horizontal" class="icon-xxs"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownTask12">
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="edit-2"></i>Edit this task
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="check-square"></i>Mark
                                                            Complete</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="eye"></i>View
                                                            Details
                                                        </a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="maximize-2"></i>Open in
                                                            New Tab</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                            task</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon" data-feather="link"></i>Copy
                                                            task link</a>
                                                        <a class="dropdown-item
                                          d-flex
                                          align-items-center" href="#!"><i class="dropdown-item-icon
                                            " data-feather="trash-2"></i>Delete task
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between
                                  align-items-center ps-4 mt-4">
                                            <!-- img -->
                                            <div class="d-flex align-items-center">
                                                <img src="../assets/images/avatar/avatar-14.jpg" alt="Image" class="avatar avatar-xs
                                      rounded-circle imgtooltip" data-template="thirteen">
                                                <!-- avatar -->
                                                <!-- text -->
                                                <div id="thirteen" class="d-none">
                                                    <span>Niman Kant</span>

                                                </div>
                                                <!-- text -->
                                                <div class="ms-2">
                                                    <span class="fs-6"><i class=" text-muted icon-xxs me-1 align-text-bottom" data-feather="clock"></i>30
                                                        Dec</span>
                                                </div>
                                            </div>
                                            <!-- message count -->
                                            <div>
                                                <span class="me-2 align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="paperclip"></i>
                                                    <span class="
                                        fs-6">9</span>
                                                </span>
                                                <span class="align-middle">
                                                    <i class="
                                        text-muted icon-xxs" data-feather="message-square"></i>
                                                    <span class="
                                        fs-6">18</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <!-- button -->
                            <div class="d-grid">
                                <button type="button" class="btn btn-secondary
                             btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
                                    <i class="fe fe-plus-circle me-1"></i>Add
                                    Task</button>
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
                <h5 class="modal-title" id="taskModalLabel">Create New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">
                <form class="row">
                    <div class="mb-2 col-12">
                        <label for="taskTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="taskTitle" placeholder="Title" required>
                    </div>
                    <div class="col-6">
                        <label for="priority" class="form-label">Priority</label>
                        <select class="form-select">
                            <option selected>Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>

                        </select>
                    </div>
                    <div class="mb-2 col-6">
                        <label for="date" class="form-label">Due Date</label>
                        <input class="form-control flatpickr" type="text" placeholder="Select Date" id="date" required>
                    </div>
                    <div class="mb-2 col-12">
                        <label for="descriptions" class="form-label">Descriptions</label>
                        <textarea class="form-control" id="descriptions" rows="3" required></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="assignTo" class="form-label">Assign To</label>
                        <select class="form-select">
                            <option selected>Codescandy</option>
                            <option value="John Deo">John Deo</option>
                            <option value="Misty">Misty</option>
                            <option value="Simon Ray">Simon Ray</option>

                        </select>
                    </div>



                    <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary
                        me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create
                            Task</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection