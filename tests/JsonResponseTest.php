<?php

namespace SmartOver\ApiResponse\Test;

use PHPUnit\Framework\TestCase;
use SmartOver\ApiResponse\JsonResponse;

/**
 * Class JsonResponseTest
 *
 * @package SmartOver\ApiResponse\Test
 */
final class JsonResponseTest extends TestCase
{
    /**
     * JsonResponseTest constructor.
     *
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * Test for SmartOver\ApiResponse\JsonResponse
     *
     * @return  void
     */
    public function testRender()
    {

        $response = new JsonResponse('GNR001', 200, 'OK', ['foo' => 'bar']);
        $rendered = $response->render();
        $decoded = json_decode($rendered->content());

        $this->assertInstanceOf('SmartOver\ApiResponse\JsonResponse', $response);
        $this->assertSame($rendered->status(), 200);
        $this->assertSame($decoded->code, 'GNR001');
        $this->assertSame($decoded->message, 'OK');
        $this->assertSame($decoded->data->foo, 'bar');
    }

    public function testWithData()
    {

        $response = new JsonResponse();
        $rendered = $response->withData(['foo' => 'bar'])->render();

        $decoded = json_decode($rendered->content());
        $this->assertInstanceOf('SmartOver\ApiResponse\JsonResponse', $response);
        $this->assertSame($rendered->status(), 200);
        $this->assertSame($decoded->code, 'GNR001');
        $this->assertSame($decoded->message, 'OK');
        $this->assertSame($decoded->data->foo, 'bar');
    }
}