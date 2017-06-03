<?php
if(isset($_POST['_email_to'])) {
	$email_to = 'robin_moons@student.uhasselt.be, kobe.bamps@student.uhasselt.be';   
	$email_from = $_POST['_email'];
	$email_msg = $_POST['_message'];
    $name = $_POST['_name'];
	$email_subject = "SOA Kobe & Robin contact";
	
	
	function died($error) {
		// your error code can go here
		echo "versturen van het contactformulier is mislukt.<br /><br />";
		echo $error."<br /><br />";		
		die();
	}
	
	// validation expected data exists
	if(!isset($_POST['_message']) ||
		!isset($_POST['_name'])) {
		died('Onze excuses, het versturen van het contactformulier is mislukt.');		
	}
	
	
	function clean_string($string) {
	  $bad = array("content-type","bcc:","to:","cc:","href");
	  return str_replace($bad,"",$string);
	}
	
	$email_message .= "Van: ".clean_string($name)."\n"."Bericht: ".clean_string($email_msg)."\n";
	
    // create email headers
    $headers = 'From: '.$email_from."\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email_to, $email_subject, $email_message, $headers);  

    echo "Uw contactaanvraag is verzonden.";
    ?>

    <!-- place your own success html below -->





<?php
}
die();
?>