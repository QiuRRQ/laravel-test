<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

class CategoryController extends Controller
{
    //

    public function index(Request $request){
        $category = Category::get()->toJson(JSON_PRETTY_PRINT);
        return response($category, 200);
    }

    public function create(Request $request){
        if(isset($request->name)){
            $category = new Category;
            if(preg_match("/[^a-zA-Z ]+/", $request->name)){
                return response()->json([
                    "message" => "name harus huruf"
                ], 400);
            }else{
                $input = strtolower($request->name);
                $category->name = $input;    
            }
            
            if(isset($request->parent_id)){
                if(preg_match("/[^0-9]+/", $request->parent_id)){
                    return response()->json([
                        "message" => "parent_id harus angka"
                    ], 400);
                }else{
                    $input = strtolower($request->parent_id);
                    $category->parent_id = $input;
                }
            }
            $category->save();

            return response()->json([
                "message" => "category inserted"
            ], 201);
        }else{
            return response()->json([
                "message" => "name adalah parameter mandatory"
            ], 400);
        }
        
    }

    public function destroy($id){
        $category = Category::find($id);
        $category->delete();

        return response()->json([
            "message" => "delete item success"
        ], 202);
    }

    public function show(Request $request, $id){
        if(Category::where('id', $id)->exists()){
            $category = Category::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);

            return response($category, 200);
        }else{
            return response()->json([
                "message" => "category not found"
            ], 404);
        }
    }

    public function update(Request $request, $id){
        if(Category::where('id', $id)->exists()){

            $category = Category::find($id);
            

            if(is_null($request->name)){
                $category->name = $category->name;
            }else{
                if(preg_match("/[^a-zA-Z ]+/", $request->name)){
                    return response()->json([
                        "message" => "name harus huruf"
                    ], 400);
                }else{
                    $input = strtolower($request->name);
                    $category->name = $input;    
                }
            }
            
            if(isset($request->parent_id)){
                if(is_null($request->parent_id)){
                    $category->parent_id = $category->parent_id;
                }else{
                    if(preg_match("/[^0-9]+/", $request->parent_id)){
                        return response()->json([
                            "message" => "parent_id harus angka"
                        ], 400);
                    }else{
                        $input = strtolower($request->parent_id);
                        $category->parent_id = $input;
                    }
                }
                
            }
            
            $category->save();
            
            return response()->json([
                "message" => "update success"
            ], 200);
        }else{
            return response()->json([
                "message" => "failed to update"
            ], 400);
        }
    }

}
