@extends('/project/navbarInput')

@section('inputan')
<link href="/assets/css/select2Custom.css" rel="stylesheet">
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
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- row -->
<div class="row">
    <span id="peringatan"></span>
    <div class="col-12 mb-4">
        <div class="card mb-4">
            <!-- card body -->
            <div class="card-body">
                <!-- input -->
                <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <h4 class="mb-4">Project Meeting Information</h4>
                        <input type="hidden" name="momId" id="momId" value="#">
                        <div class="mb-3 col-12">
                            <label class="form-label">Customer Name</label>
                            <input type="text" class="form-control" placeholder="Enter Customer Name" value="{{$project->customer->company}}" disabled>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Project Name</label>
                            <input type="text" class="form-control" placeholder="Enter Project Name" value="{{$project->projectName}}" disabled>
                        </div>
                        <div class=" mb-3 col-6">
                            <label class="form-label">Date</label>
                            <div class="input-group me-3">
                                <input id="date" name="date" type="text" class="form-control rounded datepicker" data-input aria-describedby="date1" required>
                                <div class="input-group-append custom-picker">
                                    <button class="btn btn-light" type="button" id="date1" title="toggle" data-toggle><i data-feather="calendar" class="icon-xs"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Time</label>
                            <div class="input-group me-3 datepicker">
                                <input id="time" name="time" type="text" class="form-control rounded" data-input aria-describedby="date2" required>
                            </div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Venue</label>
                            <input type="text" class="form-control" id="venue" name="venue" placeholder="Enter Venue">
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Agenda</label>
                            <div class="pb-5" id="agenda" name="agenda"></div>
                            <textarea name="agendaContent" id="agendaContent" style="display:none;"></textarea>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Lead By</label>
                            <input type="text" id="chaired" name="chaired" class="form-control" placeholder="Enter Chaired by">
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">PM {{$project->customer->company}}</label>
                            <input type="text" id="pmCust" name="pmCust" class="form-control" placeholder="Enter PM {{$project->customer->company}}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Attendees</label>
                        </div>
                        <div class="mb-3 col-6">
                            <div class="table-responsive">
                                <table class="table table-centered text-nowrap mb-0" style="border: 1px solid var(--dashui-table-border-color)">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 95%;" colspan="2">{{$project->customer->company}}</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailCustomer">
                                        <tr class="input-100">
                                            <td hidden>
                                                <input type="text" name="idCustomer[]" id="idCustomer0">
                                            </td>
                                            <td><input type="text" name="customer[]" id="customer0" placeholder="Name"></td>
                                            <td><input type="email" name="mailCustomer[]" id="mailCustomer0" placeholder="Email"></td>
                                            <td>
                                                <a href="#!" onclick="deleteRow(this)" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashCust">
                                                    <i data-feather="trash-2" class="icon-xs"></i>
                                                    <div id="trashCust" class="d-none">
                                                        <span>Delete</span>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <button type="button" onclick="addCustomer()" class="btn btn-warning-soft">Add Customer</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <div class="table-responsive">
                                <table class="table table-centered text-nowrap mb-0" style="border: 1px solid var(--dashui-table-border-color)">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 95%;" colspan="2">IST</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailMii">
                                        <tr class="input-100">
                                            <td hidden>
                                                <input type="text" name="idMii[]" id="idMii0">
                                            </td>
                                            <td><input type="text" name="mii[]" id="mii0" placeholder="Name"></td>
                                            <td><input type="email" name="mailMii[]" id="mailMii0" placeholder="Email"></td>
                                            <td>
                                                <a href="#!" onclick="deleteRow(this)" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashMii">
                                                    <i data-feather="trash-2" class="icon-xs"></i>
                                                    <div id="trashMii" class="d-none">
                                                        <span>Delete</span>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <button type="button" onclick="addMii()" class="btn btn-warning-soft">Add IST</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="mb-3 col-12 text-end">
                            <button id="meetingInformation" type="button" class="btn btn-primary-soft">Save Project Meeting Information</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="card mb-4">
            <!-- card body -->
            <div class="card-body">
                <div>
                    <!-- input -->
                    <div class="mb-3">
                        <h4><label class="form-label">Minutes Of Meeting</label></h4>
                        <input type="hidden" id="idDiscussion" value="#">
                        <textarea name="discussionContent" id="discussionContent"></textarea>
                    </div>
                    <div class="mb-3 text-end">
                        <button type="button" id="saveQuill" data-form="discussion" class="btn btn-primary-soft">Save Minutes Of Meeting</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <!-- card body -->
            <div class="card-body">
                <div class="row">
                    <h4><label class="form-label">Meeting Follow-Up</label></h4>
                    <div class="mb-3 col-12">
                        <div class="table-responsive">
                            <form method="post" role="form" id="form-fu" enctype="multipart/form-data">
                                @csrf
                                <table class="table table-centered text-nowrap mb-0" style="border: 1px solid var(--dashui-table-border-color)">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 30%;">Action</th>
                                            <th style="width: 20%;">PIC</th>
                                            <th style="width: 20%;">Target Date</th>
                                            <th style="width: 25%;">Notes</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailFu">
                                        <tr class="input-100">
                                            <td hidden>
                                                <input type="text" name="idFu[]" id="idFu0">
                                            </td>
                                            <td><input type="text" name="actionFu[]" id="actionFu0"></td>
                                            <td><input type="text" name="picFu[]" id="picFu0"></td>
                                            <td>
                                                <input id="targetFu0" name="targetFu[]" type="text" class="text-center datepicker" data-input aria-describedby="date1">
                                            </td>
                                            <td><input type="text" name="notesFu[]" id="notesFu0"></td>
                                            <td>
                                                <a href="#!" onclick="deleteFu(this)" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip" data-template="trashCust">
                                                    <i data-feather="trash-2" class="icon-xs"></i>
                                                    <div id="trashCust" class="d-none">
                                                        <span>Delete</span>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-end" colspan="5">
                                                <button type="button" onclick="addFu()" class="btn btn-warning-soft">Add Follow-Up</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="mb-3 text-end">
                        <button id="meetingFu" type="button" class="btn btn-primary-soft">Save Meeting Follow-Up</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script>
    $(document).ready(function() {
        //datepicker
        flatpickr("#date", {
            dateFormat: "d-m-Y",
            defaultDate: "today",
            allowInput: true, // Mengizinkan input manual
        });
        flatpickr("#targetFu0", {
            dateFormat: "d-m-Y",
            defaultDate: "today",
            allowInput: true, // Mengizinkan input manual
        });
        flatpickr("#time", {
            allowInput: true, // Mengizinkan input manual
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            defaultDate: new Date(), // Set your default time here (in 24-hour format)
            time_24hr: true
        });
    })
    $(document).ready(function() {
        var editor = Jodit.make('#discussionContent', {
            "buttons": "bold,italic,underline,strikethrough,eraser,ul,ol,font,fontsize,lineHeight,image,cut,copy,paste,selectall,table,symbols,indent,outdent",
            uploader: {
                insertImageAsBase64URI: true // Menyisipkan gambar sebagai base64 URI
            },
            table: {
                // Konfigurasi tabel
            }
        });


        var agendaDec = new Quill("#agenda", {
            modules: {
                toolbar: [
                    // [{ header: [1, 2, !1] }],
                    // [{ font: [] }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        size: ["small", !1, "large", "huge"]
                    }],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }],
                    [{
                        color: []
                    }, {
                        background: []
                    }, {
                        align: []
                    }],
                    // ["link", "image", "code-block", "video"],
                ],
            },
            theme: "snow",
        });

        agendaDec.on('text-change', function() {
            var html = agendaDec.root.innerHTML;
            document.getElementById('agendaContent').value = html;
        });


        if ('{{isset($aksi) && $aksi == "EditData"}}') {
            $('#momId').val('{!! isset($data) ? $data->id : "#" !!}');
            $('#date').val(('{!! isset($data) ? $data->dateMom : "" !!}').split("-").reverse().join("-"));
            $('#time').val('{!! isset($data) ? substr($data->timeMom, 0, 5) : "" !!}');
            $('#venue').val('{!! isset($data) ? $data->venue : "" !!}');
            agendaDec.clipboard.dangerouslyPasteHTML('{!! isset($data) ? $data->agenda : "" !!}');
            $('#chaired').val('{!! isset($data) ? $data->chairedBy : "" !!}');
            $('#pmCust').val('{!! isset($data) ? $data->pmCust : "" !!}');
            var dataCust = <?php echo json_encode($partCust); ?>;
            if (dataCust.length > 0) {
                for (let i = 0; i < (dataCust.length - 1); i++) {
                    addCustomer();
                }
                for (let i = 0; i < dataCust.length; i++) {
                    $('#idCustomer' + i).val(dataCust[i].id);
                    $('#customer' + i).val(dataCust[i].name);
                    $('#mailCustomer' + i).val(dataCust[i].email);
                }
            }
            var dataMii = <?php echo json_encode($partMii); ?>;
            if (dataMii.length > 0) {
                for (let i = 0; i < (dataMii.length - 1); i++) {
                    addMii();
                }
                for (let i = 0; i < dataMii.length; i++) {
                    $('#idMii' + i).val(dataMii[i].id);
                    $('#mii' + i).val(dataMii[i].name);
                    $('#mailMii' + i).val(dataMii[i].email);
                }
            }
            $('#idDiscussion').val('{!! isset($discussion) ? $discussion->id : "#" !!}');
            var editor = new Jodit('#discussionContent');
            editor.value = `{!! isset($discussion) ? $discussion->discussion : "" !!}`;
            var meetingFu = <?php echo json_encode($meetingFu); ?>;
            if (meetingFu.length > 0) {
                for (let i = 0; i < (meetingFu.length - 1); i++) {
                    addFu();
                }
                for (let i = 0; i < meetingFu.length; i++) {
                    $('#idFu' + i).val(meetingFu[i].id);
                    $('#actionFu' + i).val(meetingFu[i].action);
                    $('#picFu' + i).val(meetingFu[i].pic);
                    $('#targetFu' + i).val((meetingFu[i].targetDate).split("-").reverse().join("-"));
                    $('#notesFu' + i).val(meetingFu[i].notes);

                }
            }
        }
    })
