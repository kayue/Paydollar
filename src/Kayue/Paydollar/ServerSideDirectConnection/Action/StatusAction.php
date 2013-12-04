<?php

namespace Kayue\Paydollar\ServerSideDirectConnection\Action;

use Kayue\Paydollar\ServerSideDirectConnection\Api;
use Payum\Action\ActionInterface;
use Payum\Bridge\Spl\ArrayObject;
use Payum\Exception\RequestNotSupportedException;
use Payum\Request\StatusRequestInterface;

class StatusAction implements ActionInterface
{
    /**
     * @param mixed $request
     *
     * @throws \Payum\Exception\RequestNotSupportedException if the action dose not support the request.
     *
     * @return void
     */
    function execute($request)
    {
        /** @var $request StatusRequestInterface */
        if (false == $this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        $model = new ArrayObject($request->getModel());

        if (null === $model['successcode']) {
            $request->markNew();

            return;
        }

        if (Api::SUCCESSCODE_SUCCEEDED === $model['successcode']) {
            $request->markSuccess();

            return;
        }

        $request->markFailed();
    }

    /**
     * @param mixed $request
     *
     * @return boolean
     */
    function supports($request)
    {
        return
            $request instanceof StatusRequestInterface &&
            $request->getModel() instanceof \ArrayAccess
            ;
    }
} 