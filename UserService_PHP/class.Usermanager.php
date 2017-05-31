<?php
/**
 * blabla
 * 
 * @pw_complex GebruikerArray
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
     * @param string $gebruikersnaam
     * @param string $wachtwoord
     * @return GebruikerArray klasse gebruiker
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

}


