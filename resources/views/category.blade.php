@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
    
        <p></p>
        <h1 style="text-align: center;">category Tables</h1>
       
        <p> </p><p> </p>
    
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default panel-table">
              <div class="panel-heading">
                <div class="row">
                  <div class="col col-xs-6">
                    <h3 class="panel-title">Panel Heading</h3>
                  </div>
                  <div class="col col-xs-6 text-right">
                    <button type="button" onclick="location.href='/create-category'" class="btn btn-sm btn-primary btn-create">Create New</button>
                  </div>
                </div>
              </div>
              <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th><em class="fa fa-cog"></em></th>
                            <th class="hidden-xs">ID</th>
                            <th>Name</th>
                            <th>status</th>
                        </tr> 
                    </thead>
                    <tbody id='categories'>
                    </tbody>
                </table>
            
              </div>
              <div class="panel-footer">
                <div class="row" id='paginate'>
                
                </div>
              </div>
            </div>

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
</script>
@endsection
