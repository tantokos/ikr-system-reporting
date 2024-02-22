@extends('layout.main')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
                </div>

                <div class="card-block">

                    <form action="{{ route('callsignLead.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="my-2">
                            <input type="text" name="lead_callsign" id="lead_callsign" style="text-transform: uppercase;"
                                class="form-control @error('lead_callsign') is-invalid @enderror"
                                placeholder="Lead Callsign" value="{{ old('lead_callsign') }}">
                            @error('lead_callsign')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <select name="leader_id" id="leader_id" class="form-control">
                            <option value="{{ old('leader_id') }}">Pilih Leader</option>
                            @foreach ($leaderlist as $leaders)
                                <option value="{{ $leaders->id }}">{{ $leaders->nama_karyawan }}</option>
                            @endforeach
                        </select>


                        <div class="my-2">
                            <input type="text" name="branch" id="branch"
                                class="form-control @error('branch') is-invalid @enderror" placeholder="branch"
                                value="">
                        </div>

                        <div class="mb-3 justify-content-md-center">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <a class="btn btn-danger" href="{{ route('callsignLead.index') }}">back</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#leader_id').change(function() {
            var id = $(this).val();
            var url = '{{ route('callsignLead.show', ':id') }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response != null) {
                        $('#branch').val(response);

                    }
                }
            });
        });
    </script>
@endsection
