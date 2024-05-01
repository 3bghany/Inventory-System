<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PosController extends Controller
{
    public function index()
    {   $products= DB::table('Products')
                        ->join('categories','Products.category_id','categories.id')
                        ->leftJoin('suppliers','Products.supplier_id','suppliers.id')
                        ->select('suppliers.name as supplier_name','categories.name as category_name','Products.*')
                        ->get();
        $products =$products->shuffle();
        return response()->json([
            'status' => 'success',
            'message' => 'All products viewed successfully',
            'data' => $products,
        ], 203);
    }

    public function AddOrder(Request $request){
        $validate = $request->validate([
            'payBy' => 'required',
            'customer_id' => 'required',
        ]);
        if(!($request->quantity)){
            return response()->json([
                'status' => 'error',
                'message' => 'There is no product added to order',
            ]);
        }
        $data = array();
        $data['customer_id']=$request->customer_id;
        $data['quantity']=$request->quantity;
        $data['sub_total']=$request->sub_total;
        $data['total']=$request->total	;
        $data['payBy']=$request->payBy;
        $data['pay']=$request->pay;
        $data['due']=$request->due;
        $data['order_date']= date('d/m/Y');
        $data['order_month']=date('F');
        $data['order_year']=date('Y');

        $order_id= DB::table('orders')->insertGetId($data);

        $cart= DB::table('P_O_S')->get();

        $order_data= array();
        foreach($cart as $order){
            $order_data['product_id']=$order->product_id;
            $order_data['order_id']=$order_id;
            $order_data['product_quantity']=$order->product_quantity;
            $order_data['product_price']=$order->product_price;
            $order_data['sub_total']=$order->sub_total;

            DB::table('order_details')->insert($order_data);
            DB::table('Products')->where('id',$order->product_id)->decrement('quantity',$order->product_quantity);
        }
        DB::table('P_O_S')->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order has been sold successfully',
        ], 203);
    }
}
