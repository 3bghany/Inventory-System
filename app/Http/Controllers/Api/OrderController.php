<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\Base64ImageDecoder;
use App\Http\Resources\OrderResource;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::leftJoin('customers','customers.id','=','orders.customer_id')
                            ->orderBy('orders.id','DESC')
                            ->get(['customers.name as customer_name','orders.*']);
        return response()->json([
            'status' => 'success',
            'message' => 'All Orders viewed successfully',
            'data' => OrderResource::collection($orders),
        ], 203);
    }



    public function TodayOrders(){
        $date=date('d/m/Y');
        
        $orders = Order::leftJoin('customers','customers.id','=','orders.customer_id')
        ->where('order_date',$date)
        ->orderBy('orders.id','DESC')
        ->get(['customers.name as customer_name','orders.*']);
        return response()->json([
            'status' => 'success',
            'message' => 'All Orders viewed successfully',
            'data' => OrderResource::collection($orders),
        ], 203);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orders = Order::leftJoin('customers','customers.id','=','orders.customer_id')
                        ->where('orders.id',$id)
                        ->orderBy('orders.id','DESC')
                        ->get(['customers.name as customer_name','customers.phone as customer_phone','customers.address as customer_address','orders.*']);
        return response()->json([
            'status' => 'success',
            'message' => 'Order viewed successfully',
            'data' => OrderResource::collection($orders),
        ], 203);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
