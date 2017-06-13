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
    <script type="text/javascript" src="require.js"></script> 
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
        function sendMail(){
            name = $("#name").val();
            email = $("#email").val();
            message = $("#message").val();
            
             $.ajax("sendMail.php",
            {
                data:{
                    _email_to: email,
                    _message: message,
                    _name: name
                },
                type: "POST",
                 success: function (data){
                     //alert(data);   
                     //document.getElementById("sendComplete").innerHTML = "Contact aanvraag verzonden!";
                     //$("sendComplete").text("Contact aanvraag verzonden!");
                 },
                 error: function(data){
                     //alert(data);
                    // document.getElementById("sendComplete").innerHTML = "Kon contact aanvraag niet verzenden!";
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
                <div class="col-md-6 col-md-offset-3">
                  <div class="well well-sm">
                    <form class="form-horizontal" action="" method="post">
                    <fieldset>
                      <legend class="text-center">Contacteer ons</legend>

                      <!-- Name input-->
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="name">Naam</label>
                        <div class="col-md-9">
                          <input id="name" name="name" type="text" placeholder="naam" class="form-control">
                        </div>
                      </div>

                      <!-- Email input-->
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="email">E-mail</label>
                        <div class="col-md-9">
                          <input id="email" name="email" type="text" placeholder="email" class="form-control">
                        </div>
                      </div>

                      <!-- Message body -->
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="message">Bericht</label>
                        <div class="col-md-9">
                          <textarea class="form-control" id="message" name="message" placeholder="Please enter your message here..." rows="5"></textarea>
                        </div>
                      </div>

                      <!-- Form actions -->
                      <div class="form-group">
                        <div class="col-md-12 text-right">
                            
                            <button type="submit" class="btn btn-primary btn-lg" onclick="sendMail()">Send</button>
                        </div>
                      </div>
                    </fieldset>                        
                    </form>                     
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
