<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Category;
use App\Helper\Helper;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = Coupon::query()->join('users', 'coupons.vendor_id', '=', 'users.id')->select('coupons.*', 'users.name');

        if($request->keyword){
            $d['keyword'] = $request->keyword;

            $q->where(function ($query) use($d){
                $query->where('coupon_code', 'like', '%'.$d['keyword'].'%')
                        ->orwhere('name', 'like', '%'.$d['keyword'].'%');
            });
        }

        if($request->status){
            $d['status'] = $request->status;

            if($request->status == 'active'){
                $q->where('coupons.status', '=', 1);
            }
            else {
                $q->where('coupons.status', '=', 0);
            }
        }

        if($request->items){
            $d['items'] = $request->items;
        }
        else{
            $d['items'] = 10;
        }

        $d['data'] = $q->orderBy('created_at','DESC')->with('vendor')->paginate($d['items']);

        return view('admin.coupon.index',$d);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $d['vendors'] = User::where('is_vendor', '=', 1)->pluck('name', 'id');
        return view('admin.coupon.create',$d);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'vendor' => 'required',
            'coupon_code' => 'required | unique:coupons,coupon_code,'.$request->id,
            'content' => 'required',
            'valid_to' => 'required',
            'valid_from' => 'required | before:valid_to',
            'discount_type' => 'required | in:F,P',
            'discount' => 'required',
            'max_reedem' => 'required',
            'max_user' => 'required | integer',
            'max_discount' => 'required | integer',
            'min_order_value' => 'required | integer',
            'status' =>'required'
        ]);

        $data = Coupon::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'vendor_id' => $request->vendor,
                'coupon_code' => strtoupper($request->coupon_code),
                'coupon_details' => $request->content,
                'valid_from' => $request->valid_from,
                'valid_to' => $request->valid_to,
                'discount_type' => $request->discount_type,
                'amount' => $request->discount,
                'max_reedem' => $request->max_reedem,
                'max_user' => $request->max_user,
                'max_discount' => $request->max_discount,
                'min_order_value' => $request->min_order_value,
                'status' => $request->status,
            ]
        );

        $result = $data->update();

        if($result)
        {
            if($request->id)
            {
                return redirect()->route('admin.coupons.index')->with('success','Coupon Updated successfully');
            }
            else
            {
                return redirect()->route('admin.coupons.index')->with('success','Coupon Created successfully');
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Something went Wrong, Please try again!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $d['data'] = Coupon::where('id', $id)->first();
        return view('admin.coupon.show',$d);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $d['vendors'] = User::where('is_vendor', '=', 1)->pluck('name', 'id');
        $d['data'] = Coupon::where('id', $id)->first();
        return view('admin.coupon.create',$d);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data= Coupon::where('id',$id)->first();
            $result = $data->delete();
            if($result) {
                return response()->json(["success" => true]);
            }
            else {
                return response()->json(["success" => false]);
            }
        }  catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message'  => "Something went wrong, please try again!",
                'error_msg' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Change the specified resource status from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id, Request $request)
    {
        try {
            $data= Coupon::where('id',$id)->first();
            if($data) {
                $data->status = $data->status == 1 ? 0 : 1;
                $data->save();
                return response()->json(["success" => true, "status"=> $data->status]);
            }
            else {
                return response()->json(["success" => false]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'  => "Something went wrong, please try again!",
                'error_msg' => $e->getMessage(),
            ], 400);
        }
    }
}
