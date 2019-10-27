<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    require_once '../classes/Menu.php';
    if(isset($_SESSION['email'])){
      $session = $_SESSION['email'];
    

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
  <link rel="stylesheet" href="../../css/admin.css">
  <title>ACCUEIL</title>
</head>

<body>

  <!-- Bar de Navigation -->
  
 
  <nav class="navbar navbar-inverse" aria-label="">
            <div class="container-fluid">
              <ul class="nav navbar-nav">
                <li class="active"><a href="homeadmin.php">SEN-MEDIC</a></li>
                <li><a href="secretariat.php">COMPTE SECRETAIRE</a></li>
                <li><a href="medecine.php">COMPTE MEDECIN</a></li>
                <li><a href="services.php">COMPTE SERVICES</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="connect"><?php if(isset( $session)){echo $session;}?></li>
                <li><a href="deconnectadmin.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
              </ul>
            </div>
          </nav>


</body>
</html>
<?php
}else{
  header('location:admin.php');
}
?>