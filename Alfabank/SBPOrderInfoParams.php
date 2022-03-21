<?php

namespace Alfabank;
use Alfabank\Common\AbstractParams;

/**
 * Параметры запроса динамического QR кода
 * @version 1.0
 */
class SBPOrderInfoParams extends AbstractParams
{
    /**
     * Массив параметров заказа
     * @var array|array[]
     * @since version 1.0
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
            "name" => "mdOrder",
            "type" => "string",
            "required" => true,
            "value" => ""
        ),
        array(
            "name" => "qrId",
            "type" => "string",
            "required" => true,
            "value" => ""
        ),
    );


    /**
     * @param string $userName  Логин магазина, полученный при подключении
     * @param string $password  Пароль магазина, полученный при подключении
     * @param string $mdOrder   Номер заказа в системе платёжного шлюза.
     * @param string $qrId      Идентификатор QR-кода.
     * @throws Exceptions\ParamsException
     * @since version 1.1
     */
    public function __construct(
        string $userName,
        string $password,
        string $mdOrder,
        string $qrId
    )
    {
        parent::__construct($userName, $password);

        $this->_setParam('mdOrder', $mdOrder);
        $this->_setParam('qrId', $qrId);
    }
}