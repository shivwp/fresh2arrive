<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VendorCollection extends ResourceCollection
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
                'name'          => (string)$data->name,
                'distance'      => (string)$data->distance,
                'image'         => !empty($data->vendor->store_image) ? url(config('app.vendor_document').'/'.$data->vendor->store_image) : '',
            ];
        });
    }
}
