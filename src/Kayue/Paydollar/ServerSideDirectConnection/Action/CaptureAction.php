<?php

namespace Kayue\Paydollar\ServerSideDirectConnection\Action;

use Kayue\Paydollar\ServerSideDirectConnection\Api;
use Kayue\Paydollar\ServerSideDirectConnection\Bridge\Buzz\Request;
use Payum\Action\ActionInterface;
use Payum\ApiAwareInterface;
use Payum\Bridge\Spl\ArrayObject;
use Payum\Exception\RequestNotSupportedException;
use Payum\Exception\UnsupportedApiException;
use Payum\Request\CaptureRequest;

class CaptureAction implements ActionInterface, ApiAwareInterface
{
    /**
     * @var Api
     */
    protected $api;

    /**
     * {@inheritdoc}
     */
    public function setApi($api)
    {
        if (false == $api instanceof Api) {
            throw new UnsupportedApiException('Not supported.');
        }

        $this->api = $api;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($request)
    {
        /** @var $request CaptureRequest */
        if (false == $this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

         $model = new ArrayObject($request->getModel());

         $buzzRequest = new Request();
         $buzzRequest->setFields($model->toUnsafeArray());
         $response = $this->api->doPayment($buzzRequest);

        // TODO: Do something with the response here...
        // $model->replace($response);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return
            $request instanceof CaptureRequest &&
            $request->getModel() instanceof \ArrayAccess
            ;
    }
}