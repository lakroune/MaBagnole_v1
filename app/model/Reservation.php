<?php

namespace app\model;

require __DIR__ . '/../../vendor/autoload.php';

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
    public function getIdReservation()
    {
        return $this->idReservation;
    }
    public function getDateReservation()
    {
        return $this->dateReservation;
    }
    public function getDateDebutReservation()
    {
        return $this->dateDebutReservation;
    }
    public function getDateFinReservation()
    {
        return $this->dateFinReservation;
    }
    public function getLieuChange()
    {
        return $this->lieuChange;
    }
    public function getIdVehicule()
    {
        return $this->idVehicule;
    }
    public function getStatusReservation()
    {
        return $this->statusReservation;
    }
    public function getIdClient()
    {
        return $this->idClient;
    }


    // setters
    public function setIdReservation($idReservation)
    {
        if ($idReservation > 0) {
            $this->idReservation = $idReservation;
            return true;
        }
        return false;
    }
    public function setDateReservation($dateReservation)
    {
        if (strlen($dateReservation) > 0) {
            $this->dateReservation = $dateReservation;
            return true;
        } else {
            return false;
        }
    }
    public function setDateDebutReservation($dateDebutReservation)
    {
        if (strlen($dateDebutReservation) > 0) {
            $this->dateDebutReservation = $dateDebutReservation;
            return true;
        } else {
            return false;
        }
    }
    public function setDateFinReservation($dateFinReservation)
    {
        if (strlen($dateFinReservation) > 0) {
            $this->dateFinReservation = $dateFinReservation;
            return true;
        } else {
            return false;
        }
    }
    public function setLieuChange($lieuChange)
    {
        if (strlen($lieuChange) > 0) {
            $this->lieuChange = $lieuChange;
            return true;
        }
        return false;
    }

    public function setIdVehicule($idVehicule)
    {
        if ($idVehicule > 0) {
            $this->idVehicule = $idVehicule;
            return true;
        }
        return false;
    }
    public function setStatusReservation($statusReservation)
    {
        if ($statusReservation == 0 or $statusReservation == 1) {
            $this->statusReservation = $statusReservation;
            return true;
        }
        return false;
    }
    public function setIdClient($idClient)
    {
        if ($idClient > 0) {
            $this->idClient = $idClient;
            return true;
        }
        return false;
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
            $sql = "insert into reservations (dateDebutReservation, dateFinReservation, lieuChange, idVehicule, idClient) values (:dateDebutReservation, :dateFinReservation, :lieuChange, :idVehicule, :idClient)";
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
            $sql = "update reservations set statusReservation='confirmer' where idReservation=:idReservation";
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
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from reservations where idReservation=:idReservation";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idReservation", $idReservation);
            if ($stmt->execute()) {
                $reservation = $stmt->fetch(\PDO::FETCH_OBJ);
                return $reservation;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return null;
        }
    }
    //vrifeir  si client a une Reservation confirmer et terminer  et non fais deja avis 
    public function getReservationByClientVehicule(int $idClient, int $idVehicule): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from reservations where idClient=:idClient and statusReservation='confirmer' and idVehicule=:idVehicule and dateFinReservation<now()";
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
            $sql = "select * from reservations r inner join vehicules v on r.idVehicule=v.idVehicule inner join utilisateurs u on r.idClient=u.idUtilisateur";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $reservations = $stmt->fetchAll(\PDO::FETCH_OBJ);
                return $reservations;
            } else {
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

    public function getNbReservationToDay()
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

    public function getNbReservationActive()
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

    public function getNbReservationAnnuler()
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
    public function getNbReservationConfirmer()
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
    public function getNbReservationEnCours()
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

    public function getRevenueReservation()
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select sum(v.prixVehicule) as total from reservations r inner join vehicules v on r.idVehicule=v.idVehicule where r.statusReservation='confirmer' ";
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
}
