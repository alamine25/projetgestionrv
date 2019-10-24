<?php
session_start();
require_once '../classes/ConnexionDB.php';
require_once '../classes/Requette.php';
require_once '../classes/Formulaire.php';
if (isset($_POST['submit'])) {
  if(!empty($_POST['email']) && !empty($_POST['passwd'])){
    $email=$_POST['email'];
    $password=sha1($_POST['passwd']);
    $req = new ConnexionDB();
    $res = $req->connect()->prepare("SELECT * FROM medecin WHERE email= :email AND passwd= :passwd");
    $res->execute(array('email'=>$email,'passwd'=>$mdp));
    $requser = $res->rowCount();
    if($requser == 1 ){
      $infouser = $res->fetch();
      $_SESSION['id_medecin'] = $infouser['id_medecin'];
      $_SESSION['prenom'] = $infouser['prenom'];
      $_SESSION['nom'] = $infouser['nom'];
      header('location:profile.php?id='.$_SESSION['id_medecin']);
    }else{
      $erreur_saisi = "<p class=\"alert alert-danger\"> Adresse email ou mot de passe incorrect! </p>";
    }
    
  }else{
   $error = "<p class=\"alert alert-danger\"> Tous les champs doivent être remplis ! </p>";
  }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
    <title>COMPTE ADMIN</title>
</head>
<body>

  <div class="modal-dialog text-center" > 
      <div class="col-sm-8 main-section">
        <div class="modal-content">
          <div class="col-12 user-img" >
            <img src="../../img/user8-512.png" alt="">
          </div>
          <form class="col-12" action="" method="post">
          <?php
              $forms = new Formulaire();
              echo $forms->inputEmail('email','email','Entrez votre adresse email');
              echo $forms->inputPassword('password','passwd','Entrez votre mot de passe');
              echo $forms->inputSubmit('submit','Se connecter');
            ?>
          </form>
          <?php
            if(isset($error)){echo $error;}
            if(isset($erreur_saisi)){echo $erreur_saisi;}
          ?>
        </div> 

      </div>
  </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>