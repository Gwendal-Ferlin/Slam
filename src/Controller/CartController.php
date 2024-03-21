<?php

declare (strict_types = 1);

namespace MyApp\Controller;

use MyApp\Entity\CartItemModel;
use MyApp\Entity\CartModel;
use MyApp\Entity\ProductModel;
use MyApp\Service\DependencyContainer;
use Twig\Environment;

class CartController
{

    private $twig;
    private $dependencyContainer;

    public function __construct(Environment $twig, DependencyContainer $dependencyContainer)
    {
        $this->twig = $twig;
        $this->dependencyContainer = $dependencyContainer;
        $this->cartModel = $dependencyContainer->get('CartModel');
        $this->productModel = $dependencyContainer->get('ProductModel');
        $this->cartItemModel = $dependencyContainer->get('CartItemModel');
    }
    public function cart()
    {   
        $user_id = $_SESSION['id'];
        $panier = $this->cartModel->getOneCart($user_id);
        echo $this->twig->render('defaultController/cart.html.twig', ['panier' => $panier]);
    }
    public function cart_list()
    {   $paniers = $this->cartModel->getAllCarts();
        echo $this->twig->render('defaultController/cart_list.html.twig', ['paniers' => $paniers]);
    }
    public function cart_list2()
    {
        $user_id = intVal($_GET['id']);
        $panier = $this->cartModel->getOneCart($user_id);
        echo $this->twig->render('defaultController/cart.html.twig', ['panier' => $panier]);
    }
    public function add_to_cart()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?page=login');
        }
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];
        $id_user = $_SESSION['id'];
        $unitPrice = $this->productModel->getPriceByIdProduct(intVal($productId));

        $conn = $this->dependencyContainer->getDatabaseConnection();

        $sql_check_cart = "SELECT id_cart FROM Cart WHERE id_user = :id_user";
        $stmt_check_cart = $conn->prepare($sql_check_cart);
        $stmt_check_cart->bindParam(':id_user', $id_user);
        $stmt_check_cart->execute();

        if ($stmt_check_cart->rowCount() > 0) {
            $cartId = $stmt_check_cart->fetchColumn();

            $sql_check_product = "SELECT * FROM CartItem WHERE id_cart = :cartId AND id_product = :productId";
            $stmt_check_product = $conn->prepare($sql_check_product);
            $stmt_check_product->bindParam(':cartId', $cartId);
            $stmt_check_product->bindParam(':productId', $productId);
            $stmt_check_product->execute();

            if ($stmt_check_product->rowCount() > 0) {
                $sql_update_quantity = "UPDATE CartItem SET quantity = quantity + :quantity WHERE id_cart = :cartId AND id_product = :productId";
                $stmt_update_quantity = $conn->prepare($sql_update_quantity);
                $stmt_update_quantity->bindParam(':quantity', $quantity);
                $stmt_update_quantity->bindParam(':cartId', $cartId);
                $stmt_update_quantity->bindParam(':productId', $productId);
                $stmt_update_quantity->execute();

            } else {
                $sql_add_to_cart = "INSERT INTO CartItem (id_cart, id_product, quantity, unitPrice) VALUES (:cartId, :productId, :quantity, :unitPrice)";
                $stmt_add_to_cart = $conn->prepare($sql_add_to_cart);
                $stmt_add_to_cart->bindParam(':cartId', $cartId);
                $stmt_add_to_cart->bindParam(':productId', $productId);
                $stmt_add_to_cart->bindParam(':quantity', $quantity);
                $stmt_add_to_cart->bindParam(':unitPrice', $unitPrice);
                $stmt_add_to_cart->execute();

            }
        } else {
            $creationdate = date("Y-m-d");
            $status = "Ouvert";

            $sql_create_cart = "INSERT INTO Cart (creationdate, status, id_user) VALUES (:creationdate, :status, :id_user)";
            $stmt_create_cart = $conn->prepare($sql_create_cart);
            $stmt_create_cart->bindParam(':creationdate', $creationdate);
            $stmt_create_cart->bindParam(':status', $status);
            $stmt_create_cart->bindParam(':id_user', $id_user);
            $stmt_create_cart->execute();

            $cartId = $conn->lastInsertId();

            $sql_add_to_cart = "INSERT INTO CartItem (id_cart, id_product, quantity, unitPrice) VALUES (:cartId, :productId, :quantity, :unitPrice)";
            $stmt_add_to_cart = $conn->prepare($sql_add_to_cart);
            $stmt_add_to_cart->bindParam(':cartId', $cartId);
            $stmt_add_to_cart->bindParam(':productId', $productId);
            $stmt_add_to_cart->bindParam(':quantity', $quantity);
            $stmt_add_to_cart->bindParam(':unitPrice', $unitPrice);
            $stmt_add_to_cart->execute();
        }
        header('Location: index.php?page=cart');
    }

    public function delete_cart()
    {
        $id = $_GET['id_cart'];
        $this->cartModel->deleteCart(intVal($id));
        header('Location: index.php?page=cart_list');
    }

}
