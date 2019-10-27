<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_SESSION['email'])){
      $session = $_SESSION['email'];
    }
    if(isset($_POST['submit'])){
    $nom_service =ucfirst( $_POST['service']);
    $data = ['nom_service'=>$nom_service];
    $add = new Requette();
    $req = new ConnexionDB();
    $d = $req->connect()->prepare("SELECT COUNT(*) as nbservices FROM service WHERE nom_service = :nom_service");
    $d->execute(array('nom_service'=>$nom_service));
    while($email_verify = $d->fetch()){
      if($email_verify['nbservices'] != 0){
        $errordoublon= "<p class=\"alert alert-danger \" role=\"alert\"> Ce nom de service existe déja. </p>";
    }else{
      $res =  $add->insert($data,'service');
    if($res){
      header('location:services.php');
    }else{
        echo 'impossible';
    }
    }
  }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
  <link rel="stylesheet" href="../../css/menu.css">
  <title>SERVICES</title>
</head>
<body>
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
<div class="container">
  
  <div class="panel-group col-md-6">
    <div class="panel panel-success">
      <div class="panel-heading">AJOUTER UN SERVICE</div>
      <div class="panel-body">
        <?php
        if(isset($errordoublon)){echo $errordoublon;}
        ?>
        <form action="" method="post">
            <?php $forms = new Formulaire(); ?>
            <div class="form-group">
                <?=$forms->formInput('Nom du service','text','service','Entrez le nom du service').'<br>';?>
            </div>
            <?=$forms->formSubmit('submit','Enrégister');?>
        </form>
      </div>
 
    </div>
  </div>
  <div class="panel-group col-md-6">
    <div class="panel panel-success">
      <div class="panel-heading">LISTE DES SERVICES</div>
      <div class="panel-body">
      <?php
            $req = new Requette();
            $res = $req->selectAll('service');
            echo "
            <table class=\"table\">
            <thead class='thead-dark'>
              <tr>
                <th scope=\"col\">#</th>
                <th scope=\"col\">Nom du service</th>
                <th scope=\"col\">Actions</th>
              </tr>
            </thead>
            ";
            if(!empty($res)){
            foreach($res as $val){
                echo"<tbody>";
                echo "<tr>
                <td>".$val['id_service']."</td>
                <td>".$val['nom_service']."</td>";
                echo "
                <td><a class='btn btn-success'href='editservice.php?id=".$val['id_service']."'><em class=\"far fa-edit\"></em></a> 
                    <a class='btn btn-danger' href='delservice.php?id=".$val['id_service']."' onclick=\"return confirm('êtes vous sure de vouloir supprimer cet enrégistrement ?')\";><em class=\"fas fa-trash-alt\"></em></a>
                </td>";
            }
            echo "</tbody>";
            echo "</table>";
          }else{
            echo "<p class=\"alert alert-danger \" role=\"alert\"> Le tableau ne contient aucun élément. </p>";
          }
        ?>
      </div>
 
    </div>
  </div>

</body>
</html>
