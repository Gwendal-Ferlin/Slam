<?php

declare(strict_types = 1);

namespace MyApp\Model;

use MyApp\Entity\Product;
use PDO;
class ProductModel{
    private PDO $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function getAllProduct():array{
        $sql = "SELECT * FROM Product";
        $stmt = $this->db->query($sql);
        $produit=[];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $produit[]= new Product($row['id'], $row['name'], $row['description'], $row['price']);
        }

        return $produit;
    }

    public function createProduct(Product $product): bool
    {
        $sql = "INSERT INTO Product (name, description, price, stock) VALUES (:name, :description, :price, :stock)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $product->getname(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $product->getdescription(), PDO::PARAM_STR);
        $stmt->bindValue(':price', $product->getprice(), PDO::PARAM_STR);
        $stmt->bindValue(':stock', $product->getstock(), PDO::PARAM_STR);
        return $stmt->execute();
    }


}