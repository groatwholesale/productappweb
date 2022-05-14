@extends('layouts.mainapp')

@section('style')
    <link rel="stylesheet" href="{{ asset('theme/datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('products.create') }}" class="btn btn-primary float-right">Add Product</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" cellspacing="0" id='productsTable' width='100%'>
                    <thead>
                      <tr>
                        <td>id</td>
                        <td>Image</td>
                        <td>Title</td>
                        <td>Description</td>
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
      $('#productsTable').DataTable({
         processing: true,
         serverSide: true,
         autoWidth: true,
         order: [[ 0, "desc" ]],
         ajax: "{{route('products.lists')}}",
         columns: [
            { data: 'id' },
            { data: 'image' },
            { data: 'title' },
            { data: 'description' },
            { data: 'action' },
         ],
         columnDefs: [
            { targets: [0], visible: false,searchable: false},
            { targets: [1], sortable: false,searchable: false},
            { targets: [2], sortable: true,searchable: true},
            { targets: [3], sortable: true,searchable: true},
            { targets: [4], sortable: false,searchable: false},
        ]
      });

    });
    </script>
@endsection