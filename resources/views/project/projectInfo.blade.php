@extends('index')

@section('konten')
<div id="app-content">

    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0 ">{{$judul}}</h3>
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-12">
                    <!-- card -->
                    <div class="card">
                        <div class="card-header d-md-flex border-bottom-0">
                            <div class="flex-grow-1">
                                <a href="project/inputProject" class="btn btn-primary">+ Add {{$judul}}</a>
                            </div>
                        </div>
                        <!-- table -->
                        <div class="table-responsive">
                            <table id="example1" class="table text-nowrap table-centered mt-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Dates</th>
                                        <th>Budget</th>
                                        <th>Task Progress</th>
                                        <th>Status</th>
                                        <th>Team</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-lg rounded-3 border ">
                                                    <i class="icon-sm text-muted" data-feather="layout"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h4 class="mb-0 fs-5"><a href="#!" class="text-inherit">Web Application Design</a></h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            01 Jan, 2023
                                        </td>
                                        <td>
                                            $22,000
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2"> <span>80%</span></div>
                                                <div class="progress flex-auto" style="height: 6px;">
                                                    <div class="progress-bar bg-primary " role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info-soft text-dark-info">In Progress</span>
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-11.jpg" class="rounded-circle imgtooltip" data-template="one">
                                                    <span id="one" class="d-none">
                                                        <span>Paul Haney</span>
                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm avatar-primary imgtooltip" data-template="textThree">
                                                    <span class="avatar-initials rounded-circle ">

                                                        DU</span>

                                                    <span id="textThree" class="d-none">
                                                        <span>Dash UI Only</span>

                                                    </span>
                                                </span>

                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-3.jpg" class="rounded-circle imgtooltip" data-template="two">
                                                    <span id="two" class="d-none">
                                                        <span>Mary Holler</span>
                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm ">
                                                    <span class="avatar-initials rounded-circle bg-light text-dark">5+</span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropstart">
                                                <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                                </a>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="edit"></i>Edit Details
                                                    </a>

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="link"></i>Copy project link

                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="save"></i>Save as Default
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                    </a>


                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="upload"></i>Import
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="printer"></i>Export / Print
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="users"></i>Move to another team
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="archive"></i>Archive
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="trash"></i>Delete Project
                                                    </a>


                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-lg rounded-3 border ">
                                                    <i class="icon-sm text-muted" data-feather="clipboard"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h4 class="mb-0 fs-5"><a href="#!" class="text-inherit">Task Application Development..</a></h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            20 Nov, 2023
                                        </td>
                                        <td>
                                            $20,000
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2"> <span>100%</span></div>
                                                <div class="progress flex-auto" style="height: 6px;">
                                                    <div class="progress-bar bg-success " role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-success-soft text-dark-success">Completed</span>
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                <span class="avatar avatar-sm avatar-primary imgtooltip" data-template="textFour">
                                                    <span class="avatar-initials rounded-circle ">

                                                        DU</span>

                                                    <span id="textFour" class="d-none">
                                                        <span>Dash UI Only</span>

                                                    </span>
                                                </span>

                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-5.jpg" class="rounded-circle imgtooltip" data-template="three">
                                                    <span id="three" class="d-none">
                                                        <span>Gali Linear</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-6.jpg" class="rounded-circle imgtooltip" data-template="four">
                                                    <span id="four" class="d-none">
                                                        <span>Mary Holler</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm ">
                                                    <span class="avatar-initials rounded-circle bg-light text-dark">8+</span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropstart">
                                                <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                                </a>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="edit"></i>Edit Details
                                                    </a>

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="link"></i>Copy project link

                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="save"></i>Save as Default
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                    </a>


                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="upload"></i>Import
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="printer"></i>Export / Print
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="users"></i>Move to another team
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="archive"></i>Archive
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="trash"></i>Delete Project
                                                    </a>


                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-lg rounded-3 border ">
                                                    <i class="icon-sm text-muted" data-feather="users"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h4 class="mb-0 fs-5"><a href="#!" class="text-inherit">CRM Dashboard </a></h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            23 Dec, 2023
                                        </td>
                                        <td>
                                            $0
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2"> <span>30%</span></div>
                                                <div class="progress flex-auto" style="height: 6px;">
                                                    <div class="progress-bar bg-danger " role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="30">

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger-soft text-dark-danger">Cancel</span>
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-7.jpg" class="rounded-circle imgtooltip" data-template="five">
                                                    <span id="five" class="d-none">
                                                        <span>Paul Haney</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-8.jpg" class="rounded-circle imgtooltip" data-template="six">
                                                    <span id="six" class="d-none">
                                                        <span>Gali Linear</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm avatar-primary imgtooltip" data-template="textSix">
                                                    <span class="avatar-initials rounded-circle ">

                                                        DU</span>

                                                    <span id="textSix" class="d-none">
                                                        <span>Dash UI Only</span>

                                                    </span>
                                                </span>

                                                <span class="avatar avatar-sm ">
                                                    <span class="avatar-initials rounded-circle bg-light text-dark">4+</span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropstart">
                                                <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                                </a>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="edit"></i>Edit Details
                                                    </a>

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="link"></i>Copy project link

                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="save"></i>Save as Default
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                    </a>


                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="upload"></i>Import
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="printer"></i>Export / Print
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="users"></i>Move to another team
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="archive"></i>Archive
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="trash"></i>Delete Project
                                                    </a>


                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-lg rounded-3 border ">
                                                    <i class="icon-sm text-muted" data-feather="cpu"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h4 class="mb-0 fs-5"><a href="#!" class="text-inherit">Marketing Sites </a></h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            10 Oct, 2023
                                        </td>
                                        <td>
                                            $0
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2"> <span>10%</span></div>
                                                <div class="progress flex-auto" style="height: 6px;">
                                                    <div class="progress-bar bg-danger " role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="10">

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger-soft text-dark-danger">Cancel</span>
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-7.jpg" class="rounded-circle imgtooltip" data-template="seven">
                                                    <span id="seven" class="d-none">
                                                        <span>Paul Haney</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm avatar-primary imgtooltip" data-template="textSeven">
                                                    <span class="avatar-initials rounded-circle ">

                                                        DU</span>

                                                    <span id="textSeven" class="d-none">
                                                        <span>Dash UI Only</span>

                                                    </span>
                                                </span>

                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-9.jpg" class="rounded-circle imgtooltip" data-template="eight">
                                                    <span id="eight" class="d-none">
                                                        <span>Mary Holler</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm ">
                                                    <span class="avatar-initials rounded-circle bg-light text-dark">7+</span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropstart">
                                                <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                                </a>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="edit"></i>Edit Details
                                                    </a>

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="link"></i>Copy project link

                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="save"></i>Save as Default
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                    </a>


                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="upload"></i>Import
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="printer"></i>Export / Print
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="users"></i>Move to another team
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="archive"></i>Archive
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="trash"></i>Delete Project
                                                    </a>


                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-lg rounded-3 border ">
                                                    <i class="icon-sm text-muted" data-feather="message-square"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h4 class="mb-0 fs-5"><a href="#!" class="text-inherit">Chat Application Design </a></h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            19 Oct, 2023
                                        </td>
                                        <td>
                                            $20,000
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2"> <span>65%</span></div>
                                                <div class="progress flex-auto" style="height: 6px;">
                                                    <div class="progress-bar bg-warning " role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="65">

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-warning-soft text-dark-warning">Pending</span>
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                <span class="avatar avatar-sm avatar-primary imgtooltip" data-template="textEight">
                                                    <span class="avatar-initials rounded-circle ">

                                                        DU</span>

                                                    <span id="textEight" class="d-none">
                                                        <span>Dash UI Only</span>

                                                    </span>
                                                </span>

                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-8.jpg" class="rounded-circle imgtooltip" data-template="nine">
                                                    <span id="nine" class="d-none">
                                                        <span>Gali Linear</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-9.jpg" class="rounded-circle imgtooltip" data-template="ten">
                                                    <span id="ten" class="d-none">
                                                        <span>Mary Holler</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm ">
                                                    <span class="avatar-initials rounded-circle bg-light text-dark">6+</span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropstart">
                                                <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                                </a>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="edit"></i>Edit Details
                                                    </a>

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="link"></i>Copy project link

                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="save"></i>Save as Default
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                    </a>


                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="upload"></i>Import
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="printer"></i>Export / Print
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="users"></i>Move to another team
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="archive"></i>Archive
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="trash"></i>Delete Project
                                                    </a>


                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-lg rounded-3 border ">
                                                    <i class="icon-sm text-muted" data-feather="shopping-cart"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h4 class="mb-0 fs-5"><a href="#!" class="text-inherit">E-Commerce Project </a></h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            5 Nov, 2023
                                        </td>
                                        <td>
                                            $25,000
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2"> <span>100%</span></div>
                                                <div class="progress flex-auto" style="height: 6px;">
                                                    <div class="progress-bar bg-success " role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-success-soft text-dark-success">Completed</span>
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-7.jpg" class="rounded-circle imgtooltip" data-template="eleven">
                                                    <span id="eleven" class="d-none">
                                                        <span>Paul Haney</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-8.jpg" class="rounded-circle imgtooltip" data-template="twelve">
                                                    <span id="twelve" class="d-none">
                                                        <span>Gali Linear</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-9.jpg" class="rounded-circle imgtooltip" data-template="thirteen">
                                                    <span id="thirteen" class="d-none">
                                                        <span>Mary Holler</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm ">
                                                    <span class="avatar-initials rounded-circle bg-light text-dark">8+</span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropstart">
                                                <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                                </a>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="edit"></i>Edit Details
                                                    </a>

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="link"></i>Copy project link

                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="save"></i>Save as Default
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                    </a>


                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="upload"></i>Import
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="printer"></i>Export / Print
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="users"></i>Move to another team
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="archive"></i>Archive
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="trash"></i>Delete Project
                                                    </a>


                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-lg rounded-3 border ">
                                                    <i class="icon-sm text-muted" data-feather="users"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h4 class="mb-0 fs-5"><a href="#!" class="text-inherit">CRM Dashboard </a></h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            23 Dec, 2023
                                        </td>
                                        <td>
                                            $0
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2"> <span>30%</span></div>
                                                <div class="progress flex-auto" style="height: 6px;">
                                                    <div class="progress-bar bg-danger " role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="30">

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger-soft text-dark-danger">Cancel</span>
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-7.jpg" class="rounded-circle imgtooltip" data-template="twentyOne">
                                                    <span id="twentyOne" class="d-none">
                                                        <span>Paul Haney</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-8.jpg" class="rounded-circle imgtooltip" data-template="twentyTwo">
                                                    <span id="twentyTwo" class="d-none">
                                                        <span>Gali Linear</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm avatar-primary imgtooltip" data-template="textOne">
                                                    <span class="avatar-initials rounded-circle ">

                                                        DU</span>

                                                    <span id="textOne" class="d-none">
                                                        <span>Dash UI Only</span>

                                                    </span>
                                                </span>

                                                <span class="avatar avatar-sm ">
                                                    <span class="avatar-initials rounded-circle bg-light text-dark">4+</span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropstart">
                                                <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                                </a>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="edit"></i>Edit Details
                                                    </a>

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="link"></i>Copy project link

                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="save"></i>Save as Default
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                    </a>


                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="upload"></i>Import
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="printer"></i>Export / Print
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="users"></i>Move to another team
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="archive"></i>Archive
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="trash"></i>Delete Project
                                                    </a>


                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-lg rounded-3 border ">
                                                    <i class="icon-sm text-muted" data-feather="cpu"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h4 class="mb-0 fs-5"><a href="#!" class="text-inherit">Marketing Sites </a></h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            10 Oct, 2023
                                        </td>
                                        <td>
                                            $0
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2"> <span>10%</span></div>
                                                <div class="progress flex-auto" style="height: 6px;">
                                                    <div class="progress-bar bg-danger " role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="10">

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger-soft text-dark-danger">Cancel</span>
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-7.jpg" class="rounded-circle imgtooltip" data-template="fourteen">
                                                    <span id="fourteen" class="d-none">
                                                        <span>Paul Haney</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm avatar-primary imgtooltip" data-template="textTwo">
                                                    <span class="avatar-initials rounded-circle ">

                                                        DU</span>

                                                    <span id="textTwo" class="d-none">
                                                        <span>Dash UI Only</span>

                                                    </span>
                                                </span>

                                                <span class="avatar avatar-sm">
                                                    <img alt="avatar" src="../assets/images/avatar/avatar-9.jpg" class="rounded-circle imgtooltip" data-template="fifteen">
                                                    <span id="fifteen" class="d-none">
                                                        <span>Mary Holler</span>

                                                    </span>
                                                </span>
                                                <span class="avatar avatar-sm ">
                                                    <span class="avatar-initials rounded-circle bg-light text-dark">7+</span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropstart">
                                                <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                                </a>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="edit"></i>Edit Details
                                                    </a>

                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="link"></i>Copy project link

                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="save"></i>Save as Default
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="copy"></i>Duplicate
                                                    </a>


                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="upload"></i>Import
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class=" dropdown-item-icon" data-feather="printer"></i>Export / Print
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="users"></i>Move to another team
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="archive"></i>Archive
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#!">
                                                        <i class="dropdown-item-icon" data-feather="trash"></i>Delete Project
                                                    </a>


                                                </div>
                                            </div>
                                        </td>
                                    </tr>

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

<script>
    $(function() {
        var oTable = $('#example1').DataTable({
            // processing: true,
            // serverSide: true,
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"bottom"pi>',
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": false,
            "columnDefs": [{
                "className": "text-center",
                "targets": [0, 1, 2, 3, 4, 5], // table ke 1
            }, ],

        });
    })
</script>
@endsection