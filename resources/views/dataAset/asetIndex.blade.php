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
            <button type="button" class="btn  btn-info form-text" data-toggle="modal" data-target="#md-edit-kelengkapan">Input
                Baru</button>
        </div>

        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-striped" id="dataAset" width="100%" cellspacing="0" style="font-size: 12px">
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

    <div class="modal fade" id="md-edit-kelengkapan" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Input Data Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-edit-kelengkapan">
                    <div class="row">
                        <div class="col-sm-12">
                            {{-- <div class="card"> --}}
                            {{-- <div class="card-header">
                
                                </div> --}}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <form action="{{ route('aset.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf


                                            <div class="form-group ">
                                                <label class="col form-text">Tanggal Penginputan</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary "
                                                        type="date" name="tgl_input" id="tgl_input" value="{{ old('tgl_input') }}" required/>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col form-text">Kategori Aset</label>
                                                <div class="col-sm">
                                                    <select class="form-control form-control-sm border-secondary"
                                                        name="kategori" >
                                                        <option value="{{ old('kategori') }}">Pilih Kategori</option>
                                                        @foreach ($kategori as $list )
                                                        <option value="{{ $list->kategori }}">{{ $list->kategori}}</option>
                                                        @endforeach
                                                        
                                                        {{-- <option value="Seragam">Seragam</option>
                                                        <option value="Laptop">Laptop</option>
                                                        <option value="Tools">Tools</option>
                                                        <option value="Kendaraan">Kendaraan</option> --}}
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group ">
                                                <label class="col form-text">Nama Aset</label>
                                                <div class="col-sm">
                                                    <input type="text"
                                                        class="form-control form-control-sm border-secondary @error('nama_barang') is-invalid @enderror"
                                                        name="nama_barang" value="{{ old('nama_barang') }}"
                                                        placeholder="Input Nama Barang" required/>
                                                    @error('nama_barang')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Merk</label>
                                                <div class="col-sm">
                                                    <input
                                                        class="form-control form-control-sm border-secondary @error('merk_barang') is-invalid @enderror"
                                                        type="text" name="merk_barang" value="{{ old('merk_barang') }}"
                                                        placeholder="Input Merk Barang" required/>
                                                    @error('merk_barang')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Spesifikasi</label>
                                                <div class="col-sm">
                                                    <textarea class="form-control form-control-sm border-secondary @error('spesifikasi') is-invalid @enderror"
                                                        type="text" name="spesifikasi" value="{{ old('spesifikasi') }}" placeholder="Input Spesifikasi Barang"></textarea>
                                                    @error('spesifikasi')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                    </div>

                                    <div class="col">

                                        <div class="form-group ">
                                            <label class="col form-text">Kode Aset</label>
                                            <div class="col-sm">
                                                <input
                                                    class="form-control form-control-sm border-secondary @error('kode_aset') is-invalid @enderror"
                                                    type="text" name="kode_aset" value="{{ old('kode_aset') }}"
                                                    placeholder="Input Kode Aset" required/>

                                                @error('kode_aset')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Kode GA</label>
                                            <div class="col-sm">
                                                <input
                                                    class="form-control form-control-sm border-secondary @error('kode_ga') is-invalid @enderror"
                                                    type="text" name="kode_ga" value="{{ old('kode_ga') }}"
                                                    placeholder="Input Kode Aset" required/>
                                                    @error('kode_ga')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Kondisi Aset</label>
                                            <div class="col-sm">
                                                <select class="form-control form-control-sm border-secondary"
                                                    name="kondisi" value="{{ old('kondisi') }}">
                                                    <option value="">Pilih Kondisi Barang</option>
                                                    <option value="Baik">Baik</option>
                                                    <option value="Rusak">Rusak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Satuan</label>
                                            <div class="col-sm">
                                                <select
                                                    class="form-control form-control-sm border-secondary @error('satuan') is-invalid @enderror"
                                                    name="satuan" value="{{ old('satuan') }}">
                                                    <option value="">Pilih Satuan</option>
                                                    <option value="Unit">Unit</option>
                                                    <option value="Pcs">Pcs</option>

                                                </select>
                                                @error('satuan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Jumlah Aset</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary @error('jml') is-invalid @enderror"
                                                    type="text" name="jml" value="{{ old('jml') }}"
                                                    placeholder="Input Jml Barang" />
                                                    @error('jml')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>


                                    {{-- Detail Kendaraan --}}

                                    <div class="col">

                                        <div class="form-group ">
                                            <label class="col form-text">Tanggal Pembelian</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary "
                                                        type="date" name="tgl_beli" id="tgl_beli" value="{{ old('tgl_beli') }}" required/>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Nomor Polisi</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary"
                                                    type="text" name="nopol" value="{{ old('nopol') }}"
                                                    placeholder="Input Nomor Polisi" />
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Tanggal Pajak STNK (1 Tahun)</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary"
                                                    type="date" name="tgl_pajak_1tahun"
                                                    value="{{ old('tgl_pajak_1tahun') }}" />
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Masa Aktif STNK (5 Tahun)</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary"
                                                    type="date" name="tgl_pajak_5tahun"
                                                    value="{{ old('tgl_pajak_5tahun') }}" />
                                            </div>
                                        </div>

                                    </div>
                                    {{-- End Detail Kendaraan --}}


                                    {{-- Foto barang --}}
                                    <div class="col">
                                        <div class="form-group row justify-content-md-center ">
                                            <h5></h5>
                                            <img src="{{ asset('assets/images/pattern2.jpg') }}" id="showgambar"
                                                alt="Card Image" style="width:200;height: 300px;" />
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-6 form-text">Foto Barang</label>
                                            <div class="col-sm">
                                                <input type="file" id="inputgambar"
                                                    class="custom-input-file form-control-sm border-primary"
                                                    name="foto_barang">
                                            </div>
                                        </div>

                                    </div>
                                    {{-- </form> --}}
                                </div>

                            </div>
                            {{-- </div> --}}

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn  btn-primary">Save</button>
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>

                </div>
                </form>
            </div>
        </div>
    </div>



    {{-- Modal Edit --}}

    <div class="modal fade" id="md-edit-aset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Edit Data Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-edit-aset">
                    <div class="row">
                        <div class="col-sm-12">
                            {{-- <div class="card"> --}}
                            {{-- <div class="card-header">
                
                                </div> --}}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <form action="#" method="POST" id="edit"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')

                                            <div class="form-group ">
                                                <label class="col form-text">Tanggal Penginputan</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary "
                                                        type="date" name="tgl_inputEdit" id="tgl_inputEdit" value="" required/>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col form-text">Kategori Aset</label>
                                                <div class="col-sm">
                                                    <select class="form-control form-control-sm border-secondary"
                                                        name="kategoriEdit" id="kategoriEdit" value="{{ old('kategoriEdit') }}">
                                                        <option value="">Pilih Kategori</option>
                                                        @foreach ($kategori as $listEdit )  
                                                        <option value="{{ $listEdit->kategori }}">{{ $listEdit->kategori }}</option>
                                                        @endforeach
                                                        
                                                        {{-- <option value="ID Card">ID Card</option>
                                                        <option value="Seragam">Seragam</option>
                                                        <option value="Laptop">Laptop</option>
                                                        <option value="Tools">Tools</option>
                                                        <option value="Kendaraan">Kendaraan</option> --}}
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group ">
                                                <label class="col form-text">Nama Aset</label>
                                                <div class="col-sm">
                                                    <input type="text"
                                                        class="form-control form-control-sm border-secondary @error('nama_barangEdit') is-invalid @enderror"
                                                        name="nama_barangEdit" id="nama_barangEdit" value="{{ old('nama_barangEdit') }}"
                                                        placeholder="Input Nama Barang" required/>
                                                    @error('nama_barangEdit')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Merk</label>
                                                <div class="col-sm">
                                                    <input
                                                        class="form-control form-control-sm border-secondary @error('merk_barangEdit') is-invalid @enderror"
                                                        type="text" name="merk_barangEdit" id="merk_barangEdit" value="{{ old('merk_barangEdit') }}"
                                                        placeholder="Input Merk Barang" required/>
                                                    @error('merk_barangEdit')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Spesifikasi</label>
                                                <div class="col-sm">
                                                    <textarea class="form-control form-control-sm border-secondary @error('spesifikasiEdit') is-invalid @enderror"
                                                        type="text" name="spesifikasiEdit" id="spesifikasiEdit" value="{{ old('spesifikasiEdit') }}" placeholder="Input Spesifikasi Barang"></textarea>
                                                    @error('spesifikasiEdit')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                    </div>

                                    <div class="col">

                                        <div class="form-group ">
                                            <label class="col form-text">Kode Aset</label>
                                            <div class="col-sm">
                                                <input
                                                    class="form-control form-control-sm border-secondary @error('kode_asetEdit') is-invalid @enderror"
                                                    type="text" name="kode_asetEdit" id="kode_asetEdit" value="{{ old('kode_asetEdit') }}"
                                                    placeholder="Input Kode Aset" required/>

                                                @error('kode_asetEdit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Kode GA</label>
                                            <div class="col-sm">
                                                <input
                                                    class="form-control form-control-sm border-secondary @error('kode_gaEdit') is-invalid @enderror"
                                                    type="text" name="kode_gaEdit" id="kode_gaEdit" value="{{ old('kode_gaEdit') }}"
                                                    placeholder="Input Kode Aset" required/>
                                                    @error('kode_gaEdit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Kondisi Aset</label>
                                            <div class="col-sm">
                                                <select class="form-control form-control-sm border-secondary"
                                                    name="kondisiEdit" id="kondisiEdit" value="{{ old('kondisiEdit') }}">
                                                    <option value="">Pilih Kondisi Barang</option>
                                                    <option value="Baik">Baik</option>
                                                    <option value="Rusak">Rusak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Satuan</label>
                                            <div class="col-sm">
                                                <select
                                                    class="form-control form-control-sm border-secondary @error('satuanEdit') is-invalid @enderror"
                                                    name="satuanEdit" id="satuanEdit" value="{{ old('satuanEdit') }}">
                                                    <option value="">Pilih Satuan</option>
                                                    <option value="Unit">Unit</option>
                                                    <option value="Pcs">Pcs</option>

                                                </select>
                                                @error('satuanEdit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Jumlah Aset</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary @error('jmlEdit') is-invalid @enderror"
                                                    type="text" name="jmlEdit" id="jmlEdit" value="{{ old('jmlEdit') }}"
                                                    placeholder="Input Jml Barang" />
                                                    @error('jmlEdit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>


                                    {{-- Detail Kendaraan --}}

                                    <div class="col">

                                        <div class="form-group ">
                                            <label class="col form-text">Nomor Polisi</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary"
                                                    type="text" name="nopolEdit" id="nopolEdit" value="{{ old('nopolEdit') }}"
                                                    placeholder="Input Nomor Polisi" />
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Tanggal Pajak STNK (1 Tahun)</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary"
                                                    type="date" name="tgl_pajak_1tahunEdit" id="tgl_pajak_1tahunEdit"
                                                    value="{{ old('tgl_pajak_1tahunEdit') }}" />
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Masa Aktif STNK (5 Tahun)</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary"
                                                    type="date" name="tgl_pajak_5tahunEdit" id="tgl_pajak_5tahunEdit"
                                                    value="{{ old('tgl_pajak_5tahunEdit') }}" />
                                            </div>
                                        </div>

                                    </div>
                                    {{-- End Detail Kendaraan --}}


                                    {{-- Foto barang --}}
                                    <div class="col">
                                        <div class="form-group row justify-content-md-center ">
                                            <h5></h5>
                                            <img src="{{ asset('assets/images/pattern2.jpg') }}" id="showgambarEdit"
                                                alt="Card Image" style="width:200;height: 300px;" />
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-6 form-text">Foto Barang</label>
                                            <div class="col-sm">
                                                <input type="file" id="inputgambarEdit"
                                                    class="custom-input-file form-control-sm border-primary"
                                                    name="foto_barangEdit" value="">
                                            </div>
                                        </div>

                                    </div>
                                    {{-- </form> --}}
                                </div>

                            </div>
                            {{-- </div> --}}

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn  btn-primary">Update</button>
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cancel</button>

                </div>
                </form>
            </div>
        </div>
    </div>
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
        @if (count($errors) > 0)
            $('#md-edit-kelengkapan').modal('show');
        @endif

        function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#showgambar').attr('src', e.target.result);

                    }

                    reader.readAsDataURL(input.files[0]);

                }
            }

            $("#inputgambar").change(function() {
                readURL(this);
            });


        // $('#dataAset tbody').on('click', '.edit-barang', function(e) {
            // e.preventDefault();
            // var data = $('#dataAset').DataTable().row($(this).parents('tr')).data();

            // var kondisiEdit = data.kondisi.toUpperCase();


            // var edit = '{{ route('aset.update', ':data.id') }}';
            // edit = edit.replace(':data.id', data.id);
            
            // var gmbrpath = "{{ asset('storage/image-brg/') }}/"; 
            // var gmbr = gmbrpath+data.foto_barang

            // document.getElementById('showgambarEdit').src =  gmbr

            // $('#kategoriEdit').val(data.kategori)
            // $('#tgl_inputEditt').val(data.tgl_pengadaan)
            // $('#nama_barangEdit').val(data.nama_barang)
            // $('#merk_barangEdit').val(data.merk_barang)
            // $('#spesifikasiEdit').val(data.spesifikasi)
            // $('#kode_asetEdit').val(data.kode_aset)
            // $('#kode_gaEdit').val(data.kode_ga)
            // $('#kondisiEdit').val(data.kondisi)
            // $('#satuanEdit').val(data.satuan)
            // $('#jmlEdit').val(data.jumlah)
            // $('#foto_barangEdit').val(data.foto_barang)



            // $('#md-edit-aset').modal('show');





        // });

        $(document).ready(function() {
            fetch_data()

            function fetch_data() {
                $('#dataAset').DataTable({
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
                        url: "{{ route('aset.data') }}",
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
                        {
                            data: 'merk_barang',
                        },
                        {
                            data: 'spesifikasi',
                        },
                        {
                            data: 'kode_aset',
                        },
                        {
                            data: 'kode_ga',
                        },
                        {
                            data: 'kondisi',
                        },
                        {
                            data: 'satuan',
                        },
                        {
                            data: 'jumlah',
                        },
                        {
                            data: 'kategori',
                        },
                        {
                            data: 'tgl_pengadaan',
                        },
                        {
                            data: 'fotoAset',
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
