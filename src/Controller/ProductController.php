<?php
declare (strict_types = 1);
namespace MyApp\Controller;

use MyApp\Entity\Product;
use MyApp\Model\ProductModel;
use MyApp\Model\TypeModel;
use MyApp\Service\DependencyContainer;
use Twig\Environment;

class ProductController
{
    private $twig;
    private ProductModel $productModel;
    private TypeModel $typeModel;
    public function __construct(Environment $twig, DependencyContainer
         $dependencyContainer) {
        $this->twig = $twig;
        $this->productModel = $dependencyContainer->get('ProductModel');
        $this->typeModel = $dependencyContainer->get('TypeModel');
    }
    public function listProducts()
    {
        $products = $this->productModel->getAllProducts();
        echo $this->twig->render('productController/produit.html.twig', ['products' =>
            $products]);
    }
    public function addProduct()
    {
        $types = $this->typeModel->getAllTypes();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description',
                FILTER_SANITIZE_STRING);
            $price = filter_input(INPUT_POST, 'price',
                FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);
            $idType = filter_input(INPUT_POST, 'id_Type',
                FILTER_SANITIZE_NUMBER_INT);
            if (!empty($name) && !empty($description) && !empty($price) && !empty($stock)
                && !empty($idType)) {
                $type = $this->typeModel->getTypeById(intVal($idType));
                if ($type == null) {
                    $_SESSION['message'] = 'Erreur sur le type.';
                } else {
                    $product = new Product(null, $name, $description, floatVal($price),
                        intVal($stock), $type);
                    $success = $this->productModel->createProduct($product);
                }
            } else {
                $_SESSION['message'] = 'Veuillez saisir toutes les données.';
            }
        }
        echo $this->twig->render('defaultController/addProduct.html.twig', ['types' => $types]);
    }

    public function updateProduct()
    {
        $types = $this->typeModel->getAllTypes();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description',
                FILTER_SANITIZE_STRING);
            $price = filter_input(INPUT_POST, 'price',
                FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);
            $idType = filter_input(INPUT_POST, 'idType',
                FILTER_SANITIZE_NUMBER_INT);
            if (!empty($id) && !empty($name) && !empty($description) && !empty($price)
                && !empty($stock) && !empty($idType)) {
                $product = $this->productModel->getOneProduct(intVal($id));
                if ($product == null) {
                    $_SESSION['message'] = 'Erreur sur le produit.';
                } else {
                    $type = $this->typeModel->getTypeById(intVal($idType));
                    if ($type == null) {
                        $_SESSION['message'] = 'Erreur sur le type.';
                    } else {
                        $product = new Product(intVal($id), $name, $description, floatVal($price),
                            intVal($stock), $type);
                        $success = $this->productModel->updateProduct($product);
                        if ($success) {
                            header('Location: index.php?page=produit');
                        } else {
                            $_SESSION['message'] = 'Erreur sur la modification.';
                            header('Location: index.php?page=produit');
                        }

                    }
                }
            } else {
                $_SESSION['message'] = 'Veuillez saisir toutes les données.';
            }
        } else {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $product = $this->productModel->getOneProduct(intVal($id));
            if ($product == null) {
                $_SESSION['message'] = 'Erreur sur le produit.';
                header('Location: index.php?page=produit');
            }
        }
        echo $this->twig->render('productController/updateProduct.html.twig',
            ['product' => $product, 'types' => $types]);
    }
}
