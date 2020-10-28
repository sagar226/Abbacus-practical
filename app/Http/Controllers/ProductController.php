<?php

namespace App\Http\Controllers;

use App\Category;
use App\Core\Repositories\UserRepository;
use App\Product;
use App\User;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\CountValidator\Exact;

class ProductController extends Controller
{
    public function index()
    {
        return view('products');
    }
    public function products($item=4){
        $products=Product::with('category')->paginate($item);
        return $this->successResponse($products);
    }
    public function productForm()
    {
        $category=Category::where('status','active')->get();
        return view('productForm',['categories'=>$category]);
    }
    public function create(Request $request){
       
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'sku'=>'required',
            'desc'=>'required|string',
            'quantity'=>'required|numeric',
            'category_id'=>'required|exists:categories,id'
            ]);    

        if($validator->fails())   return view('productForm',['errors'=>$validator->errors(),'categories'=>Category::where('status','active')->get()]);  
       
            $products=Product::create([
                'name'=>$request->name,
                'sku'=>$request->sku,
                'desc'=>$request->desc,
                'quantity'=>$request->quantity,
                'category_id'=>$request->category_id,
                'image' => '/path.png'
            ]);

        return redirect('products');
    }
    public function getDetails($id){
        $validator = Validator::make(['id'=>$id],[
            'id'=>'required|exists:products,id'   
        ]);    

        if($validator->fails())   return redirect('products');

        $products=Product::where('id',$id)->first();
        $category=Category::where('status','active')->get();
        return view('productForm',['data'=>$products,'categories'=>$category]);
    }
    public function update(Request $request){

      $validator = Validator::make($request->all(),[
            'id'=>'required|exists:products,id'  ,
            'name'=>'nullable|string',
            'sku'=>'nullable',
            'desc'=>'nullable|string',
            'quantity'=>'nullable|numeric',
            'category_id'=>'nullable|exists:categories,id'
            ]);    

        if($validator->fails())   return view('productForm',['errors'=>$validator->errors(),'categories'=>Category::where('status','active')->get()]);  
       
       
            Product::where('id',$request->id)->update(array_filter([
                'name'=>$request->name,
                'sku'=>$request->sku,
                'desc'=>$request->desc,
                'quantity'=>$request->quantity,
                'category_id'=>$request->category_id,
                'image' => '/path.png'
            ]));

        return redirect('products');
    }
    public function delete($id){
        $validator = Validator::make(['id'=>$id],[
            'id'=>'required|exists:products,id'   
        ]);    

        if($validator->fails())   return redirect('products');

        $product=Product::where('id',$id)->delete();
        
        return redirect('products');
    }

}