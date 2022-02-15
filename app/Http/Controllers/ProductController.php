<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController{
    public function index(){
        $product = DB::table('products')
            ->join('materials', 'products.mid', '=', 'materials.id')
            ->select('products.id', 'name', 'price_kg', 'material', 'production_time', 'created_at','updated_at')
            ->get();
        return $this->sendResponse( $product, "Termékek betöltve" );
    }
    public function create(Request $request){
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
        $material = $input["material"];
        $mid = DB::table('materials')
            ->select('id')
            ->where('material', '=', $material)
            ->get();
        $counter = count($mid);
        if($counter==0){
            return $this->sendError("Nincs ilyen alapanyag");
        }
        try {
            $product = Product::create([
                'name' => $input["name"],
                'price_kg' =>  $input["price_kg"],
                'mid' =>  $mid[0]->id,
                'production_time' =>  $input["production_time"]
            ]);
            return $this->sendResponse(new ProductResource($product), "Termék hozzáadava");
        } catch (\Throwable $e) {
            return $this->sendError("Hiba a kiírás során", $e);
        }
    }
    public function show($id){
        $test = Product::find($id);
        if( is_null($test)){
            return $this->sendError("Nincs ilyen termék");
        }
        $product = DB::table('products')
            ->join('materials', 'products.mid', '=', 'materials.id')
            ->select('products.id', 'name', 'price_kg', 'material', 'production_time', 'created_at','updated_at')
            ->where('products.id', '=', $id)
            ->get();
        return $this->sendResponse( $product, "Termék betöltve");
    }
    public function update(Request $request, $id ) {
        $product = Product::find($id);
        if( is_null($product)){
            return $this->sendError("Nincs ilyen termék");
        }
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
        $material = $input["material"];
        $mid = DB::table('materials')
            ->select('id')
            ->where('material', '=', $material)
            ->get();
        $counter = count($mid);
        if($counter==0){
            return $this->sendError("Nincs ilyen alapanyag");
        }
        try {
            $product->name = $input["name"];
            $product->price_kg = $input["price_kg"];
            $product->mid =  $mid[0]->id;
            $product->production_time = $input["production_time"];
            $product->save();
            return $this->sendResponse(new ProductResource($product), "Termék módosítva");
        } catch (\Throwable $e) {
            return $this->sendError("Hiba a kiírás során", $e);
        }
    }
    public function search($name){
        $product = DB::table('products')
            ->join('materials', 'products.mid', '=', 'materials.id')
            ->select('products.id', 'name', 'price_kg', 'material', 'production_time', 'created_at','updated_at')
            ->where('name', 'like', '%'.$name.'%')
            ->get();
        if(count($product)==0){
            return $this->sendError("Nincs találat a keresésre");
        }
        return $this->sendResponse($product, "Keresési találatok betöltve");
    }
    public function filter($material){
        $product = DB::table('products')
            ->join('materials', 'products.mid', '=', 'materials.id')
            ->select('products.id', 'name', 'price_kg', 'material', 'production_time', 'created_at','updated_at')
            ->where('materials.material', '=', $material)
            ->get();
        if(count($product)==0){
            return $this->sendError("Nincs találat a szűrésre");
        }
        return $this->sendResponse($product, "Szűrési találatok betöltve");
    }
    public function destroy($id){
        $product = Product::find($id);
        if( is_null($product)){
            return $this->sendError("Nincs ilyen termék");
        }
        Product::destroy($id);
        return $this->sendResponse( [], "Termék törölve");
    }
}
