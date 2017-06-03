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

    <title>Contact</title>

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
            <div class="row">
                <h1>About</h1>    
                <p>Supercoole pagina waarvan de info nog ingevult moet worden.</p>
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