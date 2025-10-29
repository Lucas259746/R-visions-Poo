<?php

include_once 'category.php';
include_once 'Clothing.php';
include_once 'electronic.php';
include_once 'Product.php';

// test des class

$clothing = new Clothing(
    300,
    'pyjama',
    ['https://picsum.photos/9000/3000'],
    220,
    'pyjama enfant',
    2,
    6,
    new DateTime('2025-01-01 10:00:00'),
    new DateTime('2025-01-01 10:00:00'),
    'S',
    'vert',
    'coton',
    222
);
$clothing->create();
echo "<pre>";
print_r($clothing);
echo "</pre>";
echo "<pre>";
$electronic = new Electronic(
    75,
    'Sega Saturn',
    ['https://picsum.photos/98/300'],
    1000,
    "console",
    2,
    12,
    new DateTime(),
    new DateTime(),
    'SEGA',
    22
);
$electronic->create();
print_r($electronic);
echo "</pre>";
