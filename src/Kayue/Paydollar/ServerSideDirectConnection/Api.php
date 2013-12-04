<?php

namespace Kayue\Paydollar\ServerSideDirectConnection;

use Buzz\Client\ClientInterface;
use Payum\Exception\Http\HttpException;
use Kayue\Paydollar\ServerSideDirectConnection\Bridge\Buzz\Request;
use Kayue\Paydollar\ServerSideDirectConnection\Bridge\Buzz\Response;

class Api extends \Kayue\Paydollar\Api
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var array
     */
    protected $options;

    function __construct(ClientInterface $client, array $options)
    {
        $this->client = $client;
        $this->options = $options;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function doPayment(Request $request)
    {
        $this->addOptions($request);

        return $this->doRequest($request);
    }

    /**
     * @param Request $request
     *
     * @throws HttpException
     *
     * @return Response
     */
    protected function doRequest(Request $request)
    {
        $request->setMethod('POST');
        $request->fromUrl($this->getApiEndpoint());

        $this->client->send($request, $response = $this->createResponse());

        if (false == $response->isSuccessful()) {
            throw HttpException::factory($request, $response);
        }

        return $response;
    }

    /**
     * @return string
     */
    protected function getApiEndpoint()
    {
        if($this->options['sandbox']) {
            return "https://test.paydollar.com/b2cDemo/eng/directPay/payComp.jsp";
        }

        return "https://www.paydollar.com/b2c2/eng/dPayment/payComp.jsp";
    }

    /**
     * @param Request $request
     */
    protected function addOptions(Request $request)
    {
        $request->setField('merchantId', $this->options['merchantId']);
    }

    /**
     * @return Response
     */
    protected function createResponse()
    {
        return new Response();
    }
} 