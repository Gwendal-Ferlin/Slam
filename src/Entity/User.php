<?php

declare(strict_types = 1);

namespace MyApp\Entity;

class User{

    private ?int $id = null;
    private string $email;
    private string $lastName;
    private string $firstName;
    private string $password;
    private string $address;
    private string $postalCode;
    private string $city;
    private string $phone;
    private array $roles; 
    

    public function __construct(?int $id, string $email, string $lastName, string $firstName, string $password, string $address, string $postalCode, string $city, string $phone, array $roles){
        $this->id = $id;
        $this->email = $email;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->password = $password;
        $this->address = $address;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->phone = $phone;
        $this->roles = $roles;
    }

    public function setId(?int $id):void{
        $this->id = $id;
    }
    public function getId():?int{
        return $this->id;
    }

    public function getEmail():string{
        return $this->email;
    }
    public function setEmail(string $email): void
    {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    throw new InvalidArgumentException("Email invalide.");
    }
    $this->email = $email;
    }
    public function getlastName():string{
        return $this->lastName;
    }
    public function setlastName(string $lastName):void{
        $this->lastName = $lastName;
    }
    public function getfirstName():string{
        return $this->firstName;
    }
    public function setfirstName(string $firstName):void{
        $this->firstName = $firstName;
    }
    public function getaddress():string{
        return $this->address;
    }
    public function setaddress(string $address):void{
        $this->address = $address;
    }
    public function getpostalCode():string{
        return $this->postalCode;
    }
    public function setpostalCode(string $postalCode):void{
        $this->postalCode = postalCode;
    }
    public function getcity():string{
        return $this->city;
    }
    public function setcity(string $city):void{
        $this->city = $city;
    }
    public function getphone():string{
        return $this->phone;
    }
    public function setphone(string $phone):void{
        $this->phone = $phone;
    }
    public function getPassword(): string
 {
 return $this->password;
 }
 public function verifyPassword(string $password): bool
 {
 return password_verify($password , $this->password);
 }
 public function getRoles(): array
 {
 // Désérialise les rôles en tableau PHP
 return $this->roles;
 }
 public function setRoles(array $roles): void
 {
 $this->roles = $roles;
 }
}