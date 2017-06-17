
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require('class.Gebruiker.php');

if (isset($_POST['jwt'])) {
	$gebruiker = new Gebruiker("","",$_POST['voornaam'],$_POST['achternaam'],"",$_POST['locatie'],$_POST['owid'],$_POST['energieLeverancier'],$_POST['enid'],$_POST['landcode'],$_POST['gasLeverancier'],$_POST['email']);
    $client = new SoapClient("http://localhost/SOAproject/UserService_PHP/UserManagerService.php?wsdl", 
            array('trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE));

    $object = $client->updateGebruiker($_POST['jwt'],$gebruiker);

    	print(json_encode([$object]));
  
	}
?>
       
