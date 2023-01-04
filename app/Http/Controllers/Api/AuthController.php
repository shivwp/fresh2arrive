<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\ResponseBuilder;
use App\Helper\Helper;
use App\Models\User;
use App\Models\Setting;
use App\Models\UserReferal;
use App\Http\Resources\Admin\UserResource;
use Validator;
use Auth;

class AuthController extends Controller
{
    /**
     * User Login/Register Function
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        try {
            // Validation start
            $validSet = [
                'phone' => 'required | digits:10 | integer'
            ]; 

            $isInValid = $this->isValidPayload($request, $validSet);
            if($isInValid){
                return ResponseBuilder::error($isInValid, $this->badRequest);
            }
            // Validation end
            
            $data = $this->sendOtp($request->phone);

            $otp = $data['otp'];
            $login = $data['user_exists'];

            if($login) {
                return ResponseBuilder::success($this->msg['OTP_SENT'], $this->success, $otp);
            }

            $userData = User::create([
                'phone' => $request->phone,
                'referal_code' => Helper::generateReferCode(),
                'otp' => $otp,
            ]);

            if($request->referred_code) {
                $user = User::findByReferalCode($request->referred_code);
                if(!$user) {
                    return ResponseBuilder::error($this->msg['CODE_INVALID'], $this->badRequest);
                }

                $bonusAmount = Setting::getDataByKey('referal_amount');
                $user->wallet_balance += $bonusAmount->value;
                $user->save();

                UserReferal::create([
                    'referred_user_id' => $user->id,
                    'user_id' => $userData->id,
                ]);
            }

            return ResponseBuilder::success($this->msg['OTP_SENT'], $this->success, $otp);

        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }

    /**
     * User Otp Verify Function
     * @param \Illuminate\Http\Request $request, phone, otp
     * @return \Illuminate\Http\Response
     */
    public function verifyOtp(Request $request) {
        try {
            // Validation start
            $validSet = [
                'phone' => 'required | digits:10 | integer | exists:users,phone',
                'otp' => 'required | digits:4'
            ]; 

            $isInValid = $this->isValidPayload($request, $validSet);
            if($isInValid){
                return ResponseBuilder::error($isInValid, $this->badRequest);
            }
            // Validation end

            $user = User::findByPhone($request->phone);
            
            if($request->otp != $user->otp) {
                return ResponseBuilder::error($this->msg['INVALID_OTP'], $this->badRequest);
            }
            $token = $user->createToken('Token')->accessToken;
            $data = $this->setAuthResponse($user);
            
            return ResponseBuilder::successwithToken($token, $data, $this->msg['USER_VERIFIED'], $this->success);

        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }

    /**
     * User Resend Otp Verify Function
     * @param \Illuminate\Http\Request $request, phone, otp
     * @return \Illuminate\Http\Response
     */
    public function resendOtp(Request $request) {
        try {
            // Validation start
            $validSet = [
                'phone' => 'required | digits:10 | integer',
            ]; 

            $isInValid = $this->isValidPayload($request, $validSet);
            if($isInValid){
                return ResponseBuilder::error($isInValid, $this->badRequest);
            }
            // Validation end
 
            $data = $this->sendOtp($request->phone);
            $otp = $data['otp'];

            return ResponseBuilder::success($this->msg['OTP_SENT'], $this->success, $otp);

        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }

    public function sendOtp($phone) {
        $otp = Helper::generateOtp();
        $user = User::findByPhone($phone);
        $user_exists = false;

        if($user) {
            $user->otp = $otp;
            $user->save();
            $user_exists = true;
        }
         
        return ["otp"=>$otp, "user_exists"=>$user_exists];
    }

    /**
     * User Profile Update
     * @param \Illuminate\Http\Request $request, name, email, phone
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request) {
        try {
            $user = Auth::guard('api')->user();
            // Validation start
            $validSet = [
                'name' => 'required',
                'email' => 'required | email | unique:users,email,'.$user->id,
                'profile_image' => 'mimes:jpeg,png,jpg',
            ]; 
            // return $validSet;

            $isInValid = $this->isValidPayload($request, $validSet);
            if($isInValid){
                return ResponseBuilder::error($isInValid, $this->badRequest);
            }
            // Validation end

            $imagePath = config('app.profile_image');
            $profileImageOld = $user->profile_image;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->profile_image = $request->hasfile('profile_image') ? Helper::storeImage($request->file('profile_image'), $imagePath, $profileImageOld) : (isset($profileImageOld) ? $profileImageOld : '');
            $user->update();

            $data = $this->setAuthResponse($user);

            return ResponseBuilder::successMessage(trans('global.profile_updated'), $this->success, $data); 
            
        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }

    /**
     * User Profile
     * @return \Illuminate\Http\Response
     */
    public function userProfile() {
        try {
            $user = Auth::guard('api')->user();  
            $data = $this->setAuthResponse($user);
            return ResponseBuilder::successMessage(trans('global.profile_detail'), $this->success, $data); 
        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }

    /**
     * User logout Function
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        try {
            if(!Auth::guard('api')->check()) {
                return ResponseBuilder::error($this->msg['LOGIN'], $this->badRequest);
            }
            
            Auth::guard('api')->user()->token()->revoke();
            
            return ResponseBuilder::successMessage($this->msg['LOG_OUT'], $this->success); 
        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(), $this->badRequest);
        }
    }

    public function setAuthResponse($user) {
        return $this->response->user =  new UserResource($user);
    }
}
