
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>SOA K&R Login</title>
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
        

            function jsLogin(){                
                username = $("#form-username").val();
                passwoord = $("#form-password").val();
                $.ajax("http://localhost/SOAproject/UserService_PHP/Authenticatie/authenticatie.php",
                {
                    data:{
                        methode: "login",
                        gebruikersnaam: username,
                        wachtwoord: passwoord
                    },
                    type: "POST",
                    success: function (data){                    
                        if (typeof data.mislukt === "undefined") {
                            sessionStorage.setItem('token',data.jwt);
                            window.location.href = "user_page/index.php";
                        } else {
                            alert(data.mislukt);
                        }
                        
                    },
                    error: function(data){
                        alert("Oeps er iets iets fout gelopen");
                    }                    
                }); 
            }
            function startSession(user){
                $.ajax("http://localhost/SOAproject/Website/session.php",
                {
                   type: "POST",   
                   data : {
                       gebruiker: user
                   },                                    
                   success: function(data){    
                        var w = window.location.href = "user_page/index.php";
                        var token = {JWT : store.JWT};
                        w.myVariable  = token;
                   },
                   error: function(data){
                        alert("start session failed");
                    }
                });
            }
        </script> 

    </head>

    <body>
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>SOA project</strong> </h1> 
                            <h1>Home Energy Management Service</h1>
                            <h3>by:</h3>
                            <h2>Kobe Bamps & Robin Moons</h2>
                            <div class="description">
                            	<p>

                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login</h3>
                            		<p>Vul uw gebruikersnaam en wachtwoord in om in te loggen:</p>
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
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="form-password" placeholder="Wachtwoord..." class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="button" onclick="jsLogin();" class="btn">Inloggen!</button>
                                    <div class="form-group">
                                        <a href="registreer.php">Registreer</a>      -      <a href="wachtwoord-vergeten.php">Wachtwoord vergeten</a>
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