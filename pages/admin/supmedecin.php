<?php
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $req = new Requette();
        $result = $req->delete('medecin','id_medecin',$id);
        if($result){
            header('location:medecine.php');
        }else{
            echo 'erreur de suppression';
        }
    }   
    
?>

