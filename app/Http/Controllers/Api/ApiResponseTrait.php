<?php

namespace App\Http\Controllers\Api;


trait ApiResponseTrait
{
    public $paginateNumber = 10;
   public function apiResponse($data = null,  $message = null, int $code = 200 )
   {
       $array = [
        'data' => $data,
        'status' => in_array($code , $this->successCode()) ? true : false,
        'message' => $message
       ];
       return response($array, $code);
   }
   public function successCode()
   {
       return [200, 201, 202];
   }
   public function createdResponse($data)
   {
       return $this->apiResponse($data, 'Created Successfully' , 201);
   }
   public function notFoundResponse()
   {
    return $this->apiResponse(null, 'Not Found', 404);
   }
   public function unknownError()
   {
    return $this->apiResponse(null, 'Unknown Error', 520);
   }
   public function deleteResponse()
   {
       return $this->apiResponse(null, 'Deleted Successfully' , 200);
   }
}
