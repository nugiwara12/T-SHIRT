@extends('layouts.app3')
  
@section('title', 'User Management')
  
@section('contents')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('usermanagement.create') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Users">Add User</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover" id="example">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Roles</th>
                <th>Email Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($users->count() > 0)
                @foreach($users as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->name }}</td>
                        <td class="align-middle">{{ $rs->role }}</td>
                        <td class="align-middle">{{ $rs->email }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('usermanagement.show', $rs->id) }}" type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="View Details">Detail</a>
                                <a href="{{ route('usermanagement.edit', $rs->id)}}" type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit">Edit</a>
                                <form action="{{ route('usermanagement.destroy', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')" data-toggle="tooltip" data-placement="top" title="Delete">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
            @endif
        </tbody>
    </table>
    <footer>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                // dom: 'Bfrtip',
                // buttons: [
                //     'print',
                //     'excel'
                // ]
            } );
        } );
    </script>

    <!-- Include DataTables Buttons extension CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>

    <!-- Include ExcelJS library for Excel export -->
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    </footer>
@endsection