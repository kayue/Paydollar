<?php

namespace Kayue\Paydollar\Model;

use Kayue\Paydollar\Api;
use Payum\Exception\InvalidArgumentException;
use Payum\Exception\LogicException;
use Traversable;

/**
 * @see http://www.paydollar.com/pdf/paygate_integration_guide.pdf
 */
class PaymentDetails implements \ArrayAccess, \IteratorAggregate
{
    protected $request_orderRef;
    protected $request_amount;
    protected $request_currCode;
    protected $request_lang;
    protected $request_merchantId;
    protected $request_pMethod;
    protected $request_epMonth;
    protected $request_epYear;
    protected $request_cardNo;
    protected $request_securityCode;
    protected $request_cardHolder;
    protected $request_failUrl;
    protected $request_successUrl;
    protected $request_errorUrl;
    protected $request_payType;
    protected $request_remark;

    protected $response_successcode;
    protected $response_ref;
    protected $response_payRef;
    protected $response_amt;
    protected $response_cur;
    protected $response_prc;
    protected $response_src;
    protected $response_ord;
    protected $response_holder;
    protected $response_authId;
    protected $response_txTime;
    protected $response_errMsg;

    /**
     * Get Merchant's Order Reference Number
     *
     * @return string
     */
    public function getOrderRef()
    {
        return $this->request_orderRef;
    }

