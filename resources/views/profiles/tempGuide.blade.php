@extends('/profiles/navbarPmo')

@section('pmo')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="row">
            @foreach ($category as $key => $categorys)
            <div class="col-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <a class="text-dark fs-4 " data-bs-toggle="collapse" href="#task{{$key}}" aria-expanded="false" aria-controls="task{{$key}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down icon-xs">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg> {{$categorys->categori}} <span class="text-muted"></span>
                            </a>
                        </div>


                        <div class="collapse show" id="task{{$key}}">
                            <div id="detail{{$key}}" class="p-2 mt-4">
                                @foreach ($typeId as $keyy => $typeIds)
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a class="text-dark fs-4 " data-bs-toggle="collapse" href="#taskk{{$keyy}}" aria-expanded="false" aria-controls="taskk{{$keyy}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down icon-xs">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg> {{$typeIds->type}} <span class="text-muted"></span>
                                        </a>
                                    </div>


                                    <div class="collapse show" id="taskk{{$keyy}}">
                                        <div id="detail{{$keyy}}" class="p-2 mt-4">
                                            @foreach ($tempGuide as $tempGuides)
                                            @if ($tempGuides->categoryId.$typeIds->id == $categorys->id.$tempGuides->typeId)
                                            <div class="row mb-2 border-bottom pb-2 g-0">
                                                <div class="col-lg-6">
                                                    <div class="d-flex">
                                                        <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                                        <div class="form-check custom-checkbox ">
                                                            <label class="form-check-label" for="customCheck1">
                                                                <span class="h5">{{$tempGuides->documentName}} </span>

                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 ms-5 ms-lg-0 mt-2 mt-lg-0">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="ms-4">{{$tempGuides->types->type}}</span>
                                                        <span class="me-10">
                                                            <a target="_blank" href="{{$tempGuides->link}}" class="btn btn-ghost btn-icon btn-sm rounded-circle ms-3" data-bs-toggle="tooltip" data-placement="top" title="Link">
                                                                <i class="bi bi-link-45deg icon-lg"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection