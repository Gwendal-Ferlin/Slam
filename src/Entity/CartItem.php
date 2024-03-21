<?php
declare(strict_types=1);

namespace MyApp\Entity;

use MyApp\Entity\Product;

class CartItem
{
    private int $cartId;
    private Product $product;
    private int $quantity;
    private float $unitPrice;

    public function __construct(int $cartId, Product $product, int $quantity, float $unitPrice)
    {
        $this->cartId = $cartId;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }

    public function setCartId(int $cartId): void
    {
        $this->cartId = $cartId;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }
}