@extends('layout.main')

@section('content')
    <div class="row">

        {{-- <div class="row"> --}}

        <!-- order-card start -->
        <div class="col-md-6 col-xl-2">
            <div class="card bg-c-blue">
                <div class="card-block ">
                    <h6 class="m-b-20">Total Karyawan</h6>
                    <h2 class="text-right"><i class="ti-user f-left"></i><span>{{ $totalKaryawan }}</span></h2>
                    {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card bg-info">
                <div class="card-block">
                    <h6 class="m-b-20">Supervisor</h6>
                    <h2 class="text-right"><i class="ti-user f-left"></i><span>{{ $totalSpv }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">213</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card bg-c-green ">
                <div class="card-block">
                    <h6 class="m-b-20">Staff</h6>
                    <h2 class="text-right"><i class="ti-user f-left"></i><span>{{ $totalStaff }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">213</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card bg-c-yellow ">
                <div class="card-block">
                    <h6 class="m-b-20">Leader</h6>
                    <h2 class="text-right"><i class="ti-user f-left"></i><span>{{ $totalLeader }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">5,032</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card bg-c-pink ">
                <div class="card-block">
                    <h6 class="m-b-20">Installer</h6>
                    <h2 class="text-right"><i class="ti-user f-left"></i><span>{{ $totalInstaller }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">542</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card bg-info ">
                <div class="card-block">
                    <h6 class="m-b-20">Maintenance</h6>
                    <h2 class="text-right"><i class="ti-user f-left"></i><span>{{ $totalMaintenance }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">$542</span></p> --}}
                </div>
            </div>
        </div>

        {{-- </div>   --}}
        <!-- order-card end -->

        <!-- statustic and process start -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="Month-chart"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="Statistics-chart"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-timur"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-selatan"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-bekasi"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-bogor"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-tangerang"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-medan"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-PangkalPinang"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-Pontianak"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-Jambi"></canvas>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    {{-- <div style="position: relative"> --}}
                    <canvas id="posisiBranch-Bali"></canvas>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

 
    <script type="text/javascript">
        var totKarPerBranch = {!! $totKarPerBranch !!}

        var branch = [];
        var jmlKar = [];


        $.each(totKarPerBranch, function(key, item) {

            branch.push(item.nama_branch);
            jmlKar.push(item.jumlah);

        });



        const ctxBranch = document.getElementById('Statistics-chart');

        new Chart(ctxBranch, {
            type: 'bar',
            data: {
                labels: branch,
                datasets: [{
                    label: 'Jumlah Karyawan',
                    data: jmlKar,
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
                    borderWidth: 2
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
            plugins: [ChartDataLabels]
        });


        var totPerMonth = {!! $totPerBulan !!}
        var perMonth = [];
        var jmlMonth = [];

        $.each(totPerMonth, function(key, item) {

            perMonth.push(item.tahun);
            jmlMonth.push(item.jumlah);

        });

        const ctxMonth = document.getElementById('Month-chart');

        new Chart(ctxMonth, {
            type: 'line',
            data: {
                labels: perMonth,
                datasets: [{
                    label: 'Jumlah Karyawan Baru Per Bulan',
                    data: jmlMonth,
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
                        beginAtZero: true
                    }
                }
            }
        });

        var totPerPosTimur = {!! $totPerPosTimur !!}
        var perPosTimur = [];
        var jmlPosTimur = [];

        $.each(totPerPosTimur, function(key, item) {

            perPosTimur.push(item.posisi);
            jmlPosTimur.push(item.jumlah);

        });

        const backgroundTimur=[];
        for (i=0; i < perPosTimur.length; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            backgroundTimur.push('rgba('+r+','+g+','+b+', 0.2)');
        }

        const ctxPosTimur = document.getElementById('posisiBranch-timur');

        new Chart(ctxPosTimur, {
            type: 'doughnut',
            data: {
                labels: perPosTimur,
                datasets: [{
                    // label: 'Jumlah Posisi Karyawan Branch Jakarta Timur',
                    data: jmlPosTimur,
                    backgroundColor: backgroundTimur,
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Karyawan Per Posisi Branch Jakarta Timur'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start'
                    }
                },
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


        var totPerPosSelatan = {!! $totPerPosSelatan !!}
        var perPosSelatan = [];
        var jmlPosSelatan = [];

        $.each(totPerPosSelatan, function(key, item) {

            perPosSelatan.push(item.posisi);
            jmlPosSelatan.push(item.jumlah);

        });

        const backgroundSelatan=[];
        for (i=0; i < perPosSelatan.length; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            backgroundSelatan.push('rgba('+r+','+g+','+b+', 0.2)');
        }

        const ctxPosSelatan = document.getElementById('posisiBranch-selatan');

        new Chart(ctxPosSelatan, {
            type: 'doughnut',
            data: {
                labels: perPosSelatan,
                datasets: [{
                    // label: 'Jumlah Posisi Karyawan Branch Jakarta Selatan',
                    data: jmlPosSelatan,
                    backgroundColor: backgroundSelatan,
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Karyawan Per Posisi Branch Jakarta Selatan'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        // max: 70,

                        ticks: {
                            // stepSize: 5
                        }
                    },

                }
            },
            plugins: [ChartDataLabels]
        });


        var totPerPosBekasi = {!! $totPerPosBekasi !!}
        var perPosBekasi = [];
        var jmlPosBekasi = [];

        $.each(totPerPosBekasi, function(key, item) {

            perPosBekasi.push(item.posisi);
            jmlPosBekasi.push(item.jumlah);

        });

        const backgroundBekasi=[];
        for (i=0; i < perPosBekasi.length; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            backgroundBekasi.push('rgba('+r+','+g+','+b+', 0.2)');
        }

        const ctxPosBekasi = document.getElementById('posisiBranch-bekasi');

        new Chart(ctxPosBekasi, {
            type: 'doughnut',
            data: {
                labels: perPosBekasi,
                datasets: [{
                    // label: 'Jumlah Posisi Karyawan Branch Bekasi',
                    data: jmlPosBekasi,
                    backgroundColor: backgroundBekasi,
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Karyawan Per Posisi Branch Bekasi'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start'
                    }
                },
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

        var totPerPosBogor = {!! $totPerPosBogor !!}
        var perPosBogor = [];
        var jmlPosBogor = [];

        $.each(totPerPosBogor, function(key, item) {

            perPosBogor.push(item.posisi);
            jmlPosBogor.push(item.jumlah);

        });

        const backgroundBogor=[];
        for (i=0; i < perPosBogor.length; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            backgroundBogor.push('rgba('+r+','+g+','+b+', 0.2)');
        }

        const ctxPosBogor = document.getElementById('posisiBranch-bogor');

        new Chart(ctxPosBogor, {
            type: 'doughnut',
            data: {
                labels: perPosBogor,
                datasets: [{
                    // label: 'Jumlah Posisi Karyawan Branch Bogor',
                    data: jmlPosBogor,
                    backgroundColor: backgroundBogor,
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Karyawan Per Posisi Branch Bogor'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start'
                    }
                },
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

        var totPerPosTangerang = {!! $totPerPosTangerang !!}
        var perPosTangerang = [];
        var jmlPosTangerang = [];

        $.each(totPerPosTangerang, function(key, item) {

            perPosTangerang.push(item.posisi);
            jmlPosTangerang.push(item.jumlah);

        });

        const backgroundTangerang=[];
        for (i=0; i < perPosTangerang.length; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            backgroundTangerang.push('rgba('+r+','+g+','+b+', 0.2)');
        }

        const ctxPosTangerang = document.getElementById('posisiBranch-tangerang');

        new Chart(ctxPosTangerang, {
            type: 'doughnut',
            data: {
                labels: perPosTangerang,
                datasets: [{
                    // label: 'Jumlah Posisi Karyawan Branch Tangerang',
                    data: jmlPosTangerang,
                    backgroundColor: backgroundTangerang,
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Karyawan Per Posisi Branch Tangerang'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start'
                    }
                },
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

        var totPerPosMedan = {!! $totPerPosMedan !!}
        var perPosMedan = [];
        var jmlPosMedan = [];

        $.each(totPerPosMedan, function(key, item) {

            perPosMedan.push(item.posisi);
            jmlPosMedan.push(item.jumlah);

        });

        const backgroundMedan=[];
        for (i=0; i < perPosMedan.length; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            backgroundMedan.push('rgba('+r+','+g+','+b+', 0.2)');
        }

        const ctxPosMedan = document.getElementById('posisiBranch-medan');

        new Chart(ctxPosMedan, {
            type: 'doughnut',
            data: {
                labels: perPosMedan,
                datasets: [{
                    // label: 'Jumlah Posisi Karyawan Branch Medan',
                    data: jmlPosMedan,
                    backgroundColor: backgroundMedan,
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Karyawan Per Posisi Branch Medan'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start'
                    }
                },
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

        var totPerPosPangkalPinang = {!! $totPerPosPangkalPinang !!}
        var perPosPangkalPinang = [];
        var jmlPosPangkalPinang = [];

        $.each(totPerPosPangkalPinang, function(key, item) {

            perPosPangkalPinang.push(item.posisi);
            jmlPosPangkalPinang.push(item.jumlah);

        });

        const backgroundPangkalPinang=[];
        for (i=0; i < perPosPangkalPinang.length; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            backgroundPangkalPinang.push('rgba('+r+','+g+','+b+', 0.2)');
        }

        const ctxPosPangkalPinang = document.getElementById('posisiBranch-PangkalPinang');

        new Chart(ctxPosPangkalPinang, {
            type: 'doughnut',
            data: {
                labels: perPosPangkalPinang,
                datasets: [{
                    // label: 'Jumlah Posisi Karyawan Branch PangkalPinang',
                    data: jmlPosPangkalPinang,
                    backgroundColor: backgroundPangkalPinang,
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Karyawan Per Posisi Branch PangkalPinang'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start'
                    }
                },
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

        var totPerPosPontianak = {!! $totPerPosPontianak !!}
        var perPosPontianak = [];
        var jmlPosPontianak = [];

        $.each(totPerPosPontianak, function(key, item) {

            perPosPontianak.push(item.posisi);
            jmlPosPontianak.push(item.jumlah);

        });

        const backgroundPontianak=[];
        for (i=0; i < perPosPontianak.length; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            backgroundPontianak.push('rgba('+r+','+g+','+b+', 0.2)');
        }

        const ctxPosPontianak = document.getElementById('posisiBranch-Pontianak');

        new Chart(ctxPosPontianak, {
            type: 'doughnut',
            data: {
                labels: perPosPontianak,
                datasets: [{
                    // label: 'Jumlah Posisi Karyawan Branch Pontianak',
                    data: jmlPosPontianak,
                    backgroundColor: backgroundPontianak,
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Karyawan Per Posisi Branch Pontianak'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start'
                    }
                },
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

        var totPerPosJambi = {!! $totPerPosJambi !!}
        var perPosJambi = [];
        var jmlPosJambi = [];

        $.each(totPerPosJambi, function(key, item) {

            perPosJambi.push(item.posisi);
            jmlPosJambi.push(item.jumlah);

        });

        const backgroundJambi=[];
        for (i=0; i < perPosJambi.length; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            backgroundJambi.push('rgba('+r+','+g+','+b+', 0.2)');
        }

        const ctxPosJambi = document.getElementById('posisiBranch-Jambi');

        new Chart(ctxPosJambi, {
            type: 'doughnut',
            data: {
                labels: perPosJambi,
                datasets: [{
                    // label: 'Jumlah Posisi Karyawan Branch Jambi',
                    data: jmlPosJambi,
                    backgroundColor: backgroundJambi,
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Karyawan Per Posisi Branch Jambi'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start'
                    }
                },
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

        var totPerPosBali = {!! $totPerPosBali !!}
        var perPosBali = [];
        var jmlPosBali = [];

        $.each(totPerPosBali, function(key, item) {

            perPosBali.push(item.posisi);
            jmlPosBali.push(item.jumlah);

        });

        const backgroundBali=[];
        for (i=0; i < perPosBali.length; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            backgroundBali.push('rgba('+r+','+g+','+b+', 0.2)');
        }

        const ctxPosBali = document.getElementById('posisiBranch-Bali');

        new Chart(ctxPosBali, {
            type: 'doughnut',
            data: {
                labels: perPosBali,
                datasets: [{
                    label: 'Jumlah Karyawan',
                    data: jmlPosBali,
                    backgroundColor: backgroundBali,
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Karyawan Per Posisi Branch Bali'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start'
                    }
                },
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
