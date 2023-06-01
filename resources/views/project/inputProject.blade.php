@extends('/project/navbarInput')

@section('inputan')
<!-- custom select2 -->
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div>
    <!-- row -->

    <div class="row">
        <div class="col-lg-12 col-12">
            <!-- card -->
            <div class="card mb-4">
                <!-- card body -->
                <div class="card-body">
                    <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            <span id="peringatan"></span>
                            <input class="form-control" type="text" name="id" id="id" hidden>
                            <!-- input -->
                            <div class="mb-3">
                                <label class="form-label">Project ID</label>
                                <input name="noProject" id="noProject" value="{{ (isset($noProject)) ? $noProject : $data->noProject }}" type="text" class="form-control" readonly>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label" for="selectOne">Customer</label>
                                <select name="cust_id" id="cust_id" class="select2" aria-label="Default select example">
                                    <option value="#" selected>Open this select menu</option>
                                    @foreach($customer as $customer)
                                    <option value="{{$customer->id}}">{{$customer->company}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label" for="selectOne">Customer Type</label>
                                <select name="customerType" id="customerType" class="select2" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="BankingNFinancialServicesIndustry">Banking & Financial Services Industry</option>
                                    <option value="BUMN">BUMN</option>
                                    <option value="government">Government</option>
                                    <option value="manufacture">Manufacture</option>
                                </select>
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label">Project Name</label>
                                <input name="projectName" id="projectName" type="text" class="form-control" placeholder="Enter Here" required>
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label">Number Contract</label>
                                <input name="noContract" id="noContract" type="text" class="form-control" placeholder="Enter Here" required>
                            </div>
                            <div class="mb-3 col-3">
                                <label class="form-label">Contract Date</label>
                                <div class="input-group me-3 datepicker">
                                    <input id="contractDate" name="contractDate" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-1 text-center">
                                <label class="form-label" for="flexCheckChecked">
                                    Main Contract
                                </label>
                                <input class="form-check-input" type="checkbox" id="payung">
                            </div>
                            <div id="poHid" class="mb-3 col-4" hidden>
                                <label class="form-label">PO/SPP/SO</label>
                                <input name="po" id="po" type="text" value="{{ (isset($data->po)) ? $data->po : '' }}" class="form-control" placeholder="Enter Here">
                            </div>
                            <div id="noPoHid" class="mb-3 col-4" hidden>
                                <label class="form-label">Number Of PO/SPP/SO</label>
                                <input name="noPo" id="noPo" type="text" class="form-control" placeholder="Enter Here">
                            </div>
                            <div id="datePoHid" class="mb-3 col-4" hidden>
                                <label class="form-label">PO/SPP/SO Date</label>
                                <div class="input-group me-3 datepicker">
                                    <input id="datePo" name="datePo" type="text" class="form-control rounded" data-input aria-describedby="date1">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label">Project Value</label>
                                <input name="projectValue" id="projectValue" type="text" class="form-control number-input" placeholder="Enter Here" required>
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label" for="selectOne">Project Type</label>
                                <select name="projectType" id="projectType" class="select2" aria-label="Default select example" required>
                                    <option value="#" selected>Open this select menu</option>
                                    <option value="internal">Internal</option>
                                    <option value="external">External</option>
                                    <option value="joinDevelopment">Join Development</option>
                                </select>
                            </div>
                            <div class="mb-3 col-4" id="joinDev1"></div>
                            <div class="mb-3 col-4" id="joinDev2" hidden>
                                <label class="form-label" for="selectOne">Partner</label>
                                <select name="partnerId" id="partnerId" class="select2" aria-label="Default select example" required>
                                    <option value="#" selected>Open this select menu</option>
                                    @foreach($partner as $partner)
                                    <option value="{{$partner->id}}">{{$partner->company}}</option>
                                    @endforeach
                                </select>
                            </div>
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
                            <div class="mb-3 col-6">
                                <label class="form-label">Contract Start Date</label>
                                <div class="input-group me-3 datepicker">
                                    <input id="contractStart" name="contractStart" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label">Contrack End Date</label>
                                <div class="input-group me-3 datepicker">
                                    <input id="contractEnd" name="contractEnd" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-3">
                                <button type="button" class="btn btn-primary add"> Save & Next</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
                        window.location.href = "/project/detailOrder/" + data[0].id;
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
            } else {
                $('#poHid').attr('hidden', 'hidden');
                $('#noPoHid').attr('hidden', 'hidden');
                $('#datePoHid').attr('hidden', 'hidden');
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

    });
    //datepicker
    flatpickr("#contractDate,#contractStart,#contractEnd,#datePo", {
        dateFormat: "d-m-Y",
        defaultDate: "today",
    });

    function formatNumberr(number) {
        var reversed = number.toString().split("").reverse().join("");
        var formatted = reversed.match(/\d{1,3}/g).join(".");
        return formatted.split("").reverse().join("");
    }
</script>
<script>
    $(document).ready(function() {
        if ('{{isset($aksi) && $aksi == "EditData"}}') {
            $('#id').val('{{ isset($data) ? $data->id : "" }}');
            $('#noProject').val('{{ isset($data) ? $data->noProject : "" }}');
            $('#cust_id').val('{{ isset($data) ? $data->cust_id : "" }}').trigger('change');
            $('#customerType').val('{{ isset($data) ? $data->customerType : "" }}').trigger('change');
            $('#projectName').val('{{ isset($data) ? $data->projectName : "" }}');
            $('#po').val('{{ isset($data) ? $data->po : "" }}');
            $('#noContract').val('{{ isset($data) ? $data->noContract : "" }}');
            $('#contractDate').val(('{{ isset($data) ? $data->contractDate : "" }}').split("-").reverse().join("-"));
            if ('{{ isset($data) && $data->po !== null }}') {
                $("#payung").prop("checked", true).trigger('change');
            }
            $('#po').val('{{ isset($data) ? $data->po : "" }}');
            $('#noPo').val('{{ isset($data) ? $data->noPo : "" }}');
            $('#datePo').val(('{{ isset($data) ? $data->datePo : "" }}').split("-").reverse().join("-"));
            $('#projectValue').val(formatNumberr('{{ isset($data) ? $data->projectValue : "" }}'));
            $('#projectType').val('{{ isset($data) ? $data->projectType : "" }}').trigger('change');
            $('#partnerId').val('{{ isset($data) ? $data->partnerId : "" }}').trigger('change');
            $('#sales').val('{{ isset($data) ? $data->sales : "" }}').trigger('change');
            $('#pmName').val('{{ isset($data) ? $data->pmName : "" }}').trigger('change');
            $('#coPm').val('{{ isset($data) ? $data->coPm : "" }}').trigger('change');
            //multi-select
            var rawData = '{{ isset($data) ? $data->sponsor : "" }}';
            var dataArray = rawData.split(",");
            $('#sponsor').val(dataArray).trigger('change');
            //end
            $('#contractStart').val(('{{ isset($data) ? $data->contractStart : "" }}').split("-").reverse().join("-"));
            $('#contractEnd').val(('{{ isset($data) ? $data->contractEnd : "" }}').split("-").reverse().join("-"));
        }
    })
</script>
@endsection