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
                <table class="table table-striped" id="dataPinjaman" width="100%" cellspacing="0" style="font-size: 12px">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl Distribusi</th>
                            <th>Nama Karyawan</th>
                            <th>Branch</th>
                            <th>Kategori</th>
                            <th>Nama Aset</th>
                            <th>Kode Aset</th>
                            <th>Satuan</th>
                            <th>Jml Distribusi</th>

                            <th>Status Pengembalian</th>
                            {{-- <th>Foto Barang</th> --}}
                            <th style="text-align: center">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>11-05-2018</td>
                            <td>Muhammad Solkan</td>
                            <td>Jakarta Timur</td>
                            <td>Seragam</td>
                            <td>Seragam Oxygen Hijau-L</td>
                            <td>SRGHL-2018-01</SRG-2018-01></td>
                            <td>Pcs</td>
                            <td>1</td>

                            <td>Sudah Dikembalikan</td>
                            <td style="text-align: center">
                                {{-- <button type="button" class="btn btn-sm btn-info edit-barang" data-toggle="modal"
                                    data-target="#md-detail-pinjam"> <i class="fas fa-edit"></i> Detail</button> --}}
                                <a href="#" class="btn btn-sm btn-primary edit-barang"> <i class="fas fa-edit"></i>
                                    Edit</a>
                            </td>

                        </tr>
                        <tr>
                            <td>2</td>
                            <td>11-05-2018</td>
                            <td>Muhammad Solkan</td>
                            <td>Jakarta Timur</td>
                            <td>Seragam</td>
                            <td>Seragam Oxygen Biru-L</td>
                            <td>SRGBL-2018-01</SRG-2018-01></td>
                            <td>Pcs</td>
                            <td>1</td>

                            <td>Sudah Dikembalikan</td>
                            <td style="text-align: center">
                                {{-- <button type="button" class="btn btn-sm btn-info edit-barang" data-toggle="modal"
                                    data-target="#md-detail-pinjam"> <i class="fas fa-edit"></i> Detail</button> --}}
                                <a href="#" class="btn btn-sm btn-primary edit-barang"> <i class="fas fa-edit"></i>
                                    Edit</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>15-12-2023</td>
                            <td>Muhammad Sobar</td>
                            <td>Jakarta Selatan</td>
                            <td>Seragam</td>
                            <td>Seragam Oxygen Hijau-L</td>
                            <td>SRGHL-2018-03</SRG-2018-01></td>
                            <td>Pcs</td>
                            <td>1</td>

                            <td>Belum Dikembalikan</td>
                            <td style="text-align: center">
                                {{-- <button type="button" class="btn btn-sm btn-info edit-barang" data-toggle="modal"
                                    data-target="#md-detail-pinjam"> <i class="fas fa-edit"></i> Detail</button> --}}
                                <a href="#" class="btn btn-sm btn-primary edit-barang"> <i class="fas fa-edit"></i>
                                    Edit</a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>15-12-2023</td>
                            <td>Muhammad Sobar</td>
                            <td>Jakarta Selatan</td>
                            <td>Seragam</td>
                            <td>Seragam Oxygen Biru-L</td>
                            <td>SRGBL-2018-03</SRG-2018-01></td>
                            <td>Pcs</td>
                            <td>1</td>

                            <td>Belum Dikembalikan</td>
                            <td style="text-align: center">
                                {{-- <button type="button" class="btn btn-sm btn-info edit-barang" data-toggle="modal"
                                    data-target="#md-detail-pinjam"> <i class="fas fa-edit"></i> Detail</button> --}}
                                <a href="#" class="btn btn-sm btn-primary edit-barang"> <i class="fas fa-edit"></i>
                                    Edit</a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>04-05-2023</td>
                            <td>Tanto Koswara</td>
                            <td>Jakarta Timur</td>
                            <td>Laptop</td>
                            <td>Laptop Lenovo</td>
                            <td>NB-IKR-102117</td>
                            <td>Unit</td>
                            <td>1</td>

                            <td>Belum Dikembalikan</td>
                            <td style="text-align: center">
                                {{-- <button type="button" class="btn btn-sm btn-info edit-barang" data-toggle="modal"
                                    data-target="#md-detail-pinjam"> <i class="fas fa-edit"></i> Detail</button> --}}
                                <a href="#" class="btn btn-sm btn-primary edit-barang"> <i class="fas fa-edit"></i>
                                    Edit</a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>03-12-2022</td>
                            <td>Raden Feby Prihadi</td>
                            <td>Jakarta Timur</td>
                            <td>Laptop</td>
                            <td>Laptop Lenovo</td>
                            <td>NB-IKR-102128</td>
                            <td>Unit</td>
                            <td>1</td>

                            <td>Belum Dikembalikan</td>
                            <td style="text-align: center">
                                {{-- <button type="button" class="btn btn-sm btn-info edit-barang" data-toggle="modal"
                                    data-target="#md-detail-pinjam"> <i class="fas fa-edit"></i> Detail</button> --}}
                                <a href="#" class="btn btn-sm btn-primary edit-barang"> <i class="fas fa-edit"></i>
                                    Edit</a>
                            </td>
                        </tr>


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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Input Data Distribusi Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-edit-kelengkapan">
                    <div class="row">
                        <div class="col-sm-12">
 

                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <form action="{{ route('simpan.pinjam') }}" method="POST"
                                            enctype="multipart/form-data" id="form-data-input">
                                            @csrf

                                            @if ($errors->any())
                                                {{-- @foreach ($errors->all() as $err) --}}
                                                <p class="alert alert-danger">{{ $errors }}</p>
                                                {{-- @endforeach --}}
                                            @endif

                                            {{-- <form action="{{ route('customer.store') }}" method="POST"> --}}

                                            <div class="form-group row">

                                                <div class="col">
                                                    <label class="col form-text">Tipe Distribusi Aset</label>
                                                    <div class="col-sm">
                                                        <select class="form-control form-control-sm border-secondary"
                                                            name="peminjam">
                                                            <option value="">Pilih Tipe Distribusi</option>
                                                            <option value="Individu">Individu</option>
                                                            <option value="Callsign/Leader">Leader</option>
                                                            {{-- <option value="Branch">Branch</option> --}}

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm">
                                                    <label class="col form-text">Tanggal Distribusi/Serah Terima</label>
                                                    <div class="col-sm">
                                                        <input class="form-control form-control-sm border-secondary"
                                                            type="date" name="tglPinjam"
                                                            value="{{ old('tgl_pinjam') }}" />
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm">
                                                    <label class="col form-text">PIC/Nama Karyawan</label>
                                                    <div class="col-sm">
                                                        <select class="form-control form-control-sm border-secondary"
                                                            name="idKaryawan" id="idKaryawan">
                                                            <option value="">Pilih Karyawan</option>
                                                            @foreach ($karyawanOpt as $karyawanList)
                                                                <option value="{{ $karyawanList->id }}">
                                                                    {{ $karyawanList->nama_karyawan }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <label class="col form-text">Nik Karyawan</label>
                                                    <div class="col-sm">
                                                        <input class="form-control form-control-sm border-secondary"
                                                            type="text" name="nikKaryawan" id="nikKaryawan"
                                                            value="" readonly />
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <div class="col-sm">
                                                    <label class="col form-text">Divisi</label>
                                                    <div class="col-sm">
                                                        <input type="text"
                                                            class="form-control form-control-sm border-secondary"
                                                            name="divisi" id="divisi" value="" readonly />
                                                    </div>
                                                </div>

                                                <div class="col-sm">
                                                    <label class="col form-text">Departemen</label>
                                                    <div class="col-sm">
                                                        <input type="text"
                                                            class="form-control form-control-sm border-secondary"
                                                            name="departemen" id="departemen" value="" readonly />
                                                    </div>
                                                </div>


                                            </div>


                                            <div class="form-group row">

                                                <div class="col-sm ">
                                                    <label class="col form-text">Posisi</label>
                                                    <div class="col-sm">
                                                        <input type="text"
                                                            class="form-control form-control-sm border-secondary"
                                                            name="posisi" id="posisi" value="" readonly />
                                                    </div>
                                                </div>

                                                <div class="col-sm ">
                                                    <label class="col form-text">Branch</label>
                                                    <div class="col-sm">
                                                        <input type="text"
                                                            class="form-control form-control-sm border-secondary"
                                                            name="branch" id="branch" value="" readonly />
                                                    </div>
                                                </div>
                                            </div>

                                    </div>

                                    <div class="col">

                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <label class="col form-text">Nama Barang</label>
                                                    <div class="col-sm">
                                                        <select class="form-control form-control-sm border-secondary"
                                                            name="namaBarang" id="namaBarang">
                                                            <option value="">Pilih Aset/Barang</option>
                                                            @foreach ($asetOpt as $asetList)
                                                                <option value="{{ $asetList->nama_barang }}">
                                                                    {{ $asetList->nama_barang }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <label class="col form-text">Kode Aset | Kode GA</label>
                                                    <div class="col-sm">
                                                        <select class="form-control form-control-sm border-secondary"
                                                            name="kodeAset" id="kodeAset">
                                                            <option value="">Pilih Kode Aset & Kode GA</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <div class="col-sm">
                                                <label class="col form-text">Merk Barang</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary"
                                                        type="text" name="merkBarang" id="merkBarang" value=""
                                                        readonly />
                                                </div>
                                            </div>

                                            <div class="col">
                                                <label class="col form-text">Spesifikasi Barang</label>
                                                <div class="col-sm">
                                                    <textarea class="form-control form-control-sm border-secondary" type="text" name="spesifikasiBarang"
                                                        id="spesifikasiBarang" value="" readonly></textarea>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <div class="col-sm">
                                                <label class="col form-text">Kondisi Barang</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary"
                                                        name="kondisiBarang" id="kondisiBarang" value=""
                                                        readonly />
            
                                                </div>
                                            </div>

                                            <div class="col">
                                                <label class="col form-text">Jumlah Tersedia</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary"
                                                        type="text" name="jumlahTersedia" id="jumlahTersedia"
                                                        value="" readonly />
                                                </div>

                                            </div>

                                            <div class="col">
                                                <label class="col form-text">Satuan</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary"
                                                        type="text" name="satuanBarang" id="satuanBarang"
                                                        value="" readonly />

                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <label class="col form-text">Jumlah Distribusi</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary"
                                                        type="text" name="jumlahBarang" id="jumlahBarang"
                                                        value="{{ old('no_bpjs') }}" />
                                                </div>
                                            </div>

                                            <div class="col">
                                                <label class="col form-text">_________________________________</label>
                                                <div class="col-sm">
                                                    <button class="btn btn-success" id="tambahList">Tambah List
                                                        Distribusi</button>
                                                </div>
                                            </div>

                                            <div id="field_pinjam">
                                                <input type="hidden" name="asetPinjam" id="asetPinjam"
                                                    value="" />
                                                <input type="hidden" name="jmPinjam" id="jmPinjam" value="" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>


                <div class="form-group">

                    <div class="table-responsive">
                        <table class="table table-striped" id="tblPinjaman" cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr>
                                    {{-- <th>No</th> --}}
                                    {{-- <th hidden>id_barang</th> --}}
                                    <th>Nama Barang</th>
                                    <th>Merk Barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Kode Aset</th>
                                    <th>kode GA</th>
                                    <th>Kondisi</th>
                                    <th>Satuan</th>
                                    <th>Jml Distribusi</th>
                                    <th>Kategori</th>
                                    {{-- <th>Tgl Pengadaan</th> --}}
                                    {{-- <th>Foto Barang</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody id="listPinjaman" name="listPinjaman">


                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn  btn-primary" id="savePinjam">Save</button>
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal input baru --}}

    {{-- Modal View Detail --}}




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
        // var asetPinjam = "";
        // var jmPinjam = "";
        var i = 0;

        $('#tambahList').click(function(e) {
            e.preventDefault();

            var listTable = document.getElementById('listPinjaman');
            var lastRow = listTable.rows.length;
            var row = listTable.insertRow(lastRow);


            let idbr = $('#kodeAset').val();
            // let asetPinjam = $('#asetPinjam').val();
            // let jmPinjam = $('#jmPinjam').val();

            // console.log(idbr);

            // let listAset = "";

            $.ajax({
                type: "GET",
                url: "{{ route('getKodeList') }}",
                data: {
                    'idAset': idbr
                },
                success: function(getAset) {
                    ++i;

                    // if (asetPinjam == "") {
                    //     asetPinjam = $('#kodeAset').val();
                    // } else {
                    //     asetPinjam = asetPinjam + '|' + $('#kodeAset').val();
                    // };

                    // if (jmPinjam == "") {
                    //     jmPinjam = $('#jumlahBarang').val();
                    // } else {
                    //     jmPinjam = jmPinjam + '|' + $('#jumlahBarang').val();
                    // };

                    // $('#asetPinjam').val(asetPinjam);
                    // $('#jmPinjam').val(jmPinjam);

                    $.each(getAset, function(index, ls) {
                        $("#listPinjaman").append(
                            '<tr><td><input type="text" name="p_namaBarang[' + i +
                            ']" value="' + ls.nama_barang +
                            '" class="form-control form-control-sm" style="font-size: 12px" readonly/></td>' +
                            '<td><input type="text" name="p_namaBarang[' + i +
                            ']" value="' + ls.merk_barang +
                            '" class="form-control form-control-sm" style="font-size: 12px" readonly/></td>' +
                            '<td><input type="text" name="p_namaBarang[' + i +
                            ']" value="' + ls.spesifikasi +
                            '" class="form-control form-control-sm" style="font-size: 12px" readonly/></td>' +
                            '<td><input type="text" name="p_namaBarang[' + i +
                            ']" value="' + ls.kode_aset +
                            '" class="form-control form-control-sm" style="font-size: 12px" readonly/></td>' +
                            '<td><input type="text" name="p_namaBarang[' + i +
                            ']" value="' + ls.kode_ga +
                            '" class="form-control form-control-sm" style="font-size: 12px" readonly/></td>' +
                            '<td><input type="text" name="p_namaBarang[' + i +
                            ']" value="' + ls.kondisi +
                            '" class="form-control form-control-sm" style="font-size: 12px" readonly/></td>' +
                            '<td><input type="text" name="p_namaBarang[' + i +
                            ']" value="' + ls.satuan +
                            '" class="form-control form-control-sm" style="font-size: 12px" readonly/></td>' +
                            '<td><input type="text" name="p_namaBarang[' + i +
                            ']" value="' + $('#jumlahBarang').val() +
                            '" class="form-control form-control-sm" style="font-size: 12px" readonly/></td>' +
                            '<td><input type="text" name="p_namaBarang[' + i +
                            ']" value="' + ls.kategori +
                            '" class="form-control form-control-sm" style="font-size: 12px" readonly/></td>' +
                            '<td><button id="' + ls.id + '" type="button" value="' + ls.id +
                            '" onclick="deleteRow(event)" class="btn btn-outline-danger remove-input-field" style="font-size: 12px">X</button></td></tr>'
                        );

                        // $('#field_pinjam').append(

                        // '<input type="text" name="kAsetPinjam'+ i +'" value="'+ ls.id +'"/>' 
                        // );
                    });
                    clear();
                    updateList();
                }
            });






        });

        function updateList() {

            let asetPinjam = "";
            let jmPinjam = "";


            var x = 0;

            $('#listPinjaman tr').each(function(row, tr) {

                if ($(tr).find('td:eq(9) button').val() != undefined) {
                    if (asetPinjam == "") {
                        asetPinjam = $(tr).find('td:eq(9) button').val();
                    } else {
                        asetPinjam +=  '|' + $(tr).find('td:eq(9) button').val();
                    };

                    if (jmPinjam == "") {
                        jmPinjam = $(tr).find('td:eq(7) input').val();
                    } else {
                        jmPinjam += '|' + $(tr).find('td:eq(7) input').val();
                    };
                };




            });
            // asetPinjam.shift();
            // jumlah.shift();
            console.log(asetPinjam);

            $('#asetPinjam').val(asetPinjam);
            $('#jmPinjam').val(jmPinjam);
        }

        function deleteRow(event) {


            event.target.parentNode.parentNode.remove();
            updateList();
        }

        function clear() {
            $('#namaBarang').val("");
            $('#kodeAset').val("");
            $('#merkBarang').val("");
            $('#spesifikasiBarang').val("");
            $('#kondisiBarang').val("");
            $('#jumlahTersedia').val("");
            $('#satuanBarang').val("");
            $('#jumlahBarang').val("");
        }


        $('#idKaryawan').change(function() {

            let idk = $(this).val();
            let dtk = @json($karyawanOpt);
            let kry = dtk.find(i => i.id == idk);
            // let idb = lead.branch_id;


            // console.log(kry);
            $('#nikKaryawan').val(kry.nik_karyawan);
            $('#divisi').val(kry.divisi);
            $('#departemen').val(kry.departement);
            $('#posisi').val(kry.posisi);
            $('#branch').val(kry.nama_branch);

            // $('#branch').val(lead.nama_branch);
            // $('#posisi').val(lead.posisi);

        });

        $('#namaBarang').change(function() {

            let nmBr = $(this).val();
            // console.log($(this).val());

            let optKdAset = "<option value=''>Pilih Kode Aset & Kode GA</option>";

            $('#kodeAset').val("");
            $('#merkBarang').val("");
            $('#spesifikasiBarang').val("");
            $('#kondisiBarang').val("");
            $('#jumlahTersedia').val("");
            $('#satuanBarang').val("");

            // var dataList = $('#form-data').serialize();
            var ListIdAset = new Array();

            $('#listPinjaman tr').each(function(row, tr) {
                ListIdAset[row] = {
                    "id_Aset": $(tr).find('td:eq(9) button').val(),
                    // "jumlah": $(tr).find('td:eq(7)').text()

                }
            });
            ListIdAset.shift(); // first row will be empty - so remove

            // dataList += ListIdAset;
            // console.log(ListIdAset);


            $.ajax({
                type: "GET",
                url: "{{ route('getKodeAset') }}",
                data: {
                    'nama_barang': nmBr,
                    'idAset': ListIdAset
                },
                success: function(kodeAset) {
                    $.each(kodeAset, function(index, br) {
                        optKdAset += "<option value='" + br.id + "'>" + br.kode_aset + ' | ' +
                            br.kode_ga +
                            "</option>";
                    });
                    $('#kodeAset').html(optKdAset);
                }
            });

        });


        $('#kodeAset').change(function() {

            let kAset = $(this).val();
            console.log($(this).val());

            let optKdGa = "";
            let optMerk = "";
            let optSpeck = "";
            let optjml = "";
            let optsatuan = "";
            let optkondisi = "";

            $.ajax({
                type: "GET",
                url: "{{ route('getKodeGa') }}",
                data: {
                    'kode_aset': kAset
                },
                success: function(kodeGa) {
                    $.each(kodeGa, function(index, ga) {
                        // optKdGa += "<option value='" + ga.kode_ga + "'>" + ga.kode_ga + "</option>";

                        // optKdGa = ga.kode_ga
                        optMerk = ga.merk_barang
                        optSpeck = ga.spesifikasi
                        optjml = ga.jumlah
                        optsatuan = ga.satuan
                        optkondisi = ga.kondisi


                    });
                    // $('#kodeGa').val(optKdGa);
                    $('#merkBarang').val(optMerk);
                    $('#spesifikasiBarang').val(optSpeck);
                    $('#jumlahTersedia').val(optjml);
                    $('#satuanBarang').val(optsatuan);
                    $('#kondisiBarang').val(optkondisi);

                }
            });



        });

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
