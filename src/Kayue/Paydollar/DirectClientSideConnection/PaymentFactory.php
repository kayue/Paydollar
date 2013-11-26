<?php

namespace Kayue\Paydollar\DirectClientSideConnection;

use Kayue\Paydollar\DirectClientSideConnection\Action\ConnectionAction;
use Payum\Payment;
use Payum\Extension\EndlessCycleDetectorExtension;

class PaymentFactory 
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

        $payment->addAction(new ConnectionAction());

        return $payment;
    }

    /**
     */
    private function __construct()
    {
    }
} 