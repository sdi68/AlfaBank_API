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

define('ALFABANK_ROOT_PATH', dirname(__FILE__));

function AlfabankLoadClass($className)
{
    if (strncmp('Alfabank', $className, 8) === 0) {
        $path = ALFABANK_ROOT_PATH;
        $length = 8;
    } else {
        return;
    }
    $path .= str_replace('\\', '/', substr($className, $length)) . '.php';

    if (file_exists($path)) {
        require $path;
    }
}

spl_autoload_register('AlfabankLoadClass');
