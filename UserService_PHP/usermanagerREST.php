<?php

require("class.Usermanager.php");

if (!isset($_GET['methode']) && !isset($_POST['methode'])) {
    die("No method selected");
}
//else if (isset($_GET['methode'])) {
//  switch ($_GET['methode']) {
//    case "checkUser":
//        $manager = new Usermanager();
//        print($manager->check());
//        break;
//    default:
//        print("no proper method selected");   
//  }
//}

else if (isset($_POST['methode'])) {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
  switch ($_POST['methode']) {
    case "check":
        $manager = new Usermanager();
        $gebruiker = $manager->login($_POST['gebruikersnaam'],$_POST['wachtwoord']);
        if ($gebruiker == NULL){
            print(json_encode(["mislukt"=>"gebruikersnaam of paswoord incorrect"]));
        } else {
            print($gebruiker->getJSON());
        }      
        break;
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