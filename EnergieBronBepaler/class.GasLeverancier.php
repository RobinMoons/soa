<?php  

/**
 * record bevat informatie van de gasleverancier
 * @pw_element int $id het id nummer van de gasleverancier
 * @pw_element string $leverancier de naam van de gasleverancier
 * @pw_element double $prijsHoog de prijs van het dagtarief
 * @pw_element int $uurHoog het uur wanneer het dagtarief begint
 * @pw_element double $prijsLaag de prijs van het nachttarief
 * @pw_element int $uurLaag het uur wanneer het nachttarief begint
 * @pw_complex record bevat informatie van de gasleverancier
*/
class GasLeverancier {

	private $pdo;

	/**
	 * Dit is de constructor, deze zorgt voor de databaseconnectie
	 */
	function __construct(){
		$this->pdo = new PDO("mysql:host=localhost;dbname=soa", "root", "");
	}

	/**
	 * Haal alle gasleveranciers op
	 * @return array een lijst van energieLeveranciers
	 */
	function getGasleveranciers(){
		$stmt = $this->pdo->prepare("select * FROM gasLeveranciers");
		$stmt->setFetchMode(PDO::FETCH_OBJ); 
		$succes = $stmt->execute();
		$record = NULL;
		if ($succes){
			while ($rij = $stmt->fetch()) {
				$record[] = $rij;
			}

		}
		return $record;
	}

	/**
	 * haal één gasleverancier op met naam, als deze niet correct krijgt met een leeg object terug.
	 * @param string $leverancier de naam van de leverancier
	 * @return Record informatie van de leverancier terug 
	 */
	function getGasleverancier($leverancier){
		$stmt = $this->pdo->prepare("select * FROM gasLeveranciers WHERE leverancier = :l");
		$stmt->bindParam(':l',$leverancier);
		$stmt->setFetchMode(PDO::FETCH_OBJ); 
		$succes = $stmt->execute();
		$record = NULL;
		if ($succes){
			while ($rij = $stmt->fetch()) {
				$record[] = $rij;
			}

		}
		return $record[0];
	}


	/**
	 * Haalt de gasprijzen op per uur van een gasleverancier met id.
	 * @param int $id het id nummer van de gasLeverancier
	 * @return array deze array bevat per uur de gasprijs per kwh
	 */
	function getGasprijzen($id){
		$stmt = $this->pdo->prepare("select prijsHoog , uurHoog , prijsLaag , uurLaag FROM gasLeveranciers WHERE id = :id");
		$stmt->bindParam(':id',$id);
		$stmt->setFetchMode(PDO::FETCH_OBJ); 
		$succes = $stmt->execute();
		$leverancier = NULL;
	
		if ($succes){
			while ($rij = $stmt->fetch()) {
				$leverancier = $rij;
			}
		}
		if ($leverancier != NULL) {
			for ($i=1; $i < 25; $i++) { 
				if ($i >= $leverancier->uurHoog && $i <= $leverancier->uurLaag) {
					$antwoord[$i] = $leverancier->prijsHoog;
				} else {
					$antwoord[$i] = $leverancier->prijsLaag;
				}
			}
		}
		
		return $antwoord;
	}
}

?>