<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{

    const HTTP_BAD_REQUEST = 400;
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_INTERNAL_ERROR = 500;
    const HTTP_AUTHORIZED = 401;
    const HTTP_NOT_FOUND = 404;

    protected $limit = 0;
    protected $offset = 0;

    public function __construct(Request $request)
    {
        $this->limit = (int)$request->limit??0;
        $this->offset = (int)$request->offset??0;
    }


    public function apiResponse($response, $code)
    {

        $meta = [
            'meta' => [
                'limit' => $this->limit,
                'offset' => $this->offset
            ]

        ];
        return response()->json($meta + $response, $code);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($results, $message, $statusCode)
    {
        $response = [
            'success' => true,
            'results' => $results,
            'message' => $message,
            'code' => $statusCode
        ];

        return response()->json($response, $statusCode);
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendOkResponse($results, $message, $statusCode = self::HTTP_OK)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'code' => self::HTTP_OK,
            'results' => $results
        ];

        return $this->apiResponse($response, $statusCode);
    }

    /**
     * @param $results
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCreatedResponse($results, $message)
    {
        $response = [
            'success' => true,
            'results' => $results,
            'message' => $message,
            'code' => self::HTTP_CREATED
        ];

        return response()->json($response, self::HTTP_CREATED);
    }

    /**
     * @param $error
     * @param array $errorMessages
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendInternalError($error, $errorMessages = [])
    {
        $response = [
            'success' => false,
            'message' => $error,
            'code' => self::HTTP_INTERNAL_ERROR
        ];


        if (!empty($errorMessages)) {
            $response['results'] = $errorMessages;
        }


        return response()->json($response, self::HTTP_INTERNAL_ERROR);
    }

    /**
     * @param $error
     * @param array $errorMessages
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendBadRequest($error, $errorMessages = [])
    {
        $response = [
            'success' => false,
            'message' => $error,
            'code' => self::HTTP_BAD_REQUEST
        ];

        if (!empty($errorMessages)) {
            $response['results'] = $errorMessages;
        }
        return response()->json($response, self::HTTP_BAD_REQUEST);
    }

}