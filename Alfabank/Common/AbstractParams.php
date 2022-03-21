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

namespace Alfabank\Common;

use Alfabank\Exceptions\ParamsException;


/**
 * Код ошибки - несоответствие типа параметра
 * @since 1.0
 */
define('PARAMS_EXCEPTIONS_CODE_NOT_ARRAY', 0);
/**
 * Код ошибки неизвестное имя параметра
 * @since 1.0
 */
define('PARAMS_EXCEPTIONS_CODE_UNKNOWN_NAME', 1);
/**
 * Код ошибки неуказано значение обязательного параметра
 * @since 1.0
 */
define('PARAMS_EXCEPTIONS_CODE_EMPTY_REQUIRED', 2);
/**
 * Код ошибки - не указан тип параметра
 * @since 1.0
 */
define('PARAMS_EXCEPTIONS_CODE_MISSING_TYPE', 3);
/**
 * Код ошибки некорректный тип параметра
 * @since 1.0
 */
define('PARAMS_EXCEPTIONS_CODE_WRONG_TYPE', 4);


/**
 * Класс параметров заказа
 * @since 1.0
 */
class AbstractParams
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
    );

    /**
     * Конструктор класса
     * @throws ParamsException
     * @since 1.0
     */
    public function __construct(
        string $userName,
        string $password)
    {
        $this->_setParam('userName', $userName);
        $this->_setParam('password', $password);
    }

    /**
     * Получает массив параметров
     * @param bool $withEmptyNotRequired Флаг выводить или нет необязательные параметры без значений
     * @return array
     * @since 1.0
     */
    public function getParamsArray(bool $withEmptyNotRequired = false): array
    {
        $out = array();
        foreach ($this->_params as $param) {
            if (!$withEmptyNotRequired && $param['required'] == false && empty($param['value']))
                continue;
            $out[$param['name']] = $param['value'];
        }
        return $out;
    }

    /**
     * Получает параметр по наименованию
     * @param $paramName
     * @return array|mixed
     * @throws ParamsException
     * @since 1.0
     */
    public function getParamByName($paramName)
    {
        $key = $this->_getParamKey($paramName);
        if ($key === false) {
            throw new ParamsException(PLG_CPGALFABANK_ORDER_PARAMS_EXCEPTIONS_CODE_UNKNOWN_NAME);
        }
        return $this->_params[$key];
    }

    /**
     * Устанавливает значение параметра по имени
     * @param $paramName
     * @param $paramValue
     * @return void
     * @throws ParamsException
     * @since 1.0
     */
    protected function _setParam($paramName, $paramValue): void
    {
        $key = $this->_getParamKey($paramName);
        if ($key !== false) {
            $this->_params[$key]['value'] = $paramValue;
            $this->_validate($key);
            return;
        }
    }

    /**
     * Получает ключ параметра по наименованию
     * @param $paramName
     * @return false|int
     * @since 1.0
     */
    private function _getParamKey($paramName)
    {
        foreach ($this->_params as $key => $param) {
            if ($param['name'] == $paramName) {
                return $key;
            }
        }
        return false;
    }


    /**
     * Проверяет значение параметра
     * @param $key
     * @return void
     *
     * @throws ParamsException
     * @since 1.0
     */
    private function _validate($key): void
    {
        $param = $this->_params[$key];
        if (!is_array($param)) {
            throw new ParamsException(PARAMS_EXCEPTIONS_CODE_NOT_ARRAY);
        }

        if ($param['required'] && empty($param['value'])) {
            throw new ParamsException(PARAMS_EXCEPTIONS_CODE_EMPTY_REQUIRED);
        }
        switch ($param['type']) {
            case 'string':
                $func = 'is_string';
                break;
            case 'numeric':
                $func = 'is_numeric';
                break;
            default;
                throw new ParamsException(PARAMS_EXCEPTIONS_CODE_MISSING_TYPE);
        }

        if (!$func($param['value'])) {
            throw new ParamsException(PARAMS_EXCEPTIONS_CODE_WRONG_TYPE);
        }
    }
}