<?PHP    
    session_start();
    if(isset($_POST['gebruiker'])){          
        $gebruiker = $_POST['gebruiker'];
        $_SESSION['gebruiker'] = $gebruiker;
        $_SESSION['timestamp'] = time(); 
        echo($_SESSION['gebruiker'].gebruiker.gebruikersnaam);
    }    
    
    if(isset($_POST['logout'])){          
        session_unset(); 
        session_destroy();
    }  

    if(isset($_POST['check'])){  
        if(isset($_SESSION['gebruiker'])){        
            $idletime = 3600;
            if (time()-$_SESSION['timestamp'] > $idletime){            
                session_unset(); 
                session_destroy();
                header("Location: http://localhost/SOAproject/Website/indexREST.php");
                //echo('sessie verlopen');
            }
            else
            {
                $_SESSION['timestamp'] = time(); 
                //echo('sessie nog niet verlopen');
            }  
        }  
        else{
            session_unset(); 
            session_destroy();
            //header("Location: http://localhost/SOAproject/Website/indexREST.php");
            echo('<p>sessie bestaat niet</p>');
        }
    }  
    
?>
