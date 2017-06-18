
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>registreer</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
        <script type="text/javascript" src="jquery-3.2.1.min.js"></script> 
        
        <script type="text/javascript">        
            //functie om een nieuwe gebruiker te registreren
            function jsRegister(){   
                //haal de gegevens op uit de pagina             
                username = $("#form-username").val();
                passwoord = $("#form-password").val();
                passwoord2 = $("#form-password2").val();
                email = $("#form-email").val();
                //check of de passwoord lengte < 7, geef dan een errormelding
                if(passwoord.length < 7){
                    document.getElementById("form-info").innerHTML = "Wachtwoord moet meer dan 6 karakters bevatten!";
                    document.getElementById("form-info").style.color = "#ff0000";
                    document.getElementById("form-password").innerHTML = "";
                    document.getElementById("form-password2").innerHTML = "";
                }
                else{
                    //indien lengte oké, check of de twee passwoorden gelijk zijn
                    if (passwoord === passwoord2){
                        //stuur naar usermanagerREST de gegevens van de nieuwe gebruiker, en registreermethode
                        $.ajax("http://localhost/SOAproject/UserService_PHP/usermanagerREST.php",
                        {
                            data:{
                                methode: "nieuweUser",
                                gebruikersnaam: username,
                                wachtwoord: passwoord,
                                emailadres: email
                            },
                            type: "POST",
                            success: function (data){
                                //alert(data);                                
                            },
                            error: function(data){
                               // alert(JSON.stringify(data));
                            }                    
                        });       
                    }
                    else //als de passwoordlengtes niet gelijk zijn, geef errormelding
                    {
                        document.getElementById("form-info").innerHTML = "Wachtwoorden zijn niet gelijk!";
                        document.getElementById("form-info").style.color = "#ff0000";
                    }
                }

                
            }
            
            
        </script> 

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">                            
							<h1>Registreer een nieuwe gebruiker</h1>
                            <div class="description">
                            	<p>
	                            	Vul uw gegevens in!                                        
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Kies een gebruikersnaam en wachtwoord</h3>
                                    <p id="form-info"></p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="form-username" placeholder="Gebruikersnaam..." class="form-username form-control" id="form-username">
			                        </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-email">E-mail</label>
                                        <input type="text" name="form-email" placeholder="E-mail adres..." class="form-email form-control" id="form-email">
                                    </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="form-password" placeholder="Wachtwoord..." class="form-password form-control" id="form-password">
			                        </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password2">Password</label>
                                        <input type="password" name="form-password2" placeholder="Herhaal wachtwoord..." class="form-password2 form-control" id="form-password2">
                                    </div>
			                        <button type="button" onclick="jsRegister();" class="btn">Registreer!</button>
                                    <div class="form-group">
                                        <a href="indexREST.php">login</a>      -      <a href="wachtwoord-vergeten.php">Wachtwoord vergeten</a>
                                    </div>
			                    </form>
		                    </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>