<?php

namespace ByTIC\Omnipay\Payu\Tests;

use ByTIC\Omnipay\Payu\Gateway;
use ByTIC\Omnipay\Payu\Message\PurchaseRequest;
use ByTIC\Omnipay\Payu\Message\PurchaseResponse;

/**
 * Class HelperTest
 * @package ByTIC\Omnipay\Payu\Tests
 */
class GatewayTest extends AbstractTest
{
    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

    public function testPurchase()
    {
        $gateway = new Gateway();

        $parameters = [
            'merchant' => $_ENV['PAYU_MERCHANT'],
            'secretKey' => $_ENV['PAYU_KEY'],
            'orderId' => '99',
            'orderName' => 'Test order name',
            'notifyUrl' => 'http://localhost',
            'returnUrl' => 'http://localhost',
            'amount' => 20.00,
            'card' => [
                'first_name' => '',
            ],
        ];
        $request = $gateway->purchase($parameters);
        self::assertInstanceOf(PurchaseRequest::class, $request);

        /** @var PurchaseResponse $response */
        $response = $request->send();
        self::assertInstanceOf(PurchaseResponse::class, $response);
        $data = $response->getRedirectData();
        self::assertSame('GALANTOM', $data['MERCHANT']);

        $payuResponse = $this->client->post($response->getRedirectUrl(), null, $data)->send();
        self::assertSame(200, $payuResponse->getStatusCode());

        $body = $payuResponse->getBody(true);
        self::assertContains('checkout.php', $body);
        self::assertContains('CART_ID=', $body);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->client = new \Guzzle\Http\Client();
    }
}
