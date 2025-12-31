 <?php
    class Favori
    {
        private int $idFavoris;
        private int $idClient;
        private int $idVehicule;
        // constructeur
        public function __construct() {}
        // getters
        public function __get($aturibut)
        {
            return $this->$aturibut;
        }
        // setters
        public function __set($aturibut, $value)
        {
            $this->$aturibut = $value;
        }
        // tostring
        public function __toString() {}
        // ajouter Favori
        public function ajouterFavori() {}
        // annuler Favori
        public function annulerFavori() {}
        // getAll Favoris par vehicule
        public function getFavorisByVehicule() {}
        // get Favori
        public function getFavori() {}
    }
