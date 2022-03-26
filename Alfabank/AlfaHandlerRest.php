<?php
/*
 * AlfaHandlerRest.php
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
use Alfabank\Exceptions\GatewayException;


/**
 * @version 1.1
 * @since 1.0
 */
class AlfaHandlerRest
{
    protected $USERNAME;
    protected $PASSWORD;
    protected $RETURN_URL;
    protected $client;


    /**
     * @param $USERNAME
     * @param $PASSWORD
     * @param $RETURN_URL
     * @throws GatewayException
     * @since version 1.0
     */
    public function __construct($USERNAME, $PASSWORD, $RETURN_URL)
    {
        if(empty($USERNAME) || empty($PASSWORD) || empty($RETURN_URL)){
            throw new GatewayException(GatewayException::GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE);
        }
        $this->USERNAME = $USERNAME;
        $this->PASSWORD = $PASSWORD;
        $this->RETURN_URL = $RETURN_URL;
        $this->client = new GatewayRest($this->USERNAME,$this->PASSWORD);
    }

    /**
     * ЗАПРОС РЕГИСТРАЦИИ ОДНОСТАДИЙНОГО ПЛАТЕЖА В ПЛАТЕЖНОМ ШЛЮЗЕ С ПОЛНЫМИ ПАРАМЕТРАМИ
     * @param OrderParams $orderParams Параметры запроса
     * @param bool $prod
     * @return array|null
     * @throws GatewayException
     * @since 1.1
     *
     * ПАРАМЕТРЫ ОТВЕТА
     * orderId            Номер заказа в платёжной системе. Уникален в пределах системы. Отсутствует если регистрация заказа на удалась по причине ошибки, детализированной в errorCode.
     * formUrl            URL платёжной формы, на который надо перенаправить броузер клиента. Не возвращается если регистрация заказа не удалась по причине ошибки, детализированной в errorCode.
     * errorCode        Код ошибки.
     * errorMessage        Описание ошибки на языке, переданном в параметре language в запросе.
     *
     * КОДЫ ОШИБОК
     * 0    Обработка запроса прошла без системных ошибок
     * 1    Заказ с таким номером уже обработан
     * 1    Заказ с таким номером был зарегистрирован, но не был оплачен
     * 1    Неверный номер заказа
     * 3    Неизвестная валюта
     * 4    Номер заказа не может быть пуст
     * 4    Имя мерчанта не может быть пустым
     * 4    Отсутствует сумма
     * 4    URL возврата не может быть пуст
     * 4    Пароль не может быть пуст
     * 5    Логин продавца неверен
     * 5    Неверная сумма
     * 5    Неправильный параметр 'Язык'
     * 5    Доступ запрещён
     * 5    Пользователь должен сменить свой пароль
     * 5    Доступ запрещён
     * 5    jsonParams неверен
     * 7    Системная ошибка
     * 13    Использование обоих значений Features FORCETDS/FORCESSL и AUTO_PAYMENT недопустимо
     * 13    Мерчант не имеет привилегии выполнять AUTO платежи
     * 13    Мерчант не имеет привилегии выполнять проверочные платежи
     * 14    Features указаны некорректно
     *
     */
    public function createOrderSinglePayment(OrderParams $orderParams, bool $prod=false ): array
    {
        $params = $orderParams->getParamsArray();
        return $this->client->registerDo($params,$prod);
    }

    /**
     * ЗАПРОС ДИНАМИЧЕСКОГО QR КОДА
     *
     * @param SBPParams $SBPParams
     * @param bool $prod
     * @return array
     * @throws GatewayException
     * @since 1.1
     *
     * ПАРАМЕТРЫ ОТВЕТА
     *
     * errorCode        Код ошибки.
     * errorMessage     Описание ошибки.
     * payload          Содержимое зарегистрированного в СБП QRкода. Присутствует, если значение qrStatus — STARTED.
     * qrId             Идентификатор QR-кода.
     * qrStatus         Состояние запроса QR_кода. Возможны следующие значения:
     *       STARTED - QR-код cформирован;
     *       CONFIRMED - заказ принят к оплате;
     *       REJECTED - оплата отклонена;
     *       REJECTED_BY_USER - оплате по QR-коду отклонена мерчантом;
     *       ACCEPTED - заказ оплачен.
     *
     */
    public function getOrderQR(SBPParams $SBPParams, bool $prod=false): array
    {
        $params = $SBPParams->getParamsArray();
        return $this->client->qetQR($params,$prod);
    }

    /**
     * РЕГИСТРАЦИЯ ДВУХСТАДИЙНОГО ПЛАТЕЖА В ПЛАТЕЖНОМ ШЛЮЗЕ
     *      registerOrder
     *
     * ПАРАМЕТРЫ
     *      merchantOrderNumber     Уникальный идентификатор заказа в магазине.
     *      amount                  Сумма заказа.
     *      returnUrl               Адрес, на который надо перенаправить пользователя в случае успешной оплаты.
     *
     * ОТВЕТ
     *      В случае ошибки:
     *          errorCode           Код ошибки. Список возможных значений приведен в таблице ниже.
     *          errorMessage        Описание ошибки.
     *
     *      В случае успешной регистрации:
     *          orderId             Номер заказа в платежной системе. Уникален в пределах системы.
     *          formUrl             URL платежной формы, на который надо перенаправить браузер клиента.
     *
     *  Код ошибки      Описание
     *      0           Обработка запроса прошла без системных ошибок.
     *      1           Заказ с таким номером уже зарегистрирован в системе;
     *                  Неверный номер заказа.
     *      3           Неизвестная (запрещенная) валюта.
     *      4           Отсутствует обязательный параметр запроса.
     *      5           Ошибка значения параметра запроса.
     *      7           Системная ошибка.
     *
     * @param string $orderNumber
     * @param int $amount (Минимальная единица валюты. Пример 1 копейка. Минимальный размер платежа 1 единица валюты - 1 рубль)
     * @param string $lang в формате 'ru','en'
     * @param string $currency код валюты по ISO 4217
     * @param bool $returnPaymentOrderId
     * @param bool $prod
     * @return array (в случае успеха возвращает ссылку на форму оплаты или ID в платежной системе если установлен $returnPaymentOrderId = true)
     * @throws Exceptions\GatewayException
     * @since 1.0
     */
    public function createOrderDoublePayment(string $orderNumber, int $amount, string $lang='ru', string $currency='', bool $returnPaymentOrderId=false, bool $prod=false): array
    {
        $params = array(
            'userName' => $this->USERNAME,
            'password' => $this->PASSWORD,
            'orderNumber' => urlencode($orderNumber),
            'amount' => urlencode($amount),
            'returnUrl' => $this->RETURN_URL,
            'language'=>$lang
        );
        if (!empty($currency)) {
            $params['currency'] = $currency;
        }
        return $this->client->registerPreAuth($params,$returnPaymentOrderId,$prod);

    }

    /**
     * ЗАПРОС СОСТОЯНИЯ ЗАКАЗА
     *      getOrderStatus
     *
     * ПАРАМЕТРЫ
     *      orderId         Номер заказа в платежной системе. Уникален в пределах системы.
     *
     * ОТВЕТ
     *      ErrorCode       Код ошибки. Список возможных значений приведен в таблице ниже.
     *      OrderStatus     По значению этого параметра определяется состояние заказа в платежной системе.
     *                      Список возможных значений приведен в таблице ниже. Отсутствует, если заказ не был найден.
     *
     *  Код ошибки      Описание
     *      0           Обработка запроса прошла без системных ошибок.
     *      2           Заказ отклонен по причине ошибки в реквизитах платежа.
     *      5           Доступ запрещён;
     *                  Пользователь должен сменить свой пароль;
     *                  Номер заказа не указан.
     *      6           Неизвестный номер заказа.
     *      7           Системная ошибка.
     *
     *  Статус заказа   Описание
     *      0           Заказ зарегистрирован, но не оплачен.
     *      1           Предавторизованная сумма захолдирована (для двухстадийных платежей).
     *      2           Проведена полная авторизация суммы заказа.
     *      3           Авторизация отменена.
     *      4           По транзакции была проведена операция возврата.
     *      5           Инициирована авторизация через ACS банка-эмитента.
     *      6           Авторизация отклонена.
     *
     * @param OrderStatusParams $data
     * @param bool $prod
     * @return array
     * @throws GatewayException
     * @since version 1.0
     */
    public function getOrderInfo(OrderStatusParams $data, bool $prod=false): array
    {
        $params = $data->getParamsArray();
        return $this->client->getOrderInfo($params,$prod);
    }


    /**
     * @param SBPOrderInfoParams $data  Параметры запроса
     * @param bool $prod                Флаг работы в тестовой или продуктивной среде
     * @return array
     * @throws GatewayException
     * @since version 1.1
     *
     * ПАРАМЕТРЫ ОТВЕТА
     * errorCode        Код ошибки.
     * errorMessage     Описание ошибки.
     * qrStatus         Состояние запроса QR_кода. Возможны следующие значения:
     *      STARTED - QR-код cформирован;
     *      CONFIRMED - заказ принят к оплате;
     *      REJECTED - оплата отклонена;
     *      REJECTED_BY_USER - оплате по QR-коду отклонена мерчантом;
     *      ACCEPTED - заказ оплачен.
     * qrType           Тип QR-кода:
     *      STATIC - статический;
     *      DYNAMIC - динамический.
     * В настоящее время всегда возвращается значение DYNAMIC.
     * transactionState Статус заказа:
     *      CREATED - создан;
     *      DECLINED - отклонён;
     *      DEPOSITED - оплачен
     *
     */
    public function getOrderInfoSBP(SBPOrderInfoParams $data, bool $prod=false): array {
        $params = $data->getParamsArray();
        return $this->client->getOrderInfoSBP($params,$prod);
    }

}