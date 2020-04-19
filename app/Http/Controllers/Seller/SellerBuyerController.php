<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;

class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $Buyers = $seller->products()
                      ->whereHas('transactions')
                      ->with('transactions.buyer')
                      ->get()
                      ->pluck('transactions')
                      ->collapse()
                      ->pluck('buyer')
                      ->unique('id')
                      ->values();

        return $this->showAll($Buyers);
    }
}