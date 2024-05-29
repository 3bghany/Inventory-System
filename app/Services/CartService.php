<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public function addProductToCart($id){
        $product=Product::where('id',$id)->first();
        $inCart=Cart::where('product_id',$id)->first();

        if($product->quantity > 0){
            if($inCart){
                if($inCart->product_quantity == $product->quantity){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Product out of stock',
                    ]);
                }
                Cart::where('product_id',$id)->update(
                    ['product_quantity'=> ($inCart->product_quantity)+1,'sub_total'=> ($inCart->sub_total)+($inCart->product_price)]
                );
            }else{
                $data=new Cart;
                $data->product_id=$id;
                $data->product_name=$product->name;
                $data->product_quantity=1;
                $data->product_price=$product->selling_price;
                $data->sub_total=$product->selling_price;

            $data->save();
            }
            return true;
        }
        return false;
    }

    public function increaseCartProduct($id){

        $inCart=Cart::where('id',$id)->first();
        $product=Product::where('id',$inCart->product_id)->first();
        if($inCart->product_quantity >= $product->quantity){

            return false;

        }

        Cart::where('id',$id)->increment('product_quantity');
        Cart::where('id',$id)->update(
            ['sub_total'=> ($inCart->sub_total)+($inCart->product_price)]
        );

        return true;
    }

    public function decreaseCartProduct($id){
        $inCart=Cart::where('id',$id)->first();
        if($inCart->product_quantity <= 1){
            $inCart->delete();
        }else{
            $inCart->product_quantity--;
            $inCart->sub_total-=($inCart->product_price);
            $inCart->save();
        }
    }
}