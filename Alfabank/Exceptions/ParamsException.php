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

namespace Alfabank\Exceptions;

use Exception;

class ParamsException extends Exception
{
    public function __construct($code = 0)
    {
        $message = 'PARAMS_EXCEPTIONS_CODE_' . $code . '_MSG';
        parent::__construct($message, $code);
    }

}
