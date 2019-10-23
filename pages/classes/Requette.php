<?php
class Requette extends ConnexionDB{

    /**
     * Méthode qui permet de selectionner tous les informations d'une table.
     */
    public function selectAll($nomtable){
        $sql = "SELECT * FROM $nomtable";
        $res = $this->connect()->query($sql);
        if($res->rowCount() > 0){
            while($ligne  = $res->fetch()){
                $d []= $ligne;
                
            }
        }
        if(empty($d))
        {return '';}
        else{
            return $d;
        }
    }

     /**
     * Méthode qui permet d'ajouter des informations dans une table de la base de données.
     */
    public function insert($fields,$nomtable){
        $cle = implode(', ',array_keys($fields));

        $valeur = implode(", :",array_keys($fields));

        $sql = "INSERT INTO $nomtable ($cle) VALUES (:".$valeur.")";

        $req = $this->connect()->prepare($sql);

        foreach($fields as $key => $value){
            $req->bindValue(':'.$key,$value);
        }
        $result = $req->execute();

        return $result;
    }


    /**
     * Méthode qui permet de mettre à jour les données d'une table.
     */
    public function update($fields,$nomtable,$id){
        $sql = "UPDATE $nomtable SET ='$fields WHERE id= ?";
        $stmt = $this->prepare($sql);
        $stmt->execute($id);
        return  $stmt->execute($id);
    }

    /**
     * Méthode qui permet de supprimer un champs .
     */
    public function delete($nomtable,$nom_id_table,$id){
        $sql = "DELETE FROM $nomtable WHERE $nom_id_table = :id";
        $req = $this->connect()->prepare($sql);
        $req->bindValue(':id', $id);
        $result = $req->execute();
        return $result;
    }

    /**
     * Méthode qui permet selectionner un champs .
     */
    public function selectOne($nomtable,$nom_id_table,$id){
        $sql = "SELECT * FROM $nomtable WHERE $nom_id_table = :id";
        $req = $this->connect()->prepare($sql);
        $req->bindValue(':id', $id);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return $result;
        
    }
     /**
     * Méthode qui permet selectionner tous les elements d'un champs par rapport à une condition donnée.
     */
    public function selectWithCondition($nomtable,$nom_id_table,$id){
        $res = $this->connect()->prepare("SELECT * FROM $nomtable WHERE $nom_id_table  = ? ");
        $res->execute(array($id));
        if($res->rowCount() > 0){
            while($ligne  = $res->fetch()){
                $user []= $ligne;
            }
        }
        if(empty($user))
        {return '';}
        else{
            return $user;
        }
    }

     /**
     * Méthode qui permet selectionner les elements d'un champs par rapport à des conditions données.
     */
    public function selectAllCondition($table1,$table2,$table3,$cond1,$cond2,$cond3,$id){
        $res = $this->connect()->prepare("SELECT DISTINCT  rendez_vous.id_rv ,patient.prenom,patient.nom,patient.age,patient.adresse,patient.telephone,rendez_vous.date,rendez_vous.heure_debut,rendez_vous.heure_fin FROM $table1,$table2,$table3 WHERE $cond1 = $cond2 AND $cond3 = ? ");
        $res->execute(array($id));
        if($res->rowCount() > 0){
            while($ligne  = $res->fetch()){
                $user []= $ligne;
            }
            return $user;
        }
       
    }
 
   
}
