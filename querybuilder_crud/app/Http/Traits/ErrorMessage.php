<?php


namespace App\Http\Traits;
use App\Http\Controllers\UserController;
use Illuminate\Support\Str;

trait ErrorMessage{
    public function ErrorResponse($validateUser){
        return response()->json([
            'status' => 403,
            'message' => 'validation error',
            'errors' => $validateUser->errors()
        ], 403);
    }

    public function DataNotFound(){
        return response()->json([
            'status' => 404,
            'message' => 'Data Not Found'
        ],401);
    }

    public function SQLError($ex){
        $status = Str::contains($ex->getMessage(),'Duplicate entry');
        if($status){
            return response()->json([
                'message' => 'duplicate Email Entry Please Enter any Other Emailid',
                'status' => 402,
            ],402);
        }
        else{
            return response()->json([
                'message' => $ex->getMessage(),
                'status' => 404,
            ],404);
        }
    }
}
?>