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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['week_arr'] = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday']; 

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
        // print_r(Helper::generateReferCode());
        // dd($request->all());

        try {
            $request->validate([
                'name' => 'required | string',
                'email' => 'required | email | unique:users,email',
                'phone' => 'required | integer | unique:users,phone',
                'password' => 'required | string | min:8',
                'profileImage' => 'mimes:jpeg,png,jpg',
                'location' => 'required | string',
                'latitude' => 'required | string',
                'longitude' => 'required | string',
                
                'dob' => 'required_if:driver,1',
                'driverAadhar' => 'required_if:driver,1 | unique:driver_profiles,aadhar_no',
                'driverPanCard' => 'required_if:driver,1 | unique:driver_profiles,pan_no',
                'driverVehicle' => 'required_if:driver,1 | unique:driver_profiles,vehicle_no',
                'driverDrivingLicence' => 'required_if:driver,1 | unique:driver_profiles,licence_no',
                'driverStatement' => 'required_if:driver,1 | mimes:jpeg,png,jpg',
                'driverPanImage' => 'required_if:driver,1 | mimes:jpeg,png,jpg',
                'driverLicenceFront' => 'required_if:driver,1 | mimes:jpeg,png,jpg',
                'driverLicenceBack' => 'required_if:driver,1 | mimes:jpeg,png,jpg',
                'driverAadharFront' => 'required_if:driver,1 | mimes:jpeg,png,jpg',
                'driverAadharBack' => 'required_if:driver,1 | mimes:jpeg,png,jpg',

                'aadharNumber' => 'required_if:vendor,1 | unique:vendor_profiles,aadhar_no',
                'panCardNumber' => 'required_if:vendor,1 | unique:vendor_profiles,pan_no',
                'bankStatement' => 'required_if:vendor,1 | mimes:jpeg,png,jpg',
                'panCardImage' => 'required_if:vendor,1 | mimes:jpeg,png,jpg',
                'aadharCardFront' => 'required_if:vendor,1 | mimes:jpeg,png,jpg',
                'aadharCardBack' => 'required_if:vendor,1 | mimes:jpeg,png,jpg',
                'deliveryRange' => 'required_if:vendor,1',
                'admin_commission' => 'required_if:vendor,1',
                'storeImage' => 'required_if:vendor,1 | mimes:jpeg,png,jpg',

            ]);

            // dd($request->all());

            $imagePath = 'uploads/profile-images';

            $userData = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'profile_image' => $request->hasfile('profileImage') ? Helper::storeImage($request->file('profileImage'),$imagePath) : '',
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
            ]);
            // print_r($userData->save());

            if($request->driver == '1')
            {
                $imagePath = 'uploads/driver-documents';

                $driverData = DriverProfile::create([
                    'user_id' => $userData->id,
                    'dob' => $request->dob,
                    'aadhar_no' => $request->driverAadhar,
                    'pan_no' => $request->driverPanCard,
                    'vehicle_no' => $request->driverVehicle,
                    'licence_no' => $request->driverDrivingLicence,
                    'bank_statement' => $request->hasfile('driverStatement') ? Helper::storeImage($request->file('driverStatement'),$imagePath) : '',
                    'pan_card_image' => $request->hasfile('driverPanImage') ? Helper::storeImage($request->file('driverPanImage'),$imagePath) : '',
                    'licence_front_image' => $request->hasfile('driverLicenceFront') ? Helper::storeImage($request->file('driverLicenceFront'),$imagePath) : '',
                    'licence_back_image' => $request->hasfile('driverLicenceBack') ? Helper::storeImage($request->file('driverLicenceBack'),$imagePath) : '',
                    'aadhar_front_image' => $request->hasfile('driverAadharFront') ? Helper::storeImage($request->file('driverAadharFront'),$imagePath) : '',
                    'aadhar_back_image' => $request->hasfile('driverAadharBack') ? Helper::storeImage($request->file('driverAadharBack'),$imagePath) : '',
                    'status' => $request->driverVerify ? $request->driverVerify : '',
                ]);
            }

            if($request->vendor == '1')
            {
                $imagePath = 'uploads/vendor-documents';

                $vendorData = VendorProfile::create([
                    'user_id' => $userData->id,
                    'aadhar_no' => $request->aadharNumber,
                    'pan_no' => $request->panCardNumber,
                    'store_image' => $request->hasfile('storeImage') ? Helper::storeImage($request->file('storeImage'),$imagePath) : '',
                    'bank_statement' => $request->hasfile('bankStatement') ? Helper::storeImage($request->file('bankStatement'),$imagePath) : '',
                    'pan_card_image' => $request->hasfile('panCardImage') ? Helper::storeImage($request->file('panCardImage'),$imagePath) : '',
                    'aadhar_front_image' => $request->hasfile('aadharCardFront') ? Helper::storeImage($request->file('aadharCardFront'),$imagePath) : '',
                    'aadhar_back_image' => $request->hasfile('aadharCardBack') ? Helper::storeImage($request->file('aadharCardBack'),$imagePath) : '',
                    'status' => $request->vendorVerify ? $request->vendorVerify : '',
                ]);

                $data = array();

                // foreach($request->weekday as $key => $value) {
                //     $data[] = [
                //         'user_id' => $userData->id,
                //         'week_day' => $key, 
                //         'start_time' => $request->start_time[$key], 
                //         'end_time' => $request->end_time[$key]
                //     ];
                // }


                for ($i=1; $i <= 7; $i++) { 
                    $data[] = [
                        'user_id' => $userData->id,
                        'week_day' => $i, 
                        'start_time' => !empty($request->start_time[$i]) ? $request->start_time[$i] : '09:00', 
                        'end_time' => !empty($request->end_time[$i]) ? $request->end_time[$i] : '17:00',
                        'status' => isset($request->weekday[$i]) ? $request->weekday[$i] : 0,
                    ];
                }

                VendorAvailability::insert($data);
                
            }
            
            return redirect()->route('admin.user.create')->with('success', 'User Created Successfully');
        }
        catch(Exception $e) {
            return redirect()->route('admin.user.create')->with('error', $e);
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
