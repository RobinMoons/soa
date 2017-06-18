<?php

require("class.Usermanager.php");

require ('/Authenticatie/class.ApiToken.php');
use \ApiToken as apiToken;


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if (!isset($_GET['methode']) && !isset($_POST['methode'])) {
    die("No method selected");
    
}else if (isset($_GET['methode'])) {
    switch ($_GET['methode']) {
        case "dataGebruiker":
                $jwt = $_GET['data'];
                $manager = new Usermanager();
                $gebruiker = $manager->getGebruiker($jwt);
                if (isset($gebruiker['mislukt'])) {
                    print(json_encode($gebruiker));   
                } else {
                    print (json_encode(array("gebruiker" => $gebruiker[0])));
                }
                
            break;
        case 'info':
            $info = new \stdClass();
            $info->GET->methode->dataGebruiker->beschrijving = "Deze methode haalt de gevraagde gebruiker op uit de mysql database. Als de API token niet correct is, kan er ook geen gebruiker opgehaald worden";
            $info->GET->methode->dataGebruiker->parameters->data = "De JWT token";
            $info->POST->methode->nieuweUser->beschrijving = "Hiermee wordt er een nieuwe user toegevoegd aan de database";
            $info->POST->methode->nieuweUser->parameters->emailadres = "emailadres";
            $info->POST->methode->nieuweUser->parameters->gebruikersnaam ="gebruikersnaam";
            $info->POST->methode->nieuweUser->parameters->wachtwoord = "wachtwoord";
            print json_encode($info);
            break;
        default:
            print("no proper method selected");   
    }
}else if (isset($_POST['methode'])) {

    switch ($_POST['methode']) {          

        case 'nieuweUser':
            //print(json_encode("Nieuwe gebruiker toevoegfunctie"));
            
            $manager = new Usermanager();            
            print(json_encode($manager->register($_POST['emailadres'],$_POST['gebruikersnaam'],$_POST['wachtwoord'])));
            break;
        default:
            print(json_encode("no proper method selected"));  
            break; 
    }
}
?>