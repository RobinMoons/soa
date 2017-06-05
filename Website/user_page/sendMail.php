<?PHP    
    
    if(isset($_POST['_email_to'])){          
       $url = 'http://www.bmksolutions.be/DEV/Robin/mailSOA.php';
        //$url = 'http://localhost/SOAproject/mailSOA.php';
        $myvars = array(
            '_email' => $_POST['_email_to'],
            '_message' => $_POST['_message'],
            '_name' => $_POST['_name'],
            '_email_to' => 'bmk SOA service',
            );
        

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );
        echo $response;
    }    
    
    
?>
