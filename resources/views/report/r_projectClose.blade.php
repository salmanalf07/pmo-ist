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
                                        <select name="cust_id" id="cust_id" class="select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($customer as $customer)
                                            <option value="{{$customer->id}}">{{strtoupper($customer->company)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Project Manager</label>
                                        <select name="pmName" id="pmName" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($pm->unique('pmName') as $pmName)
                                            @if($pmName->pm != null)
                                            <option value="{{$pmName->pm->id}}">{{$pmName->pm->name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Date Range</label>
                                        <div class="input-group me-3">
                                            <input type="text" class="form-control float-right" id="reservation">
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="mb-3 col-6">
                                        <button id="in" type="button" class="btn btn-primary-soft" style="width:100%">Filter Data</button>
                                    </div> -->
                                    <div class="mb-3 col-12">
                                        <button id="clear" type="button" class="btn btn-danger-soft" style="width:100%">Clear Filter</button>
                                    </div>
                                </div>
                                <div class="row col-2 pt-7 ms-3">
                                    <div class="mb-3 col-12">
                                        <form method="post" role="form" id="form-print" action="/closeProjectExport" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                            @csrf
                                            <input type="text" id="date_st" name="date_st" hidden>
                                            <input type="text" id="date_ot" name="date_ot" hidden>
                                            <input type="text" id="cust_idd" name="cust_idd" hidden>
                                            <input type="text" id="pmNamee" name="pmNamee" hidden>
                                            <button id="export" type="submit" class="btn btn-success-soft" style="width:100%">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="0 0 20 20">
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

        $('#reservation').daterangepicker({
            startDate: moment().startOf('month'), // Mengatur tanggal awal ke awal bulan ini
            endDate: moment().endOf('month'), // Mengatur tanggal akhir ke akhir bulan ini
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function(start, end) {
            var dateinn = start.format('YYYY-MM-DD');
            var dateenn = end.format('YYYY-MM-DD');
        });
    })
</script>
<script>
    $(function() {
        $('.col-12').on('click', '#clear', function() {
            $('#date_st').val('');
            $('#date_ot').val('');
            $('#cust_idd').val('');
            $('#pmNamee').val('');
            //
            $('#cust_id').val('#').trigger('change');
            $('#pmName').val('#').trigger('change');
        });
        $('.col-12').on('change', '#reservation', function() {
            var date = $('#reservation').val().split(" - ");
            $('#date_st').val(date[0]);
            $('#date_ot').val(date[1]);
            // console.log(date)
        });

        $('#pmName, #cust_id').on('change', function() {
            $('#cust_idd').val($('#cust_id').val());
            $('#pmNamee').val($('#pmName').val());
        })
    })
</script>
@endsection