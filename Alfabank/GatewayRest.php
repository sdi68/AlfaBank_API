<?php
/*
 * GatewayRest.php
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
 *
 */
class GatewayRest
{

    /**
     * URL тестовой среды
     * @var string
     */
    protected string $GATEWAY_URL_DBG = 'https://web.rbsuat.com/ab/rest/';
    /**
     * URL продуктивной среды
     * @var string
     */
    protected string $GATEWAY_URL_PROD = 'https://pay.alfabank.ru/payment/rest/';

    /**
     * ФУНКЦИЯ ДЛЯ ВЗАИМОДЕЙСТВИЯ С ПЛАТЕЖНЫМ ШЛЮЗОМ
     * Для отправки POST запросов на платежный шлюз используется стандартная библиотека cURL.
     *
     * @param string $method Метод из API
     * @param array $data Массив данных
     * @param bool $prod Флаг работы в тестовой или продуктивной среде
     * @return array|mixed
     */
    private function gateway(string $method, array $data, bool $prod = false)
    {
        $curl = curl_init(); // Инициализируем запрос
        $url = $prod === true ? $this->GATEWAY_URL_PROD : $this->GATEWAY_URL_DBG;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . $method, // Полный адрес метода
            CURLOPT_RETURNTRANSFER => true, // Возвращать ответ
            CURLOPT_POST => true, // Метод POST
            CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
        ));
        $response = curl_exec($curl); // Выполняем запрос

        $response = json_decode($response, true); // Декодируем из JSON в массив
        curl_close($curl); // Закрываем соединение
        return $response; // Возвращаем ответ
    }

    /**
     * ОДНОСТАДИЙНЫЙ ПЛАТЕЖ
     * Запрос платежа
     *
     * @param array $data Данные платежа
     * @param bool $prod флаг тестовой или продуктивной среды
     * @return array
     * @throws GatewayException
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
     * @since version 1.0
     */
    public function registerDo(array $data, bool $prod = false)
    {
        if (count($data) == 0) {
            throw new GatewayException(GatewayException::GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE);
        }
        $response = $this->gateway('register.do', $data, $prod);
        if(is_null($response)) {
            throw new GatewayException(GatewayException::GATEWAY_EXCEPTION_NULL_RETURNED_CODE);
        }
        if (isset($response['errorCode'])) { // В случае ошибки вывести ее
            throw new GatewayException($response['errorCode'], $response['errorMessage']);
        } else { // В случае успеха перенаправить пользователя на платежную форму
            return $response;
        }
    }

    /**
     * ДВУХСТАДИЙНЫЙ ПЛАТЕЖ
     * Запрос предавторизации платежа
     *
     * @param array $data Данные платежа
     * @return array
     * @throws GatewayException
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
     * ПАРАМЕТРЫ ОТВЕТА
     * orderId            Номер заказа в платёжной системе. Уникален в пределах системы. Отсутствует если регистрация заказа на удалась по причине ошибки, детализированной в errorCode.
     * formUrl            URL платёжной формы, на который надо перенаправить броузер клиента. Не возвращается если регистрация заказа не удалась по причине ошибки, детализированной в errorCode.
     * errorCode        Код ошибки.
     * errorMessage        Описание ошибки на языке, переданном в параметре language в запросе.
     *
     * @since version 1.0
     */
    public function registerPreAuth(array $data): array
    {
        $response = $this->gateway('registerPreAuth.do', $data);
        if (isset($response['errorCode'])) { // В случае ошибки вывести ее
            throw new GatewayException($response['errorCode'], $response['errorMessage']);
        } else { // В случае успеха перенаправить пользователя на платежную форму
            return $response;
        }
    }

    /**
     * ЗАПРОС СТАТУСА ПЛАТЕЖА
     * @param array $data
     * @param bool $prod
     * @return array
     * @throws GatewayException
     * @since version 1.0
     *
     * ПАРАМЕТРЫ ОТВЕТА
     * OrderStatus        По значению этого параметра определяется состояние заказа в платёжной системе. Список возможных значений приведён в таблице ниже. Отсутствует, если заказ не был найден.
     *      0    Заказ зарегистрирован, но не оплачен
     *      1    Предавторизованная сумма захолдирована (для двухстадийных платежей)
     *      2    Проведена полная авторизация суммы заказа
     *      3    Авторизация отменена
     *      4    По транзакции была проведена операция возврата
     *      5    Инициирована авторизация через ACS банка-эмитента
     *      6    Авторизация отклонена
     * ErrorCode        Код ошибки.
     * ErrorMessage     Описание ошибки на языке, переданном в параметре Language в запросе.
     * OrderNumber      Номер (идентификатор) заказа в системе магазина
     * Pan              Маскированный номер карты, которая использовалась для оплаты. Указан только после оплаты заказа.
     * expiration       Срок истечения действия карты в формате YYYYMM. Указан только после оплаты заказа.
     * cardholderName   Имя держателя карты. Указан только после оплаты заказа.
     * Amount           Сумма платежа в копейках (или центах)
     * currency         Код валюты платежа ISO 4217. Если не указан, считается равным 810 (российские рубли).
     * approvalCode     Код авторизации МПС. Поле фиксированной длины (6 символов), может содержать цифры и латинские буквы.
     * authCode         Это поле является устаревшим. Его значение всегда равно "2", независимо от состояния заказа и кода авторизации процессинговой системы.
     * Ip               IP адрес пользователя, который оплачивал заказ
     * BindingInfo      Элемент состоит из параметров:
     *      clientId        Номер (идентификатор) клиента в системе магазина, переданный при регистрации заказа. Присутствует только если магазину разрешено создание связок.
     *      bindingId       Идентификатор связки созданной при оплате заказа или использованной для оплаты. Присутствует только если магазину разрешено создание связок.
     *
     */
    public function getOrderInfo(array $data, bool $prod = false): array
    {
        if (count($data) == 0) {
            throw new GatewayException(GatewayException::GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE);
        }
        $response = $this->gateway('getOrderStatus.do', $data, $prod);
        if ($response['ErrorCode']) {
            throw new GatewayException($response['ErrorCode'], $response['ErrorMessage']);
        } else {
            return $response;
        }
    }


    /**
     * Запрос получения QR кода
     * @param array $data Параметры запроса
     * @param bool $prod Режим работы: test or production
     * @return array
     * @throws GatewayException
     * @since version 1.1
     *
     * ПАРАМЕТРЫ ОТВЕТА
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
     */
    public function qetQR(array $data, bool $prod = false): array
    {
        if (count($data) == 0) {
            throw new GatewayException(GatewayException::GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE);
        }
        $response = $this->gateway('sbp/c2b/qr/dynamic/get.do', $data, $prod);
        if (isset($response['errorCode'])) { // В случае ошибки вывести ее
            throw new GatewayException($response['errorCode'], $response['errorMessage']);
        } else { // В случае успеха перенаправить пользователя на платежную форму
            return $response;
        }
    }


    /**
     * ЗАПРОС СТАТУСА ПЛАТЕЖА ПО QR КОДУ
     *
     * @param array $data
     * @param bool $prod
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
    public function getOrderInfoSBP(array $data, bool $prod = false): array
    {
        if (count($data) == 0) {
            throw new GatewayException(GatewayException::GATEWAY_EXCEPTION_EMPTY_PARAMS_CODE);
        }
        $response = $this->gateway('sbp/c2b/qr/status.do', $data, $prod);
        if ($response['ErrorCode']) {
            throw new GatewayException($response['errorCode'], $response['errorMessage']);
        } else {
            return $response;
        }
    }
}