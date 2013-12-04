<?php

namespace Kayue\Paydollar;

abstract class Api
{
    const SUCCESSCODE_ERROR = -1;
    const SUCCESSCODE_SUCCEEDED = 0;
    const SUCCESSCODE_FAILURE = 1;

    const CREDITCARDTYPE_VISA = 'VISA';
    const CREDITCARDTYPE_MASTERCARD = 'Master';
    const CREDITCARDTYPE_DINERSCLUB = 'Diners';
    const CREDITCARDTYPE_JCB = 'JCB';
    const CREDITCARDTYPE_AMEX = 'AMEX';

    const PAYMENTTYPE_NORMAL = 'N';
    const PAYMENTTYPE_HOLD   = 'H';
} 