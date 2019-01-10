<?php

namespace SmartOver\ApiResponse;

use Laravel\Lumen\Exceptions\Handler;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ExceptionHandler
 *
 * @package SmartOver\ApiResponse
 */
class ExceptionHandler extends Handler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * @param \Exception $exception
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|mixed|\SmartOver\ApiResponse\JsonResponse
     */
    public function render($request, Exception $e)
    {

        switch (true) {

            case $e instanceof ValidationException:
                return (new JsonResponse(ResponseCode::ERR002, 400, __('errors.validation'), $e->errors()))->render();

            case $e instanceof NotFoundHttpException:
                return (new JsonResponse(ResponseCode::ERR003, 400, __('errors.notfound')))->render();

            default:
                return (new JsonResponse(ResponseCode::ERR001, 400, $e->getMessage()))->render();
        }
    }
}