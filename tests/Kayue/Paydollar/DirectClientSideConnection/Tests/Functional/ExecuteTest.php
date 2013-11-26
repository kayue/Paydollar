<?php

namespace Kayue\Paydollar\DirectClientSideConnection\Tests\Functional;

use Buzz\Client\Curl;
use Kayue\Paydollar\DirectClientSideConnection\Api;
use Kayue\Paydollar\Model\PaymentDetails;
use Kayue\Paydollar\DirectClientSideConnection\PaymentFactory;
use Payum\Request\CaptureRequest;

class ExecuteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testVisa()
    {
        //@testo:start
        $payment = PaymentFactory::create(new Api([
            'merchantId' => $GLOBALS['__KAYUE_PAYDOLLAR_MERCHANT_ID'],
            'sandbox' => true,
        ]));

        $orderRef = uniqid();

        $instruction = new PaymentDetails();
        $instruction->setOrderRef($orderRef);
        $instruction->setAmount('1.00');
        $instruction->setCurrCode(840);
        $instruction->setLang('E');
        $instruction->setPMethod(PaymentDetails::CREDITCARDTYPE_VISA);
        $instruction->setEpMonth('07');
        $instruction->setEpYear('2015');
        $instruction->setCardNo('4918914107195005');
        $instruction->setSecurityCode('123');
        $instruction->setCardHolder('Someone');
        $instruction->setSuccessUrl('http://google.com');
        $instruction->setFailUrl('http://google.com');
        $instruction->setErrorUrl('http://google.com');
        $instruction->setPayType(PaymentDetails::PAYMENTTYPE_NORMAL);

        $captureRequest = new CaptureRequest($instruction);
        $interactiveRequest = $payment->execute($captureRequest, true);

        $this->assertInstanceOf('Kayue\Paydollar\DirectClientSideConnection\Request\ResponseInteractiveRequest', $interactiveRequest);
        $this->assertContains("name=\"merchantId\" value=\"{$GLOBALS['__KAYUE_PAYDOLLAR_MERCHANT_ID']}\"", $interactiveRequest->getContent());
        $this->assertContains("name=\"orderRef\" value=\"{$orderRef}\"", $interactiveRequest->getContent());
    }
} 