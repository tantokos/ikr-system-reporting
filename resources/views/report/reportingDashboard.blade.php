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
                            <div class="col-sm-4">
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

                            <div class="col text-center">
                                <a href="{{ route('exportData', 'data=sortir&type_wo='.$data->type.'&month='.$month->bulan.'&year='.$month->tahun.'&monthYear='.$month->monthYear.'') }}" class="btn btn-sm btn-info btn-round"><small>Download Data Sortir</small></a>
                            </div>

                            <div class="col text-center">
                                <a href="{{ route('exportData', 'data=ori&type_wo='.$data->type.'&month='.$month->bulan.'&year='.$month->tahun.'&monthYear='.$month->monthYear.'') }}" class="btn btn-sm btn-secondary btn-round"><small>Download Data Ori</small></a>
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
