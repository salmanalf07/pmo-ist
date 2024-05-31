@extends('/project/navbarInput')

@section('inputan')
<!-- custom select2 -->
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div>
    <!-- row -->

    <div class="row">
        <div class="col-lg-12 col-12">

            <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                <div class="row">
                    @csrf
                    <span id="peringatan"></span>
                    <input class="form-control" type="text" name="id" id="id" hidden>
                    <div class="col-xxl-7 col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-2 col-12">
                                        <h4 class="form-label">Project Information</h4>
                                    </div>
                                    <ul class="nav nav-lt-tab px-4 mb-3" id="pills-tab" role="tablist">
                                    </ul>
                                    <div class="mb-3 col-3">
                                        <label class="form-label">Project ID</label>
                                        <input name="noProject" id="noProject" value="{{ (isset($noProject)) ? $noProject : $data->noProject }}" type="text" class="form-control" readonly>
                                    </div>
                                    <div class="mb-3 col-9">
                                        <label class="form-label">Project Short Name</label>
                                        <input name="shortProjectName" id="shortProjectName" type="text" class="form-control" required>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="form-label">Project Name By Contract</label>
                                        <input name="projectName" id="projectName" type="text" class="form-control" placeholder="Enter Here" required>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="selectOne">Solution</label>
                                        <select name="solution" id="solution" class="select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach(collect($solution)->sortBy('name') as $solution)
                                            <option value="{{$solution->id}}">{{$solution->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6"></div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="selectOne">Customer</label>
                                        <select name="cust_id" id="cust_id" class="select2" aria-label="Default select example">
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($customer as $customer)
                                            <option value="{{$customer->id}}">{{strtoupper($customer->company)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="selectOne">Sector</label>
                                        <select name="customerType" id="customerType" class="select2" aria-label="Default select example">
                                            <option selected>Open this select menu</option>
                                            <option value="BankingNFinancialServicesIndustry">Banking & Financial Services Industry</option>
                                            <option value="bumn">BUMN</option>
                                            <option value="government">Government</option>
                                            <option value="manufacture">Manufacture</option>
                                            <option value="swasta">Swasta</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Project Value</label>
                                        <input name="projectValuePPN" id="projectValuePPN" type="text" class="form-control number-input" value="0" placeholder="Enter Here" required>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Project Value + PPN</label>
                                        <input name="projectValue" id="projectValue" type="text" class="form-control number-input" value="0" placeholder="Enter Here" required>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="selectOne">Project Type</label>
                                        <select name="projectType" id="projectType" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            <option value="internal">Internal</option>
                                            <option value="external">External</option>
                                            <option value="joinDevelopment">Join Development</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6" id="joinDev1"></div>
                                    <div class="mb-3 col-6" id="joinDev2" hidden>
                                        <label class="form-label" for="selectOne">Partner</label>
                                        <select name="partnerId" id="partnerId" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($partner as $partner)
                                            <option value="{{$partner->id}}">{{$partner->company}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Contract Start Date</label>
                                        <div class="input-group me-3 datepicker">
                                            <input id="contractStart" name="contractStart" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Contract End Date</label>
                                        <div class="input-group me-3 datepicker">
                                            <input id="contractEnd" name="contractEnd" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-5 col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-2 col-12">
                                        <h4 class="form-label">Contract Information</h4>
                                    </div>
                                    <ul class="nav nav-lt-tab px-4 mb-3" id="pills-tab" role="tablist">
                                    </ul>
                                    <div class="mb-3 col-12">
                                        <label class="form-label">Contract PO/SPP/SO Number</label>
                                        <input name="noContract" id="noContract" type="text" class="form-control" placeholder="Enter Here" required>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="form-label">Contract Date</label>
                                        <div class="input-group me-3 datepicker">
                                            <input id="contractDate" name="contractDate" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="form-label" for="flexCheckChecked">
                                            Has main contract?
                                        </label>
                                        <input class="form-check-input" type="checkbox" id="payung">
                                    </div>
                                    <div id="poHid" class="mb-3 col-12" hidden>
                                        <label class="form-label">Main Contract</label>
                                        <input name="po" id="po" type="text" value="{{ (isset($data->po)) ? $data->po : '' }}" class="form-control" placeholder="Enter Here">
                                    </div>
                                    <div id="noPoHid" class="mb-3 col-12" hidden>
                                        <label class="form-label">Main Contract Number</label>
                                        <input name="noPo" id="noPo" type="text" class="form-control" placeholder="Enter Here">
                                    </div>
                                    <div id="datePoHid" class="mb-3 col-12" hidden>
                                        <label class="form-label">Main Contract Date</label>
                                        <div class="input-group me-3 datepicker">
                                            <input id="datePo" name="datePo" type="text" class="form-control rounded" data-input aria-describedby="date1">
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="datePoSt" class="mb-3 col-6" hidden>
                                        <label class="form-label">Main Contract Start Date</label>
                                        <div class="input-group me-3 datepicker">
                                            <input id="dateStPo" name="dateStPo" type="text" class="form-control rounded" data-input aria-describedby="date1">
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="datePoEd" class="mb-3 col-6" hidden>
                                        <label class="form-label">Main Contract End Date</label>
                                        <div class="input-group me-3 datepicker">
                                            <input id="dateEdPo" name="dateEdPo" type="text" class="form-control rounded" data-input aria-describedby="date1">
                                            <div class="input-group-append custom-picker">
                                                <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="valuePo" class="mb-3 col-12" hidden>
                                        <label class="form-label">Main Contract Value</label>
                                        <input name="poValue" id="poValue" type="text" class="form-control number-input" value="0" placeholder="Enter Here" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- input -->
                    <div class="col-xxl-12 col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-2 col-12">
                                        <h4 class="form-label">Person In Charge</h4>
                                    </div>
                                    <ul class="nav nav-lt-tab px-4 mb-3" id="pills-tab" role="tablist">
                                    </ul>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="selectOne">Sales</label>
                                        <select name="sales" id="sales" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($employee as $sales)
                                            <option value="{{$sales->id}}">{{$sales->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="selectOne">Project Manager</label>
                                        <select name="pmName" id="pmName" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($employee as $pmName)
                                            <option value="{{$pmName->id}}">{{$pmName->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="selectOne">Co Project Manager</label>
                                        <select name="coPm" id="coPm" class="select2" aria-label="Default select example" required>
                                            <option value="#" selected>Open this select menu</option>
                                            @foreach($employee as $coPm)
                                            <option value="{{$coPm->id}}">{{$coPm->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sponsor</label>
                                        <select name="sponsor[]" id="sponsor" multiple="multiple" class="select2 multi-sponsor" aria-label="Default select example" required>
                                            @foreach($employee as $sponsor)
                                            <option value="{{$sponsor->id}}">{{$sponsor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    @can('bisa-tambah')
                    <div class="mb-3 col-3">
                        <button type="button" class="btn btn-primary-soft add"> Save</button>
                    </div>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>

<!-- flatpickr -->
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>

<script>
    $(function() {
        //add data
        $('.col-3').on('click', '.add', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '{{ url("store_project") }}',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data[1]) {
                        let text = "";
                        var dataa = Object.assign({}, data[0])
                        for (let x in dataa) {
                            text += "<div class='alert alert-dismissible hide fade in alert-danger show'><strong>Errorr!</strong> " + dataa[x] + "<a href='#' class='close float-close' data-dismiss='alert' aria-label='close'>×</a></div>";
                        }
                        $('#peringatan').append(text);
                    } else {
                        //console.log(data)
                        document.getElementById("form-add").reset();
                        window.location.href = "/project/inputProject/" + data[0].id;
                    }

                },
            });
        });
    })
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('#payung').change(function() {
            if ($(this).is(':checked')) {
                $('#poHid').removeAttr('hidden');
                $('#noPoHid').removeAttr('hidden');
                $('#datePoHid').removeAttr('hidden');
                $('#datePoSt').removeAttr('hidden');
                $('#datePoEd').removeAttr('hidden');
                $('#valuePo').removeAttr('hidden');
            } else {
                $('#poHid').attr('hidden', 'hidden');
                $('#noPoHid').attr('hidden', 'hidden');
                $('#datePoHid').attr('hidden', 'hidden');
                $('#datePoSt').attr('hidden', 'hidden');
                $('#datePoEd').attr('hidden', 'hidden');
                $('#valuePo').attr('hidden', 'hidden');
            }
        });
        $('#projectType').change(function() {
            var selectedOption = $(this).val();
            if (selectedOption === 'external' || selectedOption === 'joinDevelopment') {
                $('#joinDev1').attr('hidden', 'hidden');
                $('#joinDev2').removeAttr('hidden');
            } else {
                $('#joinDev2').attr('hidden', 'hidden');
                $('#joinDev1').removeAttr('hidden');
            }
        });
        $('#projectValue').on('input', function() {
            var projectValue = $(this).val();
            $('#projectValuePPN').val(formatNumberr(calculatePriceWithoutVAT(projectValue.replace(/\./g, ""))));
        });
        $('#projectValuePPN').on('input', function() {
            var projectValue = $(this).val();
            $('#projectValue').val(formatNumberr(calculatePriceWithVAT(projectValue.replace(/\./g, ""))));
        });

    });
    //datepicker
    flatpickr("#contractDate,#contractStart,#contractEnd,#datePo,#dateStPo,#dateEdPo", {
        dateFormat: "d-m-Y",
        defaultDate: "01-01-1900",
        allowInput: true, // Mengizinkan input manual
    });
</script>
<script>
    $(document).ready(function() {
        if ('{{isset($aksi) && $aksi == "EditData"}}') {
            $('#id').val('{!! isset($data) ? $data->id : "" !!}');
            $('#noProject').val('{!! isset($data) ? $data->noProject : "" !!}');
            $('#cust_id').val('{!! isset($data) ? $data->cust_id : "" !!}').trigger('change');
            $('#customerType').val('{!! isset($data) ? $data->customerType : "" !!}').trigger('change');
            $('#projectName').val('{!! isset($data) ? $data->projectName : "" !!}');
            $('#shortProjectName').val('{!! isset($data) ? $data->shortProjectName : "" !!}');
            $('#solution').val('{!! isset($data) ? $data->solution : "" !!}').trigger('change');
            $('#po').val('{!! isset($data) ? $data->po : "" !!}');
            $('#noContract').val(`{!! isset($data) ? $data->noContract : "" !!}`);
            $('#contractDate').val(('{!! isset($data) ? $data->contractDate : "" !!}').split("-").reverse().join("-"));
            if ('{!! isset($data) && $data->po !== null !!}') {
                $("#payung").prop("checked", true).trigger('change');
            }
            $('#po').val('{!! isset($data) ? $data->po : "" !!}');
            $('#noPo').val('{!! isset($data) ? $data->noPo : "" !!}');
            $('#datePo').val(('{!! isset($data) ? $data->datePo : "" !!}').split("-").reverse().join("-"));
            $('#dateStPo').val(('{!! isset($data) ? $data->dateStPo : "" !!}').split("-").reverse().join("-"));
            $('#dateEdPo').val(('{!! isset($data) ? $data->dateEdPo : "" !!}').split("-").reverse().join("-"));
            $('#poValue').val(formatNumberr('{!! isset($data) ? $data->poValue : "" !!}'));
            $('#projectValue').val(formatNumberr('{!! isset($data) ? $data->projectValue : "" !!}'));
            $('#projectValuePPN').val(formatNumberr(calculatePriceWithoutVAT('{!! isset($data) ? $data->projectValue : "" !!}')));
            $('#projectType').val('{!! isset($data) ? $data->projectType : "" !!}').trigger('change');
            $('#partnerId').val('{!! isset($data) ? $data->partnerId : "" !!}').trigger('change');
            $('#sales').val('{!! isset($data) ? $data->sales : "" !!}').trigger('change');
            $('#pmName').val('{!! isset($data) ? $data->pmName : "" !!}').trigger('change');
            $('#coPm').val('{!! isset($data) ? $data->coPm : "" !!}').trigger('change');
            //multi-select
            var rawData = '{!! isset($data) ? $data->sponsors : "" !!}';
            var dataArray = JSON.parse(rawData);
            var sponsorIds = dataArray.map(item => item.sponsorId);
            $('#sponsor').val(sponsorIds).trigger('change');
            //end
            $('#contractStart').val(('{!! isset($data) ? $data->contractStart : "" !!}').split("-").reverse().join("-"));
            $('#contractEnd').val(('{!! isset($data) ? $data->contractEnd : "" !!}').split("-").reverse().join("-"));
        }
    })
</script>
@endsection