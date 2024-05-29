<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDetailResource;
use App\Services\OrderDetailService;

class OrderDetailController extends Controller
{
    protected $orderDetailService;

    public function __construct(OrderDetailService $orderDetailService)
    {
        $this->orderDetailService = $orderDetailService;
    }

    public function showByOrder(string $orderId){
        $orderDetails= $this->orderDetailService->getOrderDetail($orderId);
        return response()->json([
            'status' => 'success',
            'message' => 'Orders Details viewed successfully',
            'data' => OrderDetailResource::collection($orderDetails),
        ]);
    }
}
