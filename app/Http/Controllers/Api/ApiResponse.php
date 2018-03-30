<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class ApiResponse
{

    const HTTP_BAD_REQUEST = 400;
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_INTERNAL_ERROR = 500;
    const HTTP_AUTHORIZED = 401;
    const HTTP_NOT_FOUND = 404;


    private $apiResponse = [
        'meta' => [
            'limit' => 0,
            'offset' => 0
        ],
        'success' => false,
        'data' => [],
        'message' => '',
        'code' => self::HTTP_OK
    ];


    public function setLimit(int $value)
    {
        $this->apiResponse['meta']['limit'] = $value;
        return $this;
    }

    public function setOffset(int $value)
    {
        $this->apiResponse['meta']['offset'] = $value;
        return $this;
    }

    public function setSuccess(Bool $value)
    {
        $this->apiResponse['success'] = $value;
        return $this;
    }

    public function setData(array $data)
    {
        $this->apiResponse['data'] = json_encode($data);
        return $this;
    }


    public function setMessage(string $value)
    {
        $this->apiResponse['message'] = $value;
        return $this;
    }

    public function setCode($value)
    {
        $this->apiResponse['code'] = $value;
        return $this;
    }

    public function apiResponse()
    {
        return $this->apiResponse;
    }

}