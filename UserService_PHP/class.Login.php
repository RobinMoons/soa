<?php 

require_once 'php-jwt/src/BeforeValidException.php';
require_once 'php-jwt/src/ExpiredException.php';
require_once 'php-jwt/src/SignatureInvalidException.php';
require_once 'php-jwt/src/JWT.php';

use \Firebase\JWT\JWT;

Class login
{
	public static function checkLogin($gebruikersnaam,$wachtwoord){
		try {
			$pdo = new PDO("mysql:host=localhost;dbname=soa", "root", "");
			$stmt = $pdo->prepare("select * FROM klantenbestand");
			$succes = $stmt->execute();
			if ($succes) {
				$wachtwoordIsCorrect = false;
				while ($rij = $stmt->fetch()) {
					if ($rij['gebruikersnaam'] == $gebruikersnaam && $rij['wachtwoord'] == $wachtwoord){
						$wachtwoordIsCorrect = true;
						$id = $rij['id'];
						break;
					}
				}

				if ($wachtwoordIsCorrect) {
					$tokenId    = base64_encode(mcrypt_create_iv(32));
					$tijd   = time();            
					$vervallen     = $tijd + 3600;          				  


					$data = [
					'iat'  => $tijd,         
					'jti'  => $tokenId,                     
					'exp'  => $vervallen,           
					'data' => [                  
					'userId'   => $id, 
					'userName' => $gebruikersnaam, 
					]
					];

					$secretKey = base64_decode("test");

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
}

?>