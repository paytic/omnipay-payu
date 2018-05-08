<?php

namespace ByTIC\Omnipay\Payu\Message;

use ByTIC\Omnipay\Common\Message\Traits\RedirectHtmlTrait;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * PayU Purchase Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    use RedirectHtmlTrait;
    /**
     * @return array
     */
    public function getRedirectData()
    {
        return $this->getData();
    }
}
