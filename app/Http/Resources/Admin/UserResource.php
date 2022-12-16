<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'is_driver' => boolval($this->is_driver),
            'is_vendor' => boolval($this->is_vendor),
            'latitude' => (string)$this->latitude,
            'longitude' => (string)$this->longitude,
            'location' => (string)$this->location,
            'name' => (string)$this->name,
            'email' => (string)$this->email,
            'phone' => (string)$this->phone,
            'wallet_balance' => (string)$this->wallet_balance,
            'profile_image' => (string)isset($this->profile_image) ? url(config('app.profile_image').'/'.$this->profile_image) : '',
            'referal_code' => (string)$this->referal_code,
            'is_driver_online' => boolval($this->is_driver_online),
            'is_vendor_online' => boolval($this->is_vendor_online),
            'delivery_range' => $this->delivery_range,
            'self_delivery' => boolval($this->self_delivery),
            'as_driver_verified' => boolval($this->as_driver_verified),
            'as_vendor_verified' => boolval($this->as_vendor_verified),
            'is_profile_complete' => boolval($this->is_profile_complete),
        ];
    }
}