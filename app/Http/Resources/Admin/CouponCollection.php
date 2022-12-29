<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CouponCollection extends ResourceCollection
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
                'id' =>$data->id,
                'vendor_id' => $data->vendor_id,
                'coupon_code' => (string)$data->coupon_code,
                'coupon_details' => (string)$data->coupon_details,
                'valid_from' => (string)$data->valid_from,
                'valid_to' => (string)$data->valid_to,
                'discount_type' => (string)$data->discount_type,
                'max_reedem' => (string)$data->max_reedem,
                'max_user' => (string)$data->max_user,
                'max_discount' => (string)$data->max_discount,
                'min_order_value' => (string)$data->min_order_value,
                'amount' => (string)$data->amount,
            ];
        });
    }
}
