<?php

namespace Kayue\Paydollar\DirectClientSideConnection;
use Buzz\Client\ClientInterface;
use Buzz\Message\Form\FormRequest;
use Buzz\Message\Response;

class Api
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

    public function createMiddlePage(FormRequest $request)
    {
        ob_start(); ?>

<!DOCTYPE html>
    <html>
    <head>
        <meta charset=utf-8 />
        <title>Reidrecting...</title>
    </head>
    <body>
    <form action='<?= $this->getApiEndpoint(); ?>' method='post' name='paydollar'>
        <? // TODO: build the hidden form ?>
    </form>
    <script>
        document.paydollar.submit();
    </script>
    </body>
</html>

        <?
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    /**
     * @return string
     */
    protected function getApiEndpoint()
    {
        if($this->options['sandbox']) {
            return "https://test.paydollar.com/b2cDemo/eng/dPayment/payComp.jsp";
        }

        return "https://www.paydollar.com/b2c2/eng/dPayment/payComp.jsp";
    }

    /**
     * @param FormRequest $request
     */
    protected function addOptions(FormRequest $request)
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
