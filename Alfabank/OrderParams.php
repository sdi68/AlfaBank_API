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
use Alfabank\Exceptions\ParamsException;

/**
 * Класс параметров заказа
 * @since 1.0
 */
class OrderParams extends AbstractParams
{

    /**
     * Конструктор класса
     * @param string $userName
     * @param string $password
     * @param string $token
     * @param int $amount
     * @param string $orderNumber
     * @param string $returnUrl
     * @param int $currency
     * @param string $failUrl
     * @param string $dynamicCallbackUrl
     * @param string $email
     * @param string $phone
     * @param string $description
     * @param string $language
     * @param string $ip
     * @param string $pageView
     * @param string $clientId
     * @param string $merchantLogin
     * @param string $jsonParams
     * @param int $sessionTimeoutSecs
     * @param string $expirationDate
     * @param string $bindingId
     * @param string $features
     * @param string $prodURLType Определяет тип используемого продуктивного URL ("" или "R")
     * @throws ParamsException
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
        string $features = "",
        string $prodURLType = "",
    )
    {

        parent::__construct($userName, $password, $token);

        $this->_params = array_merge($this->_params, array(
            array(
                "name" => "amount",
                "type" => "numeric",
                "required" => true,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "orderNumber",
                "type" => "string",
                "required" => true,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "returnUrl",
                "type" => "string",
                "required" => true,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "currency",
                "type" => "numeric",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "failUrl",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "dynamicCallbackUrl",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "email",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "phone",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "description",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "language",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "ip",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "pageView",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "clientId",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "merchantLogin",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "jsonParams",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "sessionTimeoutSecs",
                "type" => "numeric",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "expirationDate",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "bindingId",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            array(
                "name" => "features",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>false
            ),
            /**
             * Определяет тип используемого продуктивного URL
             */
            array(
                "name" => "prodURLType",
                "type" => "string",
                "required" => false,
                "value" => "",
                "service" =>true
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
        $this->_setParam('prodURLType', $prodURLType);
    }
}