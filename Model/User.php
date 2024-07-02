<?php

namespace user;
use \PDO;

Class User{
    private string $username;
    private string $password;
    private string $first_name;
    private string $last_name;

    public function saveToDatabase() { 
        include_once 'config.php';
        $pdo = new PDO($HOST.';'.$DBNAME, $USERNAME, $PASSWORD);
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username ');
        $stmt->bindParam(":username", $this->username,PDO::PARAM_STR);
        $stmt->execute();
        //faire si un résultat retourner une erreur
        /*$resultats = $stmt->get_result();
        if($resultats->num_rows > 0 )
        { 
            return false;
        }
        $stmt=$pdo->prepare("INSERT INTO users ( username , password, first_name, last_name) VALUES (:username, :password,:first_name,:last_name) ");
        $stmt->bindValue(":username", $this->username,PDO::PARAM_STR);
        $stmt->bindValue(":password", $this->password,PDO::PARAM_STR);
        $stmt->bindValue(":first_name", $this->first_name,PDO::PARAM_STR);
        $stmt->bindValue(":last_name", $this->last_name,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->close();*/
    }
}