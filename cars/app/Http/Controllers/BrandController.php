<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Model;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class BrandController extends Controller
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
            $brands = Brand::select('id', 'name')->get();
            $result = [
                "success" => true,
                "total" => count($brands),
                "brands" => $brands
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

    public function getBrand($id)
    {
        try{
            $brand = Brand::find($id);
            if(!$brand){
                throw new Exception("Brand not found with this id!");
            }
            $models = Model::select('id', 'model_name', 'start_year')->where('brand_id', $brand['id'])->get();
            $result = [
                "success" => true,
                "name" => $brand['name'],
                "country" => $brand['country'],
                "logo" => $brand['logo'],
                "number_of_models" => count($models),
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

    

    public function createBrand(Request $request)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'country' => 'required|string',
                'logo' => 'required|url',
            ]);
        
            if ($validator->fails()){
                $result = [
                    'success' => false,
                    'error' => "Wrong input data!",
                    'errors' => $validator->errors()->all()
                ];

                return response()->json($result);
            }

            $brand = Brand::create($request->all());

            $result = [
                'succes' => true,
                "id" => $brand['id']
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

    public function updateBrand(Request $request, $id)
    {
        try{

            $user = $this->auth($request->input("api_token"));

             $brand = Brand::find($id);

            if(!$brand){
                throw new Exception("Brand not found with this id!");
            }

            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'country' => 'string',
                'logo' => 'url',
            ]);
        
            if ($validator->fails()){
                $result = [
                    'success' => false,
                    'error' => "Wrong input data!",
                    'errors' => $validator->errors()->all()
                ];

                return response()->json($result);
            }

            Brand::where('id', $id)->update($request->only(['name', 'country', 'logo']));

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

    public function deleteBrand(Request $request, $id)
    {
        try{

            $user = $this->auth($request->input("api_token"));

            $brand = Brand::find($id);

            if(!$brand){
                throw new Exception("Brand not found!");
            }

            $brand->delete();

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
