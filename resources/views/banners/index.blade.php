@extends('layouts.mainapp')

@section('title','Banners')
@section('style')
    <link rel="stylesheet" href="{{ asset('theme/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"/>
    <style>
        #dragimage div{
            width:100px;
            height:100px;
            background: rebeccapurple;
            margin: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Banners</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
           <div class="row">
            
            <div class="col-md-3" id="dragimage" style="width:200px;height:200px;">



            </div>
            <div id="txtresponse" > </div>
            <ul id="image-list" >
                @foreach ($banner as $images)
                    <li id="image_{{$images->id}}"> <img src="{{$images->image}}" style="width:100px"> </li>
                @endforeach
            </ul>

       
            <div id="submit-container"> 
                <input type='button' class="btn-submit" value='Submit' id='submit' />
            </div>
           </div>
           
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
<script type="text/javascript">
    $(document).ready(function () {
        var dropIndex;
        $("#image-list").sortable({
            	update: function(event, ui) { 
            		dropIndex = ui.item.index();
            }
        });

        $('#submit').click(function (e) {
            var imageIdsArray = [];
            $('#image-list li').each(function (index) {
                if(index <= dropIndex) {
                    var id = $(this).attr('id');
                    var split_id = id.split("_");
                    imageIdsArray.push(split_id[1]);
                }
            });

            $.ajax({
                url: "{{ route('banner.uploadimage') }}",
                type: 'post',
                data: {imageIds: imageIdsArray,_token:"{{csrf_token()}}"},
                success: function (response) {
                   $("#txtresponse").css('display', 'inline-block'); 
                   $("#txtresponse").text(response);
                }
            });
            e.preventDefault();
        });
    });
    </script>
@endsection