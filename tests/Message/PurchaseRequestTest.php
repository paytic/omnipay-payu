<?php

namespace Paytic\Omnipay\Payu\Tests\Message;

use Paytic\Omnipay\Payu\Message\PurchaseRequest;
use Paytic\Omnipay\Payu\Tests\AbstractTest;
use Paytic\Omnipay\Payu\Tests\Fixtures\PayuData;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class PurchaseRequestTest
 * @package Paytic\Omnipay\Payu\Tests\Message
 */
class PurchaseRequestTest extends AbstractTest
{

    /** @noinspection PhpMethodNamingConventionInspection */
    public function testGetDataWithItems()
    {
        $request = new PurchaseRequest($this->getHttpClient(), new HttpRequest());
        $dataRequest = PayuData::getPurchaseRequest();
        $request->initialize($dataRequest);
        $data = $request->getData();

        self::assertTrue(isset($data['ORDER_PRICE'][0]));
        self::assertSame(30, $data['ORDER_PRICE'][0]);
    }
}
