@extends('layout.main')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>
--}}
    <!-- DataTales Example -->

    <div class="card">
        <div class="card-header">
            {{-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}
            {{-- <a href="/employeeCreate" class="btn btn-primary">input baru</a> --}}
            {{-- <button type="button" class="btn  btn-info form-text" data-toggle="modal" data-target="#md-edit-kelengkapan">Input Baru</button> --}}
        </div>

        <div class="card-block" style="text-align: center">
            <img src="{{ asset('assets/images/under_Construction.jpg')}}" style="width:400px;height: 400px;" >
        </div>
    </div>

    {{-- Modal Input Baru --}}

    
@endsection

