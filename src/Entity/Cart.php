<?php
declare (strict_types = 1);
namespace MyApp\Entity;

use MyApp\Entity\Cart;

class Cart
{
    private ?int $id = null;
    private string $creationdate;
    private string $status;
    private int $id_user;
    public function __construct(?int $id, string $creationdate, string $status, int $id_user)
    {
        $this->id = $id;
        $this->creationdate = $creationdate;
        $this->status = $status;
        $this->id_user = $id_user;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCreationdate(): ?string
    {
        return $this->creationdate;
    }
    public function setCreationDate(?int $creationdate): void
    {
        $this->creationdate = $creationdate;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    public function getId_user(): ?int
    {
        return $this->id_user;
    }
    public function setId_user(?int $id_user): void
    {
        $this->id_user = $id_user;
    }

}
