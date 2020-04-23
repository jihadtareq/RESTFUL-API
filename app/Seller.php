<?php

namespace App;

use App\Product;
use App\Transformers\SellerTransformer;
use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Model;

class Seller extends User
{  
    public $transformer = SellerTransformer::class;
    protected static function boot(){
        parent::boot();
        static::AddGlobalScope(new SellerScope);
    }
    public function products(){

        return $this->hasMany(Product::class);
        
    }
}
