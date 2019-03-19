<?php

namespace SmartOver\ApiResponse\Exceptions;

use Exception;
use SmartOver\ApiResponse\ResponseCode;

/**
 * Class RequiredParameterException
 * @package SmartOver\ApiResponse\Exceptions
 */
class RequiredParameterException extends Exception implements ExceptionInterface
{

    /**
     * @var
     */
    public $parameter;

    /**
     * @var string
     */
    public $code = ResponseCode::ERR007;

    /**
     * @var int
     */
    public $status = 400;

    /**
     * RequiredParameterException constructor.
     *
     * @param $parameter
     */
    public function __construct($parameter)
    {
        parent::__construct("$parameter parameter is required");
    }

    /**
     * @return int|mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed|null
     */
    public function getData()
    {
        return [];
    }
}