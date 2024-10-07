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
                                    {{-- <option>All</option>
                                        <option>FTTH</option>
                                        <option>FTTX/B</option> --}}
                                </select>
                            </div>
                            {{-- <div class="row"> --}}
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-sm btn-success filterDashBoard"
                                        id="filterDashBoard">Filter</button>
                                </div>
                            </div>

                            {{-- </div> --}}
                        </div>

                        <div class="col-sm" hidden>
                            <label class="form-text">Periode Tanggal</label>
                            <input class="col form-control-sm" type="text" name="periode" id ="periode"
                                value="01/01/2018 - 01/15/2018" />
                        </div>

                        {{-- <div class="col-sm">
                                <label class="form-text">Project</label>
                                <select class="col form-control-sm">
                                    <option>All</option>
                                    <option>FTTH</option>
                                    <option>FTTX/B</option>
                                </select>
                            </div> --}}

                        <div class="col-sm" hidden>
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
                    <h6>Summary WO FTTX Maintenance - <h5 id="CardTitle">All Branch</h5>
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
                <div class="card-body" id="canvasTotIBDonex">
                    {{-- <canvas id="TotWoMt"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body" id="canvasTotIBPendingx">
                    {{-- <canvas id="TotWoMtClose"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body" id="canvasTotIBCancelx">
                    {{-- <canvas id="TotWoMtClose"></canvas> --}}
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
                                    <th>WO FTTX MT</th>
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
                                    <th>WO FTTX MT Close</th>
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
                                    <th>WO FTTX MT Failed</th>
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
                                    <th>WO FTTX MT Cancel</th>
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
                    <h6>Trend WO FTTX Maintenance - <h5 id="CardTitle">All Branch<h5>
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
                    <canvas id="TrendTotWoIBFtth" style="align-content: center; align-items: center"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
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
                                    <th>WO MT FTTX</th>
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
                                    <td>WO MT FTTX Failed</td>
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
                    <h6>Summary Closing WO FTTX Maintenance<h5 id="CardTitle">All Branch<h5>
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
                            {{-- <th>Root Couse Penagihan (Sortir)</th> --}}
                            {{-- <th></th> --}}
                            {{-- <th></th> --}}
                            {{-- <th style="text-align: center">Jumlah</th> --}}
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
        {{-- Root Couse Sortir MT --}}
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered border-primary" style="font-size: 11px; table-layout: auto;">
                    <thead>
                        <tr id="rootCouseHeadAPKDetail">
                            {{-- <th>Root Couse Penagihan (Sortir)</th> --}}
                            {{-- <th></th> --}}
                            {{-- <th></th> --}}
                            {{-- <th style="text-align: center">Jumlah</th> --}}
                        </tr>
                    </thead>
                    <tbody id="bodyRootCouseAPKDetail">
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
                    <h5>Summary Root Couse Failed WO FTTX Maintenance - <h5 id="CardTitle">All Branch<h5></h6>
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
                    <h5>Summary Root Couse Cancel WO FTTX Maintenance - <h5 id="CardTitle">All Branch<h5></h6>
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
                            </thead>
                            <tbody id="rootCouseTbCancel">
                            </tbody>
                            <tfoot>
                                <tr id="totRootCouseCancel">
                                    <th>Total</th>
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
                                    {{-- <th>action</th> --}}
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

    {{-- detail cluster Chart--}}

    <div class="modal fade" id="md-detailAPKCluster" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Cluster per Branch </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-rusakAsetCluster">

                    <div class="row">
                        <div class="col-sm">
                            <div class="card">
                                <div class="card-body" id="canvasDetailAPKCluster">
                                    {{-- <canvas id="TotWoMt"></canvas> --}}
                                </div>
                            </div>
                        </div>
                    </div>
        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">back</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal detail cluster Chart --}}
   
@endsection

@section('script')
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    {{-- <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.css" rel="stylesheet"> --}}
    {{-- <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.js"></script> --}}

    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css" rel="stylesheet">

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script> --}}
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
{{-- <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script> --}}


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
            // console.log("firsDate : ", firstDate.toDate());
            // console.log("lastDate : ", lastDate.toDate());

            $('#periode').data('daterangepicker').setStartDate(firstDate);
            $('#periode').data('daterangepicker').setEndDate(lastDate);

        });


        $(document).on('change', '#branch', function() {
            let filBranch = $(this).val()

            $.ajax({
                url: "{{ route('getFilterBranchMTFttx') }}",
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
        let detailClikChart;
        let filSite = $('#site').val();
        let filBranch = $('#branch').val();

        let detAPK = apk_id.split("|");

         
        // RootCause APK
        if(detAPK[0]=="rootCouseAPK"){
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
                detailClikChart = detAPK[0]+"|"+detAPK[1]+"|"+detAPK[2]+"|"+detAPK[3]+"|"+detAPK[4];
            }
            if(detAPK[1]=="couse_code") {
                datafilter = {
                        detSlide: detAPK[0],
                        detKategori: detAPK[1], 
                        detPenagihan: detAPK[2],
                        detCouse_code: detAPK[3],
                        detBulan: detAPK[4],
                        detThn: detAPK[5],
                        detSite: filSite,
                        detBranch: filBranch,
                        _token: _token
                };

                detailTitle = detAPK[2];
                detailSubTitle = detAPK[3];
                detailClikChart = detAPK[0]+"|"+detAPK[1]+"|"+detAPK[2]+"|"+detAPK[3]+"|"+detAPK[4]+"|"+detAPK[5];
            }
            if(detAPK[1]=="root_couse") {
                datafilter = {
                        detSlide: detAPK[0],
                        detKategori: detAPK[1], 
                        detPenagihan: detAPK[2],
                        detCouse_code: detAPK[3],
                        detRoot_couse: detAPK[4],
                        detBulan: detAPK[5],
                        detThn: detAPK[6],
                        detSite: filSite,
                        detBranch: filBranch,
                        _token: _token
                };

                detailTitle = detAPK[2];
                detailSubTitle = detAPK[3] + " - " + detAPK[4];
                detailClikChart = detAPK[0]+"|"+detAPK[1]+"|"+detAPK[2]+"|"+detAPK[3]+"|"+detAPK[4]+"|"+detAPK[5]+"|"+detAPK[6];
            }

            
        }
        // End RootCause APK

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
                detailClikChart = detAPK[0]+"|"+detAPK[1]+"|"+detAPK[2]+"|"+detAPK[3]+"|"+detAPK[4];
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
                detailClikChart = detAPK[0]+"|"+detAPK[1]+"|"+detAPK[2]+"|"+detAPK[3]+"|"+detAPK[4];
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
        }
        // end Cancel Detail
        
        bulanData = months[datafilter.detBulan - 1] + "-" + datafilter.detThn;

        $('#md-detail').modal('show');
        $('#canvasDetailAPK').empty();
        event.stopPropagation()

        $.ajax({
            url: "{{ route('getDetailAPKMtFttx') }}",
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

                var chartDetail = Highcharts.chart('detailAPK', {
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
                        },
                        series: {
                            point: {
                                events: {
                                    click() {
                                        // console.log(this.series.name)
                                        // alert(this.category+"|"+detailClikChart)
                                        dataDetail = this.category+"|"+detailClikChart;
                                        // detailAPKCluster(dataDetail);
                                    }
                                }
                            }
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

                console.log(chartDetail.series.points);
                fetch_detail();
            }                
        })


        function fetch_detail() 
        {
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
                        url: "{{ route('dataDetailAPKMtFttx') }}",
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

    // Click Branch show Cluster
    function detailAPKCluster(dataDetail) {

        console.log(dataDetail);

        let months = ["jan","Feb","Mar","Apr","May","Jun","Jul","Agt","Sept","Oct","Nov","Dec"];

        let filSite = $('#site').val();
        let filBranch = $('#branch').val();
        let datafilterCluster;
        let detAPKCluster=dataDetail.split("|");

        //Root Couse APK
        if(detAPKCluster[1]=="rootCouseAPK" ) {
            if(detAPKCluster[2]=="penagihan") {
                datafilterCluster = {

                        detBranch: detAPKCluster[0],
                        detSlide: detAPKCluster[1],
                        detKategori: detAPKCluster[2], 
                        detPenagihan: detAPKCluster[3],
                        detBulan: detAPKCluster[4],
                        detThn: detAPKCluster[5],
                        detSite: filSite,
                        // detBranch: filBranch,
                        _token: _token
                };

                detailTitleCluster = detAPKCluster[0];
                detailSubTitleCluster = detAPKCluster[2];
            }

            if(detAPKCluster[2]=="couse_code") {
                datafilterCluster = {
                        detBranch: detAPKCluster[0],
                        detSlide: detAPKCluster[1],
                        detKategori: detAPKCluster[2], 
                        detPenagihan: detAPKCluster[3],
                        detCouse_code: detAPKCluster[4],
                        detBulan: detAPKCluster[5],
                        detThn: detAPKCluster[6],
                        detSite: filSite,
                        // detBranch: filBranch,
                        _token: _token
                };

                detailTitleCluster = detAPKCluster[0];
                detailSubTitleCluster = detAPKCluster[2] + " - " + detAPKCluster[3];
            }

            if(detAPKCluster[2]=="root_couse") {
                datafilterCluster = {
                        detBranch: detAPKCluster[0],
                        detSlide: detAPKCluster[1],
                        detKategori: detAPKCluster[2], 
                        detPenagihan: detAPKCluster[3],
                        detCouse_code: detAPKCluster[4],
                        detRoot_couse: detAPKCluster[5],
                        detBulan: detAPKCluster[6],
                        detThn: detAPKCluster[7],
                        detSite: filSite,
                        // detBranch: filBranch,
                        _token: _token
                };

                detailTitleCluster = detAPKCluster[0];
                detailSubTitleCluster = detAPKCluster[2] + " - " + detAPKCluster[3] + " - " + detAPKCluster[4];
            }

            bulanData = months[datafilterCluster.detBulan - 1] + "-" + datafilterCluster.detThn;
        }

        //Pending
        if(detAPKCluster[1]=="pending" ) {
            if(detAPKCluster[2]=="penagihan") {
                datafilterCluster = {
                        detBranch: detAPKCluster[0],
                        detSlide: detAPKCluster[1],
                        detKategori: detAPKCluster[2], 
                        detPenagihan: detAPKCluster[3],
                        detBulan: detAPKCluster[4],
                        detThn: detAPKCluster[5],
                        detSite: filSite,
                        // detBranch: filBranch,
                        _token: _token
                };

                detailTitleCluster = detAPKCluster[0];
                detailSubTitleCluster = detAPKCluster[2];
            }

            bulanData = months[datafilterCluster.detBulan - 1] + "-" + datafilterCluster.detThn;
        }

        //Cancel
        if(detAPKCluster[1]=="cancel" ) {
            if(detAPKCluster[2]=="penagihan") {
                datafilterCluster = {
                        detBranch: detAPKCluster[0],
                        detSlide: detAPKCluster[1],
                        detKategori: detAPKCluster[2], 
                        detPenagihan: detAPKCluster[3],
                        detBulan: detAPKCluster[4],
                        detThn: detAPKCluster[5],
                        detSite: filSite,
                        // detBranch: filBranch,
                        _token: _token
                };

                detailTitleCluster = detAPKCluster[0];
                detailSubTitleCluster = detAPKCluster[2];
            }

            bulanData = months[datafilterCluster.detBulan - 1] + "-" + datafilterCluster.detThn;
        }
        

        $('#md-detailAPKCluster').modal('show');
        $('#canvasDetailAPKCluster').empty();

        $.ajax({
            url: "{{ route('getDetailAPKMtFttxCluster') }}",
            type: "GET",
            data: datafilterCluster,
            beforeSend: () => {
                $("#smDetWO").show();
            },
            complete: () => {
                $("#smDetWO").hide();
            },
            success: function(detAPKCluster) {

                // dataSource = detAPK.detailAPK;
                var totDetailAPK = detAPKCluster;
                // var totDetailAPK = totDetailAPK.sort((a,b) => b.done - a.done);
                var ChrClusterAPK = [];
                var ChrClusterTot = [];

                $.each(detAPKCluster.detailBranchAPKCluster, function(key, item) {

                    ChrClusterAPK.push(item.cluster);
                    ChrClusterTot.push([Number(item.total)]);

                });

                $('#canvasDetailAPKCluster').empty();

                let chartBranchAPK = `
                <figure class="highcharts-figure">
                    <div id="detailAPKCluster"></div>
                </figure>
                `;

                $('#canvasDetailAPKCluster').append(chartBranchAPK);

                var chartDetailCluster = Highcharts.chart('detailAPKCluster', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: detailTitleCluster.replaceAll('_',' '),
                        align: 'left'
                    },
                    subtitle: {
                        text: detailSubTitleCluster,
                        align: 'left'
                    },
                    xAxis: {
                        categories: ChrClusterAPK, // ['Africa', 'America', 'Asia', 'Europe'],
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
                        },
                        // series: {
                        //     point: {
                        //         events: {
                        //             click() {
                        //                 console.log(this.series.name)
                        //                 alert(this.category+"|"+detailClikChart)
                        //             }
                        //         }
                        //     }
                        // }
                    },
                    legend:{ enabled:false },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: '',
                        data: ChrClusterTot // [631, 727, 3202, 721]
                    }]
                });

                // console.log(chartDetail.series.points);
                // fetch_detail();
            }                
        })
    }

</script>

    <script type="text/javascript">
        $(document).on('click', '.closeDetailToday', function() {
            $('#canvasTotWOIB').empty();
            $('#canvasTotWOIBClose').empty();
        })

        $('#filterDashBoard').on('click', function(e) {

            // console.log($('#periode').data('daterangepicker').startDate.format("YYYY-MM-DD"))
            // console.log($('#periode').data('daterangepicker').endDate.format("YYYY-MM-DD"))


            e.preventDefault();
            if ($('#bulanReport').val() === "") {
                alert('Pilih Bulan Report');
                return;
            }

            let bulanReport = $('#bulanReport').val();

            // console.log(moment([new Date(bulanReport).getFullYear(), new Date(bulanReport).getMonth()]).format("DD-MM-YYYY"));
            let trendWoIBFtth;
            var dataResult;

            let filBulanReport = $('#bulanReport').val();
            let filTglPeriode = $('#periode').val();
            let filPeriodeStart = $('#periode').data('daterangepicker').startDate.format("YYYY-MM-DD");
            let filPeriodeEnd = $('#periode').data('daterangepicker').endDate.format("YYYY-MM-DD");
            let filSite = $('#site').val();
            let filBranch = $('#branch').val();
            let filKotamadya = $('#kotamadya').val();

            let titleBranch;
            let titleSite;

            if (filBranch == "All") {
                titleBranch = "All Branch";
            } else {
                titleBranch = "Branch " + filBranch;
            }

            if (filSite == "All") {
                // titleSite = "All Site (Retail, Apartemen, Underground)";
                titleSite = "";
            } else {
                // titleSite = "Site " + filSite;
                titleSite = "";
            }

            document.querySelectorAll('#CardTitle').forEach(function(elem) {
                elem.innerText = titleBranch;
            })
            // console.log($('#CardTitle').html("testing"));

            let uri;
            if ((filSite == "All") && (filBranch == "All")) {
                uri = "{{ route('getTotalWoBranchMTFttx') }}";
            } else {
                uri = "{{ route('getFilterDashboardMTFttx') }}";
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
                    filterDateEnd: filPeriodeEnd
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

                        // console.log(item.site_penagihan);
                        // console.log(item.nama_branch);
                        // if(item.site_penagihan == "Retail"){
                        branch.push(item.nama_branch);
                        totWoDone.push([item.nama_branch + " " + item.done, item.done]);
                        branchWTot.push([item.nama_branch + " " + item.total, item.total]);
                        // }
                        // if((item.site_penagihan == "Apartemen") || (item.site_penagihan == "Underground") ){
                        // branch.push(item.site_penagihan);
                        // totWoDone.push([item.site_penagihan + " " + item.done, item.done]);
                        // branchWTot.push([item.site_penagihan + " " + item.total, item.total]);
                        // }

                        totWo.push(item.total);


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
                            text: 'Total WO FTTX MT ' + bulanReport,
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
                            name: 'Percentage',
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
                            text: 'WO FTTX MT Close ' + bulanReport,
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
                            name: 'Percentage',
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

                    $('#canvasTotIBDonex').empty();

                    let chartIBDone = `
					<figure class="highcharts-figure">
					    <div id="TotIBDone"></div>
					</figure>
				    `;

                    $('#canvasTotIBDonex').append(chartIBDone);

                    Highcharts.chart('TotIBDone', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO FTTX MT ' + titleBranch + ' Done ', //+ bulanReport,
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

                    $('#canvasTotIBPendingx').empty();

                    let chartIBPending = `
					<figure class="highcharts-figure">
					    <div id="TotIBPending"></div>
					</figure>
				    `;

                    $('#canvasTotIBPendingx').append(chartIBPending);

                    Highcharts.chart('TotIBPending', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO FTTX MT ' + titleBranch + ' Pending ', // + bulanReport,
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

                    $('#canvasTotIBCancelx').empty();

                    let chartIBCancel = `
					<figure class="highcharts-figure">
					    <div id="TotIBCancel"></div>
					</figure>
				    `;

                    $('#canvasTotIBCancelx').append(chartIBCancel);

                    Highcharts.chart('TotIBCancel', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO FTTX MT ' + titleBranch + ' Cancel ', // + bulanReport,
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
                        <th>WO FTTX MT</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoClose').append(`
                        <th>WO FTTX MT Close</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoPending').append(`
                        <th>WO FTTX MT Failed</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoCancel').append(`
                        <th>WO FTTX MT Cancel</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    let nmBranch;

                    $.each(dataTotalWo, function(key, item) {

                        // if(item.site_penagihan == "Retail"){
                        nmBranch = item.nama_branch;
                        // }
                        // if((item.site_penagihan == "Apartemen") || (item.site_penagihan == "Underground")){
                        // nmBranch = item.site_penagihan;
                        // }

                        let tbTotalWo = `
                            <tr>
                                <td>${nmBranch}</td>
                                <td style="text-align: center">${item.total.toLocaleString()}</td>
                                <td style="text-align: center">${item.persenTotal.toFixed(1).replace(/\.0$/, '')}%</td>
                            </tr>    
                        `;

                        totWo = Number(totWo) + Number(item.total);

                        $('#totWoBranch').append(tbTotalWo);


                        let tbWoClose = `
                            <tr>
                                <td>${nmBranch}</td>
                                <td style="text-align: center">${item.done.toLocaleString()}</td>
                                <td style="text-align: center">${item.persenDone.toFixed(1).replace(/\.0$/, '')}%</td>
                            </tr>    
                        `;

                        totWoClose = Number(totWoClose) + Number(item.done);

                        $('#totWoCloseBranch').append(tbWoClose);

                        let tbWoPending = `
                            <tr>
                                <td>${nmBranch}</td>
                                <td style="text-align: center">${item.pending.toLocaleString()}</td>
                                <td style="text-align: center">${item.persenPending.toFixed(1).replace(/\.0$/, '')}%</td>
                            </tr>    
                        `;

                        totWoPending = Number(totWoPending) + Number(item.pending);
                        $('#totWoPendingBranch').append(tbWoPending);

                        let tbWoCancel = `
                            <tr>
                                <td>${nmBranch}</td>
                                <td style="text-align: center">${item.cancel.toLocaleString()}</td>
                                <td style="text-align: center">${item.persenCancel.toFixed(1).replace(/\.0$/, '')}%</td>
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
                        <th style="text-align: center; vertical-align: middle;"></th>
                    `;

                    $('#totalWo').append(isiTotalWo);

                    persenTotClose = (Number(totWoClose) * 100) / Number(totWo);

                    let isiTotalWoClose = `
                    <th>Total WO Close</th>
                        <th style="text-align: center; vertical-align: middle;">${totWoClose.toLocaleString()}</th>
                        <th style="text-align: center; vertical-align: middle;">${persenTotClose.toFixed(1).replace(/\.0$/, '')}%</th>
                    `;


                    $('#totWoClose').append(isiTotalWoClose);

                    persenTotPending = (Number(totWoPending) * 100) / Number(totWo);

                    let isiTotalWoPending = `
                    <th>Total WO Failed</th>
                        <th style="text-align: center; vertical-align: middle;">${totWoPending.toLocaleString()}</th>
                        <th style="text-align: center; vertical-align: middle;">${persenTotPending.toFixed(1).replace(/\.0$/, '')}%</th>
                    `;
                    $('#totWoPending').append(isiTotalWoPending);

                    persenTotCancel = (totWoCancel * 100) / totWo;

                    let isiTotalWoCancel = `
                    <th>Total WO Cancel</th>
                        <th style="text-align: center; vertical-align: middle;">${totWoCancel.toLocaleString()}</th>
                        <th style="text-align: center; vertical-align: middle;">${persenTotCancel.toFixed(1).replace(/\.0$/, '')}%</th>
                    `;
                    $('#totWoCancel').append(isiTotalWoCancel);
                }


            })

            $.ajax({
                url: "{{ route('getTrendMonthlyMTFttx') }}",
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
                    // var trendWoIBFtth = {!! $trendMonthly !!}
                    trendWoIBFtth = dataTrendMonthly;

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



                    var ChartTrendTotWo = new Chart(ctxTrendTotWoIBFtth, {
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
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,

                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    formatter: function(value) {
                                        return value.toLocaleString();}
                                },
                                title: {
                                    display: true,
                                    text: 'Trend WO FTTX MT',
                                    align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: true, //this will remove all the x-axis grid lines
                                    // max: 6000,
                                    // min: 2000,
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

                    const ctxTrendTotWoIBFtthClose = document.getElementById('TrendTotWoIBFtthClose');

                    var graphTrendTotWoIBFtthClose = Chart.getChart('TrendTotWoIBFtthClose');
                    if (graphTrendTotWoIBFtthClose) {
                        graphTrendTotWoIBFtthClose.destroy();
                    }

                    var ChartTrendTotWoClose = new Chart(ctxTrendTotWoIBFtthClose, {
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
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,

                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    formatter: function(value) {
                                        return value.toLocaleString();
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Trend WO FTTX MT Close',
                                    align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: true, //this will remove all the x-axis grid lines
                                    // max: 6000,
                                    // min: 2000,
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

                    var maxChartTot = ChartTrendTotWo.scales.y.max;
                    var minChartTotClose = ChartTrendTotWoClose.scales.y.min;
                    ChartTrendTotWoClose.options.scales.y.max = ChartTrendTotWo.scales.y.max;
                    ChartTrendTotWo.options.scales.y.min= minChartTotClose;

                    ChartTrendTotWoClose.update();
                    ChartTrendTotWo.update();

                }

            })


            $.ajax({
                url: "{{ route('getTabelStatusMTFttx') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd

                },
                beforeSend: () => {
                    $("#smWOTrend").show();
                },
                complete: () => {
                    $("#smWOTrend").hide();
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
                    $('#dateMonth').append(`<th>FTTX MT ${titleBranch}</th>`)

                    $('#woDone').find("td").remove();
                    $('#woDone').find("th").remove();
                    $('#woDone').append("<td>Done</td>")

                    $('#woPending').find("td").remove();
                    $('#woPending').find("th").remove();
                    $('#woPending').append("<td>FTTX MT Failed</td>")

                    $('#woCancel').find("td").remove();
                    $('#woCancel').find("th").remove();
                    $('#woCancel').append("<td>Cancel</td>")

                    $('#totWo').find("td").remove()
                    $('#totWo').find("th").remove()
                    $('#totWo').append("<th>Total Wo</th>")


                    $.each(data, function(key, item) {
                        // day.push(new Date(item.tgl_ikr).getDate());
                        day.push(new Date(item.mt_date).getDate());
                        doneDay.push(item.Done);
                        pendingDay.push(item.Pending);
                        cancelDay.push(item.Cancel);

                        let htgl = `
                           <th>${new Date(item.mt_date).getDate()}</th>
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

                    $('#woDone').append(`<th>${parseFloat((totDone * 100) / total).toFixed(1).replace(/\.0$/, '')}%</th>`)
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
                            text: 'Status WO FTTX MT - ' + titleBranch + ' ' +
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
                url: "{{ route('getReasonStatusMTFttxGraph') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd

                },
                success: function(data) {
                    console.log(data);
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
                            text: 'Action Status WO FTTX MT Close Dialy - ' +
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

                        series: nameGraph, 
                        
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
                url: "{{ route('getRootCouseAPKMTFttx') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd
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
                    let TotMonth = [];
                    let tbPenagihanAPK;
                    let tbCouseCodeAPK;
                    let tbRootCouseAPK;
                    let hdRootCouseAPK = `
                        <th>Penagihan</th>`;
                        // <th>Cause Code</th>
                        // <th>Root Cause</th>`;
                    // <th style="text-align: center">Jumlah</th>`;

                for (h = 0; h < trendWoIBFtth.length; h++) {
                    hdRootCouseAPK = hdRootCouseAPK +
                        `<th colspan="2" style="text-align: center">${trendWoIBFtth[h].bulan.toLocaleString()}</th>`
                }

                $('#rootCouseHeadAPK').append(hdRootCouseAPK + `<th colspan="2" style="text-align: center">Subtotal</th></tr>`);


                $.each(apk.detPenagihanSortir, function(key, itemPenagihan) {

                    tbPenagihanAPK = `
                                    <tr><th>${itemPenagihan.penagihan}</th>`;
                                    // <th class="table-secondary"></th>
                                    // <th class="table-secondary"></th>`;
                    
                    subtotal = 0;
                    for (p = 0; p < trendWoIBFtth.length; p++) {

                        TotMonth[p]=0;
                        $.each(apk.detPenagihanSortir, function(ky, itm) {
                            TotMonth[p] += Number(itm.bulanan[p])
                        })
                        tbPenagihanAPK = tbPenagihanAPK +
                            `<td style="text-align: center">${itemPenagihan.bulanan[p].toLocaleString()}</td>
                            <td style="text-align: center">${parseFloat((itemPenagihan.bulanan[p]*100)/TotMonth[p]).toFixed(1).replace(/\.0$/, '')}%</td>`;

                        subtotal += Number(itemPenagihan.bulanan[p]);

                    }

                    $('#bodyRootCouseAPK').append(tbPenagihanAPK + `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`);

                    
                });

                let totRootCouseAPK = `
                            <tr><th class="table-dark">TOTAL</th>`;
                                // <th class="table-dark"></th>
                                // <th class="table-dark"></th>`;
                
                    subtotal=0;
                    for (p = 0; p < trendWoIBFtth.length; p++) {
                        TotPenagihan[p] = 0
                        $.each(apk.detPenagihanSortir, function(key, iPenagihan) {
                            TotPenagihan[p] += Number(iPenagihan.bulanan[p]);
                        })

                        totRootCouseAPK = totRootCouseAPK +
                            `<th class="table-dark" style="text-align: center">${TotPenagihan[p].toLocaleString()}</th>
                            <th class="table-dark" style="text-align: center"></th>`;

                        subtotal += Number(TotPenagihan[p]);
                    }

                    $('#bodyRootCouseAPK').append(totRootCouseAPK + `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);
                }

            });

            $.ajax({
                url: "{{ route('getRootCouseAPKMTFttxDetail') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd
                },
                beforeSend: () => {
                    $("#smWOClosing").show();
                },
                complete: () => {
                    $("#smWOClosing").hide();
                },
                success: function(apk) {

                    console.log(apk);

                    $('#rootCouseHeadAPKDetail').find("th").remove();
                    $('#bodyRootCouseAPKDetail').find("tr").remove();
                    $('#penagihanAPKDetail').find("th").remove();
                    $('#couseCodePenagihanAPKDetail').find("th").remove();
                    $('#rootCousePenagihanAPKDetail').find("td").remove();

                    let subtotal;
                    let TotPenagihan = [];
                    let TotMonth = [];
                    let tbPenagihanAPK;
                    let tbCouseCodeAPK;
                    let tbRootCouseAPK;
                    let hdRootCouseAPK = `
                        <th>Penagihan</th>
                        <th>Cause Code</th>
                        <th>Root Cause</th>`;
                    // <th style="text-align: center">Jumlah</th>`;

                for (h = 0; h < trendWoIBFtth.length; h++) {
                    hdRootCouseAPK = hdRootCouseAPK +
                        `<th colspan="2" style="text-align: center">${trendWoIBFtth[h].bulan.toLocaleString()}</th>`
                }

                $('#rootCouseHeadAPKDetail').append(hdRootCouseAPK + `<th colspan="2" style="text-align: center">Subtotal</th></tr>`);


                $.each(apk.detPenagihanSortir, function(key, itemPenagihan) {

                    tbPenagihanAPK = `
                                    <tr><th class="table-secondary">${itemPenagihan.penagihan}</th>
                                    <th class="table-secondary"></th>
                                    <th class="table-secondary"></th>`;
                    
                    subtotal = 0;
                    for (p = 0; p < trendWoIBFtth.length; p++) {

                        blnId = new Date(trendWoIBFtth[p].bulan).getMonth();
                        thnId = new Date(trendWoIBFtth[p].bulan).getFullYear();
                        detailCel = `rootCouseAPK|penagihan|${itemPenagihan.penagihan}|${(blnId + 1)}|${thnId}`;

                        TotMonth[p]=0;
                        $.each(apk.detPenagihanSortir, function(ky, itm) {
                            TotMonth[p] += Number(itm.bulanan[p])
                        })
                        tbPenagihanAPK = tbPenagihanAPK +
                            `<td class="table-secondary" style="text-align: center; cursor:pointer;" id="${detailCel}" onClick="det_click(this.id)">${itemPenagihan.bulanan[p].toLocaleString()}</td>
                            <td class="table-secondary" style="text-align: center">${parseFloat((itemPenagihan.bulanan[p]*100)/TotMonth[p]).toFixed(1).replace(/\.0$/, '')}%</td>`;

                        subtotal += Number(itemPenagihan.bulanan[p]);

                    }

                    $('#bodyRootCouseAPKDetail').append(tbPenagihanAPK + `<td class="table-secondary" style="text-align: center">${subtotal.toLocaleString()}</td></tr>`);

                    $.each(apk.detCouseCodeSortir, function(key, itemCouseCode) {
                            if (itemPenagihan.penagihan == itemCouseCode.penagihan) {
                                tbCouseCodeAPK = `
                                    <tr><th></th>
                                    <th class="table-info">${itemCouseCode.couse_code}</th>
                                    <th class="table-info"></th>`;
                                
                                subtotalDT = 0;
                                for (cc = 0;cc < trendWoIBFtth.length; cc++) {
                                    blnId = new Date(trendWoIBFtth[cc].bulan).getMonth();
                                    thnId = new Date(trendWoIBFtth[cc].bulan).getFullYear();
                                    detailCel = `rootCouseAPK|couse_code|${itemPenagihan.penagihan}|${itemCouseCode.couse_code}|${(blnId + 1)}|${thnId}`;
                                    tbCouseCodeAPK = tbCouseCodeAPK + 
                                    `<td class="table-info" style="text-align: center; cursor:pointer" font-weight:bold">
                                        <span id="${detailCel}" onClick="det_click(this.id)">${itemCouseCode.bulanan[cc].toLocaleString()}</span></td>
                                    <td class="table-info" style="text-align: center" font-weight:bold">${itemCouseCode.persen[cc].toLocaleString()}%</td>`;

                                    subtotalDT += Number(itemCouseCode.bulanan[cc]);
                                }

                                detailCelDT = `rootCouseAPK|couse_code|${itemPenagihan.penagihan}|${itemCouseCode.couse_code}|All|All`;

                                $('#bodyRootCouseAPKDetail').append(tbCouseCodeAPK + 
                                `<th class="table-info" style="text-align: center" id="${detailCelDT}">${subtotalDT.toLocaleString()}</th></tr>`);


                                $.each(apk.detRootCouseSortir, function(key,
                                    itemRootCouse) {

                                    if (itemPenagihan.penagihan == itemRootCouse
                                        .penagihan && itemCouseCode
                                        .couse_code == itemRootCouse.couse_code
                                    ) {
                                        tbRootCouseAPK = `
                                            <tr><td></td>
                                            <td></td>
                                            <td>${itemRootCouse.root_couse}</td>`;
                                        
                                        subtotalDT=0;
                                        for (rc = 0; rc < trendWoIBFtth.length; rc++) {
                                            blnId = new Date(trendWoIBFtth[rc].bulan).getMonth();
                                            thnId = new Date(trendWoIBFtth[rc].bulan).getFullYear();
                                            detailCel = `rootCouseAPK|root_couse|${itemPenagihan.penagihan}|${itemCouseCode.couse_code}|${itemRootCouse.root_couse}|${(blnId + 1)}|${thnId}`;
                                    
                                            tbRootCouseAPK = tbRootCouseAPK +
                                            `<td style="text-align: center; cursor:pointer" >
                                                <span id="${detailCel}" onClick="det_click(this.id)">${itemRootCouse.bulanan[rc].toLocaleString()}</span></td>
                                            <td style="text-align: center">${itemRootCouse.persen[rc].toLocaleString()}%</td>`;

                                            subtotalDT += Number(itemRootCouse.bulanan[rc]);

                                        }

                                        detailCelDT = `rootCouseAPK|root_couse|${itemPenagihan.penagihan}|${itemCouseCode.couse_code}|${itemRootCouse.root_couse}|All|All`;

                                        $('#bodyRootCouseAPKDetail').append(tbRootCouseAPK + 
                                            `<td style="text-align: center" id="${detailCelDT}">${subtotalDT.toLocaleString()}</td></tr>`);
                                    }
                                });
                            }
                        });
                    
                });

                let totRootCouseAPK = `
                            <tr><th class="table-dark">TOTAL</th>
                                <th class="table-dark"></th>
                                <th class="table-dark"></th>`;
                
                    subtotal=0;
                    for (p = 0; p < trendWoIBFtth.length; p++) {
                        TotPenagihan[p] = 0
                        $.each(apk.detPenagihanSortir, function(key, iPenagihan) {
                            TotPenagihan[p] += Number(iPenagihan.bulanan[p]);
                        })

                        totRootCouseAPK = totRootCouseAPK +
                            `<th class="table-dark" style="text-align: center">${TotPenagihan[p].toLocaleString()}</th>
                            <th class="table-dark" style="text-align: center"></th>`;

                        subtotal += Number(TotPenagihan[p]);
                    }

                    $('#bodyRootCouseAPKDetail').append(totRootCouseAPK + `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);
                }

            });



            $.ajax({
                url: "{{ route('getRootCousePendingGraphMTFttx') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd

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
                            text: 'Action Taken WO FTTX MT Failed Dialy - ' +
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

                        series: nameGraphPending, //[{
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
                url: "{{ route('getRootCousePendingMTFttx') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd
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

                    let subtotal;
                    var TotRootDonePending = 0;
                    let TotMonthPending =[];
                    let TotPenagihan = [];
                    let tbRootCousePending;
                    let hdRootCousePending = `
                        <tr>
                                <th>Action Taken FTTX MT Pending</th>
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
                                <td>${item.penagihan}</td>
                                
                            `;
                        subtotal=0;
                        for (bln = 0; bln < trendWoIBFtth.length; bln++) {

                                blnId = new Date(trendWoIBFtth[bln].bulan).getMonth();
                                thnId = new Date(trendWoIBFtth[bln].bulan).getFullYear();
                                detailCel = `pending|penagihan|${item.penagihan}|${(blnId + 1)}|${thnId}`;

                                TotMonthPending[bln]=0;
                                $.each(dataRootCousePending, function(ky,itm) {
                                    TotMonthPending[bln] += Number(itm.bulanan[bln]);
                                })

                                tbRootCousePending = tbRootCousePending +
                                    `<td style="text-align: center; cursor:pointer" id="${detailCel}" onClick="det_click(this.id)">${item.bulanan[bln].toLocaleString()}</td>
                                    <td style="text-align: center">${parseFloat((item.bulanan[bln]*100)/TotMonthPending[bln]).toFixed(1).replace(/\.0$/, '')}%</td>`;

                                subtotal += Number(item.bulanan[bln]);

                        }
                        
                        $('#rootCouseTbPending').append(tbRootCousePending +`<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`);

                    });

                    let totRootCouseAPK = `
                            <tr><th class="table-dark">TOTAL</th>`;

                    subtotal=0;
                    for (p = 0; p < trendWoIBFtth.length; p++) {
                        TotPenagihan[p] = 0
                        $.each(dataRootCousePending, function(key, iPenagihan) {
                            TotPenagihan[p] += Number(iPenagihan.bulanan[p]);
                        })

                        totRootCouseAPK = totRootCouseAPK +
                            `<th class="table-dark" style="text-align: center">${TotPenagihan[p].toLocaleString()}</th>
                            <th class="table-dark" style="text-align: center"></th>`;

                        subtotal += Number(TotPenagihan[p]);
                    }

                    $('#rootCouseTbPending').append(totRootCouseAPK + `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);
                

                }

            });

            $.ajax({
                url: "{{ route('getRootCouseCancelGraphMTFttx') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd

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

                    let chartRootCouseAPKDialy = `
					<figure class="highcharts-figure">
					    <div id="conRooCouseAPKDialyCancel"></div>
					</figure>
				    `;

                    $('#canvasRootCouseAPKCancel').append(chartRootCouseAPKDialy);

                    Highcharts.chart('conRooCouseAPKDialyCancel', {

                        title: {
                            text: 'Action Taken WO FTTX MT Cancel Dialy - ' +
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

                        series: nameGraphCancel, //[{
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
                url: "{{ route('getRootCouseCancelMTFttx') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd
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

                    let subtotal;
                    var TotRootDoneCancel = 0;
                    let TotMonthCancel = [];
                    let TotPenagihan = [];
                    let tbRootCouseCancel;
                    let hdRootCouseCancel = `
                        <tr>
                                <th>Action Taken FTTX MT Cancel</th>
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
                                <td>${item.penagihan}</td>
                            `;
                        
                        subtotal = 0;
                        for (bln = 0; bln < trendWoIBFtth.length; bln++) {

                            blnId = new Date(trendWoIBFtth[bln].bulan).getMonth();
                            thnId = new Date(trendWoIBFtth[bln].bulan).getFullYear();
                            detailCel = `cancel|penagihan|${item.penagihan}|${(blnId + 1)}|${thnId}`;

                            TotMonthCancel[bln]=0;

                            $.each(dataRootCouseCancel, function(ky, itm) {
                                TotMonthCancel[bln] += Number(itm.bulanan[bln]);
                            })

                            tbRootCouseCancel = tbRootCouseCancel +
                                `<td style="text-align: center; cursor:pointer" id="${detailCel}" onClick="det_click(this.id)">${item.bulanan[bln].toLocaleString()}</td>
                                <td style="text-align: center">${item.persen[bln].toLocaleString()}%</td>`;

                            subtotal += Number(item.bulanan[bln]);

                        }

                        tbRootCouseCancel = tbRootCouseCancel + `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`;
                        $('#rootCouseTbCancel').append(tbRootCouseCancel);

                    });

                    let totRootCouseAPK = `
                            <tr><th class="table-dark">TOTAL</th>`;

                    subtotal=0;
                    for (p = 0; p < trendWoIBFtth.length; p++) {
                        TotPenagihan[p] = 0
                        $.each(dataRootCouseCancel, function(key, iPenagihan) {
                            TotPenagihan[p] += Number(iPenagihan.bulanan[p]);
                        })

                        totRootCouseAPK = totRootCouseAPK +
                            `<th class="table-dark" style="text-align: center">${TotPenagihan[p].toLocaleString()}</th>
                            <th class="table-dark" style="text-align: center"></th>`;

                        subtotal += Number(TotPenagihan[p]);
                    }

                    $('#rootCouseTbCancel').append(totRootCouseAPK + `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);
                
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
