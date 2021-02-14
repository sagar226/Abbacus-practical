<?php

namespace App\Http\Controllers;

use App\Category;
use App\DeliveryData;
use App\Imports\DeliveryImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category');
    }

    public function uploader(Request $request){
        
        $unique=$this->downloadFile($request->file);
        $path=config('filesystems.disks.local.url');
        $url=$path.'/'.$unique;
        
        Excel::import(new DeliveryImport,$url);
     
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