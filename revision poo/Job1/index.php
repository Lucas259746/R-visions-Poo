<?php
include_once 'Product.php';
// Exemple d'utilisation et test avec var_dump()
$product1 = new Product(
    1,
    "Chaise design",
    ["photo1.jpg", "photo2.jpg"],
    150,
    "Une chaise confortable au design moderne.",
    10,
    new DateTime('2025-01-01 10:00:00'),
    new DateTime('2025-01-05 12:00:00')
);
$product2 = new Product(
    2,
    "Table en bois",
    ["table1.jpg", "table2.jpg"],
    300,
    "Une table robuste en bois massif.",
    5,
    new DateTime('2025-02-01 11:00:00'),
    new DateTime('2025-02-03 14:00:00')
);


// Affichage des propriétés via getters
echo "Nom du Produit : " . $product1->getName();
echo "<br>";
echo "Prix : " . $product1->getPrice() . " EUR";
echo "<br>";
echo "Description : " . $product1->getDescription();
echo "<br>";
echo "Quantité : " . $product1->getQuantity();
echo "<br>";
echo "Date de Création : " . $product1->getCreatedAt()->format('Y-m-d H:i:s');
echo "<br>";
echo "Date de mise a jour : " . $product1->getUpdatedAt()->format('Y-m-d H:i:s');
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

// Modification via setters
$product1->setPrice(160);
$product1->setQuantity(8);
$product1->setUpdatedAt(new DateTime('2025-04-10 15:00:00'));

echo "Après modification :\n";
echo "<br>";
echo "<br>";
echo "Prix : " . $product1->getPrice() . " EUR";
echo "<br>";
echo "Quantité : " . $product1->getQuantity();
echo "<br>";
echo "Date de mise a jour : " . $product1->getUpdatedAt()->format('Y-m-d H:i:s');
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "--------------------------------";
echo "<br>";
echo "Nom du Produit : " . $product2->getName();
echo "<br>";
echo "Prix : " . $product2->getPrice() . " EUR";
echo "<br>";
echo "Description : " . $product2->getDescription();
echo "<br>";
echo "Quantité : " . $product2->getQuantity();
echo "<br>";
echo "Date de Création : " . $product2->getCreatedAt()->format('Y-m-d H:i:s');
echo "<br>";
echo "Date de mise a jour : " . $product2->getUpdatedAt()->format('Y-m-d H:i:s');
echo "<br>";
