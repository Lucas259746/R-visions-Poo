<?php

use Soap\Url;

include_once 'class.php';

// test des class

$product1 = new Product();
$product1->DB_connect(1);
echo "<pre>";
print_r($product1);
echo "</pre>";
