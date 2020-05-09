<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int)$transaction->id,
            'quantity' => (int)$transaction->quantity,
            'buyer' => (int)$transaction->buyer_id,
            'product' => (int)$transaction->product_id,
            'creationDate' => (string)$transaction->created_at,
            'lastChange' => (string)$transaction->updated_at,
            'deletedDate' => isset($transaction->deleted_at) ? (string) $transaction->deleted_at : null,

            'links' =>[
                [
                'rel' =>'self',
                'href'=>route('transactions.show',$transaction->id),
                ],
                [
                    'rel' =>'transaction.categories',
                    'href'=>route('transactions.categories.index',$transaction->id),
                ],
                [
                    'rel' =>'transaction.sellers',
                    'href'=>route('transactions.sellers.index',$transaction->id),
                ],
                [
                    'rel' =>'product',
                    'href'=>route('products.show',$transaction->product_id),
                ],
                [
                    'rel' =>'buyer',
                    'href'=>route('buyers.show',$transaction->buyer_id),
                ],
            ]
        ];
    }

    public static function originalAttributes($index){

        $attribute =[
            'identifier' => 'id',
            'quantity' => 'quantity',
            'buyer' => 'buyer',
            'product' => 'product',
            'creationDate' =>'created_at',
            'lastChange' =>'updated_at',
            'deletedDate' =>'deleted_at',

           
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null ;
    }
    
    public static function transformedAttribute($index){

        $attribute =[
             'id'=>'identifier',
             'quantity' => 'quantity',
             'buyer' => 'buyer',
             'product' => 'product',
             'created_at'=>'creationDate',
             'updated_at'=>'lastChange',
             'deleted_at'=>'deletedDate',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null ;
    }
}
