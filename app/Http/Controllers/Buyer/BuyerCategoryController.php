<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $sellers = $buyer->transactions()->with('product.categories')
            ->get()
            ->pluck('product.categories')
            ->collapse() //will create a unique list with serveral lists
            ->unique('id')
            ->values();

        return $this->showAll($sellers);
    }
   
}
