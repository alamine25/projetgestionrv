<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    
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
  <title>RENDEZ-VOUS</title>
</head>
<body>
<nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <?php
                if(isset($_SESSION['id_medecin'])){
                    $s = $_SESSION['id_medecin'];
                
                ?>
                <li><a href="">RENDEZ-VOUS</a></li><?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <li class="connect"><?php if(isset( $_SESSION['prenom'])&& $_SESSION['prenom']){echo $_SESSION['prenom']." " .$_SESSION['nom'];}?></li>
            <li><a href="deconnexion.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
            </ul>
        </div>
        </nav>
<div class="container-fluid">


    <div class="panel-group col-md-10">
    <div class="panel panel-success">
      <div class="panel-heading">LISTE DES RENDEZ-VOUS</div>
      <div class="panel-body">
       <!-- Liste des rv -->
       <?php
       if(isset($_GET['id'])){
        $id =  $_GET['id']; 
        }
        $bdd = new ConnexionDB();
        $req = new Requette();
        $user = $req->selectAllCondition('patient','rendez_vous','secretaire','rendez_vous.id_patient','patient.id_patient','rendez_vous.id_secretaire',$id);
        
         echo "
         <table class=\"table\" align=\"center\" >
         <thead class='thead-dark' align=\"center\">
           <tr>
             <th scope=\"col\">Numéro RV</th>
             <th scope=\"col\">Prenom</th>
             <th scope=\"col\">Nom</th>
             <th scope=\"col\">Age</th>
             <th scope=\"col\">Adresse</th>
             <th scope=\"col\">Telephone</th>
             <th scope=\"col\">Date rv</th>
             <th scope=\"col\">Heure debut</th>
             <th scope=\"col\">Heure fin</th>
             <th scope=\"col\">Actions</th>
           </tr>
         </thead>
         ";
        if(!empty($user)){
         foreach($user as $val){
             echo"<tbody>";
             echo "<tr>
            <td>".$val['id_rv']."</td>
            <td>".$val['prenom']."</td>
            <td>".$val['nom']."</td>
            <td>".$val['age']."</td>
            <td>".$val['adresse']."</td>
            <td>".$val['telephone']."</td>
            <td>".$val['date']."</td>
            <td>".$val['heure_debut']."</td>
            <td>".$val['heure_fin']."</td>";
             echo "
            <td><a class='btn btn-primary'href='modifrv.php?id=".$val['id_rv']."'><em class=\"far fa-edit\"></em></a> 
                 <a class='btn btn-danger' href='suprv.php?id=".$val['id_rv']."' onclick=\"return confirm('êtes vous sure de vouloir supprimer cet enrégistrement ?')\";><em class=\"fas fa-trash-alt\"></em></a>
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

</body>
</html>
