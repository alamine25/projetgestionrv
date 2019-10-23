<?php
    class Menu{
        public function __construct()
        {
            echo "
            
            <nav class=\"navbar navbar-inverse\">
            <div class=\"container-fluid\">
              <ul class=\"nav navbar-nav\">
                <li class=\"active\"><a href=\"homeadmin.php\">ACCUEIL</a></li>
                <li><a href=\"secretariat.php\">SECRETARIAT</a></li>
                <li><a href=\"medecine.php\">MEDECINE</a></li>
                <li><a href=\"services.php\">SERVICES</a></li>
              </ul>
              <ul class=\"nav navbar-nav navbar-right\">
                <li><a href=\"#\"><span class=\"glyphicon glyphicon-log-in\"></span> DECONNEXION</a></li>
              </ul>
            </div>
          </nav> 
            ";
        }
    
    }
?>