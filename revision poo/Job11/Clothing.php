<?php
include_once 'Product.php';

class Clothing extends Product
{

    private string $size;
    private string $color;
    private string $type;
    private int $material_fee;
    private string $db_server = "localhost";
    private string $db_user = "root";
    private string $db_password = "";
    private string $db_name = "draft_shop";



    // Constructeur
    public function __construct(int|null $id = 0, string $name = "", array $photos = [], int $price = 0, string $description = "", int $quantity = 0, int $category_id = 0, DateTime $createdAt = new DateTime(), DateTime $updatedAt = new DateTime(), string $size = "", string $color = "", string $type = "", int $material_fee = 0)
    {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $category_id, $createdAt, $updatedAt);
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
    }
}
