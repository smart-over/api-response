<?php

namespace SmartOver\ApiResponse\Test;

use PHPUnit\Framework\TestCase;
use SmartOver\ApiResponse\ResponseCode;

/**
 * Class ResponseCodeTest
 *
 * @package SmartOver\ApiResponse\Test
 */
class ResponseCodeTest extends TestCase
{
    /**
     * Test case for SmartOver\ApiResponse\ResponseCode
     *
     * @return  void
     */
    public function testResponseCode()
    {
        $this->assertSame(ResponseCode::GNR001, 'GNR001');
        $this->assertSame(ResponseCode::ERR001, 'ERR001');
    }
}