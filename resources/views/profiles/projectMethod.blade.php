@extends('/profiles/navbarPmo')

@section('pmo')
<!-- row -->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="card mb-10">
            <ul class="nav nav-line-bottom nav-example mb-3" id="pills-tabTwo" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-accordions-design-tab" data-bs-toggle="pill" href="#pills-accordions-design" role="tab" aria-controls="pills-accordions-design" aria-selected="true">Pre Project</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-accordions-html-tab" data-bs-toggle="pill" href="#pills-accordions-html" role="tab" aria-controls="pills-accordions-html" aria-selected="false" tabindex="-1">Initiation & Planning</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-accordions-executing-tab" data-bs-toggle="pill" href="#pills-accordions-executing" role="tab" aria-controls="pills-accordions-executing" aria-selected="false" tabindex="-1">Executing</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-accordions-closing-tab" data-bs-toggle="pill" href="#pills-accordions-closing" role="tab" aria-controls="pills-accordions-closing" aria-selected="false" tabindex="-1">Closing</a>
                </li>
            </ul>
            <div class="tab-content p-4" id="pills-tabTwoContent">
                <div class="tab-pane tab-example-design fade active show" id="pills-accordions-design" role="tabpanel" aria-labelledby="pills-accordions-design-tab">
                    <img src="{{asset('assets/images/projectMethod/PRE-PROJECT.png')}}" width="100%" alt="Pre Project">
                </div>
                <div class="tab-pane tab-example-html fade" id="pills-accordions-html" role="tabpanel" aria-labelledby="pills-accordions-html-tab">
                    <img src="{{asset('assets/images/projectMethod/INITIATION-PLAN.png')}}" width="100%" alt="Pre Project">
                </div>
                <div class="tab-pane tab-example-executing fade" id="pills-accordions-executing" role="tabpanel" aria-labelledby="pills-accordions-executing-tab">
                    <img src="{{asset('assets/images/projectMethod/EXCECUTING.png')}}" width="100%" alt="Pre Project">
                </div>
                <div class="tab-pane tab-example-closing fade" id="pills-accordions-closing" role="tabpanel" aria-labelledby="pills-accordions-closing-tab">
                    <img src="{{asset('assets/images/projectMethod/CLOSING.png')}}" width="100%" alt="Pre Project">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection