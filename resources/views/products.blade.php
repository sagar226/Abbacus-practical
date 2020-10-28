@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
    
        <p></p>
        <h1 style="text-align: center;  ">product Tables</h1>
       
        <p> </p><p> </p>
    
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default panel-table">
              <div class="panel-heading">
                <div class="row">
                  <div class="col col-xs-6">
                    <h3 class="panel-title">Panel Heading</h3>
                  </div>
                  <div class="col col-xs-6 text-right">
                    <button type="button" onclick="location.href='/create-products'" class="btn btn-sm btn-primary btn-create">Create New</button>
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
                            <th>SKU</th>
                            <th>desc</th>
                            <th>Quantity</th>
                            <th>Category</th>
                        </tr> 
                    </thead>
                    <tbody id='products'>
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
      getproducts(1);
    });
    function getproducts(page){
      $.ajax({
            url: 'getproducts/?page='+page,
            type: 'get',
            dataType: 'json',
            success:function(response){
                products=response.data.data;
                console.log(products);
                data=null;
                pagination=null;
                $("#paginate").empty();
                $("#products").empty();
                if(products.length){
                    for(ii=0;ii < products.length;ii++){
                        data+="<tr> <td align='center'><a href='product/"+products[ii]['id']+"' class='btn btn-default'><em class='fa fa-pencil'></em></a><a href='delete-product/"+products[ii]['id']+"' class='btn btn-danger btn-margin' ><em class='fa fa-trash'></em></button>"+
                        "<td class='hidden-xs'>"+ products[ii]['id']  +"</td><td>"+ products[ii]['name']+"</td><td>"+ products[ii]['sku']+"</td><td>"+ products[ii]['desc']+"</td><td>"+ products[ii]['quantity']+"</td><td>"+ products[ii]['category'].name+"</td></tr>";    
                    }
                    pageNextUrl='';
                    if(response.data.next_page_url!=null){
                        pageNextUrl="<li><button class='btn btn-default' onclick='getproducts("+response.data.next_page_url.substr(-1)+")'>»</button></li>";
                    }
                    pagePrevUrl='';
                    if(response.data.prev_page_url!=null){
                        pagePrevUrl="<li><button class='btn btn-default' onclick='getproducts("+response.data.prev_page_url.substr(-1)+")'>«</button></li>";
                    }
                    pagination="<div class='col col-xs-4'>Page "+response.data.current_page+" of "+response.data.last_page+"</div>"+
                  "<div class='col col-xs-8'><ul class='pagination hidden-xs pull-right'>"+pagePrevUrl+pageNextUrl+"</ul></div>";
                }else{
                    data="<tr><td colspan='6' style='text-align:center;'>no value found</td></tr>";
                }
               
                $("#products").append(data);
                $("#paginate").append(pagination);
            }
        });
    }
    function pageUrl(url){
      console.log(url);
    }
</script>
@endsection
