<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    require_once '../classes/Menu.php';
    $req = new ConnexionDB();
    $add = new Requette();
    if(isset($_SESSION['id_secretaire'])){
    if(isset($_POST['submit'])){
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $telephone = $_POST['telephone'];
        $age = $_POST['age'];
        $adresse = $_POST['adresse'];
        $secretaire = $_POST['secretaire'];
        $data = ['prenom'=>$prenom,'nom'=>$nom,'age'=>$age,'adresse'=>$adresse,'telephone'=>$telephone,'id_secretaire'=>$secretaire];
        if(!empty($prenom) && !empty($nom) && !empty($telephone) && !empty($age)){
           if(is_numeric($age) && $age > 0){
              if(preg_match('#^(77||78||76||70)[0-9]{7}$#', $telephone)){
                $res = $add->insert($data,'patient');
                if($res){
                    header('locaion:acceuil.php');
                }else{
                    echo 'ca ne marche pas';
                }
              }else{
                $error_numb = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez saisir un numero valide . </p>";
              }
           }else{
            $error_age = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez saisir un age valide . </p>";
           }
        }else{
            $error_champ = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez remplir tous les champs . </p>";
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
  <title>PATIENT</title>
</head>
<body>
<nav class="navbar navbar-inverse">
            <div class="container-fluid">
              <ul class="nav navbar-nav">
              <li class="active"><a href="">SEN-MEDIC</a></li>
                <li><a href="">PATIENT</a></li>
                <?php
                    if(isset($_SESSION['id_secretaire'])){
                        $s = $_SESSION['id_secretaire'];
                  ?>
                <li><a href='rv.php?id=<?php echo $s ;?>'>RENDEZ-VOUS</a>
              </li> <?php } ?>
              </ul>
              <ul class="nav navbar-nav navbar-right">
              <li class="connect"><?php if(isset( $_SESSION['prenom'])&& $_SESSION['prenom']){echo $_SESSION['prenom']." " .$_SESSION['nom'];}?></li>
                <li><a href="deconnexion.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
              </ul>
            </div>
          </nav>
<div class="container-fluid">
  
  <div class="panel-group col-md-4">
    <div class="panel panel-success">
      <div class="panel-heading">ENREGISTRER UN PATIENT</div>
      <div class="panel-body">
        <?php
        if(isset($error_age)){echo $error_age;}
        if(isset($error_champ)){echo $error_champ;} 
        if(isset($error_numb)){echo $error_numb;}
        ?>
    <form action="" method="post">
    <div class="form-group ">
        <?php
            $forms = new Formulaire();
            $req = new Requette();
            echo $forms->formInput('Prenom','text','prenom','Entrez le prénom');
            echo $forms->formInput('Nom ','text','nom','Entrez le nom ');
            echo $forms->formInput('Age','text','age','Entrez l\'age');
            echo $forms->formInput('adresse','text','adresse','Entrez l\'adresse ');
            echo $forms->formInput('Telephone','tel','telephone','Entrez le numero ');
            echo $forms->formInput('','hidden','secretaire','',$_GET['id']);
        ?>
    </div>
    
        <?php echo $forms->formSubmit('submit','Enrégister'); ?>
   
    
    </form>
      </div>
 
    </div>
  </div>
  <div class="panel-group col-md-8">
    <div class="panel panel-success">
      <div class="panel-heading">LISTE DES PATIENT</div>
      <div class="panel-body">
       <!-- Liste des patients -->
       <?php
       if(isset($_GET['id'])){
        $id =  $_GET['id']; 
        }
        $bdd = new ConnexionDB();
        $req = new Requette();
        $user = $req->selectWithCondition('patient','id_secretaire',$id);
         echo "
         <table class=\"table\" >
         <thead class='thead-dark'>
           <tr>
             <th scope=\"col\">#</th>
             <th scope=\"col\">Prenom</th>
             <th scope=\"col\">Nom</th>
             <th scope=\"col\">Age</th>
             <th scope=\"col\">Adresse</th>
             <th scope=\"col\">Telephone</th>
             <th scope=\"col\">Actions</th>
           </tr>
         </thead>
         ";
          if(!empty($user)){
         foreach($user as $val){
             echo"<tbody>";
             echo "<tr>
             <td>".$val['id_patient']."</td>
             <td>".$val['prenom']."</td>
             <td>".$val['nom']."</td>
             <td>".$val['age']."</td>
             <td>".$val['adresse']."</td>
             <td>".$val['telephone']."</td>";
             echo "
             <td><a class='btn btn-success'href='modifrv.php?id=".$val['id_patient']."'><em class=\"far fa-edit\"></em></a> 
                 <a class='btn btn-danger' href='suprvrv.php?id=".$val['id_patient']."' onclick=\"return confirm('êtes vous sure de vouloir supprimer cet enrégistrement ?')\";><em class=\"fas fa-trash-alt\"></em></a>
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
<?php
}
?>