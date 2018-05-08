<?php

namespace ByTIC\Omnipay\Payu\Tests;

use ByTIC\Omnipay\Payu\Gateway;
use ByTIC\Omnipay\Payu\Message\PurchaseRequest;

/**
 * Class HelperTest
 * @package ByTIC\Omnipay\Payu\Tests
 */
class GatewayTest extends AbstractTest
{
    public function testGetSecureUrl()
    {
        $gateway = new Gateway();

        // INITIAL TEST MODE IS TRUE
        self::assertEquals(
            'http://sandboxsecure.mobilpay.ro',
            $gateway->getEndpointUrl()
        );
    }
}
