<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($data) {
            return [
                'id'            => $data->id,
                'category_id'   => $data->category_id,
                'SKU'           => (string)$data->SKU,
                'name'          => (string)$data->name,
                'qty'           => $data->qty,
                'qty_type'      => (string)$data->qty_type,
                'market_price'  => (string)$data->market_price,
                'regular_price' => (string)$data->regular_price,
                'content'       => (string)$data->content,
                'image'         => !empty($data->image) ? url(config('app.product_image').'/'.$data->image) : '',
            ];
        });
    }
}
