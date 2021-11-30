<?php

namespace Paytic\Omnipay\Payu\Message;

use Paytic\Omnipay\Common\Message\Traits\GatewayNotificationResponseTrait;
use Paytic\Omnipay\Common\Message\Traits\HtmlResponses\ConfirmHtmlTrait;

/**
 * Class PurchaseResponse
 * @package ByTIC\Common\Payments\Gateways\Providers\AbstractGateway\Messages
 */
class CompletePurchaseResponse extends AbstractResponse
{
    use ConfirmHtmlTrait;
    use GatewayNotificationResponseTrait;

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        if (!$this->isSuccessful()) {
            return 'Error authorising payment';
        }

        return parent::getMessage();
    }
}
