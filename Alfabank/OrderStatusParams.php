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

use Alfabank\Common\AbstractParams;

/**
 * Класс параметров запроса статуса заказа
 * @since 1.0
 */
class OrderStatusParams extends AbstractParams
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
        ),
    );

    /**
     * Конструктор класса
     * @throws Exceptions\ParamsException
     * @since 1.0
     */
    public function __construct(
        string $userName,
        string $password,
        int    $amount,
        string $orderId,
        string $language = "ru"
    )
    {
        parent::__construct($userName, $password);

        $this->_setParam('amount', $amount);
        $this->_setParam('orderId', $orderId);
        $this->_setParam('language', $language);
    }
}