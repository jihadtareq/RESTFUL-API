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

        $collection = $this->filterData($collection ,$transformer);
        $collection = $this->sortData($collection ,$transformer);

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
      /* this method filter data which it makes request on any query 
      that recieve then we go through every paramter we will recieve one by one 
      then wa gonna obtain original attribute from that
      query paramter if it exists and obtain the val
      then make sure that attribute(not null) and value(not empty or null)
      are exist then filter collection depend on this */
    protected function filterData(Collection $collection ,$transformer){

        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::originalAttributes($query);
            if(isset($attribute,$value)){
             $collection = $collection->where($attribute,$value);
            }
        }

        return $collection;

    }   

    protected function sortData( Collection $collection , $transformer)
     {
        if (request()->has('sort_by')) {
            $attribute = $transformer::originalAttributes(request()->sort_by); // equal the value of sort_by request
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
     }
     /* it return an array so if we want to create a collection from dataArray it won't work in same way becuz 
     the transformation is an instance of php fractal class so wa have to use sort before transformDaTa*/ 

     /* this method would recieve tha data and the expected transform to be use */ 
     protected function transformData($data , $transformer){

      $transformation =fractal($data , new $transformer);

      return $transformation->toArray();
     }
}