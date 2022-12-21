<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DriverProfile;
use App\Models\VendorProfile;
use App\Models\VendorAvailability;
use App\Helper\Helper;
use Hash;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = User::query();
        
        if(isset($request->keyword)){
            $d['keyword'] = $request->keyword;
    
            $q->where(function ($query) use ($d) {
                $query->where('name', 'like', '%'.$d['keyword'].'%')
                ->orwhere('email', 'like', '%'.$d['keyword'].'%')
                ->orwhere('phone', 'like', '%'.$d['keyword'].'%');
            });
        }

        if(isset($request->role)){
            $d['role'] = $request->role;
            
            if($request->role == 'driver') {
                $q->where('is_driver', '=', 1);
            }
            if($request->role == 'vendor') {
                $q->where('is_vendor', '=', 1);
            }
            if($request->role == 'customer') {
                $q->where('is_vendor', '=', 0)->where('is_driver', '=', 0);
            }
        }
        
        if(isset($request->status)){
            $d['status'] = $request->status;
            
            if($request->status == 'active'){
                $q->where('status', '=', 1);
            }
            else {
                $q->where('status', '=', 0);
            }
        }

        if(isset($request->items)){
            $d['items'] = $request->items;
        }
        else{
            $d['items'] = 10;
        }

        $d['data'] = $q->orderBy('created_at','DESC')->paginate($d['items']);

        return view('admin.user.index', $d);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['week_arr'] = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday']; 
        $data['range'] = Helper::DeliveryRange();

        return view('admin.user.create',$data);
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
            'name' => 'required | string',
            'email' => 'required | email | unique:users,email,'.$request->id,
            'phone' => 'required | digits:10 | integer | unique:users,phone,'.$request->id,
            'profileImage' => 'mimes:jpeg,png,jpg',
            'location' => 'required | string',
            'latitude' => 'required | string',
            'longitude' => 'required | string',
            
            'dob' => 'required_if:driver,1',
            'driverAadhar' => 'required_if:driver,1 | unique:driver_profiles,aadhar_no,'.$request->driver_id,
            'driverPanCard' => 'required_if:driver,1 | unique:driver_profiles,pan_no,'.$request->driver_id,
            'driverVehicle' => 'required_if:driver,1 | unique:driver_profiles,vehicle_no,'.$request->driver_id,
            'driverDrivingLicence' => 'required_if:driver,1 | unique:driver_profiles,licence_no,'.$request->driver_id,

            'aadharNumber' => 'required_if:vendor,1 | unique:vendor_profiles,aadhar_no,'.$request->vendor_id,
            'panCardNumber' => 'required_if:vendor,1 | unique:vendor_profiles,pan_no,'.$request->vendor_id,
            'deliveryRange' => 'required_if:vendor,1',
            'admin_commission' => 'required_if:vendor,1',
        ],
        [
            'required_if' => 'The :attribute field is required.',
        ]);

        // if($request->id) {
        //     if(!empty($request->password)) {
        //         $request->validate([
        //             'password' => ['regex:/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%]).*$/', 'string', 'min:8'],
        //         ]);
        //     }
        // }

        if(empty($request->id)) {
            $request->validate([
                // 'password' => ['required', 'regex:/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%]).*$/', 'string', 'min:8'],

                'driverStatement' => 'required_if:driver,1 | mimes:jpeg,png,jpg',
                'driverPanImage' => 'required_if:driver,1 | mimes:jpeg,png,jpg',
                'driverLicenceFront' => 'required_if:driver,1 | mimes:jpeg,png,jpg',
                'driverLicenceBack' => 'required_if:driver,1 | mimes:jpeg,png,jpg',
                'driverAadharFront' => 'required_if:driver,1 | mimes:jpeg,png,jpg',
                'driverAadharBack' => 'required_if:driver,1 | mimes:jpeg,png,jpg',

                'bankStatement' => 'required_if:vendor,1 | mimes:jpeg,png,jpg',
                'panCardImage' => 'required_if:vendor,1 | mimes:jpeg,png,jpg',
                'aadharCardFront' => 'required_if:vendor,1 | mimes:jpeg,png,jpg',
                'aadharCardBack' => 'required_if:vendor,1 | mimes:jpeg,png,jpg',
                'storeImage' => 'required_if:vendor,1 | mimes:jpeg,png,jpg',
            ],
            [
                'required_if' => 'The :attribute field is required.',
            ]);
        }
        else {
            $request->validate([
                'driverStatement' => 'mimes:jpeg,png,jpg',
                'driverPanImage' => 'mimes:jpeg,png,jpg',
                'driverLicenceFront' => 'mimes:jpeg,png,jpg',
                'driverLicenceBack' => 'mimes:jpeg,png,jpg',
                'driverAadharFront' => 'mimes:jpeg,png,jpg',
                'driverAadharBack' => 'mimes:jpeg,png,jpg',

                'bankStatement' => 'mimes:jpeg,png,jpg',
                'panCardImage' => 'mimes:jpeg,png,jpg',
                'aadharCardFront' => 'mimes:jpeg,png,jpg',
                'aadharCardBack' => 'mimes:jpeg,png,jpg',
                'storeImage' => 'mimes:jpeg,png,jpg',
            ]);
        }

        $imagePath = config('app.profile_image');

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'profile_image' => $request->hasfile('profileImage') ? Helper::storeImage($request->file('profileImage'), $imagePath, $request->profileImageOld) : (isset($request->profileImageOld) ? $request->profileImageOld : ''),
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'referal_code' => Helper::generateReferCode(),
            'is_driver' => $request->driver ? $request->driver : 0,
            'is_vendor' => $request->vendor ? $request->vendor : 0,
            'is_driver_online' => $request->driver ? ($request->driverMode ? $request->driverMode : 0 ) : 0,
            'as_driver_verified' => $request->driver ? ($request->driverVerify ? $request->driverVerify : 0 ) : 0,
            'delivery_range' => $request->vendor ? ($request->deliveryRange ? $request->deliveryRange : 0 ) : 0,
            'is_vendor_online' => $request->vendor ? ($request->storeOpen ? $request->storeOpen : 0 ) : 0,
            'self_delivery' => $request->vendor ? ($request->self_delivery ? $request->self_delivery : 0 ) : 0,
            'admin_commission' => $request->vendor ? ($request->admin_commission ? $request->admin_commission : 0 ) : 0,
            'as_vendor_verified' => $request->vendor ? ($request->vendorVerify ? $request->vendorVerify : 0 ) : 0,
        ];

        if(!empty($request->password)) {
            
            $data['password'] = Hash::make($request->password);
        }

        $userData = User::updateOrCreate(['id' => $request->id,],$data);

        if($request->driver == '1')
        {
            $imagePath = config('app.driver_document');

            $driverData = DriverProfile::updateOrCreate(
            [
                'user_id' => $request->id,
            ],
            [
                'user_id' => $userData->id,
                'dob' => $request->dob,
                'aadhar_no' => $request->driverAadhar,
                'pan_no' => $request->driverPanCard,
                'vehicle_no' => $request->driverVehicle,
                'licence_no' => $request->driverDrivingLicence,
                'bank_statement' => $request->hasfile('driverStatement') ? Helper::storeImage($request->file('driverStatement'), $imagePath, $request->driverStatementOld) : (isset($request->driverStatementOld) ? $request->driverStatementOld : ''),
                'pan_card_image' => $request->hasfile('driverPanImage') ? Helper::storeImage($request->file('driverPanImage'), $imagePath, $request->driverPanImageOld) : (isset($request->driverPanImageOld) ? $request->driverPanImageOld : ''),
                'licence_front_image' => $request->hasfile('driverLicenceFront') ? Helper::storeImage($request->file('driverLicenceFront'), $imagePath, $request->driverLicenceFrontOld) : (isset($request->driverLicenceFrontOld) ? $request->driverLicenceFrontOld : ''),
                'licence_back_image' => $request->hasfile('driverLicenceBack') ? Helper::storeImage($request->file('driverLicenceBack'), $imagePath, $request->driverLicenceBackOld) : (isset($request->driverLicenceBackOld) ? $request->driverLicenceBackOld : ''),
                'aadhar_front_image' => $request->hasfile('driverAadharFront') ? Helper::storeImage($request->file('driverAadharFront'), $imagePath, $request->driverAadharFrontOld) : (isset($request->driverAadharFrontOld) ? $request->driverAadharFrontOld : ''),
                'aadhar_back_image' => $request->hasfile('driverAadharBack') ? Helper::storeImage($request->file('driverAadharBack'), $imagePath, $request->driverAadharBackOld) : (isset($request->driverAadharBackOld) ? $request->driverAadharBackOld : ''),
                'status' => $request->driverVerify ? $request->driverVerify : 0,
            ]);
        }

        if($request->vendor == '1')
        {
            $imagePath = config('app.vendor_document');

            $vendorData = VendorProfile::updateOrCreate(
            [
                'user_id' => $request->id,
            ],
            [
                'user_id' => $userData->id,
                'aadhar_no' => $request->aadharNumber,
                'pan_no' => $request->panCardNumber,
                'store_image' => $request->hasfile('storeImage') ? Helper::storeImage($request->file('storeImage'), $imagePath, $request->storeImageOld) : (isset($request->storeImageOld) ? $request->storeImageOld : ''),
                'bank_statement' => $request->hasfile('bankStatement') ? Helper::storeImage($request->file('bankStatement'), $imagePath, $request->bankStatementOld) : (isset($request->bankStatementOld) ? $request->bankStatementOld : ''),
                'pan_card_image' => $request->hasfile('panCardImage') ? Helper::storeImage($request->file('panCardImage'), $imagePath, $request->panCardImageOld) : (isset($request->panCardImageOld) ? $request->panCardImageOld : ''),
                'aadhar_front_image' => $request->hasfile('aadharCardFront') ? Helper::storeImage($request->file('aadharCardFront'), $imagePath, $request->aadharCardFrontOld) : (isset($request->aadharCardFrontOld) ? $request->aadharCardFrontOld : ''),
                'aadhar_back_image' => $request->hasfile('aadharCardBack') ? Helper::storeImage($request->file('aadharCardBack'), $imagePath, $request->aadharCardBackOld) : (isset($request->aadharCardBackOld) ? $request->aadharCardBackOld : ''),
                'status' => $request->vendorVerify ? $request->vendorVerify : 0,
            ]);

            $data = array();

            
            for ($i=1; $i <= 7; $i++) { 
                $data[] = [
                    'week_day' => $i, 
                    'start_time' => !empty($request->start_time[$i]) ? $request->start_time[$i] : '09:00', 
                    'end_time' => !empty($request->end_time[$i]) ? $request->end_time[$i] : '17:00',
                    'status' => isset($request->weekday[$i]) ? $request->weekday[$i] : 0,
                ]
                + (!empty($request->id) ? ['user_id' => $request->id] : ['user_id' => $userData->id])
                + (!empty($request->vendor_available_id) ? ['id' => $request->vendor_available_id[$i-1]] : []);
            }

            VendorAvailability::upsert($data, ['id','user_id','week_day'],['start_time','end_time','status']);
  
        }
        if(!empty($request->id)) {
            return redirect()->route('admin.users.index')->with('success', "User Updated Successfully!");
        }
        else {
            return redirect()->route('admin.users.index')->with('success', "User Created Successfully!");
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
        $data['data'] = User::where('id',$id)->with('driver','vendor','vendor_availability')->first();
        // dd($data['data']);
        $data['week_arr'] = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday']; 

        return view('admin.user.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['data'] = User::where('id',$id)->with('driver','vendor','vendor_availability')->first();
        $data['range'] = Helper::DeliveryRange();
        $data['week_arr'] = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday']; 

        return view('admin.user.create',$data);
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
            $data= User::where('id',$id)->delete();
            if($data) {
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

    public function changeStatus($id, Request $request)
    {
        try {
            $data= User::where('id',$id)->first();
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
