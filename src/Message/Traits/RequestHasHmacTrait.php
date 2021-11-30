<?php

namespace Paytic\Omnipay\Payu\Message\Traits;

use Paytic\Omnipay\Payu\Message\Helper;

/**
 * Trait RequestHasHmacTrait
 * @package Paytic\Omnipay\Payu\Message\Traits
 */
trait RequestHasHmacTrait
{

    /**
     * @param $data
     * @return string
     */
    protected function generateHmac($data)
    {
        $key = $this->getSecretKey();
        return Helper::generateHmac($data, $key);
    }
}
