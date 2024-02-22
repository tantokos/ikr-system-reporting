<!DOCTYPE html>
<html>

<head>
    <title>Laravel 9 Import Export Excel to Database Example - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="card bg-light mt-3">
            <div class="card-header">
                Laravel 9 Import Export Excel to Database Example - ItSolutionStuff.com
            </div>
            <div class="card-body">
                <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-success">Import User Data</button>
                </form>

                <table class="table table-bordered mt-3">
                    <tr>
                        <th colspan="16">
                            List Of Users
                            <a class="btn btn-warning float-end" href="#">Export User Data</a>
                        </th>
                    </tr>
                    <tr>
                        <th>wo_no</th>
                        <th>ticket_no</th>
                        <th>wo_date</th>
                        <th>cust_id</th>
                        <th>name</th>
                        <th>cust_phone</th>
                        <th>cust_mobile</th>
                        <th>address</th>
                        <th>area</th>
                        <th>wo_type</th>
                        <th>fat_code</th>
                        <th>fat_port</th>
                        <th>remarks</th>
                        <th>vendor_installer</th>
                        <th>ikr_date</th>
                        <th>time</th>
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->wo_no }}</td>
                            <td>{{ $user->ticket_no }}</td>
                            <td>{{ $user->wo_date }}</td>
                            <td>{{ $user->cust_id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->cust_phone }}</td>
                            <td>{{ $user->cust_mobile }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->area }}</td>
                            <td>{{ $user->wo_type }}</td>
                            <td>{{ $user->fat_code }}</td>
                            <td>{{ $user->fat_port }}</td>
                            <td>{{ $user->remarks }}</td>
                            <td>{{ $user->vendor_installer }}</td>
                            <td>{{ $user->ikr_date }}</td>
                            <td>{{ $user->time }}</td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>

</body>

</html>
