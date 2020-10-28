@extends('layouts.app')
@section('content')
<div class="container">

    <table class="table table-striped">

       <tbody>
        @if($errors->any())
        <div class="row">
            <div class="col-md-4 col-md-offset-4 error">
                <ul>
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <li>{{$error}}</li>
                    </div>
                    @endforeach
                </ul>
            </div>
        </div>    
        @endif
          <tr>
             <td colspan="1">
                 
                <form class="well form-horizontal" id="myForm" method="POST" action={{ isset($data->id) ? 'update-product' : 'submit-product'  }}>
                    <div id="error" style="margin-left: 35%;"></div>
                   <fieldset>
                   <input type="hidden" name="id" id="id" value={{ isset($data->id) ? $data->id : ""}}  />
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                      <div class="form-group">
                         <label class="col-md-3 control-label">Name</label>
                         <div class="col-md-8 inputGroupContainer">
                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="name" name="name" placeholder="Name" class="form-control" required="true" value="{{ isset($data->name) ? $data->name : ''  }}" type="text"></div>
                         </div>
                         <small id="error_name" class="form-text text-danger"></small>
                      </div>
                      <div class="form-group">
                         <label class="col-md-3 control-label">SKU</label>
                         <div class="col-md-8 inputGroupContainer">
                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="sku" name="sku" placeholder="sku" class="form-control" required="true" value="{{ isset($data->sku) ? $data->sku : ''  }}" type="text"></div>
                         </div>
                         <small id="error_name" class="form-text text-danger"></small>
                      </div>

                      <div class="form-group">
                         <label class="col-md-3 control-label">desc</label>
                         <div class="col-md-8 inputGroupContainer">
                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="desc" name="desc" placeholder="desc" class="form-control" required="true" value="{{ isset($data->desc) ? $data->desc : ''  }}" type="text"></div>
                         </div>
                         <small id="error_name" class="form-text text-danger"></small>
                      </div>
                      <div class="form-group">
                         <label class="col-md-3 control-label">Quantity</label>
                         <div class="col-md-8 inputGroupContainer">
                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="Quantity" name="quantity" placeholder="quantity" class="form-control" required="true" value="{{ isset($data->quantity) ? $data->quantity : ''  }}" type="text"></div>
                         </div>
                         <small id="error_name" class="form-text text-danger"></small>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">category</label>
                         <div class="col-md-8 inputGroupContainer">
                            <div class="input-group">
                               <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                               <select class="selectpicker form-control" id="status" name="category_id">
                                @if(isset($categories) && count($categories) >0)   
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (isset($data->category_id) && $data->category_id==$category->id) ? 'selected' : ''  }} >{{ $category->name }}</option>
                                    @endforeach                               
                                </select>
                                @endif
                            </div>
                         </div>
                      </div>
                   </fieldset>
                   <button type="submit" style="text-align:center;" class="btn btn-primary">Submit</button>
                </form>
             </td>
          </tr>
       </tbody>
    </table>
 </div> 
@endsection
@section('script')
<style>
.error {
    color: red;
 }
    </style>
<script>


</script>
@endsection
