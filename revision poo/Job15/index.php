<?php

declare(strict_types=1);

namespace App;

use DateTime;

use App\Electronic;
use App\Clothing;

date_default_timezone_set('Europe/Paris');
require_once './vendor/autoload.php';

// test des class
$manteau = new Clothing(325, 'manteau', ['https://picsum.photos/9000/3000'], 220, 'manteau enfant', 2, 6, new DateTime(), new DateTime(), 'S', 'vert', 'coton', 222);
$manteau->create();
echo "<pre>";
var_dump($manteau->addStocks(50)); //on ajoute 50 au stock de manteau
echo "</pre>";
echo "<pre>";
var_dump($manteau->removeStocks(5)); //on ajoute 50 au stock de manteau
echo "</pre>";
echo "<pre>";
echo $manteau->getStock();
echo "</pre>";
$electronic = new Electronic(450, 'PS2', ['https://picsum.photos/98/300'], 1000, "console", 2, 12, new DateTime(), new DateTime(), 'Sony', 22);
$electronic->create();
echo "<pre>";
var_dump($electronic->addStocks(40)); //on ajoute 50 au stock de manteau
echo "</pre>";
echo "<pre>";
var_dump($electronic->removeStocks(5)); //on ajoute 50 au stock de manteau
echo "</pre>";
echo "<pre>";
echo $electronic->getStock();
