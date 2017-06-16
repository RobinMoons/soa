<?php
/**
 * blabla
 * 
 * @pw_element int $id blabla
 * @pw_element string $gebruikersnaam blabla
 * @pw_element string $voornaam blabla
 * @pw_element string $achternaam blabla
 * @pw_element string $licentie blabla
 * @pw_element string $locatie blabla
 * @pw_element string $owid blabla
 * @pw_element string $energieleverancier blabla
 * @pw_element string $enid blabla
 * @pw_element string $lancode blbla
 * @pw_element string $gasLeverancier
 * @pw_complex Gebruiker blabla
 */
class Gebruiker {
    
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $gebruikersnaam;
    /**
     * @var string
     */
    public $voornaam;
    /**
     * @var string
     */
    public $achternaam;
    /**
     * @var string
     */
    public $licentie;
    /**
     * @var string
     */
    public $locatie;
    /**
     * @var string
     */
    public $owid;
    /**
     * @var string
     */
    public $energieleverancier;
    /**
     * @var string
     */
    public $enid;

    /**
     * @var string
     */
    public $landcode;
    /**
     * @var string
     */
    public $gasLeverancier;

    /**
     * @param int $id id van gebruiker
     * @param string $gebruikersnaam Descriptionpa
     * @param string $voornaam Description
     * @param string $achternaam Description
     * @param string $licentie Description
     * @param string $locatie Description
     * @param string $owid Descriptionpa
     * @param string $energieleverancier Description
     * @param string $enid Description
     * @param string $landcode Description
     * @param string $gasLeverancier Description
     */
    function __construct($id,$gebruikersnaam,$voornaam,$achternaam,$licentie,$locatie,$owid,$energieleverancier,$enid,$landcode,$gasLeverancier) {
        $this->id = $id;
        $this->gebruikersnaam = $gebruikersnaam;
        $this->voornaam = $voornaam;
        $this->achternaam = $achternaam;
        $this->licentie = $licentie;
        $this->locatie = $locatie;
        $this->owid = $owid;
        $this->energieleverancier = $energieleverancier;
        $this->enid = $enid;
        $this->landcode = $landcode;
        $this->gasLeverancier = $gasLeverancier;
    }
    
    /*
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
    
    */
    
}

