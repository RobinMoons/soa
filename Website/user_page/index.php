<?PHP
    //checkSession function
/*
    session_start();
        if(isset($_SESSION['gebruiker'])){        
            $idletime = 3600;
            if (time()-$_SESSION['timestamp'] > $idletime){            
                session_unset(); 
                session_destroy();
                header("Location: http://localhost/SOAproject/Website/indexREST.php");
            }
            else
            {
                $_SESSION['timestamp'] = time(); 
            }  
        }   
        else{
            session_unset(); 
            session_destroy();
            header("Location: http://localhost/SOAproject/Website/indexREST.php");
        }
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SOA Kobe & Robin</title>

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
        });

        function checkToken(){
            $.ajax("http://localhost/SOAproject/UserService_PHP/Authenticatie/authenticatie.php",
                {
                    data:{
                        methode: "checkToken",
                        jwt: sessionStorage.getItem('token'),
                    },
                    type: "POST",
                    success: function (data){
                        alert(JSON.stringify(data));                        
                        if (typeof data.mislukt === "undefined") {
                            jsGetDataGebruiker();
                            // controleer of de gebruiker gegevens heeft
                            getWeatherOw();
                            //doeRequestYh();
                            return true;
                        } else {
                            window.location.href ="http://localhost/SOAproject/Website/indexREST.php";

                        }
                        
                    },
                    error: function(data){
                        alert("Oeps er iets iets fout gelopen");
                    }                    
                });              
        }
        
        function jsGetDataGebruiker() {
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
                error: function(data){
                    alert("Oeps er iets iets fout gelopen");
                }                    
            });        
        }
        function getWeatherOw(){ 
            var data = JSON.parse(sessionStorage.getItem('gebruiker'))
            var id =  data.gebruiker.owid;
            $.ajax("http://api.openweathermap.org/data/2.5/weather?id=" + id + "&units=metric&APPID=a4a530758bce79a5b8ef70c4b2a2a71b&mode=json",
            {
                data: {
                    format: 'json'
                },
                dataType: 'json',
                success: function (data) { 
                    sunrise = data.sys.sunrise;
                    sunrise = new Date(sunrise*1000);
                    //alert(sunrise);
                    sessionStorage.setItem("Sunrise",sunrise.getHours() *60  + sunrise.getMinutes());
                    sunset = data.sys.sunset;
                    sunset = new Date(sunset*1000);
                    sessionStorage.setItem("Sunset",sunset.getHours() * 60 + sunset.getMinutes());
                    now = new Date();
                    var prefix = 'wi wi-owm-';
                    var code = data.weather[0].id;                   
                    // If we are not in the ranges mentioned above, add a day/night prefix.
                    if (!(code > 699 && code < 800) && !(code > 899 && code < 1000)) {
                        if (now > sunrise && now < sunset ){
                            icon = 'day-' + code;
                        }
                        else
                        {
                            icon = 'night-' + code;
                        }                        
                    }
                    else
                    {
                        icon = code;
                    }
                    // Finally tack on the prefix.
                    icon = prefix + icon;   
                    $("#icoOw").addClass(icon);
                    $("#dateTime").text(now);
                    
                },
                error: function (data) {
                    alert("fout");
                }
            }
            );   
        }
        
        function getForecastOw() {
            //checkSession();
            //var id =  "<?php //echo json_decode($_SESSION['gebruiker'])->gebruiker->owid?>";
            $.ajax("http://api.openweathermap.org/data/2.5/forecast?id=" + id + "&units=metric&APPID=a4a530758bce79a5b8ef70c4b2a2a71b&mode=json",
            {
                data: {
                    format: 'json'
                },
                dataType: 'json',
                success: function (data) {
                    //alert("gelukt");
                    //var xmlString = (new XMLSerializer()).serializeToString(data);
                    var jsonString = JSON.stringify(data);
                    //console.log(data);
                    //$("#resultaatOw").text(xmlString);
                    var prefix = 'wi wi-owm-';
                    var code = data.list[0].weather[0].id;                   
                    // If we are not in the ranges mentioned above, add a day/night prefix.
                    if (!(code > 699 && code < 800) && !(code > 899 && code < 1000)) {
                        if (now > sunrise && now < sunset ){
                            icon = 'day-' + code;
                        }
                        else
                        {
                            icon = 'night-' + code;
                        }                        
                    }
                    else
                    {
                        icon = code;
                    }
                    // Finally tack on the prefix.
                    icon = prefix + icon;                    
                    $("#icoOw").addClass(icon);
                    
                    
                    draw(data);
                    //$("#preForXMLResponse").html('<pre>'+data+'</pre>');
                   // $("#woord").html(data);
                },
                error: function (data) {
                    alert("fout");
                }
            }
            );            
        }
        
        function doeRequestYh() {   
            //var city ="<?php //echo (json_decode($_SESSION['gebruiker'])->gebruiker->locatie)?>";
            var countryCode = "BE";
            
            $.ajax("https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22" + city + "%2C%20" + countryCode +"%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys",
            {
                data: {
                    format: 'json'
                },
                dataType: 'json',
                success: function (data) {
                    //alert("gelukt");
                    //var xmlString = (new XMLSerializer()).serializeToString(data);
                   var jsonString = JSON.stringify(data);    
                   var icoNow = "wi wi-yahoo-" + data.query.results.channel.item.condition.code;
                    //$("#resultaatYh").text(jsonString);
                    $("#icoYahoo").addClass(icoNow);
                    //$("#preForXMLResponse").html('<pre>'+data+'</pre>');
                   // $("#woord").html(data);
                },
                error: function (data) {
                    alert("fout");
                }
            }
            );
        }
        function doeRequestEs() {
            //checkSession();
            //var key ="<?php//echo (json_decode($_SESSION['gebruiker'])->gebruiker->enid)?>";
            //var leverancier = "<?php //echo (json_decode($_SESSION['gebruiker'])->gebruiker->energieleverancier)?>";
            $.ajax("http://usermanager-167313.appspot.com/getData?&key="+ key + "&distributor=" + leverancier,
            {
                data: {
                    format: 'json'
                },
                dataType: 'json',
                success: function (data) {
                    //alert("gelukt");
                    //var xmlString = (new XMLSerializer()).serializeToString(data);
                    var jsonString = JSON.stringify(data);                    
                    //$("#resultaatOw").text(xmlString);
                    $("#resultaatEs").text(jsonString);
                    //$("#preForXMLResponse").html('<pre>'+data+'</pre>');
                   // $("#woord").html(data);                   
                },
                error: function (data) {
                    alert("fout");
                }
            }
            );
        }
        function clearEs(){
            //checkSession();
            $("#resultaatEs").text(" ");
        }
        function logout(){            
            $.ajax("http://localhost/SOAproject/Website/session.php",
            {
               type: "POST",   
               data : {
                   logout: "logout"
                },  
               success: function(data){                   
                   window.location.href = "index.php";
               }
            });        
        }   
    </script> 
    
    
</head>

<body>

        <div id="wrapper" class="toggled">

        <?php include 'menu.php'; ?>

       

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <!--<h1>Welkom <?php echo json_decode($_SESSION['gebruiker'])->gebruiker->voornaam?>  <?php echo json_decode($_SESSION['gebruiker'])->gebruiker->achternaam?>  </h1>     -->
                                                     
                        <div>       
                            <h3 id="dateTime"></h3>
                            <h1><i id="icoOw"></i></h1>   
                            <h1><i id="icoYahoo"></i></h1>
                            <p id="resultaatOw"> </p>
                        </div>
                        
                        <!--
                        <div>Weather from Yahoo</div>
                        <input type="button" value="Clear" onclick="clearYh();" />
                        <div>      
                            <h1><i id="icoYahoo"></i></h1>
                            <p id="resultaatYh"> </p>
                        </div>
                        
                        <div>Data from Energys ervice</div>
                        <input type="button" value="Clear" onclick="clearEs();" />
                        <div>                             
                            <p id="resultaatEs"> </p>
                        </div>
                        
                        <div>Draw Chart</div>
                        <input type="button" value="Draw" onclick="draw();" />                            
                        <div id="curve_chart" style="width: 900px; height: 500px"></div>
                        -->
                        <!-- Toggle button for the menu
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle menu</a>
                        -->
                    </div>
                </div>
            </div>
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
