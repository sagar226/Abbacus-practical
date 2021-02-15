@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
    
        <p></p>
        <h1 style="text-align: center;">CSV Uploader</h1>
       
        <p> </p><p> </p>
  <form action="uploader" enctype="multipart/form-data" method="POST">

    <div class="col-md-10 col-md-offset-1">
          <div class="form-group">
            <label for="exampleFakeFile1">File</label>

            <div class="input-group">
              <input type="file" id="exampleFile1" name="file" style="display: none">
              <input type="text" class="form-control" id="exampleFakeFile1" readonly>
              <span class="input-group-btn">
                          <button class="btn btn-default" type="button" id="exampleFakeBrowseFile1">Browse...</button>
                      </span>
            </div>
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
        {{-- @if(isset($url) && !empty($url))
        <a href={{$url}} class='btn btn-danger btn-margin' download>Fail to imported Data </a>
        @endif --}}
          @if(isset($response) && !empty($response))
        <p  class=' btn-margin' style="color:green">{{$response}}</p>
        @endif
      </div>
    </div>
</div>  
@endsection
@section('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{{Session::token()}}}'
        }
    });
    $(document).ready(function() {
      getcategories(1);
    });
    function getcategories(page){
      $.ajax({
            url: 'getcategories/?page='+page,
            type: 'get',
            dataType: 'json',
            success:function(response){
                categories=response.data.data;
                console.log(categories);
                data=null;
                pagination=null;
                $("#paginate").empty();
                $("#categories").empty();
                if(categories.length){
                    for(ii=0;ii < categories.length;ii++){
                        data+="<tr> <td align='center'><a href='category/"+categories[ii]['id']+"' class='btn btn-default'><em class='fa fa-pencil'></em></a><a href='delete-category/"+categories[ii]['id']+"' class='btn btn-danger btn-margin' ><em class='fa fa-trash'></em></button>"+
                        "<td class='hidden-xs'>"+ categories[ii]['id']  +"</td><td>"+ categories[ii]['name']+"</td><td>"+ categories[ii]['status']+"</tr>";    
                    }
                    pageNextUrl='';
                    if(response.data.next_page_url!=null){
                        pageNextUrl="<li><button class='btn btn-default' onclick='getcategories("+response.data.next_page_url.substr(-1)+")'>»</button></li>";
                    }
                    pagePrevUrl='';
                    if(response.data.prev_page_url!=null){
                        pagePrevUrl="<li><button class='btn btn-default' onclick='getcategories("+response.data.prev_page_url.substr(-1)+")'>«</button></li>";
                    }
                    pagination="<div class='col col-xs-4'>Page "+response.data.current_page+" of "+response.data.last_page+"</div>"+
                  "<div class='col col-xs-8'><ul class='pagination hidden-xs pull-right'>"+pagePrevUrl+pageNextUrl+"</ul></div>";
                }else{
                    data="<tr><td colspan='6' style='text-align:center;'>no value found</td></tr>";
                }
               
                $("#categories").append(data);
                $("#paginate").append(pagination);
            }
        });
    }
    function pageUrl(url){
      console.log(url);
    }
    $('#exampleFakeBrowseFile1, #exampleFakeFile1').on('click', function() {
      $('#exampleFile1').trigger("click");
    });
    $('#exampleFile1').change(function() {
      var file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '');
      $('#exampleFakeFile1').val(file_name);
    });
</script>
@endsection
