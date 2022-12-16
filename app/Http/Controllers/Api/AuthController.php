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

            $otp = Helper::generateOtp();
            $user = User::findByPhone($request->phone);

            if($user) {

                $user->otp = $otp;
                $user->save();
                // $data = ['otp' => $otp];
                return ResponseBuilder::success($this->msg['OTP_SENT'], $this->success, $otp);
            }
            
            if($request->referred_code) {
                $user = User::findByReferalCode($request->referred_code);
                if(!$user) {
                    return ResponseBuilder::error($this->msg['CODE_INVALID'], $this->badRequest);
                }

                $bonusAmount = Setting::where('key','referal_amount')->first();
                $user->wallet_balance += $bonusAmount->value;
                $user->save();

                UserReferal::create([
                    'referred_user_id' => $request->referred_code,
                    'user_id' => $userData->id,
                ]);
            }

            $userData = User::create([
                'phone' => $request->phone,
                'referal_code' => Helper::generateReferCode(),
                'otp' => $otp,
            ]);

            return ResponseBuilder::success($this->msg['OTP_SENT'], $this->success, $otp);

        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }

    /**
     * User Otp Verify Function
     * @param \Illuminate\Http\Request $request
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

    public function logout() {
        try {
            if(!Auth::guard('api')->check()) {
                return ResponseBuilder::error($this->msg['LOGIN'], $this->badRequest);
            }
            $user = Auth::guard('api')->user();
            $user->token()->revoke();
            return ResponseBuilder::success($this->msg['LOG_OUT'], $this->success); 
        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(), $this->badRequest);
        }
    }

    public function setAuthResponse($user) {
        return $this->response->user =  new UserResource($user);
    }
}
