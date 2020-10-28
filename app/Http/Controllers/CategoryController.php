<?php

namespace App\Http\Controllers;

use App\Category;
use App\Core\Repositories\UserRepository;
use App\User;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\CountValidator\Exact;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category');
    }
    public function categories($item=4){
        $category=Category::paginate($item);
        return $this->successResponse($category);
    }
    public function categoryForm()
    {
        return view('categoryForm');
    }
    public function create(Request $request){
       
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'status'=>'required|in:active,inactive'
            ]);    

        if($validator->fails())   return view('categoryForm',['errors'=>$validator->errors()]);  
       
            $category=Category::create([
                'name'=>$request->name,
                'status'=>$request->status
            ]);

        return redirect('categories');
    }
    public function getDetails($id){
        $validator = Validator::make(['id'=>$id],[
            'id'=>'required|exists:categories,id'   
        ]);    

        if($validator->fails())   return redirect('categories');

        $category=Category::where('id',$id)->first();
        
        return view('categoryForm',['data'=>$category]);
    }
    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:categories,id',
            'name'=>'required|string',
            'status'=>'required|in:active,inactive'
            ]);    

        if($validator->fails())   return view('categoryForm',['errors'=>$validator->errors()]);  
       
            $category=Category::where('id',$request->id)->update([
                'name'=>$request->name,
                'status'=>$request->status
            ]);

        return redirect('categories');
    }
    public function delete($id){
        $validator = Validator::make(['id'=>$id],[
            'id'=>'required|exists:categories,id'   
        ]);    

        if($validator->fails())   return redirect('categories');

        $category=Category::where('id',$id)->delete();
        
        return redirect('categories');
    }

}