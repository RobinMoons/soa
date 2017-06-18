<?php 

require ('class.ApiToken.php');
use \ApiToken as apiToken;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if (!isset($_GET['methode']) && !isset($_POST['methode'])) {
    die("No method selected");
}elseif (isset($_GET['methode'])) {
    switch ($_GET['methode']) {
        case 'info':
            $info = new stdClass();
            $info->POST->methode->login->beschrijving = "Deze methode vergelijkt het paswoord met de gebruikersnaam, als deze juist zijn wordt er een jwt token aangemaakt";
            $info->POST->methode->login->parameters->gebruikersnaam = "Gebruikersnaam";
            $info->POST->methode->login->parameters->wachtwoord = "wachtwoord";
            $info->POST->methode->checkToken->beschrijving = "Controleert of de token nog geldig is";
            $info->POST->methode->checkToken->parameters->jwt = "de jwt token";

            $info->GET->methode = "geen get methodes beschikbaar";
            print json_encode($info);
            break;
        
        default:
            print("no proper method selected");
            break;
    }
}else if (isset($_POST['methode'])) {
    switch ($_POST['methode']) {
        case "login":
            //hash verify gebeurt in 'checkAuthenticatie'
            print json_encode(apiToken::checkAuthenticatie($_POST['gebruikersnaam'],$_POST['wachtwoord']));
        break;
        case "checkToken":// refrech ofzo iets
        	$check = (apiToken::checkToken($_POST['jwt']));
            if (isset($check['data'])){
                print json_encode(array('message'=> "gelukt"));
        	} else {
                print json_encode($check);
            }
        break;
        default:
        print("no proper method selected");   
    }
}


 ?>
