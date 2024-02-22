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
        {{-- <div class="card-header">
            <button type="button" class="btn  btn-info form-text" data-toggle="modal" data-target="#md-edit-kelengkapan">Input
                Baru</button>
        </div> --}}





        <div class="row">
            <div class="col-sm-12">
                {{-- <div class="card"> --}}
                {{-- <div class="card-header">
                
                                </div> --}}

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('aset.update', $editAset->id)}}" method="POST" id="edit" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group ">
                                    <label class="col form-text">Tanggal Penginputan</label>
                                    <div class="col-sm">
                                        <input class="form-control form-control-sm border-secondary " type="date"
                                            name="tgl_inputEdit" id="tgl_inputEdit"
                                            value="{{ old($editAset->tgl_pengadaan) }}" required />
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col form-text">Kategori Aset</label>
                                    <div class="col-sm">
                                        <select class="form-control form-control-sm border-secondary" name="kategoriEdit"
                                            id="kategoriEdit" value="">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($kategori as $listEdit)
                                                <option value="{{ $listEdit->kategori }}"
                                                    {{ $listEdit->kategori == $editAset->kategori ? 'selected' : '' }}>
                                                    {{ $listEdit->kategori }}</option>
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
                                            name="nama_barangEdit" id="nama_barangEdit" value="{{ $editAset->nama_barang }}"
                                            placeholder="Input Nama Barang" required />
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
                                            type="text" name="merk_barangEdit" id="merk_barangEdit"
                                            value="{{ $editAset->merk_barang }}" placeholder="Input Merk Barang" required />
                                        @error('merk_barangEdit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col form-text">Spesifikasi</label>
                                    <div class="col-sm">
                                        <textarea class="form-control form-control-sm border-secondary @error('spesifikasiEdit') is-invalid @enderror"
                                            type="text" name="spesifikasiEdit" id="spesifikasiEdit" value=""
                                            placeholder="Input Spesifikasi Barang">{{ $editAset->spesifikasi }}</textarea>
                                        @error('spesifikasiEdit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn  btn-primary">Update</button>
                                    <a type="button" class="btn  btn-secondary" href="{{ route('aset.index') }}">Cancel</a>

                                </div>


                        </div>

                        <div class="col">

                            <div class="form-group ">
                                <label class="col form-text">Kode Aset</label>
                                <div class="col-sm">
                                    <input
                                        class="form-control form-control-sm border-secondary @error('kode_asetEdit') is-invalid @enderror"
                                        type="text" name="kode_asetEdit" id="kode_asetEdit"
                                        value="{{ $editAset->kode_aset }}" placeholder="Input Kode Aset" required />

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
                                        type="text" name="kode_gaEdit" id="kode_gaEdit" value="{{ $editAset->kode_ga }}"
                                        placeholder="Input Kode Aset" required />
                                    @error('kode_gaEdit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col form-text">Kondisi Aset</label>
                                <div class="col-sm">
                                    <select class="form-control form-control-sm border-secondary" name="kondisiEdit"
                                        id="kondisiEdit" value="{{ $editAset->kondisi }}">
                                        <option value="">Pilih Kondisi Barang</option>
                                        <option value="Baik" {{"Baik" == $editAset->kondisi ? 'selected' : '' }}>Baik</option>
                                        <option value="Rusak" {{"Rusak" == $editAset->kondisi ? 'selected' : '' }}>Rusak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col form-text">Satuan</label>
                                <div class="col-sm">
                                    <select
                                        class="form-control form-control-sm border-secondary @error('satuanEdit') is-invalid @enderror"
                                        name="satuanEdit" id="satuanEdit" value="{{ $editAset->satuan }}">
                                        <option value="">Pilih Satuan</option>
                                        <option value="Unit" {{"Unit" == $editAset->satuan ? 'selected' : '' }}>Unit</option>
                                        <option value="Pcs" {{"Pcs" == $editAset->satuan ? 'selected' : '' }}>Pcs</option>

                                    </select>
                                    @error('satuanEdit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col form-text">Jumlah Aset</label>
                                <div class="col-sm">
                                    <input
                                        class="form-control form-control-sm border-secondary @error('jmlEdit') is-invalid @enderror"
                                        type="text" name="jmlEdit" id="jmlEdit" value="{{ $editAset->jumlah }}"
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
                                <label class="col form-text">Tanggal Pembelian</label>
                                <div class="col-sm">
                                    <input class="form-control form-control-sm border-secondary " type="date"
                                            name="tgl_beliEdit" id="tgl_beliEdit"
                                            value="" />
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col form-text">Nomor Polisi</label>
                                <div class="col-sm">
                                    <input class="form-control form-control-sm border-secondary" type="text"
                                        name="nopolEdit" id="nopolEdit" value="{{ $editAset->nopol }}"
                                        placeholder="Input Nomor Polisi" />
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col form-text">Tanggal Pajak STNK (1 Tahun)</label>
                                <div class="col-sm">
                                    <input class="form-control form-control-sm border-secondary" type="date"
                                        name="tgl_pajak_1tahunEdit" id="tgl_pajak_1tahunEdit"
                                        value="{{ $editAset->pajak_1tahun }}" />
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col form-text">Masa Aktif STNK (5 Tahun)</label>
                                <div class="col-sm">
                                    <input class="form-control form-control-sm border-secondary" type="date"
                                        name="tgl_pajak_5tahunEdit" id="tgl_pajak_5tahunEdit"
                                        value="{{ $editAset->pajak_5tahun }}" />
                                </div>
                            </div>

                        </div>
                        {{-- End Detail Kendaraan --}}


                        {{-- Foto barang --}}
                        <div class="col">
                            <div class="form-group row justify-content-md-center ">
                                <h5></h5>
                                <img src="{{ asset('storage/image-brg/'.$editAset->foto_barang ) }}" id="showgambarEdit"
                                    alt="Card Image" style="width:200;height: 300px;" />
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6 form-text">Foto Barang</label>
                                <div class="col-sm">
                                    <input type="file" id="inputgambarEdit"
                                        class="custom-input-file form-control-sm border-primary" name="foto_barangEdit"
                                        value="{{ $editAset->foto_barang }}">
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


        

       
    </script>
@endsection
