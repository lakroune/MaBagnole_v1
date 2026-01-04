<?php

namespace app\model;


use app\model\Connexion;

class Reservation
{
    private int $idReservation;
    private string $dateReservation;
    private string $dateDebutReservation;
    private string $dateFinReservation;
    private string $lieuChange;
    private int $idVehicule;
    private string $statusReservation;
    private int $idClient;
    // constructeur
    public function __construct() {}
    // getters
    public function getIdReservation(): int
    {
        return $this->idReservation;
    }
    public function getDateReservation(): string
    {
        return $this->dateReservation;
    }
    public function getDateDebutReservation(): string
    {
        return $this->dateDebutReservation;
    }
    public function getDateFinReservation(): string
    {
        return $this->dateFinReservation;
    }
    public function getLieuChange(): string
    {
        return $this->lieuChange;
    }
    public function getIdVehicule(): int
    {
        return $this->idVehicule;
    }
    public function getStatusReservation(): string
    {
        return $this->statusReservation;
    }
    public function getIdClient(): int
    {
        return $this->idClient;
    }


    // setters

    public function setIdReservation(int $idReservation): void
    {
        if ($idReservation < 1)
            throw new \InvalidArgumentException("ID reservation invalide");
        else
            $this->idReservation = $idReservation;
    }

    public function setDateReservation(string $dateReservation): void
    {
        if (empty($dateReservation))
            throw new \InvalidArgumentException("Date reservation invalide");
        else
            $this->dateReservation = $dateReservation;
    }

    public  function  setDateDebutReservation(string $dateDebutReservation): void
    {
        if (empty($dateDebutReservation))
            throw new \InvalidArgumentException("Date debut reservation invalide");
        else
            $this->dateDebutReservation = $dateDebutReservation;
    }


    public  function  setDateFinReservation(string $dateFinReservation): void
    {
        if (empty($dateFinReservation))
            throw new \InvalidArgumentException("Date fin reservation invalide");
        else
            $this->dateFinReservation = $dateFinReservation;
    }


    public function setLieuChange(string $lieuChange): void
    {
        if (empty($lieuChange))
            throw new \InvalidArgumentException("Lieu change invalide");
        else
            $this->lieuChange = $lieuChange;
    }

    public function setIdVehicule(int $idVehicule): void
    {
        if ($idVehicule < 1)
            throw new \InvalidArgumentException("ID vehicule invalide");
        else
            $this->idVehicule = $idVehicule;
    }

    public function setStatusReservation(string $statusReservation): void
    {
        if ($statusReservation != "en cours" && $statusReservation != "confirmer" && $statusReservation != "annuler")
            throw new \InvalidArgumentException("Status reservation invalide");
        else
            $this->statusReservation = $statusReservation;
    }

    public function setIdClient(int $idClient): void
    {
        if ($idClient < 1)
            throw new \InvalidArgumentException("ID client invalide");
        else
            $this->idClient = $idClient;
    }

