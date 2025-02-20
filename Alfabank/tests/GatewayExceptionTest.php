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

namespace Alfabank\Tests;

use Alfabank\Exceptions\GatewayException;
use PHPUnit\Framework\TestCase;

require_once '../Exceptions/GatewayException.php';

class GatewayExceptionTest extends TestCase
{
    public function test__construct()
    {
        $e = new GatewayException(GatewayException::GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE);
        $this->assertEquals('GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE_MSG', $e->getMessage());
        $this->assertEquals(GatewayException::GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE, $e->getCode());
    }
}
