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
                                </svg>Leeson Learned</span>
                            </a>
                        </div>

                        <div class="collapse show" id="taskCardOne">
                            <div id="do" class="p-2 mt-4">
                                @foreach ($leesonLearned as $leesonLearneds )
                                <div class="row mb-2 border-bottom pb-2 g-0">
                                    <div class="col-lg-6">
                                        <div class="d-flex">
                                            <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                            <div class="form-check custom-checkbox ">
                                                <label class="form-check-label" for="customCheck1">
                                                    <span class="h5">{{$leesonLearneds->leesonLearned}}</span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ms-5 ms-lg-0 mt-2 mt-lg-0">
                                        <div class="d-flex justify-content-between">
                                            <img src="{{asset('/assets/images/avatar/avatar-11.jpg')}}" alt="Image" class="avatar avatar-xs rounded-2">
                                            <span class="ms-4">{{$leesonLearneds->pmNames->name}}</span>
                                            <span class="ms-4">{{date('d-F-Y',strtotime($leesonLearneds->uploadDate))}}</span>
                                            <span class="ms-6 me-10" data-bs-toggle="tooltip" data-placement="top" title="{{$leesonLearneds->statuss->keterangan}}">{{$leesonLearneds->statuss->status}}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection