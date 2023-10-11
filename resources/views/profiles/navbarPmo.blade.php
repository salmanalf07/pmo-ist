@extends('index')

@section('konten')
<div id="app-content">

    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">


            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <!-- Bg -->
                    <!-- <div class="pt-20 rounded-top" style="background: url(/assets/images/background/profile-cover.jpg)no-repeat;background-size: cover;"></div> -->
                    <div class="card rounded-bottom rounded-0 smooth-shadow-sm mb-5">
                        <div class="d-flex align-items-center justify-content-between pt-4 pb-6 px-4">
                            <div class="d-flex align-items-center">
                                <!-- avatar -->
                                <!-- <div class="avatar-xxl avatar-indicators avatar-online me-2 position-relative d-flex justify-content-end align-items-end mt-n10">
                                    <img src="/assets/images/logo-ist.png" class="avatar-xxl rounded-circle border border-2 " alt="Image">
                                    <a href="#!" class="position-absolute top-0 right-0 me-2">
                                        <img src="/assets/images/svg/checked-mark.svg" alt="Image" class="icon-sm">
                                    </a>
                                </div> -->
                                <!-- text -->
                                <!-- <div class="lh-1">
                                    <h2 class="mb-0">
                                        PMO PORTAL
                                        <a href="#!" class="text-decoration-none">
                                        </a>
                                    </h2>
                                    <p class="mb-0 d-block">PT. Infosys Solusi Terpadu</p>
                                </div> -->
                            </div>
                        </div>
                        <!-- nav -->
                        <ul class="nav nav-lt-tab px-4" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), '/profile') ? 'active' : '' }}" href="/profile">Team</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), '/projectMethod') ? 'active' : '' }}" href="/projectMethod">Project Method</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), '/tempGuide') ? 'active' : '' }}" href="/tempGuide">Template & Guidelines</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), '/lessonLearned') ? 'active' : '' }}" href="/lessonLearned">Lesson Learned</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), '/linkComunity') ? 'active' : '' }}" href="/linkComunity">Link Comunity</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div>
                @yield('pmo')
            </div>
        </div>
    </div>
</div>
@endsection