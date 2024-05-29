<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Product;

class OrderService
{
    public function getOrders(){
        $orders = Order::leftJoin('customers','customers.id','=','orders.customer_id')
                            ->orderBy('orders.id','DESC')
                            ->get(['customers.name as customer_name','orders.*']);

        return $orders;
    }
    public function getTodayOrders(){
        $date=date('d/m/Y');

        $orders = Order::leftJoin('customers','customers.id','=','orders.customer_id')
                        ->where('order_date',$date)
                        ->orderBy('orders.id','DESC')
                        ->get(['customers.name as customer_name','orders.*']);

        return $orders;
    }

    public function getOrder($id){
        $order = Order::leftJoin('customers','customers.id','=','orders.customer_id')
                        ->where('orders.id',$id)
                        ->orderBy('orders.id','DESC')
                        ->get(['customers.name as customer_name','customers.phone as customer_phone','customers.address as customer_address','orders.*']);
        return $order;
    }

    public function insertOrder(Request $request){

        if(!($request->quantity)){
            return false;
        }
        $order=new Order;
        $order->customer_id =$request->customer_id;
        $order->quantity =$request->quantity;
        $order->sub_total =$request->sub_total;
        $order->total =$request->total;
        $order->payBy =$request->payBy;
        $order->pay =$request->pay;
        $order->due =$request->due;
        $order->order_date =date('d/m/Y');
        $order->order_month =date('F');
        $order->order_year =date('Y');
        $order->save();

        $cart= Cart::all();

        foreach($cart as $product){
            $order_data= new OrderDetail;
            $order_data->product_id=$product->product_id;
            $order_data->order_id=$order->id;
            $order_data->product_quantity=$product->product_quantity;
            $order_data->product_price=$product->product_price;
            $order_data->sub_total=$product->sub_total;

            $order_data->save();
            Product::where('id',$product->product_id)->decrement('quantity',$product->product_quantity);
        }
        Cart::truncate();

        return $order;
    }
    
}