@extends('layout.main')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>
--}}
    <!-- DataTales Example -->

    <div class="card">
        <div class="card-header">
            {{-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}
            <a href="/callsignLeadCreate" class="btn btn-primary">input baru</a>
        </div>

        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataCallsignLead" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lead Callsign</th>
                            <th>Leader</th>
                            <th>Branch</th>
                            <th>Action</th>
                        </tr>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap5.min.js"></script> --}}

    {{-- <script type="text/javascript">
        @if (count($errors) > 0)
            $('#callsignLeadCreate').modal('show');
        @endif
    </script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            fetch_data()

            function fetch_data() {
                $('#dataCallsignLead').DataTable({
                    pageLength: 10,
                    lengthChange: true,
                    bFilter: true,
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    oLanguage: {
                        sZeroRecords: "Tidak Ada Data",
                        sSearch: "Pencarian _INPUT_",
                        sLengthMenu: "_MENU_",
                        sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        sInfoEmpty: "0 data",
                        oPaginate: {
                            sNext: "<i class='fa fa-angle-right'></i>",
                            sPrevious: "<i class='fa fa-angle-left'></i>"
                        }
                    },
                    ajax: {
                        url: "{{ route('aset.data') }}",
                        type: "GET"

                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            "className": "text-center",
                            // orderable: false, 
                            searchable: false
                        },
                        {
                            data: 'nama_barang',
                            "className": "text-center",
                        },
                        {
                            data: 'kode_barang',
                        },
                        {
                            data: 'kategori',
                        },


                        // {
                        //     data: 'gender',
                        //     "className": "text-center"      
                        // },                                   
                        {
                            data: 'action',
                            "className": "text-center",
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            }

        });
    </script>
@endsection
