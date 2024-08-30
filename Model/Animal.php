<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/Animal.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{

    require_once "Image.php";

    Class Animal{
        private int $id_animal;
        private string $name;
        private int $breed;
        private int $housing;
        private bool $isVisible;

        private int $popularityRange;

        private int $numberOfClics;

        private $images=[];

        private $medicalReports=[];
        private $foods=[];

        public function getId(){
            return $this->id_animal;
        }
        public function setId(int $id){
            $this->id_animal = $id;
        }

        public function getName(){
            return $this->name;
        }

        public function setName(string $name){
            $this->name = $name;
        }

        public function getIdBreed(){
            return $this->breed;
        }

        public function getBreed(){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT label FROM breeds WHERE id_breed = :id');
                $stmt->bindParam(":id", $this->breed, PDO::PARAM_INT);
                $stmt->execute();
                $breed = $stmt->fetch(PDO::FETCH_ASSOC);
                return $breed['label'];
            }
            catch(error $e)
            {
                return "inconnue";
            }
        }

        public function setIdBreed(int $breed){
            $this->breed = $breed;
        }

        public function getIdHousing(){
            return $this->housing;
        }

        public function getHousing(){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT name FROM housings WHERE id_housing = :id');
                $stmt->bindParam(":id", $this->housing, PDO::PARAM_INT);
                $stmt->execute();
                $breed = $stmt->fetch(PDO::FETCH_ASSOC);
                return $breed['name'];
            }
            catch(error $e)
            {
                return "inconnue";
            }
        }

        public function setIdHousing(int $housing){
            $this->housing = $housing;
        }

        public function getIsVisible(){
            return $this->isVisible;
        }

        public function setIsVisible(int $isVisible){
            $this->isVisible = $isVisible;
        }

        public function setMedicalReport(int $indice, $report){
            $this->medicalReports[$indice]=$report;
        }

        public function getMedicalReport(int $id){
            if($id<count($this->medicalReports)){
                return $this->medicalReports[$id];
            }
            else{
                return new MedicalReport();
            }
        }
        public function getLastMedicalReport(){
            if ($this->countMedicalReports() <1) return null;
            return $this->medicalReports[0];
        }
        public function addMedicalReport($report){
            array_push($this->medicalReports,$report);
        }

        public function countMedicalReports(){
            return count($this->medicalReports);
        }

        public function setImage(int $indice, $img){
            $this->images[$indice]=$img;
        }

        public function getImage(int $id) : Image{
            if($id<count($this->images)){
                return $this->images[$id];
            }
            else{
                return new Image();
            }
        }
        public function addImage(Image $img){
            array_push($this->images,$img);
        }

        public function countImages(){
            return count($this->images);
        }

        public function setFoods(int $indice, $food){
            $this->foods[$indice]=$food;
        }

        public function getFoods(int $id){
            if($id<count($this->foods)){
                return $this->foods[$id];
            }
            else{
                return new FedAnimal();
            }
        }
        public function getLastFoods(){
            if ($this->countFoods() <1) return null;
            return $this->foods[0];
        }
        public function addFood($food){
            array_push($this->foods,$food);
        }

        public function countFoods(){
            return count($this->foods);
        }

        public function getPopularityRange():int{
            return $this->popularityRange;
        }

        public function setPopularityRange($range){
            $this->popularityRange = $range;
        }

        public function getNumberOfClics():int{
            return $this->numberOfClics;
        }

        public function setNumberOfClics($clics){
            $this->numberOfClics=$clics;
        }
    }
}