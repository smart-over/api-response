<?php

namespace SmartOver\ApiResponse\Exceptions;

use Exception;

/**
 * Class GenericException
 * @package SmartOver\ApiResponse\Exceptions
 */
class GenericException extends Exception implements ExceptionInterface
{

    /**
     * @var
     */
    public $status;

    /**
     * @var
     */
    public $code;

    /**
     * @var
     */
    public $message;

    /**
     * @var
     */
    public $data;

    /**
     * GenericException constructor.
     *
     * @param $status
     * @param $code
     * @param $message
     * @param $data
     */
    public function __construct($status, $code, $message, $data)
    {
        parent::__construct($message);

        $this->status  = $status;
        $this->code    = $code;
        $this->message = $message;
        $this->data    = $data;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}