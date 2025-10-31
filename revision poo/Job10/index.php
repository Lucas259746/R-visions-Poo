<?php

include_once 'class.php';

// test des class
$product = new Product();
$product->DB_connect(12);
echo "<pre>";
print_r($product);
echo "</pre>";
$updatedProduct = $product->setPrice(450);
$updatedProduct = $product->update();
echo "<pre>";
print_r($updatedProduct);
echo "</pre>";
