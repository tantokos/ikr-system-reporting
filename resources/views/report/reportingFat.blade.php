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
                    <h6>Summary Activity FAT - <h5 id="CardTitle">All Branch - All Site (Retail, Apartemen, Underground)<h5></h6>
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
                                    <th>Branch</th>
                                    <th>Kode Fat</th>
                                    {{-- <th>no_ticket</th> --}}
                                    <th>Tgl IKR</th>
                                    {{-- <th>cust_address1</th> --}}
                                    {{-- <th>cust_address2</th> --}}
                                    {{-- <th>type_maintenance</th> --}}
                                    <th>Type WO</th>
                                    <th>Cust Id</th>
                                    <th>Cust Name</th>
                                    <th>Status WO</th>
                                    <th>Cause Code</th>
                                    <th>Root Cause</th>
                                    <th>Action Taken</th>
                                    {{-- <th>slot_time_leader</th> --}}
                                    {{-- <th>Callsign</th> --}}
                                    {{-- <th>Leader</th> --}}
                                    <th>Teknisi 1</th>
                                    <th>Teknisi 2</th>
                                    <th>Teknisi 3</th>
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

             
            // Tabel FAT
            if(detAPK[0]=="tblFat"){
                if(detAPK[1]=="branchFat") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1], 
                            detBranchFat: detAPK[2],
                            detBulan: detAPK[3],
                            detThn: detAPK[4],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = '';
                }
                if(detAPK[1]=="kodeFat") {
                    datafilter = {
                            detSlide: detAPK[0],
                            detKategori: detAPK[1], 
                            detBranchFat: detAPK[2],
                            detKodeFat: detAPK[3],
                            detBulan: detAPK[4],
                            detThn: detAPK[5],
                            detSite: filSite,
                            detBranch: filBranch,
                            _token: _token
                    };

                    detailTitle = detAPK[2];
                    detailSubTitle = detAPK[3];
                }
                                
            }
            // End Tabel FAT

            bulanData = months[datafilter.detBulan - 1] + "-" + datafilter.detThn;

            $('#md-detail').modal('show');
            $('#canvasDetailAPK').empty();
            event.stopPropagation()

            $.ajax({
                url: "{{ route('getDetailFAT') }}",
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

                    $.each(detAPK.detailBranchFAT, function(key, item) {

                        ChrBranchAPK.push(item.type_wo);
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
                            url: "{{ route('dataDetailFAT') }}",
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
                                data: 'branch',
                                width: '90'
                            },
                            {
                                data: 'kode_fat',
                                width: '90'
                            },
                            {
                                data: 'tgl_ikr'
                            },
                            {
                                "data": 'type_wo',
                                "width": '90'
                            },
                            // {
                            //     data: 'no_wo',
                            //     width: '90'
                            // },
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
                                data: 'action_taken'
                            },
                            // {
                            //     data: 'callsign'
                            // },
                            // {
                            //     data: 'leader'
                            // },
                            {
                                data: 'teknisi1'
                            },
                            {
                                data: 'teknisi2'
                            },
                            {
                                data: 'teknisi3'
                            },
                            
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


            $.ajax({
                url: "{{ route('getBranchFat') }}",
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

                    let blnId;
                    let thnId;
                    let detailCel;
                    let subtotal;
                    let TotBranchCluster = [];
                    let TotMonthCluster = [];
                    let tbBranchCluster;
                    let tbCouseCodeAPK;
                    let tbRootCouseAPK;
                    let hdRootCouseAPK = `
                        <th>Branch</th>
                        <th>Kode FAT</th>`;
                        // <th>Root Couse</th>`;
                        // <th style="text-align: center">Jumlah</th>`;

                    for (h = 0;h < trendWoMt.length; h++) {
                        hdRootCouseAPK = hdRootCouseAPK +
                            `<th colspan="2" style="text-align: center">${trendWoMt[h].bulan}</th>`
                    }

                    $('#tableHeadCluster').append(hdRootCouseAPK + `<th style="text-align: center">Subtotal</th></tr>`);

                    console.log(dataCluster.detCluster.length);
                    $.each(dataCluster.branchFat, function(key, nmBranch) {
                        tbBranchCluster = `
                                <tr class="table-secondary"><th>${nmBranch.nmTbranch}</th>
                                <th class="table-secondary"></th>`;
                                // <th class="table-secondary"></th>`;
                        subtotal=0;

                        for (p=0;p<trendWoMt.length; p++) {

                            TotMonthCluster[p]=0
                            $.each(dataCluster.branchFat, function(key, jmlBln){
                                TotMonthCluster[p] += Number(jmlBln.totbulanan[p]);
                            })

                            blnId = new Date(trendWoMt[p].bulan).getMonth();
                            thnId = new Date(trendWoMt[p].bulan).getFullYear();
                            detailCel = `tblFat|branchFat|${nmBranch.nmTbranch}|${(blnId + 1)}|${thnId}`;
                            
                            tbBranchCluster = tbBranchCluster +
                                `<th class="table-secondary" style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${nmBranch.totbulanan[p].toLocaleString()}</th>
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
                                    <td>${itemCluster.kode_fat}</td>`;
                                    // <th class="table-info"></th>`;
                                
                                subtotal = 0;
                                for (cc = 0;cc < trendWoMt.length; cc++) {

                                    TotMonthCluster[cc]=0
                                    $.each(dataCluster.detCluster, function(ky, jmlBlnCL){
                                        TotMonthCluster[cc] += Number(jmlBlnCL.bulanan[cc]);
                                    })

                                    blnId = new Date(trendWoMt[cc].bulan).getMonth();
                                    thnId = new Date(trendWoMt[cc].bulan).getFullYear();
                                    detailCel = `tblFat|kodeFat|${nmBranch.nmTbranch}|${itemCluster.kode_fat}|${(blnId + 1)}|${thnId}`;

                                    tbCluster = tbCluster + 
                                    `<td style="text-align: center" id="${detailCel}" onClick="det_click(this.id)">${itemCluster.bulanan[cc].toLocaleString()}</td>
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
