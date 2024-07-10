<?php

function userExist(string $user){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $stmt = $pdo->prepare('SELECT * FROM users WHERE mail = :username ');
        $stmt->bindParam(":username", $user,PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->fetch()!=null){
            return true;
        }
        else{
            return false;
        }
    }
    catch(error $e){
        echo("erreur de bd");
        return true;
    }
}

function verifiedLoginInput(string $mailInput, string $passwordInput){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        
        $stmt = $pdo->prepare('SELECT users.password, users.first_name, users.role, roles.label FROM users JOIN roles ON users.role = roles.id_role WHERE mail = :username');

        $stmt->bindValue(":username", $mailInput,PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        if(password_verify($passwordInput,$res['password'])){
            session_start();
            $_SESSION['mail']=$mailInput;
            $_SESSION['firstName']=$res['first_name'];
            $_SESSION['role'] = $res['label'];
            
            return true;
        }
        else{
            return false;
        }
    }
    catch(error $e){
        echo("erreur de bd");
    }
}

function newUser(User $user){
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
    $stmt=$pdo->prepare("INSERT INTO users ( mail, password, first_name, last_name) VALUES (:username, :password,:first_name,:last_name) ");
    $username = $user->getUsername();
    $password= password_hash($user->getPassword(), PASSWORD_DEFAULT);
    $fistName = $user->getFirstName();
    $lastName = $user->getLastName();
    $stmt->bindValue(":username", $username,PDO::PARAM_STR);
    $stmt->bindValue(":password", $password,PDO::PARAM_STR);
    $stmt->bindValue(":first_name", $fistName,PDO::PARAM_STR);
    $stmt->bindValue(":last_name", $lastName,PDO::PARAM_STR);
    $stmt->execute();

}