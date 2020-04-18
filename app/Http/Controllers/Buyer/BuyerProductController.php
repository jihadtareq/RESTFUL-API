<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
      //$products = $buyer->$transactions->product; 
      /*it does not work because the relation is 1 to M 
      so there are many transaction (collection) and product not in collection*/

      $products = $buyer->transactions()->with('product')
                  ->get()
                  ->pluck('product'); 

      return $this->showAll($products);
    }

}
