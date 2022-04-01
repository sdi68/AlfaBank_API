<?php

namespace Alfabank\Exceptions;

use ReflectionClass;
use Exception;
use Alfabank\AlfaHelper;

/**
 * @package     Alfabank\Exceptions
 * @version 1.0.
 * @since version 1.0
 */
class GatewayException extends Exception
{
    /**
     * Код ошибки - параметры не установлены
     * @since version 1.0
     */
    public const GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE = 2001;

    /**
     * Код ошибки - процессинг возвратил NULL
     * @since version 1.0
     */
    public const GATEWAY_EXCEPTION_NULL_RETURNED_CODE = 2002;

    /**
     * @param $code
     * @param string|null $msg
     * @since version 1.0
     */
    public function __construct($code, string $msg="")
    {
        parent::__construct(empty($msg) ? $this->_getMessageConstName($code) : $msg,$code);
    }

    /**
     * Выводит название константы, значение которой равно тексту + суффикс
     * Если константы нет, то выводим входное значение
     *
     * @param string $val
     *
     * @return string
     *
     * @since version 1.0
     */
    private function _getMessageConstName (string $val):string {
        $rc = new ReflectionClass ( 'Alfabank\Exceptions\GatewayException' );
        $constants = $rc->getConstants();

        foreach ( $constants as $name => $value )
        {
            if ( $value == $val )
            {
                // нашли константу, выводим ее наименование с суффиксом
                return $name.'_MSG';
                break;
            }
        }
        // Констатнты с таким значением нет, выводим значение как есть
        return $val;
    }

}