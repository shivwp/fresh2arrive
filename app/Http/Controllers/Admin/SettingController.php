<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Helper\Helper;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = Setting::pluck('value','key');
        $data['week_arr'] = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday']; 

        return view('admin.setting.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'admin_commission_type' => 'required',
            'admin_commission' => 'required',
            'referal_amount' => 'required',
            'default_tax' => 'required',
            'surcharge' => 'required',
            'packing_charge' => 'required',
            'delivery_charge_till' => 'required',
            'delivery_charge_per_km' => 'required',
        ]);
        
        $imagePath = config('app.logo');

        $data[] = [
            'logo_1' => $request->hasfile('logo_1') ? Helper::storeImage($request->file('logo_1'),$imagePath) : (isset($request->logo_1_old) ? $request->logo_1_old : ''),
            'logo_2' => $request->hasfile('logo_2') ? Helper::storeImage($request->file('logo_2'),$imagePath) : (isset($request->logo_2_old) ? $request->logo_2_old : ''),
            'admin_commission_type' => $request->admin_commission_type,
            'admin_commission' => $request->admin_commission,
            'referal_amount' => $request->referal_amount,
            'default_tax' => $request->default_tax,
            'surcharge' => $request->surcharge,
            'packing_charge' => $request->packing_charge,
            'delivery_charge_till' => $request->delivery_charge_till,
            'delivery_charge_per_km' => $request->delivery_charge_per_km,
            'tip_is_tax_free' => $request->tip_is_tax_free ? $request->tip_is_tax_free : 0,
        ];

        foreach ($data[0] as $key => $value) {
            Setting::updateOrCreate(
                [
                    'key' => $key,
                ],
                [
                    'value' => $value,
                ]
            );
        }

        return redirect()->back()->with('success', 'Setting Data Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
