<?php

namespace Alfabank\Tests;

use Alfabank\Exceptions\GatewayException;
use PHPUnit\Framework\TestCase;
require_once '../Exceptions/GatewayException.php';

class GatewayExceptionTest extends TestCase
{
    public function test__construct(){
        $e = new GatewayException(GatewayException::GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE);
        $this->assertEquals('GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE_MSG', $e->getMessage());
        $this->assertEquals(GatewayException::GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE, $e->getCode());
    }
}
