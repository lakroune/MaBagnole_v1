<?php

namespace app\model;


use app\model\Connexion;

class Vehicule
{
    private int $idVehicule;
    private string $marqueVehicule;
    private string $modeleVehicule;
    private string $anneeVehicule;
    private string $imageVehicule;
    private string $typeBoiteVehicule;
    private string $typeCarburantVehicule;
    private string $couleurVehicule;
    private float $prixVehicule;
    private int $statusVehicule;
    private int $idCategorie;

    //constructeur par default
    public function __construct() {}
    //getters
    public function getIdVehicule(): int
    {
        return $this->idVehicule;
    }


    public function getMarqueVehicule(): string
    {
        return $this->marqueVehicule;
    }

    public function getModeleVehicule(): string
    {
        return $this->modeleVehicule;
    }

    public function getAnneeVehicule(): string
    {
        return $this->anneeVehicule;
    }

    public function getImageVehicule(): string
    {
        return $this->imageVehicule;
    }

    public function getTypeBoiteVehicule(): string
    {
        return $this->typeBoiteVehicule;
    }

    public function getTypeCarburantVehicule(): string
    {
        return $this->typeCarburantVehicule;
    }

    public function getCouleurVehicule(): string
    {
        return $this->couleurVehicule;
    }

    public function getPrixVehicule(): float
    {
        return $this->prixVehicule;
    }

    public function getStatusVehicule(): int
    {
        return $this->statusVehicule;
    }

    public function getIdCategorie(): int
    {
        return $this->idCategorie;
    }

    //setters
    public function setIdVehicule(int $idVehicule): void
    {
        if (empty($idVehicule))
            throw new \InvalidArgumentException("ID vehicule invalide");
        $this->idVehicule = $idVehicule;
    }

    public function setMarqueVehicule(string  $marqueVehicule): void
    {
        if (empty($marqueVehicule)) {
            throw new \InvalidArgumentException("La marque est obligatoire");
        } else
            $this->marqueVehicule = $marqueVehicule;
    }


    public function setModeleVehicule(string $modeleVehicule): void
    {
        if (empty($modeleVehicule)) {
            throw new \InvalidArgumentException("Le modele est obligatoire");
        } else
            $this->modeleVehicule = $modeleVehicule;
    }

    public function setAnneeVehicule(string $anneeVehicule): void
    {
        if (empty($anneeVehicule)) {
            throw new \InvalidArgumentException("L'annee est obligatoire");
        } else
            $this->anneeVehicule = $anneeVehicule;
    }

    public function setImageVehicule(string $imageVehicule): void
    {
        if ($imageVehicule < 1) {
            throw new \InvalidArgumentException("La photo est obligatoire");
        } else
            $this->imageVehicule = $imageVehicule;
    }



    public function setTypeBoiteVehicule(string $typeBoiteVehicule): void
    {
        if (empty($typeBoiteVehicule)) {
            throw new \InvalidArgumentException("Le type de boite est obligatoire");
        } else
            $this->typeBoiteVehicule = $typeBoiteVehicule;
    }

    public function setTypeCarburantVehicule(string $typeCarburantVehicule): void
    {
        if (empty($typeCarburantVehicule)) {
            throw new \InvalidArgumentException("Le type de carburant est obligatoire");
        } else
            $this->typeCarburantVehicule = $typeCarburantVehicule;
    }

    public function setCouleurVehicule(string $couleurVehicule): void
    {
        if (empty($couleurVehicule)) {
            throw new \InvalidArgumentException("La couleur est obligatoire");
        } else
            $this->couleurVehicule = $couleurVehicule;
    }

    public function setPrixVehicule(float $prixVehicule): void
    {
        if ($prixVehicule <= 0) {
            throw new \InvalidArgumentException("Le prix est obligatoire");
        } else
            $this->prixVehicule = $prixVehicule;
    }

    public function setStatusVehicule(int $statusVehicule): void
    {
        if ($statusVehicule != 1 && $statusVehicule != 0) {
            throw new \InvalidArgumentException("Le status est obligatoire");
        } else
            $this->statusVehicule = $statusVehicule;
    }

    public function setIdCategorie(int $idCategorie): void
    {
        if (empty($idCategorie)) {
            throw new \InvalidArgumentException("La categorie est obligatoire");
        } else
            $this->idCategorie = $idCategorie;
    }





