<?php

namespace App;

use App\Transaction;
use App\Category;
use App\Seller;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{ 
    use SoftDeletes;
    const AVAILABLE_PRODUCT='available';
    const UNAVAILABLE_PRODUCT='unavailable';

    protected $dates = ['deleted_at'];
    protected $fillable =[
    'name','description',
    'quantity','status',
    'image','seller_id',];

    public $transformer = ProductTransformer::class;


    
  protected $hidden =[
    'pivot',
  ];

    public function isavailable(){
        return $this->status == Product::AVAILABLE_PRODUCT;
    }
    
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

}
