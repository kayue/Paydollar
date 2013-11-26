<?php

namespace Kayue\Paydollar\DirectClientSideConnection;
use Buzz\Message\Response;
use Payum\Request\CaptureRequest;

class Api
{
    /**
     * @var array
     */
    protected $options;

    function __construct(array $options)
    {
        $this->options = $options;
    }

    public function createMiddlePage(CaptureRequest $request)
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
     * @return Response
     */
    protected function createResponse()
    {
        return new Response();
    }
}
