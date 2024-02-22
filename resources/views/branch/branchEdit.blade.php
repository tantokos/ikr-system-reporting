
@extends('layout.main')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
{{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>
--}}
<!-- DataTales Example -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">

            </div>

            <div class="card-block">

                    @if($errors->any())
                    @foreach($errors->all() as $err)
                    <p class="alert alert-danger">{{ $err }}</p>
                    @endforeach
                    @endif

                    {{-- <form action="{{ route('customer.store') }}" method="POST"> --}}
                    <form action="{{ route('branch.update', $branchid) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">ID Branch</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-sm" name="nama_branch" value="{{ $branchid->id }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Branch</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-sm" name="nama_branch" value="{{ $branchid->nama_branch }}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kode Branch</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-sm" name="kode_branch" value="{{ $branchid->kode_branch }}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alamat Branch</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="alamat" value="{{ $branchid->alamat }}" />
                            </div>
                        </div>

                        
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a class="btn btn-danger" href="{{ route('branch.index') }}">Back</a>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>

@endsection