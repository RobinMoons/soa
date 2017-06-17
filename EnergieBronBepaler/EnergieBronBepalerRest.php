

<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); ///// NOGGGG OPZOEKEN!!!!!
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if (!isset($_GET['methode']) && !isset($_POST['methode'])) {
    die("No method selected");
    
}else if (isset($_GET['methode'])) {

    $client = new SoapClient("http://localhost/SOAproject/EnergieBronBepaler/GasLeverancierService.php?wsdl", 
            array('trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE));

    $leverancier = $client->getGasleverancier($_GET['leverancier']);
    echo($leverancier[0]->leverancier);

}else if (isset($_POST['methode'])) {

}
    
  
?>
