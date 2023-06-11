@extends('/profiles/navbarPmo')

@section('pmo')
<!-- row -->
<div class="row">
    <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="card h-100">
            <!-- card body -->
            <div class="card-header">
                <h4 class="mb-0">About Me</h4>
            </div>
            <div class="card-body">
                <!-- card title -->

                <h5 class="text-uppercase">Bio</h5>
                <!-- text -->
                <p class="mt-2 mb-6">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Suspen disse var ius enim in eros elementum tristique.
                    Duis cursus, mi quis viverra ornare, eros dolor interdum
                    nulla, ut commodo diam libero vitae erat.
                </p>
                <!-- row -->
                <div class="row">
                    <div class="col-12 mb-5">
                        <!-- text -->
                        <h5 class="text-uppercase">Position</h5>
                        <p class="mb-0">Theme designer at Bootstrap.</p>
                    </div>
                    <div class="col-6 mb-5">
                        <h5 class="text-uppercase">Phone</h5>
                        <p class="mb-0">+32112345689</p>
                    </div>
                    <div class="col-6 mb-5">
                        <h5 class="text-uppercase">
                            Date of Birth
                        </h5>
                        <p class="mb-0">01.10.1997</p>
                    </div>
                    <div class="col-6">
                        <h5 class="text-uppercase">Email</h5>
                        <p class="mb-0">Dashui@gmail.com</p>
                    </div>
                    <div class="col-6">
                        <h5 class="text-uppercase">Location</h5>
                        <p class="mb-0">Ahmedabad, India</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Projects Contributions</h4>
            </div>
            <!-- card body -->
            <div class="card-body">
                <!-- card title -->

                <div class="d-md-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <div>
                            <div>
                                <img src="/assets/images/svg/brand-logo-1.svg" alt="Image">
                            </div>
                        </div>
                        <!-- text -->
                        <div class="ms-3">
                            <h5 class="mb-1">
                                <a href="#!" class="text-inherit">Slack Figma Design UI</a>
                            </h5>
                            <p class="mb-0 fs-5 text-muted">
                                Project description and details about...
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center ms-10 ms-md-0 mt-3">
                        <!-- avatar group -->
                        <div class="avatar-group me-2">
                            <!-- img -->
                            <span class="avatar avatar-sm">
                                <img alt="avatar" src="/assets/images/avatar/avatar-11.jpg" class="rounded-circle">
                            </span>
                            <!-- img -->
                            <span class="avatar avatar-sm">
                                <img alt="avatar" src="/assets/images/avatar/avatar-2.jpg" class="rounded-circle">
                            </span>
                            <!-- img -->
                            <span class="avatar avatar-sm">
                                <img alt="avatar" src="/assets/images/avatar/avatar-3.jpg" class="rounded-circle">
                            </span>
                        </div>
                        <div>
                            <!-- dropdown -->
                            <div class="dropdown dropstart">
                                <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle" id="dropdownprojectOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownprojectOne">
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Action</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Another action</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <div>
                            <!-- icon shape -->
                            <div>
                                <img src="/assets/images/svg/brand-logo-2.svg" alt="Image">
                            </div>
                        </div>
                        <!-- text -->
                        <div class="ms-3">
                            <h5 class="mb-1">
                                <a href="#!" class="text-inherit">Design 3d Character</a>
                            </h5>
                            <p class="mb-0 fs-5 text-muted">
                                Project description and details about...
                            </p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center ms-10 ms-md-0 mt-3">
                        <!-- avatar group -->
                        <div class="avatar-group me-2">
                            <span class="avatar avatar-sm">
                                <!-- img -->
                                <img alt="avatar" src="/assets/images/avatar/avatar-4.jpg" class="rounded-circle">
                            </span>
                            <span class="avatar avatar-sm">
                                <!-- img -->
                                <img alt="avatar" src="/assets/images/avatar/avatar-5.jpg" class="rounded-circle">
                            </span>
                            <span class="avatar avatar-sm">
                                <!-- img -->
                                <img alt="avatar" src="/assets/images/avatar/avatar-6.jpg" class="rounded-circle">
                            </span>
                        </div>
                        <div>
                            <!-- dropdown -->
                            <div class="dropdown dropstart">
                                <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle" id="dropdownprojectTwo" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownprojectTwo">
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Action</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Another action</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <div>
                            <!-- icon shape -->
                            <div>
                                <img src="/assets/images/svg/brand-logo-3.svg" alt="Image">
                            </div>
                        </div>
                        <!-- text -->
                        <div class="ms-3">
                            <h5 class="mb-1">
                                <a href="#!" class="text-inherit">Github Development</a>
                            </h5>
                            <p class="mb-0 fs-5 text-muted">
                                Project description and details about...
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center ms-10 ms-md-0 mt-3">
                        <!-- avatar group -->
                        <div class="avatar-group me-2">
                            <span class="avatar avatar-sm">
                                <!-- img -->
                                <img alt="avatar" src="/assets/images/avatar/avatar-7.jpg" class="rounded-circle">
                            </span>
                            <span class="avatar avatar-sm">
                                <!-- img -->
                                <img alt="avatar" src="/assets/images/avatar/avatar-8.jpg" class="rounded-circle">
                            </span>
                            <span class="avatar avatar-sm">
                                <!-- img -->
                                <img alt="avatar" src="/assets/images/avatar/avatar-9.jpg" class="rounded-circle">
                            </span>
                        </div>
                        <div>
                            <!-- dropdown -->
                            <div class="dropdown dropstart">
                                <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle" id="dropdownprojectThree" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownprojectThree">
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Action</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Another action</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <!-- icon shape -->
                        <div>
                            <div>
                                <img src="/assets/images/svg/brand-logo-4.svg" alt="Image">
                            </div>
                        </div>
                        <!-- text -->
                        <div class="ms-3">
                            <h5 class="mb-1">
                                <a href="#!" class="text-inherit">Dropbox Design System</a>
                            </h5>
                            <p class="mb-0 fs-5 text-muted">
                                Project description and details about...
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center ms-10 ms-md-0 mt-3">
                        <!-- avatar group -->
                        <div class="avatar-group me-2">
                            <!-- img -->
                            <span class="avatar avatar-sm">
                                <img alt="avatar" src="/assets/images/avatar/avatar-10.jpg" class="rounded-circle">
                            </span>
                            <!-- img -->
                            <span class="avatar avatar-sm">
                                <img alt="avatar" src="/assets/images/avatar/avatar-11.jpg" class="rounded-circle">
                            </span>
                            <!-- img -->
                            <span class="avatar avatar-sm">
                                <img alt="avatar" src="/assets/images/avatar/avatar-12.jpg" class="rounded-circle">
                            </span>
                        </div>
                        <div>
                            <!-- dropdown -->
                            <div class="dropdown dropstart">
                                <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle" id="dropdownprojectFour" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownprojectFour">
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Action</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Another action</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <!-- icon shape -->
                        <div>
                            <div>
                                <img src="/assets/images/svg/brand-logo-5.svg" alt="Image">
                            </div>
                        </div>
                        <!-- text -->
                        <div class="ms-3">
                            <h5 class="mb-1">
                                <a href="#!" class="text-inherit">Project Management</a>
                            </h5>
                            <p class="mb-0 fs-5 text-muted">
                                Project description and details about...
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center ms-10 ms-md-0 mt-3">
                        <!-- avatar group -->
                        <div class="avatar-group me-2">
                            <!-- img -->
                            <span class="avatar avatar-sm">
                                <img alt="avatar" src="/assets/images/avatar/avatar-13.jpg" class="rounded-circle">
                            </span>
                            <!-- img -->
                            <span class="avatar avatar-sm">
                                <img alt="avatar" src="/assets/images/avatar/avatar-14.jpg" class="rounded-circle">
                            </span>
                            <!-- img -->
                            <span class="avatar avatar-sm">
                                <img alt="avatar" src="/assets/images/avatar/avatar-15.jpg" class="rounded-circle">
                            </span>
                        </div>
                        <div>
                            <!-- dropdown -->
                            <div class="dropdown dropstart">
                                <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle" id="dropdownprojectFoufive" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" class="icon-xs"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownprojectFoufive">
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Action</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Another action</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#!">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="card">
            <!-- card body -->
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5 align-items-center">
                    <!-- avatar -->
                    <div class="d-flex align-items-center">
                        <div>
                            <img src="/assets/images/avatar/avatar-11.jpg" alt="Image" class="avatar avatar-md rounded-circle">
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 ">Jitu Chauhan</h5>
                            <p class="mb-0">19 minutes ago</p>
                        </div>
                    </div>
                    <div>
                        <!-- dropdown -->
                        <div class="dropdown dropstart">
                            <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle" id="dropdownprojectFive" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="more-vertical" class="icon-xs"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownprojectFive">
                                <a class="dropdown-item d-flex align-items-center" href="#!">Action</a>
                                <a class="dropdown-item d-flex align-items-center" href="#!">Another action</a>
                                <a class="dropdown-item d-flex align-items-center" href="#!">Something else here</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <!-- text -->
                    <p class="mb-4">
                        Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit. Suspen disse var ius enim in eros elementum
                        tristique. Duis cursus, mi quis viverra ornare, eros
                        dolor interdum nulla, ut commodo diam libero vitae
                        erat.
                    </p>
                    <img src="/assets/images/blog/blog-img-1.jpg" class="rounded-3 w-100" alt="Image">
                </div>
                <!-- icons -->
                <div class="mb-4">
                    <span class="me-1 me-md-4"><i data-feather="heart" class="icon-xxs text-muted me-2"></i><span>20 Like</span></span>
                    <span class="me-1 me-md-4"><i data-feather="message-square" class="icon-xxs text-muted me-2"></i><span>12 Comment</span></span>
                    <span><i data-feather="share-2" class="icon-xxs text-muted me-2"></i><span>Share</span></span>
                </div>
                <div class="border-bottom border-top py-5 d-flex align-items-center mb-4">
                    <!-- avatar group -->
                    <div class="avatar-group me-2 me-md-3">
                        <span class="avatar avatar-sm">
                            <!-- img -->
                            <img alt="avatar" src="/assets/images/avatar/avatar-7.jpg" class="rounded-circle">
                        </span>
                        <span class="avatar avatar-sm">
                            <!-- img -->
                            <img alt="avatar" src="/assets/images/avatar/avatar-8.jpg" class="rounded-circle">
                        </span>
                        <span class="avatar avatar-sm">
                            <!-- img -->
                            <img alt="avatar" src="/assets/images/avatar/avatar-9.jpg" class="rounded-circle">
                        </span>
                    </div>
                    <div><span>You and 20 more liked this</span></div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-1 col-lg-2 col-md-2 col-12 mb-3 mb-lg-0">
                        <!-- avatar -->
                        <img src="/assets/images/avatar/avatar-11.jpg" class="avatar avatar-md rounded-circle" alt="Image">
                    </div>
                    <!-- input -->
                    <div class="col-xl-11 col-lg-10 col-md-9 col-12">
                        <div class="row g-3 align-items-center">

                            <div class="col-md-8 col-xxl-10 mt-0 mt-md-3">
                                <input type="password" id="name" class="form-control" aria-describedby="name">
                            </div>
                            <div class="col-md-2 col-xxl-2 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Post
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="card mb-5">
            <!-- card body -->
            <div class="card-header">
                <h4 class="mb-0">My Team</h4>
            </div>

            <div class="card-body">
                <!-- card title -->

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <!-- img -->
                        <div>
                            <img src="/assets/images/avatar/avatar-11.jpg" class="rounded-circle avatar-md" alt="Image">
                        </div>
                        <!-- text -->
                        <div class="ms-3">
                            <h5 class="mb-1">Dianna Smiley</h5>
                            <p class="text-muted mb-0 fs-5 text-muted">
                                UI / UX Designer
                            </p>
                        </div>
                    </div>
                    <div>
                        <!-- icons -->
                        <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="callOne">
                            <i data-feather="phone-call" class="icon-xs"></i>
                            <div id="callOne" class="d-none">
                                <span>Call</span>
                            </div>
                        </a>
                        <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="videoOne">
                            <i data-feather="video" class="icon-xs"></i>
                            <div id="videoOne" class="d-none">
                                <span>Video</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <!-- img -->
                        <div>
                            <img src="/assets/images/avatar/avatar-2.jpg" class="rounded-circle avatar-md" alt="Image">
                        </div>
                        <!-- content -->
                        <div class="ms-3">
                            <h5 class="mb-1">Anne Brewer</h5>
                            <p class="text-muted mb-0 fs-5 text-muted">
                                Senior UX Designer
                            </p>
                        </div>
                    </div>
                    <div>
                        <!-- icons -->
                        <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="callTwo">
                            <i data-feather="phone-call" class="icon-xs"></i>
                            <div id="callTwo" class="d-none">
                                <span>Call</span>
                            </div>
                        </a>
                        <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="videoTwo">
                            <i data-feather="video" class="icon-xs"></i>
                            <div id="videoTwo" class="d-none">
                                <span>Video</span>
                            </div>
                        </a>


                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <!-- img -->
                        <div>
                            <img src="/assets/images/avatar/avatar-3.jpg" class="rounded-circle avatar-md" alt="Image">
                        </div>
                        <!-- text -->
                        <div class="ms-3">
                            <h5 class="mb-1">Richard Christmas</h5>
                            <p class="text-muted mb-0">Front-End Engineer</p>
                        </div>
                    </div>
                    <div>
                        <!-- icons -->
                        <!-- icons -->
                        <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="callThree">
                            <i data-feather="phone-call" class="icon-xs"></i>
                            <div id="callThree" class="d-none">
                                <span>Call</span>
                            </div>
                        </a>
                        <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="videoThree">
                            <i data-feather="video" class="icon-xs"></i>
                            <div id="videoThree" class="d-none">
                                <span>Video</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <!-- img -->
                    <div class="d-flex align-items-center">
                        <div>
                            <img src="/assets/images/avatar/avatar-4.jpg" class="rounded-circle avatar-md" alt="Image">
                        </div>
                        <!-- text -->
                        <div class="ms-3">
                            <h5 class="mb-1">Nicholas Binder</h5>
                            <p class="text-muted mb-0 fs-5">
                                Content Marketing Manager
                            </p>
                        </div>
                    </div>
                    <div>
                        <!-- icons -->
                        <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="callFour">
                            <i data-feather="phone-call" class="icon-xs"></i>
                            <div id="callFour" class="d-none">
                                <span>Call</span>
                            </div>
                        </a>
                        <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="videoFour">
                            <i data-feather="video" class="icon-xs"></i>
                            <div id="videoFour" class="d-none">
                                <span>Video</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-header">
                        <h4 class="mb-0">Activity Feed</h4>
                    </div>
                    <div class="card-body">
                        <!-- card title -->

                        <div class="d-flex mb-5">
                            <!-- img -->
                            <div>
                                <img src="/assets/images/avatar/avatar-6.jpg" class="rounded-circle avatar-md" alt="Image">
                            </div>
                            <!-- content -->
                            <div class="ms-3">
                                <h5 class="mb-1">Dianna Smiley</h5>
                                <p class="text-muted mb-2">
                                    Just create a new Project in Dashui...
                                </p>
                                <p class="fs-5 mb-0">2m ago</p>
                            </div>
                        </div>
                        <div class="d-flex mb-5">
                            <!-- img -->
                            <div>
                                <img src="/assets/images/avatar/avatar-7.jpg" class="rounded-circle avatar-md" alt="Image">
                            </div>
                            <!-- content -->
                            <div class="ms-3">
                                <h5 class="mb-1">Irene Hargrove</h5>
                                <p class="text-muted mb-2">
                                    Comment on Bootstrap Tutorial Says Hi, I m
                                    irene...
                                </p>
                                <p class="fs-5 mb-0">1hour ago</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <!-- img -->
                            <div>
                                <img src="/assets/images/avatar/avatar-9.jpg" class="rounded-circle avatar-md" alt="Image">
                            </div>
                            <!-- content -->
                            <div class="ms-3">
                                <h5 class="mb-1">Trevor Bradley</h5>
                                <p class="text-muted mb-2">
                                    Just share your article on Social Media..
                                </p>
                                <p class="mb-0 fs-5 text-muted">2month ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection