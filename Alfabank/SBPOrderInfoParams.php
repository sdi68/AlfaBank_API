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
 * Параметры запроса динамического QR кода
 * @version 1.0
 */
class SBPOrderInfoParams extends AbstractParams
{

    /**
     * @param string $userName Логин магазина, полученный при подключении
     * @param string $password Пароль магазина, полученный при подключении
     * @param string $token Токен безопасности (вместо логина и пароля)
     * @param string $mdOrder Номер заказа в системе платёжного шлюза.
     * @param string $qrId Идентификатор QR-кода.
     * @throws Exceptions\ParamsException
     * @since version 1.1
     */
    public function __construct(
        string $userName,
        string $password,
        string $token,
        string $mdOrder,
        string $qrId
    )
    {
        parent::__construct($userName, $password, $token);

        $this->_params = array_merge($this->_params, array(
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
        ));

        $this->_setParam('mdOrder', $mdOrder);
        $this->_setParam('qrId', $qrId);
    }
}