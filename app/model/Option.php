<?php
namespace app\model;
class Option
{
    private int $idOptionReservation;
    private int $idReservation;
    private int $idOption;

    // constructeur
    public function __construct() {}
    // getters
    public function __get($attribute) {}
    // setters
    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }
    // tostring
    public function __toString() {}
}
