<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;


trait ApiResponser {

    private function successResponse($data, $code)
	{
		return response()->json($data, $code);
	}

    protected function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}


    protected function showAll(Collection $collection,$code = 200 ){

        if($collection->isEmpty()){
            return $this->successResponse(['data' => $collection],$code);
        }
         //first() to obtain the transformer directly from property
        $transformer = $collection->first()->transformer;

        $collection = $this->sortData($collection);

        $collection = $this->transformData($collection , $transformer); 
      return $this->successResponse( $collection ,$code);

    }
    
    protected function showOne(Model $instance,$code = 200 ){

       $transformer = $instance->transformer;

       $instance = $this->transformData($instance , $transformer);

       return $this->successResponse($instance,$code);

    }

    protected function showMessage ($message,$code = 200 ){

        return $this->successResponse(['data' => $message],$code);
 
     }

     protected function sortData( Collection $collection)
     {
        if (request()->has('sort_by')) {
            $attribute = request()->sort_by; // equal the value of sort_by request
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
     }
     /* it return an array so if we want to create a collection from dataArray it won't work in same way becuz 
     the transformation is an instance of php fractal class so wa have to use sort before transformDaTa*/  
     protected function transformData($data , $transformer){

      $transformation =fractal($data , $transformer);

      return $transformation->toArray();
     }
}