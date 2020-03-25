<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Variants;
use DB;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    //
    /*
        mandatory parameter untuk add product :
            - name, description, category_id, brand_id
        mandatory parameter untuk add variant :
            - color, size, stock, price, product_id, disabled
        mandatory parameter untuk add product dan variantnya bersamaan :
            - name, description, category_id, brand_id, color, size, stock, price, disabled
    */
    public function create(Request $request){
        $product = new Products;
        $variant = new Variants;
        $product_added = false;

        //$request->product_id parameter ini akan di isi jika dia ingin menambah variant saja.
        //akan kosong jika dia menambah product baru dan variant terhadap product baru tersebut.
        if(isset($request->color) && isset($request->size) && isset($request->stock) && isset($request->price) && isset($request->disabled)){
            //add variant too

            
            if(isset($request->name) && isset($request->description) && isset($request->category_id) && isset($request->brand_id)){

                if(preg_match("/[^a-zA-Z ]+/", $request->name)){
                    return response()->json([
                        "message" => "name harus huruf"
                    ], 400);
                }else{
                    $input = strtolower($request->name);
                    $product->name = $input;
                }
                if(preg_match("/[^a-zA-Z0-9 ]+/", $request->description)){
                    return response()->json([
                        "message" => "description tidak boleh mengandung angka ataupun simbol"
                    ], 400);
                }else{
                    $input = strtolower($request->description);
                    $product->description = $input;
                }
                
                $product->category_id = $request->category_id;
                $product->brand_id = $request->brand_id;

                $product->save(); // save product lebih dulu untuk dapatkan product id nya
                $product_added = true;
            }
            
            if(preg_match("/[^a-zA-Z]+/", $request->color)){
                
                return response()->json([
                    "message" => "color harus memakai huruf"
                ], 400);
            }else{
                $input = strtolower($request->color);
                $variant->color = $input;
            }
            
            if(preg_match("/[^a-zA-Z]+/", $request->size)){
                
                return response()->json([
                    "message" => "size tidak boleh kombinasi angka dan huruf ataupun simbol"
                ], 400);
            }else{
                $input = strtolower($request->size);
                $variant->size = $input;
            }

            if(preg_match("/[^0-9]+/", $request->stock)){
                
                return response()->json([
                    "message" => "stock harus angka"
                ], 400);
            }else{
                $input = strtolower($request->stock);
                $variant->stock = $input;
            }
            
            if(preg_match("/[^0-9]+/", $request->price)){
                
                return response()->json([
                    "message" => "price harus angka"
                ], 400);
            }else{
                $input = strtolower($request->price);
                $variant->price = $input;
            }

            if(isset($request->products_id)){
                $variant->products_id = $request->products_id; //ini akan diset saat product id di kasih param berarti dia hanya mau menambah variant saja
            }else{
                $variant->products_id = $product->id; // dia akan ambil product id yang barusan dibikin
            }
            $variant->disabled = $request->disabled;

            $variant->save();

            if($product_added){
                return response()->json([
                    "message" => "product dan variant baru berhasil ditambahkan"
                ], 201);
            }else{
                return response()->json([
                    "message" => "variant baru berhasil ditambahkan"
                ], 201);
            }
            
        }else{
            // add product only
            
            if(preg_match("/[^a-zA-Z ]+/", $request->name)){
                return response()->json([
                    "message" => "name harus huruf"
                ], 400);
            }else{
                $input = strtolower($request->name);
                $product->name = $input;
            }
            if(preg_match("/[^a-zA-Z0-9 ]+/", $request->description)){
                return response()->json([
                    "message" => "description tidak boleh mengandung angka ataupun simbol"
                ], 400);
            }else{
                $input = strtolower($request->description);
                $product->description = $input;
            }
            
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            
            $product->save();
            return response()->json([
                "message" => "product baru berhasil ditambahkan"
            ], 201);
        }
    }

    public function product_update(Request $request, $id){
        if(Products::where('id', $id)->exists()){
            $product = Products::find($id);
            
            if(is_null($request->name)){
                $product->name = $product->name;
            }else{
                if(preg_match("/[^a-zA-Z ]+/", $request->name)){
                    return response()->json([
                        "message" => "name harus huruf"
                    ], 400);
                }else{
                    $input = strtolower($request->name);
                    $product->name = $input;
                }
            }
            if(is_null($request->description)){
                $product->description = $product->description;
            }else{
                if(preg_match("/[^a-zA-Z0-9 ]+/", $request->description)){
                    return response()->json([
                        "message" => "description tidak boleh mengandung angka ataupun simbol"
                    ], 400);
                }else{
                    $input = strtolower($request->description);
                    $product->description = $input;
                }
            }
            
            $product->category_id = is_null($request->category_id) ? $product->category_id : $request->category_id;
            $product->brand_id = is_null($request->brand_id) ? $product->brand_id : $request->brand_id;
            $product->save();
            
            return response()->json([
                "message" => "update product success"
            ], 200);
        }else{
            return response()->json([
                "message" => "failed to update"
            ], 400);
        }
    }

    public function variant_destroy($id){
        if(Variants::where('id', $id)->exists()){
            $variant = Variants::find($id);
            $variant->delete();

            return response()->json([
                "message" => "delete variant item success"
            ], 202);
        }else{
            return response()->json([
                "message" => "delete failed your item not found"
            ], 400);
        }
    }

    public function getProductBy(Request $request){
        $product = new Products;
        $variant = new Variants;
        if(isset($request->product_id)){
            $temp = $product->with(['brand', 'category', 'variant'])->find($request->product_id);
        }else if(isset($request->name)){
            $temp = $product->with(['brand', 'category', 'variant'])->where('name', '=', $request->name)->get();
        }else{
            $temp = $product->with([
                'brand',
                'category' => function($q){
                    if(isset($request->category))
                        $q->where('name', '=', $request->category);
                }, 
                'variant' => function($query){ //ini akan memfilter variant yang di tampilkan pada produk. jadi hanya variant yang lolos filter yang akan ditampilkan.
                    $query->where('disabled', '!=', 1);
                    $query->where('stock', '!=', 0);
                    if(isset($request->price_min) || isset($request->price_max) && $request->price_min < $request->price_max){
                        $query->where('price', '>=', $request->price_min);
                        $query->where('price', '<=', $request->price_max);
                    }
                }
                ])->whereHas('variant')//ini akan menampilkan product yang setidaknya memiliki 1 variant. filter terhadap bariant 
                                        //yang akan ditampilkan, tak bisa digunakan disini. ini hanya akan memfilter produk berdasarkan variant
                
                ->get();
        }
        
        return response($temp->toJson(JSON_PRETTY_PRINT), 200);
    }
}
