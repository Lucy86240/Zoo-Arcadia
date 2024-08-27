<?php
if($_SERVER['REQUEST_URI']=='/Model/MedicalReport.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    //namespace MedicalReport;
    include_once "User.php";
    include_once "Animal.php";
    //use \PDO;

    Class MedicalReport{
        private int $id_report;
        private int $animal;
        private string $veterinarian;
        private $date;
        private string $health;
        private string $food;
        private $weight_of_food;
        private string $comment;

        public function getId(){
            return $this->id_report;
        }

        public function getIdAnimal(){
            return $this->animal;
        }

        public function setIdAnimal(int $animal){
            $this->animal = $animal;
        }
        public function getIdVeterinarian(){
            return $this->veterinarian;
        }

        public function getVeterinarian(){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT mail, first_name, last_name FROM users WHERE mail = :id');
                $stmt->bindParam(":id", $this->veterinarian, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
            }
            catch(error $e)
            {
                return "inconnue";
            }
        }

        public function setIdVeterinarian(int $veterinarian){
            $this->veterinarian = $veterinarian;
        }

        public function getDate(){
            return $this->date;
        }
        public function setDate($date){
            $this->date = $date;
        }

        public function getHealth():string{
            return $this->health;
        }
        public function setHealth(string $health){
            $this->health = $health;
        }

        public function getFood():string{
            return $this->food;
        }
        public function setFood(string $food){
            $this->food = $food;
        }

        public function getWeightOfFood():string{
            return $this->weight_of_food;
        }
        public function setWeightOfFood(string $weight){
            $this->weight_of_food = $weight;
        }
        public function getComment():string{
            return $this->comment;
        }
        public function setComment(string $comment){
            $this->comment = $comment;
        }
    }
}