<?php
namespace SmartOver\ApiResponse\Exceptions;

/**
 * Interface ExceptionInterface
 * @package SmartOver\ApiResponse\Exceptions
 */
interface ExceptionInterface
{
    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @return mixed
     */
    public function getCode();

    /**
     * @return mixed
     */
    public function getMessage();

    /**
     * @return mixed
     */
    public function getData();
}