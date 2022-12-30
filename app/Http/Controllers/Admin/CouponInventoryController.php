<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CouponInventory;

class CouponInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = CouponInventory::query();

        if($request->keyword){
            $d['keyword'] = $request->keyword;

            $q->where(function ($query) use ($d) {
                $query->where('user.name', 'like', '%'.$d['keyword'].'%')
                ->orwhere('coupon_code', 'like', '%'.$d['keyword'].'%');
            });
        }

        if($request->status){
            $d['status'] = $request->status;

            if($request->status == 'active'){
                $q->where('status', '=', 1);
            }
            else {
                $q->where('status', '=', 0);
            }
        }

        if($request->items){
            $d['items'] = $request->items;
        }
        else{
            $d['items'] = 10;
        }

        $d['data'] = $q->orderBy('created_at','DESC')->paginate($d['items']);

        return view('admin.coupon-inventory.index',$d);
    }
}
