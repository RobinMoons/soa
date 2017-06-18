<script type="text/javascript">

    //ieder menuitem 
    function navZonnewering(){
        window.location.href = "zonnewering.php";
    }
    function navBoilerverwarming(){
        window.location.href = "boilerverwarming.php";
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

    function navBewerkGegevens(){
        window.location.href = "bewerkGegevens.php";
    }
    function navEnergieBronBerekening(){
        window.location.href = "energieBronBerekening.php";
    }
    function logout(){            
        sessionStorage.setItem('token', null);  
        sessionStorage.setItem('gebruiker', null);            
        window.location.href = "http://localhost/SOAproject/Website/indexREST.php";                  
    }  
</script>


 <div id="wrapper" class="toggled">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#" onclick="logout()"> Log out</a>
                </li>
                <li>
                    <a href="#" onclick="navHome()">Dashboard home</a>
                </li>
                <li>
                    <a href="#" onclick="navBoilerverwarming()">Boiler verwarming</a>
                </li>
                <li>
                    <a href="#" onclick="navZonnewering()">Automatische zonnewering</a>
                </li>
                <li>
                    <a href="#" onclick="navEnergieBronBerekening()">Energie bron berekening</a>
                </li>
                <li>
                    <a href="#" onclick="navBewerkGegevens()">Bewerk gegevens</a>
                </li>
                
                <li>
                    <a href="#" onclick="navAbout()">Info</a>
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
    

