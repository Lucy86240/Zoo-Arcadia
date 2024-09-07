<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/ManageUsersModel.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    /**
     * Summary of newUser ajoute un utilisateur à la base de données
     * @param User $user
     * @return bool
     */
    function newUser(User $user){
        try{
            if(!userExist($user->getUsername())){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt=$pdo->prepare("INSERT INTO users ( mail, password, first_name, last_name, role) VALUES (:username, :password,:firstName,:lastName, :role) ");
                $username = $user->getUsername();
                $password= password_hash($user->getPassword(), PASSWORD_DEFAULT);
                $firstName = $user->getFirstName();
                $lastName = $user->getLastName();
                $role = $user->getIdRole();
                $stmt->bindParam(":username", $username,PDO::PARAM_STR);
                $stmt->bindParam(":password", $password,PDO::PARAM_STR);
                $stmt->bindParam(":firstName", $firstName,PDO::PARAM_STR);
                $stmt->bindParam(":lastName", $lastName,PDO::PARAM_STR);
                $stmt->bindParam(":role", $role,PDO::PARAM_INT);
                if($stmt->execute()) return true;
                else return false;
            }
            else return false;
        }catch(error $e){
            echo('error');
            return false;

        }
    }

    /**
     * Summary of listOfUsers
     * @return array tableau de tous les objets user de la base de données
     */
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

    /**
     * Summary of unblocUser débloque un utilisateur dans la base de données
     * @param string $id : mail de l'utilisateur à débloquer
     * @param string $password : nouveau mot de passe de l'utilisateur
     * @return void
     */
    function unblocUser(string $id, string $password){
        try{
            if(userExist($id) && verifiedBlocked($id)){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('UPDATE users SET blocked = 0, password = :password WHERE mail = :id');
                $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                $pwd= password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(":password", $pwd, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
        catch(error $e){
            echo('Une erreur est survenue');
        }
    }

    /**
     * Summary of listOfRole : liste nom des roles existants
     * @return array
     */
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

    /**
     * Summary of findIdRole retourne l'id du nom du role saisi
     * @param mixed $label : nom du role à trouver
     * @return int
     */
    function findIdRole($label){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT id_role role FROM roles WHERE label = :label');
            $stmt->bindParam(':label',$label,PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetch();
            if($res==null)
                return 0;
            else 
            return $res[0];
        }
        catch(error $e){
            echo("erreur de bd");
            return 0;
        }
    }

    /**
     * Summary of idRoleExist indique si un role existe dans la base de données en fonction de son id
     * @param mixed $id
     * @return mixed
     */
    function idRoleExist($id){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT * FROM roles WHERE id_role = :id');
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch();
            if($res==null)
                return 0;
            else 
            return $res;
        }
        catch(error $e){
            echo("erreur de bd");
            return 0;
        }
    }

    /**
     * Summary of updateUser met à jour un utilisateur dans la base de données
     * @param User $user : objet utilisateur
     * @param string $originMail : mail de l'utilisateur indiqué dans la base de données
     * @return bool : false si pas de mise à jour effectuée
     */
    function updateUser(User $user, string $originMail){
        try{
            if(userExist($originMail)){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $newFirstname = $user->getFirstName();
                if($newFirstname != ''){
                    $stmt = $pdo->prepare('UPDATE users SET first_name = :firstName WHERE mail = :id');
                    $stmt->bindParam(":id", $originMail, PDO::PARAM_STR);
                    $stmt->bindParam(":firstName", $newFirstname, PDO::PARAM_STR); 
                    $stmt->execute();       
                }
                $newLastname = $user->getLastName();
                if($newLastname != ''){
                    $stmt = $pdo->prepare('UPDATE users SET last_name = :lastName WHERE mail = :id');
                    $stmt->bindParam(":id", $originMail, PDO::PARAM_STR);
                    $stmt->bindParam(":lastName", $newLastname, PDO::PARAM_STR); 
                    $stmt->execute();       
                }
                $newIdRole = $user->getIdRole();
                if($newIdRole != '' && idRoleExist($newIdRole)){
                    $stmt = $pdo->prepare('UPDATE users SET role = :role WHERE mail = :id');
                    $stmt->bindParam(":id", $originMail, PDO::PARAM_STR);
                    $stmt->bindParam(":role", $newIdRole, PDO::PARAM_INT); 
                    $stmt->execute();       
                }
                $newPassword = $user->getPassword();
                if($newPassword != ''){
                    $stmt = $pdo->prepare('UPDATE users SET password = :password WHERE mail = :id');
                    $stmt->bindParam(":id", $originMail, PDO::PARAM_STR);
                    $pwd= password_hash($newPassword, PASSWORD_DEFAULT);
                    $stmt->bindParam(":password", $pwd, PDO::PARAM_STR); 
                    $stmt->execute();       
                }
                $newMail = $user->getUsername();
                if($newMail != ''){
                    $stmt = $pdo->prepare('UPDATE users SET mail = :mail WHERE mail = :id');
                    $stmt->bindParam(":id", $originMail, PDO::PARAM_STR);
                    $stmt->bindParam(":mail", $newMail, PDO::PARAM_STR); 
                    $stmt->execute();       
                }
                return true;
            }
            else{
                return false;
            }
        }
        catch(error $e){
            echo('Une erreur est survenue');
            return false;
        }
    }

    /**
     * Summary of deleteUser supprime un utilisateur de la base de deonnées
     * @param string $mail : mail de l'utilisateur à supprimer
     * @return void
     */
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
}