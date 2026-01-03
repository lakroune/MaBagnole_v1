<?php

namespace app\model;

use app\model\Utilisateur;

class Admin extends Utilisateur

{
    // constructeur
    public function __construct()
    {
        parent::__construct();
    }
    //tostring
    public function __toString(): string
    {
        return parent::__toString();
    }
}
