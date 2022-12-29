<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'category_id'   => $this->category_id,
            'SKU'           => (string)$this->SKU,
            'name'          => (string)$this->name,
            'qty'           => $this->qty,
            'qty_type'      => (string)$this->qty_type,
            'market_price'  => (string)$this->market_price,
            'regular_price' => (string)$this->regular_price,
            'content'       => (string)$this->content,
            'image'         => !empty($this->image) ? url(config('app.product_image').'/'.$this->image) : '',
        ];
    }
}
