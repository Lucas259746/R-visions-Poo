<?php

declare(strict_types=1);
date_default_timezone_set('Europe/Paris');

class Product
{
    private int $id = 1;
    private string $name;
    private array $product_photo;
    private int $price;
    private string $description;
    private int $quantity;
    private int $category_id;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private string $db_server = "localhost";
    private string $db_user = "root";
    private string $db_password = "";
    private string $db_name = "draft_shop";


    // Constructeur
    public function __construct(int $id = 0, string $name = "", array $product_photo = [], int $price = 0, string $description = "", int $quantity = 0, int $category_id = 0, DateTime $createdAt = new DateTime(), DateTime $updatedAt = new DateTime())
    {
        $this->id = $id;
        $this->name = $name;
        $this->product_photo = $product_photo;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
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
    // Connexion à la BDD
    public function DB_connect(int $id)
    {
        $conn = $this->PDB_connect();

        $stmt = $conn->prepare("SELECT * FROM product WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT photo_url FROM product_photo WHERE product_id = :id ");
        $stmt->execute([':id' => $id]);
        $image = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $this->id = $product['id'];
        $this->name = $product['name'];
        foreach ($image as $product_photo) {
            $this->product_photo[] = $product_photo['photo_url'];
        }
        $this->price = $product['price'];
        $this->description = $product['description'];
        $this->quantity = $product['quantity'];
        $this->category_id = $product['category_id'];
        $this->createdAt = new DateTime($product['created_at']);
        $this->updatedAt = new DateTime($product['updated_at']);
        return true;
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

    public function getPhotos(): array
    {
        return $this->product_photo;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getCategoryid(): int
    {
        return $this->category_id;
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

    public function setPhotos(array $product_photo): void
    {
        $this->product_photo = $product_photo;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
    public function SetCategoryid(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    // get all infos from 1 product
    public function getAllInfos(): array
    {
        return [

            'id' => $this->id,
            'name' => $this->name,
            'photos' => $this->photos,
            'price' => $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'category_id' => $this->category_id,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }
    // get products by category id
    public function GetProductFromCategoryId(int $category_id): array
    {
        $conn = $this->PDB_connect();

        $stmt = $conn->prepare("SELECT * FROM product WHERE category_id = :category_id");
        $stmt->execute([':category_id' => $category_id]);

        // Fetch all matching products
        $products_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];

        foreach ($products_list as $product) {
            $products[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'photo_url' => $product['photo_url'] ?? null, // optional field
                'price' => $product['price'],
                'description' => $product['description'],
                'quantity' => $product['quantity'],
                'category_id' => $product['category_id'],
                'created_at' => $product['created_at'],
                'updated_at' => $product['updated_at'],
            ];
        }

        return $products_list;
    }
    // get product by id
    public function FindOneById(int $id): array
    {
        $conn = $this->PDB_connect();

        $stmt = $conn->prepare("SELECT * FROM product WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product ? $product : [];
    }
    // get all products
    public function FindAllProducts(): array
    {
        $conn = $this->PDB_connect();

        $stmt = $conn->prepare("SELECT * FROM product");
        $stmt->execute();
        $products_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products_list;
    }
    // ajouté un produit à la base de données
    public function create(): Product|false
    {
        try {
            $conn = $this->PDB_connect();

            // 1. Insertion du produit dans la table "product"
            $stmt = $conn->prepare("
            INSERT INTO product (name, price, description, quantity, category_id, created_at, updated_at)
            VALUES (:name, :price, :description, :quantity, :category_id, :created_at, :updated_at)
        ");

            $success = $stmt->execute([
                ':name' => $this->name,
                ':price' => $this->price,
                ':description' => $this->description,
                ':quantity' => $this->quantity,
                ':category_id' => $this->category_id,
                ':created_at' => $this->createdAt->format('Y-m-d H:i:s'),
                ':updated_at' => $this->updatedAt->format('Y-m-d H:i:s')
            ]);

            if (!$success) {
                return false;
            }

            // 2. Récupérer l'ID généré automatiquement
            $this->id = (int)$conn->lastInsertId();

            // 3. Insérer les photos si présentes
            if (!empty($this->photos)) {
                $photoStmt = $conn->prepare("
                INSERT INTO photos (photo_url,product_id)
                VALUES ( :photo_url,:product_id)
            ");

                foreach ($this->photos as $photo_url) {
                    $photoStmt->execute([

                        ':product_id' => $this->id,
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
    public function update(): Product|false
    {
        try {
            $conn = $this->PDB_connect();

            // 1. mise à jour du produit dans la table "product"
            $stmt = $conn->prepare(" UPDATE product SET name=:name,price=:price,description=:description,quantity=:quantity,category_id=:category_id,created_at=:created_at,updated_at=:updated_at WHERE id = :id ");
            $success = $stmt->execute([
                ':id' => $this->id,
                ':name' => $this->name,
                ':price' => $this->price,
                ':description' => $this->description,
                ':quantity' => $this->quantity,
                ':category_id' => $this->category_id,
                ':created_at' => $this->createdAt->format('Y-m-d H:i:s'),
                ':updated_at' => $this->updatedAt->format('Y-m-d H:i:s')
            ]);
            if (!empty($this->photos)) {
                $photoStmt = $conn->prepare("
                UPDATE  photos SET photo_url=:photo_url WHERE product_id=:product_id
            ");

                foreach ($this->photos as $photo_url) {
                    $photoStmt->execute([
                        ':product_id' => $this->id,
                        ':photo_url' => $photo_url

                    ]);
                }
            }
            return $this;
        } catch (Exception $e) {
            echo "Erreur lors de la mise à jour du produit : " . $e->getMessage();
            return false;
        }
    }
}





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
}
