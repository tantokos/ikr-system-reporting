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
            {{-- <a href="/employeeCreate" class="btn btn-primary">input baru</a> --}}
            {{-- <button type="button" class="btn  btn-info form-text" data-toggle="modal" data-target="#md-edit-kelengkapan">Input
                Baru</button> --}}
            <div class="row">
                <div class="col">
                    <form action="{{ route('aset.ImportTempdata') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col form-text"></label>
                            <div class="col">
                                <input type="file" name="fileAset" class="form-control form-text" required="required">
                                @error('fileAset')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2">

                                <button type="submit" class="btn btn-success">Import Data Aset</button>
                            </div>
                        </div>
                    </form>

                    <hr>


                </div>

                <div class="col">
                    <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 form-text">Import By : </label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm border-secondary" name="akses" value="{{ $akses }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 form-text">Jumlah Data :</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm border-secondary" id="jmlImport" name="jmlImport" value="{{ $jmlImport }}" readonly>
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <div class="col">

                                <button type="submit" class="btn btn-primary">Simpan data Import</button>
                                <button type="button" class="btn btn-secondary">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>





        </div>
        <hr>


        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTempAset" width="100%" cellspacing="0" style="font-size: 12px">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Merk Barang</th>
                            <th>Spesifikasi</th>
                            <th>Kode Aset</th>
                            <th>Kode GA</th>
                            <th>Kondisi</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Kategori</th>
                            <th>Tgl Pengadaan</th>
                            <th>Foto Barang</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Input Baru --}}



    {{-- Modal Edit --}}
@endsection

@section('script')
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap5.min.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.js"></script>


    <script type="text/javascript">
        $('#dataAset tbody').on('click', '.edit-barang', function(e) {
            e.preventDefault();
            var data = $('#dataAset').DataTable().row($(this).parents('tr')).data();

            console.log(data);
            $('#kategoriEdit').val(data.kategori)
            $('#tglPengadaanEdit').val(data.tgl_pengadaan)
            $('#namaBarangEdit').val(data.nama_barang)
            $('#merkBarangEdit').val(data.merk_barang)
            $('#spesifikasiEdit').val(data.spesifikasi)
            $('#kodeAsetEdit').val(data.kode_aset)
            $('#kondisiBarangEdit').val(data.kondisi)
            $('#satuanEdit').val(data.satuan)
            $('#jumlahEdit').val(data.jumlah)



            $('#md-edit-barang').modal('show');





        });

        $(document).ready(function() {
            fetch_data()

            function fetch_data() {
                $('#dataTempAset').DataTable({
                    fixedColumns: true,

                    fixedColumns: {
                        // leftColumns: 4,
                        rightColumns: 1
                    },


                    scrollCollapse: true,
                    scrollX: true,
                    // scrollY: 300,
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
                        url: "{{ route('aset.Tempdata') }}",
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
                            "className": "text-center",

                        },
                        {
                            data: 'merk_barang',
                        },
                        {
                            data: 'spesifikasi'
                        },
                        {
                            data: 'kode_aset'
                        },
                        {
                            data: 'kode_ga'
                        },
                        {
                            data: 'kondisi'
                        },
                        {
                            data: 'satuan'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'kategori'
                        },
                        {
                            data: 'tgl_pengadaan'
                        },
                        {
                            data: 'fotoAset'
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
