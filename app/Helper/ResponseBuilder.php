<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Response as HttpResponse;
use stdClass;

class ResponseBuilder {

    private $status;
    private $msg = null;
    private $data = null;
    private $httpCode;
    private $authToken = null;

    public function __construct(bool $status) {
        $this->status = $status;
    }

    public static function success ($msg, $httpCode, $data): HttpResponse {
        return self::asSuccess()
                ->withData($data)
                ->withMessage($msg)
                ->withHttpCode($httpCode)
                ->build();
    }

    public static function successwithToken ($token, $data, $msg, $httpCode): HttpResponse {
        return self::asSuccess()
                ->withAuthToken($token)
                ->withData($data)
                ->withMessage($msg)
                ->withHttpCode($httpCode)
                ->build();
    }

    public static function successMessage ($msg, $httpCode, $data = null) {
        return self::asSuccess()
                ->withData($data)
                ->withMessage($msg)
                ->withHttpCode($httpCode)
                ->build();
    }

    public static function error ($msg, $httpCode, $data = null) {
        return self::asError()
                ->withData($data)
                ->withMessage($msg)
                ->withHttpCode($httpCode)
                ->build();
    }

    public static function asSuccess(): self {
        return new self(1);
    }

    public static function asError(): self {
        return new self(0);
    }

    public function withAuthToken(string $token = null) {
        $this->authToken = $token;
        return $this;
    }

    public function withData($data = null):self {
        $this->data = $data;
        return $this;
    }

    public function withMessage($msg = null):self {
        $this->msg = $msg;
        return $this;
    }

    public function withHttpCode(int $httpCode = null):self {
        $this->httpCode = $httpCode;
        return $this;
    }

    public function build(): HttpResponse {
        $response['status'] = $this->status;

        !is_null($this->msg) && $response['message'] = $this->msg;
        !is_null($this->authToken) && $response['auth_token'] = $this->authToken;
        !is_null($this->data) && $response['data'] = $this->data;

        return response($response, $this->httpCode);
    }

    // public static function json($msg = "", $data = [], $http_status_code = 200, $errors = NULL, $headers = [])
    // {
    //     if (empty($data)) {
    //         $data = new stdClass();
    //     }

    //     if (empty($errors)) {
    //         $errors = new stdClass();
    //     }

    //     $body = [
    //         "message" => $msg,
    //         "errors" => $errors,
    //         "data"  => $data,
    //     ];

    //     return response()->json($body, $http_status_code, $headers, JSON_UNESCAPED_UNICODE);
    // }
}