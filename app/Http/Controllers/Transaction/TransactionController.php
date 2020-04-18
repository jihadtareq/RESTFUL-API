<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
    public function index()
    {
      $Transactions =Transaction::all();
      
      return $this->showAll($Transactions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $Transaction)
    {
        return $this->showOne($Transaction);
    }

}
