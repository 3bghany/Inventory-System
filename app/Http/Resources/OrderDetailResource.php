<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'product_id' => $this->product_id ,
            'product_name' => $this->product_name,
            'product_code' => $this->product_code,
            'product_photo' => $this->product_photo,
            'order_id' => $this->order_id,
            'product_quantity' => $this->product_quantity,
            'product_price' => $this->product_price,
            'sub_total' => $this->sub_total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
