<?php

class Option
{
    private int $idOptionReservation;
    private int $idReservation;
    private int $idOption;

    // constructeur
    public function __construct() {}
    // getters
    public function __get($aturibut) {}
    // setters
    public function __set($aturibut, $value)
    {
        $this->$aturibut = $value;
    }
    // tostring
    public function __toString() {}
}
