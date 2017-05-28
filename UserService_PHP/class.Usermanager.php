<?php

/**
 * 
 */
require 'class.Gebruiker.php';

class Usermanager {

    private $pdo;

    /**
     * 
     */
    public function __construct() {
        $this->pdo = new PDO("mysql:host=localhost;dbname=soa", "root", "");
    }

    /**
     * 
     * @param String $gebruikersnaam
     * @param String $wachtwoord
     * @return Gebruiker $gebruiker
     */
    public function login($gebruikersnaam, $wachtwoord) {
        $stmt = $this->pdo->prepare("select * FROM klantenbestand WHERE gebruikersnaam = :gn AND wachtwoord = :ww ");
        $stmt->bindParam(":gn", $gebruikersnaam);
        $stmt->bindParam(":ww", $wachtwoord);
        $succes = $stmt->execute();
        $gebruiker = NULL;
        if ($succes) {
            while ($rij = $stmt->fetch()) {
                $gebruiker = new Gebruiker($rij['id'], $gebruikersnaam, $rij['voornaam'], $rij['achternaam'], $rij['licentie'], $rij['locatie'], $rij['owid'], $rij['energieleverancier'],$rij['enid']);
            }
        }
        return $gebruiker;
    }
    /**
     * 
     * @return string
     */
    public function test(){
        return "gelukt";
    }

}
?>

