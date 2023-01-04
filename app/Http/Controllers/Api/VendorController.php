<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\VendorCollection;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helper\ResponseBuilder;
use Auth;

class VendorController extends Controller
{
    /**
     * Display a listing of all stores.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        try {
            // if(!Auth::guard('api')->check()) {
            //     return ResponseBuilder::error(trans('global.user_not_found'), $this->unauthorized);
            // }
            $user = Auth::guard('api')->user();

            $latitude = $user->latitude;
            $longitude = $user->longitude;

            $distance = 10;
            $page = ($request->pagination) ? $request->pagination : 10;

            // $haversine = "(
            //     6371 * acos(
            //         cos(radians(" .$latitude. "))
            //         * cos(radians(`latitude`))
            //         * cos(radians(`longitude`) - radians(" .$longitude. "))
            //         + sin(radians(" .$latitude. ")) * sin(radians(`latitude`))
            //     )
            // )";

            // $data = User::select("*")
            //     ->where('is_vendor', 1)
            //     ->with('vendor')
            //     ->selectRaw("round($haversine, 2) AS distance")
            //     ->having("distance", "<=", $distance)
            //     ->orderby("distance", "asc")
            //     ->paginate($page);

            $data = User::storeDistance($latitude, $longitude, $distance, $page);
            
            return $data;

            if(count($data) > 0) {
                $this->response = new VendorCollection($data);
                return ResponseBuilder::successWithPagination($data, $this->response, trans('global.all_stores'), $this->success);
            }
            return ResponseBuilder::successWithPagination($data, [], trans('global.no_stores'), $this->success);

        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }
}
