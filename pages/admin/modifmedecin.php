<?php
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_GET['id'])){
        $id =$_GET['id'];
        $forms = new Requette();
        $result = $forms->selectOne('medecin','id_medecin',$id);
        
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
<nav class="navbar navbar-inverse">
            <div class="container-fluid">
              <ul class="nav navbar-nav">
                <li class="active"><a href="homeadmin.php">ACCUEIL</a></li>
                <li><a href="secretariat.php">SECRETARIAT</a></li>
                <li><a href="medecine.php">MEDECINE</a></li>
                <li><a href="services.php">SERVICES</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="deconnectadmin.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
              </ul>
            </div>
          </nav>


</body>
<div class="container-fluid">
  
  <div class="panel-group col-md-4">
    <div class="panel panel-success">
      <div class="panel-heading">Modifier un medecin</div>
      <div class="panel-body">
        <?php
        if(isset($errormail)){echo $errormail;}
        if(isset($errornumb)){echo $errornumb;}
        if(isset($errochamp)){echo $errochamp;} 
        ?>
        <form action="" method="post">
        <div class="form-group ">
        <div class="form-group ">
          <label>prenom</label>
          <input type="text" class="form-control col-md-2" name="prenom" value="<?php if($result['prenom']) {echo $result['prenom'];} ?>" >
        </div>
        <div class="form-group ">
          <label>nom</label>
          <input type="text" class="form-control col-md-2" name="nom" value="<?php if($result['nom']) {echo $result['nom'];} ?>" >
        </div>
        <div class="form-group ">
          <label>telephone</label>
          <input type="text" class="form-control col-md-2" name="telephone" value="<?php if($result['telephone']) {echo $result['telephone'];} ?>" >
        </div>
        <div class="form-group ">
          <label>specialite</label>
          <input type="text" class="form-control col-md-2" name="specialite" value="<?php if($result['specialite']) {echo $result['specialite'];} ?>" >
        </div>
        <div class="form-group ">
          <label>email</label>
          <input type="text" class="form-control col-md-2" name="email" value="<?php if($result['email']) {echo $result['email'];} ?>" >
        </div>
        
        <div class="form-group">
            <label >service</label>
            <select name="service" class="form-control col-md-4">
                <option value='<?php if($result['id_service'] == $id) {echo 'selected';} ?>'></option>
                <option value='<?php if($result['id_service'] == $id) {echo 'selected';} ?>'></option>
                <option value='<?php if($result['id_service'] == $id) {echo 'selected';} ?>'></option>
                <option value='<?php if($result['id_service'] == $id) {echo 'selected';} ?>'></option>
            </select>
        </div>
      </div>
      </form>  
    </div>
  </div>
