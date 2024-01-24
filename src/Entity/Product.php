<?php

declare(strict_types = 1);

namespace MyApp\Entity;

class Product{

    private ?int $id = null;
    private string $name;
    private string $description;
    private int $stock;
    private float $price;


    public function __construct(?int $id, string $name, string $description, float $price, int $stock){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function setId(?int $id):void{
        $this->id = $id;
    }
    public function getId():?int{
        return $this->id;
    }

    public function getname():string{
        return $this->name;
    }
    public function setname(string $name):void{
        $this->name = $name;
    }
    public function getdescription():string{
        return $this->description;
    }
    public function setdescription(string $description):void{
        $this->description = $description;
    }
    public function getprice():float{
        return $this->price;
    }
    public function setprice(float $price):void{
        $this->price = $price;
    }
        public function getstock():int{
        return $this->stock;
    }
    public function setstock(int $stock):void{
        $this->stock = $stock;
    }
}