@extends('/project/navbarInput')

@section('inputan')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="card-body text-center">
                        <div class="row p-4" style="font-weight: bold; color: black">
                            <div class="col-lg-5 pt-2 pb-2 border border-start 1">Task</div>
                            <div class="col-lg-2 pt-2 pb-2 border border-start 1">Owner</div>
                            <div class="col-lg-1 pt-2 pb-2 border border-start 1">Start Date</div>
                            <div class="col-lg-1 pt-2 pb-2 border border-start 1">End Date</div>
                            <div class="col-lg-2 pt-2 pb-2 border border-start 1">Status</div>
                            <div class="col-lg-1 pt-2 pb-2 border border-start 1">Link</div>
                        </div>
                    </div>
                    @foreach ($section as $keyy => $sections)
                    @if ($keyy == 0)
                    @continue
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <a class="text-dark fs-4 " data-bs-toggle="collapse" href="#taskk{{$keyy}}" aria-expanded="false" aria-controls="taskk{{$keyy}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width=" 24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down icon-xs">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg> {{$sections->sectionName}} <span class="text-muted"></span>
                            </a>
                        </div>

                        <div class="collapse show" id="taskk{{$keyy}}">
                            <div id="detail{{$keyy}}" class="p-2 mt-4">
                                @foreach ($sections['task'] as $tasks)
                                <div class="row border-bottom g-0">
                                    <div class="col-lg-5 pt-2" style="border-right: 1px solid #dee2e6;">
                                        <div class="d-flex">
                                            <div class="me-2"><i class="mdi mdi-drag"></i></div>
                                            <div class="form-check custom-checkbox ">
                                                <label class="form-check-label" for="customCheck1">
                                                    <span class="h5">{{$tasks->taskName}} </span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 pt-2 ps-2" style="border-right: 1px solid #dee2e6;">
                                        <div class="d-flex">
                                            <div class="form-check custom-checkbox ">
                                                <label class="form-check-label" for="customCheck1">
                                                    <span class="h5">{{$tasks['detailTask']->assignee}}</span>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 pt-2 text-center" style="border-right: 1px solid #dee2e6;">
                                        <label class="form-check-label" for="customCheck1">
                                            <span class="h5">
                                                {{$tasks['detailTask']->start_on ? date('d-M-y', strtotime($tasks['detailTask']->start_on)) : ''}}
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-1 pt-2 text-center" style="border-right: 1px solid #dee2e6;">
                                        <label class="form-check-label" for="customCheck1">
                                            <span class="h5">
                                                {{$tasks['detailTask']->due_on ? date('d-M-y', strtotime($tasks['detailTask']->due_on)):''}}
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 pt-2 text-center" style="border-right: 1px solid #dee2e6;">
                                        <label class="form-check-label" for="customCheck1">
                                            <span class="h5">{{$tasks['detailTask']->status == 1 ? 'Completed' : null}}</span>

                                        </label>
                                    </div>
                                    <div class="col-lg-1 pt-2" style="border-right: 1px solid #dee2e6;">
                                        <div class="d-flex">
                                            <div class="form-check custom-checkbox ">
                                                <label class="form-check-label" for="customCheck1">
                                                    <span class="me-3">
                                                        <a target="_blank" href="{{$tasks['detailTask']->permalink_url}}" class="btn btn-ghost btn-icon btn-sm rounded-circle ms-3" data-bs-toggle="tooltip" data-placement="top" title="Link">
                                                            <i class="bi bi-link-45deg icon-lg"></i>
                                                        </a>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

@endsection