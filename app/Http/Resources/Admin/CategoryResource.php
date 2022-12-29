<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id' => $this->id,
            'tax_percent' => !empty($this->tax_percent) ? $this->tax_percent.'%' : '',
            'name' => (string)$this->name,
            'slug' => (string)$this->slug,
            'image' => !empty($this->image) ? url(config('app.category_image').'/'.$this->image) : '',
        ];
    }
}
