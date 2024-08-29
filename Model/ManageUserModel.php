<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/ManageUserModel.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    /**
     * Summary of userExist indique si un utilisateur existe avec ce mail
     * @param string $user : mail à chercher
     * @return bool : en cas problème de base de données retourne vrai
     */
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

    /**
     * Summary of verifiedLoginInput vérifie si le mail et le mot de passe sont liés
     * @param string $mailInput :
     * @param string $passwordInput
     * @return bool attention retourne aussi false en cas de problème de base de données
     */
    function verifiedLoginInput(string $mailInput, string $passwordInput){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT users.password, users.first_name, users.last_name, users.role, roles.label, users.blocked FROM users 
            JOIN roles ON users.role = roles.id_role WHERE mail = :username');
            $stmt->bindValue(":username", $mailInput,PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetch();
            //si le mot de passe est ok on initialise les variables de session
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
            return false;
        }
    }

    /**
     * Summary of verifiedBlocked indique si l'utilisateur est bloqué
     * @param string $mailInput
     * @return bool attention en cas de problème de base de données retourne vrai
     */
    function verifiedBlocked(string $mailInput){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT blocked FROM users 
            JOIN roles WHERE mail = :username');
            $stmt->bindValue(":username", $mailInput,PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetch();
            //initialise la variable de session
            if(isset($res['blocked'])){
                $_SESSION['blocked'] = $res['blocked'];
                if($res['blocked']==1) return true;
                else return false;
            }else return false;
        }
        catch(error $e){
            echo("erreur de bd");
            return true;
        }
    }

    /**
     * Summary of findNameOfUser retourne le prénom nom de l'utilisateur
     * @param string $id : mail
     * @return string
     */
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

    /**
     * Summary of listOfUserByRole retourne le prénom, nom, mail des utilisateurs suivant le role indiqué
     * @param int $role : 0:Administrateur.rice, 1:Employé.e, 2:Vétérinaire
     * @return array|string
     */
    function listOfUserByRole(int $role){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT first_name, last_name, mail FROM users 
            WHERE role = :role');
            $stmt->bindValue(":role", $role,PDO::PARAM_INT);
            $stmt->execute();
            return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(error $e){
            echo("erreur de bd");
            return '';
        }
    }
}