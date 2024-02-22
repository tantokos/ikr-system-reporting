
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
        <a href="/branchCreate" class="btn btn-primary">input baru</a>
    </div>

    <div class="card-block table-border-style">
        <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-striped cell-border" cellspacing="0" widht='100%' style="font-size: 12px">
                    <thead>
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>ID</th>
                            <th>Nama Branch</th>
                            <th>Kode Branch</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
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
    <script type="text/javascript">
    $(document).ready(function() { 
        fetch_data()
        function fetch_data(){                    
                $('#dataTable').DataTable({
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
                        url:"{{ route('branch.data') }}",
                        type: "GET"
                             
                    },
                    columns: [
                        { 
                            data: 'id',
                            name: 'id', 
                            "className": "text-center" ,
                            // orderable: false, 
                            searchable: false   
                        },
                        // {
                        //     data: 'id',                                    
                        // },
                        {
                            data: 'nama_branch'       
                        },
                        {
                            data: 'kode_branch'      
                        },
                        {
                            data: 'alamat'      
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