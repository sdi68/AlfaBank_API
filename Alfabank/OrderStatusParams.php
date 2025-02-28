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

/**
 * Класс параметров запроса статуса заказа
 * @since 1.0
 */
class OrderStatusParams extends AbstractParams
{

    /**
     * Конструктор класса
     * @throws Exceptions\ParamsException
     * @since 1.0
     */
    public function __construct(
        string $userName,
        string $password,
        string $token,
        int    $amount,
        string $orderId,
        string $language = "ru"
    )
    {
        parent::__construct($userName, $password, $token);

        $this->_params = array_merge($this->_params, array(
            array(
                "name" => "amount",
                "type" => "numeric",
                "required" => true,
                "value" => 0
            ),
            array(
                "name" => "orderId",
                "type" => "string",
                "required" => true,
                "value" => ""
            ),
            array(
                "name" => "language",
                "type" => "string",
                "required" => false,
                "value" => ""
            )
        ));

        $this->_setParam('amount', $amount);
        $this->_setParam('orderId', $orderId);
        $this->_setParam('language', $language);
    }
}