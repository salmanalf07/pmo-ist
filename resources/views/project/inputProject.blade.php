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
                    <form action="">
                        <div class="row">
                            <!-- input -->
                            <div class="mb-3">
                                <label class="form-label">Project ID</label>
                                <input name="projectId" id="projectId" type="text" class="form-control" readonly>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label" for="selectOne">Customer</label>
                                <select name="customer" id="customer" class="select2" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="banking">Bangking</option>
                                    <option value="goverment">goverment</option>
                                    <option value="bumn">BUMN</option>
                                </select>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label" for="selectOne">Customer Type</label>
                                <select name="customerType" id="customerType" class="select2" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="banking">Bangking</option>
                                    <option value="goverment">goverment</option>
                                    <option value="bumn">BUMN</option>
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
                                    Kontrak Payung
                                </label>
                                <input class="form-check-input" type="checkbox" id="payung">
                            </div>
                            <div id="poHid" class="mb-3 col-4" hidden>
                                <label class="form-label">PO/SPP/SO</label>
                                <input name="po" id="po" type="text" class="form-control" placeholder="Enter Here">
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
                                    <option selected>Open this select menu</option>
                                    <option value="internal">Internal</option>
                                    <option value="external">External</option>
                                    <option value="joinDevelopment">Join Development</option>
                                </select>
                            </div>
                            <div class="mb-3 col-4" id="joinDev1"></div>
                            <div class="mb-3 col-4" id="joinDev2" hidden>
                                <label class="form-label" for="selectOne">Company Join Dev</label>
                                <select name="comJoin" id="comJoin" class="select2" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                </select>
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label" for="selectOne">Sales</label>
                                <select name="sales" id="sales" class="select2" aria-label="Default select example" required>
                                    <option selected>Open this select menu</option>
                                    <option value="banking">Bangking</option>
                                    <option value="goverment">goverment</option>
                                    <option value="bumn">BUMN</option>
                                </select>
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label" for="selectOne">PM Name</label>
                                <select name="pmName" id="pmName" class="select2" aria-label="Default select example" required>
                                    <option selected>Open this select menu</option>
                                    <option value="banking">Bangking</option>
                                    <option value="goverment">goverment</option>
                                    <option value="bumn">BUMN</option>
                                </select>
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label" for="selectOne">Co PM</label>
                                <select name="coPm" id="coPm" class="select2" aria-label="Default select example" required>
                                    <option selected>Open this select menu</option>
                                    <option value="banking">Bangking</option>
                                    <option value="goverment">goverment</option>
                                    <option value="bumn">BUMN</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sponsor</label>
                                <input name="sponsor" id="sponsor" type="text" class="form-control number-input" placeholder="Enter Here" required>
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
                                <button type="submit" class="btn btn-primary"> Save & Next</button>
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
</script>
@endsection