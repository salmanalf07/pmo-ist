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
                    <!-- <a class="nav-link {{ request()->is('pipeline') ? 'active' : '' }} pe-5" href="/pipeline">
                        Pipeline
                    </a> -->
                    @role(['SuperAdm','BOD'])
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ request()->is('dashboard','projectDashboard','r_allProject','r_projectClose','r_invByMonth','r_planInvhByCust','r_statPayment','r_planBast','r_sales*','r_pm*') ? 'active' : '' }} dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dashboard & Report
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPages">

                            <li>
                                <a class="dropdown-item" href="/dashboard">
                                    Executive Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/projectDashboard">
                                    Project Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/resourcesDashboard">
                                    Resources Dashboard
                                </a>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                                    Report
                                </a>
                                <ul class="dropdown-menu" style="min-width: 16.5rem">
                                    <li>
                                        <a class="dropdown-item" href="/r_allProject">
                                            All Data Project
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/r_projectClose">
                                            Project Close
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/r_invByMonth">
                                            Invoice By Month
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/r_planInvhByCust">
                                            Plan Invoice Monthly By Customer
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/r_statPayment">
                                            Status Payment
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/r_planBast">
                                            By Plan BAST Monthly
                                        </a>
                                    </li>
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                                            Sales
                                        </a>
                                        <ul class="dropdown-menu" style="min-width: 19rem">

                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/r_sales/detailPoBySales">
                                                    Detail PO Received
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/r_sales/summaryPoBySales">
                                                    Summary PO Received
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/r_sales/invoiceStatusSalesDetail">
                                                    Invoice Status Per PO Per Sales - Detail
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                                            Project Manager
                                        </a>
                                        <ul class="dropdown-menu" style="min-width: 19rem">
                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/r_pm/pmAssigment">
                                                    Summary PM Assigment
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>

                            </li>
                        </ul>
                    </li>
                    @endrole
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ request()->is('projectInfo','projectInfoByDate','projectByMainCon','project/*') ? 'active' : '' }} dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    @role(['SuperAdm','BOD'])
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ request()->is('financeInfo','financeTermsStat','financeByInvoice','financeByPayment') ? 'active' : '' }} dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Finance
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPages">

                            <li>
                                <a class="dropdown-item" href="/financeInfo">
                                    Plan BAST
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/financeByInvoice">
                                    Finance By Invoice
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/financeByPayment">
                                    Finance By Payment
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
                        <a class="nav-link {{ request()->is('employee','empByAssignment','empExtResources','empByUnassigned','partByAssignment') ? 'active' : '' }} dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Resources
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPages">

                            <li>
                                <a class="dropdown-item" href="/employee">
                                    All Employee
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/empByAssignment">
                                    By Assignment
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/partByAssignment">
                                    Partner By Assignment
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/empByUnassigned">
                                    By Unassigned
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/empExtResources">
                                    External Resources
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endrole
                    <a class="nav-link pe-5 {{ request()->is('profile','projectMethod','tempGuide','meeting','lessonLearned','linkComunity') ? 'active' : '' }}" href="/profile">
                        PMO
                    </a>
                    <!-- <a class="nav-link pe-5 {{ request()->is('customers') ? 'active' : '' }}" href="/customers">
                        Customers
                    </a> -->

                    @role(['Manage','PM'])
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ request()->is('customers','departments','divisions','doctypes','skilllevels','solutions','specializations','roles','users','taxes','logHistory','pmo*') ? 'active' : '' }} dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Master Data
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPages">
                            @if (Auth::user()->hasRole('SuperAdm') || Auth::user()->can('customers-editor'))
                            <li>
                                <a class="dropdown-item" href="/customers">
                                    Customer
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasRole('SuperAdm') || Auth::user()->can('departments-editor'))
                            <li>
                                <a class="dropdown-item" href="/departments">
                                    Department
                                </a>
                            </li>@endif
                            @if (Auth::user()->hasRole('SuperAdm') || Auth::user()->can('divisions-editor'))
                            <li>
                                <a class="dropdown-item" href="/divisions">
                                    Division
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasRole('SuperAdm') || Auth::user()->can('doctypes-editor'))
                            <li>
                                <a class="dropdown-item" href="/doctypes">
                                    Document Type
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasRole('SuperAdm') || Auth::user()->can('skilllevels-editor'))
                            <li>
                                <a class="dropdown-item" href="/skilllevels">
                                    Skill Level
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasRole('SuperAdm') || Auth::user()->can('solutions-editor'))
                            <li>
                                <a class="dropdown-item" href="/solutions">
                                    Solution
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasRole('SuperAdm') || Auth::user()->can('specializations-editor'))
                            <li>
                                <a class="dropdown-item" href="/specializations">
                                    Specialization
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasRole('SuperAdm') || Auth::user()->can('roles-editor'))
                            <li>
                                <a class="dropdown-item" href="/roles">
                                    Role
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasRole('SuperAdm') || Auth::user()->can('users-editor'))
                            <li>
                                <a class="dropdown-item" href="/users">
                                    User
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasRole('SuperAdm') || Auth::user()->can('taxes-editor'))
                            <li>
                                <a class="dropdown-item" href="/taxes">
                                    Taxes
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasRole('SuperAdm'))
                            <li>
                                <a class="dropdown-item" href="/logHistory">
                                    Log History
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasRole('SuperAdm'))
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                                    PMO
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                                            Template & Guideline
                                        </a>
                                        <ul class="dropdown-menu">

                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/pmo/guideCategory">
                                                    Category
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/pmo/guideType">
                                                    Type
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/pmo/tempGuide">
                                                    Data
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                                            Lesson Learned
                                        </a>
                                        <ul class="dropdown-menu">

                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/pmo/statusLeeson">
                                                    Status
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/pmo/leesonLearned">
                                                    Data
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                                            Link Community
                                        </a>
                                        <ul class="dropdown-menu">

                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/pmo/communityCategory">
                                                    Category
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/pmo/communityType">
                                                    Type
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="dropdown-item " href="/pmo/community">
                                                    Data
                                                </a>
                                            </li>
                                        </ul>
                                    </li>


                                </ul>

                            </li>
                            @endif
                        </ul>
                    </li>
                    @endrole
                </ul>
            </div>

        </nav>

    </div>
</div>