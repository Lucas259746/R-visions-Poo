<?php

include_once 'category.php';
include_once 'Clothing.php';
include_once 'electronic.php';
include_once 'Product.php';

// test des class
echo "<pre>";
$elec = new Clothing();
var_dump($elec->FindAllClothing());
echo "</pre>";
