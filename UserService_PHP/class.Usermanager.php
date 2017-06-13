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
     * @param string $email
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

    /**
     * 
     * @param string $jwt
     * @return Gebruiker klasse gebruiker
     */
    public function getGebruiker($jwt) {
        try {
            $check = (apiToken::checkToken($jwt));
            if (isset($check['data'])){
                $data = $check['data'];
                $id = $data->userId;
                $stmt = $this->pdo->prepare("select * FROM klantenbestand WHERE id=" .$id);
                $succes = $stmt->execute();
                if ($succes) {
                    while ($rij = $stmt->fetch()) {
                        $gebruiker = new Gebruiker($rij['id'], $rij['gebruikersnaam'], $rij['voornaam'], $rij['achternaam'], $rij['licentie'], $rij['locatie'], $rij['owid'], $rij['energieleverancier'],$rij['enid']);
                    }
                } 
                return [$gebruiker];
            } else {
                return $check;
            }
        }catch (Exception $e) {
            return ['mislukt'=>"Connectie met de mysql server is mislukt"];
        }
    }


}


