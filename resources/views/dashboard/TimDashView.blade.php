@extends('layout.main')

@section('content')
    <div class="row">

        {{-- <div class="row"> --}}

        <!-- order-card start -->
        <div class="col">
            <div class="card bg-c-blue">
                <div class="card-block ">
                    <h6 class="m-b-20">Leader & Tim</h6>
                    <h2 class="text-right"><i class="ti-view-list-alt f-left"></i><span>{{ number_format(255) }}</span></h2>
                    {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-info">
                <div class="card-block">
                    <h6 class="m-b-20">Leader</h6>
                    <h2 class="text-right"><i class="ti-list f-left"></i><span>25</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">213</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-c-green ">
                <div class="card-block">
                    <h6 class="m-b-20">Callsign Tim</h6>
                    <h2 class="text-right"><i class="ti-write f-left"></i><span>95</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">213</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-c-yellow ">
                <div class="card-block">
                    <h6 class="m-b-20">Teknisi Installer</h6>
                    <h2 class="text-right"><i class="ti-layers f-left"></i><span>132</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">5,032</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-c-pink ">
                <div class="card-block">
                    <h6 class="m-b-20">Teknisi Maintenance</h6>
                    <h2 class="text-right"><i class="ti-archive f-left"></i><span>123</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">542</span></p> --}}
                </div>
            </div>
        </div>

    </div>
    {{-- </div>   --}}
    <!-- order-card end -->

    <!-- statustic and process start -->

    <!-- <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <div style="position: relative"> --}}
                        <canvas id="Month-chart"></canvas>
                        {{-- </div> --}}
                    </div>
                </div>
            </div> -->


    <div class="row">

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-timurIB"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-timurMT"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-selatanIB"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-selatanMT"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-BekasiIB"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-BekasiMT"></canvas>
                    {{-- </div> --}}
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"
        integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script type="text/javascript">
        const ctxPosTimurIB = document.getElementById('posisiBranch-timurIB');

        new Chart(ctxPosTimurIB, {
            type: 'bar',
            data: {
                labels: ['Leader Installer', 'Callsign Tim Installer', 'Installer'],
                datasets: [{
                    label: 'Jumlah Tim Installer - Jakarta Timur',
                    data: ['2', '10', '30'],
                    // backgroundColor: backgroundTimur,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            // stepSize: 5
                        }
                    },

                }
            },
            plugins: [ChartDataLabels]

        });

        const ctxPosTimurMT = document.getElementById('posisiBranch-timurMT');

        new Chart(ctxPosTimurMT, {
            type: 'bar',
            data: {
                labels: ['Leader Maintenance', 'Callsign Tim Maintenance', 'Maintenance'],
                datasets: [{
                    label: 'Jumlah Tim Maintenance - Jakarta Timur',
                    data: ['2', '12', '36'],
                    // backgroundColor: backgroundTimur,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            // stepSize: 5
                        }
                    },

                }
            },
            plugins: [ChartDataLabels]

        });

        const ctxPosSelatanIB = document.getElementById('posisiBranch-selatanIB');

        new Chart(ctxPosSelatanIB, {
            type: 'bar',
            data: {
                labels: ['Leader Installer', 'Callsign Tim Installer', 'Installer'],
                datasets: [{
                    label: 'Jumlah Tim Installer - Jakarta Selatan',
                    data: ['2', '8', '24'],
                    // backgroundColor: backgroundTimur,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            // stepSize: 5
                        }
                    },

                }
            },
            plugins: [ChartDataLabels]

        });

        const ctxPosSelatanMT = document.getElementById('posisiBranch-selatanMT');

        new Chart(ctxPosSelatanMT, {
            type: 'bar',
            data: {
                labels: ['Leader Maintenance', 'Callsign Tim Maintenance', 'Maintenance'],
                datasets: [{
                    label: 'Jumlah Tim Maintenance - Jakarta Selatan',
                    data: ['3', '15', '44'],
                    // backgroundColor: backgroundTimur,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            // stepSize: 5
                        }
                    },

                }
            },
            plugins: [ChartDataLabels]

        });

        const ctxPosBekasiIB = document.getElementById('posisiBranch-BekasiIB');

        new Chart(ctxPosBekasiIB, {
            type: 'bar',
            data: {
                labels: ['Leader Installer', 'Callsign Tim Installer', 'Installer'],
                datasets: [{
                    label: 'Jumlah Tim Installer - Bekasi',
                    data: ['1', '7', '21'],
                    // backgroundColor: backgroundTimur,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            // stepSize: 5
                        }
                    },

                }
            },
            plugins: [ChartDataLabels]

        });

        const ctxPosBekasiMT = document.getElementById('posisiBranch-BekasiMT');

        new Chart(ctxPosBekasiMT, {
            type: 'bar',
            data: {
                labels: ['Leader Maintenance', 'Callsign Tim Maintenance', 'Maintenance'],
                datasets: [{
                    label: 'Jumlah Tim Maintenance - Bekasi',
                    data: ['2', '8', '19'],
                    // backgroundColor: backgroundTimur,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            // stepSize: 5
                        }
                    },

                }
            },
            plugins: [ChartDataLabels]

        });

        
    </script>
@endsection
