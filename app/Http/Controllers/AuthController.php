<?php

namespace App\Http\Controllers;

use App\Core\Repositories\UserRepository;
use App\User;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\CountValidator\Exact;

class AuthController extends Controller
{
    public function index(){
        return view('userForm');
    }
    public function userRegistration(Request $request){
       
        $message=[
            'password.regex' => 'Password must contain 1 number and 1 special character'
        ];
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'gender' => ['required',Rule::in('male','female','transgender')],
            'phone' => 'required|numeric',
            'password' => 'required|confirmed|min:6|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/',
        ],$message);    

        if($validator->fails())   return view('userForm',['errors'=>$validator->errors()]);  
       
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'gender' => $request->gender,
                'phone' =>$request->phone,
                'password' => encrypt($request->password)
            ]);

            $request->session()->put('user_id', $user->id);

        return redirect('profile/'.$user->id);
    }
    public function profile($id){
        $validator = Validator::make(['id'=>$id],[
            'id'=>'required|exists:users,id'   
        ]);    

        if($validator->fails())   return view('userForm',['errors'=>$validator->errors()]);  
        $user=User::where('id',$id)->first();
        
        return view('profile',['data'=>$user]);
    }
    public function updateProfile(Request $request){

        $message=[
            'password.regex' => 'Password must contain 1 number and 1 special character'
        ];
        $validator = Validator::make($request->all(),[
            'name'=>'nullable|string',
            'id'=>'required|exists:users,id',   
            'gender' => ['nullable',Rule::in('male','female','transgender')],
            'phone' => 'nullable|numeric',
            'password' => 'nullable|min:6|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/',
        ],$message);    

        if($validator->fails())   return view('userForm',['errors'=>$validator->errors()]); 
  
        User::where('id',$request->id)->update(array_filter([
            'name'=>$request->name,
            'email'=>$request->email,
            'gender' => $request->gender,
            'phone' =>$request->phone,
            'password' => encrypt($request->password)
        ]));

        return redirect('profile/'.$request->id);
    }

}