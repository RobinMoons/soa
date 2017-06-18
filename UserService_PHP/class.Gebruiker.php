<?php
/**
 * Gegevens van de gebruiker
 * 
 * @pw_element int $id het id van de gebruiker
 * @pw_element string $gebruikersnaam de gebruikersnaam
 * @pw_element string $voornaam de voornaam
 * @pw_element string $achternaam de achternaam
 * @pw_element string $licentie licentie van de gebruiker, van wat mag deze gebruiker gebruik maken en wat niet
 * @pw_element string $locatie Waar woont de gebruiker
 * @pw_element string $owid de id van de locatie in openweather
 * @pw_element string $energieleverancier bij welke stroomleverancier is de gebruiker aangesloten
 * @pw_element string $enid id van de stroomleverancier
 * @pw_element string $landcode landcode
 * @pw_element string $gasLeverancier bij welke gasleverancier is de gebruiker aangesloten
 * @pw_element string $het email van de gerbuker
 * @pw_complex Gebruiker
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
     * @var string
     */
    public $email;

    /**
     * De constructor
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
    function __construct($id,$gebruikersnaam,$voornaam,$achternaam,$licentie,$locatie,$owid,$energieleverancier,$enid,$landcode,$gasLeverancier,$email) {
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
        $this->email = $email;
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

