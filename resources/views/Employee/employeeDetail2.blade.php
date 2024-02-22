@extends('layout.main')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Informasi Karyawan</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col"> --}}
                        {{-- <div class="form-group row "> --}}

                        <div class="col-sm-2">
                            {{-- <div class="card"> --}}
                            {{-- <div class="card-block"> --}}

                            {{-- <div style="position: relative"> --}}
                            <img src="{{ asset('storage/image-kry/' . $karyawan->foto_karyawan) }}" id="showgambar"
                                alt="Card Image" style="width:160px;height: 160px;" />
                            {{-- </div> --}}

                            {{-- </div> --}}
                            {{-- </div> --}}
                        </div>

                        <div class="col">
                            <dl class="dl-horizontal row">
                                <dt class="col-sm-4"><small> Nik Karyawan</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->nik_karyawan }}</small></dd>
                                <dt class="col-sm-4"><small>Nama Karyawan</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->nama_karyawan }}</small></dd>
                            </dl>
                            <hr>
                            <hr>
                            <dl class="dl-horizontal row">
                                <dt class="col-sm-4"><small>Status Karyawan</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->status_active }}</small></dd>
                                <dt class="col-sm-4"><small>Status Kepegawaian</small></dt>
                                <dd class="col-sm-8"><small>Kontrak</small></dd>
                                <dt class="col-sm-4"><small> Tanggal Bergabung</small></dt>
                                <dd class="col-sm-8"><small>{{ substr($karyawan->nik_karyawan,0,4)."-".substr($karyawan->nik_karyawan,4,2)."-01" ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small> Divisi</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->divisi ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small> Departemen</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->departement ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small> Posisi</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->posisi ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small> Branch</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->nama_branch ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small>Email</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->email }}</small></dd>
                            </dl>
                            <hr>
                            <hr>
                        </div>

                        <div class="col">
                            <dl class="dl-horizontal row">
                                <dt class="col-sm-4"><small> Nik Supervisor</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->no_bpjs ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small> Nama Supervisor</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->no_bpjs ?: '-' }}</small></dd>
                            </dl>
                            <hr>
                            <hr>
                            <dl class="dl-horizontal row">
                                <dt class="col-sm-4"><small>No Telepon</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->no_telp }}</small></dd>
                                <dt class="col-sm-4"><small>Periode Bergabung</small></dt>
                                <dd class="col-sm-8"><small>{{ $join->y.' Tahun ' . $join->m.' Bulan '.$join->d.' Hari'}}</small></dd>
                                <dt class="col-sm-4"><small>No Rekening Bank</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->no_rek ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small> No BPJS</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->no_bpjs ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small> No Jamsostek</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->no_jamsostek ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small> No NPWP</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->no_npwp ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small> Tgl Pencatatan Data</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->date_created ?: '-' }}</small></dd>
                                <dt class="col-sm-4"><small> Tgl Pembaruan Data</small></dt>
                                <dd class="col-sm-8"><small>{{ $karyawan->date_update ?: '-' }}</small></dd>
                            </dl>
                            <hr>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="nav nav-tabs md-tabs " role="tablist">
                        
                        {{-- <li class="nav-item"> --}}
                        <button class="nav-link active btn-outline-info" data-toggle="tab" href="#DetailKry" role="tab"
                            aria-expanded="true"><small>Detail Karyawan</small>
                        </button>
                        {{-- </li> --}}
                        {{-- <li class="nav-item"> --}}

                        {{-- </li> --}}
                        {{-- <li class="nav-item"> --}}
                        <button class="nav-link btn-outline-info" data-toggle="tab" href="#KontrakKry"
                            role="tab"><small>Kontrak Karyawan</small>
                        </button>
                        <button class="nav-link btn-outline-info" data-toggle="tab" href="#Aset"
                            role="tab"><small>Aset </small>
                        </button>
                        {{-- </li> --}}
                        {{-- <li class="nav-item"> --}}
                        <button class="nav-link btn-outline-info" data-toggle="tab" href="#Kepesertaan"
                            role="tab"><small>Kepesertaan</small>
                        </button>
                        <button class="nav-link btn-outline-info" data-toggle="tab" href="#IdentitasKeluarga"
                            role="tab"><small>Identitas Keluarga</small>
                        </button>
                        <button class="nav-link btn-outline-info" data-toggle="tab" href="#kontakDarurat"
                            role="tab"><small>Kontak Darurat</small>
                        </button>
                        <button class="nav-link btn-outline-info" data-toggle="tab" href="#Dokumen"
                            role="tab"><small>Dokumen</small>
                        </button>
                        <button class="nav-link btn-outline-info" data-toggle="tab" href="#sp"
                            role="tab"><small>Surat Peringatan</small>
                        </button>

                        {{-- </li> --}}
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="DetailKry" role="tabpanel" 
                            aria-expanded="true">
                            <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <dl class="dl-horizontal row">
                                        <dt class="col-sm-4 bg-light"><small>Nik Karyawan</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->nik_karyawan }}</small></dd>

                                        <dt class="col-sm-4 bg-light"><small>Nama Karyawan</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->nama_karyawan }}</small></dd>

                                        <dt class="col-sm-4 bg-light"><small>Tempat & Tanggal Lahir</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->tgl_lahir ?: '-' }}</small></dd>

                                        <dt class="col-sm-4 bg-light"><small>Agama</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->agama ?: '-' }}</small></dd>

                                        <dt class="col-sm-4 bg-light"><small>No KTP</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->no_ktp ?: '-' }}</small></dd>

                                        <dt class="col-sm-4 bg-light"><small>Kewarganegaraan</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->kewarganegaraan ?: '-' }}</small></dd>

                                        <dt class="col-sm-4 bg-light"><small>No Telepon</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->no_telp ?: '-' }}</small></dd>

                                        <dt class="col-sm-4 bg-light"><small>Alamat Lengkap</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->alamat_ktp ?: '-' }}</small></dd>
                                    </dl>
                                </div>

                                <div class="col">
                                    <dl class="dl-horizontal row">
                                        <dt class="col-sm-4  bg-light"><small>Jenis Kelamin</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->no_bpjs ?: '-' }}</small></dd>
                                        <dt class="col-sm-4  bg-light"><small> Status Pernikahan</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->no_bpjs ?: '-' }}</small></dd>
                                    
                                        <dt class="col-sm-4  bg-light"><small>Jumlah Tanggungan</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->jml_tanggungan ?: '-' }}</small></dd>
                                        
                                        <dt class="col-sm-4  bg-light"><small>Email Pribadi</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->email_pribadi ?: '-' }}</small></dd>
                                        <dt class="col-sm-4  bg-light"><small>Email Perusahaan</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->email_perusahaan ?: '-' }}</small></dd>
                                        <dt class="col-sm-4  bg-light"><small>Alamat Domisili</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->no_bpjs ?: '-' }}</small></dd>
                                        <dt class="col-sm-4  bg-light"><small>Pendidikan Terakhir</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->no_jamsostek ?: '-' }}</small></dd>
                                        <dt class="col-sm-4  bg-light"><small>Golongan Darah</small></dt>
                                        <dd class="col-sm-8"><small>{{ $karyawan->no_npwp ?: '-' }}</small></dd>

                                    </dl>
                                    
                                </div>
                            </div>
                            </div>
                            <div class="card-body">
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <dl class="dl-horizontal row">
            
                                            <dt class="col-sm-4 bg-light"><small> Pencatat Data</small></dt>
                                            <dd class="col-sm-8"><small>{{ $karyawan->created_by ?: '-' }}</small></dd>
                                            <dt class="col-sm-4 bg-light"><small> Tanggal Input</small></dt>
                                            <dd class="col-sm-8"><small>{{ $karyawan->created_date ?: '-' }}</small></dd>
                                          
                                        </dl>
            
                                    </div>
            
                                    <div class="col">
                                        <dl class="dl-horizontal row">
                                            <dt class="col-sm-4 bg-light"><small> Di Update Oleh</small></dt>
                                            <dd class="col-sm-8 "><small>{{ $karyawan->date_created ?: '-' }}</small></dd>
                                            <dt class="col-sm-4 bg-light"><small> Tgl Update Data</small></dt>
                                            <dd class="col-sm-8"><small>{{ $karyawan->date_update ?: '-' }}</small></dd>
                                        </dl>
            
                                    </div>
            
                                </div>
            
                            </div>
                        </div>
                        <div class="tab-pane" id="KontrakKry" role="tabpanel" style="text-align: center">
                            <img src="{{ asset('assets/images/under_Construction.jpg') }}"
                                style="width:400px;height: 400px;">
                        </div>
                        <div class="tab-pane" id="Aset" role="tabpanel" style="text-align: center">
                            <img src="{{ asset('assets/images/under_Construction.jpg') }}"
                                style="width:400px;height: 400px;">
                        </div>
                        <div class="tab-pane" id="Kepesertaan" role="tabpanel" style="text-align: center">
                            <img src="{{ asset('assets/images/under_Construction.jpg') }}"
                                style="width:400px;height: 400px;">
                        </div>
                        
                        <div class="tab-pane" id="IdentitasKeluarga" role="tabpanel" style="text-align: center">
                            <img src="{{ asset('assets/images/under_Construction.jpg') }}"
                                style="width:400px;height: 400px;">
                        </div>

                        <div class="tab-pane" id="kontakDarurat" role="tabpanel" style="text-align: center">
                            <img src="{{ asset('assets/images/under_Construction.jpg') }}"
                                style="width:400px;height: 400px;">
                        </div>

                        <div class="tab-pane" id="Dokumen" role="tabpanel" style="text-align: center">
                            <img src="{{ asset('assets/images/under_Construction.jpg') }}"
                                style="width:400px;height: 400px;">
                        </div>

                        <div class="tab-pane" id="sp" role="tabpanel" style="text-align: center">
                            <img src="{{ asset('assets/images/under_Construction.jpg') }}"
                                style="width:400px;height: 400px;">
                        </div>
                    </div>
                </div>
                

            </div>
        </div>



    </div>
@endsection

@section('script')
    <script>
        // $('.nav-tabs a').click(function(){
        //     $('.nav-tabs li a').setAttribute('aria-expanded', 'false');
        // //   $(this).tab('show');
        //     $('.nav-tabs li').classList.remove('active');
        //   $(this).setAttribute('aria-expanded', 'true');
        // })
    </script>
@endsection
