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

                            <th>Tgl Pengembalian</th>
                            <th>Nama Karyawan</th>
                            <th>Branch</th>
                            <th>Nama Aset</th>
                            <th>Kode Aset</th>

                            <th>Satuan</th>
                            <th>Jml Distribusi</th>
                            <th>Kategori</th>
                            <th>Tgl Distribusi</th>
                            <th>Jml Kembali</th>
                            <th>Kondisi</th>
                            {{-- <th>Foto Barang</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>15-12-2023</td>
                            
                            <td>Muhammad Solkan</td>
                            <td>Jakarta Timur</td>
                            <td>Seragam Oxygen Hijau-L</td>
                            <td>SRGHL-2018-01</td>
                            <td>Pcs</td>
                            <td>1</td>
                            <td>Seragam</td>
                            <td>11-05-2018</td>
                            <td>1</td>
                            <td>Rusak</td>
                            <td>
                                {{-- <a href="#" class="btn btn-sm btn-primary edit-barang" > <i class="fas fa-edit"></i> Detail</a> --}}
                                <a href="#" class="btn btn-sm btn-primary edit-barang"> <i class="fas fa-edit"></i>
                                    Edit</a>
                            </td>

                        </tr>
                        <tr>
                            <td>2</td>
                            <td>15-12-2023</td>
                            
                            <td>Muhammad Solkan</td>
                            <td>Jakarta Timur</td>
                            <td>Seragam Oxygen Biru-L</td>
                            <td>SRGBL-2018-01	</td>
                            <td>Pcs</td>
                            <td>1</td>
                            <td>Seragam</td>
                            <td>11-05-2018</td>
                            <td>0</td>
                            <td>Hilang</td>
                            <td>
                                {{-- <a href="#" class="btn btn-sm btn-primary edit-barang" > <i class="fas fa-edit"></i> Detail</a> --}}
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Input Data Pengembalian Aset</h5>
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
                                        <form method="POST" enctype="multipart/form-data" id="form-data">
                                            @csrf

                                            @if ($errors->any())
                                                {{-- @foreach ($errors->all() as $err) --}}
                                                <p class="alert alert-danger">{{ $errors }}</p>
                                                {{-- @endforeach --}}
                                            @endif

                                            {{-- <form action="{{ route('customer.store') }}" method="POST"> --}}

                                            <div class="form-group row">

                                                <div class="col-sm">
                                                    <label class="col form-text">Nama Karyawan/PIC</label>
                                                    <div class="col-sm">
                                                        <select class="form-control form-control-sm border-secondary"
                                                            name="idKaryawan" id="idKaryawan">
                                                            <option value="Muhammad Sobar">Muhammad Sobar</option>
                                                            {{-- @foreach ($karyawanOpt as $karyawanList)
                                                                <option value="{{ $karyawanList->id }}">
                                                                    {{ $karyawanList->nama_karyawan }}
                                                                </option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- <div class="col">
                                                    <label class="col form-text">Tipe Peminjam</label>
                                                    <div class="col-sm">
                                                        <select class="form-control form-control-sm border-secondary"
                                                            name="peminjam">
                                                            <option value="">Pilih Tipe Peminjam</option>
                                                            <option value="Karyawan">Karyawan</option>
                                                            <option value="Tim">Tim</option>
                                                            <option value="Branch">Branch</option>

                                                        </select>
                                                    </div>
                                                </div> --}}

                                                <div class="col-sm">
                                                    <label class="col form-text">Tanggal Pengembalian/Serah Terima</label>
                                                    <div class="col-sm">
                                                        <input class="form-control form-control-sm border-secondary"
                                                            type="date" name="tglPinjam"
                                                            value="{{ old('tgl_pinjam') }}" />
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group row">


                                                <div class="col">
                                                    <label class="col form-text">Nik Karyawan</label>
                                                    <div class="col-sm">
                                                        <input class="form-control form-control-sm border-secondary"
                                                            type="text" name="nikKaryawan" id="nikKaryawan"
                                                            value="2017020034" />
                                                    </div>
                                                </div>

                                                <div class="col-sm">
                                                    <label class="col form-text">Departemen</label>
                                                    <div class="col-sm">
                                                        <input type="text"
                                                            class="form-control form-control-sm border-secondary"
                                                            name="departemen" id="departemen" value="FTTH" />
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">


                                                <div class="col ">
                                                    <label class="col form-text">Posisi</label>
                                                    <div class="col-sm">
                                                        <input type="text"
                                                            class="form-control form-control-sm border-secondary"
                                                            name="posisi" id="posisi" value="Leader Installer" />
                                                    </div>
                                                </div>

                                                <div class="col-sm ">
                                                    <label class="col form-text">Branch</label>
                                                    <div class="col-sm">
                                                        <input type="text"
                                                            class="form-control form-control-sm border-secondary"
                                                            name="branch" id="branch" value="Jakarta Selatan" />
                                                    </div>
                                                </div>
                                            </div>


                                    </div>

 
                                </div>

                            </div>
                            {{-- </div> --}}

                        </div>
                    </div>
                    <hr>
                    <div class="form-group">

                        <div class="table-responsive">
                            <table class="table table-striped" id="tblPinjaman" cellspacing="0" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        {{-- <th>No</th> --}}
                                        <th>Tgl Distribusi</th>
                                        <th>Nama Barang</th>
                                        <th>Merk Barang</th>
                                        <th>Spesifikasi</th>
                                        <th>Kode Aset</th>
                                        <th>Kategori</th>
                                        <th>Kondisi</th>
                                        <th>Satuan</th>
                                        <th>Jml Distribusi</th>
                                        <th>Jml kembali</th>
                                        <th>Status Barang</th>
                                        {{-- <th>Foto Barang</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="listPinjaman" name="listPinjaman">

                                    <tr>
                                        {{-- <td>1</td> --}}

                                        <td>11-05-2018</td>
                                        <td>Seragam Oxygen Hijau-L</td>
                                        <td>Oxygen</td>
                                        <td>Seragam Oxygen Hijau-L</td>
                                        <td>SRGHL-2018-03	</td>
                                        <td>Seragam</td>
                                        <td>Baru</td>
                                        <td>Pcs</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>Rusak</td>
                                        
                                        <td>
                                            {{-- <a href="#" class="btn btn-sm btn-primary edit-barang" > <i class="fas fa-edit"></i> Detail</a> --}}
                                            <a class="btn btn-sm btn-info form-text" data-toggle="modal" data-target="#md-pengembalian">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        {{-- <td>1</td> --}}

                                        <td>11-05-2018</td>
                                        <td>Seragam Oxygen Biru-L</td>
                                        <td>Oxygen</td>
                                        <td>Seragam Oxygen Biru-L</td>
                                        <td>SRGBL-2018-03</td>
                                        <td>Seragam</td>
                                        <td>Baru</td>
                                        <td>Pcs</td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td>Belum dikembalikan</td>
                                        
                                        <td>
                                            {{-- <a href="#" class="btn btn-sm btn-primary edit-barang" > <i class="fas fa-edit"></i> Detail</a> --}}
                                            <a href="#" class="btn btn-sm btn-primary md-pengembalian"> <i
                                                    class="fas fa-edit"></i>Input Pengembalian</a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>




                <div class="modal-footer">
                    <button class="btn  btn-primary" name="savePinjam" id="savePinjam">Save</button>
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>

                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal pengembalian --}}

    <div class="modal fade" id="md-pengembalian" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Pengembalian Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <hr>
                <div class="modal-body" id="bdy-edit-kelengkapan">
                    <div class="row">
                        <div class="col-sm-12">
                            {{-- <div class="card"> --}}
                            {{-- <div class="card-header">
                
                                </div> --}}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <form action="#" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            @if ($errors->any())
                                                {{-- @foreach ($errors->all() as $err) --}}
                                                <p class="alert alert-danger">{{ $errors }}</p>
                                                {{-- @endforeach --}}
                                            @endif

                                            {{-- <form action="{{ route('customer.store') }}" method="POST"> --}}


                                            <div class="form-group">
                                                <label class="col form-text">Tgl Distribusi</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary"
                                                        type="date" name="tglPinjam"
                                                        value="2018-05-11" />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Nama Aset</label>
                                                <div class="col-sm">
                                                    <input type="text"
                                                        class="form-control form-control-sm border-secondary"
                                                        name="namaBarangEdit" id="namaBarangEdit" value="Seragam Oxygen Hijal-L"
                                                        placeholder="Input Nama Barang" />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Merk Barang</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary"
                                                        type="text" name="merkBarangEdit" id="merkBarangEdit"
                                                        value="Oxygen" placeholder="Input Merk Barang" />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Kode Aset</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary"
                                                        type="text" name="kodeAsetEdit" id="kodeAsetEdit"
                                                        value="SRGHL-2018-03" placeholder="Input Kode Aset" />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Spesifikasi Barang</label>
                                                <div class="col-sm">
                                                    <textarea class="form-control form-control-sm border-secondary" type="text" name="spesifikasiEdit"
                                                        id="spesifikasiEdit" value="Seragam Oxygen Hijau-L">Seragam Oxygen Hijau-L</textarea>
                                                </div>
                                            </div>

                                            



                                            {{-- <div class="mb-3">
                                                    <button class="btn btn-primary">Save</button>
                                                    <a class="btn btn-danger" href="{{ route('employee.index') }}">Back</a>
                                                </div> --}}
                                            {{-- </form> --}}
                                    </div>

                                    <div class="col">

                                        

                                        <div class="form-group ">
                                            <label class="col form-text">Kondisi Barang</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary"
                                                    type="text" name="kodeAsetEdit" id="kodeAsetEdit"
                                                    value="Baru" placeholder="Input Kode Aset" />
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col form-text">Satuan Barang</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary"
                                                    type="text" name="kodeAsetEdit" id="kodeAsetEdit"
                                                    value="Pcs" placeholder="Input Kode Aset" />
                                            </div>
                                            
                                        </div>

                                        

                                        <div class="form-group ">
                                            <label class="col form-text">Jumlah Distribusi</label>
                                            <div class="col-sm">
                                                <input class="form-control form-control-sm border-secondary"
                                                    type="text" name="jumlahEdit" id="jumlahEdit"
                                                    value="1" placeholder="Input Jml Barang" />
                                            </div>
                                        </div>

                                        



                                        {{-- <div class="form-group">
                                                <label class="col form-text">Kelengkapan Karyawan</label>
                                                <div class="col">
                                                    <button type="button" class="btn  btn-info form-text"
                                                        data-toggle="modal" data-target="#md-input-kelengkapan">Input
                                                        Detail Kelengkapan Karyawan</button>
                                                </div>

                                            </div> --}}

                                    </div>

                                    <div class="col">
                                        <form action="#" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            @if ($errors->any())
                                                {{-- @foreach ($errors->all() as $err) --}}
                                                <p class="alert alert-danger">{{ $errors }}</p>
                                                {{-- @endforeach --}}
                                            @endif

                                            {{-- <form action="{{ route('customer.store') }}" method="POST"> --}}


                                            <div class="form-group">
                                                <label class="col form-text">Tgl Pengembalian</label>
                                                <div class="col-sm">
                                                    <input class="form-control form-control-sm border-secondary"
                                                        type="date" name="tglPinjam"
                                                        value="{{date('Y-m-d')}}" />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Jumlah Pengembalian</label>
                                                <div class="col-sm">
                                                    <input type="text"
                                                        class="form-control form-control-sm border-secondary"
                                                        name="namaBarangEdit" id="namaBarangEdit" value="1"
                                                        placeholder="Input Jumlah Pengembalian" />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Kondisi Barang</label>
                                                <div class="col-sm">
                                                    <select class="form-control form-control-sm border-secondary">
                                                    <option value="Baik">Baik</option>
                                                    <option value="Rusak">Rusak</option>
                                                    <option value="Hilang">Hilang</option>
                                                    </select>
                                                    <small class="form-text text-muted"><code>*Baik/Rusak/Hilang</code></small>
                                                </div>
                                                
                                            </div>

                                            <div class="form-group ">
                                                <label class="col form-text">Keterangan</label>
                                                <div class="col-sm">
                                                    <textarea class="form-control form-control-sm border-secondary" type="text" name="spesifikasiEdit"
                                                        id="spesifikasiEdit" value="">Sobek di bagian lengan</textarea>
                                                </div>
                                            </div>



                                            {{-- <div class="mb-3">
                                                    <button class="btn btn-primary">Save</button>
                                                    <a class="btn btn-danger" href="{{ route('employee.index') }}">Back</a>
                                                </div> --}}
                                            {{-- </form> --}}
                                    </div>


                                    {{-- Foto Karyawan --}}
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
                                                    name="foto_karyawan">
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
        $('#savePinjam').click(function(e) {

            e.preventDefault();

            // var listPinjam = $('#listPinjaman').find("tr").length;
            var data = $('#form-data').serialize();

            var TableData = new Array();

            $('#tblPinjaman tr').each(function(row, tr) {
                TableData[row] = {
                    "id_aset": $(tr).find('td:eq(8) button').val(),
                    "jumlah": $(tr).find('td:eq(6)').text()

                }
            });

            TableData.shift(); // first row will be empty - so remove

            data += TableData;
            console.log(data);
            console.log(TableData);

            $.ajax({

                type: 'post',
                url: "{{ route('peminjaman.store') }}",
                data: data
            });

        });

        // $('#tambahList').click(function(e) {
        //     e.preventDefault();

        //     let idbr = $('#namaBarang').val();

        //     let br = dtbr.find(i => i.id == idbr);


        //     var listTable = document.getElementById('listPinjaman');
        //     var lastRow = listTable.rows.length;
        //     var row = listTable.insertRow(lastRow);

        //     console.log(listTable);


        //     // alert(lastRow);
        //     // row.insertCell(0).setAttribute('id',"baris");

        //     // row.insertCell(0).innerHTML = lastRow;
        //     row.insertCell(0).innerHTML = br.nama_barang;
        //     row.insertCell(1).innerHTML = br.merk_barang;
        //     row.insertCell(2).innerHTML = br.spesifikasi;
        //     row.insertCell(3).innerHTML = br.kode_aset;
        //     row.insertCell(4).innerHTML = br.kondisi;
        //     row.insertCell(5).innerHTML = br.satuan
        //     row.insertCell(6).innerHTML = $('#jumlahBarang').val();
        //     row.insertCell(7).innerHTML = br.kategori;
        //     row.insertCell(8).innerHTML = '<td><button id="idAset" name="idAset" value="' + br.id +
        //         '" onclick="deleteRow(event)">x</button></td>'

        // });

        function deleteRow(event) {
            event.target.parentNode.parentNode.remove();
        }


        // $('#idKaryawan').change(function() {

        //     let idk = $(this).val();
        //  
        //     let kry = dtk.find(i => i.id == idk);
        //     // let idb = lead.branch_id;


        //     // console.log(kry);
        //     $('#nikKaryawan').val(kry.nik_karyawan);
        //     $('#departemen').val(kry.departement);
        //     $('#posisi').val(kry.posisi);
        //     $('#branch').val(kry.nama_branch);

        //     // $('#branch').val(lead.nama_branch);
        //     // $('#posisi').val(lead.posisi);

        // });

        // $('#namaBarang').change(function() {

        //     let idb = $(this).val();
        //     
        //     let brg = dtb.find(i => i.id == idb);
        //     // let idb = lead.branch_id;


        //     // console.log(brg);
        //     $('#kodeAset').val(brg.kode_aset);
        //     $('#merkBarang').val(brg.merk_barang);
        //     $('#spesifikasiBarang').val(brg.spesifikasi);
        //     $('#kondisiBarang').val(brg.kondisi);
        //     $('#satuanBarang').val(brg.satuan);
        //     $('#jumlahTersedia').val(brg.jumlah);

        // });

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
