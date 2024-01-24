<?php

declare (strict_types = 1);

namespace MyApp\Model;

use MyApp\Entity\User;
use PDO;

class UserModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllUsers(): array
    {
        $sql = "SELECT * FROM User";
        $stmt = $this->db->query($sql);
        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($row['id'], $row['email'], $row['lastName'], $row['firstName'],'', $row['postalCode'], $row['address'], $row['city'], $row['phone'], json_decode($row['roles']));
        }

        return $users;
    }
    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM User WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new User($row['id'], $row['email'], $row['lastName'], $row['firstName'], $row['password'], $row['address'], $row['postalCode'], $row['city'], $row['phone'], json_decode($row['roles']));
    }

    public function getOneUser(int $id): ?User
    {
        $sql = "SELECT * from User where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new User($row['id'], $row['email'], $row['lastName'], $row['firstName'], $row['password'], $row['postalCode'], $row['address'], $row['city'], $row['phone'], json_decode($row['roles']));
    }

    public function updateUser(User $user): bool
    {
        $sql = "UPDATE User SET email = :email , password = :password , firstName = :firstName , lastName = :lastName, address = :address, postalCode = :postalCode, city = :city, phone = :phone, roles = :roles  WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':roles', json_encode($user->getRoles()));
        $stmt->bindValue(':firstName', $user->getfirstName(), PDO::PARAM_STR);
        $stmt->bindValue(':lastName', $user->getlastName(), PDO::PARAM_STR);
        $stmt->bindValue(':address', $user->getaddress(), PDO::PARAM_STR);
        $stmt->bindValue(':postalCode', $user->getpostalCode(), PDO::PARAM_STR);
        $stmt->bindValue(':city', $user->getcity(), PDO::PARAM_STR);
        $stmt->bindValue(':phone', $user->getphone(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function createUser(User $user): bool
    {
        $sql = "INSERT INTO User (firstName, lastName, email, password, address, postalCode, city, phone, roles) VALUES (:firstName, :lastName, :email, :password, :address, :postalCode, :city, :phone, :roles)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':firstName', $user->getfirstName(), PDO::PARAM_STR);
        $stmt->bindValue(':lastName', $user->getlastName(), PDO::PARAM_STR);
        $stmt->bindValue(':address', $user->getaddress(), PDO::PARAM_STR);
        $stmt->bindValue(':postalCode', $user->getpostalCode(), PDO::PARAM_STR);
        $stmt->bindValue(':city', $user->getcity(), PDO::PARAM_STR);
        $stmt->bindValue(':phone', $user->getphone(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':roles', json_encode($user->getRoles()));

        return $stmt->execute();
    }

    public function deleteUser(int $id): bool
    {
        $sql = "DELETE FROM User WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getUserById(int $id): ?User
    {
        $sql = "SELECT * FROM user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new User($row['id'], $row['name'], $row['email'], $row['password'],
            json_decode($row['roles']));
    }

}
