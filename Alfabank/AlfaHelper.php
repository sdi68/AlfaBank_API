<?php
/*
 * AlfaHelper.php
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

use Exception;

/**
 * Ошибка отсутствия данных в уведомлении от платежного шлюза
 * @since 1.0
 */

const PAYMENT_VALIDATION_ERROR_MISSING_DATA_CODE = 1000;
/**
 * Ошибка несоответствия суммы заказа сумме оплаты
 * @since 1.0
 */
const PAYMENT_VALIDATION_ERROR_AMOUNT_CODE = 1001;

/**
 * @version 1.0
 * @since version 1.0
 */
abstract class AlfaHelper
{

    /**
     * Логирование требует переопределения в наследнике
     * @param array $logdata
     * @param bool $enabled
     *
     * @return void
     * @since 1.0
     */
    public abstract static function _logging(array $logdata, bool $enabled = false);


    /**
     * Выводит текст, определяемый константой
     * Необходимо переопределить в наследнике, например для JOOMLA исполльзовать в конструкции JText::_($text)
     * Если входной параметр не константа, то возвращает false, в противном случае - текст
     * @param $text
     * @return false|mixed
     * @since version 1.0
     */
    protected abstract static function _translate($text);

    /**
     * @param array $data Параметры платежного уведомления альфа-банка
     * @param object $vars Параметры заказа
     * @param string $login Логин
     * @param string $password Пароль
     * @param string $returnURL URL возврата после платежа
     * @param bool $enable_log Разрешить логирование
     * @param bool $prod_mode Режим работы тест/продуктивный
     * @return array
     * @throws Exception
     * @since version 1.0
     *
    $vars->order_id = "JGOID-000124";
    $vars->client = "com_jgive";
    $vars->user_firstname = "дмитрий";
    $vars->user_lastname = "санаев";
    $vars->address = "";
    $vars->address2 = "";
    $vars->zipcode = "";
    $vars->contactNumber = "";
    $vars->countryName = "Russian Federation";
    $vars->stateName = "";
    $vars->cityName = "";
    $vars->user_id = 0;
    $vars->user_email = "dsanaev@mail.ru";
    $vars->item_name = "Волейбол женщины 50+ 2022 г";
    $vars->payment_description = "Благотворительное пожертвование в \"Фонд поддержки спортивных инициатив\"";
    $vars->submiturl = "/khochu-pomoch?task=donations.confirmpayment&processor=cpgalfabank&order_id=JGOID-000124";
    $vars->return = "https://www.sportcf.ru/index.php?option=com_jgive&view=donation&donationid=124&processor=cpgalfabank&email=6f327c68d1beaaeef308dad60ba67a38";
    $vars->cancel_return = "https://www.sportcf.ru/index.php?option=com_jgive&view=donation&donationid=124&processor=cpgalfabank&email=6f327c68d1beaaeef308dad60ba67a38";
    $vars->url = "https://www.sportcf.ru/index.php?option=com_jgive&task=donations.processPayment&processor=cpgalfabank&order_id=JGOID-000124";
    $vars->notify_url = "https://www.sportcf.ru/index.php?option=com_jgive&task=donations.notify&processor=cpgalfabank&order_id=JGOID-000124";
    $vars->campaign_promoter = "";
    $vars->currency_code = "RUB";
    $vars->amount = 666;
    $vars->is_recurring = 0;
    $vars->recurring_frequency = "";
    $vars->recurring_count = 0;
    $vars->country_code = "";
    $vars->adaptiveReceiverList = array();
     *
     */
    protected static final function validate($data, object $vars, string $login = '', string $password = '', string $returnURL = '', bool $enable_log = false, bool $prod_mode = false): array
    {
        static::_logging(array(static::_translate('PAYMENT_VALIDATION_STARTED')), $enable_log);
        if (is_array($data)) {

            $handler = new AlfaHandlerRest($login, $password, $returnURL);
            try {
                $orderInfo = $handler->getOrderInfo($data['mdOrder'], $prod_mode);
            } catch (Exception $e) {
                static::_logging(json_decode(json_encode($e), true), $enable_log);
                return array(
                    'error' =>
                        array(
                            'code' => $e->getCode(),
                            'message' => $e->getMessage())
                );
            }

            // Информация по платежу получена, проводим проверки
            if ($orderInfo['error']['code']) {
                // ОШИБКА. Ошибка проверки статуса оплаты
                static::_logging($orderInfo['error'], $enable_log);
                return array(
                    'error' =>
                        array(
                            'code' => $orderInfo['error']['code'],
                            'message' => $orderInfo['error']['msg']),
                    'status' => $orderInfo['status'],
                    'response' => $orderInfo,
                );
            }

            $order_amount = (float)$vars->amount * 100; // Процессинг возвращает сумму платежа в копейках
            $retrunamount = (float)$orderInfo['response']['Amount'];
            $epsilon = 0.01; // Допуск
            if (($order_amount - $retrunamount) > $epsilon) {
                // ОШИБКА. Не соответствие суммы заказа сумме оплаты
                static::_logging(array(
                    'code' => PAYMENT_VALIDATION_ERROR_AMOUNT_CODE,
                    'msg' => static::_translate('PAYMENT_VALIDATION_ERROR_AMOUNT_MSG')), $enable_log);
                return array(
                    'error' =>
                        array(
                            'code' => PAYMENT_VALIDATION_ERROR_AMOUNT_CODE,
                            'msg' => static::_translate('PAYMENT_VALIDATION_ERROR_AMOUNT_MSG')),
                    'status' => $orderInfo['status'],
                    'response' => $orderInfo,
                );
            }

            static::_logging(array('orderInfo' => $orderInfo), $enable_log);

            return $orderInfo;

        } else {
            // ОШИБКА. Не переданы параметры уведомления
            static::_logging(array(
                'code' => PAYMENT_VALIDATION_ERROR_MISSING_DATA_CODE,
                'msg' => static::_translate('PAYMENT_VALIDATION_ERROR_MISSING_DATA_MSG')), $enable_log);
            return array(
                'error' =>
                    array(
                        'code' => PAYMENT_VALIDATION_ERROR_MISSING_DATA_CODE,
                        'msg' => static::_translate('PAYMENT_VALIDATION_ERROR_MISSING_DATA_MSG')));
        }
    }
}