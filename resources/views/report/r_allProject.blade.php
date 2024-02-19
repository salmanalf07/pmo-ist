@extends('index')

@section('konten')
<!-- custom select2 -->
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div id="app-content">
    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <!-- row -->

            <div class="row mb-3">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="row col-12">
                                    <div class="text-end">
                                        <p>Report - {{$judul}}</p>
                                    </div>
                                </div>
                                <div class="row col-10">
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="selectOne">Customer</label>
                                        <select name="cust_ids" id="cust_ids" class="select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($customer as $customer)
                                            <option value="{{$customer->id}}">{{strtoupper($customer->company)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Project Manager</label>
                                        <select name="pmNames" id="pmNames" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($employee as $pmName)
                                            <option value="{{$pmName->id}}">{{$pmName->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Sales</label>
                                        <select name="saless" id="saless" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($employee as $sales)
                                            <option value="{{$sales->id}}">{{$sales->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label">SPK</label>
                                        <select name="spks" id="spks" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            <option value="noContract">NO SPK</option>
                                            @foreach($spk as $spks)
                                            <option value="{{$spks->noContract}}">{{$spks->noContract}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Project Status</label>
                                        <select name="status" id="status" class="select2" aria-label="Default select example" required>
                                            <option value="all">All</option>
                                            <option value="progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Project Sponsors</label>
                                        <select name="sponsors[]" id="sponsors" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($sponsors->unique('sponsorId') as $sponsor)
                                            @if($sponsor->employee != null)
                                            <option value="{{$sponsor->sponsorId}}">{{$sponsor->employee['name']}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row col-2 pt-7 ms-3">
                                    <div class="mb-3 col-6">
                                        <button id="clear" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Clear" class="btn btn-danger-soft" style="width:100%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <form method="post" role="form" id="form-print" action="/allProjectExport" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                            @csrf
                                            <input type="text" id="cust_id" name="cust_id" value="#" hidden>
                                            <input type="text" id="pmName" name="pmName" value="#" hidden>
                                            <input type="text" id="sales" name="sales" value="#" hidden>
                                            <input type="text" id="spk" name="spk" value="#" hidden>
                                            <input type="text" id="statusId" name="statusId" value="#" hidden>
                                            <input type="text" id="sponsor" name="sponsor" value="#" hidden>
                                            <button id="export" type="submit" class="btn btn-success-soft" style="width:100%">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20">
                                                    <path fill="currentColor" d="M15.534 1.36L14.309 0H4.662c-.696 0-.965.516-.965.919v3.63H5.05V1.653c0-.154.13-.284.28-.284h6.903c.152 0 .228.027.228.152v4.82h4.913c.193 0 .268.1.268.246v11.77c0 .246-.1.283-.25.283H5.33a.287.287 0 0 1-.28-.284V17.28H3.706v1.695c-.018.6.302 1.025.956 1.025H18.06c.7 0 .939-.507.939-.969V5.187l-.35-.38l-3.116-3.446Zm-1.698.16l.387.434l2.596 2.853l.143.173h-2.653c-.2 0-.327-.033-.38-.1c-.053-.065-.084-.17-.093-.313V1.52Zm-1.09 9.147h4.577v1.334h-4.578v-1.334Zm0-2.666h4.577v1.333h-4.578V8Zm0 5.333h4.577v1.334h-4.578v-1.334ZM1 5.626v10.667h10.465V5.626H1Zm5.233 6.204l-.64.978h.64V14H3.016l2.334-3.51l-2.068-3.156H5.01L6.234 9.17l1.223-1.836h1.727L7.112 10.49L9.449 14H7.656l-1.423-2.17Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })
</script>
<script>
    $(function() {
        $('.col-12').on('click', '#clear', function() {
            $('#cust_id').val('#');
            $('#pmName').val('#');
            $('#sales').val('#');
            $('#spk').val('#');
            $('#statusId').val('#');
            $('#sponsor').val('#');
            //
            $('#cust_ids').val('#').trigger('change');
            $('#pmNames').val('#').trigger('change');
            $('#saless').val('#').trigger('change');
            $('#spks').val('#').trigger('change');
            $('#status').val('#').trigger('change');
            $('#sponsors').val('#').trigger('change');
        });
        $('#cust_ids, #pmNames, #saless, #spks, #status, #sponsors').on('change', function() {
            $('#cust_id').val($('#cust_ids').val());
            $('#pmName').val($('#pmNames').val());
            $('#sales').val($('#saless').val());
            $('#spk').val($('#spks').val());
            $('#statusId').val($('#status').val());
            $('#sponsor').val($('#sponsors').val());
        });
    })
</script>
@endsection