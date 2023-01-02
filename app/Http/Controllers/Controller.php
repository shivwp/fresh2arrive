<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use stdClass;
use App\Helper\Helper;
use Illuminate\Http\Request;
use Validator;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $serverError = 500;
    protected $badRequest = 400;
    protected $unauthorized = 401;
    protected $forbidden = 403;
    protected $notFound = 404;
    protected $success = 200;
    protected $noContent = 204;
    protected $partialContent = 206;

    protected $response;
    protected $responseNew;
    protected $msg;

    public function __construct() {
        $this->response = new stdClass();
        $this->responseNew = new stdClass();
        $this->msg = Helper::Messages();
    }

    static public function isValidPayload(Request $request, $validSet){
        $validator = Validator::make($request->all(), $validSet);

        if($validator->fails()) {
            return $validator->errors()->first();
        }
    }
    
}
