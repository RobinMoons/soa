
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Zonnewering</title>

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
        //wanneer de pagina geladen wordt
        $( function(){
            //check of het token geldig is
           checkToken();
        });

        //functie voor het checken van het token
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
                        if (data.message === "gelukt") {
                            
                        }    
                        else{
                            window.location.href ="http://localhost/SOAproject/Website/indexREST.php";
                            sessionStorage.setItem('gebruiker',null); 
                            sessionStorage.setItem('token',null); 
                        }                    
                    },
                    async:false,
                    error: function(data){
                        alert("Oeps er iets iets fout gelopen");
                    }                    
                });              
        }
           
        function draw(v){
           google.charts.load('current', {'packages':['corechart']});
           google.charts.setOnLoadCallback(drawChart);      
           jsonData = v;           
        }
        function drawChart() {
            //get elements from UI
            var maxTemp = document.getElementById('maxTemp').value;            
            //create charts
            //Temp
            var tempArray = new google.visualization.DataTable();
            tempArray.addColumn('string', 'Time');
            tempArray.addColumn('number', 'temperatuur');
            tempArray.addColumn('number', 'max. temperatuur');    
            //Cloud
            var cloudArray = new google.visualization.DataTable();
            cloudArray.addColumn('string', 'Time');
            cloudArray.addColumn('number', 'zonneschijn');   
            //Result screens
            var screensArray = new google.visualization.DataTable();
            screensArray.addColumn('string', 'Time');
            screensArray.addColumn('number', 'screens naar onder');
            //loop trough the JSON data to extract data
            for (i = 0; i < jsonData.list.length; i++){
                var dateTime = jsonData.list[i].dt;
                dateTime = new Date(dateTime*1000);
                hours = dateTime.getHours();
                minutes = dateTime.getMinutes();
                strTimeStamp = String(dateTime);
                strTimeStamp = strTimeStamp.substring(4,10) + " " + strTimeStamp.substring(16,21);
                time = hours  * 60 + minutes;
                //temp data
                tempArray.addRow([strTimeStamp,       jsonData.list[i].main.temp,    Number(maxTemp)]  );
                //cloud data
                var bewolking = jsonData.list[i].weather[0].id;
                var rateBewolking = 0;
                sunrise = sessionStorage.getItem("Sunrise");
                sunset = sessionStorage.getItem("Sunset");
                //alert (sunrise + "-" + sunset + "-" + time);
                if(time > sunrise && time < sunset)
                {
                    if (bewolking === 800){
                        rateBewolking = 100;
                    }
                    else if(bewolking === 801){
                        rateBewolking = 50;
                    }
                    else
                    {
                        rateBewolking = 0;
                    }
                }
                else{
                    rateBewolking = 0;
                }                
                cloudArray.addRow([strTimeStamp,       rateBewolking]  );
                if(jsonData.list[i].main.temp > maxTemp && rateBewolking > 0){
                    screensArray.addRow([strTimeStamp,       1]  );
                }
                else
                {
                    screensArray.addRow([strTimeStamp,       0]  );
                }
            }
            
            //create the options
            var tempOptions = {
              title: 'Min. en max temperatuur',
              curveType: 'function',
              legend: { position: 'bottom' }
            };                      
            var cloudOptions = {
              title: 'Zon',
              curveType: 'function',
              legend: { position: 'bottom' }
            };           
            var screensOptions = {
                title: 'Zonnewering',
                bar: {groupWidth: "100%"},
                //curveType: 'function',
                legend: { position: 'bottom' }
            };
            //create the charts
            var tempChart = new google.visualization.LineChart(document.getElementById('temp_chart'));
            tempChart.draw(tempArray, tempOptions);
            var cloudChart = new google.visualization.LineChart(document.getElementById('cloud_chart'));
            cloudChart.draw(cloudArray, cloudOptions);  
            var screensChart = new google.visualization.ColumnChart(document.getElementById('screens_chart'));
            screensChart.draw(screensArray, screensOptions);  
          }
    
        //als er op de knop gedrukt wordt, word de berekening gestart
        function calculate() {      
            //haal de gegevens van de gebruiker op  
            var data = JSON.parse(sessionStorage.getItem('gebruiker')) ;
            var id = data.gebruiker.owid;  
            //doe een GET request naar de weerservice
            $.ajax("http://api.openweathermap.org/data/2.5/forecast?id=" + id + "&units=metric&APPID=a4a530758bce79a5b8ef70c4b2a2a71b&mode=json",
            {
                data: {
                    format: 'json'
                },
                dataType: 'json',
                success: function (data) {   
                    //on succes, teken de data                 
                    var jsonString = JSON.stringify(data);
                    draw(data);
                },
                error: function (data) {
                    alert("fout");
                }
            }
            );            
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
                        <h1>Berekening automatische zonneregeling  </h1>    
                             
                        <h2>Parameters</h2>                        
                        Maximum Temperatuur: <input type="text" id="maxTemp"/>
                        <input type="button" value="Bereken" onclick="calculate();" />
                        
                        <h2>Berekening</h2>
                        <div id="temp_chart" style="width: 600px; height: 250px; float:left"></div>
                        <div id="cloud_chart" style="width: 600px; height: 250px; float:left"></div>
                        <div id="screens_chart" style="width: 1200px; height: 500px; float:left"></div>
                        
                        -->
                    </div>
                </div>
            </div>
        </div>
        
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
