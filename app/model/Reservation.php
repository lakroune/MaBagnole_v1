<?php

namespace app\model;

require __DIR__ . '/../../vendor/autoload.php';

use app\model\Connexion;

class Reservation
{
    private int $idReservation;
    private \DateTime $dateReservation;
    private \DateTime $dateDebutReservation;
    private \DateTime $dateFinReservation;
    private string $lieuChange;
    private int $idVehicule;
    private string $statusReservation;
    private int $idClient;
    // constructeur
    public function __construct() {}
    // getters
    public function __get($attribute)
    {
        return $this->$attribute;
    }
    // setters
    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
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

 