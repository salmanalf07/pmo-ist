<style>
  #initial-circle:hover::before {
    visibility: none;
    opacity: 0;
  }
</style>
<div class="header">
  <!-- navbar -->
  <div class="navbar-custom navbar navbar-expand-lg">
    <div class="container-fluid px-0">
      <div class="col-xl-12 col-lg-12 col-md-12 col-12">
        <!-- Bg -->
        <div class="d-flex align-items-center">
          <!-- avatar -->
          <div class="avatar-xxl me-2 position-relative d-flex justify-content-end align-items-end mt-n10" style="width: 10rem;">
            <img src="/assets/images/logo-ist.png" class="avatar-xl rounded-circle border border-2 " alt="Image">
          </div>
          <!-- text -->
          <div class="lh-1">
            <h2 class="mb-0">
              PMO PORTAL
              <a href="#!" class="text-decoration-none">
              </a>
            </h2>
            <p class="mb-0 d-block">PT. Infosys Solusi Terpadu</p>
          </div>
        </div>
      </div>
    </div>



    <a id="nav-toggle" href="#!" class="ms-auto ms-md-0 me-0 me-lg-3 ">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-text-indent-left text-muted" viewBox="0 0 16 16">
        <path d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
      </svg></a>

    <div class="d-none d-md-none d-lg-block">
      <!-- Form -->
      <!-- <form action="#">


          <div class="input-group ">
            <input class="form-control rounded-3" type="search" value="" id="searchInput" placeholder="Search">
            <span class="input-group-append">
              <button class="btn  ms-n10 rounded-0 rounded-end" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search text-dark">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
              </button>
            </span>
          </div>
        </form> -->
    </div>
    <!--Navbar nav -->
    <ul class="navbar-nav navbar-right-wrap ms-lg-auto d-flex nav-top-wrap align-items-center ms-4 ms-lg-0">
      <a href="#" class="form-check form-switch theme-switch btn btn-ghost btn-icon rounded-circle mb-0 " style="padding: 0 !important;display: inline-flex !important">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault"></label>

      </a>
      </li>

      <!-- List -->
      <li class="dropdown ms-2">
        <a class="rounded-circle" href="#!" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="avatar avatar-md">
            <div id="initial-container">
              <div class="initial-container" id="initial-circle" data-tooltip="{{auth()->user()->employee->name}}"></div>
            </div>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
          <div class="px-4 pb-0 pt-2">


            <div class="lh-1 ">
              <h5 class="mb-1">{{auth()->user()->employee->name}}</h5>
            </div>
            <div class=" dropdown-divider mt-3 mb-2"></div>
          </div>

          <ul class="list-unstyled">

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/user/profile">
                <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>Edit
                Profile
              </a>
            </li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit(); " role="button">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power me-2 icon-xxs dropdown-item-icon">
                    <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                    <line x1="12" y1="2" x2="12" y2="12"></line>
                  </svg>Sign Out
                </a>
              </form>
            </li>
          </ul>

        </div>
      </li>
    </ul>
  </div>
</div>
</div>