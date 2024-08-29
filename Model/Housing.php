<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/Housing.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    //namespace housing;
    include_once "Image.php";

    class Housing{
        private int $id_housing;
        private string $name;
        private string $description;
        private int $popularityRange;
        private int $numberOfClics;
        private $images=[];

        public function getId(){
            return $this->id_housing;
        }

        public function getName(){
            return $this->name;
        }

        public function setName(string $name){
            $this->name = $name;
        }

        public function getDescription(){
            return $this->description;
        }

        public function setDescription(string $description){
            $this->description = $description;
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
    }
}