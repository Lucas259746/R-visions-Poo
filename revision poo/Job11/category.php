<?php

declare(strict_types=1);
date_default_timezone_set('Europe/Paris');

// Classe Category


class Category
{
    private int $id = 58;
    private string $name;
    private string $description;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private string $db_server = "localhost";
    private string $db_user = "root";
    private string $db_password = "";
    private string $db_name = "draft_shop";



    // Constructeur
    public function __construct(int $id, string $name, string $description, DateTime $createdAt = new DateTime(), DateTime $updatedAt = new DateTime())
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
    // Méthode privée pour obtenir une connexion PDO
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
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getProducts(): array
    {
        $products = [];

        try {
            $conn = $this->PDB_connect();

            $stmt = $conn->prepare("SELECT * FROM product WHERE category_id = :category_id");
            $stmt->execute([':category_id' => $this->id]);
            $productDataList = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($productDataList as $data) {
                //  Récupérer les photos du produit
                $photoStmt = $conn->prepare("SELECT photo_url FROM photos WHERE product_id = :product_id");
                $photoStmt->execute([':product_id' => $data['id']]);
                $photoRows = $photoStmt->fetchAll(PDO::FETCH_ASSOC);
                $photos = [];
                foreach ($photoRows as $photo) {
                    $photos[] = $photo['photo_url'];
                }
                $product = new Product(
                    $data['id'],
                    $data['name'],
                    $photos,
                    $data['price'],
                    $data['description'],
                    $data['quantity'],
                    $data['category_id'],
                    new DateTime($data['created_at']),
                    new DateTime($data['updated_at'])
                );

                $products[] = $product;
            }
        } catch (Exception $e) {
            // Affiche ou logue l’erreur si besoin
            echo "Erreur lors de la récupération des produits : " . $e->getMessage();
        }

        return $products;
    }
}
