<script type="text/javascript">
    function navZonnewering(){
        window.location.href = "zonnewering.php";
    }
    
    function navHome(){
        window.location.href = "index.php";
    }
    
    function navAbout(){
        window.location.href = "about.php";
    }
    
    function navContact(){
        window.location.href = "contact.php";
    }
</script>


 <div id="wrapper" class="toggled">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#" onclick="logout()">
                        Log out
                    </a>
                </li>
                <li>
                    <a href="#" onclick="navHome()">Dashboard home</a>
                </li>
                <li>
                    <a href="#" onclick="getForecastOw()">OpenWeathermap test</a>
                </li>
                <li>
                    <a href="#" onclick="navZonnewering()">Automatische zonnewering</a>
                </li>
                <li>
                    <a href="#" onclick="doeRequestEs()">Energy Service test</a>
                </li>
                <li>
                    <a href="#">Bewerk gegevens</a>
                </li>
                
                <li>
                    <a href="#" onclick="navAbout()">About</a>
                </li>                
                <li>
                    <a href="#" onclick="navContact()">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->


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
    

