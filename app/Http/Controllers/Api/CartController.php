<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Models\POS;
use DB;
class CartController extends Controller
{
    public function AddToCart($id){
        $product=DB::table('products')->where('id',$id)->first();
        $inCart=DB::table('P_O_S')->where('product_id',$id)->first();

        if($product->quantity > 0){
            if($inCart){
                if($inCart->product_quantity == $product->quantity){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Product out of stock',
                    ]);
                }
                DB::table('P_O_S')->where('product_id',$id)->update(
                    ['product_quantity'=> ($inCart->product_quantity)+1,'sub_total'=> ($inCart->sub_total)+($inCart->product_price)]
                );
            }else{
                $data=array();
                $data['product_id']=$id;
                $data['product_name']=$product->name;
                $data['product_quantity']=1;
                $data['product_price']=$product->selling_price;
                $data['sub_total']=$product->selling_price;

            DB::table('P_O_S')->insert($data);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart',
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Product out of stock',
        ]);
    }


    
    // show all product in cart
    public function CartProducts(){
        return response()->json([
            'status'=>'success',
            'message'=> 'Cart viewed successfully',
            'data'=>CartResource::collection(POS::orderByDesc('id')->get()),
        ]);
    }


    // Delete
    public function DeleteProduct($id){
        DB::table('P_O_S')->where('id',$id)->delete();
    }



    // increase
    public function increaseQuantity($id){
        $inCart=DB::table('P_O_S')->where('id',$id)->first();
        $product=DB::table('products')->where('id',$inCart->product_id)->first();
        if($inCart->product_quantity >= $product->quantity){
            return response()->json([
                'status' => 'error',
                'message' => 'Product out of stock',
            ]);
        }
        DB::table('P_O_S')->where('id',$id)->increment('product_quantity');
        DB::table('P_O_S')->where('id',$id)->update(
            ['sub_total'=> ($inCart->sub_total)+($inCart->product_price)]
        );
    }
    //decrease
    public function decreaseQuantity($id){
        $inCart=DB::table('P_O_S')->where('id',$id)->first();
        if($inCart->product_quantity <= 1){
            DB::table('P_O_S')->where('id',$id)->delete();
        }
        DB::table('P_O_S')->where('id',$id)->decrement('product_quantity');
        DB::table('P_O_S')->where('id',$id)->update(
            ['sub_total'=> ($inCart->sub_total)-($inCart->product_price)]
        );
    }
}
