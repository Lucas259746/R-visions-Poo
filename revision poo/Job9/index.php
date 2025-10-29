<?php

include_once 'class.php';

// test des class
$product = new Product(
    4,
    'Table de jardin',
    ['https://picsum.photos/9000/3000'],
    000,
    'Belle table de jardin en teck',
    10,
    25,
    new DateTime(),
    new DateTime()
);

$product->create();
echo "<pre>";
print_r($product);
echo "</pre>";
