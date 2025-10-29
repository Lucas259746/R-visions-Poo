<?php

include_once 'category.php';
include_once 'Clothing.php';
include_once 'electronic.php';
include_once 'Product.php';

// test des class

$category1 = new Category(4, 'Vêtements', 'tous les vêtements');
$category2 = new Category(1, 'Electronique', 'Produits électroniques divers');

$clothing = new Clothing(77, 'jean', ['https://picsum.photos/988/300'], 100, 'jean de luxe', 2, $category1->getId(), new DateTime(), new DateTime(), 'XL', 'rouge', 'pantalon', 500);
echo "<pre>";
print_r($clothing);
echo "</pre>";
echo "<pre>";
$electronic = new Electronic(78, 'TV', ['https://picsum.photos/987/300'], 1000, "grand télévision", 2, $category2->getId(), new DateTime(), new DateTime(), 'Sony', 22);
print_r($electronic);
echo "</pre>";
