@extends('layout.main')

@section('content')
    <div class="row" id="mychart">

        {{-- <div class="row"> --}}

        <!-- order-card start -->
        <div class="col">
            <div class="card bg-c-blue">
                <div class="card-block ">
                    <h6 class="m-b-20">Total Aset</h6>
                    <h2 class="text-right"><i class="ti-view-list-alt f-left"></i><span>{{ $totAset }}</span></h2>
                    {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-info">
                <div class="card-block">
                    <h6 class="m-b-20">Aset Tersedia</h6>
                    <h2 class="text-right"><i class="ti-list f-left"></i><span>{{ $tersedia }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">213</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-c-green ">
                <div class="card-block">
                    <h6 class="m-b-20">Aset Terdistribusi</h6>
                    <h2 class="text-right"><i class="ti-write f-left"></i><span>{{ $distribusi }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">213</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-c-yellow ">
                <div class="card-block">
                    <h6 class="m-b-20">Aset Rusak</h6>
                    <h2 class="text-right"><i class="ti-layers f-left"></i><span>{{ $rusak }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">5,032</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-c-pink ">
                <div class="card-block">
                    <h6 class="m-b-20">Aset Hilang</h6>
                    <h2 class="text-right"><i class="ti-archive f-left"></i><span>{{ $hilang }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">542</span></p> --}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-info ">
                <div class="card-block">
                    <h6 class="m-b-20">Aset Disposal</h6>
                    <h2 class="text-right"><i class="ti-archive f-left"></i><span>{{ $disposal }}</span></h2>
                    {{-- <p class="m-b-0">This Month<span class="f-right">542</span></p> --}}
                </div>
            </div>
        </div>


        {{-- </div>   --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="kategori-chart"></canvas>
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
        var totAsetKategori = {!! $totAsetKategori !!}

        var kategori = [];
        var jmlKategori = [];


        $.each(totAsetKategori, function(key, item) {

            kategori.push(item.kategori);
            jmlKategori.push(item.jumlah);

        });

        const ctxKategori = document.getElementById('kategori-chart');

        new Chart(ctxKategori, {
            type: 'bar',
            data: {
                labels: kategori, //['Tools', 'Seragam', 'Laptop'],
                datasets: [{
                    label: 'Jumlah Aset Per Kategori',
                    data: jmlKategori, //['435', '65', '535'],
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
            },
            plugins: [ChartDataLabels]

        });


        var totAsetTools = {!! $totAsetTools !!}

        var toolName;

        for (var t = 0; t < Object.keys(totAsetTools).length; t++) {

            namaTool = Object.keys(totAsetTools[t])

            const div1 = document.createElement('div');
            div1.className = "col-sm-3";
            div1.setAttribute("id", namaTool + "1");
            document.getElementById('mychart').appendChild(div1);

            for (var x = 2; x <= 3; x++) {

                if (x == 2) {
                    const div2 = document.createElement('div');
                    div2.className = "card"
                    div2.setAttribute("id", namaTool + "2");

                    document.getElementById(namaTool + "1").appendChild(div2);
                }

                if (x == 3) {
                    const div3 = document.createElement('div');
                    div3.className = "card-body";
                    div3.setAttribute("id", namaTool + "3");
                    div3.innerHTML = `<canvas id="` + namaTool + `"></canvas>`;

                    document.getElementById(namaTool + "2").appendChild(div3);
                }
            }

            eval('var tool' + t + '= [];');
            eval('var jmlTool' + t + '= [];');
            eval('var kategoriName' + t);

            $.each(totAsetTools[t][namaTool], function(key, item) {

                eval('tool' + t + '.push(item.kategori)');
                eval('jmlTool' + t + '.push(item.jumlah)');
                eval('kategoriName' + t + '= item.kategoriName');

            });

            var kategori = eval('kategoriName' + t);

            new Chart(document.getElementById(namaTool), {
                type: 'bar',
                data: {
                    labels: eval('tool' + t), //['Tersedia', 'Di Pinjam', 'Rusak', 'Hilang'],
                    datasets: [{
                        label: 'Kategori  ' + kategori + ' - ' + namaTool,
                        data: eval('jmlTool' + t), //['5', '42', '3', '0'],
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
                        borderWidth: 1,
                        datalabels: {
                            color: 'red',
                            anchor: 'end',
                            align: 'top'
                        
                    }
                    }]
                },
                plugins: [ChartDataLabels],

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    
                }
                
            });
        }
    </script>
@endsection
