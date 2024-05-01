<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "supplier_name"=> $this->supplier_name,
            "category_name"=> $this->category_name,
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'code' => $this->code,
            'root' => $this->root,
            'buying_price' => $this->buying_price,
            'selling_price' => $this->selling_price,
            'supplier_id' => $this->supplier_id,
            'buying_date' => $this->buying_date,
            'photo' => $this->photo,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
