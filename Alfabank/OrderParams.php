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

use Alfabank\Exceptions\OrderParamsException;


/**
 * Код ошибки - несоответствие типа параметра
 * @since 1.0
 */
define('PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_NOT_ARRAY', 0);
/**
 * Код ошибки неизвестное имя параметра
 * @since 1.0
 */
define('PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_UNKNOWN_NAME', 1);
/**
 * Код ошибки неуказано значение обязательного параметра
 * @since 1.0
 */
define('PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_EMPTY_REQUIRED', 2);
/**
 * Код ошибки - не указан тип параметра
 * @since 1.0
 */
define('PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_MISSING_TYPE', 3);
/**
 * Код ошибки некорректный тип параметра
 * @since 1.0
 */
define('PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_WRONG_TYPE', 4);


/**
 * Класс параметров заказа
 * @since 1.0
 */
class OrderParams
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
     * @throws OrderParamsException
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
        $this->_setParam('userName', $userName);
        $this->_setParam('password', $password);
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

    public function getParamsArray($withEmptyNotRequired = false){
        $out = array();
        foreach ($this->_params as $param) {
            if(!$withEmptyNotRequired && $param['required'] == false && empty($param['value']))
                continue;
            $out[$param['name']] = $param['value'];
        }
        return $out;
    }

    /**
     * Получает параметр по наименованию
     * @param $paramName
     * @return array|mixed
     * @throws OrderParamsException
     * @since 1.0
     */
    public function getParamByName($paramName)
    {
        $key = $this->_getParamKey($paramName);
        if ($key === false) {
            throw new OrderParamsException(PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_UNKNOWN_NAME);
        }
        return $this->_params[$key];
    }

    /**
     * Устанавливает значение параметра по имени
     * @param $paramName
     * @param $paramValue
     * @return bool|false
     * @throws OrderParamsException
     * @since 1.0
     */
    private function _setParam($paramName, $paramValue)
    {
        $key = $this->_getParamKey($paramName);
        if ($key !== false) {
            $this->_params[$key]['value'] = $paramValue;
            return $this->_validate($key);
        }
        return false;
    }

    /**
     * Получает ключ параметра по наименованию
     * @param $paramName
     * @return false|int
     * @since 1.0
     */
    private function _getParamKey($paramName)
    {
        foreach ($this->_params as $key => &$param) {
            if ($param['name'] == $paramName) {
                return $key;
            }
        }
        return false;
    }


    /**
     * Проверяет значение параметра
     * @param $param
     *
     * @return bool
     *
     * @throws OrderParamsException
     * @since 1.0
     */
    private function _validate($key): bool
    {
        $param = &$this->_params[$key];
        if (!is_array($param)) {
            throw new OrderParamsException(PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_NOT_ARRAY);
        }

        if ($param['required'] && empty($param['value'])) {
            throw new OrderParamsException(PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_EMPTY_REQUIRED);
        }
        $func = '';
        switch ($param['type']) {
            case 'string':
                $func = 'is_string';
                break;
            case 'numeric':
                $func = 'is_numeric';
                break;
            default;
                throw new OrderParamsException(PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_MISSING_TYPE);
        }

        if (!$func($param['value'])) {
            throw new OrderParamsException(PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_WRONG_TYPE);
        }
        return true;
    }
}