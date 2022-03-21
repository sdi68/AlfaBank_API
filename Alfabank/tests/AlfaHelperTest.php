<?php
/*
 * AlfaHelperTest.php
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

use PHPUnit\Framework\TestCase;
use Alfabank\tests\Helper;
require_once '../autoload.php';

class AlfaHelperTest extends TestCase
{
    protected $login = "";
    protected $password = "";
    protected $enable_log = true;
    protected $prod_mode = false;
    protected $returnUrl ="";
    protected $vars, $data;

    public function setUp():void {
        $this->vars = new class{};

        $this->vars->order_id = "JGOID-000124";
        $this->vars->client = "com_jgive";
        $this->vars->user_firstname = "дмитрий";
        $this->vars->user_lastname = "санаев";
        $this->vars->address = "";
        $this->vars->address2 = "";
        $this->vars->zipcode = "";
        $this->vars->contactNumber = "";
        $this->vars->countryName = "Russian Federation";
        $this->vars->stateName = "";
        $this->vars->cityName = "";
        $this->vars->user_id = 0;
        $this->vars->user_email = "dsanaev@mail.ru";
        $this->vars->item_name = "Волейбол женщины 50+ 2022 г";
        $this->vars->payment_description = "Благотворительное пожертвование в \"Фонд поддержки спортивных инициатив\"";
        $this->vars->submiturl = "/khochu-pomoch?task=donations.confirmpayment&processor=cpgalfabank&order_id=JGOID-000124";
        $this->vars->return = "https://www.sportcf.ru/index.php?option=com_jgive&view=donation&donationid=124&processor=cpgalfabank&email=6f327c68d1beaaeef308dad60ba67a38";
        $this->vars->cancel_return = "https://www.sportcf.ru/index.php?option=com_jgive&view=donation&donationid=124&processor=cpgalfabank&email=6f327c68d1beaaeef308dad60ba67a38";
        $this->vars->url = "https://www.sportcf.ru/index.php?option=com_jgive&task=donations.processPayment&processor=cpgalfabank&order_id=JGOID-000124";
        $this->vars->notify_url = "https://www.sportcf.ru/index.php?option=com_jgive&task=donations.notify&processor=cpgalfabank&order_id=JGOID-000124";
        $this->vars->campaign_promoter = "";
        $this->vars->currency_code = "RUB";
        $this->vars->amount = 666;
        $this->vars->is_recurring = 0;
        $this->vars->recurring_frequency = "";
        $this->vars->recurring_count = 0;
        $this->vars->country_code = "";
        $this->vars->adaptiveReceiverList = array();
        $this->data = json_decode('{"orderNumber":"JGOID-000124","mdOrder":"00847f61-237e-74df-a4d2-bc0502084b8b","operation":"deposited","status":"1"}',true);
        $this->login = "sportcf-api";
        $this->password = "sportcf*?1";
        $this->prod_mode = false;
        $this->enable_log = true;
        $this->returnUrl = $this->vars->return;
    }



    public function testValidateSuccessPayment()
    {
        $response = Helper::validate($this->data,$this->vars,$this->login, $this->password,$this->returnUrl, $this->enable_log,$this->prod_mode);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('status',$response);
        $this->assertArrayHasKey('response',$response);
        $this->assertArrayHasKey('error',$response);
        $this->assertEquals($response['error']['code'],0);
        $this->assertEquals($response['status']['code'],2);

    }
    public function testValidateErrorPaymentAmount()
    {
        // Несоответствие суммы заказа
        $this->vars->amount = 1000;
        $response = Helper::validate($this->data,$this->vars,$this->login, $this->password,$this->returnUrl, $this->enable_log,$this->prod_mode);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('status',$response);
        $this->assertArrayHasKey('response',$response);
        $this->assertArrayHasKey('error',$response);
        $this->assertEquals(PAYMENT_VALIDATION_ERROR_AMOUNT_CODE,$response['error']['code']);
        $this->assertEquals(2,$response['status']['code']);
    }

    public function testValidateErrorPaymentNoPayment()
    {
        // Ошибка Неизвестный номер заказа
        $this->data['mdOrder'] = "00847f61-237e-74df-a4d2-bc0502084b8b".'q';
        $response = Helper::validate($this->data,$this->vars,$this->login, $this->password,$this->returnUrl, $this->enable_log,$this->prod_mode);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('status',$response);
        $this->assertArrayHasKey('response',$response);
        $this->assertArrayHasKey('error',$response);
        $this->assertEquals(6,$response['error']['code']);
        $this->assertEquals(null,$response['status']['code']);
    }
}
