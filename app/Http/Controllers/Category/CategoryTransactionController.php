<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $transactions = $category->products()->whereHas('transactions') //need only the products has at least one trans
                       ->with('transactions')
                       ->get()->pluck('transactions')
                       ->collapse();
        return $this->showAll($transactions);
    }

}
