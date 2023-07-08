<?php
declare(strict_types=1);

$parameters = $parameters ?? [];

$parameters = array_merge(
    $parameters,
    [
        'merchant' => getenv('PAYU_MERCHANT'),
        'secretKey' => getenv('PAYU_KEY'),
        'testMode' => true
    ]
);

return $parameters;
