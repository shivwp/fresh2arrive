<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CouponCollection;
use Illuminate\Http\Request;
use App\Helper\ResponseBuilder;
use App\Models\Coupon;

class CouponController extends Controller
{
    /**
     * Display a listing of the Products.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        try {
            $data = Coupon::getCoupons();
            if(count($data) > 0) {
                $this->response = new CouponCollection($data);
                return ResponseBuilder::success(trans('global.all_coupons'),$this->success,$this->response);
            }
            return ResponseBuilder::success(trans('global.no_coupons'),$this->success,[]);

        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }
}
