<?php

namespace Alfabank;
use Alfabank\Common\AbstractParams;

/**
 * Параметры запроса динамического QR кода
 * @version 1.0
 */
class SBPParams extends AbstractParams
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
    );


    /**
     * @param string $userName  Логин магазина, полученный при подключении
     * @param string $password  Пароль магазина, полученный при подключении
     * @param string $mdOrder   Номер заказа в системе платёжного шлюза.
     * @param string $qrHeight  Высота QR-кода в пикселах. Укажите, если требуется renderedQR. Минимальное значение: 10. Максимальное значение: 1000
     * @param string $qrWidth   Ширина QR-кода. Укажите, если требуется renderedQR. Минимальное значение: 10. Максимальное значение: 1000.
     * @param string $qrFormat  Возможные значения: matrix - вернёт матрицу из нулей и единиц; image - вернёт картинку в base64.
     * @throws Exceptions\ParamsException
     * @since version 1.0
     */
    public function __construct(
        string $userName,
        string $password,
        string $mdOrder,
        string $qrHeight = '',
        string $qrWidth = '',
        string $qrFormat = 'image'
    )
    {
        parent::__construct($userName, $password);

        $this->_setParam('mdOrder', $mdOrder);
        $this->_setParam('qrHeight', $qrHeight);
        $this->_setParam('qrWidth', $qrWidth);
        $this->_setParam('qrFormat', $qrFormat);
    }
}