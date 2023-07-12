@extends('/project/navbarInput')

@section('inputan')
<style>
    .input-80 input {
        width: 80% !important;
    }

    .input-100 input {
        width: 100% !important;
        border: var(--dashui-border-width) solid var(--dashui-input-border);
        border-radius: 0.2rem;
        height: 2rem;
        padding-left: 1rem;
    }

    .input-100 td {
        padding: 0.5rem;
    }

    .percentage-input::after {
        content: '%';
    }
</style>
<link href="/assets/css/select2Custom.css" rel="stylesheet">
<div>
    <!-- row -->

    <div class="row">
        <div class="col-xxl-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Project Bonus</h4>
                    <span id="error-message"></span>
                </div>
                <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                    @csrf
                    <span id="peringatan"></span>
                    <input class="form-control" type="text" name="id" id="id" hidden>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-centered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 35%;">Status</th>
                                        <th class="text-center" style="width: 30%;">Submit Date</th>
                                        <th class="text-center" style="width: 35%;">PIC</th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrder">
                                    <tr class="input-100">
                                        <td hidden>
                                            <input type="text" name="idBonus" id="idBonus">
                                        </td>
                                        <td>
                                            <select name="status" id="status" class="select2" aria-label="Default select example">
                                                <option value="#" selected>-- select --</option>
                                                <option value="inProcess">In Process</option>
                                                <option value="circulate">Circulate</option>
                                                <option value="finance">Finance</option>
                                                <option value="done">Done/Paid</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input id="SubDate" name="SubDate" type="text" class="text-center datepicker" data-input aria-describedby="date1" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group me-3">
                                                <input type="text" name="pic" id="pic">
                                            </div>
                                        </td>
                                    </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer  justify-content-between">
                        <button type="button" class="btn btn-primary-soft add"> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script>
    flatpickr(".datepicker", {
        enableTime: false,
        dateFormat: "d-m-Y",
        defaultDate: "01-01-1900",
        allowInput: true, // Mengizinkan input manual
    });
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    $(function() {
        //add data
        $('.card-footer').on('click', '.add', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '/store_bonus/{{$id}}',
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
                        // console.log(data)
                        document.getElementById("form-add").reset();
                        window.location.href = "/project/bonus/" + data.projectId;
                    }

                },
            });
        });
    })
</script>
<script>
    $(document).ready(function() {
        if ('{{isset($aksi) && $aksi == "EditData"}}') {
            var data = <?php echo json_encode($data); ?>;
            $('#idBonus').val('{!! isset($data) ? $data->id : "" !!}');
            $('#status').val('{!! isset($data) ? $data->status : "" !!}').trigger('change');
            $('#SubDate').val('{!! isset($data) ? $data->SubDate : "" !!}'.split("-").reverse().join("-"));
            $('#pic').val('{!! isset($data) ? $data->pic : "" !!}');

            // console.log(data)
        }


    })
</script>
@endsection