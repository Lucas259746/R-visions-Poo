<?php

include_once 'Abstract_Product.php';

interface StockableInterface
{
    public function addStocks(int $stock): self;
    public function removeStocks(int $stock): self;
}
