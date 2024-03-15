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
                                <label class="form-text">Periode</label>
                                <input class="col form-control-sm" type="text" name="periode"
                                    value="01/01/2018 - 01/15/2018" />
                            </div>

                            <div class="col-sm">
                                <label class="form-text">Project</label>
                                <select class="col form-control-sm">
                                    <option>All</option>
                                    <option>FTTH</option>
                                    <option>FTTX/B</option>
                                </select>
                            </div>

                            <div class="col-sm">
                                <label class="form-text">Branch</label>
                                <select class="col form-control-sm">
                                    <option>All</option>
                                    <option>Jakarta Selatan</option>
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

                            <div class="col-sm">
                                <label class="form-text">WO Type</label>
                                <select class="col form-control-sm">
                                    <option>All</option>
                                    <option>New Installation</option>
                                    <option>Maintenance</option>
                                    <option>Dismantle</option>
                                </select>
                            </div>
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
                    <canvas id="TotWoIb"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="TotWoCloseIb"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataTotAsetDt" width="100%"
                            cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>Total WO</th>
                                    <th style="text-align: center; vertical-align: middle;">Januari</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jakarta Timur</td>
                                    <td style="text-align: center; vertical-align: middle;">857</td>
                                </tr>
                                <tr>
                                    <td>Jakarta Selatan</td>
                                    <td style="text-align: center; vertical-align: middle;">545</td>
                                </tr>
                                <tr>
                                    <td>Bekasi</td>
                                    <td style="text-align: center; vertical-align: middle;">770</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total WO</th>
                                    <th style="text-align: center; vertical-align: middle;">3,895</th>
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
                                <tr>
                                    <td>Jakarta Timur</td>
                                    <td style="text-align: center; vertical-align: middle;">857</td>
                                    <td style="text-align: center; vertical-align: middle;">93.2%</td>
                                </tr>
                                <tr>
                                    <td>Jakarta Selatan</td>
                                    <td style="text-align: center; vertical-align: middle;">545</td>
                                    <td style="text-align: center; vertical-align: middle;">80.4%</td>
                                </tr>
                                <tr>
                                    <td>Bekasi</td>
                                    <td style="text-align: center; vertical-align: middle;">770</td>
                                    <td style="text-align: center; vertical-align: middle;">94%</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total WO Close</th>
                                    <th style="text-align: center; vertical-align: middle;">3,597</th>
                                    <th style="text-align: center; vertical-align: middle;">92.3%</th>
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
                                    <th>WO Installation Failed</th>
                                    <th style="text-align: center; vertical-align: middle;">Januari</th>
                                    <th style="text-align: center; vertical-align: middle;">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jakarta Timur</td>
                                    <td style="text-align: center; vertical-align: middle;">857</td>
                                    <td style="text-align: center; vertical-align: middle;">93.2%</td>
                                </tr>
                                <tr>
                                    <td>Jakarta Selatan</td>
                                    <td style="text-align: center; vertical-align: middle;">545</td>
                                    <td style="text-align: center; vertical-align: middle;">80.4%</td>
                                </tr>
                                <tr>
                                    <td>Bekasi</td>
                                    <td style="text-align: center; vertical-align: middle;">770</td>
                                    <td style="text-align: center; vertical-align: middle;">94%</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total WO Installation Failed</th>
                                    <th style="text-align: center; vertical-align: middle;">26</th>
                                    <th style="text-align: center; vertical-align: middle;">0.7%</th>
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
                                <tr>
                                    <td>Jakarta Timur</td>
                                    <td style="text-align: center; vertical-align: middle;">857</td>
                                    <td style="text-align: center; vertical-align: middle;">93.2%</td>
                                </tr>
                                <tr>
                                    <td>Jakarta Selatan</td>
                                    <td style="text-align: center; vertical-align: middle;">545</td>
                                    <td style="text-align: center; vertical-align: middle;">80.4%</td>
                                </tr>
                                <tr>
                                    <td>Bekasi</td>
                                    <td style="text-align: center; vertical-align: middle;">770</td>
                                    <td style="text-align: center; vertical-align: middle;">94%</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total WO Cancel</th>
                                    <th style="text-align: center; vertical-align: middle;">272</th>
                                    <th style="text-align: center; vertical-align: middle;">7%</th>
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
                    <canvas id="TrendTotWoIb"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="TrendTotWoCloseIb"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-secondary" id="dataTotAsetDt" width="100%"
                            cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr id="dateMonth">
                                    <th>Installation All Branch</th>
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
                                <tr>
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

        // const daysInSeptember = getDaysInMonth(2024, 1); // Returns 31

        var day = new Date(2024,1,0).getDate();
        var daytb;
        var donetb;

        for (var dt=1; dt<=day; dt++) {
            daytb = document.createElement('th');
            daytb.append(dt);
            document.getElementById('dateMonth').appendChild(daytb)
            
            donetb = document.createElement('td');
            donetb.append(20);
            document.getElementById('woDone').appendChild(donetb)

            pendingtb = document.createElement('td');
            pendingtb.append(10);
            document.getElementById('woPending').appendChild(pendingtb)

            canceltb = document.createElement('td');
            canceltb.append(1);
            document.getElementById('woCancel').appendChild(canceltb)
        }

            daytb = document.createElement('th');
            daytb.append("Total");
            document.getElementById('dateMonth').appendChild(daytb)   
            
            daytb = document.createElement('th');
            daytb.append("%");
            document.getElementById('dateMonth').appendChild(daytb)

        // $('#dataTotAsetDt').DataTable();
    </script>



    <script>
        const ctx = document.getElementById('TotWoIb');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Jakarta Timur', 'Jakarta Selatan', 'Bekasi', 'Bogor', 'Tangerang', 'Medan'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
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
                        text: 'WO Installation FTTH Januari 2024',
                        align: 'start',
                    }
                }
            }
        });

        const ctxCloseIB = document.getElementById('TotWoCloseIb');

        new Chart(ctxCloseIB, {
            type: 'pie',
            data: {
                labels: ['Jakarta Timur', 'Jakarta Selatan', 'Bekasi', 'Bogor', 'Tangerang', 'Medan'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
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
                        text: 'WO Close Installation FTTH Januari 2024',
                        align: 'start',
                    }
                }
            }
        });

        const ctxTrendTotWoIB = document.getElementById('TrendTotWoIb');

        new Chart(ctxTrendTotWoIB, {
            type: 'line',
            data: {
                labels: ['Dec-23', 'Jan-24'],
                datasets: [{
                    // label: '# of Votes',
                    data: [3291, 3895],
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
                        text: 'Trend WO Installation All Branch',
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

        const ctxTrendTotWoCloseIB = document.getElementById('TrendTotWoCloseIb');

        new Chart(ctxTrendTotWoCloseIB, {
            type: 'line',
            data: {
                labels: ['Dec-23', 'Jan-24'],
                datasets: [{
                    // label: '# of Votes',
                    data: [3082, 3597],
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
                        text: 'Trend WO Installation Close All Branch',
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
