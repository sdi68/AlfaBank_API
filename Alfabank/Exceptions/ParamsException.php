<?php
/*
 * OrderParamsException.php
 * Created for project JOOMLA 3.x
 * subpackage PAYMENT/CPGALFABANK plugin
 * based on https://github.com/SatanaKonst/AlfaBank_API
 * version 1.0.0
 * https://econsultlab.ru
 * mail: info@econsultlab.ru
 * Released under the GNU General Public License
 * Copyright (c) 2022 Econsult Lab.
 */

namespace Alfabank\Exceptions;
use Exception;

class ParamsException extends Exception
{
    public function __construct($code = 0)
    {
        $message = 'PARAMS_EXCEPTIONS_CODE_'.$code.'_MSG';
        parent::__construct($message, $code);
    }

}
