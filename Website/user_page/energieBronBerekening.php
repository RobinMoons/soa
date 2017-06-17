
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
        $( function(){
           callBestEnergySource();
        });     

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
        }

        
        for (i = 0; i < jsonData.length; i++){
                var dateTime = jsonData[i].timestamp;
                var result = jsonData[i].result;
                strTimeStamp = String(dateTime);
                strTimeStamp = strTimeStamp.substring(4,10) + " " + strTimeStamp.substring(16,21);


        }
        

        function callBestEnergySource() {
            var data = JSON.parse(sessionStorage.getItem('gebruiker')) ;
            var energieleverancier = data.gebruiker.energieleverancier;
            var gasleverancier = data.gebruiker.gasLeverancier;  
            $.ajax("http://localhost/SOAproject/EnergieBronBepaler/EnergieBronBepalerRest.php?methode=call&gasleverancier=" + gasleverancier + "&energieleverancier=" + energieleverancier,
            {
                data: {
                    format: 'json'
                },
                dataType: 'json',
                success: function (data) {
                    var jsonString = JSON.stringify(data);
                    alert(jsonString);
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
