<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }


    public function addToCart($id){

        $productAdded= $this->cartService->addProductToCart($id);

        if($productAdded){
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


    
    // show all products in cart
    public function cartProducts(){
        return response()->json([
            'status'=>'success',
            'message'=> 'Cart viewed successfully',
            'data'=>CartResource::collection(Cart::orderByDesc('id')->get()),
        ]);
    }


    // Delete
    public function deleteProduct($id){
        Cart::where('id',$id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Cart deleted successfully',
        ]);
    }



    // increase
    public function increaseQuantity($id){

        $updatedCart=$this->cartService->increaseCartProduct($id);

        if(!$updatedCart){
            return response()->json([
                'status' => 'error',
                'message' => 'Product out of stock',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Selected product quantity incremented',
        ]);
    }
    //decrease
    public function decreaseQuantity($id){
        $this->cartService->decreaseCartProduct($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Selected product quantity decremented',
        ]);
    }
}
