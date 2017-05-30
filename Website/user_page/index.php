<?PHP
    //checkSession function
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
        var jsonData;        
        function draw(v){
           google.charts.load('current', {'packages':['corechart']});
           google.charts.setOnLoadCallback(drawChart);      
           jsonData = v;           
        }
        function drawChart() {
            var dataArray = new google.visualization.DataTable();
            dataArray.addColumn('string', 'Time');
            dataArray.addColumn('number', 'min. temperatuur');
            dataArray.addColumn('number', 'max. temperatuur');            
            
            for (i = 0; i < jsonData.list.length; i++){
                dataArray.addRow([jsonData.list[i].dt_txt,       jsonData.list[i].main.temp_min,    jsonData.list[i].main.temp_max]);
            }
            //var data = google.visualization.arrayToDataTable(dataArray);
            /*
            var data = google.visualization.arrayToDataTable([
              ['Time',                          'min. temperatuur',                 'max. temperatuur'],
              [jsonData.list[0].dt_txt,       jsonData.list[0].main.temp_min,    jsonData.list[0].main.temp_max],
              [jsonData.list[1].dt_txt,       jsonData.list[1].main.temp_min,    jsonData.list[1].main.temp_max],
              [jsonData.list[2].dt_txt,       jsonData.list[2].main.temp_min,    jsonData.list[2].main.temp_max],
              [jsonData.list[3].dt_txt,       jsonData.list[3].main.temp_min,    jsonData.list[3].main.temp_max],
              [jsonData.list[4].dt_txt,       jsonData.list[4].main.temp_min,    jsonData.list[4].main.temp_max],
              [jsonData.list[5].dt_txt,       jsonData.list[5].main.temp_min,    jsonData.list[5].main.temp_max],
              [jsonData.list[6].dt_txt,       jsonData.list[6].main.temp_min,    jsonData.list[6].main.temp_max],
              [jsonData.list[7].dt_txt,       jsonData.list[7].main.temp_min,    jsonData.list[7].main.temp_max],
              [jsonData.list[8].dt_txt,       jsonData.list[8].main.temp_min,    jsonData.list[8].main.temp_max],
              [jsonData.list[9].dt_txt,       jsonData.list[9].main.temp_min,    jsonData.list[9].main.temp_max]
            ]);
            */
            var options = {
              title: 'Min. en max temperatuur',
              curveType: 'function',
              legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(dataArray, options);
          }
        function checkSession(){
            $.ajax("http://localhost/SOAproject/Website/session.php",
                {
                   type: "POST",   
                   data : {
                       check: "check"
                   }  
                });
        }
        function doeRequestOw() {
            //checkSession();
            var id =  "<?php echo json_decode($_SESSION['gebruiker'])->gebruiker->owid?>";
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
                    var icoNow = "wi wi-owm-" + data.list[0].weather[0].id;
                    $("#icoOw").addClass(icoNow);
                    $("#resultaatOw").text(jsonString);
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
        function clearOw(){
            //checkSession();
            $("#resultaatOw").text(" ");
        }
        function clearYh(){
            $("#resultaatYh").text(" ");
        }
        function doeRequestYh() {   
            var city ="<?php echo (json_decode($_SESSION['gebruiker'])->gebruiker->locatie)?>";
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
                    $("#resultaatYh").text(jsonString);
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
            var key ="<?php echo (json_decode($_SESSION['gebruiker'])->gebruiker->enid)?>";
            var leverancier = "<?php echo (json_decode($_SESSION['gebruiker'])->gebruiker->energieleverancier)?>";
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

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#" onclick="logout()">
                        Log out
                    </a>
                </li>
                <li>
                    <a href="#" onclick="doeRequestOw()">OpenWeathermap test</a>
                </li>
                <li>
                    <a href="#" onclick="doeRequestYh()">Yahoo Weather test</a>
                </li>
                <li>
                    <a href="#" onclick="doeRequestEs()">Energy Service test</a>
                </li>
                <li>
                    <a href="#">Bewerk gegevens</a>
                </li>
                
                <li>
                    <a href="#">About</a>
                </li>                
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

       

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Welkom <?php echo json_decode($_SESSION['gebruiker'])->gebruiker->voornaam?>  <?php echo json_decode($_SESSION['gebruiker'])->gebruiker->achternaam?>  </h1>    
                             
                        <div>Weather from OpenWeathermap</div>
                        
                        <input type="button" value="Clear" onclick="clearOw();" />
                        <div>       
                            <h1><i id="icoOw"></i></h1>
                            <p id="resultaatOw"> </p>
                        </div>
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
                        
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Open menu</a>
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
