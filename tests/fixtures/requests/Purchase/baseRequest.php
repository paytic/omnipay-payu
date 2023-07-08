<?php
declare(strict_types=1);

return [
    'orderId' => random_int(9999999, 9999999999999999),
    'orderName' => 'Order Name',
    'amount' => 12.34,
    'card' => [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '0741000111',
        'country' => 'Romania',
        'state' => 'Bucharest',
        'city' => 'Bucharest',
        'address1' => 'NoStreet',
        'email' => 'john.doe@gmail.com',
    ],
];
