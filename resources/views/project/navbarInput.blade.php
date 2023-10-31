@extends('index')


@section('konten')
<div id="app-content">

    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">


            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <div class="card rounded-bottom rounded-0 smooth-shadow-sm mb-5">
                        <div class="d-flex align-items-end justify-content-end pt-4 pb-4 px-4">
                            {{isset($header)?$header:""}}
                        </div>
                        <!-- nav -->
                        <ul class="nav nav-lt-tab px-4" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/summaryProject') ? 'active' : '' }}" href="{{ isset($id) ? '/project/summaryProject/' . $id : '#' }}">Summary</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/inputProject') ? 'active' : '' }}" href="{{ isset($id) ? '/project/inputProject/' . $id : '/project/inputProject' }}">Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/detailOrder') ? 'active' : '' }}" href="{{ isset($id) ? '/project/detailOrder/' . $id : '#' }}">Detail Order</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/sow') ? 'active' : '' }}" href="{{ isset($id) ? '/project/sow/' . $id : '#' }}">SOW</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/top') ? 'active' : '' }}" href="{{ isset($id) ? '/project/top/' . $id : '#' }}">Terms</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/projectMember') ? 'active' : '' }}" href="{{ isset($id) ? '/project/projectMember/' . $id : '#' }}">Member</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/riskIssues') ? 'active' : '' }}" href="{{ isset($id) ? '/project/riskIssues/' . $id : '#' }}">Risk/Issues</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/projectTimeline') ? 'active' : '' }}" href="{{ isset($id) ? '/project/projectTimeline/' . $id : '#' }}">Timeline</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/mandays') ? 'active' : '' }}" href="{{ isset($id) ? '/project/mandays/' . $id : '#' }}">Mandays</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/documentation') ? 'active' : '' }}" href="{{ isset($id) ? '/project/documentation/' . $id : '#' }}">Documentation</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/costing') ? 'active' : '' }}" href="{{ isset($id) ? '/project/costing/' . $id : '#' }}">Project Costing</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/highAndNotes') ? 'active' : '' }}" href="{{ isset($id) ? '/project/highAndNotes/' . $id : '#' }}">Highlight And Notes</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ request()->is('project/moms*','project/formMoms*','editMom*') ? 'active' : '' }}" href="{{ isset($id) ? '/project/moms/' . $id : '#' }}">MOM</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ request()->is('project/gantt_cart/*') ? 'active' : '' }}" href="{{ isset($id) ? '/project/gantt_cart/' . $id : '#' }}">Gantt Cart</a>
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