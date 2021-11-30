<?php

namespace Paytic\Omnipay\Payu\Message;

use Paytic\Omnipay\Common\Message\Traits\DataAccessorsTrait;
use Omnipay\Common\Message\AbstractResponse as CommonAbstractResponse;

/**
 * Class Response
 * @package Paytic\Omnipay\Payu\Message
 */
abstract class AbstractResponse extends CommonAbstractResponse
{
    use DataAccessorsTrait;

    /**
     * @inheritdoc
     */
    public function isSuccessful()
    {
        return
            isset($this->data['success'])
            && $this->data['success'];
    }
}
