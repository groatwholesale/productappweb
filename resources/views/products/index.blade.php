@extends('layouts.mainapp')

@section('title','Products')
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
                <div class="col-md-2 mb-4 ml-0">
                    <label for="categoryid">Category</label>
                    <select name="categoryid" id="categoryid" class="form-control">
                        <option value="">All</option>
                        @foreach ($category as $singlecategory)
                            <option value="{{$singlecategory->id}}">{{$singlecategory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <table class="table table-bordered" cellspacing="0" id='productsTable' width='100%'>
                    <thead>
                      <tr>
                        <td>id</td>
                        <td>Title</td>
                        <td>Description</td>
                        <td>Category</td>
                        <td>Price</td>
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

        $(document).on('change',"#categoryid",function () {  
            fetchProduct(this.value);
        });

        fetchProduct("");
    function fetchProduct(category_id){
        $('#productsTable').DataTable({
           processing: true,
           serverSide: true,
           bDestroy: true,  
           autoWidth: true,
           order: [[ 0, "desc" ]],
           ajax:{
                url:"{{route('products.lists')}}",
                dataType:"json",
                data:function(d){
                    d.category_id=category_id
                }
           },
           columns: [
              { data: 'id' },
              { data: 'title' },
              { data: 'description' },
              { data: 'category' },
              { data: 'price' },
              { data: 'action' },
           ],
           columnDefs: [
              { targets: [0], visible: false,searchable: false},
              { targets: [1], sortable: true,searchable: true},
              { targets: [2], sortable: true,searchable: true},
              { targets: [3], sortable: false,searchable: true},
              { targets: [4], sortable: true,searchable: true},
              { targets: [5], sortable: false,searchable: false},
          ]
        });
    }

    });
    </script>
@endsection