<?php
/**
 * 
 * @pw_element int $id 
 * @pw_element string $gebruikersnaam
 * @pw_element string $voornaam
 * @pw_element string $achternaam
 * @pw_element string $licentie
 * @pw_element string $locatie
 * @pw_element string $owid
 * @pw_element string $energieleverancier
 * @pw_element string $enid
 * @pw_complex Gebruiker
 */
class Gebruiker {
    
    /*
     * @var int
     */
    public $id;
    /*
     * @var string
     */
    public $gebruikersnaam;
    /*
     * @var string
     */
    public $voornaam;
    /*
     * @var string
     */
    public $achternaam;
    /*
     * @var string
     */
    public $licentie;
    /*
     * @var string
     */
    public $locatie;
    /*
     * @var string
     */
    public $owid;
    /*
     * @var string
     */
    public $energieleverancier;
    
    /*
     * @var string
     */
    public $enid;

    /**
     * 
     */
    function __construct($id,$gebruikersnaam,$voornaam,$achternaam,$licentie,$locatie,$owid,$energieleverancier,$enid) {
        $this->id = $id;
        $this->gebruikersnaam = $gebruikersnaam;
        $this->voornaam = $voornaam;
        $this->achternaam = $achternaam;
        $this->licentie = $licentie;
        $this->locatie = $locatie;
        $this->owid = $owid;
        $this->energieleverancier = $energieleverancier;
        $this->enid = $enid;
    }
    
    function getId() {
        return $this->id;
    }
    
    function getGebruikersnaam() {
        return $this->gebruikersnaam;
    }
    
    function getVoornaam() {
        return $this->voornaam;
    }
    
    function getAchternaam() {
        return $this->achternaam;
    }
    
    function getLicentie() {
        return $this->licentie;
    }
    
    function getLocatie() {
        return $this->locatie;
    }
    
    function getOwid() {
        return $this->owid;
    }
    
    function getEnergieleverancier() {
        return $this->energieleverancier;
    }
    function getEnid() {
        return $this->enid;
    }
    
    function getJSON() {
        $list = array("id" => $this->id, "gebruikersnaam" =>  $this->gebruikersnaam,"voornaam" =>  $this->voornaam,"achternaam" =>  $this->achternaam,
        "licentie" =>  $this->licentie,"locatie" =>  $this->locatie,"owid" =>  $this->owid,"energieleverancier" =>  $this->energieleverancier,"enid" =>  $this->enid);
        return json_encode(array("gebruiker"=>$list));
    }
    
}
?>

