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
                            <form action="{{ route('callsignTim.update', $timEdit->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                {{-- {{ $timEdit2 }} --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Lead Callsign</label>
                                    <div class="col">
                                        <select name="leadCallsign" id="leadCallsign"
                                            class="form-control @error('leadCallsign') is-invalid @enderror">
                                            <option value="{{ $timEdit->lead_callsign }}">Pilih Lead Callsign</option>
                                            @foreach ($leadCallOpt as $leadCallList)
                                                <option value="{{ $leadCallList->id }}"
                                                    {{ $leadCallList->id == $timEdit->lead_callsign ? 'selected' : '' }}>
                                                    {{ $leadCallList->lead_callsign }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('leadCallsign')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Leader</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="leader" id="leader"
                                            placeholder="Leader" readonly value="{{ $timEdit->nama_leader }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Branch</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="branch" id="branch"
                                            placeholder="Branch" readonly value="{{ $timEdit->nama_branch }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Posisi</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="posisi" id="posisi"
                                            placeholder="Posisi" readonly value="{{ $timEdit->posisi_leader }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Callsign Tim</label>
                                    <div class="col">
                                        <input type="text" class="form-control @error('callsign') is-invalid @enderror"
                                            name="callsign" id="callsign" placeholder="Callsign"
                                            value="{{ $timEdit->callsign_tim }}">
                                        @error('callsign')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Teknisi 1</label>
                                    <div class="col">
                                        <select name="teknisi[]" id="teknisi1" class="js-example form-control">
                                            {{-- <option value="" selected="selected">Pilih Teknisi 1</option> --}}
                                            {{-- @foreach ($teknisiBranch as $teknisiBranchList) --}}
                                            {{-- <option value=""></option> --}}
                                            {{-- @endforeach --}}

                                        </select>
                                    </div>
                                </div>
                                

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Teknisi 2</label>
                                    <div class="col">
                                        <select name="teknisi[]" id="teknisi2" class="js-example form-control">
                                            {{-- <option value="">Pilih Teknisi</option> --}}
                                            {{-- @foreach ($teknisiBranch as $teknisiBranchList) --}}
                                            {{-- <option value=""></option> --}}
                                            {{-- @endforeach --}}

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Teknisi 3</label>
                                    <div class="col">
                                        <select name="teknisi[]" id="teknisi3" class="js-example form-control">
                                            {{-- <option value="">Pilih Teknisi</option> --}}
                                            {{-- @foreach ($teknisiBranch as $teknisiBranchList) --}}
                                            {{-- <option value=""></option> --}}
                                            {{-- @endforeach --}}

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Teknisi 4</label>
                                    <div class="col">
                                        <select name="teknisi[]" id="teknisi4" class="js-example form-control">
                                            {{-- <option value="">Pilih Teknisi</option> --}}
                                            {{-- @foreach ($teknisiBranch as $teknisiBranchList) --}}
                                            {{-- <option value=""></option> --}}
                                            {{-- @endforeach --}}

                                        </select>
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary">Simpan</button>
                                        <a class="btn btn-danger" href="{{ route('callsignTim.index') }}">back</a>
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

    <div class="copy invisible">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Tim</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="tim[]" placeholder="Email">
            </div>
            <div class="col-sm-2">
                <button class="btn  btn-sm remove" type="button">
                    <i class="ti-trash"></i>remove</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // let result
            // let idl
            // let dt
            // let lead
            // let idb
            // let url

            // $('#leadCallsign').change(function() {

            let idl = $('#leadCallsign').val();
            let dt = @json($leadCallOpt);
            let lead = dt.find(i => i.id == idl);
            let idb = lead.branch_id;


            // console.log(lead.leader_id);
            // $('#leader').val(lead.nama_karyawan);
            // $('#branch').val(lead.nama_branch);
            // $('#posisi').val(lead.posisi);




            // var url = "{{ route('callsignTimShow.show', ':id') }}";
            var url = '{{ route('callsignTimShow.show', ':id') }}';
            url = url.replace(':id', lead.leader_id);




            // $('#teknisi1').trigger('change');

            $("#teknisi1").select2({
                theme: 'classic',
                allowClear: true,
                placeholder: 'Pilih Teknisi 1',
                ajax: {
                    url: url,
                    processResults: function({
                        data
                    }) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama_karyawan
                                }
                            })
                        }
                    }
                }
            });

            $("#teknisi2").select2({
                theme: 'classic',
                allowClear: true,
                placeholder: 'Pilih Teknisi 2',

                ajax: {
                    url: url,
                    processResults: function({
                        data
                    }) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama_karyawan
                                }
                            })
                        }
                    }
                }
            });

            $("#teknisi3").select2({
                theme: 'classic',
                allowClear: true,
                placeholder: 'Pilih Teknisi 3',
                ajax: {
                    url: url,
                    processResults: function({
                        data
                    }) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama_karyawan
                                }
                            })
                        }
                    }
                }
            });

            $("#teknisi4").select2({
                theme: 'classic',
                allowClear: true,
                placeholder: 'Pilih Teknisi 4',
                ajax: {
                    url: url,
                    processResults: function({
                        data
                    }) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama_karyawan
                                }
                            })
                        }
                    }
                }
            });


            // });


            // });

            var edit2 = @json($timEdit2)

            $.each(@json($timEdit2), function(index, item) {

                // for (i = 1; i < 4; i++) {

                    
                    var newOption = new Option(item.nama_karyawan1, item.nik_tim1, false, false);
                    $('#teknisi1').append(newOption).trigger('change');
                    var newOption2 = new Option(item.nama_karyawan2, item.nik_tim2, false, false);
                    $('#teknisi2').append(newOption2).trigger('change');
                    var newOption3 = new Option(item.nama_karyawan3, item.nik_tim3, false, false);
                    $('#teknisi3').append(newOption3).trigger('change');
                    var newOption4 = new Option(item.nama_karyawan4, item.nik_tim4, false, false);
                    $('#teknisi4').append(newOption4).trigger('change');

                    
                    // console.log('#teknisi' + i);                    
                // }
            });

        });
    </script>
@endsection
