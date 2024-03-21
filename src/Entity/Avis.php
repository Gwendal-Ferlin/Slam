<?php
declare (strict_types = 1);
namespace MyApp\Entity;

use MyApp\Entity\Avis;

class Avis
{
    private ?int $id = null;
    private int $id_product;
    private string $id_user;
    private int $note;
    private string $description;
    public function __construct(?int $id, int $id_product, string $id_user, int $note, string $description)
    {
        $this->id = $id;
        $this->id_product = $id_product;
        $this->id_user = $id_user;
        $this->note = $note;
        $this->description = $description;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getId_product(): ?int
    {
        return $this->id_product;
    }
    public function setId_product(?int $id_product): void
    {
        $this->id_product = $id_product;
    }

    public function getId_user(): ?string
    {
        return $this->id_user;
    }
    public function setId_user(?int $id_user): void
    {
        $this->id_user = $id_user;
    }

    public function getnote(): ?int
    {
        return $this->note;
    }
    public function setnote(?int $note): void
    {
        $this->note = $note;
    }

    public function getdescription(): ?string
    {
        return $this->description;
    }
    public function setdescription(?string $description): void
    {
        $this->description = $description;
    }
}
