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
                                <a class="nav-link" href="#">Summary</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/inputProject') ? 'active' : '' }}" href="{{ isset($id) ? '/project/inputProject/' . $id : '/project/inputProject' }}">Project</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/detailOrder') ? 'active' : '' }}" href="{{ isset($id) ? '/project/detailOrder/' . $id : '/project/detailOrder' }}">Detail Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/top') ? 'active' : '' }}" href="{{ isset($id) ? '/project/top/' . $id : '/project/top' }}">Terms</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/scopeHighLevel') ? 'active' : '' }}" href="{{ isset($id) ? '/project/scopeHighLevel/' . $id : '/project/scopeHighLevel' }}">Scope</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/projectMember') ? 'active' : '' }}" href="{{ isset($id) ? '/project/projectMember/' . $id : '/project/projectMember' }}">Member</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/riskIssues') ? 'active' : '' }}" href="{{ isset($id) ? '/project/riskIssues/' . $id : '/project/riskIssues' }}">Risk/Issues</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/projectTimeline') ? 'active' : '' }}" href="{{ isset($id) ? '/project/projectTimeline/' . $id : '/project/projectTimeline' }}">Timeline</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link {{ str_contains(request()->url(), 'project/mandays') ? 'active' : '' }}" href="{{ isset($id) ? '/project/mandays/' . $id : '/project/mandays' }}">Mandays</a>
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