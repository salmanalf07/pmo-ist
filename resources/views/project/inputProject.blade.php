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
                                <input name="projectId" id="projectId" type="text" class="form-control" placeholder="Enter Here" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label">Project Name</label>
                                <input name="projectName" id="projectName" type="text" class="form-control" placeholder="Enter Here" required>
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
                                <label class="form-label">Number Contract</label>
                                <input name="noContract" id="noContract" type="text" class="form-control" placeholder="Enter Here" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <div class="input-group me-3 datepicker">
                                    <input id="dateProject" name="dateProject" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Project Value</label>
                                <input name="projectValue" id="projectValue" type="text" class="form-control number-input" placeholder="Enter Here" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label">Contract Start Date <span class="text-danger">*</span></label>
                                <div class="input-group me-3 datepicker">
                                    <input id="contractStart" name="contractStart" type="text" class="form-control rounded" data-input aria-describedby="date1" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label">Contrack End Date <span class="text-danger">*</span></label>
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
    });
</script>

<script>
    flatpickr("#dateProject,#contractStart,#contractEnd", {
        dateFormat: "d-m-Y",
        defaultDate: "today",
    });
</script>
@endsection