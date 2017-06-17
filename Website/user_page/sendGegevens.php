<?PHP    
    
    $url = 'http://localhost/SOAproject/UserService_PHP/ClientSoap.php';

        $myvars = array(
            'jwt' => $_POST['token'],
            'voornaam' => $_POST['form-voornaam'],
            'achternaam' => $_POST['form-naam'],
            'email' => $_POST['form-email'],
            'licentie' => 'n y i',
            'locatie' => $_POST['form-locatie'],
            'landcode' => $_POST['form-land'],
            'owid' => $_POST['form-owid'],
            'energieLeverancier' => $_POST['form-stroomlev'],
            'enid' => $_POST['form-enid'],
            'gasLeverancier' => $_POST['form-gaslev'],
            );
        

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );
        echo "<script>
                window.location.href='bewerkGegevens.php';
              </script>";  
    
?>
