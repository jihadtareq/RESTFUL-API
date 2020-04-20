<?php

namespace App;

use App\Transaction;
use App\Category;
use App\Seller;
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

    
  protected $hidden =[
    'pivot',
  ];

    public function isavailable(){
        return $this->status == Product::AVAILABLE_PRODUCT;
    }

    public function isUnavailable(){
        return $this->status == Product::unavailable;
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
