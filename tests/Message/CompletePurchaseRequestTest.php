<?php

namespace ByTIC\Omnipay\Payu\Tests\Message;

use ByTIC\Omnipay\Payu\Message\CompletePurchaseRequest;
use ByTIC\Omnipay\Payu\Tests\AbstractTest;
use ByTIC\Omnipay\Payu\Tests\Fixtures\PayuData;

/**
 * Class CompletePurchaseRequestTest
 * @package ByTIC\Omnipay\Payu\Tests\Message
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
