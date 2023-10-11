@extends('/profiles/navbarPmo')

@section('pmo')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <a class="text-dark fs-4 " data-bs-toggle="collapse" href="#taskCardOne" aria-expanded="false" aria-controls="taskCardOne">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down icon-xs">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg> To Do <span class="text-muted">(12)</span>
                            </a>
                            <!-- dropdown -->
                            <div class="dropdown dropstart">
                                <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask11" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xs">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="12" cy="5" r="1"></circle>
                                        <circle cx="12" cy="19" r="1"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownTask11">
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 dropdown-item-icon">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>Edit this task
                                    </a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square dropdown-item-icon">
                                            <polyline points="9 11 12 14 22 4"></polyline>
                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                        </svg>Mark
                                        Complete</a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye dropdown-item-icon">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>View
                                        Details
                                    </a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize-2 dropdown-item-icon">
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <polyline points="9 21 3 21 3 15"></polyline>
                                            <line x1="21" y1="3" x2="14" y2="10"></line>
                                            <line x1="3" y1="21" x2="10" y2="14"></line>
                                        </svg>Open in
                                        New Tab</a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy dropdown-item-icon">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>Duplicate
                                        task</a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link dropdown-item-icon">
                                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                        </svg>Copy
                                        task link</a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 dropdown-item-icon ">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>Delete task
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="collapse show" id="taskCardOne">
                            <div id="do" class="p-2 mt-4">
                                <div class="row mb-2 border-bottom pb-2 g-0">
                                    <div class="col-lg-6">
                                        <div class="d-flex">
                                            <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                            <div class="form-check custom-checkbox ">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1">
                                                    <span class="h5">Initial setup your design </span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ms-5 ms-lg-0 mt-2 mt-lg-0">
                                        <div class="d-flex justify-content-between">
                                            <img src="../assets/images/avatar/avatar-11.jpg" alt="Image" class="avatar avatar-xs rounded-2">
                                            <span class="ms-4">30 Oct 2023</span>
                                            <span class="ms-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square me-1 icon-xs">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg>3/12</span>
                                            <span class="ms-6"><span class="badge badge-danger-soft">High</span></span>
                                            <span class="me-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right icon-xs">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2 border-bottom pb-2 g-0">
                                    <div class="col-lg-6">
                                        <div class="d-flex">
                                            <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                            <div class="form-check custom-checkbox">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">
                                                    <span class="h5">Invite your teammates and start
                                                        collaborating </span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ms-5 ms-lg-0 mt-2 mt-lg-0">
                                        <div class="d-flex justify-content-between">
                                            <img src="../assets/images/avatar/avatar-2.jpg" alt="Image" class="avatar avatar-xs rounded-2">
                                            <span class="ms-4">15 Oct 2023</span>
                                            <span class="ms-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square me-1 icon-xs">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg>8/16</span>
                                            <span class="ms-6"><span class="badge badge-warning-soft">Medium</span></span>
                                            <span class="me-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right icon-xs">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2 border-bottom pb-2 g-0">
                                    <div class="col-lg-6">
                                        <div class="d-flex">
                                            <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                            <div class="form-check custom-checkbox">
                                                <input type="checkbox" class="form-check-input" id="customCheck3">
                                                <label class="form-check-label" for="customCheck3">
                                                    <span class="h5">Start manage projects on the go </span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ms-5 ms-lg-0 mt-2 mt-lg-0">
                                        <div class="d-flex justify-content-between">
                                            <img src="../assets/images/avatar/avatar-3.jpg" alt="Image" class="avatar avatar-xs rounded-2">
                                            <span class="ms-4">25 Nov 2023</span>
                                            <span class="ms-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square me-1 icon-xs">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg>9/24</span>
                                            <span class="ms-6"><span class="badge badge-info-soft">Low</span></span>
                                            <span class="me-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right icon-xs">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg></span>
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
                            <a class="text-dark fs-4 " data-bs-toggle="collapse" href="#taskCardTwo" aria-expanded="false" aria-controls="taskCardTwo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down icon-xs">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg> Doing
                            </a>
                            <!-- dropdown -->
                            <div class="dropdown dropstart">
                                <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="dropdownTask2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xs">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="12" cy="5" r="1"></circle>
                                        <circle cx="12" cy="19" r="1"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownTask2">
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 dropdown-item-icon">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>Edit this task
                                    </a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square dropdown-item-icon">
                                            <polyline points="9 11 12 14 22 4"></polyline>
                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                        </svg>Mark
                                        Complete</a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye dropdown-item-icon">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>View
                                        Details
                                    </a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize-2 dropdown-item-icon">
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <polyline points="9 21 3 21 3 15"></polyline>
                                            <line x1="21" y1="3" x2="14" y2="10"></line>
                                            <line x1="3" y1="21" x2="10" y2="14"></line>
                                        </svg>Open in
                                        New Tab</a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy dropdown-item-icon">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>Duplicate
                                        task</a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link dropdown-item-icon">
                                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                        </svg>Copy
                                        task link</a>
                                    <a class="dropdown-item
                                      d-flex
                                      align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 dropdown-item-icon ">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>Delete task
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="collapse show" id="taskCardTwo">
                            <div id="progress" class="p-2 mt-4">
                                <div class="row mb-2 border-bottom pb-2 g-0">
                                    <div class="col-lg-6">
                                        <div class="d-flex">
                                            <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                            <div class="form-check custom-checkbox ">
                                                <input type="checkbox" class="form-check-input" id="customCheck4">
                                                <label class="form-check-label" for="customCheck4">
                                                    <span class="h5">Website launch planning </span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ms-5 ms-lg-0 mt-2 mt-lg-0">
                                        <div class="d-flex justify-content-between">
                                            <img src="../assets/images/avatar/avatar-4.jpg" alt="Image" class="avatar avatar-xs rounded-2">
                                            <span class="ms-4">15 Sept 2020</span>
                                            <span class="ms-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square me-1 icon-xs">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg>7/24</span>
                                            <span class="ms-6"><span class="badge badge-warning-soft">Meidum</span></span>
                                            <span class="me-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right icon-xs">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2 border-bottom pb-2 g-0">
                                    <div class="col-lg-6">
                                        <div class="d-flex">
                                            <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                            <div class="form-check custom-checkbox">
                                                <input type="checkbox" class="form-check-input" id="customCheck5">
                                                <label class="form-check-label" for="customCheck5">
                                                    <span class="h5">Start prototyping in framer </span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ms-5 ms-lg-0 mt-2 mt-lg-0">
                                        <div class="d-flex justify-content-between">
                                            <img src="../assets/images/avatar/avatar-5.jpg" alt="Image" class="avatar avatar-xs rounded-2">
                                            <span class="ms-4">17 Oct 2023</span>
                                            <span class="ms-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square me-1 icon-xs">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg>8/16</span>
                                            <span class="ms-6"><span class="badge badge-info-soft">Low</span></span>
                                            <span class="me-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right icon-xs">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2 border-bottom pb-2 g-0">
                                    <div class="col-lg-6">
                                        <div class="d-flex">
                                            <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                            <div class="form-check custom-checkbox">
                                                <input type="checkbox" class="form-check-input" id="customCheck7">
                                                <label class="form-check-label" for="customCheck7">
                                                    <span class="h5">Create a UI / UX designer team </span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ms-5 ms-lg-0 mt-2 mt-lg-0">
                                        <div class="d-flex justify-content-between">
                                            <img src="../assets/images/avatar/avatar-6.jpg" alt="Image" class="avatar avatar-xs rounded-2">
                                            <span class="ms-4">30 Sept 2020</span>
                                            <span class="ms-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square me-1 icon-xs">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg>23/24</span>
                                            <span class="ms-6"><span class="badge badge-danger-soft">High</span></span>
                                            <span class="me-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right icon-xs">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2 border-bottom pb-2 g-0">
                                    <div class="col-lg-6">
                                        <div class="d-flex">
                                            <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                            <div class="form-check custom-checkbox ">
                                                <input type="checkbox" class="form-check-input" id="customCheck8">
                                                <label class="form-check-label" for="customCheck8">
                                                    <span class="h5">Initial setup your design </span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ms-5 ms-lg-0 mt-2 mt-lg-0">
                                        <div class="d-flex justify-content-between">
                                            <img src="../assets/images/avatar/avatar-8.jpg" alt="Image" class="avatar avatar-xs rounded-2">
                                            <span class="ms-4">30 Oct 2023</span>
                                            <span class="ms-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square me-1 icon-xs">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg>3/12</span>
                                            <span class="ms-6"><span class="badge badge-danger-soft">High</span></span>
                                            <span class="me-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right icon-xs">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2 border-bottom pb-2 g-0">
                                    <div class="col-lg-6">
                                        <div class="d-flex">
                                            <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                            <div class="form-check custom-checkbox">
                                                <input type="checkbox" class="form-check-input" id="customCheck9">
                                                <label class="form-check-label" for="customCheck9">
                                                    <span class="h5">Invite your teammates and start
                                                        collaborating </span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ms-5 ms-lg-0 mt-2 mt-lg-0">
                                        <div class="d-flex justify-content-between">
                                            <img src="../assets/images/avatar/avatar-2.jpg" alt="Image" class="avatar avatar-xs rounded-2">
                                            <span class="ms-4">15 Oct 2023</span>
                                            <span class="ms-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square me-1 icon-xs">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg>8/16</span>
                                            <span class="ms-6"><span class="badge badge-warning-soft">Medium</span></span>
                                            <span class="me-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right icon-xs">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection