

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); ///// NOGGGG OPZOEKEN!!!!!
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');


if (!isset($_GET['methode']) && !isset($_POST['methode'])) {
    die("No method selected");
    
}else if (isset($_GET['methode'])) {
	switch($_GET['methode']){
		case 'get' :
			if (isset($_GET['energieleverancier']) && isset($_GET['gasleverancier']) && isset($_GET['owid'])){
			    $client = new SoapClient("http://localhost/SOAproject/EnergieBronBepaler/GasLeverancierService.php?wsdl", 
			            array('trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE));

			    $gasleverancier = $client->getGasleverancier($_GET['gasleverancier']);
			    if ($gasleverancier == NULL) {
			    	print json_encode(["message" => 'gasleverancier niet gekent']);
			    	return;
			    }
			    $gasPrijzen = $client->getGasprijzen($gasleverancier->id);

			    $urlenergie = "http://usermanager-167313.appspot.com/getData?&key=". "5717271485874176" . "&distributor=" . $_GET['energieleverancier'];
			    $ch = curl_init($urlenergie);
				curl_setopt_array($ch, array( 
				    CURLOPT_FOLLOWLOCATION => true,
				    CURLOPT_HEADER => false,
				    CURLOPT_RETURNTRANSFER => true
				));
			    $energieleverancier = json_decode(curl_exec($ch)); 
			    
			    if ($energieleverancier->message != 'succes') {
			    	print json_encode(["message" => 'fout energieleverancier niet gekend']);
			    	return;
			    }

			    for ($i=1; $i < 25; $i++) { 
					if ($i >= 8 && $i <= 17) {
						$energijprijs[$i] = $energieleverancier->Distributor_info->Dagtarief;
					} else {
						$energijprijs[$i] = $energieleverancier->Distributor_info->Nachttarief;
					}
				}

			    $urlweer = "http://api.openweathermap.org/data/2.5/forecast?id=" . $_GET['owid'] . "&units=metric&APPID=a4a530758bce79a5b8ef70c4b2a2a71b&mode=json";
			    $ch = curl_init($urlweer);
				curl_setopt_array($ch, array( 
				    CURLOPT_FOLLOWLOCATION => true,
				    CURLOPT_HEADER => false,
				    CURLOPT_RETURNTRANSFER => true
				));
				$openfor =  json_decode(curl_exec($ch));

				$urlweer = "http://api.openweathermap.org/data/2.5/weather?id=" . $_GET['owid'] . "&units=metric&APPID=a4a530758bce79a5b8ef70c4b2a2a71b&mode=json";
			    $ch = curl_init($urlweer);
				curl_setopt_array($ch, array( 
				    CURLOPT_FOLLOWLOCATION => true,
				    CURLOPT_HEADER => false,
				    CURLOPT_RETURNTRANSFER => true
				));
				$openw =  json_decode(curl_exec($ch));
				$sunset = intval(date('H',$openw->sys->sunset));
				$sunrise = intval(date('H',$openw->sys->sunrise));

				foreach ($openfor->list as $key => $value) {
					$time = strtotime($value->dt_txt);
					$uur = intval(date('H',$time));
					$zon = 1 - $value->clouds->all/100;
					if ($uur == 0) {
						$gaspr = $gasPrijzen[24];
						$energiepr = $energijprijs[24];
					}else {
						$gaspr = $gasPrijzen[$uur];
						$energiepr = $energijprijs[$uur];
					}

					if ($sunrise+1 <= $uur && $uur <= $sunset-1) {
						if (($gaspr * 2 *3) < (3 - opgewerkteZonnenEnergie($zon)) * 3 * $energiepr ) {
							$bron[$key] = ['timestamp' => $value->dt_txt , 'result' =>'G'];
						}  else {
							$bron[$key] = ['timestamp' => $value->dt_txt , 'result' =>'E'];
						}
					} else {
						if (($gaspr * 2 *3) < 3 * 3 * $energiepr ) {
							$bron[$key] = ['timestamp' => $value->dt_txt , 'result' =>'G'];
						}  else {
							$bron[$key] = ['timestamp' => $value->dt_txt , 'result' =>'E'];
						}
					}
				}

				$antwoord = new \stdClass();
				$antwoord->message = "succes";
				$antwoord->data = $bron;
				print json_encode($antwoord);
			} else {
				print json_encode(["message" => 'parameters niet correct']);
			}
			break;
		default:
			print "No method selected";
			break;
	}

}else if (isset($_POST['methode'])) {

}



	/**
	 * Deze functie interpoleert tussen 2 uren, en geeft de bewolking terug van de punten die er tussen liggen
	 *
	*/
	function interpolatieBewolking($bewolking1,$bewolking2) {
		return [($bewolking2-$bewolking1)/(3)*1+$bewolking1, ($bewolking2-$bewolking1)/(3)*2+$bewolking1];

	}
	/**
	 * Deze function berekent het aantal opgewekte kwh.
	 *
	 */ 
	function opgewerkteZonnenEnergie($procentZon) {
		return 1.9*$procentZon + 0.1;
	}
	/**
	 * Deze functie berekent hoeveel kwh een gasverwarming verbruikt als het een temperatuursverschil moet overbruggen
	 * @param $tempverschil het temperatuursverschil
	 * @return het aantal kwh.
	 */
	function vermogenVanGasVerwarming($tempverschil) {
		return $tempverschil*0.9;
	}

	/**
	 * Deze functie berekent hoeveel kwh een elektrischeverwarming verbruikt als het een temperatuursverchil moet overbruggen
	 * @param $tempverschil het temperatuursverschil
	 * @return het aantal kwh.
	 */
	function vermsogenVanElektrischeVerwarming($tempverschil) {
		return $tempverschil*1.2;
	}

?>
