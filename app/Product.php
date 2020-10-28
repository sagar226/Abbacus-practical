<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id', 'name', 'sku','category_id','desc','quantity','image'
    ];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
}
