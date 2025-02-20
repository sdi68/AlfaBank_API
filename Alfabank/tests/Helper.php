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

namespace Alfabank\tests;

use Alfabank\AlfaHelper;

class Helper extends AlfaHelper
{

    /**
     * @inheritDoc
     */
    public static function _logging(array $logdata, bool $enabled = false)
    {
        // TODO: Implement _logging() method.
        return;
    }

    /**
     * @inheritDoc
     */
    protected static function _translate($text)
    {
        // TODO: Implement _translate() method.
        return $text;
    }
}