</script>
<script>
    function addCustomer() {
        var table = document.getElementById("detailCustomer");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 3; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 0) {
                newCell5.style.display = "none";
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            if (j > 0 && j <= 2) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);

                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = ""; // Reset input value
                }
            }
        }
    }

    function addMii() {
        var table = document.getElementById("detailMii");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 3; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 0) {
                newCell5.style.display = "none";
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            if (j > 0 && j <= 2) {
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);

                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = ""; // Reset input value
                }
            }
        }
    }

    function addFu() {
        var table = document.getElementById("detailFu");
        var tableRange = table.rows.length
        var lastRow = table.rows[table.rows.length - 1];

        var row = table.insertRow(table.rows.length);
        row.classList.add("input-100");

        for (let j = 0; j <= 5; j++) {
            var cell5 = lastRow.cells[j]; // Mengambil sel keempat (cell 4)
            var newCell5 = row.insertCell(j);
            // Mengklon semua elemen yang ada di dalam sel keempat (cell 4) pada row sebelumnya
            var selectElement = cell5.querySelector('input');
            var clonedContent = cell5.cloneNode(true);
            var childNodes = clonedContent.childNodes;
            if (j == 0) {
                newCell5.style.display = "none";
                clonedContent.querySelector('input').id = (selectElement.id).replace(/\d+/g, '') + tableRange;
            }
            if (j > 0 && j <= 4) {
                var inputs = clonedContent.querySelectorAll('input');
                inputs.forEach(function(input, index) {
                    // if (input.type == "checkbox") {
                    var newId = (input.id).replace(/\d+/g, '') + tableRange;
                    input.id = newId;
                    // console.log(input.id)
                    // }
                });
            }
            // Menambahkan semua child node yang telah dikloning ke dalam sel keempat (cell 4) pada row baru
            for (var k = 0; k < childNodes.length; k++) {
                var clonedNode = childNodes[k].cloneNode(true);
                newCell5.appendChild(clonedNode);

                if (clonedNode.tagName === "INPUT") {
                    clonedNode.value = ""; // Reset input value
                }
            }
            if (clonedContent.querySelector('input.datepicker')) {
                flatpickr("#" + clonedContent.querySelector('input.datepicker').id, {
                    dateFormat: "d-m-Y",
                    defaultDate: "01-01-1900",
                    allowInput: true, // Mengizinkan input manual
                });
            }
        }
    }


    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        var row = button.closest("tr");
        var inputElement1 = row.querySelector("input[name='idCustomer[]']");
        var inputElement = row.querySelector("input[name='idMii[]']");
        // console.log(inputElement1)
        if (inputElement1 && inputElement1.value) {
            var id = inputElement1.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_participant/' + id,
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'typeParticipant': 'customer'
                    },
                    success: function(data) {
                        alert("Data Berhasil Dihapus");
                    }
                });

            } else {
                return false;
            }
        } else {
            row.parentNode.removeChild(row);
        }
        if (inputElement && inputElement.value) {
            var id = inputElement.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_participant/' + id,
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'typeParticipant': 'MII'
                    },
                    success: function(data) {
                        alert("Data Berhasil Dihapus");
                    }
                });

            } else {
                return false;
            }
        } else {
            row.parentNode.removeChild(row);
        }

    }
    //delete Fu
    function deleteFu(button) {
        var row = button.closest("tr");
        var inputElement = row.querySelector("input[name='idFu[]']");
        if (inputElement && inputElement.value) {
            var id = inputElement.value;
            if (confirm('Yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/delete_participant/' + id,
                    data: {
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        alert("Data Berhasil Dihapus");
                    }
                });

            } else {
                return false;
            }
        }
        row.parentNode.removeChild(row);
    }
