<?php  

/**
 * Deze klassen haalt uit een database de gasprijs op voor een heledag
 * @pw_element int $id
 * @pw_element string $leverancier
 * @pw_element double $prijsHoog
 * @pw_element int $uurHoog
 * @pw_element double $prijsLaag
 * @pw_element int $uurLaag
 * @pw_complex record
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
	 * @param int $id het id nummer van de gasLeverancier
	 * @return array deze array bevat per uur de gasprijs per m3
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