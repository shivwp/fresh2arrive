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
    // protected $msg;

    // public function __construct() {
    //     $this->msg = Helper::Messages();
    // }
    /**
     * User Login/Register Function
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required | digits:10 | integer',
            ]);

            if($validator->fails()) {
                return ResponseBuilder::error($validator->errors()->first(), $this->badRequest);
            }
            
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
                    'referred_user_id' => $request->referred_code,
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
            $validator = Validator::make($request->all(), [
                'phone' => 'required | digits:10 | integer | exists:users,phone',
                'otp' => 'required | digits:4'
            ]);

            if($validator->fails()) {
                return ResponseBuilder::error($validator->errors()->first(), $this->badRequest);
            }

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
            $validator = Validator::make($request->all(), [
                'phone' => 'required | digits:10 | integer',
            ]);

            if($validator->fails()) {
                return ResponseBuilder::error($validator->errors()->first(), $this->badRequest);
            }
 
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
