<?php

//namespace user;
//use \PDO;

Class User{
    private string $mail;
    private string $password;
    private string $first_name;
    private string $last_name;
    private int $role;
    private bool $blocked;

    public function getUsername():string{
        return $this->mail;
    }

    public function setUsername(string $username){
        $this->mail = $username;
    }

    public function getPassword():string{
        return $this->password;
    }

    public function setPassword(string $password){
        $this->password = $password;
    }

    public function getFirstName(){
        return $this->first_name;
    }

    public function setFirstName(string $firstName){
        $this->first_name = $firstName;
    }

    public function getLastName(){
        return $this->last_name;
    }
    public function setLastName(string $lastName){
        $this->last_name = $lastName;
    }

    public function getIdRole():int{
        return $this->role;
    }

    public function setIdRole($role){
        $this->role = $role;
    }
    public function getRole():string{
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT label FROM roles WHERE id_role= '.$this->role);
            $stmt->execute();
            return  $stmt->fetch()['label'];
        }
        catch(error $e){
            echo("erreur de bd");
            return 'inconnu';
        }
    }

    public function getBlocked(){
        return $this->blocked;
    }
    public function setBlocked(bool $blocked){
        $this->blocked = $blocked;
    }



    public function saveToDatabase() { 
        /*include_once 'config.php';
        $pdo = new PDO($HOST.';'.$DBNAME, $USERNAME, $PASSWORD);
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username ');
        $stmt->bindParam(":username", $this->username,PDO::PARAM_STR);
        $stmt->execute();*/
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