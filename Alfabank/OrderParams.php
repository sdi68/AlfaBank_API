<?php
/*
 * OrderParams.php
 * Created for project JOOMLA 3.x
 * subpackage PAYMENT/CPGALFABANK plugin
 * based on https://github.com/SatanaKonst/AlfaBank_API
 * version 1.0.0
 * https://econsultlab.ru
 * mail: info@econsultlab.ru
 * Released under the GNU General Public License
 * Copyright (c) 2022 Econsult Lab.
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
     * Массив параметров заказа
     * @var array|array[]
     * @since 1.0
     */
    protected array $_params = array(
        array(
            "name" => "userName",
            "type" => "string",
            "required" => true,
            "value" => "",
        ),
        array(
            "name" => "password",
            "type" => "string",
            "required" => true,
            "value" => ""
        ),
        array(
            "name" => "token",
            "type" => "string",
            "required" => false,
            "value" => ""
        ),
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
    );

    /**
     * Конструктор класса
     * @throws Exceptions\ParamsException
     * @since 1.0
     */
    public function __construct(
        string $userName,
        string $password,
        int    $amount,
        string $orderNumber,
        string $returnUrl,
        string $token = "",
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
        parent::__construct($userName, $password);

        $this->_setParam('amount', $amount);
        $this->_setParam('orderNumber', $orderNumber);
        $this->_setParam('returnUrl', $returnUrl);
        $this->_setParam('token', $token);
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