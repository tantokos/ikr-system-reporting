@extends('layout.main')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row  justify-content-md-center">
        <!-- [ form-element ] start -->
        <div class="col-sm-9 ">
            <div class="card w-100">
                {{-- <div class="card-header">
                    <h5>Basic Component</h5>
                </div> --}}
                <div class="card-body">

                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <h5 class="mt-5">{{ $title }}</h5>
                            <hr>
                            <form action="{{ route('fat.store') }}" method="POST">
                                @csrf
                                @method_field('POST')


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Branch</label>
                                    <div class="col">
                                        <select name="branch" class="form-control" id="branch">
                                            <option value="">Pilih branch</option>
                                            @foreach ($branchopt as $branchlist)
                                                <option value="{{ $branchlist->id }}">{{ $branchlist->nama_branch }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('branch')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <label class="col-sm-2 col-form-label">Kode Branch</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="kode_branch" id="kode_branch"
                                            readonly value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Area FAT</label>
                                    <div class="col">
                                        <select name="areaFat" id="areaFat"
                                            class="form-control @error('areaFat') is-invalid @enderror">
                                            {{-- <option value="">Pilih Area FAT</option> --}}
                                            {{-- @foreach ($leadCallOpt as $leadCallList) --}}
                                            {{-- <option value="JKT">Jakarta Timur</option>
                                                <option value="JKT">Jakarta Selatan</option>
                                                <option value="JKT">Jakarta Pusat</option>
                                                <option value="JKT">Jakarta Utara</option>
                                                <option value="JKT">Jakarta Barat</option>
                                                <option value="BKS">Bekasi</option>
                                                <option value="BGR">Bogor</option>
                                                <option value="TGR">Tangerang</option>
                                                <option value="MDN">Medan</option>
                                                <option value="PGP">Pangkal Pinang</option>
                                                <option value="PTK">Pontianak</option>
                                                <option value="JMB">Jambi</option>
                                                <option value="DPR">Bali</option> --}}
                                            {{-- @endforeach --}}

                                        </select>
                                        @error('areaFat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kode Cluster</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="kode_cluster" id="kode_cluster"
                                            placeholder="Input Kode Cluster">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Cluster</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="cluster" id="cluster"
                                            placeholder="Input Cluster">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Jumlah Home Pas</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="homepas" id="homepas"
                                            placeholder="Input Jumlah Home Pas">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Jumlah FAT</label>
                                    <div class="col">
                                        <input type="text" class="form-control @error('jml_fat') is-invalid @enderror"
                                            name="jml_fat" id="jml_fat" placeholder="Input Jumlah FAT">
                                        @error('jml_fat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Sub Active</label>
                                    <div class="col">
                                        <input type="text" class="form-control @error('sub_active') is-invalid @enderror"
                                            name="sub_active" id="sub_active" placeholder="Input Sub Active">
                                        @error('sub_active')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Suspend</label>
                                    <div class="col">
                                        <input type="text" class="form-control @error('suspend') is-invalid @enderror"
                                            name="suspend" id="suspend" placeholder="Input Jumlah Suspend">
                                        @error('suspend')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Manage Service</label>
                                    <div class="col">
                                        <select name="ms_regular" id="ms_regular"
                                            class="form-control @error('ms_regular') is-invalid @enderror">
                                            <option value="">Pilih Manage Service / Non Manage Service</option>

                                            <option value="Manage Service">Manage Service</option>
                                            <option value="Non Manage Service">Non Manage Service</option>



                                        </select>
                                        @error('areaFat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>





                                <hr>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary">Simpan</button>
                                        <a class="btn btn-danger" href="{{ route('fat.index') }}">back</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- Input group -->


        <!-- [ form-element ] end -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#branch').change(function() {

                let branch = $(this).val();
               

                let idl = $('#branch').val();
                let dt = @json($branchopt);
                let lead = dt.find(i => i.id == idl);
                let idb = lead.kode_branch;

                console.log(branch);

                switch (branch) {

                    case '1':
                        var html =
                            '<option value="Jakarta Selatan">Jakarta Selatan</option> <option value="Jakarta Pusat">Jakarta Pusat</option> <option value="Jakarta Utara">Jakarta Utara</option><option value="Jakarta Barat">Jakarta Barat</option>'
                        break;
                    case '2':
                        var html = '<option value="Jakarta Timur">Jakarta Timur</option>'
                        break;
                    case '3':
                        var html = '<option value="Bekasi">Bekasi</option>'
                        break;
                    case '4':
                        var html = '<option value="Bogor">Bogor</option>'
                        break;
                    case '5':
                        var html = '<option value="Tangerang">Tangerang</option>'
                        break;
                    case '6':
                        var html = '<option value="Medan">Medan</option>'
                        break;
                    case '7':
                        var html = '<option value="Pangkal Pinang">Pangkal Pinang</option>'
                        break;
                }

                $('#areaFat').empty();
                $('#areaFat').append(html);
                $('#kode_branch').val(idb);

            });

        });
    </script>
@endsection
