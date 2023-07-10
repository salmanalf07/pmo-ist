<div class="navbar-horizontal nav-dashboard">
    <div class="container-fluid ">

        <nav class="navbar navbar-expand-lg navbar-default navbar-dropdown p-0 py-lg-2">
            <div class="d-flex d-lg-block justify-content-between align-items-center w-100 w-lg-0 py-2  px-4 px-md-2 px-lg-0">
                <span class="d-lg-none">Menu</span>
                <!-- Button -->
                <button class="navbar-toggler collapsed ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar top-bar mt-0"></span>
                    <span class="icon-bar middle-bar"></span>
                    <span class="icon-bar bottom-bar"></span>
                </button>
            </div>
            <!-- Collapse -->
            <div class="collapse navbar-collapse  px-6 px-lg-0" id="navbar-default">
                <ul class="navbar-nav ms-2">
                    <a class="nav-link {{ request()->is('pipeline') ? 'active' : '' }} pe-5" href="/pipeline">
                        Pipeline
                    </a>
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ request()->is('projectInfo','project/*') ? 'active' : '' }} dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Project
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPages">

                            <li>
                                <a class="dropdown-item" href="/projectInfo">
                                    Project All
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/projectInfoByDate">
                                    By Contract Date
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/projectByMainCon">
                                    By Main Contract
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ request()->is('financeInfo','financeTermsStat') ? 'active' : '' }} dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Finance
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPages">

                            <li>
                                <a class="dropdown-item" href="/financeInfo">
                                    Plan BAST
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/financeTermsStat">
                                    Terms Status
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ request()->is('employee') ? 'active' : '' }} dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Resources
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPages">

                            <li>
                                <a class="dropdown-item" href="/employee">
                                    All Employee
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    By Assignment
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    External Resources
                                </a>
                            </li>
                        </ul>
                    </li>
                    <a class="nav-link pe-5 {{ request()->is('customers') ? 'active' : '' }}" href="/customers">
                        Customers
                    </a>
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ request()->is('dashboard','projectDashboard') ? 'active' : '' }} dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dashboard
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPages">

                            <li>
                                <a class="dropdown-item" href="/dashboard">
                                    Management Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/projectDashboard">
                                    Project Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="../horizontal/starter.html">
                                    Resources Dashboard
                                </a>
                            </li>
                        </ul>
                    </li>
                    <a class="nav-link pe-5 {{ str_contains(request()->url(), 'profile') ? 'active' : '' }}" href="/profile">
                        PMO
                    </a>
                </ul>
            </div>

        </nav>

    </div>
</div>