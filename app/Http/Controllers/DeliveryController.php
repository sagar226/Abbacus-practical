<?php

namespace App\Http\Controllers;

use App\Category;
use App\Core\Repositories\UserRepository;
use App\Delivery;
use App\Product;
use App\User;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\CountValidator\Exact;

class DeliveryController extends Controller
{
    public function index()
    {
        return view('delivery');
    }
    public function deliveries($item=5){
        $products=Delivery::paginate($item);
        return $this->successResponse($products);
    }

}