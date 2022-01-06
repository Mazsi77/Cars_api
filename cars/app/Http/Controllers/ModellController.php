<?php

namespace App\Http\Controllers;

use App\Models\Body_type;
use App\Models\Brand;
use App\Models\Fuel;
use App\Models\Model;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ModellController extends Controller
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
            $modelsW = Model::with('brand')->get();       
            $models = $modelsW->map(function($model){
                return array(
                    'id' => $model['id'],
                    'brand_id' => $model['brand_id'],
                    'brand_name' => $model['brand']['name'],
                    'model_name' => $model['model_name'],
                    'start_year' => $model['start_year']
                );
            });

            $result = [
                "success" => true,
                "total" => count($models),
                "models" => $models
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
    
    public function getModel($id)
    {
        try{
            
            $modelsW = Model::with(['brand:id,name', 'fuel:id,name', 'body:id,name'])->where('id', $id)->first();

            if($modelsW == null){
                throw new Exception('No model found with this id!');
            }
            
            $result = [
                "success" => true,
                "brand_id" => $modelsW['brand_id'],
                "brand_name" => $modelsW['brand']['name'],
                "model_name" => $modelsW['model_name'],
                "start_year" => $modelsW['start_year'],
                "last_year" => $modelsW['last_year'],
                "number_of_fuel_types" => $modelsW['fuel']->count(),
                "fuel_types" => $modelsW['fuel'],
                "number_of_body_types" => $modelsW['body']->count(),
                "body_types" => $modelsW['body']
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


    public function createModel(Request $request)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $validator = Validator::make($request->all(), [
                'model_name' => 'required|string',
                'brand_id' => 'required|integer',
                'start_year' => 'required|digits:4',
                'last_year' => 'required|digits:4|gte:start_year'
            ]);
        
            if ($validator->fails()){
                $result = [
                    'success' => false,
                    'error' => "Wrong input data!",
                    'errors' => $validator->errors()->all()
                ];

                return response()->json($result);
            }
            
            $brand = Brand::find($request->input('brand_id'));

            if($brand == null){
                throw new Exception("No brand found with this id!");
            }

            $model = Model::create($request->all());

            $result = [
                'succes' => true,
                "id" => $model['id']
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

    public function updateModel(Request $request, $id)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $modelA = Model::find($id);

            if($modelA == null){
                throw new Exception('No model found with this id!');
            }

            $model = $modelA->first();

            $validator = Validator::make($request->all(), [
                'model_name' => 'string',
                'brand_id' => 'integer',
                'start_year' => 'digits:4',
                'last_year' => 'digits:4'
            ]);

        
            if ($validator->fails()){
                $result = [
                    'success' => false,
                    'error' => "Wrong input data!",
                    'errors' => $validator->errors()->all()
                ];

                return response()->json($result);
            }

            if($request->input('brand_id') !== null){

                $brand = Brand::find($request->input('brand_id'));

                if($brand == null){
                    throw new Exception("No brand found with this id!");
                }
            }
            
            if($request->input('start_year') != null && $request->input('last_year') == null){
                if($request->input('start_year') > $model['last_year']){
                    throw new Exception("start_year can't be bigger than last_year!1");
                }
            }

            if($request->input('last_year') != null && $request->input('start_year') == null){
                if($request->input('last_year') < $model['start_year']){
                    throw new Exception("start_year can't be bigger than last_year!2");
                }
            }

            if($request->input('start_year') != null && $request->input('last_year') != null){
                if($request->input('start_year') > $request->input('last_year')){
                    throw new Exception("start_year can't be bigger than last_year!3");
                }
            }


            Model::where('id', $id)->update($request->only(['model_name', 'brand_id', 'start_year', 'last_year']));

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

    public function deleteModel(Request $request, $id)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $model = Model::find($id);

            if(!$model){
                throw new Exception("Model not found!");
            }

            $model->delete();

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

    //Adding fuel option to model_fuel table
    public function addFuel(Request $request, $modelId, $fuelId)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $model = Model::find($modelId);
            $fuel = Fuel::find($fuelId);

            if(!$model){
                throw new Exception("Model not found!");
            }

            if(!$fuel){
                throw new Exception("Fuel not found!");
            }

            $model->fuel()->syncWithoutDetaching($fuel);

            $result = [
                'succes' => true,
                'model_id' => $modelId,
                'fuel_id' => $fuelId
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

    public function removeFuel(Request $request, $modelId, $fuelId)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $model = Model::find($modelId);
            $fuel = Fuel::find($fuelId);

            if(!$model){
                throw new Exception("Model not found!");
            }

            if(!$fuel){
                throw new Exception("Fuel not found!");
            }

            $model->fuel()->detach($fuel);

            $result = [
                'succes' => true,
                'model_id' => $modelId,
                'fuel_id' => $fuelId
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

    public function addBody(Request $request, $modelId, $bodyId)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $model = Model::find($modelId);
            $body = Body_type::find($bodyId);

            if(!$model){
                throw new Exception("Model not found!");
            }

            if(!$body){
                throw new Exception("Body not found!");
            }

            $model->body()->syncWithoutDetaching($body);

            $result = [
                'succes' => true,
                'model_id' => $modelId,
                'fuel_id' => $bodyId
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

    public function removeBody(Request $request, $modelId, $bodyId)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $model = Model::find($modelId);
            $body = Body_type::find($bodyId);

            if(!$model){
                throw new Exception("Model not found!");
            }

            if(!$body){
                throw new Exception("Body not found!");
            }

            $model->body()->detach($body);

            $result = [
                'succes' => true,
                'model_id' => $modelId,
                'body_id' => $bodyId
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
