<?php
declare(strict_types=1);

require __DIR__ . '/init.php';

$gateway = new \Paytic\Omnipay\Payu\Gateway();
$gateway->initialize(require TEST_FIXTURE_PATH . '/enviromentParams.php');

$parameters = require TEST_FIXTURE_PATH . '/requests/Purchase/baseRequest.php';

$parameters['notifyUrl'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$parameters['notifyUrl'] = str_replace('card-redirect', 'card-return', $parameters['notifyUrl']);
$parameters['returnUrl'] = $parameters['notifyUrl'];

$request = $gateway->purchase($parameters);
$response = $request->send();

// Send the Symfony HttpRedirectResponse
$response->send();
