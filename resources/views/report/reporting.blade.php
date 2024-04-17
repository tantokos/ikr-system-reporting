@extends('layout.main')

@section('content')
    <div class="row" id="mychart">

        {{-- <div class="row"> --}}

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-sm">
                                <label class="form-text">Bulan Laporan</label>
                                <select class="col form-control-sm" id="bulanReport" name="bulanReport">
                                    <option value="pilihBulan">Pilih Bulan Report</option>
                                    @foreach ($trendMonthly as $bulan)
                                        <option value="{{ $bulan->bulan }}">{{ $bulan->bulan }}</option>
                                    @endforeach
                                    {{-- <option>All</option>
                                    <option>FTTH</option>
                                    <option>FTTX/B</option> --}}
                                </select>
                            </div>

                            <div class="col-sm">
                                <label class="form-text">Periode Tanggal</label>
                                <input class="col form-control-sm" type="text" name="periode"
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

                            <div class="col-sm">
                                <label class="form-text">Branch</label>
                                <select class="col form-control-sm">
                                    <option>All</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->nama_branch }}">{{ $branch->nama_branch }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-sm-2">
                                <label class="form-text">Kotamadya</label>
                                <select class="col form-control-sm">
                                    <option>All</option>
                                    <option>Jakarta Selatan</option>
                                    <option>Jakarta Pusat</option>
                                    <option>Jakarta Utara</option>
                                    <option>Jakarta Timur</option>
                                    <option>Bekasi</option>
                                    <option>Bogor</option>
                                    <option>Tangerang</option>
                                    <option>Medan</option>
                                    <option>Pangkal Pinang</option>
                                    <option>Pontianak</option>
                                    <option>Jambi</option>
                                    <option>Bali</option>
                                </select>
                            </div>

                            {{-- <div class="col-sm">
                                <label class="form-text">WO Type</label>
                                <select class="col form-control-sm">
                                    <option>All</option>
                                    <option>New Installation</option>
                                    <option>Maintenance</option>
                                    <option>Dismantle</option>
                                </select>
                            </div> --}}
                        </div>

                        <div class="row">
                            {{-- <div class="form-group"> --}}
                            <div class="col-sm-2">
                                
                                <button type="submit" class="btn btn-sm btn-success">Filter</button>
                            </div>
                            {{-- </div> --}}
                            
                        </div>

                    </form>
                </div>
            </div>
        </div>



    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Maintenance FTTH - All Branch & Apartement</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="TotWoMt"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="TotWoMtClose"></canvas>
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
                            style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>Total WO</th>
                                    <th style="text-align: center; vertical-align: middle;"></th>
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



        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataCloseWOIb" width="100%"
                            cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>WO Close</th>
                                    <th style="text-align: center; vertical-align: middle;">Januari</th>
                                    <th style="text-align: center; vertical-align: middle;">%</th>
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
                                    <th>Total WO Close</th>
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

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataCloseWOIb" width="100%"
                            cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>WO Maintenance Failed</th>
                                    <th style="text-align: center; vertical-align: middle;">Januari</th>
                                    <th style="text-align: center; vertical-align: middle;">%</th>
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
                                    <th>Total WO Maintenance Failed</th>
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

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataCloseWOIb" width="100%"
                            cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>WO Cancel</th>
                                    <th style="text-align: center; vertical-align: middle;">Januari</th>
                                    <th style="text-align: center; vertical-align: middle;">%</th>
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
                                    <th>Total WO Cancel</th>
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
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Report Maintenance FTTH - All Branch & Apartment</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="TrendTotWoMt" style="align-content: center; align-items: center"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="TrendTotWoMtClose"></canvas>
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

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Closing WO Maintenance FTTH - All Branch & Apartment (Penagihan)</h5>
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
                            cellspacing="0" style="font-size: 12px">
                            <thead id="rootCouseHead">
                                {{-- <tr> --}}
                                {{-- <th>Root Couse</th> --}}
                                {{-- <th style="text-align: center; vertical-align: middle;">1</th> --}}
                                {{-- <th style="text-align: center; vertical-align: middle;">2</th> --}}
                                {{-- </tr> --}}
                            </thead>
                            <tbody id="rootCouseTb">
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
                                <tr id="totRootCouse">
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
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Closing WO Maintenance FTTH - All Branch & Apartment (Aplikasi)</h5>
                </div>
            </div>
        </div>
    </div>


    <div class="row">

        {{-- Root Couse Sortir MT --}}
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered border-primary" style="font-size: 11px; table-layout: fixed;">
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
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Maintenance Failed FTTH - All Branch & Apartment</h5>
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
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Cancel Maintenance FTTH - All Branch & Apartment</h5>
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

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary WO Maintenance Back To Normal</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <canvas id="GraphWoBTN"></canvas>
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
                            style="font-size: 11px; table-layout: fixed;">
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
                            style="font-size: 11px; table-layout: fixed;">
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
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary WO Maintenance FTTH Apartment All Area</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Trend WO Maintenance Apartment All Branch</div>
                <div class="card-body">

                    <canvas id="TrendTotWoMtApart" style="align-content: center; align-items: center"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Trend WO Maintenance Close Apartment All Branch</div>
                <div class="card-body">
                    <canvas id="TrendTotWoMtCloseApart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataTotWOApart"
                            width="100%" cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr id="dateMonthApart">
                                    <th>Maintenance Apartment All Branch</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">1</th> --}}
                                    {{-- <th style="text-align: center; vertical-align: middle;">2</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="woDoneApart">
                                    <td>Done</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">857</td> --}}
                                </tr>
                                <tr id="woPendingApart">
                                    <td>Maintenance Failed</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">545</td> --}}
                                </tr>
                                <tr id="woCancelApart">
                                    <td>Cancel</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">770</td> --}}
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr id="totWoApart">
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

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Closing WO Maintenance Apartment</h5>
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
                            cellspacing="0" style="font-size: 12px; table-layout: fixed">
                            <thead id="rootCouseHeadApart">
                                {{-- <tr> --}}
                                {{-- <th>Root Couse</th> --}}
                                {{-- <th style="text-align: center; vertical-align: middle;">1</th> --}}
                                {{-- <th style="text-align: center; vertical-align: middle;">2</th> --}}
                                {{-- </tr> --}}
                            </thead>
                            <tbody id="rootCouseTbApart">
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
                                <tr id="totRootCouseApart">
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
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Closing WO Maintenance FTTH Apartment (Aplikasi)</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Root Couse Sortir MT --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered border-primary" style="font-size: 11px; table-layout: fixed;">
                            <thead>
                                <tr id="rootCouseHeadAPKApart">
                                    {{-- <th>Root Couse Penagihan (Sortir)</th> --}}
                                    {{-- <th></th> --}}
                                    {{-- <th></th> --}}
                                    {{-- <th style="text-align: center">Jumlah</th> --}}
                                </tr>
                            </thead>
                            <tbody id="bodyRootCouseAPKApart">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Root Couse Sortir MT --}}

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Maintenance Failed FTTH Apartment</h5>
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
                            <thead id="rootCouseHeadPendingApart">
                            </thead>
                            <tbody id="rootCouseTbPendingApart">
                            </tbody>
                            <tfoot>
                                <tr id="totRootCousePendingApart">
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
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Cancel Maintenance FTTH Apartment</h5>
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
                            <thead id="rootCouseHeadCancelApart">
                            </thead>
                            <tbody id="rootCouseTbCancelApart">
                            </tbody>
                            <tfoot>
                                <tr id="totRootCouseCancelApart">
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
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary WO Maintenance FTTH Underground All Area</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Trend WO Maintenance Underground All Branch</div>
                <div class="card-body">

                    <canvas id="TrendTotWoMtUG" style="align-content: center; align-items: center"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Trend WO Maintenance Close Underground All Branch</div>
                <div class="card-body">
                    <canvas id="TrendTotWoMtCloseUG"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataTotWOUG"
                            width="100%" cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr id="dateMonthUG">
                                    <th>Maintenance Underground All Branch</th>
                                    {{-- <th style="text-align: center; vertical-align: middle;">1</th> --}}
                                    {{-- <th style="text-align: center; vertical-align: middle;">2</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="woDoneUG">
                                    <td>Done</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">857</td> --}}
                                </tr>
                                <tr id="woPendingUG">
                                    <td>Maintenance Failed</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">545</td> --}}
                                </tr>
                                <tr id="woCancelUG">
                                    <td>Cancel</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">770</td> --}}
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr id="totWoUG">
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

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Closing WO Maintenance Underground</h5>
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
                            cellspacing="0" style="font-size: 12px; table-layout: fixed">
                            <thead id="rootCouseHeadUG">
                            </thead>
                            <tbody id="rootCouseTbUG">
                            </tbody>
                            <tfoot>
                                <tr id="totRootCouseUG">
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
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Closing WO Maintenance Underground (Aplikasi)</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Root Couse Sortir MT --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered border-primary" style="font-size: 11px; table-layout: fixed;">
                            <thead>
                                <tr id="rootCouseHeadAPKUG">
                                    {{-- <th>Root Couse Penagihan (Sortir)</th> --}}
                                    {{-- <th></th> --}}
                                    {{-- <th></th> --}}
                                    {{-- <th style="text-align: center">Jumlah</th> --}}
                                </tr>
                            </thead>
                            <tbody id="bodyRootCouseAPKUG">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Root Couse Sortir MT --}}

    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Maintenance Failed FTTH Underground</h5>
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
                            <thead id="rootCouseHeadPendingUG">
                            </thead>
                            <tbody id="rootCouseTbPendingUG">
                            </tbody>
                            <tfoot>
                                <tr id="totRootCousePendingUG">
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
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Summary Root Cause Cancel Maintenance FTTH Underground</h5>
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
                            <thead id="rootCouseHeadCancelUG">
                            </thead>
                            <tbody id="rootCouseTbCancelUG">
                            </tbody>
                            <tfoot>
                                <tr id="totRootCouseCancelUG">
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


    {{-- modal Total detail --}}

    <div class="modal fade" id="md-totAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Total Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-totAset">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTotAsetDt" width="100%" cellspacing="0"
                            style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    {{-- <th>Merk Barang</th> --}}
                                    {{-- <th>Kondisi</th> --}}
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Kategori</th>
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
    {{-- end modal total detail --}}

    {{-- modal tersedia detail --}}
    <div class="modal fade" id="md-tersediaAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Aset Tersedia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-tersediaAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                    {{-- <div class="row"> --}}
                    {{-- <div class="col"> --}}
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTersediaAsetDt" width="100%" cellspacing="0"
                            style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    {{-- <th>Merk Barang</th> --}}
                                    {{-- <th>Kondisi</th> --}}
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Kategori</th>
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
    {{-- end modal tersedia detail --}}

    {{-- modal distribusi detail --}}
    <div class="modal fade" id="md-distribusiAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Aset Terdistribusi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-distribusiAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                    {{-- <div class="row"> --}}
                    {{-- <div class="col"> --}}
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataDistribusiAsetDt" width="100%" cellspacing="0"
                            style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    {{-- <th>Merk Barang</th> --}}
                                    {{-- <th>Kondisi</th> --}}
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Kategori</th>
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
    {{-- end modal distribusi detail --}}

    {{-- modal rusak detail --}}

    <div class="modal fade" id="md-rusakAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Aset Rusak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-rusakAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                    {{-- <div class="row"> --}}
                    {{-- <div class="col"> --}}
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataRusakAsetDt" width="100%" cellspacing="0"
                            style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th width="100%">No</th>
                                    <th width="100%">Nama Barang</th>
                                    {{-- <th>Merk Barang</th> --}}
                                    {{-- <th>Kondisi</th> --}}
                                    <th width="100%">Satuan</th>
                                    <th width="100%">Jumlah</th>
                                    <th width="100%">Kategori</th>
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
    {{-- end modal rusak detail --}}

    {{-- modal hilang detail --}}

    <div class="modal fade" id="md-hilangAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Aset Hilang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-hilangAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                    {{-- <div class="row"> --}}
                    {{-- <div class="col"> --}}
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataHilangAsetDt" width="100%" cellspacing="0"
                            style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th width="100%">No</th>
                                    <th width="100%">Nama Barang</th>
                                    {{-- <th>Merk Barang</th> --}}
                                    {{-- <th>Kondisi</th> --}}
                                    <th width="100%">Satuan</th>
                                    <th width="100%">Jumlah</th>
                                    <th width="100%">Kategori</th>
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
    {{-- end modal hilang detail --}}

    {{-- modal disposal detail --}}

    <div class="modal fade" id="md-disposalAset" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="myLargeModalLabel">Detail Disposal Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" id="bdy-disposalAset">
                    {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12"> --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-header">
                
                                </div> --}}

                    {{-- <div class="card-body"> --}}
                    {{-- <div class="row"> --}}
                    {{-- <div class="col"> --}}
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataDisposalAsetDt" width="100%" cellspacing="0"
                            style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th width="100%">No</th>
                                    <th width="100%">Nama Barang</th>
                                    {{-- <th>Merk Barang</th> --}}
                                    {{-- <th>Kondisi</th> --}}
                                    <th width="100%">Satuan</th>
                                    <th width="100%">Jumlah</th>
                                    <th width="100%">Kategori</th>
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
    {{-- end modal disposal detail --}}
