@extends('layout.main')

@section('content')
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
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group row ">

                                <div class="col justify-content-md-center">
                                    {{-- <div class="card"> --}}
                                    {{-- <div class="card-block"> --}}
                        
                                    {{-- <div style="position: relative"> --}}
                                    <img src="{{ asset('storage/image-kry/' . $karyawan->foto_karyawan) }}" id="showgambar" alt="Card Image"
                                        style="width:300px;height: 300px;" />
                                    {{-- </div> --}}
                        
                                    {{-- </div> --}}
                                    {{-- </div> --}}
                                </div>

                                <div class="col">
                                    <small class="col form-text">Nik Karyawan</small>
                                    <label class="col">{{ $karyawan->nik_karyawan}}</label>

                                    <small class="col form-text">Nama Karyawan</small>
                                    <label class="col">{{ $karyawan->nama_karyawan}}</label>

                                    <small class="col form-text">No Telepon</small>
                                    <label class="col">{{ $karyawan->no_telp}}</label>

                                    <small class="col form-text">Email</small>
                                    <label class="col">{{ $karyawan->email}}</label>

                                    <small class="col form-text">Status Aktif</small>
                                    <label class="col">{{ $karyawan->status_active}}</label>
                                </div>

                                <div class="col">
                                    <small class="col form-text">No BPJS</small>
                                    <label class="col">{{ $karyawan->no_bpjs ?: '-'}}</label>

                                    <small class="col form-text">No Jamsostek</small>
                                    <label class="col">{{ $karyawan->no_jamsostek ?: '-'}}</label>

                                    <small class="col form-text">Tanggal Bergabung</small>
                                    <label class="col">{{ $karyawan->tgl_gabung ?: '-'}}</label>

                                    <small class="col form-text">Tanggal Non Aktif</small>
                                    <label class="col">{{ $karyawan->tgl_nonactive ?: '-'}}</label>

                                    
                                </div>

                                <div class="col">
                                    <small class="col form-text">Divisi</small>
                                    <label class="col">{{ $karyawan->divisi}}</label>

                                    <small class="col form-text">Departemen</small>
                                    <label class="col">{{ $karyawan->departement}}</label>

                                    <small class="col form-text">Posisi</small>
                                    <label class="col">{{ $karyawan->posisi}}</label>

                                    <small class="col form-text">Branch</small>
                                    <label class="col">{{ $karyawan->nama_branch}}</label>

                                    
                                </div>

                                
                            </div>


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
                    {{-- <div style="position: relative"> --}}
                    {{-- <canvas id="posisiBranch-selatanIB"></canvas> --}}
                    {{-- </div> --}}
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataEmployee" width="100%" cellspacing="0"
                            style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Callsign</th>
                                    <th>Teknisi 1</th>
                                    <th>Teknisi 2</th>
                                    <th>Teknisi 3</th>
                                    <th>Teknisi 4</th>
                                    
                                </tr>
                            </thead>
        
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>JKTMST001</td>
                                    <td>Jajang Nurzaman (KKM)</td>
                                    <td>Muhammad Ibnu Alfarizi</td>
                                    <td>Hendi</td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>JKTMST002</td>
                                    <td>Saputra Arbidah</td>
                                    <td>Juprianto Manalu</td>
                                    <td>Fadilla Muhammad Ramadhan</td>
                                    <td></td>

                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>JKTMST003</td>
                                    <td>Wahyudi Harianto</td>
                                    <td>Zaenal Abidin</td>
                                    <td>Dandy Rizky Nanda</td>
                                    <td></td>

                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>JKTMST004</td>
                                    <td>Christian Safei</td>
                                    <td>Sarwani</td>
                                    <td>Ahmad Sarifudin</td>
                                    <td></td>

                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td>JKTMST005</td>
                                    <td>Rachmad Sariyanto</td>
                                    <td>Ahmad Faisal</td>
                                    <td>Iya Irawan</td>
                                    <td></td>

                                </tr>
        
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataEmployee" width="100%" cellspacing="0"
                            style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Nama Aset</th>
                                    <th>Satuan</th>
                                    <th>Jml Pinjam</th>
                                    
                                    
                                    
                                </tr>
                            </thead>
        
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Seragam</td>
                                    <td>Seragam Oxygen Hijau-L</td>
                                    <td>Pcs</td>
                                    <td>15</td>
                                    

                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Seragam</td>
                                    <td>Seragam Oxygen Biru-L</td>
                                    <td>Pcs</td>
                                    <td>15</td>

                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>Laptop</td>
                                    <td>Laptop Lenovo</td>
                                    <td>Unit</td>
                                    <td>1</td>

                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>Tools</td>
                                    <td>OPM</td>
                                    <td>Unit</td>
                                    <td>5</td>

                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td>Tools</td>
                                    <td>Tangga</td>
                                    <td>Unit</td>
                                    <td>5</td>

                                </tr>
        
                            </tbody>
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
