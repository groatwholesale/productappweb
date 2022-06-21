@extends('layouts.mainapp')
@section('title','Users')

@section('style')
    <link rel="stylesheet" href="{{ asset('theme/datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
    </div>
    <div class="card shadow mb-4">
        {{-- <div class="card-header py-3">
            <a href="{{ route('category.create') }}" class="btn btn-primary float-right">Add Category</a>
        </div> --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" cellspacing="0" id='usersTable' width='100%'>
                    <thead>
                      <tr>
                        <td>id</td>
                        <td>Name</td>
                        <td>Phonenumber</td>
                        <td>Email</td>
                        <td>Birthdate</td>
                        <td>Address</td>
                        <td>Action</td>
                      </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('theme/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $('#usersTable').DataTable({
         processing: true,
         serverSide: true,
         autoWidth: true,
         order: [[ 0, "desc" ]],
         ajax: "{{route('users.lists')}}",
         columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'phonenumber' },
            { data: 'email' },
            { data: 'birth_date' },
            { data: 'address' },
            { data: 'action' },
         ],
         columnDefs: [
            { targets: [0], visible: false,searchable: false},
            { targets: [1], sortable: true,searchable: true},
            { targets: [2], sortable: true,searchable: true},
            { targets: [3], sortable: true,searchable: true},
            { targets: [4], sortable: true,searchable: true},
            { targets: [5], sortable: true,searchable: true},
            { targets: [6], sortable: false,searchable: false},
        ]
      });
    });
    </script>
@endsection