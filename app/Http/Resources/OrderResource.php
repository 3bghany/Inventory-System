<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id ,
            'customer_name' => $this->customer_name ,
            'customer_phone' => $this->customer_phone ,
            'customer_address' => $this->customer_address ,
            'quantity' => $this->quantity,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'payBy' => $this->payBy,
            'pay' => $this->pay,
            'due' => $this->due,
            'order_date' => $this->order_date,
            'order_month' => $this->order_month,
            'order_year' => $this->order_year,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
