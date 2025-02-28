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

use Alfabank\Common\AbstractParams;

/**
 * Класс параметров заказа
 * @since 1.0
 */
class OrderParams extends AbstractParams
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
        int    $amount,
        string $orderNumber,
        string $returnUrl,
        int    $currency = 810,
        string $failUrl = "",
        string $dynamicCallbackUrl = "",
        string $email = "",
        string $phone = "",
        string $description = "",
        string $language = "ru",
        string $ip = "",
        string $pageView = "DESKTOP",
        string $clientId = "",
        string $merchantLogin = "",
        string $jsonParams = "",
        int    $sessionTimeoutSecs = 0,
        string $expirationDate = "",
        string $bindingId = "",
        string $features = ""
    )
    {

        parent::__construct($userName, $password, $token);

        $this->_params = array_merge($this->_params, array(
            array(
                "name" => "amount",
                "type" => "numeric",
                "required" => true,
                "value" => ""
            ),
            array(
                "name" => "orderNumber",
                "type" => "string",
                "required" => true,
                "value" => ""
            ),
            array(
                "name" => "returnUrl",
                "type" => "string",
                "required" => true,
                "value" => ""
            ),
            array(
                "name" => "currency",
                "type" => "numeric",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "failUrl",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "dynamicCallbackUrl",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "email",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "phone",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "description",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "language",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "ip",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "pageView",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "clientId",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "merchantLogin",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "jsonParams",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "sessionTimeoutSecs",
                "type" => "numeric",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "expirationDate",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "bindingId",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "features",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
        ));
        $this->_setParam('amount', $amount);
        $this->_setParam('orderNumber', $orderNumber);
        $this->_setParam('returnUrl', $returnUrl);
        $this->_setParam('currency', $currency);
        $this->_setParam('failUrl', $failUrl);
        $this->_setParam('dynamicCallbackUrl', $dynamicCallbackUrl);
        $this->_setParam('phone', $phone);
        $this->_setParam('email', $email);
        $this->_setParam('description', $description);
        $this->_setParam('language', $language);
        $this->_setParam('ip', $ip);
        $this->_setParam('pageView', $pageView);
        $this->_setParam('clientId', $clientId);
        $this->_setParam('merchantLogin', $merchantLogin);
        $this->_setParam('jsonParams', $jsonParams);
        $this->_setParam('sessionTimeoutSecs', $sessionTimeoutSecs);
        $this->_setParam('expirationDate', $expirationDate);
        $this->_setParam('bindingId', $bindingId);
        $this->_setParam('features', $features);
    }
}