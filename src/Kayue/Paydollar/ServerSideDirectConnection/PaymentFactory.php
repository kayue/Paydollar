<?php

namespace Kayue\Paydollar\ServerSideDirectConnection;

use Kayue\Paydollar\ServerSideDirectConnection\Action\CaptureAction;
use Payum\Payment;
use Payum\Extension\EndlessCycleDetectorExtension;

abstract class PaymentFactory
{
    /**
     * @param Api $api
     *
     * @return Payment
     */
    public static function create(Api $api)
    {
        $payment = new Payment;

        $payment->addApi($api);

        $payment->addExtension(new EndlessCycleDetectorExtension);

        $payment->addAction(new CaptureAction);

        return $payment;
    }

    /**
     */
    private function __construct()
    {
    }
}