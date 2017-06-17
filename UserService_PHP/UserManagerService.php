<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("php-wsdl-2.3.2/class.phpwsdl.php");
PhpWsdl::RunQuickMode(array('class.Usermanager.php','class.Gebruiker.php','Authenticatie/class.ApiToken.php'));
?>