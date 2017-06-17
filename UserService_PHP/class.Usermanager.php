<?php
/**
 * blabla
 * @pw_element int $id blabla
 * @pw_element string $gebruikersnaam blabla
 * @pw_element string $voornaam blabla
 * @pw_element string $achternaam blabla
 * @pw_element string $licentie blabla
 * @pw_element string $locatie blabla
 * @pw_element string $owid blabla
 * @pw_element string $energieleverancier blabla
 * @pw_element string $enid blabla
 * @pw_element string $landcode blbla
 * @pw_element string $gasLeverancier
 * @pw_element string $email
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
                        $gebruiker = new Gebruiker($rij['id'], $rij['gebruikersnaam'], $rij['voornaam'], $rij['achternaam'], $rij['licentie'], $rij['locatie'], $rij['owid'], $rij['energieleverancier'],$rij['enid'],$rij['landcode'],$rij['gasLeverancier'],$rij['email']);
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
    /**
     *
     * @param string $jwt de apitoken als verificatie
     * @param Gebruiker $gebruiker
     * @return string true als het lukt , false als het mislukt
     */  
    public function updateGebruiker($jwt,$gebruiker) {
        try {
            $check = apiToken::checkToken($jwt);
            if (isset($check['data'])){
                $data = $check['data'];
                $id = $data->userId;
                $stmt = $this->pdo->prepare("UPDATE klantenbestand SET email = :email , voornaam = :vn , achternaam = :an , locatie = :loc , owid = :owid , energieleverancier = :el , enid = :enid , landcode = :lc , gasLeverancier = :gl WHERE id = ".$id);
                $stmt->bindParam(':email',$gebruiker->email);
                $stmt->bindParam(':vn',$gebruiker->voornaam);
                $stmt->bindParam(':an',$gebruiker->achternaam);
                $stmt->bindParam(':loc',$gebruiker->locatie);
                $stmt->bindParam(':owid',$gebruiker->owid);
                $stmt->bindParam(':el',$gebruiker->energieleverancier);
                $stmt->bindParam(':enid',$gebruiker->enid);
                $stmt->bindParam(':lc',$gebruiker->landcode);
                $stmt->bindParam(':gl',$gebruiker->gasLeverancier);
                $succes = $stmt->execute();
                return $succes;
            }
        }catch (Exception $e) {
            return false;
        }
    }


}


