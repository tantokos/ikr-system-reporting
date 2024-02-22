@extends('layout.main')

@section('content')
    <!-- Page Heading -->
    {{-- <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1> --}}
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>
--}}
    <!-- DataTales Example -->

    <div class="card">
        {{-- <div class="card-header"> --}}
        {{-- <h6 3class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}

        {{-- </div> --}}



        <div class="card">
            <div class="col-md-12">
                <h3 class="mt-5">{{ $title }}</h3>
                <hr>
            </div>

            <div class="col-md-6">

                <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="import_by" class="form-control" value="userDemo" hidden>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Batch WO</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="batch_wo" required="required">
                                <option value="">Pilih Batch WO</option>
                                <option value="Batch 1">Batch 1</option>
                                <option value="Batch 2">Batch 2</option>
                                <option value="Batch 3">Batch 3</option>
                                <option value="Batch 4">Batch 4</option>
                                <option value="Batch 5">Batch 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis WO</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="jenis_wo" required="required">
                                <option value="">Pilih Jenis WO</option>
                                <option value="FTTH New Installation">FTTH New Installation</option>
                                <option value="FTTH Maintenance">FTTH Maintenance</option>
                                <option value="Dismantle">Dismantle</option>
                                <option value="FTTX New Installation">FTTX New Installation</option>
                                <option value="FTTX Maintenance">FTTX Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal IKR</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="tgl_ikr" required="required">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Import Work Order</label>
                        <div class="col-sm-7">
                            <input type="file" name="file" class="form-control" required="required">
                            @error('file')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- </div> --}}

                        {{-- <div class="form-group row"> --}}
                        <div class="col-sm-2">

                            <button type="submit" class="btn btn-success">Import Data Order</button>
                        </div>
                    </div>

                </form>
            </div>






        </div>
        {{-- <hr> --}}
        {{-- <div class="card-block"> --}}

        <div class="col">


            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataImportOrder">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Batch WO</th>
                            <th>WO Type</th>
                            <th>No WO</th>
                            <th>No Ticket</th>
                            <th>WO Date</th>
                            <th>Cust ID</th>
                            <th>Cust Name</th>
                            <th>Cust Phone</th>
                            <th>Cust Mobile</th>
                            <th style="width: 10%">Address</th>
                            <th>Area</th>
                            <th>WO Type</th>
                            <th>FAT Code</th>
                            <th>FAT Port</th>
                            <th>Remarks</th>
                            <th>Vendor Installation</th>
                            <th>IKR Date</th>
                            <th>Time</th>
                            {{-- <th>Action</th> --}}
                        </tr>

                        {{-- @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->batch_wo }}</td>
                                <td>{{ $user->wo_no }}</td>
                                <td>{{ $user->ticket_no }}</td>
                                <td>{{ date('d/m/Y H:m:s', strtotime($user->wo_date)) }}</td>
                                <td>{{ $user->cust_id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->cust_phone }}</td>
                                <td>{{ $user->cust_mobile }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->area }}</td>
                                <td>{{ $user->wo_type }}</td>
                                <td>{{ $user->fat_code }}</td>
                                <td>{{ $user->fat_port }}</td>
                                <td>{{ $user->remarks }}</td>
                                <td>{{ $user->vendor_installer }}</td>
                                <td>{{ $user->ikr_date }}</td>
                                <td>{{ $user->time }}</td>
                            </tr>
                        @endforeach --}}
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        {{-- </div> --}}
    </div>
@endsection

@section('script')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js" ></script> --}}
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap5.min.js"></script> --}}

    {{-- <script src="https://bsnl.co.in/opencms/bsnl/BSNL/assets/global/plugins/datatables/media/js/jquery.js"></script> --}}
    {{-- <script src="https://bsnl.co.in/opencms/bsnl/BSNL/assets/global/plugins/datatables/media/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script> --}}

    <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            // fetch_data()

            // function fetch_data() {

            // var table = $('#dataImportOrder').DataTable({

            $('#dataImportOrder').DataTable({

                fixedColumns: true,

                fixedColumns: {
                    leftColumns: 4,
                    // rightColumns: 2
                },
                autoWidth: false,
                // scrollCollapse: true,
                scrollX: true,
                scrollY: true,
                scrollCollapse: true,
                // pageLength: 10,
                // lengthChange: true,
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
                    url: "{{ route('import.index') }}",
                    type: "GET"

                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_Row_Index',
                        "className": "text-center",
                        // orderable: false, 
                        searchable: false,


                    },
                    {
                        data: 'batch_wo',
                        name: 'cbatch_wo',



                    },
                    {
                        data: 'jenis_wo'

                    },
                    {
                        data: 'wo_no'

                    },
                    {
                        data: 'ticket_no',


                    },
                    {
                        data: 'wo_date'

                    },
                    {
                        data: 'cust_id'

                    },
                    {
                        data: 'name'

                    },
                    {
                        data: 'cust_phone'

                    },
                    {
                        data: 'cust_mobile'

                    },
                    {
                        data: 'address',



                    },
                    {
                        data: 'area'

                    },
                    {
                        data: 'wo_type'

                    },

                    {
                        data: 'fat_code'

                    },
                    {
                        data: 'fat_port'

                    },
                    {
                        data: 'remarks'

                    },
                    {
                        data: 'vendor_installer'

                    },
                    {
                        data: 'ikr_date'

                    },
                    {
                        data: 'time'

                    },


                    // {
                    //     data: 'gender',
                    //     "className": "text-center"      
                    // },                                   
                    // {
                    //     data: 'action',
                    //     "className": "text-center",
                    //     orderable: false,
                    //     searchable: false

                    // }

                ]



                // });

                // }


            });
        });

        
    </script>
@endsection
