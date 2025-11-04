<?php

declare(strict_types=1);

namespace App;

use App\Abstracts\AbstractProduct;
use App\Interfaces\StockableInterface;
use PDO;
use PDOException;
use Exception;
use DateTime;

class Electronic extends AbstractProduct implements StockableInterface
{

    private string $brand;
    private int $stock = 0;
    private int $warranty_fee;
    private string $db_server = "localhost";
    private string $db_user = "root";
    private string $db_password = "";
    private string $db_name = "draft_shop";



    // Constructeur
    public function __construct(int $id = 0, string $name = "", array $product_photo = [], int $price = 0, string $description = "", int $quantity = 0, int $category_id = 0, DateTime $createdAt = new DateTime(), DateTime $updatedAt = new DateTime(), string $brand = "", int $warranty_fee = 0)
    {
        parent::__construct($id, $name, $product_photo, $price, $description, $quantity, $category_id, $createdAt, $updatedAt);
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhotos(): array
    {
        return $this->product_photo;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getWarranty_fee(): int
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

    public function addStocks(int $stock): self
    {
        $this->stock += $stock;
        return $this;
    }

    public function removeStocks(int $stock): self
    {
        // Optionnel : prévenir stock négatif
        $this->stock = max(0, $this->stock - $stock);
        return $this;
    }
    public function getStock(): int
    {
        return $this->stock;
    }

    public function create(): Electronic|false
    {
        try {
            $conn = $this->PDB_connect();


            // 1. Insertion des infos dans la table "product"
            $stmt = $conn->prepare("INSERT INTO product (name, price, description, quantity, category_id, created_at, updated_at)
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
            $lastId = $conn->lastInsertId();
            $this->setId((int)$lastId);
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

    public function update(): Electronic|false
    {
        try {
            $conn = $this->PDB_connect();

            // 1. mise à jour du produit dans la table "product"
            $stmt = $conn->prepare(" UPDATE product SET name=:name,price=:price,description=:description,quantity=:quantity,category_id=:category_id,created_at=:created_at,updated_at=:updated_at WHERE id = :id ");
            $success = $stmt->execute([
                ':id' => $this->getId(),
                ':name' => $this->getName(),
                ':price' => $this->getPrice(),
                ':description' => $this->getDescription(),
                ':quantity' => $this->getQuantity(),
                ':category_id' => $this->getCategoryId(),
                ':created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
                ':updated_at' => $this->getUpdatedAt()->format('Y-m-d H:i:s')

            ]);
            if (!empty($this->photos)) {
                $photoStmt = $conn->prepare("
                UPDATE  photos SET photo_url=:photo_url WHERE product_id=:product_id
            ");

                foreach ($this->getPhotos() as $photo_url) {
                    $photoStmt->execute([
                        ':product_id' => $this->getId(),
                        ':photo_url' => $photo_url

                    ]);
                }
            }
            // 2. mise à jour des infos dans la table "electronic"
            $stmt = $conn->prepare(" UPDATE electronic SET brand=:brand,warranty_fee=:warranty_fee WHERE product_id = :product_id ");
            $success = $stmt->execute([
                ':brand' => $this->brand,
                ':warranty_fee' => $this->warranty_fee,
                ':product_id' => $this->getId()

            ]);
            return $this;
        } catch (Exception $e) {
            echo "Erreur lors de la mise à jour du produit : " . $e->getMessage();
            return false;
        }
    }

    public function FindElectronicById(int $id): void
    {
        $conn = $this->PDB_connect();

        $stmt = $conn->prepare("SELECT * FROM product WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->setId($data['id']);
        $this->setName($data['name']);
        $this->setPrice($data['price']);
        $this->setDescription($data['description']);
        $this->setQuantity($data['quantity']);
        $this->setCategoryId($data['category_id']);
        $this->setCreatedAt(new DateTime($data['created_at']));
        $this->setUpdatedAt(new DateTime($data['updated_at']));

        // 2. Requête photos du produit
        $photoStmt = $conn->prepare("SELECT photo_url FROM product_photo WHERE product_id = :id");
        $photoStmt->execute([':id' => $id]);
        $photoData = $photoStmt->fetchAll(PDO::FETCH_ASSOC);

        $photos = [];
        foreach ($photoData as $photo) {
            $photos[] = $photo['photo_url'];
        }

        // 3. Requête infos de electronic
        $electonicStmt = $conn->prepare("SELECT * FROM electronic WHERE product_id = :id LIMIT 1");
        $electonicStmt->execute([':id' => $id]);
        $electronic = $electonicStmt->fetch(PDO::FETCH_ASSOC);
        $this->setPhotos($photos);
        $this->brand = $electronic['brand'];
        $this->warranty_fee = $electronic['warranty_fee'];
    }

    public function FindAllElectronic(): array
    {
        $conn = $this->PDB_connect();

        $stmt = $conn->prepare("
        SELECT 
            p.id,
            p.name,
            p.price,
            p.description,
            p.quantity,
            p.category_id,
            p.created_at,
            p.updated_at,
            e.brand,
            e.warranty_fee
        FROM product p
        INNER JOIN electronic e ON p.id = e.product_id
    ");
        $stmt->execute();
        $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $results = [];

        foreach ($datas as $data) {
            // Get product photos
            $photoStmt = $conn->prepare("SELECT photo_url FROM product_photo WHERE product_id = :id");
            $photoStmt->execute([':id' => $data['id']]);
            $photoData = $photoStmt->fetchAll(PDO::FETCH_ASSOC);

            // Extract photo URLs
            $photos = array_column($photoData, 'photo_url');

            $data['photos'] = $photos;

            $results[] = $data;
        }

        return $results;
    }
}
