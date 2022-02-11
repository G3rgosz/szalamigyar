<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;

class ProductController extends BaseController{
    public function index(){
        $product = Product::all();
        return $this->sendResponse( ProductResource::collection($product),"Termékek betöltve" );
    }
    public function store(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            "name" => "required",
            "price_kg" => "required",
            "material" => "required",
            "production_time" => "required"
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $product = Product::create($input);
        return $this->sendResponse(new ProductResource($product), "Termék hozzáadava");
    }
    public function show($id){
        $product = Product::find($id);
        if( is_null($product)){
            return $this->sendError("Nincs ilyen termék");
        }
        return $this->sendResponse(new ProductResource($product), "Termék betöltve");
    }
    public function update(Request $request, Product $product ) {
        $input = $request->all();
        $validator = Validator::make($input, [
            "name" => "required",
            "price_kg" => "required",
            "material" => "required",
            "production_time" => "required"
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $product->name = $input["name"];
        $product->price_kg = $input["price_kg"];
        $product->material = $input["material"];
        $product->production_time = $input["production_time"];
        $product->save();
        return $this->sendResponse(new ProductResource($product), "Termék adatai módosítva");
    }
    public function destroy(Product $product){
        $product->delete();
        return $this->sendResponse( [], "Termék törölve");
    }
}
