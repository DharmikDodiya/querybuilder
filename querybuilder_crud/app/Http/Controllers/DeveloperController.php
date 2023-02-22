<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Developer as DeveloperResource;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ErrorMessage;
use Exception;

class DeveloperController extends BaseController
{
    use ErrorMessage;
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required',
            'position' => 'required',
            'technology' => 'required',
            'salary' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());  
            return $this->ErrorResponse($data);     
        }
        else{
            DB::table('developers')->insert($data);
                
                return response()->json([
                'status' => 200,
                'message' => 'developer created',
                'data' => $data
            ]);
        }
    }

    public function show($id)
    {
        $developer = DB::table('developers')->find($id);
        if (is_null($developer)) {
            return $this->DataNotFound();
        }
        else{
            return response()->json([
                'status' => 200,
                'message' => 'developer Data',
                'data' => $developer
            ]);
        }
    }

    public function index()
    {   
        
        $developer = DB::table('developers')->orderBy('id','desc')->get();
        return response()->json([
            'status' => '200',
            'message' => 'All Record Are Dispaly',
            'Data' => $developer,
        ]);

    }

    public function destroy($id){
        $developer = DB::table('developers')->where('id',$id)->delete();

        if($developer==0){
                return $this->DataNotFound();
        }
        else{
            return response()->json([
            'status' => 200,
            'message' => 'Data Deleted Successfully',
        ]);
        }
    }

    public function update(Request $request,$id){
        try{
        $data = $request->all();
        $validateData = Validator::make($data, [
            'name' => 'required',
            //'email' => 'required|email',
            'position' => 'required',
            'technology' => 'required',
            'salary' => 'required'
        ]);

        if($validateData->fails()){
            $error = $this->ErrorResponse($validateData);
            return $error;    
        }
        else{
            DB::table('developers')->where('id',$id)->update($data);
            return response()->json([
                'status' => 200,
                'message' => 'Data Updated Successfully',
                'data' => $data
            ]);
        }
    }
    catch(Exception $ex){
        return $this->SQLError($ex);
    }
    }





}
