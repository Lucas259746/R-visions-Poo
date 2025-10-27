<?php

include_once 'class.php';

// test des class
$products = new Product();
$products->DB_connect(2);
echo "<pre>";
print_r($products);
echo "</pre>";
echo "<pre>";
var_dump($products->GetProductFromCategoryId(12));
echo "</pre>";
