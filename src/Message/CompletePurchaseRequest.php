<?php

namespace Paytic\Omnipay\Payu\Message;

use Paytic\Omnipay\Common\Message\Traits\GatewayNotificationRequestTrait;
use Paytic\Omnipay\Payu\Message\Traits\RequestHasHmacTrait;
use Paytic\Omnipay\Payu\Message\Traits\RequestHasSecretKeyTrait;
use Symfony\Component\HttpFoundation\HeaderUtils;

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
    public function isValidNotification()
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
    protected function determineReturnUrl(): string
    {
        $url = $this->httpRequest->getSchemeAndHttpHost()
            . $this->httpRequest->getBaseUrl()
            . $this->httpRequest->getPathInfo();

        $query = $this->httpRequest->server->get('QUERY_STRING');
        $params = HeaderUtils::parseQuery($query);
        unset($params['ctrl']);
        $url .= '?' . http_build_query($params, '', '&', \PHP_QUERY_RFC3986);

        return $url;
    }
}
