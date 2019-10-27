<?php
class Insert extends ConnexionDB{
    public function __construct($fields){
        $implodeColumns = implode(', ',array_keys($fields));

        $implodePlaceholder = implode(", :",array_keys($fields));


        $sql = "INSERT INTO rendez_vous ($implodeColumns) VALUES (:".$implodePlaceholder.")";

        $stmt = $this->connect()->prepare($sql);

        foreach($fields as $key => $value){

            $stmt->bindValue(':'.$key,$value);
        }

        $stmtEx = $stmt->execute();

        if($stmtEx){
            header("locatin: rv.php");
        }
    }
}