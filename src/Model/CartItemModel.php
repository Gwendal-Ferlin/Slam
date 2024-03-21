<?php
declare (strict_types = 1);
namespace MyApp\Model;

use MyApp\Entity\CartItem;
use PDO;

class CartItemModel
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;

    }
    public function getAllCartItems(): array
    {
        $sql = "SELECT ci.id_cart, ci.id_product, ci.quantity, ci.unitPrice, p.id as idProduit, p.name, p.description, p.price, p.stock, t.id as id_Type, t.label
            FROM CartItem ci
            INNER JOIN Product p ON ci.id_product = p.id
            INNER JOIN Type t ON p.id_Type = t.id";
        $stmt = $this->db->query($sql);
        $cartItems = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $type = new Type($row['id_Type'], $row['label']);
            $product = new Product($row['idProduit'], $row['name'], $row['description'],
                $row['price'], $row['stock'], $type);
            $cartItems[] = new CartItem($row['id_cart'], $product, $row['quantity'], $row['unitPrice']);
        }
        return $cartItems;
    }
}
