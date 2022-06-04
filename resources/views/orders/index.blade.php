@extends('layouts.mainapp')

@section('title','Orders')
@section('style')
    <link rel="stylesheet" href="{{ asset('theme/datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Orders</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" cellspacing="0" id='categoryTable' width='100%'>
                    <thead>
                      <tr>
                        <td>Order Id</td>
                        <td>Userame</td>
                        <td>Total Price</td>
                        <td>Stauts</td>
                        <td>Action</td>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->users->name}}</td>
                            <td>{{$order->total_price}}</td>
                            <td>{{$order->status==0?"Pending":"Completed"}}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('order.show',$order->id) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                    <form action="{{ route('complete_order') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="orderid" value="{{$order->id}}">
                                        <button type="submit" class="btn btn-primary" {{$order->status==0?"":"disabled"}}>Completed</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                            
                        @endforelse
                    </tbody>
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

      $('#categoryTable').DataTable({
         processing: true,
        //  serverSide: true,
         autoWidth: true,
         order: [[ 0, "desc" ]],
        //  ajax: "{{route('order.lists')}}",
         columns: [
            { data: 'id' },
            { data: 'name',name:'users.name' },
            { data: 'quantity' },
            { data: 'status' },
            { data: 'action' },
         ],
         columnDefs: [
            { targets: [0], sortable: true,searchable: false},
            { targets: [1], sortable: true,searchable: true},
            { targets: [2], sortable: true,searchable: true},
            { targets: [3], sortable: true,searchable: true},
            { targets: [4], sortable: false,searchable: false},
        ]
      });

    });
    </script>
@endsection