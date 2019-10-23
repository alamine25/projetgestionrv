<?php
class Insert extends ConnexionDB{
    public function add($fields,$table){
        $cle = implode(', ',array_keys($fields));

        $valeur = implode(", :",array_keys($fields));

        $sql = "INSERT INTO $table ($cle) VALUES (:".$valeur.")";

        $stmt = $this->connect()->prepare($sql);

        foreach($fields as $key => $value){
            $stmt->bindValue(':'.$key,$value);
        }
        $stmtExec = $stmt->execute();

        return $stmtExec;
    }
}