<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $req = new Requette();
        $result = $req->delete('patient','id_patient',$id);
        if($result){
            if(isset($_SESSION['id_secretaire'])){
                header('location:rv.php?id='.$_SESSION['id_secretaire']);
            }
        }else{
            echo 'erreur de suppression';
        }
    }   
    
?>
