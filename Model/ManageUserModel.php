<?php
if($_SERVER['REQUEST_URI']=='/Model/ManageUserModel.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
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
            $stmt = $pdo->prepare('SELECT users.password, users.first_name, users.last_name, users.role, roles.label, users.blocked FROM users 
            JOIN roles ON users.role = roles.id_role WHERE mail = :username');
            $stmt->bindValue(":username", $mailInput,PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetch();
            if(password_verify($passwordInput,$res['password'])){
                $_SESSION['blocked'] = $res['blocked'];
                if($res['blocked']==0){
                    $_SESSION['mail']=$mailInput;
                    $_SESSION['firstName']=$res['first_name'];
                    $_SESSION['lastName']=$res['last_name'];
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

    function listOfUserByRole(int $role){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT first_name, last_name, mail FROM users 
            WHERE role = :role');
            $stmt->bindValue(":role", $role,PDO::PARAM_STR);
            $stmt->execute();
            return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(error $e){
            echo("erreur de bd");
            return '';
        }
    }
}