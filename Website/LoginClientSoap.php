
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
if (isset($_POST['gebruikersnaam'])) {
    $client = new SoapClient("http://localhost/SOAproject/UserService_PHP/UserManagerService.php?wsdl", 
            array('trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE));

    $object = $client->login($_POST['gebruikersnaam'], $_POST['wachtwoord']);

    if ($object == NULL) {
    	print(json_encode(["mislukt"=>"gebruikersnaam of paswoord incorrect"]));
    } else {    
    	print(json_encode(array("gebruiker" => $object)));
	}
}
?>
       
