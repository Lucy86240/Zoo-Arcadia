<?php

function newUser(User $user){
    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
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

function listOfUsers(){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT first_name, last_name, mail, blocked, role FROM users');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,'User');
        return  $stmt->fetchAll();
    }
    catch(error $e){
        echo("erreur de bd");
        return [];
    }
}

function blocUser(string $id){
    try{
        if(userExist($id)){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('UPDATE users SET blocked = 1 WHERE mail = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    catch(error $e){
        echo('Une erreur est survenue');
    }
}

function deblocUser(string $id){
    try{
        if(userExist($id)){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('UPDATE users SET blocked = 0 WHERE mail = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    catch(error $e){
        echo('Une erreur est survenue');
    }
}

function listOfRole(){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT label role FROM roles');
        $stmt->execute();
        return  $stmt->fetchAll(PDO::FETCH_NUM);
    }
    catch(error $e){
        echo("erreur de bd");
        return [];
    }
}

function deleteUser(string $mail){
    try{
        if(userExist($mail)){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('DELETE FROM users WHERE mail = :id');
            $stmt->bindParam(':id',$mail,PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    catch(error $e){
        echo("erreur de bd");
    }
}