    /**
     * Set Merchant's Order Reference Number
     *
     * @param string $orderRef
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setOrderRef($orderRef)
    {
        if(strlen($orderRef) > 35) {
            throw new InvalidArgumentException('Merchant\'s Order Reference Number must not exceed 35 characters.');
        }
        $this->request_orderRef = $orderRef;
    }

    /**
     * The total amount your want to charge the customer.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->request_amount;
    }

    /**
     * @param string $amount total amount want to charge the customer, up to 2 decimal place.
     */
    public function setAmount($amount)
    {
        // TODO: add input checking here, up to 2 decimal place allowed (00.00)
        $this->request_amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrCode()
    {
        return $this->request_currCode;
    }

    /**
     * @param $currCode string 3 digit currecny code.
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setCurrCode($currCode)
    {
        if(!in_array($currCode, [
            '344',
            '840',
            '702',
            '156',
            '392',
            '901',
            '036',
            '978',
            '826',
            '124',
            '446',
            '608',
            '764',
            '458',
            '360',
            '410',
            '682',
            '554',
            '784',
            '096',
            '704',
        ])) {
            throw new InvalidArgumentException('Invalid currency code.');
        }

        $this->request_currCode = $currCode;
    }

    /**
     * Get the language of the payment page
     *
     * @return string
     */
    public function getLang()
    {
        return $this->request_lang;
    }

    /**
     * Set the language of the payment page
     *
     * @param string $lang Language code
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setLang($lang)
    {
        if(!in_array($lang, [
            'C', 'E', 'X', 'K', 'J', 'T'
        ])) {
            throw new InvalidArgumentException('Invalid language code.');
        }

        $this->request_lang = $lang;
    }

    /**
     * Get the merchant ID.
     *
     * @return int
     */
    public function getMerchantId()
    {
        return $this->request_merchantId;
    }

    /**
     * Set the merchant ID.
     *
     * @param int $merchantId The merchant ID PayDollar provide to you
     */
    public function setMerchantId($merchantId)
    {
        $this->request_merchantId = $merchantId;
    }

    /**
     * Get the payment card type
     *
     * @return string
     */
    public function getPMethod()
    {
        return $this->request_pMethod;
    }

    /**
     * Set the payment card type
     *
     * @param string $pMethod Payment card code.
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setPMethod($pMethod)
    {
        if(!in_array($pMethod, [
            Api::CREDITCARDTYPE_AMEX,
            Api::CREDITCARDTYPE_DINERSCLUB,
            Api::CREDITCARDTYPE_JCB,
            Api::CREDITCARDTYPE_MASTERCARD,
            Api::CREDITCARDTYPE_VISA,
        ])) {
            throw new InvalidArgumentException('Invalid payment card type.');
        }

        $this->request_pMethod = $pMethod;
    }

    /**
     * Get credit card expiry month
     *
     * @return string
     */
    public function getEpMonth()
    {
        return $this->request_epMonth;
    }

    /**
     * Set credit card expiry month
     *
     * @param string $epMonth expiry month
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setEpMonth($epMonth)
    {
        if((int) $epMonth < 1 || (int) $epMonth > 12) {
            throw new InvalidArgumentException('Invalid expiry month.');
        }

        // pad month with leading zero
        $epMonth = str_pad($epMonth, 2, "0", STR_PAD_LEFT);

        $this->request_epMonth = $epMonth;
    }

    /**
     * Get credit card expiry year
     *
     * @return string
     */
    public function getEpYear()
    {
        return $this->request_epYear;
    }

    /**
     * Set credit card expiry year
     *
     * @param string $epYear
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setEpYear($epYear)
    {
        if((int) $epYear < (int) date("Y") || strlen($epYear) !== 4) {
            throw new InvalidArgumentException('Invalid expiry year.');
        }

        $this->request_epYear = (string) $epYear;
    }

    /**
     * Set credit card number
     *
     * @return string
     */
    public function getCardNo()
    {
        return $this->request_cardNo;
    }

    /**
     * Get credit card number
     *
     * @param string $cardNo Credit card number
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setCardNo($cardNo)
    {
        if(strlen($cardNo) !== 16) {
            throw new InvalidArgumentException('Credit card number should be 16 digit.');
        }

        $this->request_cardNo = (string) $cardNo;
    }

    /**
     * Get credit card verification code (CVV)
     *
     * @return string
     */
    public function getSecurityCode()
    {
        return $this->request_securityCode;
    }

    /**
     * Set credit card verification code (CVV)
     *
     * @param string $securityCode Verification code
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setSecurityCode($securityCode)
    {
        if(strlen($securityCode) < 3 || strlen($securityCode) > 4) {
            throw new InvalidArgumentException('Credit card security code should be 3-4 digit.');
        }

        $this->request_securityCode = (string) $securityCode;
    }

    /**
     * Get credit card holder name
     *
     * @return string Card holder name
     */
    public function getCardHolder()
    {
        return $this->request_cardHolder;
    }

    /**
     * Set credit card holder name
     *
     * @param string $cardHolder Card holder name
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setCardHolder($cardHolder)
    {
        if(strlen($cardHolder) > 20) {
            throw new InvalidArgumentException('Card holder name must not exceed 20 characters.');
        }

        $this->request_cardHolder = $cardHolder;
    }

    /**
     * Get fail URL. A Web page address you want PayDollar to redirect upon the transaction being rejected by them.
     *
     * @return string
     */
    public function getFailUrl()
    {
        return $this->request_failUrl;
    }

    /**
     * Set fail URL. A Web page address you want PayDollar to redirect upon the transaction being rejected by them.
     *
     * @param string $failUrl The fail URL.
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setFailUrl($failUrl)
    {
        if(strlen($failUrl) > 300) {
            throw new InvalidArgumentException('Fail URL must not exceed 300 characters.');
        }

        $this->request_failUrl = $failUrl;
    }

    /**
     * Get success URL.
     *
     * @return string
     */
    public function getSuccessUrl()
    {
        return $this->request_successUrl;
    }

    /**
     * Set success URL. A Web page address you want PayDollar to redirect upon the transaction being accepted by them.
     *
     * @param string $successUrl
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setSuccessUrl($successUrl)
    {
        if(strlen($successUrl) > 300) {
            throw new InvalidArgumentException('Success URL must not exceed 300 characters.');
        }

        $this->request_successUrl = $successUrl;
    }

    /**
     * @return string
     */
    public function getErrorUrl()
    {
        return $this->request_errorUrl;
    }

    /**
     * @param string $errorUrl
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setErrorUrl($errorUrl)
    {
        if(strlen($errorUrl) > 300) {
            throw new InvalidArgumentException('Success URL must not exceed 300 characters.');
        }

        $this->request_errorUrl = $errorUrl;
    }

    /**
     * @return string
     */
    public function getPayType()
    {
        return $this->request_payType;
    }

    /**
     * @param string $payType
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function setPayType($payType)
    {
        if(!in_array($payType, [Api::PAYMENTTYPE_NORMAL, Api::PAYMENTTYPE_HOLD])) {
            throw new InvalidArgumentException('Invalid pay type.');
        }

        $this->request_payType = $payType;
    }

    /**
     * An additional remark field that will appear in the confirmation email and transaction detail report to help you
     * to refer the order
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->request_remark;
    }

    /**
     * An additional remark field that will appear in the confirmation email and transaction detail report to help you
     * to refer the order
     *
     * @param string $remark
     */
    public function setRemark($remark)
    {
        $this->request_remark = $remark;
    }

    /**
     * @param integer $successcode
     */
    public function setSuccesscode($successcode)
    {
        $this->response_successcode = $successcode;
    }

    /**
     * @return integer
     */
    public function getSuccesscode()
    {
        return $this->response_successcode;
    }

    /**
     * @param string $prefix
     *
     * @return array
     */
    protected function getProperties($prefix)
    {
        $properties = array();
        $reflection = new \ReflectionClass($this);
        /** @var $prop \ReflectionProperty */
        foreach ($reflection->getProperties() as $prop) {
            if ($prefix == substr($prop->getName(), 0, strlen($prefix))) {
                $name = $prop->getName();
                $properties[substr($prop->getName(), strlen($prefix))] = $this->$name;
            }
        }

        return $properties;
    }

    /**
     * @return array
     */
    public function getRequest()
    {
        return $this->getProperties('request_');
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->getProperties('response_');
    }

    /**
     * @param $nvp array|\Traversable
     * @throws \Payum\Exception\InvalidArgumentException
     */
    public function fromNvp($nvp)
    {
        if (false == (is_array($nvp) || $nvp instanceof \Traversable)) {
            throw new InvalidArgumentException('Invalid nvp argument. Should be an array of an object implemented Traversable interface.');
        }
        foreach ($nvp as $name => $value) {
            $name = 'response_' . strtolower($name);
            if (!property_exists($this, $name)) {
                trigger_error(
                    "Key '{$name}' does not exist in the repose: " . print_r($this->getResponse(), true),
                    E_USER_NOTICE
                );
            }
            $this->$name = $value;
        }
    }

    public function toNvp()
    {
        $properties = array_replace($this->getRequest(),$this->getResponse());

        return array_filter($properties, function($value) {
            return false === is_null($value);
        });
    }

    /**
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toNvp());
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->toNvp());
    }

    public function offsetGet($offset)
    {
        $nvp = $this->toNvp();

        return array_key_exists($offset, $nvp) ?
            $nvp[$offset] :
            null
            ;
    }

    public function offsetSet($offset, $value)
    {
        $this->fromNvp(array($offset => $value));
    }

    public function offsetUnset($offset)
    {
        throw new LogicException('Not implemented');
    }


}