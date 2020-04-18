<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $sellers = $buyer->transactions()
                   ->with('product.seller')
                   ->get()
                   ->pluck('product.seller')
                   ->unique('id') // if there is any repeat id unique method would remove it and without empty one
                   ->values(); //create index for a collection
        return $this->showAll($sellers);           
    }  
}
