@extends('layout.main')

@section('content')
    <div class="row" id="mychart">

        {{-- <div class="row"> --}}

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    {{-- <form action="#"> --}}
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label class="form-text">Bulan Laporan</label>
                                <select class="col form-control-sm" id="bulanReport" name="bulanReport" required>
                                    <option value="">Pilih Bulan Report</option>
                                    @foreach ($trendMonthly as $bulan)
                                        <option value="{{ $bulan->bulan }}">{{ $bulan->bulan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-sm btn-success filterDashBoard"
                                        id="filterDashBoard">Filter</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm" hidden>
                            <label class="form-text">Periode Tanggal</label>
                            <input class="col form-control-sm" type="text" name="periode" id ="periode"
                                value="01/01/2018 - 01/15/2018" />
                        </div>

                        <div class="col-sm">
                            <label class="form-text">Site</label>
                            <select class="col form-control-sm" id="site">
                                <option value="All">All</option>
                                <option value="Retail">FTTH Retail</option>
                                <option value="Apartemen">FTTH Apartemen</option>
                                <option value="Underground">FTTH Underground</option>

                            </select>
                        </div>

                        <div class="col-sm">
                            <label class="form-text">Branch</label>
                            <select class="col form-control-sm" id="branch">
                                <option value="All">All</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->nama_branch }}">{{ $branch->nama_branch }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-sm">
                            <label class="form-text">Type WO</label>
                            <select class="col form-control-sm" id="typePenagihanIB">
                                <option value="All">All</option>
                                <option value="New Installation">New Installation</option>
                                <option value="Additional Service STB">Additional Service STB</option>
                                {{-- @foreach ($penagihanIB as $ib) --}}
                                    {{-- <option value="{{ $ib->penagihan }}">{{ $ib->penagihan }}</option> --}}
                                {{-- @endforeach --}}

                            </select>
                        </div>

                    </div>

                    {{-- </form> --}}
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Summary WO FTTH <span id="CardTitle1">New Installation & Additional Service STB</span> - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen,
                            Underground)</h5>
                    </h6>
                    <div class="clearfix" id="smWO" style="display: none">
                        <div class="spinner-border float-right" role="status">
                            <span class="sr-only" >Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body" id="canvasTotWOIB">
                    {{-- <canvas id="TotWoMt"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body" id="canvasTotWOIBClose">
                    {{-- <canvas id="TotWoMtClose"></canvas> --}}
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body" id="canvasTotIBDone">
                    {{-- <canvas id="TotWoMt"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body" id="canvasTotIBPending">
                    {{-- <canvas id="TotWoMtClose"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body" id="canvasTotIBCancel">
                    {{-- <canvas id="TotWoMt"></canvas> --}}
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataTotAsetDt"
                            style="font-size: 12px">
                            <thead>
                                <tr id="theadTotWo">
                                    <th>WO New Installation</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;"></th> --}}
                                </tr>
                            </thead>
                            <tbody id="totWoBranch">

                            </tbody>
                            <tfoot>
                                <tr id="totalWo">
                                    <th>Total WO</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataCloseWOIb" width="100%"
                            cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr id="theadTotWoClose">
                                    <th>WO New Installation Close</th>
                                </tr>
                            </thead>
                            <tbody id="totWoCloseBranch">
                            </tbody>
                            <tfoot>
                                <tr id="totWoClose">
                                    <th>Total</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataCloseWOIb" width="100%"
                            cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr id="theadTotWoPending">
                                    <th>WO New Installation Failed</th>
                                </tr>
                            </thead>
                            <tbody id="totWoPendingBranch">
                            </tbody>
                            <tfoot>
                                <tr id="totWoPending">
                                    <th>Total</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataCloseWOIb" width="100%"
                            cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr id="theadTotWoCancel">
                                    <th>WO New Installation Cancel</th>
                                </tr>
                            </thead>
                            <tbody id="totWoCancelBranch">
                            </tbody>
                            <tfoot>
                                <tr id="totWoCancel">
                                    <th>Total</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Summary WO FTTH <span id="CardTitle1">New Installation & Additional Service STB</span> By Cluster Area - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen, Underground)<h5></h6>
                    <div class="clearfix" id="smWOCluster" style="display: none">
                        <div class="spinner-border float-right" role="status">
                            <span class="sr-only" >Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- Root Couse Sortir MT --}}
        <div class="col-sm-12">
            {{-- <div class="col"> --}}
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="font-size: 11px; table-layout: auto;" id="tableCluster">
                            <thead>
                                <tr id="tableHeadCluster">
                                </tr>
                            </thead>
                            <tbody id="bodyCluster">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Root Couse Sortir MT --}}
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Trend WO FTTH <span id="CardTitle1">New Installation & Additional Service STB</span> - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen,
                            Underground)<h5>
                    </h6>
                    <div class="clearfix" id="smWOTrend" style="display: none">
                        <div class="spinner-border float-right" role="status">
                            <span class="sr-only" >Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendTotWo"></h6>
                    <canvas id="TrendTotWoIBFtth" style="align-content: center; align-items: center"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoClose"></h6>
                    <canvas id="TrendTotWoIBFtthClose"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" id="canvasTrendDialyWo">

                    {{-- <canvas id="TrendTotWoIBFtthApart" style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataTotAsetDt"
                            width="100%" cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr id="dateMonth">
                                    <th>WO New Installation</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">1</th> --}}
                                    {{-- <th style="text-align: center; vertical-align: middle;">2</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="woDone">
                                    <td>Done</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">857</td> --}}
                                </tr>
                                <tr id="woPending">
                                    <td>New Installation Failed</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">545</td> --}}
                                </tr>
                                <tr id="woCancel">
                                    <td>Cancel</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">770</td> --}}
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr id="totWo">
                                    <th>Total WO</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">3,895</th> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Summary WO FTTH <span id="CardTitle1">New Installation & Additional Service STB </span> Done<h5 id="CardTitle"> All Branch - All Site (Retail,
                            Apartemen, Underground)<h5>
                    </h6>
                    <div class="clearfix" id="smWOClosing" style="display: none">
                        <div class="spinner-border float-right" role="status">
                            <span class="sr-only" >Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" id="canvasRootCouseAPK">

                    {{-- <canvas id="TrendTotWoIBFtthApart" style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="row">

        {{-- Root Couse Sortir MT --}}
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered border-primary" style="font-size: 11px; table-layout: auto;">
                    <thead>
                        <tr id="rootCouseHeadAPK">
                        </tr>
                    </thead>
                    <tbody id="bodyRootCouseAPK">
                    </tbody>
                </table>
            </div>
        </div>
        {{-- End Root Couse Sortir MT --}}
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Summary WO FTTH <span id="CardTitle1">New Installation & Additional Service </span> Pending - <h5 id="CardTitle">All Branch - All Site (Retail,
                            Apartemen, Underground)<h5>
                                </h6>
                    <div class="clearfix" id="smWOPending" style="display: none">
                        <div class="spinner-border float-right" role="status">
                            <span class="sr-only" >Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" id="canvasRootCouseAPKPending">

                    {{-- <canvas id="TrendTotWoIBFtthApart" style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="rootCousePendingtable"
                            cellspacing="0" style="font-size: 12px">
                            <thead id="rootCouseHeadPending">
                            </thead>
                            <tbody id="rootCouseTbPending">
                            </tbody>
                            <tfoot>
                                <tr id="totRootCousePending">
                                    <th>Total</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Summary WO FTTH <span id="CardTitle1">New Installation & Additional Service STB </span> Cancel - <h5 id="CardTitle">All Branch - All Site (Retail,
                            Apartemen, Underground)<h5>
                    </h6>
                    <div class="clearfix" id="smWOCancel" style="display: none">
                        <div class="spinner-border float-right" role="status">
                            <span class="sr-only" >Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" id="canvasRootCouseAPKCancel">

                    {{-- <canvas id="TrendTotWoIBFtthApart" style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="rootCouseCanceltable"
                            cellspacing="0" style="font-size: 12px">
                            <thead id="rootCouseHeadCancel">
                                {{-- <tr> --}}
                                {{-- <th>Root Couse</th> --}}
                                {{-- <th style="text-align: center; vertical-align: middle;">1</th> --}}
                                {{-- <th style="text-align: center; vertical-align: middle;">2</th> --}}
                                {{-- </tr> --}}
                            </thead>
                            <tbody id="rootCouseTbCancel">
                                {{-- <tr id="woDone"> --}}
                                {{-- <td>Done</td> --}}
                                {{-- <td style="text-align: center; vertical-align: middle;">857</td> --}}
                                {{-- </tr> --}}
                                {{-- <tr id="woPending"> --}}
                                {{-- <td>Installation Failed</td> --}}
                                {{-- <td style="text-align: center; vertical-align: middle;">545</td> --}}
                                {{-- </tr> --}}
                                {{-- <tr id="woCancel"> --}}
                                {{-- <td>Cancel</td> --}}
                                {{-- <td style="text-align: center; vertical-align: middle;">770</td> --}}
                                {{-- </tr> --}}
                            </tbody>
                            <tfoot>
                                <tr id="totRootCouseCancel">
                                    <th>Total</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">3,895</th> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- modal rusak detail APK--}}

    <div class="modal fade" id="md-detail" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-rusakAset">

                    <div class="row">
                        <div class="col-sm">
                            <div class="card">
                                <div class="card-body" id="canvasDetailAPK">
                                    {{-- <canvas id="TotWoMt"></canvas> --}}
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataDetailRoot" width="100%" cellspacing="0"
                            style="font-size: 12px; table-layout: auto;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>type_wo</th>
                                    <th>no_wo</th>
                                    <th>cust_id</th>
                                    <th>nama_cust</th>
                                    <th>kode_fat</th>
                                    <th>kode_wilayah</th>
                                    <th>cluster</th>
                                    <th>kotamadya</th>
                                    <th>kotamadya_penagihan</th>
                                    <th>branch</th>
                                    <th>tgl_ikr</th>
                                    <th>slot_time_apk</th>
                                    <th>sesi</th>
                                    <th>callsign</th>
                                    <th>leader</th>
                                    <th>teknisi1</th>
                                    <th>teknisi2</th>
                                    <th>teknisi3</th>
                                    <th>status_wo</th>
                                    <th>reason status</th>
                                    <th>penagihan</th>
                                    <th>alasan cancel</th>
                                    <th>alasan pending</th>
                                    <th>weather</th>
                                    <th>validasi_start</th>
                                    <th>validasi_end</th>
                                    <th>checkin_apk</th>
                                    <th>checkout_apk</th>
                                    <th>status_apk</th>
                                    <th>ms_regular</th>
                                    <th>wo_date_apk</th>
                                    <th>wo_date_mail_reschedule</th>
                                    <th>wo_date_slot_tim_apk</th>
                                    <th>slot_time_assign_apk</th>
                                    <th>slot_time_apk_delay</th>
                                    <th>status_slot_time_apk_delay</th>
                                    <th>ket_delay_slot_time</th>
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
                                    <th>fast_connector</th>
                                    <th>patchcord</th>
                                    <th>terminal_box</th>
                                    <th>remote_fiberhome</th>
                                    <th>remote_extrem</th>
                                    <th>port_fat</th>
                                    <th>site_penagihan</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" class="btn  btn-primary">Save</button> --}}
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal detail APK --}}

@endsection

@section('script')
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.js"></script>


    {{-- <script src="{{ $chart->cdn() }}"></script> --}}

    {{-- {{ $chart->script() }} --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script> --}}
    <script src="{{ asset('assets/js/chartjs-plugin-datalabels.min.js') }}"></script>

    <script type="text/javascript">
        let firstDate;
        let lastDate;

        $('#periode').daterangepicker({
            startDate: moment().startOf(),
            endDate: moment().startOf(),
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $(document).on('change', '#bulanReport', function() {
            bln = new Date($(this).val()).getMonth();
            thn = new Date($(this).val()).getFullYear();

            firstDate = moment([thn, bln]);
            lastDate = moment(firstDate).endOf('month');

            $('#periode').data('daterangepicker').setStartDate(firstDate);
            $('#periode').data('daterangepicker').setEndDate(lastDate);

        });

        
        $(document).on('change', '#branch', function() {
            let filBranch = $(this).val()

            $.ajax({
                url: "{{ route('getFilterBranchIBFtth') }}",
                type: "GET",
                data: {
                    branchReport: filBranch
                },
                success: function(filterBranch) {
                    $('#kotamadya').find("option").remove();

                    $('#kotamadya').append(`
                        <option value="All">All</option>
                    `);

                    $.each(filterBranch, function(key, item) {
                        $('#kotamadya').append(`
                            <option value="${item.kotamadya_penagihan}">${item.kotamadya_penagihan}</option>
                        
                        `);

                    })
                }
            })
        });
    </script>

    <script type="text/javascript">

        var _token = $('meta[name=csrf-token]').attr('content');

        function det_click(apk_id)
        {
            let months = ["jan","Feb","Mar","Apr","May","Jun","Jul","Agt","Sept","Oct","Nov","Dec"];
            let dataSource;
            let datafilter;
            let detailTitle;
            let detailSubTitle;
            let filSite = $('#site').val();
            let filBranch = $('#branch').val();

            let detAPK = apk_id.split("|");
            
            // Reason Status Detail
            if(detAPK[0]=="reason_status"){
                if(detAPK[1]=="penagihan") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1], 
                            detPenagihan: detAPK[2],
                            detBulan: detAPK[3],
                            detThn: detAPK[4],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = '';
                }

                if(detAPK[1]=="total") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1], 
                            detPenagihan: detAPK[2],
                            detBulan: detAPK[3],
                            detThn: detAPK[4],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = '';
                }

                bulanData = months[datafilter.detBulan - 1] + "-" + datafilter.detThn;
            }
            // end reason status Detail

            // Pending Detail
            if(detAPK[0]=="pending"){
                if(detAPK[1]=="penagihan") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1], 
                            detPenagihan: detAPK[2],
                            detBulan: detAPK[3],
                            detThn: detAPK[4],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = '';
                }

                if(detAPK[1]=="total") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1], 
                            detPenagihan: detAPK[2],
                            detBulan: detAPK[3],
                            detThn: detAPK[4],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = '';
                }

                bulanData = months[datafilter.detBulan - 1] + "-" + datafilter.detThn;
            }
            // end Pending Detail

            // Cancel Detail
            if(detAPK[0]=="cancel"){
                if(detAPK[1]=="penagihan") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1], 
                            detPenagihan: detAPK[2],
                            detBulan: detAPK[3],
                            detThn: detAPK[4],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = '';
                }

                if(detAPK[1]=="total") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1], 
                            detPenagihan: detAPK[2],
                            detBulan: detAPK[3],
                            detThn: detAPK[4],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = '';
                }

                bulanData = months[datafilter.detBulan - 1] + "-" + datafilter.detThn;
            }
            // end Cancel Detail            

            

            $('#md-detail').modal('show');
            $('#canvasDetailAPK').empty();
            event.stopPropagation()

            $.ajax({
                url: "{{ route('getDetailAPKIb') }}",
                type: "GET",
                data: datafilter,
                beforeSend: () => {
                    $("#smDetWO").show();
                },
                complete: () => {
                    $("#smDetWO").hide();
                },
                success: function(detAPK) {

                    dataSource = detAPK.detailAPK;
                    var totDetailAPK = detAPK;
                    // var totDetailAPK = totDetailAPK.sort((a,b) => b.done - a.done);
                    var ChrBranchAPK = [];
                    var ChrBranchTot = [];

                    $.each(detAPK.detailBranchAPK, function(key, item) {

                        ChrBranchAPK.push(item.branch);
                        ChrBranchTot.push([Number(item.total)]);

                    });

                    $('#canvasDetailAPK').empty();

                    let chartBranchAPK = `
                    <figure class="highcharts-figure">
                        <div id="detailAPK"></div>
                    </figure>
                    `;

                    $('#canvasDetailAPK').append(chartBranchAPK);

                    Highcharts.chart('detailAPK', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: detailTitle.replaceAll('_',' '),
                            align: 'left'
                        },
                        subtitle: {
                            text: detailSubTitle,
                            align: 'left'
                        },
                        xAxis: {
                            categories: ChrBranchAPK, // ['Africa', 'America', 'Asia', 'Europe'],
                            title: {
                                text: null
                            },
                            gridLineWidth: 3,
                            lineWidth: 0
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: bulanData,
                                // align: 'high'
                            },
                            labels: {
                                overflow: 'justify'
                            },
                            gridLineWidth: 0
                        },
                        // tooltip: {
                        //     valueSuffix: ' millions'
                        // },
                        plotOptions: {
                            bar: {
                                borderRadius: '10%',
                                dataLabels: {
                                    enabled: true
                                },
                                groupPadding: 0.1
                            }
                        },
                        legend:{ enabled:false },
                        credits: {
                            enabled: false
                        },
                        series: [{
                            name: '',
                            data: ChrBranchTot // [631, 727, 3202, 721]
                        }]
                    });

                    fetch_detail();
                }                
            })

            function fetch_detail() {
                    var tabel = $('#dataDetailRoot').DataTable();
                    tabel.clear().draw();

                    $('#dataDetailRoot').DataTable({
                        // dom: 'Bftip',
                        layout: {
                            topStart: {
                                buttons: ['excel']
                            }
                        },
                        paging: true,
                        orderClasses: false,
                        
                        // fixedColumns: true,

                        // fixedColumns: {
                        //     // leftColumns: 4,
                        //     rightColumns: 1
                        // },
                        deferRender: true,
                        scrollCollapse: true,
                        scrollX: true,
                        // scrollY: 300,
                        // pageLength: 10,
                        lengthChange: false,
                        bFilter: true,
                        destroy: true,
                        processing: true,
                        serverSide: false,
                        // oLanguage: {
                        //     sZeroRecords: "Tidak Ada Data",
                        //     sSearch: "Pencarian _INPUT_",
                        //     sLengthMenu: "_MENU_",
                        //     sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        //     sInfoEmpty: "0 data",
                        //     oPaginate: {
                        //         sNext: "<i class='fa fa-angle-right'></i>",
                        //         sPrevious: "<i class='fa fa-angle-left'></i>"
                        //     }
                        // },
                        ajax: {
                            url: "{{ route('dataDetailAPKIb') }}",
                            type: "get",
                            dataType: "json",
                            data: datafilter
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
                            // {
                            //     data: 'slot_time_leader'
                            // },
                            {
                                data: 'slot_time_apk'
                            },
                            {
                                data: 'sesi'
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
                                data: 'reason_status'
                            },
                            {
                                data: 'penagihan'
                            },
                            // {
                            //     data: 'alasan_tag_alarm'
                            // },
                            // {
                            //     data: 'tgl_jam_reschedule'
                            // },
                            // {
                            //     data: 'tgl_jam_fat_on'
                            // },
                            {
                                data: 'alasan_cancel'
                            },
                            {
                                data: 'alasan_pending'
                            },
                            {
                                data: 'weather'
                            },
                            // {
                            //     data: 'start_ikr_wa'
                            // },
                            // {
                            //     data: 'end_ikr_wa'
                            // },
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
                            // {
                            //     data: 'konfirmasi_penjadwalan'
                            // },
                            // {
                            //     data: 'konfirmasi_cst'
                            // },
                            // {
                            //     data: 'konfirmasi_dispatch'
                            // },
                            // {
                            //     data: 'remark_status2'
                            // },
                            // {
                            //     data: 'login'
                            // },

                            // {
                            //     data: 'gender',
                            //     "className": "text-center"      
                            // },                                   
                            // {
                            //     data: 'action',
                            //     "className": "text-center",
                            //     orderable: false,
                            //     searchable: false
                            // },
                        ]
                    });


                }
        }
    </script>


    <script type="text/javascript">
        $(document).on('click', '.closeDetailToday', function() {
            $('#canvasTotWOIB').empty();
            $('#canvasTotWOIBClose').empty();
        })

        $('#filterDashBoard').on('click', function(e) {

            e.preventDefault();
            if ($('#bulanReport').val() === "") {
                alert('Pilih Bulan Report');
                return;
            }

            let bulanReport = $('#bulanReport').val();

            let trendWoIBFtth;
            var dataResult;

            let filBulanReport = $('#bulanReport').val();
            let filTglPeriode = $('#periode').val();
            let filPeriodeStart = $('#periode').data('daterangepicker').startDate.format("YYYY-MM-DD");
            let filPeriodeEnd = $('#periode').data('daterangepicker').endDate.format("YYYY-MM-DD");
            let filSite = $('#site').val();
            let filBranch = $('#branch').val();
            let filKotamadya = $('#kotamadya').val();
            let typePenagihanIB = $('#typePenagihanIB').val();

            let title1;
            let titleBranch;
            let titleSite;

            if (filBranch == "All") {
                titleBranch = "All Branch";
            } else {
                titleBranch = "Branch " + filBranch;
            }

            if (filSite == "All") {
                titleSite = "All Site (Retail, Apartemen, Underground)";
            } else {
                titleSite = "Site " + filSite;
            }

            if (typePenagihanIB == "All"){
                title1 = "New Installation & Additional Service STB"
            }        
            if (typePenagihanIB == "New Installation"){
                title1 = "New Installation"
            }
            if (typePenagihanIB == "Additional Service STB"){
                title1 = "Additional Service STB"
            }

            document.querySelectorAll('#CardTitle1').forEach(function(elem) {
                elem.innerText = title1;
            })

            document.querySelectorAll('#CardTitle').forEach(function(elem) {
                elem.innerText = titleBranch + " - " + titleSite;
            })

            $.ajax({
                url: "{{ route('getMonthlyIBFtth') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd

                },
                success: function(dataTrendMonthly) {
                    // var trendWoMt = {!! $trendMonthly !!}
                    trendWoIBFtth = dataTrendMonthly;

                }

            })

            
 
            let uri;
            if ((filSite == "All") && (filBranch == "All") && (typePenagihanIB == "All")) {
                uri = "{{ route('getTotalWoBranchIBFtth') }}";
            } else {
                uri = "{{ route('getFilterDashboardIBFtth') }}";
            }

            $.ajax({
                // url: "{{ route('getTotalWoBranch') }}",
                url: uri, //( filSite == "All" ) ? "{{ route('getTotalWoBranch') }}" : "{{ route('getFilterDashboard') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport,
                    filterBulan: filBulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    typePenagihanIB: typePenagihanIB
                    
                },
                beforeSend: () => {
                    $("#smWO").show();
                },
                complete: () => {
                    $("#smWO").hide();
                },
                success: function(dataTotalWo) {

                    var totWoMt = dataTotalWo;

                    var branch = [];
                    var totWo = [];
                    var totWoDone = [];
                    var branchWTot = [];

                    $.each(totWoMt, function(key, item) {

                        branch.push(item.nama_branch);
                        totWoDone.push([item.nama_branch + " " + parseInt(item.done), parseInt(item.done)]);
                        branchWTot.push([item.nama_branch + " " + parseInt(item.total), parseInt(item.total)]);

                        totWo.push(parseInt(item.total));


                    });


                    $('#canvasTotWOIB').empty();


                    let chartWoType = `
					<figure class="highcharts-figure">
					    <div id="containerTotWoIB"></div>
					</figure>
				    `;

                    $('#canvasTotWOIB').append(chartWoType);

                    Highcharts.chart('containerTotWoIB', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: 'Total WO FTTH ' + title1 + ' ' + bulanReport,
                        },
                        // tooltip: {
                        //     valueSuffix: '%'
                        // },
                        // subtitle: {
                        //     text:
                        //     'MDPI'
                        // },
                        plotOptions: {
                            series: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: [{
                                    enabled: true,
                                    distance: 30
                                }]
                            }
                        },
                        series: [{
                            name: 'Total WO',
                            colorByPoint: true,
                            data: branchWTot

                        }]
                    });



                    $('#canvasTotWOIBClose').empty();

                    let chartWoTypeClose = `
					<figure class="highcharts-figure">
					    <div id="containerTotWoIBClose"></div>
					</figure>
				    `;

                    $('#canvasTotWOIBClose').append(chartWoTypeClose);

                    Highcharts.chart('containerTotWoIBClose', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: 'Total WO FTTH ' + title1 + ' Done ' + bulanReport,
                        },
                        tooltip: {
                            valueSuffix: '%'
                        },
                        // subtitle: {
                        //     text:
                        //     'MDPI'
                        // },
                        plotOptions: {
                            series: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: [{
                                    enabled: true,
                                    distance: 30
                                }]
                            }
                        },
                        series: [{
                            name: 'Total WO',
                            colorByPoint: true,
                            data: totWoDone

                        }]
                    });


                    var totChartDone = dataTotalWo;
                    var totChartDone = totChartDone.sort((a,b) => b.done - a.done);
                    var ChrBranchDone = [];
                    var ChrDone = [];

                    $.each(totChartDone, function(key, item) {

                        ChrBranchDone.push(item.nama_branch);
                        ChrDone.push([parseInt(item.done)]);

                    });

                    $('#canvasTotIBDone').empty();

                    let chartIBDone = `
					<figure class="highcharts-figure">
					    <div id="TotIBDone"></div>
					</figure>
				    `;

                    $('#canvasTotIBDone').append(chartIBDone);

                    Highcharts.chart('TotIBDone', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO FTTH ' + title1 + ' Done ', //+ bulanReport,
                            align: 'left',
                            style: {
                                fontSize: '13px' 
                            }
                        },
                        subtitle: {
                            text: bulanReport,
                            align: 'left'
                        },
                        xAxis: {
                            categories: ChrBranchDone, // ['Africa', 'America', 'Asia', 'Europe'],
                            title: {
                                text: null
                            },
                            gridLineWidth: 3,
                            lineWidth: 0
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: '',
                                align: 'high'
                            },
                            labels: {
                                overflow: 'justify'
                            },
                            gridLineWidth: 0
                        },
                        // tooltip: {
                        //     valueSuffix: ' millions'
                        // },
                        plotOptions: {
                            bar: {
                                borderRadius: '10%',
                                dataLabels: {
                                    enabled: true
                                },
                                groupPadding: 0.1
                            }
                        },
                        
                        credits: {
                            enabled: false
                        },
                        series: [{
                            name: 'WO Done',
                            data: ChrDone // [631, 727, 3202, 721]
                        }]
                    });

                    var totChartPending = dataTotalWo;
                    var totChartPending = totChartPending.sort((a,b) => b.pending - a.pending);
                    var ChrBranchPending = [];
                    var ChrPending = [];

                    $.each(totChartPending, function(key, item) {

                        ChrBranchPending.push(item.nama_branch);
                        ChrPending.push([parseInt(item.pending)]);

                    });

                    $('#canvasTotIBPending').empty();

                    let chartIBPending = `
					<figure class="highcharts-figure">
					    <div id="TotIBPending"></div>
					</figure>
				    `;

                    $('#canvasTotIBPending').append(chartIBPending);

                    Highcharts.chart('TotIBPending', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO FTTH ' + title1 + ' Pending ', // + bulanReport,
                            align: 'left',
                            style: {
                                fontSize: '13px' 
                            }
                        },
                        subtitle: {
                            text: bulanReport,
                            align: 'left'
                        },
                        xAxis: {
                            categories: ChrBranchPending, // ['Africa', 'America', 'Asia', 'Europe'],
                            title: {
                                text: null
                            },
                            gridLineWidth: 3,
                            lineWidth: 0
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: '',
                                align: 'high'
                            },
                            labels: {
                                overflow: 'justify'
                            },
                            gridLineWidth: 0
                        },
                        // tooltip: {
                        //     valueSuffix: ' millions'
                        // },
                        plotOptions: {
                            bar: {
                                borderRadius: '10%',
                                dataLabels: {
                                    enabled: true
                                },
                                groupPadding: 0.1
                            }
                        },
                        
                        credits: {
                            enabled: false
                        },
                        series: [{
                            name: 'WO Pending',
                            data: ChrPending // [631, 727, 3202, 721]
                        }]
                    });

                    var dataChartCancel = dataTotalWo;
                    var totChartCancel = dataChartCancel.sort((a,b) => b.cancel - a.cancel);
                    var ChrBranchCancel = [];
                    var ChrCancel = [];

                    $.each(totChartCancel, function(key, item) {

                        ChrBranchCancel.push(item.nama_branch);
                        ChrCancel.push([parseInt(item.cancel)]);

                    });

                    $('#canvasTotIBCancel').empty();

                    let chartIBCancel = `
					<figure class="highcharts-figure">
					    <div id="TotIBCancel"></div>
					</figure>
				    `;

                    $('#canvasTotIBCancel').append(chartIBCancel);

                    Highcharts.chart('TotIBCancel', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO FTTH ' + title1 + ' Cancel ', // + bulanReport,
                            align: 'left',
                            style: {
                                fontSize: '13px' 
                            }
                        },
                        subtitle: {
                            text: bulanReport,
                            align: 'left'
                        },
                        xAxis: {
                            categories: ChrBranchCancel, // ['Africa', 'America', 'Asia', 'Europe'],
                            title: {
                                text: null
                            },
                            gridLineWidth: 3,
                            lineWidth: 0
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: '',
                                align: 'high'
                            },
                            labels: {
                                overflow: 'justify'
                            },
                            gridLineWidth: 0
                        },
                        // tooltip: {
                        //     valueSuffix: ' millions'
                        // },
                        plotOptions: {
                            bar: {
                                borderRadius: '10%',
                                dataLabels: {
                                    enabled: true
                                },
                                groupPadding: 0.1
                            }
                        },
                        
                        credits: {
                            enabled: false
                        },
                        series: [{
                            name: 'WO Cancel',
                            data: ChrCancel // [631, 727, 3202, 721]
                        }]
                    });

                    var totWo = 0;
                    var totWoClose = 0;
                    var totWoPending = 0;
                    var totWoCancel = 0;

                    $('#totWoBranch').find("tr").remove();
                    $('#totWoCloseBranch').find("tr").remove();
                    $('#totWoPendingBranch').find("tr").remove();
                    $('#totWoCancelBranch').find("tr").remove();
                    $('#theadTotWo').find("th").remove();
                    $('#theadTotWoClose').find("th").remove();
                    $('#theadTotWoPending').find("th").remove();
                    $('#theadTotWoCancel').find("th").remove();

                    $('#theadTotWo').append(`
                        <th>Total WO</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoClose').append(`
                        <th>WO Done</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoPending').append(`
                        <th>WO Pending</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoCancel').append(`
                        <th>WO Cancel</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    let nmBranch;

                    dataTotalWo.sort((a,b) => a.id - b.id);

                    $.each(dataTotalWo, function(key, item) {

                        // if(item.site_penagihan == "Retail"){
                        nmBranch = item.nama_branch;
                        // }
                        // if((item.site_penagihan == "Apartemen") || (item.site_penagihan == "Underground")){
                        // nmBranch = item.site_penagihan;
                        // }

                        var totPersenIB = 0;

                        $.each(dataTotalWo, function(key, totItem){
                            totPersenIB = Number(totPersenIB) + Number(totItem.total);
                        })

                        let tbTotalWo = `
                            <tr>
                                <td>${nmBranch}</td>
                                <td style="text-align: center">${item.total.toLocaleString()}</td>
                                <td style="text-align: center">${parseFloat(item.persenTotal).toFixed(1).replace(/\.0$/, '')}%</td>
                            </tr>    
                        `;

                        totWo = Number(totWo) + Number(item.total);

                        $('#totWoBranch').append(tbTotalWo);


                        let tbWoClose = `
                            <tr>
                                <td>${nmBranch}</td>
                                <td style="text-align: center">${parseInt(item.done).toLocaleString()}</td>
                                <td style="text-align: center">${parseFloat(item.persenDone).toFixed(1).replace(/\.0$/, '')}%</td>
                            </tr>    
                        `;

                        totWoClose = Number(totWoClose) + Number(item.done);

                        $('#totWoCloseBranch').append(tbWoClose);

                        let tbWoPending = `
                            <tr>
                                <td>${nmBranch}</td>
                                <td style="text-align: center">${parseInt(item.pending).toLocaleString()}</td>
                                <td style="text-align: center">${parseFloat(item.persenPending).toFixed(1).replace(/\.0$/, '')}%</td>
                            </tr>    
                        `;

                        totWoPending = Number(totWoPending) + Number(item.pending);
                        $('#totWoPendingBranch').append(tbWoPending);

                        let tbWoCancel = `
                            <tr>
                                <td>${nmBranch}</td>
                                <td style="text-align: center">${parseInt(item.cancel).toLocaleString()}</td>
                                <td style="text-align: center">${parseFloat(item.persenCancel).toFixed(1).replace(/\.0$/, '')}%</td>
                            </tr>    
                        `;

                        totWoCancel = Number(totWoCancel) + Number(item.cancel);
                        $('#totWoCancelBranch').append(tbWoCancel);


                    });

                    $('#totalWo').find("th").remove();
                    $('#totWoClose').find("th").remove();
                    $('#totWoPending').find("th").remove();
                    $('#totWoCancel').find("th").remove();

                    let isiTotalWo = `
                        <th>Total WO</th>
                        <th style="text-align: center; vertical-align: middle;">${totWo.toLocaleString()}</th>
                    `;

                    $('#totalWo').append(isiTotalWo);

                    persenTotClose = (Number(totWoClose) * 100) / Number(totWo);

                    let isiTotalWoClose = `
                    <th>Total Done</th>
                        <th style="text-align: center; vertical-align: middle;">${parseInt(totWoClose).toLocaleString()}</th>
                        <th style="text-align: center; vertical-align: middle;">${parseFloat(persenTotClose).toFixed(1).replace(/\.0$/, '')}%</th>
                    `;


                    $('#totWoClose').append(isiTotalWoClose);

                    persenTotPending = (Number(totWoPending) * 100) / Number(totWo);

                    let isiTotalWoPending = `
                    <th>Total Pending</th>
                        <th style="text-align: center; vertical-align: middle;">${totWoPending.toLocaleString()}</th>
                        <th style="text-align: center; vertical-align: middle;">${parseFloat(persenTotPending).toFixed(1).replace(/\.0$/, '')}%</th>
                    `;
                    $('#totWoPending').append(isiTotalWoPending);

                    persenTotCancel = (totWoCancel * 100) / totWo;

                    let isiTotalWoCancel = `
                    <th>Total Cancel</th>
                        <th style="text-align: center; vertical-align: middle;">${totWoCancel.toLocaleString()}</th>
                        <th style="text-align: center; vertical-align: middle;">${parseFloat(persenTotCancel).toFixed(1).replace(/\.0$/, '')}%</th>
                    `;
                    $('#totWoCancel').append(isiTotalWoCancel);

                }

            })

            $.ajax({
                url: "{{ route('getClusterBranchIBFtth') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    typePenagihanIB: typePenagihanIB
                },
                beforeSend: () => {
                    $("#smWOCluster").show();
                },
                complete: () => {
                    $("#smWOCluster").hide();
                },
                success: function(dataCluster) {    
                    $('#tableHeadCluster').find("th").remove();
                    $('#bodyCluster').find("tr").remove();

                    let subtotal
                    let TotMonthCluster = [];
                    let TotBranchCluster = [];
                    let tbBranchCluster;
                    let tbCouseCodeAPK;
                    let tbRootCouseAPK;
                    let hdRootCouseAPK = `
                        <th>Branch</th>
                        <th>Cluster</th>`;
                        // <th>Root Couse</th>`;
                        // <th style="text-align: center">Jumlah</th>`;

                    for (h = 0;h < trendWoIBFtth.length; h++) {
                        hdRootCouseAPK = hdRootCouseAPK +
                            `<th colspan="2" style="text-align: center">${trendWoIBFtth[h].bulan.toLocaleString()}</th>`
                    }

                    $('#tableHeadCluster').append(hdRootCouseAPK); // + `</tr>`);

                    $('#tableHeadCluster').append(`<th style="text-align: center">Subtotal</th></tr>`);


                    $.each(dataCluster.branchCluster, function(key, nmBranch) {

                        tbBranchCluster = `
                                <tr class="table-secondary"><th>${nmBranch.nmTbranch}</th>
                                <th class="table-secondary"></th>`;
                                // <th class="table-secondary"></th>`;
                        
                        subtotal = 0
                        for (p=0;p<trendWoIBFtth.length; p++) {

                            TotMonthCluster[p]=0
                            $.each(dataCluster.branchCluster, function(key, jmlBln){
                                TotMonthCluster[p] += Number(jmlBln.totbulanan[p]);
                            })

                            tbBranchCluster = tbBranchCluster +
                                `<th class="table-secondary" style="text-align: center">${Number(nmBranch.totbulanan[p]).toLocaleString()}</th>
                                <th class="table-secondary" style="text-align: center">${parseFloat((nmBranch.totbulanan[p]*100)/TotMonthCluster[p]).toFixed().replace(/\.0$/, '')}%</th>`;

                            subtotal += Number(nmBranch.totbulanan[p]);

                        }

                        $('#bodyCluster').append(tbBranchCluster + 
                                    `<th class="table-secondary" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);


                        $.each(dataCluster.detCluster, function(key, itemCluster) {
                            if (nmBranch.nmTbranch == itemCluster.nama_branch) {
                                tbCluster = `
                                    <tr><td></td>
                                    <td>${itemCluster.cluster}</td>`;
                                    // <th class="table-info"></th>`;
                                
                                subtotal = 0;

                                for (cc = 0;cc < trendWoIBFtth.length; cc++) {

                                    TotMonthCluster[cc]=0
                                    $.each(dataCluster.detCluster, function(ky, jmlBlnCL){
                                        TotMonthCluster[cc] += Number(jmlBlnCL.bulanan[cc]);
                                    })

                                    tbCluster = tbCluster + 
                                    `<td style="text-align: center">${itemCluster.bulanan[cc].toLocaleString()}</td>
                                    <td style="text-align: center">${parseFloat((itemCluster.bulanan[cc]*100)/TotMonthCluster[cc]).toFixed(1).replace(/\.0$/, '')}%</td>`;

                                    subtotal += Number(itemCluster.bulanan[cc]);
                                }

                                $('#bodyCluster').append(tbCluster + 
                                                `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`);

                            }
                        });
                    });

                    let totBulananCluster = `
                        <tr><th class="table-dark">TOTAL</th>
                            <th class="table-dark"></th>`;
                    

                    subtotal=0;
                    for (p=0;p<trendWoIBFtth.length; p++) {
                        TotBranchCluster[p] = 0
                        $.each(dataCluster.branchCluster, function(key, totBranchCl) {
                            TotBranchCluster[p] += Number(totBranchCl.totbulanan[p]);
                        })

                        totBulananCluster = totBulananCluster + 
                        `<th class="table-dark" style="text-align: center">${TotBranchCluster[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;

                        subtotal += TotBranchCluster[p];
                    }

                    $('#bodyCluster').append(totBulananCluster + 
                                `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);

                }

            });

            $.ajax({
                url: "{{ route('getTrendMonthlyIBFtth') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    typePenagihanIB: typePenagihanIB

                },
                beforeSend: () => {
                    $("#smWOTrend").show();
                },
                complete: () => {
                    $("#smWOTrend").hide();
                },
                success: function(dataTrendMonthly) {
                    trendWoIBFtth = dataTrendMonthly;

                    document.querySelectorAll('#titleTrendTotWo').forEach(function(elem){
                        elem.innerText = 'Trend Total WO FTTH ' + title1 + ' ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoClose').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH ' + title1 + ' Done ' + titleBranch + " - " + bulanReport; 
                    })

                    var trendMonth = [''];
                    var trendTotIBFtth = ['null'];
                    var trendIBDone = ['null'];

                    $.each(trendWoIBFtth, function(key, item) {
                        
                        trendMonth.push(item.bulan);
                        trendTotIBFtth.push(item.trendIBFtthTotal);
                        trendIBDone.push(item.trendIBFtthDone);

                    });

                    trendMonth.push('');
                    trendTotIBFtth.push('null');
                    trendIBDone.push('null');

                    const ctxTrendTotWoIBFtth = document.getElementById('TrendTotWoIBFtth');

                    var graphTrendTotWoIBFtth = Chart.getChart('TrendTotWoIBFtth');
                    if (graphTrendTotWoIBFtth) {
                        graphTrendTotWoIBFtth.destroy();
                    }



                    var ChartTrendTotWoIB = new Chart(ctxTrendTotWoIBFtth, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendTotIBFtth, //[3895],
                                borderWidth: 1,

                            }]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    display: false,

                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    display: 'auto',
                                    formatter: function(value) {
                                        return value.toLocaleString();}
                                },
                                title: {
                                    display: 'auto',
                                    // text: 'Trend WO FTTH ' + title1,
                                    // align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: true, //this will remove all the x-axis grid lines
                                    // max: 6000,
                                    // grace: '10%',
                                    ticks: {
                                            // beginAtZero: true,
                                            stepSize: 1000,
                                            // stepValue: 500,
                                            // max: 6000
                                        }
                                }
                            }
                        },
                        plugins: [ChartDataLabels],

                    });

                    var maxChartTot = ChartTrendTotWoIB.scales.y.max;

                    const ctxTrendTotWoIBFtthClose = document.getElementById('TrendTotWoIBFtthClose');

                    var graphTrendTotWoIBFtthClose = Chart.getChart('TrendTotWoIBFtthClose');
                    if (graphTrendTotWoIBFtthClose) {
                        graphTrendTotWoIBFtthClose.destroy();
                    }

                    var ChartTrendTotWoIBClose = new Chart(ctxTrendTotWoIBFtthClose, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendIBDone, //[3082, 3597],
                                borderWidth: 1,

                            }]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    display: false,

                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    display: 'auto',
                                    formatter: function(value) {
                                        return value.toLocaleString();
                                    }
                                },
                                title: {
                                    display: 'auto',
                                    // text: 'Trend WO FTTH ' + title1 + ' Done',
                                    // align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: true, //this will remove all the x-axis grid lines
                                    // max: maxChartTot,
                                    // grace: '10%',
                                    ticks: {
                                            // beginAtZero: true,
                                            stepSize: 1000,
                                            // stepValue: 500,
                                            // max: 6000
                                        }
                                }
                            }
                        },
                        plugins: [ChartDataLabels],

                    });

                    var maxChartTot = ChartTrendTotWoIB.scales.y.max;
                    var minChartTotClose = ChartTrendTotWoIBClose.scales.y.min;
                    ChartTrendTotWoIBClose.options.scales.y.max = ChartTrendTotWoIB.scales.y.max;
                    ChartTrendTotWoIB.options.scales.y.min= minChartTotClose;

                    ChartTrendTotWoIBClose.update();
                    ChartTrendTotWoIB.update();

                }

            })

            $.ajax({
                url: "{{ route('getTabelStatusIBFtth') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    typePenagihanIB: typePenagihanIB

                },
                success: function(data) {

                    // var day = new Date(tahun, bulan, 0).getDate();
                    var day = [];
                    var daytb;
                    var doneDay = [];
                    var pendingDay = [];
                    var cancelDay = [];
                    var donetb;
                    var totDone = 0;
                    var totPending = 0;
                    var totCancel = 0;
                    var totWo = 0;
                    var total = 0;

                    $('#dateMonth').find("th").remove();
                    $('#dateMonth').append(`<th>Status WO ${titleBranch}</th>`)

                    $('#woDone').find("td").remove();
                    $('#woDone').find("th").remove();
                    $('#woDone').append("<td>Done</td>")

                    $('#woPending').find("td").remove();
                    $('#woPending').find("th").remove();
                    $('#woPending').append("<td>Pending</td>")

                    $('#woCancel').find("td").remove();
                    $('#woCancel').find("th").remove();
                    $('#woCancel').append("<td>Cancel</td>")

                    $('#totWo').find("td").remove()
                    $('#totWo').find("th").remove()
                    $('#totWo').append("<th>Total Wo</th>")


                    $.each(data, function(key, item) {
                        // day.push(new Date(item.tgl_ikr).getDate());
                        day.push(new Date(item.tgl_ikr).getDate());
                        doneDay.push(item.Done);
                        pendingDay.push(item.Pending);
                        cancelDay.push(item.Cancel);

                        let htgl = `
                           <th>${new Date(item.tgl_ikr).getDate()}</th>
                        `;

                        $('#dateMonth').append(htgl);

                        let dtDone = `
                            <td>${item.Done.toLocaleString()}</td>
                        `;

                        $('#woDone').append(dtDone);

                        totDone += item.Done;

                        let dtPending = `
                            <td>${item.Pending.toLocaleString()}</td>
                        `;

                        $('#woPending').append(dtPending);

                        totPending += item.Pending;
                        totCancel += item.Cancel;

                        let dtCancel = `
                            <td>${item.Cancel.toLocaleString()}</td>
                        `;

                        $('#woCancel').append(dtCancel)

                        totWo = item.Done + item.Pending + item.Cancel

                        let dtTotWo = `
                            <td>${totWo.toLocaleString()}</td>
                        `;

                        $('#totWo').append(dtTotWo);


                    });

                    $('#dateMonth').append("<th>Total</th>")

                    $('#woDone').append(`<th>${totDone.toLocaleString()}</th>`)

                    $('#woPending').append(`<th>${totPending.toLocaleString()}</th>`)

                    $('#woCancel').append(`<th>${totCancel.toLocaleString()}</th>`)

                    total = totDone + totPending + totCancel

                    $('#totWo').append(`<th>${total.toLocaleString()}</th>`)

                    $('#dateMonth').append(`<th>%</th>`)

                    $('#woDone').append(`<th>${((totDone * 100) / total).toFixed(1).replace(/\.0$/, '')}%</th>`)
                    $('#woPending').append(
                        `<th>${parseFloat((totPending * 100) / total).toFixed(1).replace(/\.0$/, '')}%</th>`)
                    $('#woCancel').append(
                        `<th>${parseFloat((totCancel * 100) / total).toFixed(1).replace(/\.0$/, '')}%</th>`)


                    // graph line dialy //

                    $('#canvasTrendDialyWo').empty();

                    let chartTrendDialyWo = `
					<figure class="highcharts-figure">
					    <div id="conTrendDialyWo"></div>
					</figure>
				    `;

                    $('#canvasTrendDialyWo').append(chartTrendDialyWo);

                    Highcharts.chart('conTrendDialyWo', {

                        title: {
                            text: 'Status WO FTTH ' + title1 + ' - ' + titleBranch + ' ' +
                                bulanReport,
                            align: 'left'
                        },


                        xAxis: {
                            categories: day
                        },

                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },

                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            },
                            series: {
                                label: {
                                    connectorAllowed: false
                                },

                            }
                        },

                        series: [{
                            name: 'WO Done',
                            data: doneDay //[
                            //43934, 48656, 65165, 81827, 112143, 142383,
                            //171533, 165174, 155157, 161454, 154610
                            //]
                        }, {
                            name: 'WO Pending',
                            data: pendingDay //[
                            //24916, 37941, 29742, 29851, 32490, 30282,
                            //38121, 36885, 33726, 34243, 31050
                            //]
                        }, {
                            name: 'WO Cancel',
                            data: cancelDay //[
                            //11744, 30000, 16005, 19771, 20185, 24377,
                            //32147, 30912, 29243, 29213, 25663
                            //]
                        }],

                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: 'horizontal',
                                        align: 'center',
                                        verticalAlign: 'bottom'
                                    }
                                }
                            }]
                        }

                    });

                }

            })
            

            $.ajax({
                url: "{{ route('getReasonStatusIBFtthGraph') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    typePenagihanIB: typePenagihanIB

                },
                success: function(data) {
                    // var day = new Date(tahun, bulan, 0).getDate();
                    var dayGraph = [];
                    var nameGraph = [];
                    var nameDataGraph = [];
                    var objDataGraph = {};
                    var dayApk = [];
                    var pendingDay = [];
                    var cancelDay = [];
                    var donetb;
                    var totDone = 0;
                    var totPending = 0;
                    var totCancel = 0;
                    var totWo = 0;
                    var total = 0;

                    for (tg = 0; tg < data.tglGraphAPK.length; tg++) {
                        // console.log(data.tglGraphAPK[tg].tgl_ikr)
                        dayGraph.push(new Date(data.tglGraphAPK[tg].tgl_ikr).getDate())


                    }

                    for (nm = 0; nm < data.nameGraphAPK.length; nm++) {
                        // console.log(data.nameGraphAPK[nm].penagihan);
                        nameGraph.push({
                            name: data.nameGraphAPK[nm].penagihan
                        });
                        // objDataGraph.name= data.nameGraphAPK[nm].penagihan;

                        // for(dt=0;dt<data.dataGraphAPK.length;dt++){
                        // console.log(data.dataGraphAPK[dt].data);
                        nameGraph[nm]['data'] = data.dataGraphAPK[nm].data
                        // }

                    }

                    // graph line dialy //

                    $('#canvasRootCouseAPK').empty();

                    let chartRootCouseAPKDialy = `
					<figure class="highcharts-figure">
					    <div id="conRooCouseAPKDialy"></div>
					</figure>
				    `;

                    $('#canvasRootCouseAPK').append(chartRootCouseAPKDialy);

                    Highcharts.chart('conRooCouseAPKDialy', {

                        title: {
                            text: 'Daily Report Done WO FTTH ' + title1 + ' - ' +
                                titleBranch + ' ' + bulanReport,
                            align: 'left'
                        },


                        xAxis: {
                            categories: dayGraph
                        },

                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },

                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            },
                            series: {
                                label: {
                                    connectorAllowed: false
                                },

                            }
                        },

                        series: nameGraph, //[{
                        // name: 'WO Done',
                        // data: doneDay //[
                        //43934, 48656, 65165, 81827, 112143, 142383,
                        //171533, 165174, 155157, 161454, 154610
                        //]
                        // }, {
                        // name: 'WO Pending',
                        // data: pendingDay //[
                        //24916, 37941, 29742, 29851, 32490, 30282,
                        //38121, 36885, 33726, 34243, 31050
                        //]
                        // }, {
                        // name: 'WO Cancel',
                        // data: cancelDay //[
                        //11744, 30000, 16005, 19771, 20185, 24377,
                        //32147, 30912, 29243, 29213, 25663
                        //]
                        // }],

                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: 'horizontal',
                                        align: 'center',
                                        verticalAlign: 'bottom'
                                    }
                                }
                            }]
                        }

                    });

                }

            })

            $.ajax({
                url: "{{ route('getRootCouseAPKIBFtth') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    typePenagihanIB: typePenagihanIB
                },
                beforeSend: () => {
                    $("#smWOClosing").show();
                },
                complete: () => {
                    $("#smWOClosing").hide();
                },
                success: function(apk) {

                    $('#rootCouseHeadAPK').find("th").remove();
                    $('#bodyRootCouseAPK').find("tr").remove();
                    $('#penagihanAPK').find("th").remove();
                    $('#couseCodePenagihanAPK').find("th").remove();
                    $('#rootCousePenagihanAPK').find("td").remove();

                    let subtotal;
                    let TotPenagihan = [];
                    let tbPenagihanAPK;
                    let tbCouseCodeAPK;
                    let tbRootCouseAPK;
                    let blnId;
                    let thnId;
                    let detailCel;

                    let hdRootCouseAPK = `
                        <th>Status Done</th>`;
                        // <th>Reason Status</th>`;
                        // <th>Root Couse</th>`;
                    // <th style="text-align: center">Jumlah</th>`;

                    for (h = 0; h < trendWoIBFtth.length; h++) {
                        hdRootCouseAPK = hdRootCouseAPK +
                            `<th colspan="2" style="text-align: center">${trendWoIBFtth[h].bulan.toLocaleString()}</th>`
                    }

                    $('#rootCouseHeadAPK').append(hdRootCouseAPK + 
                            `<th style="text-align: center">Subtotal</th></tr>`);

                    let TotMonthly = [];
                    $.each(apk.detPenagihanSortir, function(key, itemPenagihan) {

                        tbPenagihanAPK = `
                                    <tr><th>${itemPenagihan.penagihan}</th>`;
                                    // <th class="table-secondary"></th>`;
                                    // <th class="table-secondary"></th>`;
                    
                        subtotal = 0;
                        for (p = 0; p < trendWoIBFtth.length; p++) {

                            TotMonthly[p] = 0
                        
                            $.each(apk.detPenagihanSortir, function(key, iPenagihan) {
                                TotMonthly[p] += Number(iPenagihan.bulanan[p]);
                            })

                            blnId = new Date(trendWoIBFtth[p].bulan).getMonth();
                            thnId = new Date(trendWoIBFtth[p].bulan).getFullYear();
                            detailCel = `reason_status|penagihan|${itemPenagihan.penagihan}|${(blnId + 1)}|${thnId}`;

                            tbPenagihanAPK = tbPenagihanAPK +
                                `<th style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${itemPenagihan.bulanan[p].toLocaleString()}</th>
                                <th style="text-align: center">${((itemPenagihan.bulanan[p] * 100) / TotMonthly[p]).toFixed(1).replace(/\.0$/, '')}%</th>`;

                            subtotal += Number(itemPenagihan.bulanan[p]);

                        }

                        $('#bodyRootCouseAPK').append(tbPenagihanAPK + 
                                `<th style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);

                    });

                    let totRootCouseAPK = `
                            <tr><th class="table-dark">TOTAL</th>`;
                    
                    subtotal=0;
                    for (p = 0; p < trendWoIBFtth.length; p++) {
                        TotPenagihan[p] = 0
                        
                        $.each(apk.detPenagihanSortir, function(key, iPenagihan) {
                            TotPenagihan[p] += Number(iPenagihan.bulanan[p]);
                        })

                        totRootCouseAPK = totRootCouseAPK +
                            `<th class="table-dark" style="text-align: center">${TotPenagihan[p].toLocaleString()}</th>
                            <th class="table-dark" style="text-align: center"></th>`;

                        subtotal += TotPenagihan[p];
                    }

                    $('#bodyRootCouseAPK').append(totRootCouseAPK + 
                            `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);

                }

            });

            $.ajax({
                url: "{{ route('getRootCousePendingGraphIBFtth') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    typePenagihanIB: typePenagihanIB

                },
                success: function(data) {
                    // var day = new Date(tahun, bulan, 0).getDate();
                    var dayGraphPending = [];
                    var nameGraphPending = [];
                    var nameDataGraphPending = [];
                    var objDataGraph = {};
                    var dayApk = [];
                    var pendingDay = [];
                    var cancelDay = [];
                    var donetb;
                    var totDone = 0;
                    var totPending = 0;
                    var totCancel = 0;
                    var totWo = 0;
                    var total = 0;

                    for (tg = 0; tg < data.tglGraphAPKPending.length; tg++) {
                        // console.log(data.tglGraphAPK[tg].tgl_ikr)
                        dayGraphPending.push(new Date(data.tglGraphAPKPending[tg].tgl_ikr).getDate())


                    }

                    for (nm = 0; nm < data.nameGraphAPKPending.length; nm++) {
                        // console.log(data.nameGraphAPK[nm].penagihan);
                        nameGraphPending.push({
                            name: data.nameGraphAPKPending[nm].penagihan
                        });
                        // objDataGraph.name= data.nameGraphAPK[nm].penagihan;

                        // for(dt=0;dt<data.dataGraphAPK.length;dt++){
                        // console.log(data.dataGraphAPK[dt].data);
                        nameGraphPending[nm]['data'] = data.dataGraphAPKPending[nm].data
                        // }

                    }

                    // graph line dialy //

                    $('#canvasRootCouseAPKPending').empty();

                    let chartRootCouseAPKDialy = `
					<figure class="highcharts-figure">
					    <div id="conRooCouseAPKDialyPending"></div>
					</figure>
				    `;

                    $('#canvasRootCouseAPKPending').append(chartRootCouseAPKDialy);

                    Highcharts.chart('conRooCouseAPKDialyPending', {

                        title: {
                            text: 'Daily Report Pending WO FTTH ' + title1 + ' - ' +
                                titleBranch + ' ' + bulanReport,
                            align: 'left'
                        },


                        xAxis: {
                            categories: dayGraphPending
                        },

                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },

                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            },
                            series: {
                                label: {
                                    connectorAllowed: false
                                },

                            }
                        },

                        series: nameGraphPending, 

                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: 'horizontal',
                                        align: 'center',
                                        verticalAlign: 'bottom'
                                    }
                                }
                            }]
                        }

                    });

                }

            })

            $.ajax({
                url: "{{ route('getRootCousePendingIBFtth') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    typePenagihanIB: typePenagihanIB
                },
                beforeSend: () => {
                    $("#smWOPending").show();
                },
                complete: () => {
                    $("#smWOPending").hide();
                },
                success: function(dataRootCousePending) {

                    $('#rootCouseHeadPending').find("tr").remove();
                    $('#rootCouseTbPending').find("tr").remove();
                    $('#totRootCousePending').find("th").remove();

                    let blnId;
                    let thnId;
                    let detailCel;
                    let subtotal;
                    var TotPenagihanPending = [];
                    var TotRootDonePending = 0;
                    let tbRootCousePending;
                    let hdRootCousePending = `
                        <tr>
                                <th>Status WO Pending</th>
                        </tr>`;

                    $('#rootCouseHeadPending').append(hdRootCousePending);

                    for (b = 0; b < trendWoIBFtth.length; b++) {
                        $('#rootCouseHeadPending').find("tr").append(
                            `<th colspan="2" style="text-align: center">${trendWoIBFtth[b].bulan.toLocaleString()}</th>`
                        )
                    }

                    $('#rootCouseHeadPending').find("tr").append(
                            `<th style="text-align: center">Subtotal</th>`
                    )

                    $.each(dataRootCousePending, function(key, item) {
                        
                        tbRootCousePending = `
                            <tr>
                            <td>${item.penagihan}</td>`;
                        
                        subtotal = 0;
                        for (bln = 0; bln < trendWoIBFtth.length; bln++) {
                            
                            blnId = new Date(trendWoIBFtth[bln].bulan).getMonth();
                            thnId = new Date(trendWoIBFtth[bln].bulan).getFullYear();
                            detailCel = `pending|penagihan|${item.penagihan}|${(blnId + 1)}|${thnId}`;

                            tbRootCousePending = tbRootCousePending +
                                `<td style="text-align: center" id="${detailCel}" onClick="det_click(this.id)"">${item.bulanan[bln].toLocaleString()}</td>
                                <td style="text-align: center">${parseFloat(item.persen[bln]).toFixed(1).replace(/\.0$/, '')}%</td>`;

                            subtotal += Number(item.bulanan[bln]);
                        }

                        tbRootCousePending = tbRootCousePending; // + `</tr>`;
                        $('#rootCouseTbPending').append(tbRootCousePending + 
                                    `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`
                        );

                    });

                    let totRootPending = `
                        <th class="table-dark">TOTAL</th>`;

                    subtotal = 0;
                    for (p=0;p<trendWoIBFtth.length; p++) {
                        TotPenagihanPending[p] = 0;
                        
                        $.each(dataRootCousePending, function(key, iPenagihan) {
                            TotPenagihanPending[p] += Number(iPenagihan.bulanan[p]);
                        })

                        totRootPending = totRootPending + 
                        `<th class="table-dark" style="text-align: center">${TotPenagihanPending[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;

                        subtotal += TotPenagihanPending[p];
                    }

                    $('#totRootCousePending').append(totRootPending + 
                        `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`
                    );
                }

            });

            $.ajax({
                url: "{{ route('getRootCouseCancelGraphIBFtth') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    typePenagihanIB: typePenagihanIB

                },
                success: function(data) {
                    // var day = new Date(tahun, bulan, 0).getDate();
                    var dayGraphCancel = [];
                    var nameGraphCancel = [];
                    var nameDataGraphCancel = [];
                    var objDataGraph = {};
                    var dayApk = [];
                    var pendingDay = [];
                    var cancelDay = [];
                    var donetb;
                    var totDone = 0;
                    var totPending = 0;
                    var totCancel = 0;
                    var totWo = 0;
                    var total = 0;

                    for (tg = 0; tg < data.tglGraphAPKCancel.length; tg++) {
                        // console.log(data.tglGraphAPK[tg].tgl_ikr)
                        dayGraphCancel.push(new Date(data.tglGraphAPKCancel[tg].tgl_ikr).getDate())


                    }

                    for (nm = 0; nm < data.nameGraphAPKCancel.length; nm++) {
                        // console.log(data.nameGraphAPK[nm].penagihan);
                        nameGraphCancel.push({
                            name: data.nameGraphAPKCancel[nm].penagihan
                        });
                        // objDataGraph.name= data.nameGraphAPK[nm].penagihan;

                        // for(dt=0;dt<data.dataGraphAPK.length;dt++){
                        // console.log(data.dataGraphAPK[dt].data);
                        nameGraphCancel[nm]['data'] = data.dataGraphAPKCancel[nm].data
                        // }

                    }

                    // graph line dialy //

                    $('#canvasRootCouseAPKCancel').empty();

                    let chartRootCouseAPKDialyCancel = `
					<figure class="highcharts-figure">
					    <div id="conRooCouseAPKDialyCancel"></div>
					</figure>
				    `;

                    $('#canvasRootCouseAPKCancel').append(chartRootCouseAPKDialyCancel);

                    Highcharts.chart('conRooCouseAPKDialyCancel', {

                        title: {
                            text: 'Daily Report Cancel WO FTTH ' + title1 + ' - ' +
                                titleBranch + ' ' + bulanReport,
                            align: 'left'
                        },


                        xAxis: {
                            categories: dayGraphCancel
                        },

                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },

                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            },
                            series: {
                                label: {
                                    connectorAllowed: false
                                },

                            }
                        },

                        series: nameGraphCancel, 

                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: 'horizontal',
                                        align: 'center',
                                        verticalAlign: 'bottom'
                                    }
                                }
                            }]
                        }

                    });

                }

            })


            $.ajax({
                url: "{{ route('getRootCouseCancelIBFtth') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    typePenagihanIB: typePenagihanIB
                },
                beforeSend: () => {
                    $("#smWOCancel").show();
                },
                complete: () => {
                    $("#smWOCancel").hide();
                },
                success: function(dataRootCouseCancel) {

                    $('#rootCouseHeadCancel').find("tr").remove();
                    $('#rootCouseTbCancel').find("tr").remove();
                    $('#totRootCouseCancel').find("th").remove();

                    let blnId;
                    let thnId;
                    let detailCel;
                    let subtotal;
                    var TotPenagihanCancel = [];
                    var TotRootDoneCancel = 0;
                    let tbRootCouseCancel;
                    let hdRootCouseCancel = `
                        <tr>
                                <th>Status WO Cancel</th>
                        </tr>`;

                    $('#rootCouseHeadCancel').append(hdRootCouseCancel);

                    for (b = 0; b < trendWoIBFtth.length; b++) {
                        $('#rootCouseHeadCancel').find("tr").append(
                            `<th colspan="2" style="text-align: center">${trendWoIBFtth[b].bulan.toLocaleString()}</th>`
                        )
                    }

                    $('#rootCouseHeadCancel').find("tr").append(
                            `<th style="text-align: center">Subtotal</th>`
                        )

                    $.each(dataRootCouseCancel, function(key, item) {
                        
                        tbRootCouseCancel = `
                            <tr>
                                <td>${item.penagihan}</td>`;
                        
                        subtotal = 0;

                        for (bln = 0; bln < trendWoIBFtth.length; bln++) {

                            blnId = new Date(trendWoIBFtth[bln].bulan).getMonth();
                            thnId = new Date(trendWoIBFtth[bln].bulan).getFullYear();
                            detailCel = `cancel|penagihan|${item.penagihan}|${(blnId + 1)}|${thnId}`;

                            tbRootCouseCancel = tbRootCouseCancel +
                                `<td style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${item.bulanan[bln].toLocaleString()}</td>
                                <td style="text-align: center">${parseFloat(item.persen[bln]).toFixed(1).replace(/\.0$/, '')}%</td>`;

                            subtotal += Number(item.bulanan[bln]);
                        }
                        

                        tbRootCouseCancel = tbRootCouseCancel;
                        $('#rootCouseTbCancel').append(tbRootCouseCancel  + 
                                `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`);

                    });

                    let totRootCancel = `
                        <th class="table-dark">TOTAL</th>`;
                            // <th class="table-dark"></th>
                            // <th class="table-dark"></th>`;
                            // <th class="table-dark" style="text-align: center">totpenagihan</th></tr>`;

                    subtotal = 0;
                    for (p=0;p<trendWoIBFtth.length; p++) {
                        TotPenagihanCancel[p] = 0;
                        
                        $.each(dataRootCouseCancel, function(key, iPenagihan) {
                            TotPenagihanCancel[p] += Number(iPenagihan.bulanan[p]);
                        })

                        totRootCancel = totRootCancel + 
                        `<th class="table-dark" style="text-align: center">${TotPenagihanCancel[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;

                        subtotal += TotPenagihanCancel[p];
                    }

                    $('#totRootCouseCancel').append(totRootCancel +
                        `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th>`
                    );
                }

            });


        });

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        let blnDashboard = urlParams.get('dashBoard');

        if (blnDashboard != null){

        document.getElementById('bulanReport').value= blnDashboard;

        $('#bulanReport').change();
        $('#filterDashBoard').click();

        
        }

    </script>
@endsection
