<?php
/**
 * blabla
 * 
 * @pw_complex Gebruiker
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
     * @return Gebruiker klasse gebruiker
     */
    
    public function register($email, $gebruikersnaam, $wachtwoord){        
        //return ("succes hier");
        
        $stmt = $this->pdo->prepare("INSERT INTO klantenbestand(email, gebruikersnaam, wachtwoord) VALUES(:email, :gebruikersnaam, :wachtwoord);");
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':gebruikersnaam',$gebruikersnaam);        
        $stmt->bindParam(':wachtwoord',password_hash($wachtwoord,PASSWORD_BCRYPT));
        $succes = $stmt->execute();
        if ($succes) {
            return "gebruiker toegevoegd";
        }         
        else
        {
            return "fout opgetreden bij aanmaken gebruiker";
        }
        
    }

    public function getGebruiker($id) {
        $stmt = $this->pdo->prepare("select * FROM klantenbestand WHERE id=" .$id);
        $succes = $stmt->execute();
        $gebruiker = NULL;
        if ($succes) {
            while ($rij = $stmt->fetch()) {
                $gebruiker = new Gebruiker($rij['id'], $rij['gebruikersnaam'], $rij['voornaam'], $rij['achternaam'], $rij['licentie'], $rij['locatie'], $rij['owid'], $rij['energieleverancier'],$rij['enid']);
            }
        }
        return $gebruiker;
    }

}


