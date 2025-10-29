<?php

include_once 'Product.php';

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

    private function PDB_connect(): PDO
    {
        try {
            $pdo = new PDO("mysql:host=$this->db_server;dbname=$this->db_name;", $this->db_user, $this->db_password);
            // Active le mode exception pour les erreurs SQL
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion PDO : " . $e->getMessage());
        }
    }

    // Getters
    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getWarranty_fee(): string
    {
        return $this->warranty_fee;
    }

    //Setters

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function setWarranty_fee(int $warranty_fee): void
    {
        $this->warranty_fee = $warranty_fee;
    }

    public function create(): Electronic|false
    {
        try {
            $conn = $this->PDB_connect();


            // 1. Insertion des infos dans la table "product"
            $stmt = $conn->prepare("
               INSERT INTO product (name, price, description, quantity, category_id, created_at, updated_at)
                VALUES (:name, :price, :description, :quantity, :category_id, :created_at, :updated_at)
            ");

            $success = $stmt->execute([
                ':name' => $this->getName(),
                ':price' => $this->getPrice(),
                ':description' => $this->getDescription(),
                ':quantity' => $this->getQuantity(),
                ':category_id' => $this->getCategoryId(),
                ':created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
                ':updated_at' => $this->getUpdatedAt()->format('Y-m-d H:i:s')

            ]);

            if (!$success) {
                return false;
            }
            // 2. Insertion des infos dans la table "clothing"
            $stmt = $conn->prepare("
                INSERT INTO electronic (brand, warranty_fee,product_id)
                VALUES (:brand, :warranty_fee, :product_id)
            ");
            // Récupérer l'ID généré automatiquement
            $this->setId($conn->lastInsertId());
            $success = $stmt->execute([
                ':brand' => $this->brand,
                ':warranty_fee' => $this->warranty_fee,
                ':product_id' => $this->getId()

            ]);

            if (!$success) {
                return false;
            }

            // 3. Insérer les photos si présentes
            if (!empty($this->getPhotos())) {
                $photoStmt = $conn->prepare("
                    INSERT INTO product_photo (photo_url,product_id)
                    VALUES (:photo_url,:product_id)
                ");

                foreach ($this->getPhotos() as $photo_url) {
                    $photoStmt->execute([

                        ':product_id' => $this->getId(),
                        ':photo_url' => $photo_url
                    ]);
                }
            }

            // 4. Retourner l'objet courant avec son ID

            return $this;
        } catch (Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
    }
}
