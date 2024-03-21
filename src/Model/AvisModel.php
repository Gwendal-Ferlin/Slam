<?php
declare (strict_types = 1);
namespace MyApp\Model;

use MyApp\Entity\Avis;
use PDO;

class AvisModel
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;

    }
    public function createAvis(Avis $avis): bool
    {
        $sql = "INSERT INTO Avis (id, note, description, id_product, id_user) VALUES (NULL, :note, :description, :id_product, :id_user)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':note', $avis->getNote(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $avis->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':id_user', $avis->getId_user(), PDO::PARAM_STR);
        $stmt->bindValue(':id_product', $avis->getId_product(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAllAvisForProduct($id_product): array
    {
        $sql = "SELECT * FROM Avis WHERE id_product = $id_product";
        $stmt = $this->db->query($sql);
        $Avis = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Avis[] = new Avis($row['id'], $row['id_product'], $row['id_user'], $row['note'], $row['description']);
        }
        return $Avis;
    }
    public function getAllAvis(): array
    {
        $sql = "SELECT * FROM Avis";
        $stmt = $this->db->query($sql);
        $Avis = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Avis[] = new Avis($row['id'], $row['id_product'], $row['id_user'], $row['note'], $row['description']);
        }
        return $Avis;
    }

    public function getAllMoyenneAvisForProduct($tableau)
    {
        if ($tableau == []) {
            return 0;
        } else {

            $nombreAvis = count($tableau);
            $totalNotes = 0;

            foreach ($tableau as $avis) {
                $totalNotes += $avis->getnote(); // Assumant que getNote() est une méthode pour obtenir la note
            }
            $moyenneNotes = $totalNotes / $nombreAvis;
            return $moyenneNotes;
        }
    }
}
