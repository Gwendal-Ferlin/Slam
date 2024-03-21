<?php
declare (strict_types = 1);
namespace MyApp\Model;

use MyApp\Entity\Product;
use MyApp\Entity\Type;
use PDO;

class ProductModel
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;

    }
    public function getAllProducts(): array
    {
        $sql = "SELECT p.id as idProduit, name, description, price, stock, t.id as id_Type, label
FROM Product p inner join Type t on p.id_Type = t.id order by name";
        $stmt = $this->db->query($sql);
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $type = new Type($row['id_Type'], $row['label']);
            $products[] = new Product($row['idProduit'], $row['name'], $row['description'],
                $row['price'], $row['stock'], $type);
        }
        return $products;
    }
    public function createProduct(Product $product): bool
    {
        $sql = "INSERT INTO Product (name, description, price, stock, id_Type) VALUES
(:name, :description, :price, :stock, :id_Type)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $product->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $product->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':price', $product->getPrice(), PDO::PARAM_STR);
        $stmt->bindValue(':stock', $product->getStock(), PDO::PARAM_INT);
        $stmt->bindValue(':id_Type', $product->getType()->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateProduct(Product $product): bool
    {
        $sql = "UPDATE product SET name = :name, description = :description, price = :price,
    stock = :stock, id_Type = :idType WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $product->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $product->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':price', $product->getPrice(), PDO::PARAM_STR);
        $stmt->bindValue(':stock', $product->getStock(), PDO::PARAM_INT);
        $stmt->bindValue(':idType', $product->getType()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':id', $product->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getOneProduct(int $id): ?Product
    {
        $sql = "SELECT p.id as idProduit, name, description, price, stock, t.id as id_Type, label
FROM Product p inner join Type t on p.id_Type = t.id where p.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $type = new Type($row['id_Type'], $row['label']);
        return new Product($row['idProduit'], $row['name'], $row['description'], $row['price'],
            $row['stock'], $type);
    }

    public function getProductById(int $id): ?Product
    {
        $sql = "SELECT p.id, t.id AS id_Type, label, name, description, price, stock FROM Product p inner JOIN Type t ON p.id_Type = t.id WHERE p.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', intVal($id));
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $type = new Type($row['id_Type'], $row['label']);
        return new Product($row['id'], $row['name'], $row['description'], $row['price'], $row['stock'], $type);
    }

    public function getPriceByIdProduct(int $id): ?float
    {
        $sql = "SELECT price FROM Product WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', intVal($id));
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return $row['price'];
    }
}
