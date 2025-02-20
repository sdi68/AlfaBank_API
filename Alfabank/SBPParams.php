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
 * @version 1.0.2
 */
class SBPParams extends AbstractParams
{

    /**
     * @param string $userName Логин магазина, полученный при подключении
     * @param string $password Пароль магазина, полученный при подключении
     * @param string $token Токен безопасности (вместо логина и пароля)
     * @param string $mdOrder Номер заказа в системе платёжного шлюза.
     * @param string $qrHeight Высота QR-кода в пикселах. Укажите, если требуется renderedQR. Минимальное значение: 10. Максимальное значение: 1000
     * @param string $qrWidth Ширина QR-кода. Укажите, если требуется renderedQR. Минимальное значение: 10. Максимальное значение: 1000.
     * @param string $qrFormat Возможные значения: matrix - вернёт матрицу из нулей и единиц; image - вернёт картинку в base64.
     * @throws Exceptions\ParamsException
     * @since version 1.0
     */
    public function __construct(
        string $userName,
        string $password,
        string $token,
        string $mdOrder,
        string $qrHeight = '',
        string $qrWidth = '',
        string $qrFormat = 'image'
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
                "name" => "qrHeight",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "qrWidth",
                "type" => "string",
                "required" => false,
                "value" => ""
            ),
            array(
                "name" => "qrFormat",
                "type" => "string",
                "required" => false,
                "value" => "image"
            ),
        ));

        $this->_setParam('mdOrder', $mdOrder);
        $this->_setParam('qrHeight', $qrHeight);
        $this->_setParam('qrWidth', $qrWidth);
        $this->_setParam('qrFormat', $qrFormat);
    }
}