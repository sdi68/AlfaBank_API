<?php

namespace Alfabank\Exceptions;

use ReflectionClass;
use Exception;

class GatewayException extends Exception
{
    public const GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE = 2001;

    public function __construct($code, $msg="")
    {
        parent::__construct(empty($msg) ? $this->_getMessageConstName($code) : $msg,$code);
    }

    private function _getMessageConstName ($val):string {
        $rc = new ReflectionClass ( 'Alfabank\Exceptions\GatewayException' );
        $constants = $rc->getConstants();

        $constName = null;
        foreach ( $constants as $name => $value )
        {
            if ( $value == $val )
            {
                $constName = $name;
                break;
            }
        }

        return $constName.'_MSG';
    }

}