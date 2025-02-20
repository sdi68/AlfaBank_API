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

use Alfabank\Exceptions\GatewayException;
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
     * @param array $data Параметры платежного уведомления альфа-банка
     * @param object $vars Параметры заказа
     * @param string $login Логин
     * @param string $password Пароль
     * @param string $token Токе безопасности (вместо логина и пароля)
     * @param string $returnURL URL возврата после платежа
     * @param bool $enable_log Разрешить логирование
     * @param bool $prod_mode Режим работы тест/продуктивный
     *
     * @return array
     * @throws GatewayException
     * @since version 1.0
     *
     */
    public static final function validate($data, object $vars, string $login = '', string $password = '', string $token = '', string $returnURL = '', bool $enable_log = false, bool $prod_mode = false): array
    {
        static::_logging(array(static::_translate('PAYMENT_VALIDATION_STARTED')), $enable_log);
        if (is_array($data)) {

            $handler = new AlfaHandlerRest($login, $password, $token, $returnURL);
            try {
                $params = new OrderStatusParams($login, $password, $token, (float)$vars->amount * 100, $data['mdOrder']);
                $orderInfo = $handler->getOrderInfo($params, $prod_mode);
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
            if ($orderInfo['ErrorCode']) {
                // ОШИБКА. Ошибка проверки статуса оплаты
                static::_logging($orderInfo, $enable_log);
                return array(
                    'error' =>
                        array(
                            'code' => $orderInfo['ErrorCode'],
                            'message' => $orderInfo['ErrorMessage']),
                    'status' => $orderInfo['OrderStatus'],
                    'response' => $orderInfo,
                );
            }

            $order_amount = (float)$vars->amount * 100; // Процессинг возвращает сумму платежа в копейках
            $retrunamount = (float)$orderInfo['Amount'];
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
}