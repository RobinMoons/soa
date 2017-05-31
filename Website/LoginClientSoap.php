
<?php

if (isset($_POST['gebruikersnaam'])) {
    $client = new SoapClient("http://localhost/SOAproject/UserService_PHP/UserManagerService.php?wsdl", 
            array('trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE));

    $object = $client->login($_POST['gebruikersnaam'], $_POST['wachtwoord']);

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    print(json_encode(array("gebruiker" => $object)));
}
?>
       