</script>
<script>
    $(function() {
        $(document).on('click', '#saveQuill', function(e) {
            e.preventDefault();
            if ($('#momId').val() != "#") {
                var key = $(this).data('form');
                // alert(uid)
                if (key === 'discussion') {
                    var uid = $('#idDiscussion').val();
                    var content = $('#discussionContent').val();
                }

                $.ajax({
                    type: 'POST',
                    url: '/store_quill',
                    data: {
                        key: key,
                        uid: uid,
                        konten: content,
                        momId: $('#momId').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.message);
                        if (data.key === 'discussion') {
                            $('#idDiscussion').val(data.post);
                        }
                    },
                    error: function(data) {
                        alert(data.message);
                    }
                });
            } else {
                alert('Harap mengisi Project Meeting Information & save')
            }
        })

        $('.text-end').on('click', '#meetingInformation', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);

            $.ajax({
                type: 'POST',
                url: '/meeting_information/{{$id}}',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#momId').val(data.idMom);
                    alert('Data berhasil disimpan')

                    // window.location.href = "/project/moms/" + data.id;

                },
                error: function(data) {
                    alert('Data gagal disimpan')
                    // window.location.href = "/project/moms/" + data.id;

                },
            });
        })

        $('.text-end').on('click', '#meetingFu', function() {
            if ($('#momId').val() != "#") {
                var form = document.getElementById("form-fu");
                var fd = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: '/meeting_fu/' + $('#momId').val(),
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        alert('Data berhasil disimpan')
                        // window.location.href = "/project/moms/" + data.id;

                    },
                    error: function(data) {
                        alert('Data gagal disimpan')
                        // window.location.href = "/project/moms/" + data.id;

                    },
                });
            } else {
                alert('Harap mengisi Project Meeting Information & save')
            }
        })
    })
</script>



@endsection