<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order_details;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\Base64ImageDecoder;
use App\Http\Resources\OrderDetailsResource;
use DB;
class OrderDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order_details::leftJoin('products','products.id','=','order_details.product_id')
                        ->orderBy('order_details.id','DESC')
                        ->get(['products.name as product_name','products.code as product_code','products.photo as product_photo','order_details.*']);
        return response()->json([
            'status' => 'success',
            'message' => 'Orders Details viewed successfully',
            'data' => OrderDetailsResource::collection($orders),
        ], 203);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orders = Order_details::leftJoin('products','products.id','=','order_details.product_id')
                        ->where('order_details.id',$id)
                        ->orderBy('order_details.id','DESC')
                        ->get(['products.name as product_name','products.code as product_code','products.photo as product_photo','order_details.*']);
        return response()->json([
            'status' => 'success',
            'message' => 'Orders Details viewed successfully',
            'data' => OrderDetailsResource::collection($orders),
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

    public function showByOrder(string $orderId){
        $orders = Order_details::leftJoin('products','products.id','=','order_details.product_id')
                        ->where('order_details.order_id',$orderId)
                        ->orderBy('order_details.id','DESC')
                        ->get(['products.name as product_name','products.code as product_code','products.photo as product_photo','order_details.*']);
        return response()->json([
            'status' => 'success',
            'message' => 'Orders Details viewed successfully',
            'data' => OrderDetailsResource::collection($orders),
        ], 203);
    }
}