@endsection

@section('script')
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/fc-4.3.0/datatables.min.js"></script>


    {{-- <script src="{{ $chart->cdn() }}"></script> --}}

    {{-- {{ $chart->script() }} --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">
        $('input[name="periode"]').daterangepicker();

        // var tableRootCouseAPK = document.getElementById('bodyRootCouseAPK');

        // var trRCPenagihanAPK = tableRootCouseAPK.createElement('tr');
        // trRCPenagihanAPK.attr('id', "rootCousePenagihanAPK");

        // var trCCPenagihanAPK = tableRootCouseAPK.createElement('tr');
        // trCCPenagihanAPK.attr('id', "rootCousePenagihanAPK");

        // var trRCPenagihanAPK = tableRootCouseAPK.createElement('tr');
        // trRCPenagihanAPK.attr('id', "rootCousePenagihanAPK");
    </script>

    <script type="text/javascript">
        $('#bulanReport').on('change', function(e) {

            // console.log($(this).val())

            e.preventDefault();
            let bulanReport = $(this).val();
            let trendWoMt;
            var dataResult;

            $.ajax({
                url: "{{ route('getTotalWoBranch') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(dataTotalWo) {

                    const ctx = document.getElementById('TotWoMt');

                    let graphTotWoMt = Chart.getChart(ctx);
                    if (graphTotWoMt != undefined) {
                        graphTotWoMt.destroy();
                    }

                    var totWoMt = dataTotalWo;

                    var branch = [];
                    var totWo = [];
                    var totWoDone = [];

                    $.each(totWoMt, function(key, item) {

                        branch.push(item.nama_branch);
                        totWo.push(item.total);
                        totWoDone.push(item.done);

                    });


                    chart1 = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: branch, //['Jakarta Timur', 'Jakarta Selatan', 'Bekasi', 'Bogor', 'Tangerang', 'Medan'],
                            datasets: [{
                                label: 'Jumlah WO',
                                data: totWo, //[12, 19, 3, 5, 2, 3],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'right',
                                    align: "start"
                                },
                                title: {
                                    display: true,
                                    text: 'WO Maintenance FTTH ' + bulanReport,
                                    align: 'start',
                                }
                            }
                        }
                    });

                    const ctxMtClose = document.getElementById('TotWoMtClose');

                    var graphTotWoMtClose = Chart.getChart('TotWoMtClose');
                    if (graphTotWoMtClose) {
                        graphTotWoMtClose.destroy();
                    }

                    new Chart(ctxMtClose, {
                        type: 'pie',
                        data: {
                            labels: branch, //['Jakarta Timur', 'Jakarta Selatan', 'Bekasi', 'Bogor', 'Tangerang', 'Medan'],
                            datasets: [{
                                label: 'Jumlah WO',
                                data: totWoDone, //[12, 19, 3, 5, 2, 3],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'right',
                                    align: "start"
                                },
                                title: {
                                    display: true,
                                    text: 'WO Close Maintenance FTTH ' + bulanReport,
                                    align: 'start',
                                }
                            }
                        }
                    });

                    var totWo = 0;
                    var totWoClose = 0;
                    var totWoPending = 0;
                    var totWoCancel = 0;

                    $('#totWoBranch').find("tr").remove();
                    $('#totWoCloseBranch').find("tr").remove();
                    $('#totWoPendingBranch').find("tr").remove();
                    $('#totWoCancelBranch').find("tr").remove();

                    $.each(dataTotalWo, function(key, item) {

                        let tbTotalWo = `
                            <tr>
                                <td>${item.nama_branch}</td>
                                <td style="text-align: center">${item.total.toLocaleString()}</td>
                            </tr>    
                        `;

                        totWo = Number(totWo) + Number(item.total);

                        $('#totWoBranch').append(tbTotalWo);


                        let tbWoClose = `
                            <tr>
                                <td>${item.nama_branch}</td>
                                <td style="text-align: center">${item.done.toLocaleString()}</td>
                                <td style="text-align: center">${item.persenDone.toFixed(1) + "%"}</td>
                            </tr>    
                        `;

                        totWoClose = Number(totWoClose) + Number(item.done);

                        $('#totWoCloseBranch').append(tbWoClose);

                        let tbWoPending = `
                            <tr>
                                <td>${item.nama_branch}</td>
                                <td style="text-align: center">${item.pending.toLocaleString()}</td>
                                <td style="text-align: center">${item.persenPending.toFixed(1) + "%"}</td>
                            </tr>    
                        `;

                        totWoPending = Number(totWoPending) + Number(item.pending);
                        $('#totWoPendingBranch').append(tbWoPending);

                        let tbWoCancel = `
                            <tr>
                                <td>${item.nama_branch}</td>
                                <td style="text-align: center">${item.cancel.toLocaleString()}</td>
                                <td style="text-align: center">${item.persenCancel.toFixed(1) + "%"}</td>
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
                        <th>Total WO Close</th>
                        <th style="text-align: center; vertical-align: middle;">${totWo.toLocaleString()}</th>
                    `;

                    $('#totalWo').append(isiTotalWo);

                    persenTotClose = (Number(totWoClose) * 100) / Number(totWo);

                    let isiTotalWoClose = `
                    <th>Total WO Close</th>
                        <th style="text-align: center; vertical-align: middle;">${totWoClose.toLocaleString()}</th>
                        <th style="text-align: center; vertical-align: middle;">${persenTotClose.toFixed(1) + "%"}</th>
                    `;


                    $('#totWoClose').append(isiTotalWoClose);

                    persenTotPending = (Number(totWoPending) * 100) / Number(totWo);

                    let isiTotalWoPending = `
                    <th>Total WO Maintenance Failed</th>
                        <th style="text-align: center; vertical-align: middle;">${totWoPending.toLocaleString()}</th>
                        <th style="text-align: center; vertical-align: middle;">${persenTotPending.toFixed(1) + "%"}</th>
                    `;
                    $('#totWoPending').append(isiTotalWoPending);

                    persenTotCancel = (totWoCancel * 100) / totWo;

                    let isiTotalWoCancel = `
                    <th>Total WO Cancel</th>
                        <th style="text-align: center; vertical-align: middle;">${totWoCancel.toLocaleString()}</th>
                        <th style="text-align: center; vertical-align: middle;">${persenTotCancel.toFixed(1) + "%"}</th>
                    `;
                    $('#totWoCancel').append(isiTotalWoCancel);




                }


            })

            $.ajax({
                url: "{{ route('getTabelStatus') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport

                },
                success: function(data) {

                    // var day = new Date(tahun, bulan, 0).getDate();
                    var day = [];
                    var daytb;
                    var donetb;
                    var totDone = 0;
                    var totPending = 0;
                    var totCancel = 0;
                    var totWo = 0;
                    var total = 0;

                    $('#dateMonth').find("th").remove();
                    $('#dateMonth').append("<th>Maintenance All Branch</th>")

                    $('#woDone').find("td").remove();
                    $('#woDone').find("th").remove();
                    $('#woDone').append("<td>Done</td>")

                    $('#woPending').find("td").remove();
                    $('#woPending').find("th").remove();
                    $('#woPending').append("<td>Maintenance Failed</td>")

                    $('#woCancel').find("td").remove();
                    $('#woCancel').find("th").remove();
                    $('#woCancel').append("<td>Cancel</td>")

                    $('#totWo').find("td").remove()
                    $('#totWo').find("th").remove()
                    $('#totWo').append("<th>Total Wo</th>")


                    $.each(data, function(key, item) {
                        // day.push(new Date(item.tgl_ikr).getDate());
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

                    $('#woDone').append(`<th>${parseFloat((totDone * 100) / total).toFixed(2)}%</th>`)
                    $('#woPending').append(
                        `<th>${parseFloat((totPending * 100) / total).toFixed(2)}%</th>`)
                    $('#woCancel').append(
                        `<th>${parseFloat((totCancel * 100) / total).toFixed(2)}%</th>`)
                }

            })

            $.ajax({
                url: "{{ route('getTrendMonthly') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport

                },
                success: function(dataTrendMonthly) {
                    // var trendWoMt = {!! $trendMonthly !!}
                    trendWoMt = dataTrendMonthly;

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



                    new Chart(ctxTrendTotWoMt, {
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
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,

                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top'
                                },
                                title: {
                                    display: true,
                                    text: 'Trend WO Maintenance All Branch',
                                    align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: false, //this will remove all the x-axis grid lines
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

                    new Chart(ctxTrendTotWoMtClose, {
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
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,

                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top'
                                },
                                title: {
                                    display: true,
                                    text: 'Trend WO Maintenance Close All Branch',
                                    align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: false, //this will remove all the x-axis grid lines
                                }
                            }
                        },
                        plugins: [ChartDataLabels],

                    });

                }

            })

            $.ajax({
                url: "{{ route('getRootCouseDone') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(dataRootCouse) {

                    $('#rootCouseHead').find("tr").remove();
                    $('#rootCouseTb').find("tr").remove();
                    $('#totRootCouse').find("th").remove();

                    var TotRootDone = 0;
                    let tbRootCouse;
                    let hdRootCouse = `
                        <tr>
                                <th>RootCouse Done</th>
                        </tr>`;

                    $('#rootCouseHead').append(hdRootCouse);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHead').find("tr").append(
                            `<th style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                            )
                    }

                    $.each(dataRootCouse, function(key, item) {

                        if (item.penagihan == 'total_done') {
                            tbRootCouse = `
                            <tr>
                                <th>Total</th>
                                
                            `;
                        } else {
                            tbRootCouse = `
                            <tr>
                                <td>${item.penagihan}</td>
                                
                            `;
                        }

                        if (item.penagihan == 'total_done') {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouse = tbRootCouse +
                                    `<th style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</th>`;
                            }

                        } else {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouse = tbRootCouse +
                                    `<td style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</td>`;

                            }
                        }


                        tbRootCouse = tbRootCouse + `</tr>`;
                        $('#rootCouseTb').append(tbRootCouse);

                    });

                    // $('#totRootCouse').append(tbTotalRootCouse);  
                }

            });

            $.ajax({
                url: "{{ route('getRootCousePending') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(dataRootCousePending) {

                    $('#rootCouseHeadPending').find("tr").remove();
                    $('#rootCouseTbPending').find("tr").remove();
                    $('#totRootCousePending').find("th").remove();

                    var TotRootDonePending = 0;
                    let tbRootCousePending;
                    let hdRootCousePending = `
                        <tr>
                                <th>RootCouse Pending</th>
                        </tr>`;

                    $('#rootCouseHeadPending').append(hdRootCousePending);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHeadPending').find("tr").append(
                            `<th style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                            )
                    }

                    $.each(dataRootCousePending, function(key, item) {

                        if (item.penagihan == 'total_pending') {
                            tbRootCousePending = `
                            <tr>
                                <th>Total</th>
                                
                            `;
                        } else {
                            tbRootCousePending = `
                            <tr>
                                <td>${item.penagihan}</td>
                                
                            `;
                        }

                        if (item.penagihan == 'total_pending') {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCousePending = tbRootCousePending +
                                    `<th style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</th>`;
                            }

                        } else {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCousePending = tbRootCousePending +
                                    `<td style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</td>`;

                            }
                        }

                        tbRootCousePending = tbRootCousePending + `</tr>`;
                        $('#rootCouseTbPending').append(tbRootCousePending);

                    });
                }

            });

            $.ajax({
                url: "{{ route('getRootCouseCancel') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(dataRootCouseCancel) {

                    $('#rootCouseHeadCancel').find("tr").remove();
                    $('#rootCouseTbCancel').find("tr").remove();
                    $('#totRootCouseCancel').find("th").remove();

                    var TotRootDoneCancel = 0;
                    let tbRootCouseCancel;
                    let hdRootCouseCancel = `
                        <tr>
                                <th>RootCouse Cancel</th>
                        </tr>`;

                    $('#rootCouseHeadCancel').append(hdRootCouseCancel);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHeadCancel').find("tr").append(
                            `<th style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                            )
                    }

                    $.each(dataRootCouseCancel, function(key, item) {

                        if (item.penagihan == 'total_cancel') {
                            tbRootCouseCancel = `
                            <tr>
                                <th>Total</th>
                                
                            `;
                        } else {
                            tbRootCouseCancel = `
                            <tr>
                                <td>${item.penagihan}</td>
                                
                            `;
                        }

                        if (item.penagihan == 'total_cancel') {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouseCancel = tbRootCouseCancel +
                                    `<th style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</th>`;
                            }

                        } else {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouseCancel = tbRootCouseCancel +
                                    `<td style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</td>`;

                            }
                        }

                        tbRootCouseCancel = tbRootCouseCancel + `</tr>`;
                        $('#rootCouseTbCancel').append(tbRootCouseCancel);

                    });
                }

            });

            $.ajax({
                url: "{{ route('getRootCouseAPK') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(apk) {

                    $('#rootCouseHeadAPK').find("th").remove();
                    $('#bodyRootCouseAPK').find("tr").remove();
                    $('#penagihanAPK').find("th").remove();
                    $('#couseCodePenagihanAPK').find("th").remove();
                    $('#rootCousePenagihanAPK').find("td").remove();

                    let TotPenagihan = 0;
                    let tbPenagihanAPK;
                    let tbCouseCodeAPK;
                    let tbRootCouseAPK;
                    let hdRootCouseAPK = `
                        <th>RootCouse Aplikasi ${bulanReport}</th>
                        <th></th>
                        <th></th>
                        <th style="text-align: center">Jumlah</th>`;

                    $('#rootCouseHeadAPK').append(hdRootCouseAPK);



                    $.each(apk.detPenagihanSortir, function(key, itemPenagihan) {

                        tbPenagihanAPK = `
                                <tr class="table-secondary"><th>${itemPenagihan.penagihan}</th>
                                <th class="table-secondary"></th>
                                <th class="table-secondary"></th>
                                <th class="table-secondary" style="text-align: center">${itemPenagihan.jml}</th></tr>
                            `;
                        // $('#penagihanAPK').append(tbPenagihanAPK);
                        $('#bodyRootCouseAPK').append(tbPenagihanAPK);

                        TotPenagihan += itemPenagihan.jml;

                        $.each(apk.detCouseCodeSortir, function(key, itemCouseCode) {
                            if (itemPenagihan.penagihan == itemCouseCode.penagihan) {
                                tbCouseCodeAPK = `
                                    <tr><th></th>
                                    <th class="table-info">${itemCouseCode.couse_code}</th>
                                    <th class="table-info"></th>
                                    <th class="table-info" style="text-align: center">${itemCouseCode.jml}</th></tr>
                                `;
                                //         // $('#couseCodePenagihanAPK').append(tbCouseCodeAPK);
                                $('#bodyRootCouseAPK').append(tbCouseCodeAPK);


                                $.each(apk.detRootCouseSortir, function(key,
                                    itemRootCouse) {
                                    if (itemPenagihan.penagihan == itemRootCouse
                                        .penagihan && itemCouseCode
                                        .couse_code == itemRootCouse.couse_code
                                        ) {
                                        tbRootCouseAPK = `
                                            <tr><td></td>
                                            <td></td>
                                            <td>${itemRootCouse.root_couse}</td>
                                            <td style="text-align: center">${itemRootCouse.jml}</td></tr>
                                        `;

                                        //                 $('#rootCousePenagihanAPK').append(tbRootCouseAPK);
                                        $('#bodyRootCouseAPK').append(
                                            tbRootCouseAPK);
                                    }

                                });
                            }


                        });

                    });

                    let totRootCouseAPK = `
                        <tr><th class="table-dark">TOTAL</th>
                            <th class="table-dark"></th>
                            <th class="table-dark"></th>
                            <th class="table-dark" style="text-align: center">${TotPenagihan}</th></tr>`;

                    $('#bodyRootCouseAPK').append(totRootCouseAPK);
                }

            });

            $.ajax({
                url: "{{ route('getCancelSystemProblem') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(btn) {

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
                    $('#PersenBackToNormalHead').append(`<th>Persentase WO Back To Normal</th>`);

                    $('#totWoMT').find("th").remove();
                    $('#totWoMT').find("td").remove();
                    $('#totWoMT').append(`<th>Total WO Maintenance</th>`);

                    $('#totWoBtn').find("th").remove();
                    $('#totWoBtn').find("td").remove();
                    $('#totWoBtn').append(`<th>Total WO Back To Normal</th>`);

                    $('#PersenTotSysProblem').find("th").remove();
                    $('#PersenTotSysProblem').append(`<th class="table-dark">Total</th>`);



                    var TotBtn = 0;
                    let tbBtn;
                    let hdBtn = `
                                <th>WO Back To Normal</th>
                                <th></th>`;

                    $('#backToNormalHead').append(hdBtn);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#backToNormalHead').append(
                            `<th style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                            )
                    }


                    $.each(btn.statVisit, function(key, itemVisit) {
                        tbBtn = tbBtn +
                            `<tr><th class="table-secondary">${itemVisit.visit_novisit}</th>
                            <th class="table-secondary"></th>`;

                        for (bln = 0; bln < trendWoMt.length; bln++) {
                            tbBtn = tbBtn +
                                `<th class="table-secondary" style="text-align: center">${itemVisit.bulan[trendWoMt[bln].bulan]}</th>`;

                        }

                        tbBtn = tbBtn + `</tr>`;

                        $.each(btn.visitSysProblem, function(key, itemSysProblem) {

                            if (itemVisit.visit_novisit == itemSysProblem
                                .visit_novisit) {
                                tbBtn = tbBtn +
                                    `<tr><th></th>
                                            <th class="table-info">${itemSysProblem.action_taken}</th>
                                            `;

                                for (bln = 0; bln < trendWoMt.length; bln++) {
                                    tbBtn = tbBtn +
                                        `<td class="table-info" style="text-align: center">${itemSysProblem.bulan[trendWoMt[bln].bulan].toLocaleString()}</td>`;

                                }
                            }
                        });



                    });

                    $('#bodyBackToNormal').append(tbBtn + `</tr>`);

                    $.each(btn.totSysProblem, function(key, itemTot) {
                        $('#totSysProblem').append(
                            `<th class="table-dark" style="text-align: center">${itemTot.total}</th>
                            `);

                        $('#PersenBackToNormalHead').append(
                            `<th style="text-align: center">${itemTot.bulan}</th>`);

                        $('#totWoMT').append(
                            `<td style="text-align: center">${itemTot.totalMt.toLocaleString()}</td>`
                            );

                        $('#totWoBtn').append(
                            `<td style="text-align: center">${itemTot.total.toLocaleString()}</td>`
                            );

                        $('#PersenTotSysProblem').append(
                            `<th class="table-dark" style="text-align: center">${parseFloat((itemTot.total * 100) / itemTot.totalMt).toFixed(1)}%</th>`
                            );


                        btnMonth.push(itemTot.bulan);
                        btnTotMt.push(itemTot.totalMt);
                        btnTot.push(itemTot.total)

                    });

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
                                    label: 'Total WO MT',
                                    data: btnTotMt, //[3895],
                                    borderWidth: 1,

                                },
                                {
                                    label: 'Total WO Back To Normal',
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
                                    align: 'top'
                                },
                                title: {
                                    display: true,
                                    text: 'WO Back To Normal',
                                    align: 'start',
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
                url: "{{ route('getTrendMonthlyApart') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport

                },
                success: function(dataTrendMonthlyApart) {
                    trendWoMtApart = dataTrendMonthlyApart;

                    var trendMonthApart = [''];
                    var trendTotMtApart = ['null'];
                    var trendMtDoneApart = ['null'];

                    $.each(trendWoMtApart, function(key, item) {

                        trendMonthApart.push(item.bulan);
                        trendTotMtApart.push(item.trendMtTotal);
                        trendMtDoneApart.push(item.trendMtDone);

                    });

                    trendMonthApart.push('');
                    trendTotMtApart.push('null');
                    trendMtDoneApart.push('null');

                    const ctxTrendTotWoMtApart = document.getElementById('TrendTotWoMtApart');

                    var graphTrendTotWoMtApart = Chart.getChart('TrendTotWoMtApart');
                    if (graphTrendTotWoMtApart) {
                        graphTrendTotWoMtApart.destroy();
                    }



                    new Chart(ctxTrendTotWoMtApart, {
                        type: 'line',
                        data: {
                            labels: trendMonthApart, //['Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendTotMtApart, //[3895],
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
                                    align: 'top'
                                },
                                title: {
                                    display: true,
                                    // text: 'Trend WO Maintenance Apartment All Branch',
                                    // align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: false, //this will remove all the x-axis grid lines
                                }
                            }
                        },
                        plugins: [ChartDataLabels],

                    });

                    const ctxTrendTotWoMtCloseApart = document.getElementById('TrendTotWoMtCloseApart');

                    var graphTrendTotWoMtCloseApart = Chart.getChart('TrendTotWoMtCloseApart');
                    if (graphTrendTotWoMtCloseApart) {
                        graphTrendTotWoMtCloseApart.destroy();
                    }

                    new Chart(ctxTrendTotWoMtCloseApart, {
                        type: 'line',
                        data: {
                            labels: trendMonthApart, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendMtDoneApart, //[3082, 3597],
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
                                    align: 'top'
                                },
                                title: {
                                    display: true,
                                    // text: 'Trend WO Maintenance Close Apartment All Branch',
                                    align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: false, //this will remove all the x-axis grid lines
                                }
                            }
                        },
                        plugins: [ChartDataLabels],

                    });

                }

            });

            $.ajax({
                url: "{{ route('getTabelStatusApart') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport

                },
                success: function(dataApart) {

                    // var day = new Date(tahun, bulan, 0).getDate();
                    var dayApart = [];
                    var daytbApart;
                    var donetbApart;
                    var totDoneApart = 0;
                    var totPendingApart = 0;
                    var totCancelApart = 0;
                    var totWoApart = 0;
                    var totalApart = 0;

                    $('#dateMonthApart').find("th").remove();
                    $('#dateMonthApart').append("<th>Maintenance Apartment All Branch</th>")

                    $('#woDoneApart').find("td").remove();
                    $('#woDoneApart').find("th").remove();
                    $('#woDoneApart').append("<td>Done</td>")

                    $('#woPendingApart').find("td").remove();
                    $('#woPendingApart').find("th").remove();
                    $('#woPendingApart').append("<td>Maintenance Failed</td>")

                    $('#woCancelApart').find("td").remove();
                    $('#woCancelApart').find("th").remove();
                    $('#woCancelApart').append("<td>Cancel</td>")

                    $('#totWoApart').find("td").remove()
                    $('#totWoApart').find("th").remove()
                    $('#totWoApart').append("<th>Total Wo</th>")

                    $.each(dataApart, function(key, itemApart) {

                        let htglApart = `
                           <th>${new Date(itemApart.tgl_ikr).getDate()}</th>
                        `;

                        $('#dateMonthApart').append(htglApart);

                        let dtDoneApart = `
                            <td>${itemApart.Done.toLocaleString()}</td>
                        `;

                        $('#woDoneApart').append(dtDoneApart);

                        totDoneApart += itemApart.Done;

                        let dtPendingApart = `
                            <td>${itemApart.Pending.toLocaleString()}</td>
                        `;

                        $('#woPendingApart').append(dtPendingApart);

                        totPendingApart += itemApart.Pending;
                        totCancelApart += itemApart.Cancel;

                        let dtCancelApart = `
                            <td>${itemApart.Cancel.toLocaleString()}</td>
                        `;

                        $('#woCancelApart').append(dtCancelApart)

                        totWoApart = itemApart.Done + itemApart.Pending + itemApart.Cancel

                        let dtTotWoApart = `
                            <td>${totWoApart.toLocaleString()}</td>
                        `;

                        $('#totWoApart').append(dtTotWoApart);


                    });

                    $('#dateMonthApart').append("<th>Total</th>")

                    $('#woDoneApart').append(`<th>${totDoneApart.toLocaleString()}</th>`)

                    $('#woPendingApart').append(`<th>${totPendingApart.toLocaleString()}</th>`)

                    $('#woCancelApart').append(`<th>${totCancelApart.toLocaleString()}</th>`)

                    totalApart = totDoneApart + totPendingApart + totCancelApart

                    $('#totWoApart').append(`<th>${totalApart.toLocaleString()}</th>`)

                    $('#dateMonthApart').append(`<th>%</th>`)

                    $('#woDoneApart').append(
                        `<th>${parseFloat((totDoneApart * 100) / totalApart).toFixed(2)}%</th>`)
                    $('#woPendingApart').append(
                        `<th>${parseFloat((totPendingApart * 100) / totalApart).toFixed(2)}%</th>`)
                    $('#woCancelApart').append(
                        `<th>${parseFloat((totCancelApart * 100) / totalApart).toFixed(2)}%</th>`)
                }

            })

            $.ajax({
                url: "{{ route('getRootCouseDoneApart') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(dataRootCouseApart) {

                    $('#rootCouseHeadApart').find("tr").remove();
                    $('#rootCouseTbApart').find("tr").remove();
                    $('#totRootCouseApart').find("th").remove();

                    var TotRootDoneApart = 0;
                    let tbRootCouseApart;
                    let hdRootCouseApart = `
                        <tr>
                                <th>RootCouse Done</th>
                        </tr>`;

                    $('#rootCouseHeadApart').append(hdRootCouseApart);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHeadApart').find("tr").append(
                            `<th style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                            )
                    }

                    $.each(dataRootCouseApart, function(key, item) {

                        if (item.penagihan == 'total_done') {
                            tbRootCouseApart = `
                            <tr>
                                <th>Total</th>
                                
                            `;
                        } else {
                            tbRootCouseApart = `
                            <tr>
                                <td>${item.penagihan}</td>
                                
                            `;
                        }

                        if (item.penagihan == 'total_done') {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouseApart = tbRootCouseApart +
                                    `<th style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</th>`;
                            }

                        } else {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouseApart = tbRootCouseApart +
                                    `<td style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</td>`;

                            }
                        }

                        tbRootCouseApart = tbRootCouseApart + `</tr>`;
                        $('#rootCouseTbApart').append(tbRootCouseApart);

                    });

                    // $('#totRootCouse').append(tbTotalRootCouse);  
                }

            });

            $.ajax({
                url: "{{ route('getRootCouseAPKApart') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(apkApart) {

                    $('#rootCouseHeadAPKApart').find("th").remove();
                    $('#bodyRootCouseAPKApart').find("tr").remove();
                    $('#penagihanAPKApart').find("th").remove();
                    $('#couseCodePenagihanAPKApart').find("th").remove();
                    $('#rootCousePenagihanAPKApart').find("td").remove();

                    let TotPenagihanApart = 0;
                    let tbPenagihanAPKApart;
                    let tbCouseCodeAPKApart;
                    let tbRootCouseAPKApart;
                    let hdRootCouseAPKApart = `
                        <th>RootCouse Aplikasi ${bulanReport}</th>
                        <th></th>
                        <th></th>
                        <th style="text-align: center">Jumlah</th>`;

                    $('#rootCouseHeadAPKApart').append(hdRootCouseAPKApart);



                    $.each(apkApart.detPenagihanSortirApart, function(key, itemPenagihanApart) {

                        tbPenagihanAPKApart = `
                                <tr class="table-secondary"><th>${itemPenagihanApart.penagihan}</th>
                                <th class="table-secondary"></th>
                                <th class="table-secondary"></th>
                                <th class="table-secondary" style="text-align: center">${itemPenagihanApart.jml}</th></tr>
                            `;
                        // $('#penagihanAPK').append(tbPenagihanAPK);
                        $('#bodyRootCouseAPKApart').append(tbPenagihanAPKApart);

                        TotPenagihanApart += itemPenagihanApart.jml;

                        $.each(apkApart.detCouseCodeSortirApart, function(key,
                            itemCouseCodeApart) {
                            if (itemPenagihanApart.penagihan == itemCouseCodeApart
                                .penagihan) {
                                tbCouseCodeAPKApart = `
                                    <tr><th></th>
                                    <th class="table-info">${itemCouseCodeApart.couse_code}</th>
                                    <th class="table-info"></th>
                                    <th class="table-info" style="text-align: center">${itemCouseCodeApart.jml}</th></tr>
                                `;
                                //         // $('#couseCodePenagihanAPK').append(tbCouseCodeAPK);
                                $('#bodyRootCouseAPKApart').append(tbCouseCodeAPKApart);


                                $.each(apkApart.detRootCouseSortirApart, function(key,
                                    itemRootCouseApart) {
                                    if (itemPenagihanApart.penagihan ==
                                        itemRootCouseApart.penagihan &&
                                        itemCouseCodeApart.couse_code ==
                                        itemRootCouseApart.couse_code) {
                                        tbRootCouseAPKApart = `
                                            <tr><td></td>
                                            <td></td>
                                            <td>${itemRootCouseApart.root_couse}</td>
                                            <td style="text-align: center">${itemRootCouseApart.jml}</td></tr>
                                        `;

                                        //                 $('#rootCousePenagihanAPK').append(tbRootCouseAPK);
                                        $('#bodyRootCouseAPKApart').append(
                                            tbRootCouseAPKApart);
                                    }

                                });
                            }


                        });

                    });

                    let totRootCouseAPKApart = `
                        <tr><th class="table-dark">TOTAL</th>
                            <th class="table-dark"></th>
                            <th class="table-dark"></th>
                            <th class="table-dark" style="text-align: center">${TotPenagihanApart}</th></tr>`;

                    $('#bodyRootCouseAPKApart').append(totRootCouseAPKApart);
                }

            });

            $.ajax({
                url: "{{ route('getRootCousePendingApart') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(dataRootCousePendingApart) {

                    $('#rootCouseHeadPendingApart').find("tr").remove();
                    $('#rootCouseTbPendingApart').find("tr").remove();
                    $('#totRootCousePendingApart').find("th").remove();

                    var TotRootDonePendingApart = 0;
                    let tbRootCousePendingApart;
                    let hdRootCousePendingApart = `
                        <tr>
                                <th>RootCouse Pending</th>
                        </tr>`;

                    $('#rootCouseHeadPendingApart').append(hdRootCousePendingApart);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHeadPendingApart').find("tr").append(
                            `<th style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                            )
                    }

                    $.each(dataRootCousePendingApart, function(key, item) {

                        if (item.penagihan == 'total_pending') {
                            tbRootCousePendingApart = `
                            <tr>
                                <th>Total</th>
                                
                            `;
                        } else {
                            tbRootCousePendingApart = `
                            <tr>
                                <td>${item.penagihan}</td>
                                
                            `;
                        }

                        if (item.penagihan == 'total_pending') {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCousePendingApart = tbRootCousePendingApart +
                                    `<th style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</th>`;
                            }

                        } else {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCousePendingApart = tbRootCousePendingApart +
                                    `<td style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</td>`;

                            }
                        }

                        tbRootCousePendingApart = tbRootCousePendingApart + `</tr>`;
                        $('#rootCouseTbPendingApart').append(tbRootCousePendingApart);

                    });
                }

            });

            $.ajax({
                url: "{{ route('getRootCouseCancelApart') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(dataRootCouseCancelApart) {

                    $('#rootCouseHeadCancelApart').find("tr").remove();
                    $('#rootCouseTbCancelApart').find("tr").remove();
                    $('#totRootCouseCancelApart').find("th").remove();

                    var TotRootDoneCancelApart = 0;
                    let tbRootCouseCancelApart;
                    let hdRootCouseCancelApart = `
                        <tr>
                                <th>RootCouse Cancel</th>
                        </tr>`;

                    $('#rootCouseHeadCancelApart').append(hdRootCouseCancelApart);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHeadCancelApart').find("tr").append(
                            `<th style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                            )
                    }

                    $.each(dataRootCouseCancelApart, function(key, item) {

                        if (item.penagihan == 'total_cancel') {
                            tbRootCouseCancelApart = `
                            <tr>
                                <th>Total</th>
                                
                            `;
                        } else {
                            tbRootCouseCancelApart = `
                            <tr>
                                <td>${item.penagihan}</td>
                                
                            `;
                        }

                        if (item.penagihan == 'total_cancel') {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouseCancelApart = tbRootCouseCancelApart +
                                    `<th style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</th>`;
                            }

                        } else {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouseCancelApart = tbRootCouseCancelApart +
                                    `<td style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</td>`;

                            }
                        }

                        tbRootCouseCancelApart = tbRootCouseCancelApart + `</tr>`;
                        $('#rootCouseTbCancelApart').append(tbRootCouseCancelApart);

                    });
                }

            });

            $.ajax({
                url: "{{ route('getTrendMonthlyUG') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport

                },
                success: function(dataTrendMonthlyUG) {
                    trendWoMtUG = dataTrendMonthlyUG;

                    var trendMonthUG = [''];
                    var trendTotMtUG = ['null'];
                    var trendMtDoneUG = ['null'];

                    $.each(trendWoMtUG, function(key, item) {

                        trendMonthUG.push(item.bulan);
                        trendTotMtUG.push(item.trendMtTotal);
                        trendMtDoneUG.push(item.trendMtDone);

                    });

                    trendMonthUG.push('');
                    trendTotMtUG.push('null');
                    trendMtDoneUG.push('null');

                    const ctxTrendTotWoMtUG = document.getElementById('TrendTotWoMtUG');

                    var graphTrendTotWoMtUG = Chart.getChart('TrendTotWoMtUG');
                    if (graphTrendTotWoMtUG) {
                        graphTrendTotWoMtUG.destroy();
                    }



                    new Chart(ctxTrendTotWoMtUG, {
                        type: 'line',
                        data: {
                            labels: trendMonthUG, //['Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendTotMtUG, //[3895],
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
                                    align: 'top'
                                },
                                title: {
                                    display: true,
                                    // text: 'Trend WO Maintenance Apartment All Branch',
                                    // align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: false, //this will remove all the x-axis grid lines
                                }
                            }
                        },
                        plugins: [ChartDataLabels],

                    });

                    const ctxTrendTotWoMtCloseUG = document.getElementById('TrendTotWoMtCloseUG');

                    var graphTrendTotWoMtCloseUG = Chart.getChart('TrendTotWoMtCloseUG');
                    if (graphTrendTotWoMtCloseUG) {
                        graphTrendTotWoMtCloseUG.destroy();
                    }

                    new Chart(ctxTrendTotWoMtCloseUG, {
                        type: 'line',
                        data: {
                            labels: trendMonthUG, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendMtDoneUG, //[3082, 3597],
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
                                    align: 'top'
                                },
                                title: {
                                    display: true,
                                    // text: 'Trend WO Maintenance Close Apartment All Branch',
                                    align: 'start',
                                },

                            },
                            scales: {
                                y: {
                                    display: false, //this will remove all the x-axis grid lines
                                }
                            }
                        },
                        plugins: [ChartDataLabels],

                    });

                }

            });

            $.ajax({
                url: "{{ route('getTabelStatusUG') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport

                },
                success: function(dataUG) {

                    // var day = new Date(tahun, bulan, 0).getDate();
                    var dayUG = [];
                    var daytbUG;
                    var donetbUG;
                    var totDoneUG = 0;
                    var totPendingUG = 0;
                    var totCancelUG = 0;
                    var totWoUG = 0;
                    var totalUG = 0;

                    $('#dateMonthUG').find("th").remove();
                    $('#dateMonthUG').append("<th>Maintenance Underground All Branch</th>")

                    $('#woDoneUG').find("td").remove();
                    $('#woDoneUG').find("th").remove();
                    $('#woDoneUG').append("<td>Done</td>")

                    $('#woPendingUG').find("td").remove();
                    $('#woPendingUG').find("th").remove();
                    $('#woPendingUG').append("<td>Maintenance Failed</td>")

                    $('#woCancelUG').find("td").remove();
                    $('#woCancelUG').find("th").remove();
                    $('#woCancelUG').append("<td>Cancel</td>")

                    $('#totWoUG').find("td").remove()
                    $('#totWoUG').find("th").remove()
                    $('#totWoUG').append("<th>Total Wo</th>")

                    $.each(dataUG, function(key, itemUG) {

                        let htglUG = `
                           <th>${new Date(itemUG.tgl_ikr).getDate()}</th>
                        `;

                        $('#dateMonthUG').append(htglUG);

                        let dtDoneUG = `
                            <td>${itemUG.Done.toLocaleString()}</td>
                        `;

                        $('#woDoneUG').append(dtDoneUG);

                        totDoneUG += itemUG.Done;

                        let dtPendingUG = `
                            <td>${itemUG.Pending.toLocaleString()}</td>
                        `;

                        $('#woPendingUG').append(dtPendingUG);

                        totPendingUG += itemUG.Pending;
                        totCancelUG += itemUG.Cancel;

                        let dtCancelUG = `
                            <td>${itemUG.Cancel.toLocaleString()}</td>
                        `;

                        $('#woCancelUG').append(dtCancelUG)

                        totWoUG = itemUG.Done + itemUG.Pending + itemUG.Cancel

                        let dtTotWoUG = `
                            <td>${totWoUG.toLocaleString()}</td>
                        `;

                        $('#totWoUG').append(dtTotWoUG);


                    });

                    $('#dateMonthUG').append("<th>Total</th>")

                    $('#woDoneUG').append(`<th>${totDoneUG.toLocaleString()}</th>`)

                    $('#woPendingUG').append(`<th>${totPendingUG.toLocaleString()}</th>`)

                    $('#woCancelUG').append(`<th>${totCancelUG.toLocaleString()}</th>`)

                    totalUG = totDoneUG + totPendingUG + totCancelUG

                    $('#totWoUG').append(`<th>${totalUG.toLocaleString()}</th>`)

                    $('#dateMonthUG').append(`<th>%</th>`)

                    $('#woDoneUG').append(
                        `<th>${parseFloat((totDoneUG * 100) / totalUG).toFixed(2)}%</th>`)
                    $('#woPendingUG').append(
                        `<th>${parseFloat((totPendingUG * 100) / totalUG).toFixed(2)}%</th>`)
                    $('#woCancelUG').append(
                        `<th>${parseFloat((totCancelUG * 100) / totalUG).toFixed(2)}%</th>`)
                }

            })

            $.ajax({
                url: "{{ route('getRootCouseDoneUG') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(dataRootCouseUG) {

                    $('#rootCouseHeadUG').find("tr").remove();
                    $('#rootCouseTbUG').find("tr").remove();
                    $('#totRootCouseUG').find("th").remove();

                    var TotRootDoneUG = 0;
                    let tbRootCouseUG;
                    let hdRootCouseUG = `
                        <tr>
                                <th>RootCouse Done</th>
                        </tr>`;

                    $('#rootCouseHeadUG').append(hdRootCouseUG);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHeadUG').find("tr").append(
                            `<th style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                            )
                    }

                    $.each(dataRootCouseUG, function(key, item) {

                        if (item.penagihan == 'total_done') {
                            tbRootCouseUG = `
                            <tr>
                                <th>Total</th>
                                
                            `;
                        } else {
                            tbRootCouseUG = `
                            <tr>
                                <td>${item.penagihan}</td>
                                
                            `;
                        }

                        if (item.penagihan == 'total_done') {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouseUG = tbRootCouseUG +
                                    `<th style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</th>`;
                            }

                        } else {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouseUG = tbRootCouseUG +
                                    `<td style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</td>`;

                            }
                        }

                        tbRootCouseUG = tbRootCouseUG + `</tr>`;
                        $('#rootCouseTbUG').append(tbRootCouseUG);

                    });

                    // $('#totRootCouse').append(tbTotalRootCouse);  
                }

            });

            $.ajax({
                url: "{{ route('getRootCouseAPKUG') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(apkUG) {

                    $('#rootCouseHeadAPKUG').find("th").remove();
                    $('#bodyRootCouseAPKUG').find("tr").remove();
                    $('#penagihanAPKUG').find("th").remove();
                    $('#couseCodePenagihanAPKUG').find("th").remove();
                    $('#rootCousePenagihanAPKUG').find("td").remove();

                    let TotPenagihanUG = 0;
                    let tbPenagihanAPKUG;
                    let tbCouseCodeAPKUG;
                    let tbRootCouseAPKUG;
                    let hdRootCouseAPKUG = `
                        <th>RootCouse Aplikasi ${bulanReport}</th>
                        <th></th>
                        <th></th>
                        <th style="text-align: center">Jumlah</th>`;

                    $('#rootCouseHeadAPKUG').append(hdRootCouseAPKUG);



                    $.each(apkUG.detPenagihanSortirUG, function(key, itemPenagihanUG) {

                        tbPenagihanAPKUG = `
                                <tr class="table-secondary"><th>${itemPenagihanUG.penagihan}</th>
                                <th class="table-secondary"></th>
                                <th class="table-secondary"></th>
                                <th class="table-secondary" style="text-align: center">${itemPenagihanUG.jml}</th></tr>
                            `;
                        // $('#penagihanAPK').append(tbPenagihanAPK);
                        $('#bodyRootCouseAPKUG').append(tbPenagihanAPKUG);

                        TotPenagihanUG += itemPenagihanUG.jml;

                        $.each(apkUG.detCouseCodeSortirUG, function(key,
                            itemCouseCodeUG) {
                            if (itemPenagihanUG.penagihan == itemCouseCodeUG
                                .penagihan) {
                                tbCouseCodeAPKUG = `
                                    <tr><th></th>
                                    <th class="table-info">${itemCouseCodeUG.couse_code}</th>
                                    <th class="table-info"></th>
                                    <th class="table-info" style="text-align: center">${itemCouseCodeUG.jml}</th></tr>
                                `;
                                //         // $('#couseCodePenagihanAPK').append(tbCouseCodeAPK);
                                $('#bodyRootCouseAPKUG').append(tbCouseCodeAPKUG);


                                $.each(apkUG.detRootCouseSortirUG, function(key,
                                    itemRootCouseUG) {
                                    if (itemPenagihanUG.penagihan ==
                                        itemRootCouseUG.penagihan &&
                                        itemCouseCodeUG.couse_code ==
                                        itemRootCouseUG.couse_code) {
                                        tbRootCouseAPKUG = `
                                            <tr><td></td>
                                            <td></td>
                                            <td>${itemRootCouseUG.root_couse}</td>
                                            <td style="text-align: center">${itemRootCouseUG.jml}</td></tr>
                                        `;

                                        //                 $('#rootCousePenagihanAPK').append(tbRootCouseAPK);
                                        $('#bodyRootCouseAPKUG').append(
                                            tbRootCouseAPKUG);
                                    }

                                });
                            }


                        });

                    });

                    let totRootCouseAPKUG = `
                        <tr><th class="table-dark">TOTAL</th>
                            <th class="table-dark"></th>
                            <th class="table-dark"></th>
                            <th class="table-dark" style="text-align: center">${TotPenagihanUG}</th></tr>`;

                    $('#bodyRootCouseAPKUG').append(totRootCouseAPKUG);
                }

            });

            $.ajax({
                url: "{{ route('getRootCousePendingUG') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(dataRootCousePendingUG) {

                    $('#rootCouseHeadPendingUG').find("tr").remove();
                    $('#rootCouseTbPendingUG').find("tr").remove();
                    $('#totRootCousePendingUG').find("th").remove();

                    var TotRootDonePendingUG = 0;
                    let tbRootCousePendingUG;
                    let hdRootCousePendingUG = `
                        <tr>
                                <th>RootCouse Pending</th>
                        </tr>`;

                    $('#rootCouseHeadPendingUG').append(hdRootCousePendingUG);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHeadPendingUG').find("tr").append(
                            `<th style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                            )
                    }

                    $.each(dataRootCousePendingUG, function(key, item) {

                        if (item.penagihan == 'total_pending') {
                            tbRootCousePendingUG = `
                            <tr>
                                <th>Total</th>
                                
                            `;
                        } else {
                            tbRootCousePendingUG = `
                            <tr>
                                <td>${item.penagihan}</td>
                                
                            `;
                        }

                        if (item.penagihan == 'total_pending') {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCousePendingUG = tbRootCousePendingUG +
                                    `<th style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</th>`;
                            }

                        } else {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCousePendingUG = tbRootCousePendingUG +
                                    `<td style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</td>`;

                            }
                        }

                        tbRootCousePendingUG = tbRootCousePendingUG + `</tr>`;
                        $('#rootCouseTbPendingUG').append(tbRootCousePendingUG);

                    });
                }

            });

            $.ajax({
                url: "{{ route('getRootCouseCancelUG') }}",
                type: "GET",
                data: {
                    bulanTahunReport: bulanReport
                },
                success: function(dataRootCouseCancelUG) {

                    $('#rootCouseHeadCancelUG').find("tr").remove();
                    $('#rootCouseTbCancelUG').find("tr").remove();
                    $('#totRootCouseCancelUG').find("th").remove();

                    var TotRootDoneCancelUG = 0;
                    let tbRootCouseCancelUG;
                    let hdRootCouseCancelUG = `
                        <tr>
                                <th>RootCouse Cancel</th>
                        </tr>`;

                    $('#rootCouseHeadCancelUG').append(hdRootCouseCancelUG);

                    for (b = 0; b < trendWoMt.length; b++) {
                        $('#rootCouseHeadCancelUG').find("tr").append(
                            `<th style="text-align: center">${trendWoMt[b].bulan.toLocaleString()}</th>`
                            )
                    }

                    $.each(dataRootCouseCancelUG, function(key, item) {

                        if (item.penagihan == 'total_cancel') {
                            tbRootCouseCancelUG = `
                            <tr>
                                <th>Total</th>
                                
                            `;
                        } else {
                            tbRootCouseCancelUG = `
                            <tr>
                                <td>${item.penagihan}</td>
                                
                            `;
                        }

                        if (item.penagihan == 'total_cancel') {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouseCancelUG = tbRootCouseCancelUG +
                                    `<th style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</th>`;
                            }

                        } else {
                            for (bln = 0; bln < trendWoMt.length; bln++) {
                                tbRootCouseCancelUG = tbRootCouseCancelUG +
                                    `<td style="text-align: center">${item.bulan[trendWoMt[bln].bulan].toLocaleString()}</td>`;

                            }
                        }

                        tbRootCouseCancelUG = tbRootCouseCancelUG + `</tr>`;
                        $('#rootCouseTbCancelUG').append(tbRootCouseCancelUG);

                    });
                }

            });


        });
    </script>
@endsection
