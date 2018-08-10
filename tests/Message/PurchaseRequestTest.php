<?php

namespace ByTIC\Omnipay\Payu\Tests\Message;

use ByTIC\Omnipay\Payu\Message\PurchaseRequest;
use ByTIC\Omnipay\Payu\Tests\AbstractTest;
use ByTIC\Omnipay\Payu\Tests\Fixtures\PayuData;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class PurchaseRequestTest
 * @package ByTIC\Omnipay\Payu\Tests\Message
 */
class PurchaseRequestTest extends AbstractTest
{

    /** @noinspection PhpMethodNamingConventionInspection */
    public function testGetDataWithItems()
    {
        $request = new PurchaseRequest(new \Guzzle\Http\Client(), new HttpRequest());
        $dataRequest = PayuData::getPurchaseRequest();
        $request->initialize($dataRequest);
        $data = $request->getData();

        self::assertTrue(isset($data['ORDER_PRICE'][0]));
        self::assertSame(30, $data['ORDER_PRICE'][0]);
    }

}