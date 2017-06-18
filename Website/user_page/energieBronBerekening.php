
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Energie bron berekening</title>

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
            //check token
            checkToken();
            //roep de functie op om de energiebron te berekenen en tekenen
            callBestEnergySource();
        });     
        //functie voor  het checken van het token
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
                            //alert("token oké");
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
        //teken de gegevens
        function draw(v){
           google.charts.load('current', {'packages':['corechart']});
           google.charts.setOnLoadCallback(drawChart);      
           jsonData = v;           
        }

        function drawChart(){
            var sourceArray = new google.visualization.DataTable();
            sourceArray.addColumn('string', 'Time');    
            sourceArray.addColumn('number', 'energiebron');    
            sourceArray.addColumn({type:'string', role: 'annotation' });   
            sourceArray.addColumn({type:'string', role: 'style' });
        
            //als de data goed is
            if (jsonData.message ==="succes"){
                //doorloop de lijst met gegevens en bouw de array op
                for (i = 0; i < jsonData.data.length; i++){
                    var dateTime = jsonData.data[i].timestamp;
                    var result = jsonData.data[i].result;
                    strTimeStamp = String(dateTime);
                    strTimeStamp = strTimeStamp.substring(5,10) + ", " + strTimeStamp.substring(11,16);
                    if (result === "E"){
                        sourceArray.addRow([strTimeStamp,100,'E','color: yellow']);
                    }
                    if (result === "G"){
                        sourceArray.addRow([strTimeStamp,100,'G','color: green']);
                    }
                }
            }
            else
            {
                alert("no succes");
            }

            var sourceOptions = {
                title: 'Bepaling van de zuinigste energiebron',
                bar: {groupWidth: "100%"},           
                'vAxis': {'title': ' ',
                            'minValue': 0, 
                            'maxValue': 100},
            };

            var sourceChart = new google.visualization.ColumnChart(document.getElementById('source_chart'));
            sourceChart.draw(sourceArray, sourceOptions);  
        }
        
        //functie die de gegevens gaat ophalen, die berekendw orden door de EnergieBronBepalerRest    
        function callBestEnergySource() {
            //haal de gegevens op uit de variabele
            var data = JSON.parse(sessionStorage.getItem('gebruiker')) ;
            var energieleverancier = data.gebruiker.energieleverancier;            
            var gasleverancier = data.gebruiker.gasLeverancier;  
            var owid = data.gebruiker.owid;
            //stuur GET request naar de service met als parameters de leveranciers en het OWID die gebruikt zal worden om de weerinfo op te halen
            $.ajax("http://localhost/SOAproject/EnergieBronBepaler/EnergieBronBepalerRest.php?methode=get&gasleverancier=" + gasleverancier + "&energieleverancier=" + energieleverancier + "&owid=" + owid,
            {
                data: {
                    format: 'json'
                },               
                dataType: 'json',
                success: function (data) {
                    var jsonString = JSON.stringify(data);
                    //alert(jsonString);
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
            <div class="row">
                <h1>Energie bron berekening</h1>    
                <p>Op onderstaande grafiek is te zien welke energie bron het rendabelste is.</p>
                <div id="source_chart" style="width: 1200px; height: 500px; float:left"></div>
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
