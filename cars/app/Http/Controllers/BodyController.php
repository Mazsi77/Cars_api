<?php

namespace App\Http\Controllers;

use App\Models\Body_type;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class BodyController extends Controller
{

    private function auth(String $token = null)
    {
        if($token == null){
            throw new Exception("Please use an api_token!");
        }

        $user = User::where('api_token', $token);
        
        if($user->count() == 0){
            throw new Exception("Api_token not found! Please use a valid token!");
        }

        return $user;
    }

    public function index()
    {
        try{
            $bodiesW = Body_type::with('model:id')->get();       
            $bodies = $bodiesW->map(function($body){
                return array(
                    'id' => $body['id'],
                    'name' => $body['name'],
                    'number_of_models' => $body['model']->count(),
                );
            });

            $result = [
                "success" => true,
                "total" => count($bodies),
                "fuel-types" => $bodies
            ];
            
            return response()->json($result);
        }catch(Throwable $e){
            $result = [
                "success" => false,
                "error" => $e->getMessage()
            ];

            return response()->json($result);
        }
    }
    public function getBody($id)
    {
        try{
            
            $body = Body_type::with(['model.brand:id,name'])->where('id', $id)->first();

            if(!$body){
                throw new Exception("Body not found with this id!");
            }

            
            $result = [
                "success" => true,
                "id" => $body['id'],
                "name" => $body['name'],
                "number_of_models" => $body['model']->count(),
                'models' => $body['model']->map(function($model){
                    return array([
                        "id" => $model['id'],
                        "brand_id" => $model['brand_id'],
                        "brand_name" => $model['brand']['name'],
                        "model_name" => $model['model_name'],
                        "start_year" => $model['start_year'],
                    ]);
                })
            ];
            
            return response()->json($result);
        }catch(Throwable $e){
            $result = [
                "success" => false,
                "error" => $e->getMessage()
            ];

            return response()->json($result);
        }
    }


    public function createBody(Request $request)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'seat_number' => 'required|digits_between:1,2|min:1',
            ]);
        
            if ($validator->fails()){
                $result = [
                    'success' => false,
                    'error' => "Wrong input data!",
                    'errors' => $validator->errors()->all()
                ];

                return response()->json($result);
            }

            $body = Body_type::create($request->all());

            $result = [
                'succes' => true,
                "id" => $body['id']
            ];

            return response()->json($result);

        }catch(Throwable $e){
            $result = [
                "success" => false,
                "error" => $e->getMessage()
            ];

            return response()->json($result);
        }
    }

    public function updateBody(Request $request, $id)
    {
        try{

            $user = $this->auth($request->input("api_token"));

             $body = Body_type::find($id);

            if(!$body){
                throw new Exception("Body not found with this id!");
            }

            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'seat_number' => 'digits_between:1,2|min:1',
            ]);
        
            if ($validator->fails()){
                $result = [
                    'success' => false,
                    'error' => "Wrong input data!",
                    'errors' => $validator->errors()->all()
                ];

                return response()->json($result);
            }

            Body_type::where('id', $id)->update($request->only(['name', 'seat_number']));

            $result = [
                'succes' => true,
                "id" => $id
            ];

            return response()->json($result);

        }catch(Throwable $e){
            $result = [
                "success" => false,
                "error" => $e->getMessage()
            ];

            return response()->json($result);
        }
    }
    
    public function deleteBody(Request $request, $id)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $body = Body_type::find($id);

            if(!$body){
                throw new Exception("Body not found!");
            }

            $body->delete();

            $result = [
                'succes' => true,
                "id" => $id
            ];

            return response()->json($result);

        }catch(Throwable $e){
            $result = [
                "success" => false,
                "error" => $e->getMessage()
            ];

            return response()->json($result);
        }
    }
}
