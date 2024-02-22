@extends('layout.main')

@section('content')
    <div class="row" id="mychart">

        {{-- <div class="row"> --}}

        <!-- order-card start -->
        <div class="col">
            <a href="#" data-toggle="modal" data-target="#md-totAset">
                <div class="card bg-c-blue">
                    <div class="card-block ">
                        <h6 class="m-b-20">Total Aset</h6>
                        <h2 class="text-right"><i class="ti-view-list-alt f-left"></i><span>{{ $totAset }}</span></h2>
                        {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" data-toggle="modal" data-target="#md-tersediaAset">
            <div class="card bg-info">
                <div class="card-block">
                    <h6 class="m-b-20">Aset Tersedia</h6>
                    <h2 class="text-right"><i class="ti-list f-left"></i><span>{{ $tersedia }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">213</span></p> --}}
                </div>
            </div>
            </a>
        </div>
        <div class="col">
            <a href="#" data-toggle="modal" data-target="#md-distribusiAset">
            <div class="card bg-c-green ">
                <div class="card-block">
                    <h6 class="m-b-20">Aset Terdistribusi</h6>
                    <h2 class="text-right"><i class="ti-write f-left"></i><span>{{ $distribusi }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">213</span></p> --}}
                </div>
            </div>
        </a>
        </div>

    </div>

    <div class="row">
        <div class="col">
            <a href="#" data-toggle="modal" data-target="#md-rusakAset">
            <div class="card bg-c-yellow ">
                <div class="card-block">
                    <h6 class="m-b-20">Aset Rusak</h6>
                    <h2 class="text-right"><i class="ti-layers f-left"></i><span>{{ $rusak }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">5,032</span></p> --}}
                </div>
            </div>
            </a>
        </div>

        <div class="col">
            <a href="#" data-toggle="modal" data-target="#md-hilangAset">
            <div class="card bg-c-pink ">
                <div class="card-block">
                    <h6 class="m-b-20">Aset Hilang</h6>
                    <h2 class="text-right"><i class="ti-archive f-left"></i><span>{{ $hilang }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">542</span></p> --}}
                </div>
            </div>
            </a>
        </div>
        <div class="col">
            <a href="#" data-toggle="modal" data-target="#md-disposalAset">
            <div class="card bg-info ">
                <div class="card-block">
                    <h6 class="m-b-20">Aset Disposal</h6>
                    <h2 class="text-right"><i class="ti-archive f-left"></i><span>{{ $disposal }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">542</span></p> --}}
                </div>
            </div>
            </a>
        </div>


        {{-- </div>   --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>



    </div>

    {{-- modal Total detail --}}

    <div class="modal fade" id="md-totAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Total Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-totAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                        {{-- <div class="row"> --}}
                        {{-- <div class="col"> --}}
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTotAsetDt" width="100%" cellspacing="0"
                                style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th width="100%">No</th>
                                        <th width="100%">Nama Barang</th>
                                        {{-- <th>Merk Barang</th> --}}
                                        {{-- <th>Kondisi</th> --}}
                                        <th width="100%">Satuan</th>
                                        <th width="100%">Jumlah</th>
                                        <th width="100%">Kategori</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>




                        {{-- </div> --}}
                        {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" class="btn  btn-primary">Save</button> --}}
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal total detail --}}

    {{-- modal tersedia detail --}}
    <div class="modal fade" id="md-tersediaAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Aset Tersedia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-tersediaAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                        {{-- <div class="row"> --}}
                        {{-- <div class="col"> --}}
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTersediaAsetDt" width="100%" cellspacing="0"
                                style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        {{-- <th>Merk Barang</th> --}}
                                        {{-- <th>Kondisi</th> --}}
                                        <th>Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>




                        {{-- </div> --}}
                        {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" class="btn  btn-primary">Save</button> --}}
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal tersedia detail --}}

    {{-- modal distribusi detail --}}
    <div class="modal fade" id="md-distribusiAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Aset Terdistribusi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-distribusiAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                        {{-- <div class="row"> --}}
                        {{-- <div class="col"> --}}
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataDistribusiAsetDt" width="100%" cellspacing="0"
                                style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        {{-- <th>Merk Barang</th> --}}
                                        {{-- <th>Kondisi</th> --}}
                                        <th>Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>




                        {{-- </div> --}}
                        {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" class="btn  btn-primary">Save</button> --}}
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal distribusi detail --}}

    {{-- modal rusak detail --}}

    <div class="modal fade" id="md-rusakAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Aset Rusak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-rusakAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                        {{-- <div class="row"> --}}
                        {{-- <div class="col"> --}}
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataRusakAsetDt" width="100%" cellspacing="0"
                                style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th width="100%">No</th>
                                        <th width="100%">Nama Barang</th>
                                        {{-- <th>Merk Barang</th> --}}
                                        {{-- <th>Kondisi</th> --}}
                                        <th width="100%">Satuan</th>
                                        <th width="100%">Jumlah</th>
                                        <th width="100%">Kategori</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>




                        {{-- </div> --}}
                        {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" class="btn  btn-primary">Save</button> --}}
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal rusak detail --}}

    {{-- modal hilang detail --}}

    <div class="modal fade" id="md-hilangAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Aset Hilang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-hilangAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                        {{-- <div class="row"> --}}
                        {{-- <div class="col"> --}}
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataHilangAsetDt" width="100%" cellspacing="0"
                                style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th width="100%">No</th>
                                        <th width="100%">Nama Barang</th>
                                        {{-- <th>Merk Barang</th> --}}
                                        {{-- <th>Kondisi</th> --}}
                                        <th width="100%">Satuan</th>
                                        <th width="100%">Jumlah</th>
                                        <th width="100%">Kategori</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>




                        {{-- </div> --}}
                        {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" class="btn  btn-primary">Save</button> --}}
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal hilang detail --}}

    {{-- modal disposal detail --}}

    <div class="modal fade" id="md-disposalAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Disposal Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-disposalAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                        {{-- <div class="row"> --}}
                        {{-- <div class="col"> --}}
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataDisposalAsetDt" width="100%" cellspacing="0"
                                style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th width="100%">No</th>
                                        <th width="100%">Nama Barang</th>
                                        {{-- <th>Merk Barang</th> --}}
                                        {{-- <th>Kondisi</th> --}}
                                        <th width="100%">Satuan</th>
                                        <th width="100%">Jumlah</th>
                                        <th width="100%">Kategori</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>




                        {{-- </div> --}}
                        {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" class="btn  btn-primary">Save</button> --}}
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal disposal detail --}}

@endsection

@section('script')
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            fetch_data()
            fetch_dataTersedia()
            fetch_dataDistribusi()
            fetch_dataRusak()
            fetch_dataHilang()
            fetch_dataDisposal()

            function fetch_data() {
                $('#dataTotAsetDt').DataTable({
                    // fixedColumns: true,

                    fixedColumns: {
                        // leftColumns: 4,
                        rightColumns: 1
                    },


                    scrollCollapse: true,
                    scrollX: true,
                    // scrollY: 300,
                    // pageLength: 10,
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
                        url: "{{ route('dataTotAsetDt') }}",
                        type: "GET"

                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_Row_Index',
                            "className": "text-center",
                            // orderable: false, 
                            searchable: false

                        },
                        {
                            data: 'nama_barang',
                            //"className": "text-center",

                        },

                        // {
                        //     data: 'kondisi'
                        // },
                        {
                            data: 'satuan'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'kategori'
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
                        // },
                    ]
                });
            }


            function fetch_dataTersedia() {
                $('#dataTersediaAsetDt').DataTable({
                    // fixedColumns: true,

                    fixedColumns: {
                        // leftColumns: 4,
                        rightColumns: 1
                    },


                    scrollCollapse: true,
                    scrollX: true,
                    // scrollY: 300,
                    // pageLength: 10,
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
                        url: "{{ route('dataTersediaAsetDt') }}",
                        type: "GET"

                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_Row_Index',
                            "className": "text-center",
                            // orderable: false, 
                            searchable: false

                        },
                        {
                            data: 'nama_barang',
                            //"className": "text-center",

                        },

                        // {
                        //     data: 'kondisi'
                        // },
                        {
                            data: 'satuan'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'kategori'
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
                        // },
                    ]
                });
            }

            function fetch_dataDistribusi() {
                $('#dataTerdistribusiAsetDt').DataTable({
                    // fixedColumns: true,

                    fixedColumns: {
                        // leftColumns: 4,
                        rightColumns: 1
                    },


                    scrollCollapse: true,
                    scrollX: true,
                    // scrollY: 300,
                    // pageLength: 10,
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
                        url: "{{ route('dataDistribusiAsetDt') }}",
                        type: "GET"

                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_Row_Index',
                            "className": "text-center",
                            // orderable: false, 
                            searchable: false

                        },
                        {
                            data: 'nama_barang',
                            //"className": "text-center",

                        },

                        // {
                        //     data: 'kondisi'
                        // },
                        {
                            data: 'satuan'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'kategori'
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
                        // },
                    ]
                });
            }

            function fetch_dataRusak() {
                $('#dataRusakAsetDt').DataTable({
                    // fixedColumns: true,

                    fixedColumns: {
                        // leftColumns: 4,
                        rightColumns: 1
                    },


                    scrollCollapse: true,
                    scrollX: true,
                    // scrollY: 300,
                    // pageLength: 10,
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
                        url: "{{ route('dataRusakAsetDt') }}",
                        type: "GET"

                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_Row_Index',
                            "className": "text-center",
                            // orderable: false, 
                            searchable: false

                        },
                        {
                            data: 'nama_barang',
                            //"className": "text-center",

                        },

                        // {
                        //     data: 'kondisi'
                        // },
                        {
                            data: 'satuan'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'kategori'
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
                        // },
                    ]
                });
            }

            function fetch_dataHilang() {
                $('#dataHilangAsetDt').DataTable({
                    // fixedColumns: true,

                    fixedColumns: {
                        // leftColumns: 4,
                        rightColumns: 1
                    },


                    scrollCollapse: true,
                    scrollX: true,
                    // scrollY: 300,
                    // pageLength: 10,
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
                        url: "{{ route('dataHilangAsetDt') }}",
                        type: "GET"

                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_Row_Index',
                            "className": "text-center",
                            // orderable: false, 
                            searchable: false

                        },
                        {
                            data: 'nama_barang',
                            //"className": "text-center",

                        },

                        // {
                        //     data: 'kondisi'
                        // },
                        {
                            data: 'satuan'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'kategori'
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
                        // },
                    ]
                });
            }

            function fetch_dataDisposal() {
                $('#dataDisposalAsetDt').DataTable({
                    // fixedColumns: true,

                    fixedColumns: {
                        // leftColumns: 4,
                        rightColumns: 1
                    },


                    scrollCollapse: true,
                    scrollX: true,
                    // scrollY: 300,
                    // pageLength: 10,
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
                        url: "{{ route('dataDisposalAsetDt') }}",
                        type: "GET"

                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_Row_Index',
                            "className": "text-center",
                            // orderable: false, 
                            searchable: false

                        },
                        {
                            data: 'nama_barang',
                            //"className": "text-center",

                        },

                        // {
                        //     data: 'kondisi'
                        // },
                        {
                            data: 'satuan'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'kategori'
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
                        // },
                    ]
                });
            }




        });
    </script>
@endsection
