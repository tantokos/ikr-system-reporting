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
                        <div class="col-8">

                            @if ($errors->any())
                                @foreach ($errors->all() as $err)
                                    <p class="alert alert-danger">{{ $err }}</p>
                                @endforeach
                            @endif

                            {{-- <form action="{{ route('customer.store') }}" method="POST"> --}}
                            <form action="{{ route('employee.update', $karyawan) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">NIK Karyawan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" name="nik_karyawan"
                                            value="{{ $karyawan->nik_karyawan }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">Nama Karyawan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" name="nama_karyawan"
                                            value="{{ $karyawan->nama_karyawan }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">No Telepon/WA</label>
                                    <div class="col">
                                        <input class="form-control form-control-sm" type="text" name="no_telp"
                                            value="{{ $karyawan->no_telp }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">Tanggal Masuk</label>
                                    <div class="col">
                                        <input class="form-control form-control-sm" type="date" name="tgl_gabung"
                                            value="{{ $karyawan->tgl_gabung }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">Branch</label>
                                    <div class="col-sm-9">
                                        <select name="branch" class="form-control form-control-sm">
                                            <option value="">Pilih branch</option>
                                            @foreach ($branchopt as $branchlist)
                                                <option value="{{ $branchlist->id }}"
                                                    {{ $branchlist->id == $karyawan->branch_id ? 'selected' : '' }}>
                                                    {{ $branchlist->nama_branch }}</option>
                                                
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">Divisi</label>
                                    <div class="col-sm-9">
                                        <input class="form-control form-control-sm" type="text" name="divisi"
                                            value="{{ $karyawan->divisi }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">Departemen</label>
                                    <div class="col-sm-9">
                                        <input class="form-control form-control-sm" type="text" name="departement"
                                            value="{{ $karyawan->departement }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">Posisi</label>
                                    <div class="col-sm-9">
                                        <input class="form-control form-control-sm" type="text" name="posisi"
                                            value="{{ $karyawan->posisi }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">Email</label>
                                    <div class="col-sm-9">
                                        <input class="form-control form-control-sm" type="text" name="email"
                                            value="{{ $karyawan->email }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">No BPJS</label>
                                    <div class="col-sm-9">
                                        <input class="form-control form-control-sm" type="text" name="no_bpjs"
                                            value="{{ $karyawan->no_bpjs }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">No Jamsostek</label>
                                    <div class="col-sm-9">
                                        <input class="form-control form-control-sm" type="text" name="no_jamsostek"
                                            value="{{ $karyawan->no_jamsostek }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">Status Actif / Tidak Aktif</label>
                                    <div class="col-sm-9">
                                        <select name="status_active" class="form-control form-control-sm">
                                            <option value="aktif"
                                                {{ $karyawan->status_active == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="tidak_aktif"
                                                {{ $karyawan->status_active == 'tidak_aktif' ? 'selected' : '' }}>Tidak
                                                Aktif</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 form-text">Tanggal Tidak Aktif</label>
                                    <div class="col-sm-9">
                                        <input class="form-control form-control-sm" type="date" name="no_nonactive"
                                            value="{{ $karyawan->tgl_nonactive }}" />
                                    </div>
                                </div>

                              

                                <div class="mb-3">
                                    <button class="btn btn-primary">Update</button>
                                    <a class="btn btn-danger" href="{{ route('employee.index') }}">Back</a>
                                </div>
                            </form>
                        </div>



                        <div class="col">
                            <div class="form-group row justify-content-md-center">
                                {{-- <div class="col-md-4"> --}}

                                    <h5></h5>

                                    {{-- <div class="card"> --}}
                                    {{-- <label class="col-sm-3">Foto Karyawan</label> --}}
                                    {{-- <div class="col-md-11"> --}}
                                        <img src="{{ asset('storage/image-kry/' . $karyawan->foto_karyawan) }}"
                                            id="showgambar" alt="Card Image" style="width:500px;height: 500px;" />
                                    {{-- </div> --}}
                                    {{-- </div> --}}

                                {{-- </div> --}}



                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 form-text">Foto Karyawan</label>
                                <div class="col-sm-9">
                                    <input type="file" id="inputgambar" class="custom-input-file"
                                        name="foto_karyawan" value="{{ $karyawan->foto_karyawan }}">
                                </div>
                            </div>
                        </div>
                    </div>

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
