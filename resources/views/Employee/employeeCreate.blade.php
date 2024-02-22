@extends('layout.main')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>
--}}
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                {{-- <div class="card-header">

                </div> --}}

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if ($errors->any())
                                    {{-- @foreach ($errors->all() as $err) --}}
                                    <p class="alert alert-danger">{{ $errors }}</p>
                                    {{-- @endforeach --}}
                                @endif

                                {{-- <form action="{{ route('customer.store') }}" method="POST"> --}}


                                <div class="form-group">
                                    <label class="col form-text">NIK Karyawan</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control form-control-sm border-secondary"
                                            name="nik_karyawan" value="{{ old('nik_karyawan') }}" placeholder="Input Nik Karyawan"/>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col form-text">Nama Karyawan</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control form-control-sm border-secondary"
                                            name="nama_karyawan" value="{{ old('nama_karyawan') }}" placeholder="Input Nama Karyawan"/>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col form-text">No BPJS</label>
                                    <div class="col-sm">
                                        <input class="form-control form-control-sm border-secondary" type="text"
                                            name="no_bpjs" value="{{ old('no_bpjs') }}" placeholder="Input No BPJS"/>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col form-text">Tanggal Masuk</label>
                                    <div class="col-sm">
                                        <input class="form-control form-control-sm border-secondary" type="date"
                                            name="tgl_gabung" value="{{ old('tgl_gabung') }}"/>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col form-text">Tanggal Habis Kontrak</label>
                                    <div class="col-sm">
                                        <input class="form-control form-control-sm border-secondary" type="date"
                                            name="tgl_kontrak" value="{{ old('tgl_kontrak') }}"/>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col form-text">Divisi</label>
                                    <div class="col-sm">
                                        <select class="form-control form-control-sm border-secondary" type="text"
                                            name="divisi" value="{{ old('divisi') }}">
                                            <option value="">Pilih Divisi</option>
                                            <option value="IKR">IKR</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col form-text">Departemen</label>
                                    <div class="col-sm">
                                        <select class="form-control form-control-sm border-secondary" type="text"
                                            name="departement" value="{{ old('departement') }}" >
                                        <option value="">Pilih Departement</option>
                                        <option value="FTTH">FTTH</option>
                                        <option value="FTTX/FTTB">FTTX/FTTB</option>
                                        <option value="Dokumen Kontrol">Dokumen Kontrol</option>
                                        <option value="Traffic IKR">Traffic IKR</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary">Save</button>
                                    <a class="btn btn-danger" href="{{ route('employee.index') }}">Back</a>
                                </div>
                                {{-- </form> --}}
                        </div>

                        <div class="col">

                            <div class="form-group ">
                                <label class="col form-text">No Telepon/WA</label>
                                <div class="col-sm">
                                    <input class="form-control form-control-sm border-secondary" type="text"
                                        name="no_telp" value="{{ old('no_telp') }}" placeholder="Input No Telepon/WA"/>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col form-text">Email</label>
                                <div class="col-sm">
                                    <input class="form-control form-control-sm border-secondary" type="text"
                                        name="email" value="{{ old('email') }}" placeholder="Input Email"/>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col form-text">No Jamsostek</label>
                                <div class="col-sm">
                                    <input class="form-control form-control-sm border-secondary" type="text"
                                        name="no_jamsostek" value="{{ old('no_jamsostek') }}" placeholder="Input No Jamsostek"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm">
                                    <label class="col form-text">Status Pernikahan</label>
                                    <div class="col-sm form-text">
                                        <select name="status_nikah" class="form-control form-control-sm border-secondary">
                                            <option value="Kawin">Kawin</option>
                                            <option value="Belum Kawin">Belum Kawin</option>
                                            <option value="Janda">Janda</option>
                                            <option value="Duda">Duda</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col form-text">Jml Tanggungan</label>
                                    <div class="col-sm">
                                        <input class="form-control form-control-sm border-secondary" type="text"
                                            name="jml_tanggungan" value="{{ old('jml_tanggungan') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm">
                                    <label class="col form-text">Status Karyawan</label>
                                    <div class="col-sm">
                                        <select name="status_active" class="form-control form-control-sm border-secondary">
                                            <option value="aktif">Aktif</option>
                                            <option value="tidak_aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col form-text">Tanggal Keluar</label>
                                    <div class="col-sm">
                                        <input class="form-control form-control-sm border-secondary" type="date"
                                            name="tgl_nonactive" value="{{ old('tgl_nonactive') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col form-text">Branch</label>
                                <div class="col-sm">
                                    <select name="branch" class="form-control form-control-sm border-secondary">
                                        <option value="{{ old('branch') }}">Pilih branch</option>
                                        @foreach ($branchopt as $branchlist)
                                            <option value="{{ $branchlist->id }}">{{ $branchlist->nama_branch }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col form-text">Posisi</label>
                                <div class="col-sm">
                                    <select class="form-control form-control-sm border-secondary" type="text"
                                        name="posisi" value="{{ old('posisi') }}">
                                        <option value="">Pilih Posisi</option>
                                        <option value="Installer">Installer</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="Dismantle">Dismantle</option>
                                        <option value="Leader Instalasi FTTH">Leader Instalasi FTTH</option>
                                        <option value="Leader Maintenance FTTH">Leader Maintenance FTTH</option>
                                        <option value="Leader Instalasi FTTH">Leader Instalasi FTTH</option>
                                    </select>
                                </div>
                            </div>

                        </div>


                        {{-- Foto Karyawan --}}
                        <div class="col">
                            <div class="form-group row justify-content-md-center ">
                                <h5></h5>
                                <img src="{{ asset('assets/images/pattern2.jpg') }}" id="showgambar" alt="Card Image"
                                    style="width:500px;height: 500px;" />
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6 form-text">Foto Karyawan</label>
                                <div class="col-sm">
                                    <input type="file" id="inputgambar"
                                        class="custom-input-file form-control-sm border-primary" name="foto_karyawan">
                                </div>
                            </div>

                        </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

        {{-- Modal Input Kelengkapan--}}
        <div class="modal fade" id="md-input-kelengkapan" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-lg w-75" role="document">
                <div class="modal-content">
                    <form id="frm-input-kelengkapan" action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title h4" id="myLargeModalLabel">Input Kelengkapan Karyawan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body" id="bdy-input-kelengkapan">

                            <div class="row">

                                <div class="col">

                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label form-text">Login Account
                                            GreatDay</label>
                                        <input type="text" class="form-control form-control-sm border-secondary col-md-3" id="accountGreatDay"
                                            value="" name="accountGreatDay" placeholder="Input Account GreatDay">
                                        {{-- {{-- </div> --}}

                                        <div class="form-group ">
                                            <div class="form-row">

                                                <div class="form-group col-md-3">
                                                    <label class="col-form-label form-text">ID Card</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input border-secondary" type="checkbox"
                                                            name="idCard" value="seragam">
                                                        <label class="form-text">ID Card</label>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label class="col-form-label form-text">Tanggal Serah Terima</label>
                                                    <input type="date" class="form-control form-control-sm border-secondary"
                                                        name="tglSerahTerimaHijau" value="">
                                                </div>

                                            </div>

                                            <div class="form-row">

                                                <div class="form-group col-md-3">
                                                    <label class="col-form-label form-text">Seragam</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input border-secondary" type="checkbox"
                                                            name="seragamHijau" value="seragam">
                                                        <label class="form-text">Seragam Hijau</label>

                                                    </div>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label class="col-form-label form-text">Ukuran</label>
                                                    {{-- <div class="form-check"> --}}
                                                    <select class="form-control form-control-sm border-secondary col-md-10"
                                                        value="" name="ukuranSeragamHijau">
                                                        <option value=""></option>
                                                        <option value="S">S</option>
                                                        <option value="L">L</option>
                                                        <option value="XL">XL</option>
                                                        <option value="XXL">XXL</option>
                                                        <option value="XXXL">XXXL</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label class="col-form-label form-text">Jumlah</label>
                                                    <input type="text" class="form-control form-control-sm border-secondary col-md-10"
                                                        id="jmlSeragamHijau" value="" name="jmlSeragamHijau">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label class="col-form-label form-text">Tanggal Serah Terima</label>
                                                    <input type="date" class="form-control form-control-sm border-secondary"
                                                        name="tglSerahTerimaHijau" value="">
                                                </div>

                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input border-secondary" type="checkbox"
                                                            name="seragamBiru" value="seragamBiru">
                                                        <label class="form-text">Seragam Biru</label>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <select class="form-control form-control-sm border-secondary col-md-10"
                                                        value="" name="ukuranSeragamBiru" value="">
                                                        <option value=""></option>
                                                        <option value="S">S</option>
                                                        <option value="L">L</option>
                                                        <option value="XL">XL</option>
                                                        <option value="XXL">XXL</option>
                                                        <option value="XXXL">XXXL</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <input type="text" class="form-control form-control-sm border-secondary col-md-10"
                                                        id="jmlSeragamBiru" value="" name="jmlSeragamBiru">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <input type="date" class="form-control form-control-sm border-secondary"
                                                        name="tglSerahTerimaBiru" value="">
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
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
    @endsection

    @section('script')
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
