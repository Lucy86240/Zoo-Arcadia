<?php

function userExist(string $user){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
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
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT users.password, users.first_name, users.role, roles.label, users.blocked FROM users 
        JOIN roles ON users.role = roles.id_role WHERE mail = :username');
        $stmt->bindValue(":username", $mailInput,PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        if(password_verify($passwordInput,$res['password'])){
            $_SESSION['blocked'] = $res['blocked'];
            if($res['blocked']==0){
                $_SESSION['mail']=$mailInput;
                $_SESSION['firstName']=$res['first_name'];
                $_SESSION['role'] = $res['label']; 
            }   
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

function verifiedBlocked(string $mailInput){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT blocked FROM users 
        JOIN roles WHERE mail = :username');
        $stmt->bindValue(":username", $mailInput,PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        if(isset($res['blocked'])){
            $_SESSION['blocked'] = $res['blocked'];
            if($res['blocked']==1) return true;
            else return false;
        }else return false;
    }
    catch(error $e){
        echo("erreur de bd");
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

function findNameOfUser(string $id) : string{
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT first_name, last_name FROM users 
        WHERE mail = :username');
        $stmt->bindValue(":username", $id,PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        $name = $res['first_name'].' '.$res['last_name'] ; 
        return $name;
    }
    catch(error $e){
        echo("erreur de bd");
        return '';
    }
}