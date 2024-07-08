@extends('layout.main')

@section('content')
    <div class="row" id="mychart">

        {{-- <div class="row"> --}}

        <div class="col-sm-12">
            <div class="card bg-light">
                <div class="card-body">
                    <form action="#">
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

                            <div class="form-group">
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-sm btn-success filterDashBoard" id="filterDashBoard">Filter</button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>



    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Summary WO FTTH Maintenance - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen, Underground)</h5></h6>
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
                <div class="card-body" id="canvasTotWOMt">
                    {{-- <canvas id="TotWoMt"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body" id="canvasTotWOMtClose">
                    {{-- <canvas id="TotWoMtClose"></canvas> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body" id="canvasTotMTDone">
                    {{-- <canvas id="TotWoMt"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body" id="canvasTotMTPending">
                    {{-- <canvas id="TotWoMtClose"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body" id="canvasTotMTCancel">
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
                                    <th>Total WO FTTH Maintenance</th>
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
                                    <th>WO Maintenance Close</th>
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
                                    <th>WO Maintenance Failed</th>
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
                                    <th>WO Maintenance Cancel</th>
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
                    <h6>Summary WO FTTH Maintenance By Cluster Area - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen, Underground)<h5></h6>
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
                    <h6>Trend WO FTTH Maintenance - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen, Underground)<h5></h6>
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
                    <canvas id="TrendTotWoMt" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoClose"></h6>
                    <canvas id="TrendTotWoMtClose"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" id="canvasTrendDialyWo">

                    {{-- <canvas id="TrendTotWoMtApart" style="align-content: center; align-items: center"></canvas> --}}
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
                            width="100%" cellspacing="0" style="font-size: 12px; table-layout: auto;">
                            <thead>
                                <tr id="dateMonth">
                                    <th>Maintenance All Branch</th>
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
                                    <td>Maintenance Failed</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">545</td> --}}
                                </tr>
                                <tr id="woCancel">
                                    <td>Cancel</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">770</td> --}}
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr id="totWo">
                                    <th class="table-dark">Total WO</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">3,895</th> --}}
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
                    <h6>Summary Root Couse Closing WO FTTH Maintenance<h5 id="CardTitle">All Branch - All Site (Retail, Apartemen, Underground)<h5></h6>
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

                    {{-- <canvas id="TrendTotWoMtApart" style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="font-size: 11px; table-layout: auto;">
                            <thead>
                                <tr id="rootCouseHead">
                                    {{-- <th>Root Couse Penagihan (Sortir)</th> --}}
                                    {{-- <th></th> --}}
                                    {{-- <th></th> --}}
                                    {{-- <th style="text-align: center">Jumlah</th> --}}
                                </tr>
                            </thead>
                            <tbody id="bodyRootCouse">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        {{-- Root Couse Sortir MT --}}
        <div class="col-sm-12">
            <div class="table-responsive">
                <table id="TabelRootCouseAPK" class="table table-bordered border-primary" style="font-size: 11px; table-layout: auto;">
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
                    <h6>Summary Root Couse Pending WO FTTH Maintenance - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen, Underground)<h5></h6>
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

                    {{-- <canvas id="TrendTotWoMtApart" style="align-content: center; align-items: center"></canvas> --}}
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
                            cellspacing="0" style="font-size: 12px; table-layout: auto;">
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
                    <h6>Summary Root Cause Cancel WO FTTH Maintenance - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen, Underground)<h5></h6>
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

                    {{-- <canvas id="TrendTotWoMtApart" style="align-content: center; align-items: center"></canvas> --}}
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
                            cellspacing="0" style="font-size: 12px; table-layout: auto;">
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

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Summary Root Couse Cancel System Problem/Back To Normal WO FTTH Maintenance - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen, Underground)<h5></h6>

                    <div class="clearfix" id="smWOCancelSysProb" style="display: none">
                        <div class="spinner-border float-right" role="status">
                            <span class="sr-only" >Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleBackToNormal"></h6>
                    <div>
                    <canvas id="GraphWoBTN"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- Back To Normal Sortir MT --}}
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered border-secondary"
                            style="font-size: 11px; table-layout: auto;;">
                            <thead>
                                <tr id="backToNormalHead">
                                </tr>
                            </thead>
                            <tbody id="bodyBackToNormal">
                            </tbody>
                            <tfoot>
                                <tr id="totSysProblem">
                                    {{-- <th class="table-dark">Total</th>
                            <th class="table-dark"></th> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Back To Normal Sortir MT --}}
    </div>

    <div class="row">

        {{-- Back To Normal 2 Sortir MT --}}
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary"
                            style="font-size: 11px; table-layout: auto;">
                            <thead>
                                <tr id="PersenBackToNormalHead">
                                    {{-- <th>Persentase WO Back To Normal</th> --}}
                                </tr>
                            </thead>
                            <tbody id="PersenBodyBackToNormal">
                                <tr id="totWoMT">
                                    {{-- <th>Total WO Maintenance</th> --}}
                                </tr>
                                <tr id="totWoBtn">
                                    {{-- <th>Total WO Back To Normal</th> --}}
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr id="PersenTotSysProblem">
                                    {{-- <th class="table-dark">Total</th> --}}
                                    {{-- <th class="table-dark"></th> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Back To Normal 2 Sortir MT --}}
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Summary Analisa Bad Precon WO FTTH Maintenance<h5 id="CardTitleAnalisPrecon">All Branch<h5></h6>
                    <div class="clearfix" id="smWOAnalisPrecon" style="display: none">
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
            <div class="table-responsive">
                <table class="table table-bordered border-primary" style="font-size: 11px; table-layout: auto;">
                    <thead>
                        <tr id="analisHeadAPK">
                            {{-- <th>Root Couse Penagihan (Sortir)</th> --}}
                            {{-- <th></th> --}}
                            {{-- <th></th> --}}
                            {{-- <th style="text-align: center">Jumlah</th> --}}
                        </tr>
                    </thead>
                    <tbody id="analisAPK">
                    </tbody>
                </table>
            </div>
        </div>
        {{-- End Root Couse Sortir MT --}}
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
                                    {{-- <th>slot_time_leader</th> --}}
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
                                    {{-- <th>alasan_tag_alarm</th> --}}
                                    {{-- <th>tgl_jam_reschedule</th> --}}
                                    {{-- <th>tgl_jam_fat_on</th> --}}
                                    <th>action_taken</th>
                                    <th>panjang_kabel</th>
                                    <th>weather</th>
                                    <th>remark_status</th>
                                    <th>action_status</th>
                                    {{-- <th>start_ikr_wa</th> --}}
                                    {{-- <th>end_ikr_wa</th> --}}
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
                                    {{-- <th>login</th> --}}
                                    {{-- <th>action</th> --}}
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>




                    {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}
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
    <script src="{{ asset('assets/js/chartjs-plugin-datalabels.min.js')}}"></script>

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


        
        $(document).on('change', '#bulanReport', function(){
            bln = new Date($(this).val()).getMonth();
            thn = new Date($(this).val()).getFullYear();

            firstDate = moment([thn, bln]);
            lastDate = moment(firstDate).endOf('month');
            // console.log("firsDate : ", firstDate.toDate());
            // console.log("lastDate : ", lastDate.toDate());

            $('#periode').data('daterangepicker').setStartDate(firstDate);
            $('#periode').data('daterangepicker').setEndDate(lastDate);

        });
        
        
        $(document).on('change', '#branch', function(){
            let filBranch = $(this).val()

            $.ajax({
                url: "{{ route('getFilterBranch') }}",
                type: "GET",
                data: {
                    branchReport: filBranch
                },
                success: function(filterBranch) {
                    $('#kotamadya').find("option").remove();

                    $('#kotamadya').append(`
                        <option value="All">All</option>
                    `);

                    $.each(filterBranch, function(key, item){
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

            // analisa Precon
            if(detAPK[0]=="analisa_precon"){
                if(detAPK[1]=="result") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1],
                            detResult: detAPK[2], 
                            // detPenagihan: detAPK[2],
                            detBulan: detAPK[3],
                            detThn: detAPK[4],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = '';
                }
                if(detAPK[1]=="penagihan") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1],
                            detResult: detAPK[2], 
                            detPenagihan: detAPK[3],
                            // detCouse_code: detAPK[3],
                            detBulan: detAPK[4],
                            detThn: detAPK[5],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = detAPK[3];
                }
                if(detAPK[1]=="root_couse") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1], 
                            detResult: detAPK[2],
                            detPenagihan: detAPK[3],
                            // detCouse_code: detAPK[3],
                            detRoot_couse: detAPK[4],
                            detBulan: detAPK[5],
                            detThn: detAPK[6],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = detAPK[3] + " - " + detAPK[4];
                }

                
            }
            // End Analisa Precon

            bulanData = months[datafilter.detBulan - 1] + "-" + datafilter.detThn;

            $('#md-detail').modal('show');
            $('#canvasDetailAPK').empty();
            event.stopPropagation()

            $.ajax({
                url: "{{ route('getDetailAPK') }}",
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
                            url: "{{ route('dataDetailAPK') }}",
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
            $('#canvasTotWOMt').empty();
        })

        $('#filterDashBoard').on('click', function(e) {

            // console.log($('#periode').data('daterangepicker').startDate.format("YYYY-MM-DD"))
            // console.log($('#periode').data('daterangepicker').endDate.format("YYYY-MM-DD"))
            
            
            e.preventDefault();
            if($('#bulanReport').val() === ""){
                alert('Pilih Bulan Report');
                return;
            }

            let bulanReport = $('#bulanReport').val();

            // console.log(moment([new Date(bulanReport).getFullYear(), new Date(bulanReport).getMonth()]).format("DD-MM-YYYY"));
            let trendWoMt;
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

            if(filBranch == "All"){
                titleBranch = "All Branch";
            } else {
                titleBranch = "Branch " + filBranch;
            }

            if(filSite == "All"){
                titleSite = "All Site (Retail, Apartemen, Underground)";
            } else {
                titleSite = "Site " + filSite;
            }
            
            document.querySelectorAll('#CardTitle').forEach(function(elem){
                elem.innerText = titleBranch + " - " + titleSite; 
            })

            document.querySelectorAll('#CardTitleAnalisPrecon').forEach(function(elem){
                elem.innerText = titleBranch; 
            })
            // console.log($('#CardTitle').html("testing"));

            $.ajax({
                url: "{{ route('getMonthly') }}",
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
                    trendWoMt = dataTrendMonthly;

                }

            })


            let uri;
            if ((filSite == "All") && (filBranch == "All")){
                uri = "{{ route('getTotalWoBranch')}}";
            }else {
                uri = "{{ route('getFilterDashboard')}}";
            }
            
            $.ajax({
                // url: "{{ route('getTotalWoBranch') }}",
                url: uri, //( filSite == "All" ) ? "{{ route('getTotalWoBranch')}}" : "{{ route('getFilterDashboard')}}",
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

                            branch.push(item.nama_branch);
                            totWoDone.push([item.nama_branch + " " + item.done.toLocaleString(), item.done]);
                            branchWTot.push([item.nama_branch + " " + item.total.toLocaleString(), item.total]);
                        
                        totWo.push(item.total);
                        
                    });

                    
                    $('#canvasTotWOMt').empty();
                    

                    let chartWoType = `
					<figure class="highcharts-figure">
					    <div id="container7"></div>
					</figure>
				    `;

                    $('#canvasTotWOMt').append(chartWoType);

                    Highcharts.chart('container7', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: 'Total WO FTTH Maintenance - ' + bulanReport,
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
                                    distance: 20
                                }]
                            }
                        },
                        series: [{
                            name: 'Total WO',
                            colorByPoint: true,
                            data: branchWTot

                        }]
                    });

                   

                    $('#canvasTotWOMtClose').empty();

                    let chartWoTypeClose = `
					<figure class="highcharts-figure">
					    <div id="container8"></div>
					</figure>
				    `;

                    $('#canvasTotWOMtClose').append(chartWoTypeClose);

                    Highcharts.chart('container8', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: 'WO FTTH Maintenance Done - ' + bulanReport,
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
                                    distance: 20
                                }]
                            }
                        },
                        series: [{
                            name: 'WO Done',
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
                        ChrDone.push([item.done]);

                    });

                    $('#canvasTotMTDone').empty();

                    let chartMTDone = `
					<figure class="highcharts-figure">
					    <div id="TotMTDone"></div>
					</figure>
				    `;

                    $('#canvasTotMTDone').append(chartMTDone);

                    Highcharts.chart('TotMTDone', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO FTTH Maintenance Done', //+ bulanReport,
                            align: 'left'
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
                        ChrPending.push([item.pending]);

                    });

                    $('#canvasTotMTPending').empty();

                    let chartMTPending = `
					<figure class="highcharts-figure">
					    <div id="TotMTPending"></div>
					</figure>
				    `;

                    $('#canvasTotMTPending').append(chartMTPending);

                    Highcharts.chart('TotMTPending', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO FTTH Maintenance Pending', // + bulanReport,
                            align: 'left'
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
                        ChrCancel.push([item.cancel]);

                    });

                    $('#canvasTotMTCancel').empty();

                    let chartMTCancel = `
					<figure class="highcharts-figure">
					    <div id="TotMTCancel"></div>
					</figure>
				    `;

                    $('#canvasTotMTCancel').append(chartMTCancel);

                    Highcharts.chart('TotMTCancel', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Top WO FTTH Maintenance Cancel', // + bulanReport,
                            align: 'left'
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
                        <th>Total WO FTTH Maintenance</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoClose').append(`
                        <th>WO FTTH Mintenance Done</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoPending').append(`
                        <th>WO FTTH Mintenance Pending</th>
                        <th style="text-align: center; vertical-align: middle;">${bulanReport}</th>
                        <th style="text-align: center; vertical-align: middle;">%</th>
                            `);

                    $('#theadTotWoCancel').append(`
                        <th>WO FTTH Mintenance Cancel</th>
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
                        <th class="table-dark">Total WO</th>
                        <th class="table-dark" style="text-align: center; vertical-align: middle;">${totWo.toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center; vertical-align: middle;"></th>
                    `;

                    $('#totalWo').append(isiTotalWo);

                    persenTotClose = (Number(totWoClose) * 100) / Number(totWo);

                    let isiTotalWoClose = `
                    <th class="table-dark">Total Done</th>
                        <th class="table-dark" style="text-align: center; vertical-align: middle;">${totWoClose.toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center; vertical-align: middle;">${persenTotClose.toFixed(1).replace(/\.0$/, '')}%</th>
                    `;


                    $('#totWoClose').append(isiTotalWoClose);

                    persenTotPending = (Number(totWoPending) * 100) / Number(totWo);

                    let isiTotalWoPending = `
                    <th class="table-dark">Total Pending</th>
                        <th class="table-dark" style="text-align: center; vertical-align: middle;">${totWoPending.toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center; vertical-align: middle;">${persenTotPending.toFixed(1).replace(/\.0$/, '')}%</th>
                    `;
                    $('#totWoPending').append(isiTotalWoPending);

                    persenTotCancel = (totWoCancel * 100) / totWo;

                    let isiTotalWoCancel = `
                    <th class="table-dark">Total Cancel</th>
                        <th class="table-dark" style="text-align: center; vertical-align: middle;">${totWoCancel.toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center; vertical-align: middle;">${persenTotCancel.toFixed(1).replace(/\.0$/, '')}%</th>
                    `;
                    $('#totWoCancel').append(isiTotalWoCancel);

                }
                
            })

            $.ajax({
                url: "{{ route('getClusterBranch') }}",
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

                    for (h = 0;h < trendWoMt.length; h++) {
                        hdRootCouseAPK = hdRootCouseAPK +
                            `<th colspan="2" style="text-align: center">${trendWoMt[h].bulan}</th>`
                    }

                    $('#tableHeadCluster').append(hdRootCouseAPK + `<th style="text-align: center">Subtotal</th></tr>`);


                    $.each(dataCluster.branchCluster, function(key, nmBranch) {
                        tbBranchCluster = `
                                <tr class="table-secondary"><th>${nmBranch.nmTbranch}</th>
                                <th class="table-secondary"></th>`;
                                // <th class="table-secondary"></th>`;
                        subtotal=0;

                        for (p=0;p<trendWoMt.length; p++) {

                            TotMonthCluster[p]=0
                            $.each(dataCluster.branchCluster, function(key, jmlBln){
                                TotMonthCluster[p] += Number(jmlBln.totbulanan[p]);
                            })
                            
                            tbBranchCluster = tbBranchCluster +
                                `<th class="table-secondary" style="text-align: center">${nmBranch.totbulanan[p].toLocaleString()}</th>
                                <th class="table-secondary" style="text-align: center">${((nmBranch.totbulanan[p]*100)/TotMonthCluster[p]).toFixed(1).replace(/\.0$/, '')}%</th>`;
                                // <th class="table-secondary" style="text-align: center">${nmBranch.persen[p].toLocaleString()}%</th>`;

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
                                for (cc = 0;cc < trendWoMt.length; cc++) {

                                    TotMonthCluster[cc]=0
                                    $.each(dataCluster.detCluster, function(ky, jmlBlnCL){
                                        TotMonthCluster[cc] += Number(jmlBlnCL.bulanan[cc]);
                                    })

                                    tbCluster = tbCluster + 
                                    `<td style="text-align: center">${itemCluster.bulanan[cc].toLocaleString()}</td>
                                    <td style="text-align: center">${((itemCluster.bulanan[cc]*100)/TotMonthCluster[cc]).toFixed(1).replace(/\.0$/, '')}%</td>`;
                                    // <td style="text-align: center">${itemCluster.persen[cc].toLocaleString()}%</td>`;

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
                            // <th class="table-dark"></th>`;
                            // <th class="table-dark" style="text-align: center">totpenagihan</th></tr>`;
                    
                    subtotal=0;
                    for (p=0;p<trendWoMt.length; p++) {
                        colBln = trendWoMt[p].bulan;
                        colBln = colBln.replace("-","_");
                            
                        TotBranchCluster[p] = 0
                        
                        $.each(dataCluster.branchCluster, function(key, totBranchCl) {
                            TotBranchCluster[p] += Number(totBranchCl.totbulanan[p]);

                            subtotal += Number(totBranchCl.totbulanan[p]);
                        })

                        totBulananCluster = totBulananCluster + 
                        `<th class="table-dark" style="text-align: center">${TotBranchCluster[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;
                    }

                    $('#bodyCluster').append(totBulananCluster + 
                                        `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);
                }

            });

            $.ajax({
                url: "{{ route('getTrendMonthly') }}",
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
                    // var trendWoMt = {!! $trendMonthly !!}
                    trendWoMt = dataTrendMonthly;

                    document.querySelectorAll('#titleTrendTotWo').forEach(function(elem){
                        elem.innerText = 'Trend Total WO FTTH Maintenance ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoClose').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH Maintenance Done ' + titleBranch + " - " + bulanReport; 
                    })

                    var trendMonth = [''];
                    var trendTotMt = ['null'];
                    var trendMtDone = ['null'];

                    $.each(trendWoMt, function(key, item) {

                        trendMonth.push(item.bulan);
                        trendTotMt.push(item.trendMtTotal);
                        trendMtDone.push(item.trendMtDone);

                    });

                    trendMonth.push('');
                    trendTotMt.push('null');
                    trendMtDone.push('null');

                    const ctxTrendTotWoMt = document.getElementById('TrendTotWoMt');

                    var graphTrendTotWoMt = Chart.getChart('TrendTotWoMt');
                    if (graphTrendTotWoMt) {
                        graphTrendTotWoMt.destroy();
                    }


                    var ChartTrendTotWoMT = new Chart(ctxTrendTotWoMt, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendTotMt, //[3895],
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
                                    // text: 'Trend WO Maintenance ' + titleBranch + ' ' + bulanReport,
                                    // align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: true, //this will remove all the x-axis grid lines
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

                    

                    const ctxTrendTotWoMtClose = document.getElementById('TrendTotWoMtClose');

                    var graphTrendTotWoMtClose = Chart.getChart('TrendTotWoMtClose');
                    if (graphTrendTotWoMtClose) {
                        graphTrendTotWoMtClose.destroy();
                    }



                    var ChartTrendTotWoMTClose = new Chart(ctxTrendTotWoMtClose, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendMtDone, //[3082, 3597],
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
                                        return value.toLocaleString();},
                                },
                                title: {
                                    display: 'auto',
                                    // text: 'Trend WO Maintenance ' + titleBranch + ' ' + bulanReport,
                                    // align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: true, //this will remove all the x-axis grid lines
                                    // max: maxChartTot,
                                    // min: minChartTot,
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

                    var maxChartTot = ChartTrendTotWoMT.scales.y.max;
                    var minChartTotClose = ChartTrendTotWoMTClose.scales.y.min;
                    ChartTrendTotWoMTClose.options.scales.y.max = ChartTrendTotWoMT.scales.y.max;
                    ChartTrendTotWoMT.options.scales.y.min= minChartTotClose;

                    ChartTrendTotWoMTClose.update();
                    ChartTrendTotWoMT.update();

                }

            })


            $.ajax({
                url: "{{ route('getTabelStatus') }}",
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
                    $('#dateMonth').append(`<th>Status WO FTTH Maintenance ${titleBranch}</th>`)

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
                    $('#totWo').append(`<th class="table-dark">Total Wo</th>`)


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
                            <td class="table-dark">${totWo.toLocaleString()}</td>
                        `;

                        $('#totWo').append(dtTotWo);


                    });

                    $('#dateMonth').append(`<th>Total</th>`)

                    $('#woDone').append(`<th>${totDone.toLocaleString()}</th>`)

                    $('#woPending').append(`<th>${totPending.toLocaleString()}</th>`)

                    $('#woCancel').append(`<th>${totCancel.toLocaleString()}</th>`)

                    total = totDone + totPending + totCancel

                    $('#totWo').append(`<th class="table-dark">${total.toLocaleString()}</th>`)

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
                            text: 'Status WO FTTH Maintenance - ' + titleBranch + ' ' + bulanReport,
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
                url: "{{ route('getRootCouseAPK') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport,
                    filterTgl: filTglPeriode,
                    filterSite: filSite,
                    filterBranch: filBranch,
                    filterDateStart: filPeriodeStart,
                    filterDateEnd: filPeriodeEnd
                },
                success: function(apk) {    
                    // console.log(apk);

                    $('#rootCouseHeadAPK').find("th").remove();
                    $('#bodyRootCouseAPK').find("tr").remove();

                    $('#rootCouseHead').find("th").remove();
                    $('#bodyRootCouse').find("tr").remove();

                    $('#penagihanAPK').find("th").remove();
                    $('#couseCodePenagihanAPK').find("th").remove();
                    $('#rootCousePenagihanAPK').find("td").remove();

                    let subtotalSM;
                    let subtotalDT;
                    let TotPenagihan = [];
                    let TotSumPenagihan = [];
                    let tbSumPenagihanAPK;
                    let tbPenagihanAPK;
                    let tbCouseCodeAPK;
                    let tbRootCouseAPK;
                    let blnId;
                    let thnId;
                    let detailCel;

                    let hdRootCouse = `
                        <th>Penagihan</th>`;

                    let hdRootCouseAPK = `
                        <th>Penagihan</th>
                        <th>Couse Code</th>
                        <th>Root Couse</th>`;
                        // <th style="text-align: center">Jumlah</th>`;

                    for (h = 0;h < trendWoMt.length; h++) {
                        hdRootCouse = hdRootCouse +
                            `<th colspan="2" style="text-align: center">${trendWoMt[h].bulan.toLocaleString()}</th>`;

                        hdRootCouseAPK = hdRootCouseAPK +
                            `<th colspan="2" style="text-align: center">${trendWoMt[h].bulan.toLocaleString()}</th>`;
                            //  <th style="text-align: center">% ${trendWoMt[h].bulan.toLocaleString()}</th>`
                    }

                    $('#rootCouseHead').append(hdRootCouse + `<th colspan="2" style="text-align: center">Subtotal</th></tr>`);
                    $('#rootCouseHeadAPK').append(hdRootCouseAPK + `<th colspan="2" style="text-align: center">Subtotal</th></tr>`);
                    


                    $.each(apk.detPenagihanSortir, function(key, itemPenagihan) {

                        tbSumPenagihanAPK = `
                                <tr><td>${itemPenagihan.penagihan}</td>`;

                        tbPenagihanAPK = `
                                <tr class="table-secondary"><td style="font-weight:bold" >${itemPenagihan.penagihan}</td>
                                <td class="table-secondary"></td>
                                <td class="table-secondary"></td>`;
                        
                        subtotalSM = 0;
                        subtotalDT = 0;
                        for (p=0;p<trendWoMt.length; p++) {
                            // console.log(trendWoMt[p]);
                            // new Date($(this).val()).getMonth()
                            blnId = new Date(trendWoMt[p].bulan).getMonth();
                            thnId = new Date(trendWoMt[p].bulan).getFullYear();
                            detailCel = `${itemPenagihan.penagihan}|${(blnId + 1)}|${thnId}`;
                            tbSumPenagihanAPK = tbSumPenagihanAPK +
                                `<td style="text-align: center" >${itemPenagihan.bulanan[p].toLocaleString()}</td>
                                <td style="text-align: center">${itemPenagihan.persen[p].toLocaleString()}%</td>`;

                            tbPenagihanAPK = tbPenagihanAPK +
                                `<td class="table-secondary" style="text-align: center; font-weight:bold" 
                                ><span id="rootCouseAPK|penagihan|${detailCel}" onClick="det_click(this.id)">${itemPenagihan.bulanan[p].toLocaleString()}</span></td>

                                <td class="table-secondary" style="text-align: center; font-weight:bold">${itemPenagihan.persen[p].toLocaleString()}%</td>`;

                            subtotalSM += Number(itemPenagihan.bulanan[p]);
                            subtotalDT += Number(itemPenagihan.bulanan[p]);

   
                        }

                        detailCelDT = `rootCouseAPK|penagihan|${itemPenagihan.penagihan}|All|All`;

                        $('#bodyRootCouse').append(tbSumPenagihanAPK + `<td style="text-align: center">${subtotalSM.toLocaleString()}</td></tr>`);
                        $('#bodyRootCouseAPK').append(tbPenagihanAPK + 
                            `<th class="table-secondary" style="text-align: center" id="${detailCelDT}" >${subtotalDT.toLocaleString()}</th></tr>`);


                        $.each(apk.detCouseCodeSortir, function(key, itemCouseCode) {
                            if (itemPenagihan.penagihan == itemCouseCode.penagihan) {
                                tbCouseCodeAPK = `
                                    <tr><th></th>
                                    <th class="table-info">${itemCouseCode.couse_code}</th>
                                    <th class="table-info"></th>`;
                                
                                subtotalDT = 0;
                                for (cc = 0;cc < trendWoMt.length; cc++) {
                                    blnId = new Date(trendWoMt[cc].bulan).getMonth();
                                    thnId = new Date(trendWoMt[cc].bulan).getFullYear();
                                    detailCel = `${itemPenagihan.penagihan}|${itemCouseCode.couse_code}|${(blnId + 1)}|${thnId}`;
                                    tbCouseCodeAPK = tbCouseCodeAPK + 
                                    `<td class="table-info" style="text-align: center" font-weight:bold">
                                        <span id="rootCouseAPK|couse_code|${detailCel}" onClick="det_click(this.id)">${itemCouseCode.bulanan[cc].toLocaleString()}</span></td>
                                    <td class="table-info" style="text-align: center" font-weight:bold">${itemCouseCode.persen[cc].toLocaleString()}%</td>`;

                                    subtotalDT += Number(itemCouseCode.bulanan[cc]);
                                }

                                detailCelDT = `rootCouseAPK|couse_code|${itemPenagihan.penagihan}|${itemCouseCode.couse_code}|All|All`;

                                $('#bodyRootCouseAPK').append(tbCouseCodeAPK + 
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
                                        for (rc = 0; rc < trendWoMt.length; rc++) {
                                            blnId = new Date(trendWoMt[rc].bulan).getMonth();
                                            thnId = new Date(trendWoMt[rc].bulan).getFullYear();
                                            detailCel = `${itemPenagihan.penagihan}|${itemCouseCode.couse_code}|${itemRootCouse.root_couse}|${(blnId + 1)}|${thnId}`;
                                    
                                            tbRootCouseAPK = tbRootCouseAPK +
                                            `<td style="text-align: center" >
                                                <span id="rootCouseAPK|root_couse|${detailCel}" onClick="det_click(this.id)">${itemRootCouse.bulanan[rc].toLocaleString()}</span></td>
                                            <td style="text-align: center">${itemRootCouse.persen[rc].toLocaleString()}%</td>`;

                                            subtotalDT += Number(itemRootCouse.bulanan[rc]);

                                        }

                                        detailCelDT = `rootCouseAPK|root_couse|${itemPenagihan.penagihan}|${itemCouseCode.couse_code}|${itemRootCouse.root_couse}|All|All`;

                                        $('#bodyRootCouseAPK').append(tbRootCouseAPK + 
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
                            // <th class="table-dark" style="text-align: center">totpenagihan</th></tr>`;

                    let totSumRootCouseAPK = `
                        <tr><th class="table-dark">TOTAL</th>`;
                    
                    subtotalDT = 0;
                    subtotalSM = 0;
                    for (p=0;p<trendWoMt.length; p++) {
                        TotPenagihan[p] = 0
                        TotSumPenagihan[p] = 0

                        $.each(apk.detPenagihanSortir, function(key, iPenagihan) {
                            TotPenagihan[p] += Number(iPenagihan.bulanan[p]);
                            TotSumPenagihan[p] += Number(iPenagihan.bulanan[p]);

                            subtotalDT += Number(iPenagihan.bulanan[p]);
                            subtotalSM += Number(iPenagihan.bulanan[p]);
                        })

                        totRootCouseAPK = totRootCouseAPK + 
                        `<th class="table-dark" style="text-align: center" >${TotPenagihan[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;

                        totSumRootCouseAPK = totSumRootCouseAPK + 
                        `<th class="table-dark" style="text-align: center">${TotSumPenagihan[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;
                    }

                    $('#bodyRootCouse').append(totSumRootCouseAPK + `<th class="table-dark" style="text-align: center">${subtotalSM.toLocaleString()}</th></tr>`);
                    $('#bodyRootCouseAPK').append(totRootCouseAPK + `<th class="table-dark" style="text-align: center">${subtotalDT.toLocaleString()}</th></tr>`);
                }

            });

            

            $.ajax({
                url: "{{ route('getRootCouseAPKGraph') }}",
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
                    $("#smWOClosing").show();
                },
                complete: () => {
                    $("#smWOClosing").hide();
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

                    for(tg=0;tg<data.tglGraphAPK.length;tg++){
                        
                        dayGraph.push(new Date(data.tglGraphAPK[tg].tgl_ikr).getDate())
                        

                    }

                    for(nm=0;nm<data.nameGraphAPK.length;nm++){
                        
                        nameGraph.push({name: data.nameGraphAPK[nm].penagihan});
                           
                            nameGraph[nm]['data'] = data.dataGraphAPK[nm].data
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
                            text: 'Daily Report Root Couse WO FTTH Maintenance Done - ' + titleBranch + ' ' + bulanReport,
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
                url: "{{ route('getRootCousePendingGraph') }}",
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

                    for(tg=0;tg<data.tglGraphAPKPending.length;tg++){

                        dayGraphPending.push(new Date(data.tglGraphAPKPending[tg].tgl_ikr).getDate())

                    }

                    for(nm=0;nm<data.nameGraphAPKPending.length;nm++){
                        nameGraphPending.push({name: data.nameGraphAPKPending[nm].penagihan});

                        nameGraphPending[nm]['data'] = data.dataGraphAPKPending[nm].data
                        
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
                            text: 'Daily Report WO FTTH Maintenance Pending - ' + titleBranch + ' ' + bulanReport,
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
                url: "{{ route('getRootCousePending') }}",
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
                    var TotPenagihanPending = [];
                    var TotRootDonePending = 0;
                    let tbRootCousePending;
                    let blnId;
                    let thnId;
                    let detailCel;

                    let hdRootCousePending = `
                        <tr>
                                <th>Status WO Pending</th>
                        </tr>`;

                    $('#rootCouseHeadPending').append(hdRootCousePending);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHeadPending').find("tr").append(
                            `<th colspan="2" style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                        )
                    }

                    $('#rootCouseHeadPending').find("tr").append(
                            `<th style="text-align: center">Subtotal</th>`
                        )

                    $.each(dataRootCousePending, function(key, item) {

                        tbRootCousePending = `
                            <tr>
                            <td>${item.penagihan}</td>`;

                        subtotal=0
                        for (pn=0; pn<trendWoMt.length; pn++){

                            blnId = new Date(trendWoMt[pn].bulan).getMonth();
                            thnId = new Date(trendWoMt[pn].bulan).getFullYear();
                            detailCel = `pending|penagihan|${item.penagihan}|${(blnId + 1)}|${thnId}`;

                            tbRootCousePending = tbRootCousePending +
                                    `<td style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${item.bulanan[pn].toLocaleString()}</td>
                                    <td style="text-align: center">${item.persen[pn].toLocaleString()} %</td>`;

                            subtotal += Number(item.bulanan[pn]);
                        }

                        tbRootCousePending = tbRootCousePending + `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`;

                        $('#rootCouseTbPending').append(tbRootCousePending);

                    });


                    let totRootPending = `
                        <th class="table-dark">TOTAL</th>`;

                    subtotal=0;
                    for (p=0;p<trendWoMt.length; p++) {
                        TotPenagihanPending[p] = 0

                        blnId = new Date(trendWoMt[p].bulan).getMonth();
                        thnId = new Date(trendWoMt[p].bulan).getFullYear();
                        detailCel = `pending|total|All|${(blnId + 1)}|${thnId}`;
                        
                        $.each(dataRootCousePending, function(key, iPenagihan) {
                            TotPenagihanPending[p] += Number(iPenagihan.bulanan[p]);
                            subtotal += Number(iPenagihan.bulanan[p]);
                        })

                        totRootPending = totRootPending + 
                        `<th class="table-dark" style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${TotPenagihanPending[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;
                    }

                    $('#totRootCousePending').append(totRootPending + 
                                    `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th>`
                    );
                }

            });

            $.ajax({
                url: "{{ route('getRootCouseCancelGraph') }}",
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

                    for(tg=0;tg<data.tglGraphAPKCancel.length;tg++){
                        // console.log(data.tglGraphAPK[tg].tgl_ikr)
                        dayGraphCancel.push(new Date(data.tglGraphAPKCancel[tg].tgl_ikr).getDate())
                        

                    }

                    for(nm=0;nm<data.nameGraphAPKCancel.length;nm++){
                        // console.log(data.nameGraphAPK[nm].penagihan);
                        nameGraphCancel.push({name: data.nameGraphAPKCancel[nm].penagihan});
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
                            text: 'Daily Report WO FTTH Maintenance Cancel - ' + titleBranch + ' ' + bulanReport,
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
                url: "{{ route('getRootCouseCancel') }}",
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
                    var TotPenagihanCancel = [];
                    var TotRootDoneCancel = 0;
                    let tbRootCouseCancel;
                    let blnId;
                    let thnId;
                    let detailCel;
                    let hdRootCouseCancel = `
                        <tr>
                                <th>Status WO Cancel</th>
                        </tr>`;

                    $('#rootCouseHeadCancel').append(hdRootCouseCancel);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHeadCancel').find("tr").append(
                            `<th colspan="2" style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                        )
                    }

                    $('#rootCouseHeadCancel').find("tr").append(
                            `<th colspan="2" style="text-align: center">Subtotal</th>`
                        )

                    $.each(dataRootCouseCancel, function(key, item) {

                        tbRootCouseCancel = `
                            <tr>
                                <td>${item.penagihan}</td>`;
                        
                        subtotal=0;
                        for (bln = 0; bln < trendWoMt.length; bln++) {
                            blnId = new Date(trendWoMt[bln].bulan).getMonth();
                            thnId = new Date(trendWoMt[bln].bulan).getFullYear();
                            detailCel = `cancel|penagihan|${item.penagihan}|${(blnId + 1)}|${thnId}`;
                            tbRootCouseCancel = tbRootCouseCancel +
                                `<td style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${item.bulanan[bln].toLocaleString()}</td>
                                <td style="text-align: center">${item.persen[bln].toLocaleString()} %</td>`;

                            subtotal += Number(item.bulanan[bln]);
                        }

                        tbRootCouseCancel = tbRootCouseCancel + `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`;
                        $('#rootCouseTbCancel').append(tbRootCouseCancel);

                    });

                    let totRootCancel = `
                        <th class="table-dark">TOTAL</th>`;
                            // <th class="table-dark"></th>
                            // <th class="table-dark"></th>`;
                            // <th class="table-dark" style="text-align: center">totpenagihan</th></tr>`;

                    subtotal=0;
                    for (p=0;p<trendWoMt.length; p++) {
                        TotPenagihanCancel[p] = 0

                        blnId = new Date(trendWoMt[p].bulan).getMonth();
                        thnId = new Date(trendWoMt[p].bulan).getFullYear();
                        detailCel = `cancel|total|All|${(blnId + 1)}|${thnId}`;

                        $.each(dataRootCouseCancel, function(key, iPenagihan) {
                            TotPenagihanCancel[p] += Number(iPenagihan.bulanan[p]);
                            subtotal += Number(iPenagihan.bulanan[p]);
                        })

                        totRootCancel = totRootCancel + 
                        `<th class="table-dark" style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${TotPenagihanCancel[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;
                    }

                    $('#totRootCouseCancel').append(totRootCancel + `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th>`);

                }

            });


            $.ajax({
                url: "{{ route('getCancelSystemProblem') }}",
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
                    $("#smWOCancelSysProb").show();
                },
                complete: () => {
                    $("#smWOCancelSysProb").hide();
                },
                success: function(btn) {

                    document.querySelectorAll('#titleBackToNormal').forEach(function(elem){
                        elem.innerText = 'WO Back To Normal'
                    })

                    let subtotal1;
                    let subtotal2;
                    var btnMonth = [];
                    var btnTotMt = [];
                    var btnTot = [];

                    $('#backToNormalHead').find("th").remove();
                    $('#bodyBackToNormal').find("tr").remove();
                    $('#totSysProblem').find("th").remove();

                    $('#totSysProblem').append(
                        `<th class="table-dark">Total</th>
                        <th class="table-dark"></th>`);

                    $('#PersenBackToNormalHead').find("th").remove();
                    $('#PersenBackToNormalHead').append(`<th>Persentase Back To Normal</th>`);

                    $('#totWoMT').find("th").remove();
                    $('#totWoMT').find("td").remove();
                    $('#totWoMT').append(`<th>Total WO FTTH Maintenance</th>`);

                    $('#totWoBtn').find("th").remove();
                    $('#totWoBtn').find("td").remove();
                    $('#totWoBtn').append(`<th>Total WO FTTH Maintenance Back To Normal</th>`);

                    $('#PersenTotSysProblem').find("th").remove();
                    $('#PersenTotSysProblem').append(`<th class="table-dark">Total</th>`);



                    var TotBtn = 0;
                    var TotPersenSysMT = 0;
                    var TotPersenSysBtn = 0;
                    let tbBtn;
                    let hdBtn = `
                                <th>WO Back To Normal</th>
                                <th></th>`;

                    $('#backToNormalHead').append(hdBtn);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#backToNormalHead').append(
                            `<th colspan="2" style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                        )
                    }

                    $('#backToNormalHead').append(
                            `<th style="text-align: center">Subtotal</th>`
                    )

                    $.each(btn.statVisit, function(key, itemVisit) {
                        tbBtn = tbBtn +
                            `<tr><th class="table-secondary">${itemVisit.visit_novisit}</th>
                            <th class="table-secondary"></th>`;
                        subtotal1=0;
                        for (bln = 0; bln < trendWoMt.length; bln++) {
                            tbBtn = tbBtn +
                                `<th class="table-secondary" style="text-align: center">${itemVisit.bulanan[bln].toLocaleString()}</th>
                                <th class="table-secondary" style="text-align: center">${itemVisit.persen[bln].toLocaleString()}%</th>`;

                            subtotal1 += Number(itemVisit.bulanan[bln]);
                            TotBtn += Number(itemVisit.bulanan[bln]);

                        }

                        tbBtn = tbBtn + `<th class="table-secondary" style="text-align: center">${subtotal1.toLocaleString()}</th></tr>`;

                        $.each(btn.visitSysProblem, function(key, itemSysProblem) {
                            if (itemVisit.visit_novisit == itemSysProblem
                                .visit_novisit) {
                                tbBtn = tbBtn +
                                    `<tr><th></th>
                                            <th class="table-info">${itemSysProblem.action_taken}</th>
                                            `;
                                subtotal2=0;
                                for (bln = 0; bln < trendWoMt.length; bln++) {
                                    tbBtn = tbBtn +
                                        `<td class="table-info" style="text-align: center">${itemSysProblem.bulanan[bln].toLocaleString()}</td>
                                        <td class="table-info" style="text-align: center">${itemSysProblem.persen[bln].toLocaleString()}%</td>`;

                                    subtotal2 += Number(itemSysProblem.bulanan[bln]);

                                }

                                tbBtn = tbBtn +
                                    `<td class="table-info" style="text-align: center">${subtotal2.toLocaleString()}</td>`;
                            }
                        });
                    });

                    $('#bodyBackToNormal').append(tbBtn + `</tr>`);

                    TotPersenSysMT=0;
                    TotPersenSysBtn=0;

                    $.each(btn.totSysProblem, function(key, itemTot) {
                        $('#totSysProblem').append(
                            `<th class="table-dark" style="text-align: center">${itemTot.total}</th>
                            <th class="table-dark" style="text-align: center"></th>
                            `);

                        $('#PersenBackToNormalHead').append(
                            `<th style="text-align: center">${itemTot.bulan}</th>`);

                        $('#totWoMT').append(
                            `<td style="text-align: center">${itemTot.totalMt.toLocaleString()}</td>`
                        );

                        TotPersenSysMT += Number(itemTot.totalMt);

                        $('#totWoBtn').append(
                            `<td style="text-align: center">${itemTot.total.toLocaleString()}</td>`
                        );

                        TotPersenSysBtn += Number(itemTot.total);

                        $('#PersenTotSysProblem').append(
                            `<th class="table-dark" style="text-align: center">${parseFloat((itemTot.total * 100) / itemTot.totalMt).toFixed(1).replace(/\.0$/, '')}%</th>`
                        );


                        btnMonth.push(itemTot.bulan);
                        btnTotMt.push(itemTot.totalMt);
                        btnTot.push(itemTot.total)

                    });

                    $('#totSysProblem').append(
                            `<th class="table-dark" style="text-align: center">${TotBtn.toLocaleString()}</th>`);

                    $('#PersenBackToNormalHead').append(
                                `<th style="text-align: center">Subtotal</th>`);

                    $('#totWoMT').append(
                            `<td style="text-align: center">${TotPersenSysMT.toLocaleString()}</td>`
                        );

                    $('#totWoBtn').append(
                            `<td style="text-align: center">${TotPersenSysBtn.toLocaleString()}</td>`
                        );

                    $('#PersenTotSysProblem').append(
                            `<th class="table-dark" style="text-align: center">${((TotPersenSysBtn * 100) / TotPersenSysMT).toFixed(1).replace(/\.0$/, '')}%</th>`
                        );

                    const ctxBtnWoMt = document.getElementById('GraphWoBTN');

                    var graphBtnWoMt = Chart.getChart('GraphWoBTN');
                    if (graphBtnWoMt) {
                        graphBtnWoMt.destroy();
                    }

                    new Chart(ctxBtnWoMt, {
                        type: 'bar',
                        data: {
                            labels: btnMonth, //['Jan-24'],
                            datasets: [{
                                    label: 'Total WO FTTH Mmaintenance',
                                    data: btnTotMt, //[3895],
                                    borderWidth: 1,

                                },
                                {
                                    label: 'Total WO FTTH MT Back To Normal',
                                    data: btnTot, //[3895],
                                    borderWidth: 1,

                                }
                            ]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom',

                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    display: 'auto',
                                    formatter: function(value) {
                                        return value.toLocaleString();}
                                    
                                },
                                title: {
                                    display: true,
                                    // text: 'WO Back To Normal',
                                    // align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: true, //if false, this will remove all the x-axis grid lines
                                }
                            }
                        },
                        plugins: [ChartDataLabels],

                    });

                }

            });

            $.ajax({
                url: "{{ route('getAnalisPrecon') }}",
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
                    $("#smWOAnalisPrecon").show();
                },
                complete: () => {
                    $("#smWOAnalisPrecon").hide();
                },
                success: function(apk) {    
                    $('#analisHeadAPK').find("th").remove();
                    $('#analisAPK').find("tr").remove();

                    let blnId;
                    let thnId;
                    let detailCel;
                    let TotPenagihan = [];
                    let TotMonthly = [];
                    let subtotal;
                    let tbPenagihanAPK;
                    let tbCouseCodeAPK;
                    let tbRootCouseAPK;
                    let hdRootCouseAPK = `
                        <th>Instalasi Aging</th>
                        <th>Penagihan</th>
                        <th>Root Couse</th>`;
                        // <th style="text-align: center">Jumlah</th>`;

                    for (h = 0;h < trendWoMt.length; h++) {
                        hdRootCouseAPK = hdRootCouseAPK +
                            `<th colspan="2" style="text-align: center">${trendWoMt[h].bulan.toLocaleString()}</th>`
                    }

                    $('#analisHeadAPK').append(hdRootCouseAPK + `<th colspan="2" style="text-align: center">Subtotal</th></tr>`);


                    $.each(apk.detPenagihanSortir, function(key, itemPenagihan) {

                        tbPenagihanAPK = `
                                <tr class="table-secondary"><th>${itemPenagihan.result}</th>
                                <th class="table-secondary"></th>
                                <th class="table-secondary"></th>`;
                        
                        subtotal=0;
                        for (p=0;p<trendWoMt.length; p++) {
                            TotMonthly[p] = 0

                            blnId = new Date(trendWoMt[p].bulan).getMonth();
                            thnId = new Date(trendWoMt[p].bulan).getFullYear();
                            detailCel = `analisa_precon|result|${itemPenagihan.result}|${(blnId + 1)}|${thnId}`;

                            $.each(apk.detPenagihanSortir, function(key, iPenagihan) {
                                TotMonthly[p] += Number(iPenagihan.bulanan[p]);
                                
                            })

                            tbPenagihanAPK = tbPenagihanAPK +
                                `<th class="table-secondary" style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${itemPenagihan.bulanan[p].toLocaleString()}</th>
                                <th class="table-secondary" style="text-align: center">${((itemPenagihan.bulanan[p] * 100) / TotMonthly[p]).toFixed(1).replace(/\.0$/, '')}%</th>`;

                            subtotal+= Number(itemPenagihan.bulanan[p]);
                        }

                        $('#analisAPK').append(tbPenagihanAPK + `<th class="table-secondary" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);

                        $.each(apk.detCouseCodeSortir, function(key, itemCouseCode) {
                            if (itemPenagihan.result == itemCouseCode.result) {
                                tbCouseCodeAPK = `
                                    <tr><th></th>
                                    <th class="table-info">${itemCouseCode.penagihan}</th>
                                    <th class="table-info"></th>`;
                                
                                subtotal=0;
                                for (cc = 0;cc < trendWoMt.length; cc++) {
                                    TotMonthly[cc] = 0

                                    blnId = new Date(trendWoMt[cc].bulan).getMonth();
                                    thnId = new Date(trendWoMt[cc].bulan).getFullYear();
                                    detailCel = `analisa_precon|penagihan|${itemPenagihan.result}|${itemCouseCode.penagihan}|${(blnId + 1)}|${thnId}`;

                                    $.each(apk.detCouseCodeSortir, function(key, iPenagihan) {
                                        TotMonthly[cc] += Number(iPenagihan.bulanan[cc]);
                                        
                                    })

                                    tbCouseCodeAPK = tbCouseCodeAPK + 
                                        `<th class="table-info" style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${itemCouseCode.bulanan[cc].toLocaleString()}</th>
                                        <th class="table-info" style="text-align: center">${((itemCouseCode.bulanan[cc] * 100) / TotMonthly[cc]).toFixed(1).replace(/\.0$/, '')}%</th>`;

                                    subtotal += Number(itemCouseCode.bulanan[cc]);

                                }

                                $('#analisAPK').append(tbCouseCodeAPK + `<th class="table-info" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);


                                apk.detRootCouseSortir.sort((a,b) => b.bulanan - a.bulanan)

                                $.each(apk.detRootCouseSortir, function(key,
                                    itemRootCouse) {

                                    if (itemPenagihan.result == itemRootCouse
                                        .result && itemCouseCode
                                        .penagihan == itemRootCouse.penagihan
                                    ) {
                                        tbRootCouseAPK = `
                                            <tr><td></td>
                                            <td></td>
                                            <td>${itemRootCouse.root_couse}</td>`;
                                        
                                        subtotal=0;
                                        for (rc = 0; rc < trendWoMt.length; rc++) {

                                            TotMonthly[rc] = 0

                                            blnId = new Date(trendWoMt[rc].bulan).getMonth();
                                            thnId = new Date(trendWoMt[rc].bulan).getFullYear();
                                            detailCel = `analisa_precon|root_couse|${itemPenagihan.result}|${itemCouseCode.penagihan}|${itemRootCouse.root_couse}|${(blnId + 1)}|${thnId}`;

                                            $.each(apk.detRootCouseSortir, function(key, iPenagihan) {
                                                TotMonthly[rc] += Number(iPenagihan.bulanan[rc]);
                                                
                                            })


                                            tbRootCouseAPK = tbRootCouseAPK +
                                            `<td style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${itemRootCouse.bulanan[rc].toLocaleString()}</td>
                                            <td style="text-align: center">${((itemRootCouse.bulanan[rc] * 100) / TotMonthly[rc]).toFixed(1).replace(/\.0$/, '')}%</td>`;

                                            subtotal += Number(itemRootCouse.bulanan[rc]);
                                        }
                                        $('#analisAPK').append(tbRootCouseAPK + `<td style="text-align: center">${subtotal.toLocaleString()}</td></tr>`);
                                    }
                                });
                            }
                        });
                    });

                    

                    let totRootCouseAPK = `
                        <tr><th class="table-dark">TOTAL</th>
                            <th class="table-dark"></th>
                            <th class="table-dark"></th>`;
                            // <th class="table-dark" style="text-align: center">totpenagihan</th></tr>`;
                    
                    subtotal=0;
                    for (p=0;p<trendWoMt.length; p++) {
                        TotPenagihan[p] = 0
                        $.each(apk.detPenagihanSortir, function(key, iPenagihan) {
                            TotPenagihan[p] += Number(iPenagihan.bulanan[p]);
                            
                        })

                        totRootCouseAPK = totRootCouseAPK + `<th class="table-dark" style="text-align: center">${TotPenagihan[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;

                        subtotal+= Number(TotPenagihan[p]);
                    }

                    $('#analisAPK').append(totRootCouseAPK + `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th></tr>`);
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
