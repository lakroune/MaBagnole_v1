<?php

    namespace app\model;

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
        public function __get($attribute) {}
        // setters
        public function __set($attribute, $value) {}
        public function __toString() {}
        // ajouter Reservation
        public function ajouterReservation() {}
        // confirmer Reservation
        public function confirmerReservation(int $idReservation) {}
        // annuler Reservation
        public function annulerReservation(int $idReservation) {}
        //get Reservation
        public function getReservation(int $idReservation) {}
        //getAll Reservations
        public static function getAllReservations() {}
        //conter Reservations
        public static function conterReservations() {}
    }
