@extends('layout.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mt-2">Monitoring Work Order</h3>
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
                                <label class="col-form-label col-form-label-sm">Tanggal IKR</label>
                                <input type="date" class="form-control form-control-sm" name="tgl_ikr" id="tgl_ikr">
                                {{-- <input type="text" class="form-control form-control-sm" name="tgl_ikr" id="dateFilter" value=""> --}}
                            </div>

                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm">Batch WO</label>
                                {{-- <input type="text" class="form-control" placeholder="Pilih Batch WO"> --}}
                                <select class="form-control form-control-sm" name="batch_wo" id="batch_wo">
                                    <option value="">All</option>
                                    <option value="Batch 1">Batch 1</option>
                                    <option value="Batch 2">Batch 2</option>
                                    <option value="Batch 3">Batch 3</option>
                                    <option value="Batch 4">Batch 4</option>
                                    <option value="Batch 5">Batch 5</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm">Status WO</label>
                                <select class="form-control form-control-sm" name="status_wo" id="status_wo">
                                    <option value="">All</option>
                                    <option value="Done">Done</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Cancel">Cancel</option>
                                    <option value="<blank>">-Blank-</option>

                                </select>

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
                                <label class="col-form-label col-form-label-sm">Branch</label>
                                {{-- <input type="text" class="form-control" placeholder="Pilih Branch"> --}}
                                <select class="form-control form-control-sm" name="branch" id="branch">
                                    <option value="">All</option>
                                    <option value="Jakarta Timur">Jakarta Timur</option>
                                    <option value="Jakarta Selatan">Jakarta Selatan</option>
                                    <option value="Bekasi">Bekasi</option>
                                    <option value="Bogor">Bogor</option>
                                    <option value="Tangerang">Tangerang</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm">Pilih Area</label>
                                <select class="form-control form-control-sm" name="area_fat" id="area_fat">
                                    <option value="">All</option>
                                    <option value="Jakarta Selatan">Jakarta Selatan</option>
                                    <option value="Jakarta Pusat">Jakarta Pusat</option>
                                    <option value="Jakarta Utara">Jakarta Utara</option>
                                    <option value="Jakarta Barat">Jakarta Barat</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm">Pilih Callsign</label>
                                <select class="form-control form-control-sm" name="callsign" id="callsign">
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
                                <label class="col-form-label col-form-label-sm">No WO</label>
                                <input type="text" class="form-control form-control-sm" placeholder="All" name="no_wo"
                                    id="no_wo">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm">ID Customer</label>
                                <input type="text" class="form-control form-control-sm" placeholder="All" name="cust_id"
                                    id="cust_id">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <hr>

                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped fixed" id="data-wo" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No WO</th>
                                        <th>WO Date</th>
                                        <th>No Ticket</th>
                                        <th>Cust ID</th>
                                        <th>Cust Name</th>
                                        <th>FAT Code</th>
                                        <th>cluster</th>
                                        <th>Kotamadya</th>
                                        <th>Branch</th>
                                        <th>Tanggal IKR</th>
                                        <th>Slot Time</th>
                                        <th>Batch WO</th>
                                        <th>Remark Traffic</th>
                                        <th>Callsign</th>
                                        <th>Leader</th>
                                        <th>Teknisi 1</th>
                                        <th>Teknisi 2</th>
                                        <th>Teknisi 3</th>
                                        <th>Teknisi 4</th>
                                        <th>Status WO</th>
                                        <th>Couse Code</th>
                                        <th>Root Couse</th>
                                        <th>Action Taken</th>
                                        <th>Tanggal Resechedule</th>
                                        <th>Remark Status Precon</th>
                                        <th>Remark Status Migrasi</th>
                                        <th>start IKR</th>
                                        <th>End IKR</th>
                                        <th>Checkin APK</th>
                                        <th>Checkout APK</th>
                                        <th>Status APK</th>
                                        <th>Cuaca</th>
                                        <th>ONT Out</th>
                                        <th>ONT Out SN</th>
                                        <th>ONT Out MAC</th>
                                        <th>ONT In</th>
                                        <th>ONT In SN</th>
                                        <th>ONT In MAC</th>
                                        <th>STB Out</th>
                                        <th>STB Out SN</th>
                                        <th>STB Out MAC</th>
                                        <th>STB In</th>
                                        <th>STB In SN</th>
                                        <th>STB In MAC</th>
                                        <th>Router Out</th>
                                        <th>Router Out SN</th>
                                        <th>Router Out MAC</th>
                                        <th>Router In</th>
                                        <th>Router In SN</th>
                                        <th>Router In MAC</th>
                                        <th>Cable Precon Out</th>
                                        <th>Cable Precon Bad</th>
                                        <th>Cable DW Out</th>
                                        <th>Fast Connector</th>
                                        <th>Patchcord</th>
                                        <th>Terminal Box</th>
                                        <th>Remote</th>
                                        <th>Adaptor</th>
                                        <th>Report WA</th>
                                        <th>Konfirmasi Cst</th>
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
            <div class="modal-dialog modal-lg mw-100" role="document">
                <div class="modal-content">
                    <form id="frm-edit-callsign" action="{{ route('batchWO.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title h4" id="myLargeModalLabel">Edit Data Monitoring WO Maintenance</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body" id="bdy-edit-callsign">

                            <div class="row">

                                <div class="col-sm-3">

                                    <div class="form-group">
                                        <small class="form-text">Tanggal IKR:</small>
                                        <input type="text" class="form-control form-control-sm" id="TglIkrEdit"
                                            value="" name="tglIkrEdit">
                                    </div>
                                    <div class="form-group">
                                        <small class="form-text">No WO:</small>
                                        <input type="text" class="form-control form-control-sm" id="noWoEdit"
                                            value="" name="noWoEdit">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <small class="form-text">Cust ID:</small>
                                            <input type="text" class="form-control form-control-sm" id="custIdEdit"
                                                value="" name="custIdEdit">
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Cust Name:</small>
                                            <input type="text" class="form-control form-control-sm" id="CustNameEdit"
                                                value="" name="CustNameEdit">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Remark Traffic</small>
                                        <input type="text" class="form-control form-control-sm" id="remarkTrafficEdit"
                                            value="" name="remarkTrafficEdit">
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Slot
                                            Time:</small>
                                        <select class="form-control form-control-sm" id="slottimeEdit" value=""
                                            name="slottimeEdit">
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
                                        <small class="form-text">Callsign:</small>
                                        <select class="form-control form-control-sm" id="callsignEdit" value=""
                                            name="callsignEdit">
                                            <option value="JKTMST001">JKTMST001</option>
                                            <option value="JKTMST002">JKTMST002</option>
                                            <option value="JKTMST003">JKTMST003</option>
                                            <option value="JKTMST004">JKTMST004</option>
                                            <option value="JKTMST005">JKTMST005</option>
                                            <option value="BKSMST004">BKSMST001</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Leader</small>
                                        <input type="text" class="form-control form-control-sm" id="leaderEdit"
                                            value="" name="leaderEdit">
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="noWoEdit" class="col-form-label">Jenis WO:</label>
                                        <input type="text" class="form-control form-control-sm" id="JenisWoEdit"
                                        value="" name="JenisWoEdit">
                                    </div> --}}

                                    <div class="form-group">
                                        <small class="form-text">Teknisi 1:</small>
                                        <select class="form-control form-control-sm" id="teknisi1Edit" value=""
                                            name="teknisi1Edit">
                                            {{-- <option value="">Pilih Teknisi 1</option> --}}

                                            <option value="Satria Adhin J. Lubis">Satria Adhin J. Lubis</option>
                                            <option value="Fajar Cahyono">Fajar Cahyono</option>
                                            <option value="Daniel Christopher">Daniel Christopher</option>
                                            <option value="Zulfin Ramadhan Simanjuntak">Zulfin Ramadhan Simanjuntak
                                            </option>
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
                                        <small class="form-text">Teknisi 2:</small>
                                        <select class="form-control form-control-sm" id="teknisi2Edit" value=""
                                            name="teknisi2Edit">
                                            {{-- <option value="">Pilih Teknisi 2</option> --}}
                                            <option value="Satria Adhin J. Lubis">Satria Adhin J. Lubis</option>
                                            <option value="Fajar Cahyono">Fajar Cahyono</option>
                                            <option value="Daniel Christopher">Daniel Christopher</option>
                                            <option value="Zulfin Ramadhan Simanjuntak">Zulfin Ramadhan Simanjuntak
                                            </option>
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
                                        <small class="form-text">Teknisi 3:</small>
                                        <select class="form-control form-control-sm" id="teknisi3Edit" value=""
                                            name="teknisi3Edit">
                                            {{-- <option value="">Pilih Teknisi 3</option> --}}
                                            <option value="Satria Adhin J. Lubis">Satria Adhin J. Lubis</option>
                                            <option value="Fajar Cahyono">Fajar Cahyono</option>
                                            <option value="Daniel Christopher">Daniel Christopher</option>
                                            <option value="Zulfin Ramadhan Simanjuntak">Zulfin Ramadhan Simanjuntak
                                            </option>
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
                                        <small class="form-text">Teknisi 4:</small>
                                        <select class="form-control form-control-sm" id="teknisi4Edit" value=""
                                            name="teknisi4Edit">
                                            {{-- <option value="">Pilih Teknisi 4</option> --}}
                                            <option value="Satria Adhin J. Lubis">Satria Adhin J. Lubis</option>
                                            <option value="Fajar Cahyono">Fajar Cahyono</option>
                                            <option value="Daniel Christopher">Daniel Christopher</option>
                                            <option value="Zulfin Ramadhan Simanjuntak">Zulfin Ramadhan Simanjuntak
                                            </option>
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
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <small class="form-text">Status WO:</small>
                                        <select class="form-control form-control-sm" id="statusWoEdit" value=""
                                            name="statusWoEdit">
                                            <option value="On Progress">On Progress</option>
                                            <option value="Done">Done</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Cancel">Cancel</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <small class="form-text">Couse Code:</small>
                                        <select class="form-control form-control-sm" id="couseCodeEdit" value=""
                                            name="couseCodeEdit">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <small class="form-text">Root Couse:</small>
                                        <select class="form-control form-control-sm" id="rootCouseEdit" value=""
                                            name="rootCouseEdit">
                                            <option value=""></option>
                                            {{-- <option value="">Pilih Teknisi 1</option> --}}


                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <small class="form-text">Action Taken:</small>
                                        <select class="form-control form-control-sm" id="actionTakenEdit" value=""
                                            name="actionTakenEdit">
                                            <option value=""></option>
                                            {{-- <option value="">Pilih Teknisi 2</option> --}}

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <small class="form-text">Tanggal Reschedule</small>
                                        <input type="date" class="form-control form-control-sm" id="tglRescheduleEdit"
                                            value="" name="tglRescheduleEdit">

                                    </div>
                                    <div class="form-group">
                                        <small class="form-text">Remark DW / Precon Customer</small>
                                        <select class="form-control form-control-sm" id="remarkPreconEdit" value=""
                                            name="remarkPreconEdit">
                                            {{-- <option value="">Pilih Teknisi 4</option> --}}
                                            <option value="Sudah Precon">Sudah Precon</option>
                                            <option value="Belum Precon">Belum Precon</option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Remark Status Migration-DW/Precon</small>
                                        <select class="form-control form-control-sm" id="remarkPreconEdit" value=""
                                            name="remarkPreconEdit">
                                            {{-- <option value="">Pilih Teknisi 4</option> --}}
                                            <option value="Sudah Precon">Sudah Precon</option>
                                            <option value="Permintaan Customer">Permintaan Customer</option>
                                            <option value="Underground">Underground</option>
                                            <option value="Tarikan Lebih 300M">Tarikan Lebih 300M</option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Keterangan Cuaca</small>
                                        <select class="form-control form-control-sm" id="weatherEdit" value=""
                                            name="weatherEdit">
                                            {{-- <option value="">Pilih Teknisi 4</option> --}}
                                            <option value="Cerah">Cerah</option>
                                            <option value="Hujan">Hujan</option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Status APK:</small>
                                        <input type="text" class="form-control form-control-sm" id="statusApkEdit"
                                            value="" name="statusApkEdit">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <small class="form-text">Checkin APK:</small>
                                            <input type="text" class="form-control form-control-sm"
                                                id="checkinApkEdit" value="" name="CheckinApkEdit">
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Checkout APK:</small>
                                            <input type="text" class="form-control form-control-sm"
                                                id="checkOutApkEdit" value="" name="checkOutApkEdit">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <small class="form-text">Pemakaian Material ONT:</small>
                                        <input type="text" class="form-control form-control-sm" id="materialOntOut"
                                            value="" name="materialOntOut">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <small class="form-text">SN ONT:</small>
                                            <input type="text" class="form-control form-control-sm" id="snOntOut"
                                                value="" name="snOntOut">
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Mac ONT:</small>
                                            <input type="text" class="form-control form-control-sm" id="macOntOut"
                                                value="" name="macOntOut">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Pemakaian Material STB:</small>
                                        <input type="text" class="form-control form-control-sm" id="materialSTBOut"
                                            value="" name="materialSTBOut">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <small class="form-text">SN STB:</small>
                                            <input type="text" class="form-control form-control-sm" id="snStbOut"
                                                value="" name="snOntOut">
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Mac STB:</small>
                                            <input type="text" class="form-control form-control-sm" id="macStbOut"
                                                value="" name="macStbOut">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Pemakaian Material Router:</small>
                                        <input type="text" class="form-control form-control-sm"
                                            id="materialRoutertOut" value="" name="materialRouterOut">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <small class="form-text">SN Router:</small>
                                            <input type="text" class="form-control form-control-sm" id="snRouterOut"
                                                value="" name="snRouterOut">
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Mac Router:</small>
                                            <input type="text" class="form-control form-control-sm" id="macRouterOut"
                                                value="" name="macRouterOut">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Pemakaian Material DW/Panjang DW</small>
                                        <input type="text" class="form-control form-control-sm" id="materialDwOut"
                                            value="" name="materialDwOut">

                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Pemakaian Material Precon</small>
                                        <select class="form-control form-control-sm" id="materialPreconOut"
                                            value="" name="materialPreconOut">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <small class="form-text">Pemakaian Material Precon Bad</small>
                                        <select class="form-control form-control-sm" id="materialPreconOut"
                                            value="" name="materialPreconOut">
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col">
                                            <small class="form-text">F.Connector</small>
                                            <small><input type="text" class="form-control form-control-sm"
                                                    id="fcOutEdit" value="" name="fcOutEdit"></small>
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Patch Cord</small>
                                            <small><input type="text" class="form-control form-control-sm"
                                                    id="pcOutEdit" value="" name="pcOutEdit"></small>
                                        </div>
                                        <div class="col">
                                            <small class="form-text">T.Box</small>
                                            <small><input type="text" class="form-control form-control-sm"
                                                    id="tbOutEdit" value="" name="tbOutEdit"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <small class="form-text">Remote</small>
                                            <small><input type="text" class="form-control form-control-sm"
                                                    id="remoteOutEdit" value="" name="remoteOutEdit"></small>
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Adaptor</small>
                                            <small><input type="text" class="form-control form-control-sm"
                                                    id="adaptorOutEdit" value="" name="adaptorOutEdit"></small>
                                        </div>

                                    </div>


                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <small class="form-text">Penerimaan Material ONT:</small>
                                        <input type="text" class="form-control form-control-sm" id="materialOntIn"
                                            value="" name="materialOntIn">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <small class="form-text">SN ONT:</small>
                                            <input type="text" class="form-control form-control-sm" id="snOntIn"
                                                value="" name="snOntIn">
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Mac ONT:</small>
                                            <input type="text" class="form-control form-control-sm" id="macOntIn"
                                                value="" name="macOntIn">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Penerimaan Material STB:</small>
                                        <input type="text" class="form-control form-control-sm" id="materialSTBIn"
                                            value="" name="materialSTBIn">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <small class="form-text">SN STB:</small>
                                            <input type="text" class="form-control form-control-sm" id="snStbIn"
                                                value="" name="snOntIn">
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Mac STB:</small>
                                            <input type="text" class="form-control form-control-sm" id="macStbIn"
                                                value="" name="macStbIn">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Penerimaan Material Router:</small>
                                        <input type="text" class="form-control form-control-sm" id="materialRoutertIn"
                                            value="" name="materialRouterIn">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <small class="form-text">SN Router:</small>
                                            <input type="text" class="form-control form-control-sm" id="snRouterIn"
                                                value="" name="snRouterIn">
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Mac Router:</small>
                                            <input type="text" class="form-control form-control-sm" id="macRouterIn"
                                                value="" name="macRouterIn">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col">
                                            <small class="form-text">Remote</small>
                                            <small><input type="text" class="form-control form-control-sm"
                                                    id="remoteOutEdit" value="" name="remoteOutEdit"></small>
                                        </div>
                                        <div class="col">
                                            <small class="form-text">Adaptor</small>
                                            <small><input type="text" class="form-control form-control-sm"
                                                    id="adaptorOutEdit" value="" name="adaptorOutEdit"></small>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Report WA:</small>
                                        <textarea class="form-control form-control-sm" rows="3" id="materialOntOut" value=""
                                            name="materialOntOut"></textarea>
                                    </div>


                                    <div class="form-group">
                                        <small class="form-text">Keterangan:</small>
                                        <textarea class="form-control form-control-sm" rows="3" id="keteranganEdit" value=""
                                            name="keteranganEdit"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text">Konfirmasi Customer:</small>
                                        <input type="file" class="form-control form-control-sm" id="konfirmasiCstEdit"
                                            value="" name="konfirmasiCstEdit">
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

        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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

                    // console.log(tgl_ikr)
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
                            url: "{{ route('batchwodataMT.data') }}",
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
                                data: 'wo_no',
                                // name: 'cbatch_wo',
                                searchable: true,



                            },
                            {
                                data: 'wo_date'

                            },
                            {
                                data: 'ticket_no',
                                searchable: true,

                            },
                            {
                                data: 'cust_id'

                            },
                            {
                                data: 'name',


                            },
                            {
                                data: 'fat_code'

                            },
                            {
                                data: 'cluster_fat'

                            },
                            {
                                data: 'area_fat'

                            },
                            {
                                data: 'nama_branch'

                            },

                            {
                                data: 'tgl_ikr'

                            },
                            {
                                data: 'slot_time'

                            },
                            {
                                data: 'batch_wo'

                            },
                            {
                                data: 'remark_traffic'

                            },
                            {
                                data: 'callsign'

                            },
                            {
                                data: 'leader'

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
                                data: 'status_wo',



                            },

                            {
                                data: 'couse_code'

                            },


                            {
                                data: 'root_couse'

                            },
                            {
                                data: 'action_taken'

                            },
                            {
                                data: 'tgl_resechedule'

                            },
                            {
                                data: 'remark_status_precon'

                            },
                            {
                                data: 'remark_status_migrasi'

                            },
                            {
                                data: 'start_ikr'

                            },
                            {
                                data: 'end_ikr'

                            },
                            {
                                data: 'checkin_apk'

                            },
                            {
                                data: 'checkout_apk'

                            },
                            {
                                data: 'status_apk'

                            },
                            {
                                data: 'cuaca'

                            },
                            {
                                data: 'material_ont_out'

                            },
                            {
                                data: 'material_sn_ont_out'

                            },
                            {
                                data: 'material_mac_ont_out'

                            },
                            {
                                data: 'material_ont_in'

                            },
                            {
                                data: 'material_sn_ont_in'

                            },
                            {
                                data: 'material_mac_ont_in'

                            },
                            {
                                data: 'material_stb_out'

                            },
                            {
                                data: 'material_sn_stb_out'

                            },
                            {
                                data: 'material_mac_stb_out'

                            },
                            {
                                data: 'material_stb_in'

                            },
                            {
                                data: 'material_sn_stb_in'

                            },
                            {
                                data: 'material_mac_stb_in'

                            },
                            {
                                data: 'material_router_out'

                            },
                            {
                                data: 'material_sn_router_out'

                            },
                            {
                                data: 'material_mac_router_out'
                            },
                            {
                                data: 'material_router_in'

                            },
                            {
                                data: 'material_sn_router_in'

                            },
                            {
                                data: 'material_mac_router_in'
                            },
                            {
                                data: 'material_precon_new'
                            },
                            {
                                data: 'material_precon_bad'
                            },
                            {
                                data: 'material_dw'
                            },
                            {
                                data: 'material_fastconnector'
                            },
                            {
                                data: 'material_patchcord'
                            },
                            {
                                data: 'material_terminalbox'
                            },
                            {
                                data: 'material_remote'
                            },
                            {
                                data: 'material_adaptor'
                            },
                            {
                                data: 'report_wa'

                            },
                            {
                                data: 'konfirmasi_cst'

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

                    

                    // });
                }

                $('#data-wo tbody').on('click', '.edit-callsign', function(e) {
                        e.preventDefault();
                        var data = $('#data-wo').DataTable().row($(this).parents('tr')).data();

                        $('#TglIkrEdit').val(data.tgl_ikr)
                        $('#noWoEdit').val(data.wo_no)
                        $('#custIdEdit').val(data.cust_id)
                        $('#CustNameEdit').val(data.name)
                        $('#remarkTrafficEdit').val(data.remark_traffic)
                        $('#FatCodeEdit').val(data.fat_code)
                        $('#weatherEdit').val(data.cuaca)
                        $('#JenisWoEdit').val(data.jenis_wo)
                        $('#slottimeEdit').val(data.slot_time)
                        $('#callsignEdit').val(data.callsign)
                        $('#teknisi1Edit').val(data.teknisi1)
                        $('#teknisi2Edit').val(data.teknisi2)
                        $('#teknisi3Edit').val(data.teknisi3)
                        $('#teknisi4Edit').val(data.teknisi4)

                        $('#md-edit-callsign').modal('show');



                        

                    });

                $('#statusWoEdit').on('change', function() {
                    var status_wo = $(this).val();
                    if (status_wo) {
                        $.ajax({
                            url: "{{ route('getCouseCode.data') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                status_wo: status_wo,
                            },
                            success: function(data) {
                                $('select[name="couseCodeEdit"]').empty();
                                $('select[name="couseCodeEdit"]').append(
                                    '<option value=""></option>');
                                $.each(data, function(key, item) {
                                    console.log(item.couse_code)
                                    $('select[name="couseCodeEdit"]').append(
                                        '<option value="' + item.couse_code + '">' +
                                        item.couse_code + '</option>');
                                });

                            }
                        })

                    }
                });

                $('#couseCodeEdit').on('change', function() {
                    var couse_code = $(this).val();
                    if (couse_code) {
                        $.ajax({
                            url: "{{ route('getRootCouse.data') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                couse_code: couse_code,
                            },
                            success: function(data) {
                                $('select[name="rootCouseEdit"]').empty();
                                $('select[name="rootCouseEdit"]').append(
                                    '<option value=""></option>');
                                $.each(data, function(key, item) {
                                    console.log(item.root_couse)
                                    $('select[name="rootCouseEdit"]').append(
                                        '<option value="' + item.root_couse + '">' +
                                        item.root_couse + '</option>');
                                });

                            }
                        })

                    }
                });

                $('#rootCouseEdit').on('change', function() {
                    var root_couse = $(this).val();
                    if (root_couse) {
                        $.ajax({
                            url: "{{ route('getActionTaken.data') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                root_couse: root_couse,
                            },
                            success: function(data) {
                                $('select[name="actionTakenEdit"]').empty();
                                $('select[name="actionTakenEdit"]').append(
                                    '<option value=""></option>');
                                $.each(data, function(key, item) {
                                    console.log(item.action_taken)
                                    $('select[name="actionTakenEdit"]').append(
                                        '<option value="' + item.action_taken + '">' +
                                        item.action_taken + '</option>');
                                });

                            }
                        })

                    }
                });




            });
        </script>
    @endsection
