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

    {{-- Trend WO New Installation --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Trend WO FTTH New Installation - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen, Underground)<h5></h6>
                    <div class="clearfix" id="smWOIBTrend" style="display: none">
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
                    <h6 class="card-title" id="titleTrendTotWoIB"></h6>
                    <canvas id="TrendTotWoIb" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoCloseIB"></h6>
                    <canvas id="TrendTotWoIbClose"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoPendingIB"></h6>
                    <canvas id="TrendTotWoIbPending" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoCancelIB"></h6>
                    <canvas id="TrendTotWoIbCancel"></canvas>
                </div>
            </div>
        </div>

    </div>

    
    {{-- Trend WO Maintenance --}}
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
                    <h6 class="card-title" id="titleTrendTotWoMT"></h6>
                    <canvas id="TrendTotWoMt" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoCloseMT"></h6>
                    <canvas id="TrendTotWoMtClose"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoPendingMT"></h6>
                    <canvas id="TrendTotWoMtPending" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoCancelMT"></h6>
                    <canvas id="TrendTotWoMtCancel"></canvas>
                </div>
            </div>
        </div>

    </div>

{{-- Trend WO Dismantle --}}
<div class="row">
    <div class="col-sm-12">
        <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
            <div class="card-body">
                <h6>Trend WO Dismantle - <h5 id="CardTitle">All Branch<h5></h6>
                <div class="clearfix" id="smWODisTrend" style="display: none">
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
                <h6 class="card-title" id="titleTrendTotWoDis"></h6>
                <canvas id="TrendTotWoDis" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title" id="titleTrendWoCloseDis"></h6>
                <canvas id="TrendTotWoDisClose"></canvas>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title" id="titleTrendWoPendingDis"></h6>
                <canvas id="TrendTotWoDisPending" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title" id="titleTrendWoCancelDis"></h6>
                <canvas id="TrendTotWoDisCancel"></canvas>
            </div>
        </div>
    </div>

</div>    


    {{-- Trend WO FTTX IB --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h6>Trend WO FTTX New Installation - <h5 id="CardTitle">All Branch<h5></h6>
                    <div class="clearfix" id="smWOFttxIBTrend" style="display: none">
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
                    <h6 class="card-title" id="titleTrendTotWoFttxIB"></h6>
                    <canvas id="TrendTotWoFttxIB" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoCloseFttxIB"></h6>
                    <canvas id="TrendTotWoFttxIBClose"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoPendingFttxIB"></h6>
                    <canvas id="TrendTotWoFttxIBPending" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title" id="titleTrendWoCancelFttxIB"></h6>
                    <canvas id="TrendTotWoFttxIBCancel"></canvas>
                </div>
            </div>
        </div>

    </div>

        {{-- Trend WO FTTX MT --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                    <div class="card-body">
                        <h6>Trend WO FTTX Maintenance - <h5 id="CardTitle">All Branch<h5></h6>
                        <div class="clearfix" id="smWOFttxMTTrend" style="display: none">
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
                        <h6 class="card-title" id="titleTrendTotWoFttxMT"></h6>
                        <canvas id="TrendTotWoFttxMT" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
                    </div>
                </div>
            </div>
    
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title" id="titleTrendWoCloseFttxMT"></h6>
                        <canvas id="TrendTotWoFttxMTClose"></canvas>
                    </div>
                </div>
            </div>
    
        </div>
    
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title" id="titleTrendWoPendingFttxMT"></h6>
                        <canvas id="TrendTotWoFttxMTPending" ></canvas> {{-- style="align-content: center; align-items: center"></canvas> --}}
                    </div>
                </div>
            </div>
    
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title" id="titleTrendWoCancelFttxMT"></h6>
                        <canvas id="TrendTotWoFttxMTCancel"></canvas>
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
                    detailClikChart = detAPK[0]+"|"+detAPK[1]+"|"+detAPK[2]+"|"+detAPK[3]+"|"+detAPK[4];
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
                    detailClikChart = detAPK[0]+"|"+detAPK[1]+"|"+detAPK[2]+"|"+detAPK[3]+"|"+detAPK[4]+"|"+detAPK[5];
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
                    detailClikChart = detAPK[0]+"|"+detAPK[1]+"|"+detAPK[2]+"|"+detAPK[3]+"|"+detAPK[4]+"|"+detAPK[5]+"|"+detAPK[6];
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
                                            detailAPKCluster(dataDetail);
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
                            {
                                "data": 'type_wo',
                                "width": '90'
                            },
                            {
                                data: 'no_wo',
                                width: '90'
                            },
                            {
                                data: 'cust_id',
                                width: '90'
                            },
                            {
                                data: 'nama_cust',
                                width: '90'
                            },
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
                        ]
                    });


            }
        }

        // Click Branch show Cluster
        function detailAPKCluster(dataDetail) {

            // console.log(dataDetail);

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
                    detailSubTitleCluster = detAPKCluster[3];
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
                    detailSubTitleCluster = detAPKCluster[3] + " - " + detAPKCluster[4];
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
                    detailSubTitleCluster = detAPKCluster[3] + " - " + detAPKCluster[4] + " - " + detAPKCluster[5];
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
                    detailSubTitleCluster = detAPKCluster[3];
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
                    detailSubTitleCluster = detAPKCluster[3];
                }

                bulanData = months[datafilterCluster.detBulan - 1] + "-" + datafilterCluster.detThn;
            }

            //analisa precon
            if(detAPKCluster[1]=="analisa_precon" ) {
                if(detAPKCluster[2]=="result") {
                    datafilterCluster = {

                            detBranch: detAPKCluster[0],
                            detSlide: detAPKCluster[1],
                            detKategori: detAPKCluster[2], 
                            detResult: detAPKCluster[3],
                            // detPenagihan: detAPKCluster[3],
                            detBulan: detAPKCluster[4],
                            detThn: detAPKCluster[5],
                            detSite: filSite,
                            // detBranch: filBranch,
                            _token: _token
                    };

                    detailTitleCluster = detAPKCluster[0];
                    detailSubTitleCluster = detAPKCluster[3];
                }

                if(detAPKCluster[2]=="penagihan") {
                    datafilterCluster = {
                            detBranch: detAPKCluster[0],
                            detSlide: detAPKCluster[1],
                            detKategori: detAPKCluster[2], 
                            detResult: detAPKCluster[3],
                            detPenagihan: detAPKCluster[4],
                            // detCouse_code: detAPKCluster[4],
                            detBulan: detAPKCluster[5],
                            detThn: detAPKCluster[6],
                            detSite: filSite,
                            // detBranch: filBranch,
                            _token: _token
                    };

                    detailTitleCluster = detAPKCluster[0];
                    detailSubTitleCluster = detAPKCluster[3] + " - " + detAPKCluster[4];
                }

                if(detAPKCluster[2]=="root_couse") {
                    datafilterCluster = {
                            detBranch: detAPKCluster[0],
                            detSlide: detAPKCluster[1],
                            detKategori: detAPKCluster[2], 
                            detResult: detAPKCluster[3],
                            detPenagihan: detAPKCluster[4],
                            // detCouse_code: detAPKCluster[4],
                            detRoot_couse: detAPKCluster[5],
                            detBulan: detAPKCluster[6],
                            detThn: detAPKCluster[7],
                            detSite: filSite,
                            // detBranch: filBranch,
                            _token: _token
                    };

                    detailTitleCluster = detAPKCluster[0];
                    detailSubTitleCluster = detAPKCluster[3] + " - " + detAPKCluster[4] + " - " + detAPKCluster[5];
                }

                bulanData = months[datafilterCluster.detBulan - 1] + "-" + datafilterCluster.detThn;
            }


            $('#md-detailAPKCluster').modal('show');
            $('#canvasDetailAPKCluster').empty();

            $.ajax({
                url: "{{ route('getDetailAPKCluster') }}",
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
        

        $('#filterDashBoard').on('click', function(e) {

            // console.log($('#periode').data('daterangepicker').startDate.format("YYYY-MM-DD"))
            // console.log($('#periode').data('daterangepicker').endDate.format("YYYY-MM-DD"))
            
            
            e.preventDefault();
            if($('#bulanReport').val() === ""){
                alert('Pilih Bulan Report');
                return;
            }

            var bulanReport = $('#bulanReport').val();

            // console.log(moment([new Date(bulanReport).getFullYear(), new Date(bulanReport).getMonth()]).format("DD-MM-YYYY"));
            let trendWoMtGet;
            let trendWoIbGet;
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
                    trendWoMtGet = dataTrendMonthly;

                }

            })

            
            //**Script get data trend wo IB**//
            $.ajax({
                url: "{{ route('getTrendMonthlyIB') }}",
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
                    $("#smWOIBTrend").show();
                },
                complete: () => {
                    $("#smWOIBTrend").hide();
                },
                success: function(dataTrendMonthlyIB) {
                    // var trendWoMt = {!! $trendMonthly !!}
                    trendWoIb = dataTrendMonthlyIB;

                    document.querySelectorAll('#titleTrendTotWoIB').forEach(function(elem){
                        elem.innerText = 'Trend Total WO FTTH New Installation ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoCloseIB').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH New Installation Done ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoPendingIB').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH New Installation Pending ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoCancelIB').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH New Installation Cancel ' + titleBranch + " - " + bulanReport; 
                    })

                    var trendMonth = [''];
                    var trendTotIb = ['null'];
                    var trendIbDone = ['null'];
                    var trendIbPending = ['null'];
                    var trendIbCancel = ['null'];

                    $.each(trendWoIb, function(key, item) {

                        trendMonth.push(item.bulan);
                        trendTotIb.push(item.trendIbTotal);
                        trendIbDone.push(item.trendIbDone);
                        trendIbPending.push(item.trendIbPending);
                        trendIbCancel.push(item.trendIbCancel);

                    });

                    trendMonth.push('');
                    trendTotIb.push('null');
                    trendIbDone.push('null');
                    trendIbPending.push('null');
                    trendIbCancel.push('null');


                    //**Canvas line graph tot WO IB**//
                    const ctxTrendTotWoIb = document.getElementById('TrendTotWoIb');

                    var graphTrendTotWoIb = Chart.getChart('TrendTotWoIb');
                    if (graphTrendTotWoIb) {
                        graphTrendTotWoIb.destroy();
                    }


                    var ChartTrendTotWoIb = new Chart(ctxTrendTotWoIb, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendTotIb, //[3895],
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


                    //**Canvas line graph tot WO IB Done**//
                    const ctxTrendTotWoIbClose = document.getElementById('TrendTotWoIbClose');

                    var graphTrendTotWoIbClose = Chart.getChart('TrendTotWoIbClose');
                    if (graphTrendTotWoIbClose) {
                        graphTrendTotWoIbClose.destroy();
                    }



                    var ChartTrendTotWoIbClose = new Chart(ctxTrendTotWoIbClose, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendIbDone, //[3082, 3597],
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

                    //**Canvas line graph tot WO IB Pending**//
                    const ctxTrendTotWoIbPending = document.getElementById('TrendTotWoIbPending');

                    var graphTrendTotWoIbPending = Chart.getChart('TrendTotWoIbPending');
                    if (graphTrendTotWoIbPending) {
                        graphTrendTotWoIbPending.destroy();
                    }


                    var ChartTrendTotWoIbPending = new Chart(ctxTrendTotWoIbPending, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendIbPending, //[3082, 3597],
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

                    //**Canvas line graph tot WO MT Cancel**//
                    const ctxTrendTotWoIbCancel = document.getElementById('TrendTotWoIbCancel');

                    var graphTrendTotWoIbCancel = Chart.getChart('TrendTotWoIbCancel');
                    if (graphTrendTotWoIbCancel) {
                        graphTrendTotWoIbCancel.destroy();
                    }



                    var ChartTrendTotWoIbCancel = new Chart(ctxTrendTotWoIbCancel, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendIbCancel, //[3082, 3597],
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

                    var maxChartTot = ChartTrendTotWoIb.scales.y.max;
                    var minChartTotClose = ChartTrendTotWoIbClose.scales.y.min;
                    var minChartTotPending = ChartTrendTotWoIbPending.scales.y.min;
                    var minChartTotCancel = ChartTrendTotWoIbCancel.scales.y.min;
                    ChartTrendTotWoIbClose.options.scales.y.max = ChartTrendTotWoIb.scales.y.max;
                    ChartTrendTotWoIbPending.options.scales.y.max = ChartTrendTotWoIb.scales.y.max;
                    ChartTrendTotWoIbCancel.options.scales.y.max = ChartTrendTotWoIb.scales.y.max;
                    ChartTrendTotWoIb.options.scales.y.min= minChartTotClose;

                    ChartTrendTotWoIbClose.update();
                    ChartTrendTotWoIbPending.update();
                    ChartTrendTotWoIbCancel.update();
                    ChartTrendTotWoIb.update();

                }

            })

            //**Script get data trend wo MT**//
            $.ajax({
                url: "{{ route('getTrendMonthlyMT') }}",
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

                    document.querySelectorAll('#titleTrendTotWoMT').forEach(function(elem){
                        elem.innerText = 'Trend Total WO FTTH Maintenance ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoCloseMT').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH Maintenance Done ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoPendingMT').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH Maintenance Pending ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoCancelMT').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH Maintenance Cancel ' + titleBranch + " - " + bulanReport; 
                    })

                    var trendMonth = [''];
                    var trendTotMt = ['null'];
                    var trendMtDone = ['null'];
                    var trendMtPending = ['null'];
                    var trendMtCancel = ['null'];

                    $.each(trendWoMt, function(key, item) {

                        trendMonth.push(item.bulan);
                        trendTotMt.push(item.trendMtTotal);
                        trendMtDone.push(item.trendMtDone);
                        trendMtPending.push(item.trendMtPending);
                        trendMtCancel.push(item.trendMtCancel);

                    });

                    trendMonth.push('');
                    trendTotMt.push('null');
                    trendMtDone.push('null');
                    trendMtPending.push('null');
                    trendMtCancel.push('null');


                    //**Canvas line graph tot WO MT**//
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


                    //**Canvas line graph tot WO MT Done**//
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

                    //**Canvas line graph tot WO MT Pending**//
                    const ctxTrendTotWoMtPending = document.getElementById('TrendTotWoMtPending');

                    var graphTrendTotWoMtPending = Chart.getChart('TrendTotWoMtPending');
                    if (graphTrendTotWoMtPending) {
                        graphTrendTotWoMtPending.destroy();
                    }



                    var ChartTrendTotWoMTPending = new Chart(ctxTrendTotWoMtPending, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendMtPending, //[3082, 3597],
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

                    //**Canvas line graph tot WO MT Cancel**//
                    const ctxTrendTotWoMtCancel = document.getElementById('TrendTotWoMtCancel');

                    var graphTrendTotWoMtCancel = Chart.getChart('TrendTotWoMtCancel');
                    if (graphTrendTotWoMtCancel) {
                        graphTrendTotWoMtCancel.destroy();
                    }



                    var ChartTrendTotWoMTCancel = new Chart(ctxTrendTotWoMtCancel, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendMtCancel, //[3082, 3597],
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
                    var minChartTotPending = ChartTrendTotWoMTPending.scales.y.min;
                    var minChartTotCancel = ChartTrendTotWoMTCancel.scales.y.min;
                    ChartTrendTotWoMTClose.options.scales.y.max = ChartTrendTotWoMT.scales.y.max;
                    ChartTrendTotWoMTPending.options.scales.y.max = ChartTrendTotWoMT.scales.y.max;
                    ChartTrendTotWoMTCancel.options.scales.y.max = ChartTrendTotWoMT.scales.y.max;
                    ChartTrendTotWoMT.options.scales.y.min= minChartTotClose;

                    ChartTrendTotWoMTClose.update();
                    ChartTrendTotWoMTPending.update();
                    ChartTrendTotWoMTCancel.update();
                    ChartTrendTotWoMT.update();

                }

            })

            //**Script get data trend wo Dismantle**//
            $.ajax({
                url: "{{ route('getTrendMonthlyDismantle') }}",
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
                    $("#smWODisTrend").show();
                },
                complete: () => {
                    $("#smWODisTrend").hide();
                },
                success: function(dataTrendMonthlyDis) {
                    // var trendWoMt = {!! $trendMonthly !!}
                    trendWoDis = dataTrendMonthlyDis;

                    document.querySelectorAll('#titleTrendTotWoDis').forEach(function(elem){
                        elem.innerText = 'Trend Total WO Dismantle ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoCloseDis').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH Dismantle Done ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoPendingDis').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH Dismantle Pending ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoCancelDis').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTH Dismantle Cancel ' + titleBranch + " - " + bulanReport; 
                    })

                    var trendMonth = [''];
                    var trendTotDis = ['null'];
                    var trendDisDone = ['null'];
                    var trendDisPending = ['null'];
                    var trendDisCancel = ['null'];

                    $.each(trendWoDis, function(key, item) {

                        trendMonth.push(item.bulan);
                        trendTotDis.push(item.trendDisTotal);
                        trendDisDone.push(item.trendDisDone);
                        trendDisPending.push(item.trendDisPending);
                        trendDisCancel.push(item.trendDisCancel);

                    });

                    trendMonth.push('');
                    trendTotDis.push('null');
                    trendDisDone.push('null');
                    trendDisPending.push('null');
                    trendDisCancel.push('null');


                    //**Canvas line graph tot WO IB**//
                    const ctxTrendTotWoDis = document.getElementById('TrendTotWoDis');

                    var graphTrendTotWoDis = Chart.getChart('TrendTotWoDis');
                    if (graphTrendTotWoDis) {
                        graphTrendTotWoDis.destroy();
                    }


                    var ChartTrendTotWoDis = new Chart(ctxTrendTotWoDis, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendTotDis, //[3895],
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


                    //**Canvas line graph tot WO IB Done**//
                    const ctxTrendTotWoDisClose = document.getElementById('TrendTotWoDisClose');

                    var graphTrendTotWoDisClose = Chart.getChart('TrendTotWoDisClose');
                    if (graphTrendTotWoDisClose) {
                        graphTrendTotWoDisClose.destroy();
                    }



                    var ChartTrendTotWoDisClose = new Chart(ctxTrendTotWoDisClose, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendDisDone, //[3082, 3597],
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

                    //**Canvas line graph tot WO IB Pending**//
                    const ctxTrendTotWoDisPending = document.getElementById('TrendTotWoDisPending');

                    var graphTrendTotWoDisPending = Chart.getChart('TrendTotWoDisPending');
                    if (graphTrendTotWoDisPending) {
                        graphTrendTotWoDisPending.destroy();
                    }


                    var ChartTrendTotWoDisPending = new Chart(ctxTrendTotWoDisPending, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendDisPending, //[3082, 3597],
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

                    //**Canvas line graph tot WO MT Cancel**//
                    const ctxTrendTotWoDisCancel = document.getElementById('TrendTotWoDisCancel');

                    var graphTrendTotWoDisCancel = Chart.getChart('TrendTotWoDisCancel');
                    if (graphTrendTotWoDisCancel) {
                        graphTrendTotWoDisCancel.destroy();
                    }



                    var ChartTrendTotWoDisCancel = new Chart(ctxTrendTotWoDisCancel, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendDisCancel, //[3082, 3597],
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

                    var maxChartTot = ChartTrendTotWoDis.scales.y.max;
                    var minChartTotClose = ChartTrendTotWoDisClose.scales.y.min;
                    var minChartTotPending = ChartTrendTotWoDisPending.scales.y.min;
                    var minChartTotCancel = ChartTrendTotWoDisCancel.scales.y.min;
                    ChartTrendTotWoDisClose.options.scales.y.max = ChartTrendTotWoDis.scales.y.max;
                    ChartTrendTotWoDisPending.options.scales.y.max = ChartTrendTotWoDis.scales.y.max;
                    ChartTrendTotWoDisCancel.options.scales.y.max = ChartTrendTotWoDis.scales.y.max;
                    ChartTrendTotWoDis.options.scales.y.min= minChartTotClose;

                    ChartTrendTotWoDisClose.update();
                    ChartTrendTotWoDisPending.update();
                    ChartTrendTotWoDisCancel.update();
                    ChartTrendTotWoDis.update();

                }

            })

            //**Script get data trend wo Fttx IB**//
            $.ajax({
                url: "{{ route('getTrendMonthlyFttxIB') }}",
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
                    $("#smWOFttxIBTrend").show();
                },
                complete: () => {
                    $("#smWOFttxIBTrend").hide();
                },
                success: function(dataTrendMonthlyFttxIB) {
                    // var trendWoMt = {!! $trendMonthly !!}
                    trendWoFttxIB = dataTrendMonthlyFttxIB;

                    document.querySelectorAll('#titleTrendTotWoFttxIB').forEach(function(elem){
                        elem.innerText = 'Trend Total WO FTTX New Installation ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoCloseFttxIB').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTX New Installation Done ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoPendingFttxIB').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTX New Installation Pending ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoCancelFttxIB').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTX New Installation Cancel ' + titleBranch + " - " + bulanReport; 
                    })

                    var trendMonth = [''];
                    var trendTotFttxIB = ['null'];
                    var trendFttxIBDone = ['null'];
                    var trendFttxIBPending = ['null'];
                    var trendFttxIBCancel = ['null'];

                    $.each(trendWoFttxIB, function(key, item) {

                        trendMonth.push(item.bulan);
                        trendTotFttxIB.push(item.trendFttxIBTotal);
                        trendFttxIBDone.push(item.trendFttxIBDone);
                        trendFttxIBPending.push(item.trendFttxIBPending);
                        trendFttxIBCancel.push(item.trendFttxIBCancel);

                    });

                    trendMonth.push('');
                    trendTotFttxIB.push('null');
                    trendFttxIBDone.push('null');
                    trendFttxIBPending.push('null');
                    trendFttxIBCancel.push('null');


                    //**Canvas line graph tot WO IB**//
                    const ctxTrendTotWoFttxIB = document.getElementById('TrendTotWoFttxIB');

                    var graphTrendTotWoFttxIB = Chart.getChart('TrendTotWoFttxIB');
                    if (graphTrendTotWoFttxIB) {
                        graphTrendTotWoFttxIB.destroy();
                    }


                    var ChartTrendTotWoFttxIB = new Chart(ctxTrendTotWoFttxIB, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendTotFttxIB, //[3895],
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


                    //**Canvas line graph tot WO IB Done**//
                    const ctxTrendTotWoFttxIBClose = document.getElementById('TrendTotWoFttxIBClose');

                    var graphTrendTotWoFttxIBClose = Chart.getChart('TrendTotWoFttxIBClose');
                    if (graphTrendTotWoFttxIBClose) {
                        graphTrendTotWoFttxIBClose.destroy();
                    }



                    var ChartTrendTotWoFttxIBClose = new Chart(ctxTrendTotWoFttxIBClose, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendFttxIBDone, //[3082, 3597],
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

                    //**Canvas line graph tot WO FttxIBPending**//
                    const ctxTrendTotWoFttxIBPending = document.getElementById('TrendTotWoFttxIBPending');

                    var graphTrendTotWoFttxIBPending = Chart.getChart('TrendTotWoFttxIBPending');
                    if (graphTrendTotWoFttxIBPending) {
                        graphTrendTotWoFttxIBPending.destroy();
                    }


                    var ChartTrendTotWoFttxIBPending = new Chart(ctxTrendTotWoFttxIBPending, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendFttxIBPending, //[3082, 3597],
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

                    //**Canvas line graph tot WO MT Cancel**//
                    const ctxTrendTotWoFttxIBCancel = document.getElementById('TrendTotWoFttxIBCancel');

                    var graphTrendTotWoFttxIBCancel = Chart.getChart('TrendTotWoFttxIBCancel');
                    if (graphTrendTotWoFttxIBCancel) {
                        graphTrendTotWoFttxIBCancel.destroy();
                    }



                    var ChartTrendTotWoFttxIBCancel = new Chart(ctxTrendTotWoFttxIBCancel, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendFttxIBCancel, //[3082, 3597],
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

                    var maxChartTot = ChartTrendTotWoFttxIB.scales.y.max;
                    var minChartTotClose = ChartTrendTotWoFttxIBClose.scales.y.min;
                    var minChartTotPending = ChartTrendTotWoFttxIBPending.scales.y.min;
                    var minChartTotCancel = ChartTrendTotWoFttxIBCancel.scales.y.min;
                    ChartTrendTotWoFttxIBClose.options.scales.y.max = ChartTrendTotWoFttxIB.scales.y.max;
                    ChartTrendTotWoFttxIBPending.options.scales.y.max = ChartTrendTotWoFttxIB.scales.y.max;
                    ChartTrendTotWoFttxIBCancel.options.scales.y.max = ChartTrendTotWoFttxIB.scales.y.max;
                    ChartTrendTotWoFttxIB.options.scales.y.min= minChartTotClose;

                    ChartTrendTotWoFttxIBClose.update();
                    ChartTrendTotWoFttxIBPending.update();
                    ChartTrendTotWoFttxIBCancel.update();
                    ChartTrendTotWoFttxIB.update();

                }

            })

            //**Script get data trend wo Fttx MT**//
            $.ajax({
                url: "{{ route('getTrendMonthlyFttxMT') }}",
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
                    $("#smWOFttxMTTrend").show();
                },
                complete: () => {
                    $("#smWOFttxMTTrend").hide();
                },
                success: function(dataTrendMonthlyFttxMT) {
                    // var trendWoMt = {!! $trendMonthly !!}
                    trendWoFttxMT = dataTrendMonthlyFttxMT;

                    document.querySelectorAll('#titleTrendTotWoFttxMT').forEach(function(elem){
                        elem.innerText = 'Trend Total WO FTTX Maintenance ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoCloseFttxMT').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTX Maintenance Done ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoPendingFttxMT').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTX Maintenance Pending ' + titleBranch + " - " + bulanReport; 
                    })

                    document.querySelectorAll('#titleTrendWoCancelFttxMT').forEach(function(elem){
                        elem.innerText = 'Trend WO FTTX Maintenance Cancel ' + titleBranch + " - " + bulanReport; 
                    })

                    var trendMonth = [''];
                    var trendTotFttxMT = ['null'];
                    var trendFttxMTDone = ['null'];
                    var trendFttxMTPending = ['null'];
                    var trendFttxMTCancel = ['null'];

                    $.each(trendWoFttxMT, function(key, item) {

                        trendMonth.push(item.bulan);
                        trendTotFttxMT.push(item.trendFttxMTTotal);
                        trendFttxMTDone.push(item.trendFttxMTDone);
                        trendFttxMTPending.push(item.trendFttxMTPending);
                        trendFttxMTCancel.push(item.trendFttxMTCancel);

                    });

                    trendMonth.push('');
                    trendTotFttxMT.push('null');
                    trendFttxMTDone.push('null');
                    trendFttxMTPending.push('null');
                    trendFttxMTCancel.push('null');


                    //**Canvas line graph tot WO FTTX MT**//
                    const ctxTrendTotWoFttxMT = document.getElementById('TrendTotWoFttxMT');

                    var graphTrendTotWoFttxMT = Chart.getChart('TrendTotWoFttxMT');
                    if (graphTrendTotWoFttxMT) {
                        graphTrendTotWoFttxMT.destroy();
                    }


                    var ChartTrendTotWoFttxMT = new Chart(ctxTrendTotWoFttxMT, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendTotFttxMT, //[3895],
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


                    //**Canvas line graph tot WO fttx mt Done**//
                    const ctxTrendTotWoFttxMTClose = document.getElementById('TrendTotWoFttxMTClose');

                    var graphTrendTotWoFttxMTClose = Chart.getChart('TrendTotWoFttxMTClose');
                    if (graphTrendTotWoFttxMTClose) {
                        graphTrendTotWoFttxMTClose.destroy();
                    }



                    var ChartTrendTotWoFttxMTClose = new Chart(ctxTrendTotWoFttxMTClose, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendFttxMTDone, //[3082, 3597],
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

                    //**Canvas line graph tot WO FttxIBPending**//
                    const ctxTrendTotWoFttxMTPending = document.getElementById('TrendTotWoFttxMTPending');

                    var graphTrendTotWoFttxMTPending = Chart.getChart('TrendTotWoFttxMTPending');
                    if (graphTrendTotWoFttxMTPending) {
                        graphTrendTotWoFttxMTPending.destroy();
                    }


                    var ChartTrendTotWoFttxMTPending = new Chart(ctxTrendTotWoFttxMTPending, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendFttxMTPending, //[3082, 3597],
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

                    //**Canvas line graph tot WO MT Cancel**//
                    const ctxTrendTotWoFttxMTCancel = document.getElementById('TrendTotWoFttxMTCancel');

                    var graphTrendTotWoFttxMTCancel = Chart.getChart('TrendTotWoFttxMTCancel');
                    if (graphTrendTotWoFttxMTCancel) {
                        graphTrendTotWoFttxMTCancel.destroy();
                    }



                    var ChartTrendTotWoFttxMTCancel = new Chart(ctxTrendTotWoFttxMTCancel, {
                        type: 'line',
                        data: {
                            labels: trendMonth, //['Dec-23', 'Jan-24'],
                            datasets: [{
                                // label: '# of Votes',
                                data: trendFttxMTCancel, //[3082, 3597],
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

                    var maxChartTot = ChartTrendTotWoFttxMT.scales.y.max;
                    var minChartTotClose = ChartTrendTotWoFttxMTClose.scales.y.min;
                    var minChartTotPending = ChartTrendTotWoFttxMTPending.scales.y.min;
                    var minChartTotCancel = ChartTrendTotWoFttxMTCancel.scales.y.min;
                    ChartTrendTotWoFttxMTClose.options.scales.y.max = ChartTrendTotWoFttxMT.scales.y.max;
                    ChartTrendTotWoFttxMTPending.options.scales.y.max = ChartTrendTotWoFttxMT.scales.y.max;
                    ChartTrendTotWoFttxMTCancel.options.scales.y.max = ChartTrendTotWoFttxMT.scales.y.max;
                    ChartTrendTotWoFttxMT.options.scales.y.min= minChartTotClose;

                    ChartTrendTotWoFttxMTClose.update();
                    ChartTrendTotWoFttxMTPending.update();
                    ChartTrendTotWoFttxMTCancel.update();
                    ChartTrendTotWoFttxMT.update();

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
                                    `<td style="text-align: center; cursor:pointer;" id="${detailCel}" onClick="det_click(this.id)">${item.bulanan[pn].toLocaleString()}</td>
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
                        `<th class="table-dark" style="text-align: center; cursor:pointer" id="${detailCel}" onClick="det_click(this.id)">${TotPenagihanPending[p].toLocaleString()}</th>
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
                                `<td style="text-align: center; cursor:pointer" id="${detailCel}" onClick="det_click(this.id)">${item.bulanan[bln].toLocaleString()}</td>
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
                        `<th class="table-dark" style="text-align: center; cursor:pointer" id="${detailCel}" onClick="det_click(this.id)">${TotPenagihanCancel[p].toLocaleString()}</th>
                        <th class="table-dark" style="text-align: center"></th>`;
                    }

                    $('#totRootCouseCancel').append(totRootCancel + `<th class="table-dark" style="text-align: center">${subtotal.toLocaleString()}</th>`);

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
