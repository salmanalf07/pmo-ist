@extends('/project/navbarInput')

@section('inputan')
<!-- row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-md-flex border-bottom-0">
                @canany(['bisa-tambah','mom-editor'])
                <div class="flex-grow-1">
                    <a class="btn btn-primary" href="/project/formMoms/{{$id}}">Add New</a>
                </div>
                @endcanany
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table id="example1" class="table text-nowrap table-centered mt-0" style="width: 100%">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    No
                                </th>
                                <th>Date</th>
                                <th>Agenda</th>
                                <th>Venue</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(function() {

        var oTable = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"bottom"pi>',
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": false,
            "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 1, 4], // table ke 1
                },
                {
                    targets: 1,
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    },
                },
            ],
            ajax: {
                url: '/json_moms/{{$id}}'
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'dateMom',
                    name: 'dateMom'
                },
                {
                    data: 'agendaRender',
                    name: 'agenda',
                },
                {
                    data: 'venue',
                    name: 'venue'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                }
            ],
        });
    });


    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        if (confirm('Yakin akan menghapus data ini?')) {
            // alert("Thank you for subscribing!" + $(this).data('id') );

            $.ajax({
                type: 'DELETE',
                url: '/delete_moms/' + $(this).data('id'),
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
</script>



@endsection