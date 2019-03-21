<?php

namespace SmartOver\ApiResponse\Test;

use Google\Cloud\Core\Exception\ServiceException;
use PHPUnit\Framework\TestCase;
use SmartOver\ApiResponse\ExceptionHandler;
use SmartOver\ApiResponse\Exceptions\GenericException;
use SmartOver\ApiResponse\Exceptions\RequiredParameterException;
use SmartOver\ApiResponse\ResponseCode;
use Illuminate\Http\Request;

/**
 * Class ExceptionsTest
 * @package SmartOver\ApiResponse\Test
 */
class ExceptionsTest extends TestCase
{

    /**
     * test default exception
     */
    public function testDefaultException()
    {
        $request = Request::createFromBase(\Symfony\Component\HttpFoundation\Request::create(
            "uri",
            "get"
        ));

        $exception = new ExceptionHandler();
        $except    = $exception->render($request, new \Exception('foo'));
        $decoded   = json_decode($except->getContent());

        $this->assertEquals(400, $except->status());
        $this->assertEquals(ResponseCode::ERR001, $decoded->code);
        $this->assertEquals('foo', $decoded->message);

    }

    /**
     * Test required parameter exception
     */
    public function testRequiredParameterException()
    {

        $request = Request::createFromBase(\Symfony\Component\HttpFoundation\Request::create(
            "uri",
            "get"
        ));

        $exception = new ExceptionHandler();
        $except    = $exception->render($request, new RequiredParameterException('foo'));
        $decoded   = json_decode($except->getContent());

        $this->assertEquals(400, $except->status());
        $this->assertEquals(ResponseCode::ERR007, $decoded->code);
        $this->assertEquals('foo parameter is required', $decoded->message);

    }

    /**
     * Test generic exception
     */
    public function testGenericException()
    {
        $request = Request::createFromBase(\Symfony\Component\HttpFoundation\Request::create(
            "uri",
            "get"
        ));

        $exception = new ExceptionHandler();
        $except    = $exception->render($request, new GenericException(405, ResponseCode::ERR001, 'message', ['foo' => 'bar']));
        $decoded   = json_decode($except->getContent());

        $this->assertEquals(405, $except->status());
        $this->assertEquals(ResponseCode::ERR001, $decoded->code);
        $this->assertEquals('message', $decoded->message);
        $this->assertEquals(['foo' => 'bar'], (array)$decoded->data);

    }


    /**
     * Test generic exception
     */
    public function testGoogleCloudException()
    {
        $request = Request::createFromBase(\Symfony\Component\HttpFoundation\Request::create(
            "uri",
            "get"
        ));

        $exception = new ExceptionHandler();
        $except    = $exception->render($request, new ServiceException('test'));
        $decoded   = json_decode($except->getContent());

        $this->assertEquals(400, $except->status());
        $this->assertEquals(ResponseCode::ERR008, $decoded->code);
        $this->assertEquals('Cloud error', $decoded->message);

    }

}