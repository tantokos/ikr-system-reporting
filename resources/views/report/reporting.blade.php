@extends('layout.main')

@section('content')
    <div class="row" id="mychart">

        {{-- <div class="row"> --}}

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-sm">
                                <label class="form-text">Bulan Laporan</label>
                                <select class="col form-control-sm" id="bulanReport" name="bulanReport">
                                    <option value=""></option>
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
                    </form>
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
                        <table class="table table-striped table-bordered border-secondary" id="dataTotAsetDt" style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>Total WO</th>
                                    <th style="text-align: center; vertical-align: middle;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($totWoMtBranch as $totWoRetail)
                                    <tr>
                                        <td>{{ $totWoRetail->nama_branch }}</td>
                                        <td style="text-align: center">{{ number_format($totWoRetail->total) }}</td>
                                    </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total WO</th>
                                    <th style="text-align: center; vertical-align: middle;">
                                        {{ number_format($totWoMtBranch->sum('total')) }}</th>
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
                            <tbody>
                                @foreach ($totWoMtBranch as $totWoMtDone)
                                    <tr>
                                        <td>{{ $totWoMtDone->nama_branch }}</td>
                                        <td style="text-align: center">{{ $totWoMtDone->done }}</td>
                                        <td style="text-align: center">
                                            {{ number_format($totWoMtDone->persenDone, 1) . '%' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total WO Close</th>
                                    <th style="text-align: center; vertical-align: middle;">
                                        {{ number_format($totWoMtBranch->sum('done')) }}</th>
                                    <th style="text-align: center;">
                                        {{ number_format(($totWoMtBranch->sum('done') * 100) / $totWoMtBranch->sum('total'), 1) . '%' }}
                                    </th>
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
                            <tbody>
                                @foreach ($totWoMtBranch as $totWoMtPending)
                                    <tr>
                                        <td>{{ $totWoMtPending->nama_branch }}</td>
                                        <td style="text-align: center">{{ $totWoMtPending->pending }}</td>
                                        <td style="text-align: center">
                                            {{ number_format($totWoMtPending->persenPending, 1) . '%' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total WO Maintenance Failed</th>
                                    <th style="text-align: center; vertical-align: middle;">
                                        {{ number_format($totWoMtBranch->sum('pending')) }}</th>
                                    <th style="text-align: center;">
                                        {{ number_format(($totWoMtBranch->sum('pending') * 100) / $totWoMtBranch->sum('total'), 1) . '%' }}
                                    </th>
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
                            <tbody>
                                @foreach ($totWoMtBranch as $totWoMtCancel)
                                    <tr>
                                        <td>{{ $totWoMtCancel->nama_branch }}</td>
                                        <td style="text-align: center">{{ $totWoMtCancel->cancel }}</td>
                                        <td style="text-align: center">
                                            {{ number_format($totWoMtCancel->persenCancel, 1) . '%' }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total WO Cancel</th>
                                    <th style="text-align: center; vertical-align: middle;">
                                        {{ number_format($totWoMtBranch->sum('cancel')) }}</th>
                                    <th style="text-align: center;">
                                        {{ number_format(($totWoMtBranch->sum('cancel') * 100) / $totWoMtBranch->sum('total'), 1) . '%' }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
                                    <td>Installation Failed</td>
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
    </script>

    <script type="text/javascript">
        $('#bulanReport').on('change', function(e) {

            e.preventDefault();
            let bulanReport = $(this).val();
            var dataResult;
            // console.log(bulanReport);

            $.ajax({
                url: "{{ route('getTabelStatus') }}",
                type: 'GET',
                data: {
                    bulanTahunReport: bulanReport

                },
                success: function(data) {

                    // var day = new Date(tahun, bulan, 0).getDate();
                    console.log(data);
                    var day = [];
                    var daytb;
                    var donetb;
                    var totDone = 0;
                    var totPending = 0;
                    var totCancel = 0;
                    var totWo = 0;
                    var total = 0;

                    $.each(data, function(key, item) {
                        // day.push(new Date(item.tgl_ikr).getDate());

                        daytb = document.createElement('th');
                        daytb.append(new Date(item.tgl_ikr).getDate());
                        document.getElementById('dateMonth').appendChild(daytb)

                        donetb = document.createElement('td');
                        donetb.append(item.Done);
                        document.getElementById('woDone').appendChild(donetb)

                        totDone += item.Done;

                        pendingtb = document.createElement('td');
                        pendingtb.append(item.Pending);
                        document.getElementById('woPending').appendChild(pendingtb)

                        totPending += item.Pending;
                        totCancel += item.Cancel;

                        canceltb = document.createElement('td');
                        canceltb.append(item.Cancel);
                        document.getElementById('woCancel').appendChild(canceltb)

                        totWo = item.Done + item.Pending + item.Cancel

                        tottb = document.createElement('td');
                        tottb.append(totWo.toLocaleString());
                        document.getElementById('totWo').appendChild(tottb)

                    });


                    // var bulanTahun = new Date(document.getElementById('bulanReport').value)
                    // var bulan = bulanTahun.getMonth() + 1;
                    // var tahun = bulanTahun.getFullYear()





                    // for (var dt = 1; dt <= data.length; dt++) {

                    // daytb = document.createElement('th');
                    // daytb.append(dt);
                    // document.getElementById('dateMonth').appendChild(daytb)


                    // donetb = document.createElement('td');
                    // donetb.append(200);
                    // document.getElementById('woDone').appendChild(donetb)

                    // pendingtb = document.createElement('td');
                    // pendingtb.append(10);
                    // document.getElementById('woPending').appendChild(pendingtb)

                    // canceltb = document.createElement('td');
                    // canceltb.append(1);
                    // document.getElementById('woCancel').appendChild(canceltb)
                    // }

                    daytb = document.createElement('th');
                    daytb.append("Total");
                    document.getElementById('dateMonth').appendChild(daytb)

                    donetb = document.createElement('th');
                    donetb.append(totDone.toLocaleString());
                    document.getElementById('woDone').appendChild(donetb)

                    pendingtb = document.createElement('th');
                    pendingtb.append(totPending.toLocaleString());
                    document.getElementById('woPending').appendChild(pendingtb)

                    canceltb = document.createElement('th');
                    canceltb.append(totCancel.toLocaleString());
                    document.getElementById('woCancel').appendChild(canceltb)
                    
                    total = totDone + totPending + totCancel

                    tottb = document.createElement('th');
                    tottb.append(total.toLocaleString());
                    document.getElementById('totWo').appendChild(tottb)

                    
                    daytb = document.createElement('th');
                    daytb.append("%");
                    document.getElementById('dateMonth').appendChild(daytb)
                    

                    donePer = document.createElement('th');
                    donePer.append(parseFloat((totDone*100)/total).toFixed(2)+"%");
                    document.getElementById('woDone').appendChild(donePer)

                    pendingtb = document.createElement('th');
                    pendingtb.append(parseFloat((totPending*100)/total).toFixed(2)+"%");
                    document.getElementById('woPending').appendChild(pendingtb)

                    canceltb = document.createElement('th');
                    canceltb.append(parseFloat((totCancel*100)/total).toFixed(2)+"%");
                    document.getElementById('woCancel').appendChild(canceltb)
                }

            })
            // });



        });
    </script>



    <script>
        const ctx = document.getElementById('TotWoMt');

        var totWoMt = {!! $totWoMtBranch !!}

        // console.log(totWoMt)

        var branch = [];
        var totWo = [];
        var totWoDone = [];


        $.each(totWoMt, function(key, item) {

            branch.push(item.nama_branch);
            totWo.push(item.total);
            totWoDone.push(item.done);



        });

        new Chart(ctx, {
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
                        text: 'WO Maintenance FTTH Januari 2024',
                        align: 'start',
                    }
                }
            }
        });

        const ctxMtClose = document.getElementById('TotWoMtClose');

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
                        text: 'WO Close Maintenance FTTH Januari 2024',
                        align: 'start',
                    }
                }
            }
        });

        var trendWoMt = {!! $trendMonthly !!}

        // console.log(totWoMt)

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
    </script>
@endsection
