<?php 

require_once 'php-jwt/src/BeforeValidException.php';
require_once 'php-jwt/src/ExpiredException.php';
require_once 'php-jwt/src/SignatureInvalidException.php';
require_once 'php-jwt/src/JWT.php';

include('config.php');


use \Firebase\JWT\JWT;

Class ApiToken
{ 
	/**
		Deze functie controleert of de de gebruikersnaam en wachtwoord overeenkomen.
		@Return een array met een JWT token.
	*/
	public static function checkAuthenticatie($gebruikersnaam,$wachtwoord){
		try {
			$pdo = new PDO("mysql:host=localhost;dbname=soa", "root", "");
			$stmt = $pdo->prepare("select * FROM klantenbestand WHERE gebruikersnaam = :gb");
			$stmt->bindparam(':gb',$gebruikersnaam);
			$succes = $stmt->execute();
			if ($succes) {
				$wachtwoordIsCorrect = false;
				while ($rij = $stmt->fetch()) {
					$storedPw = $rij['wachtwoord'];
                	if (password_verify($wachtwoord, $storedPw)){ 
						$wachtwoordIsCorrect = true;
						$id = $rij['id'];
						break;
					}
				}

				if ($wachtwoordIsCorrect) {
					$tokenId    = base64_encode(mcrypt_create_iv(32));
					$tijd   = time();            
					$vervallen     = $tijd + 300;          				  


					$data = [
					'iat'  => $tijd,         
					'jti'  => $tokenId,                     
					'exp'  => $vervallen,           
					'data' => [                  
						'userId'   => $id, 
						'userName' => $gebruikersnaam, 
						]
					];

					$secretKey = base64_decode('projectSoa');

					$jwt = JWT::encode($data,$secretKey,'HS512');

					$jwtArray = array('jwt' => $jwt);
					return $jwtArray;
				} else {
					return ["mislukt"=>"gebruikersnaam of paswoord incorrect"];
				}
			} else {
				return ["mislukt"=>"Uitvoeren van de sqlstatement is niet gelukt"];
			}
		} catch (Exception $e){
			return ["mislukt"=>"Connectie met de Mysqldatabase is niet gelukt:" . $e];
		}
	}

	/**
		Deze functie controleert of de de JWT token nog geldig is.
		@return Als de token geldig is dan wordt de data over de gebruiker gereturnd.
	*/
	public static function checkToken($jwt){
		try{
	        $key = base64_decode("projectSoa");
	        $decoded = JWT::decode($jwt, $key, array('HS512'));
	        return (['data' => $decoded->data]);
	    }catch (Exception $e) {
	    	return (['mislukt' => "De token is niet geldig: " . $e]);
	    }
	}
}

?>