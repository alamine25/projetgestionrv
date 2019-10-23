<?php
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $req = new Requette();
        $result = $req->delete('service','id_service',$id);
        if($result){
            header('location:services.php');
        }else{
            echo 'erreur de suppression';
        }
    }   
    
?>

