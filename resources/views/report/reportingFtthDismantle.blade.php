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
                    <h6>Summary WO FTTH Dismantle & Remove Device - <h5 id="CardTitle">All Branch</h5>
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
                <div class="card-body" id="canvasTotDone">
                    {{-- <canvas id="TotWoMt"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body" id="canvasTotPending">
                    {{-- <canvas id="TotWoMtClose"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body" id="canvasTotCancel">
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
                                    <th>WO Dismantle</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;"></th> --}}
                                </tr>
                            </thead>
                            <tbody id="totWoBranch">
                                {{-- @foreach ($totWoMtBranch as $totWoRetail)
                                    <tr>
                                        <td>{{ $totWoRetail->nama_branch }}</td>
                                        <td style="text-align: center">{{ number_format($totWoRetail->total) }}</td>
                                    </tr>
                                @endforeach --}}


                            </tbody>
                            <tfoot>
                                <tr id="totalWo">
                                    <th>Total WO</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">
                                        {{ number_format($totWoMtBranch->sum('total')) }}</th> --}}
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
                                    <th>WO Dismantle Close</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">Januari</th> --}}
                                    {{-- <th style="text-align: center; vertical-align: middle;">%</th> --}}
                                </tr>
                            </thead>
                            <tbody id="totWoCloseBranch">
                                {{-- @foreach ($totWoMtBranch as $totWoMtDone)
                                    <tr>
                                        <td>{{ $totWoMtDone->nama_branch }}</td>
                                        <td style="text-align: center">{{ $totWoMtDone->done }}</td>
                                        <td style="text-align: center">
                                            {{ number_format($totWoMtDone->persenDone, 1) . '%' }}
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                            <tfoot>
                                <tr id="totWoClose">
                                    <th>Total</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">
                                        {{ number_format($totWoMtBranch->sum('done')) }}</th>
                                    <th style="text-align: center;">
                                        {{ number_format(($totWoMtBranch->sum('done') * 100) / $totWoMtBranch->sum('total'), 1) . '%' }}
                                    </th> --}}
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
                                    <th>WO Dismantle Failed</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">Januari</th> --}}
                                    {{-- <th style="text-align: center; vertical-align: middle;">%</th> --}}
                                </tr>
                            </thead>
                            <tbody id="totWoPendingBranch">
                                {{-- @foreach ($totWoMtBranch as $totWoMtPending)
                                    <tr>
                                        <td>{{ $totWoMtPending->nama_branch }}</td>
                                        <td style="text-align: center">{{ $totWoMtPending->pending }}</td>
                                        <td style="text-align: center">
                                            {{ number_format($totWoMtPending->persenPending, 1) . '%' }}</td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                            <tfoot>
                                <tr id="totWoPending">
                                    <th>Total</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">
                                        {{ number_format($totWoMtBranch->sum('pending')) }}</th>
                                    <th style="text-align: center;">
                                        {{ number_format(($totWoMtBranch->sum('pending') * 100) / $totWoMtBranch->sum('total'), 1) . '%' }}
                                    </th> --}}
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
                                    <th>WO Dismantle Cancel</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">Januari</th> --}}
                                    {{-- <th style="text-align: center; vertical-align: middle;">%</th> --}}
                                </tr>
                            </thead>
                            <tbody id="totWoCancelBranch">
                                {{-- @foreach ($totWoMtBranch as $totWoMtCancel)
                                    <tr>
                                        <td>{{ $totWoMtCancel->nama_branch }}</td>
                                        <td style="text-align: center">{{ $totWoMtCancel->cancel }}</td>
                                        <td style="text-align: center">
                                            {{ number_format($totWoMtCancel->persenCancel, 1) . '%' }}</td>
                                    </tr>
                                @endforeach --}}

                            </tbody>
                            <tfoot>
                                <tr id="totWoCancel">
                                    <th>Total</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">
                                        {{ number_format($totWoMtBranch->sum('cancel')) }}</th>
                                    <th style="text-align: center;">
                                        {{ number_format(($totWoMtBranch->sum('cancel') * 100) / $totWoMtBranch->sum('total'), 1) . '%' }}
                                    </th> --}}
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
                    <h6>Summary WO FTTH Dismantle & Remove Device By Cluster Area - <h5 id="CardTitle">All Branch<h5></h6>
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
                        <table class="table table-bordered" style="font-size: 11px; table-layout: auto;">
                            <thead>
                                <tr id="tableHeadCluster">
                                {{-- <th>Root Couse Penagihan (Sortir)</th> --}}
                                {{-- <th></th> --}}
                                {{-- <th></th> --}}
                                {{-- <th style="text-align: center">Jumlah</th> --}}
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
                    <h6>Trend WO FTTH Dismantle & Remove Device - <h5 id="CardTitle">All Branch<h5>
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
                                    <th>WO Dismantle</th>
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
                                    <td>WO Dismantle Failed</td>
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
                    <h6>Summary Closing WO FTTH Dismantle & Remove Device <h5 id="CardTitle">All Branch<h5>
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
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h5>Summary Root Couse Failed WO FTTH Dismantle & Remove Device - <h5 id="CardTitle">All Branch<h5></h6>
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
            // console.log("firsDate : ", firstDate.toDate());
            // console.log("lastDate : ", lastDate.toDate());

            $('#periode').data('daterangepicker').setStartDate(firstDate);
            $('#periode').data('daterangepicker').setEndDate(lastDate);

        });


        $(document).on('change', '#branch', function() {
            let filBranch = $(this).val()

            $.ajax({
                url: "{{ route('getFilterBranchDismantleFtth') }}",
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

            $.ajax({
                url: "{{ route('getMonthlyDismantle') }}",
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
            if ((filSite == "All") && (filBranch == "All")) {
                uri = "{{ route('getTotalWoBranchDismantleFtth') }}";
            } else {
                uri = "{{ route('getFilterDashboardDismantleFtth') }}";
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
                    let subtotal;
                    var branch = [];
                    var totWo = [];
                    var totWoDone = [];
                    var branchWTot = [];

                    $.each(totWoMt, function(key, item) {

                        branch.push(item.nama_branch);
                        totWoDone.push([item.nama_branch + " " + item.done, item.done]);
                        branchWTot.push([item.nama_branch + " " + item.total, item.total]);

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
                            text: 'Total WO Dismantle ' + bulanReport,
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
                            text: 'WO Dismantle Close ' + bulanReport,
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

                    $('#canvasTotDone').empty();

                    let chartDone = `
					<figure class="highcharts-figure">
					    <div id="TotDone"></div>
					</figure>
				    `;

                    $('#canvasTotDone').append(chartDone);

                    Highcharts.chart('TotDone', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO Dismantle ' + titleBranch + ' Done ', //+ bulanReport,
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

                    $('#canvasTotPending').empty();

                    let chartPending = `
					<figure class="highcharts-figure">
					    <div id="TotPending"></div>
					</figure>
				    `;

                    $('#canvasTotPending').append(chartPending);

                    Highcharts.chart('TotPending', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO Dismantle ' + titleBranch + ' Pending ', // + bulanReport,
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

                    $('#canvasTotCancel').empty();

                    let chartCancel = `
					<figure class="highcharts-figure">
					    <div id="TotCancel"></div>
					</figure>
				    `;

                    $('#canvasTotCancel').append(chartCancel);

                    Highcharts.chart('TotCancel', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO Dismantle ' + titleBranch + ' Cancel ', // + bulanReport,
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
                        <th>WO Dismantle</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoClose').append(`
                        <th>WO Dismantle Close</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoPending').append(`
                        <th>WO Dismantle Failed</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoCancel').append(`
                        <th>WO Dismantle Cancel</th>
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
                url: "{{ route('getClusterBranchDismantleFtth') }}",
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
                    $("#smWOCluster").show();
                },
                complete: () => {
                    $("#smWOCluster").hide();
                },
                success: function(dataCluster) {    
                    $('#tableHeadCluster').find("th").remove();
                    $('#bodyCluster').find("tr").remove();

                    let subtotal;
                    let TotBranchCluster = [];
                    let TotMonthCluster = [];
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

                    $('#tableHeadCluster').append(hdRootCouseAPK + `<th colspan="2" style="text-align: center">Subtotal</th></tr>`);


                    $.each(dataCluster.branchCluster, function(key, nmBranch) {

                        tbBranchCluster = `
                                <tr class="table-secondary"><th>${nmBranch.nmTbranch}</th>
                                <th class="table-secondary"></th>`;
                                // <th class="table-secondary"></th>`;
                        
                        subtotal=0;
                        for (p=0;p<trendWoIBFtth.length; p++) {

                            TotMonthCluster[p]=0
                            $.each(dataCluster.branchCluster, function(key, jmlBln){
                                TotMonthCluster[p] += Number(jmlBln.totbulanan[p]);
                            })

                            tbBranchCluster = tbBranchCluster +
                                `<th class="table-secondary" style="text-align: center">${nmBranch.totbulanan[p].toLocaleString()}</th>
                                <th class="table-secondary" style="text-align: center">${parseFloat((nmBranch.totbulanan[p]*100)/TotMonthCluster[p]).toFixed(1).replace(/\.0$/, '')}%</th>`;

                            subtotal += Number(nmBranch.totbulanan[p]);
   
                        }

                        $('#bodyCluster').append(tbBranchCluster + `<th class="table-secondary" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);

                        $.each(dataCluster.detCluster, function(key, itemCluster) {
                            if (nmBranch.nmTbranch == itemCluster.nama_branch) {
                                tbCluster = `
                                    <tr><td></td>
                                    <td>${itemCluster.cluster}</td>`;
                                    // <th class="table-info"></th>`;
                                
                                subtotal=0;
                                for (cc = 0;cc < trendWoIBFtth.length; cc++) {

                                    TotMonthCluster[cc]=0
                                    $.each(dataCluster.detCluster, function(ky, jmlBlnCL){
                                        TotMonthCluster[cc] += Number(jmlBlnCL.bulanan[cc]);
                                    })

                                    tbCluster = tbCluster + 
                                    `<td style="text-align: center">${itemCluster.bulanan[cc].toLocaleString()}</td>
                                    <td style="text-align: center">${parseFloat((itemCluster.bulanan[cc]*100)/TotMonthCluster[cc]).toFixed(1).replace(/\.0$/, '')}%</th>`;

                                    subtotal += Number(itemCluster.bulanan[cc]);
                                }

                                $('#bodyCluster').append(tbCluster + `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`);

                            }
                        });
                    });


                    let totBulananCluster = `
                        <tr><th class="table-dark">TOTAL</th>
                            <th class="table-dark"></th>`;
                            // <th class="table-dark"></th>`;
                            // <th class="table-dark" style="text-align: center">totpenagihan</th></tr>`;
                    
                    subtotal=0;
                    for (p=0;p<trendWoIBFtth.length; p++) {
                        TotBranchCluster[p] = 0
                        $.each(dataCluster.branchCluster, function(key, totBranchCl) {
                            TotBranchCluster[p] += Number(totBranchCl.totbulanan[p]);
                        })

                        totBulananCluster = totBulananCluster + `
                        <th class="table-dark" style="text-align: center">${TotBranchCluster[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;

                        subtotal += Number(TotBranchCluster[p]);
                    }

                    $('#bodyCluster').append(totBulananCluster + `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);
                }

            });

            
            $.ajax({
                url: "{{ route('getTabelStatusDismantleFtth') }}",
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
                    $('#dateMonth').append(`<th>Dismantle ${titleBranch}</th>`)

                    $('#woDone').find("td").remove();
                    $('#woDone').find("th").remove();
                    $('#woDone').append("<td>Done</td>")

                    $('#woPending').find("td").remove();
                    $('#woPending').find("th").remove();
                    $('#woPending').append("<td>Dismantle Failed</td>")

                    $('#woCancel').find("td").remove();
                    $('#woCancel').find("th").remove();
                    $('#woCancel').append("<td>Cancel</td>")

                    $('#totWo').find("td").remove()
                    $('#totWo').find("th").remove()
                    $('#totWo').append("<th>Total Wo</th>")


                    $.each(data, function(key, item) {
                        // day.push(new Date(item.tgl_ikr).getDate());
                        day.push(new Date(item.visit_date).getDate());
                        doneDay.push(item.Done);
                        pendingDay.push(item.Pending);
                        cancelDay.push(item.Cancel);

                        let htgl = `
                           <th>${new Date(item.visit_date).getDate()}</th>
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

                    $('#woDone').append(`<th>${parseFloat((totDone * 100) / total).toFixed().replace(/\.0$/, '')}%</th>`)
                    $('#woPending').append(
                        `<th>${parseFloat((totPending * 100) / total).toFixed().replace(/\.0$/, '')}%</th>`)
                    $('#woCancel').append(
                        `<th>${parseFloat((totCancel * 100) / total).toFixed().replace(/\.0$/, '')}%</th>`)


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
                            text: 'Status WO Dismantle FTTH - ' + titleBranch + ' ' +
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
                url: "{{ route('getTrendMonthlyDismantleFtth') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
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
                                    text: 'Trend WO Dismantle',
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
                                    text: 'Trend WO Dismantle Close',
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
                url: "{{ route('getReasonStatusDismantleFtthGraph') }}",
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
                            text: 'Reason Status WO Dismantle Close Daily - ' +
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
                url: "{{ route('getRootCouseAPKDismantleFtth') }}",
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
                    let TotMonthly = [];
                    let TotPenagihan = [];
                    let tbPenagihanAPK;
                    let tbCouseCodeAPK;
                    let tbRootCouseAPK;
                    let hdRootCouseAPK = `
                        <th>Reason Status Dismantle Close</th>`;
                        // <th>Reason Status</th>`;
                        // <th>Root Couse</th>`;
                    // <th style="text-align: center">Jumlah</th>`;

                for (h = 0; h < trendWoIBFtth.length; h++) {
                    hdRootCouseAPK = hdRootCouseAPK +
                        `<th colspan="2" style="text-align: center">${trendWoIBFtth[h].bulan.toLocaleString()}</th>`
                }

                $('#rootCouseHeadAPK').append(hdRootCouseAPK + `<th colspan="2" style="text-align: center">Subtotal</th></tr>`);


                $.each(apk.detPenagihanSortir, function(key, itemPenagihan) {

                    tbPenagihanAPK = `
                                    <tr><th>${itemPenagihan.penagihan}</th>`;
                                    // <th class="table-secondary"></th>`;
                                    // <th class="table-secondary"></th>`;
                    
                    subtotal=0;
                    for (p = 0; p < trendWoIBFtth.length; p++) {
                        tbPenagihanAPK = tbPenagihanAPK +
                            `<td style="text-align: center">${itemPenagihan.bulanan[p].toLocaleString()}</td>
                            <td style="text-align: center">${itemPenagihan.persen[p]}%</td>`;

                        subtotal += Number(itemPenagihan.bulanan[p]);

                    }

                    $('#bodyRootCouseAPK').append(tbPenagihanAPK + `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`);

                });


                let totRootCouseAPK = `
                            <tr><th class="table-dark">TOTAL</th>`;
                                // <th class="table-dark"></th>`;
                                // <th class="table-dark"></th>`;
                // <th class="table-dark" style="text-align: center">totpenagihan</th></tr>`;
                    subtotal=0;
                    for (p = 0; p < trendWoIBFtth.length; p++) {
                        TotPenagihan[p] = 0
                        $.each(apk.detPenagihanSortir, function(key, iPenagihan) {
                            TotPenagihan[p] += Number(iPenagihan.bulanan[p]);
                        })

                        totRootCouseAPK = totRootCouseAPK +
                            `<th class="table-dark" style="text-align: center">${TotPenagihan[p].toLocaleString()}</th>
                            <th class="table-dark" style="text-align: center"></th>`;

                        subtotal+= Number(TotPenagihan[p]);
                    }

                    $('#bodyRootCouseAPK').append(totRootCouseAPK + `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);
                }

            });

            $.ajax({
                url: "{{ route('getRootCousePendingGraphDismantleFtth') }}",
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
                            text: 'Reason Status WO Dismantle Failed Daily - ' +
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
                url: "{{ route('getRootCousePendingDismantleFtth') }}",
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
                    let TotPenagihan = [];
                    var TotRootDonePending = 0;
                    let tbRootCousePending;
                    let hdRootCousePending = `
                        <tr>
                                <th>Reason Status Dismantle Pending</th>
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
                                tbRootCousePending = tbRootCousePending +
                                    `<td style="text-align: center">${item.bulanan[bln].toLocaleString()}</td>
                                    <td style="text-align: center">${item.persen[bln].toLocaleString()} %</td>`;

                                subtotal += Number(item.bulanan[bln]);

                            }
                        

                        tbRootCousePending = tbRootCousePending + `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`;
                        $('#rootCouseTbPending').append(tbRootCousePending);

                    });

                    let totRootCouseAPK = `
                            <th class="table-dark">TOTAL</th>`;

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

                    $('#totRootCousePending').append(totRootCouseAPK + `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th>`);

                    
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
