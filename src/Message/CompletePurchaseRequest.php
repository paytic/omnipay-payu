<?php

namespace ByTIC\Omnipay\Payu\Message;

use ByTIC\Omnipay\Common\Message\Traits\GatewayNotificationRequestTrait;
use ByTIC\Omnipay\Payu\Message\Traits\RequestHasHmacTrait;
use ByTIC\Omnipay\Payu\Message\Traits\RequestHasSecretKeyTrait;

/**
 * Class PurchaseResponse
 * @package ByTIC\Common\Payments\Gateways\Providers\AbstractGateway\Messages
 */
class CompletePurchaseRequest extends AbstractRequest
{
    use GatewayNotificationRequestTrait;
    use RequestHasSecretKeyTrait;
    use RequestHasHmacTrait;

    /**
     * @return mixed
     */
    protected function isValidNotification()
    {
        return $this->hasGet('ctrl') && $this->isValidCtrl();
    }

    /**
     * @return bool|mixed
     */
    protected function parseNotification()
    {
        $data = $this->httpRequest->query->all();

        return $data;
    }

    /**
     * @return bool
     */
    protected function isValidCtrl()
    {
        $isValid = $this->httpRequest->query->get('ctrl') == $this->getCtrl();
        if ($isValid) {
            $this->setDataItem('success', true);
        }
        return $isValid;
    }

    /**
     * @return mixed
     */
    protected function getCtrl()
    {
        if (!$this->hasDataItem('ctrl')) {
            $this->setDataItem('ctrl', $this->generateCtrl());
        }

        return $this->getDataItem('ctrl');
    }

    /**
     * @return string
     */
    protected function generateCtrl()
    {
        $returnUrl = $this->determineReturnUrl();

        return $this->generateHmac(Helper::generateHashFromString($returnUrl));
    }

    /**
     * @return string
     */
    protected function determineReturnUrl()
    {
        $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        return $url;
    }
}
