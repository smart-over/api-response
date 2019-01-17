<?php

namespace SmartOver\ApiResponse;

use \Laravel\Lumen\Http\ResponseFactory;

/**
 * Class JsonResponse
 *
 * @package OmerKamcili\ApiResponse
 */
class JsonResponse implements ResponseInterface
{
    /**
     * @var
     */
    private $code;

    /**
     * @var
     */
    private $status;

    /**
     * @var
     */
    private $message;

    /**
     * @var
     */
    private $data;

    /**
     * JsonResponse constructor.
     *
     * @param string $code
     * @param int $status
     * @param string $message
     * @param array $data
     */
    public function __construct(
        string $code = ResponseCode::GNR001,
        int $status = 200,
        string $message = 'OK',
        array $data = []
    ) {
        $this->code = $code;
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function render()
    {

        $factory = new ResponseFactory();

        return $factory->json([
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data,
        ], $this->status)->header('Content-Type', 'application/json');
    }

    /**
     * @param $data
     * @return $this
     */
    public function withData($data)
    {
        $this->data = $data;

        return $this;
    }
}