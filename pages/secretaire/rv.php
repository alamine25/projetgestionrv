<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_GET['id'])){
    $id = $_GET['id'];
    }
    if(isset($_POST['submit'])){
        $dates = $_POST['date'];
        $hdebut = $_POST['heure_debut'];
        $hfin = $_POST['heure_fin'];
        $horaire = $_POST['plage_horaire'];
        $secretaire = $_POST['secretaire'];
        $medecin = $_POST['medecin'];
        $patient = $_POST['patient'];
        if(!empty($dates) && !empty($hdebut) && !empty($hfin) && !empty($horaire) && !empty($secretaire)&& !empty($medecin) && !empty($patient)){
        $data = [ 'date'=>$dates,'heure_debut'=>$hdebut,'heure_fin'=>$hfin,'id_secretaire'=>$secretaire,'id_horaire'=>$horaire,'id_medecin'=>$medecin,'id_patient'=>$patient ];
        $datenow = new DateTime();
        if ($datenow <= DateTime::createFromFormat('Y-m-d', $dates)){
           echo 'cool';
        }
        else{
            $error_date = "<p class=\"alert alert-danger \" role=\"alert\"> La date est passée. </p>";
        } 
        }else{
            $error_champ = "<p class=\"alert alert-danger \" role=\"alert\"> Tous les champs doivent être remplis. </p>";
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
  <title>RENDEZ-VOUS</title>
</head>
<body>
<nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <?php
                if(isset($_SESSION['id_secretaire'])){
                    $s = $_SESSION['id_secretaire'];
                
                ?>
            <li><a href='acceuil.php?id=<?php echo $s ;?>' > PATIENT</a></li>
                <li><a href="">RENDEZ-VOUS</a></li><?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <li class="connect"><?php if(isset( $_SESSION['prenom'])&& $_SESSION['prenom']){echo $_SESSION['prenom']." " .$_SESSION['nom'];}?></li>
            <li><a href="deconnexion.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
            </ul>
        </div>
        </nav>
 <div class="container-fluid">
  
  <div class="panel-group col-md-2">
    <div class="panel panel-success">
      <div class="panel-heading">FIXER UN RENDEZ_V</div>
      <div class="panel-body">
        <?php
        if(isset($error_champ)){echo $error_champ;} 
        if(isset($error_date)){echo $error_date;}   
        ?>
    <form action="" method="post">
        <div class="form-group ">
            <?php
                $forms = new Formulaire();
                $req = new Requette();
                echo $forms->formInput('Date','date','date','Entrez la date');
                echo $forms->formInput('Heure début ','time','heure_debut','');
                echo $forms->formInput('Heure fin ','time','heure_fin','');
                echo $forms->formInput('','hidden','secretaire','',$_GET['id']);
                $res = $req->selectAll('plage_horaire');
                $liste_option= "";
                if(!empty($res)){
                foreach ($res as $value) {

                        $liste_option .= "<option value=".$value['id_horaire'].">" .$value['id_horaire'].' - '.$value['date']."</option>";
                    }
                }else{
                    echo "<p class=\"alert alert-danger \" role=\"alert\"> La table est vide. </p>";
                }
                echo $forms->selectList('Choisissez une horaire','plage_horaire',$liste_option);

                if(isset($_SESSION['id_service'])){
                    $id_service = $_SESSION['id_service'];
                }    
                $res = $req->selectWithCondition('medecin','id_service',$id_service);
                $liste_option= "";
                if(!empty($res)){
                foreach ($res as $value) {

                    $liste_option .= "<option value=".$value['id_medecin'].">" .$value['id_medecin'].' - '.$value['prenom'].' - '.$value['nom']."</option>";
                }
                }else{
                    echo "<p class=\"alert alert-danger \" role=\"alert\"> La table est vide. </p>";
                }
                echo $forms->selectList('Choisissez un medecin','medecin',$liste_option);
                $res = $req->selectWithCondition('patient','id_secretaire',$_GET['id']);
                $liste_option= "";
                if(!empty($res)){
                foreach ($res as $value) {

                    $liste_option .= "<option value=".$value['id_patient'].">" .$value['id_patient'].' - '.$value['prenom'].' - '.$value['nom']."</option>";
                }
                }else{
                    echo "<p class=\"alert alert-danger \" role=\"alert\"> La table est vide. </p>";
                }
                echo $forms->selectList('Choisissez un patient','patient',$liste_option);
            ?>
            </div> 
            <?php echo $forms->formSubmit('submit','Enrégister'); ?>
        </form>
        </div>
        </div>
    </div>
    <div class="panel-group col-md-10">

        <div class="panel panel-primary">
            <div class="panel-heading">RECHERCHE</div>
            <div class="panel-body">
               <form action="" method="get" class="form-inline">
                    <div class="form-group">
                        <input type="text" name="nom" placeholder="saisir un nom" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-search"></span> Rechercher</button>
               </form>
            </div>
        </div>

    <div class="panel panel-success">
      <div class="panel-heading">LES RENDEZ-VOUS</div>
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
            <td><a class='btn btn-success'href='modifrv.php?id=".$val['id_rv']."'><em class=\"far fa-edit\"></em></a> 
                 <a class='btn btn-danger' href='suprv.php?id=".$val['id_rv']."' onclick=\"return confirm('êtes vous sure de vouloir supprimer cet enrégistrement ?')\";><em class=\"fas fa-trash-alt\"></em></a>
             </td>";
         }
         echo "</tbody>";
         echo "</table>";
        }else{
            echo "<p class=\"alert alert-danger \" role=\"alert\"> Le tableau est vide. </p>";
        }
        ?>
      </div>
 
    </div>
  </div>

</body>
</html>

</body>
</html>
