<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/User.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{

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
    }
}