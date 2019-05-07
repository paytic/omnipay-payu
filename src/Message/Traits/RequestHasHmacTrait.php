<?php

namespace ByTIC\Omnipay\Payu\Message\Traits;

use ByTIC\Omnipay\Payu\Message\Helper;

/**
 * Trait RequestHasHmacTrait
 * @package ByTIC\Omnipay\Payu\Message\Traits
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
