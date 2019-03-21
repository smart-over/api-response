<?php

namespace SmartOver\ApiResponse;

use Google\Cloud\Core\Exception\ServiceException;
use Laravel\Lumen\Exceptions\Handler;
use Exception;
use SmartOver\ApiResponse\Exceptions\ExceptionInterface;
use SmartOver\ApiResponse\Exceptions\GenericException;
use SmartOver\ApiResponse\Exceptions\RequiredParameterException;
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
        GenericException::class,
        RequiredParameterException::class,
        ExceptionInterface::class,
        ServiceException::class,
    ];

    /**
     * @param \Exception $exception
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|mixed|\SmartOver\ApiResponse\JsonResponse
     */
    public function render($request, Exception $e)
    {

        switch (true) {

            /**
             * Request validate exception
             */
            case $e instanceof ValidationException:

                $response = new JsonResponse(ResponseCode::ERR002, 400, __('errors.validation'), $e->errors());

                return $response->render();


            /**
             * Route not found exception
             */
            case $e instanceof NotFoundHttpException:

                $response = new JsonResponse(ResponseCode::ERR003, 400, __('errors.notfound'));

                return $response->render();


            /**
             * Eloquent not found exception
             */
            case $e instanceof ModelNotFoundException:

                $message = $e->getModel() . ': ' . __('errors.recordNotFound');

                return (new JsonResponse(ResponseCode::ERR004, 404, $message))->render();


            /**
             * Throw while exception interface
             */
            case $e instanceof ExceptionInterface:

                $response = new JsonResponse($e->getCode(), $e->getStatus(), $e->getMessage(), $e->getData());

                return $response->render();


            /**
             * Google cloud exceptions
             */
            case $e instanceof ServiceException:

                $decoded  = json_decode($e->getMessage());
                $message  = isset($decoded->error->message) ? $decoded->error->message : 'Cloud error';
                $data     = isset($decoded->error) ? (array)$decoded->error : [];
                $response = new JsonResponse(ResponseCode::ERR008, 400, $message, $data);

                return $response->render();


            /**
             * App default exception
             *
             * If you use \Exception('') directly this line will be return
             */
            default:

                $response = new JsonResponse(ResponseCode::ERR001, 400, $e->getMessage());

                return $response->render();

        }
    }
}