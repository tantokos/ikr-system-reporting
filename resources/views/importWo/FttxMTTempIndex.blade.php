@extends('layout.main')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 id="CardTitle">Import Data FTTX Maintenance (MT)<h5>
            </div>
        </div>
    </div>
</div>
    {{-- <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1> --}}

    <div class="card bg-light">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <form action="{{ route('import.ImportFttxMTTemp') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            {{-- <label class="col form-text"></label>
                            <div class="col">
                                <input type="file" name="fileFtthMT" class="form-control form-text border-secondary" required="required">
                                @error('fileFtthMT')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div> --}}

                            <label class="col-sm-3 form-text">File FTTX MT Ori : </label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control form-control-sm border-secondary" name="fileFttxMTOri"
                                id="fileFttxIBOri" required="required">
                                @error('fileFttxMTOri')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                        </div>

                        <label class="col-sm-3 form-text">File FTTX MT Sortir : </label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control form-control-sm border-secondary" name="fileFttxMTSortir"
                                id="fileFttxIBSortir" required="required">
                                @error('fileFttxMTSortir')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                        </div>
                        </div>

                        

                        <div class="form-group">
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-sm btn-danger">Import Data FTTX MT Original</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col form-text">Informasi Data Import</label>
                            <div class="col">
                                @if ($croscekData != '-')
                                    <span class="error">{{ $croscekData }}</span>
                                @else
                                    <span class="error">-</span>
                                @endif
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>

                <div class="col">
                    {{-- <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data"> --}}
                    <form action="{{ route('saveImportFttxMT') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 form-text">Import By : </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm border-secondary" name="akses"
                                    id="akses" value="{{ $akses }}" readonly>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 form-text">Jumlah Data FTTX MT :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm border-secondary" id="jmlImport"
                                    name="jmlImport" value="{{ $jmlImport }}" readonly required>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 form-text">Periode Report : </label>
                            <label class="col-sm-6 form-text" style="font-weight: bold">{{ $tglIkr->min('mt_date') }} s/d
                                {{ $tglIkr->max('mt_date') }}</label>
                        </div>

                        <div class="form-group">
                            <div class="col">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#md-showSummary">Show Summary</button>
                                <button onclick="return confirm('Simpan hasil import Data Ori New Installation?')" type="submit"
                                    class="btn btn-sm btn-primary" name="action" value="simpan">Simpan data Import</button>
                                <button onclick="return confirm('Hapus hasil import Data Ori New Installation?')"type="submit"
                                    class="btn btn-sm btn-secondary" name="action" value="batal">Batalkan Import</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <hr>

        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTempFtthIb" width="100%" cellspacing="0"
                    style="font-size: 12px">
                    <thead>
                        <tr>
                            <th>No</th>
                            {{-- <th>pic_monitoring</th> --}}
                            <th>no_so</th>
                            <th>no_wo</th>
                            <th>wo_date</th>
                            <th>mt_date</th>
                            <th>wo_type</th>
                            <th>cust_name</th>
                            <th>cust_address</th>
                            <th>area</th>
                            <th>site</th>
                            <th>packages_type</th>
                            <th>service_type</th>
                            <th>slot_time</th>
                            <th>teknisi1</th>
                            <th>teknisi2</th>
                            <th>teknisi3</th>
                            <th>leader</th>
                            <th>branch</th>
                            <th>callsign</th>
                            <th>nopol</th>
                            <th>start</th>
                            <th>finish</th>
                            <th>report_wa</th>
                            <th>fdt_code</th>
                            <th>fat_code</th>
                            <th>fat_port</th>
                            <th>signal_fat</th>
                            <th>signal_tb</th>
                            <th>signal_ont</th>
                            <th>ont_sn_out</th>
                            <th>ont_mac_out</th>
                            <th>ont_sn_in</th>
                            <th>ont_mac_in</th>
                            <th>stb2_sn</th>
                            <th>stb2_mac</th>
                            <th>stb3_sn</th>
                            <th>stb3_mac</th>
                            <th>router_sn</th>
                            <th>router_mac</th>
                            <th>drop_cable</th>
                            <th>precon</th>
                            <th>fast_connector</th>
                            <th>termination_box</th>
                            <th>patch_cord_3m</th>
                            <th>patch_cord_10m</th>
                            <th>screw_hanger</th>
                            <th>indor_cable_duct</th>
                            <th>pvc_pipe_20mm</th>
                            <th>socket_pvc_20mm</th>
                            <th>clamp_pvc_20mm</th>
                            <th>flexible_pvc_20mm</th>
                            <th>clamp_cable</th>
                            <th>cable_lan</th>
                            <th>connector_rj45</th>
                            <th>cable_marker</th>
                            <th>insulation</th>
                            <th>cable_ties</th>
                            <th>adapter_optic</th>
                            <th>fisher</th>
                            <th>paku_beton</th>
                            <th>splitter</th>
                            <th>status_wo</th>
                            <th>root_couse</th>
                            <th>action_taken</th>
                            <th>remarks</th>

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

    {{-- Modal Show Summary --}}
    <div class="modal fade" id="md-showSummary" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Summary Data Import FTTX MT</h5>
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
                                            <th><select class="col" name="FiltersitePenagihan" id="sitePenagihanOri">
                                                    <option value="ALL">ALL</option>
                                                    @foreach ($sitePenagihan as $site)
                                                        <option value="{{ $site->site_penagihan }}">
                                                            {{ $site->site_penagihan }}</option>
                                                    @endforeach

                                                </select></th>
                                        </tr>
                                        <tr>
                                            <th>Branch </th>
                                            <th><select class="col" name="branchOri" id="branchOri">
                                                    <option value="ALL">ALL</option>
                                                    @foreach ($branch as $bran)
                                                        <option value="{{ $bran->branch }}">{{ $bran->branch }}</option>
                                                    @endforeach
                                                </select></th>
                                        </tr>
                                        <tr>
                                            <th>Kotamadya (Penagihan) </th>
                                            <th><select class="col" name="kotamadyaPenagihanOri"
                                                    id="kotamadyaPenagihanOri">
                                                    <option value="ALL">ALL</option>
                                                    @foreach ($kotamadyaPenagihan as $kotamadya)
                                                        <option value="{{ $kotamadya->kotamadya_penagihan }}">
                                                            {{ $kotamadya->kotamadya_penagihan }}</option>
                                                    @endforeach
                                                </select></th>
                                        </tr>

                                        <tr>
                                            <th colspan="2" style="text-align: center">
                                                <button type="button"
                                                    class="btn btn-sm btn-primary filterSummary" id="filterSummary">Filter</button>
                                                <button type="button" class="btn btn-sm btn-warning filterAll" id="filterAll">Show
                                                    ALL</button>
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-dismiss="modal" aria-label="Close">Back</button>
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
                                            <th><select class="col" name="tglIkr" id="tglIkr">
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
                                            <th><select class="col" name="RootPenagihan" id="RootPenagihan">
                                                    <option value="ALL">ALL</option>
                                                    @foreach ($penagihan as $penagih)
                                                        <option value="{{ $penagih->penagihan }}">
                                                            {{ $penagih->penagihan }}</option>
                                                    @endforeach
                                                </select></th>
                                        </tr>
                                        <tr>
                                            <th>Status WO</th>
                                            <th><select class="col" name="statusWo" id="statusWo">
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
                                <h6>Summary Data ORI FTTX MT</h6>
                                <table class="table table-bordered" style="font-size: 12px">
                                    <tr class="table-active">
                                        <th>Status WO</th>
                                        <th style="text-align: center">Jumlah</th>
                                    </tr>
                                    </thead>
                                    <tbody id=tbodyStatusWoOri>
                                        {{-- <tr> --}}
                                            {{-- <td>Done</td> --}}
                                            {{-- <td style="text-align: center">{{ number_format($done) }}</td> --}}
                                        {{-- </tr> --}}
                                        {{-- <tr> --}}
                                            {{-- <td>Pending</td> --}}
                                            {{-- <td style="text-align: center">{{ number_format($pending) }}</td> --}}
                                        {{-- </tr> --}}
                                        {{-- <tr> --}}
                                            {{-- <td>Cancel</td> --}}
                                            {{-- <td style="text-align: center">{{ number_format($cancel) }}</td> --}}
                                        {{-- </tr> --}}
                                        {{-- <tr class="table-active"> --}}
                                            {{-- <th>Total</th> --}}
                                            {{-- <th style="text-align: center">{{ number_format($done + $pending + $cancel) }} --}}
                                                {{-- </th> --}}
                                        {{-- </tr> --}}
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <h6>Summary Data Sortir FTTX MT</h6>
                                <table class="table table-bordered" style="font-size: 12px">
                                    <tr class="table-active">
                                        <th>Status WO</th>
                                        <th style="text-align: center">Jumlah</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyStatusWoSortir">
                                        {{-- <tr> --}}
                                            {{-- <td>Done</td> --}}
                                            {{-- <td style="text-align: center">{{ number_format($doneSortir) }}</td> --}}
                                        {{-- </tr> --}}
                                        {{-- <tr> --}}
                                            {{-- <td>Pending</td> --}}
                                            {{-- <td style="text-align: center">{{ number_format($pendingSortir) }}</td> --}}
                                        {{-- </tr> --}}
                                        {{-- <tr> --}}
                                            {{-- <td>Cancel</td> --}}
                                            {{-- <td style="text-align: center">{{ number_format($cancelSortir) }}</td> --}}
                                        {{-- </tr> --}}
                                        {{-- <tr class="table-active"> --}}
                                            {{-- <th>Total</th> --}}
                                            {{-- <th style="text-align: center"> --}}
                                                {{-- {{ number_format($doneSortir + $pendingSortir + $cancelSortir) }}</td> --}}
                                        {{-- </tr> --}}
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
                                            <th>Action Taken FTTX MT (Ori)</th>
                                            <th style="text-align: center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyRootCouseOri">

                                        {{-- @for ($x = 0; $x < count($detPenagihan); $x++) --}}
                                            {{-- <tr> --}}
                                                {{-- <th> --}}
                                                    {{-- {{ $detPenagihan[$x]->penagihan }} --}}
                                                {{-- </th> --}}
                                                {{-- <th style="text-align: center"> --}}
                                                    {{-- {{ number_format($detPenagihan[$x]->jml) }} --}}
                                                {{-- </th> --}}
                                            {{-- </tr> --}}

                                            {{-- @for ($y = 0; $y < count($detCouseCode); $y++) --}}
                                                {{-- @if ($detPenagihan[$x]->penagihan == $detCouseCode[$y]->penagihan) --}}
                                                    {{-- <tr> --}}
                                                        {{-- <th style="text-indent: 20px"> --}}

                                                            {{-- {{ $detCouseCode[$y]->couse_code }} --}}
                                                        {{-- </th> --}}
                                                        {{-- <th style="text-align: center"> --}}
                                                            {{-- {{ number_format($detCouseCode[$y]->jml) }} --}}
                                                        {{-- </th> --}}
                                                    {{-- </tr> --}}

                                                    {{-- @for ($z = 0; $z < count($detRootCouse); $z++) --}}
                                                        {{-- @if ( --}}
                                                            {{-- $detPenagihan[$x]->penagihan == $detRootCouse[$z]->penagihan && --}}
                                                                {{-- $detCouseCode[$y]->couse_code == $detRootCouse[$z]->couse_code) --}}
                                                            {{-- <tr> --}}
                                                                {{-- <td style="text-indent: 40px"> --}}
                                                                    {{-- {{ $detRootCouse[$z]->root_couse }} --}}
                                                                {{-- </td> --}}
                                                                {{-- <td style="text-align: center"> --}}
                                                                    {{-- {{ number_format($detRootCouse[$z]->jml) }} --}}
                                                                {{-- </td> --}}
                                                            {{-- </tr> --}}
                                                        {{-- @endif --}}
                                                    {{-- @endfor --}}
                                                {{-- @endif --}}
                                            {{-- @endfor --}}
                                        {{-- @endfor --}}
                                        {{-- <tr> --}}
                                            {{-- <th>TOTAL</th> --}}
                                            {{-- <th style="text-align: center">{{ number_format($detRootCouse->sum('jml')) }} --}}
                                            {{-- </th> --}}
                                            
                                        {{-- </tr> --}}


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
                                            <th>Action Taken FTTX MT (Sortir)</th>
                                            <th style="text-align: center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyRootCouseSortir">

                                        {{-- @for ($x = 0; $x < count($detPenagihanSortir); $x++) --}}
                                            {{-- <tr> --}}
                                                {{-- <th> --}}
                                                    {{-- {{ $detPenagihanSortir[$x]->penagihan }} --}}
                                                {{-- </th> --}}
                                                {{-- <th style="text-align: center"> --}}
                                                    {{-- {{ number_format($detPenagihanSortir[$x]->jml) }} --}}
                                                {{-- </th> --}}
                                            {{-- </tr> --}}

                                            {{-- @for ($y = 0; $y < count($detCouseCodeSortir); $y++) --}}
                                                {{-- @if ($detPenagihanSortir[$x]->penagihan == $detCouseCodeSortir[$y]->penagihan) --}}
                                                    {{-- <tr> --}}
                                                        {{-- <th style="text-indent: 20px"> --}}
                                                            {{-- {{ $detCouseCodeSortir[$y]->couse_code }} --}}
                                                        {{-- </th> --}}
                                                        {{-- <th style="text-align: center"> --}}
                                                            {{-- {{ number_format($detCouseCodeSortir[$y]->jml) }} --}}
                                                        {{-- </th> --}}
                                                    {{-- </tr> --}}

                                                    {{-- @for ($z = 0; $z < count($detRootCouseSortir); $z++) --}}
                                                        {{-- @if ( --}}
                                                            {{-- $detPenagihanSortir[$x]->penagihan == $detRootCouseSortir[$z]->penagihan && --}}
                                                                {{-- $detCouseCodeSortir[$y]->couse_code == $detRootCouseSortir[$z]->couse_code) --}}
                                                            {{-- <tr> --}}
                                                                {{-- <td style="text-indent: 40px"> --}}
                                                                    {{-- {{ $detRootCouseSortir[$z]->root_couse }} --}}
                                                                {{-- </td> --}}
                                                                {{-- <td style="text-align: center"> --}}
                                                                    {{-- {{ number_format($detRootCouseSortir[$z]->jml) }} --}}
                                                                {{-- </td> --}}
                                                            {{-- </tr> --}}
                                                        {{-- @endif --}}
                                                    {{-- @endfor --}}

                                                {{-- @endif --}}
                                            {{-- @endfor --}}

                                        {{-- @endfor --}}
                                        {{-- <tr> --}}
                                            {{-- <th>TOTAL</th> --}}
                                            {{-- <th style="text-align: center"> --}}
                                                {{-- {{ number_format($detRootCouseSortir->sum('jml')) }}</th> --}}
                                        {{-- </tr> --}}


                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>

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

            var _token = $('meta[name=csrf-token]').attr('content');

            $(document).on('click','.filterAll', function(){
                $('#sitePenagihanOri').val('ALL');
                $('#branchOri').val('ALL');
                $('#kotamadyaPenagihanOri').val('ALL');
                $('#tglIkr').val('ALL');
                $('#RootPenagihan').val('ALL');
                $('#statusWo').val('ALL');

                document.getElementById('filterSummary').click();
            })

            $(document).on('click', '.filterSummary', function() {

                let fSitePenagihan = $('#sitePenagihanOri').val();
                let fbranch = $('#branchOri').val();
                let fkotamadya = $('#kotamadyaPenagihanOri').val();
                let ftglIkr = $('#tglIkr').val();
                let frootPenagihan = $('#RootPenagihan').val();
                let fstatusWo = $('#statusWo').val();

                var _token = $('meta[name=csrf-token]').attr('content');

                $('#tbodyRootCouseOri').empty();
                $('#tbodyRootCouseSortir').empty();
                $('#tbodyStatusWoOri').empty();
                $('#tbodyStatusWoSortir').empty();

                $.ajax({
                    url: "{{ route('getFilterSummaryFttxMT') }}",
                    type: "get",
                    data: {
                        // bulanTahunReport: bulanReport,
                        filSitePenagihan: fSitePenagihan,
                        filBranch: fbranch,
                        filKotamadya: fkotamadya,
                        filTglIkr: ftglIkr,
                        filRootPenagihan: frootPenagihan,
                        filStatusWo: fstatusWo,
                        _token : _token
                    },
                    success: function(summary) {

                        let totRootOri = 0;
                        let totRootSortir = 0;

                        console.log(summary);

                        $('#tbodyStatusWoOri').append(`
                            <tr>
                                <td>Done</td>
                                <td style="text-align: center">${summary.done.toLocaleString()}</td>
                            </tr>
                            <tr>
                                <td>Pending</td>
                                <td style="text-align: center">${summary.pending.toLocaleString()}</td>
                            </tr>
                            <tr>
                                <td>Cancel</td>
                                <td style="text-align: center">${summary.cancel.toLocaleString()}</td>
                            </tr>
                            <tr class="table-active">
                                <th>Total</th>
                                <th style="text-align: center">${(summary.done + summary.pending + summary.cancel).toLocaleString()}</th>
                            </tr>
                        `);

                        $('#tbodyStatusWoSortir').append(`
                            <tr>
                                <td>Done</td>
                                <td style="text-align: center">${summary.doneSortir.toLocaleString()}</td>
                            </tr>
                            <tr>
                                <td>Pending</td>
                                <td style="text-align: center">${summary.pendingSortir.toLocaleString()}</td>
                            </tr>
                            <tr>
                                <td>Cancel</td>
                                <td style="text-align: center">${summary.cancelSortir.toLocaleString()}</td>
                            </tr>
                            <tr class="table-active">
                                <th>Total</th>
                                <th style="text-align: center">${(summary.doneSortir + summary.pendingSortir + summary.cancelSortir).toLocaleString()}</th>
                            </tr>
                        `);

                        for(x=0; x < summary.detPenagihan.length; x++) {

                            $('#tbodyRootCouseOri').append(`
                                <tr>
                                    <th>${summary.detPenagihan[x].action_taken}</th>
                                    <th style="text-align: center">
                                        ${summary.detPenagihan[x].jml.toLocaleString()}
                                    </th>
                                </tr>
                            `);

                            totRootOri = totRootOri + summary.detPenagihan[x].jml

                            // for(y=0; y < summary.detCouseCode.length; y++) {

                                // if(summary.detPenagihan[x].penagihan == summary.detCouseCode[y].penagihan) {
                                    // $('#tbodyRootCouseOri').append(`
                                        // <tr>
                                            // <th style="text-indent: 20px">${summary.detCouseCode[y].reason_status}</th>
                                            // <th style="text-align: center">
                                                // ${summary.detCouseCode[y].jml.toLocaleString()}
                                            // </th>
                                        // </tr>
                                    // `);

                                    // for(z=0; z < summary.detRootCouse.length; z++) {

                                        // if(summary.detPenagihan[x].penagihan == summary.detRootCouse[z].penagihan &&
                                            // summary.detCouseCode[y].couse_code== summary.detRootCouse[z].couse_code) {
                                                // $('#tbodyRootCouseOri').append(`
                                                    // <tr>
                                                        // <td style="text-indent: 40px">
                                                            // ${summary.detRootCouse[z].root_couse}
                                                        // </td>
                                                        // <td style="text-align: center">
                                                            // ${summary.detRootCouse[z].jml.toLocaleString()}
                                                        // </td>
                                                    // </tr>
                                                // `);

                                                // totRootOri = totRootOri + summary.detRootCouse[z].jml
                                        // }
                                    // }
                                // }
                            // }

                        }

                        //rootcouse Sortir
                        for(x=0; x < summary.detPenagihanSortir.length; x++) {

                            $('#tbodyRootCouseSortir').append(`
                                <tr>
                                    <th>${summary.detPenagihanSortir[x].action_taken}</th>
                                    <th style="text-align: center">
                                        ${summary.detPenagihanSortir[x].jml.toLocaleString()}
                                    </th>
                                </tr>
                            `);

                            totRootSortir = totRootSortir + summary.detPenagihanSortir[x].jml

                            // for(y=0; y < summary.detCouseCodeSortir.length; y++) {

                                // if(summary.detPenagihanSortir[x].penagihan == summary.detCouseCodeSortir[y].penagihan) {
                                    // $('#tbodyRootCouseSortir').append(`
                                        // <tr>
                                            // <th style="text-indent: 20px">${summary.detCouseCodeSortir[y].reason_status}</th>
                                            // <th style="text-align: center">
                                                // ${summary.detCouseCodeSortir[y].jml.toLocaleString()}
                                            // </th>
                                        // </tr>
                                    // `);

                                    // for(z=0; z < summary.detRootCouseSortir.length; z++) {

                                        // if(summary.detPenagihanSortir[x].penagihan == summary.detRootCouseSortir[z].penagihan &&
                                            // summary.detCouseCodeSortir[y].couse_code== summary.detRootCouseSortir[z].couse_code) {
                                                // $('#tbodyRootCouseSortir').append(`
                                                    // <tr>
                                                        // <td style="text-indent: 40px">
                                                            // ${summary.detRootCouseSortir[z].root_couse}
                                                        // </td>
                                                        // <td style="text-align: center">
                                                            // ${summary.detRootCouseSortir[z].jml.toLocaleString()}
                                                        // </td>
                                                    // </tr>
                                                // `);

                                                // totRootSortir = totRootSortir + summary.detRootCouseSortir[z].jml
                                        // }
                                    // }
                                // }
                            // }

                        }

                        $('#tbodyRootCouseOri').append(`
                            <tr>
                                <th>Total</th>
                                <th style="text-align: center">${totRootOri.toLocaleString()}</th>
                            </tr>
                        `);

                        $('#tbodyRootCouseSortir').append(`
                            <tr>
                                <th>Total</th>
                                <th style="text-align: center">${totRootSortir.toLocaleString()}</th>
                            </tr>
                        `);

                    }

                });
            });


            $(document).ready(function() {
                
                akses = $('#akses').val();
                fetch_data()

                function fetch_data() {
                    $('#dataTempFtthIb').DataTable({
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
                            url: "{{ route('import.dataImportFttxMTTemp') }}",
                            type: "post",
                            dataType: "json",
                            data: {
                                akses: akses,
                                _token : _token
                            }

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

                            {data: `no_so`},
                            {data: `no_wo`},
                            {data: `wo_date`},
                            {data: `mt_date`},
                            {data: `wo_type`},
                            {data: `cust_name`},
                            {data: `cust_address`},
                            {data: `area`},
                            {data: `site`},
                            {data: `packages_type`},
                            {data: `service_type`},
                            {data: `slot_time`},
                            {data: `teknisi1`},
                            {data: `teknisi2`},
                            {data: `teknisi3`},
                            {data: `leader`},
                            {data: `branch`},
                            {data: `callsign`},
                            {data: `nopol`},
                            {data: `start`},
                            {data: `finish`},
                            {data: `report_wa`},
                            {data: `fdt_code`},
                            {data: `fat_code`},
                            {data: `fat_port`},
                            {data: `signal_fat`},
                            {data: `signal_tb`},
                            {data: `signal_ont`},
                            {data: `ont_sn_out`},
                            {data: `ont_mac_out`},
                            {data: `ont_sn_in`},
                            {data: `ont_mac_in`},
                            {data: `stb2_sn`},
                            {data: `stb2_mac`},
                            {data: `stb3_sn`},
                            {data: `stb3_mac`},
                            {data: `router_sn`},
                            {data: `router_mac`},
                            {data: `drop_cable`},
                            {data: `precon`},
                            {data: `fast_connector`},
                            {data: `termination_box`},
                            {data: `patch_cord_3m`},
                            {data: `patch_cord_10m`},
                            {data: `screw_hanger`},
                            {data: `indor_cable_duct`},
                            {data: `pvc_pipe_20mm`},
                            {data: `socket_pvc_20mm`},
                            {data: `clamp_pvc_20mm`},
                            {data: `flexible_pvc_20mm`},
                            {data: `clamp_cable`},
                            {data: `cable_lan`},
                            {data: `connector_rj45`},
                            {data: `cable_marker`},
                            {data: `insulation`},
                            {data: `cable_ties`},
                            {data: `adapter_optic`},
                            {data: `fisher`},
                            {data: `paku_beton`},
                            {data: `splitter`},
                            {data: `status_wo`},
                            {data: `root_couse`},
                            {data: `action_taken`},
                            {data: `remarks`},
                            {data: 'login'},


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
