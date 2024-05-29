<?php

namespace App\Services;

use App\Models\OrderDetail;

class OrderDetailService
{
    public function getOrderDetail($orderId){
        $orderDetails = OrderDetail::leftJoin('products','products.id','=','order_details.product_id')
                        ->where('order_details.order_id',$orderId)
                        ->orderBy('order_details.id','DESC')
                        ->get(['products.name as product_name','products.code as product_code','products.photo as product_photo','order_details.*']);
        return $orderDetails;
    }
}