@extends('layouts.app')
@section('content')
<div class="container">

    <table class="table table-striped">
    <h1 style="text-align:center">Profile</h1>

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
                <form class="well form-horizontal" id="myForm" method="POST" action="/update-profile">
                    <div id="error" style="margin-left: 35%;"></div>
                   <fieldset>
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
                      <div class="form-group">
                         <label class="col-md-3 control-label">Name</label>
                         <div class="col-md-8 inputGroupContainer">
                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="name" name="name" placeholder="Full Name" class="form-control" required="true" value={{ isset($data->name) ? $data->name : "" }} type="text"></div>
                         </div>
                         <small id="error_name" class="form-text text-danger"></small>
                      </div>
                      <div class="form-group">
                         <label class="col-md-3 control-label">Email</label>
                         <div class="col-md-8 inputGroupContainer">
                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="email" name="email" placeholder="Email" class="form-control" required="true" value={{ isset($data->email) ? $data->email : "" }} type="email" disabled></div>
                         </div>
                         <small id="error_email" class="form-text text-danger"></small>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">Gender</label>
                      
                         <div class="col-md-8 inputGroupContainer">
                            <div class="input-group">
                               <label class="radio-inline"><input type="radio" name="gender" value="male" id='gender' {{ ($data->gender=='male') ? "checked" : "" }}>Male</label>
                              <label class="radio-inline"><input type="radio" name="gender" value="female" {{ ($data->gender=='female') ? "checked" : "" }}>Female</label>
                              <label class="radio-inline"><input type="radio" name="gender" value="transgender" {{ ($data->gender=='transgender') ? "checked" : "" }}>Transgender</label>
                            </div>
                         </div>
                          <small id="error_gender" class="form-text text-danger"></small>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">phone</label>
                        <div class="col-md-8 inputGroupContainer">
                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="phone" name="phone" placeholder="phone" class="form-control" required="true" value={{ isset($data->phone) ? $data->phone : "" }} type="number"></div>
                        </div>
                        <small id="error_password" class="form-text text-danger"></small>
                     </div>
                      <div class="form-group">
                         <label class="col-md-3 control-label">Password</label>
                         <div class="col-md-8 inputGroupContainer">
                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="password" name="password" placeholder="Password" class="form-control" required="true" value={{ isset($data->password) ? $data->password : "" }} type="password"></div>
                         </div>
                         <small id="error_password" class="form-text text-danger"></small>
                      </div>
                   </fieldset>
                   <button type="submit" style="text-align:center;" class="btn btn-primary">Update</button>
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

$(document).ready(function () {

   $("#myForm").validate({
        rules: {
            name: "required",
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            gender: {
                required: true
            },
            password_confirmation: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
            phone: { 
                    required: true,
                    minlength: 10
            } 
        },
        messages: {
            name: "Please enter your name",
            email: "Please enter a valid email address",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            gender: {
                required: "Please select the gender",
            },
            password_confirmation: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above"
            },
            phone: { 
                    required:" Please select a phone number",
                    minlength: "Your phone number must be at least 10 digit",
            } 
         }
    });

});

$("#myForm").submit(function(event) {

    $("#error").empty();
   // check if the input is valid or not
   if (!$("#myForm").validate()) return false;

    return true;
});

</script>
@endsection
