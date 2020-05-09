<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;


class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $transformer)
    {  
        $transformInput=[];

        //using request  attribut then request to obtain all the fields
        foreach ($request->request->all() as $input => $value) {
              $transformInput[$transformer::originalAttribute($input)] =$value; 
        }
        //replace the original request by the new one
        $request->replace($transformInput);

        $response = $next($request);

        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            //obtain data of response or error
            $data =$response->getData();

            $transformedError=[];
            
            //loop over every error
            foreach ($data->error as $field => $error) {
                $transformedField=$transformer::transformedAttribute($field);

                //replace original values by transformedvalues ,where we gonna replace that ? in $error
                $transformedError[$transformedField]=str_replace($field,$transformedField,$error);
            }

            $data->error=$transformedError;
            
            //specify the new data to the response
            $response->setData($data);
           
        }

       return $response;
    }
}
