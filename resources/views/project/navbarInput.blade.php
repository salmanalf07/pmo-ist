@extends('index')


@section('konten')
<div id="app-content">

    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">


            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <div class="card rounded-bottom rounded-0 smooth-shadow-sm mb-5">
                        <div class="d-flex align-items-center justify-content-between pt-4 pb-6 px-4">
                            <div class="d-flex align-items-center">
                            </div>
                        </div>
                        <!-- nav -->
                        <ul class="nav nav-lt-tab px-4" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('project/inputProject') ? 'active' : '' }}" href="inputProject">Project Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('project/detailOrder') ? 'active' : '' }}" href="detailOrder">Detail Order</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('project/top') ? 'active' : '' }}" href="top">TOP</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('project/projectMember') ? 'active' : '' }}" href="projectMember">Project Member</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('project/scopeHighLevel') ? 'active' : '' }}" href="scopeHighLevel">Scope High Level</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('project/riskIssues') ? 'active' : '' }}" href="riskIssues">Risk/Issues</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('project/projectTimeline') ? 'active' : '' }}" href="projectTimeline">Project Timeline</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('project/mandays') ? 'active' : '' }}" href="mandays">Mandays</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div>
                @yield('inputan')
            </div>
        </div>
    </div>
</div>

@endsection