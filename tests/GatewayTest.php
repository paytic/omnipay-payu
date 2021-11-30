<?php

namespace Paytic\Omnipay\Payu\Tests;

use Paytic\Omnipay\Payu\Gateway;
use Paytic\Omnipay\Payu\Message\CompletePurchaseRequest;
use Paytic\Omnipay\Payu\Message\CompletePurchaseResponse;
use Paytic\Omnipay\Payu\Message\PurchaseRequest;
use Paytic\Omnipay\Payu\Message\PurchaseResponse;
use Paytic\Omnipay\Payu\Message\ServerCompletePurchaseResponse;
use Paytic\Omnipay\Payu\Tests\Fixtures\PayuData;
use Http\Discovery\Psr17FactoryDiscovery;
use Omnipay\Common\Http\Client;

/**
 * Class HelperTest
 * @package Paytic\Omnipay\Payu\Tests
 */
class GatewayTest extends AbstractTest
{
    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * @var Gateway
     */
    protected $gateway;

    public function testPurchase()
    {
        $httpClient = new Client();

        $parameters = [
            'orderId' => '99',
            'orderName' => 'Test order name',
            'notifyUrl' => 'http://localhost',
            'returnUrl' => 'http://localhost',
            'amount' => 20.00,
            'card' => [
                'first_name' => '',
            ],
        ];

        $request = $this->gateway->purchase($parameters);
        self::assertInstanceOf(PurchaseRequest::class, $request);

        /** @var PurchaseResponse $response */
        $response = $request->send();
        self::assertInstanceOf(PurchaseResponse::class, $response);
        $data = $response->getRedirectData();
        self::assertSame('GALANTOM', $data['MERCHANT']);

        $headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=utf-8';
        $body = Psr17FactoryDiscovery::findStreamFactory()->createStream(http_build_query($data, '', '&'));

        $payuResponse = $httpClient->request('POST', $response->getRedirectUrl(), $headers, $body);
        self::assertSame(200, $payuResponse->getStatusCode());

        $body = $payuResponse->getBody()->__toString();
        self::stringContains('checkout.php', $body);
        self::stringContains('CART_ID=', $body);
        self::stringContains('REF=99', $body);
    }

    public function testCompletePurchaseResponse()
    {
        $httpRequest = PayuData::getConfirmAuthorizedRequest();
        $response = $this->doCompletePurchaseResponse($httpRequest);
//        self::assertEquals(null, $response->getModel()->status);
    }

    /**
     * @param $httpRequest
     * @return CompletePurchaseResponse
     */
    protected function doCompletePurchaseResponse($httpRequest)
    {
        $this->gateway->setHttpRequest($httpRequest);
        /** @var CompletePurchaseRequest $request */
        $request = $this->gateway->completePurchase();
        /** @var CompletePurchaseResponse $response */
        $response = $request->send();

        self::assertInstanceOf(CompletePurchaseResponse::class, $response);
        self::assertTrue($response->isSuccessful());
        self::assertFalse($response->isCancelled());
        self::assertFalse($response->isPending());

        return $response;
    }

    public function testServerCompletePurchaseAuthorizedResponse()
    {
        $httpRequest = PayuData::getIpnAuthorizedRequest();
        $this->gateway->setHttpRequest($httpRequest);
        $request = $this->gateway->serverCompletePurchase();
        $response = $request->send();

        self::assertInstanceOf(ServerCompletePurchaseResponse::class, $response);
        $data = $response->getData();
        self::assertSame($data['hash'], $data['hmac']);
        self::assertTrue($response->isSuccessful());

        self::assertSame('PAYMENT_AUTHORIZED', $response->getCode());

        $notification = $response->getDataProperty('notification');
        self::assertCount(54, $notification);

        $content = $response->getContent();
        self::assertStringStartsWith('<EPAYMENT>', $content);
        self::assertStringEndsWith('</EPAYMENT>', $content);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this > $this->getHttpClient();

        $this->gateway = new Gateway();
        $this->gateway->setMerchant($_ENV['PAYU_MERCHANT']);
        $this->gateway->setSecretKey($_ENV['PAYU_KEY']);
    }
}