    public function __toString()
    {
        return "idReservation:$this->idReservation, dateReservation :$this->dateReservation, dateDebutReservation:$this->dateDebutReservation, dateFinReservation:$this->dateFinReservation, lieuChange:$this->lieuChange, idVehicule:$this->idVehicule, statusReservation:$this->statusReservation, idClient:$this->idClient";
    }
    // ajouter Reservation
    public function ajouterReservation(): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            // $sql = "insert into reservations (dateDebutReservation, dateFinReservation, lieuChange, idVehicule, idClient) values (:dateDebutReservation, :dateFinReservation, :lieuChange, :idVehicule, :idClient)";
            $sql = "CALL AjouterReservation(:idClient, :idVehicule, :dateDebutReservation, :dateFinReservation, :lieuChange)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":dateDebutReservation", $this->dateDebutReservation);
            $stmt->bindParam(":dateFinReservation", $this->dateFinReservation);
            $stmt->bindParam(":lieuChange", $this->lieuChange);
            $stmt->bindParam(":idVehicule", $this->idVehicule);
            $stmt->bindParam(":idClient", $this->idClient);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    // confirmer Reservation
    public function confirmerReservation(int $idReservation): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            // $sql = "update reservations set statusReservation='confirmer' where idReservation=:idReservation";
            $sql = "CALL confirmerReservation(:idReservation)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idReservation", $idReservation);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    // annuler Reservation
    public function annulerReservation(int $idReservation): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "update reservations set statusReservation='annuler' where idReservation=:idReservation";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idReservation", $idReservation);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    //get Reservation
    public function getReservation(int $idReservation): ?Reservation
    {

        $db = Connexion::connect()->getConnexion();
        $sql = "select * from reservations where idReservation=:idReservation";
        $stmt = $db->prepare($sql);
        try {
            $stmt->bindParam(":idReservation", $idReservation);
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
        }
        if ($stmt->execute()) {
            $stmt->setFetchMode(\PDO::FETCH_CLASS, Reservation::class);
            $reservation = $stmt->fetch();
            return $reservation;
        } else {
            return null;
        }
    }
    //vrifeir  si client a une Reservation confirmer et terminer  et non fais deja avis 
    public function getReservationByClientVehicule(int $idClient, int $idVehicule): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select  * from reservations where idClient=:idClient and statusReservation='confirmer' and idVehicule=:idVehicule and dateFinReservation<now()";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idClient", $idClient);
            $stmt->bindParam(":idVehicule", $idVehicule);
            if ($stmt->execute()) {
                $reservation = $stmt->fetch(\PDO::FETCH_OBJ);
                if ($reservation)
                    return $reservation->idReservation;
                else
                    return 0;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }

    //getAll Reservations
    public  function getAllReservations(): array
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select r.* from reservations r inner join vehicules v on r.idVehicule=v.idVehicule inner join utilisateurs u on r.idClient=u.idUtilisateur";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $reservations = $stmt->fetchAll(\PDO::FETCH_CLASS, Reservation::class);
                return $reservations;
            } else {
                throw new \Exception("Reservation introuvable");
                return [];
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return [];
        }
    }
    //conter Reservations
    public static function counterReservations(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) as total from reservations";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $reservation = $stmt->fetch(\PDO::FETCH_OBJ);
                return $reservation->total;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }

    public function getNbReservationToDay(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $toDay = date('Y-m-d');
            $sql = "select count(*) as total from reservations where dateDebutReservation like :dateDebutReservation";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(":dateDebutReservation", $toDay . "%");
            if ($stmt->execute()) {
                $reservation = $stmt->fetch(\PDO::FETCH_OBJ);
                return $reservation->total;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }

    public function getNbReservationActive(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) as total from reservations where statusReservation='confirmer' and dateFinReservation > now() and dateDebutReservation < now()";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $reservation = $stmt->fetch(\PDO::FETCH_OBJ);
                return $reservation->total;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }

    public function getNbReservationAnnuler(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) as total from reservations where statusReservation='annuler'";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $reservation = $stmt->fetch(\PDO::FETCH_OBJ);
                return $reservation->total;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }
    public function getNbReservationConfirmer(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) as total from reservations where statusReservation='confirmer'";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $reservation = $stmt->fetch(\PDO::FETCH_OBJ);
                return $reservation->total;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }
    public function getNbReservationEnCours(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) as total from reservations where statusReservation='en cours'";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $reservation = $stmt->fetch(\PDO::FETCH_OBJ);
                return $reservation->total;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }

    public function getRevenueReservation(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select sum(v.prixVehicule) as total from reservations r inner join vehicules v on r.idVehicule=v.idVehicule where r.statusReservation='confirmer' ";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $reservation = $stmt->fetch(\PDO::FETCH_OBJ);
                return $reservation->total ?? 0;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }
}
