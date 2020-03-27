<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\OrdersDetails;
class OrderController extends Controller
{
    //

    //get all order apply filter
    public function getOrder(Request $request){
        $OrderDetail = new OrdersDetails;
        $temp = $OrderDetail->with([
            'getvariant',
            'order'
            ])->get();
        
        return response($temp->toJson(JSON_PRETTY_PRINT), 200);
    }
    //get order per customer apply filter
    public function getCustomerOrder(Request $request, $id){

    }

    public function create(Request $request){
        $array = $request->all();
        $Order = new Orders;
        if(is_null($array['user_id']) || is_null($array['order_item']) || is_null($array['order_status']) || is_null($array['total_price']) || is_null($array['date_ordered'])){
            return response()->json([
                "Error" => "mandatory parameter harus di isi, lihat dokumentasi"
            ], 400);
        }else{
            if(preg_match("/[^a-zA-Z ]+/", $array['order_status'])){
                return response()->json([
                    "Error" => "order_status harus huruf, tidak boleh mengandung angka dan simbol"
                ], 400);
            }else{
                $input = strtolower($array['order_status']);
                $Order->order_status = $input;    
            }

            if(preg_match("/[^0-9]+/", $array['total_price'])){
                return response()->json([
                    "Error" => "total_price harus angka, tidak boleh ada huruf atau simbol"
                ], 400);
            }else{
                $input = strtolower($array['total_price']);
                $Order->total_price = $input;
            }

            $Order->user_id = $array['user_id'];
            $Order->date_ordered = $array['date_ordered'];
            
            $Order->save();
            foreach ($array['order_item'] as $item){
                $newItem = new OrdersDetails;
                if(is_null($item['qty_order']) || is_null($item['variants_id']) || is_null($item['on_cart']) || is_null($item['on_buy'])){
                    $deletedOrder = Orders::find($Order->id);
                    $deletedOrder->delete();
                    return response()->json([
                        "Error" => "parameter mandatory di order_item harus di isi",
                        "message" => "Orders telah dihapus ulang, submit ulang orders"
                    ], 400);
                }else{
                    if(preg_match("/[^0-9]+/", $item['qty_order'])){
                        $deletedOrder = Orders::find($Order->id);
                        $deletedOrder->delete();
                        return response()->json([
                            "Error" => "qty_order harus angka, tidak boleh ada huruf atau simbol"
                        ], 400);
                    }else{
                        $newItem->qty_order = $item['qty_order'];
                    }
                    
                    if(preg_match("/[^0-9]+/", $item['on_cart'])){
                        $deletedOrder = Orders::find($Order->id);
                        $deletedOrder->delete();
                        return response()->json([
                            "Error" => "on_cart harus angka, tidak boleh ada huruf atau simbol"
                        ], 400);
                    }else{
                        if($item['on_cart'] > 1){
                            return response()->json([
                                "Error" => "on_cart harus bernilai 1 atau 0"
                            ], 400);
                        }
                        $newItem->on_cart = $item['on_cart'];
                    }

                    if(preg_match("/[^0-9]+/", $item['on_buy'])){
                        $deletedOrder = Orders::find($Order->id);
                        $deletedOrder->delete();
                        return response()->json([
                            "Error" => "on_buy harus angka, tidak boleh ada huruf atau simbol"
                        ], 400);
                    }else{
                        if($item['on_buy'] > 1){
                            return response()->json([
                                "Error" => "on_buy harus bernilai 1 atau 0"
                            ], 400);
                        }
                        $newItem->on_buy = $item['on_buy'];
                    }
                    $newItem->variants_id = $item['variants_id'];
                    $newItem->orders_id = $Order->id;
                    $newItem->save();
                }

            }

            return response()->json([
                "Message" => "Order Created"
            ], 200);
        }

    } 
}
