@extends('layouts.mainapp')

@section('title','Banners')
@section('style')
  <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
  <style>
       /* image dimension */
       img{
            height: 200px;
            width: 350px;
        }
  
        /* imagelistId styling */
        #imageListId
        { 
        margin: 0; 
        padding: 0;
        list-style-type: none;
        }
        #imageListId div
        { 
            margin: 0 4px 4px 4px;
            padding: 0.4em;             
            display: inline-block;
        }
  
        /* Output order styling */
        #outputvalues{
        margin: 0 2px 2px 2px;
        padding: 0.4em; 
        padding-left: 1.5em;
        width: 250px;
        border: 2px solid dark-green; 
        background : gray;
        }
        .listitemClass 
        {
          position: relative;
            border: 1px solid #006400; 
            width: 350px;     
        }
        .listitemClass img{
          width: 100%;
          height: 100%;
        }
        .height{ 
            height: 10px;
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
            
            <div id = "imageListId">
              @foreach ($banners as $index=>$banner)
                <div id="imageNo{{++$index}}" data-id="{{$banner->id}}" class = "listitemClass">
                  <form method="post" action="{{ route('banners.destroy',$banner->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger float-right" style="position: absolute;right:0"><i class="fa fa-trash"></i></button>
                  </form>
                    <img src="{{$banner->image}}" alt="image">
                </div>
              @endforeach
            </div>

            <div class="row">
              <div class="col-md-12">

                <form action="{{ route('banners.store') }}" id="bannerform" method="post" enctype="multipart/form-data">
                  @csrf
                  <input type="file" name="images[]" multiple>
                  <button type="submit" class="btn btn-primary">Save</button>
                </form>
              </div>
            </div>

           </div>
           
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
 
            $( "#imageListId" ).sortable({
            update: function(event, ui) {
                getIdsOfImages();
            }//end update         
            });
 
            $(document).on('submit','#bannerform',function(e){
              e.preventDefault();
              $.ajax({
                type: "post",
                url: "{{route('banners.store')}}",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function (response) {
                    if(response.status){
                      toastr.success("Image uploaded successfully.");
                      location.reload();
                    }
                }
              });
            })
            
        function getIdsOfImages() {
            var values = [];
            $('.listitemClass').each(function (index) {
              // console.log($(this).attr('data-id'));
                values.push({
                  id:$(this).attr('data-id'),
                  order:$(this).attr("id").replace("imageNo", "")
                });
            });
            $.ajax({
              type: "post",
              url: "{{route('banner.uploadimage')}}",
              data: {order:values,'_token':"{{csrf_token()}}"},
              dataType: "json",
              success: function (response) {
                if(response.status){
                  toastr.success("Image reorder successfully.");
                  // location.reload();
                }
              }
            });
        }
</script>
@endsection