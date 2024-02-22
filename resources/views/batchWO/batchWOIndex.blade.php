@extends('layout.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mt-2">Data Batch WO</h3>
                </div>


                <div class="card-body">

                    <div class="row">
                        <hr>
                        <div class="col-sm-4">
                            {{-- <form action="{{ route('batchwodata.data') }}" method="POST" enctype="multipart/form-data"> --}}
                            {{-- @csrf --}}
                            {{-- @method('GET') --}}

                            {{-- @method('GET') --}}
                            <div class="form-group">
                                <label>Batch WO</label>
                                {{-- <input type="text" class="form-control" placeholder="Pilih Batch WO"> --}}
                                <select class="form-control" name="batch_wo" id="batch_wo">
                                    <option value="">All</option>
                                    <option value="Batch 1">Batch 1</option>
                                    <option value="Batch 2">Batch 2</option>
                                    <option value="Batch 3">Batch 3</option>
                                    <option value="Batch 4">Batch 4</option>
                                    <option value="Batch 5">Batch 5</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label>Jenis WO</label>
                                {{-- <input type="text" class="form-control" placeholder="Pilih Jenis WO"> --}}
                                <select class="form-control" name="jenis_wo" id="jenis_wo">
                                    <option value="">All</option>
                                    <option value="FTTH New Installation">FTTH New Installation</option>
                                    <option value="FTTH Maintenance">FTTH Maintenance</option>
                                    <option value="Dismantle">Dismantle</option>
                                    <option value="FTTX New Installation">FTTX New Installation</option>
                                    <option value="FTTX Maintenance">FTTX Maintenance</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label>Tanggal IKR</label>
                                <input type="date" class="form-control" name="tgl_ikr" id="tgl_ikr">
                            </div>

                            {{-- <button type="submit" class="btn btn-primary">Cari</button> --}}
                            <button type="button" class="btn btn-primary" id="cari">cari</button>
                            {{-- <button type="button" class="btn  btn-primary" data-toggle="modal"
                                data-target="#md-edit-callsign">Large modal</button> --}}
                            {{-- </form> --}}
                        </div>
                        <div class="col-sm-4">
                            {{-- <form> --}}
                            <div class="form-group">
                                <label>Branch</label>
                                {{-- <input type="text" class="form-control" placeholder="Pilih Branch"> --}}
                                <select class="form-control" name="branch" id="branch">
                                    <option value="">All</option>
                                    <option value="Jakarta Timur">Jakarta Timur</option>
                                    <option value="Jakarta Selatan">Jakarta Selatan</option>
                                    <option value="Bekasi">Bekasi</option>
                                    <option value="Bogor">Bogor</option>
                                    <option value="Tangerang">Tangerang</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Pilih Area</label>
                                <select class="form-control" name="area_fat" id="area_fat">
                                    <option value="">All</option>
                                    <option value="Jakarta Selatan">Jakarta Selatan</option>
                                    <option value="Jakarta Pusat">Jakarta Pusat</option>
                                    <option value="Jakarta Utara">Jakarta Utara</option>
                                    <option value="Jakarta Barat">Jakarta Barat</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Pilih Callsign</label>
                                <select class="form-control" name="callsign" id="callsign">
                                    <option value="">All</option>
                                    <option value="JKTMST001">JKTMST001</option>
                                    <option value="JKTMST002">JKTMST002</option>
                                    <option value="JKTMST003">JKTMST003</option>
                                    <option value="JKTMST004">JKTMST004</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>No WO</label>
                                <input type="text" class="form-control" placeholder="All" name="no_wo" id="no_wo">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">ID Customer</label>
                                <input type="text" class="form-control" placeholder="All" name="cust_id" id="cust_id">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <hr>

                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped fixed" id="data-wo">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Batch WO</th>
                                        <th>Tanggal IKR</th>
                                        <th>Jenis WO</th>
                                        <th>No WO</th>
                                        <th>No Ticket</th>
                                        <th>WO Date</th>
                                        <th>Cust ID</th>
                                        <th>Cust Name</th>
                                        <th>FAT Code</th>
                                        <th>Cluster</th>
                                        <th>Area_Fat</th>
                                        <th>Branch</th>
                                        <th>Callsign</th>
                                        <th>Teknisi 1</th>
                                        <th>Teknisi 2</th>
                                        <th>Teknisi 3</th>
                                        <th>Teknisi 4</th>
                                        <th>Cust Phone</th>
                                        <th>Cust Mobile</th>
                                        <th style="width: inherit">Address</th>

                                        <th>WO Type</th>

                                        <th>FAT Port</th>
                                        <th>Remarks</th>
                                        <th>Vendor Installation</th>
                                        <th>IKR Date</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>


                                </thead>
                                <tfoot>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="md-edit-callsign" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="frm-edit-callsign" action="{{ route('batchWO.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title h4" id="myLargeModalLabel">Edit Data WO</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body" id="bdy-edit-callsign">

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">Tanggal IKR:</label>
                                        <input type="text" class="form-control form-control-sm" id="TglIkrEdit"
                                            value="" name="tglIkrEdit">
                                    </div>
                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">No WO:</label>
                                        <input type="text" class="form-control form-control-sm" id="noWoEdit"
                                        value="" name="noWoEdit">
                                    </div>
                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">Cust ID:</label>
                                        <input type="text" class="form-control form-control-sm" id="custIdEdit"
                                        value="" name="custIdEdit">
                                    </div>
                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">Cust Name:</label>
                                        <input type="text" class="form-control form-control-sm" id="CustNameEdit"
                                        value="" name="CustNameEdit">
                                    </div>
                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">FAT Code:</label>
                                        <input type="text" class="form-control form-control-sm" id="FatCodeEdit"
                                        value="" name="FatCodeEdit">
                                    </div>
                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">Jenis WO:</label>
                                        <input type="text" class="form-control form-control-sm" id="JenisWoEdit"
                                        value="" name="JenisWoEdit">
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="noWoEdit" class="col-form-label">Slot
                                            Time:</label>
                                        <select class="form-control form-control-sm" id="slottimeEdit" value="" name="slottimeEdit">
                                            <option value="09:00:00">09:00</option>
                                            <option value="09:30:00">09:30</option>
                                            <option value="10:00:00">10:00</option>
                                            <option value="10:30:00">10:30</option>
                                            <option value="11:00:00">11:00</option>
                                            <option value="11:30:00">11:30</option>
                                            <option value="12:00:00">12:00</option>
                                            <option value="12:30:00">12:30</option>
                                            <option value="13:00:00">13:00</option>
                                            <option value="13:30:00">13:30</option>
                                            <option value="14:00:00">14:00</option>
                                            <option value="14:30:00">14:30</option>
                                            <option value="15:00:00">15:00</option>
                                            <option value="15:30:00">15:30</option>
                                            <option value="16:00:00">16:00</option>
                                            <option value="16:30:00">16:30</option>
                                            <option value="17:00:00">17:00</option>
                                            <option value="17:30:00">17:30</option>
                                            <option value="18:00:00">18:00</option>
                                            <option value="18:30:00">18:30</option>
                                            <option value="19:00:00">19:00</option>
                                            <option value="19:30:00">19:30</option>
                                            <option value="20:00:00">20:00</option>
                                            <option value="20:30:00">20:30</option>
                                            <option value="21:00:00">21:00</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="noWoEdit"class="col-form-label">Callsign:</label>
                                        <select class="form-control form-control-sm" id="callsignEdit" value="" name="callsignEdit">
                                            <option value="JKTMST001">JKTMST001</option>
                                            <option value="JKTMST002">JKTMST002</option>
                                            <option value="JKTMST003">JKTMST003</option>
                                            <option value="JKTMST004">JKTMST004</option>
                                            <option value="JKTMST005">JKTMST005</option>
                                            <option value="BKSMST004">BKSMST001</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">Teknisi 1:</label>
                                        <select class="form-control form-control-sm" id="teknisi1Edit" value="" name="teknisi1Edit">
                                            {{-- <option value="">Pilih Teknisi 1</option> --}}
                                            
                                            <option value="Satria Adhin J. Lubis">Satria Adhin J. Lubis</option>
                                            <option value="Fajar Cahyono">Fajar Cahyono</option>
                                            <option value="Daniel Christopher">Daniel Christopher</option>
                                            <option value="Zulfin Ramadhan Simanjuntak">Zulfin Ramadhan Simanjuntak</option>
                                            <option value="Achmad Fadilla Syah">Achmad Fadilla Syah</option>
                                            <option value="Denis Setiawan">Denis Setiawan</option>
                                            <option value="Zaki Maulana">Zaki Maulana</option>
                                            <option value="Yohanes Paskalis Ndori">Yohanes Paskalis Ndori</option>
                                            <option value="Uga">Uga</option>
                                            <option value="Khoirul Rozak">Khoirul Rozak</option>
                                            <option value="Rama Alfiwansyah">Rama Alfiwansyah</option>
                                            <option value="Muhamad Rizal Fariq">Muhamad Rizal Fariq</option>
                                            <option value="Andi Topan">Andi Topan</option>
                                            <option value="Aldi Ruslan">Aldi Ruslan</option>
                                            <option value="Syaiful Ogi Hekmatiar">Syaiful Ogi Hekmatiar</option>
                                            <option value="Akbar Kharisma Saragih">Akbar Kharisma Saragih</option>
                                            <option value="Rafli Fahreza">Rafli Fahreza</option>
                                            <option value="Muhammad Fauzan Nurrasyid">Muhammad Fauzan Nurrasyid</option>
                                            <option value="Sultan Yoga Permana">Sultan Yoga Permana</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">Teknisi 2:</label>
                                        <select class="form-control form-control-sm" id="teknisi2Edit" value="" name="teknisi2Edit">
                                            {{-- <option value="">Pilih Teknisi 2</option> --}}
                                            <option value="Satria Adhin J. Lubis">Satria Adhin J. Lubis</option>
                                            <option value="Fajar Cahyono">Fajar Cahyono</option>
                                            <option value="Daniel Christopher">Daniel Christopher</option>
                                            <option value="Zulfin Ramadhan Simanjuntak">Zulfin Ramadhan Simanjuntak</option>
                                            <option value="Achmad Fadilla Syah">Achmad Fadilla Syah</option>
                                            <option value="Denis Setiawan">Denis Setiawan</option>
                                            <option value="Zaki Maulana">Zaki Maulana</option>
                                            <option value="Yohanes Paskalis Ndori">Yohanes Paskalis Ndori</option>
                                            <option value="Uga">Uga</option>
                                            <option value="Khoirul Rozak">Khoirul Rozak</option>
                                            <option value="Rama Alfiwansyah">Rama Alfiwansyah</option>
                                            <option value="Muhamad Rizal Fariq">Muhamad Rizal Fariq</option>
                                            <option value="Andi Topan">Andi Topan</option>
                                            <option value="Aldi Ruslan">Aldi Ruslan</option>
                                            <option value="Syaiful Ogi Hekmatiar">Syaiful Ogi Hekmatiar</option>
                                            <option value="Akbar Kharisma Saragih">Akbar Kharisma Saragih</option>
                                            <option value="Rafli Fahreza">Rafli Fahreza</option>
                                            <option value="Muhammad Fauzan Nurrasyid">Muhammad Fauzan Nurrasyid</option>
                                            <option value="Sultan Yoga Permana">Sultan Yoga Permana</option>
                                            

                                            
                                            {{-- @foreach ($teknisiList as $teknisi)
                                                <option value="{{ $teknisi->id }}">{{ $teknisi->nama_karyawan }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">Teknisi 3:</label>
                                        <select class="form-control form-control-sm" id="teknisi3Edit" value="" name="teknisi3Edit">
                                            {{-- <option value="">Pilih Teknisi 3</option> --}}
                                            <option value="Satria Adhin J. Lubis">Satria Adhin J. Lubis</option>
                                            <option value="Fajar Cahyono">Fajar Cahyono</option>
                                            <option value="Daniel Christopher">Daniel Christopher</option>
                                            <option value="Zulfin Ramadhan Simanjuntak">Zulfin Ramadhan Simanjuntak</option>
                                            <option value="Achmad Fadilla Syah">Achmad Fadilla Syah</option>
                                            <option value="Denis Setiawan">Denis Setiawan</option>
                                            <option value="Zaki Maulana">Zaki Maulana</option>
                                            <option value="Yohanes Paskalis Ndori">Yohanes Paskalis Ndori</option>
                                            <option value="Uga">Uga</option>
                                            <option value="Khoirul Rozak">Khoirul Rozak</option>
                                            <option value="Rama Alfiwansyah">Rama Alfiwansyah</option>
                                            <option value="Muhamad Rizal Fariq">Muhamad Rizal Fariq</option>
                                            <option value="Andi Topan">Andi Topan</option>
                                            <option value="Aldi Ruslan">Aldi Ruslan</option>
                                            <option value="Syaiful Ogi Hekmatiar">Syaiful Ogi Hekmatiar</option>
                                            <option value="Akbar Kharisma Saragih">Akbar Kharisma Saragih</option>
                                            <option value="Rafli Fahreza">Rafli Fahreza</option>
                                            <option value="Muhammad Fauzan Nurrasyid">Muhammad Fauzan Nurrasyid</option>
                                            <option value="Sultan Yoga Permana">Sultan Yoga Permana</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">Teknisi 4:</label>
                                        <select class="form-control form-control-sm" id="teknisi4Edit" value="" name="teknisi4Edit">
                                            {{-- <option value="">Pilih Teknisi 4</option> --}}
                                            <option value="Satria Adhin J. Lubis">Satria Adhin J. Lubis</option>
                                            <option value="Fajar Cahyono">Fajar Cahyono</option>
                                            <option value="Daniel Christopher">Daniel Christopher</option>
                                            <option value="Zulfin Ramadhan Simanjuntak">Zulfin Ramadhan Simanjuntak</option>
                                            <option value="Achmad Fadilla Syah">Achmad Fadilla Syah</option>
                                            <option value="Denis Setiawan">Denis Setiawan</option>
                                            <option value="Zaki Maulana">Zaki Maulana</option>
                                            <option value="Yohanes Paskalis Ndori">Yohanes Paskalis Ndori</option>
                                            <option value="Uga">Uga</option>
                                            <option value="Khoirul Rozak">Khoirul Rozak</option>
                                            <option value="Rama Alfiwansyah">Rama Alfiwansyah</option>
                                            <option value="Muhamad Rizal Fariq">Muhamad Rizal Fariq</option>
                                            <option value="Andi Topan">Andi Topan</option>
                                            <option value="Aldi Ruslan">Aldi Ruslan</option>
                                            <option value="Syaiful Ogi Hekmatiar">Syaiful Ogi Hekmatiar</option>
                                            <option value="Akbar Kharisma Saragih">Akbar Kharisma Saragih</option>
                                            <option value="Rafli Fahreza">Rafli Fahreza</option>
                                            <option value="Muhammad Fauzan Nurrasyid">Muhammad Fauzan Nurrasyid</option>
                                            <option value="Sultan Yoga Permana">Sultan Yoga Permana</option>
                                        </select>
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
        <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.js"></script>

        <script type="text/javascript">
            // $('#data-wo tfoot .th').each(function() {
            //     var title = $(this).text();
            //     $(this).html('<input type="text" class="form-control shadow" placeholder="search" name="' +
            //         title + '" id="search' + title + '"/>');
            // });


            // $(document).on('click', '.test', function() {

            // $('.test').on('click', function() {
            //     // batch_wo = $('#batch_wo').val()
            //     // console.log(batch_wo)



            //     $('#searchBatch_WO').val($('#batch_wo').val())
            //     $('#searchTanggal_IKR').val($('#tgl_ikr').val())
            //     $('#searchJenis_WO').val($('#jenis_wo').val())
            //     $('#searchBranch').val($('#branch').val())
            //     $('#searchArea_Fat').val($('#area').val())
            //     $('#searchCallsign').val($('#callsign').val())
            //     $('#searchNo_WO').val($('#no_wo').val())
            //     $('#searchCust_ID').val($('#cust_id').val())

            //     getData()

            // });


            $(document).ready(function() {

                getData()

                $('#cari').on('click', function(e) {
                    e.preventDefault();
                    getData();
                });

                function getData() {

                    let batch_wo = $('#batch_wo').val();
                    let jenis_wo = $('#jenis_wo').val();
                    let tgl_ikr = $('#tgl_ikr').val();
                    let branch = $('#branch').val();
                    let area_fat = $('#area_fat').val();
                    let callsign = $('#callsign').val();
                    let no_wo = $('#no_wo').val();
                    let cust_id = $('#cust_id').val()

                    // console.log(branch)
                    // $(function() {

                    var table = $('#data-wo').DataTable({

                        fixedColumns: true,

                        fixedColumns: {
                            leftColumns: 5,
                            rightColumns: 1
                        },
                        // autoWidth: false,
                        responsive: true,
                        scrollCollapse: true,
                        scrollX: true,
                        scrollY: true,
                        scrollCollapse: true,
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
                            url: "{{ route('batchwodata.data') }}",
                            type: "GET",
                            dataType: "JSON",
                            data: {
                                batch_wo: batch_wo,
                                jenis_wo: jenis_wo,
                                tgl_ikr: tgl_ikr,
                                branch: branch,
                                area_fat: area_fat,
                                callsign: callsign,
                                no_wo: no_wo,
                                cust_id: cust_id,
                            }

                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_Row_Index',
                                // "className": "text-center",
                                // orderable: false, 
                                // searchable: false,


                            },
                            {
                                data: 'batch_wo',
                                // name: 'cbatch_wo',
                                searchable: true,



                            },
                            {
                                data: 'tgl_ikr'

                            },
                            {
                                data: 'jenis_wo',
                                searchable: true,

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
                                data: 'fat_code'

                            },
                            {
                                data: 'clusterFat'

                            },
                            {
                                data: 'areaFat'

                            },
                            {
                                data: 'nama_branch'

                            },
                            {
                                data: 'callsign'

                            },
                            {
                                data: 'teknisi1'

                            },
                            {
                                data: 'teknisi2'

                            },
                            {
                                data: 'teknisi3'

                            },
                            {
                                data: 'teknisi4'

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
                                data: 'wo_type'

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
                            {
                                data: 'action',
                                // "className": "text-center",
                                // orderable: false,
                                // searchable: false

                            }

                        ],
                        // initComplete: function() {
                        //     this.api()
                        //         .columns()
                        //         .every(function() {
                        //             var that = this;
                        //             // $('input', this.footer()).on('keyup change clear',
                        //             $('input', this.footer()).on('keyup click change clear',
                        //                 function() {
                        //                     if (that.search() !== this.value) {
                        //                         that.search(this.value).draw();
                        //                     }
                        //                 });
                        //         });
                        // }





                        // });

                        // }


                    });

                    $('#data-wo tbody').on('click', '.edit-callsign', function() {
                        var data = table.row($(this).parents('tr')).data();


                        console.log(data);

                        $('#TglIkrEdit').val(data.tgl_ikr)
                        $('#noWoEdit').val(data.wo_no)
                        $('#custIdEdit').val(data.cust_id)
                        $('#CustNameEdit').val(data.name)
                        $('#FatCodeEdit').val(data.fat_code)
                        $('#JenisWoEdit').val(data.jenis_wo)
                        $('#slottimeEdit').val(data.slot_time)
                        $('#callsignEdit').val(data.callsign)
                        $('#teknisi1Edit').val(data.teknisi1)
                        $('#teknisi2Edit').val(data.teknisi2)
                        $('#teknisi3Edit').val(data.teknisi3)
                        $('#teknisi4Edit').val(data.teknisi4)
                        



                        // $('#bdy-edit-callsign').empty();
                        let body = '<div class="row">' +
                            '<div class="col-sm-6">' +
                            '<form id="frm-edit-callsign">' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">Tanggal IKR:</label>' +
                            '<input type="text" class="form-control form-control-sm" id="TglIkrEdit" value="' +
                            data.tgl_ikr + '">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">No WO:</label>' +
                            '<input type="text" class="form-control form-control-sm" id="noWoEdit" value="' +
                            data.wo_no + '">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">Cust ID:</label>' +
                            '<input type="text" class="form-control form-control-sm" id="custIdEdit" value="' +
                            data.cust_id + '">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">Cust Name:</label>' +
                            '<input type="text" class="form-control form-control-sm" id="CustNameEdit" value="' +
                            data.name + '">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">FAT Code:</label>' +
                            '<input type="text" class="form-control form-control-sm" id="FatCodeEdit" value="' +
                            data.fat_code + '">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">Jenis WO:</label>' +
                            '<input type="text" class="form-control form-control-sm" id="JenisWoEdit" value="' +
                            data.jenis_wo + '">' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-sm-6">' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">Slot Time:</label>' +
                            '<select class="form-control form-control-sm" id="slottimeEdit" value="">' +
                            '<option value="09:00">09:00</option>' +
                            '<option value="09:30">09:30</option>' +
                            '<option value="10:00">10:00</option>' +
                            '<option value="10:30">10:30</option>' +
                            '<option value="11:00">11:00</option>' +
                            '<option value="11:30">11:30</option>' +
                            '<option value="12:00">12:00</option>' +
                            '<option value="12:30">12:30</option>' +
                            '<option value="13:00">13:00</option>' +
                            '<option value="13:30">13:30</option>' +
                            '<option value="14:00">14:00</option>' +
                            '<option value="14:30">14:30</option>' +
                            '<option value="15:00">15:00</option>' +
                            '<option value="15:30">15:30</option>' +
                            '<option value="16:00">16:00</option>' +
                            '<option value="16:30">16:30</option>' +
                            '<option value="17:00">17:00</option>' +
                            '<option value="17:30">17:30</option>' +
                            '<option value="18:00">18:00</option>' +
                            '<option value="18:30">18:30</option>' +
                            '<option value="19:00">19:00</option>' +
                            '<option value="19:30">19:30</option>' +
                            '<option value="20:00">20:00</option>' +
                            '<option value="20:30">20:30</option>' +
                            '<option value="21:00">21:00</option>' +
                            '</select>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">Callsign:</label>' +
                            '<select class="form-control form-control-sm" id="callsignEdit" value="' + data
                            .callsign + '">' +
                            '<option value="JKTMST001">JKTMST001</option>' +
                            '<option value="JKTMST002">JKTMST002</option>' +
                            '<option value="JKTMST003">JKTMST003</option>' +
                            '<option value="JKTMST004">JKTMST004</option>' +
                            '</select>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">Teknisi 1:</label>' +
                            '<input type="text" class="form-control form-control-sm" id="teknisi1Edit" value="' +
                            data.teknisi1 + '">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">Teknisi 2:</label>' +
                            '<input type="text" class="form-control form-control-sm" id="teknisi2Edit" value="' +
                            data.teknisi2 + '">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">Teknisi 3:</label>' +
                            '<input type="text" class="form-control form-control-sm" id="teknisi3Edit" value="' +
                            data.teknisi3 + '">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label for="noWoEdit" class="col-form-label">Teknisi 4:</label>' +
                            '<input type="text" class="form-control form-control-sm" id="teknisi4Edit" value="' +
                            data.teknisi4 + '">' +
                            '</div>'
                        '</div>' +
                        '</form>' +

                        '</div>';

                        // $('#bdy-edit-callsign').append(body);

                        $('#md-edit-callsign').modal('show');



                        // alert(data.batch_wo + "'s salary is: " + data.callsign);
                    });

                    // });
                }




            });
        </script>
    @endsection
