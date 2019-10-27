<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    require_once '../classes/Menu.php';
    $req = new ConnexionDB();
    if(isset($_SESSION['email'])){
      $session = $_SESSION['email'];
    }
    if(isset($_POST['submit'])){
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $telephone = $_POST['telephone'];
        $specialite = $_POST['specialite'];
        $email = $_POST['email'];
        $password = sha1($_POST['passwd']);
        $service [] = $_POST['service'];
        if(!empty($prenom) && !empty($nom) && !empty($telephone) && !empty($email) && !empty($password) && !empty($service) && !empty($specialite)){
            if(preg_match('#^(77||78||76||70)[0-9]{7}$#',  $telephone)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                  $nbemail  = $req->connect()->prepare("SELECT COUNT(*) as nbemail FROM medecin WHERE email = :email");
                  $nbemail->execute(array('email'=>$email));
                  while($email_verify = $nbemail->fetch()){
                    if($email_verify['nbemail'] != 0){
                      $errormailnb = "<p class=\"alert alert-danger \" role=\"alert\"> Cette adresse email existe déja. </p>";
                  }else{
                    foreach ($service as $value) {
                      $value = intval($value);
                      $data = ['prenom'=>$prenom, 'nom'=>$nom, 'telephone'=>$telephone, 'specialite'=>$specialite,'email'=>$email, 'passwd'=>$password, 'prenom'=>$prenom,'id_service'=>$value];
                      $add = new Requette();
                      $res =  $add->insert($data,'medecin');
                      if($res){
                         header('location:medecine.php');
                      }else{
                          echo 'impossible';
                      }
                      
                      }   
                  }
                }
    
                }else{
                    $errormail = "<p class=\alert alert-danger \ role=\alert\"> Veuillez entrez une adresse email valide. </p>";
                }
            }else{
                $errornumb = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez entrez un numéro de téléphone valide. </p>";
            }
        }else{
            $errochamp = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez remplir tous les champs . </p>";
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
  <title>MEDECINE</title>
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
<div class="container-fluid">
  
  <div class="panel-group col-md-4">
    <div class="panel panel-success">
      <div class="panel-heading">AJOUTER UN MEDECIN</div>
      <div class="panel-body">
        <?php
        if(isset($errormail)){echo $errormail;}
        if(isset($errormailnb)){echo $errormailnb;} 
        if(isset($errornumb)){echo $errornumb;}
        if(isset($errochamp)){echo $errochamp;} 
        ?>
    <form action="" method="post">
    <div class="form-group ">
            <?php
                $forms = new Formulaire();
                $req = new Requette();
                echo $forms->formInput('Prenom','text','prenom','Entrez le prénom');
                echo $forms->formInput('Nom ','text','nom','Entrez le nom ');
                echo $forms->formInput('Telephone','tel','telephone','Entrez le numero de telephone');
                echo $forms->formInput('Specialte','text','specialite','Entrez le specialte ');
                echo $forms->formInput('Adresse email','email','email','Entrez l\'adresse email');
                echo $forms->formInput('Mot de passe','password','passwd','Entrez le mot de passe');
                $res = $req->selectAll('service');
                $liste_option= "";
                foreach ($res as $value) {

                    $liste_option .= "<option value=".$value['id_service'].">" .$value['id_service'].' - '.$value['nom_service']."</option>";
                }
                echo $forms->selectList('Choisissez un service','service',$liste_option);
            ?>
        </div>

        <?php echo $forms->formSubmit('submit','Enrégister'); ?>
   
    
    </form>
      </div>
 
    </div>
  </div>
  <div class="panel-group col-md-8">
    <div class="panel panel-success">
      <div class="panel-heading">LISTE DES MEDECINS</div>
      <div class="panel-body">
       <!-- Liste des medecins -->
       <?php
         $req = new Requette();
         $res = $req->selectAll('medecin');
         echo "
         <table class=\"table\" >
         <thead class='thead-dark'>
           <tr>
             <th scope=\"col\">#</th>
             <th scope=\"col\">Prenom</th>
             <th scope=\"col\">Nom</th>
             <th scope=\"col\">telephone</th>
             <th scope=\"col\">Specialite</th>
             <th scope=\"col\">Email</th>
             <th scope=\"col\">Services</th>
             <th scope=\"col\">Actions</th>
           </tr>
         </thead>
         ";
         if(!empty($res)){
         foreach($res as $val){
             echo"<tbody>";
             echo "<tr>
             <td>".$val['id_medecin']."</td>
             <td>".$val['prenom']."</td>
             <td>".$val['nom']."</td>
             <td>".$val['telephone']."</td>
             <td>".$val['specialite']."</td>
             <td>".$val['email']."</td>
             <td>".$val['id_service']."</td>";
             echo "
             <td><a class='btn btn-success'href='editmedecin.php?id=".$val['id_medecin']."'><em class=\"far fa-edit\"></em></a> 
                 <a class='btn btn-danger' href='delmedecin.php?id=".$val['id_medecin']."' onclick=\"return confirm('êtes vous sure de vouloir supprimer cet enrégistrement ?')\";><em class=\"fas fa-trash-alt\"></em></a>
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
