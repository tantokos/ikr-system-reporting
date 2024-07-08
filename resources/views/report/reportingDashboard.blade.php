@extends('layout.main')

@section('content')
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white" style="background: linear-gradient(to right, #0071f3, #15559e)">
                <div class="card-body">
                    <h5>IKR System Reporting<h6 id="CardTitle">PT. Mitra Sinergi Telematika</h6></h5>
                    <div class="clearfix" id="smWO" style="display: none">
                        <div class="spinner-border float-right" role="status">
                            <span class="sr-only" >Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ( $monthYear as $month )
        
    <div class="row">
        <div class="col-sm">
            <div class="card bg-light">
                <div class="card-header text-center" style="background: linear-gradient(to right, #0071f3, #15559e)">
                    <h4 class="text-white">Month Report :  {{ isset($month->monthYear) ? $month->monthYear : '-' }}</h4>
                </div>

                    <div class="card-body">
                        @foreach ( $dataMonthly as $data )
                            
                        @if($month->monthYear == $data->monthYear)
                        <div class="row">
                            <div class="col">
                                <p>{{ isset($data->type_segment) ? $data->type_segment : '-' }}</p>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($data->total_wo) ? number_format($data->total_wo) : 0 }}
                                <p><small>Total WO</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($data->total_done) ? number_format($data->total_done) : 0 }}
                                <p><small>WO Done</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($data->total_pending) ? number_format($data->total_pending) : 0 }}
                                <p><small>WO Pending</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($data->total_cancel) ? number_format($data->total_cancel) : 0 }}
                                <p><small>WO Cancel</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <a href="{{ route($data->rlink, 'dashBoard='.$data->monthYear.'') }}" class="btn btn-sm btn-primary btn-round"><small>Show Report</small></a>
                            </div>
                                <hr>
                        </div>
                        @endif

                        @endforeach

                        

                    </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- <div class="row">
        <div class="col-sm">
            <div class="card bg-light">
                <div class="card-header text-center" style="background: linear-gradient(to right, #0071f3, #15559e)">
                    <h5 class="text-white">Month Report :  {{ isset($woFtthIB->MonthYearFtthIB) ? $woFtthIB->MonthYearFtthIB : '-' }}</h5>
                </div>
                
                    <div class="card-body">

                        <div class="row">
                            <div class="col">
                                <p>WO FTTH New Installation & Additional Service STB</p>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthIB->TotFtthIB) ? number_format($woFtthIB->TotFtthIB) : 0 }}
                                <p><small>Total WO</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthIB->TotFtthIBDone) ? number_format($woFtthIB->TotFtthIBDone) : 0 }}
                                <p><small>WO Done</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthIB->TotFtthIBPending) ? number_format($woFtthIB->TotFtthIBPending) : 0 }}
                                <p><small>WO Pending</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthIB->TotFtthIBCancel) ? number_format($woFtthIB->TotFtthIBCancel) : 0 }}
                                <p><small>WO Cancel</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <a href="{{ route('reportIBFtth.index') }}" class="btn btn-sm btn-primary btn-round"><small>Show Report</small></a>
                            </div>
                                <hr>
                        </div>

                        <div class="row">
                            <div class="col">
                                <p>WO FTTH Maintenance</p>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthMT->TotFtthMT) ? number_format($woFtthMT->TotFtthMT) : 0 }}
                                <p><small>Total WO</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthMT->TotFtthMTDone) ? number_format($woFtthMT->TotFtthMTDone) : 0 }}
                                    <p><small>WO Done</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthMT->TotFtthMTPending) ? number_format($woFtthMT->TotFtthMTPending) : 0 }}
                                    <p><small>WO Pending</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthMT->TotFtthMTCancel) ? number_format($woFtthMT->TotFtthMTCancel) : 0 }}
                                <p><small>WO Cancel</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <a href="{{ route('reportMtFtth.index') }}" class="btn btn-sm btn-primary btn-round"><small>Show Report</small></a>
                            </div>

                            <hr>
                        </div>

                        <div class="row">
                            <div class="col">
                                <p>WO FTTH Dismantle</p>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthDis->TotFtthDis) ? number_format($woFtthDis->TotFtthDis) : 0 }}
                                    <p><small>Total WO</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthDis->TotFtthDisDone) ? number_format($woFtthDis->TotFtthDisDone) : 0 }}
                                <p><small>WO Done</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthDis->TotFtthDisPending) ? number_format($woFtthDis->TotFtthDisPending) : 0 }}
                                <p><small>WO Pending</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFtthDis->TotFtthDisCancel) ? number_format($woFtthDis->TotFtthDisCancel) : 0 }}
                                <p><small>WO Cancel</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <a href="{{ route('reportDismantleFtth.index') }}" class="btn btn-sm btn-primary btn-round"><small>Show Report</small></a>
                            </div>

                            <hr>
                        </div>

                        <div class="row">
                            <div class="col">
                                <p>WO FTTX New Installation</p>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFttxIB->TotFttxIB) ? number_format($woFttxIB->TotFttxIB) : 0 }}
                                <p><small>Total WO</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFttxIB->TotFttxIBDone) ? number_format($woFttxIB->TotFttxIBDone) : 0 }}
                                <p><small>WO Done</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFttxIB->TotFttxIBPending) ? number_format($woFttxIB->TotFttxIBPending) : 0 }}
                                <p><small>WO Pending</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFttxIB->TotFttxIBCancel) ? number_format($woFttxIB->TotFttxIBCancel) : 0 }}
                                <p><small>WO Cancel</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <a href="{{ route('reportIBFttx.index') }}" class="btn btn-sm btn-primary btn-round"><small>Show Report</small></a>
                            </div>

                            <hr>
                        </div>

                        <div class="row">
                            <div class="col">
                                <p>WO FTTX Maintenance</p>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFttxMT->TotFttxMT) ? number_format($woFttxMT->TotFttxMT) : 0 }}
                                <p><small>Total WO</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFttxMT->TotFttxMTDone) ? number_format($woFttxMT->TotFttxMTDone) : 0 }}
                                <p><small>WO Done</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFttxMT->TotFttxMTPending) ? number_format($woFttxMT->TotFttxMTPending) : 0 }}
                                <p><small>WO Pending</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <h6>{{ isset($woFttxMT->TotFttxMTCancel) ? number_format($woFttxMT->TotFttxMTCancel) : 0 }}
                                <p><small>WO Cancel</small></p> </h6>
                            </div>

                            <div class="col text-center">
                                <a href="{{ route('reportMTFttx.index') }}" class="btn btn-sm btn-primary btn-round"><small>Show Report</small></a>
                            </div>

                            <hr>
                        </div>

                    </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="row">
        <div class="col-sm-6">
            <div class="card bg-c-blue">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <h6><p>WO FTTH New Installation & Additional Service STB</p></h6>
                        </div>

                        <div class="col-auto text-right">
                            <h6><span class="badge badge-secondary">{{ isset($woFtthIB->MonthYearFtthIB) ? $woFtthIB->MonthYearFtthIB : '-' }}</span></h6>
                        </div>
                    </div>

                    <div class="row">
                        
                        <h6><strong><span>Total {{ isset($woFtthIB->TotFtthIB) ? number_format($woFtthIB->TotFtthIB) : 0 }} WO</span></strong></h6>
                    </div>
                    <hr>

                    <div class="row">

                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3><i class="ti-check-box"></i></h3>
                                </div>

                                <div class="col-auto">
                                    <h4>{{ isset($woFtthIB->TotFtthIBDone) ? number_format($woFtthIB->TotFtthIBDone) : 0 }}
                                    <p><span>WO Done</span></p></h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3><i class="ti-write"></i></h3>
                                    
                                </div>

                                <div class="col-auto">
                                    <h4>{{ isset($woFtthIB->TotFtthIBPending) ? number_format($woFtthIB->TotFtthIBPending) : 0 }}
                                    <p><span>WO Pending</span></p></h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3><i class="ti-back-right"></i></h3>
                                    
                                </div>

                                <div class="col-auto">
                                    <h4>{{ isset($woFtthIB->TotFtthIBCancel) ? number_format($woFtthIB->TotFtthIBCancel) : 0 }}
                                    <p><span>WO Cancel</span></p></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <a href="{{ route('reportIBFtth.index') }}" class="btn btn-sm btn-primary btn-round">Show Report</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card bg-c-green">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <h5><p>WO FTTH Maintenance</p></h5>
                        </div>

                        <div class="col-sm text-right">
                            <h6><span class="badge badge-secondary">{{ isset($woFtthMT->MonthYearFtthMT) ? $woFtthMT->MonthYearFtthMT : '-' }}</span></h6>
                        </div>
                    </div>

                    <div class="row">
                        <h6><strong><span>Total {{ isset($woFtthMT->TotFtthMT) ? number_format($woFtthMT->TotFtthMT) : 0 }} WO</span></strong></h6>
                    </div>
                    <hr>

                    <div class="row">

                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3><i class="ti-check-box"></i></h3>
                                </div>

                                <div class="col-auto">
                                    <h4>{{ isset($woFtthMT->TotFtthMTDone) ? number_format($woFtthMT->TotFtthMTDone) : 0 }}
                                    <p><span>WO Done</span></p></h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3><i class="ti-write"></i></h3>
                                    
                                </div>

                                <div class="col-auto">
                                    <h4>{{ isset($woFtthMT->TotFtthMTPending) ? number_format($woFtthMT->TotFtthMTPending) : 0 }}
                                    <p><span>WO Pending</span></p></h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3><i class="ti-back-right"></i></h3>
                                    
                                </div>

                                <div class="col-auto">
                                    <h4>{{ isset($woFtthMT->TotFtthMTCancel) ? number_format($woFtthMT->TotFtthMTCancel) : 0 }}
                                    <p><span>WO Cancel</span></p></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <a href="{{ route('reportMtFtth.index') }}" class="btn btn-success btn-round">Show Report</a>
                    </div>

                </div>
            </div>
        </div> 

    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card" style="background: linear-gradient(45deg,#ffb64d,#ffcb80)">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <h5><p>WO FTTH Dismantle</p></h5>
                        </div>

                        <div class="col-sm text-right">
                            <h6><span class="badge badge-secondary">{{ isset($woFtthDis->MonthYearFtthDis) ? $woFtthDis->MonthYearFtthDis : '-' }}</span></h6>
                        </div>
                    </div>

                    <div class="row">
                        <h6><strong><span>Total {{ isset($woFtthDis->TotFtthDis) ? number_format($woFtthDis->TotFtthDis) : 0 }} WO</span></strong></h6>
                    </div>
                    <hr>

                    <div class="row">

                        <div class="col">
                            <div class="row">
                                <div class="col-3">
                                    <h5><i class="ti-check-box"></i></h5>
                                </div>

                                <div class="col-sm">
                                    <h5>{{ isset($woFtthDis->TotFtthDisDone) ? number_format($woFtthDis->TotFtthDisDone) : 0 }}
                                    <p><small>WO Done</small></p></h5>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col-3">
                                    <h5><i class="ti-write"></i></i></h5>
                                </div>

                                <div class="col-sm">
                                    <h5>{{ isset($woFtthDis->TotFtthDisPending) ? number_format($woFtthDis->TotFtthDisPending) : 0 }}
                                    <p><small>WO Pending</small></p</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col-3">
                                    <h5><i class="ti-back-right"></i></h5>
                                </div>

                                <div class="col-sm">
                                    <h5>{{ isset($woFtthDis->TotFtthDisCancel) ? number_format($woFtthDis->TotFtthDisCancel) : 0 }}
                                    <p><small>WO Cancel</small></p> </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <a href="{{ route('reportDismantleFtth.index') }}" class="btn btn-secondary btn-round">Show Report</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card bg-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <h5><p>WO FTTX New Installation</p></h5>
                        </div>

                        <div class="col-sm text-right">
                            <h6><span class="badge badge-secondary">{{ isset($woFttxIB->MonthYearFttxIB) ? $woFttxIB->MonthYearFttxIB : '-' }}</span></h6>
                        </div>
                    </div>

                    <div class="row">
                        <h6><strong><span>Total {{ isset($woFttxIB->TotFttxIB) ? number_format($woFttxIB->TotFttxIB) : 0 }} WO</span></strong></h6>
                    </div>
                    <hr>

                    <div class="row">

                        <div class="col">
                            <div class="row">
                                <div class="col-3">
                                    <h5><i class="ti-check-box"></i></h5>
                                </div>

                                <div class="col-sm">
                                    <h5>{{ isset($woFttxIB->TotFttxIBDone) ? number_format($woFttxIB->TotFttxIBDone) : 0 }}
                                    <p><small>WO Done</small></p> </h5>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col-3">
                                    <h5><i class="ti-write"></i></i></h5>
                                </div>

                                <div class="col-sm">
                                    <h5>{{ isset($woFttxIB->TotFttxIBPending) ? number_format($woFttxIB->TotFttxIBPending) : 0 }}
                                    <p><small>WO Pending</small></p> </h5>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col-3">
                                    <h5><i class="ti-back-right"></i></h5>
                                </div>

                                <div class="col-sm">
                                    <h5>{{ isset($woFttxIB->TotFttxIBCancel) ? number_format($woFttxIB->TotFttxIBCancel) : 0 }}
                                    <p><small>WO Cancel</small></p> </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <a href="{{ route('reportIBFttx.index') }}" class="btn btn-secondary btn-round">Show Report</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <h5><p>WO FTTX Maintenance</p></h5>
                        </div>

                        <div class="col-sm text-right">
                            <h6><span class="badge badge-secondary">{{ isset($woFttxMT->MonthYearFttxMT) ? $woFttxMT->MonthYearFttxMT : '-' }}</span></h6>
                        </div>
                    </div>

                    <div class="row">
                        <h6><strong><span>Total {{ isset($woFttxMT->TotFttxMT) ? number_format($woFttxMT->TotFttxMT) : 0 }} WO</span></strong></h6>
                    </div>
                    <hr>

                    <div class="row">

                        <div class="col">
                            <div class="row">
                                <div class="col-3">
                                    <h5><i class="ti-check-box"></i></h5>
                                </div>

                                <div class="col-sm">
                                    <h5>{{ isset($woFttxMT->TotFttxMTDone) ? number_format($woFttxMT->TotFttxMTDone) : 0 }}
                                    <p><small>WO Done</small></p> </h5>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col-3">
                                    <h5><i class="ti-write"></i></i></h5>
                                </div>

                                <div class="col-sm">
                                    <h5>{{ isset($woFttxMT->TotFttxMTPending) ? number_format($woFttxMT->TotFttxMTPending) : 0 }}
                                    <p><small>WO Pending</small></p> </h5>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col-3">
                                    <h5><i class="ti-back-right"></i></h5>
                                </div>

                                <div class="col-sm">
                                    <h5>{{ isset($woFttxMT->TotFttxMTCancel) ? number_format($woFttxMT->TotFttxMTCancel) : 0 }}
                                    <p><small>WO Cancel</small></p> </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <a href="{{ route('reportMTFttx.index') }}" class="btn btn-secondary btn-round">Show Report</a>
                    </div>

                </div>
            </div>
        </div>

    </div> --}}

    

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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="{{ asset('assets/js/chartjs-plugin-datalabels.min.js') }}"></script>

    <script type="text/javascript">
        let firstDate;
        let lastDate;

        // $('#periode').daterangepicker({
        //     startDate: moment().startOf(),
        //     endDate: moment().startOf(),
        //     locale: {
        //         format: 'DD-MM-YYYY'
        //     }
        // });



        // $(document).on('change', '#bulanReport', function() {
        //     bln = new Date($(this).val()).getMonth();
        //     thn = new Date($(this).val()).getFullYear();

        //     firstDate = moment([thn, bln]);
        //     lastDate = moment(firstDate).endOf('month');

        //     $('#periode').data('daterangepicker').setStartDate(firstDate);
        //     $('#periode').data('daterangepicker').setEndDate(lastDate);

        // });


        // $(document).on('change', '#branch', function() {
        //     let filBranch = $(this).val()

        //     $.ajax({
        //         url: "{{ route('getFilterBranchIBFtth') }}",
        //         type: "GET",
        //         data: {
        //             branchReport: filBranch
        //         },
        //         success: function(filterBranch) {
        //             $('#kotamadya').find("option").remove();

        //             $('#kotamadya').append(`
        //                 <option value="All">All</option>
        //             `);

        //             $.each(filterBranch, function(key, item) {
        //                 $('#kotamadya').append(`
        //                     <option value="${item.kotamadya_penagihan}">${item.kotamadya_penagihan}</option>
                        
        //                 `);

        //             })
        //         }
        //     })
        // });
    </script>

@endsection
