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
                $check = (apiToken::checkToken($jwt));
                if (isset($check['data'])){
                    $data = $check['data'];
                    $manager = new Usermanager();
                    $gebruiker = $manager->getGebruiker($data->userId);
                    print (json_encode(array("gebruiker" => $gebruiker)));
                } else {
                    print(json_encode($check));
                }
                
            break;
        default:
            print("no proper method selected");   
    }
}else if (isset($_POST['methode'])) {
    switch ($_POST['methode']) {
        /*
        case "check":
            print json_encode(login::checkLogin($_POST['gebruikersnaam'],$_POST['wachtwoord']));
        break;
    
    case "check":
        $manager = new Usermanager();
        $gebruiker = $manager->login($_POST['gebruikersnaam'],$_POST['wachtwoord']);
        if ($gebruiker == NULL){
            print(json_encode(["mislukt"=>"gebruikersnaam of paswoord incorrect"]));
        } else {
            print($gebruiker->getJSON());
        }      
        break;
    */
        case "nieuweUser":
        $manager = new Usermanager();
        print($manager->voegUserToe($_POST['naam'],$_POST['voornaam'],$_POST['woonplaats']));
        break;
        case "test":
        print("oke");
        break;
        default:
        print("no proper method selected");   
    }
}
?>