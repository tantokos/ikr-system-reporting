@extends('layout.main')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <form action="{{ route('import.ImportFtthMtTemp') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col form-text"></label>
                            <div class="col">
                                <input type="file" name="fileFtthMT" class="form-control form-text" required="required">
                                @error('fileFtthMT')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-sm btn-success">Import Data Aset</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>

                <div class="col">
                    {{-- <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data"> --}}
                    <form action="{{ route('saveImportMtFtth')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 form-text">Import By : </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm border-secondary" name="akses"
                                    value="{{ $akses }}" readonly>
                            </div>
                            
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 form-text">Jumlah Data :</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm border-secondary" id="jmlImport"
                                    name="jmlImport" value="{{ $jmlImport }}" readonly required>
                            </div>
                            
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 form-text">Periode Report : </label>
                            <label class="col-sm-4 form-text" style="font-weight: bold">{{ $tglIkr->min('tgl_ikr') }} s/d {{ $tglIkr->max('tgl_ikr') }}</label>
                        </div>

                        <div class="form-group">
                            <div class="col">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#md-showSummary">Show Summary</button>
                                <button type="submit" class="btn btn-sm btn-primary" name="action" value="simpan">Simpan data Import</button>
                                <button type="submit" class="btn btn-sm btn-secondary" name="action" value="batal">Batalkan Import</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <hr>

        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTempFtthMt" width="100%" cellspacing="0"
                    style="font-size: 12px">
                    <thead>
                        <tr>
                            <th>No</th>
                            {{-- <th>pic_monitoring</th> --}}
                            <th>type_wo</th>
                            <th>no_wo</th>
                            {{-- <th>no_ticket</th> --}}
                            <th>cust_id</th>
                            <th>nama_cust</th>
                            {{-- <th>cust_address1</th> --}}
                            {{-- <th>cust_address2</th> --}}
                            {{-- <th>type_maintenance</th> --}}
                            <th>kode_fat</th>
                            <th>kode_wilayah</th>
                            <th>cluster</th>
                            <th>kotamadya</th>
                            <th>kotamadya_penagihan</th>
                            <th>branch</th>
                            <th>tgl_ikr</th>
                            <th>slot_time_leader</th>
                            <th>slot_time_apk</th>
                            <th>sesi</th>
                            <th>remark_traffic</th>
                            <th>callsign</th>
                            <th>leader</th>
                            <th>teknisi1</th>
                            <th>teknisi2</th>
                            <th>teknisi3</th>
                            <th>status_wo</th>
                            <th>couse_code</th>
                            <th>root_couse</th>
                            <th>penagihan</th>
                            <th>alasan_tag_alarm</th>
                            <th>tgl_jam_reschedule</th>
                            <th>tgl_jam_fat_on</th>
                            <th>action_taken</th>
                            <th>panjang_kabel</th>
                            <th>weather</th>
                            <th>remark_status</th>
                            <th>action_status</th>
                            <th>start_ikr_wa</th>
                            <th>end_ikr_wa</th>
                            <th>validasi_start</th>
                            <th>validasi_end</th>
                            <th>checkin_apk</th>
                            <th>checkout_apk</th>
                            <th>status_apk</th>
                            {{-- <th>keterangan</th> --}}
                            <th>ms_regular</th>
                            <th>wo_date_apk</th>
                            <th>wo_date_mail_reschedule</th>
                            <th>wo_date_slot_tim_apk</th>
                            <th>actual_sla_wo_minute_apk</th>
                            <th>actual_sla_wo_jam_apk</th>
                            <th>mttr_over_apk_minute</th>
                            <th>mttr_over_apk_jam</th>
                            <th>mttr_over_apk_persen</th>
                            <th>status_sla</th>
                            <th>root_couse_before</th>
                            <th>slot_time_assign_apk</th>
                            <th>slot_time_apk_delay</th>
                            <th>status_slot_time_apk_delay</th>
                            <th>ket_delay_slot_time</th>
                            <th>konfirmasi_customer</th>
                            <th>ont_merk_out</th>
                            <th>ont_sn_out</th>
                            <th>ont_mac_out</th>
                            <th>ont_merk_in</th>
                            <th>ont_sn_in</th>
                            <th>ont_mac_in</th>
                            <th>router_merk_out</th>
                            <th>router_sn_out</th>
                            <th>router_mac_out</th>
                            <th>router_merk_in</th>
                            <th>router_sn_in</th>
                            <th>router_mac_in</th>
                            <th>stb_merk_out</th>
                            <th>stb_sn_out</th>
                            <th>stb_mac_out</th>
                            <th>stb_merk_in</th>
                            <th>stb_sn_in</th>
                            <th>stb_mac_in</th>
                            <th>dw_out</th>
                            <th>precon_out</th>
                            <th>bad_precon</th>
                            <th>fast_connector</th>
                            <th>patchcord</th>
                            <th>terminal_box</th>
                            <th>remote_fiberhome</th>
                            <th>remote_extrem</th>
                            <th>port_fat</th>
                            <th>site_penagihan</th>
                            <th>konfirmasi_penjadwalan</th>
                            <th>konfirmasi_cst</th>
                            <th>konfirmasi_dispatch</th>
                            <th>remark_status2</th>
                            <th>login</th>
                            <th>action</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Input Baru --}}
    <div class="modal fade" id="md-showSummary" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Summary Data Import MT FTTH</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-showSummary">

                    {{-- Filter Row --}}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="font-size: 12px">
                                    <thead>
                                        <tr>
                                            <th>Site (Penagihan) </th>
                                            <th><select class="col" name="sitePenagihanOri">
                                                    <option value="ALL">ALL</option>
                                                    @foreach ($sitePenagihan as $site)
                                                        <option value="{{ $site->site_penagihan }}">
                                                            {{ $site->site_penagihan }}</option>
                                                    @endforeach

                                                </select></th>
                                        </tr>
                                        <tr>
                                            <th>Branch </th>
                                            <th><select class="col" name="branchOri">
                                                    <option value="ALL">ALL</option>
                                                    @foreach ($branch as $bran)
                                                        <option value="{{ $bran->branch }}">{{ $bran->branch }}</option>
                                                    @endforeach
                                                </select></th>
                                        </tr>
                                        <tr>
                                            <th>Kotamadya (Penagihan) </th>
                                            <th><select class="col" name="kotamadyaPenagihanOri">
                                                    <option value="ALL">ALL</option>
                                                    @foreach ($kotamadyaPenagihan as $kotamadya)
                                                        <option value="{{ $kotamadya->kotamadya_penagihan }}">
                                                            {{ $kotamadya->kotamadya_penagihan }}</option>
                                                    @endforeach
                                                </select></th>
                                        </tr>

                                        <tr>
                                            <th colspan="2" style="text-align: center">
                                            <button type="button" class="btn btn-sm btn-primary">Filter</button>
                                            <button type="button" class="btn btn-sm btn-warning">Show ALL</button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">Back</button>
                                            </th>
                                        </tr>
                                        

                                    </thead>
                                </table>

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="font-size: 12px">
                                    <thead>
                                        <tr>
                                            <th>Tanggal IKR</th>
                                            <th><select class="col" name="tglIkr">
                                                    <option value="ALL">ALL</option>
                                                    @foreach ($tglIkr as $tgl)
                                                        <option value="{{ $tgl->tgl_ikr }}">{{ $tgl->tgl_ikr }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </th>
                                        </tr>

                                        <tr>
                                            <th>Penagihan</th>
                                            <th><select class="col" name="penagihan">
                                                    <option value="ALL">ALL</option>
                                                    @foreach ($penagihan as $penagih)
                                                        <option value="{{ $penagih->penagihan }}">
                                                            {{ $penagih->penagihan }}</option>
                                                    @endforeach
                                                </select></th>
                                        </tr>
                                        <tr>
                                            <th>Status WO</th>
                                            <th><select class="col" name="statusWo">
                                                    <option value="ALL">ALL</option>
                                                    @foreach ($statusWo as $status)
                                                        <option value="{{ $status->status_wo }}">{{ $status->status_wo }}
                                                        </option>
                                                    @endforeach
                                                </select></th>
                                        </tr>


                                    </thead>
                                </table>

                            </div>
                        </div>
                    </div>

                    {{-- End Filter Row --}}

                    {{-- Status WO MT FTTH --}}

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <h6>Summary Data ORI MT FTTH</h6>
                                <table class="table table-bordered" style="font-size: 12px">
                                    <tr class="table-active">
                                        <th>Status WO</th>
                                        <th style="text-align: center">Jumlah</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Done</td>
                                            <td style="text-align: center">{{ number_format($done) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pending</td>
                                            <td style="text-align: center">{{ number_format($pending) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cancel</td>
                                            <td style="text-align: center">{{ number_format($cancel) }}</td>
                                        </tr>
                                        <tr class="table-active">
                                            <th>Total</th>
                                            <th style="text-align: center">{{ number_format($done + $pending + $cancel) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        
                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <h6>Summary Data Sortir MT FTTH</h6>
                                <table class="table table-bordered" style="font-size: 12px">
                                    <tr class="table-active">
                                        <th>Status WO</th>
                                        <th style="text-align: center">Jumlah</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Done</td>
                                            <td style="text-align: center">{{ number_format($doneSortir) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pending</td>
                                            <td style="text-align: center">{{ number_format($pendingSortir) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cancel</td>
                                            <td style="text-align: center">{{ number_format($cancelSortir) }}</td>
                                        </tr>
                                        <tr class="table-active">
                                            <th>Total</th>
                                            <th style="text-align: center">{{ number_format($doneSortir + $pendingSortir + $cancelSortir) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    {{-- End Status WO --}}

                    {{-- Summary Root Couse --}}

                    <div class="row">
                        {{-- Root Couse Ori MT --}}
                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="font-size: 11px">
                                    <thead>
                                        <tr class="table-active">
                                            <th>Root Couse Penagihan (Ori)</th>
                                            <th style="text-align: center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @for ($x = 0; $x < count($detPenagihan); $x++)
                                            <tr>
                                                <th>
                                                    {{ $detPenagihan[$x]->penagihan }}
                                                </th>
                                                <th style="text-align: center">
                                                    {{ number_format($detPenagihan[$x]->jml) }}
                                                </th>
                                            </tr>

                                            @for ($y = 0; $y < count($detCouseCode); $y++)
                                                @if ($detPenagihan[$x]->penagihan == $detCouseCode[$y]->penagihan)
                                                    <tr>
                                                        <th style="text-indent: 20px">

                                                            {{ $detCouseCode[$y]->couse_code }}
                                                        </th>
                                                        <th style="text-align: center">
                                                            {{ number_format($detCouseCode[$y]->jml) }}
                                                        </th>
                                                    </tr>

                                                    @for ($z = 0; $z < count($detRootCouse); $z++)
                                                        @if (
                                                            $detPenagihan[$x]->penagihan == $detRootCouse[$z]->penagihan &&
                                                                $detCouseCode[$y]->couse_code == $detRootCouse[$z]->couse_code)
                                                            <tr>
                                                                <td style="text-indent: 40px">
                                                                    {{ $detRootCouse[$z]->root_couse }}
                                                                </td>
                                                                <td style="text-align: center">
                                                                    {{ number_format($detRootCouse[$z]->jml) }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endfor

                                                @endif
                                            @endfor

                                        @endfor
                                        <tr>
                                            <th>TOTAL</th>
                                            <th style="text-align: center">{{ number_format($detRootCouse->sum('jml')) }}</th>
                                        </tr>


                                    </tbody>
                                </table>

                            </div>

                        </div>
                        {{-- End Root Couse ORI MT --}}

                        {{-- Root Couse Sortir MT --}}
                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="font-size: 11px">
                                    <thead>
                                        <tr class="table-active">
                                            <th>Root Couse Penagihan (Sortir)</th>
                                            <th style="text-align: center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        {{-- <ul style="font-size: 12px"> --}}
                                        @for ($x = 0; $x < count($detPenagihanSortir); $x++)
                                            <tr>
                                                <th>
                                                    {{ $detPenagihanSortir[$x]->penagihan }}
                                                </th>
                                                <th style="text-align: center">
                                                    {{ number_format($detPenagihanSortir[$x]->jml) }}
                                                </th>
                                            </tr>
                                            {{-- <ul> --}}

                                            @for ($y = 0; $y < count($detCouseCodeSortir); $y++)
                                                @if ($detPenagihanSortir[$x]->penagihan == $detCouseCodeSortir[$y]->penagihan)
                                                    <tr>
                                                        <th style="text-indent: 20px">

                                                            {{ $detCouseCodeSortir[$y]->couse_code }}
                                                        </th>
                                                        <th style="text-align: center">
                                                            {{ number_format($detCouseCodeSortir[$y]->jml) }}
                                                        </th>
                                                    </tr>

                                                    {{-- <ul> --}}
                                                    @for ($z = 0; $z < count($detRootCouseSortir); $z++)
                                                        @if (
                                                            $detPenagihanSortir[$x]->penagihan == $detRootCouseSortir[$z]->penagihan &&
                                                                $detCouseCodeSortir[$y]->couse_code == $detRootCouseSortir[$z]->couse_code)
                                                            <tr>
                                                                <td style="text-indent: 40px">
                                                                    {{ $detRootCouseSortir[$z]->root_couse }}
                                                                </td>
                                                                <td style="text-align: center">
                                                                    {{ number_format($detRootCouseSortir[$z]->jml) }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endfor

                                                    {{-- </ul> --}}
                                                @endif
                                            @endfor

                                            {{-- </ul> --}}


                                            {{-- </th> --}}
                                            {{-- <tr> --}}

                                            {{-- </ul> --}}
                                        @endfor
                                        <tr>
                                            <th>TOTAL</th>
                                            <th style="text-align: center">{{ number_format($detRootCouseSortir->sum('jml')) }}</th>
                                        </tr>


                                    </tbody>
                                </table>

                            </div>

                        </div>
                        {{-- End Root Couse Sortir MT --}}
                    </div>
                    {{-- End Root Couse --}}

                    <div class="modal-footer">
                        {{-- <button type="submit" class="btn  btn-primary">Save</button> --}}
                        <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>

                    </div>

                </div>
            </div>
        </div>


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
            $(document).ready(function() {
                fetch_data()    

                function fetch_data() {
                    $('#dataTempFtthMt').DataTable({
                        paging: true,
                        orderClasses: false,
                        deferRender: true,
                        fixedColumns: true,

                        fixedColumns: {
                            // leftColumns: 4,
                            rightColumns: 1
                        },


                        scrollCollapse: true,
                        scrollX: true,
                        // scrollY: 300,
                        pageLength: 10,
                        lengthChange: false,
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
                            url: "{{ route('import.dataImportFtthMtTemp') }}",
                            type: "get"

                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_Row_Index',
                                "className": "text-center",
                                // orderable: false, 
                                searchable: false,
                                "width": '20'
                            },
                            // {
                            //     data: 'pic_monitoring',
                            //     "className": "text-center",
                            //     width: '5%'

                            // },
                            {
                                "data": 'type_wo',
                                "width": '90'
                            },
                            {
                                data: 'no_wo',
                                width: '90'
                            },
                            // {
                            //     data: 'no_ticket',
                            //     width: '5%'
                            // },
                            {
                                data: 'cust_id',
                                width: '90'
                            },
                            {
                                data: 'nama_cust',
                                width: '90'
                            },
                            // {
                            //     data: 'cust_address1',
                            //     width: '90'
                            // },
                            // {
                            //     data: 'cust_address2',
                            //     width: '5%'
                            // },
                            // {
                            //     data: 'type_maintenance',
                            //     width: '90'
                            // },
                            {
                                data: 'kode_fat',
                                width: '90'
                            },
                            {
                                data: 'kode_wilayah',
                                width: '90'
                            },
                            {
                                data: 'cluster',
                                width: '90'
                            },
                            {
                                data: 'kotamadya',
                                width: '90'
                            },
                            {
                                data: 'kotamadya_penagihan'
                            },
                            {
                                data: 'branch'
                            },
                            {
                                data: 'tgl_ikr'
                            },
                            {
                                data: 'slot_time_leader'
                            },
                            {
                                data: 'slot_time_apk'
                            },
                            {
                                data: 'sesi'
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
                                data: 'status_wo'
                            },
                            {
                                data: 'couse_code'
                            },
                            {
                                data: 'root_couse'
                            },
                            {
                                data: 'penagihan'
                            },
                            {
                                data: 'alasan_tag_alarm'
                            },
                            {
                                data: 'tgl_jam_reschedule'
                            },
                            {
                                data: 'tgl_jam_fat_on'
                            },
                            {
                                data: 'action_taken'
                            },
                            {
                                data: 'panjang_kabel'
                            },
                            {
                                data: 'weather'
                            },
                            {
                                data: 'remark_status'
                            },
                            {
                                data: 'action_status'
                            },
                            {
                                data: 'start_ikr_wa'
                            },
                            {
                                data: 'end_ikr_wa'
                            },
                            {
                                data: 'validasi_start'
                            },
                            {
                                data: 'validasi_end'
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
                            // {
                            //     data: 'keterangan'
                            // },
                            {
                                data: 'ms_regular'
                            },
                            {
                                data: 'wo_date_apk'
                            },
                            {
                                data: 'wo_date_mail_reschedule'
                            },
                            {
                                data: 'wo_date_slot_time_apk'
                            },
                            {
                                data: 'actual_sla_wo_minute_apk'
                            },
                            {
                                data: 'actual_sla_wo_jam_apk'
                            },
                            {
                                data: 'mttr_over_apk_minute'
                            },
                            {
                                data: 'mttr_over_apk_jam'
                            },
                            {
                                data: 'mttr_over_apk_persen'
                            },
                            {
                                data: 'status_sla'
                            },
                            {
                                data: 'root_couse_before'
                            },
                            {
                                data: 'slot_time_assign_apk'
                            },
                            {
                                data: 'slot_time_apk_delay'
                            },
                            {
                                data: 'status_slot_time_apk_delay'
                            },
                            {
                                data: 'ket_delay_slot_time'
                            },
                            {
                                data: 'konfirmasi_customer'
                            },
                            {
                                data: 'ont_merk_out'
                            },
                            {
                                data: 'ont_sn_out'
                            },
                            {
                                data: 'ont_mac_out'
                            },
                            {
                                data: 'ont_merk_in'
                            },
                            {
                                data: 'ont_sn_in'
                            },
                            {
                                data: 'ont_mac_in'
                            },
                            {
                                data: 'router_merk_out'
                            },
                            {
                                data: 'router_sn_out'
                            },
                            {
                                data: 'router_mac_out'
                            },
                            {
                                data: 'router_merk_in'
                            },
                            {
                                data: 'router_sn_in'
                            },
                            {
                                data: 'router_mac_in'
                            },
                            {
                                data: 'stb_merk_out'
                            },
                            {
                                data: 'stb_sn_out'
                            },
                            {
                                data: 'stb_mac_out'
                            },
                            {
                                data: 'stb_merk_in'
                            },
                            {
                                data: 'stb_sn_in'
                            },
                            {
                                data: 'stb_mac_in'
                            },
                            {
                                data: 'dw_out'
                            },
                            {
                                data: 'precon_out'
                            },
                            {
                                data: 'bad_precon'
                            },
                            {
                                data: 'fast_connector'
                            },
                            {
                                data: 'patchcord'
                            },
                            {
                                data: 'terminal_box'
                            },
                            {
                                data: 'remote_fiberhome'
                            },
                            {
                                data: 'remote_extrem'
                            },
                            {
                                data: 'port_fat'
                            },
                            {
                                data: 'site_penagihan'
                            },
                            {
                                data: 'konfirmasi_penjadwalan'
                            },
                            {
                                data: 'konfirmasi_cst'
                            },
                            {
                                data: 'konfirmasi_dispatch'
                            },
                            {
                                data: 'remark_status2'
                            },
                            {
                                data: 'login'
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
