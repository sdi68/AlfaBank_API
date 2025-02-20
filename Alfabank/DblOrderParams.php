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

namespace AlfaBank_API;

use Alfabank\Common\AbstractParams;
use Alfabank\Exceptions;

/**
 * Класс параметров двухстадийного заказа
 * @since 1.0
 */
class DblOrderParams extends AbstractParams
{

    /**
     * Конструктор класса
     * @throws Exceptions\ParamsException
     * @since 1.0
     */
    public function __construct(
        string $userName,
        string $password,
        string $token,
        string $orderNumber,
        int    $amount,
        string $lang,
        string $currency,
        bool   $returnPaymentOrderId
    )
    {

        parent::__construct($userName, $password, $token);

        $this->_params = array_merge($this->_params, array(
            array(
                "name" => "orderNumber",
                "type" => "string",
                "required" => true,
                "value" => ""
            ),
            array(
                "name" => "amount",
                "type" => "numeric",
                "required" => true,
                "value" => ""
            ),
            array(
                "name" => "lang",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "currency",
                "type" => "numeric",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "returnPaymentOrderId",
                "type" => "numeric",
                "required" => false,
                "value" => ""
            ),

        ));
        $this->_setParam('amount', $amount);
        $this->_setParam('orderNumber', $orderNumber);
        $this->_setParam('lang', $lang);
        $this->_setParam('currency', $currency);
        $this->_setParam('returnPaymentOrderId', $returnPaymentOrderId);
    }
}