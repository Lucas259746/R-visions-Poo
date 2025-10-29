<?php

declare(strict_types=1);
date_default_timezone_set('Europe/Paris');

class Electronic extends Product
{

    private string $brand;
    private int $warranty_fee;
    private string $db_server = "localhost";
    private string $db_user = "root";
    private string $db_password = "";
    private string $db_name = "draft_shop";



    // Constructeur
    public function __construct(int|null $id = 0, string $name = "", array $photos = [], int $price = 0, string $description = "", int $quantity = 0, int $category_id = 0, DateTime $createdAt = new DateTime(), DateTime $updatedAt = new DateTime(), string $brand = "", int $warranty_fee = 0)
    {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $category_id, $createdAt, $updatedAt);
        $this->brand = $brand;
        $this->warranty_fee = $warranty_fee;
    }
}