    //tostring
    public function __toString(): string
    {
        return "Vehicule [idVehicule=$this->idVehicule, marqueVehicule=$this->marqueVehicule, modeleVehicule=$this->modeleVehicule, anneeVehicule=$this->anneeVehicule,statusVehicule=$this->statusVehicule, imageVehicule=$this->imageVehicule, typeBoiteVehicule=$this->typeBoiteVehicule, typeCarburantVehicule=$this->typeCarburantVehicule, couleurVehicule=$this->couleurVehicule, prixVehicule=$this->prixVehicule, idCategorie=$this->idCategorie]";
    }
    //ajouter Vehicule
    public function ajouterVehicule(): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "insert into vehicules (marqueVehicule, modeleVehicule, anneeVehicule, imageVehicule, typeBoiteVehicule, typeCarburantVehicule, couleurVehicule, prixVehicule, idCategorie) values (:marqueVehicule, :modeleVehicule, :anneeVehicule, :imageVehicule, :typeBoiteVehicule, :typeCarburantVehicule, :couleurVehicule, :prixVehicule, :idCategorie)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":marqueVehicule", $this->marqueVehicule);
            $stmt->bindParam(":modeleVehicule", $this->modeleVehicule);
            $stmt->bindParam(":anneeVehicule", $this->anneeVehicule);
            $stmt->bindParam(":imageVehicule", $this->imageVehicule);
            $stmt->bindParam(":typeBoiteVehicule", $this->typeBoiteVehicule);
            $stmt->bindParam(":typeCarburantVehicule", $this->typeCarburantVehicule);
            $stmt->bindParam(":couleurVehicule", $this->couleurVehicule);
            $stmt->bindParam(":prixVehicule", $this->prixVehicule);
            $stmt->bindParam(":idCategorie", $this->idCategorie);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    //modifier Vehicule
    public function modifierVehicule(): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "update vehicules set marqueVehicule=:marqueVehicule, modeleVehicule=:modeleVehicule, anneeVehicule=:anneeVehicule, imageVehicule=:imageVehicule, typeBoiteVehicule=:typeBoiteVehicule, typeCarburantVehicule=:typeCarburantVehicule, couleurVehicule=:couleurVehicule, prixVehicule=:prixVehicule, idCategorie=:idCategorie where idVehicule=:idVehicule";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":marqueVehicule", $this->marqueVehicule);
            $stmt->bindParam(":modeleVehicule", $this->modeleVehicule);
            $stmt->bindParam(":anneeVehicule", $this->anneeVehicule);
            $stmt->bindParam(":imageVehicule", $this->imageVehicule);
            $stmt->bindParam(":typeBoiteVehicule", $this->typeBoiteVehicule);
            $stmt->bindParam(":typeCarburantVehicule", $this->typeCarburantVehicule);
            $stmt->bindParam(":couleurVehicule", $this->couleurVehicule);
            $stmt->bindParam(":prixVehicule", $this->prixVehicule);
            $stmt->bindParam(":idCategorie", $this->idCategorie);
            $stmt->bindParam(":idVehicule", $this->idVehicule);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    //supprimer Vehicule 
    public function supprimerVehicule(int $idVehicule): bool
    {
        if ($idVehicule <= 0)
            return false;
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "delete from vehicules where idVehicule=:idVehicule";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idVehicule", $idVehicule, \PDO::PARAM_INT);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    //get vehicule by id
    public function getVehiculeById(int $idVehicule): ?Vehicule
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from vehicules where idVehicule=:idVehicule";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idVehicule", $idVehicule);
            if ($stmt->execute()) {
                $vehicule = $stmt->fetchObject(Vehicule::class);
                return $vehicule;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return null;
        }
    }
    //return all vehicules
    public function getAllVehicules(): array
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from vehicules";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $vehicules = $stmt->fetchAll(\PDO::FETCH_CLASS, Vehicule::class);
                return $vehicules;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return [];
        }
    }
    //getVehiculesByCategorie
    public function getVehiculesByCategorie(int $idCategorie): array
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from vehicules where idCategorie=:idCategorie";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idCategorie", $idCategorie);
            if ($stmt->execute()) {
                $vehicules = $stmt->fetchAll(\PDO::FETCH_CLASS, Vehicule::class);
                return $vehicules;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return [];
        }
    }
    // get nombre Favoris par client
    public function getVehiculesFavorisByClient(int $idClient): array
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from vehicules where idVehicule in (select idVehicule from favoris where idClient=:idClient)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idClient", $idClient);
            if ($stmt->execute()) {
                $vehicules = $stmt->fetchAll(\PDO::FETCH_CLASS, Vehicule::class);
                return $vehicules;
            }
            return [];
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return [];
        }
    }
 

    // counter vehicules
    public static function counterVehicules(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) as total from vehicules";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_OBJ);
            return (int)$result->total;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }
    public function getNbVehiculeDisponible(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) as total from vehicules where idVehicule not in (select idVehicule from reservations where statusReservation='confirmer' and dateFinReservation >= now())";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_OBJ);
            return (int)$result->total;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }
    //getVehiculesByMarque
    public function getVehiculesByMarque() {}
}
