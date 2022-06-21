@extends('layouts.mainapp')

@section('title','Banners')
@section('style')
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
                {{-- @foreach ($banner as $images)
                    <li id="image_{{$images->id}}"> <img src="{{$images->image}}" style="width:100px"> </li>
                @endforeach --}}
            </ul>


            <input type="file" id="input-100" name="input-100[]" accept="image/*" multiple>

       
            <div id="submit-container"> 
                <input type='button' class="btn-submit" value='Submit' id='submit' />
            </div>
           </div>
           
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
    
    });
</script>
@endsection