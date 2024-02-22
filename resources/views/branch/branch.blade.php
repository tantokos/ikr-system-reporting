@extends('layout.main')

@section('content')

<!-- Page Heading -->
{{-- <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1> --}}
<h1 class="h3 mb-2 text-gray-800">Data Branch</h1>
{{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>
--}}
<!-- DataTales Example -->

<div class="card">
    <div class="card-header">
        {{-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}
        <a href="/branchCreate" class="btn btn-primary">input baru</a>
    </div>

    <div class="card-block">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Branch</th>
                        <th>Alamat Branch</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($branches as $b )
                        
                    <tr>
                        <td>{{ $b->id }}</td>
                        <td>{{ $b->nama_branch }}</td>

                        <td>{{ $b->alamat }}</td>
                        <td>
                            <a href="{{ route('employee.index') }}" class="btn btn-primary btn-user btn-block">
                                Edit
                            </a>
                        
                        </td>
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection