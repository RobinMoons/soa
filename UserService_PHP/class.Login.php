<?php 

require_once 'php-jwt/src/BeforeValidException.php';
require_once 'php-jwt/src/ExpiredException.php';
require_once 'php-jwt/src/SignatureInvalidException.php';
require_once 'php-jwt/src/JWT.php';

use \Firebase\JWT\JWT;

Class login
{
	public static function checkLogin($gebruikersnaam,$wachtwoord){
		$pdo = new PDO("mysql:host=localhost;dbname=soa", "root", "");
		$stmt = $pdo->prepare("select * FROM klantenbestand");
        $succes = $stmt->execute();
        if ($succes) {
            while ($rij = $stmt->fetch()) {
            	print $rij['gebruikersnaam'];
                if ($rij['gebruikersnaam'] == $gebruikersnaam && $rij['wachtwoord'] == $wachtwoord){
                    $tokenId    = base64_encode(mcrypt_create_iv(32));
				    $issuedAt   = time();
				    $notBefore  = $issuedAt + 10;             //Adding 10 seconds
				    $expire     = $notBefore + 60;            // Adding 60 seconds
				    $serverName = "localhost";				  // Retrieve the server name from config file
				    

				    $data = [
				        'iat'  => $issuedAt,         // Issued at: time when the token was generated
				        'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
				        'iss'  => $serverName,       // Issuer
				        'nbf'  => $notBefore,        // Not before
				        'exp'  => $expire,           // Expire
				        'data' => [                  // Data related to the signer user
				            'userId'   => "1", // userid from the users table
				            'userName' => $gebruikersnaam, // User name
				        ]
				    ];

				    $secretKey = base64_decode("test");

				    $jwt = JWT::encode($data,$secretKey,'HS512');

				    $jwtArray = ['jwt' => $jwt];
				    return json_encode($jwtArray);
                }
                else {
                	return json_encode(["mislukt"=>"gebruikersnaam of paswoord incorrect"]);
                }
            }
        } 
	}
}

?>