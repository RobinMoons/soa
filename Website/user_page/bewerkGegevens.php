

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bewerk gegevens</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/weather-icons.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="jquery-3.2.1.min.js"></script> 
    
    <script type="text/javascript">             
        $( function(){
            checkToken();  
            jsGetDataGebruiker();
             //on load function
            var data = JSON.parse(sessionStorage.getItem('gebruiker')) 
            alert(JSON.stringify(data));
            var gebruikersnaam =  data.gebruiker.gebruikersnaam;            
            var voornaam =  data.gebruiker.voornaam;
            var achternaam =  data.gebruiker.achternaam;
            var email = data.gebruiker.email; //nog implementeren
            var licentie =  data.gebruiker.licentie;
            var locatie =  data.gebruiker.locatie;
            var landcode = data.gebruiker.landcode;
            var owid =  data.gebruiker.owid;
            var energieleverancier =  data.gebruiker.energieleverancier;
            var enid =  data.gebruiker.enid;
            var gasleverancier = data.gebruiker.gasleverancier;

            if (gebruikersnaam != null){
                document.getElementById("header").innerHTML = "Gebruiker: " + gebruikersnaam;
            }            
            if (voornaam != null){
                document.getElementById("form-voornaam").value = voornaam;
            }
            if (achternaam != null){
                document.getElementById("form-naam").value = achternaam;
            }
            if (email != null){
                document.getElementById("form-email").value = email;
            }
            if (owid != null){
                document.getElementById("form-owid").value = owid;
            }
            if (locatie != null){
                document.getElementById("form-locatie").value = locatie;
            }
            if (landcode != null){
                document.getElementById("form-land").value = landcode;
            }
            if (enid != null){
                document.getElementById("form-enid").value = enid;
            }
            if (energieleverancier != null){
                document.getElementById("form-stroomlev").value = energieleverancier;
            }
            if (gasleverancier != null){
                document.getElementById("form-gaslev").value = gasleverancier;
            }


        });

        function jsGetDataGebruiker() {
            var data =  sessionStorage.getItem('token');            
            $.ajax("http://localhost/SOAproject/UserService_PHP/usermanagerREST.php",
            {
                data:{
                    methode: "dataGebruiker",
                    data: sessionStorage.getItem('token'),
                },
                type: "GET",
                success: function (data){
                    if (typeof data.mislukt === "undefined") {
                        sessionStorage.setItem('gebruiker',JSON.stringify(data));                        
                    } else {
                        alert(data.mislukt);
                    }
                },
                async:false,
                error: function(data){
                    alert("Oeps er iets iets fout gelopen");
                }                    
            });        
        }

        function checkToken(){
            $.ajax("http://localhost/SOAproject/UserService_PHP/Authenticatie/authenticatie.php",
                {
                    data:{
                        methode: "checkToken",
                        jwt: sessionStorage.getItem('token'),
                    },
                    type: "POST",
                    success: function (data){
                        //alert(JSON.stringify(data));                        
                        if (!typeof data.mislukt === "undefined") {
                            window.location.href ="http://localhost/SOAproject/Website/indexREST.php";
                        }
                        else{
                            document.getElementById("token").value = sessionStorage.getItem('token')
                        }
                    },
                    async:false,
                    error: function(data){
                        alert("Oeps er iets iets fout gelopen");
                    }                    
                });              
        }

        function jsOpslaan(){
            //$.ajax("SOAP POST VAN DE GEGEVENS")
            alert("SOAP post implementeren");
        }

        
    </script> 
    
</head>

<body>

        <div id="wrapper" class="toggled">

        <?php include 'menu.php'; ?>      

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <form role="form" action="sendGegevens.php" method="post" class="gegevens-form">
                <h1 id="header">Gebruiker:</h1> 
                <div class="form-top-left">
                    <h3>Persoonlijke gegevens</h3>  
                <div class="form-group">
                    <p>Naam:</p>
                    <label class="sr-only" for="form-naam">Naam:</label>
                    <input type="text" name="form-naam" placeholder="Naam..." class="form-naam form-control" id="form-naam" required>                
                    <p>Voornaam:</p>
                    <label class="sr-only" for="form-voornaam">Voornaam:</label>
                    <input type="text" name="form-voornaam" placeholder="Voornaam..." class="form-voornaam form-control" id="form-voornaam" required>                
                   <p>Email:</p>
                    <label class="sr-only" for="form-password">E-mail:</label>
                    <input type="text" name="form-email" placeholder="E-mail..." class="form-email form-control" id="form-email" required>
                </div>
                    <h3>Weerinformatie</h3>
                <div class="form-group">
                    <p>OpenWeathermap ID:</p>
                    <label class="sr-only" for="form-owid">owid:</label>
                    <input type="text" name="form-owid" placeholder="OWID..." class="form-owid form-control" id="form-owid">                
                    <p>Locatie:</p>
                    <label class="sr-only" for="form-locatie">locatie:</label>
                    <input type="text" name="form-locatie" placeholder="Stad / dorp..." class="form-locatie form-control" id="form-locatie">
                   <p>Landcode:</p>
                    <label class="sr-only" for="form-land">Landcode:</label>
                    <input type="text" name="form-land" placeholder="BE, NL, FR..." class="form-land form-control" id="form-land">
                </div>                
                    <h3>Energie service informatie</h3>
                <div class="form-group">
                    <p>EnergieService ID:</p>
                    <label class="sr-only" for="form-enid">owid:</label>
                    <input type="text" name="form-enid" placeholder="ENID..." class="form-enid form-control" id="form-enid">
                    <p>Stroomleverancier:</p>
                    <label class="sr-only" for="form-stroomlev">stroomleverancier:</label>
                    <input type="text" name="form-stroomlev" placeholder="Stroomleverancier..." class="form-stroomlev form-control" id="form-stroomlev">              
                   <p>Gasleverancier:</p>                   
                    <label class="sr-only" for="form-gaslev">gasleverancier:</label>
                    <input type="text" name="form-gaslev" placeholder="Gasleverancier..." class="form-gaslev form-control" id="form-gaslev">
                </div>
                <input type="hidden" name="token" id="token">
             </form>               
             <button type="submit" class="btn">Opslaan!</button>
        </div>     

            
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
