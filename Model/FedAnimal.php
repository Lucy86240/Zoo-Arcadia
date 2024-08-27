<?php 
if($_SERVER['REQUEST_URI']=='/Model/FedAnimal.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    Class FedAnimal{
        private int $id_fed;
        private int $animal;
        private string $employee;
        private $date;
        private $hour;
        private string $food;
        private string $weight;
        public function getId():int{
            return $this->id_fed;
        }
        public function getIdAnimal():int{
            return $this->animal;
        }
        public function setIdAnimal($animal){
            $this->animal = $animal;
        }
        public function getIdEmployee():string{
            return $this->employee;
        }
        public function getEmployee(){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT mail, first_name, last_name FROM users WHERE mail = :id');
                $stmt->bindParam(":id", $this->employee, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
            }
            catch(error $e)
            {
                return "inconnue";
            }
        }
        public function setIdEmployee($employee){
            $this->employee = $employee;
        }
        public function getDate(){
            return $this->date;
        }
        public function setDate($date){
            $this->date = $date;
        }
        public function getHour(){
            return $this->hour;
        }
        public function setHour($hour){
            $this->hour = $hour;
        }
        public function getFood():string{
            return $this->food;
        }
        public function setFood($food){
            $this->food = $food;
        }
        public function getWeight():string{
            return $this->weight;
        }
        public function setWeight($weight){
            $this->weight = $weight;
        }
    }
}