@extends('/project/navbarInput')

@section('inputan')

<link href="/assets/css/select2Custom.css" rel="stylesheet">
<!-- row -->
<div class="row">
    <!-- col -->
    <div class="col-12">
        <!-- card -->
        <div class="card">
            <!-- card header -->
            <div class="card-header d-md-flex border-bottom-0">
                @canany(['bisa-tambah'])
                <div class="flex-grow-1">
                    <a href="/project/changeProjMember/{{$id}}" class="btn btn-primary">+ Add Or Edit {{$judul}}</a>
                </div>
                @endcanany
            </div>
            <!-- table -->
            <div class="card-body mb-10">
                <div class="table-responsive">
                    <table id="MemberProject" class="table mb-0 text-nowrap table-hover table-centered">
                        <thead class="table-light">
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive overflow-y-hidden table-card">
                    <table id="PartnerProject" class="table mb-0 text-nowrap table-hover table-centered">
                        <thead class="table-light">
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        $.ajax({
            url: '/project/json_projectMember/{{$id}}', // Ganti dengan URL skrip PHP Anda
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Handle DataTable pertama
                var MemberProject = response.dataTable1.original.data;

                // Misalnya, tampilkan DataTables menggunakan library DataTables
                $('#MemberProject').DataTable({
                    data: MemberProject,
                    processing: true,
                    "autoWidth": false,
                    "responsive": true,
                    "columnDefs": [{
                        targets: [4, 5],
                        render: function(data, type, row, meta) {
                            if (type === 'display' || type === 'filter') {
                                // Use moment.js to format the date for display and filtering
                                return moment(data).format('DD-MM-YYYY');
                            }
                            // For sorting and other operations, use the original data
                            return data;
                        },
                    }, ],
                    columns: [{
                            data: 'employees.name',
                            title: 'Member Name'
                        },
                        {
                            data: function(row, type) {
                                if (row.roles != "#") {
                                    var value = type === 'display' && row.roles.roleEmployee.length > 23 ? row.roles.roleEmployee.substring(0, 23) + '..' : row.roles.roleEmployee;
                                    return '<div data-toggle="tooltip" title="' + row.roles.roleEmployee + '">' + value + '</div>'
                                } else {
                                    return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                                }
                            },
                            title: 'Role'
                        },
                        {
                            data: function(row) {
                                return row.accesType != "#" ? row.accesType : "";
                            },
                            title: 'Acces Type'
                        },
                        {
                            data: function(row, type) {
                                if (row.employees.departments != "#") {
                                    var value = type === 'display' && row.employees.departments.department.length > 23 ? row.employees.departments.department.substring(0, 23) + '..' : row.employees.departments.department;
                                    return '<div data-toggle="tooltip" title="' + row.employees.departments.department + '">' + value + '</div>'
                                } else {
                                    return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                                }
                            },
                            title: 'Dept/Div'
                        },
                        {
                            data: 'startDate',
                            title: 'Start Date'
                        },
                        {
                            data: 'endDate',
                            title: 'End Date'
                        },
                    ]
                });

                // Handle DataTable pertama
                var PartnerProject = response.dataTable2.original.data;

                // Misalnya, tampilkan DataTables menggunakan library DataTables
                $('#PartnerProject').DataTable({
                    data: PartnerProject,
                    processing: true,
                    "autoWidth": false,
                    "responsive": true,
                    "columnDefs": [{
                        targets: [3, 4],
                        render: function(oTable) {
                            return moment(oTable).format('DD-MM-YYYY');
                        },
                    }, ],
                    columns: [{
                            data: 'partner',
                            title: 'Partner Name'
                        },
                        {
                            data: function(row) {
                                return row.roles ? row.roles.roleEmployee : "";
                            },
                            title: 'Role'
                        },
                        {
                            data: function(row) {
                                return row.accesPartner != "#" ? row.accesPartner : "";
                            },
                            title: 'Acces Type'
                        },
                        {
                            data: 'stdatePartner',
                            title: 'Start Date'
                        },
                        {
                            data: 'eddatePartner',
                            title: 'End Date'
                        },
                    ]
                });
            },
            error: function(error) {
                // Tangani kesalahan
                console.error('Error:', error);
            }
        });
    })
    $(function() {

        $(document).on('click', '#adddata', function() {
            $("#in").removeClass("btn btn-primary update");
            $("#in").addClass("btn btn-primary add");
        });
        //add data
        $('.col-12').on('click', '.add', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '/store_documentation/{{$id}}',
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
                        $('#offcanvasRight').offcanvas('hide');
                        document.getElementById("form-add").reset();
                        $('#example1').DataTable().ajax.reload();
                    }

                },
            });
        });
        $(document).on('click', '#edit', function(e) {
            e.preventDefault();
            var uid = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: '/edit_documentation/{{$id}}',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': uid,
                },
                success: function(data) {
                    //console.log(data);

                    //isi form
                    $('#id').val(data.id);
                    $('#nameFile').val(data.nameFile);
                    $('#link').val(data.link);

                    id = $('#id').val();

                    $('.modal-title').text('Edit Data');
                    $("#in").removeClass("btn btn-primary add");
                    $("#in").addClass("btn btn-primary update");
                    $('#offcanvasRight').offcanvas('show');

                },
            });

        });
        //end edit
        //update
        $('.col-12').on('click', '.update', function() {
            var form = document.getElementById("form-add");
            var fd = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '/update_documentation/' + id,
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
                        $('#offcanvasRight').offcanvas('hide');
                        document.getElementById("form-add").reset();
                        $('#example1').DataTable().ajax.reload();
                    }
                }
            });
        });
        //end update
        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            if (confirm('Yakin akan menghapus data ini?')) {
                // alert("Thank you for subscribing!" + $(this).data('id') );

                $.ajax({
                    type: 'DELETE',
                    url: '/delete_documentation/' + $(this).data('id'),
                    data: {
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        alert("Data Berhasil Dihapus");
                        $('#example1').DataTable().ajax.reload();
                    }
                });

            } else {
                return false;
            }
        });
    });
</script>
@endsection