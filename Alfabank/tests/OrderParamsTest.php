<?php
/**
 * @package    AlfaBank_API
 * @subpackage    AlfaBank_API
 * @version    1.0.2
 * @author Econsult Lab.
 * @based on   https://pay.alfabank.ru/ecommerce/instructions/merchantManual/pages/index.html
 * @copyright  Copyright (c) 2025 Econsult Lab. All rights reserved.
 * @license    GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link       https://econsultlab.ru
 */

namespace Alfabank;

use PHPUnit\Framework\TestCase;
use Alfabank\Exceptions\OrderParamsException;
use PHPUnit\Framework\assertEquals;

require_once '../autoload.php';
require_once '../Exceptions/OrderParamsException.php';

class OrderParamsTest extends TestCase
{
    protected object $_op;

    public function test__construct()
    {
        $this->_op = new OrderParams(
            'userName',
            'password',
            1234,
            'orderNumber',
            'returnUrl',
            'token',
            810,
            'failUrl',
            'dynamicCallbackUrl',
            'email',
            'phone',
            'description',
            'language',
            'ip',
            'pageView',
            'clientId',
            'merchantLogin',
            'jsonParams',
            50,
            'expirationDate',
            'bindingId',
            'features'
        );

        $this->assertEquals('userName', $this->_op->getParamByName('userName')['value']);
        $this->assertEquals('password', $this->_op->getParamByName('password')['value']);
        $this->assertEquals('orderNumber', $this->_op->getParamByName('orderNumber')['value']);
        $this->assertEquals('returnUrl', $this->_op->getParamByName('returnUrl')['value']);
        $this->assertEquals('token', $this->_op->getParamByName('token')['value']);
        $this->assertEquals('810', $this->_op->getParamByName('currency')['value']);
        $this->assertEquals('failUrl', $this->_op->getParamByName('failUrl')['value']);
        $this->assertEquals('dynamicCallbackUrl', $this->_op->getParamByName('dynamicCallbackUrl')['value']);
        $this->assertEquals('email', $this->_op->getParamByName('email')['value']);
        $this->assertEquals('phone', $this->_op->getParamByName('phone')['value']);
        $this->assertEquals('description', $this->_op->getParamByName('description')['value']);
        $this->assertEquals('language', $this->_op->getParamByName('language')['value']);
        $this->assertEquals('ip', $this->_op->getParamByName('ip')['value']);
        $this->assertEquals('pageView', $this->_op->getParamByName('pageView')['value']);
        $this->assertEquals('clientId', $this->_op->getParamByName('clientId')['value']);
        $this->assertEquals('merchantLogin', $this->_op->getParamByName('merchantLogin')['value']);
        $this->assertEquals('jsonParams', $this->_op->getParamByName('jsonParams')['value']);
        $this->assertEquals(50, $this->_op->getParamByName('sessionTimeoutSecs')['value']);
        $this->assertEquals('expirationDate', $this->_op->getParamByName('expirationDate')['value']);
        $this->assertEquals('bindingId', $this->_op->getParamByName('bindingId')['value']);
        $this->assertEquals('features', $this->_op->getParamByName('features')['value']);
    }

    public function testGetParamsArray()
    {
        $this->_op = new OrderParams(
            'userName',
            'password',
            1234,
            'orderNumber',
            'returnUrl',
            'token',
            810,
            'failUrl',
            'dynamicCallbackUrl',
            'email',
            'phone',
            'description',
            'language',
            'ip',
            'pageView',
            'clientId',
            'merchantLogin',
            'jsonParams',
            50,
            'expirationDate',
            'bindingId',
            'features'
        );
        $test = $this->_op->getParamsArray();
        $this->assertIsArray($test);
        $this->assertArrayHasKey('userName', $test, 'В массиве нет поля userName');
    }

    public function testValidateParamsValueRequiredThrowsException()
    {
        $this->expectException(OrderParamsException::class);
        $this->_op = new OrderParams(
            '',
            'password',
            1234,
            'orderNumber',
            'returnUrl',
            'token',
            810,
            'failUrl',
            'dynamicCallbackUrl',
            'email',
            'phone',
            'description',
            'language',
            'ip',
            'pageView',
            'clientId',
            'merchantLogin',
            'jsonParams',
            50,
            'expirationDate',
            'bindingId',
            'features'
        );
    }

    public function testUnknownParamsNameThrowsException()
    {
        $this->expectException(OrderParamsException::class);
        $this->_op = new OrderParams(
            1234,
            'password',
            1234,
            'orderNumber',
            'returnUrl',
            'token',
            810,
            'failUrl',
            'dynamicCallbackUrl',
            'email',
            'phone',
            'description',
            'language',
            'ip',
            'pageView',
            'clientId',
            'merchantLogin',
            'jsonParams',
            50,
            'expirationDate',
            'bindingId',
            'features'
        );
        $this->_op->getParamByName("Unknown");
    }
}
