<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Boilerverwarming</title>

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
            var data = JSON.parse(sessionStorage.getItem('gebruiker')) ;
           key = data.gebruiker.enid;
           leverancier = data.gebruiker.energieleverancier;
           $.ajax("http://usermanager-167313.appspot.com/getData?&key="+ key + "&distributor=" + leverancier,
            {
                data: {
                    format: 'json'
                },
                dataType: 'json',
                success: function (data) {
                    var jsonString = JSON.stringify(data);   
                    nachttarief = data["Distributor_info"].Nachttarief;
                    dagtarief = data["Distributor_info"].Dagtarief;
                    calculate();
                },
                error: function (data) {
                    alert("fout");
                }
            });
        });
           
        function draw(v){
           google.charts.load('current', {'packages':['corechart']});
           google.charts.setOnLoadCallback(drawChart);      
           jsonData = v;           
        }
        function drawChart() {
            //create charts
            //price
            var priceArray = new google.visualization.DataTable();
            priceArray.addColumn('string', 'Time');
            priceArray.addColumn('number', 'prijs - leverancier: ' + leverancier );  
            
            //Cloud
            var cloudArray = new google.visualization.DataTable();
            cloudArray.addColumn('string', 'Time');
            cloudArray.addColumn('number', 'zonneschijn');   
            //Result screens
            
            var boilerArray = new google.visualization.DataTable();
            boilerArray.addColumn('string', 'Time');    
            boilerArray.addColumn('number', 'energiebron');    
            boilerArray.addColumn({type:'string', role: 'annotation' });   
            boilerArray.addColumn({type:'string', role: 'style' });
    
            //loop trough the JSON data to extract data
            for (i = 0; i < jsonData.list.length; i++){
                var dateTime = jsonData.list[i].dt;
                dateTime = new Date(dateTime*1000);
                hours = dateTime.getHours();
                minutes = dateTime.getMinutes();
                strTimeStamp = String(dateTime);
                strTimeStamp = strTimeStamp.substring(4,10) + " " + strTimeStamp.substring(16,21);
                time = hours  * 60 + minutes;
               
                
                //cloud data
                var bewolking = jsonData.list[i].weather[0].id;
                var rateBewolking = 0;
                sunrise = sessionStorage.getItem("Sunrise");
                sunset = sessionStorage.getItem("Sunset");
                //alert (sunrise + "-" + sunset + "-" + time);
                if(time > sunrise && time < sunset)
                {
                    priceArray.addRow([strTimeStamp,       dagtarief]  );
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
                    if (rateBewolking > 0 ){
                        boilerArray.addRow([strTimeStamp,       100, 'z',  'color: yellow']);
                    }
                    else
                    {
                        boilerArray.addRow([strTimeStamp,       100,'e',  'color: green']);
                    }
                }
                else{
                    priceArray.addRow([strTimeStamp,       nachttarief]  );
                    rateBewolking = 0;
                    boilerArray.addRow([strTimeStamp,       100,'e',  'color: green']);
                }                
                cloudArray.addRow([strTimeStamp,       rateBewolking]  );
                
            }
            
            //create the options
            var priceOptions = {
              title: 'prijs ifv dag en nacht',
              //curveType: 'function',
              legend: { position: 'bottom' }
            };                      
            var cloudOptions = {
              title: 'Zon',
              curveType: 'function',
              legend: { position: 'bottom' },            
            };     
    
            var boilerOptions = {
                title: 'Energiebron opwarmen boiler',
                bar: {groupWidth: "100%"},
                //curveType: 'function',                
                'vAxis': {'title': ' ',
                            'minValue': 0, 
                            'maxValue': 100},
            };
    
            //create the charts
            var priceChart = new google.visualization.LineChart(document.getElementById('price_chart'));
            priceChart.draw(priceArray, priceOptions);
            var cloudChart = new google.visualization.LineChart(document.getElementById('cloud_chart'));
            cloudChart.draw(cloudArray, cloudOptions);      
            var boilerChart = new google.visualization.ColumnChart(document.getElementById('boiler_chart'));
            boilerChart.draw(boilerArray, boilerOptions);  
    
    
          }
    
             
        function calculate() {
            //checkSession();      
            var data = JSON.parse(sessionStorage.getItem('gebruiker')) ;
            var id = data.gebruiker.owid;                  
            $.ajax("http://api.openweathermap.org/data/2.5/forecast?id=" + id + "&units=metric&APPID=a4a530758bce79a5b8ef70c4b2a2a71b&mode=json",
            {
                data: {
                    format: 'json'
                },
                dataType: 'json',
                success: function (data) {                    
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
                        <h1>Berekening verwarmen van buffervat</h1>                             
                        <h2>Boiler verwarming</h2>     
                        <div id="cloud_chart" style="width: 600px; height: 250px; float:left"></div>
                        <div id="price_chart" style="width: 600px; height: 250px; float:left"></div>
                        <div id="boiler_chart" style="width: 1200px; height: 500px; float:left"></div>
                        
                        
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
