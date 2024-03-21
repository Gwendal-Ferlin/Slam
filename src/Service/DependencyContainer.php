<?php
namespace MyApp\Service;

use MyApp\Model\AvisModel;
use MyApp\Model\ProductModel;
use MyApp\Model\TypeModel;
use MyApp\Model\UserModel;
use MyApp\Model\CartModel;
use MyApp\Model\CartItemModel;
use PDO;

class DependencyContainer
{
    private $instances = [];

    public function __construct()
    {
        $this->db = $this->createPDOInstance();
    }

    public function get($key)
    {
        if (!isset($this->instances[$key])) {
            $this->instances[$key] = $this->createInstance($key);
        }

        return $this->instances[$key];
    }

    private function createInstance($key)
    {
        switch ($key) {

            case 'PDO':return $this->createPDOInstance();
            case 'TypeModel':
                $pdo = $this->get('PDO');
                return new TypeModel($pdo);
            case 'ProductModel':
                $pdo = $this->get('PDO');
                return new ProductModel($pdo);
            case 'UserModel':
                $pdo = $this->get('PDO');
                return new UserModel($pdo);
            case 'AvisModel':
                $pdo = $this->get('PDO');
                return new AvisModel($pdo);
            case 'CartModel':
                $pdo = $this->get('PDO');
                return new CartModel($pdo);
            case 'CartItemModel':
                $pdo = $this->get('PDO');
                return new CartItemModel($pdo);
            default:
                throw new \Exception("No service found for key: " . $key);
        }
    }
    private function createPDOInstance()
    {
        try {
            $pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8', $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new \Exception("PDO erreur de connexion " . $e->getMessages());
        }
    }
    public function getDatabaseConnection(): PDO
    {
        return $this->db;
    }

}
