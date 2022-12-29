<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
                'id' => $data->id,
                'tax_percent' => !empty($data->tax_percent) ? $data->tax_percent.'%' : '',
                'name' => $data->name,
                'slug' => $data->slug,
                'image' => !empty($data->image) ? url(config('app.category_image').'/'.$data->image) : '',
            ];
        });
    }
}
