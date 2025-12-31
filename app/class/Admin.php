<?php

class Admin extends Utilisateur

{
    // constructeur
    public function __construct()
    {
        parent::__construct();
    }
    //tostring
    public function __toString()
    {
        return parent::__toString() ;
    }
}
