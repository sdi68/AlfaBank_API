<?php
/*
 * autoload.php
 * Created for project JOOMLA 3.x
 * subpackage PAYMENT/CPGALFABANK plugin
 * based on https://github.com/SatanaKonst/AlfaBank_API
 * version 1.0.0
 * https://econsultlab.ru
 * mail: info@econsultlab.ru
 * Released under the GNU General Public License
 * Copyright (c) 2022 Econsult Lab.
 */

define('ALFABANK_ROOT_PATH', dirname(__FILE__));

function AlfabankLoadClass($className)
{
	if (strncmp('Alfabank', $className, 8) === 0) {
        $path   = ALFABANK_ROOT_PATH;
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
