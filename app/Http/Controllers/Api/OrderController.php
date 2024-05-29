<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Product;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;

use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->orderService->getOrders();

        return response()->json([
            'status' => 'success',
            'message' => 'All Orders viewed successfully',
            'data' => OrderResource::collection($orders),
        ]);
    }



    public function todayOrders()
    {
        $orders = $this->orderService->getTodayOrders();

        return response()->json([
            'status' => 'success',
            'message' => 'All Orders viewed successfully',
            'data' => OrderResource::collection($orders),
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = $this->orderService->getOrder($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Order viewed successfully',
            'data' => OrderResource::collection($order),
        ]);
    }

    public function store(StoreOrderRequest $request){

        $order=$this->orderService->insertOrder($request);

        if($order)
            return response()->json([
                'status' => 'success',
                'message' => 'Order has been sold successfully',
                'order'=> new OrderResource($order),
            ]);
        
        return response()->json([
            'status' => 'error',
            'message' => 'You didn\'t select product to order',
        ]);

    }

}
