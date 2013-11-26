<?php

namespace Kayue\Paydollar\DirectClientSideConnection\Action;

use Kayue\Paydollar\DirectClientSideConnection\Api;
use Kayue\Paydollar\DirectClientSideConnection\Request\ResponseInteractiveRequest;
use Payum\Action\ActionInterface;
use Payum\ApiAwareInterface;
use Payum\Exception\RequestNotSupportedException;
use Payum\Exception\UnsupportedApiException;
use Payum\Request\CaptureRequest;
use Symfony\Component\HttpFoundation\Response;

class ConnectionAction implements ActionInterface, ApiAwareInterface
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

        $html = $this->api->createMiddlePage($request);

        throw new ResponseInteractiveRequest($html);
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