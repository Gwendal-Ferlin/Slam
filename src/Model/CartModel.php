<?php
declare (strict_types = 1);
namespace MyApp\Model;

use MyApp\Entity\Cart;
use PDO;

class CartModel
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;

    }
    public function getAllCarts(): array
    {
        $sql = "SELECT id_cart, creationdate, status, id_user FROM Cart";
        $stmt = $this->db->query($sql);
        $carts = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $carts[] = new Cart($row['id_cart'], $row['creationdate'], $row['status'], $row['id_user']);
        }
        return $carts;
    }
    public function getOneCart(int $id)
    {
        $sql = "SELECT
        c.id_cart,
        p.id AS product_id,
        p.name AS product_name,
        p.price AS product_price,
        ci.quantity AS product_quantity
    FROM
        Cart c
    INNER JOIN
        CartItem ci ON c.id_cart = ci.id_cart
    INNER JOIN
        Product p ON ci.id_product = p.id
    WHERE
        c.id_user  =:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            foreach ($result as $row) {
                $list[] = [
                    'id_cart' => $row['id_cart'],
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'product_price' => $row['product_price'],
                    'total_price' => $row['product_price'] * $row['product_quantity'],
                    'product_quantity' => $row['product_quantity'],
                ];
            }
        } else {
            $list[] = "Aucun produit trouvé dans le panier de l'utilisateur.";
        }
        return $list;
    }

    public function deleteCart(int $id): bool
    {
        $sql = "DELETE FROM CartItem WHERE id_cart = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $sql = "DELETE FROM Cart WHERE id_cart = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
