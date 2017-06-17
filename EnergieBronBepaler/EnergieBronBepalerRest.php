

<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); ///// NOGGGG OPZOEKEN!!!!!
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if (!isset($_GET['methode']) && !isset($_POST['methode'])) {
    die("No method selected");
    
}else if (isset($_GET['methode'])) {

    $client = new SoapClient("http://localhost/SOAproject/EnergieBronBepaler/GasLeverancierService.php?wsdl", 
            array('trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE));

    $gasleverancier = $client->getGasleverancier($_GET['leverancier']);
    $gasPrijzen = $client->getGasprijzen($gasleverancier->id);

    $urlenergie = "http://usermanager-167313.appspot.com/getData?&key=". "5717271485874176" . "&distributor=" . $gasleverancier->leverancier;
    $ch = curl_init($urlenergie);
	curl_setopt_array($ch, array( 
	    CURLOPT_FOLLOWLOCATION => true,
	    CURLOPT_HEADER => false,
	    CURLOPT_RETURNTRANSFER => true
	));

    $energieleverancier = json_decode(curl_exec($ch));

    $urlweer = "http://api.openweathermap.org/data/2.5/forecast?id=" . "2795648" . "&units=metric&APPID=a4a530758bce79a5b8ef70c4b2a2a71b&mode=json";
    $ch = curl_init($urlweer);
	curl_setopt_array($ch, array( 
	    CURLOPT_FOLLOWLOCATION => true,
	    CURLOPT_HEADER => false,
	    CURLOPT_RETURNTRANSFER => true
	));

	$openw =  json_decode(curl_exec($ch));

	//echo curl_exec($ch);
	for ($i=0; $i < 10; $i++) { 
		echo json_encode($openw->list[$i]->clouds->all);
	}
	

}else if (isset($_POST['methode'])) {

}
    
  
?>
