<?php
class ConnexionDB{
    public function connect(){

        $servername = "localhost";
        $dbname = 'gestion_rv';
        $username = "root";
        $pass = "root";
        $encodage = 'utf8';

        try {
        $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=$encodage", $username, $pass);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
        }
        catch(PDOException $e)
        {
        echo "Impossible de se connecter à la base de données: " . $e->getMessage();
        }
    }
}
