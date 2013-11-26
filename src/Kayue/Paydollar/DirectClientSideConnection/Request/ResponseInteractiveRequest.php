<?php

namespace Kayue\Paydollar\DirectClientSideConnection\Request;

use Payum\Request\BaseInteractiveRequest;

class ResponseInteractiveRequest extends BaseInteractiveRequest
{
    protected $content;

    function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}