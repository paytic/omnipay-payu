<?php

namespace Paytic\Omnipay\Payu\Tests\Message;

use Paytic\Omnipay\Payu\Message\CompletePurchaseRequest;
use Paytic\Omnipay\Payu\Tests\AbstractTest;
use Paytic\Omnipay\Payu\Tests\Fixtures\PayuData;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class CompletePurchaseRequestTest
 * @package Paytic\Omnipay\Payu\Tests\Message
 */
class CompletePurchaseRequestTest extends AbstractTest
{

    /** @noinspection PhpMethodNamingConventionInspection */
    public function testGetDataWithAuthorizedRequest()
    {
        $client = $this->getHttpClient();
        $httpRequest = PayuData::getConfirmAuthorizedRequest();
        $request = new CompletePurchaseRequest($client, $httpRequest);
        $data = $request->getData();

        self::assertArrayHasKey('ctrl', $data);

    }
}
