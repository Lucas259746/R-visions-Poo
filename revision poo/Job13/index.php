<?php

include_once 'category.php';
include_once 'Clothing.php';
include_once 'electronic.php';
include_once 'Abstract_Product.php';

// test des class
echo "<pre>";
$elec = new Electronic();
var_dump($elec->FindAllElectronic());
echo "</pre>";
