<?php

namespace Paytic\Omnipay\Payu\Message\Traits;

/**
 * Trait RequestHasSecretKeyTrait
 * @package Paytic\Omnipay\Payu\Message\Traits
 *
 * @method setParameter($key, $value)
 * @method getParameter($key)
 */
trait RequestHasSecretKeyTrait
{

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }
}
