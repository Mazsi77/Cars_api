<?php

namespace App\Http\Controllers;

use App\Models\Fuel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class FuelController extends Controller
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
            $fuelsW = Fuel::with('model:id')->get();       
            $fuels = $fuelsW->map(function($fuel){
                return array(
                    'id' => $fuel['id'],
                    'name' => $fuel['name'],
                    'number_of_models' => $fuel['model']->count(),
                );
            });

            $result = [
                "success" => true,
                "total" => count($fuels),
                "fuel-types" => $fuels
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

    public function getFuel($id)
    {
        try{
            
            $fuelW = Fuel::with(['model.brand:id,name'])->where('id', $id)->first();

            if(!$fuelW){
                throw new Exception("Fuel not found with this id!");
            }
            
            $result = [
                "success" => true,
                "id" => $fuelW['id'],
                "name" => $fuelW['name'],
                "number_of_models" => $fuelW['model']->count(),
                'models' => $fuelW['model']->map(function($model){
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

    public function createFuel(Request $request)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);
        
            if ($validator->fails()){
                $result = [
                    'success' => false,
                    'error' => "Wrong input data!",
                    'errors' => $validator->errors()->all()
                ];

                return response()->json($result);
            }

            $fuel = Fuel::create($request->all());

            $result = [
                'succes' => true,
                "id" => $fuel['id']
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

    public function updateFuel(Request $request, $id)
    {
        try{

            $user = $this->auth($request->input("api_token"));

             $fuel = Fuel::find($id);

            if(!$fuel){
                throw new Exception("Fuel not found with this id!");
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);
        
            if ($validator->fails()){
                $result = [
                    'success' => false,
                    'error' => "Wrong input data!",
                    'errors' => $validator->errors()->all()
                ];

                return response()->json($result);
            }

            Fuel::where('id', $id)->update($request->only(['name']));

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
    
    public function deleteFuel(Request $request, $id)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $fuel = Fuel::find($id);

            if(!$fuel){
                throw new Exception("Fuel not found!");
            }

            $fuel->delete();

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
